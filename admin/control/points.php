<?php
/**
 * 积分管理
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class pointsControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('points');
		/**
		 * 判断系统是否开启积分功能
		 */
		if ($GLOBALS['setting_config']['points_isuse'] != 1){
			showMessage(Language::get('admin_points_unavailable'),'index.php?act=dashboard&op=welcome','','error');
		}
	}
	/**
	 * 积分添加
	 */
	public function addpointsOp(){
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["member_id"], "require"=>"true", "message"=>Language::get('admin_points_member_error_again')),
				array("input"=>$_POST["pointsnum"], "require"=>"true",'validator'=>'Compare','operator'=>' >= ','to'=>1,"message"=>Language::get('admin_points_points_min_error'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error,'','','error');
			}
			//查询会员信息
			$obj_member = Model('member');
			$member_id = intval($_POST['member_id']);
			$member_info = $obj_member->infoMember(array('member_id'=>"$member_id"));
			
			if (!is_array($member_info) || count($member_info)<=0){
				showMessage(Language::get('admin_points_userrecord_error'),'index.php?act=points&op=addpoints','','error');
			}
			
			$pointsnum = intval($_POST['pointsnum']);
			if ($_POST['operatetype'] == 2 && $pointsnum > intval($member_info['member_points'])){
				showMessage(Language::get('admin_points_points_short_error').$member_info['member_points'],'index.php?act=points&op=addpoints','','error');
			}
			
			$obj_points = Model('points');
			$insert_arr['pl_memberid'] = $member_info['member_id'];
			$insert_arr['pl_membername'] = $member_info['member_name'];
			$admininfo = $this->getAdminInfo();
			$insert_arr['pl_adminid'] = $admininfo['id'];
			$insert_arr['pl_adminname'] = $admininfo['name'];
			if ($_POST['operatetype'] == 2){
				$insert_arr['pl_points'] = -$_POST['pointsnum'];
			}else {
				$insert_arr['pl_points'] = $_POST['pointsnum'];
			}
			if ($_POST['pointsdesc']){
				$insert_arr['pl_desc'] = trim($_POST['pointsdesc']);	
			} else {
				$insert_arr['pl_desc'] = Language::get('admin_points_system_desc');
			}
			$result = $obj_points->savePointsLog('system',$insert_arr,true);
			if ($result){
				showMessage(Language::get('admin_points_add_success'),'index.php?act=points&op=addpoints');
			}else {
				showMessage(Language::get('admin_points_add_fail'),'index.php?act=points&op=addpoints','','error');
			}
		}else {
			Tpl::showpage('points.add');
		}
	}
	public function checkmemberOp(){
		$name = trim($_GET['name']);
		if (!$name){
			echo ''; die;
		}
		/**
		 * 转码
		 */
		if(strtoupper(CHARSET) == 'GBK'){
			$name = Language::getGBK($name);
		}
		$obj_member = Model('member');
		$member_info = $obj_member->infoMember(array('member_name'=>$name));
		if (is_array($member_info) && count($member_info)>0){
			if(strtoupper(CHARSET) == 'GBK'){
				$member_info['member_name'] = Language::getUTF8($member_info['member_name']);
			}
			echo json_encode(array('id'=>$member_info['member_id'],'name'=>$member_info['member_name'],'points'=>$member_info['member_points']));
		}else {
			echo ''; die;
		}
	}
}