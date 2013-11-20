<?php
/**
 * 退货
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2012 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class member_returnControl extends BaseMemberControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_return');
		Language::read('member_member_index');
		$state_array = array(
			'1' => Language::get('return_state_confirm'),
			'2' => Language::get('return_state_yes'),
			'3' => Language::get('return_state_no')
			);//状态:1为待审核,2为同意,3为不同意
		Tpl::output('state_array',$state_array);
	}
	/**
	 * 添加
	 *
	 */
	public function addOp(){
		$model_order = Model('order');
		$model_return	= Model('return');
		$order_id	= intval($_GET['order_id']);
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$order_list = $model_order->getOrderList($condition);
		$order = $order_list[0];
		$order_id	= $order['order_id'];
		$order_goods_list= $model_return->getOrderGoodsList($order_id);
		
		if(is_array($order_goods_list) && !empty($order_goods_list)) {
			foreach ($order_goods_list as $key => $val) {
				$val['store_id'] = $order['store_id'];
				$order_goods_list[$key] = $val;
			}
		}
		Tpl::output('order',$order);
		Tpl::output('order_goods_list',$order_goods_list);
		$model_return	= Model('return');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['order_id'] = $order_id;
		$return_list = $model_return->getList($condition);
		$return = $return_list[0];
		Tpl::output('return',$return);
		if($return["return_state"] > 0) {
			Tpl::showpage('member_return_view','null_layout');
		}
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			$return_array = array();
			$goods_list = array();
			if(is_array($order_goods_list) && !empty($order_goods_list)) {
				$return_num = 0;//退货数量
				$goods_num = 0;//商品总数
				foreach ($order_goods_list as $key => $val) {
					$goods_id	= $val['goods_id'];
					$goods_num += $val['goods_num'];
					$return_goodsnum = intval($_POST["goods_".$goods_id]);//单个商品的退货数量
					if (($return_goodsnum > 0) && ($val['goods_num'] >= ($val['goods_returnnum']+$return_goodsnum))){//还有可退数量时执行
						$return_num += $return_goodsnum;
						$return_goods = array();
						$return_goods['goods_returnnum'] = $return_goodsnum;
						$return_goods['order_id'] = $val['order_id'];
						$return_goods['goods_id'] = $val['goods_id'];
						$return_goods['goods_name'] = $val['goods_name'];
						$return_goods['spec_id'] = $val['spec_id'];
						$return_goods['spec_info'] = $val['spec_info'];
						$return_goods['goods_price'] = $val['goods_price'];
						$return_goods['goods_num'] = $val['goods_num'];
						$return_goods['goods_image'] = $val['goods_image'];
						
						$goods_list[] = $return_goods;
					}
				}
				$return_array['return_goodsnum'] = $return_num;//退货数量
				
				$return_array['order_id'] = $order['order_id'];
				$return_array['order_sn'] = $order['order_sn'];
				$return_array['seller_id'] = $order['seller_id'];
				$return_array['store_id'] = $order['store_id'];
				$return_array['store_name'] = $order['store_name'];
				$return_array['buyer_id'] = $order['buyer_id'];
				$return_array['buyer_name'] = $order['buyer_name'];
				
				$return_array['return_type'] = '1';//类型:1为买家,2为卖家
				$return_array['return_state'] = '1';//状态:1为待审核,2为同意,3为不同意
				
				$return_array['add_time'] = time();	
				$return_array['buyer_message'] = $_POST["buyer_message"];
				$return_id = $model_return->add($return_array);//添加退货单记录
	    	$order_array = array();
	    	$order_array['return_state'] = '1';
	    	Model()->table('order')->where(array('order_id'=>$order['order_id']))->update($order_array);//更新订单
				if(is_array($goods_list) && !empty($goods_list)) {
					foreach ($goods_list as $key => $val) {
						$val['return_id'] = $return_id;
						$model_return->addGoods($val);//添加退货商品记录
					}
				}
			}
			
			if($return_id) {
				showDialog(Language::get('return_add_success'),'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');//保存成功
			} else {
				showDialog(Language::get('return_add_fail'),'reload',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');//添加失败
			}
		}
		Tpl::showpage('member_return_add','null_layout');
	}
	/**
	 * 退货记录列表页
	 *
	 */
	public function indexOp(){
		/**
		 * 实例化退货模型
		 */
		$model_return	= Model('return');
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		/**
		 * 查询退货记录
		 */
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['return_type'] = '1';//类型:1为买家申请,2为卖家记录
		
		$keyword_type = array('order_sn','return_sn','store_name');
		if(trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)){
			$condition['type']	= $_GET['type'];
			$condition['keyword']	= $_GET['key'];
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
		$return_list = $model_return->getList($condition,$page);
		//查询会员信息
		$this->get_member_info();
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('member_order','buyer_return');
		Tpl::output('menu_sign','myorder');
		Tpl::output('menu_sign_url','index.php?act=member&op=order');
		Tpl::output('menu_sign1','buyer_return');
		Tpl::showpage('member_return');
	}
	/**
	 * 退货记录查看页
	 *
	 */
	public function viewOp(){
		/**
		 * 实例化退货模型
		 */
		$model_return	= Model('return');
		$condition = array();
		$condition['buyer_id'] = $_SESSION['member_id'];
		$condition['return_id'] = intval($_GET["return_id"]);
		$return_list = $model_return->getList($condition);
		$return = $return_list[0];
		$order_goods_list= $model_return->getReturnGoodsList($condition);
		if(is_array($order_goods_list) && !empty($order_goods_list)) {
			foreach ($order_goods_list as $key => $val) {
				$val['store_id'] = $return['store_id'];
				$order_goods_list[$key] = $val;
			}
		}
		Tpl::output('return',$return);
		Tpl::output('order_goods_list',$order_goods_list);
		Tpl::showpage('member_return_view','null_layout');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array	= array();
		switch ($menu_type) {
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
