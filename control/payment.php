<?php
/**
 * 支付入口
 *
 * 
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class paymentControl extends BaseHomeControl{
	/**
	 * 首页
	 */
	public function indexOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_payment_index');
		/**
		 * 传递过来的订单号的非空判断
		 */
		if(empty($_GET['order_id'])){
			showMessage(Language::get('miss_argument'),SiteUrl,'html','error');
		}
		//验证支付方式
		$payment_id = intval($_POST['payment_id']);
		if($payment_id <= 0){
			showMessage(Language::get('miss_argument'),SiteUrl.'/index.php?act=cart&op=order_pay&order_id='.$_GET['order_id'],'html','error');
		}
		if (!C('payment')){
			//支付到平台
			$payment_model = Model('gold_payment');
			$condition = array();
			$condition['payment_id'] = $payment_id;
			$payment_info = $payment_model->getRow($payment_id);					
		}else{
			//支付到店铺
			$payment_model	= Model('payment');
			$payment_info	= $payment_model->getPaymentById($payment_id);
		}

		//店铺存在该支付方式并且启用
		if (empty($payment_info) || $payment_info['payment_state'] != 1){
			showMessage(Language::get('payment_index_store_not_support'),SiteUrl.'/index.php?act=cart&op=order_pay&order_id='.$_GET['order_id'],'html','error');
		}
		//根据code验证支付方式在管理员后台是否启用
		if(!$payment_model->checkPayment($payment_info['payment_code'])){
			showMessage(Language::get('payment_index_sys_not_support').$payment_info['payment_code'],SiteUrl.'/index.php?act=cart&op=order_pay&order_id='.$_GET['order_id'],'html','error');
		}
		//银行汇款时，支付留言必填
