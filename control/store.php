<?php
/**
 * 会员中心——我是卖家
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

class storeControl extends BaseMemberStoreControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_store_index');
	}
	/**
	 * 卖家中心首页
	 *
	 * @param 
	 * @return 
	 */
	public function indexOp() {

		Language::read('member_home_index');
		$lang	= Language::getLangContent();

		//支付方式列表
		if (C('payment')){		
			$model_payment = Model('payment');
			if (file_exists(BasePath.DS.'api'.DS.'payment'.DS.'payment.inc.php')){//$payment_inc
				require_once(BasePath.DS.'api'.DS.'payment'.DS.'payment.inc.php');
			}
			$payment_list = $model_payment->getPaymentList();
			if (strtoupper(CHARSET) == 'GBK'){
				$payment_list = Language::getGBK($payment_list);
			}
			$payment_list	= $model_payment->checkinstallPayment($payment_list);
			$store_payment = array();
			if(is_array($payment_list) && !empty($payment_list)) {
				foreach ($payment_list as $key => $val) {
					if($val['install'] == 1 && @in_array($val['code'],$payment_inc)) $store_payment[] = $val;
				}
			}
			Tpl::output('store_payment',$store_payment);
		}
		/**
		 * 实例化店铺模型
		 */
		$model_store	= Model('store');
		$store_info		= $model_store->shopStore(array('store_id'=>$_SESSION['store_id']));

		if($store_info['store_end_time']!='') {
			$store_info['store_end_time'] = number_format(($store_info['store_end_time']-time())/(3600*24),2);
		}
		$store_info['store_end_time']	= $store_info['store_end_time'] ? ($store_info['store_end_time']<=0) ? $lang['store_end'] : $store_info['store_end_time'].$lang['store_day'] : $lang['store_no_limit'];
		/**
		 * 店铺信用
		 */
		$store_info['credit_arr'] = getCreditArr($store_info['store_credit']);
		//生成缓存的键值
		$hash_key = $_SESSION['store_id'];
		if ($_cache = rcache($hash_key,'store')){
			foreach ($_cache as $k=>$v){
				$store_info[$k] = $v;
			}
		}else {
			//动态评价
			$store_info['store_desccredit_rate'] = @round($store_info['store_desccredit']/5*100,2);
			$store_info['store_servicecredit_rate'] = @round($store_info['store_servicecredit']/5*100,2);
			$store_info['store_deliverycredit_rate'] = @round($store_info['store_deliverycredit']/5*100,2);
			//实例化店铺等级模型
			$store_grade = ($setting = F('store_grade')) ? $setting : H('store_grade',true,'file');
			$store_grade = $store_grade[$store_info['grade_id']];
			$store_info['grade_id'] = $store_grade['sg_id'];
			$store_info['grade_name'] = $store_grade['sg_name'];
			$store_info['grade_goodslimit'] = $store_grade['sg_goods_limit'];
			$store_info['grade_albumlimit'] = $store_grade['sg_album_limit'];
		}
		if(!file_exists(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id'])){
			mkdir(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id']);
		}
//		$store_info['goods_count'] = $model_store->table('goods')->where(array('store_id'=>$store_info['store_id']))->count();
//		$store_info['goods_count'] = intval($store_info['goods_count'])>0?intval($store_info['goods_count']):0;
//		$store_info['grade_goodslimit']	= $store_info['grade_goodslimit'] == 0 ? $lang['store_none_limit'] : $store_info['goods_count'].'/'.$store_info['grade_goodslimit'];
		Tpl::output('store_info',$store_info);

		$model_goods	= Model('goods');
		$model	= Model();
		$add_time_to = date("Y-m-d");//当前日期
		$add_time_from = date("Y-m-d",(strtotime($add_time_to)-60*60*24*30));//30天前
		Tpl::output('add_time_from',$add_time_from);
		Tpl::output('add_time_to',$add_time_to);
		//查询会员现有金币数,预存款
		$member_model = Model('member');
		$member_info = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		Tpl::output('member_info',$member_info);
		
		$model_article	= Model('article');
		$condition	= array();
		$condition['article_show'] = '1';
		$condition['ac_id'] = '1';
		$condition['order'] = 'article_sort desc,article_time desc';
		$condition['limit'] = '5';
		$show_article	= $model_article->getArticleList($condition);
		Tpl::output('show_article',$show_article);
		$phone_array = explode(',',C('site_phone'));
		Tpl::output('phone_array',$phone_array);

		Tpl::output('menu_sign','index');
		Tpl::showpage('home');
	}
	
	/**
	 * 异步取得卖家统计类信息
	 *
	 */
	public function statisticsOp() {
		$model = model();
		$add_time_to = date("Y-m-d");//当前日期
		$add_time_from = date("Y-m-d",(strtotime($add_time_to)-60*60*24*30));//30天前		
		$goods_selling = 0;//出售中商品
		$goods_show0 = 0;//违规下架商品
		$goods_storage = 0;//仓库待上架商品
		$consult = 0;//未回复咨询
		$inform = 0;//30天举报
		$complain = 0;//进行中投诉
		$progressing = 0;//交易中的订单
		$pending = 0;//待处理
		$shipped = 0;//待发货
		$shipping = 0;//待买家收货
		$evalseller = 0;//待卖家评价
		$return = 0;//30天退货记录
		$refund = 0;//30天退款记录
		$order30 = 0;//30天订单记录

		$goods_selling = $model->table('goods')->where(array('store_id'=>$_SESSION['store_id'],'goods_show'=>'1'))->count();
		$goods_show0 = $model->table('goods')->where(array('store_id'=>$_SESSION['store_id'],'goods_state'=>'1'))->count();
		$goods_storage = $model->table('goods')->where(array('store_id'=>$_SESSION['store_id'],'goods_state'=>'0','goods_show'=>'0'))->count();
		$consult = $model->table('consult')->where(array('seller_id'=>$_SESSION['member_id'],'consult_reply'=>''))->count();
		
		$condition = array();
		$condition['inform_store_id'] = $_SESSION['store_id'];
		$condition['inform_state'] = 2;
		$condition['inform_handle_type'] = 3;
		$condition['inform_datetime'] = array(array('gt',strtotime($add_time_from)),array('lt',strtotime($add_time_to)+60*60*24),'and');
		$inform = $model->table('inform')->where($condition)->count();

		$condition = array();
		$condition['accused_id'] = $_SESSION['member_id'];
		$condition['complain_state'] = array(array('gt',10),array('lt',90),'and');
		$complain = $model->table('complain')->where($condition)->count();
		
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['order_state'] = array(array('gt',0),array('neq',40),'and');
		$progressing = $model->table('order')->where($condition)->count();

		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['order_state'] = array(array('gt',0),array('lt',11),'and');
		$pending = $model->table('order')->where($condition)->count();

		$shipped = $model->table('order')->where(array('store_id'=>$_SESSION['store_id'],'order_state'=>20))->count();

		$shipping = $model->table('order')->where(array('store_id'=>$_SESSION['store_id'],'order_state'=>30))->count();
		$eval_condition = "store_id=".$_SESSION['store_id']." and order_state=40 and refund_state<2 ";
		$eval_condition .= "and evalseller_status = 0 and (((finnshed_time+60*60*24*15)>".time().") or ((evaluation_time+60*60*24*15)>".time().")) ";//交易成功 并且 卖家没有评价 并且 (1.十五天内 或者 2.买家评价后十五天内)
		$evalseller = $model->table('order')->where($eval_condition)->count();

		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['add_time'] = array(array('egt',strtotime($add_time_from)),array('elt',strtotime($add_time_to)+60*60*24),'and');
		$order30 = $model->table('order')->where($condition)->count();
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['return_state'] = array('gt',1);
		$condition['add_time'] = array(array('egt',strtotime($add_time_from)),array('elt',strtotime($add_time_to)+60*60*24),'and');
		$return = $model->table('return')->where($condition)->count();
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['refund_state'] = array('gt',1);
		$condition['add_time'] = array(array('egt',strtotime($add_time_from)),array('elt',strtotime($add_time_to)+60*60*24),'and');
		$refund = $model->table('refund_log')->where($condition)->count();

		//统计数组
		$statistics = array(
			'goods_selling'=>$goods_selling,
			'goods_storage'=>$goods_storage,
			'goods_show0'=>$goods_show0,
			'consult'=>$consult,
			'inform'=>$inform,
			'progressing'=>$progressing,
			'complain'=>$complain,
			'pending'=>$pending,
			'shipped'=>$shipped,
			'shipping'=>$shipping,
			'evalseller'=>$evalseller,
			'return'=>$return,
			'refund'=>$refund,
			'order30'=>$order30
		);
		exit(json_encode($statistics));
	}

	/**
	 * 卖家商品分类
	 *
	 * @param 
	 * @return 
	 */
	public function store_goods_classOp() {
		$model_class	= Model('my_goods_class');

		if($_GET['type'] == 'ok') {
			if(intval($_GET['class_id']) != 0) {
				$class_info	= $model_class->getClassInfo(array('stc_id'=>intval($_GET['class_id'])));
				Tpl::output('class_info',$class_info);
			}
			if(intval($_GET['top_class_id']) != 0) {
				Tpl::output('class_info',array('stc_parent_id'=>intval($_GET['top_class_id'])));
			}
			$goods_class		= $model_class->getClassList(array('store_id'=>$_SESSION['store_id'],'stc_top'=>1));
			Tpl::output('goods_class',$goods_class);
			Tpl::showpage('store_goods_class_add','null_layout');
		} else {
			$goods_class		= $model_class->getTreeClassList(array('store_id'=>$_SESSION['store_id']),2);
			$str	= '';
			if(is_array($goods_class) and count($goods_class)>0) {
				foreach ($goods_class as $key => $val) {
					$row[$val['stc_id']]	= $key + 1;
					$str .= intval($row[$val['stc_parent_id']]).",";
				}
				$str = substr($str,0,-1);
			} else {
				$str = '0';
			}
			Tpl::output('map',$str);
			Tpl::output('class_num',count($goods_class)-1);
			Tpl::output('goods_class',$goods_class);

			self::profile_menu('store_goods_class','store_goods_class');
			Tpl::output('menu_sign','store_goods_class');
			Tpl::output('menu_sign_url','index.php?act=store&op=store_goods_class');
			Tpl::output('menu_sign1','goods_class');
			Tpl::showpage('store_goods_class');
		}
	}
	/**
	 * 卖家商品分类保存
	 *
	 * @param 
	 * @return 
	 */
	public function goods_class_saveOp() {
		$model_class	= Model('my_goods_class');
		if($_POST['stc_id'] != '') {
			$choeck_class	= $model_class->getClassInfo(array('stc_id'=>intval($_POST['stc_id']),'store_id'=>$_SESSION['store_id']));
			if(empty($choeck_class)) {
				showDialog(Language::get('store_goods_class_wrong'));
			}
			$state = $model_class->editGoodsClass($_POST,intval($_POST['stc_id']));
			if($state) {
				showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=store_goods_class','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'));
			}
		} else {
			$state = $model_class->addGoodsClass($_POST);
			if($state) {
				showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=store_goods_class','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'));
			}
		}
	}
	/**
	 * 卖家商品分类删除
	 *
	 * @param 
	 * @return 
	 */
	public function drop_goods_classOp() {
		$model_class	= Model('my_goods_class');
		$drop_state	= $model_class->dropGoodsClass(trim($_GET['class_id']));
		if ($drop_state){
			showDialog(Language::get('nc_common_del_succ'),'index.php?act=store&op=store_goods_class','succ');
		}else{
			showDialog(Language::get('nc_common_del_fail'));
		}
	}
	/**
	 * 卖家订单默认页面
	 *
	 * @param 
	 * @return 
	 */
	public function store_orderOp() {
		$model_store_order	= Model('store_order');
		$model_member = Model('member');
		/**
		 * 订单分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/*搜索条件*/
		$array	= array();
		$array['order_state']	= trim($_GET['state_type'])=='' ? 'store_order' : trim($_GET['state_type']);
		$array['buyer_name']	= trim($_GET['buyer_name']);
		$array['order_sn']		= trim($_GET['order_sn']);
		$array['order_evalseller_able']		= trim($_GET['eval']);//待评价
        $array['add_time_from'] = strtotime($_GET['add_time_from']);
        $array['add_time_to'] = strtotime($_GET['add_time_to']);
        if($array['add_time_to'] > 0) {
            $array['add_time_to'] +=86400;
        }
		$order_list		= $model_store_order->storeOrderList($array,$page);
		if (is_array($order_list) && !empty($order_list)){
			$order_id_array = array();
			$order_array = array();
			$member_id_array = array();
			$member_array = array();
			$refund_array = array();//退款信息
			$return_array = array();//退货信息
			foreach ($order_list as $v) {
				if ($v['order_id'] == '') continue;
				$order_id_array[] = $v['order_id'];
				$order_array[$v['order_id']] = $v;				
				if(!in_array($v['buyer_id'],$member_id_array)) $member_id_array[] = $v['buyer_id'];
			}
			$goods_list = $model_store_order->storeOrderGoodsList(array('order_id'=>"'".implode("','",$order_id_array)."'"));
			$member_list = $model_member->getMemberList(array('in_member_id'=>"'".implode("','",$member_id_array)."'"));
			if (is_array($member_list) && !empty($member_list)){
				foreach ($member_list as $val) {
					$member_array[$val['member_id']] = $val;
				}
			}
			/**
			 * 实例化退款模型
			 */
			$model_refund	= Model('refund');
			$condition = array();
			$condition['seller_id'] = $_SESSION['member_id'];
			$condition['order_ids'] = "'".implode("','",$order_id_array)."'";
			$condition['refund_type'] = '1';
			$refund_list = $model_refund->getList($condition);
			if (is_array($refund_list) && !empty($refund_list)){
				foreach ($refund_list as $val) {
					$refund_array[$val['order_id']] = $val;
				}
			}
			/**
			 * 实例化退货模型
			 */
			$model_return	= Model('return'); 
			$condition = array();
			$condition['seller_id'] = $_SESSION['member_id'];
			$condition['order_ids'] = "'".implode("','",$order_id_array)."'";
			$condition['return_type'] = '1';
			$return_list= $model_return->getList($condition);
			if (is_array($return_list) && !empty($return_list)){
				foreach ($return_list as $val) {
					$return_array[$val['order_id']] = $val;
				}
			}
		}
		$goods_array = array();
		if (is_array($goods_list) && !empty($goods_list)){
			$store_class = Model('store');
			foreach ($goods_list as $val) {
				$order_id = $val['order_id'];
				if(is_array($refund_array[$order_id]) && !empty($refund_array[$order_id])) $val['refund'] = $refund_array[$order_id];
				if(is_array($return_array[$order_id]) && !empty($return_array[$order_id])) $val['return'] = $return_array[$order_id];
				$val['spec_info_arr'] = '';
				if (!empty($val['spec_info'])){
					$val['spec_info_arr']	= unserialize($val['spec_info']);
				}
				$val['state_info']		= orderStateInfo($val['order_state'],$val['refund_state']);
				//1.交易成功超过十五天双方都未评价时评价关闭2.一方评价后超过十五天评价结束
				if ($val['evalseller_status'] == 1){//卖家已经评价
					$val['able_evaluate'] = false;
				}else {
					$val['able_evaluate'] = true;
				}
				if ($val['able_evaluate'] && $val['evaluation_status'] == 0 && (intval($val['finnshed_time'])+60*60*24*15)<time()){
					$val['able_evaluate'] = false;
				}elseif ($val['able_evaluate'] && $val['evaluation_status'] == 1 && (intval($val['evaluation_time'])+60*60*24*15)<time()) {
					$val['able_evaluate'] = false;
				}
				$val['member_info'] = $member_array[$val['buyer_id']];
				$goods_array[$val['order_id']][] = $val;
			}
		}
		Tpl::output('goods_array',$goods_array);
		Tpl::output('order_array',$order_array);
		Tpl::output('show_page',$page->show());
        //输出投诉失效变量
        Tpl::output('complain_time_limit',C('complain_time_limit'));

		self::profile_menu('store_order',$array['order_state']);
		Tpl::output('menu_sign','store_order');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_order');
		Tpl::output('menu_sign1',empty($_GET['state_type'])?'all_order':$_GET['state_type']);
		Tpl::showpage('store_order');
	}

	/**
	 * 卖家订单状态操作
	 *
	 */
	public function change_stateOp() {
		$state_type	= trim($_GET['state_type']);
		$order_id	= intval($_GET['order_id']);
		if($state_type == '') return ;
		/**
		 * 实例化订单模型
		 */
		$model_order = Model('order');

        //检查订单是否属于当前
        if(!$model_order->checkOrderBelongStore($order_id,$_SESSION['store_id'])) {
            showMessage(Language::get('store_order_invalid_order'),'','','error');
        }

		$array		= array();
		switch ($state_type) {
	        // 确认订单
	        case 'order_confirm':
	            $temp_file = 'store_order_confirm';
	            $state_code = 60;
	            break;
			//收到付款
			case 'store_order_pay':
				$temp_file	= 'store_order_pay';
				$state_code = 20;
				$array['payment_time'] = time();
				break;
				//调整费用
			case 'store_order_edit_price':
				$temp_file	= 'store_order_edit_price';
				$state_code = 10;
				if(chksubmit()) {
					$array['order_amount'] = ncPriceFormat(trim($_POST['order_amount']));
					$model_order->updateOrder($array,$order_id);
				} else {
					$order_info	= $model_order->getOrderById($order_id,'simple');
					Tpl::output('order_info',$order_info);
				}
				break;
				//取消订单
			case 'store_order_cancel':
				$temp_file	= 'store_order_cancel';
				$state_code	= 0;
				break;
		}
		if(chksubmit()) {
			$array['order_state'] = $state_code;
				if($state_code == 0) {
					/**
			 		* 实例化订单模型
			 		*/
					$model_store_order = Model('store_order');
					$goods_list = $model_store_order->storeOrderGoodsList(array('order_id'=>$order_id));
					$model_goods= Model('goods');
					if(is_array($goods_list) and !empty($goods_list)) {
						foreach ($goods_list as $val) {
							$model_goods->updateSpecStorageGoods(array('spec_goods_storage'=>array('value'=>$val['goods_num'],'sign'=>'increase'),'spec_salenum'=>array('value'=>$val['goods_num'],'sign'=>'decrease')),$val['spec_id']);
							$model_goods->updateGoods(array('salenum'=>array('value'=>$val['goods_num'],'sign'=>'decrease')),$val['goods_id']);
						}
					}
				}

				$model_order->addLogOrder($state_code,$order_id,($_POST['state_info1']!=''? $_POST['state_info1'] :$_POST['state_info'] ));
				$model_order->updateOrder($array,$order_id);

				$order	= $model_order->getOrderById(intval($_GET['order_id']),'simple');
				
				/**
				 * 发送通知
				 */
				$param	= array(
					'site_url'	=> SiteUrl,
					'site_name'	=> $GLOBALS['setting_config']['site_name'],
					'store_name'	=> $order['store_name'],
					'buyer_name'	=> $order['buyer_name'],
					'order_sn'	=> $order['order_sn'],
					'order_id'	=> $order['order_id'],
					'invoice_no'=> $order['shipping_code'],
					'reason'	=> $_POST['state_info1']!=''? $_POST['state_info1'] :$_POST['state_info']
				);
				$code	= '';
				switch ($state_type) {
					//收到付款
					case 'store_order_pay':
						$code	= 'email_tobuyer_offline_pay_success_notify';
						break;
					//调整费用
					case 'store_order_edit_price':
						$code	= 'email_tobuyer_adjust_fee_notify';
						break;
					//取消订单
					case 'store_order_cancel':
						$code	= 'email_tobuyer_cancel_order_notify';
						break;
				}
				if($code != ''){
					$this->send_notice($order['buyer_id'],$code,$param);
				}
			showDialog(Language::get('nc_common_save_succ'),'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
		} else {
			Tpl::output('order_id',$order_id);
			Tpl::showpage($temp_file,'null_layout');
		}
	}
	/**
	 * 查看订单
	 *
	 */	
	public function show_orderOp() {
		$order_id	= intval($_GET['order_id']);
		/**
		 * 实例化订单模型
		 */
		$model_order	= Model('order');
		$condition = array();
		$condition['store_id'] = $_SESSION['store_id'];
		$condition['order_id'] = $order_id;
		$order_info = $model_order->getOrderById($order_id,'all',$condition);
		$order_id	= intval($order_info['order_id']);
		if($order_id == 0) {
			showMessage(Language::get('miss_argument'),'','html','error');
		}
		$order_info['state_info'] = orderStateInfo($order_info['order_state'],$order_info['refund_state']);
		Tpl::output('order_info',$order_info);
		
		if(!empty($order_info['group_id']) && is_numeric($order_info['group_id'])){
			$group_name = Model()->table('goods_group')->getfby_group_id($order_info['group_id'],'group_name');
			Tpl::output('group_name',$group_name);
		}
		
		/**
		 * 卖家信息
		 */
		$model_store	= Model('store');
		$store_info		= $model_store->shopStore(array('store_id'=>$order_info['store_id']));
		Tpl::output('store_info',$store_info);
		/**
		 * 实例化买家订单模型
		 */
		$model_store_order = Model('store_order');
		/**
		 * 订单商品
		 */
		$order_goods_list= $model_store_order->storeOrderGoodsList(array('order_id'=>$order_id));
		Tpl::output('order_goods_list',$order_goods_list);
		/**
		 * 订单处理历史
		 */		
		$log_list	= $model_order->orderLoglist($order_id);
		Tpl::output('order_log',$log_list);
		/**
		 * 实例化退款模型
		 */
		$model_refund	= Model('refund');
		$condition = array();
		$condition['seller_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$condition['refund_state'] = '2';
		$condition['order']	=  'log_id asc';
		$refund_list = $model_refund->getList($condition);
		Tpl::output('refund_list',$refund_list);
		/**
		 * 实例化退货模型
		 */
		$model_return	= Model('return'); 
		$condition = array();
		$condition['seller_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$condition['return_state'] = '2';
		$condition['order']	=  'return.return_id asc';
		$return_list= $model_return->getReturnGoodsList($condition);
		Tpl::output('return_list',$return_list);
		/**
		 * 页面输出
		 */
		self::profile_menu('member_order','member_order');
		Tpl::output('menu_sign','show_order');
		Tpl::output('left_show','order_view');
		Tpl::showpage('store_order_view');
	}
	/**
	 * 支付方式
	 *
	 * @param 
	 * @return 
	 */
	public function paymentOp() {
		$model_payment = Model('payment');
		/**
		 * 支付方式列表
		 */
		$payment_list = $model_payment->getPaymentList();
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$payment_list = Language::getGBK($payment_list);
		}
		/**
		 * 支付方式安装情况
		 */
		if (file_exists(BasePath.DS.'api'.DS.'payment'.DS.'payment.inc.php')){
			/**
			 * $payment_inc
			 */
			require_once(BasePath.DS.'api'.DS.'payment'.DS.'payment.inc.php');
		}
		/**
		 * 检测店铺是否安装
		 */
		$payment_list	= $model_payment->checkinstallPayment($payment_list);

		Tpl::output('payment_inc',$payment_inc);
		Tpl::output('payment_list',$payment_list);

		self::profile_menu('payment','payment');
		Tpl::output('menu_sign','payment');
		Tpl::output('menu_sign_url','index.php?act=store&op=payment');
		Tpl::output('menu_sign1','payment_list');
		Tpl::showpage('payment_list');
	}
	/**
	 * 添加支付接口
	 *
	 * @param 
	 * @return 
	 */	
	public function add_paymentOp() {
		$model_payment	= Model('payment');
		/**
		 * 检查支付接口是否存在
		 */		
		$paymemt_code	= trim($_REQUEST['payment_code']);
		$check_payment	= $model_payment->checkPayment($paymemt_code);
		if(!$check_payment) {
			showDialog(Language::get('store_payment_not_exists'));
		}
		$payment_info	= $model_payment->getPaymentInfo($paymemt_code,'file');
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$payment_info = Language::getGBK($payment_info);
		}
		/**
		 * 支付接口配置入库
		 */			
		if($_GET['submit'] == 'ok') {
			$model_payment->savePayment($payment_info['config']);
			showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=payment','succ');
		}
		/**
		 * 支付接口配置入库信息提取
		 */			
		$payment_array	= $model_payment->getPaymentInfo($paymemt_code,'sql');
		if(is_array($payment_array) and !empty($payment_array)) {
			$payment_info['payment_id']		= $payment_array['payment_id'];
			$payment_info['payment_info']	= $payment_array['payment_info'];
			$payment_info['payment_state']	= $payment_array['payment_state'];
			$payment_info['payment_sort']	= $payment_array['payment_sort'];
			$config_array	= unserialize($payment_array['payment_config']);
			if(is_array($config_array) and !empty($config_array)) {
				foreach ($payment_info['config'] as $k => $v) {
					$payment_info['config'][$k]['value'] = $config_array[$k];
				}
			}
		}

		Tpl::output('payment_info',$payment_info);
		self::profile_menu('payment','payment');
		Tpl::output('menu_sign','payment');
		Tpl::output('menu_sign_url','index.php?act=store&op=payment');
		Tpl::output('menu_sign1','payment_list');
		Tpl::showpage('payment_add');
	}
	/**
	 * 卸载店铺支付接口
	 *
	 * @param 
	 * @return 
	 */	
	public function uninstall_paymentOp() {
		$model_payment	= Model('payment');
		$payment_id		= intval($_GET['payment_id']);
		$uninstall_state= $model_payment->uninstallPayment($payment_id);
		if($uninstall_state) {
			showDialog(Language::get('nc_common_op_succ'),'index.php?act=store&op=payment','succ');
		} else {
			showDialog(Language::get('nc_common_op_fail'));
		}
	}
	/**
	 * 检查店铺名称是否存在
	 *
	 * @param 
	 * @return 
	 */
	public function checknameOp() {
		if(!$this->checknameinner()) {
			echo 'false';
		} else {
			echo 'true';
		}
	}
	/**
	 * 卖家导航新增
	 */
	public function store_navigation_addOp() {
		/**
		 * 实例化模型
		 */
		$model_class = Model('store_navigation_partner');
	    /**
		 * 判断页面类型
		 */
		if (!empty($_GET['type'])){
			/**
			 * 新增/编辑导航
			 */
			if (intval($_GET['sn_id']) > 0){
				/**
				 * 得到导航信息
				 */
				$sn_info = $model_class->getOneNavigation(intval($_GET['sn_id']));
				/**
				 * 输出导航信息
				 */
				Tpl::output('sn_info',$sn_info);
			}
			/**
			 * 增加/修改页面输出
			 */
			//编辑器多媒体功能
		    $editor_multimedia = false;
			Tpl::output('editor_multimedia',$editor_multimedia);
			if($_GET['type'] == 'add'){
				self::profile_menu('store_navigation','store_navigation_add');
		        Tpl::output('menu_sign','store_navigation');
		        Tpl::output('menu_sign_url','index.php?act=store&op=store_navigation');
		        Tpl::output('menu_sign1','navigation_add');
		        Tpl::showpage('store_navigation_form');
			}
			if($_GET['type'] == 'edit'){
				self::profile_menu('store_navigation_edit','store_navigation_edit');
		        Tpl::output('menu_sign','store_navigation');
		        Tpl::output('menu_sign_url','index.php?act=store&op=store_navigation');
		        Tpl::output('menu_sign1','navigation_edit');
		        Tpl::showpage('store_navigation_edit');
			}
		}
	}
	/**
	 * 卖家导航管理
	 *
	 * @param string	
	 * @param string 	
	 * @return 
	 */
	public function store_navigationOp() {
		/**
		 * 实例化模型
		 */
		$model_class = Model('store_navigation_partner');
		
		/**
		 * 判断操作类型
		 */
		if (chksubmit()){
			/**
			 * 验证表单信息
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["sn_title"],		"require"=>"true",		"message"=>Language::get('store_navigation_name_null')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}
			if (intval($_POST['sn_id']) > 0){
				/**
				 * 保存编辑导航
				 */
				if ($model_class->updateNavigation($_POST)){
					showDialog(Language::get('nc_common_save_succ'),"index.php?act=store&op=store_navigation",'succ');
				}else {
					showDialog(Language::get('nc_common_save_fail'));
				}
			}else {
				/**
				 * 保存新增导航
				 */
				if ($model_class->addNavigation($_POST)){
					showDialog(Language::get('nc_common_save_succ'),"index.php?act=store&op=store_navigation",'succ');
				}else {
					showDialog(Language::get('nc_common_save_fail'));
				}
			}
		}
		/**
		 * 删除店铺导航
		 */
		if ($_GET['drop'] == 'single' && (intval($_GET['sn_id']))>0){
			/**
			 * 验证是否为当前店铺导航
			 */
			if ($model_class->checkNavigation($_SESSION['store_id'],intval($_GET['sn_id']))){
				/**
				 * 删除店铺导航
				 */
				if($model_class->delNavigation(intval($_GET['sn_id']))){
					showDialog(Language::get('nc_common_op_succ'),"index.php?act=store&op=store_navigation",'succ');
				}else {
					showDialog(Language::get('nc_common_op_fail'));
				}
			}
		}elseif ($_GET['drop'] == 'all' && !empty($_GET['sn_id'])){
			/**
			 * 批量删除店铺导航
			 */
			$sn_array = explode(',',$_GET['sn_id']);
			if (!empty($sn_array) && is_array($sn_array)){
				foreach ($sn_array as $key=>$value){
					$value = intval($value);
					/**
					 * 验证是否为当前店铺导航
					 */
					if ($model_class->checkNavigation($_SESSION['store_id'],$value)){
						/**
						 * 删除店铺导航
						 */
						if (!$model_class->delNavigation($value)){
							showDialog(Language::get('nc_common_save_fail'));
						}
					}
				}
				showDialog(Language::get('nc_common_op_succ'),"index.php?act=store&op=store_navigation",'succ');
			}
		}
		/**
		 * 显示店铺导航列表
		 */
		$condition['sn_store_id'] = $_SESSION['store_id'];
		$navigation_list = $model_class->getNavigationList($condition);

		Tpl::output('navigation_list',$navigation_list);

		self::profile_menu('store_navigation','store_navigation');
		Tpl::output('menu_sign','store_navigation');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_navigation');
		Tpl::output('menu_sign1','navigation_list');
		Tpl::showpage('store_navigation_list');
	}

	/**
	 * 卖家合作伙伴管理
	 *
	 * @param string	
	 * @param string 	
	 * @return 
	 */
	public function store_partnerOp() {
		/**
		 * 实例化模型
		 */
		$model_class = Model('store_navigation_partner');
		/**
		 * 判断页面类型
		 */
		if (!empty($_GET['type'])){
			/**
			 * 新增/编辑合作伙伴
			 */
			if (intval($_GET['sp_id']) > 0){
				/**
				 * 得到合作伙伴信息
				 */
				$sp_info = $model_class->getOnePartner(intval($_GET['sp_id']));
				/**
				 * 输出合作伙伴信息
				 */
				Tpl::output('sp_info',$sp_info);
			}
			/**
			 * 增加/修改页面输出
			 */
			Tpl::output('type',$_GET['type']);
			Tpl::showpage('store_partner_form','null_layout');
			die;
		}
		/**
		 * 判断操作类型
		 */
		if (chksubmit()){
			/**
			 * 验证表单信息
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["sp_title"],"require"=>"true","message"=>Language::get('store_partner_title_null')),
			array("input"=>$_POST["sp_link"],"require"=>"true","message"=>Language::get('store_partner_wrong_href')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}
			if (intval($_POST['sp_id']) > 0){
				/**
				 * 修改合作伙伴
				 */
				if (!$model_class->updatePartner($_POST)){
					showDialog(Language::get('nc_common_save_fail'));
				}
			}else {
				/**
				 * 保存合作伙伴
				 */
				if (!$model_class->addPartner($_POST)){
					showDialog(Language::get('nc_common_save_fail'));
				}
			}
			showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=store_partner','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
		}
		/**
		 * 删除合作伙伴
		 */
		if ($_GET['drop'] == 'single' && (intval($_GET['sp_id']))>0){
			/**
			 * 删除合作伙伴
			 */
			if($model_class->delPartner(intval($_GET['sp_id']))){
				showDialog(Language::get('nc_common_del_succ'),'index.php?act=store&op=store_partner','succ');
			}else {
				showDialog(Language::get('nc_common_del_fail'));
			}
		}elseif ($_GET['drop'] == 'all' && !empty($_GET['sp_id'])){
			/**
			 * 批量删除合作伙伴
			 */
			$sp_array = explode(',',$_GET['sp_id']);
			if (!empty($sp_array) && is_array($sp_array)){
				foreach ($sp_array as $key=>$value){
					$value = intval($value);
					/**
					 * 删除合作伙伴
					 */
					if (!$model_class->delPartner($value)){
						showDialog(Language::get('store_partner_del_fail'));
					}
				}
				showDialog(Language::get('nc_common_del_succ'),'index.php?act=store&op=store_partner','succ');
			}
		}
		/**
		 * 显示合作伙伴列表
		 */
		$condition['sp_store_id'] = $_SESSION['store_id'];
		$partner_list = $model_class->getPartnerList($condition);

		Tpl::output('partner_list',$partner_list);

		self::profile_menu('store_partner','store_partner');
		Tpl::output('menu_sign','store_partner');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_partner');
		Tpl::output('menu_sign1','partner_list');
		Tpl::showpage('store_partner_list');
	}
	/**
	 * 卖家认证设置
	 *
	 * @param string	
	 * @param string 	
	 * @return 
	 */
	public function store_certifiedOp(){
		//读取语言包
		Language::read('member_store_cert');
		/**
		 * 实例化模型
		 */
		$model_class = Model('store');
		/**
		 * 获取店铺信息
		 */
		$store_info = $model_class->shopStore(array('store_id'=>$_SESSION['store_id']));
		if (!empty($_FILES) && is_array($_FILES)){
			//上传认证文件
			if($_FILES['cert_autonym']['name'] != '' || $_FILES['cert_material']['name'] != '') {
				$shop_array = array(
					'store_id'=>$_SESSION['store_id']
				);
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_AUTH);
				if($_FILES['cert_autonym']['name'] != '') {
					$result = $upload->upfile('cert_autonym');
					if ($result){
						$shop_array['name_auth'] = '2';
						$shop_array['store_image'] = $upload->file_name;
						//删除旧认证图片
						if (!empty($shop_array['store_image']) && !empty($store_info['store_image'])){
							@unlink(BasePath.DS.ATTACH_AUTH.DS.$store_info['store_image']);
						}
					}else {
						showDialog($upload->error);
					}
				}
				if($_FILES['cert_material']['name'] != '') {
					$upload->set('file_name','');
					$result1 = $upload->upfile('cert_material');
					if ($result1){
						$shop_array['store_auth'] = '2';
						$shop_array['store_image1'] = $upload->file_name;
						//删除旧认证图片
						if (!empty($shop_array['store_image1']) && !empty($store_info['store_image1'])){
							@unlink(BasePath.DS.ATTACH_AUTH.DS.$store_info['store_image1']);
						}
					}else {
						showDialog($upload->error);
					}
				}
				$rs = $model_class->storeUpdate($shop_array);
				if ($rs){
					showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=store_certified','succ');
				}else {
					showDialog(Language::get('nc_common_save_fail'));
				}
			}else {
				showDialog(Language::get('member_store_cert_sel_file'));
			}
		}
		Tpl::output('store_info',$store_info);
		
		self::profile_menu('store_setting','store_certified');
		Tpl::output('menu_sign','store_setting');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_setting');
		Tpl::output('menu_sign1','store_cert');
		/**
		 * 页面输出
		 */
		Tpl::showpage('store_certified_form');
	}
	/**
	 * 店铺打印设置
	 */
	public function store_printsetupOp(){
		$model = Model();
		$store_info = $model->table('store')->where(array('store_id'=>$_SESSION['store_id']))->find();
		if(empty($store_info)){
			showDialog(Language::get('store_storeinfo_error'),'index.php?act=store','error');
		}
		if(chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST['store_printdesc'], "require"=>"true","validator"=>"Length","min"=>1,"max"=>200,"message"=>Language::get('store_printsetup_desc_error'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showDialog($error);
			}
			$update_arr = array();
			//上传认证文件
			if($_FILES['store_stamp']['name'] != '') {
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_STORE);
				if($_FILES['store_stamp']['name'] != '') {
					$result = $upload->upfile('store_stamp');
					if ($result){
						$update_arr['store_stamp'] = $upload->file_name;
						//删除旧认证图片
						if (!empty($store_info['store_stamp'])){
							@unlink(BasePath.DS.ATTACH_STORE.DS.$store_info['store_stamp']);
						}
					}
				}
			}
			$update_arr['store_printdesc'] = $_POST['store_printdesc'];
			$rs = $model->table('store')->where(array('store_id'=>$_SESSION['store_id']))->update($update_arr);
			if ($rs){
				showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=store_printsetup','succ');
			}else {
				showDialog(Language::get('nc_common_save_fail'),'index.php?act=store&op=store_printsetup','error');
			}
		}else{
			Tpl::output('store_info',$store_info);
			self::profile_menu('store_setting','store_printsetup');
			Tpl::output('menu_sign','store_setting');
			Tpl::output('menu_sign_url','index.php?act=store&op=store_setting');
			Tpl::output('menu_sign1','store_printsetup');
			Tpl::showpage('store_printsetup');
		}
	}
	/**
	 * 卖家店铺设置
	 *
	 * @param string	
	 * @param string 	
	 * @return 
	 */
	public function store_settingOp(){
		/**
		 * 实例化模型
		 */
		$model_class = Model('store');
		/**
		 * 获取设置
		 */
		$setting_config = $GLOBALS['setting_config'];
		$store_id = $_SESSION['store_id'];//当前店铺ID
		/**
		 * 获取店铺信息
		 */
		$store_info = $model_class->shopStore(array('store_id'=> $store_id));
		$subdomain_edit = intval($setting_config['subdomain_edit']);//二级域名是否可修改
		$subdomain_times = intval($setting_config['subdomain_times']);//系统设置二级域名可修改次数
		$store_domain_times = intval($store_info['store_domain_times']);//店铺已修改次数
		$subdomain_length = explode('-',$setting_config['subdomain_length']);
		$subdomain_length[0] = intval($subdomain_length[0]);
		$subdomain_length[1] = intval($subdomain_length[1]);
		if ($subdomain_length[0] < 1 || $subdomain_length[0] >= $subdomain_length[1]){//域名长度
			$subdomain_length[0] = 3;
			$subdomain_length[1] = 12;
		}
		Tpl::output('subdomain_length',$subdomain_length);
		/**
		 * 保存店铺设置
		 */
		if (chksubmit()){
			/**
			 * 验证表单信息
			 */
		    //判断是否有重名店铺
			$_GET['store_name'] = $_POST["store_name"];
			if(!$this->checknameinner()){
				showDialog(Language::get('store_create_store_name_exists'));
			}
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["store_name"], "require"=>"true",	"message"=>Language::get('store_setting_name_null')),
			array("input"=>$_POST["area_id"],	 "require"=>"true",	"message"=>Language::get('store_save_area_null'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}
			$_POST['store_domain'] = trim($_POST['store_domain']);
			$store_domain = strtolower($_POST['store_domain']);
			//判断是否设置二级域名
			if (!empty($store_domain) && $store_domain != $store_info['store_domain']){
				$store_domain_count = strlen($store_domain);
				if ($store_domain_count < $subdomain_length[0] || $store_domain_count > $subdomain_length[1]){
					showMessage(Language::get('store_setting_wrong_uri').': '.$setting_config['subdomain_length'],'','html','error');
				}
				if (!preg_match('/^[\w-]+$/i',$store_domain)){//判断域名是否正确
					showDialog(Language::get('store_setting_lack_uri'));
				}
				$store = $model_class->shopStore(array(
					'store_domain'=>$store_domain
				));
				//二级域名存在,则提示错误
				if (!empty($store) && ($store_id != $store['store_id'])){
					showMessage(Language::get('store_setting_exists_uri'),'','html','error');
				}
				//判断二级域名是否为系统禁止
				$subdomain_reserved = @explode(',',$setting_config['subdomain_reserved']);
				if(!empty($subdomain_reserved) && is_array($subdomain_reserved)){
						if (in_array($store_domain,$subdomain_reserved)){
							showDialog(Language::get('store_setting_invalid_uri'));
						}
				}
				if($subdomain_times > $store_domain_times){//可继续修改
					$param = array();
					$param['store_domain'] = $store_domain;
					if (!empty($store_info['store_domain'])) $param['store_domain_times'] = $store_domain_times+1;//第一次保存不计数
					$param['store_id'] = $store_id;
					$model_class->storeUpdate($param);
				}
				$_POST['store_domain'] = '';//避免重复更新
			}
			$_POST['store_id'] = $store_id;

			/**
			 * 处理上传图片
			 */
			$upload = new UploadFile();
			/**
			 * 上传店标
			 */
			if (!empty($_FILES['store_logo']['name'])){
				$upload->set('default_dir',	ATTACH_STORE);
				$upload->set('thumb_width',	100);
				$upload->set('thumb_height',100);
				$upload->set('thumb_ext',	'_small');
				$upload->set('ifremove',true);
				$result = $upload->upfile('store_logo');
				if ($result){
					$_POST['store_logo'] = $upload->thumb_image;
				}else {
					showDialog($upload->error);
				}
			}
			/**
			 * 删除旧店标
			 */
			if (!empty($_POST['store_logo']) && !empty($_POST['store_old_logo'])){
				@unlink(BasePath.DS.ATTACH_STORE.DS.$_POST['store_old_logo']);
			}
			/**
			 * 上传店铺图片
			 */
			if (!empty($_FILES['store_banner']['name'])){
				$upload->set('default_dir',	ATTACH_STORE);
				$upload->set('thumb_ext',	'');
				$upload->set('file_name','');
				$upload->set('ifremove',false);
				$result = $upload->upfile('store_banner');
				if ($result){
					$_POST['store_banner'] = $upload->file_name;
				}else {
					showDialog($upload->error);
				}
			}
			/**
			 * 删除旧店铺图片
			 */
			if (!empty($_POST['store_banner']) && !empty($_POST['store_old_banner'])){
				@unlink(BasePath.DS.ATTACH_STORE.DS.$_POST['store_old_banner']);
			}

			/**
			 * 上传店铺图片
			 */
			if (!empty($_FILES['store_label']['name'])){
				$upload->set('default_dir',	ATTACH_STORE);
				$upload->set('thumb_ext',	'');
				$upload->set('file_name','');
				$upload->set('ifremove',false);
				$result = $upload->upfile('store_label');
				if ($result){
					$_POST['store_label'] = $upload->file_name;
				}else {
					showDialog($upload->error);
				}
			}
			/**
			 * 删除旧店铺图片
			 */
			if (!empty($_POST['store_label']) && !empty($_POST['store_old_label'])){
				@unlink(BasePath.DS.ATTACH_STORE.DS.$_POST['store_old_label']);
			}
			
			/**
			 * 更新入库
			 */
			$_POST['description'] = $_POST['store_description'];
			$model_class->setStore($_POST);
			showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=store_setting','succ');
		}
		/**
		 * 实例化店铺等级模型
		 */			
		$model_store_grade	= Model('store_grade');
		$store_grade		= $model_store_grade->getOneGrade($store_info['grade_id']);
		//编辑器多媒体功能
		$editor_multimedia = false;
		$sg_fun = @explode('|',$store_grade['sg_function']);
		if(!empty($sg_fun) && is_array($sg_fun)){
			foreach($sg_fun as $fun){
				if ($fun == 'editor_multimedia'){
					$editor_multimedia = true;
				}
			}
		}
		Tpl::output('editor_multimedia',$editor_multimedia);
		if($subdomain_edit == 1 && ($subdomain_times > $store_domain_times)){//可继续修改二级域名
			Tpl::output('subdomain_edit',$subdomain_edit);
		}
		/**
		 * 查询店铺等级申请信息
		 */
		$model_store_gradelog = Model('store_gradelog');
		$gradelog = $model_store_gradelog->getLogInfo(array('gl_shopid'=>$store_id,'gl_allowstate'=>'0','order'=>' gl_id desc '));
		Tpl::output('gradelog',$gradelog);
		/**
		 * 输出店铺信息
		 */
		self::profile_menu('store_setting','store_setting');
		Tpl::output('store_info',$store_info);
		Tpl::output('store_grade',$store_grade);
		Tpl::output('subdomain',$setting_config['enabled_subdomain']);
		Tpl::output('subdomain_times',$setting_config['subdomain_times']);
		Tpl::output('menu_sign','store_setting');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_setting');
		Tpl::output('menu_sign1','store_setting');
		/**
		 * 页面输出
		 */
		Tpl::showpage('store_setting_form');
	}
	/**
	 * 店铺幻灯片
	 */
	public function store_slideOp() {
		/**
		 * 模型实例化
		 */
		$model_store = Model('store');
		$model_upload = Model('upload');
		/**
		 * 保存店铺信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			// 更新店铺信息
			$update	= array();
			$update['store_slide']		= implode(',', $_POST['image_path']);
			$update['store_slide_url']	= implode(',', $_POST['image_url']);
			$update['store_id']			= $_SESSION['store_id'];
			$model_store->storeUpdate($update);
			
			// 删除upload表中数据
			$model_upload->delByWhere(array('upload_type'=>7,'store_id'=>$_SESSION['store_id']));
			showDialog(Language::get('nc_common_save_succ'),'index.php?act=store&op=store_slide','succ');
		}

		// 删除upload中的无用数据
		$upload_info = $model_upload->getUploadList(array('upload_type'=>7,'store_id'=>$_SESSION['store_id']),'file_name');
		if(is_array($upload_info) && !empty($upload_info)){
			foreach ($upload_info as $val){
				@unlink(ATTACH_SLIDE.DS.$val['file_name']);
			}
		}
		$model_upload->delByWhere(array('upload_type'=>7,'store_id'=>$_SESSION['store_id']));
		
		$store_info = $model_store->getOne($_SESSION['store_id']);
		if($store_info['store_slide'] != '' && $store_info['store_slide'] != ',,,,'){
			Tpl::output('store_slide', explode(',', $store_info['store_slide']));
			Tpl::output('store_slide_url', explode(',', $store_info['store_slide_url']));
		}
		self::profile_menu('store_setting','store_slide');
		Tpl::output('menu_sign','store_setting');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_setting');
		Tpl::output('menu_sign1','store_slide');
		/**
		 * 页面输出
		 */
		Tpl::showpage('store_slide_form');
	}
	/**
	 * 店铺幻灯片ajax上传
	 */
	public function silde_image_uploadOp(){
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_SLIDE.DS.$upload->getSysSetPath());
		$upload->set('max_size',C('image_max_filesize'));
		
		$result = $upload->upfile($_POST['id']);
		
		
		$output	= array();
		if(!$result){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$upload->error = Language::getUTF8($upload->error);
			}
			$output['error']	= $upload->error;
			echo json_encode($output);die;
		}
		
		$img_path = $upload->getSysSetPath().$upload->file_name;
		
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		
		if(intval($_POST['file_id']) > 0){
			$file_info = $model_upload->getOneUpload($_POST['file_id']);
			@unlink(ATTACH_SLIDE.DS.$file_info['file_name']);
			
			$update_array	= array();
			$update_array['upload_id']	= intval($_POST['file_id']);
			$update_array['file_name']	= $img_path;
			$update_array['file_size']	= $_FILES[$_POST['id']]['size'];
			$model_upload->update($update_array);
			
			$output['file_id']	= intval($_POST['file_id']);
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
		}else{
			/**
			 * 图片数据入库
			 */
			$insert_array = array();
			$insert_array['file_name']		= $img_path;
			$insert_array['upload_type']	= '7';
			$insert_array['file_size']		= $_FILES[$_POST['id']]['size'];
			$insert_array['store_id']		= $_SESSION['store_id'];
			$insert_array['upload_time']	= time();
			
			$result = $model_upload->add($insert_array);
			
			if(!$result){
				@unlink(ATTACH_SLIDE.DS.$img_path);
				$output['error']	= Language::get('store_slide_upload_fail','UTF-8');
				echo json_encode($output);die;
			}
			
			$output['file_id']	= $result;
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
		}
	}
	/**
	 * ajax删除幻灯片图片
	 */
	public function dorp_imgOp(){
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$file_info = $model_upload->getOneUpload(intval($_GET['file_id']));
		if(!$file_info){
			@unlink(ATTACH_SLIDE.DS.$_GET['img_src']);
		}else{
			@unlink(ATTACH_SLIDE.DS.$file_info['file_name']);
			$model_upload->del(intval($_GET['file_id']));
		}
		echo json_encode(array('succeed'=>Language::get('nc_common_save_succ','UTF-8')));die;
	}
	/**
	 * 卖家店铺主题设置
	 *
	 * @param string	
	 * @param string 	
	 * @return 
	 */
	public function themeOp(){
		/**
		 * 店铺信息
		 */
		$store_class = Model('store');
		$store_info = $store_class->shopStore(array(
		'store_id'=>$_SESSION['store_id']
		));
		/**
		 * 主题配置信息
		 */
		$style_data = array();
		$style_configurl = BASE_TPL_PATH.DS.'store'.DS.'style'.DS."styleconfig.php";
		if (file_exists($style_configurl)){
			include_once($style_configurl);
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$style_data = Language::getGBK($style_data);
		}
		/**
		 * 当前店铺主题
		 */
		$curr_store_theme = !empty($store_info['store_theme'])?$store_info['store_theme']:'default';
		/**
		 * 当前店铺预览图片
		 */
		$curr_image = TEMPLATES_PATH.'/store/style/'.$curr_store_theme.'/images/preview.jpg';
		$curr_theme = array(
		'curr_name'=>$curr_store_theme,
		'curr_truename'=>$style_data[$curr_store_theme]['truename'],
		'curr_image'=>$curr_image
		);
		$theme_model = Model('store_theme');
		$state = $theme_model->getShowStyle($curr_store_theme);//是否可编辑
		Tpl::output('style_state',$state);
		/**
		 * 店铺等级
		 */
		$grade_class = Model('store_grade');
		$grade = $grade_class->getOneGrade($store_info['grade_id']);
		/**
		 * 可用主题
		 */
		$themes = explode('|',$grade['sg_template']);
		/**
		 * 可用主题预览图片
		 */
		foreach ($style_data as $key => $val){
			if (in_array($key,$themes)){
				$theme_list[$key] = array(
				'name'=>$key,
				'truename'=>$val['truename'],
				'image'=>TEMPLATES_PATH.'/store/style/'.$key.'/images/preview.jpg'
				);
			}
		}
		/**
		 * 页面输出
		 */
		self::profile_menu('store_theme','store_theme');
		Tpl::output('menu_sign','store_theme');
		Tpl::output('store_info',$store_info);
		Tpl::output('curr_theme',$curr_theme);
		Tpl::output('theme_list',$theme_list);
		Tpl::output('menu_sign_url','index.php?act=store&op=theme');
		Tpl::output('menu_sign1','valid_theme');
		Tpl::showpage('store_theme');
	}
	/**
	 * 卖家店铺主题设置
	 *
	 * @param string	
	 * @param string 	
	 * @return 
	 */
	public function set_themeOp(){
		//读取语言包
		$lang	= Language::getLangContent();
		$style = isset($_GET['style_name']) ? trim($_GET['style_name']) : null;

		if (!empty($style) && file_exists(BASE_TPL_PATH.DS.'/store/style/'.$style.'/images/preview.jpg')){
			$store_class = Model('store');
			$rs = $store_class->storeUpdate(array('store_id'=>$_SESSION['store_id'],'store_theme'=>$style));
			showDialog($lang['store_theme_congfig_success'],'reload','succ');
		}else{
			showDialog($lang['store_theme_congfig_fail'],'','succ');
		}
	}
	/**
	 * 优惠券管理
	 *
	 * @param 
	 * @return 
	 */
	public function store_couponOp() {		
		$model_coupon = Model('coupon') ;
		/**
		 * 判断操作页面
		 */
		if (!empty($_GET['type'])){
			/*
			 * 取得优惠券分类
			 */
			$model_coupon_class = Model('coupon_class') ;
			$condition = array();
			$condition['class_show'] = '1';
			$condition['order'] = 'class_sort desc,class_id desc';
			$class_list = $model_coupon_class->getCouponClass($condition) ;
			if(empty($class_list)){
				Tpl::output('msg',Language::get('store_coupon_null_class')) ;
				Tpl::showpage('../msg','null_layout') ;
				exit ;
			}
			/**
			 * 新增/编辑页面
			 */
			
			if(trim($_GET['type']=='edit')){
			    $param = array() ;
			    $coupon_array = array() ;
                
                $coupon_id = intval($_GET['coupon_id']);

                //检查优惠券是否属于该店铺
                if(!$model_coupon->checkCouponBelongStore($coupon_id,$_SESSION['store_id'])) {
                    showMessage(Language::get('store_coupon_error'),'','','error');
                }


				$param['coupon_id'] = $coupon_id ;
				$coupon_array = $model_coupon->getCoupon($param) ;	
				$coupon_array = $coupon_array[0] ;
				$old_pic = $coupon_array['coupon_pic'] ;
				if($coupon_array['coupon_lock']=='2'){
					Tpl::output('turnoff', yes) ;
				}
				$coupon_array['coupon_pic'] = $coupon_array['coupon_pic'] != '' ? $coupon_array['coupon_pic'] : SiteUrl.DS.ATTACH_COUPON.DS.'default.gif' ; 
				$coupon_array['coupon_desc'] = htmlspecialchars_decode($coupon_array['coupon_desc']) ;
				$coupon_array['coupon_start_date'] = date('Y-m-d',$coupon_array['coupon_start_date']) ;
				$coupon_array['coupon_end_date'] = date('Y-m-d',$coupon_array['coupon_end_date']) ;
				Tpl::output('coupon',$coupon_array) ;
				Tpl::output('old_pic',$old_pic) ;
			}
			
			Tpl::output('coupon_class', $class_list) ;
			Tpl::output('type',$_GET['type']);
			Tpl::showpage('member_coupon.form','null_layout');
			die;
		}
		/**
		 * 验证提交
		 */
		
		if (chksubmit()){

			if($_POST['type']!=''){
				$validate = new Validate();
				$validate->validateparam=array(
					array('input'=>trim($_POST['coupon_name']),'require'=>true,'message'=>Language::get('store_coupon_name_null')),
					array('input'=>trim($_POST['coupon_value']),'require'=>true, 'validator'=>'Currency','message'=>Language::get('store_coupon_price_error')),
					array('input'=>$_POST['start_time'],'require'=>true, 'message'=>Language::get('store_coupon_start_time_null')),
					array('input'=>$_POST['end_time'],'require'=>true, 'message'=>Language::get('store_coupon_end_time_null'))				
				) ;
				$error = $validate->validate() ;
				if($error){
					showValidateError($error);
				}
				switch ($_POST['type']) {				
					case 'edit':
						$flag=false ;
						$filename = '' ;
						$update = array() ;
						$update['coupon_title'] = trim($_POST['coupon_name']) ;
						$update['coupon_price'] = trim($_POST['coupon_value']) ;
						$update['coupon_desc'] = htmlspecialchars(trim($_POST['coupon_desc'])) ;
						$update['coupon_pic'] = trim($_POST['coupon_pic']);
						$date = explode('-', $_POST['start_time']) ;				
						$update['coupon_start_date'] = mktime(0,0,0,$date[1],$date[2],$date[0]) ;
						unset($date);
						$date = explode('-', $_POST['end_time']) ;
						$update['coupon_end_date'] = mktime(0,0,0,$date[1],$date[2],$date[0]) ;
						unset($date) ;
						$update['coupon_allowstate'] = '0';//编辑信息后需要后台审核
						$update['coupon_class_id'] = $_POST['coupon_class'] ;
						$where['coupon_id'] = trim($_POST['coupon_id']) ;
						$where['store_id'] = $_SESSION['store_id'] ;
						if($model_coupon->update_coupon($update,$where)){
							showDialog(Language::get('store_coupon_update_success'),'index.php?act=store&op=store_coupon','succ','CUR_DIALOG.close();');
						}else{
							showDialog(Language::get('store_coupon_update_fail'));
						}
						break ;
					case 'add':
						$update = array() ;
						$update['coupon_title'] = trim($_POST['coupon_name']) ;
						$update['coupon_price'] = trim($_POST['coupon_value']) ;
						$update['coupon_desc'] = htmlspecialchars(trim($_POST['coupon_desc'])) ;
						$update['coupon_pic'] = trim($_POST['coupon_pic']);
						$date = explode('-', $_POST['start_time']) ;				
						$update['coupon_start_date'] = mktime(0,0,0,$date[1],$date[2],$date[0]) ;
						unset($date);
						$date = explode('-', $_POST['end_time']) ;
						$update['coupon_end_date'] = mktime(0,0,0,$date[1],$date[2],$date[0]) ;
						unset($date) ;
						$update['coupon_allowstate'] = '0';//需要后台审核 0为待审核 1通过 2未通过
						$update['coupon_state'] = '2';//默认是上架状态,1是下架
						$update['store_id'] = $_SESSION['store_id'] ;
						$update['coupon_class_id'] = $_POST['coupon_class'] ;
						$update['coupon_add_date'] = time() ;
						if($model_coupon->add_coupon($update)){
							showDialog(Language::get('store_coupon_add_success'),'index.php?act=store&op=store_coupon','succ','CUR_DIALOG.close();');
						}else{
							showDialog(Language::get('store_coupon_add_fail'));
						}
						break ;			
				
				}
					
			}
			
		}
	
		if(trim($_GET['coupon_id']!='')){
					 
			$update = array() ;
			$id_array = explode(',',trim($_GET['coupon_id']));
			$coupon_id = "'".implode("','",$id_array)."'";
			$update['coupon_id_in'] = trim($coupon_id) ;
			$update['store_id'] = $_SESSION['store_id'] ;
			$update['coupon_allowstate2'] = '1' ;//只有待审核和未通过的可删除
			if($model_coupon->del_coupon($update)){
				showDialog(Language::get('store_coupon_del_success'),'index.php?act=store&op=store_coupon','succ');
				exit;
			}else{
				showDialog(Language::get('store_coupon_del_fail'),'index.php?act=store&op=store_coupon');
				exit;
			}	
		}
		
		$page = new Page() ;
		$page->setEachNum(8);
		$page->setStyle('admin');
				
				$condition = array() ;

				$condition = array() ;
				if(trim($_GET['key'])!=''&&trim($_GET['key'])!=Language::get('store_coupon_name')){
				
					$condition['coupon_name_like'] = trim($_GET['key']) ;
				
				}
				if($_GET['add_time_from']!=''){
				
					$time = explode('-', $_GET['add_time_from']) ;
					$condition['time_from'] = mktime(0,0,0,$time[1],$time[2],$time[0]) ;
					
				}
				if($_GET['add_time_to']!=''){
					
					$time = explode('-', $_GET['add_time_to']) ;
					$condition['time_to'] = mktime(0,0,0,$time[1],$time[2],$time[0]) ;
				
				}
				if($_GET['add_time_to']!=''&&$_GET['add_time_from']!=''&&$condition['time_from']>$condition['time_to'] )
				{
					$_GET['add_time_from'] = $_GET['add_time_to'] = '' ;
					showMessage(Language::get('store_coupon_time_error'),'','html','error');
				}
				
		/*
		 * 读取店铺优惠券信息
		 */
		$condition['store_id'] = $_SESSION['store_id'] ;
		$coupon_list = $model_coupon->getCoupon($condition,$page) ;
		if(is_array($coupon_list) && !empty($coupon_list)){
		    $state = array('1'=>Language::get('nc_no'),'2'=>Language::get('nc_yes'));
		    $allowstate = array('0'=>Language::get('store_coupon_allow_state'),'1'=>Language::get('store_coupon_allow_yes'),'2'=>Language::get('store_coupon_allow_no'));
		    foreach($coupon_list as $k=>$v){
		           $coupon_list[$k]['pic'] = $v['coupon_pic'] ? $v['coupon_pic'] : SiteUrl.DS.ATTACH_COUPON.DS.'defatul.gif' ;
		           $coupon_list[$k]['state'] = $state[$v['coupon_state']] ;
		           $coupon_list[$k]['allowstate'] = $allowstate[$v['coupon_allowstate']] ;
		    }
		}
		$model_coupon->update_coupon(array('coupon_state'=>'1'),array('coupon_state'=>'2','coupon_novalid'=>true,'store_id'=>$_SESSION['store_id']));

		/**
		 * 页面输出
		 */
		self::profile_menu('store_coupon','store_coupon');
		Tpl::output('count',count($coupon_list)) ;
		Tpl::output('coupons',$coupon_list);
		Tpl::output('show_page',$page->show()) ;
		Tpl::output('menu_sign','store_coupon');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_coupon');
		Tpl::output('menu_sign1','coupon_list');
		Tpl::showpage('member_coupon.index');
	}
	/**
	 * 活动管理
	 */
	public function store_activityOp(){
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$activity	= Model('activity');
		//活动为商品活动，并且为开启状态
		$list	= $activity->getList(array('activity_type'=>'1','opening'=>true,'order'=>'activity.activity_sort asc'),$page);
		/**
		 * 页面输出
		 */
		Tpl::output('list',$list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('store_activity','store_activity');
		Tpl::output('menu_sign','store_activity');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_activity');
		Tpl::output('menu_sign1','activity_list');
		Tpl::showpage('store_activity.list');
	}
	/**
	 * 参与活动
	 */
	public function activity_applyOp(){
		//根据活动编号查询活动信息
		$activity_id = intval($_GET['activity_id']);
		if($activity_id <= 0){
			showMessage(Language::get('miss_argument'),'index.php?act=store&op=store_activity','html','error');
		}
		$activity_model	= Model('activity');
		$activity_info	= $activity_model->getOneById($activity_id);
		//活动类型必须是商品并且活动没有关闭并且活动进行中
		if(empty($activity_info) || $activity_info['activity_type'] != '1' || $activity_info['activity_state'] != 1 || $activity_info['activity_start_date']>time() || $activity_info['activity_end_date']<time()){
			showMessage(Language::get('store_activity_not_exists'),'index.php?act=store&op=store_activity','html','error');
		}
		Tpl::output('activity_info',$activity_info);
		$list	= array();//声明存放活动细节的数组
		//查询商品分类列表
		$gc	= Model('goods_class');
		$gc_list	= $gc->getTreeClassList(3,array('gc_show'=>1,'order'=>'gc_parent_id asc,gc_sort asc,gc_id asc'));
		foreach($gc_list as $k=>$gc){
			$gc_list[$k]['gc_name']	= '';
			$gc_list[$k]['gc_name']	= str_repeat("&nbsp;",$gc['deep']*2).$gc['gc_name'];
		}
		Tpl::output('gc_list',$gc_list);
		//查询品牌列表
		$brand	= Model('brand');
		$brand_list	= $brand->getBrandList(array());
		Tpl::output('brand_list',$brand_list);
		//查询活动细节信息
		$activity_detail_model	= Model('activity_detail');
		$list	= $activity_detail_model->getGoodsJoinList(array('activity_id'=>"$activity_id",'store_id'=>"{$_SESSION['store_id']}",'activity_detail_state_in'=>"'0','1','3'",'group'=>'activity_detail_state asc'));
		//构造通过与审核中商品的编号数组,以便在下方待选列表中,不显示这些内容
		$item_ids	= array();
		if(is_array($list) and !empty($list)){
			foreach($list as $k=>$v){
				$item_ids[]	= $v['item_id'];
			}
		}
		Tpl::output('list',$list);
		
		//根据查询条件查询商品列表
		$condition	= array();
		if($_GET['gc_id']!=''){
			$condition['gc_id']	= intval($_GET['gc_id']);
		}
		if($_GET['brand_id']!=''){
			$condition['brand_id']	= intval($_GET['brand_id']);
		}
		if(trim($_GET['name'])!=''){
			$condition['keyword']	= trim($_GET['name']);
		}
		$condition['store_id']		= $_SESSION['store_id'];
		$condition['goods_show']	= '1';
		$condition['goods_state']	= '0';
		$condition['goods_store_state']	= 'open';
		if (!empty($item_ids)){
			$condition['no_goods_id']	= implode(',',$item_ids);
		}
		$page	= new Page();
		$page->setEachNum(16);
		$page->setStyle('admin');
		$page->setNowPage(empty($_GET['curpage'])?1:intval($_GET['curpage']));
		$goods	= Model('goods');
		$goods_list	= $goods->getGoods($condition,$page,'*','brand');
		Tpl::output('goods_list',$goods_list);
		Tpl::output('show_page',$page->show());
		Tpl::output('search',$_GET);
		/**
		 * 页面输出
		 */
		self::profile_menu('activity_apply','activity_apply');
		Tpl::output('menu_sign','store_activity');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_activity');
		Tpl::output('menu_sign1','activity_apply');
		Tpl::showpage('store_activity.apply');
	}
	/**
	 * 常用操作
	 *
	 */
	public function quicklinkOp(){
		if (chksubmit()){
			$store	= Model('store');
			$store->storeUpdate(array('store_id'=>$_SESSION['store_id'],'store_center_quicklink'=>serialize($_POST['doc_content'])));
			showDialog(Language::get('nc_common_save_succ'),'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
		}
		Tpl::showpage('store_quicklink','null_layout');
	}
	/**
	 * 活动申请保存
	 */
	public function activity_apply_saveOp(){
		//判断页面参数
		if(empty($_POST['item_id'])){
			showDialog(Language::get('store_activity_choose_goods'),'index.php?act=store&op=store_activity');
		}
		$activity_id = intval($_POST['activity_id']);
		if($activity_id <= 0){
			showDialog(Language::get('miss_argument'),'index.php?act=store&op=store_activity');
		}
		//根据页面参数查询活动内容信息，如果不存在则添加，存在则根据状态进行修改
		$activity_model	= Model('activity');
		$activity	= $activity_model->getOneByid($activity_id);
		//活动类型必须是商品并且活动没有关闭并且活动进行中
		if(empty($activity) || $activity['activity_type'] != '1' || $activity['activity_state'] != '1' || $activity['activity_start_date']>time() || $activity['activity_end_date']<time()){
			showDialog(Language::get('store_activity_not_exists'),'index.php?act=store&op=store_activity');
		}
		$activity_detail	= Model('activity_detail');
		$list	= $activity_detail->getList(array('store_id'=>"{$_SESSION['store_id']}",'activity_id'=>"$activity_id"));
		$ids	= array();//已经存在的活动内容编号
		$ids_state2	= array();//已经存在的被拒绝的活动编号
		if(is_array($list) and !empty($list)){
			foreach ($list as $ad){
				$ids[]	= $ad['item_id'];
				if($ad['activity_detail_state']=='2'){
					$ids_state2[]	= $ad['item_id'];
				}	
			}
		}
		//根据查询条件查询商品列表
		$condition_goods	= array();
		$condition_goods['store_id']	= $_SESSION['store_id'];
		$condition_goods['goods_show']	= '1';
		$condition_goods['goods_state']	= '0';
		$condition_goods['goods_store_state']	= 'open';
		foreach ($_POST['item_id'] as $item_id){
			$item_id = intval($item_id);
			if(!in_array($item_id,$ids)){
				$condition_goods['goods_id'] = "$item_id";
				$input	= array();
				$input['activity_id']	= $activity_id;
				$goods	= Model('goods');
				$item	= $goods->getGoods($condition_goods,'','*','store');
				$item	= $item[0];
				if(empty($item)){
					continue;	
				}
				$input['item_name']	= $item['goods_name'];
				$input['item_id']	= $item_id;
				$input['store_id']	= $item['store_id'];
				$input['store_name']= $item['store_name'];
				$activity_detail->add($input);
			}elseif(in_array($item_id,$ids_state2)){
				$input	= array();
				$input['activity_detail_state']= '0';//将重新审核状态去除
				$activity_detail->updateList($input,array('item_id'=>$item_id));
			}
		}
		showDialog(Language::get('store_activity_submitted'),'reload','succ');
	}
	/**
	 * ajax修改指定商品分类的信息
	 *
	 */
	public function goods_class_ajaxOp(){
		$rzt['done']	= true;
		if(!isset($_GET['ajax']) and $_GET['column'] != 'stc_state'){
			showMessage(Language::get('invalid_request'),'','html','error');
		} elseif($_GET['id'] == ''){
			$rzt['done']	= false;
			$rzt['msg']	= Language::get('miss_argument');//"缺少参数：商品分类编号";
		} elseif($_GET['value']	== ''){
			$rzt['done']	= false;
			$rzt['msg']	= Language::get('miss_argument');//"缺少参数：修改后的值";
		} elseif($_GET['column'] == ''){
			$rzt['done']	= false;
			$rzt['msg']	= Language::get('miss_argument');//"缺少参数：待修改的数据名称";
		} else {
			switch($_GET['column']){
				case 'stc_name':
					break;
				case 'stc_sort':
					if(!preg_match("/^\d+$/",$_GET['value'])){
						$rzt['done']	= false;
						$rzt['msg']	= Language::get('wrong_argument');//"：必须是整数";
					}elseif($_GET['value'] < 0 or $_GET['value'] > 255){
						$rzt['done']	= false;
						$rzt['msg']	= Language::get('wrong_argument');//"：超出范围0~255";
					}
					break;
				case 'stc_state':
					if(!in_array($_GET['value'],array('0','1'))){
						$rzt['done']	= false;
						$rzt['msg']	= Language::get('invalid_request');
					}
					break;
				default:
					$rzt['done']	= false;
					$rzt['msg']	= Language::get('wrong_argument');//"参数错误：未知的数据名称";
			}
			if($rzt['done']){
				$input	= array();
				$input[$_GET['column']]	= $_GET['value'];
				$model_class	= Model('my_goods_class');
				$result	= $model_class->editGoodsClass($input,intval($_GET['id']));
				if($result){
					$class_info	= $model_class->getClassInfo(array('stc_id'=>intval($_GET['id'])));
					switch($_GET['column']){
						case 'stc_name':
							$rzt['retval']	= $class_info['stc_name'];
							break;
						case 'stc_sort':
							$rzt['retval']	= $class_info['stc_sort'];
							break;
					}
				}else{
					$rzt['done']	= false;
					$rzt['msg']	= Language::get('store_goods_class_ajax_update_fail');
				}
			}
		}
		echo json_encode($rzt);
	}
	/**
	 * 修改店铺二维码 ajax
	 */
	public function ajax_change_store_codeOp(){
		/**
		 * 实例化
		 */
		$store_model	= Model('store');
		
		// 删除原有二维码图片
		$store_info		= $store_model->getOne($_SESSION['store_id']);
		if($store_info['store_code'] != 'default_qrcode.png') @unlink(ATTACH_STORE.DS.$store_info['store_code']);
		
		// 生成新的二维码
		require_once(BasePath.DS.'resource'.DS.'phpqrcode'.DS.'index.php');
		$PhpQRCode	= new PhpQRCode();
	    if(C('enabled_subdomain')==1 && $store_info['store_domain'] != ''){
        	$PhpQRCode->set('date',ncUrl(array('act'=>'show_store','id'=>$_SESSION['store_id']), 'store', $store_info['store_domain']));
        }else{
        	$PhpQRCode->set('date',SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$_SESSION['store_id']), 'store', $store_info['store_domain']));
        }
		$PhpQRCode->set('pngTempDir',ATTACH_STORE.DS);
		$url = $PhpQRCode->init();
		$store_model->storeUpdate(array('store_code'=>$url,'store_id'=>$_SESSION['store_id']));
		
		echo json_encode($url);
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return 
	 */
	private function profile_menu($menu_type,$menu_key='') {
		Language::read('member_layout');
		$menu_array		= array();
		switch ($menu_type) {
			case 'store_goods_class':
				$menu_array = array(
				1=>array('menu_key'=>'store_goods_class','menu_name'=>Language::get('nc_member_path_goods_class'),	'menu_url'=>'index.php?act=store&op=store_goods_class'));
				break;
			case 'store_order':
				$menu_array = array(
				1=>array('menu_key'=>'store_order',			'menu_name'=>Language::get('nc_member_path_all_order'),	'menu_url'=>'index.php?act=store&op=store_order'),
				2=>array('menu_key'=>'order_pay',			'menu_name'=>Language::get('nc_member_path_wait_pay'),	'menu_url'=>'index.php?act=store&op=store_order&state_type=order_pay'),
				12=>array('menu_key'=>'pay_confirm',			'menu_name'=>Language::get('nc_member_path_pay_confirm'),	'menu_url'=>'index.php?act=store&op=store_order&state_type=pay_confirm'),
				3=>array('menu_key'=>'order_submit',		'menu_name'=>Language::get('nc_member_path_submitted'),	'menu_url'=>'index.php?act=store&op=store_order&state_type=order_submit'),
				4=>array('menu_key'=>'order_no_shipping',	'menu_name'=>Language::get('nc_member_path_wait_send'),	'menu_url'=>'index.php?act=store&op=store_order&state_type=order_no_shipping'),
				5=>array('menu_key'=>'order_shipping',		'menu_name'=>Language::get('nc_member_path_sent'),	'menu_url'=>'index.php?act=store&op=store_order&state_type=order_shipping'),
				6=>array('menu_key'=>'order_finish',		'menu_name'=>Language::get('nc_member_path_finished'),	'menu_url'=>'index.php?act=store&op=store_order&state_type=order_finish'),
				7=>array('menu_key'=>'order_cancel',		'menu_name'=>Language::get('nc_member_path_canceled'),	'menu_url'=>'index.php?act=store&op=store_order&state_type=order_cancel'),
				);
				break;
			case 'payment':
				$menu_array = array(
				1=>array('menu_key'=>'payment',		'menu_name'=>Language::get('nc_member_path_payment_list'),		'menu_url'=>'index.php?act=store&op=payment')
				);
				break;
			case 'store_navigation':
				$menu_array = array(
				1=>array('menu_key'=>'store_navigation','menu_name'=>Language::get('nc_member_path_nav_list'),'menu_url'=>'index.php?act=store&op=store_navigation'),
				2=>array('menu_key'=>'store_navigation_add','menu_name'=>Language::get('store_navigation_new'),'menu_url'=>'index.php?act=store&op=store_navigation_add&type=add')
				);
				break;
			case 'store_navigation_edit':
				$menu_array = array(
				1=>array('menu_key'=>'store_navigation','menu_name'=>Language::get('nc_member_path_nav_list'),'menu_url'=>'index.php?act=store&op=store_navigation'),
				2=>array('menu_key'=>'store_navigation_add','menu_name'=>Language::get('store_navigation_new'),'menu_url'=>'index.php?act=store&op=store_navigation_add&type=add'),
				3=>array('menu_key'=>'store_navigation_edit','menu_name'=>Language::get('store_navigation_edit'),'menu_url'=>'#')
				);
				break;
			case 'store_partner':
				$menu_array = array(
				1=>array('menu_key'=>'store_partner','menu_name'=>Language::get('nc_member_path_partner_list'),'menu_url'=>'index.php?act=store&op=store_partner')
				);
				break;
			case 'store_setting':
				$menu_array = array(
				1=>array('menu_key'=>'store_setting','menu_name'=>Language::get('nc_member_path_store_config'),'menu_url'=>'index.php?act=store&op=store_setting'),
				2=>array('menu_key'=>'store_callcenter','menu_name'=>Language::get('nc_member_path_store_callcenter'),'menu_url'=>'index.php?act=store_callcenter'),
				3=>array('menu_key'=>'store_certified','menu_name'=>Language::get('nc_member_path_store_cert'),'menu_url'=>'index.php?act=store&op=store_certified'),
				4=>array('menu_key'=>'store_map','menu_name'=>Language::get('nc_member_path_store_map'),'menu_url'=>'index.php?act=map'),
				5=>array('menu_key'=>'store_slide','menu_name'=>Language::get('nc_member_path_store_slide'),'menu_url'=>'index.php?act=store&op=store_slide'),
				6=>array('menu_key'=>'store_printsetup','menu_name'=>Language::get('nc_member_path_store_printsetup'),'menu_url'=>'index.php?act=store&op=store_printsetup')
				);
				break;
			case 'store_theme':
				$menu_array = array(
				1=>array('menu_key'=>'store_theme','menu_name'=>Language::get('nc_member_path_valid_theme'),'menu_url'=>'index.php?act=store&op=theme')
				);
				break;
			case 'store_coupon':
				$menu_array = array(
				1=>array('menu_key'=>'store_coupon','menu_name'=>Language::get('nc_member_path_coupon_list'),'menu_url'=>'index.php?act=store&op=store_coupon')
				);
				break;
			case 'store_activity':
				$menu_array = array(
				1=>array('menu_key'=>'store_activity','menu_name'=>Language::get('nc_member_path_activity_list'),'menu_url'=>'index.php?act=store&op=store_activity')
				);
				break;
			case 'activity_apply':
				$menu_array = array(
				1=>array('menu_key'=>'store_activity','menu_name'=>Language::get('nc_member_path_activity_list'),'menu_url'=>'index.php?act=store&op=store_activity'),
				2=>array('menu_key'=>'activity_apply','menu_name'=>Language::get('nc_member_path_join_activity'),'menu_url'=>'')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}