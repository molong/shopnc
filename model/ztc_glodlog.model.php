<?php
/**
 * 直通车金币日志管理
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

class ztc_glodlogModel {
	/**
	 * 添加直通车申请信息
	 *
	 * @param array $param 添加信息数组
	 */
	public function addlog($param) {
		if(empty($param)) {
			return false;
		}
		$result	= Db::insert('ztc_glodlog',$param);
		return $result;
	}
	/**
	 * 直通车申请信息列表
	 *
	 * @param array $condition 条件数组
	 * @param array $page   分页
	 * @param array $field   查询字段
	 * @param array $page   分页  
	 */
	public function getLogList($condition,$page='',$field='*'){
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		$param['table']	= 'ztc_glodlog';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'ztc_glodlog.glog_id desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 直通车申请信息单条
	 *
	 * @param array $condition 条件数组
	 * @param array $field   查询字段
	 */
	/*public function getZtcInfo($condition,$field='*'){
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$array			= array();
		$array['table']	= 'ztc_goods';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$goods_info		= Db::select($array);
		return $goods_info[0];
	}	*/
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		//直通车金币日志商品名称
		if ($condition_array['glog_goodsname']) {
			$condition_sql	.= " and `ztc_glodlog`.glog_goodsname like '%{$condition_array['glog_goodsname']}%'";
		}
		if ($condition_array['glog_type']){
			$condition_sql	.= " and `ztc_glodlog`.glog_type = '{$condition_array['glog_type']}'";
		}
		if ($condition_array['glog_storeid']) {
			$condition_sql	.= " and `ztc_glodlog`.glog_storeid = '{$condition_array['glog_storeid']}'";
		}
		if ($condition_array['glog_storename']) {
			$condition_sql	.= " and `ztc_glodlog`.glog_storename like '%{$condition_array['glog_storename']}%'";
		}
		if ($condition_array['saddtime']){
			$condition_sql	.= " and `ztc_glodlog`.glog_addtime >= '{$condition_array['saddtime']}'";
		}
		if ($condition_array['eaddtime']){
			$condition_sql	.= " and `ztc_glodlog`.glog_addtime <= '{$condition_array['eaddtime']}'";
		}
		return $condition_sql;
	}
}