<?php
/**
 * 代金券管理
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class voucherControl extends SystemControl{    
    const SECONDS_OF_30DAY = 2592000;
    private $applystate_arr;
    private $quotastate_arr;
    private $templatestate_arr;
    
	public function __construct(){
		parent::__construct();
		Language::read('voucher');
		if (C('voucher_allow') != 1 || C('gold_isuse') != 1 || C('points_isuse')!=1){
			showMessage(Language::get('admin_voucher_unavailable'),'index.php?act=dashboard&op=welcome');
		}
		$this->applystate_arr = array('new'=>array(1,Language::get('admin_voucher_applystate_new')),'verify'=>array(2,Language::get('admin_voucher_applystate_verify')),'cancel'=>array(3,Language::get('admin_voucher_applystate_cancel')));
		$this->quotastate_arr = array('activity'=>array(1,Language::get('admin_voucher_quotastate_activity')),'cancel'=>array(2,Language::get('admin_voucher_quotastate_cancel')),'expire'=>array(3,Language::get('admin_voucher_quotastate_expire')));
		//代金券模板状态
		$this->templatestate_arr = array('usable'=>array(1,Language::get('admin_voucher_templatestate_usable')),'disabled'=>array(2,Language::get('admin_voucher_templatestate_disabled')));
		Tpl::output('applystate_arr',$this->applystate_arr);
		Tpl::output('quotastate_arr',$this->quotastate_arr);
		Tpl::output('templatestate_arr',$this->templatestate_arr);
	}
    /*
	 * 默认操作列出代金券
	 */
	public function indexOp(){
        $this->applylistOp();
    }
    /**
     * 代金券设置
     */
    public function settingOp(){
    	$setting_model = Model('setting');
    	if (chksubmit()){
    		$obj_validate = new Validate();
			$validate_arr[] = array('input'=>$_POST['promotion_voucher_price'],'require'=>'true','validator'=>'IntegerPositive','message'=>Language::get('admin_voucher_setting_price_error'));
			$validate_arr[] = array('input'=>$_POST['promotion_voucher_storetimes_limit'],'require'=>'true','validator'=>'IntegerPositive','message'=>Language::get('admin_voucher_setting_storetimes_error'));
			$validate_arr[] = array('input'=>$_POST['promotion_voucher_buyertimes_limit'],'require'=>'true','validator'=>'IntegerPositive','message'=>Language::get('admin_voucher_setting_buyertimes_error'));
			
			$obj_validate->validateparam = $validate_arr;
			$error = $obj_validate->validate();			
			if ($error != ''){
				showMessage(Language::get('error').$error,'','','error');
			}
    		//每月代金劵软件服务单价
	    	$promotion_voucher_price = intval($_POST['promotion_voucher_price']);
	        if($promotion_voucher_price < 0) {
	            $promotion_voucher_price = 20;
	        }
	        //每月店铺可以发布的代金劵数量
	        $promotion_voucher_storetimes_limit = intval($_POST['promotion_voucher_storetimes_limit']);
	        if($promotion_voucher_storetimes_limit <= 0) {
	            $promotion_voucher_storetimes_limit = 20;
	        }
	        //买家可以领取的代金劵总数
	        $promotion_voucher_buyertimes_limit = intval($_POST['promotion_voucher_buyertimes_limit']);
	        if($promotion_voucher_buyertimes_limit <= 0) {
	            $promotion_voucher_buyertimes_limit = 5;
	        }
	        $update_array = array();
	        $update_array['promotion_voucher_price'] = $promotion_voucher_price;
	        $update_array['promotion_voucher_storetimes_limit'] = $promotion_voucher_storetimes_limit;
	        $update_array['promotion_voucher_buyertimes_limit'] = $promotion_voucher_buyertimes_limit;	        
	        $result = $setting_model->updateSetting($update_array);
	        if ($result){
	            showMessage(Language::get('nc_common_save_succ'),'');
	        }else {
	            showMessage(Language::get('nc_common_save_fail'),'');
	        }
    	} else {
    		$setting = $setting_model->GetListSetting();
    		$this->show_menu('voucher','setting');
	        Tpl::output('setting',$setting);
	        Tpl::showpage('voucher.setting');
    	}
    }
	/*
	 * 代金券面额列表
	 */
	public function pricelistOp(){
		//获得代金券金额列表 
		$model = Model();
		$voucherprice_list = $model->table('voucher_price')->order('voucher_price asc')->page(10)->select();
		Tpl::output('list', $voucherprice_list) ;
		Tpl::output('show_page',$model->showpage(2));
		$this->show_menu('voucher','pricelist');
		Tpl::showpage('voucher.pricelist');
	}
    /*
	 * 添加代金券面额页面 
	 */
	public function priceaddOp(){
		if (chksubmit()){
			$obj_validate = new Validate();
			$validate_arr[] = array('input'=>$_POST['voucher_price'],'require'=>'true','validator'=>'IntegerPositive','message'=>Language::get('admin_voucher_price_error'));
			$validate_arr[] = array('input'=>$_POST['voucher_price_describe'],'require'=>'true','message'=>Language::get('admin_voucher_price_describe_error'));
			$validate_arr[] = array('input'=>$_POST['voucher_points'],'require'=>'true','validator'=>'IntegerPositive','message'=>Language::get('admin_voucher_price_points_error'));
			$obj_validate->validateparam = $validate_arr;
			$error = $obj_validate->validate();
			//验证面额是否存在
			$voucher_price = intval($_POST['voucher_price']);
			$voucher_points = intval($_POST['voucher_points']);
			$model = Model();
			$voucherprice_info = $model->table('voucher_price')->where(array('voucher_price'=>$voucher_price))->find();	
	        if(!empty($voucherprice_info)) {
	            $error .= Language::get('admin_voucher_price_exist');
	        }
	        if ($error != ''){
	            showMessage($error);
	        }
	        else {
	            //保存
	            $insert_arr = array(
					'voucher_price_describe'=>trim($_POST['voucher_price_describe']),
					'voucher_price'=>$voucher_price,
					'voucher_defaultpoints'=>$voucher_points,
				);
	            $rs = $model->table('voucher_price')->insert($insert_arr);
	            if ($rs){
	            	showMessage(Language::get('nc_common_save_succ'),'index.php?act=voucher&op=pricelist');
	            }else {
	            	showMessage(Language::get('nc_common_save_fail'),'index.php?act=voucher&op=priceadd');
	            }
	        }
		}else {
			$this->show_menu('voucher','priceadd');
			Tpl::showpage('voucher.priceadd') ;
		}
    }
    /*
	 * 编辑代金券面额
	 */
    public function priceeditOp(){
    	$id = intval($_GET['priceid']);
    	if ($id <= 0){
    		$id = intval($_POST['priceid']);
    	}
    	if ($id <= 0){
    		showMessage(Language::get('wrong_argument'),'index.php?act=voucher&op=pricelist');
    	}
    	$model = Model();
    	if (chksubmit()){
    		$obj_validate = new Validate();
			$validate_arr[] = array('input'=>$_POST['voucher_price'],'require'=>'true','validator'=>'IntegerPositive','message'=>Language::get('admin_voucher_price_error'));
			$validate_arr[] = array('input'=>$_POST['voucher_price_describe'],'require'=>'true','message'=>Language::get('admin_voucher_price_describe_error'));
			$validate_arr[] = array('input'=>$_POST['voucher_points'],'require'=>'true','validator'=>'IntegerPositive','message'=>Language::get('admin_voucher_price_points_error'));
			$obj_validate->validateparam = $validate_arr;
			$error = $obj_validate->validate();
			//验证面额是否存在
    		$voucher_price = intval($_POST['voucher_price']);
			$voucher_points = intval($_POST['voucher_points']);
			$voucherprice_info = $model->table('voucher_price')->where(array('voucher_price'=>$voucher_price,'voucher_price_id'=>array('neq',$id)))->find();	
	        if(!empty($voucherprice_info)) {
	        	$error .= Language::get('admin_voucher_price_exist');
	        }
			if ($error != ''){
				showMessage($error,'','','error');
			}else {
				$update_arr = array();
	    		$update_arr['voucher_price_describe'] = trim($_POST['voucher_price_describe']);
	    		$update_arr['voucher_price'] = $voucher_price;
	    		$update_arr['voucher_defaultpoints'] = $voucher_points;
	    		$rs = $model->table('voucher_price')->where(array('voucher_price_id'=>$id))->update($update_arr);
	    		if ($rs){
	    			showMessage(Language::get('nc_common_save_succ'),'index.php?act=voucher&op=pricelist');
	    		}else {
	    			showMessage(Language::get('nc_common_save_fail'),'index.php?act=voucher&op=pricelist');
	    		}
			}
    	}else {
    		$voucherprice_info = $model->table('voucher_price')->where(array('voucher_price_id'=>$id))->find();
    		if (empty($voucherprice_info)){
    			showMessage(Language::get('wrong_argument'),'index.php?act=voucher&op=pricelist');
    		}
    		Tpl::output('info',$voucherprice_info);
    		$this->show_menu('priceedit','priceedit');
    		Tpl::showpage('voucher.priceadd');
    	}
    }
    /*
	 * 删除代金券面额
	 */
    public function pricedropOp(){
        $voucher_price_id = trim($_POST['voucher_price_id']);
        if(empty($voucher_price_id)) {
            showMessage(Language::get('wrong_argument'),'index.php?act=voucher&op=pricelist');
        }
        $model = Model();
        $rs = $model->table('voucher_price')->where(array('voucher_price_id'=>array('in',$voucher_price_id)))->delete();
        if ($rs){
        	showMessage(Language::get('nc_common_del_succ'),'index.php?act=voucher&op=pricelist');
        }else{
        	showMessage(Language::get('nc_common_del_fail'),'index.php?act=voucher&op=pricelist');
        }
    }
    /**
     * 申请管理
     **/
    public function applylistOp(){
        $model = Model();
        $list = $model->table('voucher_apply')->order('apply_state asc,apply_id asc')->page(10)->select();
        Tpl::output('show_page',$model->showpage(2));
        $this->show_menu('voucher','applylist');
        Tpl::output('list',$list);
        Tpl::showpage('voucher.applylist');
    }
	/**
     * 申请审核通过
     **/
    public function apply_verifyOp(){
        $apply_id = intval($_POST['object_id']);
        if($apply_id <= 0) {
            showMessage(Language::get('wrong_argument'),'','','error');
        }
        //获取申请详情
        $model = Model();
        $applyinfo =$model->table('voucher_apply')->where(array('apply_id'=>$apply_id,'apply_state'=>$this->applystate_arr['new'][0]))->find();
        if(empty($applyinfo)) {
            showMessage(Language::get('wrong_argument'),'','','error');
        }
        //获取当前价格
        $current_price = intval(C('promotion_voucher_price'));
        //获取申请人账户信息
        $member_info = $model->table('member')->where(array('member_id'=>$applyinfo['apply_memberid']))->find();
        if(empty($member_info)) {
        	showDialog(Language::get('nc_common_op_fail'),'index.php?act=voucher&op=applylist');
        }
        //判断余额
        $apply_price = intval($applyinfo['apply_quantity']) * $current_price;
        if($apply_price > intval($member_info['member_goldnum'])) {
            showDialog(Language::get('admin_voucher_apply_goldnotenough'),'index.php?act=voucher&op=applylist');
        }
        //扣除金币
        $update_array = array();
        $update_array['member_goldnum'] = array('exp','member_goldnum - '.$apply_price);
        $update_array['member_goldnumminus'] = array('exp','member_goldnumminus + '.$apply_price);
        $result = $model->table('member')->where(array('member_id'=>$applyinfo['apply_memberid']))->update($update_array);
        if(!$result){
        	showDialog(Language::get('nc_common_op_fail'),'index.php?act=voucher&op=applylist');
        }
        //写入金币日志
        $admin_info = $this->getAdminInfo();
        $param = array();
        $param['glog_memberid'] 	= $applyinfo['apply_memberid'];
        $param['glog_membername'] 	= $applyinfo['apply_membername'];
        $param['glog_storeid'] 		= $applyinfo['apply_storeid'];
        $param['glog_storename'] 	= $applyinfo['apply_storename'];
        $param['glog_adminid'] 		= $admin_info['id'];
        $param['glog_adminname'] 	= $admin_info['name'];
        $param['glog_goldnum'] 		= $apply_price;
        $param['glog_method'] 		= 2;//减少
        $param['glog_addtime'] 		= time();
        $param['glog_desc'] 		= sprintf(Language::get('admin_voucher_apply_goldlog'),$applyinfo['apply_quantity'],$current_price,$apply_price);
        $param['glog_stage'] 		= 'voucher';
        $model->table('gold_log')->insert($param);
        
        //获取该用户已有套餐
        $last_quota = $model->table('voucher_quota')->where(array('quota_storeid'=>$applyinfo['apply_storeid'],'quota_state'=>$this->quotastate_arr['activity'][0]))->order('quota_endtime desc')->find();
        //开始时间
        $start_time = time();
        //根据已存在的套餐记录，计算套餐开始时间
    	if(!empty($last_quota)) {
    		$last_end_time = intval($last_quota['quota_endtime']) + 1;
    		if($last_end_time > $start_time) {
    			$start_time = $last_end_time;
    		}
    	}
    	//生成套餐
    	$param = array();
    	$param['quota_applyid'] = $applyinfo['apply_id'];
    	$param['quota_memberid'] = $applyinfo['apply_memberid'];
    	$param['quota_membername'] = $applyinfo['apply_membername'];
    	$param['quota_storeid'] = $applyinfo['apply_storeid'];
    	$param['quota_storename'] = $applyinfo['apply_storename'];
    	$param['quota_timeslimit'] = intval(C('promotion_voucher_storetimes_limit'));
    	$param['quota_state'] = 1;
    	
    	$apply_quantity =intval($applyinfo['apply_quantity']);
    	$param_array = array();
        for($i=0;$i<$apply_quantity;$i++) {
            $end_time = $start_time + self::SECONDS_OF_30DAY - 1;
            $param['quota_starttime'] = $start_time;
            $param['quota_endtime'] = $end_time;
            $param_array[] = $param;
            $start_time += self::SECONDS_OF_30DAY;
        }
        $reault = $model->table('voucher_quota')->insertAll($param_array);
        if($reault !== true){
        	showDialog(Language::get('nc_common_op_fail'),'index.php?act=voucher&op=applylist');
        }
        $message = '';
        //更新申请状态
        $result = $model->table('voucher_apply')->where(array('apply_id'=>$apply_id))->update(array('apply_state'=>$this->applystate_arr['verify'][0]));
        if($result) {
        	//发送通知站内信
        	$message = sprintf(Language::get('admin_voucher_apply_message'),$applyinfo['apply_quantity'],$current_price,$apply_price);
        	$this->send_message($applyinfo['apply_memberid'],$applyinfo['apply_membername'],$message);
            showMessage(Language::get('admin_voucher_apply_verifysucc'),'');
        } else {
            showMessage(Language::get('admin_voucher_apply_verifyfail'),'','','error');
        }
    }
    /**
     * 取消申请
     **/
    public function apply_cancelOp(){
    	$apply_id = intval($_POST['object_id']);
        if($apply_id <= 0) {
            showMessage(Language::get('wrong_argument'),'','','error');
        }        
        $model = Model();
        $result = $model->table('voucher_apply')->where(array('apply_id'=>$apply_id))->update(array('apply_state'=>$this->applystate_arr['cancel'][0]));
        if($result) {
            showMessage(Language::get('admin_voucher_apply_cancelsucc'),'');
        } else {
            showMessage(Language::get('admin_voucher_apply_cancelfail'),'');
        }
    }
	/**
     * 套餐管理
     **/
    public function quotalistOp(){
        $model = Model();
        //更新过期套餐的状态
        $time = time();
        $model->table('voucher_quota')->where(array('quota_endtime'=>array('lt',$time),'quota_state'=>"{$this->quotastate_arr['activity'][0]}"))->update(array('quota_state'=>$this->quotastate_arr['expire'][0]));
        
        $param = array();
        if(trim($_GET['store_name'])){
        	$param['quota_storename'] = array('like',"%{$_GET['store_name']}%");
        }
        $state = intval($_GET['state']);
    	if($state){
        	$param['quota_state'] = $state;
        }
        $list = $model->table('voucher_quota')->where($param)->order('quota_id desc')->page(10)->select();
        Tpl::output('show_page',$model->showpage(2));
        $this->show_menu('voucher','quotalist');
        Tpl::output('list',$list);
        Tpl::showpage('voucher.quotalist');
    }
	/**
     * 套餐取消
     **/
    public function quota_cancelOp() {
        $quota_id = $_POST['object_id'];
        if(empty($quota_id)) {
            showMessage(Language::get('wrong_argument'),'index.php?act=voucher&op=quotalist');
        }
        $model = Model();
        $result = $model->table('voucher_quota')->where(array('quota_id'=>array('in',$quota_id),'quota_state'=>$this->quotastate_arr['activity'][0]))->update(array('quota_state'=>$this->quotastate_arr['cancel'][0]));
        if($result) { 
            showMessage(Language::get('admin_voucher_quota_cancelsucc'),'index.php?act=voucher&op=quotalist');
        }
        else {
            showMessage(Language::get('admin_voucher_quota_cancelfail'),'index.php?act=voucher&op=quotalist','','error');
        }
    }
	/*
     * 发送消息 
     */
    private function send_message($member_id,$member_name,$message) {
        $param = array();
        $param['message_parent_id'] = 0;
        $param['from_member_id'] = 0;
        $param['to_member_id'] = $member_id;
        $param['message_title'] = '';
        $param['message_body'] = $message;
        $param['message_time'] = time();
        $param['message_update_time'] = time();
        $param['message_state'] = 0;
        $param['message_type'] = 1;
        $param['read_member_id'] = '';
        $param['del_member_id'] = '';
        $param['from_member_name'] = '';
        $param['to_member_name'] = $member_name;
        $model = Model();
        $model->table('message')->insert($param);
    }
    /**
     * 代金券列表
     */
    public function templatelistOp(){
        $model = Model();
        $param = array();
        if(trim($_GET['store_name'])){
        	$param['voucher_t_storename'] = array('like',"%{$_GET['store_name']}%");
        }
    	if(trim($_GET['sdate']) && trim($_GET['edate'])){
    		$sdate = strtotime($_GET['sdate']);
    		$edate = strtotime($_GET['edate']);
        	$param['voucher_t_add_date'] = array('between',"$sdate,$edate");
        }elseif (trim($_GET['sdate'])){
        	$sdate = strtotime($_GET['sdate']);
        	$param['voucher_t_add_date'] = array('egt',$sdate);
        }elseif (trim($_GET['edate'])){
        	$edate = strtotime($_GET['edate']);
        	$param['voucher_t_add_date'] = array('elt',$edate);
        }
        $state = intval($_GET['state']);
    	if($state){
        	$param['voucher_t_state'] = $state;
        }
        $list = $model->table('voucher_template')->where($param)->order('voucher_t_state asc,voucher_t_id desc')->page(10)->select();
        Tpl::output('show_page',$model->showpage(2));
        $this->show_menu('voucher','templatelist');
        Tpl::output('list',$list);
        Tpl::showpage('voucher.templatelist');
    }
    /*
	 * 代金券模版编辑
	 */
    public function templateeditOp(){
    	$t_id = intval($_GET['tid']);
    	if ($t_id <= 0){
    		$t_id = intval($_POST['tid']);
    	}
    	if ($t_id <= 0){
    		showMessage(Language::get('wrong_argument'),'index.php?act=voucher&op=templatelist','','error');
    	}
        $model = Model('voucher');
        //查询模板信息
        $param = array();
        $param['voucher_t_id'] = $t_id;
        $t_info = $model->table('voucher_template')->where($param)->find();
        if (empty($t_info)){
        	showMessage(Language::get('wrong_argument'),'index.php?act=voucher&op=templatelist','html','error');
        }
        if(chksubmit()){
        	$points = intval($_POST['points']);
        	if ($points<=0){
        		showMessage(Language::get('admin_voucher_template_points_error'),'','html','error');
        	}
	       	$update_arr = array();
	       	$update_arr['voucher_t_points'] = $points;
	       	$update_arr['voucher_t_state'] = intval($_POST['tstate']) == $this->templatestate_arr['usable'][0]?$this->templatestate_arr['usable'][0]:$this->templatestate_arr['disabled'][0];
	       	$rs = $model->table('voucher_template')->where(array('voucher_t_id'=>$t_info['voucher_t_id']))->update($update_arr);
	       	if($rs){
	       		showMessage(Language::get('nc_common_save_succ'),'index.php?act=voucher&op=templatelist','succ'); 
	       	}else{
	       		showMessage(Language::get('nc_common_save_fail'),'index.php?act=voucher&op=templatelist','error'); 
	       	}
        }else{
	        if (!$t_info['voucher_t_customimg'] || !file_exists(BasePath.DS.ATTACH_VOUCHER.DS.$t_info['voucher_t_store_id'].DS.$t_info['voucher_t_customimg'])){
	        	$t_info['voucher_t_customimg'] = '';
	        }else{
	        	$t_info['voucher_t_customimg'] = SiteUrl.DS.ATTACH_VOUCHER.DS.$t_info['voucher_t_store_id'].DS.$t_info['voucher_t_customimg'];
	        }
	        TPL::output('t_info',$t_info);
	        $this->show_menu('templateedit','templateedit');
	        Tpl::showpage('voucher.templateedit');
        }
    }
    
	/**
     * 页面内导航菜单
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return 
     */
    private function show_menu($menu_type,$menu_key='') {
    	$menu_array		= array();
		switch ($menu_type) {
			case 'voucher':
				$menu_array = array(
				1=>array('menu_key'=>'applylist','menu_name'=>Language::get('admin_voucher_apply_manage'), 'menu_url'=>'index.php?act=voucher&op=applylist'),
				2=>array('menu_key'=>'quotalist','menu_name'=>Language::get('admin_voucher_quota_manage'), 'menu_url'=>'index.php?act=voucher&op=quotalist'),
				3=>array('menu_key'=>'templatelist','menu_name'=>Language::get('admin_voucher_template_manage'), 'menu_url'=>'index.php?act=voucher&op=templatelist'),
				4=>array('menu_key'=>'setting','menu_name'=>Language::get('admin_voucher_setting'),	'menu_url'=>'index.php?act=voucher&op=setting'),
				5=>array('menu_key'=>'pricelist','menu_name'=>Language::get('admin_voucher_pricemanage'), 'menu_url'=>'index.php?act=voucher&op=pricelist'),
				6=>array('menu_key'=>'priceadd','menu_name'=>Language::get('admin_voucher_priceadd'), 'menu_url'=>'index.php?act=voucher&op=priceadd')
				);
				break;
			case 'priceedit':
				$menu_array = array(
				1=>array('menu_key'=>'setting','menu_name'=>Language::get('admin_voucher_setting'),	'menu_url'=>'index.php?act=voucher&op=setting'),
				2=>array('menu_key'=>'pricelist','menu_name'=>Language::get('admin_voucher_pricemanage'), 'menu_url'=>'index.php?act=voucher&op=pricelist'),
				3=>array('menu_key'=>'priceedit','menu_name'=>Language::get('admin_voucher_priceedit'), 'menu_url'=>'')
				);
				break;
			case 'templateedit':
				$menu_array = array(
				1=>array('menu_key'=>'templatelist','menu_name'=>Language::get('admin_voucher_template_manage'), 'menu_url'=>'index.php?act=voucher&op=templatelist'),
				2=>array('menu_key'=>'templateedit','menu_name'=>Language::get('admin_voucher_template_edit'), 'menu_url'=>'')
				);
				break;
		}
        Tpl::output('menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}