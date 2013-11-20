<?php
/**
 * 默认展示页面
 *
 * 默认展示页面
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class connectControl extends BaseHomeControl{
	public function __construct(){
		parent::__construct();
		Language::read("home_login_register,home_login_index,home_qqconnect");
		/**
		 * 判断qq互联功能是否开启
		 */
		if ($GLOBALS['setting_config']['qq_isuse'] != 1){
			showMessage(Language::get('home_qqconnect_unavailable'),'index.php','html','error');//'系统未开启QQ互联功能'
		}
		/**
		 * 初始化测试数据
		 */
		if (!$_SESSION['openid']){
			showMessage(Language::get('home_qqconnect_error'),'index.php','html','error');//'系统错误'
		}
	}
	/**
	 * 首页
	 */
	public function indexOp(){
		/**
		 * 检查登录状态
		 */
		if($_SESSION['is_login'] == '1') {
			//qq绑定
			$this->bindqqOp();
		}else {
			$this->autologin();
			$this->registerOp();
		}
	}
	/**
	 * qq绑定新用户
	 */
	public function registerOp(){
		//实例化模型
		$model_member	= Model('member');
		//检查登录状态
		$model_member->checkloginMember();
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 注册验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["user_name"],		"require"=>"true",		"message"=>Language::get('login_usersave_username_isnull')),
			array("input"=>$_POST["password"],		"require"=>"true",		"message"=>Language::get('login_usersave_password_isnull')),
			array("input"=>$_POST["password_confirm"],"require"=>"true",	"validator"=>"Compare","operator"=>"==","to"=>$_POST["password"],"message"=>Language::get('login_usersave_password_not_the_same')),
			array("input"=>$_POST["email"],			"require"=>"true",		"validator"=>"email", "message"=>Language::get('login_usersave_wrong_format_email')),
			array("input"=>$_POST["agree"],			"require"=>"true", 		"message"=>Language::get('login_usersave_you_must_agree'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage(Language::get('error').$error,'','html','error');//'在处理您的请求时出现了问题:<br />'
			}
			if (C('captcha_status_register') == '1'){
				$captcha = trim($_POST['captcha']);
				if (!$captcha){
					showMessage(Language::get('login_usersave_code_isnull'),'','html','error');
				}
				if (!checkSeccode($_POST['nchash'],$captcha)){
					showMessage(Language::get('login_usersave_wrong_code'),'','html','error');
				}
			}
			$check_member_name	= $model_member->infoMember(array('member_name'=>trim($_POST['user_name'])));
			if(is_array($check_member_name) and count($check_member_name)>0) {
				showMessage(Language::get('login_usersave_your_username_exists'),'','html','error');//"您填写的用户名称已经存在，请您选择其他用户名填写"
			}
			$check_member_email	= $model_member->infoMember(array('member_email'=>trim($_POST['email'])));
			if(is_array($check_member_email) and count($check_member_email)>0) {
				showMessage(Language::get('login_usersave_your_email_exists'),'','html','error');//"您填写的邮箱已经存在，请您选择其他邮箱填写"
			}
			$user_array	= array();
			if($GLOBALS['setting_config']['ucenter_status'] == '1') {
				/**
				* Ucenter处理
				*/
				$model_ucenter = Model('ucenter');
				$uid = $model_ucenter->addUser(trim($_POST['user_name']),trim($_POST['password']),trim($_POST['email']));
				if ($uid > 0){
					$user_array['member_id'] = $uid;
				} else {
					showMessage(Language::get('login_usersave_regist_fail'),SiteUrl.'/index.php?act=login&op=register','html','error');//"会员注册失败"
				}
			}
			/**
			 * 会员添加
			 */
			$user_array['member_name']		= $_POST['user_name'];
			$user_array['member_passwd']	= $_POST['password'];
			$user_array['member_email']		= $_POST['email'];
			$user_array['member_qqopenid']	= $_SESSION['openid'];//qq openid
			//处理qq账号信息
			$qq_arr = array();
			if (trim($_POST['regnickname'])){
				$qq_arr['nickname'] = trim($_POST['regnickname']);
			}
			$qq_str = '';
			if (is_array($qq_arr) && count($qq_arr)>0){
				$qq_str = serialize($qq_arr);
			}
			$user_array['member_qqinfo']	= $qq_str;//qq 信息
			
			$result	= $model_member->addMember($user_array);
			if($result) {
				$_SESSION['is_login']	= '1';
				$_SESSION['member_id']	= $result;
				$_SESSION['member_name']= trim($user_array['member_name']);
				$_SESSION['member_email']= trim($user_array['member_email']);
				
				//添加会员积分
				if ($GLOBALS['setting_config']['points_isuse'] == 1){
					$points_model = Model('points');
					$points_model->savePointsLog('regist',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name']),false);
				}
				
				$success_message = Language::get('login_usersave_regist_success');
				showMessage($success_message,SiteUrl);
			} else {
				showMessage(Language::get('login_usersave_regist_fail'),SiteUrl.'/index.php?act=login&op=register','html','error');//"会员注册失败"
			}
		}else {
			//获取qq账号信息
			require_once (BasePath.DS.'api'.DS.'qq'.DS.'user'.DS.'get_user_info.php');
			$qquser_info = get_user_info($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["token"], $_SESSION["secret"], $_SESSION["openid"]);
			Tpl::output('qquser_info',$qquser_info);
			Tpl::output('nchash',substr(md5(SiteUrl.$_GET['act'].$_GET['op']),0,8));
			Tpl::showpage('connect_register');
		}
	}
	/**
	 * qq绑定已有用户
	 */
	public function loginOp(){
		//实例化模型
		$model_member	= Model('member');
		//检查登录状态
		$model_member->checkloginMember();
		if ($_POST['form_submit'] == 'ok'){
			//登录验证
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["user_name"],		"require"=>"true", "message"=>Language::get('login_index_username_isnull')),
				array("input"=>$_POST["password"],		"require"=>"true", "message"=>Language::get('login_index_password_isnull'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage(Language::get('error').$error,'','html','error');
			}else {		
				if (C('captcha_status_login') == '1'){
					$captcha_login = trim($_POST['captcha_login']);
					if (!$captcha_login){
						showMessage(Language::get('login_usersave_code_isnull'),'','html','error');
					}
					if (!checkSeccode($_POST['nchash'],$captcha_login)){
						showMessage(Language::get('login_usersave_wrong_code'),'','html','error');
					}
				}
				if($GLOBALS['setting_config']['ucenter_status'] == '1') {
					//Ucenter处理
					$model_ucenter = Model('ucenter');
					$member_id = $model_ucenter->userLogin(trim($_POST['user_name']),trim($_POST['password']));
					if(intval($member_id) <= 0) {
						showMessage(Language::get('login_index_login_again'),SiteUrl.'/index.php?act=login','','html','error');//'用户名或密码错误，请重新登录'
						exit;
					}
				}
				
				$array	= array();
				$array['member_name']	= trim($_POST['user_name']);
				$array['member_passwd']	= md5(trim($_POST['password']));
				$member_info = $model_member->infoMember($array);
				if(is_array($member_info) and !empty($member_info)) {
					if(!$member_info['member_state']){//1为启用 0 为禁用
						showMessage(Language::get('nc_notallowed_login'),'','html','error');
					}
					/**
					 * 登录时间更新
					 */
					$update_info	= array(
					'member_login_num'=>($member_info['member_login_num']+1),
					'member_login_time'=>time(),
					'member_old_login_time'=>$member_info['member_login_time'],
					'member_login_ip'=>getIp(),
					'member_old_login_ip'=>$member_info['member_login_ip'],
					'member_qqopenid'=>$_SESSION['openid']); //qq openid
					//处理qq账号信息
					$qq_arr = array();
					if (trim($_POST['loginnickname'])){
						$qq_arr['nickname'] = trim($_POST['loginnickname']);
					}
					$qq_str = '';
					if (is_array($qq_arr) && count($qq_arr)>0){
						$qq_str = serialize($qq_arr);
					}
					$update_info['member_qqinfo']	= $qq_str;//qq 信息
					
					$model_member->updateMember($update_info,$member_info['member_id']);
					/**
					 * 写入session
					 */
					$_SESSION['is_login']	= '1';
					$_SESSION['is_seller']	= intval($member_info['store_id']) == 0 ? '' : 1;
					$_SESSION['member_id']	= $member_info['member_id'];
					$_SESSION['member_name']= $member_info['member_name'];
					$_SESSION['member_email']= $member_info['member_email'];
					//查询店铺信息
					$store_model = Model('store');
					$store_info = $store_model->shopStore(array('store_id'=>$member_info['store_id']));
					if (is_array($store_info) && count($store_info)>0){
						$_SESSION['store_id']	= $store_info['store_id'];
						$_SESSION['store_name']	= $store_info['store_name'];
						$_SESSION['grade_id']	= $store_info['grade_id'];
					}
					
					//添加会员积分
					if ($GLOBALS['setting_config']['points_isuse'] == 1){
						$points_model = Model('points');
						$points_model->savePointsLog('login',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name']),true);
					}
					/**
					 * 同步登录通知
					 */
					$success_message = Language::get('login_index_login_success');
					if($GLOBALS['setting_config']['ucenter_status'] == '1') {
						$out_str = $model_ucenter->outputLogin($member_info['member_id'],trim($_POST['password']));
						$success_message = $success_message.$out_str;
					}
					/**
					 * 返回信息
					 */
					showMessage($success_message,SiteUrl);
				} else {
					/**
					 * 返回信息
					 */
					showMessage(Language::get('login_index_login_again'),'','html','error');//'用户名或密码错误，请重新登录'
				}
			}
		}else {
			//获取qq账号信息
			require_once (BasePath.DS.'api'.DS.'qq'.DS.'user'.DS.'get_user_info.php');
			$qquser_info = get_user_info($_SESSION["appid"], $_SESSION["appkey"], $_SESSION["token"], $_SESSION["secret"], $_SESSION["openid"]);
			Tpl::output('qquser_info',$qquser_info);
			Tpl::output('nchash',substr(md5(SiteUrl.$_GET['act'].$_GET['op']),0,8));
			Tpl::showpage('connect_register');
		}
	}
	/**
	 * 绑定qq后自动登录
	 */
	public function autologin(){
		//查询是否已经绑定该qq,已经绑定则直接跳转
		$model_member	= Model('member');
		$array	= array();
		$array['member_qqopenid']	= $_SESSION['openid'];
		$member_info = $model_member->infoMember($array);
		if (is_array($member_info) && count($member_info)>0){
			if(!$member_info['member_state']){//1为启用 0 为禁用
				showMessage(Language::get('nc_notallowed_login'),'','html','error');
			}
			//验证用户在ucenter中信息是否存在
			if($GLOBALS['setting_config']['ucenter_status'] == '1') {
				$model_ucenter = Model('ucenter');
				$uc_userinfo = $model_ucenter->getUserInfo($member_info['member_name']);
				if (!is_array($uc_userinfo) || count($uc_userinfo)<=0){
					showMessage(Language::get('login_index_login_fail'),SiteUrl.'/index.php?act=login&op=register','html','error');//'登录失败'
				}else {
					if ($uc_userinfo[0] != $member_info['member_id'] || $uc_userinfo[1] != $member_info['member_name']){
						showMessage(Language::get('login_index_login_fail'),SiteUrl.'/index.php?act=login&op=register','html','error');//'登录失败'
					}
				}
			}
			//设置session
			/**
			 * 登录时间更新
			 */
			$update_info	= array(
			'member_login_num'=>($member_info['member_login_num']+1),
			'member_login_time'=>time(),
			'member_old_login_time'=>$member_info['member_login_time'],
			'member_login_ip'=>getIp(),
			'member_old_login_ip'=>$member_info['member_login_ip'],
			'member_qqopenid'=>$_SESSION['openid']); //qq openid
			$model_member->updateMember($update_info,$member_info['member_id']);
			/**
			 * 写入session
			 */
			$_SESSION['is_login']	= '1';
			$_SESSION['is_seller']	= intval($member_info['store_id']) == 0 ? '' : 1;
			$_SESSION['member_id']	= $member_info['member_id'];
			$_SESSION['member_name']= $member_info['member_name'];
			$_SESSION['member_email']= $member_info['member_email'];
			//查询店铺信息
			$store_model = Model('store');
			$store_info = $store_model->shopStore(array('store_id'=>$member_info['store_id']));
			if (is_array($store_info) && count($store_info)>0){
				$_SESSION['store_id']	= $store_info['store_id'];
				$_SESSION['store_name']	= $store_info['store_name'];
				$_SESSION['grade_id']	= $store_info['grade_id'];
			}
			
			//添加会员积分
			if ($GLOBALS['setting_config']['points_isuse'] == 1){
				$points_model = Model('points');
				$points_model->savePointsLog('login',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name']),true);
			}
			/**
			 * 同步登录通知
			 */
			$success_message = Language::get('login_index_login_success');
			if($GLOBALS['setting_config']['ucenter_status'] == '1') {
				$out_str = $model_ucenter->outputLogin($member_info['member_id'],'');
				$success_message = $success_message.$out_str;
			}
			showMessage($success_message,SiteUrl);
		}
	}
	/**
	 * 已有用户绑定QQ
	 */
	public function bindqqOp(){
		$model_member	= Model('member');
		//验证QQ账号用户是否已经存在
		$array	= array();
		$array['member_qqopenid']	= $_SESSION['openid'];
		$member_info = $model_member->infoMember($array);
		if (is_array($member_info) && count($member_info)>0){
			unset($_SESSION['openid']);
			showMessage(Language::get('home_qqconnect_binding_exist'),'index.php?act=member_qqconnect&op=qqbind','html','error');//'该QQ账号已经绑定其他商城账号,请使用其他QQ账号与本账号绑定'
		}
		$edit_state		= $model_member->updateMember(array('member_qqopenid'=>$_SESSION['openid']),$_SESSION['member_id']);
		if ($edit_state){
			showMessage(Language::get('home_qqconnect_binding_success'),'index.php?act=member_qqconnect&op=qqbind');
		}else {
			showMessage(Language::get('home_qqconnect_binding_fail'),'index.php?act=member_qqconnect&op=qqbind','html','error');//'绑定QQ失败'
		}
	}
	/**
	 * 更换绑定QQ号码
	 */
	public function changeqqOp(){
		//如果用户已经登录，进入此链接则显示错误
		if($_SESSION['is_login'] == '1') {
			showMessage(Language::get('home_qqconnect_error'),'index.php','html','error');//'系统错误'
		}
		unset($_SESSION['openid']);
		@header('Location:'.SiteUrl.'/api.php?act=toqq');
		exit;
	}
}