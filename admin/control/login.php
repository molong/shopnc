<?php
/**
 * 登录
 *
 * 包括 登录 验证 退出 操作
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class LoginControl extends SystemControl {

	/**
	 * 不进行父类的登录验证，所以增加构造方法重写了父类的构造方法
	 */
	public function __construct(){
		Language::read('common,layout,login');
		$lang	= Language::getLangContent();
		if (chksubmit()){
			/**
			 * 检查提交
			 */
			Security::checkToken();
			/**
			 * 登录验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["user_name"],		"require"=>"true", "message"=>$lang['login_index_username_null']),
			array("input"=>$_POST["password"],		"require"=>"true", "message"=>$lang['login_index_password_null']),
			array("input"=>$_POST["captcha"],		"require"=>"true", "message"=>$lang['login_index_checkcode_null']),
			);

			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($lang['error'].$error);
			}else {
				if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
					showMessage($lang['login_index_checkcode_wrong'].$error);
				}
				/**
				 * 验证登录
				 * 目前为 都可以登录
				 */
				$model_admin = Model('admin');
				$array	= array();
				$array['admin_name']	= trim($_POST['user_name']);
				$array['admin_password']	= md5(trim($_POST['password']));
				$admin_info = $model_admin->infoAdmin($array);
				if(is_array($admin_info) and !empty($admin_info)) {
					$login_array = array();
					$login_array['name']	= $admin_info['admin_name'];
					$login_array['id']		= $admin_info['admin_id'];
					/**
					 * 判断是否有登录权限
					 * 暂时对admin_info进行赋值用来做权限验证
					 */
					$this->setAdminInfo($login_array);
					$this->checkPermission('login');
					/**
					 * 加密 写入cookie
					 */
					$authkey = md5(C('setup_date').MD5_KEY);
					setNcCookie('sys_key',encrypt(serialize($login_array),$authkey));
					/**
					 * 登录时间更新
					 */
					$update_info	= array(
					'admin_id'=>$admin_info['admin_id'],
					'admin_login_num'=>($admin_info['admin_login_num']+1),
					'admin_login_time'=>time()
					);
					$model_admin->updateAdmin($update_info);
					@header('Location: index.php');
					exit;
				}else {
					showMessage($lang['login_index_username_password_wrong'],'index.php?act=login&op=login');
				}
			}
		}
		Tpl::output('nchash',substr(md5(SiteUrl.$_GET['act'].$_GET['op']),0,8));
		Tpl::output('html_title',$lang['login_index_need_login']);
		Tpl::showpage('login','login_layout');
	}

	public function loginOp(){}
	public function indexOp(){}
}