<?php
/**
 * 会员中心——账户概览
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

class memberControl extends BaseMemberControl{
	/**
	 * 会员地址
	 *
	 * @param
	 * @return
	 */
	public function addressOp() {
		/**
		 * 读取语言包
		 */
		Language::read('member_member_index');
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$address_class = Model('address');
		/**
		 * 判断页面类型
		 */
		if (!empty($_GET['type'])){
			/**
			 * 新增/编辑地址页面
			 */
			if (intval($_GET['id']) > 0){
				/**
				 * 得到地址信息
				 */
				$address_info = $address_class->getOneAddress(intval($_GET['id']));
				if (empty($address_info) && !is_array($address_info)){
					showMessage($lang['member_address_wrong_argument'],'index.php?act=member&op=address','html','error');
				}
				/**
				 * 输出地址信息
				 */
				Tpl::output('address_info',$address_info);
			}
			/**
			 * 增加/修改页面输出
			 */
			Tpl::output('type',$_GET['type']);
			Tpl::showpage('address_form','null_layout');
			exit();
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
				array("input"=>$_POST["true_name"],"require"=>"true","message"=>$lang['member_address_receiver_null']),
				array("input"=>$_POST["area_id"],"require"=>"true","validator"=>"Number","message"=>$lang['member_address_wrong_area']),
				array("input"=>$_POST["city_id"],"require"=>"true","validator"=>"Number","message"=>$lang['member_address_wrong_area']),
				array("input"=>$_POST["area_info"],"require"=>"true","message"=>$lang['member_address_area_null']),
				array("input"=>$_POST["address"],"require"=>"true","message"=>$lang['member_address_address_null']),
				array("input"=>$_POST['tel_phone'].$_POST['mob_phone'],'require'=>'true','message'=>$lang['member_address_phone_and_mobile'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}
			if (intval($_POST['id']) > 0){
				$rs = $address_class->updateAddress($_POST);
				if (!$rs){
					showDialog($lang['member_address_modify_fail'],'','error');
				}
			}else {
				$rs = $address_class->addAddress($_POST);
				if (!$rs){
					showDialog($lang['member_address_add_fail'],'','error');
				}
			}
			showDialog($lang['nc_common_op_succ'],'reload','succ','CUR_DIALOG.close()');
		}
		$del_id = isset($_GET['id']) ? intval(trim($_GET['id'])) : 0 ;
		if ($del_id > 0){
			$rs = $address_class->delAddress($del_id);
			if ($rs){
				showDialog(Language::get('member_address_del_succ'),'index.php?act=member&op=address','succ');
			}else {
				showDialog(Language::get('member_address_del_fail'),'','error');
			}
		}
		$address_list = $address_class->getAddressList(array('member_id'=>$_SESSION['member_id']));
		/**
		 * 页面输出
		 */
		self::profile_menu('address','address');
		Tpl::output('menu_sign','address');
		Tpl::output('address_list',$address_list);
		Tpl::output('menu_sign_url','index.php?act=member&op=address');
		Tpl::output('menu_sign1','address_list');
		Tpl::setLayout('member_pub_layout');
		Tpl::showpage('address_index');
	}
	/**
	 * 订单
	 *
	 * @param
	 * @return
	 */
	public function orderOp() {
		/**
		 * 读取语言包
		 */
		Language::read('member_member_index');
		$lang	= Language::getLangContent();
		/**
		 * 实例化订单模型
		 */
		$model_order = Model('order');
		/**
		 * 订单分页
		 */
		
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 实例化买家订单模型
		 */
		$model_my_order = Model('my_order');
		/*搜索条件*/
		$array	= array();
		$array['order_sn']		= trim($_GET['order_sn']);		
		$array['order_state']	= (in_array(trim($_GET['state_type']),array('order_pay','order_submit','order_pay_confirm','order_no_shipping','order_shipping','order_finish','order_cancal','order_refer','order_confirm')) ? trim($_GET['state_type']) : '');
		if($_GET['state_type'] == 'noeval'){
			$array['order_evalbuyer_able']		= '1';
		}
		
		$array['add_time_from'] = strtotime($_GET['add_time_from']);
        $array['add_time_to'] = strtotime($_GET['add_time_to']);
        if($array['add_time_to'] > 0) {
            $array['add_time_to'] +=86400;
        }
		$order_list		= $model_my_order->myOrderList($array,$page,'order_id,store_id');
		/**
		 * 订单下的商品
		 */
		if(is_array($order_list) && !empty($order_list)) {
			$order_id_array = array();
			$store_id_array = array();
			$store_array = array();//店铺信息
			$refund_array = array();//退款信息
			$return_array = array();//退货信息
			$model_store = Model('store');
			foreach ($order_list as $v) {
				$order_id_array[] = $v['order_id'];
				if(!in_array($v['store_id'],$store_id_array)) $store_id_array[] = $v['store_id'];
			}
			$order_list		= array();
			$order_list		= $model_my_order->myOrderGoodsList(array('order_id_string'=>"'".implode("','",$order_id_array)."'"));
			$store_list = $model_store->getStoreList(array('store_id_in'=>"'".implode("','",$store_id_array)."'"));//获得订单店铺信息
			if (is_array($store_list) && !empty($store_list)){
				foreach ($store_list as $val) {
					$store_array[$val['store_id']] = $val;
				}
			}
			/**
			 * 实例化退款模型
			 */
			$model_refund	= Model('refund');
			$condition = array();
			$condition['buyer_id'] = $_SESSION['member_id'];
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
			$condition['buyer_id'] = $_SESSION['member_id'];
			$condition['order_ids'] = "'".implode("','",$order_id_array)."'";
			$condition['return_type'] = '1';
			$return_list= $model_return->getList($condition);
			if (is_array($return_list) && !empty($return_list)){
				foreach ($return_list as $val) {
					$return_array[$val['order_id']] = $val;
				}
			}
			
			$order_array	= array();
			if(is_array($order_list) && !empty($order_list)) {
				$store_id	= 0;
				$store = array();
				foreach ($order_list as $val) {
					$order_id = $val['order_id'];
					if(is_array($refund_array[$order_id]) && !empty($refund_array[$order_id])) $val['refund'] = $refund_array[$order_id];
					if(is_array($return_array[$order_id]) && !empty($return_array[$order_id])) $val['return'] = $return_array[$order_id];
					$val['spec_info_arr'] = '';
					if (!empty($val['spec_info'])){
						$val['spec_info_arr']	= unserialize($val['spec_info']);
					}
					$val['state_info']		= orderStateInfo($val['order_state'],$val['refund_state']);
					$store_id	= $val['store_id'];
					$store = $store_array[$store_id];
					/**
					 * 获得联系方式
					 */
					$val['member_id'] = $store['member_id'];
					$val['member_name'] = $store['member_name'];
					$val['store_qq'] = $store['store_qq'];
					$val['store_ww'] = $store['store_ww'];
					unset($store);
					//1.交易成功超过十五天双方都未评价时评价关闭2.一方评价后超过十五天评价结束
					if ($val['evaluation_status'] == 1){//买家已经评价
						$val['able_evaluate'] = false;
					}else {
						$val['able_evaluate'] = true;
					}
					if ($val['able_evaluate'] && $val['evalseller_status'] == 0 && (intval($val['finnshed_time'])+60*60*24*15)<time()){
						$val['able_evaluate'] = false;
					}elseif ($val['able_evaluate'] && $val['evalseller_status'] == 1 && (intval($val['evalseller_time'])+60*60*24*15)<time()) {
						$val['able_evaluate'] = false;
					}
					$order_array[$val['order_id']][] = $val;
				}
			}
		}
		Tpl::output('order_array',$order_array);
		Tpl::output('show_page',$page->show());
        //输出投诉失效变量
        Tpl::output('complain_time_limit',$GLOBALS['setting_config']['complain_time_limit']);
		
		//查询会员信息
		$this->get_member_info();
		self::profile_menu('member_order','member_order');
		Tpl::output('menu_sign','myorder');
		Tpl::output('menu_sign_url','index.php?act=member&op=order');
		Tpl::output('menu_sign1','myorder_list');
		Tpl::showpage('member_order');
	}
	/**
	 * 买家订单状态操作
	 *
	 */
	public function change_stateOp() {
		//读取语言包
		Language::read('member_member_index');
		$lang	= Language::getLangContent();
		$state_type	= trim($_GET['state_type']);
		$order_id	= intval($_GET['order_id']);
		//if($state_type == '') return ;
		if($state_type == '' || $order_id<=0) showMessage($lang['member_change_parameter_error'],'index.php?act=member&op=order','html','error');
		//实例化订单模型
		$model_order = Model('order');
		//获取订单详细
		$order	= $model_order->getOrderById($order_id,'simple');
		if (!is_array($order) || empty($order)){
			showDialog($lang['member_change_orderrecord_error'],'index.php?act=member&op=order');
		}
		//验证订单信息是否属于该会员
		if ($_SESSION['member_id'] != $order['buyer_id']){
			showDialog($lang['member_change_order_member_error'],'index.php?act=member&op=order');	
		}
		$array	= array();
		switch ($state_type) {
			case 'cancel_order':	//买家取消订单
			$temp_file	= 'member_order_cancel';
			$state_code = 0;
			break;
			case 'confirm_order':	//买家确定订单
			$temp_file	= 'member_order_confirm';
			$array['finnshed_time'] = time();
			$state_code = 40;
			break;
		}
		//验证订单信息状态是否与更改状态相同
		if (intval($order['order_state']) ==  $state_code){
			showDialog($lang['member_change_changed_error'],'index.php?act=member&op=order');
		}
		if(chksubmit()) {
			$array['order_state'] = $state_code;
            //实例化订单模型
            $model_my_order = Model('my_order');
            $goods_list = $model_my_order->myOrderGoodsList(array('order_id'=>$order_id));
            //取消订单
			if($state_code == 0) {
				$model_goods= Model('goods');
				if(is_array($goods_list) and !empty($goods_list)) {
					foreach ($goods_list as $val) {
						$model_goods->updateSpecStorageGoods(array('spec_goods_storage'=>array('value'=>$val['goods_num'],'sign'=>'increase'),'spec_salenum'=>array('value'=>$val['goods_num'],'sign'=>'decrease')),$val['spec_id']);
						$model_goods->updateGoods(array('salenum'=>array('value'=>$val['goods_num'],'sign'=>'decrease')),$val['goods_id']);
					}
				}
			}
			//会员model实例
			$model_member	= Model('member');
			//卖家信息
			$seller	= $model_member->infoMember(array('member_id'=>$order['seller_id']));
			//确认收货
			if ($state_code == 40){
                //更新卖家销量
                $goods_count = 0;
                foreach($goods_list as $value) {
                    $goods_count += $value['goods_num'];
                }
                $model_store = Model('store');
                $update_array = array();
                $update_array['store_sales'] = array('sign'=>'increase','value'=>$goods_count);
                $update_array['store_id'] = $order['store_id']; 
                $model_store->storeUpdate($update_array);

                if (($order['payment_code'] == 'predeposit')){
					//查询买家信息
					$model_member = Model('member');
					$buyer_info = $model_member->infoMember(array('member_id'=>$_SESSION['member_id']));
					if (!is_array($buyer_info) || count($buyer_info)<=0){
						showDialog($lang['member_change_order_member_error'],'index.php?act=member&op=order');
					}
					if (floatval($order['order_amount']) > floatval($buyer_info['freeze_predeposit'])){
						showDialog($lang['member_change_freezepredeposit_short_error'],'index.php?act=member&op=order','error','','3');
					}
					//调整预存款
					$predeposit_model = Model('predeposit');
					//卖家增加可用金额
					$log_arr = array();
					$log_arr['memberid'] = $seller['member_id'];
					$log_arr['membername'] = $seller['member_name'];
					$log_arr['logtype'] = '0';
					$log_arr['price'] = $order['order_amount'];
					$log_arr['desc'] = Language::get('member_change_order_no').$order['order_sn'].Language::get('member_change_ensurereceive_predeposit_logdesc');
					$predeposit_model->savePredepositLog('order',$log_arr);
					unset($log_arr);
					//买家减少冻结金额
					$log_arr = array();	
					$log_arr['memberid'] = $_SESSION['member_id'];
					$log_arr['membername'] = $_SESSION['member_name'];
					$log_arr['logtype'] = '1';
					$log_arr['price'] = -$order['order_amount'];
					$log_arr['desc'] = Language::get('member_change_order_no').$order['order_sn'].Language::get('member_change_ensurereceive_predepositfreeze_logdesc');
					$predeposit_model->savePredepositLog('order',$log_arr);
					unset($log_arr);
				}elseif (!C('payment')){	//如果平台收款，默认除预存款以外的支付方式都增加到预存款里
					//查询买家信息
					$model_member = Model('member');
					$buyer_info = $model_member->infoMember(array('member_id'=>$_SESSION['member_id']));
					if (!is_array($buyer_info) || count($buyer_info)<=0){
						showDialog($lang['member_change_order_member_error'],'index.php?act=member&op=order');
					}
					//调整预存款
					$predeposit_model = Model('predeposit');
					//卖家增加可用金额
					$log_arr = array();
					$log_arr['memberid'] = $seller['member_id'];
					$log_arr['membername'] = $seller['member_name'];
					$log_arr['logtype'] = '0';
					$log_arr['price'] = $order['order_amount'];
					$log_arr['desc'] = Language::get('member_change_order_no').$order['order_sn'].Language::get('member_change_ensurereceive_predeposit_logdesc');
					$predeposit_model->savePredepositLog('income',$log_arr);
				}
			}
			//添加订单日志
			$model_order->addLogOrder($state_code,$order_id,($_POST['state_info1']!=''? $_POST['state_info1'] :$_POST['state_info'] ));
			//更改订单状态
			$model_order->updateOrder($array,$order_id);
			//确认收货时添加会员积分
			if ($GLOBALS['setting_config']['points_isuse'] == 1 && $state_code == 40){
				$points_model = Model('points');
				$points_model->savePointsLog('order',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name'],'orderprice'=>$order['order_amount'],'order_sn'=>$order['order_sn'],'order_id'=>$order['order_id']),true);
			}

			/**
			 * 发送通知
			 */
			$param	= array(
				'site_url'	=> SiteUrl,
				'site_name'	=> $GLOBALS['setting_config']['site_name'],
				'buyer_name'	=> $order['buyer_name'],
				'seller_name'	=> $seller['member_name'],
				'reason'	=> $_POST['state_info1']!=''? $_POST['state_info1'] :$_POST['state_info'],
				'order_sn'	=> $order['order_sn'],
				'order_id'	=> $order['order_id']
			);
			$code	= '';
			switch ($state_type) {
				case 'cancel_order':
					$code	= 'email_toseller_cancel_order_notify';
					break;
				case 'confirm_order':
					$code	= 'email_toseller_finish_notify';
					break;
			}
			$this->send_notice($order['seller_id'],$code,$param);
			showDialog(Language::get('nc_common_save_succ'),'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
			exit;
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
		/**
		 * 读取语言包
		 */
		Language::read('member_member_index');
		$lang	= Language::getLangContent();
		$order_id	= intval($_GET['order_id']);
		/**
		 * 实例化订单模型
		 */
		$model_order	= Model('order');
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$order_info = $model_order->getOrderById($order_id,'all',$condition);
		$order_id	= intval($order_info['order_id']);
		if($order_id == 0) {
			showMessage($lang['miss_argument'],'','html','error');
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
		$model_my_order = Model('my_order');
		/**
		 * 订单商品
		 */
		$order_goods_list= $model_my_order->myOrderGoodsList(array('order_id'=>$order_id));
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
		$condition['buyer_id'] = $_SESSION['member_id'];
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
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$condition['return_state'] = '2';
		$condition['order']	=  'return.return_id asc';
		$return_list= $model_return->getReturnGoodsList($condition);
		Tpl::output('return_list',$return_list);
		/**
		 * 页面输出
		 */
		Tpl::output('left_show','order_view');
		Tpl::showpage('member_order_view');
	}

	/**
	 * 查看物流
	 *
	 */
	public function show_expressOp() {		
		/**
		 * 读取语言包
		 */
		Language::read('member_member_index');
		$lang	= Language::getLangContent();
		$order_id	= intval($_GET['order_id']);
		/**
		 * 实例化订单模型
		 */
		$model_order	= Model('order');
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$order_info = $model_order->getOrderById($order_id,'all',$condition);

		$order_id	= intval($order_info['order_id']);
		if($order_id == 0) {
			showMessage($lang['miss_argument'],'','html','error');
		}
		$order_info['state_info'] = orderStateInfo($order_info['order_state']);
		Tpl::output('order_info',$order_info);
		/**
		 * 卖家信息
		 */
		$model_store	= Model('store');
		$store_info		= $model_store->shopStore(array('store_id'=>$order_info['store_id']));
		Tpl::output('store_info',$store_info);
		/**
		 * 实例化买家订单模型
		 */
		$model_my_order = Model('my_order');
		/**
		 * 订单商品
		 */
		$order_goods_list= $model_my_order->myOrderGoodsList(array('order_id'=>$order_id));
		Tpl::output('order_goods_list',$order_goods_list);

		//卖家发货信息
		$daddress_info = Model('daddress')->find($order_info['daddress_id']);
		Tpl::output('daddress_info',$daddress_info);		
		
		//取得配送公司代码
		$express_list  = ($h = F('express')) ? $h : H('express',true,'file');

		Tpl::output('e_code',$express_list[$order_info['shipping_express_id']]['e_code']);
		Tpl::output('e_name',$express_list[$order_info['shipping_express_id']]['e_name']);
		Tpl::output('e_url',$express_list[$order_info['shipping_express_id']]['e_url']);

		Tpl::output('shipping_code',$order_info['shipping_code']);
		Tpl::output('left_show','order_view');
		Tpl::showpage('member_order_express_detail');
	}

	/**
	 * 从第三方取快递信息
	 *
	 */
	public function get_expressOp(){

		$url = 'http://www.kuaidi100.com/query?type='.$_GET['e_code'].'&postid='.$_GET['shipping_code'].'&id=1&valicode=&temp='.random(4).'&sessionid=&tmp='.random(4);
		import('function.ftp');
		$content = dfsockopen($url);
		$content = json_decode($content,true);
		

		if ($content['status'] != 200) exit(json_encode(false));
		$content['data'] = array_reverse($content['data']);
		$output = '';
		if (is_array($content['data'])){
			foreach ($content['data'] as $k=>$v) {
				if ($v['time'] == '') continue;
				$output .= '<li>'.$v['time'].'&nbsp;&nbsp;'.$v['context'].'</li>';
			}
		}
		if ($output == '') exit(json_encode(false));
		if (strtoupper(CHARSET) == 'GBK'){
			$output = Language::getUTF8($output);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
		echo json_encode($output);
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		/**
		 * 读取语言包
		 */
		Language::read('member_layout');
		$menu_array	= array();
		switch ($menu_type) {
			case 'address':
				$menu_array = array(
				1=>array('menu_key'=>'address','menu_name'=>Language::get('nc_member_path_address_list'),	'menu_url'=>'index.php?act=member&op=address'));
				break;
			case 'member_order':
				$menu_array = array(
				1=>array('menu_key'=>'member_order','menu_name'=>Language::get('nc_member_path_order_list'),	'menu_url'=>'index.php?act=member&op=order'),
				2=>array('menu_key'=>'buyer_refund','menu_name'=>Language::get('nc_member_path_buyer_refund'),	'menu_url'=>'index.php?act=member_refund'),
				3=>array('menu_key'=>'buyer_return','menu_name'=>Language::get('nc_member_path_buyer_return'),	'menu_url'=>'index.php?act=member_return'));
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
