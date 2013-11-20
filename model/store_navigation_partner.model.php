<?php
/**
 * 店铺导航, 合作伙伴管理
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
class store_navigation_partnerModel {	
	/**
	 * 删除合作伙伴
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function delPartner($id){
		if (intval($id) > 0 && $this->checkPartner($_SESSION['store_id'],$id)){
			$where = " sp_id = '". intval($id) ."'";
			$result = Db::delete('store_partner',$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 验证合作伙伴
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function checkPartner($sp_store_id,$sn_id) {
		/**
		 * 验证是否为当前合作伙伴
		 */
		$condition = array(
			'sp_store_id'=>$sp_store_id,
			'sp_id'=>$sn_id
		);
		$check_array = $this->getPartnerList($condition);
		if (!empty($check_array)){
			unset($check_array);
			return true;
		}
		unset($check_array);
		return false;
	}
	/**
	 * 更新合作伙伴
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function updatePartner($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param) && $this->checkPartner($_SESSION['store_id'],$param['sp_id'])){
			$tmp = array(
				'sp_title'=>$param['sp_title'],
				'sp_link'=>$param['sp_link'],
				'sp_sort'=>empty($param['sp_sort'])?255:$param['sp_sort'],
				'sp_logo'=>$param['sp_logo']
			);
			$where = " sp_id = '". $param['sp_id'] ."'";
			$result = Db::update('store_partner',$tmp,$where);
			unset($tmp);
			return $result;
		}else {
			return false;
		}
	}	
	/**
	 * 新增合作伙伴
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addPartner($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array(
				'sp_title'=>$param['sp_title'],
				'sp_sort'=>empty($param['sp_sort'])?255:$param['sp_sort'],
				'sp_link'=>$param['sp_link'],
				'sp_store_id'=>$_SESSION['store_id'],
				'sp_logo'=>$param['sp_logo']
			);
			$result = Db::insert('store_partner',$tmp);
			unset($tmp);
			return $result;
		}else {
			return false;
		}
	}	
	/**
	 * 取单个合作伙伴
	 *
	 * @param int $id 分类ID
	 * @return array 数组类型的返回结果
	 */
	public function getOnePartner($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'store_partner';
			$param['field'] = 'sp_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 获取合作伙伴列表
	 *
	 * @param	array $param 导航条件
	 * @param	string $field 显示字段
	 * @return	array 数组格式的返回结果
	 */
	public function getPartnerList($condition = ''){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'store_partner';
		$param['where'] = $condition_str;
		$param['order'] = 'sp_sort';
		$result = Db::select($param);
		return $result;
	}
	/**
	 * 验证店铺导航
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function checkNavigation($sn_store_id,$sn_id) {
		/**
		 * 验证是否为当前店铺导航
		 */
		$condition = array(
			'sn_store_id'=>$sn_store_id,
			'sn_id'=>$sn_id
		);
		$check_array = $this->getNavigationList($condition);
		if (!empty($check_array)){
			unset($check_array);
			return true;
		}
		unset($check_array);
		return false;
	}
	/**
	 * 取单个店铺导航
	 *
	 * @param int $id 分类ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneNavigation($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'store_navigation';
			$param['field'] = 'sn_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 获取店铺导航列表
	 *
	 * @param	array $param 导航条件
	 * @param	string $field 显示字段
	 * @return	array 数组格式的返回结果
	 */
	public function getNavigationList($condition = ''){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'store_navigation';
		$param['where'] = $condition_str;
		$param['order'] = 'sn_sort';
		$result = Db::select($param);
		return $result;
	}
	/**
	 * 新增店铺导航
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addNavigation($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array(
				'sn_title'=>$param['sn_title'],
				'sn_content'=>$param['sn_content'],
				'sn_sort'=>empty($param['sn_sort'])?255:$param['sn_sort'],
				'sn_if_show'=>$param['sn_if_show'],
			    'sn_url'=>$param['sn_url'],
			    'sn_new_open'=>$param['sn_new_open'],
				'sn_store_id'=>$_SESSION['store_id'],
				'sn_add_time'=>time()
			);
			$result = Db::insert('store_navigation',$tmp);
			unset($tmp);
			return $result;
		}else {
			return false;
		}
	}	
	/**
	 * 更新店铺导航
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function updateNavigation($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param) && $this->checkNavigation($_SESSION['store_id'],$param['sn_id'])){
			$tmp = array(
				'sn_title'=>$param['sn_title'],
				'sn_content'=>$param['sn_content'],
				'sn_sort'=>empty($param['sn_sort'])?255:$param['sn_sort'],
				'sn_if_show'=>$param['sn_if_show'],
			    'sn_url'=>$param['sn_url'],
			    'sn_new_open'=>$param['sn_new_open']
			);
			$where = " sn_id = '". $param['sn_id'] ."'";
			$result = Db::update('store_navigation',$tmp,$where);
			unset($tmp);
			return $result;
		}else {
			return false;
		}
	}	
	/**
	 * 删除店铺导航
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function delNavigation($id){
		if (intval($id) > 0){
			$where = " sn_id = '". intval($id) ."'";
			$result = Db::delete('store_navigation',$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 构造检索条件
	 *
	 * @param int $id 记录ID
	 * @return string 字符串类型的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';
		
		if (is_array($condition)){
			foreach ($condition as $key=>$value){
				$field = "`".$key."`";
				if ($value != ''){
					switch ($key){
						case 'sn_id':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
						case 'sn_title':
							$condition_str .= " and {$field} = '$value'";break;
						case 'sn_store_id':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
						case 'sn_content':
							$condition_str .= " and {$field} = '". $value ."'";break;
						case 'sn_sort':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
						case 'sn_if_show':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
						case 'sn_add_time':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
						case 'sp_id':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
						case 'sp_store_id':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
						case 'sp_title':
							$condition_str .= " and {$field} = '". $value ."'";break;
						case 'sp_link':
							$condition_str .= " and {$field} = '". $value ."'";break;
						case 'sp_logo':
							$condition_str .= " and {$field} = '". $value ."'";break;
						case 'sp_sort':
							$condition_str .= " and {$field} = '". intval($value)."'";break;
					}
				}
			}
		}
		
		return $condition_str;
	}
}