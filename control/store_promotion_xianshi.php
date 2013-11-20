<?php
/**
 * 用户中心-限时折扣 
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
class store_promotion_xianshiControl extends BaseMemberStoreControl {

    const XIANSHI_STATE_UNPUBLISHED = 1;
    const XIANSHI_STATE_PUBLISHED = 2;
    const XIANSHI_STATE_CANCEL = 3;
    const XIANSHI_STATE_INVADITATION = 4;
    const XIANSHI_STATE_END = 5;
    const QUOTA_STATE_ACTIVITY = 1;
    const QUOTA_STATE_CANCEL = 2;
    const QUOTA_STATE_EXPIRE = 3;
    const APPLY_STATE_NEW = 1;
    const XIANSHI_GOODS_STATE_NORMAL = 1;
    const XIANSHI_GOODS_STATE_CANCEL = 2;
    const SECONDS_OF_DAY = 86400;
    const SECONDS_OF_30DAY = 2592000;
    const LINK_APPLY_LIST = 'index.php?act=store_promotion_xianshi&op=xianshi_apply_list';
    const LINK_APPLY_ADD = 'index.php?act=store_promotion_xianshi&op=xianshi_quota_add';
    const LINK_XIANSHI_LIST = 'index.php?act=store_promotion_xianshi&op=xianshi_list';
    const LINK_XIANSHI_MANAGE = 'index.php?act=store_promotion_xianshi&op=xianshi_manage&xianshi_id=';

    public function __construct() {
        parent::__construct() ;
        /**
         * 读取语言包
         */
        Language::read('member_layout,promotion_xianshi');
        //检查限时折扣是否开启
        if (intval(C('gold_isuse')) !== 1 || intval(C('promotion_allow')) !== 1){
            showMessage(Language::get('promotion_unavailable'),'index.php?act=store','','error');
        }

    }

    public function indexOp() {
        $this->xianshi_listOp();
    }

    /**
     * 发布的限时折扣活动列表
     **/
    public function xianshi_listOp() {

        $model_xianshi_quota = Model('p_xianshi_quota');
        $current_xianshi_quota = $model_xianshi_quota->getCurrent($_SESSION['store_id']);

        $xianshi_quota_flag = FALSE;
        if(!empty($current_xianshi_quota)) {
            $xianshi_quota_flag = TRUE;
        }
        Tpl::output('xianshi_quota_flag',$xianshi_quota_flag);

        $apply_flag = FALSE;
        $model_xianshi_apply = Model('p_xianshi_apply');
        $apply_list = $model_xianshi_apply->getList(array('store_id'=>$_SESSION['store_id'],'state'=>self::APPLY_STATE_NEW));
        if(!empty($apply_list)) {
            $apply_flag = TRUE;
            Tpl::output('xianshi_apply',$apply_list[0]);
        }
        Tpl::output('xianshi_apply_flag',$apply_flag);

        //检查当前套餐是否可用
        $current_publish_flag = TRUE;
        $remain_times = intval($current_xianshi_quota['times_limit']) - intval($current_xianshi_quota['published_times']);
        if($remain_times <= 0) {
            $current_publish_flag = FALSE;
        }
        Tpl::output('current_publish_flag',$current_publish_flag);

        if($xianshi_quota_flag) {
            
            Tpl::output('xianshi_quota_info',$current_xianshi_quota);
            Tpl::output('remain_times',$remain_times);

            $page = new Page();
            $page->setEachNum(10) ;
            $page->setStyle('admin'); 

            $model_xianshi = Model('p_xianshi');

            //更新活动状态
            $where = array();
            $where['greater_than_end_time'] = time();
            $where['state'] = self::XIANSHI_STATE_PUBLISHED;
            $where['store_id'] = $_SESSION['store_id'];
            $model_xianshi->update(array('state'=>self::XIANSHI_STATE_END),$where);

            $param = array();
            $param['store_id'] = $_SESSION['store_id'];
            $param['xianshi_name'] = trim($_GET['xianshi_name']);
            $param['state'] = trim($_GET['state']);
            $param['order'] = 'state asc,xianshi_id asc';
            $xianshi_list = $model_xianshi->getList($param,$page);
            Tpl::output('list',$xianshi_list);

            //输出分页
            Tpl::output('show_page',$page->show());

            //输出属性列表
            $this->output_xianshi_state_list();
            Tpl::output('state_published',self::XIANSHI_STATE_PUBLISHED);
        }

        //输出导航
        self::profile_menu('xianshi_list');
        Tpl::showpage('store_promotion_xianshi.list');
    }

    /**
     * 添加限时折扣活动
     **/
    public function xianshi_addOp() {

        $model_xianshi_quota = Model('p_xianshi_quota');
        $current_xianshi_quota = $model_xianshi_quota->getCurrent($_SESSION['store_id']);
        
        //检查当前套餐是否可用
        $result = $this->check_current_xianshi_quota($current_xianshi_quota);
        if(!$result) {
            showMessage(Language::get('xianshi_quota_current_error1'),'','','error');
        }

        $remain_times = intval($current_xianshi_quota['times_limit']) - intval($current_xianshi_quota['published_times']);
        if($remain_times <=0) {
            showMessage(Language::get('xianshi_quota_current_error3'),'','','error');
        }

        Tpl::output('current_xianshi_quota',$current_xianshi_quota);

        $next_xianshi_quota = $model_xianshi_quota->getNext($_SESSION['store_id']);
        Tpl::output('next_xianshi_quota',$next_xianshi_quota);
        
        //输出导航
        self::profile_menu('xianshi_add');
        Tpl::showpage('store_promotion_xianshi.add');

    }

    /**
     * 保存添加的限时折扣活动
     **/
    public function xianshi_saveOp() {
        //获取当前套餐
        $model_xianshi_quota = Model('p_xianshi_quota');
        $current_xianshi_quota = $model_xianshi_quota->getCurrent($_SESSION['store_id']);
        //检查当前套餐是否可用
        $result = $this->check_current_xianshi_quota($current_xianshi_quota);
        if(!$result) {
            showDialog(Language::get('xianshi_quota_current_error1'));
        }

        //验证输入
        $xianshi_name = trim($_POST['xianshi_name']);
        $start_time = strtotime($_POST['start_time']);
        $end_time = strtotime($_POST['end_time']) + self::SECONDS_OF_DAY - 1;
        $discount = floatval($_POST['discount']);
        $buy_limit = 0; 
        $quota_start_time = intval($current_xianshi_quota['start_time']);
        $quota_end_time = intval($current_xianshi_quota['end_time']);

        if(empty($xianshi_name)) {
            showDialog(Language::get('xianshi_name_error'));
        }
        if($start_time >= $end_time) {
            showDialog(Language::get('greater_than_start_time'));
        }
        if($start_time < $quota_start_time) {
            showDialog(sprintf(Language::get('xianshi_add_start_time_explain'),date('Y-m-d',$current_xianshi_quota['start_time'])));
        }
        if($end_time > $quota_end_time) {
            showDialog(sprintf(Language::get('xianshi_add_end_time_explain'),date('Y-m-d',$current_xianshi_quota['end_time'])));
        }
        if($discount > 9.9 || $discount < 0.1) {
            showDialog(Language::get('xianshi_discount_explain'));
        }

        //修改套餐计数
        $update = array();
        $update['published_times'] = array('sign'=>'increase','value'=>1);
        $where = array();
        $where['quota_id'] = $current_xianshi_quota['quota_id'];
        $model_xianshi_quota->update($update,$where);

        //生成活动
        $model_xianshi = Model('p_xianshi');
        $param = array();
        $param['xianshi_name'] = $xianshi_name;
        $param['start_time'] = $start_time;
        $param['end_time'] = $end_time;
        $param['store_id'] = $current_xianshi_quota['store_id'];
        $param['store_name'] = $current_xianshi_quota['store_name'];
        $param['member_id'] = $current_xianshi_quota['member_id'];
        $param['member_name'] = $current_xianshi_quota['member_name'];
        $param['quota_id'] = $current_xianshi_quota['quota_id'];
        $param['discount'] = $discount;
        $param['buy_limit'] = $buy_limit;
        $param['goods_limit'] = $current_xianshi_quota['goods_limit'];
        $param['state'] = self::XIANSHI_STATE_UNPUBLISHED;
        $result = $model_xianshi->save($param);
        if($result) {

				// 自动发布动态
				// goods_id,store_id,goods_name,goods_image,goods_store_price,py_price
				$data_array = array();
				$data_array['goods_id']			= $result;
				$data_array['store_id']			= $_SESSION['store_id'];
				$data_array['goods_name']		= $goods_array['goods_name'];
				$data_array['goods_image']		= $goods_array['goods_image'];
				$data_array['goods_store_price']= $goods_array['goods_store_price'];
				$data_array['py_price']			= $goods_array['py_price'];
				$this->storeAutoShare($data_array, 'xianshi');
            showDialog(Language::get('xianshi_add_success'),self::LINK_XIANSHI_MANAGE.$result,'succ','',3);
        }else {
            showDialog(Language::get('xianshi_add_fail'));
        }
    } 

    /**
     * 限时折扣活动管理
     **/
    public function xianshi_manageOp() {

        $xianshi_id = intval($_GET['xianshi_id']);
        $xianshi_info = $this->get_xianshi_info($xianshi_id);
        Tpl::output('xianshi_info',$xianshi_info);

        $unpublish = false;
        if(intval($xianshi_info['state']) === self::XIANSHI_STATE_UNPUBLISHED) { 
            $unpublish = true;
        }
        Tpl::output('unpublish',$unpublish);

        $this->output_xianshi_state_list();

        $model_xianshi_goods = Model('p_xianshi_goods');

        $xianshi_goods_count = $model_xianshi_goods->getCount(array('xianshi_id'=>$xianshi_id));
        Tpl::output('xianshi_goods_count',$xianshi_goods_count);

        if(intval($xianshi_goods_count) > 0) {

            //获取限时折扣商品列表
            $param = array();
            $param['xianshi_id'] = $xianshi_id;
            $goods_list = $model_xianshi_goods->getList($param);
            $this->output_xianshi_goods_state_list();
        }
        else {
            $goods_list = array();
        }
        Tpl::output('list',$goods_list);
        Tpl::output('xianshi_state_published',self::XIANSHI_STATE_PUBLISHED);
        Tpl::output('goods_state_cancel',self::XIANSHI_GOODS_STATE_CANCEL);

        //输出导航
        self::profile_menu('xianshi_manage');
        Tpl::showpage('store_promotion_xianshi.manage');
    }

    /**
     * 限时折扣活动取消
     **/
    public function xianshi_cancelOp() {

        $xianshi_id = intval($_GET['xianshi_id']);
        $xianshi_info = $this->get_xianshi_info($xianshi_id);

        if(intval($xianshi_info['state']) !== self::XIANSHI_STATE_PUBLISHED) { 
            showMessage(Language::get('param_error'),'','','error');
        }

        $model_xianshi_goods = Model('p_xianshi_goods');
        $update = array();
        $update['state'] = self::XIANSHI_GOODS_STATE_CANCEL;
        $where = array();
        $where['xianshi_id'] = $xianshi_id;
        $model_xianshi_goods->update($update,$where);

        $update['state'] = self::XIANSHI_STATE_CANCEL;
        $model_xianshi = Model('p_xianshi');
        if($model_xianshi->update($update,$where)) {
            showMessage(Language::get('xianshi_cancel_success'),'');
        }
        else {
            showMessage(Language::get('xianshi_cancel_fail'),'','','error');
        }

    }
    /**
     * 限时折扣活动发布
     **/
    public function xianshi_publishOp() {

        $xianshi_id = intval($_GET['xianshi_id']);
        $xianshi_info = $this->get_xianshi_info($xianshi_id);
        if(intval($xianshi_info['state']) !== self::XIANSHI_STATE_UNPUBLISHED) {
            showMessage(Language::get('param_error'),'','','error');
        }

        $model_xianshi_goods = Model('p_xianshi_goods');
        $xianshi_goods_list = $model_xianshi_goods->getList(array('xianshi_id'=>$xianshi_id));
        if(empty($xianshi_goods_list)) {
            showMessage(Language::get('xianshi_no_goods'),'','','error');
        }

        //更新商品表状态
        $goods_id = array();
        foreach($xianshi_goods_list as $xianshi_goods) {
            $goods_id[] = $xianshi_goods['goods_id'];
        }
        $model_goods = Model('goods');
        $update = array('xianshi_flag'=>1);
        $model_goods->updateGoods($update,$goods_id);

        $model_xianshi = Model('p_xianshi');
        $update = array();
        $update['state'] = self::XIANSHI_STATE_PUBLISHED;
        $where = array();
        $where['xianshi_id'] = $xianshi_id;
        if($model_xianshi->update($update,$where)) {
        	// 自动发布动态
        	// goods_id,goods_name,goods_store_price,discount,goods_image
        	foreach($xianshi_goods_list as $val){
        		$data_array = array();
        		$data_array['goods_id']				= $val['goods_id'];
        		$data_array['goods_name']			= $val['goods_name'];
        		$data_array['goods_store_price']	= $val['goods_store_price'];
        		$data_array['discount']				= $val['discount'];
        		$data_array['goods_image']			= $val['goods_image'];
        		$data_array['store_id']				= $_SESSION['store_id'];
        		$this->storeAutoShare($data_array, 'xianshi');
        	}
            showMessage(Language::get('xianshi_publish_success'),'');
        }
        else {
            showMessage(Language::get('xianshi_publish_fail'),'','','error');
        }
    }
    /**
     * 检查当前套餐是否可用
     **/
    private function check_current_xianshi_quota($current_xianshi_quota) {
        $result = TRUE;
        if(empty($current_xianshi_quota)) {
            $result = FALSE;
        }
        $remain_times = intval($current_xianshi_quota['times_limit']) - intval($current_xianshi_quota['published_times']);
        if($remain_times <= 0) {
            $result = FALSE;
        }
        return $result;
    }


    /**
     * 购买的限时折扣
     **/
    public function xianshi_quota_listOp() {

        $model_xianshi_quota = Model('p_xianshi_quota');

        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin'); 

        //更新过期套餐状态
        $where['greater_than_end_time'] = time();
        $where['state'] = self::QUOTA_STATE_ACTIVITY;
        $where['store_id'] = $_SESSION['store_id'];
        $model_xianshi_quota->update(array('state'=>self::QUOTA_STATE_EXPIRE),$where);
         
        $param = array();
        $param['store_id'] = $_SESSION['store_id'];
        $param['order'] = 'state asc,start_time asc';
        $xianshi_list = $model_xianshi_quota->getList($param,$page);
        Tpl::output('list',$xianshi_list);
        $this->output_xianshi_quota_state_list();

        //输出分页
        Tpl::output('show_page',$page->show());

        //输出导航
        self::profile_menu('quota_list');
        Tpl::showpage('store_promotion_xianshi_quota.list');

    }

    /**
     * 购买的限时折扣
     **/
    public function xianshi_apply_listOp() {

        $model_xianshi = Model('p_xianshi_apply');

        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin'); 
        
        $param = array();
        $param['store_id'] = $_SESSION['store_id'];
        $param['order'] = 'state asc,apply_date asc';
        $list = $model_xianshi->getList($param,$page);
        Tpl::output('list',$list);

        //输出分页
        Tpl::output('show_page',$page->show());

        //输出导航
        self::profile_menu('xianshi_list');
        Tpl::showpage('store_promotion_xianshi_apply.list');

    }

    /**
     * 限时折扣套餐购买
     **/
    public function xianshi_quota_addOp() {

        //输出导航
        self::profile_menu('xianshi_quota_add');
        Tpl::showpage('store_promotion_xianshi_quota.add');
    }

    /**
     * 限时折扣套餐购买保存
     **/
    public function xianshi_quota_add_saveOp() {

        $xianshi_quota_quantity = intval($_POST['xianshi_quota_quantity']);

        if(empty($xianshi_quota_quantity)) {
            showDialog(Language::get('xianshi_quota_quantity_error'));
        }
        if($xianshi_quota_quantity <= 0 || $xianshi_quota_quantity > 12) {
            showDialog(Language::get('xianshi_quota_quantity_error'));
        }

        //获取当前价格
        $current_price = intval($GLOBALS['setting_config']['promotion_xianshi_price']);
        $times_limit = intval($GLOBALS['setting_config']['promotion_xianshi_times_limit']);
        $goods_limit = intval($GLOBALS['setting_config']['promotion_xianshi_goods_limit']);

        $flag = TRUE;
        //获取申请人账户信息
        $model_member = Model('member');
        $member_info = $model_member->infoMember(array('member_id'=>$_SESSION['member_id']));
        if(empty($member_info)) {
            $flag = FALSE;
        }

        //判断余额
        $apply_price = $xianshi_quota_quantity * $current_price;
        if($apply_price > intval($member_info['member_goldnum'])) {
            $flag = FALSE;
        }

        if($flag) {
            $model_quota_apply = Model('p_xianshi_apply');
            $param = array();
            $param['member_id'] = $_SESSION['member_id'];
            $param['member_name'] = $_SESSION['member_name'];
            $param['store_id'] = $_SESSION['store_id'];
            $param['store_name'] = $_SESSION['store_name'];
            $param['apply_quantity'] = $xianshi_quota_quantity;
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
                $param['glog_desc'] = sprintf(Language::get('xianshi_apply_verify_success_glog_desc'),$xianshi_quota_quantity,$apply_price,$apply_price);
                $param['glog_stage'] = 'xianshi';
                $model_gold_log->add($param);

                $model_xianshi_quota = Model('p_xianshi_quota');

                //获取该用户已有套餐
                $param = array();
                $param['store_id'] = $_SESSION['store_id'];
                $param['order'] = 'end_time desc';
                $param['state'] = self::QUOTA_STATE_ACTIVITY;
                $param['limit'] = 1;
                $last_xianshi_quota = $model_xianshi_quota->getList($param);

                //开始时间为第二天零点
                $start_time = time(); 
                //计算套餐开始时间
                if(!empty($last_xianshi_quota)) {
                    $last_end_time = intval($last_xianshi_quota[0]['end_time']) + 1;
                    if($last_end_time > $start_time) {
                        $start_time = $last_end_time;
                    }

                }

                //生成套餐
                $param = array();
                $param['member_id'] = $_SESSION['member_id'];
                $param['member_name'] = $_SESSION['member_name'];
                $param['store_id'] = $_SESSION['store_id'];
                $param['store_name'] = $_SESSION['store_name'];
                $param['times_limit'] = $times_limit;
                $param['goods_limit'] = $goods_limit;
                $param['state'] = 1;
                $param['apply_id'] = $result;
                $apply_quantity = $xianshi_quota_quantity ;
                $param_array = array();
                for($i=0;$i<$apply_quantity;$i++) {
                    $end_time = $start_time + self::SECONDS_OF_30DAY - 1;
                    $param['start_time'] = $start_time;
                    $param['end_time'] = $end_time;
                    $param_array[] = $param;
                    $start_time += self::SECONDS_OF_30DAY;
                }
                $model_xianshi_quota->save_array($param_array);

                showDialog(Language::get('xianshi_quota_add_success'),self::LINK_XIANSHI_LIST,'succ');
            }
            else {
                showDialog(Language::get('xianshi_quota_add_fail'),self::LINK_XIANSHI_LIST);
            }
        }else {
            showDialog(Language::get('xianshi_quota_add_fail_nogold'),self::LINK_XIANSHI_LIST);
        }
    }

    /**
     * 选择活动商品
     **/
    public function choose_goodsOp() {

        $xianshi_id = intval($_GET['xianshi_id']);
        $xianshi_info = $this->get_xianshi_info($xianshi_id);

        //如果已经发布不能再选择商品
        if(intval($xianshi_info['state']) !== self::XIANSHI_STATE_UNPUBLISHED) {
            showMessage(Language::get('param_error'),'','','error');
        }

        Tpl::output('xianshi_info',$xianshi_info);
        $this->output_xianshi_state_list();

        $model_xianshi_goods = Model('p_xianshi_goods');
        $xianshi_goods_count = $model_xianshi_goods->getCount(array('xianshi_id'=>$xianshi_id));
        Tpl::output('xianshi_goods_count',$xianshi_goods_count);

        //已经添加的商品列表
        $xianshi_goods_list = $model_xianshi_goods->getList(array('quota_id'=>$xianshi_info['quota_id'],'state'=>self::XIANSHI_GOODS_STATE_NORMAL));
        $xianshi_goods_id_list = array();
        if(!empty($xianshi_goods_list)) {
            foreach($xianshi_goods_list as $xianshi_goods) {
            $xianshi_goods_id_list[] = $xianshi_goods['goods_id']; 
            }
        }
        tpl::output('xianshi_goods_id_list',$xianshi_goods_id_list);

        $model_goods = Model('goods');

        $page = new Page();
        $page->setEachNum(10) ;
        $page->setStyle('admin'); 
        
        $param = array();
        $param['store_id'] = $_SESSION['store_id'];
        $param['goods_name'] = trim($_GET['goods_name']);
        $param['order'] = 'goods_id desc';
        $goods_list = $model_goods->getGoods($param,$page,'*','goods');

        Tpl::output('list',$goods_list);

        //输出分页
        Tpl::output('show_page',$page->show());

        //输出导航
        self::profile_menu('choose_goods');
        Tpl::showpage('store_promotion_xianshi.goods');
    }

    /**
     * 限时折扣商品添加
     **/
    public function xianshi_goods_addOp() {

        $goods_id = intval($_GET['goods_id']);
        $goods_info = $this->get_goods_info($goods_id);
        $xianshi_id = intval($_GET['xianshi_id']);
        $xianshi_info = $this->get_xianshi_info($xianshi_id);

        //如果已经发布不能再选择商品
        if(intval($xianshi_info['state']) !== self::XIANSHI_STATE_UNPUBLISHED) {
            echo 'error';die;
        }

        $model_xianshi_goods = Model('p_xianshi_goods');

        //验证已经添加的商品数
        $xianshi_goods_count = $model_xianshi_goods->getCount(array('xianshi_id'=>$xianshi_id));
        if(intval($xianshi_goods_count) >= intval($xianshi_info['goods_limit'])) {
            echo 'error';die;
        } 

        //判断是否已经添加
        $param = array();
        $param['goods_id'] = $goods_id;
        $param['quota_id'] = $xianshi_info['quota_id'];
        $param['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
        $result = $model_xianshi_goods->isExist($param);
        if($result) {
            echo 'error';die;
        }

        //修改商品表限时折扣价格
        $model_goods = Model('goods');
        $model_goods->updateGoods(array('xianshi_discount'=>$xianshi_info['discount']),$goods_id);

        //添加到活动商品表
        $param = array();
        $param['xianshi_id'] = $xianshi_info['xianshi_id'];
        $param['quota_id'] = $xianshi_info['quota_id'];
        $param['goods_id'] = $goods_info['goods_id'];
        $param['goods_name'] = $goods_info['goods_name'];
        $param['goods_store_price'] = $goods_info['goods_store_price'];
        $param['discount'] = $xianshi_info['discount'];
        $param['buy_limit'] = 0;
        $param['goods_image'] = $goods_info['goods_image'];
        $param['state'] = self::XIANSHI_GOODS_STATE_NORMAL;
        if($model_xianshi_goods->save($param)) {
            echo 'success';die;
        }
        else {
            echo 'error';die;
        }
    }

    /**
     * 限时折扣商品删除
     **/
    public function xianshi_goods_deleteOp() {

        $xianshi_goods_id = intval($_GET['xianshi_goods_id']);
        if($xianshi_goods_id == 0) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $model_xianshi_goods = Model('p_xianshi_goods');
        $xianshi_goods_info = $model_xianshi_goods->getOne($xianshi_goods_id);
        if(empty($xianshi_goods_info)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $xianshi_info = $this->get_xianshi_info(intval($xianshi_goods_info['xianshi_id']));
        if(intval($xianshi_info['store_id']) !== intval($_SESSION['store_id'])) {
            showMessage(Language::get('param_error'),'','','error');
        }
        if(intval($xianshi_info['state']) !== self::XIANSHI_STATE_UNPUBLISHED) {
            showMessage(Language::get('param_error'),'','','error');
        }
        if($model_xianshi_goods->drop(array('xianshi_goods_id'=>$xianshi_goods_id))) {
        	redirect();
//            showMessage(Language::get('xianshi_goods_delete_success'),'');
        }
        else {
            showMessage(Language::get('xianshi_goods_delete_fail'),'','','error');
        }
        
    }

    /**
     * 限时折扣商品取消
     **/
    public function xianshi_goods_cancelOp() {

        $xianshi_goods_id = intval($_GET['xianshi_goods_id']);
        if($xianshi_goods_id === 0) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $model_xianshi_goods = Model('p_xianshi_goods');
        $xianshi_goods_info = $model_xianshi_goods->getOne($xianshi_goods_id);
        if(empty($xianshi_goods_info)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $xianshi_info = $this->get_xianshi_info(intval($xianshi_goods_info['xianshi_id']));
        if(intval($xianshi_info['store_id']) !== intval($_SESSION['store_id'])) {
            showMessage(Language::get('param_error'),'','','error');
        }
        if(intval($xianshi_info['state']) !== self::XIANSHI_STATE_PUBLISHED) {
            showMessage(Language::get('param_error'),'','','error');
        }
        
        //更新商品表状态标志
        $model_goods = Model('goods');
        $model_goods->updateGoods(array('xianshi_flag'=>0),$xianshi_goods_info['goods_id']); 

        $update = array();
        $update['state'] = self::XIANSHI_GOODS_STATE_CANCEL;
        $where = array();
        $where['xianshi_goods_id'] = $xianshi_goods_id;
        if($model_xianshi_goods->update($update,$where)) {
        	redirect();
        }
        else {
            showMessage(Language::get('xianshi_goods_cancel_fail'),'','','error');
        }

    }

    /**
     * 获取商品详细信息
     **/
    private function get_goods_info($goods_id) {
        if($goods_id === 0) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $model_goods = Model('goods');
        $goods_info = $model_goods->getOne($goods_id);
        if(empty($goods_info)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        if(intval($goods_info['store_id']) !== intval($_SESSION['store_id'])) {
            showMessage(Language::get('param_error'),'','','error');
        }
        return $goods_info;
    }
    /**
     * 获取限时折扣详细信息
     **/
    private function get_xianshi_info($xianshi_id) {
        if(intval($xianshi_id) === 0) {
            showMessage(Language::get('param_error'),'','','error');
        }

        //获取限时折扣详情
        $model_xianshi = Model('p_xianshi');
        $xianshi_info = $model_xianshi->getOne($xianshi_id);
        if(empty($xianshi_info)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        if(intval($xianshi_info['store_id']) !== intval($_SESSION['store_id'])) {
            showMessage(Language::get('param_error'),'','','error');
        }
        return $xianshi_info;
    }

    /**
     * 输出限时折扣套餐状态列表
     **/
    private function output_xianshi_quota_state_list() {
        $state_list = array(
            0 => Language::get('all_state'),
            self::QUOTA_STATE_ACTIVITY=> Language::get('nc_normal'),
            self::QUOTA_STATE_CANCEL=> Language::get('nc_cancel'),
            self::QUOTA_STATE_EXPIRE=> Language::get('nc_end')
    );
        Tpl::output('xianshi_quota_state_list',$state_list);
    }

    /**
     * 输出限时活动状态列表
     **/
    private function output_xianshi_state_list() {
        $state_list = array(
            0 => Language::get('all_state'),
            self::XIANSHI_STATE_UNPUBLISHED => Language::get('xianshi_state_unpublished'),
            self::XIANSHI_STATE_PUBLISHED => Language::get('xianshi_state_published'),
            self::XIANSHI_STATE_CANCEL => Language::get('nc_cancel'),
            self::XIANSHI_STATE_INVADITATION => Language::get('nc_invalidation'),
            self::XIANSHI_STATE_END => Language::get('nc_end')
    );
        Tpl::output('state_list',$state_list);
    }

    /**
     * 输出限时活动商品状态列表
     **/
    private function output_xianshi_goods_state_list() {
        $state_list = array(
            self::XIANSHI_GOODS_STATE_NORMAL => Language::get('text_normal'),
            self::XIANSHI_GOODS_STATE_CANCEL=> Language::get('nc_cancel')
        );
        Tpl::output('xianshi_goods_state_list',$state_list);
    }

    //ajax操作
    public function ajaxOp(){

        $xianshi_goods_id = intval($_GET['id']);

        $model_xianshi_goods = Model('p_xianshi_goods');
        $update = array();
        $where = array();
        $where['xianshi_goods_id'] = $xianshi_goods_id; 
 
        switch ($_GET['branch']){
        case 'discount':
            $discount = floatval($_GET['value']);
            if($discount >=0.1 && $discount <=9.9) {
                
                $xianshi_goods_info = $model_xianshi_goods->getOne($xianshi_goods_id);
                if(!empty($xianshi_goods_info)) {
                    //修改商品表限时折扣价格
                    $goods_info = $this->get_goods_info($xianshi_goods_info['goods_id']);
                    if(!empty($goods_info)) {
                        $model_goods = Model('goods');
                        $model_goods->updateGoods(array('xianshi_discount'=>$discount),$xianshi_goods_info['goods_id']);
                        $update['discount'] = $discount; 
                        $model_xianshi_goods->update($update,$where);
                    }
                }
            }
            break;
        case 'buy_limit':
            $buy_limit = intval($_GET['value']);
            if($buy_limit > 0) {
                $update['buy_limit'] = $buy_limit; 
                $model_xianshi_goods->update($update,$where);
            }
            break;
        }

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
            1=>array('menu_key'=>'xianshi_list','menu_name'=>Language::get('promotion_active_list'),'menu_url'=>'index.php?act=store_promotion_xianshi&op=xianshi_list'),
            2=>array('menu_key'=>'quota_list','menu_name'=>Language::get('promotion_quota_list'),'menu_url'=>'index.php?act=store_promotion_xianshi&op=xianshi_quota_list'),
            3=>array('menu_key'=>'xianshi_add','menu_name'=>Language::get('promotion_join_active'),'menu_url'=>'index.php?act=store_promotion_xianshi&op=xianshi_add'),
            4=>array('menu_key'=>'xianshi_quota_add','menu_name'=>Language::get('promotion_buy_product'),'menu_url'=>'index.php?act=store_promotion_xianshi&op=xianshi_quota_add'),
            5=>array('menu_key'=>'xianshi_manage','menu_name'=>Language::get('promotion_goods_manage'),'menu_url'=>'index.php?act=store_promotion_xianshi&op=xianshi_manage&xianshi_id='.$_GET['xianshi_id']),
            6=>array('menu_key'=>'choose_goods','menu_name'=>Language::get('promotion_add_goods'),'menu_url'=>'index.php?act=store_promotion_xianshi&op=choose_goods&xianshi_id=='.$_GET['xianshi_id']),
        );
        switch (strtolower($_GET['op'])){
        	case 'xianshi_list':
        	case 'xianshi_quota_list':
        		unset($menu_array[3]);
        		unset($menu_array[4]);
        		unset($menu_array[5]);
        		unset($menu_array[6]);
        		break; 
        	case 'xianshi_add':
        		unset($menu_array[4]);
        		unset($menu_array[5]);
        		unset($menu_array[6]);
        		break;  
        	case 'xianshi_quota_add':
        		unset($menu_array[3]);
        		unset($menu_array[5]);
        		unset($menu_array[6]);
        		break;
        	case 'xianshi_manage':
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
        Tpl::output('menu_sign','xianshi');
		Tpl::output('menu_sign_url','index.php?act=store_promotion_xianshi&op=xianshi_list');
        Tpl::output('menu_sign1','xianshi');
    }
}