//		if ($payment_info['payment_code'] == 'offline' && trim($_POST['pay_message']) == ''){
//			showMessage(Language::get('payment_index_input_pay_info'),SiteUrl.'/index.php?act=cart&op=order_pay&order_id='.$_GET['order_id'],'html','error');
//		}
		/**
		 * 创建订单对象
		 */
		$order = Model('order');
		/**
		 * 根据订单标号读取支付方式的code(取得该订单的全部数据)
		 */
		$order_info	= $order->getOrderById(intval($_GET['order_id']));
		/**
		 * 订单数据非空判断
		 */
		if(empty($order_info) or !is_array($order_info)){
			showMessage(Language::get('payment_index_order').Language::get('payment_index_not_exists'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
		/**
		 * 验证订单编号与当前的登录用户是否对应
		 */
		if($_SESSION['member_id'] != $order_info['buyer_id']){
			showMessage(Language::get('payment_index_order').$order_info['order_sn'].Language::get('payment_index_not_exists'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
		/**
		 * 订单状态必须是0值的判断
		 */
		if($order_info['order_state'] != '10'){
			showMessage(Language::get('payment_index_order').$order_info['order_sn'].Language::get('payment_index_pay_finish'),SiteUrl.'/index.php?act=member&op=order','html','error');//'已经支付完毕'
		}
		/**
		 * 更新订单支付方式
		 */
		$input	= array();
        if($payment_info['payment_code'] == 'cod') $input['order_state'] = 50;
		$input['payment_id']	= $payment_id;
		$input['payment_name']	= $payment_info['payment_name'];
		$input['payment_code']	= $payment_info['payment_code'];
		if(!$order->updateOrder($input,intval($_GET['order_id']))){
			showMessage(Language::get('payment_index_add_info_fail'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
		/**
		 * 刷新订单数据
		 */
		$order_info	= $order->getOrderById(intval($_GET['order_id']));
		if(empty($order_info) or !is_array($order_info)){
			showMessage(Language::get('payment_index_order').$order_info['order_sn'].Language::get('payment_index_refresh_fail'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
		/**
		 * 根据订单号读取支付方式的非空判断(即如果code不为空)
		 */
		//if(empty($payment_info['payment_code'])){//code为空则报错
		//	$url	= SiteUrl."/index.php?act=cart&op=step2&order_id=".intval($_GET['order_id']);
		//	@header('Location:'.$url);
		//	exit;
		//}else{//进入支付网关
			/**
			 * 根据支付方式的线上/线下属性,分支处理
			 */
			if($payment_info['payment_online']=='1' && $order_info['payment_code'] != 'predeposit'){//线上支付处理
				/**
				 * 建立接口模型的实例对象
				 * 获得支付的url或者表单 数据
				 */
				$inc_file = BasePath.DS.'api'.DS.'payment'.DS.$order_info['payment_code'].DS.$order_info['payment_code'].'.php';
				if(!file_exists($inc_file)){
					showMessage(Language::get('payment_index_lose_file').$payment_info['payment_name'],SiteUrl.'/index.php?act=member&op=order','html','error');
				}
				require_once($inc_file);
				$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
	    		$payment_api	= new $order_info['payment_code']($payment_info,$order_info);
				if($order_info['payment_code'] == 'chinabank') {
					$payment_api->submit();
					exit;
				} else {
					@header("Location:".$payment_api->get_payurl());
					exit;
				}
			}else{//线下支付处理
				//Tpl::output('payment_info',$payment_info);
				//Tpl::output('order_info',$order_info);
				//Tpl::showpage('payment_paymessage');
				if ($payment_info['payment_code'] == 'offline'){
					$this->offline_pay($order_info);
				}elseif ($payment_info['payment_code'] == 'predeposit'){
					$this->predeposit_pay($order_info);
				}elseif ($payment_info['payment_code'] == 'cod'){
					$this->cod_pay($order_info);
				}else {
					showMessage(Language::get('payment_index_store_not_support'),SiteUrl.'/index.php?act=member&op=order','html','error');
				}
			}
		//}
	}
	/**
	 * 通知处理(目前就只是支付宝使用 v1.2)
	 *
	 */
	public function notifyOp(){
//		log_result('进入payment.php:订单号:'.$_POST['out_trade_no'].'订单状态:'.$_POST['trade_status']);
		/**
		 * 定义页面输出内容
		 */
		$success	= 'success';
		$fail		= 'fail';
		/**
		 * 对外部交易编号进行非空判断
		 */
		if(empty($_POST['out_trade_no']))exit($fail);
		/**
		 * 取得订单信息
		 */
		$order		= Model('order');
		$order_info	= $order->getOrderByOutSn($_POST['out_trade_no']);
		/**
		 * 对订单信息进行非空判断
		 */
		if(!is_array($order_info) or empty($order_info))exit($fail);
		if(empty($order_info['payment_id']))exit($fail);
		/**
		 * 取得支付方式信息
		 */
		$payment_id	= $order_info['payment_id'];
		if (!C('payment')){
			//支付到平台
			$payment_model = Model('gold_payment');
			$condition = array();
			$condition['payment_id'] = $payment_id;
			$payment_info = $payment_model->getRow($payment_id);					
		}else{
			//支付到店铺
			$payment_model	= Model('payment');
			$payment_info	= $payment_model->getPaymentById($payment_id);
		}
		/**
		 * 对支付方式进行非空判断
		 */
		if(!is_array($payment_info) or empty($payment_info))exit($fail);
		/**
		 * 还原支付方式的设置参数数组
		 */
		$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
		/**
		 * 加载对应的支付接口文件
		 */
		$inc_file = BasePath.DS.'api'.DS.'payment'.DS.$order_info['payment_code'].DS.$order_info['payment_code'].'.php';
		
		if(!file_exists($inc_file))exit($fail);
		
		require_once($inc_file);
		/**
		 * 创建支付接口对象
		 */
		$payment_api	= new $order_info['payment_code']($payment_info,$order_info);
		/**
		 * 对进入的参数进行远程数据判断
		 */
		if(!$payment_api->notify_verify())exit($fail);//非法访问或卖家更改了partner设置造成
		/**
		 * 取得更新信息的数组
		 */
		$input	= $payment_api->getUpdateParam($_POST);
		
		if ($order_info['payment_code'] == 'alipay'){//支付宝要判断支付类型:1是即时到帐,2是但保交易
			if($input['order_state']>0 and $input['order_state']<40) $input['payment_direct']	= '2';//担保交易
			if($input['order_state']==40 and $order_info['payment_direct']==1){ //即时到帐
				$input['order_state'] = 20;
				$input['payment_time']	= time();
				$input['finnshed_time']	= '';
			}
		}
				
		/**
		 * 输出处理
		 */
		if(empty($input)){
			exit($success);
		}elseif(!empty($input['error'])){
			exit($fail);
		}elseif($input['order_state']>0 and $order->updateOrder($input,$order_info['order_id']) and $order->addLogOrder($input['order_state'],$order_info['order_id'])){
			$model_member	= Model('member');
			
			$buyer	= $model_member->infoMember(array('member_id'=>$order_info['buyer_id']));
			//确认收货时添加会员积分
			if ($GLOBALS['setting_config']['points_isuse'] == 1 && $input['order_state'] == 40){
				$points_model = Model('points');
				$points_model->savePointsLog('order',array('pl_memberid'=>$buyer['member_id'],'pl_membername'=>$buyer['member_name'],'orderprice'=>$order_info['order_amount'],'order_sn'=>$order_info['order_sn'],'order_id'=>$order_info['order_id']),true);
			}
			/**
			 * 发送邮件通知
			 */
			$seller	= $model_member->infoMember(array('member_id'=>$order_info['seller_id']));
			$param	= array(
				'site_url'	=> SiteUrl,
				'site_name'	=> $GLOBALS['setting_config']['site_name'],
				'buyer_name'	=> $order_info['buyer_name'],
				'seller_name'	=> $seller['member_name'],
				'order_sn'	=> $order_info['order_sn'],
				'order_id'	=> $order_info['order_id']
			);
			switch($input['order_state']){
				case 20:
					$this->send_notice($order_info['seller_id'],'email_toseller_online_pay_success_notify',$param);
					break;
				case 30:
					$this->send_notice($order_info['buyer_id'],'email_tobuyer_shipped_notify',$param);
					break;
				case 40:
					$this->send_notice($order_info['seller_id'],'email_toseller_finish_notify',$param);
					$this->send_notice($order_info['buyer_id'],'email_tobuyer_cod_order_finish_notify',$param);
					break;
			}
			exit($success);
		}else{
			exit($fail);
		}
	}
	/**
	 * 返回地址处理
	 *
	 */
	public function returnOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_payment_index');
		$url	= SiteUrl."/index.php?act=member&op=order";
		/**
		 * 对外部交易编号进行非空判断
		 */
		if(empty($_GET['out_trade_no']))showMessage(Language::get('miss_argument'),SiteUrl,'','html','error');
		/**
		 * 取得订单信息
		 */
		$order		= Model('order');
		$order_info	= $order->getOrderByOutSn($_GET['out_trade_no']);
		/**
		 * 对订单信息进行非空判断
		 */
		if(!is_array($order_info) or empty($order_info))showMessage(Language::get('payment_index_spec_order_not_exists1').$_GET['out_trade_no'].Language::get('payment_index_spec_order_not_exists2'),SiteUrl,'html','error');
		if(empty($order_info['payment_id']))showMessage(Language::get('payment_index_miss_pay_method'),SiteUrl,'html','error');
		/**
		 * 取得支付方式信息
		 */
		$payment_id	= $order_info['payment_id'];
		if (!C('payment')){
			//支付到平台
			$payment_model = Model('gold_payment');
			$condition = array();
			$condition['payment_id'] = $payment_id;
			$payment_info = $payment_model->getRow($payment_id);					
		}else{
			//支付到店铺
			$payment_model	= Model('payment');
			$payment_info	= $payment_model->getPaymentById($payment_id);
		}
		/**
		 * 对支付方式进行非空判断
		 */
		if(!is_array($payment_info) or empty($payment_info))showMessage(Language::get('payment_index_miss_pay_method_data'),SiteUrl,'html','error');
		/**
		 * 还原支付方式的设置参数数组
		 */
		$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
		/**
		 * 加载对应的支付接口文件
		 */
		$inc_file = BasePath.DS.'api'.DS.'payment'.DS.$order_info['payment_code'].DS.$order_info['payment_code'].'.php';
		
		if(!file_exists($inc_file))showMessage(Language::get('payment_index_lose_file').$payment_info['payment_name'],SiteUrl,'html','error');
		
		require_once($inc_file);
		/**
		 * 创建支付接口对象
		 */
		$payment_api	= new $order_info['payment_code']($payment_info,$order_info);
		/**
		 * 对进入的参数进行远程数据判断
		 */
		if(!$payment_api->return_verify())showMessage(Language::get('payment_index_identify_fail'),SiteUrl,'html','error');
		/**
		 * 取得更新信息的数组
		 */
		$input	= $payment_api->getUpdateParam($_GET);
		if ($order_info['payment_code'] == 'alipay'){//支付宝要判断支付类型:1是即时到帐,2是但保交易
			if($input['order_state']>0 and $input['order_state']<40) $input['payment_direct']	= '2';//担保交易
			if($input['order_state']==40 and $order_info['payment_direct']==1){ //即时到帐
				$input['order_state'] = 20;
				$input['payment_time']	= time();
				$input['finnshed_time']	= '';
			}
		}
		/**
		 * 输出处理
		 */
		if(empty($input)){
			showMessage(Language::get('payment_index_order_ensure'),$url);//'订单状态已确认'
		}elseif(!empty($input['error'])){
			showMessage(Language::get('miss_argument'),SiteUrl,'html','error');
		}elseif($input['order_state']>0 and $order->updateOrder($input,$order_info['order_id']) and $order->addLogOrder($input['order_state'],$order_info['order_id'])){
			//财付通需要输出反馈
			if ($order_info['payment_code'] == 'tenpay'){
				$url = SiteUrl."/index.php?act=payment&op=payment_success";
				showMessage(Language::get('payment_index_deal_order_success'),$url,'tenpay');
			}else {
				showMessage(Language::get('payment_index_deal_order_success'),$url);
			}
		}else{
			showMessage(Language::get('payment_index_deal_order_fail'),'','html','error');
		}
	}
	/**
	 * 支付成功
	 * 
	 */
	public function payment_successOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_payment_index');
		$url	= SiteUrl."/index.php?act=member&op=order";
		
		showMessage(Language::get('payment_index_deal_order_success'),$url);
	}
	/**
	 * 货到付款
	 *
	 */
	public function cod_pay($order_info){
		/**
		 * 读取语言包
		 */
		Language::read('home_payment_index');
		$order	= Model('order');
		$input	= array();
		$input['pay_message']	= trim($_POST['pay_message']);
		$input['payment_time']	= time();
		if($order->updateOrder($input,intval($order_info['order_id']))){
			showMessage(Language::get('payment_index_deal_order_success'),SiteUrl.'/index.php?act=member&op=order');
		}else{
			showMessage(Language::get('payment_index_deal_order_fail'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
	}
	/**
	 * 线下支付
	 *
	 */
	public function offline_pay($order_info){
		//读取语言包
		Language::read('home_payment_index');
		$order	= Model('order');
		$input	= array();
		$input['order_state']	= $order_info['order_state'] == 50 ? 50 : 11;
		$input['pay_message']	= serialize($this->stripslashes_deep($_POST['offline']));
		$input['payment_time']	= TIMESTAMP;
		if($order->updateOrder($input,intval($order_info['order_id']))){
			/**
			 * 发送邮件通知
			 */
			$member_model	= Model('member');
			$seller	= $member_model->infoMember(array('member_id'=>$order_info['seller_id']));
			$param	= array(
				'site_url'	=> SiteUrl,
				'site_name'	=> $GLOBALS['setting_config']['site_name'],
				'buyer_name'	=> $order_info['buyer_name'],
				'seller_name'	=> $seller['member_name'],
				'order_sn'	=> $order_info['order_sn'],
				'order_id'	=> intval($order_info['order_id']),
				'pay_message'	=> trim($_POST['pay_message'])
			);
			$this->send_notice($order_info['seller_id'],'email_toseller_offline_pay_notify',$param);
			showMessage(Language::get('payment_index_deal_order_success'),SiteUrl.'/index.php?act=member&op=order');
		}else{
			showMessage(Language::get('payment_index_deal_order_fail'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
	}
	/**
	 * 预存款支付
	 *
	 */
	public function predeposit_pay($order_info){
		/**
		 * 读取语言包
		 */
		Language::read('home_payment_index');
		//验证订单信息
		$order	= Model('order');
		//验证订单是否已经支付
		if ($order_info['order_state'] != 10){//未支付时
			showMessage(Language::get('payment_index_spec_order_not_exists1').$order_info['order_sn'].Language::get('payment_index_pay_finish'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
		//冻结买家账户预存款
		$member_model	= Model('member');
		$buyer_info	= $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		if (!is_array($buyer_info) || count($buyer_info)<=0){
			showMessage(Language::get('payment_index_spec_order_not_exists1').$order_info['order_sn'].Language::get('payment_index_buyerinfo_error'),SiteUrl.'/index.php?act=member&op=order','html','error');
		}
		//预存款是否足够
		if (floatval($buyer_info['available_predeposit']) < $order_info['order_amount']){
			showMessage(Language::get('payment_predeposit_short_error'),SiteUrl.'/index.php?act=predeposit','html','error');
		}
		$predeposit_model = Model('predeposit');
		//减少可用金额
		$log_arr = array();
		$log_arr['memberid'] = $_SESSION['member_id'];
		$log_arr['membername'] = $_SESSION['member_name'];
		$log_arr['logtype'] = '0';
		$log_arr['price'] = -$order_info['order_amount'];
		$log_arr['desc'] = Language::get('payment_index_order').$order_info['order_sn'].Language::get('payment_order_predeposit_logdesc');
		$predeposit_model->savePredepositLog('order',$log_arr);
		//增加冻结金额
		$log_arr['logtype'] = '1';
		$log_arr['price'] = $order_info['order_amount'];
		$log_arr['desc'] = Language::get('payment_index_order').$order_info['order_sn'].Language::get('payment_order_predepositfreeze_logdesc');
		$predeposit_model->savePredepositLog('order',$log_arr);
		unset($log_arr);
		
		//修改订单信息
		$input	= array();
		$input['order_state']	= 20; //已付款
		$input['pay_message']	= trim($_POST['pay_message']);
		$input['payment_time']	= time();
		$result = $order->updateOrder($input,intval($order_info['order_id']));
		if($result){
			//增加订单日志
			$order->addLogOrder('20',intval($order_info['order_id']));
			/**
			 * 发送邮件通知
			 */
			$member_model	= Model('member');
			$seller	= $member_model->infoMember(array('member_id'=>$order_info['seller_id']));
			$param	= array(
				'site_url'	=> SiteUrl,
				'site_name'	=> $GLOBALS['setting_config']['site_name'],
				'buyer_name'	=> $order_info['buyer_name'],
				'seller_name'	=> $seller['member_name'],
				'order_sn'	=> $order_info['order_sn'],
				'order_id'	=> intval($order_info['order_id']),
				'pay_message'	=> trim($_POST['pay_message'])
			);
			$this->send_notice($order_info['seller_id'],'email_toseller_online_pay_success_notify',$param);
			showMessage(Language::get('payment_index_deal_order_success'),SiteUrl."/index.php?act=member&op=order");
		}else{
			showMessage(Language::get('payment_index_deal_order_fail'),SiteUrl."/index.php?act=member&op=order",'html','error');
		}
	}
	/**
	 * 发货处理
	 *
	 */
	public function sendOp(){
		if(empty($_GET['order_id'])){
			showMessage(Language::get('miss_argument'),SiteUrl."/index.php?act=store&op=store_order",'html','error');
		}
		$payment_api	= $this->getPaymentApiByOrderId(intval($_GET['order_id']),'send');
		$payment_api->sendGoods();
	}
	/**
	 * 收货处理
	 *
	 */
	public function receiveOp(){
		if(empty($_GET['order_id'])){
			showMessage(Language::get('miss_argument'),SiteUrl."/index.php?act=member&op=order",'html','error');
		}
		$payment_api	= $this->getPaymentApiByOrderId(intval($_GET['order_id']),'receive');
		$payment_api->receiveGoods();
	}
	/**
	 * 根据订单编号获得支付接口对象
	 *
	 * @param int $order_id 订单编号
	 * @param string $type  发货/收货
	 * @return obj
	 */
	private function getPaymentApiByOrderId($order_id,$type){
		Language::read('home_payment_index');
		$order		= Model('order');
		$order_info	= $order->getOrderById($order_id,'simple');
		if(!is_array($order_info) || empty($order_info)){
			showMessage(Language::get('payment_index_spec_order_not_exists1').Language::get('payment_index_spec_order_not_exists2'),'','html','error');
		}
		switch($type){
			case 'send':
				if($_SESSION['member_id'] != $order_info['seller_id']){
					showMessage(Language::get('payment_index_spec_order_not_exists1').$order_info['order_sn'].Language::get('payment_index_not_belong_you'),'','html','error');
				}
				break;
			case 'receive':
				if($_SESSION['member_id'] != $order_info['buyer_id']){
					showMessage(Language::get('payment_index_spec_order_not_exists1').$order_info['order_sn'].Language::get('payment_index_not_belong_you'),'','html','error');
				}
				break;
		}
		if(empty($order_info['payment_id']))showMessage(Language::get('payment_index_miss_pay_method'),SiteUrl,'html','error');
		$payment_id	= $order_info['payment_id'];
		if (!C('payment')){
			//支付到平台
			$payment_model = Model('gold_payment');
			$condition = array();
			$condition['payment_id'] = $payment_id;
			$payment_info = $payment_model->getRow($payment_id);					
		}else{
			//支付到店铺
			$payment_model	= Model('payment');
			$payment_info	= $payment_model->getPaymentById($payment_id);
		}
		if(!is_array($payment_info) or empty($payment_info))showMessage(Language::get('payment_index_miss_pay_method_data'),SiteUrl,'html','error');
		$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
		
		$inc_file = BasePath.DS.'api'.DS.'payment'.DS.$order_info['payment_code'].DS.$order_info['payment_code'].'.php';
		
		if(!file_exists($inc_file))showMessage(Language::get('payment_index_lose_file').$payment_info['payment_name'],SiteUrl,'html','error');
		
		require_once($inc_file);
		
		$payment_api	= new $order_info['payment_code']($payment_info,$order_info);
		return $payment_api;
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