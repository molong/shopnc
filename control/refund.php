<?php
/**
 * 退款
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

class refundControl extends BaseMemberStoreControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_refund');
		$state_array = array(
			'1' => Language::get('refund_state_confirm'),
			'2' => Language::get('refund_state_yes'),
			'3' => Language::get('refund_state_no')
			);//状态:1为待审核,2为同意,3为不同意
		Tpl::output('state_array',$state_array);
		
	}
	/**
	 * 退款记录列表页
	 *
	 */
	public function indexOp(){
		/**
		 * 实例化退款模型
		 */
		$model_refund	= Model('refund');
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		/**
		 * 查询退款记录
		 */
		$condition = array();
		$condition['seller_id'] = $_SESSION['member_id'];
		$condition['seller_refund_state'] = '2';//状态
		$keyword_type = array('order_sn','refund_sn','buyer_name');
		if(trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)){
			$condition['type']	= $_GET['type'];
			$condition['keyword']	= $_GET['key'];
		}
		if(trim($_GET['add_time_from']) != ''){
			$add_time_from	= strtotime(trim($_GET['add_time_from']));
			if($add_time_from !== false){
				$condition['add_time_from']	= $add_time_from;
			}
		}
		if(trim($_GET['add_time_to']) != ''){
			$add_time_to	= strtotime(trim($_GET['add_time_to']));
			if($add_time_to !== false){
				$condition['add_time_to']	= $add_time_to+86400;
			}
		}
		$refund_list = $model_refund->getList($condition,$page);
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('refund','refund');
		Tpl::output('menu_sign','store_refund');
		Tpl::output('menu_sign_url','index.php?act=refund');
		Tpl::output('menu_sign1','store_refund');
		Tpl::showpage('store_refund');
	}
	/**
	 * 退款审核页
	 *
	 */
	public function editOp(){
		/**
		 * 实例化退款模型
		 */
		$model_refund	= Model('refund');
		$condition = array();
		$condition['seller_id'] = $_SESSION['member_id'];
		$condition['log_id'] = intval($_GET["log_id"]);
		$condition['refund_type'] = '1';//买家申请的记录
		$refund_list = $model_refund->getList($condition);
		$refund = $refund_list[0];
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			if($refund['refund_state'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),'reload','error','CUR_DIALOG.close();');
			}
			$model_trade	= Model('trade');
			$refund_array = array();
			$refund_array['log_id'] = $refund['log_id'];
			$refund_array['order_id'] = $refund['order_id'];
			$refund_array['order_refund'] = $refund['order_refund'];
			$refund_array['seller_time'] = time();	
			$refund_array['refund_state'] = $_POST["refund_state"];//状态:1为待审核,2为同意,3为不同意
			$refund_array['refund_message'] = $_POST["refund_message"];
			if($refund_array['refund_state'] == '2' || $refund_array['refund_state'] == '3') {
				if($refund['refund_paymentcode'] == 'predeposit') $state = $model_trade->updateOrderRefund($refund_array);//预存款退款
				if($refund_array['refund_state'] == '3') $refund_array['refund_state'] = '0';
				if($refund['refund_paymentcode'] == 'offline') $state = $model_trade->updateOfflineRefund($refund_array);//线下退款
			}
			if($state) {
				showDialog(Language::get('nc_common_save_succ'),'reload','succ','CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error','CUR_DIALOG.close();');
			}
		}
		Tpl::output('refund',$refund);
		Tpl::showpage('store_refund_edit','null_layout');
	}
	/**
	 * 退款记录查看页
	 *
	 */
	public function viewOp(){
		/**
		 * 实例化退款模型
		 */
		$model_refund	= Model('refund');
		$condition = array();
		$condition['seller_id'] = $_SESSION['member_id'];
		$condition['log_id'] = intval($_GET["log_id"]);
		$refund_list = $model_refund->getList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		Tpl::showpage('store_refund_view','null_layout');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array	= array();
		switch ($menu_type) {
			case 'refund':
				$menu_array	= array(
					1=>array('menu_key'=>'refund','menu_name'=>Language::get('nc_member_path_store_refund'),	'menu_url'=>'index.php?act=refund')
				);
				break;
			case 'seller_refund':
				$menu_array	= array(
					1=>array('menu_key'=>'seller_refund','menu_name'=>Language::get('nc_member_path_seller_refund'),	'menu_url'=>'index.php?act=refund&op=seller')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
