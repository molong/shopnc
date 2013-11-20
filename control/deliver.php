<?php
/**
 * 发货——我是卖家
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

class deliverControl extends BaseMemberStoreControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_store_index,deliver');
	}

	function indexOp(){

		$model = Model('trade');

		if (!in_array($_GET['state'],array('deliverno','delivering','delivered'))) $_GET['state'] = 'deliverno';
		$state = str_replace(array('deliverno','delivering','delivered'),array('20,60',30,40),$_GET['state']);

		$condition = array();
		$condition['order.seller_id'] = $_SESSION['member_id'];
		$condition['order.order_state'] = array('in',$state);
		$order_list = $model->order_list($condition,5);
		if (is_array($order_list)){
			$arr_buyer_id = array();
			$arr_order_id = array();
			foreach ($order_list as $v) {
				$arr_buyer_id[] = $v['buyer_id'];	
				$arr_order_id[] = $v['order_id'];	
			}
			$goods_list = $model->table('order_goods')->where(array('order_id'=>array('in',$arr_order_id)))->select();
			
			foreach ($order_list as $key=>$value) {
				foreach ($goods_list as $k=>$v) {
					if ($v['order_id'] == $value['order_id']) {
						$order_list[$key]['goods'][] = $v;unset($goods_list[$k]);
					}
				}
			}

			$arr_buyer_id = array_unique($arr_buyer_id);
			$member_list = $model->table('member')->where(array('member_id'=>array('in',$arr_buyer_id)))->select();
			$member_list = array_under_reset($member_list,'member_id');
			Tpl::output('member_array',$member_list);
			Tpl::output('order_array',$order_list);
			Tpl::output('show_page',$model->showpage());
		}

		self::profile_menu('deliver',$_GET['state']);
		Tpl::output('menu_sign','deliver');
		Tpl::output('menu_sign_url','index.php?act=deliver&op=index');
		Tpl::output('menu_sign1',$_GET['state']);
		Tpl::showpage('store_order_deliver');
	}

	public function sendOp(){
		$model = Model();
		if (chksubmit()){
			if (!is_numeric($_POST['order_id'])){
				showDialog(Language::get('nc_common_save_fail'),'index.php?act=deliver&op=index&state=delivering','succ');
			}
			$model = Model('order_address');
			$data = array(
				'true_name'=>$_POST['strue_name'],
				'area_info'=>$_POST['sarea_info'],
				'address'=>$_POST['saddress'],
				'zip_code'=>$_POST['szip_code'],
				'tel_phone'=>$_POST['stel_phone'],
				'mob_phone'=>$_POST['smob_phone'],
				'order_id'=>intval($_POST['order_id'])
			);
			$update = $model->update($data);
			
			$model_order = Model('order');
			$order	= $model_order->getOrderById(intval($_POST['order_id']),'simple');
			if ($order['payment_code'] == 'alipay' && $order['payment_direct'] == '2' && $order['order_state'] == 20) {//支付宝的担保交易同步一次发货状态
				$express_list  = ($h = F('express')) ? $h : H('express',true,'file');
				
				$data = array();
				$data['daddress_id'] 		= intval($_POST['daddress_id']);
				$data['deliver_explain'] 	= trim($_POST['deliver_explain']);
				$data['shipping_express_id'] = intval($_POST['shipping_express_id']);
				$data['shipping_code'] 		= trim($_POST['shipping_code']);
				$model->table('order')->where(array('order_id'=>intval($_POST['order_id'])))->update($data);
				
				$data['express_name'] = $express_list[intval($_POST['shipping_express_id'])]['e_name'];//物流公司名称,支付宝使用
				$payment_model	= Model('payment');
				$payment_info	= $payment_model->getPaymentById($order['payment_id']);
				$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
				$inc_file = BasePath.DS.'api'.DS.'payment'.DS.$order['payment_code'].DS.$order['payment_code'].'.php';
				require_once($inc_file);
				$payment_api	= new $order['payment_code']($payment_info,$order);
				$doc = $payment_api->sendPostInfo($data);
				$is_success = $doc->getElementsByTagName( "is_success" )->item(0)->nodeValue;//返回T为调用成功,F--失败
			}else{
				$data = array();
				$data['daddress_id'] 		= intval($_POST['daddress_id']);
				$data['deliver_explain'] 	= trim($_POST['deliver_explain']);
				$data['shipping_express_id'] = intval($_POST['shipping_express_id']);
				$data['shipping_code'] 		= trim($_POST['shipping_code']);
				$data['order_state'] 		= 30;
				$data['shipping_time'] 		= time();
				$model->table('order')->where(array('order_id'=>intval($_POST['order_id'])))->update($data);
				
				//写入操作日志
				$data = array();
				$data['order_id'] = intval($_POST['order_id']);
				$data['order_state'] = Language::get('store_deliver_order_state_send');
				$data['change_state'] = Language::get('store_deliver_order_state_receive');
				$data['state_info'] = trim($_POST['deliver_explain']);
				$data['log_time'] = time();
				$data['operator'] = $_SESSION['member_name'];
				$model->table('order_log')->insert($data);
				
				/**
				 * 发送通知
				 */
				$param	= array(
					'site_url'	=> SiteUrl,
					'site_name'	=> $GLOBALS['setting_config']['site_name'],
					'store_name'	=> $order['store_name'],
					'buyer_name'	=> $order['buyer_name'],
					'order_sn'	=> $order['order_sn'],
					'order_id'	=> $order['order_id'],
					'invoice_no'=> $order['shipping_code']
				);
				$this->send_notice($order['buyer_id'],'email_tobuyer_shipped_notify',$param);
			}
			showDialog(Language::get('nc_common_save_succ'),'index.php?act=deliver&op=index&state=delivering','succ');
		}

		if (!is_numeric($_GET['order_id'])){
			showMessage(Language::get('wrong_argument'),'','html','error');
		}

		$condition = array();
		$condition['order.seller_id'] = $_SESSION['member_id'];
		$condition['order.order_id'] = $_GET['order_id'];
		$condition['order.order_state'] = array('in','20,30,60');
		$on = 'order.order_id=order_address.order_id';
		$order_info = $model->table('order,order_address')->on($on)->where($condition)->find();
		if (is_numeric($order_info['order_id'])){
			$goods_list = $model->table('order_goods')->where(array('order_id'=>$order_info['order_id']))->select();
			$member_info = $model->table('member')->where(array('member_id'=>$order_info['buyer_id']))->find();
			Tpl::output('goods_array',$goods_list);
			Tpl::output('member_array',$member_info);
			Tpl::output('order_array',$order_info);
		}
		//发货地址
		if ($order_info['daddress_id'] > 0 ){
			$daddess_info = $model->table('daddress')->find($order_info['daddress_id']);
		}else{
			$daddess_info = $model->table('daddress')->where(array('store_id'=>$_SESSION['store_id']))->order('is_default desc')->find();
		}
		Tpl::output('daddress_info',$daddess_info);

		//快递公司
		$my_express_list = $model->table('store_extend')->getfby_store_id($_SESSION['store_id'],'express');
		if (!is_null($my_express_list)){
			$my_express_list = explode(',',$my_express_list);
		}
		$express_list  = ($h = F('express')) ? $h : H('express',true,'file');
		Tpl::output('my_express_list',$my_express_list);
		Tpl::output('express_list',$express_list);

