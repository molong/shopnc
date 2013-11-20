<?php
/**
 * 金币购买管理
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
class gold_buyControl extends SystemControl{
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('gold_buy');
	}
	/**
	 * 购买记录
	 */
	public function gold_buyOp(){
		$condition	= array();
		if(trim($_GET['storename']) != ''){
			$condition['storename_like']	= trim($_GET['storename']);
		}
		if(trim($_GET['membername']) != ''){
			$condition['membername_like']	= trim($_GET['membername']);
		}
		if(trim($_GET['payment']) != ''){
			$condition['gbuy_check_type']	= trim($_GET['payment']);
		}
		if(trim($_GET['ispay']) != ''){
			$condition['gbuy_ispay']	= trim($_GET['ispay']);
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
		$condition['order'] = 'gbuy_ispay asc,gbuy_id desc';
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$payment_array = $this->getPayment_name();//支付方式列表
		Tpl::output('payment_array',$payment_array);

		$model_gbuy	= Model('gold_buy');
		$gbuy_list	= $model_gbuy->getList($condition,$page);

		Tpl::output('gbuy_list',$gbuy_list);
		Tpl::output('show_page',$page->show());
		Tpl::output('search',$_GET);
		Tpl::showpage('gold_buy.index');
	}
	/**
	 * 金币日志
	 */
	public function gold_logOp(){
		$condition	= array();
		if(trim($_GET['storename']) != ''){
			$condition['storename_like']	= trim($_GET['storename']);
		}
		if(trim($_GET['membername']) != ''){
			$condition['membername_like']	= trim($_GET['membername']);
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
		if(trim($_GET['method']) != ''){
			$condition['glog_method']	= $_GET['method'];
		}
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$model_log	= Model('gold_log');
		$glog_list	= $model_log->getList($condition,$page);
		
		Tpl::output('glog_list',$glog_list);
		Tpl::output('show_page',$page->show());
		Tpl::output('search',$_GET);
		Tpl::showpage('gold_log.index');
	}

	/**
	 * 编辑
	 */
	public function editOp(){
		/**
		 * 实例化金币购买模型
		 */
		$model_gbuy	= Model('gold_buy');
		
		$member_model = Model('member');
		
		/**
		 * 保存信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			$gbuy_id = intval($_POST["gbuy_id"]);
			$gbuy_ispay = intval($_POST["gbuy_ispay"]);
			$gbuy_num = intval($_POST["gbuy_num"]);
			$gold_buy = $model_gbuy->getRow($gbuy_id);
			$member_id = $gold_buy['gbuy_mid'];
			$condition = array();
			$condition['gbuy_id'] = $gbuy_id;
			$condition['gbuy_ispay'] = '0';
			$admin_info = $this->getAdminInfo();//取得当前管理员信息
			$gbuy_array = array();
			
			$gbuy_array['gbuy_num'] = $gbuy_num;//购买金币数量
			$gbuy_array['gbuy_adminid'] = $admin_info["id"];
			$gbuy_array['gbuy_sys_remark'] = trim($_POST["gbuy_sys_remark"]);
			if($gbuy_ispay == '1') {//收款完成
				$member_array = array();
				$member_array['member_goldnum'] = array('value'=>$gbuy_num,'sign'=>'increase');//当前数
				$member_array['member_goldnumcount'] = array('value'=>$gbuy_num,'sign'=>'increase');//总共充值数
				$state = $member_model->updateMember($member_array,$member_id);//更新会员的金币数
				if($state) {//成功更新后添加日志
					$model_glog	= Model('gold_log');
					$gold_log = array();
					$gold_log['glog_memberid'] = $gold_buy['gbuy_mid'];
					$gold_log['glog_membername'] = $gold_buy['gbuy_membername'];
					$gold_log['glog_storeid'] = $gold_buy['gbuy_storeid'];
					$gold_log['glog_storename'] = $gold_buy['gbuy_storename'];
					$gold_log['glog_adminid'] = $admin_info["id"];
					$gold_log['glog_adminname'] = $admin_info["name"];
					$gold_log['glog_method'] = '1';//金币增减方式 1增加 2减少
					$gold_log['glog_addtime'] = time();	
					$gold_log['glog_goldnum'] = $gbuy_num;	
					$gold_log['glog_stage'] = 'system';//操作阶段方式 system 表示系统操作 ztc 表示直通车阶段操作
					$gold_log['glog_desc'] = Language::get('gbuy_add_success');
					$model_glog->add($gold_log);//添加操作记录日志
				} else {//更新会员的金币数失败
					$gbuy_ispay = '0';//未支付状态
				}
			}
			$gbuy_array['gbuy_ispay'] = $gbuy_ispay;
			$model_gbuy->update($condition,$gbuy_array);//修改购买记录状态
			showMessage(Language::get('gbuy_edit_success'),'index.php?act=gold_buy&op=gold_buy');
		}
		$gbuy_id = intval($_GET["gbuy_id"]);
		if($gbuy_id > 0) {
			$gold_buy = $model_gbuy->getRow($gbuy_id);
			$member_array = $member_model->infoMember(array('member_id'=>$gold_buy['gbuy_mid']));//查询会员现有金币数
			Tpl::output('member_goldnum',$member_array['member_goldnum']);
			Tpl::output('gold_buy',$gold_buy);
		}
		Tpl::showpage('gold_buy.edit');
	}
	
	/**
	 * 删除金币购买记录
	 */
	public function delOp(){
		$gbuy_id = intval($_GET["gbuy_id"]);
		if($gbuy_id > 0) {
			/**
			 * 实例化金币购买模型
			 */
			$model_gbuy	= Model('gold_buy');
			$condition = array();
			$condition['gbuy_id'] = $gbuy_id;
			$condition['gbuy_ispay'] = '0';//未支付状态(支付完成的记录不能删除)
			$model_gbuy->del($condition);
		}
		showMessage(Language::get('gbuy_del_success'),'index.php?act=gold_buy&op=gold_buy');
	}
	/**
	 * 得到支付方式列表
	 *
	 * @return
	 */
	private function getPayment($payment_state = '') {
		/**
		 * 实例化支付方式模型
		 */
		$model_payment = Model('gold_payment');
		/**
		 * 支付方式列表
		 */
		$condition = array();
		if($payment_state > 0) $condition['payment_state'] = '1';//可用的支付方式
		$payment_list = $model_payment->getList($condition);
		return $payment_list;
	}
	/**
	 * 得到支付方式名称数组
	 *
	 * @return
	 */
	private function getPayment_name() {
		$payment_list = $this->getPayment();//支付方式列表
		$payment_array = array();
		foreach ($payment_list as $k => $v){
			$payment_code = $v['payment_code'];
			$payment_array[$payment_code] = $v['payment_name'];
		}
		return $payment_array;
	}
	
	/**
	 * 导出Excel
	 */
	public function export_step1Op(){
		$condition	= array();
		if(trim($_GET['storename']) != ''){
			$condition['storename_like']	= trim($_GET['storename']);
		}
		if(trim($_GET['membername']) != ''){
			$condition['membername_like']	= trim($_GET['membername']);
		}
		if(trim($_GET['payment']) != ''){
			$condition['gbuy_check_type']	= trim($_GET['payment']);
		}
		if(trim($_GET['ispay']) != ''){
			$condition['gbuy_ispay']	= trim($_GET['ispay']);
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
		$condition['order'] = 'gbuy_ispay asc,gbuy_id desc';
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$payment_array = $this->getPayment_name();//支付方式列表

		$model_gbuy	= Model('gold_buy');
		$gbuy_list	= $model_gbuy->getList($condition,$page);
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
				Tpl::output('download_lang',Language::get('nc_gold_buy'));
				Tpl::output('murl','index.php?act=gold_buy&op=gold_buy');
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($gbuy_list);
			}
		}else{	//下载
			$this->createExcel($gbuy_list);
		}
	}
	/**
	 * 生成excel
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
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_member'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_store'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_jbs'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_money'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_gtime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_paytype'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_paystate'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_storeid'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jbg_memberid'));
		
		$payment_array = $this->getPayment();
		$payment_array_new = array();
		if (is_array($payment_array) && count($payment_array)>0){
			foreach ($payment_array as $k=>$v){
				if ($v['payment_code'] != 'predeposit'){
					$payment_array_new[$v['payment_code']] = $v;
				}
			}
		}
		
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['gbuy_membername']);
			$tmp[] = array('data'=>$v['gbuy_storename']);
			$tmp[] = array('data'=>$v['gbuy_num']);
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['gbuy_price']));
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['gbuy_addtime']));
			$tmp[] = array('data'=>$payment_array_new[$v['gbuy_check_type']]['payment_name']);
			$tmp[] = array('data'=>str_replace(array(0,1),array(L('exp_jbg_wpay'),L('exp_jbg_ypay')),$v['gbuy_ispay']));
			$tmp[] = array('data'=>$v['gbuy_storeid']);
			$tmp[] = array('data'=>$v['gbuy_mid']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_jbg_jbgm'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_jbg_jbgm'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
	
	/**
	 * 
	 */
	public function export_log_step1Op(){
		$condition	= array();
		if(trim($_GET['storename']) != ''){
			$condition['storename_like']	= trim($_GET['storename']);
		}
		if(trim($_GET['membername']) != ''){
			$condition['membername_like']	= trim($_GET['membername']);
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
		if(trim($_GET['method']) != ''){
			$condition['glog_method']	= $_GET['method'];
		}
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE );

		$model_log	= Model('gold_log');
		$glog_list	= $model_log->getList($condition,$page);
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
				Tpl::output('download_lang',Language::get('nc_gold_buy'));
				Tpl::output('murl','index.php?act=gold_buy&op=gold_log');
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createLogExcel($glog_list);
			}
		}else{	//下载
			$this->createLogExcel($glog_list);
		}
	}

	/**
	 * 生成excel，导出金币日志
	 *
	 * @param array $data
	 */
	private function createLogExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_member'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_store'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_jbs'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_type'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_btime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_mshu'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_storeid'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_jb_memberid'));
		
		$payment_array = $this->getPayment();
		$payment_array_new = array();
		if (is_array($payment_array) && count($payment_array)>0){
			foreach ($payment_array as $k=>$v){
				if ($v['payment_code'] != 'predeposit'){
					$payment_array_new[$v['payment_code']] = $v;
				}
			}
		}
		
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['glog_membername']);
			$tmp[] = array('data'=>$v['glog_storename']);
			$tmp[] = array('data'=>$v['glog_goldnum']);
			$tmp[] = array('data'=>str_replace(array(1,2),array(L('exp_jb_add'),L('exp_jb_del')),$v['glog_method']));
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['glog_addtime']));
			$tmp[] = array('data'=>$v['glog_desc']);
			$tmp[] = array('data'=>$v['glog_storeid']);
			$tmp[] = array('data'=>$v['glog_memberid']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_jb_log'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_jb_log'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}
