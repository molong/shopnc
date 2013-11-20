<?php
/**
 * 店铺的订单管理
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
class store_orderModel {
	/**
	 * 店铺的订单列表，卖家订单
	 *
	 */
	public function storeOrderList($param,$obj_page='',$field='*') {
		$order_list	= array();
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$array		= array();
		$array['table']		= 'order,order_address';
		$array['field']		= $field;
		$array['join_type']	= 'left join';
		$array['join_on']	= array('`order`.order_id=`order_address`.order_id');
		$array['where'] 	= "where seller_id='{$_SESSION['member_id']}'".$condition_str;
		$array['order'] 	= '`order`.add_time DESC';
		$order_list	= Db::select($array,$obj_page);
		return $order_list;
	}
	/**
	 * 店铺的订单商品列表，卖家订单商品
	 *
	 */
	public function storeOrderGoodsList($param,$obj_page='',$field='*') {
		$array		= array();
		$condition_str	= $this->getCondition($param);
		$array['table']		= 'order,order_goods';
		$array['field']		= '`order`.*,`order_goods`.*';
		$array['join_type']	= 'LEFT JOIN';
		$array['join_on']	= array('order.order_id=order_goods.order_id');
		$array['where'] 	= "where order.seller_id='{$_SESSION['member_id']}'".$condition_str;
		$array['order'] 	= ' order.add_time DESC';
		$order_list	= Db::select($array,$obj_page);
		return $order_list;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if(!empty($condition_array['order_id'])) {
			$condition_sql	.= ' and order.order_id IN ('.$condition_array['order_id'].')';
		}
		if($condition_array['order_state'] == 'order_cancel') {
			$condition_sql	.= ' and order.order_state=0';
		}
		if($condition_array['order_state'] == 'order_submit') {
			$condition_sql	.= ' and order.order_state=50';
		}
		if($condition_array['order_state'] == 'order_pay') {
			$condition_sql	.= ' and order.order_state=10';
		}
		if($condition_array['order_state'] == 'pay_confirm') {
			$condition_sql	.= ' and order_state=11';
		}
		if($condition_array['order_state'] == 'order_no_shipping') {
			$condition_sql	.= ' and (order.order_state=20 or order.order_state=60)';
		}
		if($condition_array['order_state'] == 'order_shipping') {
			$condition_sql	.= ' and order.order_state=30';
		}
		if($condition_array['order_state'] == 'order_finish') {
			$condition_sql	.= ' and order.order_state=40';
		}
		if($condition_array['`order`.store_id'] > 0) {
			$condition_sql	.= " and `order`.store_id='{$condition_array['`order`.store_id']}'";
		}
		if($condition_array['`order`.evaluation_status'] > 0) {
			$condition_sql	.= " and `order`.evaluation_status='{$condition_array['`order`.evaluation_status']}'";
		}
		if($condition_array['`order_goods`.evaluation'] > 0) {
			$condition_sql	.= " and `order_goods`.evaluation='{$condition_array['`order_goods`.evaluation']}'";
		}
		if($condition_array['buyer_name'] != '') {
			$condition_sql	.= " and order.buyer_name LIKE '%".$condition_array['buyer_name']."%'";
		}
		if ($condition_array['order_sn'] != '') {
			$condition_sql	.= " and order.order_sn LIKE '%".$condition_array['order_sn']."%'";
		}	
		if($condition_array['add_time_to'] != '' and $condition_array['add_time_from'] != '') {
			$condition_sql	.= " and order.add_time>= '{$condition_array['add_time_from']}' and order.add_time<='{$condition_array['add_time_to']}'";
		}
		//待卖家评价订单(交易成功 并且 卖家没有评价 并且 (1.十五天内 或者 2.买家评价后十五天内))
		if($condition_array['order_evalseller_able'] != '') {
			$condition_sql	.= " and order.order_state=40 and order.refund_state<2 and order.evalseller_status = 0 and (((order.finnshed_time+60*60*24*15)>".time().") or ((order.evaluation_time+60*60*24*15)>".time().")) ";
		}
		return $condition_sql;
	}
}
?>