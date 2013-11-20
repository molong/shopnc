<?php
/**
 * 满即送管理
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
class promotion_mansongControl extends SystemControl{

    //定义常量
    const APPLY_STATE_NEW = 1;
    const APPLY_STATE_VERIFY = 2;
    const APPLY_STATE_CANCEL = 3;
    const APPLY_STATE_FAIL = 4;
    const QUOTA_STATE_ACTIVITY = 1;
    const QUOTA_STATE_CANCEL = 2;
    const QUOTA_STATE_EXPIRE = 3;
    const MANSONG_STATE_UNPUBLISHED = 1;
    const MANSONG_STATE_PUBLISHED = 2;
    const MANSONG_STATE_CANCEL = 3;
    const MANSONG_STATE_INVADITATION = 4;
    const MANSONG_STATE_END = 5;
    const SECONDS_OF_30DAY = 2592000;
    const LINK_APPLY_LIST = 'index.php?act=promotion_mansong&op=mansong_apply';
    const LINK_QUOTA_LIST = 'index.php?act=promotion_mansong&op=mansong_quota';
    const LINK_MANSONG_LIST = 'index.php?act=promotion_mansong&op=mansong_list';


    public function __construct(){
        parent::__construct();

        //读取语言包
        Language::read('promotion_mansong');

        //检查审核功能是否开启
        if (intval($_GET['promotion_allow']) !== 1 && intval(C('promotion_allow')) !== 1 && intval(C('gold_isuse')) !==1){
 			$url = array(
				array(
					'url'=>'index.php?act=promotion_mansong&promotion_allow=1',
					'msg'=>Language::get('open'),
				),
				array(
					'url'=>'index.php?act=dashboard&op=welcome',
					'msg'=>Language::get('close'),
				),
			);
			showMessage(Language::get('promotion_unavailable'),$url,'html','succ',1,6000);
        }
    }
    /**
     * 默认Op
     */
    public function indexOp() {

		//自动开启满就送
		if (intval($_GET['promotion_allow']) === 1){
			$model_setting = Model('setting');
			$update_array = array();
			$update_array['promotion_allow'] = 1;
			$update_array['gold_isuse'] = 1;
			$model_setting->updateSetting($update_array);	
		}

        $this->mansong_applyOp();
   
    }

    /**
     * 申请管理
     **/
    public function mansong_applyOp() {

        //分页
        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin') ;

        $model = Model('p_mansong_apply');
        $param = array();
        $param['order'] = 'state asc,apply_id asc';
        $list = $model->getList($param,$page);
        Tpl::output('show_page',$page->show());

        $this->show_menu('mansong_apply');
        Tpl::output('list',$list);
        Tpl::showpage('promotion_mansong_apply.list');
    }

    /**
     * 申请审核通过
     **/
    public function mansong_apply_verifyOp() {

        $apply_id = intval($_POST['object_id']);
        if($apply_id === 0) {
            showMessage(Language::get('param_error'),'','','error');
        }

        //获取申请详情
        $model_mansong_apply = Model('p_mansong_apply');
        $mansong_apply = $model_mansong_apply->getOne($apply_id);
        if(empty($mansong_apply)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        if(intval($mansong_apply['state']) !==  self::APPLY_STATE_NEW) {
            showMessage(Language::get('param_error'),'','','error');
        }

        //获取当前价格
        $current_price = intval($GLOBALS['setting_config']['promotion_mansong_price']);

        $flag = TRUE;
        //获取申请人账户信息
        $model_member = Model('member');
        $member_info = $model_member->infoMember(array('member_id'=>$mansong_apply['member_id']));
        if(empty($member_info)) {
            $flag = FALSE;
        }

        //判断余额
        $apply_price = intval($mansong_apply['apply_quantity']) * $current_price;
        if($apply_price > intval($member_info['member_goldnum'])) {
            $flag = FALSE;
        }
        
        if($flag) {

            //扣除金币
            $update_array = array();
            $update_array['member_goldnum'] = array('sign'=>'decrease','value'=>$apply_price);
            $update_array['member_goldnumminus'] = array('sign'=>'increase','value'=>$apply_price);
            $result = $model_member->updateMember($update_array,$mansong_apply['member_id']);

            //写入金币日志
            $admin_info = $this->getAdminInfo();
            $model_gold_log = Model('gold_log');
            $param = array();
            $param['glog_memberid'] = $mansong_apply['member_id'];
            $param['glog_membername'] = $mansong_apply['member_name'];
            $param['glog_storeid'] = $mansong_apply['store_id'];
            $param['glog_storename'] = $mansong_apply['store_name'];
            $param['glog_adminid'] = $admin_info['id'];
            $param['glog_adminname'] = $admin_info['name'];
            $param['glog_goldnum'] = $apply_price;
            $param['glog_method'] = 2;
            $param['glog_addtime'] = time();
            $param['glog_desc'] = sprintf(Language::get('mansong_apply_verify_success_glog_desc'),$mansong_apply['apply_quantity'],$current_price,$apply_price);
            $param['glog_stage'] = 'mansong';
            $model_gold_log->add($param);

            $model_mansong_quota = Model('p_mansong_quota');

            //获取该用户已有套餐
            $param = array();
            $param['store_id'] = $mansong_apply['store_id'];
            $param['order'] = 'end_time desc';
            $param['state'] = self::QUOTA_STATE_ACTIVITY;
            $param['limit'] = 1;
            $last_mansong_quota = $model_mansong_quota->getList($param);

            //开始时间为第二天零点
            $start_time = time(); 
            //计算套餐开始时间
            if(!empty($last_mansong_quota)) {
                $last_end_time = intval($last_mansong_quota[0]['end_time']);
                if($last_end_time > $start_time) {
                    $start_time = $last_end_time + 1;
                }
            }

            //生成套餐
            if($result) {
                $param = array();
                $param['member_id'] = $mansong_apply['member_id'];
                $param['member_name'] = $mansong_apply['member_name'];
                $param['store_id'] = $mansong_apply['store_id'];
                $param['store_name'] = $mansong_apply['store_name'];
                $param['state'] = self::QUOTA_STATE_ACTIVITY;
                $param['apply_id'] = $mansong_apply['apply_id'];
                $apply_quantity =intval($mansong_apply['apply_quantity']);
                $param['start_time'] = $start_time;
                $param['end_time'] = $start_time + (self::SECONDS_OF_30DAY * $apply_quantity) - 1;
                $model_mansong_quota->save($param);
            }
            else {
                $flag = FALSE;
            }
        }

        $message = '';
        //更新申请状态
        $update_array = array();
        if($flag && $result) {
            $update_array['state'] = self::APPLY_STATE_VERIFY;
            $message = sprintf(Language::get('mansong_apply_verify_success_message'),$mansong_apply['apply_quantity'],$current_price,$apply_price);
        }
        else {
            $update_array['state'] = self::APPLY_STATE_FAIL;
            $message = Language::get('mansong_apply_verify_fail_message');
        }
        $where_array = array();
        $where_array['apply_id'] = $apply_id;
        $model_mansong_apply->update($update_array,$where_array);

        //发送通知站内信
        $this->send_message($mansong_apply['member_id'],$mansong_apply['member_name'],$message);

        if($flag && $result) {
            showMessage(Language::get('mansong_apply_verify_success'),'');
        }
        else {
            showMessage(Language::get('mansong_apply_verify_fail'),'','','error');
        }


    }

    /**
     * 申请取消
     **/
    public function mansong_apply_cancelOp() {
        $apply_id = intval($_POST['object_id']);
        if($apply_id === 0) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $model_mansong_apply = Model('p_mansong_apply');
        $update_array = array();
        $update_array['state'] = self::APPLY_STATE_CANCEL;
        $where_array = array();
        $where_array['apply_id'] = $apply_id;
        if($model_mansong_apply->update($update_array,$where_array)) {
            showMessage(Language::get('mansong_apply_cancel_success'),'');
        }
        else {
            showMessage(Language::get('mansong_apply_cancel_fail'),'');
        }
        
    }

    /**
     * 套餐管理
     **/
    public function mansong_quotaOp() {

        //分页
        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin') ;

        $model = Model('p_mansong_quota');

        //更新过期套餐状态
        $model->update(array('state'=>self::QUOTA_STATE_EXPIRE),array('greater_than_end_time'=>time(),'state'=>self::QUOTA_STATE_ACTIVITY));
        $param = array();
        $param['store_name'] = trim($_GET['store_name']);
        $param['state'] = intval($_GET['state']);
        $param['order'] = 'quota_id desc';
        $list = $model->getList($param,$page);
        Tpl::output('show_page',$page->show());

        $this->output_mansong_quota_state_list();
        Tpl::output('mansong_quota_state_activity',self::QUOTA_STATE_ACTIVITY);

        $this->show_menu('mansong_quota');
        Tpl::output('list',$list);
        Tpl::showpage('promotion_mansong_quota.list');

    }

    /**
     * 套餐取消
     **/
    public function mansong_quota_cancelOp() {

        $quota_id = $_POST['object_id'];
        if(empty($quota_id)) {
            showMessage(Language::get('para_error'),'index.php?act=promotion_mansong');
        }
        $model_mansong_quota = Model('p_mansong_quota');
        $update_array = array();
        $update_array['state'] = self::QUOTA_STATE_CANCEL;
        $where_array = array();
        $where_array['in_quota_id'] = $quota_id;
        $where_array['state'] = self::QUOTA_STATE_ACTIVITY;
        if($model_mansong_quota->update($update_array,$where_array)) { 
            showMessage(Language::get('mansong_quota_cancel_success'),self::LINK_QUOTA_LIST);
        }
        else {
            showMessage(Language::get('mansong_quota_cancel_fail'),self::LINK_QUOTA_LIST,'','error');
        } 
    }

    /**
     * 活动列表
     **/
    public function mansong_listOp() {

        $model_mansong = Model('p_mansong');

        //更新活动状态
        $model_mansong->update(array('state'=>self::MANSONG_STATE_END),array('greater_than_end_time'=>time(),'state'=>self::MANSONG_STATE_PUBLISHED));

        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin'); 
        
        $param = array();
        $param['mansong_name'] = trim($_GET['mansong_name']);
        $param['store_name'] = trim($_GET['store_name']);
        $param['state'] = trim($_GET['state']);
        $param['order'] = 'state asc,mansong_id asc';
        $mansong_list = $model_mansong->getList($param,$page);
        Tpl::output('list',$mansong_list);
        Tpl::output('mansong_state_published',self::MANSONG_STATE_PUBLISHED);

        //输出属性列表
        $this->output_mansong_state_list();

        //输出分页
        Tpl::output('show_page',$page->show());

        $this->show_menu('mansong_list');
        Tpl::showpage('promotion_mansong.list');
    }

    /**
     * 满就送活动失效
     **/
    public function mansong_invaditationOp() {

        $mansong_id = intval($_GET['mansong_id']);
        $mansong_info = $this->get_mansong_info($mansong_id);

        $update = array();
        $update['state'] = self::MANSONG_STATE_INVADITATION;
        $where = array();
        $where['mansong_id'] = $mansong_id;
        $where['state'] = self::MANSONG_STATE_PUBLISHED;
        $model_mansong = Model('p_mansong');
        if($model_mansong->update($update,$where)) {
            showMessage(Language::get('mansong_invaditation_success'),'');
        }
        else {
            showMessage(Language::get('mansong_invaditation_fail'),'','','error');
        }

    }

    /**
     * 活动详细信息
     * temp
     **/
    public function mansong_detailOp() {

        $mansong_id = intval($_GET['mansong_id']);
        $mansong_info = $this->get_mansong_info($mansong_id);
        Tpl::output('mansong_info',$mansong_info);

        $this->output_mansong_state_list();

        $model_mansong_rule = Model('p_mansong_rule');
        $param = array();
        $param['mansong_id'] = $mansong_id;
        $param['order'] = 'level asc';
        $rule_list = $model_mansong_rule->getList($param);
        Tpl::output('list',$rule_list);

        $this->show_menu('mansong_detail');
        Tpl::showpage('promotion_mansong.detail');
    }

    /**
     * 设置
     **/
    public function mansong_settingOp() {

        $model_setting = Model('setting');
        $setting = $model_setting->GetListSetting();
        Tpl::output('setting',$setting);

        $this->show_menu('mansong_setting');
        Tpl::showpage('promotion_mansong.setting');
    }

    public function mansong_setting_saveOp() {

        $promotion_mansong_price = intval($_POST['promotion_mansong_price']);
        if($promotion_mansong_price === 0) {
            $promotion_mansong_price = 20;
        }

        $model_setting = Model('setting');
        $update_array = array();
        $update_array['promotion_mansong_price'] = $promotion_mansong_price;

        $result = $model_setting->updateSetting($update_array);
        if ($result === true){
            showMessage(Language::get('setting_save_success'),'');
        }else {
            showMessage(Language::get('setting_save_fail'),'');
        }

    }

    /*
     * 发送消息 
     */
    private function send_message($member_id,$member_name,$message) {
        $param = array();
        $param['from_member_id'] = 0;
        $param['member_id'] = $member_id; 
        $param['to_member_name'] = $member_name; 
        $param['message_type'] = '1';//表示为系统消息
        $param['msg_content'] = $message;
        $model_message = Model('message');
        return $model_message->saveMessage($param);
    }

    /**
     * 输出满就送申请状态列表
     **/
    private function output_mansong_apply_state_list() {
        $state_list = array(
            0 => Language::get('all_state'),
            self::APPLY_STATE_NEW=> Language::get('state_new'),
            self::APPLY_STATE_VERIFY=> Language::get('state_verify'),
            self::APPLY_STATE_CANCEL=> Language::get('state_cancel'),
            self::APPLY_STATE_FAIL=> Language::get('state_verify_fail')
    );
        Tpl::output('apply_state_list',$state_list);
    }

    /**
     * 输出满就送申请状态列表
     **/
    private function output_mansong_quota_state_list() {
        $state_list = array(
            0 => Language::get('all_state'),
            self::QUOTA_STATE_ACTIVITY=> Language::get('nc_normal'),
            self::QUOTA_STATE_CANCEL=> Language::get('nc_cancel'),
            self::QUOTA_STATE_EXPIRE=> Language::get('nc_end')
    );
        Tpl::output('mansong_quota_state_list',$state_list);
    }

    /**
     * 输出满就送状态列表
     **/
    private function output_mansong_state_list() {
        $state_list = array(
            0 => Language::get('all_state'),
            self::MANSONG_STATE_PUBLISHED => Language::get('mansong_state_published'),
            self::MANSONG_STATE_CANCEL => Language::get('nc_cancel'),
            self::MANSONG_STATE_INVADITATION => Language::get('nc_invalidation'),
            self::MANSONG_STATE_END => Language::get('nc_end')
    );
        Tpl::output('mansong_state_list',$state_list);
    }

    /**
     * 获取满就送详细信息
     * temp
     **/
    private function get_mansong_info($mansong_id) {
        if($mansong_id === 0) {
            showMessage(Language::get('param_error'),'','','error');
        }

        //获取满就送详情
        $model_mansong = Model('p_mansong');
        $mansong_info = $model_mansong->getOne($mansong_id);
        if(empty($mansong_info)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        return $mansong_info;
    }


    /**
     * 页面内导航菜单
     *
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return 
     */
    private function show_menu($menu_key) {
        $menu_array = array(
            'mansong_apply'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_apply'),'menu_url'=>'index.php?act=promotion_mansong&op=mansong_apply'),
            'mansong_quota'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_quota'),'menu_url'=>'index.php?act=promotion_mansong&op=mansong_quota'),
            'mansong_list'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_list'),'menu_url'=>'index.php?act=promotion_mansong&op=mansong_list'),
            'mansong_detail'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_detail'),'menu_url'=>'index.php?act=promotion_mansong&op=mansong_detail'),
            'mansong_setting'=>array('menu_type'=>'link','menu_name'=>Language::get('mansong_setting'),'menu_url'=>'index.php?act=promotion_mansong&op=mansong_setting'),
        );
        if($menu_key != 'mansong_detail') unset($menu_array['mansong_detail']);
        $menu_array[$menu_key]['menu_type'] = 'text';
        Tpl::output('menu',$menu_array);
    }	

}
