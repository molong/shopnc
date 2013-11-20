<?php
/**
 * 前台商品
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

class show_groupbuyControl extends BaseHomeControl {

    //定义常量
    const STATE_VERIFY =  1;
    const STATE_CANCEL =  2;
    const STATE_PROGRESS =  3;
    const STATE_VERIFY_FAIL =  4;
    const STATE_CLOSE =  5;
    const TEMPLATE_STATE_ACTIVE = 1;
    const TEMPLATE_STATE_UNACTIVE = 2;

    public function __construct() {
        parent::__construct();

        //读取语言包
        Language::read('member_groupbuy,home_cart_index');

        //检查团购功能是否开启
        if (intval($GLOBALS['setting_config']['groupbuy_allow']) !== 1){
            showMessage(Language::get('groupbuy_unavailable'),'index.php','','error');
        }
    }

	/**
	 * 默认跳转到进行中的团购列表
	 */
    public function indexOp() {
        $this->groupbuy_listOp();
	}

    /**
     * 进行中的团购
     **/
    public function groupbuy_listOp() {
		$g_cache = ($cache = F('groupbuy'))? $cache : H('groupbuy',true,'file');
        //获取当前进行中的团购活动
        $template_in_progress = $this->get_groupbuy_template_list('in_progress');
        Tpl::output('groupbuy_template',$template_in_progress[0]);

        //输出倒计时
        $this->output_count_down($template_in_progress[0]['end_time']);

        //分页
        $page = new Page();
        $page->setEachNum(9) ;
        $page->setStyle('admin') ;

        //获取正在进行中的团购列表
        $param = array();
        $param['area_id'] = intval($_GET['groupbuy_area']);
        if(empty($param['area_id'])) {
            if(cookie('groupbuy_area')) {
                $area_array = explode(',',cookie('groupbuy_area'));
                $param['area_id'] = intval($area_array[0]);
            }
        }
        $param['class_id'] = intval($_GET['groupbuy_class']);
        if(intval($_GET['groupbuy_price']) !== 0) {
            $price_range_list = $g_cache['price'];
            foreach($price_range_list as $price_range) {
                if($price_range['range_id'] == $_GET['groupbuy_price']) {
                    $param['greater_than_groupbuy_price'] = $price_range['range_end'];
                    $param['less_than_groupbuy_price'] = $price_range['range_start'];
                } 
            }
        }
        $groupbuy_order_key = trim($_GET['groupbuy_order_key']);
        $groupbuy_order = empty($_GET['groupbuy_order'])?'desc':trim($_GET['groupbuy_order']);
        if(!empty($groupbuy_order_key)) {
            switch ($groupbuy_order_key) {
                case 'price':
                    $param['order'] = 'state asc,groupbuy_price '.$groupbuy_order;
                    break;
                case 'rebate':
                    $param['order'] = 'state asc,rebate '.$groupbuy_order;
                    break;
                case 'sale':
                    $param['order'] = 'state asc,buyer_count '.$groupbuy_order;
                    break;
            }
        }
        $groupbuy_list = $this->get_groupbuy_list('in_progress',$template_in_progress[0]['template_id'],$page,$param);
        Tpl::output('groupbuy_list',$groupbuy_list);
        Tpl::output('show_page',$page->show());

		//输出页面

        Tpl::output('class_list',$g_cache['category']);
        Tpl::output('area_list',$g_cache['area']);
        Tpl::output('price_list',$g_cache['price']);
		Tpl::output('index_sign','groupbuy');
		Tpl::output('html_title',Language::get('text_groupbuy_list'));

		Model('seo')->type('group')->show();

		Tpl::showpage('groupbuy_list');
    }

    /**
     * 即将开始的团购
     **/
    public function groupbuy_soonOp() {

        //获取即将开始的团购活动
        $param = array();
        $param['order'] = 'template_id asc';
        $param['limit'] = 1;
        $template_soon = $this->get_groupbuy_template_list('soon','',$param);
        Tpl::output('groupbuy_template',$template_soon[0]);

        //获取即将开始的团购活动
        if(!empty($template_soon) && is_array($template_soon)) {
            $groupbuy_list = $this->get_groupbuy_list('soon',$template_soon[0]['template_id']);
            Tpl::output('groupbuy_list',$groupbuy_list);
        }

		Tpl::output('index_sign','groupbuy');
		Model('seo')->type('group')->show();
		Tpl::showpage('groupbuy_soon');
    }

    /**
     * 往期团购
     **/
    public function groupbuy_historyOp() {
        
        /**
         * 获取即将开始的团购活动
         **/

        //分页
        $page = new Page();
        $page->setEachNum(3);
        $page->setStyle('admin');

        $template_history = $this->get_groupbuy_template_list('history',$page);
        Tpl::output('groupbuy_template',$template_history);
        Tpl::output('show_page',$page->show());

        $template_id_array = array();
        if(!empty($template_history) && is_array($template_history)) {
            foreach($template_history as $template) {
                $template_id_array[] = $template['template_id'];
            }
        }

        //将开始的团购活动
        $groupbuy_list = $this->get_groupbuy_list('history',implode(',',$template_id_array));
        Tpl::output('groupbuy_list',$groupbuy_list);

        //热门团购
        $this->get_hot_groupbuy_list();

		Tpl::output('index_sign','groupbuy');
		Model('seo')->type('group')->show();
		Tpl::showpage('groupbuy_history');
    }

    /**
     * 获取不同状态的团购活动
     **/
    private function get_groupbuy_template_list($type,$page='',$param = array()) {

        $model_groupbuy_template = Model('groupbuy_template');
        $param['state'] = self::TEMPLATE_STATE_ACTIVE;
        switch ($type) {
            case 'in_progress':
                $param['in_progress'] = time();
                break;
            case 'soon':
                $param['less_than_start_time'] = time();
                $param['order'] = 'start_time asc';
                break;
            case 'history':
                $param['greater_than_end_time'] = time();
                break;
            default:
                $param['in_progress'] = time();
                break;
        }
        $template_list = $model_groupbuy_template->getList($param,$page);
        return $template_list;
    }

    /**
     * 获取团购信息列表
     **/
    private function get_groupbuy_list($type,$template_id,$page = '',$param = array()) {

        $model_groupbuy = Model('goods_group');
        $param['in_template_id'] = $template_id;
        switch ($type) {
            default:
                $param['state_progress_and_close'] = true; 
                break;
        }
        $groupbuy_list = $model_groupbuy->getList($param,$page);
        return $groupbuy_list;
    }

    /**
     * 热门团购
     **/
    private function get_hot_groupbuy_list() {

        $model_groupbuy = Model('goods_group');
        $param = array();
        $param['state'] = self::STATE_CLOSE;
        $param['expire'] = time();
        $param['order'] = 'buyer_count desc';
        $param['limit'] = 10;
        $groupbuy_list = $model_groupbuy->getList($param,$page);
        Tpl::output('hot_groupbuy_list',$groupbuy_list);
    }


    /**
     * 团购详细信息
     **/
    public function groupbuy_detailOp() {

        $group_id = intval($_GET['group_id']);
        if($group_id === 0) {
            showMessage(Language::get('param_error'),'index.php?act=show_groupbuy','','error');
        }

        //获取团购详细信息
        $model_group = Model('goods_group');
        $groupbuy_info = $model_group->getOne($group_id);
        if(empty($groupbuy_info)) {
            showMessage(Language::get('param_error'),'index.php?act=show_groupbuy','','error');
        }

        //过期的团购活动更新状态
        if(intval($groupbuy_info['state']) === self::STATE_PROGRESS) {
            if(intval($groupbuy_info['end_time']) < time() || $groupbuy_info['def_quantity'] >= $groupbuy_info['max_num']) {
                $update_array = array();
                $update_array['state'] = self::STATE_CLOSE;
                $model_group->update($update_array,array('group_id'=>$group_id));
            }
        }

        //浏览数统计
        $update_array = array();
        $update_array['views'] = array('sign'=>'increase','value'=>1);
        $model_group->update($update_array,array('group_id'=>$group_id));

        Tpl::output('groupbuy_info',$groupbuy_info);

        //未审核的团购信息只能发布人查看
        $groupbuy_state = intval($groupbuy_info['state']); 
       //if($groupbuy_state === self::STATE_VERIFY || $groupbuy_state === self::STATE_VERIFY_FAIL) {
            //if(intval($groupbuy_info['store_id']) !== intval($_SESSION['store_id'])) {
                //showMessage(Language::get('param_error'),'','','error');
            //}   
        //}

        //输出状态文字
        $this->output_groupbuy_state_message($groupbuy_info);


        //获取本期热门商品
        $param = array();
        $param['template_id'] = $groupbuy_info['template_id'];
        $param['state'] = self::STATE_PROGRESS;
        $param['order'] = 'buyer_count desc';
        $param['limit'] = 10;
        $groupbuy_list_in_progress = $model_group->getList($param,$page);
        Tpl::output('hot_groupbuy_list_in_progress',$groupbuy_list_in_progress);

        //获取购买记录
        $model_order = Model('order');
        $param = array();
        $param['group_id'] = $group_id;
        $param['limit'] = 20;
        $order_list = $model_order->getOrderList($param);
        Tpl::output('order_list',$order_list);

        //获取店铺推荐商品
        $model_goods = Model('goods');
        $param = array();
        $param['store_id'] = $groupbuy_info['store_id'];
        $param['limit'] = 10;
        Tpl::output('commend_goods_list',$model_goods->getCommenGoods($param));

        //获取历史热门商品
        $this->get_hot_groupbuy_list();

		Tpl::output('index_sign','groupbuy');

		Model('seo')->type('group_content')->param(array('name'=>$groupbuy_info['group_name']))->show();
		Tpl::showpage('groupbuy_detail');
    }

    private function output_groupbuy_state_message($groupbuy_info) {

        $state_message = array();
        $start_time = intval($groupbuy_info['start_time']);
        $end_time = intval($groupbuy_info['end_time']);
        $current = time();

        switch (intval($groupbuy_info['state'])) {
        case self::STATE_VERIFY:
            $state_message = $this->get_state_array_verify();
            break;
        case self::STATE_PROGRESS:
            if($current < $start_time) {
                //未开始
                $state_message['class'] = 'not-start';
                $state_message['text'] = Language::get('groupbuy_message_not_start');
                $state_message['count_down'] = TRUE;
                $state_message['count_down_text'] = Language::get('text_start_time');
                $state_message['hide_virtual_quantity'] = TRUE;
                //输出倒计时时间
                $this->output_count_down($groupbuy_info['start_time']);
            } else {
                if($current > $end_time) {
                    //已结束
                    $state_message = $this->get_state_array_close();
                } else {
                    if($groupbuy_info['def_quantity'] >= $groupbuy_info['max_num']) {
                        $state_message = $this->get_state_array_close();
                    }
                    else {
                        //进行中
                        $state_message['class'] = 'buy-now';
                        $state_message['text'] = Language::get('groupbuy_message_start');
                        $state_message['count_down'] = TRUE;
                        $state_message['count_down_text'] = Language::get('text_end_time');
                        //输出倒计时时间
                        $this->output_count_down($groupbuy_info['end_time']);
                    }
                }
            }
            break;
        case self::STATE_VERIFY_FAIL:
            $state_message = $this->get_state_array_verify();
            break;
        case self::STATE_CLOSE:
            $state_message = $this->get_state_array_close();
            break;
        default:
            showMessage(Language::get('param_error'),'','','error');
            break;
        }
        Tpl::output('groupbuy_message',$state_message);
    }

    private function get_state_array_verify() {
        $state_message = array();
        $state_message['class'] = 'not-verify';
        $state_message['text'] = '';
        $state_message['count_down'] = FALSE;
        $state_message['count_down_text'] = '';
        $state_message['hide_virtual_quantity'] = TRUE;
        return $state_message;
    }
    private function get_state_array_close() {
        $state_message = array();
        $state_message['class'] = 'close';
        $state_message['text'] = Language::get('groupbuy_message_close');
        $state_message['count_down'] = FALSE;
        $state_message['count_down_text'] = '';
        return $state_message;
    }

    /**
     * 输出倒计时时间
     **/
    private function output_count_down($time) {
        $count_down = intval($time) - time();
        Tpl::output('count_down',$count_down);
    }

	/**
	 * 团购购买流程第一步
	 */
	public function groupbuy_buyOp(){

        //获取团购详细信息
        $group_id = intval($_GET['group_id']);
        $groupbuy_info = $this->get_groupbuy_info($group_id);

        //验证是否已登录
        if ($_SESSION['is_login'] !== '1'){
			$ref_url = request_uri();
            @header("location: index.php?act=login&ref_url=".urlencode($ref_url));
            exit;
        }
        Tpl::output('groupbuy_info',$groupbuy_info);

        //检查团购商品状态
        if(intval($groupbuy_info['state']) !== self::STATE_PROGRESS) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $current_time = time();
        if(intval($groupbuy_info['start_time']) > $current_time) { 
            showMessage(Language::get('param_error'),'','','error');
        }
        if(intval($groupbuy_info['end_time']) < $current_time) { 
            showMessage(Language::get('param_error'),'','','error');
        }

        if(intval($groupbuy_info['store_id']) === intval($_SESSION['store_id'])) {
            showMessage(Language::get('can_not_buy'),'','','error');
        }


        //输出规格信息
        $spec_id = intval($_GET['groupbuy_spec_id']);
        $spec_info = $this->get_goods_spec($spec_id);
        $quantity = intval($_GET['groupbuy_quantity']);

        //验证商品库存
        if(intval($spec_info['spec_goods_storage']) < $quantity) {
            showMessage(Language::get('goods_not_enough'),'index.php?act=show_groupbuy&op=groupbuy_detail&group_id='.$group_id,'','error');
        }

        //验证团购剩余数量
        if((intval($groupbuy_info['max_num']) - intval($groupbuy_info['def_quantity'])) < $quantity) {
            showMessage(Language::get('groupbuy_not_enough'),'index.php?act=show_groupbuy&op=groupbuy_detail&group_id='.$group_id,'','error');
        }

        if($spec_info['goods_id'] != $groupbuy_info['goods_id']) {
            showMessage(Language::get('param_error'),'','','error');
        }
        Tpl::output('spec_id',$spec_id);
        $spec_text = $this->get_goods_spec_text($spec_info);
        Tpl::output('spec_text',$spec_text);
        Tpl::output('quantity',$quantity);

        
        //实例化收货地址模型
		$mode_address	= Model('address');
		$address_list	= $mode_address->getAddressList(array('member_id'=>$_SESSION['member_id'],'order'=>'address_id desc'));
		Tpl::output('address_list',$address_list);

		Tpl::showpage('groupbuy_buy');
	}
    //获取团购详细信息
    private function get_groupbuy_info($group_id) {
        $model_group = Model('goods_group');
        $groupbuy_info = $model_group->getOne($group_id);
        if(empty($groupbuy_info)) {
            showMessage(Language::get('param_error'),'index.php?act=show_groupbuy','','error');
        }
        return $groupbuy_info;
    }
    //获取商品规格详细信息
    private function get_goods_spec($spec_id) {
        $model_goods_spec = Model('goods_spec');
        $spec_info = $model_goods_spec->getOne($spec_id);
        if(empty($spec_info)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        return $spec_info;
    }
    //获取商品规格文本
    private function get_goods_spec_text($spec_info) {
        $spec_name = unserialize($spec_info['spec_name']);
        $spec_goods = unserialize($spec_info['spec_goods_spec']);

        $spec_text = '';
        if(!empty($spec_name) && is_array($spec_name)) {
            $spec_name = array_values($spec_name);
            $i = 0;
            if(is_array($spec_name) && is_array($spec_goods)) {
                foreach ($spec_goods as $val) {
                    $spec_text .= $spec_name[$i].':'.$val.' ';
                    $i++;
                }
            }
        }
        return $spec_text;
    }

    /**
     * 修改团购状态
     **/
    private function change_groupbuy_state($condition,$state) {

        $model = Model('goods_group');
        return $model->update(array('state'=>$state),$condition);
    }

	/**
	 * 团购购买流程生成订单
	 */
	public function groupbuy_orderOp() {

        //验证是否已登录
        if ($_SESSION['is_login'] !== '1'){
			$ref_url = 'index.php?act=show_groupbuy'; 
            @header("location: index.php?act=login&ref_url=".urlencode($ref_url));
            exit;
        }

        //获取购买信息
        $spec_id = intval($_POST['spec_id']);
        $quantity = intval($_POST['quantity']);
        if(empty($spec_id) || empty($quantity)) {
            showMessage(Language::get('param_error'),'','','error');
        }

        //获取团购详细信息
        $group_id = intval($_POST['group_id']);
        $groupbuy_info = $this->get_groupbuy_info($group_id);
        $store_id = $groupbuy_info['store_id'];

        if(intval($groupbuy_info['store_id']) === intval($_SESSION['store_id'])) {
            showMessage(Language::get('can_not_buy'),'','','error');
        }

        /**
         * 验证团购状态
         **/

        //验证是否已经卖完 
        if((intval($groupbuy_info['max_num']) - intval($groupbuy_info['def_quantity'])) <= 0) {
            
            //已经卖完更新团购状态
            $this->change_groupbuy_state(array('group_id'=>$group_id),self::STATE_CLOSE);
            showMessage(Language::get('groupbuy_closed'),'','','error');
        }
        //验证是否处在进行中状态
        $current_time = time();
        if(intval($groupbuy_info['start_time']) > $current_time) {
            showMessage(Language::get('groupbuy_not_state'),'','','error');
        }
        if(intval($groupbuy_info['end_time']) < $current_time) {
            showMessage(Language::get('groupbuy_closed'),'','','error');
        }
        //验证购买数量是否小于剩余数量
        if(intval($groupbuy_info['state']) !== self::STATE_PROGRESS) {
            showMessage(Language::get('groupbuy_closed'),'','','error');
        }
        //验证限购
        $history_buy_count = 0;
        $model_order = Model('order');
        $history_order = $model_order->getOrderList(array('group_id'=>$group_id,'buyer_id'=>$_SESSION['member_id']),'','order_id');
        if(!empty($history_order) && is_array($history_order)) {
            $history_order_id = '';
            foreach($history_order as $order) {
                $history_order_id .= $order['order_id'].',';
            }
            $history_order_id = rtrim($history_order_id,',');
            $model_order_goods = Model('order_goods');
            $order_goods_list = $model_order_goods->getOrderGoodsList(array('in_order_id'=>$history_order_id),' sum(goods_num) ');
            $history_buy_count = intval($order_goods_list[0][0]);
        }
        if(intval($groupbuy_info['sale_quantity']) > 0) {
            if(intval($groupbuy_info['sale_quantity']) < ($quantity+$history_buy_count)) {
                showMessage(Language::get('groupbuy_sale_quantity').$groupbuy_info['sale_quantity'].Language::get('groupbuy_index_jian'),'','','error');
            } 

        }

        //获取规格信息
        $spec_info = $this->get_goods_spec($spec_id);

        //验证商品库存
        if(intval($spec_info['spec_goods_storage']) < $quantity) {
            showMessage(Language::get('goods_not_enough'),'index.php?act=show_groupbuy&op=groupbuy_detail&group_id='.$group_id,'','error');
        }

        //验证团购剩余数量
        if((intval($groupbuy_info['max_num']) - intval($groupbuy_info['def_quantity'])) < $quantity) {
            showMessage(Language::get('groupbuy_not_enough'),'index.php?act=show_groupbuy&op=groupbuy_detail&group_id='.$group_id,'','error');
        }

        //获取商品详细信息
        $model_goods = Model('goods');
        $goods_info = $model_goods->getGoods(array('goods_id'=>$groupbuy_info['goods_id']),'','','goods'); 

        //验证商品是否在售
        if(intval($goods_info[0]['goods_show']) !== 1 || intval($goods_info[0]['goods_state']) !== 0) {
            showMessage(Language::get('param_error'),'','','error');
        }

        //验证规格信息和库存
        if(intval($spec_info['spec_goods_storage']) < $quantity) {
            showMessage(Language::get('goods_not_enough'),'index.php?act=show_groupbuy&op=groupbuy_detail&group_id='.$group_id,'','error');
        }

        $model_store = Model('store');
        $store_info = $model_store->getOne($groupbuy_info['store_id']);

		//添加生成订单，在此步中，并没有完全生成订单，还需要接下来的其他信息进行订单填充
		$order_array		= array();
		$order_array['order_sn']		= $model_order->snOrder();
		$order_array['seller_id']		= $store_info['member_id'];
		$order_array['store_id']		= $groupbuy_info['store_id'];
		$order_array['store_name']		= $groupbuy_info['store_name'];
		$order_array['buyer_id']		= $_SESSION['member_id'];
		$order_array['buyer_name']		= $_SESSION['member_name'];
		$order_array['buyer_email']		= $_SESSION['member_email'];
		$order_array['add_time']		= time();
		$order_array['out_sn']			= $model_order->outSnOrder();
		$order_array['invoice']			= '';	//发票信息，暂时没有
		$order_array['evaluation_status']= 0;
		$order_array['order_type'] = 0;
		$order_array['order_message']	= trim($_POST['order_message']);
        $order_array['group_id'] = $group_id;
        $order_array['group_count'] = $quantity;
        $order_array['shipping_fee']	= 0; 
		$order_id	= $model_order->addOrder($order_array);

		//添加订单中的商品信息
        $order_goods_array	= array();
        $order_goods_array['order_id']		= $order_id;
        $order_goods_array['goods_id']		= $groupbuy_info['goods_id'];
				$order_goods_array['stores_id']		= $groupbuy_info['store_id'];
        $order_goods_array['goods_name']	= $groupbuy_info['goods_name'];
        $order_goods_array['spec_id']		= $spec_id;
        $order_goods_array['spec_info']		= $this->get_goods_spec_text($spec_info);
        $order_goods_array['goods_price']	= $groupbuy_info['groupbuy_price'];
        $order_goods_array['goods_num']		= $quantity;
        $order_goods_array['goods_image']	= $goods_info[0]['goods_image'];
        $model_order->addGoodsOrder($order_goods_array);
		
        Tpl::output('goods_name',$groupbuy_info['goods_name']);
        
        //更新商品库存信息
        $model_goods->updateSpecStorageGoods(array('spec_goods_storage'=>array('value'=>$quantity,'sign'=>'decrease'),'spec_salenum'=>array('value'=>$quantity,'sign'=>'increase')),$spec_id);
        $model_goods->updateGoods(array('salenum'=>array('value'=>$quantity,'sign'=>'increase')),$groupbuy_info['goods_id']);

        //更新团购剩余数
        $model_group = Model('goods_group');
        $model_group->update(array('def_quantity'=>array('value'=>$quantity,'sign'=>'increase'),'buyer_count'=>array('value'=>1,'sign'=>'increase')),array('group_id'=>$group_id));

		//订单总金额
		$order_amount = $groupbuy_info['groupbuy_price'] * $quantity;
        
        //地址
		$address_options = intval($_POST['address_options']);
		if ($address_options <= 0){
			showMessage(Language::get('cart_step1_chooseaddress_error'),'index.php?act=show_groupbuy&op=groupbuy_detail&group_id='.$group_id,'','error');
		}
		$mode_address	= Model('address');
		$address_info	= $mode_address->getOneAddress($address_options);

		//添加订单配送信息
        $address_array		= array();
        $address_array['order_id']		= $order_id;
        $address_array['true_name']		= $address_info['true_name'];
        $address_array['area_id']		= $address_info['area_id'];
        $address_array['area_info']		= $address_info['area_info'];
        $address_array['address']		= $address_info['address'];
        $address_array['zip_code']		= $address_info['zip_code'];
        $address_array['tel_phone']		= $address_info['tel_phone'];
        $address_array['mob_phone']		= $address_info['mob_phone'];
        $model_order->addAddressOrder($address_array);

		//更改订单信息，更改订单总额，商品总额，优惠价格
		$order_sn		= $order_array['order_sn'];
		$order_array	= array();
		$order_array['goods_amount']	= $order_amount;
		$order_array['discount']		= 0;

        //团购无代金券数据
        $order_array['voucher_id'] = 0;
        $order_array['voucher_price'] = 0;     
        $order_array['voucher_code'] ='';

	    $order_array['order_amount'] = $order_amount; 
		$model_order->updateOrder($order_array,$order_id);

		//添加订单完成阶段信息
		$model_order->addLogOrder(10,$order_id);
		
		@header("Location: index.php?act=cart&op=order_pay&order_id=".$order_id);
		exit;
    }
}
