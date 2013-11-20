<?php
/**
 * 退货
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

class returnControl extends BaseMemberStoreControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_return');
		$state_array = array(
			'1' => Language::get('return_state_confirm'),
			'2' => Language::get('return_state_yes'),
			'3' => Language::get('return_state_no')
			);//状态:1为待审核,2为同意,3为不同意
		Tpl::output('state_array',$state_array);
	}
	/**
	 * 退货审核
	 *
	 */
	public function editOp(){
		$model_return	= Model('return');
		$condition = array();
		$condition['seller_id'] = $_SESSION['member_id'];
		$condition['return_id'] = intval($_GET["return_id"]);
		$return_list = $model_return->getList($condition);
		$return = $return_list[0];
		$order_id	= $return['order_id'];
		$order_goods_list= $model_return->getReturnGoodsList($condition);
		if(is_array($order_goods_list) && !empty($order_goods_list)) {
			foreach ($order_goods_list as $key => $val) {
				$val['store_id'] = $return['store_id'];
				$order_goods_list[$key] = $val;
			}
		}
		Tpl::output('return',$return);
		Tpl::output('order_goods_list',$order_goods_list);
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			$return_array = array();
			$goods_list = array();
			if(is_array($order_goods_list) && !empty($order_goods_list)) {
				$return_num = 0;//退货数量
				$goods_num = 0;//商品总数
				$model_order = Model('order');
				foreach ($order_goods_list as $key => $val) {
					$goods_id	= $val['goods_id'];
					$return_goodsnum = intval($val['goods_returnnum']);//单个商品的退货数量
					if (($return_goodsnum > 0) && ($val['goods_num'] >= $return_goodsnum)){//还有可退数量时执行
						$return_num += $return_goodsnum;
						$param = array();
						$param['goods_returnnum'] = $return_goodsnum;//更新已退货数量
						$model_order->updateOrderGoods($param,$val['rec_id']);
					}
				}
				if($return_num > 0) {//有效退货数据
					$goods_num = $model_return->getOrderGoodsCount($order_id);
					//修改订单
					$array['return_num'] = $return_num;
					$array['return_state'] = ($goods_num-$array['return_num'])?1:2;
					$state = $model_order->updateOrder($array,$order_id);
				}
			}
			
			if($state) {
				$return_array['return_goodsnum'] = $return_num;//退货数量
				$condition = array();
				$condition['return_id'] = intval($_GET["return_id"]);
				$return_array['seller_time'] = time();	
				$return_array['return_state'] = $_POST["return_state"];//状态:1为待审核,2为同意,3为不同意
				$return_array['return_message'] = $_POST["return_message"];
				$model_return->update($condition,$return_array);//更新退货单记录
				showDialog(Language::get('return_add_success'),'reload','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');//保存成功
			} else {
				showDialog(Language::get('return_add_fail'),'reload',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');//添加失败
			}
		}
		Tpl::showpage('store_return_edit','null_layout');
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
		$condition['seller_id'] = $_SESSION['member_id'];
		$condition['seller_return_state'] = '2';//状态
		$keyword_type = array('order_sn','refund_sn','buyer_name');
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
		Tpl::output('last_num',count($return_list)-1);
		Tpl::output('return_list',$return_list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('return','return');
		Tpl::output('menu_sign','store_return');
		Tpl::output('menu_sign_url','index.php?act=return');
		Tpl::output('menu_sign1','store_return');
		Tpl::showpage('store_return');
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
		$condition['seller_id'] = $_SESSION['member_id'];
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
		Tpl::showpage('store_return_view','null_layout');
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
			case 'return':
				$menu_array	= array(
					1=>array('menu_key'=>'return','menu_name'=>Language::get('nc_member_path_store_return'),	'menu_url'=>'index.php?act=return')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
