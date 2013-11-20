<?php
/**
 * 管理员管理
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

class adminControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('admin');
	}
	/**
	 * 管理员列表
	 */
	public function adminOp(){
		$lang	= Language::getLangContent();
		$model_admin = Model('admin');
		/**
		 * 删除
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * ID为1的会员不允许删除
			 */
			if (@in_array(1,$_POST['del_id'])){
				showMessage($lang['admin_index_not_allow_del']);
			}
			
			if (!empty($_POST['del_id'])){
				if (is_array($_POST['del_id'])){
					foreach ($_POST['del_id'] as $k => $v){
						$model_admin->delAdmin(intval($v));
					}
				}
				showMessage($lang['admin_index_del_succ']);
			}else {
				showMessage($lang['admin_index_choose']);
			}
		}
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$admin_list = $model_admin->getAdminList($condition,$page);
		
		Tpl::output('admin_list',$admin_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('admin.index');
	}
	
	/**
	 * 管理员删除
	 */
	public function admin_delOp(){
		$lang	= Language::getLangContent();
		if (!empty($_GET['admin_id'])){
			if ($_GET['admin_id'] == 1){
				showMessage($lang['admin_index_choose']);
			}
			$model_admin = Model('admin');			
			$model_admin->delAdmin(intval($_GET['admin_id']));
			showMessage($lang['admin_index_del_succ']);
		}else {
			showMessage($lang['admin_index_choose']);
		}
	}
	
	/**
	 * 管理员添加
	 */
	public function admin_addOp(){
		$lang	= Language::getLangContent();
		/**
		 * 保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			$model_admin = Model('admin');
			$param['admin_name'] = trim($_POST['admin_name']);
			$param['admin_password'] = md5(trim($_POST['admin_password']));
			if (!empty($_POST['permission']) && is_array($_POST['permission'])){
				$permission_str = '';
				foreach ($_POST['permission'] as $k=>$v){
					$permission_array[] = $k;
				}
				$permission_str = implode('|',$permission_array);
				unset($permission_array);
			} else {
				showMessage($lang['admin_index_add_allow']);
			}
			$param['admin_permission'] = $permission_str ? $permission_str : '';
			$rs = $model_admin->addAdmin($param);
			if ($rs){
				showMessage($lang['admin_index_add_succ'],'index.php?act=admin&op=admin');
			}else {
				showMessage($lang['admin_index_add_fail']);
			}
		}
        Tpl::output('function_array',$this->get_permission_list($lang));
		Tpl::showpage('admin.add');
	}
	
	/**
	 * 设置管理员权限
	 */
	public function admin_setOp(){
		$lang	= Language::getLangContent();
		$model_admin = Model('admin');
		/**
		 * 管理员ID
		 */
		$admin_id = intval($_GET['admin_id']);
		/**
		 * 验证管理员是否存在
		 */
		$condition['admin_id'] = $admin_id;
		$admin_info = $model_admin->infoAdmin($condition);
		if (empty($admin_info)){
			showMessage($lang['admin_set_admin_not_exists']);
		}
		/**
		 * 保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 判断权限是否为空
			 */
			if (empty($_POST['permission'])){
				showMessage($lang['admin_set_assign_right']);
			}
			/**
			 * 将权限整理为数组
			 */
			$permission_array = array();
			foreach ($_POST['permission'] as $k => $v){
				$permission_array[] = $k;
			}
			$permission = implode('|',$permission_array);
			/**
			 * 更新管理员
			 */
			$update_array = array();
			$update_array['admin_id'] = $admin_id;
			$update_array['admin_permission'] = $permission;
			$rs = $model_admin->updateAdmin($update_array);
			if ($rs){
				showMessage($lang['admin_set_edit_succ']);
			}else {
				showMessage($lang['admin_set_edit_fail']);
			}
		}
		/**
		 * 管理员信息
		 */
		$admin_array = $model_admin->getOneAdmin($admin_id);
		if (!empty($admin_array)){
			$admin_array['admin_permission'] = explode('|',$admin_array['admin_permission']);
		}

		Tpl::output('admin_array',$admin_array);
		Tpl::output('admin_info',$admin_info);
        Tpl::output('function_array',$this->get_permission_list($lang));

		Tpl::showpage('admin.set');
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 管理员操作 验证用户是否存在
			 */
			case 'check_admin_name':
				$model_admin = Model('admin');
				$condition['admin_name'] = trim($_GET['admin_name']);
				$list = $model_admin->infoAdmin($condition);
				if (!empty($list)){
					echo 'false';exit;
				}else {
					echo 'true';exit;
				}
				break;
		}		
	}
	/**
	 * 设置管理员权限
	 */
	public function admin_editOp(){
		if ($_POST['form_submit'] == 'ok'){
			//没有更改密码
			if (trim($_POST['new_pw']) == ''){
				showMessage(Language::get('admin_edit_success'),'index.php?act=admin&op=admin');
			}
			//修改密码
			if (trim($_POST['new_pw']) !== trim($_POST['new_pw2'])){
				showMessage(Language::get('admin_edit_repeat_error'),'index.php?act=admin&op=admin_edit&admin_id='.$_GET['admin_id']);				
			}
			//查询管理员信息
			$admin_model = Model('admin');
			$new_pw = md5(trim($_POST['new_pw']));
			$result = $admin_model->updateAdmin(array('admin_password'=>$new_pw,'admin_id'=>$_GET['admin_id']));
			if ($result){
				showMessage(Language::get('admin_edit_success'),'index.php?act=admin&op=admin');
			}else{
				showMessage(Language::get('admin_edit_fail'),'index.php?act=admin&op=admin');
			}
		}else{
			//查询用户信息
			$admin_model = Model('admin');
			$admininfo = $admin_model->getOneAdmin(intval($_GET['admin_id']));
			if (!is_array($admininfo) || count($admininfo)<=0){
				showMessage(Language::get('admin_edit_admin_error'),'index.php?act=admin&op=admin');
			}
			Tpl::output('admininfo',$admininfo);
			Tpl::showpage('admin.edit');
		}
	}

    /**
     * 取得所有权限项
     *
     * @param array $lang 语言包
     * @return array
     */
    private function get_permission_list($lang) {
		/**
		 * 取得所有权限项
		 */
		$array = require(BasePath.DS.ProjectName.DS.'include'.DS.'menu.php');
		$permission = array();
		if (is_array($array['left'])){
			foreach ($array['left'] as $k=>$v) {
				/**
				 * 去除常用操作
				 */
				if ($v['nav'] == 'dashboard') continue;
				if (is_array($v['list'])){
					
					$permission[$v['nav']][0] = $v['text'];
					$tmp = array();
					foreach ($v['list'] as $value) {
						$pms_name = explode(',',$value['args']);
						$tmp[$pms_name[1]] .= $value['text'].' ';
					}
					//合并act相同的菜单，作为一个权限
					foreach ($tmp as $tk=>$tv){
						$permission[$v['nav']][] = array($tk,$tv);
					}
				}
			}
		}
		return $permission;
    }
}
