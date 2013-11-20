<?php
/**
 * 规格管理
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

class specModel {
	/**
	 * 规格列表
	 * @param	array	$param 规格资料
	 * @param	object	$page
	 * @param	string	$field
	 */
	public function specList($param, $page = '', $field = '*') {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= 'spec';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$array['order']		= $param['order'];
		$list_spec		= Db::select($array, $page);
		return $list_spec;
	}
	/**
	 * 更新规格信息
	 * @param	array $update 更新数据
	 * @param	array $param 条件
	 * @param	string $table 表名
	 * @return	bool
	 */
	public function specUpdate($update, $param, $table){
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
	 * 添加规格信息
	 * @param	array	$param	一维数组
	 * @param	array	$param_value 二维数组
	 * @param	array	$files	二维数组
	 * @return bool
	 */
	public function apecAdd($param, $param_value, $files){
		
		/**
		 * 规格表插入数据
		 */
		$sp_id = Db::insert('spec', $param);
		
		/**
		 * 规格值表
		 */
		$condition = '';
		if(!$sp_id){
			return false;
		}
		if(is_array($param_value) && !empty($param_value)){
			
			$string_value = '';
			$upload = new UploadFile();
			$upload->set('default_dir',ATTACH_SPEC);
			$upload->set('thumb_width',	'16');
			$upload->set('thumb_height','16');
			$upload->set('thumb_ext',	'_small');
			$upload->set('ifremove',	true);			
			foreach ($param_value as $k=>$val) {
				$upload->set('file_name','');
				$val['name']	= trim($val['name']);
				$val['sort']	= intval($val['sort']);
				
				/**
				 * 图片上传
				 */
				$val['image'] = '';
				if($_POST['s_dtype'] == 'image'){
					if(!empty($files['s_value_'.$k]['name'])){
						$upload->error = '';
						$return = $upload->upfile('s_value_'.$k);
						if ($return){
							$val['image'] = $upload->thumb_image;
						}else{
							echo $upload->error;exit('a');
							showMessage($upload->error,'','','error');
						}
					}else{
						return false;
					}
				}
				if($val['name'] != ''){
					$condition .= '("' .$val['name'] .'", "'. $sp_id .'", "'. $val['image'] .'", "'. $val['sort'] .'"),';
				}
				$string_value	.= $val['name'].',';
			}
			$condition = rtrim($condition,',');
			if($condition != ''){
				$return = Db::query("insert into `".DBPRE."spec_value` (`sp_value_name`, `sp_id`, `sp_value_image`, `sp_value_sort`) values ".$condition);
				if($return){
					/**
					 * 更新规格，规格值序列化
					 */
					Db::query("update `".DBPRE."spec` set sp_value = '".rtrim($string_value,',')."' where sp_id = '".$sp_id."'");
				}
			}
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function specValueAdd($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('spec_value',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 规格值列表
	 * @param	array	$param 商品资料
	 * @param	object	$page
	 * @param	string	$field
	 * @return	array
	 */
	public function specValueList($param, $page = '', $field = '*') {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= 'spec_value';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$array['order']		= $param['order'];
		$list_spec		= Db::select($array, $page);
		return $list_spec;
	}
	/**
	 * 规格值
	 * @param	array	$param 商品资料
	 * @param	array	$field
	 * @return   一维数组
	 */
	public function specValueOne($param, $field = '*') {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['table']		= 'spec_value';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$list_spec		= Db::select($array);
		return $list_spec['0'];
	}
	/**
	 * 删除规格
	 * 
	 * @param 表名 spec,spec_value
	 * @param 一维数组
	 * @return bool
	 */
	public function delSpec($table,$param){
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
		if($condition_array['sp_id'] != ''){
			$condition_str .= ' and sp_id = "'.$condition_array['sp_id'].'"';
		}
		if($condition_array['in_sp_id'] != ''){
			$condition_str .= ' and sp_id in ('.$condition_array['in_sp_id'].')';
		}
		if($condition_array['sp_value_id'] != ''){
			$condition_str .= ' and sp_value_id = "'.$condition_array['sp_value_id'].'"';
		}
		if($condition_array['in_sp_value_id'] != ''){
			$condition_str .= ' and sp_value_id in ('.$condition_array['in_sp_value_id'].')';
		}
		return $condition_str;
	}
}