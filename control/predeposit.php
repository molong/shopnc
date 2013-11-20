<?php
/**
 * 预存款管理
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class predepositControl extends BaseMemberControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_member_predeposit');
		
		if($GLOBALS['setting_config']['predeposit_isuse'] != '1'){
			showMessage(Language::get('predeposit_unavailable'),'index.php?act=member_snsindex','html','error');
		}
		//充值记录状态数组
		$rechargestate = array(0=>Language::get('predeposit_rechargestate_auditing'),1=>Language::get('predeposit_rechargestate_completed'),2=>Language::get('predeposit_rechargestate_closed'));
		//充值记录支付状态数组
		$rechargepaystate = array(0=>Language::get('predeposit_rechargewaitpaying'),1=>Language::get('predeposit_rechargepaysuccess'));
		Tpl::output('rechargestate',$rechargestate);
		Tpl::output('rechargepaystate',$rechargepaystate);
		//提现记录状态数组
		$cashstate = array(0=>Language::get('predeposit_cashstate_auditing'),1=>Language::get('predeposit_cashstate_completed'),2=>Language::get('predeposit_cashstate_closed'));
		//提现记录支付状态数组
		$cashpaystate = array(0=>Language::get('predeposit_cashwaitpaying'),1=>Language::get('predeposit_cashpaysuccess'));
		Tpl::output('cashstate',$cashstate);
		Tpl::output('cashpaystate',$cashpaystate);
		Tpl::setLayout('member_pub_layout');
	}
	/**
	 * 充值添加
	 */
	public function indexOp(){
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["payment_sel"], "require"=>"true","message"=>Language::get('predeposit_recharge_add_paymentnull_error'));
			$validate_arr[] = array("input"=>$_POST["price"], "require"=>"true",'validator'=>'Compare','operator'=>'>=',"to"=>'0.01','message'=>Language::get('predeposit_recharge_add_pricemin_error')); 
			$payment_sel = trim($_POST['payment_sel']);
			if ($payment_sel == 'offline'){
				$validate_arr[] = array("input"=>$_POST["huikuan_name"],"require"=>"true","message"=>Language::get('predeposit_recharge_add_huikuannamenull_error'));
				$validate_arr[] = array("input"=>$_POST["huikuan_bank"],"require"=>"true","message"=>Language::get('predeposit_recharge_add_huikuanbanknull_error'));
				$validate_arr[] = array("input"=>$_POST["huikuan_date"],"require"=>"true","message"=>Language::get('predeposit_recharge_add_huikuandatenull_error'));
			}
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();			
			if ($error != ''){
				showMessage($error,'','html','error');
			}
			//判断支付方式是否是预存款
			if ($payment_sel == 'predeposit'){
				showMessage(Language::get('predeposit_recharge_payment_error'),'index.php?act=predeposit&op=rechargelist','html','error');
			}
			//获取支付方式信息
			$goldpayment_model = Model('gold_payment');
			$payment_info = $goldpayment_model->getRowByCondition(array('payment_code','payment_state'),array($payment_sel,1));
			if (!is_array($payment_info) || count($payment_info)<=0){
				showMessage(Language::get('predeposit_recharge_payment_error'),'index.php?act=predeposit&op=rechargelist','html','error');
			}
			//预存款实例
			$predeposit_model = Model('predeposit');
			$price = floatval($_POST['price']);
			$insert_arr = array();
			$insert_arr['pdr_sn'] = $predeposit_model->recharge_snOrder();
			$insert_arr['pdr_memberid'] = $_SESSION['member_id'];
			$insert_arr['pdr_membername'] = $_SESSION['member_name'];
			$insert_arr['pdr_price'] = $price;
			$insert_arr['pdr_payment'] = $payment_sel;
			if ($payment_sel == 'offline'){
				$insert_arr['pdr_remittancename'] = $_POST['huikuan_name'];
				$insert_arr['pdr_remittancebank'] = $_POST['huikuan_bank'];
				$insert_arr['pdr_remittancedate'] = strtotime($_POST['huikuan_date']);
			} else {
				$insert_arr['pdr_remittancename'] = '';
				$insert_arr['pdr_remittancebank'] = '';
				$insert_arr['pdr_remittancedate'] = '';
			}
			$insert_arr['pdr_memberremark'] = $_POST['memberremark'];
			$insert_arr['pdr_addtime'] = time();
			$insert_arr['pdr_paystate'] = 0;
			
			$state = $predeposit_model->rechargeAdd($insert_arr);
			if($state) {
				if(intval($payment_info['payment_online']) === 0) {//下线支付方式
					showMessage(Language::get('predeposit_recharge_success'),'index.php?act=predeposit&op=rechargelist');
				}else {
					//使用在线支付时跳转到对应的网站
					$payment_orderinfo = array();
					$payment_orderinfo['order_sn']      = $insert_arr['pdr_sn'];
					$payment_orderinfo['order_desc']    = Language::get('predeposit_recharge_paydesc');
					$payment_orderinfo['order_amount']  = $price;
					$payment_orderinfo['discount']		= 0;
					$payment_orderinfo['modeltype']		= '3';//表示是预存款功能调用支付接口
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
				}
			} else {
				showMessage(Language::get('predeposit_recharge_fail'),'index.php?act=predeposit','html','error');
			}
		}else {
			//获取支付方式
			$payment_array = $this->getPayment(1);
			//去除预存款支付方式
			if (!empty($payment_array)){
				foreach ($payment_array as $k=>$v){
					if ($v['payment_code'] == 'predeposit'){
						unset($payment_array[$k]);
					}
				}
			}
			Tpl::output('payment_array',$payment_array);
			//信息输出
			self::profile_menu('recharge','rechargeadd');
			Tpl::output('menu_sign','predepositrecharge');
			Tpl::output('menu_sign_url','index.php?act=predeposit');
			Tpl::output('menu_sign1','predeposit_rechargeadd');
			Tpl::showpage('member_predeposit');
		}
	}
	/**
	 * 充值列表
	 */
	public function rechargelistOp(){
		$condition_arr = array();		
		$condition_arr['pdr_memberid'] 	= "{$_SESSION['member_id']}";
		//编号
		$condition_arr['pdr_sn_like'] 	= trim($_GET['sn_search']);
		//支付方式
		$condition_arr['pdr_payment'] 	= trim($_GET['payment_search']);
		//支付状态
		if (intval($_GET['paystate_search'])>0){
			$condition_arr['pdr_paystate'] 	= intval($_GET['paystate_search'])-1;
			$condition_arr['pdr_paystate'] = "{$condition_arr['pdr_paystate']}";
		}
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$predeposit_model = Model('predeposit');
		$recharge_list = $predeposit_model->getRechargeList($condition_arr,$page);
		//获取支付方式
		$payment_array = $this->getPayment();
		$payment_array_new = array();
		if (is_array($payment_array) && count($payment_array)>0){
			foreach ($payment_array as $k=>$v){
				if ($v['payment_code'] !='predeposit'){
					$payment_array_new[$v['payment_code']] = $v;
				}
			}
		}
		Tpl::output('payment_array',$payment_array_new);
		//信息输出
		self::profile_menu('recharge','rechargelist');
		Tpl::output('menu_sign','predepositrecharge');
		Tpl::output('menu_sign_url','index.php?act=predeposit');
		Tpl::output('menu_sign1','predeposit_rechargelist');
		Tpl::output('recharge_list',$recharge_list);
		Tpl::output('show_page',$page->show());
		Tpl::showpage('member_predeposit.list');
	}
	/**
	 * 删除充值记录
	 *
	 */
	public function rechargedelOp(){
		$pdr_id = intval($_GET["id"]);
		if ($pdr_id <= 0){
			showMessage(Language::get('predeposit_parameter_error'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdr_memberid'] 	= "{$_SESSION['member_id']}";
		$condition_arr['pdr_id'] = "$pdr_id";
		$condition_arr['pdr_paystate'] = '0';//未支付信息才能删除
		$result = $predeposit_model->rechargeDel($condition_arr);
		if ($result){
			showMessage(Language::get('predeposit_recharge_del_success'),'index.php?act=predeposit&op=rechargelist');
		}else {
			showMessage(Language::get('predeposit_recharge_del_fail'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
	}
	/**
	 * 充值记录详细 
	 */
	public function rechargeinfoOp(){
		$pdr_id = intval($_GET["id"]);
		if ($pdr_id <= 0){
			showMessage(Language::get('predeposit_parameter_error'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdr_memberid'] 	= "{$_SESSION['member_id']}";
		$condition_arr['pdr_id'] = "$pdr_id";
		$info = $predeposit_model->getRechargeRow($condition_arr);
		if (!is_array($info) || count($info)<0){
			showMessage(Language::get('predeposit_record_error'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
		//获取支付方式信息
		$goldpayment_model = Model('gold_payment');
		$payment_info = $goldpayment_model->getRowByCode($info['pdr_payment']);
		if (!is_array($payment_info) || count($payment_info)<=0){
			showMessage(Language::get('predeposit_recharge_payment_error'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
		Tpl::output('payment_info',$payment_info);
		//信息输出
		self::profile_menu('rechargeinfo','rechargeinfo');
		Tpl::output('menu_sign','predepositrecharge');
		Tpl::output('menu_sign_url','index.php?act=predeposit');
		Tpl::output('menu_sign1','predeposit_rechargeinfo');
		Tpl::output('info',$info);
		Tpl::showpage('member_predeposit.info');
	}
	/**
	 * 充值信息支付操作
	 */
	public function rechargepayOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			$id = intval($_POST['id']);
		}
		if ($id <= 0){
			showMessage(Language::get('predeposit_parameter_error'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdr_memberid'] 	= "{$_SESSION['member_id']}";
		$condition_arr['pdr_id'] = "$id";
		$condition_arr['pdr_paystate'] = "0";//未支付
		//查询充值信息
		$info = $predeposit_model->getRechargeRow($condition_arr);
		if (!is_array($info) || count($info)<0){
			showMessage(Language::get('predeposit_record_error'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
		//获取支付方式信息
		$goldpayment_model = Model('gold_payment');
		$payment_info = $goldpayment_model->getRowByCondition(array('payment_code','payment_state'),array($info['pdr_payment'],1));
		if (!is_array($payment_info) || count($payment_info)<=0){
			showMessage(Language::get('predeposit_recharge_payment_error'),'index.php?act=predeposit&op=rechargelist','html','error');
		}
		if ($_POST['form_submit'] == 'ok'){
			if ($info['pdr_payment'] == 'offline'){
				$obj_validate = new Validate();
				$validate_arr[] = array("input"=>$_POST["huikuan_name"],"require"=>"true","message"=>Language::get('predeposit_recharge_add_huikuannamenull_error'));
				$validate_arr[] = array("input"=>$_POST["huikuan_bank"],"require"=>"true","message"=>Language::get('predeposit_recharge_add_huikuanbanknull_error'));
				$validate_arr[] = array("input"=>$_POST["huikuan_date"],"require"=>"true","message"=>Language::get('predeposit_recharge_add_huikuandatenull_error'));
				$obj_validate -> validateparam = $validate_arr;
				$error = $obj_validate->validate();			
				if ($error != ''){
					showMessage($error,'','html','error');
				}
			}
			//保存
			$update_arr = array();
			if ($info['pdr_payment'] == 'offline'){
				$update_arr['pdr_remittancename'] = $_POST['huikuan_name'];
				$update_arr['pdr_remittancebank'] = $_POST['huikuan_bank'];
				$update_arr['pdr_remittancedate'] = strtotime($_POST['huikuan_date']);	
			}
			$update_arr['pdr_memberremark'] = $_POST['memberremark'];
			$predeposit_model->rechargeUpdate($condition_arr,$update_arr);
			//跳转页面
			if (intval($payment_info['payment_online']) === 0){
				showMessage(Language::get('predeposit_recharge_success'),'index.php?act=predeposit&op=rechargelist');
			}else {
				//使用在线支付时跳转到对应的网站
				$payment_orderinfo = array();
				$payment_orderinfo['order_sn']      = $info['pdr_sn'];
				$payment_orderinfo['order_desc']    = Language::get('predeposit_recharge_paydesc');
				$payment_orderinfo['order_amount']  = $info['pdr_price'];
				$payment_orderinfo['discount']		= 0;
				$payment_orderinfo['modeltype']		= '3';//表示是预存款功能调用支付接口
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
			}
		}else {
			$title = trim($_GET['title'])?trim($_GET['title']):Language::get('predeposit_recharge_pay');
			Tpl::output('title',$title);
			Tpl::output('info',$info);
			Tpl::output('payment_info',$payment_info);
			Tpl::showpage('member_predeposit.pay','null_layout');
		}
	}
	/**
	 * 得到支付方式列表
	 */
	private function getPayment($payment_state = '') {
		$model_payment = Model('gold_payment');
		//支付方式列表
		$condition = array();
		if($payment_state > 0) $condition['payment_state'] = '1';//可用的支付方式
		$payment_list = $model_payment->getList($condition);
		return $payment_list;
	}
	/**
	 * 预存款日志
	 */
	public function predepositlogOp(){
		$condition_arr = array();
		$condition_arr['pdlog_memberid'] = "{$_SESSION['member_id']}";
		if ($_GET['stage']){
			$condition_arr['pdlog_stage'] = $_GET['stage'];
		}
		/*if (intval($_GET['recordtype'])>0){
			$condition_arr['pdlog_type'] = intval($_GET['recordtype'])-1;
			$condition_arr['pdlog_type'] = "{$condition_arr['pdlog_type']}";
		}*/
		$condition_arr['pdlog_type'] = "0";//只搜索可用金额的日志
		$condition_arr['saddtime'] = strtotime($_GET['stime']);
		$condition_arr['eaddtime'] = strtotime($_GET['etime']);
        if($condition_arr['eaddtime'] > 0) {
            $condition_arr['eaddtime'] += 86400;
        }
		$condition_arr['pdlog_desc_like'] = $_GET['description'];
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询预存款日志列表
		$predeposit_model = Model('predeposit');
		$list_log = $predeposit_model->predepositLogList($condition_arr,$page,'*','');
		//查询用户信息
		$member_model = Model('member');
		$member_info = $member_model->infoMember(array('member_id'=>"{$_SESSION['member_id']}"));
		if (!is_array($member_info) || count($member_info)<=0){
			showMessage(Language::get('predeposit_userrecord_error'),'index.php?act=member_snsindex','html','error');			
		}
		//信息输出
		self::profile_menu('log','loglist');
		Tpl::output('menu_sign','predepositlog');
		Tpl::output('menu_sign_url','index.php?act=predeposit&op=predepositlog');
		Tpl::output('menu_sign1','predeposit_loglist');
		Tpl::output('show_page',$page->show());
		Tpl::output('list_log',$list_log);
		Tpl::output('member_info',$member_info);
		Tpl::showpage('member_predepositlog');	
	}
	/**
	 * 提现添加
	 */
	public function predepositcashOp(){
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["payment_sel"], "require"=>"true","message"=>Language::get('predeposit_cash_add_paymentnull_error'));
			$payment_sel = trim($_POST['payment_sel']);
			if ($payment_sel == 'offline'){
				$validate_arr[] = array("input"=>$_POST["shoukuan_name"],"require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuannamenull_error'));
				$validate_arr[] = array("input"=>$_POST["shoukuan_bank"],"require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuanbanknull_error'));
			}
			$price = floatval($_POST['price']);//提现金额
			$validate_arr[] = array("input"=>$_POST["price"], "require"=>"true",'validator'=>'Compare','operator'=>'>=',"to"=>'0.01',"message"=>Language::get('predeposit_cash_add_pricemin_error'));			
			$validate_arr[] = array("input"=>$_POST["account"], "require"=>"true","message"=>Language::get('predeposit_cash_add_shoukuanaccountnull_error'));
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();			
			if ($error != ''){
				showMessage($error,'','html','error');
			}
			//判断支付方式是否是预存款
			if ($payment_sel == 'predeposit'){
				showMessage(Language::get('predeposit_payment_error'),'index.php?act=predeposit&op=predepositcash','html','error');
			}
			//获取支付方式信息
			$goldpayment_model = Model('gold_payment');
			$payment_info = $goldpayment_model->getRowByCondition(array('payment_code','payment_state'),array($payment_sel,1));
			if (!is_array($payment_info) || count($payment_info)<=0){
				showMessage(Language::get('predeposit_payment_error'),'index.php?act=predeposit&op=predepositcash','html','error');
			}
			$predeposit_model = Model('predeposit');
			//验证金额是否足够
			if (!$predeposit_model->predepositDecreaseCheck($_SESSION['member_id'],$price)){
				showMessage(Language::get('predeposit_cash_shortprice_error'),'index.php?act=predeposit&op=predepositcash','html','error');
			}
			$insert_arr = array();
			$insert_arr['pdcash_sn'] = $predeposit_model->cash_snOrder();
			$insert_arr['pdcash_memberid'] = $_SESSION['member_id'];
			$insert_arr['pdcash_membername'] = $_SESSION['member_name'];
			$insert_arr['pdcash_price'] = $price;
			$insert_arr['pdcash_payment'] = $payment_sel;
			$insert_arr['pdcash_paymentaccount'] = $_POST['account'];
			if ($payment_sel == 'offline'){
				$insert_arr['pdcash_toname'] = $_POST['shoukuan_name'];
				$insert_arr['pdcash_tobank'] = $_POST['shoukuan_bank'];
			}
			$insert_arr['pdcash_memberremark'] = $_POST['memberremark'];
			$insert_arr['pdcash_addtime'] = time();
			$insert_arr['pdcash_paystate'] = 0;
			$state = $predeposit_model->cashAdd($insert_arr);
			if($state) {
				//减少可用预存款
				$log_arr['memberid'] = $_SESSION['member_id'];
				$log_arr['membername'] = $_SESSION['member_name'];
				$log_arr['price'] = -$price;
				$log_arr['logtype'] = '0';
				$log_arr['desc'] = Language::get('predeposit_cash_availablereducedesc');
				$predeposit_model->savePredepositLog('cash',$log_arr);
				//增加冻结预存款金额
				$log_arr['price'] = $price;
				$log_arr['logtype'] = '1';
				$log_arr['desc'] = Language::get('predeposit_cash_freezeadddesc');
				$predeposit_model->savePredepositLog('cash',$log_arr);
				showMessage(Language::get('predeposit_cash_add_success'),'index.php?act=predeposit&op=cashlist');
			} else {
				showMessage(Language::get('predeposit_cash_add_fail'),'index.php?act=predeposit&op=predepositcash','html','error');
			}
		}else {
			//获取支付方式
			$payment_array = $this->getPayment(1);
			//去除预存款支付方式
			if (!empty($payment_array)){
				foreach ($payment_array as $k=>$v){
					if ($v['payment_code'] == 'predeposit'){
						unset($payment_array[$k]);
					}
				}
			}
			Tpl::output('payment_array',$payment_array);
			//查询会员信息
			$member_model = Model('member');
			$member_info = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']),'member_id,available_predeposit');
			Tpl::output('member_info',$member_info);
			//信息输出
			self::profile_menu('cash','cashadd');
			Tpl::output('menu_sign','predepositcash');
			Tpl::output('menu_sign_url','index.php?act=predeposit&op=predepositcash');
			Tpl::output('menu_sign1','predeposit_cashadd');
			Tpl::showpage('member_predepositcash');
		}
	}
	/**
	 * 提现列表
	 */
	public function cashlistOp(){
		$condition_arr = array();
		$condition_arr['pdcash_memberid'] 	= "{$_SESSION['member_id']}";
		//编号
		$condition_arr['pdcash_sn_like'] 	= trim($_GET['sn_search']);
		//支付方式
		$condition_arr['pdcash_payment'] 	= trim($_GET['payment_search']);
		//支付状态
		if (intval($_GET['paystate_search'])>0){
			$condition_arr['pdcash_paystate'] 	= intval($_GET['paystate_search'])-1;
			$condition_arr['pdcash_paystate'] = "{$condition_arr['pdcash_paystate']}";
		}
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$predeposit_model = Model('predeposit');
		$cash_list = $predeposit_model->getCashList($condition_arr,$page);
		//获取支付方式
		$payment_array = $this->getPayment();
		$payment_array_new = array();
		if (is_array($payment_array) && count($payment_array)>0){
			foreach ($payment_array as $k=>$v){
				if ($v['payment_code'] != 'predeposit'){
					$payment_array_new[$v['payment_code']] = $v;
				}
			}
		}
		Tpl::output('payment_array',$payment_array_new);
		//信息输出
		self::profile_menu('cash','cashlist');
		Tpl::output('menu_sign','predepositcash');
		Tpl::output('menu_sign_url','index.php?act=predeposit&op=predepositcash');
		Tpl::output('menu_sign1','predeposit_cashlist');
		Tpl::output('cash_list',$cash_list);
		Tpl::output('show_page',$page->show());
		Tpl::showpage('member_predepositcash.list');
	}
	/**
	 * 删除提现记录
	 */
	public function cashdelOp(){
		$pdcash_id = intval($_GET["id"]);
		if ($pdcash_id <= 0){
			showMessage(Language::get('predeposit_parameter_error'),'index.php?act=predeposit&op=cashlist','html','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdcash_memberid'] 	= "{$_SESSION['member_id']}";
		$condition_arr['pdcash_id'] = "$pdcash_id";
		$condition_arr['pdcash_paystate'] = '0';//未支付信息才能删除
		$result = $predeposit_model->cashDel($condition_arr);
		if ($result){
			showMessage(Language::get('predeposit_cash_del_success'),'index.php?act=predeposit&op=cashlist');
		}else {
			showMessage(Language::get('predeposit_cash_del_fail'),'index.php?act=predeposit&op=cashlist','html','error');
		}
	}
	/**
	 * 提现记录详细 
	 */
	public function cashinfoOp(){
		$pdcash_id = intval($_GET["id"]);
		if ($pdcash_id <= 0){
			showMessage(Language::get('predeposit_parameter_error'),'index.php?act=predeposit&op=cashlist','html','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdcash_memberid'] 	= "{$_SESSION['member_id']}";
		$condition_arr['pdcash_id'] = "$pdcash_id";
		$info = $predeposit_model->getCashRow($condition_arr);
		if (!is_array($info) || count($info)<0){
			showMessage(Language::get('predeposit_record_error'),'index.php?act=predeposit&op=cashlist','html','error');
		}
		//获取支付方式信息
		$goldpayment_model = Model('gold_payment');
		$payment_info = $goldpayment_model->getRowByCode($info['pdcash_payment']);
		if (!is_array($payment_info) || count($payment_info)<=0){
			showMessage(Language::get('predeposit_payment_error'),'index.php?act=predeposit&op=cashlist','html','error');
		}
		Tpl::output('payment_info',$payment_info);
		//信息输出
		self::profile_menu('cashinfo','cashinfo');
		Tpl::output('menu_sign','predepositcash');
		Tpl::output('menu_sign_url','index.php?act=predeposit&op=predepositcash');
		Tpl::output('menu_sign1','predeposit_cashinfo');
		Tpl::output('info',$info);
		Tpl::showpage('member_predepositcash.info');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key=''){
		$menu_array	= array();
		switch ($menu_type) {
			case 'recharge':
				$menu_array	= array(
					1=>array('menu_key'=>'rechargeadd','menu_name'=>Language::get('nc_member_path_predeposit_rechargeadd'),	'menu_url'=>'index.php?act=predeposit'),
					2=>array('menu_key'=>'rechargelist','menu_name'=>Language::get('nc_member_path_predeposit_rechargelist'),	'menu_url'=>'index.php?act=predeposit&op=rechargelist')
				);
				break;
			case 'rechargeinfo':
				$menu_array	= array(
					1=>array('menu_key'=>'rechargeadd','menu_name'=>Language::get('nc_member_path_predeposit_rechargeadd'),	'menu_url'=>'index.php?act=predeposit'),
					2=>array('menu_key'=>'rechargelist','menu_name'=>Language::get('nc_member_path_predeposit_rechargelist'),	'menu_url'=>'index.php?act=predeposit&op=rechargelist'),
					3=>array('menu_key'=>'rechargeinfo','menu_name'=>Language::get('nc_member_path_predeposit_rechargeinfo'),	'menu_url'=>'')
				);
				break;
			case 'log':
				$menu_array	= array(
					1=>array('menu_key'=>'loglist','menu_name'=>Language::get('nc_member_path_predeposit_loglist'),	'menu_url'=>'index.php?act=predeposit&op=predepositlog')
				);
				break;
			case 'cash':
				$menu_array	= array(
					1=>array('menu_key'=>'cashadd','menu_name'=>Language::get('nc_member_path_predeposit_cashadd'),	'menu_url'=>'index.php?act=predeposit&op=predepositcash'),
					2=>array('menu_key'=>'cashlist','menu_name'=>Language::get('nc_member_path_predeposit_cashlist'),	'menu_url'=>'index.php?act=predeposit&op=cashlist')
				);
				break;
			case 'cashinfo':
				$menu_array	= array(
					1=>array('menu_key'=>'cashadd','menu_name'=>Language::get('nc_member_path_predeposit_cashadd'),	'menu_url'=>'index.php?act=predeposit&op=predepositcash'),
					2=>array('menu_key'=>'cashlist','menu_name'=>Language::get('nc_member_path_predeposit_cashlist'),	'menu_url'=>'index.php?act=predeposit&op=cashlist'),
					3=>array('menu_key'=>'cashinfo','menu_name'=>Language::get('nc_member_path_predeposit_cashinfo'),	'menu_url'=>'')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
