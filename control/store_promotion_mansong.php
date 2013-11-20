<?php
/**
 * 用户中心-满就送 
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
class store_promotion_mansongControl extends BaseMemberStoreControl {

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
    const SECONDS_OF_DAY = 86400;
    const SECONDS_OF_30DAY = 2592000;
    const LINK_APPLY_LIST = 'index.php?act=store_promotion_mansong&op=mansong_apply_list';
    const LINK_APPLY_ADD = 'index.php?act=store_promotion_mansong&op=mansong_quota_add';
    const LINK_MANSONG_LIST = 'index.php?act=store_promotion_mansong&op=mansong_list';
    const LINK_MANSONG_MANAGE = 'index.php?act=store_promotion_mansong&op=mansong_manage&mansong_id=';

    public function __construct() {

        parent::__construct() ;

        /**
         * 读取语言包
         */
        Language::read('member_layout,promotion_mansong');
        //检查满就送是否开启
        if (intval(C('gold_isuse')) !== 1 || intval(C('promotion_allow')) !== 1){
            showMessage(Language::get('promotion_unavailable'),'index.php?act=store','','error');
        }

    }

    public function indexOp() {
        $this->mansong_listOp();
    }

    /**
     * 发布的满就送活动列表
     **/
    public function mansong_listOp() {

        $model_mansong_quota = Model('p_mansong_quota');
        $current_mansong_quota = $model_mansong_quota->getCurrent($_SESSION['store_id']);
        //检查当前套餐是否可用
        $result = $this->check_current_mansong_quota($current_mansong_quota);
        Tpl::output('mansong_quota_flag',$result);

        if(!$result) {

            $apply_flag = FALSE;
            $model_mansong_apply = Model('p_mansong_apply');
            $apply_list = $model_mansong_apply->getList(array('store_id'=>$_SESSION['store_id'],'state'=>self::APPLY_STATE_NEW));
            if(!empty($apply_list)) {
                $apply_flag = TRUE;
                Tpl::output('mansong_apply',$apply_list[0]);
            }
            Tpl::output('mansong_apply_flag',$apply_flag);
        } else {
            Tpl::output('current_mansong_quota',$current_mansong_quota);

            $model_mansong = Model('p_mansong');

            //更新活动状态
            $where['greater_than_end_time'] = time();
            $where['state'] = self::MANSONG_STATE_PUBLISHED;
            $where['store_id'] = $_SESSION['store_id'];
            $model_mansong->update(array('state'=>self::MANSONG_STATE_END),$where);

            $page = new Page();
            $page->setEachNum(10) ;
            $page->setStyle('admin'); 

            $param = array();
            $param['store_id'] = $_SESSION['store_id'];
            $param['mansong_name'] = trim($_GET['mansong_name']);
            $param['state'] = trim($_GET['state']);
            $param['order'] = 'state asc,mansong_id asc';
            $mansong_list = $model_mansong->getList($param,$page);
            Tpl::output('list',$mansong_list);

            //输出属性列表
            $this->output_mansong_state_list();
            Tpl::output('state_cancel',self::MANSONG_STATE_CANCEL);

            //输出分页
            Tpl::output('show_page',$page->show());
        }

        //输出导航
        self::profile_menu('mansong_list');
        Tpl::showpage('store_promotion_mansong.list');

    }

    /**
     * 添加满就送活动
     **/
    public function mansong_addOp() {

        $model_mansong_quota = Model('p_mansong_quota');
        $current_mansong_quota = $model_mansong_quota->getCurrent($_SESSION['store_id']);
        //检查当前套餐是否可用
        $result = $this->check_current_mansong_quota($current_mansong_quota);
        if(!$result) {
            showMessage(Language::get('mansong_quota_current_error'),'','','error');
        }
        $start_time = $current_mansong_quota['start_time'];
        $end_time = $current_mansong_quota['end_time'];

        $model_mansong = Model('p_mansong');
        $mansong_last = $model_mansong->getLast(array('store_id'=>$_SESSION['store_id']),self::MANSONG_STATE_PUBLISHED);
        if(!empty($mansong_last)) {
            if(intval($mansong_last['end_time']) > intval($start_time)) {
                $start_time = $mansong_last['end_time'];
            }
        }
        Tpl::output('start_time',$start_time);
        Tpl::output('end_time',$end_time);

        //输出导航
        self::profile_menu('mansong_add');
        Tpl::showpage('store_promotion_mansong.add');

    }

    /**
     * 保存添加的满就送活动
     **/
    public function mansong_saveOp() {

        //获取当前套餐
        $model_mansong_quota = Model('p_mansong_quota');
        $current_mansong_quota = $model_mansong_quota->getCurrent($_SESSION['store_id']);
        //检查当前套餐是否可用
        $result = $this->check_current_mansong_quota($current_mansong_quota);
        if(!$result) {
            showDialog(Language::get('mansong_quota_current_error'));
        }

        //验证输入
        $mansong_name = trim($_POST['mansong_name']);
        $start_time = strtotime($_POST['start_time']);
        $end_time = strtotime($_POST['end_time']) + self::SECONDS_OF_DAY - 1;
        $quota_start_time = intval($current_mansong_quota['start_time']);
        $quota_end_time = intval($current_mansong_quota['end_time']);
        if(empty($mansong_name)) {
            showDialog(Language::get('mansong_name_error'));
        }
        if($start_time >= $end_time) {
            showDialog(Language::get('greater_than_start_time'));
        }
        $model_mansong = Model('p_mansong');
        $mansong_last = $model_mansong->getLast(array('store_id'=>$_SESSION['store_id']),self::MANSONG_STATE_PUBLISHED);
        if(!empty($mansong_last)) {
            if(intval($mansong_last['end_time']) > $start_time) {
                $quota_start_time = intval($mansong_last['end_time']);
            }
        }
        if($start_time < $quota_start_time) {
            showDialog(sprintf(Language::get('mansong_add_start_time_explain'),date('Y-m-d',$current_mansong_quota['start_time'])));
        }
        if($end_time > $quota_end_time) {
            showDialog(sprintf(Language::get('mansong_add_end_time_explain'),date('Y-m-d',$current_mansong_quota['end_time'])));
        }

        //获取不同级别的规则，并验证数据
        $level_array = array();
        for($i=1,$j=0;$i<=3;$i++,$j++) {
            $price = intval($_POST['level'.$i.'_price']);
            if($price <= 0) {
                break;
            }
            $level_array[$j]['level'] = $i;
            $level_array[$j]['price'] = $price;
            if(!empty($_POST['level'.$i.'_shipping_free_flag'])) {
                $level_array[$j]['shipping_free'] = 1;
            }
            else {
                $level_array[$j]['shipping_free'] = 0;
            }
            if(!empty($_POST['level'.$i.'_discount_flag'])) {
                $level_array[$j]['discount'] = intval($_POST['level'.$i.'_discount']);
            }
            else {
                $level_array[$j]['discount'] = 0;
            }
            if(!empty($_POST['level'.$i.'_gift_flag'])) {
                $level_array[$j]['gift_name'] = trim($_POST['level'.$i.'_gift_name']);
                $level_array[$j]['gift_link'] = trim($_POST['level'.$i.'_gift_link']);
            }
            else {
                $level_array[$j]['gift_name'] = ''; 
                $level_array[$j]['gift_link'] = ''; 
            }
            if(empty($level_array[$j]['shipping_free']) && empty($level_array[$j]['discount']) && empty($level_array[$j]['gift_name'])) {
                showDialog(Language::get('param_error'));
            }

        }
        if(empty($level_array)) {
            showDialog(Language::get('param_error'));
        }

        //生成活动
        $model_mansong = Model('p_mansong');
        $param = array();
        $param['mansong_name'] = $mansong_name;
        $param['start_time'] = $start_time;
        $param['end_time'] = $end_time;
        $param['store_id'] = $current_mansong_quota['store_id'];
        $param['store_name'] = $current_mansong_quota['store_name'];
        $param['member_id'] = $current_mansong_quota['member_id'];
        $param['member_name'] = $current_mansong_quota['member_name'];
        $param['quota_id'] = $current_mansong_quota['quota_id'];
        $param['state'] = self::MANSONG_STATE_PUBLISHED;
        $param['remark'] = trim($_POST['remark']);
        $result = $model_mansong->save($param);
        if($result) {
            $count = count($level_array);
            for($i=0;$i<$count;$i++) {
                $level_array[$i]['mansong_id'] = $result;
            }
            //生成规则
            $model_mansong_rule = Model('p_mansong_rule');
            $result = $model_mansong_rule->save_array($level_array);
            
			// 自动发布动态
			// mansong_name,start_time,end_time,store_id
			$data_array = array();
			$data_array['mansong_name']		= $param['mansong_name'];
			$data_array['start_time']		= $param['start_time'];
			$data_array['end_time']			= $param['end_time'];
			$data_array['store_id']			= $_SESSION['store_id'];
			$this->storeAutoShare($data_array, 'mansong');
        }
        if($result) {
            showDialog(Language::get('mansong_add_success'),self::LINK_MANSONG_LIST,'succ');
        }
        else {
            showDialog(Language::get('mansong_add_fail'));
        }
    } 

    /**
     * 满就送活动详细信息
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

        //输出导航
        self::profile_menu('mansong_detail');
        Tpl::showpage('store_promotion_mansong.detail');
    }

    /**
     * 满就送活动取消
     **/
    public function mansong_cancelOp() {

        $mansong_id = intval($_GET['mansong_id']);
        $mansong_info = $this->get_mansong_info($mansong_id);

        $model_mansong= Model('p_mansong');
        $update = array();
        $update['state'] = self::MANSONG_STATE_CANCEL;
        $where = array();
        $where['mansong_id'] = $mansong_id;
        $model_mansong->update($update,$where);

        if($model_mansong->update($update,$where)) {
            showDialog(Language::get('mansong_cancel_success'),'index.php?act=store_promotion_mansong&op=mansong_list','succ');
        } else {
            showDialog(Language::get('mansong_cancel_fail'));
        }
    }
    /**
     * 检查当前套餐是否可用
     **/
    private function check_current_mansong_quota($current_mansong_quota) {
        $result = TRUE;
        if(empty($current_mansong_quota)) {
            $result = FALSE;
        }
        return $result;
    }


    /**
     * 满就送套餐列表
     **/
    public function mansong_quota_listOp() {

        $model_mansong = Model('p_mansong_quota');

        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin'); 

        //更新过期套餐状态
        $where['greater_than_end_time'] = time();
        $where['state'] = self::QUOTA_STATE_ACTIVITY;
        $where['store_id'] = $_SESSION['store_id'];
        $model_mansong->update(array('state'=>self::QUOTA_STATE_EXPIRE),$where);
        
        $param = array();
        $param['store_id'] = $_SESSION['store_id'];
        $param['order'] = 'state asc,start_time asc';
        $mansong_list = $model_mansong->getList($param,$page);
        Tpl::output('list',$mansong_list);
        $this->output_mansong_quota_state_list();

        //输出分页
        Tpl::output('show_page',$page->show());

        //输出导航
        self::profile_menu('mansong_quota_list');
        Tpl::showpage('store_promotion_mansong_quota.list');

    }

    /**
     * 满就送申请列表
     **/
    public function mansong_apply_listOp() {

        $model_mansong = Model('p_mansong_apply');

        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin'); 
        
        $param = array();
        $param['store_id'] = $_SESSION['store_id'];
        $param['order'] = 'state asc,apply_date asc';
        $list = $model_mansong->getList($param,$page);
        Tpl::output('list',$list);

        $this->output_mansong_apply_state_list();

        //输出分页
        Tpl::output('show_page',$page->show());

        //输出导航
        self::profile_menu('mansong_list');
        Tpl::showpage('store_promotion_mansong_apply.list');

    }

    /**
     * 满就送套餐购买
     **/
    public function mansong_quota_addOp() {

        //输出导航
        self::profile_menu('mansong_quota_add');
        Tpl::showpage('store_promotion_mansong_quota.add');
    }

    /**
     * 满就送套餐购买保存
     **/
    public function mansong_quota_add_saveOp() {

        $mansong_quota_quantity = intval($_POST['mansong_quota_quantity']);

        if(empty($mansong_quota_quantity)) {
            showDialog(Language::get('mansong_quota_quantity_error'));
        }
        if($mansong_quota_quantity <= 0 || $mansong_quota_quantity > 12) {
            showDialog(Language::get('mansong_quota_quantity_error'));
        }

        //获取当前价格
        $current_price = intval($GLOBALS['setting_config']['promotion_mansong_price']);

        $flag = TRUE;
        //获取申请人账户信息
        $model_member = Model('member');
        $member_info = $model_member->infoMember(array('member_id'=>$_SESSION['member_id']));
        if(empty($member_info)) {
            $flag = FALSE;
        }

        //判断余额
        $apply_price = $mansong_quota_quantity * $current_price;
        if($apply_price > intval($member_info['member_goldnum'])) {
            $flag = FALSE;
        }

        if($flag) {

            $model_quota_apply = Model('p_mansong_apply');
            $param = array();
            $param['member_id'] = $_SESSION['member_id'];
            $param['member_name'] = $_SESSION['member_name'];
            $param['store_id'] = $_SESSION['store_id'];
            $param['store_name'] = $_SESSION['store_name'];
            $param['apply_quantity'] = $mansong_quota_quantity;
            $param['apply_date'] = time();
            $param['state'] = 2;
            $result = $model_quota_apply->save($param);
            if($result) {
                //扣除金币
                $update_array = array();
                $update_array['member_goldnum'] = array('sign'=>'decrease','value'=>$apply_price);
                $update_array['member_goldnumminus'] = array('sign'=>'increase','value'=>$apply_price);
                $result = $model_member->updateMember($update_array,$_SESSION['member_id']);

                //写入金币日志
                $model_gold_log = Model('gold_log');
                $param = array();
                $param['glog_memberid'] = $_SESSION['member_id'];
                $param['glog_membername'] = $_SESSION['member_name'];
                $param['glog_storeid'] = $_SESSION['store_id'];
                $param['glog_storename'] = $_SESSION['store_name'];
                $param['glog_goldnum'] = $apply_price;
                $param['glog_method'] = 2;
                $param['glog_addtime'] = time();
                $param['glog_desc'] = sprintf(Language::get('mansong_apply_verify_success_glog_desc'),$mansong_quota_quantity,$apply_price,$apply_price);
                $param['glog_stage'] = 'mansong';
                $model_gold_log->add($param);

                $model_mansong_quota = Model('p_mansong_quota');

                //获取该用户已有套餐
                $param = array();
                $param['store_id'] = $_SESSION['store_id'];
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
                $param = array();
                $param['member_id'] = $_SESSION['member_id'];
                $param['member_name'] = $_SESSION['member_name'];
                $param['store_id'] = $_SESSION['store_id'];
                $param['store_name'] = $_SESSION['store_name'];
                $param['state'] = self::QUOTA_STATE_ACTIVITY;
                $param['apply_id'] = $mansong_apply['apply_id'];
                $apply_quantity = $mansong_quota_quantity;
                $param['start_time'] = $start_time;
                $param['end_time'] = $start_time + (self::SECONDS_OF_30DAY * $apply_quantity) - 1;
                $model_mansong_quota->save($param);

                showDialog(Language::get('mansong_quota_add_success'),self::LINK_MANSONG_LIST,'succ');
            }
            else {
                showDialog(Language::get('mansong_quota_add_fail'),self::LINK_MANSONG_LIST);
            }
        }
        else {
            showDialog(Language::get('mansong_quota_add_fail_nogold'),self::LINK_MANSONG_LIST);
        }

    }

    /**
     * 获取满就送详细信息
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
        if(intval($mansong_info['store_id']) !== intval($_SESSION['store_id'])) {
            showMessage(Language::get('param_error'),'','','error');
        }
        return $mansong_info;
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
        Tpl::output('state_list',$state_list);
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return 
     */
    private function profile_menu($menu_key='') {
        $menu_array = array(
            1=>array('menu_key'=>'mansong_list','menu_name'=>Language::get('promotion_active_list'),'menu_url'=>'index.php?act=store_promotion_mansong&op=mansong_list'),
            2=>array('menu_key'=>'mansong_quota_list','menu_name'=>Language::get('promotion_quota_list'),'menu_url'=>'index.php?act=store_promotion_mansong&op=mansong_quota_list'),
            3=>array('menu_key'=>'mansong_add','menu_name'=>Language::get('promotion_join_active'),'menu_url'=>'index.php?act=store_promotion_mansong&op=mansong_add'),
            4=>array('menu_key'=>'mansong_quota_add','menu_name'=>Language::get('promotion_buy_product'),'menu_url'=>'index.php?act=store_promotion_mansong&op=mansong_quota_add'),
            5=>array('menu_key'=>'mansong_detail','menu_name'=>Language::get('mansong_active_content'),'menu_url'=>'index.php?act=store_promotion_mansong&op=mansong_detail&mansong_id='.$_GET['mansong_id']),
            6=>array('menu_key'=>'choose_goods','menu_name'=>Language::get('promotion_add_goods'),'menu_url'=>'index.php?act=store_promotion_xianshi&op=choose_goods&xianshi_id=='.$_GET['xianshi_id']),
        );
        switch (strtolower($_GET['op'])){
        	case 'mansong_list':
        	case 'mansong_quota_list':
        		unset($menu_array[3]);
        		unset($menu_array[4]);
        		unset($menu_array[5]);
        		unset($menu_array[6]);
        		break; 
        	case 'mansong_add':
        		unset($menu_array[4]);
        		unset($menu_array[5]);
        		unset($menu_array[6]);
        		break;  
        	case 'mansong_quota_add':
        		unset($menu_array[3]);
        		unset($menu_array[5]);
        		unset($menu_array[6]);
        		break;
        	case 'mansong_detail':
        		unset($menu_array[3]);
        		unset($menu_array[4]);       		
        		unset($menu_array[6]);       		
        		break;
        	case 'choose_goods':
        		unset($menu_array[3]);
        		unset($menu_array[4]);       		
        		unset($menu_array[5]);       		
        		break;        		
        	default:
        		unset($menu_array[3]);
        		unset($menu_array[4]);
        		unset($menu_array[5]);
        		unset($menu_array[6]);
        		break;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
        Tpl::output('menu_sign','mansong');
		Tpl::output('menu_sign_url','index.php?act=store_promotion_mansong&op=mansong_list');
        Tpl::output('menu_sign1','mansong');
    }

}
