<?php
/**
 * 立即购买操作
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class buynowControl extends BaseHomeControl {

    const XIANSHI_STATE_PUBLISHED = 2;
    const XIANSHI_GOODS_STATE_NORMAL = 1;
    const MANSONG_STATE_PUBLISHED = 2;

	/**
	 * 构造函数 
	 */
	public function __construct() {
		parent::__construct();
		//读取语言包
		Language::read('home_cart_index');
		if (!$_SESSION['member_id']){
			redirect('index.php?act=login&ref_url='.urlencode(request_uri()));
		}
		//验证该会员是否禁止购买
        $member_model = Model('member');
        $member_id = intval($_SESSION['member_id']);
        $member_info = $member_model->infoMember(array('member_id'=>"{$member_id}"));
		if(empty($member_info) || !$member_info['is_buy']){
        	showMessage(Language::get('cart_buy_noallow'),'','html','error');
        }
        unset($member_id);
        unset($member_info);
        unset($member_model);
	}
	/**
	 * 立即购买第一步
	 */
	public function indexOp(){
		$spec_id = intval($_GET['buynow_spec_id']);
		$quantity = intval($_GET['buynow_quantity']);

		if ($spec_id <= 0 || $quantity <= 0){
			showMessage(Language::get('wrong_argument'),'index.php','','error');
		}

		//检测商品是否符合购买条件
		$legalGoods_info = $this->getLegalGoods($spec_id,$quantity);

        //促销处理
        //限时折扣处理
        $legalGoods_info = $this->xianshi($legalGoods_info);
        Tpl::output('xianshi_flag',$legalGoods_info['xianshi_flag']);
        if($legalGoods_info['xianshi_flag']) {
            Tpl::output('xianshi_info',$legalGoods_info['xianshi_info']);
            Tpl::output('promotion_explain',$legalGoods_info['xianshi_explain']);
        } else {
            //满即送处理
            $mansong = $this->mansong($legalGoods_info['goods_info'][0]['store_id'],$legalGoods_info['store_goods_price']);
            $legalGoods_info['store_goods_price'] -= $mansong['rule_discount'];

            //输出满就送活动
            Tpl::output('mansong_flag',$mansong['mansong_flag']);
            Tpl::output('rule_shipping_free',$mansong['rule_shipping_free']);
            Tpl::output('promotion_explain',$mansong['promotion_explain_show']);
        }
        Tpl::output('store_goods_price',$legalGoods_info['store_goods_price']);
        
        $legalGoods_info['goods_info'][0]['store_name'] = $legalGoods_info['store_info']['store_name'];
        $legalGoods_info['goods_info'][0]['store_domain'] = $legalGoods_info['store_info']['store_domain'];
		
        Tpl::output('cart_array',$legalGoods_info['goods_info']);
		Tpl::output('store_info',$legalGoods_info['store_info']);

		//上一页地址
		$referer_url = getReferer();

		//实例化收货地址模型
		$mode_address	= Model('address');
		$address_list	= $mode_address->getAddressList(array('member_id'=>$_SESSION['member_id'],'order'=>'address_id desc'));
		Tpl::output('address_list',$address_list);
		//如果没有参加其他活动，获取可用代金券列表
        if(C('voucher_allow') == 1 && $mansong['mansong_flag'] == false && $legalGoods_info['xianshi_flag'] ==false){
            //获取代金券列表
            $model = Model();
            $where = array();
            $where['voucher_owner_id'] = "{$_SESSION['member_id']}";
            $where['voucher_store_id'] = "{$legalGoods_info['store_info']['store_id']}";
            $where['voucher_state'] = '1';
            $where['voucher_limit'] = array('elt',$legalGoods_info['goods_info'][0]['spec_goods_price']);
            $where['voucher_start_date'] = array('elt',time());
            $where['voucher_end_date'] = array('egt',time());
            $voucher_list = $model->table('voucher')->where($where)->order('voucher_price asc')->select();
            Tpl::output('voucher_list',$voucher_list);
        }
        //直接购买标识
        Tpl::output('buynow','1');

		Tpl::showpage('cart_step1');
	}
	
	/**
	 * 组合销售购买第一步
	 */
	public function bundlingOp(){
		$quantity = intval($_POST['quantity']);
		$bl_id = intval($_POST['bundling_id']);
		$bl_price = floatval($_POST['bl_price']);
		if(empty($_POST['spec']) || !is_array($_POST['spec']) || $quantity<=0 || $bl_id<=0 || $bl_price<=0 ){
			showMessage(Language::get('wrong_argument'),'index.php','','error');
		}
		
		//检测商品是否符合购买条件
		$legalGoods_info = $this->getLegalBundlingGoods($_POST['spec'], $quantity, $bl_id);
		$promotion_explain = Language::get('cart_step1_bundling_explain1').ncPriceFormat(intval($legalGoods_info['bundling_economize'])/$quantity).Language::get('cart_step1_bundling_explain2');
		Tpl::output('bundling_flag',true);
		//促销处理
		//满即送处理
		$mansong = $this->mansong($legalGoods_info['goods_info'][0]['store_id'],$legalGoods_info['store_goods_price']);
		$legalGoods_info['store_goods_price'] -= $mansong['rule_discount'];

		if($mansong['rule_shipping_free'] === true){
			Tpl::output('bl_freight', 0);
		}else{
			Tpl::output('bl_freight', $legalGoods_info['bl_freight']);
		}
		
		//输出满就送活动
		Tpl::output('mansong_flag',$mansong['mansong_flag']);
		Tpl::output('rule_shipping_free',$mansong['rule_shipping_free']);
		Tpl::output('promotion_explain',$promotion_explain.$mansong['promotion_explain_show']);

		Tpl::output('store_goods_price',$legalGoods_info['store_goods_price']);
	
		$legalGoods_info['goods_info'][0]['store_name'] = $legalGoods_info['store_info']['store_name'];
		$legalGoods_info['goods_info'][0]['store_domain'] = $legalGoods_info['store_info']['store_domain'];
	
		Tpl::output('cart_array',$legalGoods_info['goods_info']);
		Tpl::output('store_info',$legalGoods_info['store_info']);
	
		//上一页地址
		$referer_url = getReferer();
	
		//实例化收货地址模型
		$mode_address	= Model('address');
		$address_list	= $mode_address->getAddressList(array('member_id'=>$_SESSION['member_id'],'order'=>'address_id desc'));
		Tpl::output('address_list',$address_list);
		//如果没有参加其他活动，获取可用代金券列表
		if(C('voucher_allow') == 1 && $mansong['mansong_flag'] == false && $legalGoods_info['xianshi_flag'] ==false){
			//获取代金券列表
			$model = Model();
			$where = array();
			$where['voucher_owner_id'] = "{$_SESSION['member_id']}";
			$where['voucher_store_id'] = "{$legalGoods_info['store_info']['store_id']}";
			$where['voucher_state'] = '1';
			$where['voucher_limit'] = array('elt',$legalGoods_info['goods_info'][0]['spec_goods_price']);
			$where['voucher_start_date'] = array('elt',time());
			$where['voucher_end_date'] = array('egt',time());
			$voucher_list = $model->table('voucher')->where($where)->order('voucher_price asc')->select();
			Tpl::output('voucher_list',$voucher_list);
		}
		Tpl::output('bundling','1');//组合销售标记
		Tpl::output('bundling_id', $bl_id);	// 组合销售id
		$spec = '';
		foreach ($_POST['spec'] as $k=>$v){
			$spec	.= $k.':'.$v.'|';
		}
		Tpl::output('spec', rtrim($spec,'|'));	// 规格信息
		Tpl::output('quantity', $quantity);		// 数量
	
		Tpl::showpage('cart_step1');
	}
	/**
	 * 组合销售购物流程第二步
	 */
	public function bundling_step2Op() {
		$bl_id		= intval($_POST['bundling_id']);
		$quantity	= intval($_POST['quantity']);
		$spec_array	= explode('|', $_POST['spec']);
		$spec 		= array();
		foreach ($spec_array as $val){
			list($k,$v) = explode(':', $val);
			$spec[$k]	= $v;
		}
		
		//上一页地址
		$referer_url = getReferer();
		$address_options = intval($_POST['address_options']);
		if ($address_options <= 0){
			showMessage(Language::get('cart_step1_chooseaddress_error'),$referer_url,'','error');
		}

		$mode_address	= Model('address');
		$address_info	= $mode_address->getOneAddress($address_options);
		if (empty($address_info)){
			showMessage(Language::get('cart_step1_chooseaddress_error'),$referer_url,'','error');
		}

		//获取合法的商品及总金额
		$legalGoods_info	= $this->getLegalBundlingGoods($spec, $quantity, $bl_id);
		$store_id			= $legalGoods_info['store_info']['store_id'];
		
		//添加订单中的商品信息
		$shipping_fee_total = 0;
		
		//实例化订单模型
		$order_class= Model('order');
		//添加生成订单，在此步中，并没有完全生成订单，还需要接下来的其他信息进行订单填充
		$order_array		= array();
		$order_array['order_sn']		= $order_class->snOrder();
		$order_array['seller_id']		= $legalGoods_info['store_info']['member_id'];
		$order_array['store_id']		= $legalGoods_info['store_info']['store_id'];
		$order_array['store_name']		= $legalGoods_info['store_info']['store_name'];
		$order_array['buyer_id']		= $_SESSION['member_id'];
		$order_array['buyer_name']		= $_SESSION['member_name'];
		$order_array['buyer_email']		= $_SESSION['member_email'];
		$order_array['add_time']		= TIMESTAMP;
		$order_array['out_sn']			= $order_class->outSnOrder();
		$order_array['invoice']			= '';	//发票信息，暂时没有
		$order_array['evaluation_status'] = 0;
		$order_array['order_type'] 		= 0;
		$order_array['order_message']	= trim($_POST['order_message']);
		$order_array['bundling_id']		= $bl_id;
		$order_array['bundling_explain']= sprintf(Language::get('cart_step2_bundling_explain'),$legalGoods_info['all_goods_price'],$legalGoods_info['bundling_economize']);

		//增加运费和配送方式
		if ($legalGoods_info['bl_freight'] != 0){
			$order_array['shipping_name']	= Language::get('transport_type_kd');
			$shipping_fee_total				= $legalGoods_info['bl_freight'];
		}else{
			$order_array['shipping_name']	= '';
		}
		$output_order = $order_array;
		$order_id	= $order_class->addOrder($order_array);

		$model_store_goods	= Model('goods');    
		$date = date('Ymd',time());  
		$model = Model();  
		$stat_model = Model('statistics');
		if(!empty($legalGoods_info['goods_info'])) {
			$output_goods_name = array();
			foreach ($legalGoods_info['goods_info'] as $val) {
				$order_goods_array	= array();
				$order_goods_array['order_id']		= $order_id;
				$order_goods_array['goods_id']		= $val['goods_id'];
				$order_goods_array['goods_name']	= $val['goods_name'];
				$order_goods_array['stores_id']		= $val['store_id'];
				$order_goods_array['spec_id']		= $val['spec_id'];
				$order_goods_array['spec_info']		= $val['cart_spec_info'];
				$order_goods_array['goods_price']	= $val['spec_goods_price'];
				$order_goods_array['goods_num']		= $val['goods_num'];
				$order_goods_array['goods_image']	= $val['goods_image'];
				if (count($output_goods_name)<3) $output_goods_name[] = $val['goods_name'];
				$order_class->addGoodsOrder($order_goods_array);
				//删除购物车中的商品
				$model_cart = Model('cart');
				$model_cart->dropCartByCondition(array('cart_spec_id'=>"{$val['spec_id']}",'cart_member_id'=>"{$_SESSION['member_id']}"));
				//更新商品库存信息
				$model_store_goods->updateSpecStorageGoods(array('spec_goods_storage'=>array('value'=>$val['goods_num'],'sign'=>'decrease'),'spec_salenum'=>array('value'=>$val['goods_num'],'sign'=>'increase')),$val['spec_id']);
				$model_store_goods->updateGoods(array('salenum'=>array('value'=>$val['goods_num'],'sign'=>'increase')),$val['goods_id']);
				//添加到销量统计表中
				$sale_date_array = $model->table('salenum')->where(array('date'=>$date,'goods_id'=>$val['goods_id']))->find();
				if(is_array($sale_date_array) && !empty($sale_date_array)){
					$update_param = array();
					$update_param['table'] = 'salenum';
					$update_param['field'] = 'salenum';
					$update_param['value'] = $val['goods_num'];
					$update_param['where'] = "WHERE date = '".$date."' AND goods_id = '".$val['goods_id']."'";
					$stat_model->updatestat($update_param);
				}else{
					$model->table('salenum')->insert(array('date'=>$date,'salenum'=>$val['goods_num'],'store_id'=>$store_id,'goods_id'=>$val['goods_id']));
				}
			}
		}

        //满就送
        $mansong = $this->mansong($store_id,$legalGoods_info['store_goods_price']);
        if($mansong['rule_shipping_free']) {
            $shipping_fee_total = 0;
        }

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
		$order_amount	= ncPriceFormat($legalGoods_info['store_goods_price']+$shipping_fee_total-$mansong['rule_discount']);
		$order_class->addAddressOrder($address_array);

		//更改订单信息，更改订单总额，商品总额，优惠价格,配送信息
		$order_sn		= $order_array['order_sn'];
		$order_array	= array();
		$order_array['goods_amount']	= $legalGoods_info['store_goods_price'];
		$order_array['discount']		= 0;
        $order_array['mansong_id']      = $mansong['mansong_info']['mansong_id'];
        $order_array['mansong_explain'] = $mansong['promotion_explain'];
		//处理代金券优惠
        $voucher_id = intval($_POST['voucher_id']);
        $voucher_price = 0;
        if($voucher_id > 0 && C('voucher_allow') && $mansong['mansong_flag']==false ) {
            //获取代金券面额
            $model = Model();
            $where = array();
            $where['voucher_id'] = $voucher_id;
            $where['voucher_owner_id'] = $_SESSION['member_id'];
            $where['voucher_store_id'] = $store_id;
            $where['voucher_state'] = '1';
            $where['voucher_limit'] = array('elt',$order_amount);
            $where['voucher_start_date'] = array('elt',time());
            $where['voucher_end_date'] = array('egt',time());
            $voucherinfo = $model->table('voucher')->where($where)->find();
            if(!empty($voucherinfo)) {
                $voucher_price = $voucherinfo['voucher_price']; 
                $voucher_code = $voucherinfo['voucher_code'];
                //更改代金券状态为已使用
                $model->table('voucher')->where(array('voucher_id'=>$voucherinfo['voucher_id']))->update(array('voucher_state'=>'2','voucher_order_id'=>$order_id));
                //代金券模板使用数量加一
                $model->table('voucher_template')->where(array('voucher_t_id'=>$voucherinfo['voucher_t_id']))->update(array('voucher_t_used'=>array('exp','voucher_t_used+1')));
            }
        }
        if(empty($voucher_price)) {
            $order_array['voucher_id'] = 0;
            $order_array['voucher_price'] = 0;     
            $order_array['voucher_code'] ='';
        }else {
            $order_array['voucher_id'] = $voucher_id;
            $order_array['voucher_price'] = $voucher_price;     
            $order_array['voucher_code'] = $voucher_code;
            $order_amount -= $voucher_price; 
        }
	    $order_array['order_amount'] 	= $order_amount;
	    $order_array['shipping_fee']	= $shipping_fee_total;
		$order_class->updateOrder($order_array,$order_id);
		//添加订单完成阶段信息
		$order_class->addLogOrder(10,$order_id);

		$output_order = array_merge($output_order,$order_array,array('order_id'=>$order_id,'seller_name'=>$legalGoods_info['store_info']['member_name']));
		//发送邮件通知
		$param	= array(
			'site_url'		=> SiteUrl,
			'site_name'		=> $GLOBALS['setting_config']['site_name'],
			'buyer_name'	=> $_SESSION['member_name'],
			'seller_name'	=> $legalGoods_info['store_info']['member_name'],
			'order_sn'		=> $order_sn,
			'order_id'		=> $order_id
		);
		$this->send_notice($_SESSION['member_id'],'email_tobuyer_new_order_notify',$param);
		$this->send_notice($legalGoods_info['store_info']['member_id'],'email_toseller_new_order_notify',$param);
		@header("Location: index.php?act=cart&op=order_pay&order_id=".$order_id);
		exit;
	}
    /**
     * 如果是限时折扣商品修改商品价格，输出限时折扣标志
     **/
    private function xianshi($legalGoods_info) {
        $legalGoods_info['xianshi_flag'] = FALSE;
        //验证促销功能开关
        if (intval($GLOBALS['setting_config']['promotion_allow']) === 1){
            if(intval($legalGoods_info['goods_info'][0]['xianshi_flag']) === 1) {
                $xianshi_goods = $this->get_xianshi_goods($legalGoods_info['goods_info'][0]['goods_id']);  
                if(!empty($xianshi_goods) && intval($xianshi_goods['state']) === self::XIANSHI_GOODS_STATE_NORMAL ) {
                    $xianshi_id = $xianshi_goods['xianshi_id'];
                    $model_xianshi = Model('p_xianshi');
                    $xianshi_info = $model_xianshi->getOne($xianshi_id);
                    if(!empty($xianshi_info)) {
                        if(intval($xianshi_info['state']) === self::XIANSHI_STATE_PUBLISHED) {
                            $current_time = time();
                            if(intval($xianshi_info['end_time']) > $current_time && intval($xianshi_info['start_time']) < $current_time) {
                                $legalGoods_info['goods_info'][0]['spec_goods_price'] = ncPriceFormat($legalGoods_info['goods_info'][0]['spec_goods_price'] * $xianshi_goods['discount']/10);
                                $goods_all_price = ncPriceFormat($legalGoods_info['goods_info'][0]['spec_goods_price'] * $legalGoods_info['goods_info'][0]['goods_num']);
                                $legalGoods_info['goods_info'][0]['goods_all_price'] = ncPriceFormat($goods_all_price);
                                $legalGoods_info['store_goods_price'] = $goods_all_price;
                                $legalGoods_info['xianshi_flag'] = TRUE;
                                $legalGoods_info['xianshi_info'] = $xianshi_info;
                                $legalGoods_info['xianshi_goods'] = $xianshi_goods;
                                $legalGoods_info['xianshi_goods']['discount'] /= 10;
                                $legalGoods_info['xianshi_explain'] = Language::get('nc_xianshi').Language::get('nc_colon').($xianshi_goods['discount']).Language::get('nc_xianshi_flag').'('.date('Y/m/d',$legalGoods_info['xianshi_info']['start_time']).'--'.date('Y/m/d',$legalGoods_info['xianshi_info']['end_time']).')';
                            }
                        }
                    }
                }
            }
        }
        return $legalGoods_info;
    }
    /**
     * 输出满就送活动
     **/
    private function get_mansong($store_id) {

        $mansong = array();
        $mansong_flag = FALSE;
        //验证促销功能开关
        if (intval($GLOBALS['setting_config']['promotion_allow']) === 1){
            $model_mansong = Model('p_mansong');
            $param = array();
            $param['state'] = self::MANSONG_STATE_PUBLISHED;
            $current_time = time();
            $param['greater_than_start_time'] = $current_time;
            $param['less_than_end_time'] = $current_time;
            $param['store_id'] = $store_id;
            $param['limit'] = 1;
            $mansong_list = $model_mansong->getList($param);
            $mansong_info = $mansong_list[0];
            if(!empty($mansong_info)) {
                $model_mansong_rule = Model('p_mansong_rule');
                $mansong_rule = $model_mansong_rule->getList(array('mansong_id'=>$mansong_info['mansong_id'],'order'=>'level asc'));
                if(!empty($mansong_rule)) {
                    $mansong_flag = TRUE;
                    $mansong['mansong_info'] = $mansong_info;
                    $mansong['mansong_rule'] = $mansong_rule;
                }
            }
        }
        $mansong['mansong_flag'] = $mansong_flag;
        return $mansong;
    }


    /**
     * 获取满送信息
     **/
    private function mansong($store_id,$order_price,$gift_type='link') {

        $mansong = $this->get_mansong($store_id);
        if($mansong['mansong_flag']) {
            $rule_discount = 0;
            $rule_shipping_free = FALSE;
            $promotion_explain = '';
            $promotion_explain_discount = '';
            $promotion_explain_shipping_free = '';
            $promotion_explain_gift = '';
            $promotion_explain_gift_show = '';
            foreach($mansong['mansong_rule'] as $rule) {
                if($order_price >= $rule['price']) {
                    $promotion_explain = Language::get('nc_mansong').Language::get('nc_colon').Language::get('nc_man').ncPriceFormat($rule['price']).Language::get('nc_yuan');
                    //减现金
                    if(!empty($rule['discount'])) {
                        $promotion_explain_discount = Language::get('nc_comma').Language::get('nc_reduce').ncPriceFormat($rule['discount']).Language::get('nc_yuan').Language::get('nc_cash');
                        $rule_discount = $rule['discount'];
                    }
                    else {
                        $promotion_explain_discount = '';
                        $rule_discount = 0;
                    }
                    //包邮
                    if(!empty($rule['shipping_free'])) {
                        $promotion_explain_shipping_free = Language::get('nc_comma').Language::get('nc_shipping_free');
                        $rule_shipping_free = TRUE;
                    }
                    else {
                        $promotion_explain_shipping_free = '';
                        $rule_shipping_free = FALSE;
                    }
                    //送礼品
                    if(!empty($rule['gift_name'])) {
                        if($gift_type == 'link') {
                            $promotion_explain_gift = Language::get('nc_comma').Language::get('nc_gift')."<a href=\'".$rule['gift_link']."\' target=\'blank\'>".$rule['gift_name']."</a>";
                            $promotion_explain_gift_show = Language::get('nc_comma').Language::get('nc_gift')."<a href='".$rule['gift_link']."' target='blank'>".$rule['gift_name']."</a>";
                        }
                        else {
                            $promotion_explain_gift = Language::get('nc_comma').Language::get('nc_gift').$rule['gift_name'];
                            $promotion_explain_gift_show = Language::get('nc_comma').Language::get('nc_gift').$rule['gift_name'];
                        }
                    }
                }
            }
            $promotion_explain_show = $promotion_explain;
            $promotion_explain_show .= $promotion_explain_discount;
            $promotion_explain_show .= $promotion_explain_shipping_free;
            $promotion_explain_show .= $promotion_explain_gift_show;
            
            $promotion_explain .= $promotion_explain_discount;
            $promotion_explain .= $promotion_explain_shipping_free;
            $promotion_explain .= $promotion_explain_gift;
        }
        $mansong['rule_shipping_free'] = $rule_shipping_free;
        $mansong['promotion_explain'] = $promotion_explain;
        $mansong['promotion_explain_show'] = $promotion_explain_show;
        $mansong['rule_discount'] = $rule_discount;
        return $mansong; 
    }

    /**
     * 获取限时折扣商品
     **/
    private function get_xianshi_goods($goods_id) {

        $model_xianshi_goods = Model('p_xianshi_goods');
        $param = array();
        $param['goods_id'] = $goods_id;
        $param['order'] = 'xianshi_goods_id desc';
        $param['limit'] = 1;
        $xianshi_goods = $model_xianshi_goods->getList($param);
        return $xianshi_goods[0];
    }

	/**
	 * 验证商品是否符合购买条件
	 * @return array
	 */
	private function getLegalGoods($spec_id,$quantity){
		
		//查询商品信息
		$goods_model = Model('goods');
		$goods_info = $goods_model->checkGoods(array('spec_id'=>"$spec_id",'goods_state'=>'0','goods_show'=>'1','spec_storage_enough'=>'yes'),"goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_transfee_charge,goods.py_price,goods.kd_price,es_price,goods.transport_id,goods.spec_open,goods.xianshi_flag,goods_spec.*");		
		if (empty($goods_info)){
			showMessage(Language::get('cart_add_goods_not_exists'),'index.php','','error');
		}
		if ($goods_info['store_id'] == $_SESSION['store_id']){
			showMessage(Language::get('cart_add_cannot_buy'),"index.php?act=goods&goods_id={$goods_info['goods_id']}",'','error');
		}
		//查询店铺的基本信息
		$store_id = $goods_info['store_id'];
		$model_store = Model('store');
        $store_info = $model_store->shopStore(array('store_id'=>"$store_id",'store_state'=>'1'));//店铺开启并通过审核
		if (empty($store_info)){
			showMessage(Language::get('cart_index_not_exists_store'),'index.php','','error');
		}
	
		//判断库存
		if ($quantity > $goods_info['spec_goods_storage']){//验证库存，不足时提示不能购买
			showMessage(Language::get('cart_index_store_goods').Language::get('nc_colon').$goods_info['goods_name']
				.Language::get('nc_comma').Language::get('cart_index_freight_not_enough'),"index.php?act=goods&goods_id={$goods_info['goods_id']}",'','error');
		}
		$goods_info['goods_num'] = $quantity;
		
		//构造购物车规格信息
		$goods_info['cart_spec_info'] = '';
		if ($goods_info['spec_open'] == 1 && !empty($goods_info['spec_goods_spec']) && !empty($goods_info['spec_name'])){
			$spec_name = unserialize($goods_info['spec_name']);
			if (!empty($spec_name)){
				$spec_name = array_values($spec_name);
				$spec_goods_spec = unserialize($goods_info['spec_goods_spec']);
				$i = 0;
				foreach ($spec_goods_spec as $speck=>$specv){
					$goods_info['cart_spec_info'] .= $spec_name[$i].":".$specv."&nbsp;";
					$i++;
				}
			}
		}
		
		//商品总价
		$goods_info['goods_all_price'] = ncPriceFormat($quantity*floatval($goods_info['spec_goods_price']));

		$return_array = array('goods_info'=>array($goods_info),'store_goods_price'=>$goods_info['goods_all_price'],'store_info'=>$store_info);
		return $return_array;
	}
	
	/**
	 * 验证商品是否符合购买条件
	 * @return array
	 */
	private function getLegalBundlingGoods($spec,$quantity,$bl_id){
		$model = Model();
		// 验证套餐商品数量
		$goods_id_array = array_keys($spec);
		$bundling_goods_list = $model->table('p_bundling_goods')->field('goods_id')->where('bl_id='.$bl_id)->select();
		if(!empty($bundling_goods_list) && is_array($bundling_goods_list)){
			$b_g_id_array = array();
			foreach ($bundling_goods_list as $val){
				$b_g_id_array[] = $val['goods_id'];
			}
		}else{
			showMessage(Language::get('wrong_argument'),'index.php','','error');
		}
		$dff1 = array_diff($goods_id_array, $b_g_id_array);
		$dff2 = array_diff($b_g_id_array, $goods_id_array);
		if(!empty($dff1) || !empty($dff2)){
			showMessage(Language::get('wrong_argument'),'index.php','','error');
		}
		
		//查询商品信息
		$goods_info = $model->table('goods,goods_spec')->field("goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_transfee_charge,goods.py_price,goods.kd_price,es_price,goods.transport_id,goods.spec_open,goods.xianshi_flag,goods_spec.*")
														->join('inner')->on('goods.goods_id=goods_spec.goods_id')
														->where('goods_spec.spec_id in ('.implode(',', $spec).')')->select();
		if(count($goods_info) != count($spec)){
			showMessage(Language::get('wrong_argument'),'index.php','','error');
		}
		
		if ($goods_info[0]['store_id'] == $_SESSION['store_id']){
			showMessage(Language::get('cart_add_cannot_buy'),"index.php?act=bundling&bundling_id=".$bl_id."&id=".$goods_info[0]['store_id'],'','error');
		}
		//查询店铺的基本信息
		$store_id = $goods_info[0]['store_id'];
		$store_info = $model->table('store')->where('store_id='.$store_id.' and store_state=1')->find();//店铺开启并通过审核
		if (empty($store_info)){
			showMessage(Language::get('cart_index_not_exists_store'),'index.php','','error');
		}
		
		$all_goods_price	= 0;// 全部商品总价。
		foreach ($goods_info as $key=>$val){
			//判断库存
			if ($quantity > intval($val['spec_goods_storage'])){
				showMessage(Language::get('cart_index_freight_not_enough'),'','','error');
			}
			$goods_info[$key]['goods_num'] = $quantity;
		
			//构造购物车规格信息
			$goods_info[$key]['cart_spec_info'] = '';
			if ($val['spec_open'] == 1 && !empty($val['spec_goods_spec']) && !empty($val['spec_name'])){
				$spec_name = unserialize($val['spec_name']);
				if (!empty($spec_name)){
					$spec_name = array_values($spec_name);
					$spec_goods_spec = unserialize($val['spec_goods_spec']);
					$i = 0;
					foreach ($spec_goods_spec as $speck=>$specv){
						$goods_info[$key]['cart_spec_info'] .= $spec_name[$i].":".$specv."&nbsp;";
						$i++;
					}
				}
			}
		
			//商品总价
			$goods_info[$key]['goods_all_price'] = ncPriceFormat($quantity*floatval($val['spec_goods_price']));
			$all_goods_price					+= $quantity*floatval($val['spec_goods_price']);
		}
		$bl_info = $model->table('p_bundling')->field('bl_discount_price,bl_freight')->find($bl_id);
		$return_array = array('goods_info'=>$goods_info,
								'store_goods_price'=>intval($bl_info['bl_discount_price'])*$quantity,
								'all_goods_price'=>$all_goods_price,
								'bundling_economize'=>$all_goods_price-intval($bl_info['bl_discount_price'])*$quantity,
								'bl_freight'=>$bl_info['bl_freight'],
								'store_info'=>$store_info);
		return $return_array;
	}
	/**
	 * 购物流程第二步
	 */
	public function step2Op() {
		$spec_id = intval($_POST['buynow_spec_id']);
		$quantity = intval($_POST['buynow_quantity']);
		if ($spec_id <= 0 || $quantity <= 0){
			showMessage(Language::get('wrong_argument'),'index.php','','error');
		}
		//上一页地址
		$referer_url = getReferer();
		$address_options = intval($_POST['address_options']);
		if ($address_options <= 0){
			showMessage(Language::get('cart_step1_chooseaddress_error'),$referer_url,'','error');
		}

		$mode_address	= Model('address');
		$address_info	= $mode_address->getOneAddress($address_options);
		if (empty($address_info)){
			showMessage(Language::get('cart_step1_chooseaddress_error'),$referer_url,'','error');
		}
		
		//检测商品是否符合购买条件
		$legalGoods_info = $this->getLegalGoods($spec_id,$quantity);

        //限时折扣处理
        $legalGoods_info = $this->xianshi($legalGoods_info);
        //满即送处理
        $mansong = array();
        if(!$legalGoods_info['xianshi_flag']) { 
            $mansong = $this->mansong($legalGoods_info['goods_info'][0]['store_id'],$legalGoods_info['store_goods_price']);
        }

		$shipping_fee_total = 0;        
		//实例化订单模型
		$order_class= Model('order');
		//添加生成订单，在此步中，并没有完全生成订单，还需要接下来的其他信息进行订单填充
		$order_array		= array();
		$order_array['order_sn']		= $order_class->snOrder();
		$order_array['seller_id']		= $legalGoods_info['store_info']['member_id'];
		$order_array['store_id']		= $legalGoods_info['store_info']['store_id'];
		$order_array['store_name']		= $legalGoods_info['store_info']['store_name'];
		$order_array['buyer_id']		= $_SESSION['member_id'];
		$order_array['buyer_name']		= $_SESSION['member_name'];
		$order_array['buyer_email']		= $_SESSION['member_email'];
		$order_array['add_time']		= time();
		$order_array['out_sn']			= $order_class->outSnOrder();
		$order_array['invoice']			= '';	//发票信息，暂时没有
		$order_array['evaluation_status']= 0;
		$order_array['order_type'] = 0;
		$order_array['order_message']	= trim($_POST['order_message']);
		
		if (!empty($_POST['transport_type'])){
			$tmp = @explode('|',$_POST['transport_type']);
			if (is_array($tmp) && is_numeric($tmp[1])){
				$order_array['shipping_name'] = str_replace(array('py','kd','es'),array(Language::get('transport_type_py'),Language::get('transport_type_kd'),'EMS'),$tmp[0]);
				$shipping_fee_total = $tmp[1];
			}
		}else{
			$order_array['shipping_name']	= '';					
		}
        //限时折扣标识
        if($legalGoods_info['xianshi_flag']) {
            $order_array['xianshi_id'] = $legalGoods_info['xianshi_info']['xianshi_id'];
            $order_array['xianshi_explain'] = $legalGoods_info['xianshi_explain'];
        }
        else {
            $order_array['xianshi_id'] = 0; 
            $order_array['xianshi_explain'] = ''; 
        }
        //满即送标识
        if($mansong['mansong_flag']) {
            $order_array['mansong_id'] = $mansong['mansong_info']['mansong_id'];
            $order_array['mansong_explain'] = $mansong['promotion_explain'];
        }
        else {
            $order_array['mansong_id'] = 0; 
            $order_array['mansong_explain'] = ''; 
        }
		$output_order = $order_array;
		$order_id	= $order_class->addOrder($order_array);

		//添加订单中的商品信息
		$model_store_goods	= Model('goods');
		$order_goods_array	= array();
		$order_goods_array['order_id']		= $order_id;
		$order_goods_array['goods_id']		= $legalGoods_info['goods_info'][0]['goods_id'];
		$order_goods_array['stores_id']		= $legalGoods_info['goods_info'][0]['store_id'];
		$order_goods_array['goods_name']	= $legalGoods_info['goods_info'][0]['goods_name'];
		$order_goods_array['spec_id']		= $legalGoods_info['goods_info'][0]['spec_id'];
		$order_goods_array['spec_info']		= $legalGoods_info['goods_info'][0]['cart_spec_info'];
		$order_goods_array['goods_price']	= $legalGoods_info['goods_info'][0]['spec_goods_price'];
		$order_goods_array['goods_num']		= $legalGoods_info['goods_info'][0]['goods_num'];
		$order_goods_array['goods_image']	= $legalGoods_info['goods_info'][0]['goods_image'];
		$output_goods_name[0] = $legalGoods_info['goods_info'][0]['goods_name'];
        if($mansong['rule_shipping_free']) {
            $shipping_fee_total = 0;
        }

		$order_class->addGoodsOrder($order_goods_array);

		//更新商品库存信息
		$model_store_goods->updateSpecStorageGoods(array('spec_goods_storage'=>array('value'=>$legalGoods_info['goods_info'][0]['goods_num'],'sign'=>'decrease'),'spec_salenum'=>array('value'=>$legalGoods_info['goods_info'][0]['goods_num'],'sign'=>'increase')),$legalGoods_info['goods_info'][0]['spec_id']);
		$model_store_goods->updateGoods(array('salenum'=>array('value'=>$legalGoods_info['goods_info'][0]['goods_num'],'sign'=>'increase')),$legalGoods_info['goods_info'][0]['goods_id']);
		//订单总金额
		$order_amount = $legalGoods_info['store_goods_price']+$shipping_fee_total;

		//添加订单收货地址信息
		$address_array		= array();
		$address_array['order_id']		= $order_id;
		$address_array['true_name']		= $address_info['true_name'];
		$address_array['area_id']		= $address_info['area_id'];
		$address_array['area_info']		= $address_info['area_info'];
		$address_array['address']		= $address_info['address'];
		$address_array['zip_code']		= $address_info['zip_code'];
		$address_array['tel_phone']		= $address_info['tel_phone'];
		$address_array['mob_phone']		= $address_info['mob_phone'];
		$order_amount	= ncPriceFormat($legalGoods_info['store_goods_price']+$shipping_fee_total-$mansong['rule_discount']);
		$order_class->addAddressOrder($address_array);
		//更改订单信息，更改订单总额，商品总额，优惠价格,配送信息
		$order_sn		= $order_array['order_sn'];
		$order_array	= array();
		$order_array['goods_amount']	= $legalGoods_info['store_goods_price'];
		$order_array['discount']		= 0;
	  	//处理代金券优惠 
        $voucher_id = intval($_POST['voucher_id']);
        $voucher_price = 0;
        if($voucher_id > 0 && C('voucher_allow') == 1 && $mansong['mansong_flag'] == false && $legalGoods_info['xianshi_flag'] ==false){
            //获取代金券面额
            $model = Model();
            $where = array();
            $where['voucher_id'] = $voucher_id;
            $where['voucher_owner_id'] = $_SESSION['member_id'];
            $where['voucher_store_id'] = $legalGoods_info['store_info']['store_id'];
            $where['voucher_state'] = '1';
            $where['voucher_limit'] = array('elt',$order_amount);
            $where['voucher_start_date'] = array('elt',time());
            $where['voucher_end_date'] = array('egt',time());
            $voucherinfo = $model->table('voucher')->where($where)->find();
        	if(!empty($voucherinfo)) {
                $voucher_price = $voucherinfo['voucher_price']; 
                $voucher_code = $voucherinfo['voucher_code'];
                //更改代金券状态为已使用
                $model->table('voucher')->where(array('voucher_id'=>$voucherinfo['voucher_id']))->update(array('voucher_state'=>'2','voucher_order_id'=>$order_id));
                //代金券模板使用数量加一
                $model->table('voucher_template')->where(array('voucher_t_id'=>$voucherinfo['voucher_t_id']))->update(array('voucher_t_used'=>array('exp','voucher_t_used+1')));
            }
        }
        if(empty($voucher_price)) {
            $order_array['voucher_id'] = 0;
            $order_array['voucher_price'] = 0;     
            $order_array['voucher_code'] ='';
        }
        else {
            $order_array['voucher_id'] = $voucher_id;
            $order_array['voucher_price'] = $voucher_price;     
            $order_array['voucher_code'] = $voucher_code;
            $order_amount -= $voucher_price; 
        }
	    $order_array['order_amount'] = $order_amount;
	    $order_array['shipping_fee']	= $shipping_fee_total;
		$order_class->updateOrder($order_array,$order_id);
		//添加订单完成阶段信息
		$order_class->addLogOrder(10,$order_id);

		$output_order = array_merge($output_order,$order_array,array('order_id'=>$order_id,'seller_name'=>$legalGoods_info['store_info']['member_name']));
		//添加到销量统计表中
		$date = date('Ymd',time());
		$model = Model();
		$stat_model = Model('statistics');
		$sale_date_array = $model->table('salenum')->where(array('date'=>$date,'goods_id'=>$legalGoods_info['goods_info'][0]['goods_id']))->find();
		if(is_array($sale_date_array) && !empty($sale_date_array)){
			$update_param = array();
			$update_param['table'] = 'salenum';
			$update_param['field'] = 'salenum';
			$update_param['value'] = $legalGoods_info['goods_info'][0]['goods_num'];
			$update_param['where'] = "WHERE date = '".$date."' AND goods_id = '".$legalGoods_info['goods_info'][0]['goods_id']."'";
			$stat_model->updatestat($update_param);
		}else{
			$model->table('salenum')->insert(array('date'=>$date,'salenum'=>$legalGoods_info['goods_info'][0]['goods_num'],'store_id'=>$legalGoods_info['store_info']['store_id'],'goods_id'=>$legalGoods_info['goods_info'][0]['goods_id']));
		}
		//发送邮件通知
		$param	= array(
			'site_url'		=> SiteUrl,
			'site_name'		=> $GLOBALS['setting_config']['site_name'],
			'buyer_name'	=> $_SESSION['member_name'],
			'seller_name'	=> $legalGoods_info['store_info']['member_name'],
			'order_sn'		=> $order_sn,
			'order_id'		=> $order_id
		);
		$this->send_notice($_SESSION['member_id'],'email_tobuyer_new_order_notify',$param);
		$this->send_notice($legalGoods_info['store_info']['member_id'],'email_toseller_new_order_notify',$param);
		@header("Location: index.php?act=cart&op=order_pay&order_id=".$order_id);
		exit;
	}
}