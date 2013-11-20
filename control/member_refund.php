<?php
/**
 * 买家退款
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

class member_refundControl extends BaseMemberControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_member_index');
		Language::read('member_refund');
		
		$state_array = array(
			'1' => Language::get('refund_state_confirm'),
			'2' => Language::get('refund_state_yes'),
			'3' => Language::get('refund_state_no')
			);//状态:1为待审核,2为同意,3为不同意
		Tpl::output('state_array',$state_array);
	}
	/**
	 * 添加预存款退款
	 *
	 */
	public function addOp(){
		$model_order = Model('order');
		$model_refund	= Model('refund');
		$order_id	= intval($_GET["order_id"]);
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$order_list = $model_order->getOrderList($condition);
		$order = $order_list[0];
		Tpl::output('order',$order);
		$order_amount = $order['order_amount'];//订单金额
		$condition = array();
		$condition['buyer_id'] = $order['buyer_id'];
		$condition['order_id'] = $order['order_id'];
		$condition['refund_type'] = '1';//类型:1为买家,2为卖家
		$refund_list = $model_refund->getList($condition);
		$refund = array();
		if(!empty($refund_list) && is_array($refund_list)) {
			$refund = $refund_list[0];
			$log_id = $refund["log_id"];
			Tpl::output('refund',$refund);
		}
		
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			if(!(($order['order_state'] >= 20 && $order['order_state'] < 40) && ($order['payment_code'] == 'predeposit' || C('payment') == 0))) {//检查订单状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),'reload','error','CUR_DIALOG.close();');
			}
			$order_refund = floatval($_POST["order_refund"]);//退款金额
			$refund_array = array();
			if (($order_refund < 0) || ($order_refund > $order_amount)) $order_refund = $order_amount;
			$refund_array['order_refund'] = ncPriceFormat($order_refund);
			$refund_array['buyer_message'] = $_POST["buyer_message"];
			if($log_id > 0) {
				$condition = array();
				$condition['log_id'] = $log_id;
				if($refund["refund_state"] == 1) $state = $model_refund->update($condition,$refund_array);//状态为待处理(1)时允许操作,防止页面刷新不及时造成数据错误
			} else {
				$refund_paymentcode = 'predeposit';
				$refund_array['refund_type'] = '1';//类型:1为买家,2为卖家
				$refund_array['refund_state'] = '1';//状态:1为待审核,2为同意,3为不同意
				$refund_array['order_amount'] = $order_amount;//退款前订单金额
				
				$refund_array['order_id'] = $order['order_id'];
				$refund_array['order_sn'] = $order['order_sn'];
				$refund_array['seller_id'] = $order['seller_id'];
				$refund_array['store_id'] = $order['store_id'];
				$refund_array['store_name'] = $order['store_name'];
				$refund_array['buyer_id'] = $order['buyer_id'];
				$refund_array['buyer_name'] = $order['buyer_name'];
				
				$refund_array['add_time'] = time();	
				$refund_array['refund_paymentname'] = Language::get('refund_payment_'.$refund_paymentcode);
				$refund_array['refund_paymentcode'] = $refund_paymentcode;
				$state = $model_refund->add($refund_array);
	    	$order_array = array();
	    	$order_array['refund_state'] = '1';
	    	if($state) $state = Model()->table('order')->where(array('order_id'=>$order['order_id']))->update($order_array);//更新订单
			}
			if($state) {
				showDialog(Language::get('nc_common_save_succ'),'reload','succ','CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error','CUR_DIALOG.close();');
			}
		}
		if($refund["refund_state"] > 1) {
			Tpl::showpage('member_refund_view','null_layout');
		}
		Tpl::showpage('member_refund_add','null_layout');
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
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['refund_type'] = '1';//类型:1为买家申请,2为卖家记录
		
		$keyword_type = array('order_sn','refund_sn','store_name');
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
		//查询会员信息
		$this->get_member_info();
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('member_order','buyer_refund');
		Tpl::output('menu_sign','myorder');
		Tpl::output('menu_sign_url','index.php?act=member&op=order');
		Tpl::output('menu_sign1','buyer_refund');
		Tpl::showpage('member_refund');
	}
	/**
	 * 退款记录查看
	 *
	 */
	public function viewOp(){
		/**
		 * 实例化退款模型
		 */
		$model_refund	= Model('refund');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['refund_type'] = '1';
		$condition['log_id'] = intval($_GET["log_id"]);
		$refund_list = $model_refund->getList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		Tpl::showpage('member_refund_view','null_layout');
	}
	/**
	 * 线下退款确认
	 *
	 */
	public function buyer_confirmOp(){
		/**
		 * 实例化退款模型
		 */
		$model_refund	= Model('refund');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['refund_type'] = '1';
		$condition['log_id'] = intval($_GET["log_id"]);
		$refund_list = $model_refund->getList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			if($refund['buyer_confirm'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),'reload','error','CUR_DIALOG.close();');
			}
			$model_trade	= Model('trade');
			$refund_array = array();
			$refund_array['log_id'] = $refund['log_id'];
			$refund_array['order_id'] = $refund['order_id'];
			$refund_array['order_refund'] = $refund['order_refund'];
			$refund_array['confirm_time'] = time();	
			$refund_array['buyer_confirm'] = $_POST["buyer_confirm"];//收款状态:1为待确认,2为已确认
			if($refund_array['buyer_confirm'] == '2') {
				if($refund['refund_paymentcode'] == 'offline') $state = $model_trade->updateOfflineRefund($refund_array);//线下退款
			}
			if($state) {
				showDialog(Language::get('nc_common_save_succ'),'reload','succ','CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error','CUR_DIALOG.close();');
			}
		}
		Tpl::showpage('member_refund_buyer_confirm','null_layout');
	}
	/**
	 * 添加线下退款
	 *
	 */
	public function offline_addOp(){
		$model_order = Model('order');
		$model_refund	= Model('refund');
		$order_id	= intval($_GET["order_id"]);
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$order_list = $model_order->getOrderList($condition);
		$order = $order_list[0];
		Tpl::output('order',$order);
		$order_amount = $order['order_amount'];//订单金额
		$condition = array();
		$condition['buyer_id'] = $order['buyer_id'];
		$condition['order_id'] = $order['order_id'];
		$condition['refund_type'] = '1';//类型:1为买家,2为卖家
		$refund_list = $model_refund->getList($condition);
		$refund = array();
		if(!empty($refund_list) && is_array($refund_list)) {
			$refund = $refund_list[0];
			$log_id = $refund["log_id"];
			Tpl::output('refund',$refund);
		}
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			if($order['order_state'] < 20 || $order['order_state'] > 30 || $order['payment_code'] == 'predeposit' || $order['payment_code'] == 'cod' || C('payment') == 0) {//检查订单状态,防止页面刷新不及时造成数据错误
				showDialog(Language::get('wrong_argument'),'reload','error','CUR_DIALOG.close();');
			}
			$order_refund = floatval($_POST["order_refund"]);//退款金额
			$refund_array = array();
			if (($order_refund < 0) || ($order_refund > $order_amount)) $order_refund = $order_amount;
			$refund_array['order_refund'] = ncPriceFormat($order_refund);
			$refund_array['buyer_message'] = $_POST["buyer_message"];
			if($log_id > 0) {
				$condition = array();
				$condition['log_id'] = $log_id;
				if($refund["refund_state"] == 1) $state = $model_refund->update($condition,$refund_array);//状态为待处理(1)时允许操作,防止页面刷新不及时造成数据错误
			} else {
				$refund_paymentcode = 'offline';
				$refund_array['refund_type'] = '1';//类型:1为买家,2为卖家
				$refund_array['refund_state'] = '1';//审核状态:1为待审核,2为同意,3为不同意
				$refund_array['buyer_confirm'] = '1';//收款状态:1为待确认,2为已确认
				$refund_array['order_amount'] = $order_amount;//退款前订单金额
				
				$refund_array['order_id'] = $order['order_id'];
				$refund_array['order_sn'] = $order['order_sn'];
				$refund_array['seller_id'] = $order['seller_id'];
				$refund_array['store_id'] = $order['store_id'];
				$refund_array['store_name'] = $order['store_name'];
				$refund_array['buyer_id'] = $order['buyer_id'];
				$refund_array['buyer_name'] = $order['buyer_name'];
				
				$refund_array['add_time'] = time();	
				$refund_array['refund_paymentname'] = Language::get('refund_payment_'.$refund_paymentcode);
				$refund_array['refund_paymentcode'] = $refund_paymentcode;
				$state = $model_refund->add($refund_array);
	    	$order_array = array();
	    	$order_array['refund_state'] = '1';
	    	if($state) $state = Model()->table('order')->where(array('order_id'=>$order['order_id']))->update($order_array);//更新订单
			}
			if($state) {
				showDialog(Language::get('nc_common_save_succ'),'reload','succ','CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'),'reload','error','CUR_DIALOG.close();');
			}
		}
		
		if($refund["refund_state"] > 1) {
			Tpl::showpage('member_refund_view','null_layout');
		}
		Tpl::showpage('member_refund_offline_add','null_layout');
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
			case 'member_order':
				$menu_array = array(
				1=>array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_order_list'),	'menu_url'=>'index.php?act=member&op=order'),
				2=>array('menu_key'=>'buyer_refund','menu_name'=>Language::get('nc_member_path_buyer_refund'),	'menu_url'=>'index.php?act=member_refund'),
				3=>array('menu_key'=>'buyer_return','menu_name'=>Language::get('nc_member_path_buyer_return'),	'menu_url'=>'index.php?act=member_return'));
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
