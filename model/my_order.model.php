<?php
/**
 * 我的订单
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
class my_orderModel extends Model {
	public function __construct(){
		parent::__construct('order');
	}
	/**
	 * 我的订单列表，买家订单
	 *
	 */
	public function myOrderList($param,$obj_page='',$field='*') {
		$order_list	= array();
		$condition_str	= $this->getCondition($param);
		$array		= array();
		$array['table']		= 'order';
		$array['field']		= $field;
		$array['where'] 	= "where buyer_id='{$_SESSION['member_id']}'".$condition_str;
		$array['order'] 	= 'add_time DESC';
		$order_list	= Db::select($array,$obj_page);
		return $order_list;
	}
	/**
	 * 买家订单总数
	 *
	 */
	public function myOrderCount($param) {
		$order_list	= array();
		$condition_str	= $this->getCondition($param);
		$array		= array();
		$array['table']		= 'order';
		$array['field']		= 'count(order.order_id) as ordercount';
		$array['where'] 	= $condition_str;
		$order_list	= Db::select($array);
		return $order_list[0][0];
	}
	/**
	 * 我的订单列表，买家订单
	 *
	 */
	public function myOrderGoodsList($param,$page = '') {
		$order_goods_list	= array();
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$array['table']		= 'order,order_goods';
		$array['field']		= '`order`.*,`order_goods`.*';
		$array['join_type']	= 'LEFT JOIN';
		$array['join_on']	= array('order.order_id=order_goods.order_id');
		$array['where'] 	= "where order.buyer_id='{$_SESSION['member_id']}'".$condition_str;
		$array['order'] 	= ' order.add_time DESC';
		$order_goods_list	= Db::select($array,$page);
		return $order_goods_list;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if($condition_array['order_id_string'] != '') {
			$condition_sql	.= ' and order.order_id IN ('.$condition_array['order_id_string'].')';
		}
		if($condition_array['buyer_id'] != '') {
			$condition_sql	.= " and order.buyer_id='{$condition_array['buyer_id']}'";
		}
		if($condition_array['order_id'] != '') {
			$condition_sql	.= " and order.order_id='{$condition_array['order_id']}'";
		}
		if($condition_array['`order`.store_id'] > 0) {
			$condition_sql	.= " and `order`.store_id='{$condition_array['`order`.store_id']}'";
		}
		if($condition_array['`order`.evaluation_status'] !== null) {
			$condition_sql	.= " and `order`.evaluation_status='{$condition_array['`order`.evaluation_status']}'";
		}
		if($condition_array['`order_goods`.evaluation'] > 0) {
			$condition_sql	.= " and `order_goods`.evaluation='{$condition_array['`order_goods`.evaluation']}'";
		}
		if($condition_array['`order_goods`.rec_id'] > 0) {
			$condition_sql	.= " and `order_goods`.rec_id='{$condition_array['`order_goods`.rec_id']}'";
		}
		/*买家订单状态*/
		if($condition_array['order_state'] == 'order_cancal') {
			$condition_sql	.= ' and order_state=0';
		}
		if($condition_array['order_state'] == 'order_submit') {
			$condition_sql	.= ' and order_state=10';
		}
		if($condition_array['order_state'] == 'order_pay') {
			$condition_sql	.= ' and order_state=10';
		}
		if($condition_array['order_state'] == 'order_pay_confirm') {
			$condition_sql	.= ' and order_state=11';
		}
		if($condition_array['order_state'] == 'order_no_shipping') {
			$condition_sql	.= ' and order_state=20';
		}
		if($condition_array['order_state'] == 'order_shipping') {
			$condition_sql	.= ' and order_state=30';
		}
		if($condition_array['order_state'] == 'order_finish') {
			$condition_sql	.= ' and order_state=40';
		}
        if($condition_array['order_state'] == 'order_refer') {
            $condition_sql .= ' and order.order_state=50';
        }
        if($condition_array['order_state'] == 'order_confirm') {
            $condition_sql .= ' and order.order_state=60';
        }
		if($condition_array['add_time_to'] != '' and $condition_array['add_time_from'] != '') {
			$condition_sql	.= " and add_time>= '{$condition_array['add_time_from']}' and add_time <= '{$condition_array['add_time_to']}'";
		}
		if ($condition_array['order_sn'] != '') {
			$condition_sql	.= " and order_sn LIKE '%".$condition_array['order_sn']."%'";
		}
		//待卖家评价订单(交易成功 并且 买家没有评价 并且 (1.十五天内 或者 2.卖家评价后十五天内))
		if($condition_array['order_evalbuyer_able'] != '') {
			$condition_sql	.= " and order.order_state=40 and order.refund_state<2 and order.evaluation_status = 0 and (((order.finnshed_time+60*60*24*15)>".time().") or ((order.evalseller_time+60*60*24*15)>".time().")) ";
		}
		return $condition_sql;
	}
}
