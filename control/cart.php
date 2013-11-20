<?php
/**
 * 购物车操作
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class cartControl extends BaseHomeControl {
    const MANSONG_STATE_PUBLISHED = 2;
	/**
	 * 构造函数 
	 */	
	public function __construct() {
		parent::__construct();
		//读取语言包
		Language::read('home_cart_index');
		
		//允许不登录就可以访问的op
		$op_arr = array('ajaxcart','add','drop');
		$op_str = '';
		$op_str = isset($_GET['op'])?$_GET['op']:$_POST['op'];
		if (!in_array($op_str,$op_arr) && !$_SESSION['member_id'] ){
			$current_url = request_uri();
			redirect('index.php?act=login&ref_url='.urlencode($current_url));
		}

		//验证该会员是否禁止购买
		$noallowbuyop_arr = array('step1','step2');
		$noallowbuyop_str = '';
		$noallowbuyop_str = isset($_GET['op'])?$_GET['op']:$_POST['op'];
		if (in_array($noallowbuyop_str,$noallowbuyop_arr)){
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

	}
	/**
	 * 购物车首页
	 *
	 * @param
	 * @return
	 */
	public function indexOp() {
		$model_cart	= Model('cart');

		//取出已有购物车信息
		$cart_goods	= array();
		$cart_goods	= $model_cart->listCart();

		//获取购物车列表信息
		$cart_array	= array();
		if(!empty($cart_goods)) {
			foreach ($cart_goods as $val) {
				$val['goods_all_price']		= ncPriceFormat($val['goods_store_price'] * $val['goods_num']);
				$cart_array[$val['store_id']][] = $val;
				$cart_array[$val['store_id']][0]['store_all_price'] = ncPriceFormat(floatval($cart_array[$val['store_id']][0]['store_all_price']) + floatval($val['goods_all_price']));
			}
			Tpl::output('cart_array',$cart_array);
            //输出满就送活动
            $mansong = $this->get_mansong(array_keys($cart_array));
            Tpl::output('mansong',$mansong);
            Tpl::showpage('cart');

        } else {
			Tpl::showpage('cart_empty');
		}
		
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
            $param['limit'] = 5;
            $mansong_list = $model_mansong->getList($param);
//            $mansong_info = $mansong_list[0];
            if(!empty($mansong_list) && is_array($mansong_list)) {
            	$model_mansong_rule = Model('p_mansong_rule');
            	foreach ($mansong_list as $v) {
            		$mansong_flag = FALSE;
	                $mansong_rule = $model_mansong_rule->getList(array('mansong_id'=>$v['mansong_id'],'order'=>'level asc'));
	                if(!empty($mansong_rule)) {
	                    $mansong_flag = TRUE;
	                    $mansong_info[$v['store_id']]['mansong_info'] = $v;
	                    $mansong_info[$v['store_id']]['mansong_rule'] = $mansong_rule;
	                    $mansong_info[$v['store_id']]['mansong_flag'] = $mansong_flag;
	                }
            	}
            }
        }
//        $mansong['mansong_flag'] = $mansong_flag;
        return $mansong_info;
    }

	/**
	 * 异步查询购物车
	 */
	public function ajaxcartOp() {
		if ($_SESSION['member_id']){
			$model_cart	= Model('cart');
			//取出已有购物车信息
			$cart_goods	= array();
			$cart_goods	= $model_cart->listCart();			
			$cart_array	= array();
			if(!empty($cart_goods)){
				foreach ($cart_goods as $k=>$val){
					$cart_array['goodslist'][$k]['specid'] 	= $val['spec_id'];
					$cart_array['goodslist'][$k]['goodsid'] 	= $val['goods_id'];
					$cart_array['goodslist'][$k]['storeid'] 	= $val['store_id'];
					$cart_array['goodslist'][$k]['gname'] 	= $val['goods_name'];
					$cart_array['goodslist'][$k]['price'] 	= $val['goods_store_price'];
					$cart_array['goodslist'][$k]['images']	= thumb($val);
					$cart_array['goodslist'][$k]['num'] 		= $val['goods_num'];
					$cart_array['goodslist'][$k]['goods_all_price']	= ncPriceFormat($val['goods_store_price'] * $val['goods_num']);					
					$cart_array['goods_all_price'] += floatval($val['goods_store_price']) * intval($val['goods_num']);
				}
				$cart_array['goods_all_price'] = ncPriceFormat($cart_array['goods_all_price']);//金额格式化
			}
		}else{
			//cookie购物车信息
			if (cookie('cart')){
				$cart_str = cookie('cart');
				if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
				$cookie_goods = unserialize($cart_str);
				if (!empty($cookie_goods)){
					foreach ($cookie_goods as $k=>$v){
						$v['specid'] 	= $k;
						$v['images']	= cthumb($v['images'],'tiny',$v['storeid']);
						$cart_array['goodslist'][] = $v;
						$cart_array['goods_all_price'] += floatval($v['price']) * intval($v['num']);
					}
					$cart_array['goods_all_price'] = ncPriceFormat($cart_array['goods_all_price']);//金额格式化
				}
			}
		}
		$cart_array['goods_all_num'] = count($cart_array['goodslist']);
		//转码
		if (strtoupper(CHARSET) == 'GBK'){
			$cart_array = Language::getUTF8($cart_array);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
        $json_data = json_encode($cart_array);
        if (isset($_GET['callback']))   
        {  
            $json_data = $_GET['callback']=='?' ? '('.$json_data.')' : $_GET['callback']."($json_data);";  
        }  
        echo $json_data; 
        die;
	}
	/**
	 * 购物车添加商品
	 *
	 * @param
	 * @return
	 */
	public function addOp() {
		$spec_id	= intval($_GET['spec_id']);
		$quantity	= intval($_GET['quantity']);
		if($spec_id <= 0 || $quantity <= 0) {
			echo json_encode(array('msg'=>Language::get('wrong_argument','UTF-8')));
			return;
		}
		$mode_goods= Model('goods');
		$goods_info	= $mode_goods->checkGoods(array('spec_id'=>"$spec_id"),'goods.*,goods_spec.*');
		if(empty($goods_info)) {
			echo json_encode(array('msg'=>Language::get('cart_add_goods_not_exists','UTF-8')));
			return ;
		}
		//登录状态，不能购买自己的商品
		if($_SESSION['member_id'] && $goods_info['store_id'] == $_SESSION['store_id']) {
			echo json_encode(array('msg'=>Language::get('cart_add_cannot_buy','UTF-8')));
			return ;
		}
		//判断库存
		if(intval($goods_info['spec_goods_storage'])<1) {
			echo json_encode(array('msg'=>Language::get('cart_add_stock_shortage','UTF-8')));
			return ;
		}
		if(intval($goods_info['spec_goods_storage'])<$quantity) {
			echo json_encode(array('msg'=>Language::get('cart_add_too_much','UTF-8')));
			return ;
		}
		if($_SESSION['member_id']) {
			//登录状态
			$model_cart	= Model('cart');
			$check_cart	= $model_cart->checkCart(array('cart_spec_id'=>"$spec_id",'cart_member_id'=>"{$_SESSION['member_id']}"));
			$check_cart	= $check_cart[0];
			//验证购物车商品是否已经存在
			if(empty($check_cart)) {
				$array				= array();
				$array['member_id']	= $_SESSION['member_id'];
				$array['store_id']	= $goods_info['store_id'];
				$array['goods_id']	= $goods_info['goods_id'];
				$array['goods_name']= $goods_info['goods_name'];
				$array['spec_id']	= $spec_id;
				//构造购物车规格信息
				$array['spec_info'] = '';
				if ($goods_info['spec_open'] == 1 && !empty($goods_info['spec_goods_spec']) && !empty($goods_info['spec_name'])){
					$spec_name = unserialize($goods_info['spec_name']);
					if (!empty($spec_name)){
						$spec_name = array_values($spec_name);
						$spec_goods_spec = unserialize($goods_info['spec_goods_spec']);
						$i = 0;
						foreach ($spec_goods_spec as $k=>$v){
							$array['spec_info'] .= $spec_name[$i].":".$v."&nbsp;";
							$i++;
						}
					}
				}

				$array['goods_store_price']	= $goods_info['spec_goods_price'];
				$array['goods_num']	= $quantity;
				$array['goods_images']	= $goods_info['goods_image'];
				$cart_state = $model_cart->addCart($array);
			}
			$all_price = 0;
			$cart_goods_num = 0;
			$cart_goods_num	= $model_cart->countCart(array('cart_member_id'=>"{$_SESSION['member_id']}"));
			$all_price		= $this->amountOp($model_cart);
		}else {
			//非登录状态
			if (cookie('cart')){
				$cart_str = cookie('cart');
				if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
				$cart_arr = unserialize($cart_str);
			}
			//判断商品是否已经加入购物车
			if (empty($cart_arr) || !in_array($spec_id,array_keys($cart_arr))){
				$cart_arr[$spec_id] = array('storeid'=>$goods_info['store_id'],'goodsid'=>$goods_info['goods_id'],'gname'=>$goods_info['goods_name'],'price'=>$goods_info['spec_goods_price'],'images'=>$goods_info['goods_image'],'num'=>$quantity);
			}
			//商品数量
			$cart_goods_num = 0;
			$cart_goods_num = count($cart_arr);
			//商品总价格
			$all_price = 0;
			if (!empty($cart_arr)){
				foreach ($cart_arr as $v){
					$all_price += floatval($v['price'])*intval($v['num']);
				}
			}
			setNcCookie('cart',serialize($cart_arr),90*24*3600);//保存90天
		}
		setNcCookie('goodsnum',$cart_goods_num,2*3600);		// 购物车商品种数
		echo json_encode(array('done'=>'true','num'=>$cart_goods_num,'amount'=>ncPriceFormat($all_price)));
	}
	/**
	 * 购物车更新商品数量
	 *
	 * @param
	 * @return
	 */
	public function updateOp() {
		$spec_id	= intval($_GET['spec_id']);
		$quantity	= intval($_GET['quantity']);

		//验证数量和规格编号是否合法
		if($spec_id <= 0 || $quantity <= 0) {
			echo json_encode(array('msg'=>Language::get('cart_update_buy_fail','UTF-8')));
			die;
		}
		//获取商品详细
		$mode_goods= Model('goods');
		$goods_info	= $mode_goods->checkGoods(array('spec_id'=>$spec_id),'goods.*,goods_spec.*');
		if(empty($goods_info)) {
			echo json_encode(array('msg'=>Language::get('cart_update_buy_fail','UTF-8')));
			die;
		}
		if(intval($goods_info['spec_goods_storage']) < $quantity) {
			echo json_encode(array('msg'=>Language::get('cart_index_stock_contact','UTF-8')));
			die;
		}
		//更新购物车内单个商品数量
		$model_cart	= Model('cart');
		$cart_state = $model_cart->updateCart(array('goods_num'=>$quantity),array('cart_spec_id'=>"$spec_id",'cart_member_id'=>"{$_SESSION['member_id']}"));
		if ($cart_state) {
			//计算总金额
			$all_price	= $this->storeOp($model_cart,$goods_info['store_id']);
			echo json_encode(array('done'=>'true','subtotal'=>$goods_info['spec_goods_price']*$quantity,'amount'=>ncPriceFormat($all_price)));
			die;
		}else{
			echo json_encode(array('msg'=>Language::get('cart_update_buy_fail','UTF-8')));
			die;
		}
	}
	/**
	 * 购物车删除单个商品
	 *
	 * @param
	 * @return
	 */
	public function dropOp() {
		$spec_id	= intval($_GET['specid']);
		$store_id	= intval($_GET['storeid']);
		if($spec_id <= 0 || $store_id <= 0) {
			return;
		}		
		if ($_SESSION['member_id']){
			//已经登录删除数据库购物车信息
			$model_cart	= Model('cart');
			$drop_state	= $model_cart->dropCartByCondition(array('cart_spec_id'=>"$spec_id",'cart_member_id'=>"{$_SESSION['member_id']}"));
			if($drop_state) {
				//计算商品种类
				$quantity = $model_cart->countCart(array('cart_member_id'=>"{$_SESSION['member_id']}"));
				$store_quantity = $model_cart->countCart(array('cart_member_id'=>"{$_SESSION['member_id']}",'spec_store_id'=>"$store_id"));
				if ($quantity >0){
					//计算店铺商品金额
					$amount	= $this->amountOp($model_cart);
					$store_amount = $this->storeOp($model_cart,$store_id);
					$json_data = json_encode(array('done'=>'true','amount'=>ncPriceFormat($amount),'store_amount'=>ncPriceFormat($store_amount),'quantity'=>$quantity,'store_quantity'=>$store_quantity));
					setNcCookie('goodsnum',$quantity,2*3600);		// 购物车商品种数
				}else {
					$json_data = json_encode(array('done'=>'true','amount'=>ncPriceFormat(0),'store_amount'=>ncPriceFormat(0),'quantity'=>0,'store_quantity'=>0));
					setNcCookie('goodsnum',0,2*3600);		// 购物车商品种数
				}
			} else {
				$json_data = json_encode(array('msg'=>Language::get('cart_drop_del_fail','UTF-8')));
			}
		}else{
			//未登录删除cookie购物车信息
			$cart_arr = array();
			$all_price = 0;
			if (cookie('cart')){
				$cart_str = cookie('cart');
				if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
				$cart_arr = unserialize($cart_str);
				if (!empty($cart_arr)){
					foreach ($cart_arr as $k=>$v){
						if ($k == $spec_id){
							unset($cart_arr[$k]);
						}else{
							$all_price += floatval($v['price'])*intval($v['num']);
						}
					}
					if (!empty($cart_arr)){
						//cookie购物车存在
						$json_data = json_encode(array('done'=>'true','amount'=>ncPriceFormat($all_price),'quantity'=>count($cart_arr)));
						setNcCookie('cart',serialize($cart_arr),90*24*3600);
						setNcCookie('goodsnum',count($cart_arr),2*3600);		// 购物车商品种数
					}else{
						//cookie购物车不存在
						$json_data = json_encode(array('done'=>'true','amount'=>ncPriceFormat(0),'quantity'=>0));
						setNcCookie('cart','',-1);
						setNcCookie('goodsnum',0,2*3600);		// 购物车商品种数
					}
				}else {
					$json_data = json_encode(array('msg'=>Language::get('cart_drop_del_fail','UTF-8')));
				}
			}else {
				$json_data = json_encode(array('msg'=>Language::get('cart_drop_del_fail','UTF-8')));
			}
		}
        if (isset($_GET['callback']))   
        {  
            $json_data = $_GET['callback']=='?' ? '('.$json_data.')' : $_GET['callback']."($json_data);";  
        }  
        echo $json_data; 
        die;
	}
	/**
	 * 购物车内的商品总金额
	 *
	 * @param object $model_cart 购物车控制实例
	 * @return
	 */
	private function amountOp($model_cart) {
		//计算总金额
		$cart_goods	= $model_cart->listCart();
		$all_price	= 0;
		if(!empty($cart_goods) && is_array($cart_goods)) {
			foreach ($cart_goods as $val) {
				$all_price	= ncPriceFormat($val['goods_store_price'] * $val['goods_num']) + $all_price;
			}
		}
		return $all_price;
	}
	/**
	 * 购物车内的单个店铺商品总金额
	 *
	 * @param object $model_cart 购物车控制实例
	 * @return
	 */
	private function storeOp($model_cart,$store_id) {
		//计算单个店铺商品总金额		 
		$cart_goods	= $model_cart->listCart($store_id);
		$store_price	= 0;
		if(!empty($cart_goods) && is_array($cart_goods)) {
			foreach ($cart_goods as $val) {
				$store_price	= ncPriceFormat($val['goods_store_price'] * $val['goods_num']) + $store_price;
			}
		}
		return $store_price;
	}
	/**
	 * 购物流程第一步
	 */
	public function step1Op(){
		$store_id = intval($_GET['store_id']);
		if ($store_id <= 0){
			showMessage(Language::get('cart_index_not_exists_store'),'index.php?act=cart','','error');
		}

		//取得购物车中的商品
		$cart_goods_list = $this->getLegalGoods($store_id);
        //获取满就送
        $mansong = $this->mansong($store_id,$cart_goods_list['store_goods_price']);
        $cart_goods_list['store_goods_price'] -= $mansong['rule_discount'];
        //输出满就送活动
        Tpl::output('mansong_flag',$mansong['mansong_flag']);
        Tpl::output('rule_shipping_free',$mansong['rule_shipping_free']);
        Tpl::output('promotion_explain',$mansong['promotion_explain_show']);
        
        $cart_goods_list['goods_list'][0]['store_name'] =$cart_goods_list['store_info']['store_name'];
        $cart_goods_list['goods_list'][0]['store_domain'] = $cart_goods_list['store_info']['store_domain'];        

		Tpl::output('cart_array',$cart_goods_list['goods_list']);//购物车内当前店铺的商品列表
		Tpl::output('store_goods_price',$cart_goods_list['store_goods_price']);//购物车内当前店铺的商品总价（不含运费）
        Tpl::output('store_info',$cart_goods_list['store_info']);

		//实例化收货地址模型
		$mode_address	= Model('address');
		$address_list	= $mode_address->getAddressList(array('member_id'=>"{$_SESSION['member_id']}"));
		Tpl::output('address_list',$address_list);

        //如果没有参加其他活动，获取可用代金券列表
        if(C('voucher_allow') == 1 && $mansong['mansong_flag'] == false){
            //获取代金券列表
            $model = Model();
            $where = array();
            $where['voucher_owner_id'] = "{$_SESSION['member_id']}";
            $where['voucher_store_id'] = "{$store_id}";
            $where['voucher_state'] = '1';
            $where['voucher_limit'] = array('elt',$cart_goods_list['store_goods_price']);
            $where['voucher_start_date'] = array('elt',time());
            $where['voucher_end_date'] = array('egt',time());
            $voucher_list = $model->table('voucher')->where($where)->order('voucher_price asc')->select();
            Tpl::output('voucher_list',$voucher_list);
        }
		Tpl::showpage('cart_step1');
	}
    /**
     * 获取满送信息
     **/
    private function mansong($store_id,$order_price,$gift_type='link') {

        $mansong = $this->get_mansong($store_id);
        $mansong = $mansong[$store_id];
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
     * 验证购物车商品是否符合购买条件，并返回符合条件的商品和对应的总金额
     * @return array
     */
	private function getLegalGoods($store_id){

		//获取购物车内当前店铺的基本信息
		$model_store = Model('store');
        $store_info = $model_store->shopStore(array('store_id'=>$store_id),'store_id,store_name,member_id,member_name');
        
        //判断当前已选店铺的合法性
        if(empty($store_info)) showMessage(Language::get('cart_index_not_exists_store'),'index.php?act=cart','','error');//店铺信息错误

        //查询购物车中该店铺商品信息
		$model_cart	= Model('cart');
		$goods_list	= $model_cart->checkCart(array('spec_store_id'=>"$store_id",'cart_member_id'=>"{$_SESSION['member_id']}"));
		if(empty($goods_list)) {
			showMessage(Language::get('cart_record_error'),'index.php?act=cart','','error');//购物车内不存在该店铺的商品
		}

		//处理购物车
		$cart_goods_list_new = array();//购物车商品信息处理后的数组
		if (!empty($goods_list)){
			foreach ($goods_list as $k=>$v){
				$cart_goods_list_new[$v['spec_id']] = $v;
			}
		}
		$cart_goodsid_arr = array_keys($cart_goods_list_new);
		if(empty($cart_goodsid_arr)) {
			showMessage(Language::get('cart_record_error'),'index.php?act=cart','','error');
		}
		$cart_goodsid_str = "'".implode("','",$cart_goodsid_arr)."'";
		unset($cart_goodsid_arr);
		unset($cart_goods_list);
		
		//查询购物车中商品表信息
		$model_goods = Model('goods');
		//查询购物车中,未禁售，上架，有库存并且已加入购物车的商品
		$goods_list = $model_goods->getGoods(array('goods_state'=>'0','goods_show'=>'1','spec_storage_enough'=>'yes','spec_id_in'=>$cart_goodsid_str),'',"goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_transfee_charge,goods.spec_open,goods.py_price,goods.kd_price,es_price,goods.transport_id,goods_spec.*","groupbuy_goods_info");
		if (empty($goods_list)){
			showMessage(Language::get('cart_record_error'),'index.php?act=cart','','error');
		}
		
		//整理商品信息
		$store_goods_price	= 0;//商品总价(不含运费)
		foreach ($goods_list as $k => $v) {
			$goods_list[$k] = $v;
			//构造购物车规格信息
			$goods_list[$k]['cart_spec_info'] = '';
			if ($v['spec_open'] == 1 && !empty($v['spec_goods_spec']) && !empty($v['spec_name'])){
				$spec_name = unserialize($v['spec_name']);
				if (!empty($spec_name)){
					$spec_name = array_values($spec_name);
					$spec_goods_spec = unserialize($v['spec_goods_spec']);
					$i = 0;
					foreach ($spec_goods_spec as $speck=>$specv){
						$goods_list[$k]['cart_spec_info'] .= $spec_name[$i].":".$specv."&nbsp;";
						$i++;
					}
				}
			}
			//商品库存
			$quantity = intval($cart_goods_list_new[$v['spec_id']]['goods_num']);//购买数量
			if (intval($v['spec_goods_storage']) < $quantity){//验证库存，不足时提示不能购买
				showMessage(Language::get('cart_index_store_goods').Language::get('nc_colon').$v['goods_name']
				.Language::get('nc_comma').Language::get('cart_index_freight_not_enough'),'index.php?act=cart','','error');
			}
			$goods_list[$k]['goods_num'] = $quantity;
			$goods_list[$k]['goods_all_price']	= ncPriceFormat(floatval($v['spec_goods_price']) * $quantity);//单件商品总价格
			$store_goods_price	= ncPriceFormat(floatval($goods_list[$k]['goods_all_price']) + $store_goods_price);//商品金额
		}
		return array('goods_list'=>$goods_list,'store_goods_price'=>$store_goods_price,'store_info'=>$store_info);
	}
	/**
	 * 购物流程第二步
	 */
	public function step2Op() {
		$store_id	= intval($_POST['store_id']);
		if ($store_id <= 0){
			showMessage(Language::get('cart_index_not_exists_store'),'index.php?act=cart','','error');
		}
		$address_options = intval($_POST['address_options']);
		if ($address_options <= 0){
			showMessage(Language::get('cart_step1_chooseaddress_error'),'index.php?act=cart&op=step1&store_id='.$store_id,'','error');
		}
		$mode_address	= Model('address');
		$address_info	= $mode_address->getOneAddress($address_options);
		if (empty($address_info)){
			showMessage(Language::get('cart_step1_chooseaddress_error'),'index.php?act=cart&op=step1&store_id='.$store_id,'','error');
		}

		//获取合法的商品及总金额
		$legalGoods_list = $this->getLegalGoods($store_id);
		
		//添加订单中的商品信息
		$shipping_fee_total = 0;
		
		//实例化订单模型
		$order_class= Model('order');
		//添加生成订单，在此步中，并没有完全生成订单，还需要接下来的其他信息进行订单填充
		$order_array		= array();
		$order_array['order_sn']		= $order_class->snOrder();
		$order_array['seller_id']		= $legalGoods_list['store_info']['member_id'];
		$order_array['store_id']		= $legalGoods_list['store_info']['store_id'];
		$order_array['store_name']		= $legalGoods_list['store_info']['store_name'];
		$order_array['buyer_id']		= $_SESSION['member_id'];
		$order_array['buyer_name']		= $_SESSION['member_name'];
		$order_array['buyer_email']		= $_SESSION['member_email'];
		$order_array['add_time']		= TIMESTAMP;
		$order_array['out_sn']			= $order_class->outSnOrder();
		$order_array['invoice']			= '';	//发票信息，暂时没有
		$order_array['evaluation_status'] = 0;
		$order_array['order_type'] 		= 0;
		$order_array['order_message']	= trim($_POST['order_message']);

		//增加运费和配送方式
		if (!empty($_POST['transport_type'])){
			$tmp = @explode('|',$_POST['transport_type']);
			if (is_array($tmp) && is_numeric($tmp[1])){
				$order_array['shipping_name'] = str_replace(array('py','kd','es'),array(Language::get('transport_type_py'),Language::get('transport_type_kd'),'EMS'),$tmp[0]);
				$shipping_fee_total =  $tmp[1];
			}
		}else{
			$order_array['shipping_name']	= '';					
		}
		$output_order = $order_array;
		$order_id	= $order_class->addOrder($order_array);

		$model_store_goods	= Model('goods');    
		$date = date('Ymd',time());  
		$model = Model();  
		$stat_model = Model('statistics');
		if(!empty($legalGoods_list['goods_list'])) {
			$output_goods_name = array();
			foreach ($legalGoods_list['goods_list'] as $val) {
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
        $mansong = $this->mansong($store_id,$legalGoods_list['store_goods_price']);
        if($mansong['rule_shipping_free']) {
            $shipping_fee_total = 0;echo 'b'.$shipping_fee_total;
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
		$order_amount	= ncPriceFormat($legalGoods_list['store_goods_price']+$shipping_fee_total-$mansong['rule_discount']);
		$order_class->addAddressOrder($address_array);

		//更改订单信息，更改订单总额，商品总额，优惠价格,配送信息
		$order_sn		= $order_array['order_sn'];
		$order_array	= array();
		$order_array['goods_amount']	= $legalGoods_list['store_goods_price'];
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

		$output_order = array_merge($output_order,$order_array,array('order_id'=>$order_id,'seller_name'=>$legalGoods_list['store_info']['member_name']));
		//发送邮件通知
		$param	= array(
			'site_url'		=> SiteUrl,
			'site_name'		=> $GLOBALS['setting_config']['site_name'],
			'buyer_name'	=> $_SESSION['member_name'],
			'seller_name'	=> $legalGoods_list['store_info']['member_name'],
			'order_sn'		=> $order_sn,
			'order_id'		=> $order_id
		);
		$this->send_notice($_SESSION['member_id'],'email_tobuyer_new_order_notify',$param);
		$this->send_notice($legalGoods_list['store_info']['member_id'],'email_toseller_new_order_notify',$param);
		@header("Location: index.php?act=cart&op=order_pay&order_id=".$order_id);
		exit;
	}
   /**
	 * 会员中心订单列表传过来的商品付款
	 */
	public function order_payOp() {
		$order_id	= intval($_GET['order_id']);
		if ($order_id <= 0){
			showMessage(Language::get('cart_order_pay_not_exists'),'','html','error');
		}
		//查询订单信息
		$model_order= Model('order');
		$order_info	= $model_order->getOrderById($order_id);
		if(empty($order_info) || $order_info['buyer_id'] != $_SESSION['member_id']){
			showMessage(Language::get('cart_order_pay_not_exists'),'','html','error');
		}
		
		$goods_list = Model()->table('order_goods')->field('goods_name')->where(array('order_id'=>$order_id))->limit(3)->select();
		$output_goods_name = array();
		foreach ((array)$goods_list as $v) {
			if (count($output_goods_name)<3) $output_goods_name[] = $v['goods_name'];
		}
		
   		if (!C('payment')){
	   		//取得平台支付方式
			$model_payment = Model('gold_payment');
			//支付方式列表
			$condition = array();
			$condition['payment_state'] = '1';//可用的支付方式
			$payment_list = $model_payment->getList($condition);
			foreach ((array)$payment_list as $v) {
				if ($v['payment_online'] == 1){
					$online_array[] = $v;
				}else{
					$offline_array[] = $v;
				}
			}
   		}else{
			//店铺可用的支付方式		
			$model_payment	= Model('payment');
			$online_array	= $model_payment->listStorePayment(1,$order_info['store_id']);
			$offline_array = $model_payment->listStorePayment(0,$order_info['store_id']);
   		}
        $output_order = $order_info;
        $output_order['seller_name'] = Model()->table('store')->getfby_store_id($order_info['store_id'],'member_name');
        Tpl::output('online_array',$online_array);
		Tpl::output('offine_array',$offline_array);
		Tpl::output('goods_name',$output_goods_name);
		Tpl::output('order',$output_order);
		Tpl::showpage('cart_step2');
	} 
     /**
      * 添加新的收货地址
      *
      */
     public function newaddressOp(){
     	if ($_GET['form_submit'] == 'ok'){
     		
     		$phone_tel = trim($_GET['phone_tel']);
     		$phone_mob = trim($_GET['phone_mob']);
     		//验证表单信息
     		$obj_validate = new Validate();
     		$obj_validate->validateparam = array(
     			array("input"=>$_GET["consignee"],"require"=>"true","message"=>Language::get('cart_step1_input_receiver')),
     			array("input"=>$_GET["areaid"],"require"=>"true","validator"=>"Number","message"=>Language::get('cart_step1_choose_area')),
     			array("input"=>$_GET["address"],"require"=>"true","message"=>Language::get('cart_step1_input_address'))
     		);
     		$error = $obj_validate->validate();
     		if ($phone_tel == '' && $phone_mob == ''){
     			$error .= Language::get('cart_step1_telphoneormobile').'<br/>';
     		}
			if ($error != ''){
				//转码
				if (strtoupper(CHARSET) == 'GBK'){
					$error = Language::getUTF8($error);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
				}
				echo json_encode(array('done'=>false,'msg'=>$error));
				die;
			}
			$address_model = Model('address');
			$insert_arr = array();
			$insert_arr['true_name'] = $_GET['consignee'];
			$insert_arr['area_id'] = intval($_GET['areaid']);
			$insert_arr['city_id'] = intval($_GET['city_id']);
			$insert_arr['area_info'] = $_GET['area_info'];
			$insert_arr['address'] = $_GET['address'];
			$insert_arr['zip_code'] = $_GET['zipcode'];
			$insert_arr['tel_phone'] = $phone_tel;
			$insert_arr['mob_phone'] = $phone_mob;
	     	//转码
			if(strtoupper(CHARSET) == 'GBK'){
				$insert_arr = Language::getGBK($insert_arr);
			}
			$rs = $address_model->addAddress($insert_arr);
			if ($rs){
				echo json_encode(array('done'=>true,'id'=>$rs));
				die; 
			}else {
				echo json_encode(array('done'=>false,'msg'=>Language::get('cart_step1_addaddress_fail','UTF-8')));
				die;
			}
     	}else {
     		$address_model = Model('address');
     		//查询已经选择的地址信息
     		$choose_addressid = intval($_GET['addr_id']);
     		$address_info = array();
     		if ($choose_addressid > 0){
     			$address_info = $address_model->getOneAddress($choose_addressid);
     			if (!empty($address_info)){
     				$address_info['area_info_arr'] = explode("\t",$address_info['area_info']);
     			}
     		}
     		Tpl::output('areainfo_defaultid',$areainfo_defaultid);
     		Tpl::output('address_info',$address_info);
     		Tpl::showpage('cart_newaddress','null_layout');
     	}
     }

	/**
	 * 进入商品购物流程时运费异步计算显示
	 *
	 * @return unknown
	 */
	function calc_buyOp(){
		if (empty($_GET['hash'])) return false;
		$hash = decrypt($_GET['hash'],MD5_KEY.'CART');
		if (strpos($hash,'-') === false) return false;
		$hash = explode('-',$hash);	
		/**
		 * $hash 内容注解
		 * $hash[0] = '1,2,3'  运费模板ID组合
		 * $hash[1] = '1,2,3'  依次购买数量
		 * $hash[2] = '10.00_14.00_25.00,10.00_14.00_25.00'  未使用运费模板，直接设置三种运费的价格组合，顺序为py,kd,es
		 */
		$tid = explode(',',$hash[0]);
		$tnum = explode(',',$hash[1]);
		if (count($tid) != count($tnum)) return false;
		$tmp = array();
		foreach($tid as $k=>$v){
			$tmp[$k]['num'] = $tnum[$k];
			$tmp[$k]['transport_id'] = $tid[$k];
		}
		
		//定义返回数组
		$result = array();
		$result['py'] = 0;
		$result['kd'] = 0;
		$result['es'] = 0;
				
		//购买的商品都没有使用运费模板,正接设定的运费价格
		if ((empty($hash[0]) || empty($hash[0]) && strpos($hash[2],'_'))){
				$_price = explode(',',$hash[2]);
				if ($_price[0] != ''){
					foreach ($_price as $value) {
						$_tprice = explode('_',$value);
						if (is_numeric($_tprice[0]) && $_tprice[0] > 0) $result['py'] += $_tprice[0];
						if (is_numeric($_tprice[1]) && $_tprice[1] > 0) $result['kd'] += $_tprice[1];
						if (is_numeric($_tprice[2]) && $_tprice[2] > 0) $result['es'] += $_tprice[2];
						 if($_tprice[2] == '0.00') $unset_es = true;
					}
				}
		}else{
				//购买的商品中有使用运费模板的商品
				$model_transport = Model('transport');
				$extend = $model_transport->getExtendList(array('transport_id'=>array('in',$hash[0])));
				$new_extend = array();
				$unset_py = true;
				$unset_kd = true;
				$unset_es = true;
				if (!empty($extend) && is_array($extend)){
					foreach ($extend as $k => $v) {
						$new_extend[$v['transport_id']][] = $v;
						if ($v['type'] == 'py') $unset_py = false;
						if ($v['type'] == 'kd') $unset_kd = false;
						if ($v['type'] == 'es') $unset_es = false;						
					}
				}
				//取得每个商品的三种运费
				$calc = array();
				foreach ($tmp as $k => $v) {
					$calc[$k] = $this->calc_unit($_GET['area_id'],$v['num'],$new_extend[$v['transport_id']]);
				}
				//合并平邮运费、合并快递运费、合并EMS运费		
				foreach ($calc as $v) {
					$result['py'] += $v['py'];
					$result['kd'] += $v['kd'];
					$result['es'] += $v['es'];
				}
				//最后加上未使用运费模板直接设置三种运费商品的运费
				if (strpos($hash[2],'_')){
					$_price = explode(',',$hash[2]);
					if ($_price[0] != ''){
						foreach ($_price as $value) {
							$_tprice = explode('_',$value);
							if (is_numeric($_tprice[0]) && $_tprice[0] > 0) $result['py'] += $_tprice[0];
							if (is_numeric($_tprice[1]) && $_tprice[1] > 0) $result['kd'] += $_tprice[1];
							if (is_numeric($_tprice[2]) && $_tprice[2] > 0) $result['es'] += $_tprice[2];
							 if($_tprice[2] == '0.00') $unset_es = true;
						}
					}
				}			
		}
		//格式化，保留两位小数点输出
		$result['py'] = sprintf('%.2f',$result['py']);
		$result['kd'] = sprintf('%.2f',$result['kd']);
		$result['es'] = sprintf('%.2f',$result['es']);
		if ($unset_es == true){//有商品不支持EMS，所以总配置方法也删除
			unset($result['es']);
		}
		if ($unset_py == true){//运费模板中没有平邮
			unset($result['py']);
		}
		if ($unset_kd == true){//运费模板中没有快递
			unset($result['kd']);
		}
		echo json_encode($result);
	}
	/**
	 * 计算某个具单元的运费
	 *
	 * @param 配送地区 $area_id
	 * @param 购买数量 $num
	 * @param 运费模板内容 $extend
	 */
	private function calc_unit($area_id,$num,$extend){
		if (!empty($extend) && is_array($extend)){
			$calc = array();
			$calc_default = array();
			foreach ($extend as $v) {
				if (strpos($v['area_id'],",".intval($_GET['area_id']).",") !== false){
					if ($num <= $v['snum']){
						//在首件数量范围内
						$calc[$v['type']] = $v['sprice'];
					}else{
						//超出首件数量范围，需要计算续件
						$calc[$v['type']] = sprintf('%.2f',($v['sprice'] + ceil(($num-$v['snum'])/$v['xnum'])*$v['xprice']));
					}
				}
				if ($v['is_default']==1){
					if ($num <= $v['snum']){
						//在首件数量范围内
						$calc_default[$v['type']] = $v['sprice'];
					}else{
						//超出首件数量范围，需要计算续件
						$calc_default[$v['type']] = sprintf('%.2f',($v['sprice'] + ceil(($num-$v['snum'])/$v['xnum'])*$v['xprice']));
					}
				}
			}
			//如果运费模板中没有指定该地区，取默认运费
			foreach (array('py','kd','es') as $v){
				if (!isset($calc[$v]) && isset($calc_default[$v])){
					$calc[$v] = $calc_default[$v];
				}
			}
		}
		return $calc;
	}

	/**
	 * 异步取得订单总价格
	 *
	 */
	function order_amoutOp(){
		
		$order = model()->table('order')->where(array('order_id'=>intval($_GET['order_id']),'buyer_id'=>$_SESSION['member_id']))->field('order_amount')->find();
		echo ncPriceFormat($order['order_amount']);
	}
}
