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
class predepositControl extends SystemControl{
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('predeposit');
		/**
		 * 判断系统是否开启预存款功能
		 */
		if ($GLOBALS['setting_config']['predeposit_isuse'] != 1){
			showMessage(Language::get('admin_predeposit_unavailable'),'index.php?act=dashboard&op=welcome','','error');
		}
		//充值记录状态数组
		$rechargestate = array(0=>Language::get('admin_predeposit_rechargestate_auditing'),1=>Language::get('admin_predeposit_rechargestate_completed'),2=>Language::get('admin_predeposit_rechargestate_closed'));
		//充值记录支付状态数组
		$rechargepaystate = array(0=>Language::get('admin_predeposit_rechargewaitpaying'),1=>Language::get('admin_predeposit_rechargepaysuccess'));
		Tpl::output('rechargestate',$rechargestate);
		Tpl::output('rechargepaystate',$rechargepaystate);
		//提现记录状态数组
//		$cashstate = array(0=>Language::get('admin_predeposit_cashstate_auditing'),1=>Language::get('admin_predeposit_cashstate_completed'),2=>Language::get('admin_predeposit_cashstate_closed'));
		//提现记录支付状态数组
		$cashpaystate = array(0=>Language::get('admin_predeposit_cashwaitpaying'),1=>Language::get('admin_predeposit_cashpaysuccess'));
//		Tpl::output('cashstate',$cashstate);
		Tpl::output('cashpaystate',$cashpaystate);
	}
	/**
	 * 充值列表
	 */
	public function predepositOp(){
//		$condition_arr = array();
//		//会员名称
////		$condition_arr['pdr_membername_like'] 	= trim($_GET['mname']);
//		//支付方式
//		$condition_arr['pdr_payment'] 	= trim($_GET['payment_search']);
//		//支付状态
//		if (intval($_GET['paystate_search'])>0){
//			$condition_arr['pdr_paystate'] 	= intval($_GET['paystate_search'])-1;
//			$condition_arr['pdr_paystate'] = "{$condition_arr['pdr_paystate']}";
//		}
//		//汇款人姓名
//		$condition_arr['pdr_remittancename_like'] 	= trim($_GET['huikuan_name']);
//		//汇款银行
//		$condition_arr['pdr_remittancebank_like'] 	= trim($_GET['huikuan_bank']);
//		//创建时间
//		$condition_arr['saddtime'] = strtotime($_GET['stime']);
//		$condition_arr['eaddtime'] = strtotime($_GET['etime']);
//        if($condition_arr['eaddtime'] > 0) {
//            $condition_arr['eaddtime'] += 86400;
//        }

        $condition = array();
		if(!empty($_GET['stime'])){
			$time1	= strtotime($_GET['stime']);
		}
		if(!empty($_GET['etime'])){
			$time2	= strtotime($_GET['etime']);
			if($time2 !== false) $time2 = $time2 + 86400;
		}
		if ($time1 && $time2){
			$condition['pdr_addtime'] = array('between',array($time1,$time2));
		}elseif($time1){
			$condition['pdr_addtime'] = array('egt',$time1);
		}elseif($time2){
			$condition['pdr_addtime'] = array('elt',$time2);
		}        
        if (!empty($_GET['mname'])){
        	$condition['pdr_membername'] = array('like','%'.($_GET['mname']).'%');
        }
        if (!empty($_GET['huikuan_name'])){
        	$condition['pdr_remittancename'] = array('like','%'.$_GET['huikuan_name'].'%');
        }
        if (!empty($_GET['huikuan_bank'])){
        	$condition['pdr_remittancebank'] = array('like','%'.$_GET['huikuan_bank'].'%');
        }
		if (!empty($_GET['payment_search'])){
			$condition['pdr_payment'] = $_GET['payment_search'];
		}
		if ($_GET['paystate_search'] != ''){
			$condition['pdr_paystate'] = $_GET['paystate_search'];
		}
		$model = Model();
		$recharge_list = $model->table('predeposit_recharge')->where($condition)->order('pdr_id desc')->page(10)->select();
		//分页
//		$page	= new Page();
//		$page->setEachNum(10);
//		$page->setStyle('admin');
//		
//		$predeposit_model = Model('predeposit');
//		$recharge_list = $predeposit_model->getRechargeList($condition_arr,$page);
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
		Tpl::output('recharge_list',$recharge_list);
		Tpl::output('show_page',$model->showpage());
		Tpl::showpage('predeposit.list');
	}
	/**
	 * 充值编辑
	 */
	public function rechargeeditOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			$id = intval($_POST['id']);
		}
		if ($id <= 0){
			showMessage(Language::get('admin_predeposit_parameter_error'),'index.php?act=predeposit&op=predeposit','','error');
		}		
		//查询充值信息
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdr_id'] = "$id";
		$info = $predeposit_model->getRechargeRow($condition_arr);
		if (!is_array($info) || count($info)<0){
			showMessage(Language::get('admin_predeposit_record_error'),'index.php?act=predeposit&op=predeposit','','error');
		}
		//获取支付方式信息
		$goldpayment_model = Model('gold_payment');
		$payment_info = $goldpayment_model->getRowByCode($info['pdr_payment']);
		if (!is_array($payment_info) || count($payment_info)<=0){
			showMessage(Language::get('admin_predeposit_payment_error'),'index.php?act=predeposit&op=predeposit','','error');
		}
		if ($_POST['form_submit'] == 'ok'){
			//保存
			$update_arr = array();
			//支付状态
			//支付方式为线下支付例如线下支付和预存款支付,只有线下支付方式可以修改支付状态，通过线上接口的充值信息不可以修改支付状态
			if (intval($payment_info['payment_online']) === 0){//此处可以再详细区分不同的线下支付方式，执行不同的操作
				if (intval($_POST['paystate']) != intval($info['pdr_paystate']) && intval($_POST['paystate']) === 0 && !$predeposit_model->predepositDecreaseCheck($info['pdr_memberid'],$info['pdr_price'])){
					showMessage(Language::get('admin_predeposit_shortprice_error'),'index.php?act=predeposit&op=predeposit','','error');
				}
				$update_arr['pdr_paystate'] = intval($_POST['paystate']);
			}
			//管理员备注
			$update_arr['pdr_adminremark'] = trim($_POST['admin_remark']);
			//管理员信息
			$admininfo = $this->getAdminInfo();			
			$update_arr['pdr_adminid'] = $admininfo['id'];
			$update_arr['pdr_adminname'] = $admininfo['name'];
			$result = $predeposit_model->rechargeUpdate($condition_arr,$update_arr);
			if ($result){
				//线下类型的支付方式修改用户预存款
				if (intval($payment_info['payment_online']) === 0 && intval($_POST['paystate']) != intval($info['pdr_paystate'])){//避免重复增加预存款
					$log_arr['memberid'] = $info['pdr_memberid'];
					$log_arr['membername'] = $info['pdr_membername'];
					$log_arr['adminid'] = $admininfo['id'];
					$log_arr['adminname'] = $admininfo['name'];
					$log_arr['logtype'] = '0';
					if (intval($_POST['paystate']) == 1){//增加预存款
						$log_arr['price'] = $info['pdr_price'];
						$predeposit_model->savePredepositLog('recharge',$log_arr);
					}else {//减少预存款
						$log_arr['price'] = -$info['pdr_price'];
						$log_arr['desc'] = Language::get('admin_predeposit_recharge_edit_logdesc'); //'会员充值支付状态修改减少预存款';
						$predeposit_model->savePredepositLog('recharge',$log_arr);
					}
				}
				showMessage(Language::get('admin_predeposit_recharge_edit_success'),'index.php?act=predeposit&op=predeposit');
			} else {
				showMessage(Language::get('admin_predeposit_recharge_edit_fail'),'index.php?act=predeposit&op=predeposit','','error');
			}
		}else {
			Tpl::output('payment_info',$payment_info);
			Tpl::output('info',$info);
			Tpl::showpage('predeposit.edit');
		}
	}
	/**
	 * 充值查看
	 */
	public function rechargeinfoOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showMessage(Language::get('admin_predeposit_parameter_error'),'index.php?act=predeposit&op=predeposit','','error');
		}
		//查询充值信息
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdr_id'] = "$id";
		$info = $predeposit_model->getRechargeRow($condition_arr);
		if (!is_array($info) || count($info)<0){
			showMessage(Language::get('admin_predeposit_record_error'),'index.php?act=predeposit&op=predeposit','','error');
		}
		//获取支付方式信息
		$goldpayment_model = Model('gold_payment');
		$payment_info = $goldpayment_model->getRowByCode($info['pdr_payment']);
		if (!is_array($payment_info) || count($payment_info)<=0){
			showMessage(Language::get('admin_predeposit_payment_error'),'index.php?act=predeposit&op=predeposit','','error');
		}
		Tpl::output('payment_info',$payment_info);
		Tpl::output('info',$info);
		Tpl::showpage('predeposit.info');
	
	}
	/**
	 * 充值删除
	 */
	public function rechargedelOp(){
		$pdr_id = intval($_GET["id"]);
		if ($pdr_id <= 0){
			showMessage(Language::get('admin_predeposit_parameter_error'),'index.php?act=predeposit&op=predeposit','','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();
		$condition_arr['pdr_id'] = "$pdr_id";
		$condition_arr['pdr_paystate'] = '0';//未支付信息才能删除
		$result = $predeposit_model->rechargeDel($condition_arr);
		if ($result){
			showMessage(Language::get('admin_predeposit_recharge_del_success'),'index.php?act=predeposit&op=predeposit');
		}else {
			showMessage(Language::get('admin_predeposit_recharge_del_fail'),'index.php?act=predeposit&op=predeposit','','error');
		}
	}
	/**
	 * 预存款日志
	 */
	public function predepositlogOp(){
		$condition_arr = array();
		$condition_arr['pdlog_membername_like'] = trim($_GET['mname']);
		$condition_arr['pdlog_adminname_like'] = trim($_GET['aname']);
		if ($_GET['stage']){
			$condition_arr['pdlog_stage'] = trim($_GET['stage']);
		}
		if (intval($_GET['recordtype'])>0){
			$condition_arr['pdlog_type'] = intval($_GET['recordtype'])-1;
			$condition_arr['pdlog_type'] = "{$condition_arr['pdlog_type']}";
		}
		$condition_arr['saddtime'] = strtotime($_GET['stime']);
		$condition_arr['eaddtime'] = strtotime($_GET['etime']);
        if($condition_arr['eaddtime'] > 0) {
            $condition_arr['eaddtime'] += 86400;
        }
		$condition_arr['pdlog_desc_like'] = trim($_GET['description']);
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询预存款日志列表
		$predeposit_model = Model('predeposit');
		$list_log = $predeposit_model->predepositLogList($condition_arr,$page,'*','');
		//信息输出
		Tpl::output('show_page',$page->show());
		Tpl::output('list_log',$list_log);
		Tpl::showpage('predepositlog');
	}
	/**
	 * 提现列表
	 */
	public function cashlistOp(){
//		$condition_arr = array();
//		//会员名称
//		$condition_arr['pdcash_membername_like'] 	= trim($_GET['mname']);
//		//支付方式
//		$condition_arr['pdcash_payment'] 	= trim($_GET['payment_search']);
//		//支付状态
//		if (intval($_GET['paystate_search'])>0){
//			$condition_arr['pdcash_paystate'] 	= intval($_GET['paystate_search'])-1;
//			$condition_arr['pdcash_paystate'] = "{$condition_arr['pdcash_paystate']}";
//		}
//		//收款人姓名
//		$condition_arr['pdcash_toname_like'] 	= trim($_GET['shoukuan_name']);
//		//收款银行
//		$condition_arr['pdcash_tobank_like'] 	= trim($_GET['shoukuan_bank']);
//		//创建时间
//		$condition_arr['saddtime'] = strtotime($_GET['stime']);
//		$condition_arr['eaddtime'] = strtotime($_GET['etime']);
//        if($condition_arr['eaddtime'] > 0) {
//            $condition_arr['eaddtime'] += 86400;
//        }

		$condition = array();
		if (!empty($_GET['mname'])){
			$condition['pdcash_membername'] = array('like',"%{$_GET['mname']}%");
		}
		if (!empty($_GET['shoukuan_name'])){
			$condition[' pdcash_toname'] = array('like',"%{$_GET['shoukuan_name']}%");
		}
		if(!empty($_GET['stime'])){
			$time1	= strtotime($_GET['stime']);
		}
		if(!empty($_GET['etime'])){
			$time2	= strtotime($_GET['etime']);
			if($time2 !== false) $time2 = $time2 + 86400;
		}
		if ($time1 && $time2){
			$condition['pdcash_addtime'] = array('between',array($time1,$time2));
		}elseif($time1){
			$condition['pdcash_addtime'] = array('egt',$time1);
		}elseif($time2){
			$condition['pdcash_addtime'] = array('elt',$time2);
		}
		if (!empty($_GET['payment_search'])){
			$condition['pdcash_payment'] 	= $_GET['payment_search'];
		}
		if ($_GET['paystate_search'] != ''){
			$condition['pdcash_paystate'] = $_GET['paystate_search'];
		}
//		if ($_GET['state_search'] != ''){
//			$condition['pdcash_state'] = $_GET['state_search'];
//		}
		$model = Model();
		$cash_list = $model->table('predeposit_cash')->where($condition)->order('pdcash_id desc')->page(10)->select();
//		分页
//		$page	= new Page();
//		$page->setEachNum(10);
//		$page->setStyle('admin');
//		
//		$predeposit_model = Model('predeposit');
//		$cash_list = $predeposit_model->getCashList($condition_arr,$page);
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
		Tpl::output('cash_list',$cash_list);
		Tpl::output('show_page',$model->showpage());
		Tpl::showpage('predepositcash.list');
	}
	/**
	 * 删除提现记录
	 */
	public function cashdelOp(){
		$pdcash_id = intval($_GET["id"]);
		if ($pdcash_id <= 0){
			showMessage(Language::get('admin_predeposit_parameter_error'),'index.php?act=predeposit&op=cashlist','','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();
		$condition_arr['pdcash_id'] = "$pdcash_id";
		$condition_arr['pdcash_paystate'] = '0';//未支付信息才能删除
		
		$result = $predeposit_model->cashDel($condition_arr);
		if ($result){
			showMessage(Language::get('admin_predeposit_cash_del_success'),'index.php?act=predeposit&op=cashlist');
		}else {
			showMessage(Language::get('admin_predeposit_cash_del_fail'),'index.php?act=predeposit&op=cashlist','','error');
		}
	}
	/**
	 * 提现记录详细 
	 */
	public function cashinfoOp(){
		$pdcash_id = intval($_GET["id"]);
		if ($pdcash_id <= 0){
			showMessage(Language::get('admin_predeposit_parameter_error'),'index.php?act=predeposit&op=cashlist','','error');
		}
		$predeposit_model = Model('predeposit');
		$condition_arr = array();
		$condition_arr['pdcash_id'] = "$pdcash_id";
		$info = $predeposit_model->getCashRow($condition_arr);
		if (!is_array($info) || count($info)<0){
			showMessage(Language::get('admin_predeposit_record_error'),'index.php?act=predeposit&op=cashlist','','error');
		}
		//获取支付方式信息
		$goldpayment_model = Model('gold_payment');
		$payment_info = $goldpayment_model->getRowByCode($info['pdcash_payment']);
		if (!is_array($payment_info) || count($payment_info)<=0){
			showMessage(Language::get('admin_predeposit_payment_error'),'index.php?act=predeposit&op=cashlist','','error');
		}
		Tpl::output('payment_info',$payment_info);
		//信息输出
		Tpl::output('info',$info);
		Tpl::showpage('predepositcash.info');
	}
	/**
	 * 提现编辑
	 */
	public function casheditOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			$id = intval($_POST['id']);
		}
		if ($id <= 0){
			showMessage(Language::get('admin_predeposit_parameter_error'),'index.php?act=predeposit&op=cashlist','','error');
		}		
		//查询充值信息
		$predeposit_model = Model('predeposit');
		$condition_arr = array();		
		$condition_arr['pdcash_id'] = "$id";
		$info = $predeposit_model->getCashRow($condition_arr);
		if (!is_array($info) || count($info)<0){
			showMessage(Language::get('admin_predeposit_record_error'),'index.php?act=predeposit&op=cashlist','','error');
		}
		//获取支付方式信息
		$goldpayment_model = Model('gold_payment');
		$payment_info = $goldpayment_model->getRowByCode($info['pdcash_payment']);
		if (!is_array($payment_info) || count($payment_info)<=0){
			showMessage(Language::get('admin_predeposit_payment_error'),'index.php?act=predeposit&op=cashlist','','error');
		}
		if ($_POST['form_submit'] == 'ok'){
			//保存
			$update_arr = array();
			//支付状态
			if (intval($_POST['paystate']) != intval($info['pdcash_paystate']) && intval($_POST['paystate']) === 1 && !$predeposit_model->predepositDecreaseCheck($info['pdcash_memberid'],$info['pdcash_price'],1)){
				showMessage(Language::get('admin_predeposit_shortprice_error'),'index.php?act=predeposit&op=cashlist','','error');
			}
			$update_arr['pdcash_paystate'] = intval($_POST['paystate']);
			//管理员备注
			$update_arr['pdcash_adminremark'] = $_POST['admin_remark'];
			//备注
			$update_arr['pdcash_remark'] = trim($_POST['remark']);
			//管理员信息
			$admininfo = $this->getAdminInfo();			
			$update_arr['pdcash_adminid'] = $admininfo['id'];
			$update_arr['pdcash_adminname'] = $admininfo['name'];
			$result = $predeposit_model->cashUpdate($condition_arr,$update_arr);
			if ($result){
				//修改用户冻结预存款金额
				if (intval($_POST['paystate']) != intval($info['pdcash_paystate'])){//避免重复减少冻结预存款
					$log_arr['memberid'] = $info['pdcash_memberid'];
					$log_arr['membername'] = $info['pdcash_membername'];
					$log_arr['adminid'] = $admininfo['id'];
					$log_arr['adminname'] = $admininfo['name'];
					$log_arr['logtype'] = '1';
					if (intval($_POST['paystate']) == 1){//减少冻结预存款金额
						$log_arr['price'] = -$info['pdcash_price'];
						$log_arr['desc'] = Language::get('admin_predeposit_cash_edit_reducefreezelogdesc');
						$predeposit_model->savePredepositLog('cash',$log_arr);
					}else {//减少预存款
						$log_arr['price'] = $info['pdcash_price'];
						$log_arr['desc'] = Language::get('admin_predeposit_cash_edit_addfreezelogdesc');
						$predeposit_model->savePredepositLog('cash',$log_arr);
					}
				}
				showMessage(Language::get('admin_predeposit_cash_edit_success'),'index.php?act=predeposit&op=cashlist');
			} else {
				showMessage(Language::get('admin_predeposit_cash_edit_fail'),'index.php?act=predeposit&op=cashlist','','error');
			}
		}else {
			Tpl::output('payment_info',$payment_info);
			Tpl::output('info',$info);
			Tpl::showpage('predepositcash.edit');
		}
	}
	/**
	 * 手动添加
	 */
	public function artificialOp(){
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["member_id"], "require"=>"true", "message"=>Language::get('admin_predeposit_artificial_membername_error')),
				array("input"=>$_POST["price"], "require"=>"true",'validator'=>'Compare','operator'=>' >= ','to'=>1,"message"=>Language::get('admin_predeposit_artificial_pricemin_error'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error,'','','error');
			}
			//查询会员信息
			$obj_member = Model('member');
			$member_info = $obj_member->infoMember(array('member_id'=>$_POST['member_id']));
			if (!is_array($member_info) || count($member_info)<=0){
				showMessage(Language::get('admin_predeposit_userrecord_error'),'index.php?act=predeposit&op=artificial','','error');
			}
			$predeposit_model = Model('predeposit');
			$price = floatval($_POST['price']);//金额
			$pricetype = intval($_POST['pricetype'])-1;//预存款类型
			if ($_POST['operatetype'] == 2 && !$predeposit_model->predepositDecreaseCheck($_POST['member_id'],$price,$pricetype)){
				if ($pricetype == 1){
					showMessage(Language::get('admin_predeposit_artificial_shortfreezeprice_error').$member_info['freeze_predeposit'],'index.php?act=predeposit&op=artificial','','error');
				}else {
					showMessage(Language::get('admin_predeposit_artificial_shortprice_error').$member_info['available_predeposit'],'index.php?act=predeposit&op=artificial','','error');
				}
			}
			$log_arr['memberid'] = $member_info['member_id'];
			$log_arr['membername'] = $member_info['member_name'];
			$admininfo = $this->getAdminInfo();
			$log_arr['adminid'] = $admininfo['id'];
			$log_arr['adminname'] = $admininfo['name'];
			$log_arr['logtype'] = $pricetype;
			if ($_POST['operatetype'] == 2){
				$log_arr['price'] = -$price;
			}else {
				$log_arr['price'] = $price;
			}
			if ($_POST['remark']){
				$log_arr['desc'] = trim($_POST['remark']);	
			} else {
				$log_arr['desc'] = Language::get('predepositadmindesc');
			}
			$result = $predeposit_model->savePredepositLog('admin',$log_arr);
			if ($result){
				showMessage(Language::get('admin_predeposit_artificial_success'),'index.php?act=predeposit&op=predepositlog');
			}else {
				showMessage(Language::get('admin_predeposit_artificial_fail'),'index.php?act=predeposit&op=artificial','','error');
			}
		}else {
			Tpl::showpage('predepositartificial');
		}
	}
	/**
	 * 验证会员合法性
	 */
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
			echo json_encode(array('id'=>$member_info['member_id'],'name'=>$member_info['member_name'],'availableprice'=>$member_info['available_predeposit'],'freezeprice'=>$member_info['freeze_predeposit']));
		}else {
			echo ''; die;
		}
	}
	/**
	 * 得到支付方式列表
	 *
	 * @return
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
	 * 导出预存款充值记录
	 *
	 */
	public function export_step1Op(){
        $condition = array();
		if(!empty($_GET['stime'])){
			$time1	= strtotime($_GET['stime']);
		}
		if(!empty($_GET['etime'])){
			$time2	= strtotime($_GET['etime']);
			if($time2 !== false) $time2 = $time2 + 86400;
		}
		if ($time1 && $time2){
			$condition['pdr_addtime'] = array('between',array($time1,$time2));
		}elseif($time1){
			$condition['pdr_addtime'] = array('egt',$time1);
		}elseif($time2){
			$condition['pdr_addtime'] = array('elt',$time2);
		}
        if (!empty($_GET['mname'])){
        	$condition['pdr_membername'] = array('like','%'.($_GET['mname']).'%');
        }
        if (!empty($_GET['huikuan_name'])){
        	$condition['pdr_remittancename'] = array('like','%'.$_GET['huikuan_name'].'%');
        }
        if (!empty($_GET['huikuan_bank'])){
        	$condition['pdr_remittancebank'] = array('like','%'.$_GET['huikuan_bank'].'%');
        }
		if (!empty($_GET['payment_search'])){
			$condition['pdr_payment'] = $_GET['payment_search'];
		}
		if ($_GET['paystate_search'] != ''){
			$condition['pdr_paystate'] = $_GET['paystate_search'];
		}
		$model = Model();
		$recharge_list = $model->table('predeposit_recharge')->where($condition)->select();

		if (!is_numeric($_GET['curpage'])){		
			$count = $model->table('predeposit_recharge')->where($condition)->count();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('nc_member_predepositmanage'));
				Tpl::output('murl','index.php?act=predeposit&op=predeposit');				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$filed = 'pdr_sn,pdr_membername,pdr_price,pdr_payment,pdr_addtime,pdr_paystate,pdr_memberid';
				$data = $model->table('predeposit_recharge')->field($filed)->where($condition)->order('pdr_id desc')->limit(self::EXPORT_SIZE)->select();
				$payment_array = $this->getPayment();
				$payment_array_new = array();
				if (is_array($payment_array) && count($payment_array)>0){
					foreach ($payment_array as $k=>$v){
						if ($v['payment_code'] != 'predeposit'){
							$payment_array_new[$v['payment_code']] = $v;
						}
					}
				}
				$rechargepaystate = array(0=>Language::get('admin_predeposit_rechargewaitpaying'),1=>Language::get('admin_predeposit_rechargepaysuccess'));
				foreach ($data as $k=>$v) {
					$data[$k]['pdr_payment'] = $payment_array_new[$v['pdr_payment']]['payment_name'];
					$data[$k]['pdr_paystate'] = $rechargepaystate[$v['pdr_paystate']];
				}
				$this->createExcel($data);
			}
		}else{	//下载
			$filed = 'pdr_sn,pdr_membername,pdr_price,pdr_payment,pdr_addtime,pdr_paystate,pdr_memberid';
			$limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
			$limit2 = self::EXPORT_SIZE;
			$data = $model->table('predeposit_recharge')->field($filed)->where($condition)->order('pdr_id desc')->limit("{$limit1},{$limit2}")->select();
			$payment_array = $this->getPayment();
			$payment_array_new = array();
			if (is_array($payment_array) && count($payment_array)>0){
				foreach ($payment_array as $k=>$v){
					if ($v['payment_code'] != 'predeposit'){
						$payment_array_new[$v['payment_code']] = $v;
					}
				}
			}
			$rechargepaystate = array(0=>Language::get('admin_predeposit_rechargewaitpaying'),1=>Language::get('admin_predeposit_rechargepaysuccess'));
			foreach ($data as $k=>$v) {
				$data[$k]['pdr_payment'] = $payment_array_new[$v['pdr_payment']]['payment_name'];
				$data[$k]['pdr_paystate'] = $rechargepaystate[$v['pdr_paystate']];
			}			
			$this->createExcel($data);
		}
	}

	/**
	 * 生成导出预存款充值excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_yc_no'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_yc_member'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_yc_money'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_yc_pay'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_yc_ctime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_yc_paystate'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_yc_memberid'));
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['pdr_sn']);
			$tmp[] = array('data'=>$v['pdr_membername']);
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['pdr_price']));
			$tmp[] = array('data'=>$v['pdr_payment']);
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['pdr_addtime']));
			$tmp[] = array('data'=>$v['pdr_paystate']);
			$tmp[] = array('data'=>$v['pdr_memberid']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_yc_yckcz'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_yc_yckcz'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}

	/**
	 * 导出预存款提现记录
	 *
	 */
	public function export_cash_step1Op(){
		$condition = array();
		if (!empty($_GET['mname'])){
			$condition['pdcash_membername'] = array('like',"%{$_GET['mname']}%");
		}
		if (!empty($_GET['shoukuan_name'])){
			$condition[' pdcash_toname'] = array('like',"%{$_GET['shoukuan_name']}%");
		}
		if(!empty($_GET['stime'])){
			$time1	= strtotime($_GET['stime']);
		}
		if(!empty($_GET['etime'])){
			$time2	= strtotime($_GET['etime']);
			if($time2 !== false) $time2 = $time2 + 86400;
		}
		if ($time1 && $time2){
			$condition['pdcash_addtime'] = array('between',array($time1,$time2));
		}elseif($time1){
			$condition['pdcash_addtime'] = array('egt',$time1);
		}elseif($time2){
			$condition['pdcash_addtime'] = array('elt',$time2);
		}
		if (!empty($_GET['payment_search'])){
			$condition['pdcash_payment'] 	= $_GET['payment_search'];
		}
		if ($_GET['paystate_search'] != ''){
			$condition['pdcash_paystate'] = $_GET['paystate_search'];
		}
		$model = Model();
		$recharge_list = $model->table('predeposit_cash')->where($condition)->select();

		if (!is_numeric($_GET['curpage'])){		
			$count = $model->table('predeposit_cash')->where($condition)->count();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('nc_member_predepositmanage'));
				Tpl::output('murl','index.php?act=predeposit&op=cashlist');		
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$filed = 'pdcash_sn,pdcash_memberid,pdcash_membername,pdcash_price,pdcash_payment,pdcash_paymentaccount,pdcash_addtime,pdcash_paystate';
				$data = $model->table('predeposit_cash')->field($filed)->where($condition)->order('pdcash_id desc')->limit(self::EXPORT_SIZE)->select();
				$payment_array = $this->getPayment();
				$payment_array_new = array();
				if (is_array($payment_array) && count($payment_array)>0){
					foreach ($payment_array as $k=>$v){
						if ($v['payment_code'] != 'predeposit'){
							$payment_array_new[$v['payment_code']] = $v;
						}
					}
				}
				$cashpaystate = array(0=>Language::get('admin_predeposit_cashwaitpaying'),1=>Language::get('admin_predeposit_cashpaysuccess'));
				foreach ($data as $k=>$v) {
					$data[$k]['pdcash_payment'] = $payment_array_new[$v['pdcash_payment']]['payment_name'];
					$data[$k]['pdcash_paystate'] = $cashpaystate[$v['pdcash_paystate']];
				}
				$this->createCashExcel($data);
			}
		}else{	//下载
			$filed = 'pdcash_sn,pdcash_memberid,pdcash_membername,pdcash_price,pdcash_payment,pdcash_paymentaccount,pdcash_addtime,pdcash_paystate';
			$limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
			$limit2 = self::EXPORT_SIZE;
			$data = $model->table('predeposit_cash')->field($filed)->where($condition)->order('pdcash_id desc')->limit("{$limit1},{$limit2}")->select();
			$payment_array = $this->getPayment();
			$payment_array_new = array();
			if (is_array($payment_array) && count($payment_array)>0){
				foreach ($payment_array as $k=>$v){
					if ($v['payment_code'] != 'predeposit'){
						$payment_array_new[$v['payment_code']] = $v;
					}
				}
			}
			$cashpaystate = array(0=>Language::get('admin_predeposit_cashwaitpaying'),1=>Language::get('admin_predeposit_cashpaysuccess'));
			foreach ($data as $k=>$v) {
				$data[$k]['pdcash_payment'] = $payment_array_new[$v['pdcash_payment']]['payment_name'];
				$data[$k]['pdcash_paystate'] = $rechargepaystate[$v['pdcash_paystate']];
			}
			$this->createCashExcel($data);
		}
	}

	/**
	 * 生成导出预存款提现excel
	 *
	 * @param array $data
	 */
	private function createCashExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_tx_no'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_tx_member'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_tx_money'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_tx_type'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_tx_ctime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_tx_state'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_tx_memberid'));
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['pdcash_sn']);
			$tmp[] = array('data'=>$v['pdcash_membername']);
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['pdcash_price']));
			$tmp[] = array('data'=>$v['pdcash_payment']);
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['pdcash_addtime']));
			$tmp[] = array('data'=>$v['pdcash_paystate']);
			$tmp[] = array('data'=>$v['pdcash_memberid']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_tx_title'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_tx_title'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
	
	/**
	 * 预存款明细信息导出
	 */
	public function export_mx_step1Op(){
		$condition_arr = array();
		$condition_arr['pdlog_membername_like'] = trim($_GET['mname']);
		$condition_arr['pdlog_adminname_like'] = trim($_GET['aname']);
		if ($_GET['stage']){
			$condition_arr['pdlog_stage'] = trim($_GET['stage']);
		}
		if (intval($_GET['recordtype'])>0){
			$condition_arr['pdlog_type'] = intval($_GET['recordtype'])-1;
			$condition_arr['pdlog_type'] = "{$condition_arr['pdlog_type']}";
		}
		$condition_arr['saddtime'] = strtotime($_GET['stime']);
		$condition_arr['eaddtime'] = strtotime($_GET['etime']);
        if($condition_arr['eaddtime'] > 0) {
            $condition_arr['eaddtime'] += 86400;
        }
		$condition_arr['pdlog_desc_like'] = trim($_GET['description']);
		//分页
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$predeposit_model = Model('predeposit');
		$list_log = $predeposit_model->predepositLogList($condition_arr,$page,'*','');
		if (!is_numeric($_GET['curpage'])){		
			$count = $page->getTotalNum();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('nc_member_predepositlog'));
				Tpl::output('murl','index.php?act=predeposit&op=predepositlog');				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createmxExcel($list_log);
			}
		}else{	//下载
			$this->createmxExcel($list_log);
		}		
	}

	/**
	 * 导出预存款明细excel
	 *
	 * @param array $data
	 */
	private function createmxExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mx_member'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mx_ctime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mx_money'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mx_type'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mx_system'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mx_stype'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mx_mshu'));
		$state_cn = array(Language::get('admin_predeposit_log_stage_recharge'),Language::get('admin_predeposit_log_stage_cash'),Language::get('admin_predeposit_log_stage_order'),Language::get('admin_predeposit_log_stage_artificial'),Language::get('admin_predeposit_log_stage_system'));
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['pdlog_membername']);
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['pdlog_addtime']));
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['pdlog_price']));
			$tmp[] = array('data'=>$v['pdlog_type'] == 1?Language::get('admin_predeposit_pricetype_freeze'):Language::get('admin_predeposit_pricetype_available'));
			$tmp[] = array('data'=>$v['pdlog_adminname']);
			$tmp[] = array('data'=>str_replace(array('recharge','cash','order','admin','system'),$state_cn,$v['pdlog_stage']));
			$tmp[] = array('data'=>$v['pdlog_desc']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_mx_rz'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_mx_rz'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}		
}