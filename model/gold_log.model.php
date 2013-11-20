<?php
/**
 * 金币日志记录
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
class gold_logModel{
	/**
	 * 读取金币日志记录
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getRow($glog_id){
		$param	= array();
		$param['table']	= 'gold_log';
		$param['field']	= 'glog_id';
		$param['value']	= $glog_id;
		$result	= Db::getRow($param);
		return $result;
	}
	
	/**
	 * 读取金币日志记录列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getList($condition = '',$page = ''){
		$condition_str = $this->getCondition($condition);
		$param = array();
		$param['table'] = 'gold_log';
		$param['where']	= $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'glog_id desc';
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
			$result = Db::insert('gold_log',$param);
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
		if($condition_array['glog_id'] != '') {
			$condition_sql	.= " and glog_id = '".$condition_array['glog_id']."'";
		}
		if($condition_array['glog_memberid'] != '') {
			$condition_sql	.= " and glog_memberid = '".$condition_array['glog_memberid']."'";
		}
		if($condition_array['membername_like'] != '') {
			$condition_sql	.= " and glog_membername like '%{$condition_array['membername_like']}%'";
		}
		if($condition_array['storename_like'] != '') {
			$condition_sql	.= " and glog_storename like '%{$condition_array['storename_like']}%'";
		}
		if($condition_array['glog_method'] != '') {
			$condition_sql	.= " and glog_method = '".$condition_array['glog_method']."'";
		}
		if($condition_array['glog_stage'] != '') {
			$condition_sql	.= " and glog_stage = '".$condition_array['glog_stage']."'";
		}
		if($condition_array['add_time_from'] != ''){
			$condition_sql	.= " and glog_addtime >= '".$condition_array['add_time_from']."'";
		}
		if($condition_array['add_time_to'] != ''){
			$condition_sql	.= " and glog_addtime <= '".$condition_array['add_time_to']."'";
		}
		return $condition_sql;
	}
	
}