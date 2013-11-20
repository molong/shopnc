<?php
/**
 * 限时折扣活动商品模型 
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
class p_xianshi_goodsModel{

    const TABLE_NAME = 'p_xianshi_goods';
    const PK = 'xianshi_goods_id';

	/**
	 * 构造检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 
	 */
	private function getCondition($condition){
		$condition_str = '';
        if (!empty($condition['xianshi_goods_id'])){
            $condition_str .= " and xianshi_goods_id = '".$condition['xianshi_goods_id'] ."'";
        }
        if (!empty($condition['xianshi_id'])){
            $condition_str .= " and xianshi_id = '".$condition['xianshi_id'] ."'";
        }
        if (!empty($condition['quota_id'])){
            $condition_str .= " and quota_id = '".$condition['quota_id'] ."'";
        }
        if (!empty($condition['goods_id'])){
            $condition_str .= " and goods_id = '".$condition['goods_id'] ."'";
        }
        if (!empty($condition['state'])){
            $condition_str .= " and state = '".$condition['state'] ."'";
        }
		return $condition_str;
	}

	/**
	 * 读取列表 
	 *
	 */
	public function getList($condition,$page='',$field='*'){

        $param = array() ;
        $param['table'] = self::TABLE_NAME ;
        $param['where'] = $this->getCondition($condition);
        $param['order'] = $condition['order'] ? $condition['order']: ' state asc,'.self::PK.' desc';
        $param['limit'] = $condition['limit'];
        $param['field'] = $field;
        return Db::select($param,$page);
	}

    /**
	 * 根据编号获取单个内容
	 *
	 * @param int $groupbuy_area_id 地区ID
	 * @return array 数组类型的返回结果
	 */
	public function getOne($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = self::TABLE_NAME;
			$param['field'] = self::PK;
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}

	/*
	 *  判断是否存在 
	 *  @param array $condition
	 *  @param obj $page 	//分页对象
	 *  @return array
	 */
	public function isExist($condition='') {

        $param = array() ;
        $param['table'] = self::TABLE_NAME ;
        $param['where'] = $this->getCondition($condition);
        $list = Db::select($param);
        if(empty($list)) {
            return false;
        }
        else {
            return true;
        }
	}

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
	public function save($param){
	
		return Db::insert(self::TABLE_NAME,$param);
	
	}
	
	/*
	 * 更新
	 * @param array $update_array
	 * @param array $where_array
	 * @return bool
	 */
	public function update($update_array, $where_array){
	
		$where = $this->getCondition($where_array);
		return Db::update(self::TABLE_NAME,$update_array,$where);
    
    }
	
	/*
	 * 删除
	 * @param array $param
	 * @return bool
	 */
	public function drop($param){

		$where = $this->getCondition($param);
		return Db::delete(self::TABLE_NAME, $where);
	}

    /**
     * 统计数量
	 * @param array $param
     * @return count
     **/
    public function getCount($param) {
        
        $list = $this->getList($param,'','count(*) as count');
        return $list[0]['count'];
    }
	
}
