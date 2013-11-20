<?php
/**
 * 退货记录
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
class returnModel{
	/**
	 * 读取记录
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getRow($return_id){
		$param	= array();
		$param['table']	= 'return';
		$param['field']	= 'return_id';
		$param['value']	= $return_id;
		$result	= Db::getRow($param);
		return $result;
	}
	
	/**
	 * 读取记录列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getList($condition = '',$page = ''){
		$condition_str = $this->getCondition($condition);
		$param = array();
		$param['table'] = 'return';
		$param['where']	= $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'return_id desc';
		$param['limit'] = $condition['limit'];
		$result = Db::select($param,$page);
		return $result;
	}
	/**
	 * 读取订单商品记录列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getOrderGoodsList($order_id){
		$condition_str = " and order_id = '".$order_id."'";
		$param = array();
		$param['table'] = 'order_goods';
		$param['where']	= $condition_str;
		$result = Db::select($param);
		return $result;
	}
	/**
	 * 读取订单商品总数
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getOrderGoodsCount($order_id){
		$condition_str = " and order_id = '".$order_id."'";
		$param = array();
		$param['table'] = 'order_goods';
		$array['field']		= 'sum(goods_num) as goods_num';
		$param['where']	= $condition_str;
		$result = Db::select($param);
		return $result[0]['goods_num'];
	}
	/**
	 * 读取退货商品记录列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getReturnGoodsList($condition){
		$condition_str = $this->getCondition($condition);
		$param = array();
		$param['field'] = $condition['field'] ? $condition['field'] : 'return_goods.*,return.add_time,return.order_sn,return.return_sn';
		$param['table'] = 'return,return_goods';
		$param['where']	= $condition_str;
		$param['join_type']	= 'left join';
		$param['join_on']	= array('return.return_id=return_goods.return_id');
		$param['order'] = $condition['order'] ? $condition['order'] : 'return.return_id desc';
		$result = Db::select($param);
		return $result;
	}
	/**
	 * 生成编号
	 *
	 * @return string
	 */
	public function getSn() {
		$sn = '9'.date('Ymd').substr(implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))) , -8 , 8);
		return $sn;
	}
	
	/**
	 * 新增
	 *
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public function add($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$param['return_sn'] = $this->getSn();
			$result = Db::insert('return',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 新增退货商品
	 *
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public function addGoods($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$result = Db::insert('return_goods',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 更新信息
	 *
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public function update($condition,$param){
		$return_id = $condition['return_id'];
		if (intval($return_id) < 1){
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$where = $condition_str;
		if (is_array($param)){
			$result = Db::update('return',$param,$where);
			return result;
		}else {
			return false;
		}
	}
	/**
	 * 删除
	 *
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public function del($condition){
		$return_id = $condition['return_id'];
		if (intval($return_id) < 1){
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$where = $condition_str;
		if (is_array($condition)){
			$result = Db::delete('return',$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 总数
	 *
	 */
	public function getCount($condition) {
		$condition_str	= $this->getCondition($condition);
		$count	= Db::getCount('return',$condition_str);
		return $count;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if($condition_array['return_id'] !== null) {
			$condition_sql	.= " and return.return_id = '".$condition_array['return_id']."'";
		}
		if($condition_array['order_id'] !== null) {
			$condition_sql	.= " and return.order_id = '".$condition_array['order_id']."'";
		}
		if($condition_array['seller_id'] !== null) {
			$condition_sql	.= " and seller_id = '".$condition_array['seller_id']."'";
		}
		if($condition_array['store_id'] !== null) {
			$condition_sql	.= " and store_id = '".$condition_array['store_id']."'";
		}
		if($condition_array['order_sn'] !== null) {
			$condition_sql	.= " and order_sn = '".$condition_array['order_sn']."'";
		}
		if($condition_array['return_sn'] !== null) {
			$condition_sql	.= " and return_sn = '".$condition_array['return_sn']."'";
		}
		if($condition_array['return_type'] !== null) {
			$condition_sql	.= " and return_type = '".$condition_array['return_type']."'";
		}
		if($condition_array['return_state'] !== null) {
			$condition_sql	.= " and return_state = '".$condition_array['return_state']."'";
		}
		if($condition_array['seller_return_state'] !== null) {
			$condition_sql	.= " and return_state > 1";
		}
		if($condition_array['add_time_from'] !== null){
			$condition_sql	.= " and add_time >= '".$condition_array['add_time_from']."'";
		}
		if($condition_array['add_time_to'] !== null){
			$condition_sql	.= " and add_time <= '".$condition_array['add_time_to']."'";
		}
		if ($condition_array['keyword'] !== null){
			$condition_sql .= " and return.". $condition_array['type'] ." like '%". $condition_array['keyword'] ."%'";
		}
		if($condition_array['order_ids'] !== null) {
			$condition_sql	.= " and return.order_id in(".$condition_array['order_ids'].")";
		}
		return $condition_sql;
	}
	
}