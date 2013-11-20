<?php
/**
 * 购物车管理
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
class cartModel {
	/**
	 * 检查购物车内商品是否存在
	 *
	 * @param	
	 */
	public function checkCart($param, $fields = '*') {
		$cart_info	= array();
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$array			= array();
		$array['table']	= 'cart';
		$array['where']	= $condition_str;
		$array['field']	= $fields;
		$cart_info		= Db::select($array);
		return $cart_info;
	}
	/**
	 * 将商品添加到购物车中
	 *
	 * @param	array	$param	商品数据信息
	 */	
	public function addCart($param) {
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('cart',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 更新购物车 
	 *
	 * @param	array	$param 商品信息
	 */	
	public function updateCart($param,$condition) {
		$array			= array();
		//得到条件语句
		$condition_str		= $this->getCondition($condition);
		$result	= Db::update('cart',$param,$condition_str);
		return $result;
	}
	/**
	 * 购物车列表 
	 *
	 * @param	int	$store_id 店铺id
	 */	
	public function listCart($store_id='') {
		if ($_SESSION['member_id'] == '') {
			return ;
		}
		$where	= '';
		if($store_id != '') {
			$where	= " and cart.store_id= '$store_id'";
		}
		$cart_list	= array();
		$array		= array();
		$array['table'] = 'cart,store';
		$array['field'] = 'cart.*,store_name';
		$array['join_type']= 'LEFT JOIN';
		$array['join_on']= array('cart.store_id=store.store_id');
		$array['where'] = " where cart.member_id='{$_SESSION['member_id']}'".$where;
		$cart_list	= Db::select($array);
		return $cart_list;
	}
	/**
	 * 购物车删除商品 
	 *
	 * @param	int	$cart_id 购物车对应id
	 */		
	public function dropCart($cart_id) {
		if(intval($cart_id) != 0) {
			$where = " cart_id = '".intval($cart_id)."' and member_id= '{$_SESSION['member_id']}'";
			$result = Db::delete('cart',$where);
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * 购物车删除商品 
	 *
	 * @param	int	$cart_id 购物车对应id
	 */		
	public function dropCartByCondition($condition_arr) {
		$condition_str = $this->getCondition($condition_arr);
		$result = Db::delete('cart',$condition_str);
		return $result;
	}
	/**
	 * 购物车商品种类数 
	 *
	 */		
	public function countCart($condition_arr) {
		$condition_str = $this->getCondition($condition_arr);
		$array		= array();
		$array['table'] = 'cart';
		$array['field'] = 'count(*) as countnum';
		$array['where'] = $condition_str;
		$cart_goods = Db::select($array);
		return $cart_goods[0]['countnum'];
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if($condition_array['cart_spec_id'] != '') {
			$condition_sql	.= " and spec_id= '{$condition_array['cart_spec_id']}'";
		}
		if($condition_array['cart_member_id'] != '') {
			$condition_sql	.= " and member_id= '{$condition_array['cart_member_id']}'";
		}
		//用于购物车中检查是否存在特定店铺的商品
		if($condition_array['spec_store_id'] != '') {
			$condition_sql	.= " and store_id= '{$condition_array['spec_store_id']}'";
		}
		return $condition_sql;
	}
}

