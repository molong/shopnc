<?php
/**
 * 我的订单
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
class order_goodsModel {
	/**
	 * 订单商品列表
	 *
	 */
	public function getOrderGoodsList($param,$field='*',$page = '') {

		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$array['table']		= 'order_goods';
		$array['field']		= $field;
		$array['where'] 	= $condition_str;
		$array['order'] 	= $param['order']?$param['order']:"order_goods.rec_id";
		$order_goods_list	= Db::select($array,$page);
		return $order_goods_list;
	}

    /*
     *   根据id获取订单商品信息
     */
    public function getoneOrderGoods($rec_id) {
        
        $param = array() ;
    	$param['table'] = 'order_goods';
    	$param['field'] = 'rec_id' ;
    	$param['value'] = intval($rec_id);
    	return Db::getRow($param) ;

    }

	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if(!empty($condition_array['order_id'])) {
			$condition_sql	.= " and order_id='{$condition_array['order_id']}'";
		}
		if(!empty($condition_array['in_order_id'])) {
			$condition_sql	.= " and order_id in({$condition_array['in_order_id']})";
		}
		return $condition_sql;
	}
}
