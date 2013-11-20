<?php
/**
 * 预存款支付入口
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class predeposit_paymentControl extends BaseHomeControl{
	public function __construct(){
		parent::__construct();
		Language::read('member_member_predeposit');
	}
	/**
	 * 通知处理
	 *
	 */
	public function notifyOp(){
		//定义页面输出内容
		$success	= 'success';
		$fail		= 'fail';
		$rechargeorder_sn = trim($_POST['out_trade_no']);
		if(!empty($rechargeorder_sn)) {
			//取得记录信息
			$predeposit_model	= Model('predeposit');
			$condition = array();			
			$condition['pdr_sn'] = $rechargeorder_sn;
			$condition['pdr_paystate'] = '0';//未支付			
			$recharge_info = $predeposit_model->getRechargeRow($condition);
			if (!is_array($recharge_info) || count($recharge_info)<=0){
				exit($fail);
			}
			//支付方式
			$payment_code = $recharge_info["pdr_payment"];
			
			$order_info = array();
			$order_info['order_sn'] = $rechargeorder_sn;
			$order_info['order_amount'] = $recharge_info['pdr_price'];
			$payment_info = $this->payment_info($payment_code);
			//加载对应的支付接口文件
			$inc_file = BasePath.DS.'api'.DS.'gold_payment'.DS.$payment_code.DS.$payment_code.'.php';
			require_once($inc_file);
			$payment_api = new $payment_code($payment_info,$order_info);
			//对进入的参数进行判断
			if($payment_api->notify_verify()) {//支付成功
				$update_arr = array();
				$update_arr['pdr_paystate'] = '1';
				$update_arr['pdr_onlinecode'] = $_POST['trade_no'];//线上交易流水号
				$state = $predeposit_model->rechargeUpdate($condition,$update_arr);
				if($state) {//成功更新后添加日志
					$log_arr = array();
					$log_arr['memberid'] = $recharge_info['pdr_memberid'];
					$log_arr['membername'] = $recharge_info['pdr_membername'];
					$log_arr['logtype'] = '0';
					$log_arr['price'] = $recharge_info['pdr_price'];//增加预存款
					$predeposit_model->savePredepositLog('recharge',$log_arr);
					exit($success);
				}else {
					exit($fail);
				}
			}else {
				exit($fail);
			}
		}
		exit($fail);
	}
	/**
	 * 返回地址处理
	 *
	 */
	public function returnOp(){
		$url	= SiteUrl.DS."index.php?act=predeposit&op=rechargelist";
		
		$rechargeorder_sn = trim($_GET['out_trade_no']);
		if(!empty($rechargeorder_sn)) {
			//取得记录信息
			$predeposit_model	= Model('predeposit');
			$condition = array();
			$condition['pdr_sn'] = $rechargeorder_sn;						
			$recharge_info = $predeposit_model->getRechargeRow($condition);
			if (!is_array($recharge_info) || count($recharge_info)<=0){
				showMessage(Language::get('predeposit_payment_pay_fail'),$url,'html','error');
			}
			//支付方式
			$payment_code = $recharge_info["pdr_payment"];
			
			$order_info = array();
			$order_info['order_sn'] = $rechargeorder_sn;
			$order_info['order_amount'] = $recharge_info['pdr_price'];
			$payment_info = $this->payment_info($payment_code);
			//加载对应的支付接口文件
			$inc_file = BasePath.DS.'api'.DS.'gold_payment'.DS.$payment_code.DS.$payment_code.'.php';
			require_once($inc_file);
			$payment_api = new $payment_code($payment_info,$order_info);
			//对进入的参数进行数据判断
			if($payment_api->return_verify()) {//支付成功
				$condition['pdr_paystate'] = '0';//未支付
				$update_arr = array();
				$update_arr['pdr_paystate'] = '1';
				$update_arr['pdr_onlinecode'] = $_GET['trade_no'];//线上交易流水号
				$state = $predeposit_model->rechargeUpdate($condition,$update_arr);
				if ($recharge_info['pdr_paystate'] == '0' && $state){
					$log_arr = array();
					$log_arr['memberid'] = $recharge_info['pdr_memberid'];
					$log_arr['membername'] = $recharge_info['pdr_membername'];
					$log_arr['logtype'] = '0';
					$log_arr['price'] = $recharge_info['pdr_price'];//增加预存款
					$predeposit_model->savePredepositLog('recharge',$log_arr);
				}
				//财付通需要输出反馈
				if ($payment_code == 'tenpay'){
					$url = SiteUrl."/index.php?act=predeposit_payment&op=payment_success";
					showMessage(Language::get('predeposit_payment_pay_success'),$url,'tenpay');
				} else {
					showMessage(Language::get('predeposit_payment_pay_success'),$url);
				}
			} else {
				showMessage(Language::get('predeposit_payment_pay_fail'),$url,'html','error');
			}
		} else {
			showMessage(Language::get('predeposit_payment_pay_fail'),$url,'html','error');
		}
	}
	/**
	 * 支付成功
	 */
	public function payment_successOp(){
		$url	= SiteUrl.DS."index.php?act=predeposit&op=rechargelist";
		showMessage(Language::get('predeposit_payment_pay_success'),$url);
	}
	/**
	 * 支付方式
	 */
	private function payment_info($payment_code){
		//实例化支付方式模型
		$goldpayment_model = Model('gold_payment');
		$payment_info = array();
		$payment_info = $goldpayment_model->getRowByCondition(array('payment_code','payment_state'),array($payment_code,1));
		//还原支付方式的设置参数数组
		$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
		return $payment_info;
	}
}