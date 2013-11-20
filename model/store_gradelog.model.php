<?php
/**
 * 店铺等级模型
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

class store_gradelogModel{
	/**
	 * 列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getLogList($condition,$page = ''){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'store_gradelog';
		$param['field'] = $condition['field'];
		$param['where'] = $condition_str;
		$param['order'] = $condition['order']?$condition['order']:'gl_id';
		$param['limit'] = $condition['limit'];
		$result = Db::select($param,$page);
		return $result;		
	}
	/**
	 * 申请信息单条
	 *
	 * @param array $condition 条件数组
	 * @param array $field   查询字段
	 */
	public function getLogInfo($condition,$field='*'){
		//得到条件语句
		$condition_str	= $this->_condition($condition);
		$array			= array();
		$array['table']	= 'store_gradelog';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$array['order'] = $condition['order']?$condition['order']:'gl_id';
		$log_info		= Db::select($array);
		return $log_info[0];
	}
	/**
	 * 构造检索条件
	 *
	 * @param int $id 记录ID
	 * @return string 字符串类型的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';
		if (isset($condition['gl_id'])){
			if ($condition['gl_id'] == ''){
				$condition_str .= " and store_gradelog.gl_id = '' ";
			}else {
				$condition_str .= " and store_gradelog.gl_id = '{$condition['gl_id']}'";
			}
		}
		if (isset($condition['gl_id_in'])){
			if ($condition['gl_id_in'] == ''){
				$condition_str .= " and store_gradelog.gl_id in('')";
			}else {
				$condition_str .= " and store_gradelog.gl_id in({$condition['gl_id_in']})";
			}
		}
		if (isset($condition['gl_shopid'])){
			$condition_str .= " and store_gradelog.gl_shopid = '{$condition['gl_shopid']}'";
		}
		if (isset($condition['gl_shopname_like'])){
			if ($condition['gl_shopname_like'] == ''){
				$condition_str .= " and store_gradelog.gl_shopname = '' ";
			}else {
				$condition_str .= " and store_gradelog.gl_shopname = '{$condition['gl_shopname_like']}'";
			}
		}
		if (isset($condition['gl_membername_like'])){
			if ($condition['gl_membername_like'] == ''){
				$condition_str .= " and store_gradelog.gl_membername = '' ";
			}else {
				$condition_str .= " and store_gradelog.gl_membername = '{$condition['gl_membername_like']}'";
			}
		}
		if (isset($condition['gl_sgname_like'])){
			if ($condition['gl_sgname_like'] == ''){
				$condition_str .= " and store_gradelog.gl_sgname = '' ";
			}else {
				$condition_str .= " and store_gradelog.gl_sgname = '{$condition['gl_sgname_like']}'";
			}
		}
		if (isset($condition['gl_allowstate'])){
			if ($condition['gl_allowstate'] == ''){
				$condition_str .= " and store_gradelog.gl_allowstate = '' ";
			}else {
				$condition_str .= " and store_gradelog.gl_allowstate = '{$condition['gl_allowstate']}'";
			}
		}
		return $condition_str;
	}	
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addLog($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('store_gradelog',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 申请信息修改
	 *
	 * @param	array $param 修改信息数组
	 * @param	int $ztc_id 团购商品id
	 */
	public function updateLogOne($param,$condition) {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->_condition($condition);
		$result	= Db::update('store_gradelog',$param,$condition_str);
		return $result;
	}
	/**
	 * 删除申请信息
	 * @param	mixed $gl_id 删除申请记录编号
	 */
	public function dropLogById($gl_id){
		if(empty($gl_id)) {
			return false;
		}
		$condition_str = ' 1=1 ';
		if (is_array($gl_id) && count($gl_id)>0){
			$gl_idStr = implode(',',$gl_id);
			$condition_str .= " and gl_id in({$gl_idStr}) ";
		}else {
			$condition_str .= " and gl_id = '{$gl_id}' ";
		}
		$result = Db::delete('store_gradelog',$condition_str);
		return $result;
	}
}