<?php
/**
 * 类型管理
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

class typeModel extends Model {
	
	public function __construct(){
		parent::__construct();
	}
	/**
	 * 类型列表
	 * @param array  $param 
	 * @param object $page  
	 * @param string $field 
	 */
	public function typeList($param,$page = '',$field = '*') {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= 'type';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$array['order']		= $param['order'];
		$list_type		= Db::select($array,$page);
		return $list_type;
	}
	/**
	 * 添加类型信息
	 * @param string $table 表名
	 * @param array $param 一维数组
	 * @return bool
	 */
	public function typeAdd($table,$param){
		return Db::insert($table, $param);
	}
	/**
	 * 添加对应关系信息
	 * @param string $table 表名
	 * @param array $param 一维数组
	 * @param string $id
	 * @param string $row 列名
	 * @return bool
	 */
	public function typeRelatedAdd($table, $param, $id, $row=''){
		$insert_str = '';
		if(is_array($param)){
			foreach($param as $v){
				$insert_str .= "('". $id ."', '". $v ."'),";
			}
		}else{
			$insert_str .= "('". $id ."', '". $param ."'),";
		}
		$insert_str = rtrim($insert_str,',');
		return Db::query("insert into `".DBPRE.$table."` ". $row ." values ".$insert_str);
	}
	/**
	 * 添加商品与规格、属性对应关系信息
	 * @param array $param 一维数组
	 * @param string $table 表名
	 * @return bool
	 */
	public function typeGoodsRelatedAdd( $param, $table, $type=""){
		$insert_str = '';
		if(is_array($param['value']) && !empty($param['value'])){
			foreach ($param['value'] as $key=>$val){
				if(is_array($val) && !empty($val)){
					foreach ($val as $k=>$v){
						if(intval($k)>0 && $k != 'name'){
							if($type == 'spec'){
								$insert_str .= "('". $param['goods_id'] ."','". $param['gc_id'] ."','". $param['type_id'] ."','". $key ."','". $k ."','". $v ."'),";
							}else{
								$insert_str .= "('". $param['goods_id'] ."','". $param['gc_id'] ."','". $param['type_id'] ."','". $key ."','". $k ."'),";
							}
						}
					}
				}
			}
		}
		$insert_str = rtrim($insert_str,',');
		if($insert_str != ''){
		return Db::query("insert into `".DBPRE.$table."`  values ".$insert_str);
		}
	}
	/**
	 * 对应关系信息列表
	 * @param string $table 表名
	 * @param array $param 一维数组
	 * @param string $id
	 * @param string $row 列名
	 * @return Array
	 */
	public function typeRelatedList($table, $param, $field = '*'){
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= $table;
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$array['order']		= $param['order'];
		$list_type		= Db::select($array);
		return $list_type;
	}
	/**
	 * 更新属性信息
	 * @param	array $update 更新数据
	 * @param	array $param 条件
	 * @param	string $table 表名
	 * @return	bool
	 */
	public function typeUpdate($update, $param, $table){
		$condition_str = $this->getCondition($param);
		if (empty($update)){
			return false;
		}
		if (is_array($update)){
			$tmp = array();
			foreach ($update as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::update($table,$tmp,$condition_str);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 类型与属性关联信息,多表查询
	 * 
	 * @param array $param 类型相关信息
	 * @param int   $type  参数
	 * @param string $field 
	 */
	public function typeRelatedJoinList($param, $type='', $field='*') {
		if(!$param){
			return false;
		}
		$condition_str = $this->getCondition($param);
		$array	= array();
		switch ($type){
			case 'spec':
				$array['table']		= 'type_spec, spec, spec_value';
				$array['join_type']	= 'INNER JOIN';
				$array['join_on']	= array(
					'type_spec.sp_id=spec.sp_id',
					'type_spec.sp_id=spec_value.sp_id'
				);
				$array['order'] = $param['order'] ? $param['order'] : 'spec.sp_sort asc, spec_value.sp_value_sort asc';
				break;
			case 'attr':
				$array['table']		= 'attribute, attribute_value';
				$array['join_type']	= 'INNER JOIN';
				$array['join_on']	= array(
					'attribute.attr_id=attribute_value.attr_id'
				);
				$array['order'] = $param['order'] ? $param['order'] : 'attribute.attr_sort asc, attribute_value.attr_value_sort asc, attribute_value.attr_value_id asc';
				break;
			case 'brand':
				$array['table']		= 'type_brand, brand';
				$array['join_type']	= 'INNER JOIN';
				$array['join_on']	= array(
					'type_brand.brand_id=brand.brand_id'
				);
				$array['order'] = $param['order'] ? $param['order'] : 'brand.brand_sort asc';
				break;
		}
		$array['where'] = $condition_str;
		$array['field'] = $field;
		$result = Db::select($array);
		return $result;
	}
	/**
	 * 类型与属性关联信息,多表查询
	 * 
	 * @param array $param 类型相关信息
	 * @param int   $type  参数
	 * @param string $field 
	 */
	public function typeRelatedJoinListForCache($param, $type='', $field='*') {
		if(!$param){
			return false;
		}
		$condition_str = $this->getCondition($param);
		$array	= array();
		switch ($type){
			case 'spec':
				$array['table']		= 'type_spec, spec, spec_value, goods_class';
				$array['join_type']	= 'INNER JOIN';
				$array['join_on']	= array(
					'type_spec.sp_id=spec.sp_id',
					'type_spec.sp_id=spec_value.sp_id',
					'type_spec.type_id=goods_class.type_id'
				);
				$array['order'] = $param['order'] ? $param['order'] : 'spec.sp_sort asc, spec_value.sp_value_sort asc';
				break;
			case 'attr':
				$array['table']		= 'attribute, attribute_value, goods_class';
				$array['join_type']	= 'INNER JOIN';
				$array['join_on']	= array(
					'attribute.attr_id=attribute_value.attr_id',
					'attribute.type_id=goods_class.type_id'
				);
				$array['order'] = $param['order'] ? $param['order'] : 'attribute.attr_sort asc, attribute_value.attr_value_sort asc, attribute_value.attr_value_id asc';
				break;
			case 'brand':
				$array['table']		= 'type_brand, brand, goods_class';
				$array['join_type']	= 'INNER JOIN';
				$array['join_on']	= array(
					'type_brand.brand_id=brand.brand_id',
					'type_brand.type_id=goods_class.type_id'
				);
				$array['order'] = $param['order'] ? $param['order'] : 'brand.brand_sort asc';
				break;
		}
		$array['where'] = $condition_str;
		$array['field'] = $field;
		$result = Db::select($array);
		return $result;
	}
	/**
	 * 根据规格值、品牌、属性值查询商品
	 * 
	 * @param array $param 类型相关信息
	 * @param int   $type  参数
	 * @param string $field 
	 */
	public function typeRelatedGroupList($param, $type='') {
		if(!$param){
			return false;
		}
		$condition_str = $this->getCondition($param);
		$array	= array();
		switch ($type){
			case 'spec':
				$array['table']		= 'goods_spec_index';
				$array['field'] 	= 'goods_id, sp_value_id';
				if (isset($param['limit'])){
					$array['limit'] 	= $param['limit'];
				}
				break;
			case 'attr':
				$array['table']		= 'goods_attr_index';
				$array['field']		= 'goods_id, attr_value_id';
				break;
			case 'brand':
				$array['table']		= 'goods';
				$array['field'] 	= 'goods_id, brand_id';
				if (isset($param['limit'])){
					$array['limit'] 	= $param['limit'];
				}				
				break;
		}
		$array['where'] = $condition_str;
		$result = Db::select($array);
		return $result;
	}
	/**
	 * 删除属性相关
	 * 
	 * @param string $table 表名 spec,spec_value
	 * @param array $param 一维数组
	 * @return bool
	 */
	public function delType($table,$param){
		$condition_str = $this->getCondition($param);
		return Db::delete($table, $condition_str);
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 * 
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array) {
		$condition_str = '';
		if($condition_array['goods_id'] != ''){
			$condition_str .= " and goods_id ='".$condition_array['goods_id']."'";
		}
		if($condition_array['in_goods_id'] != ''){
			$condition_str .= " and goods_id in (".$condition_array['in_goods_id'].")";
		}
		if($condition_array['gc_id'] != ''){
			$condition_str .= " and gc_id ='".$condition_array['gc_id']."'";
		}
		if($condition_array['in_gc_id'] != ''){
			$condition_str .= " and gc_id in (".$condition_array['in_gc_id'].")";
		}
		if($condition_array['type_id'] != ''){
			$condition_str .= ' and type_id = "'.$condition_array['type_id'].'"';
		}
		if($condition_array['goods_class.type_id'] != ''){
			$condition_str .= ' and goods_class.type_id = "'.$condition_array['goods_class.type_id'].'"';
		}
		if($condition_array['in_type_id'] != ''){
			$condition_str .= ' and type_id in ('.$condition_array['in_type_id'].')';
		}	
		if($condition_array['in_sp_id'] != ''){
			$condition_str .= ' and sp_id in ('.$condition_array['in_sp_id'].')';
		}	
		if($condition_array['attr_id'] != ''){
			$condition_str .= ' and attr_id = "'.$condition_array['attr_id'].'"';
		}
		if($condition_array['in_attr_id'] != ''){
			$condition_str .= ' and attr_id in ('.$condition_array['in_attr_id'].')';
		}
		if($condition_array['brand_id'] != ''){
			$condition_str .= " and brand_id = '".$condition_array['brand_id']."'";
		}
		if($condition_array['sp_value_id'] != ''){
			$condition_str .= " and sp_value_id = '".$condition_array['sp_value_id']."'";
		}
		if($condition_array['attr_value_id'] != ''){
			$condition_str .= " and attr_value_id = '".$condition_array['attr_value_id']."'";
		}
		if ($condition_array['brand_apply'] != ''){
			$condition_str .= " and brand.brand_apply = '". $condition_array['brand_apply'] ."'";
		}
		if ($condition_array['attr_show'] != ''){
			$condition_str .= " and attr_show = '". $condition_array['attr_show'] ."'";
		}
		return $condition_str;
	}
}