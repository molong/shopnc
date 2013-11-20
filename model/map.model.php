<?php
/**
 * 地图
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
class mapModel{
	/**
	 * 读取记录
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getRow($map_id){
		$param	= array();
		$param['table']	= 'map';
		$param['field']	= 'map_id';
		$param['value']	= $map_id;
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
		$param['table'] = 'map';
		$param['where']	= $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'map_id desc';
		$param['limit'] = $condition['limit'];
		$result = Db::select($param,$page);
		return $result;
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
			$result = Db::insert('map',$param);
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
		$map_id = $condition['map_id'];
		if (intval($map_id) < 1){
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$where = $condition_str;
		if (is_array($param)){
			$result = Db::update('map',$param,$where);
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
		$map_id = $condition['map_id'];
		if (intval($map_id) < 1){
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$where = $condition_str;
		if (is_array($condition)){
			$result = Db::delete('map',$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if($condition_array['map_id'] != '') {
			$condition_sql	.= " and map_id = '".$condition_array['map_id']."'";
		}
		if($condition_array['store_id'] != '') {
			$condition_sql	.= " and store_id = '".$condition_array['store_id']."'";
		}
		if($condition_array['member_id'] != '') {
			$condition_sql	.= " and member_id = '".$condition_array['member_id']."'";
		}
		if($condition_array['map_api'] != '') {
			$condition_sql	.= " and map_api = '".$condition_array['map_api']."'";
		}
		return $condition_sql;
	}
	
}