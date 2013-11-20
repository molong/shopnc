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
class gold_paymentControl extends BaseHomeControl{
	public function __construct(){
		parent::__construct();
		Language::read('member_store_gbuy');
	}
	
	/**
	 * 通知处理
	 *
	 */
	public function notifyOp(){
		/**
		 * 定义页面输出内容
		 */
		$success	= 'success';
		$fail		= 'fail';
		$gbuy_id = $_POST['out_trade_no'];
		if(intval($gbuy_id) > 0) {
			/**
			 * 取得购买金币信息
			 */
			$model_gbuy	= Model('gold_buy');
			$condition = array();
			$condition['gbuy_id'] = $gbuy_id;
			$condition['gbuy_ispay'] = '0';//未支付状态
			$gbuy_list = $model_gbuy->getList($condition);
			$gold_buy = $gbuy_list[0];
			
			$payment_code = $gold_buy["gbuy_check_type"];
			
			$order_info = array();
			$order_info['order_sn'] = $gbuy_id;
			$order_info['order_amount'] = $gold_buy['gbuy_price'];
			$payment_info = $this->payment_info($payment_code);
			/**
			 * 加载对应的支付接口文件
			 */
			$inc_file = BasePath.DS.'api'.DS.'gold_payment'.DS.$payment_code.DS.$payment_code.'.php';
			require_once($inc_file);
			$payment_api = new $payment_code($payment_info,$order_info);
			
			/**
			 * 对进入的参数进行判断
			 */
			if($payment_api->notify_verify()) {//支付成功
				$gbuy_array = array();
				$gbuy_array['gbuy_ispay'] = '1';
				$state = $model_gbuy->update($condition,$gbuy_array);//修改购买记录状态
				if($state) {//成功更新后添加日志
					$this->gold_log($gold_buy);
				}
				exit($success);
			}
		}
		exit($fail);
	}
	/**
	 * 返回地址处理
	 *
	 */
	public function returnOp(){
		$url	= SiteUrl."/index.php?act=store_gbuy";
		
		$gbuy_id = $_GET['out_trade_no'];
		if(intval($gbuy_id) > 0) {
			/**
			 * 取得购买金币信息
			 */
			$model_gbuy	= Model('gold_buy');
			$condition = array();
			$condition['gbuy_id'] = $gbuy_id;
			$gbuy_list = $model_gbuy->getList($condition);
			$gold_buy = $gbuy_list[0];
			
			$payment_code = $gold_buy["gbuy_check_type"];
			
			$order_info = array();
			$order_info['order_sn'] = $gbuy_id;
			$order_info['order_amount'] = $gold_buy['gbuy_price'];
			$payment_info = $this->payment_info($payment_code);
			/**
			 * 加载对应的支付接口文件
			 */
			$inc_file = BasePath.DS.'api'.DS.'gold_payment'.DS.$payment_code.DS.$payment_code.'.php';
			require_once($inc_file);
			$payment_api = new $payment_code($payment_info,$order_info);
			
			/**
			 * 对进入的参数进行数据判断
			 */
			if($payment_api->return_verify()) {//支付成功
				$gbuy_array = array();
				$gbuy_array['gbuy_ispay'] = '1';
				$condition['gbuy_ispay'] = '0';//未支付状态
				$state = $model_gbuy->update($condition,$gbuy_array);//修改购买记录状态
				if($gold_buy['gbuy_ispay'] == '0' && $state) {//成功更新后添加日志
					$this->gold_log($gold_buy);
				}
				//财付通需要输出反馈
				if ($payment_code == 'tenpay'){
					$url = SiteUrl."/index.php?act=gold_payment&op=payment_success";
					showMessage(Language::get('store_gbuy_pay_success'),$url,'tenpay');//'支付成功'
				} else {
					showMessage(Language::get('store_gbuy_pay_success'),$url);//'支付成功'
				}
			} else {
				showMessage(Language::get('miss_argument'),SiteUrl,'html','error');//'缺少参数'
			}
		} else {
			showMessage(Language::get('miss_argument'),SiteUrl,'html','error');//'缺少参数'
		}
	}
	/**
	 * 支付成功
	 * 
	 */
	public function payment_successOp(){
		$url	= SiteUrl."/index.php?act=store_gbuy";
		showMessage(Language::get('store_gbuy_pay_success'),$url);//'支付成功'
	}
	/**
	 * 预存款支付
	 */
	public function predeposit_payOp(){
		$gbuy_id = intval($_GET['gbuy_id']);
		if($gbuy_id<=0){
			showMessage(Language::get('miss_argument'),'index.php?act=store_gbuy','html','error');
		}
		//获取金币充值记录
		$model_gbuy	= Model('gold_buy');
		$condition = array();
		$condition['gbuy_id'] = "$gbuy_id";
		$condition['gbuy_ispay'] = '0';//未支付
		$condition['gbuy_mid'] = "{$_SESSION['member_id']}";
		$gbuy_list = $model_gbuy->getList($condition);
		$gold_buy = $gbuy_list[0];
		if (empty($gold_buy)){
			showMessage(Language::get('store_gbuy_no_record'),'index.php?act=store_gbuy','html','error');
		}
		//减少买家账户预存款
		$member_model	= Model('member');
		$buyer_info	= $member_model->infoMember(array('member_id'=>"{$_SESSION['member_id']}"));
		if (empty($buyer_info)){
			showMessage(Language::get('store_gbuy_buyer_error'),'index.php?act=store_gbuy','html','error');
		}
		//预存款是否足够
		if (floatval($buyer_info['available_predeposit']) < floatval($gold_buy['gbuy_price'])){
			showMessage(Language::get('store_gbuy_predeposit_short_error'),'index.php?act=store_gbuy','html','error');
		}
		$predeposit_model = Model('predeposit');
		//减少可用金额
		$log_arr = array();
		$log_arr['memberid'] = $_SESSION['member_id'];
		$log_arr['membername'] = $_SESSION['member_name'];
		$log_arr['logtype'] = '0';
		$log_arr['price'] = -$gold_buy['gbuy_price'];
		$log_arr['desc'] = Language::get('store_gbuy_predepositreduce_logdesc');
		$predeposit_model->savePredepositLog('order',$log_arr);
		unset($log_arr);
		//更新金币充值记录状态为已支付
		$gbuy_array = array();
		$gbuy_array['gbuy_ispay'] = '1';
		$condition['gbuy_ispay'] = '0';//未支付状态
		$state = $model_gbuy->update($condition,$gbuy_array);//修改购买记录状态
		if($gold_buy['gbuy_ispay'] == '0' && $state){//成功更新后添加日志
			$this->gold_log($gold_buy);
		}
		showMessage(Language::get('store_gbuy_edit_success'),"index.php?act=store_gbuy");//支付成功
	}
	/**
	 * 支付方式
	 *
	 */
	private function payment_info($payment_code){
		/**
		 * 实例化支付方式模型
		 */
		$model_payment = Model('gold_payment');
		$payment_info = array();
		$payment_condition = array();
		$payment_condition['payment_code'] = $payment_code;
		$payment_list = $model_payment->getList($payment_condition);
		$payment_info = $payment_list[0];
		/**
		 * 还原支付方式的设置参数数组
		 */
		$payment_info['payment_config']	= unserialize($payment_info['payment_config']);
		return $payment_info;
	}
	/**
	 * 记录日志
	 *
	 */
	private function gold_log($gold_buy){
		
		$member_model = Model('member');
		$gbuy_num = intval($gold_buy["gbuy_num"]);
		$member_id = $gold_buy['gbuy_mid'];
		$member_array = array();
		$member_array['member_goldnum'] = array('value'=>$gbuy_num,'sign'=>'increase');//当前数
		$member_array['member_goldnumcount'] = array('value'=>$gbuy_num,'sign'=>'increase');//总共充值数
		$member_model->updateMember($member_array,$member_id);//更新会员的金币数
		
		$model_glog	= Model('gold_log');
		$gold_log = array();
		$gold_log['glog_memberid'] = $gold_buy['gbuy_mid'];
		$gold_log['glog_membername'] = $gold_buy['gbuy_membername'];
		$gold_log['glog_storeid'] = $gold_buy['gbuy_storeid'];
		$gold_log['glog_storename'] = $gold_buy['gbuy_storename'];
		$gold_log['glog_adminid'] = 0;
		$gold_log['glog_adminname'] = 'system';
		$gold_log['glog_method'] = '1';//金币增减方式 1增加 2减少
		$gold_log['glog_addtime'] = time();	
		$gold_log['glog_goldnum'] = $gold_buy['gbuy_num'];
		$gold_log['glog_stage'] = 'system';//操作阶段方式 system 表示系统操作 ztc 表示直通车阶段操作
		$gold_log['glog_desc'] = Language::get('store_gbuy_success');
		$model_glog->add($gold_log);//添加操作记录日志
	}
	
}