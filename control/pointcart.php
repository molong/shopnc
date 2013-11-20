<?php
/**
 * 积分礼品购物车操作
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class pointcartControl extends BaseHomeControl {
	public function __construct() {
		parent::__construct();
		/**
		 * 读取语言包
		 */
		Language::read('home_pointcart');
		/**
		 * 判断系统是否开启积分和积分兑换功能
		 */
		if ($GLOBALS['setting_config']['points_isuse'] != 1 || $GLOBALS['setting_config']['pointprod_isuse'] != 1){
			showMessage(Language::get('pointcart_unavailable'),'index.php','html','error');
		}
		//验证是否登录
		if ($_SESSION['is_login'] != '1'){
			showMessage(Language::get('pointcart_unlogin_error'),'index.php?act=login','html','error');
		}
	}
	/**
	 * 积分礼品购物车首页
	 *
	 * @param
	 * @return
	 */
	public function indexOp() {
		$cart_goods	= array();
		$pointcart_model	= Model('pointcart');
		$cart_goods	= $pointcart_model->getPointCartList(array('pmember_id'=>$_SESSION['member_id']));
		$cart_array	= array();
		if(is_array($cart_goods) and !empty($cart_goods)) {
			$pgoods_pointall = 0;
			foreach ($cart_goods as $val) {
				$val['pgoods_image'] 			= ATTACH_POINTPROD.'/'.$val['pgoods_image'].'_small.'.get_image_type($val['pgoods_image']);
				$val['pgoods_pointone']			= intval($val['pgoods_points']) * intval($val['pgoods_choosenum']);
				$cart_array[] = $val;
				$pgoods_pointall = $pgoods_pointall + $val['pgoods_pointone'];
			}
			Tpl::output('pgoods_pointall',$pgoods_pointall);
			Tpl::output('cart_array',$cart_array);
		}
		Tpl::showpage('pointcart_list');
	}
	/**
	 * 购物车添加礼品
	 *
	 * @param
	 * @return
	 */
	public function addOp() {		
		$pgid	= intval($_GET['pgid']);
		$quantity	= intval($_GET['quantity']);
		if($pgid <= 0 || $quantity <= 0) {
			showMessage(Language::get('pointcart_cart_addcart_fail'),'index.php?act=pointprod','html','error');
		}
		//验证积分礼品是否存在购物车中
		$pointcart_model	= Model('pointcart');
		$check_cart	= $pointcart_model->getPointCartInfo(array('pgoods_id'=>$pgid,'pmember_id'=>$_SESSION['member_id']));
		if(!empty($check_cart)) {
			@header("Location:index.php?act=pointcart");exit;
		}
		
		$pointprod_model = Model('pointprod');
		//验证积分礼品是否存在
		$prod_info	= $pointprod_model->getPointProdInfo(array('pgoods_id'=>$pgid,'pgoods_show'=>'1','pgoods_state'=>'0'));
		if (!is_array($prod_info) || count($prod_info)<=0){
			showMessage(Language::get('pointcart_record_error'),'index.php?act=pointprod','html','error');
		}
		//验证积分礼品兑换状态
		$ex_state = $pointprod_model->getPointProdExstate($prod_info);
		switch ($ex_state){
			case 'willbe':
				showMessage(Language::get('pointcart_cart_addcart_willbe'),getReferer(),'html','error');
				break;
			case 'end':
				showMessage(Language::get('pointcart_cart_addcart_end'),getReferer(),'html','error');
				break;
		}
		//验证兑换数量是否合法
		$quantity = $pointprod_model->getPointProdExnum($prod_info,$quantity);
		if ($quantity <= 0){
			showMessage(Language::get('pointcart_cart_addcart_end'),getReferer(),'html','error');
		}
		//计算消耗积分总数
		$points_all = intval($prod_info['pgoods_points'])*intval($quantity);
		//验证积分数是否足够
		$member_model = Model('member');
		$member_info = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']),'member_points');
		if (intval($member_info['member_points']) < $points_all){
			showMessage(Language::get('pointcart_cart_addcart_pointshort'),getReferer(),'html','error');
		}
		$array						= array();
		$array['pmember_id']		= $_SESSION['member_id'];
		$array['pgoods_id']			= $prod_info['pgoods_id'];
		$array['pgoods_name']		= $prod_info['pgoods_name'];
		$array['pgoods_points']		= $prod_info['pgoods_points'];
		$array['pgoods_choosenum']	= $quantity;
		$array['pgoods_image']		= $prod_info['pgoods_image'];
		$cart_state = $pointcart_model->addPointCart($array);
		@header("Location:index.php?act=pointcart");
		exit;
	}
	/**
	 * 积分礼品购物车更新礼品数量
	 *
	 * @param
	 * @return
	 */
	public function updateOp() {
		$pcart_id	= intval($_GET['pc_id']);
		$quantity	= intval($_GET['quantity']);
		//兑换失败提示
		$msg = Language::get('pointcart_cart_modcart_fail');
		//转码
		if (strtoupper(CHARSET) == 'GBK'){
			$msg = Language::getUTF8($msg);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
		if($pcart_id <= 0 || $quantity <= 0) {
			echo json_encode(array('msg'=>$msg));
			die;
		}
		//验证礼品购物车信息是否存在
		$pointcart_model	= Model('pointcart');
		$cart_info	= $pointcart_model->getPointCartInfo(array('pcart_id'=>$pcart_id,'pmember_id'=>$_SESSION['member_id']));
		if (!is_array($cart_info) || count($cart_info)<=0){
			echo json_encode(array('msg'=>$msg)); die;
		}
		$pointprod_model = Model('pointprod');
		//验证积分礼品是否存在
		$prod_info	= $pointprod_model->getPointProdInfo(array('pgoods_id'=>$cart_info['pgoods_id'],'pgoods_show'=>'1','pgoods_state'=>'0'));
		if (!is_array($prod_info) || count($prod_info)<=0){
			//删除积分礼品兑换信息
			$pointcart_model->dropPointCartById($pcart_id);
			echo json_encode(array('msg'=>$msg)); die;
		}
		//验证积分礼品兑换状态
		$ex_state = $pointprod_model->getPointProdExstate($prod_info);
		switch ($ex_state){
			case 'going':
				//验证兑换数量是否合法
				$quantity = $pointprod_model->getPointProdExnum($prod_info,$quantity);
				if ($quantity <= 0){
					//删除积分礼品兑换信息
					$pointcart_model->dropPointCartById($pcart_id);
					echo json_encode(array('msg'=>$msg)); die;
				}
				break;
			default:
				//删除积分礼品兑换信息
				$pointcart_model->dropPointCartById($pcart_id);
				echo json_encode(array('msg'=>$msg)); die;
				break;
		}
		/**
		 * 更新礼品购物车内单个礼品数量
		 */
		$cart_state = $pointcart_model->updatePointCart(array('pgoods_choosenum'=>$quantity),array('pcart_id'=>$pcart_id,'pmember_id'=>$_SESSION['member_id']));
		if ($cart_state) {
			//计算总金额
			$all_price	= $this->amountOp();
			echo json_encode(array('done'=>'true','subtotal'=>$prod_info['pgoods_points']*$quantity,'amount'=>$all_price,'quantity'=>$quantity));
			die;
		}
	}
	/**
	 * 积分礼品购物车删除单个礼品
	 *
	 * @param
	 * @return
	 */
	public function dropOp() {
		$pcart_id	= intval($_GET['pc_id']);
		if($pcart_id==0) {
			die;
		}
		$pointcart_model	= Model('pointcart');
		$drop_state	= $pointcart_model->dropPointCartById($pcart_id);
		die;
	}
	/**
	 * 已选择兑换礼品总积分
	 * @return 积分值
	 */
	private function amountOp() {
		$pointcart_model	= Model('pointcart');
		$cart_goods	= $pointcart_model->getPointCartList(array('pmember_id'=>$_SESSION['member_id']));
		$all_points	= 0;
		if(is_array($cart_goods) and !empty($cart_goods)) {
			foreach ($cart_goods as $val) {
				$all_points	= $val['pgoods_points'] * $val['pgoods_choosenum'] + $all_points;
			}
		}
		return $all_points;
	}
	/**
	 * 兑换订单流程第一步
	 */
	public function step1Op(){
		//获取符合条件的兑换礼品和总积分及运费
		$pointprod_arr = $this->getLegalPointGoods();
		Tpl::output('pointprod_arr',$pointprod_arr);

		//实例化收货地址模型
		$mode_address	= Model('address');
		$address_list	= $mode_address->getAddressList(array('member_id'=>$_SESSION['member_id'],'order'=>'address_id desc'));
		Tpl::output('address_list',$address_list);		

		Tpl::showpage('pointcart_step1');
	}
	/**
	 * 兑换订单流程第二步
	 */
	public function step2Op() {
		//获取符合条件的兑换礼品和总积分及运费
		$pointprod_arr = $this->getLegalPointGoods();
		//验证积分数是否足够
		$member_model = Model('member');
		$member_info = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']),'member_points');
		if (intval($member_info['member_points']) < $pointprod_arr['pgoods_pointall']){
			showMessage(Language::get('pointcart_cart_addcart_pointshort'),'index.php?act=member_points','html','error');
		}
		//实例化兑换订单模型
		$pointorder_model= Model('pointorder');
		//实例化店铺模型
		$order_array		= array();
		$order_array['point_ordersn']		= $pointorder_model->point_snOrder();
		$order_array['point_buyerid']		= $_SESSION['member_id'];
		$order_array['point_buyername']		= $_SESSION['member_name'];
		$order_array['point_buyeremail']	= $_SESSION['member_email'];
		$order_array['point_addtime']		= time();
		$order_array['point_outsn']			= $pointorder_model->point_outSnOrder();
		$order_array['point_allpoint']		= $pointprod_arr['pgoods_pointall'];
		$order_array['point_orderamount']	= $pointprod_arr['pgoods_freightall'];
		$order_array['point_shippingcharge']= $pointprod_arr['pgoods_freightcharge'];
		$order_array['point_shippingfee']	= $pointprod_arr['pgoods_freightall'];
		$order_array['point_ordermessage']	= trim($_POST['pcart_message']);
		if ($order_array['point_shippingcharge'] == 1){
			$order_array['point_orderstate']	= 10;
		}else {
			$order_array['point_orderstate']	= 20;//卖家承担运费，则状态为已经确认收款
		}
		$order_id	= $pointorder_model->addPointOrder($order_array);
		if (!$order_id){
			showMessage(Language::get('pointcart_step2_fail'),'index.php?act=pointcart','html','error');
		}
		//扣除会员积分
		$points_model = Model('points');
		$insert_arr['pl_memberid'] = $_SESSION['member_id'];
		$insert_arr['pl_membername'] = $_SESSION['member_name'];
		$insert_arr['pl_points'] = -$pointprod_arr['pgoods_pointall'];
		$insert_arr['point_ordersn'] = $order_array['point_ordersn'];
		$points_model->savePointsLog('pointorder',$insert_arr,true);
		
		//添加订单中的礼品信息
		$pointprod_model = Model('pointprod');
		if(is_array($pointprod_arr['pointprod_list']) && count($pointprod_arr['pointprod_list'])>0) {
			$output_goods_name = array();
			foreach ($pointprod_arr['pointprod_list'] as $val) {
				$order_goods_array	= array();
				$order_goods_array['point_orderid']		= $order_id;
				$order_goods_array['point_goodsid']		= $val['pgoods_id'];
				$order_goods_array['point_goodsname']	= $val['pgoods_name'];
				$order_goods_array['point_goodspoints']	= $val['pgoods_points'];
				$order_goods_array['point_goodsnum']	= $val['quantity'];
				$order_goods_array['point_goodsimage']	= $val['pgoods_image'];
				$pointorder_model->addPointOrderProd($order_goods_array);
				
				if (count($output_goods_name)<3) $output_goods_name[] = $val['pgoods_name'];
				
				//更新积分礼品库存
				$pointprod_uparr = array();
				$pointprod_uparr['pgoods_salenum'] = array('value'=>$val['quantity'],'sign'=>'increase');
				$pointprod_uparr['pgoods_storage'] = array('value'=>$val['quantity'],'sign'=>'decrease');
				$pointprod_model->updatePointProd($pointprod_uparr,array('pgoods_id'=>$val['pgoods_id']));
				unset($pointprod_uparr);
				unset($order_goods_array);
			}
		}
		//清除购物车信息
		$pointcart_model = Model('pointcart');
		//$pointcart_model->dropPointCart(array('pmember_id'=>$_SESSION['member_id']));
		
		//保存买家收货地址
		$address_model		= Model('address');
		if(intval($_POST['address_options']) > 0) {
			$address_info = $address_model->getOneAddress(intval($_POST['address_options']));
			//sql注入过滤转义
			if (!empty($address_info) && !get_magic_quotes_gpc()){
				foreach ($address_info as $k=>$v){
					$address_info[$k] = addslashes(trim($v));
				}
			}
		} else {
			$address_info['true_name']	= trim($_POST['consignee']);
			$address_info['area_id']	= intval($_POST['area_id']);
			$address_info['area_info']	= trim($_POST['area_info']);
			$address_info['address']	= trim($_POST['address']);
			$address_info['zip_code']	= trim($_POST['zipcode']);
			$address_info['tel_phone']	= trim($_POST['phone_tel']);
			$address_info['mob_phone']	= trim($_POST['phone_mob']);
			if (intval($_POST['save_address']) == 1) {
				$address_model->addAddress($address_info);
			}
		}
		//添加订单收货地址
		if (is_array($address_info) && count($address_info)>0){
			$address_array		= array();
			$address_array['point_orderid']		= $order_id;
			$address_array['point_truename']	= $address_info['true_name'];
			$address_array['point_areaid']		= $address_info['area_id'];
			$address_array['point_areainfo']	= $address_info['area_info'];
			$address_array['point_address']		= $address_info['address'];
			$address_array['point_zipcode']		= $address_info['zip_code'];
			$address_array['point_telphone']	= $address_info['tel_phone'];
			$address_array['point_mobphone']	= $address_info['mob_phone'];
			$pointorder_model->addPointOrderAddress($address_array);
		}
		//进入订单支付页面
		$step3_arr = array();
		$step3_arr['order_id'] = $order_id;
		$step3_arr['order_sn'] = $order_array['point_ordersn'];
		$step3_arr['pgoods_pointall'] = $pointprod_arr['pgoods_pointall'];
		$step3_arr['pgoods_freightcharge'] = $pointprod_arr['pgoods_freightcharge'];
		$step3_arr['pgoods_freightall'] = $pointprod_arr['pgoods_freightall'];
		$step3_arr['output_goods_name'] = $output_goods_name;
		$this->step3Op($step3_arr);
	}
	/**
	 * 购物流程第三步支付
	 */
	public function step3Op($order_arr=array()) {
		if (!is_array($order_arr) || count($order_arr)<=0){
			$order_id = intval($_GET['order_id']);
			if ($order_id <= 0){
				showMessage(Language::get('pointcart_record_error'),'index.php','html','error');	
			}
			//查询订单信息
			$pointorder_model = Model('pointorder');
			$condition = array();
			$condition['point_orderid'] = "$order_id";
			$condition['point_buyerid'] = "{$_SESSION['member_id']}";
			$condition['point_orderstate'] = '10';
			$order_info = $pointorder_model->getPointOrderInfo($condition,'simple');
			unset($condition);
			if (!is_array($order_info) || count($order_info)<=0){
				showMessage(Language::get('pointcart_record_error'),'index.php','html','error');
			}
			$prod_list = $pointorder_model->getPointOrderProdList(array('prod_orderid'=>"{$order_id}"),$page);
			$output_goods_name = array();
			foreach ($prod_list as $val) {
				if (count($output_goods_name)<3) $output_goods_name[] = $val['point_goodsname'];
			}
			$order_arr['order_id'] = $order_info['point_orderid'];
			$order_arr['output_goods_name'] = $output_goods_name;
			$order_arr['order_sn'] = $order_info['point_ordersn'];
			$order_arr['pgoods_pointall'] = $order_info['point_allpoint'];
			$order_arr['pgoods_freightcharge'] = $order_info['point_shippingcharge'];
			$order_arr['pgoods_freightall'] = $order_info['point_shippingfee'];
		}
		//查询支付方式
		$model_payment = Model('gold_payment');
		//支付方式列表
		$condition = array();
		$condition['payment_state'] = '1';//可用的支付方式
		$payment_list = $model_payment->getList($condition);
		foreach ((array)$payment_list as $v) {
			if ($v['payment_online'] == 1){
				$online_array[] = $v;
			}else{
				$offline_array[] = $v;
			}
		}
		Tpl::output('offine_array',$offline_array);
		Tpl::output('online_array',$online_array);


		Tpl::output('payment_list',$payment_list);
		Tpl::output('order_arr',$order_arr);
		Tpl::showpage('pointcart_step2');
	}
	/**
	 * 验证购物车商品是否符合兑换条件，并返回符合条件的积分礼品和对应的总积分总运费及其他信息
	 * @return array
	 */
	private function getLegalPointGoods(){
		$return_array = array();
		//获取礼品购物车内信息
		$pointcart_model	= Model('pointcart');
		$cart_goods	= $pointcart_model->getPointCartList(array('pmember_id'=>$_SESSION['member_id']));
		if(!is_array($cart_goods) || count($cart_goods)<=0) {
			showMessage(Language::get('pointcart_record_error'),'index.php?act=pointprod','html','error');
		}
		$cart_goods_new = array();
		foreach ($cart_goods as $val) {
			$cart_goods_new[$val['pgoods_id']] = $val;
		}
		$cart_goodsid_arr = array_keys($cart_goods_new);
		if(!is_array($cart_goodsid_arr) || count($cart_goodsid_arr)<=0) {
			showMessage(Language::get('pointcart_record_error'),'index.php?act=pointprod','html','error');
		}
		$cart_goodsid_str = implode(',',$cart_goodsid_arr);
		unset($cart_goodsid_arr);
		unset($cart_goods);
		
		//查询积分礼品信息
		$pointprod_model = Model('pointprod');
		$pointprod_list = $pointprod_model->getPointProdList(array('pgoods_id_in'=>$cart_goodsid_str,'pgoods_show'=>'1','pgoods_state'=>'0'));
		if (!is_array($pointprod_list) || count($pointprod_list)<=0){
			showMessage(Language::get('pointcart_record_error'),'index.php?act=pointprod','html','error');
		}
		$cart_delid_arr = array();
		$pgoods_pointall = 0;//积分总数
		$pgoods_freightall = 0;//运费总数
		$pgoods_freightcharge = false;//是否需要支付运费
		foreach ($pointprod_list as $k=>$v){
			$v['pgoods_image_new'] = ATTACH_POINTPROD.DS.$v['pgoods_image'].'_small.'.get_image_type($v['pgoods_image']);
			$pointprod_list[$k] = $v;
			//验证积分礼品兑换状态
			$ex_state = $pointprod_model->getPointProdExstate($v);
			switch ($ex_state){
				case 'going':
					//验证兑换数量是否合法
					$quantity = $pointprod_model->getPointProdExnum($v,$cart_goods_new[$v['pgoods_id']]['pgoods_choosenum']);
					if ($quantity <= 0){
						//删除积分礼品兑换信息
						$cart_delid_arr[] = $cart_goods_new[$v['pgoods_id']]['pcart_id'];
						unset($pointprod_list[$k]);
					}else {
						$pointprod_list[$k]['quantity'] = $quantity;
						//计算单件礼品积分数
						$pointprod_list[$k]['onepoints'] = intval($quantity)*intval($v['pgoods_points']);
						$pgoods_pointall = $pgoods_pointall + $pointprod_list[$k]['onepoints'];
						//计算运费
						if ($v['pgoods_freightcharge'] == 1){
							$pgoods_freightcharge = true;
							$pgoods_freightall = $pgoods_freightall + $v['pgoods_freightprice'];
						}
					}
					break;
				default:
					//删除积分礼品兑换信息
					$cart_delid_arr[] = $cart_goods_new[$v['pgoods_id']]['pcart_id'];
					unset($pointprod_list[$k]);
					break;
			}
		}
		//删除不符合条件的礼品购物车信息
		if (is_array($cart_delid_arr) && count($cart_delid_arr)>0){
			$pointcart_model->dropPointCartById($cart_delid_arr);
		}
		if (!is_array($pointprod_list) || count($pointprod_list)<=0){
			showMessage(Language::get('pointcart_record_error'),'index.php?act=pointprod','html','error');
		}
		$pgoods_freightall = ncPriceFormat($pgoods_freightall); 
		$return_array = array('pointprod_list'=>$pointprod_list,'pgoods_freightcharge'=>$pgoods_freightcharge,'pgoods_pointall'=>$pgoods_pointall,'pgoods_freightall'=>$pgoods_freightall);
		
		return $return_array;
	}
	/**
	 * 兑换积分礼品支付
	 */
	public function paymentOp(){
		$order_id = intval($_GET['order_id']);
		if ($order_id <= 0){
			showMessage(Language::get('pointcart_record_error'),'index.php','html','error');
		}
		$payment_id = intval($_POST['payment_id']);
		if ($payment_id<=0){
			showMessage(Language::get('pointcart_step3_choosepayment'),'index.php?act=pointcart&op=step3&order_id='.$order_id,'html','error');
		}
		//查询订单信息
		$pointorder_model = Model('pointorder');
		$condition = array();
		$condition['point_orderid'] = "$order_id";
		$condition['point_buyerid'] = "{$_SESSION['member_id']}";
		$condition['point_shippingcharge'] = "1";
		$condition['point_orderstate'] = '10';
		$order_info = $pointorder_model->getPointOrderInfo($condition,'simple');
		unset($condition);
		if (!is_array($order_info) || count($order_info)<=0){
			showMessage(Language::get('pointcart_record_error'),'index.php','html','error');
		}
		//查询支付方式
		$goldpayment_model = Model('gold_payment');
		$payment_list = $goldpayment_model->getList(array('payment_id'=>$payment_id,'payment_state'=>'1'));
		
		if (!is_array($payment_list) || count($payment_list)<=0){
			showMessage(Language::get('pointcart_step3_paymenterror'),'index.php?act=pointcart&op=step3&order_id='.$order_id,'html','error');
		}else {
			$payment_info = $payment_list[0];
		}
		//保存信息
		$condition = array();
		$condition['point_orderid'] = "$order_id";
		$update_arr = array();
		$update_arr['point_paymentid'] 		= $payment_id;
		$update_arr['point_paymentname'] 	= $payment_list[0]['payment_name'];
		$update_arr['point_paymentcode'] 	= $payment_list[0]['payment_code'];
		$update_arr['point_paymentdirect'] 	= 1;
		$update_arr['point_paymenttime'] 	= time();
//		$update_arr['point_paymessage'] 	= $_POST["pay_message"];
		if (is_array($_POST['offline'])){
			$update_arr['point_paymessage']	= serialize($this->stripslashes_deep($_POST['offline']));
		}

		if($payment_info['payment_code'] == 'offline') {
			$update_arr['point_orderstate'] 	= '11';//更新兑换信息状态为已付款
		}
		$state = $pointorder_model->updatePointOrder($condition,$update_arr);
		if($payment_info['payment_code'] != 'offline') {
			switch ($payment_info['payment_code']){
				case 'predeposit':
					//跳转到支付接口页面预存款支付
					@header("Location: index.php?act=pointorder_payment&op=predeposit_pay&id=$order_id");
					break;
				default://进入在线支付方式的处理
					break;
			}
			//使用在线支付时跳转到对应的网站
			$payment_orderinfo = array();
			$payment_orderinfo['order_sn'] = $order_info['point_ordersn'];
			$payment_orderinfo['order_amount'] = $order_info['point_shippingfee'];
			$payment_orderinfo['discount']		= 0;
			$payment_orderinfo['modeltype']		= '2';//表示是积分兑换功能调用支付接口
			/**
			 * 建立接口模型的实例对象
			 * 获得支付的url或者表单 数据
			 */
			$payment_info['payment_config'] = unserialize($payment_info['payment_config']);
			$inc_file = BasePath.DS.'api'.DS.'gold_payment'.DS.$payment_info['payment_code'].DS.$payment_info['payment_code'].'.php';
			require_once($inc_file);
			$payment_api = new $payment_info['payment_code']($payment_info,$payment_orderinfo);
			if($payment_info['payment_code'] == 'chinabank') {
				$payment_api->submit();
				exit;
			} else {
				@header("Location: ".$payment_api->get_payurl());
				exit;
			}
		} else {
			showMessage(Language::get('pointcart_step3_paysuccess'),'index.php?act=member_pointorder');
		}
	}
	/**
	 * 递归去除转义
	 *
	 * @param array/string $value
	 * @return array/string
	 */
	public function stripslashes_deep($value){
	    $value = is_array($value) ? array_map(array($this,'stripslashes_deep'), $value) : stripslashes($value);
	    return $value;
	}	
}