//		self::profile_menu('deliver',$_GET['state']);
		Tpl::output('menu_sign','deliver');
//		Tpl::output('menu_sign_url','index.php?act=deliver&op=index');
		Tpl::showpage('store_order_deliver2');
	}

	public function buyer_addressOp(){
		$order_id = decrypt($_GET['order_id'],md5(1));
		if (!is_numeric($order_id)) return false;
//		$model = Model('order_address');

//		if (chksubmit()){
//			$data = array(
//				'true_name'=>$_POST['true_name'],
//				'area_info'=>$_POST['area_info'],
//				'address'=>$_POST['address'],
//				'zip_code'=>$_POST['zip_code'],
//				'tel_phone'=>$_POST['tel_phone'],
//				'mob_phone'=>$_POST['mob_phone'],
//				'order_id'=>$order_id
//			);
//			$update = $model->update($data);
//			if ($update){
//				
//			$extend_js = array($_POST['area_info'].$_POST['address'],$_POST['zip_code'],$_POST['true_name'],$_POST['tel_phone'],$_POST['mob_phone']);
//			$extend_js = implode('&nbsp;',$extend_js);
//			$extend_js .= "<a href=\"javascript:void(0);\" onclick=\"ajax_form(\'modfiy_daddress\', \'".Language::get('store_deliver_modfiy_address')."\', \'index.php?act=deliver&op=buyer_address&order_id=".encrypt($order_id,md5(1))."\', 550,0);\" class=\"fr\">".Language::get('store_deliver_modfiy_address')."</a>";
//			$extend_js = "$('#address').html('".$extend_js."');";
//			showDialog(Language::get('nc_common_save_succ'),'','succ','CUR_DIALOG.close();'.$extend_js);				
//			}else{
//				showDialog(Language::get('nc_common_save_fail'),'','error');
//			}
//		}

//		$address = $model->getby_order_id($order_id);
//		Tpl::output('address',$address);

		Tpl::showpage('deliver_buyer_address_edit','null_layout');
	}

	public function daddressOp() {
		/**
		 * 读取语言包
		 */
		Language::read('member_member_index');
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model = Model('daddress');
		/**
		 * 判断页面类型
		 */
		if (!empty($_GET['type'])){
			/**
			 * 新增/编辑地址页面
			 */
			if (intval($_GET['id']) > 0){

				$address_info = $model->getby_address_id(intval($_GET['id']));
				if (empty($address_info) && !is_array($address_info)){
					showMessage($lang['store_daddress_wrong_argument'],'index.php?act=member&op=address','html','error');
				}

				Tpl::output('address_info',$address_info);
			}
			/**
			 * 增加/修改页面输出
			 */
			Tpl::output('type',$_GET['type']);
			Tpl::showpage('store_deliver_daddress_form','null_layout');
			exit();
		}

		if (chksubmit()){

			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["seller_name"],"require"=>"true","message"=>$lang['store_daddress_receiver_null']),
				array("input"=>$_POST["area_id"],"require"=>"true","validator"=>"Number","message"=>$lang['store_daddress_wrong_area']),
				array("input"=>$_POST["city_id"],"require"=>"true","validator"=>"Number","message"=>$lang['store_daddress_wrong_area']),
				array("input"=>$_POST["area_info"],"require"=>"true","message"=>$lang['store_daddress_area_null']),
				array("input"=>$_POST["address"],"require"=>"true","message"=>$lang['store_daddress_address_null']),
				array("input"=>$_POST['tel_phone'].$_POST['mob_phone'],'require'=>'true','message'=>$lang['store_daddress_phone_and_mobile'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}
			$data = array(
				'store_id'=>$_SESSION['store_id'],
				'seller_name'=>$_POST['seller_name'],
				'area_id'=>$_POST['area_id'],
				'city_id'=>$_POST['city_id'],
				'area_info'=>$_POST['area_info'],
				'address'=>$_POST['address'],
				'zip_code'=>$_POST['zip_code'],
				'tel_phone'=>$_POST['tel_phone'],
				'mob_phone'=>$_POST['mob_phone'],
				'company'=>$_POST['company'],
				'content'=>$_POST['content']
			);			
			if (intval($_POST['id']) > 0){
				$update = $model->where(array('address_id'=>intval($_POST['id'])))->update($data);
				if (!$update){
					showDialog($lang['store_daddress_modify_fail'],'','error');
				}
			}else {
				$insert = $model->insert($data);
				if (!$insert){
					showDialog($lang['store_daddress_add_fail'],'','error');
				}
			}
			showDialog($lang['nc_common_op_succ'],'reload','succ','CUR_DIALOG.close()');
		}
		$del_id = isset($_GET['id']) ? intval(trim($_GET['id'])) : 0 ;
		if ($del_id > 0){
			$del = $model->delete($del_id);
			if ($del){
				showDialog(Language::get('store_daddress_del_succ'),'index.php?act=deliver&op=daddress','succ');
			}else {
				showDialog(Language::get('store_daddress_del_fail'),'','error');
			}
		}
		$address_list = $model->where(array('store_id'=>$_SESSION['store_id']))->select();

		/**
		 * 页面输出
		 */
		self::profile_menu('daddress','daddress');
		Tpl::output('menu_sign','daddress');
		Tpl::output('address_list',$address_list);
		Tpl::output('menu_sign_url','index.php?act=deliver&op=daddress');
		Tpl::output('menu_sign1','daddress_list');
		Tpl::showpage('store_deliver_daddress');
	}

	public function expressOp(){	
		$model = Model('store_extend');

		if (chksubmit()){
			$data['store_id'] = $_SESSION['store_id'];
			if(is_array($_POST['cexpress']) && !empty($_POST['cexpress'])){
				$data['express'] = implode(',',$_POST['cexpress']);
			}else{				
				$data['express'] = '';				
			}
			if (is_null($model->getby_store_id($_SESSION['store_id']))){
				$result = $model->insert($data);
			}else{
				$result = $model->update($data);
			}
			if ($result){
				showDialog(Language::get('nc_common_save_succ'),'reload','succ');
			}else{
				showDialog(Language::get('nc_common_save_fail'),'reload','error');
			}
		}
		if (!$express_list = F('express')){
			$express_list = H('express',true,'file');
		}
		
		//取得店铺启用的快递公司ID
		$express_select = $model->getfby_store_id($_SESSION['store_id'],'express');
		if (!is_null($express_select)){
			$express_select = explode(',',$express_select);
		}else{
			$express_select = array();
		}
		Tpl::output('express_select',$express_select);
		//页面输出
		self::profile_menu('daddress','express');
		Tpl::output('menu_sign','daddress');
		Tpl::output('express_list',$express_list);
		Tpl::output('menu_sign_url','index.php?act=deliver&op=express');
		Tpl::output('menu_sign1','default_express');
		Tpl::showpage('store_deliver_express');
	}

	public function pop_addressOp(){
		if (chksubmit()){

			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["seller_name"],"require"=>"true","message"=>$lang['store_daddress_receiver_null']),
				array("input"=>$_POST["area_id"],"require"=>"true","validator"=>"Number","message"=>$lang['store_daddress_wrong_area']),
				array("input"=>$_POST["city_id"],"require"=>"true","validator"=>"Number","message"=>$lang['store_daddress_wrong_area']),
				array("input"=>$_POST["area_info"],"require"=>"true","message"=>$lang['store_daddress_area_null']),
				array("input"=>$_POST["address"],"require"=>"true","message"=>$lang['store_daddress_address_null']),
				array("input"=>$_POST['tel_phone'].$_POST['mob_phone'],'require'=>'true','message'=>$lang['store_daddress_phone_and_mobile'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}
			$data = array(
				'store_id'=>$_SESSION['store_id'],
				'seller_name'=>$_POST['seller_name'],
				'area_id'=>$_POST['area_id'],
				'city_id'=>$_POST['city_id'],
				'area_info'=>$_POST['area_info'],
				'address'=>$_POST['address'],
				'zip_code'=>$_POST['zip_code'],
				'tel_phone'=>$_POST['tel_phone'],
				'mob_phone'=>$_POST['mob_phone'],
				'company'=>$_POST['company'],
				'content'=>$_POST['content']
			);
			$model = Model('daddress');
			$insert = $model->insert($data);
			if (!$insert){
				showDialog(Language::get('nc_common_op_fail'),'','error');
			}
			$extend_js = array($_POST['area_info'].$_POST['address'],$_POST['zip_code'],$_POST['seller_name'],$_POST['tel_phone'],$_POST['mob_phone']);
			$extend_js = implode('&nbsp;',$extend_js);
			$extend_js .= "<a href=\"javascript:void(0);\" onclick=\"ajax_form(\'modfiy_daddress\', \'".Language::get('store_deliver_select_daddress')."\', \'index.php?act=deliver&op=pop_address&type=select\', 550,0);\" class=\"fr\">".Language::get('store_deliver_select_ather_daddress')."</a>";
			$extend_js = "$('#daddress').html('".$extend_js."');";
			showDialog(Language::get('nc_common_op_succ'),'','succ','CUR_DIALOG.close();$("#dadress_id").val('.$insert.');'.$extend_js);
		}
		if ($_GET['type'] == 'select'){
			$model = Model('daddress');
			$daddress_list = $model->where(array('store_id'=>$_SESSION['store_id']))->limit(10)->select();
			Tpl::output('daddress_list',$daddress_list);

			Tpl::showpage('store_deliver_daddress_select','null_layout');
		}else{
			Tpl::showpage('store_deliver_daddress_add','null_layout');
		}
	}

	public function search_deliverOp(){
		Language::read('member_member_index');
		$lang	= Language::getLangContent();

//		if(($_GET['order_sn'])){
//			Tpl::showpage('member_order_express_detail');exit();
//		}

		$order_sn	= $_GET['order_sn'];
		/**
		 * 实例化订单模型
		 */
		$model	= Model();
		$condition['order.store_id'] = $_SESSION['store_id'];
		$condition['order.order_sn'] = $order_sn;
		$on = 'order.order_id=order_address.order_id';
		$order_info = $model->table('order,order_address')->on($on)->join('inner')->where($condition)->find();
		$order_id	= intval($order_info['order_id']);

		$order_info['state_info'] = orderStateInfo($order_info['order_state']);
		Tpl::output('order_info',$order_info);
		/**
		 * 卖家信息
		 */
		$model_store	= Model('store');
		$store_info		= $model_store->shopStore(array('store_id'=>$order_info['store_id']));
		Tpl::output('store_info',$store_info);
		/**
		 * 实例化买家订单模型
		 */
		$model_store_order = Model('store_order');
		/**
		 * 订单商品
		 */
		if ($order_id > 0){
			$order_goods_list= $model_store_order->storeOrderGoodsList(array('order_id'=>$order_id));
		}
		Tpl::output('order_goods_list',$order_goods_list);
		
		//卖家发货信息
		$daddress_info = Model('daddress')->find($order_info['daddress_id']);
		
		Tpl::output('daddress_info',$daddress_info);

		//取得配送公司代码
		$express = ($express = F('express'))? $express :H('express',true,'file');
		Tpl::output('e_code',$express[$order_info['shipping_express_id']]['e_code']);
		Tpl::output('e_name',$express[$order_info['shipping_express_id']]['e_name']);
		Tpl::output('e_url',$express[$order_info['shipping_express_id']]['e_url']);
		Tpl::output('shipping_code',$order_info['shipping_code']);

		self::profile_menu('search','search');
		Tpl::output('menu_sign','deliver');
		Tpl::output('menu_sign_url','index.php?act=deliver&op=index');
		Tpl::output('menu_sign1','deliver_info');	
		Tpl::showpage('store_order_deliver_detail');
	}

	public function ajaxOp(){
		switch ($_GET['type']) {
			case 'daddress':
				if (!is_numeric($_GET['id'])) return false;
				$model = Model('daddress');
				$model->where(array('address_id'=>$_GET['id']))->update(array('is_default'=>1));
				$model->where(array('address_id'=>array('neq',$_GET['id'])))->update(array('is_default'=>0));
			break;
		}
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return 
	 */
	private function profile_menu($menu_type,$menu_key='') {
		Language::read('member_layout');
		$menu_array		= array();
		switch ($menu_type) {
			case 'deliver':
				$menu_array = array(
				1=>array('menu_key'=>'deliverno',			'menu_name'=>Language::get('nc_member_path_deliverno'),	'menu_url'=>'index.php?act=deliver&op=index&state=deliverno'),
				2=>array('menu_key'=>'delivering',			'menu_name'=>Language::get('nc_member_path_delivering'),	'menu_url'=>'index.php?act=deliver&op=index&state=delivering'),
				3=>array('menu_key'=>'delivered',		'menu_name'=>Language::get('nc_member_path_delivered'),	'menu_url'=>'index.php?act=deliver&op=index&state=delivered'),
				);
				break;
			case 'search':
				$menu_array = array(
				1=>array('menu_key'=>'nodeliver',			'menu_name'=>Language::get('nc_member_path_deliverno'),	'menu_url'=>'index.php?act=deliver&op=index&state=nodeliver'),
				2=>array('menu_key'=>'delivering',			'menu_name'=>Language::get('nc_member_path_delivering'),	'menu_url'=>'index.php?act=deliver&op=index&state=delivering'),
				3=>array('menu_key'=>'delivered',		'menu_name'=>Language::get('nc_member_path_delivered'),	'menu_url'=>'index.php?act=deliver&op=index&state=delivered'),
				4=>array('menu_key'=>'search',		'menu_name'=>Language::get('nc_member_path_deliver_info'),	'menu_url'=>'###'),
				);
				break;				
			case 'daddress':
				$menu_array = array(
				1=>array('menu_key'=>'daddress',			'menu_name'=>Language::get('store_deliver_daddress_list'),	'menu_url'=>'index.php?act=deliver&op=daddress'),
				2=>array('menu_key'=>'express',				'menu_name'=>Language::get('store_deliver_default_express'),	'menu_url'=>'index.php?act=deliver&op=express')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}