<?php
/**
 * 店铺主题
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
class store_themeModel{
	/**
	 * 读取记录
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getRow($theme_id){
		$param	= array();
		$param['table']	= 'store_theme';
		$param['field']	= 'theme_id';
		$param['value']	= $theme_id;
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
		$param['table'] = 'store_theme';
		$param['where']	= $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'theme_id desc';
		$param['limit'] = $condition['limit'];
		$result = Db::select($param,$page);
		return $result;
	}
	
	/**
	 * 主题配置信息
	 *
	 * @return array 数组格式的返回结果
	 */
	public function getStyleConfig(){
		$style_data = array();
		$style_configurl = BASE_TPL_PATH.DS.'store'.DS.'style'.DS."styleconfig.php";
		if (file_exists($style_configurl)){
			include_once($style_configurl);
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$style_data = Language::getGBK($style_data);
		}
		return $style_data;
	}
	
	/**
	 * 主题是否可编辑(1为可自定主题)
	 *
	 */
	public function getShowStyle($style_id = 'default'){
		$style_data = array(
			'default' => 0,
			'style1' => 0,
			'style2' => 0,
			'style3' => 0,
			'style4' => 0,
			'style5' => 0,
			'style6' => 1,
			'style7' => 1,
			'style8' => 1,
			'style9' => 1,
			'style10' => 1
			);
		return $style_data[$style_id];
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
			$result = Db::insert('store_theme',$param);
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
		$theme_id = $condition['theme_id'];
		if (intval($theme_id) < 1){
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$where = $condition_str;
		if (is_array($param)){
			$result = Db::update('store_theme',$param,$where);
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
		$theme_id = $condition['theme_id'];
		if (intval($theme_id) < 1){
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$where = $condition_str;
		if (is_array($condition)){
			$result = Db::delete('store_theme',$where);
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
		if($condition_array['theme_id'] !== null) {
			$condition_sql	.= " and theme_id = '".$condition_array['theme_id']."'";
		}
		if($condition_array['store_id'] !== null) {
			$condition_sql	.= " and store_id = '".$condition_array['store_id']."'";
		}
		if($condition_array['member_id'] !== null) {
			$condition_sql	.= " and member_id = '".$condition_array['member_id']."'";
		}
		if($condition_array['style_id'] !== null) {
			$condition_sql	.= " and style_id = '".$condition_array['style_id']."'";
		}
		if($condition_array['show_page'] !== null) {
			$condition_sql	.= " and show_page = '".$condition_array['show_page']."'";
		}
		return $condition_sql;
	}
	
}