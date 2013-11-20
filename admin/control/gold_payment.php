<?php
/**
 * 金币支付方式
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
class gold_paymentControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('gold_payment,payment');
	}
	/**
	 * 支付方式
	 */
	public function gold_paymentOp(){
		$model_payment = Model('gold_payment');
		/**
		 * 支付方式列表
		 */
		$payment_list = $model_payment->getList();
		Tpl::output('payment_list',$payment_list);
		Tpl::showpage('gold_payment.index');
	}
	
	/**
	 * 设置支付方式状态 开启或关闭
	 */
	public function setOp(){
		/**
		 * 验证
		 */
		$obj_validate = new Validate();
		$payment_id = intval($_GET["payment_id"]);
		$state = $_GET["state"];
		$obj_validate->validateparam = array(
			array("input"=>$payment_id , "require"=>"true", "message"=>Language::get('wrong_argument')),
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage($error);
		}else {
			$param = array();
			$param['payment_state'] = $state;
			$model_payment = Model('gold_payment');
			$model_payment->update($payment_id,$param);
			showMessage(Language::get('payment_config_success'),'index.php?act=gold_payment&op=gold_payment');
		}
	}
	
	/**
	 * 编辑支付方式
	 */
	public function editOp(){
		/**
		 * 验证
		 */
		$obj_validate = new Validate();
		
		$model_payment = Model('gold_payment');
		/**
		 * 保存信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			$payment_id = intval($_POST["payment_id"]);
			$state = trim($_POST["payment_state"]);
			$obj_validate->validateparam = array(
				array("input"=>$payment_id , "require"=>"true", "message"=>Language::get('wrong_argument')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$param = array();
				$param['payment_state'] = $state;
				$param['payment_info'] = trim($_POST["payment_info"]);
				
				$payment_config	= '';
				$config_array = explode(',',$_POST["config_name"]);//配置参数
				if(is_array($config_array) && !empty($config_array)) {
					$config_info = array();
					foreach ($config_array as $k) {
						$config_info[$k] = trim($_POST[$k]);
					}
					$payment_config	= serialize($config_info);
				}
				$param['payment_config'] = $payment_config;//支付接口配置信息
				$model_payment->update($payment_id,$param);
				showMessage(Language::get('payment_edit_success'),'index.php?act=gold_payment&op=gold_payment');
			}
		}
		
		$payment_id = intval($_GET["payment_id"]);
		$payment = $model_payment->getRow($payment_id);
		$payment_config	= $payment['payment_config'];
		if ($payment['payment_online'] == '1' && $payment_config != ''){
			$config_array	= unserialize($payment_config);
			Tpl::output('config_array',$config_array);
		}
		/**
		 * 模板输出
		 */
		Tpl::output('payment',$payment);
		Tpl::showpage('gold_payment.edit');
	}
	/**
	 * 支付方式
	 *
	 * @param 
	 * @return 
	 */
	public function paymentOp(){
		$model_payment = Model('payment');
		/**
		 * 支付方式列表
		 */
		$payment_list = $model_payment->getPaymentList();
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$payment_list = Language::getGBK($payment_list);
		}
		/**
		 * 支付方式安装情况
		 */
		if (file_exists(BasePath.DS.'api'.DS.'payment'.DS.'payment.inc.php')){
			/**
			 * $payment_inc
			 */
			require_once(BasePath.DS.'api'.DS.'payment'.DS.'payment.inc.php');
		}
		Tpl::output('payment_inc',$payment_inc);
		Tpl::output('payment_list',$payment_list);
		Tpl::showpage('payment.index');
	}
	
	/**
	 * 设置支付方式状态 开启或关闭
	 *
	 * @param 
	 * @return 
	 */
	public function payment_setOp(){
		$lang	= Language::getLangContent();
		/**
		 * 验证
		 */
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
			array("input"=>$_GET["code"], "require"=>"true", "message"=>$lang['payment_index_null']),
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage($error);
		}else {
			switch ($_GET['state']){
				case 'open':
					$state = 'open';
					$msg = $lang['payment_index_enabled'];
					break;
				case 'close':
					$state = 'close';
					$msg = $lang['payment_index_disabled'];
					break;
					default:
						showMessage($lang['payment_index_error']);
			}
			$model_payment = Model('payment');
			
			$model_payment->setPaymentInc(trim($_GET['code']),trim($_GET['state']));
			
			showMessage($msg);
		}
	}	
}