<?php
/**
 * 商品推荐类型模型
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

class recommendModel{
	/**
	 * 类型列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getRecommendList($condition,$type="simple",$page=''){
		$condition_str = $this->_condition($condition);
		$param = array();
		switch($type){
			case 'simple':
				$param['table'] = 'recommend';
				$param['order'] = $condition['order'] ? $condition['order'] : 'recommend.recommend_id desc';
				break;
			case 'count':
				$param['table']	= 'recommend,recommend_goods';
				$param['field']	= 'recommend.*,count(recommend_goods.recommend_id) as count';
				$param['join_type']	= 'left join';
				$param['join_on']	= array('recommend.recommend_id=recommend_goods.recommend_id');
				$param['group']	= 'recommend.recommend_id';
				$param['order'] = $condition['order'] ? $condition['order'] : 'recommend.recommend_id desc';
		}
		$param['where'] = $condition_str;
		$result = Db::select($param,$page);
		return $result;
	}

	/**
	 * 构造检索条件
	 *
	 * @param int $id 记录ID
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	private function _condition($condition){
		$condition_str = '';
		if ($condition['recommend_id'] != ''){
			$condition_str .= " and recommend_id = '". intval($condition['recommend_id']) ."'";
		}
		if ($condition['no_recommend_id'] != ''){
			$condition_str .= " and recommend_id != '". intval($condition['no_recommend_id']) ."'";
		}
		if ($condition['recommend_name'] != ''){
			$condition_str .= " and recommend_name = '". $condition['recommend_name'] ."'";
		}
		if ($condition['like_recommend_name'] != ''){
			$condition_str .= " and recommend_name like '%". $condition['like_recommend_name'] ."%'";
		}
		if ($condition['home_index_recommend'] != ''){
			$condition_str .= " and recommend_id <= 9";
		}
		return $condition_str;
	}
	
	/**
	 * 取单个内容
	 *
	 * @param int $id ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneRecommend($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'recommend';
			$param['field'] = 'recommend_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function add($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('recommend',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function update($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$where = " recommend_id = '". $param['recommend_id'] ."'";
			$result = Db::update('recommend',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " recommend_id = '". intval($id) ."' and recommend_id > '1'";
			$result = Db::delete('recommend',$where);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 推荐商品列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $page 分页
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function getRecommendGoodsList($condition,$page=''){
		$condition_str = $this->_conditionGoods($condition);
		
		$param = array(
			'table'=>'recommend,recommend_goods,goods,store,brand',
			'field'=>'recommend.recommend_name,recommend.recommend_code,recommend_goods.*,goods.*,store.store_name,brand.brand_name',
			'where'=>$condition_str,
			'limit'=>$condition['limit'],
			'join_type'=>'left join',
			'join_on'=>array(
				'recommend.recommend_id=recommend_goods.recommend_id',
				'recommend_goods.goods_id=goods.goods_id',
				'goods.store_id=store.store_id',
				'goods.brand_id=brand.brand_id'
				
			),
			'order'=>$condition['order']
		);		
		$result = Db::select($param,$page);
		return $result;
	}
	
	/**
	 * 推荐商品列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $page 分页
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function getGoodsList($condition,$page=''){
		$condition_str = $this->_conditionGoods($condition);
		$param	= array();
		$param['table']	= 'recommend_goods,goods';
		$param['field'] = $condition['field'] ? $condition['field'] : 'recommend_goods.sort,goods.goods_id,goods.store_id,goods.goods_name,goods.goods_image,goods.goods_store_price';
		$param['where']	= $condition_str;
		$param['join_type']	= 'left join';
		$param['join_on']	= array('recommend_goods.goods_id=goods.goods_id');
		$param['order'] = $condition['order'] ? $condition['order'] : 'recommend_goods.sort asc,goods.goods_id desc';
		$param['limit'] = $condition['limit'] ? $condition['limit'] : 10;
		$result = Db::select($param,$page);
		return $result;
	}
	
	/**
	 * 根据条件查询推荐商品的数量
	 * 
	 * @param unknown_type $condition 检索条件
	 * $return int 整形数量结果
	 */
	public function getCount($condition){
		$condition_str	= $this->_conditionGoods($condition);
		
		$param	= array(
			'table'=>'recommend_goods',
			'field'=>'count(*) as count',
			'where'=>$condition_str
		);
		$result = Db::select($param,$page);
		return $result[0][0];
	}
	
	/**
	 * 构造推荐商品列表检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 字符串类型的返回结果
	 */
	private function _conditionGoods($condition){
		$condition_str = '';
		
		if ($condition['recommend_id'] != ''){
			$condition_str .= " and recommend_goods.recommend_id = '". $condition['recommend_id'] ."'";
		}
		if ($condition['goods_id'] != ''){
			$condition_str .= " and recommend_goods.goods_id = '". $condition['goods_id'] ."'";
		}
		if ($condition['recommend_code'] != ''){
			$condition_str	.= " and recommend.recommend_code='".$condition['recommend_code']."'";
		}
		if ($condition['in_recommend_code'] != ''){
			$condition_str	.= " and recommend.recommend_code in (".$condition['in_recommend_code'].")";
		}
		if ($condition['goods_show'] != ''){//上架:1是,0否
			$condition_str	.= " and goods.goods_show = '".$condition['goods_show']."'";
		}
		if ($condition['home_index_recommend'] != ''){
			$condition_str .= " and recommend_id <= 9";
		}
		return $condition_str;
	}
	
	/**
	 * 删除推荐商品信息
	 *
	 * @param int $recommend_id 推荐类型ID
	 * @param int $goods_id 商品ID
	 * @return bool 布尔类型的返回结果
	 */
	public function delRecommendGoods($recommend_id='',$goods_id=''){
		$where = '';
		if ($recommend_id != ''){
			$where .= " and recommend_id = '". intval($recommend_id) ."'";
		}
		if ($goods_id != ''){
			$where .= " and goods_id = '". intval($goods_id) ."'";
		}
		if ($where != ''){
			$result = Db::delete('recommend_goods',$where);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 增加推荐商品
	 *
	 * @param array $param 参数
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function addRecommendGoods($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('recommend_goods',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 更新推荐商品的排序
	 * 
	 * @param array $param 参数
	 * @return mix $result 返回mix类型的sql语句执行结果
	 */
	public function updateRecommendGoods($param){
		if(empty($param) or !is_array($param)){
			return false;
		}
		$condition_str	= $this->_conditionGoods($param);
		$update_array	= array(
			'sort'	=> $param['sort']
		);
		$result	= Db::update('recommend_goods',$update_array,$condition_str);
		return $result;
	}
}