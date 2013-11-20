<?php
/**
 * 金币支付方式
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
class gold_paymentModel{
	/**
	 * 读取支付方式信息
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getRow($payment_id){
		$param	= array();
		$param['table']	= 'gold_payment';
		$param['field']	= 'payment_id';
		$param['value']	= $payment_id;
		$result	= Db::getRow($param);
		return $result;
	}
	/**
	 * 读取支付方式信息by code
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getRowByCode($payment_code){
		$param	= array();
		$param['table']	= 'gold_payment';
		$param['field']	= 'payment_code';
		$param['value']	= $payment_code;
		$result	= Db::getRow($param);
		return $result;
	}
	/**
	 * 读取支付方式信息by Condition
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getRowByCondition($conditionfield,$conditionvalue){
		$param	= array();
		$param['table']	= 'gold_payment';
		$param['field']	= $conditionfield;
		$param['value']	= $conditionvalue;
		$result	= Db::getRow($param);
		return $result;
	}
	/**
	 * 读取支付方式列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getList($condition = array()){
		$condition_str = $this->getCondition($condition);
		$param = array();
		$param['table'] = 'gold_payment';
		$param['where']	= $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'payment_state';
		$param['limit'] = '9';
		$result = Db::select($param);
		return $result;
	}
	
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function update($payment_id,$param){
		if (intval($payment_id) < 1){
			return false;
		}
		$where = " payment_id = '". $payment_id ."'";
		if (is_array($param)){
			$result = Db::update('gold_payment',$param,$where);
			return result;
		}else {
			return false;
		}
	}
	/**
	 * 支付方式安装情况
	 *
	 * @param
	 * @return bool 布尔类型的返回结果
	 */
	public function checkPayment($payment_code) {
		$payment_info = $this->getRowByCode($payment_code);
		if (empty($payment_info)){
			return false;
		}
		if ($payment_info['payment_state'] == '1'){
			return true;
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
		if($condition_array['payment_id'] != '') {
			$condition_sql	.= " and `gold_payment`.payment_id = '".$condition_array['payment_id']."'";
		}
		if($condition_array['payment_state'] != '') {
			$condition_sql	.= " and `gold_payment`.payment_state = '".$condition_array['payment_state']."'";
		}
		if($condition_array['payment_code'] != '') {
			$condition_sql	.= " and `gold_payment`.payment_code = '".$condition_array['payment_code']."'";
		}
		return $condition_sql;
	}
	
}