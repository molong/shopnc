<?php
/**
 * 前台登录 退出操作
 *
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class loginControl extends BaseHomeControl {

	public function __construct(){
		parent::__construct();
	}

	/**
	 * 登录操作
	 *
	 * @param
	 * @return
	 */
	public function indexOp(){
		Language::read("home_login_index");
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_member	= Model('member');
		/**
		 * 检查登录状态
		 */
		$model_member->checkloginMember();
		
		if (chksubmit()){
			if (cookie('tm_login') == 5){
				showDialog($lang['nc_common_op_repeat'],SiteUrl);
			}

			Security::checkToken();

			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["user_name"],		"require"=>"true", "message"=>$lang['login_index_username_isnull']),
			array("input"=>$_POST["password"],		"require"=>"true", "message"=>$lang['login_index_password_isnull']),
			array("input"=>$_POST["captcha"],		"require"=>(C('captcha_status_login') ? "true" : "false"), "message"=>$lang['login_index_input_checkcode']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}else {
				if (C('captcha_status_login')){
					if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
						showDialog($lang['login_index_wrong_checkcode']);
					}
				}

				if(C('ucenter_status')) {
					$model_ucenter = Model('ucenter');
					$member_id = $model_ucenter->userLogin(trim($_POST['user_name']),trim($_POST['password']));
					if(intval($member_id) == 0) {
						if (cookie('tm_login') >= 6){
							showDialog($lang['nc_common_op_repeat']);
						}
						log_times('login');
						showDialog($lang['login_index_login_again']);
					}
				}
				$array	= array();
				$array['member_name']	= trim($_POST['user_name']);
				$array['member_passwd']	= md5(trim($_POST['password']));
				$member_info = $model_member->infoMember($array);
				if(is_array($member_info) and !empty($member_info)) {
					setNcCookie('tm_login','',-3600);
					if(!$member_info['member_state']){
						showDialog($lang['nc_notallowed_login']);
					}
					/**
					 * 登录时间更新
					 */
					$update_info	= array(
					'member_login_num'=>($member_info['member_login_num']+1),
					'member_login_time'=>time(),
					'member_old_login_time'=>$member_info['member_login_time'],
					'member_login_ip'=>getIp(),
					'member_old_login_ip'=>$member_info['member_login_ip']);
					$model_member->updateMember($update_info,$member_info['member_id']);
					/**
					 * 写入session
					 */
					$_SESSION['is_login']	= '1';
					$_SESSION['is_seller']	= intval($member_info['store_id']) == 0 ? '' : 1;
					$_SESSION['member_id']	= $member_info['member_id'];
					$_SESSION['member_name']= $member_info['member_name'];
					$_SESSION['member_email']= $member_info['member_email'];

					if ($GLOBALS['setting_config']['qq_isuse'] == 1 && trim($member_info['member_qqopenid'])){
						$_SESSION['openid']		= $member_info['member_qqopenid'];
					}
					if ($GLOBALS['setting_config']['sina_isuse'] == 1 && trim($member_info['member_sinaopenid'])){
						$_SESSION['slast_key']['uid'] = $member_info['member_sinaopenid'];
					}
					//查询店铺信息
					if ($member_info['store_id'] > 0){
						$store_model = Model('store');
						$store_info = $store_model->shopStore(array('store_id'=>$member_info['store_id']));
						if (is_array($store_info) && count($store_info)>0){
							$_SESSION['store_id']	= $store_info['store_id'];
							$_SESSION['store_name']	= $store_info['store_name'];
							$_SESSION['grade_id']	= $store_info['grade_id'];
						}
					}
					// cookie中的cart存入数据库
					$this->mergecart();
					
					//添加会员积分
					if (C('points_isuse')){
						//一天内只有第一次登录赠送积分
						if(trim(@date('Y-m-d',$member_info['member_login_time']))!=trim(date('Y-m-d'))){
							$points_model = Model('points');
							$points_model->savePointsLog('login',array('pl_memberid'=>$member_info['member_id'],'pl_membername'=>$member_info['member_name']),true);
						}
					}
					$evaluate_model = Model('evaluate');
					$evaluate_model->updateMemberStat($_SESSION['member_id'],$_SESSION['store_id']);//统计更新:会员信用,卖家信用,店铺评分
					$_POST['ref_url']	= strstr($_POST['ref_url'],'logout')=== false && !empty($_POST['ref_url']) ? $_POST['ref_url'] : 'index.php?act=member_snsindex';
					if(C('ucenter_status')) {
						$extrajs = $model_ucenter->outputLogin($member_info['member_id'],trim($_POST['password']));						
					}elseif(empty($_GET['inajax'])){
						@header('location: '.$_POST['ref_url']);exit();
					}

					$extrajs = empty($_GET['inajax']) ? $extrajs : $extrajs.'<script>CUR_DIALOG.close();</script>';
					$_POST['ref_url'] 	= empty($_GET['inajax']) ? $_POST['ref_url'] : 'reload';
					showDialog($lang['login_index_login_success'],$_POST['ref_url'],'succ',$extrajs);
				} else {
					log_times('login');
					showDialog($lang['login_index_login_fail']);
				}
			}
		}

		$_pic = @unserialize(C('login_pic'));
		if ($_pic[0] != ''){
			Tpl::output('lpic',SiteUrl.'/'.ATTACH_PATH.'/login/'.$_pic[array_rand($_pic)]);
		}else{
			Tpl::output('lpic',SiteUrl.'/'.ATTACH_PATH.'/login/'.rand(1,4).'.jpg');
		}

		/**
		 * 判断是否登录，如果登录，则跳转回首页
		 */
		if ($_SESSION['is_login'] == '1'){
			@header('location: index.php');
			exit;
		}
		if (C('captcha_status_login')){
			Tpl::output('nchash',substr(md5(SiteUrl.$_GET['act'].$_GET['op']),0,8));
		}
		if(empty($_GET['ref_url'])) $_GET['ref_url'] = getReferer();
		Tpl::output('html_title',C('site_name').' - '.$lang['login_index_login']);
		if ($_GET['inajax'] == 1){
			Tpl::showpage('login_inajax','null_layout');
		}else{
			Tpl::showpage('login');
		}
	}

	/**
	 * 退出操作
	 *
	 * @param int $id 记录ID
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function logoutOp(){
		/**
		 * 读取语言包
		 */
		Language::read("home_login_index");
		$lang	= Language::getLangContent();
		session_unset();
		session_destroy();
		setNcCookie('uid','',-3600);
		setNcCookie('rp_reg','',-3600);
		setNcCookie('tm_login','',-3600);
		setNcCookie('goodsnum','',-3600);		// 购物车商品种数
		/**
		* 同步登录通知
		*/
		if(C('ucenter_status')) {
			/**
			* Ucenter处理
			*/
			$model_ucenter = Model('ucenter');
			$out_str = $model_ucenter->userLogout();
			$lang['login_logout_success'] = $lang['login_logout_success'].$out_str;	
			if(empty($_GET['ref_url'])){
				$ref_url = getReferer();
			}else {
				$ref_url = $_GET['ref_url'];
			}
			showMessage($lang['login_logout_success'],'index.php?act=login&ref_url='.urlencode($ref_url));			
		}else{
			redirect();
		}
	}
	/**
	 * 会员注册页面
	 *
	 * @param
	 * @return
	 */
	public function registerOp() {
		/**
		 * 读取语言包
		 */
		Language::read("home_login_register");
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_member	= Model('member');
		/**
		 * 检查登录状态
		 */
		$model_member->checkloginMember();
		if(C('captcha_status_register') == '1'){
			Tpl::output('nchash',substr(md5(SiteUrl.$_GET['act'].$_GET['op']),0,8));
		}
		Tpl::output('html_title',C('site_name').' - '.$lang['login_register_join_us']);
		Tpl::showpage('register');
	}
	/**
	 * 会员添加操作
	 *
	 * @param
	 * @return
	 */
	public function usersaveOp() {
		//重复注册验证		
		if (check_repeat('reg',40)){
			showDialog(Language::get('nc_common_op_repeat'),'index.php');
		}

		/**
		 * 读取语言包
		 */
		Language::read("home_login_register");
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_member	= Model('member');
		/**
		 * 检查登录状态
		 */
		$model_member->checkloginMember();

		/**
		 * 注册验证
		 */
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
		array("input"=>$_POST["user_name"],		"require"=>"true",		"message"=>$lang['login_usersave_username_isnull']),
		array("input"=>$_POST["password"],		"require"=>"true",		"message"=>$lang['login_usersave_password_isnull']),
		array("input"=>$_POST["password_confirm"],"require"=>"true",	"validator"=>"Compare","operator"=>"==","to"=>$_POST["password"],"message"=>$lang['login_usersave_password_not_the_same']),
		array("input"=>$_POST["email"],			"require"=>"true",		"validator"=>"email", "message"=>$lang['login_usersave_wrong_format_email']),
		array("input"=>strtoupper($_POST["captcha"]),"require"=>(C('captcha_status_register') == '1' ? "true" : "false"),"message"=>$lang['login_usersave_code_isnull']),
		array("input"=>$_POST["agree"],			"require"=>"true", 		"message"=>$lang['login_usersave_you_must_agree'])
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			showValidateError($error);
		}
		if (C('captcha_status_login')){
			if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
				showDialog($lang['login_usersave_wrong_code']);
			}
		}
		$check_member_name	= $model_member->infoMember(array('member_name'=>trim($_POST['user_name'])));
		if(is_array($check_member_name) and count($check_member_name)>0) {
			showDialog($lang['login_usersave_your_username_exists']);
		}
		$check_member_email	= $model_member->infoMember(array('member_email'=>trim($_POST['email'])));
		if(is_array($check_member_email) and count($check_member_email)>0) {
			showDialog($lang['login_usersave_your_email_exists']);
		}
		$user_array	= array();

		if(C('ucenter_status')) {
			/**
			* Ucenter处理
			*/
			$model_ucenter = Model('ucenter');
			$uid = $model_ucenter->addUser(trim($_POST['user_name']),trim($_POST['password']),trim($_POST['email']));
			if($uid<1) showMessage($lang['login_usersave_regist_fail'],'','html','error');
			$user_array['member_id']		= $uid;
		}
		/**
		 * 会员添加
		 */
		$user_array['member_name']		= $_POST['user_name'];
		$user_array['member_passwd']	= $_POST['password'];
		$user_array['member_email']		= $_POST['email'];
		$result	= $model_member->addMember($user_array);
		if($result) {

			//注册时间标记，访问灌入垃圾用户
			setNcCookie('rp_reg',time());

			$_SESSION['is_login']	= '1';
			$_SESSION['member_id']	= $result;
			$_SESSION['member_name']= trim($user_array['member_name']);
			$_SESSION['member_email']= trim($user_array['member_email']);

			$this->mergecart();						// cookie中的cart存入数据库

			//添加会员积分
			if ($GLOBALS['setting_config']['points_isuse'] == 1){
				$points_model = Model('points');
				$points_model->savePointsLog('regist',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name']),false);
			}
			$_POST['ref_url']	= (strstr($_POST['ref_url'],'logout')=== false && !empty($_POST['ref_url']) ? $_POST['ref_url'] : 'index.php?act=home&op=member');

			showDialog(str_replace('site_name',C('site_name'),$lang['login_usersave_regist_success_ajax']),$_POST['ref_url'],'succ','',3);
		} else {
			showDialog(Language::get('login_usersave_regist_fail'));
		}
	}
	/**
	 * 会员名称检测
	 *
	 * @param
	 * @return
	 */
	public function check_memberOp() {
		if(C('ucenter_status')) {
			/**
		 	* 实例化Ucenter模型
		 	*/
			$model_ucenter = Model('ucenter');
			$result = $model_ucenter->checkUserExit(trim($_GET['user_name']));
			if($result == 1) {
				echo 'true';
			} else {
				echo 'false';
			}
		} else {
			/**
		 	* 实例化模型
		 	*/
			$model_member	= Model('member');

			$check_member_name	= $model_member->infoMember(array('member_name'=>trim($_GET['user_name'])));
			if(is_array($check_member_name) and count($check_member_name)>0) {
				echo 'false';
			} else {
				echo 'true';
			}
		}
	}
	/**
	 * cookie中的cart存入数据库
	 *
	 */
	private function mergecart(){
		//登录之后,判断是否存在购物车cookie
		if (cookie('cart') && $_SESSION['member_id']){
			//读取cookie购物车信息
			$cart_str = cookie('cart');
			if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
			$cookie_cart = unserialize($cart_str);
			if (!empty($cookie_cart)){
				//取出已有购物车信息
				$model_cart	= Model('cart');
				$cart_goods_arr	= $model_cart->listCart();				
				$cart_goodsspecid_arr = array();
				if(!empty($cart_goods_arr)) {
					foreach ($cart_goods_arr as $v){
						$cart_goodsspecid_arr[] = $v['spec_id'];
					}
				}
				//剔除数据库购物车与cookie购物车的重复项	
				foreach ($cookie_cart as $k=>$v){
					if (is_array($cart_goodsspecid_arr) && in_array($k,$cart_goodsspecid_arr)){
						unset($cookie_cart[$k]);
					}
				}
				unset($cart_goodsspecid_arr);
				unset($cart_goods_arr);
				
				//查询cookie购物车商品信息
				if (!empty($cookie_cart)){
					$mode_goods= Model('goods');
					//查询在cookie购物车中,不是店铺自己的商品，未禁售，上架，有库存的商品
					$cookie_cart_goods = $mode_goods->getGoods(array('no_store_id'=>"{$_SESSION['store_id']}",'goods_state'=>'0','goods_show'=>'1','spec_storage_enough'=>'yes','spec_id_in'=>"'".implode("','",array_keys($cookie_cart))."'"),'',"goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.spec_open,goods_spec.*","groupbuy_goods_info");
					if (!empty($cookie_cart_goods)){
						foreach ($cookie_cart_goods as $k=>$v){
							//cookie购物车信息，插入数据库购物车
							$insert_cart = array();
							$insert_cart						= array();
							$insert_cart['member_id']			= $_SESSION['member_id'];
							$insert_cart['store_id']			= $v['store_id'];
							$insert_cart['goods_id']			= $v['goods_id'];
							$insert_cart['goods_name']			= $v['goods_name'];
							$insert_cart['spec_id']				= $v['spec_id'];
							//构造购物车规格信息
							$insert_cart['spec_info'] = '';
							if ($v['spec_open'] == 1 && !empty($v['spec_goods_spec']) && !empty($v['spec_name'])){
								$spec_name = unserialize($v['spec_name']);
								if (!empty($spec_name)){
									$spec_name = array_values($spec_name);
									$spec_goods_spec = unserialize($v['spec_goods_spec']);
									$i = 0;
									foreach ($spec_goods_spec as $k=>$specv){
										$insert_cart['spec_info'] .= $spec_name[$i].":".$specv."&nbsp;";
										$i++;
									}
								}
							}
							$insert_cart['goods_store_price']	= $v['spec_goods_price'];
							//商品购买数量，根据库存判断
							$insert_cart['goods_num']			= intval($cookie_cart[$v['spec_id']]['num']);
							if ($insert_cart['goods_num'] > $v['spec_goods_storage']){
								$insert_cart['goods_num'] = $v['spec_goods_storage'];
							}
							$insert_cart['goods_images']		= $v['goods_image'];
							$model_cart->addCart($insert_cart);
						}
					}
				}
			}
			setNcCookie('cart','',-3600);
			setNcCookie('goodsnum','',-3600);		// 购物车商品种数
		}
	}
	/**
	 * 电子邮箱检测
	 *
	 * @param
	 * @return
	 */
	public function check_emailOp() {
		if(C('ucenter_status')) {
			/**
		 	* 实例化Ucenter模型
		 	*/
			$model_ucenter = Model('ucenter');
			$result = $model_ucenter->checkEmailExit(trim($_GET['email']));
			if($result == 1) {
				echo 'true';
			} else {
				echo 'false';
			}

		} else {
			/**
		 	* 实例化模型
		 	*/
			$model_member	= Model('member');

			$check_member_email	= $model_member->infoMember(array('member_email'=>trim($_GET['email'])));
			if(is_array($check_member_email) and count($check_member_email)>0) {
				echo 'false';
			} else {
				echo 'true';
			}
		}
	}
	/**
	 * 忘记密码页面
	 */
	public function forget_passwordOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_login_register');
		$_pic = @unserialize(C('login_pic'));
		if ($_pic[0] != ''){
			Tpl::output('lpic',SiteUrl.'/'.ATTACH_PATH.'/login/'.$_pic[array_rand($_pic)]);
		}else{
			Tpl::output('lpic',SiteUrl.'/'.ATTACH_PATH.'/login/'.rand(1,4).'.jpg');
		}
		Tpl::output('nchash',substr(md5(SiteUrl.$_GET['act'].$_GET['op']),0,8));
		Tpl::output('html_title',C('site_name').' - '.Language::get('login_index_find_password'));
		Tpl::showpage('find_password');
	}
	/**
	 * 找回密码的发邮件处理
	 */
	public function find_passwordOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_login_register');
		$lang	= Language::getLangContent();
		/**
		 * 表单合法性验证
		 */
		if($_POST['form_submit']!='ok'){
			showMessage($lang['login_password_enter_find'],'index.php?act=login&op=forget_password');
		}
		/**
		 * 验证码验证
		 */
		if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
			showMessage($lang['login_usersave_wrong_code'],'','html','error');
		}
		/**
		 * 用户名验证
		 */
		if(empty($_POST['username'])){
			showMessage($lang['login_password_input_username'],'','html','error');
		}
		$member_model	= Model('member');
		$member	= $member_model->infoMember(array('member_name'=>$_POST['username']));
		if(empty($member) or !is_array($member)){
			showMessage($lang['login_password_username_not_exists'],'','html','error');
		}
		/**
		 * 邮箱验证
		 */
		if(empty($_POST['email'])){
			showMessage($lang['login_password_input_email'],'','html','error');
		}
		if(strtoupper($_POST['email'])!=strtoupper($member['member_email'])){
			showMessage($lang['login_password_email_not_exists'],'','html','error');
		}
		/**
		 * 产生密码
		 */
		$new_password	= rand(100000,999999);
		if(!($member_model->updateMember(array('member_passwd'=>md5($new_password)),$member['member_id']))){
			showMessage($lang['login_password_email_fail'],'','html','error');
		}
		/**
		 * 发送邮件
		 */
		$result	= $this->send_notice($member['member_id'],'email_touser_find_password',array(
		'site_name'	=> $GLOBALS['setting_config']['site_name'],
		'site_url'	=> SiteUrl,
		'user_name'	=> $_POST['username'],
		'new_password'	=> $new_password
		),false);
		if($result){
			if(C('ucenter_status')) {
				/**
				* Ucenter处理
				*/
				$model_ucenter = Model('ucenter');
				$model_ucenter->userEdit(array('login_name'=>$_POST['username'],'','password'=>trim($new_password)));
			}
			showMessage($lang['login_password_email_success'],SiteUrl);
		}else{
			showMessage($lang['login_password_email_fail'],'','html','error');
		}
	}
}
