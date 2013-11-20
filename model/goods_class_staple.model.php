<?php
/**
 * 常用商品分类模型
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

class goods_class_stapleModel{
	/**
	 * TAG列表
	 *
	 * @param array $condition 检索条件
	 * @param object $page 
	 * @return array 数组结构的返回结果
	 */
	public function getStapleList($condition, $page = '', $field='*'){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'goods_class_staple';
		$param['field'] = $field;
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'staple_id desc';
		$result = Db::select($param, $page);

		return $result;
	}
	/**
	 * TAG一条记录
	 *
	 * @param array $condition 检索条件
	 * @param object $page 
	 * @return array 一维数组结构的返回结果
	 */
	public function getStapleOne($condition, $field='*'){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'goods_class_staple';
		$param['field'] = $field;
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'staple_id desc';
		$result = Db::select($param);

		return $result['0'];
	}
	
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addStaple($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('goods_class_staple',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 根据用户id查询常用分类数量
	 * 
	 * @param int $id 用户id
	 * @return int 分类数量
	 */
	public function countStaple($id){
		$param = array();
		$param['table'] = 'goods_class_staple';
		$param['field'] = 'count(staple_id) as count';
		$param['where'] = ' and store_id = "'.$id.'"';
		$result = Db::select($param);
		return $result['0']['count'];
	}
	
	/**
	 * 删除常用分类
	 * 
	 * @param int $staple_id 常用类目id
	 * @param int $store_id	   店铺id
	 * @return bool 布尔类型的返回结果
	 */
	public function delStaple($staple_id, $store_id){
		return Db::delete('goods_class_staple', 'staple_id ="'.$staple_id.'" and store_id ="'.$store_id.'"');
	}
	
	/**
	 * 构造检索条件
	 *
	 * @param array $condition
	 * @return string 字符串类型的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';
		if($condition['store_id'] != '') {
			$condition_str .= ' and store_id = "'. $condition['store_id'] .'"';
		}
		if($condition['gc_id'] != '') {
			$condition_str .= ' and gc_id = "'. $condition['gc_id'] .'"';
		}
		if($condition['type_id'] != '') {
			$condition_str .= ' and type_id = "'. $condition['type_id'] .'"';
		}
		return $condition_str;
	}
}