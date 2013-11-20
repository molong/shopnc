<?php
/**
 * 满即送套餐模型 
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
class p_mansong_quotaModel{

    const TABLE_NAME = 'p_mansong_quota';
    const PK = 'quota_id';

	/**
	 * 构造检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 
	 */
	private function getCondition($condition){
		$condition_str = '';
        if(!empty($condition['quota_id'])){
            $condition_str .= " and quota_id = '".$condition['quota_id'] ."'";
        }
        if(!empty($condition['in_quota_id'])) {
            $condition_str .= " and quota_id in (".$condition['in_quota_id'].")";
        }
        if(!empty($condition['store_name'])) {
            $condition_str .= " and store_name like '%".$condition['store_name'] ."%'";
        }
        if(!empty($condition['state'])) {
            $condition_str .= " and state = '".$condition['state']."'";
        }
        if(!empty($condition['store_id'])) {
            $condition_str .= " and store_id = '".$condition['store_id']."'";
        }
        if(!empty($condition['greater_than_start_time'])) {
            $condition_str .= " and start_time < '".$condition['greater_than_start_time']."'";
        }
        if(!empty($condition['less_than_start_time'])) {
            $condition_str .= " and start_time > '".$condition['less_than_start_time']."'";
        }
        if(!empty($condition['less_than_end_time'])) {
            $condition_str .= " and end_time > '".$condition['less_than_end_time']."'";
        }
        if(!empty($condition['greater_than_end_time'])) {
            $condition_str .= " and end_time < '".$condition['greater_than_end_time']."'";
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
     * 当前可用套餐
     **/
    public function getCurrent($store_id) {
        $param = array();
        $current_time = time();
        $param['greater_than_start_time'] = $current_time; 
        $param['less_than_end_time'] = $current_time; 
        $param['store_id'] = $store_id;
        $param['state'] = 1;
        $list = $this->getList($param);
        return $list[0];
    }

    /**
     * 下期可用套餐
     **/
    public function getNext($store_id) {
        $param = array();
        $current_time = time();
        $param['less_than_start_time'] = $current_time; 
        $param['store_id'] = $store_id;
        $param['state'] = 1;
        $param['limit'] = 1;
        $param['order'] = 'start_time asc';
        $list = $this->getList($param);
        return $list[0];
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
	
		return Db::insert(self::TABLE_NAME,$param) ;
	
	}
	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
	public function save_array($param_array){
	
		return Db::insertAll(self::TABLE_NAME,$param_array) ;
	
	}
	

	/*
	 * 更新
	 * @param array $update_array
	 * @param array $where_array
	 * @return bool
	 */
	public function update($update_array, $where_array){
	
		$where = $this->getCondition($where_array) ;
		return Db::update(self::TABLE_NAME,$update_array,$where) ;
    
    }
	
	/*
	 * 删除
	 * @param array $param
	 * @return bool
	 */
	public function drop($param){

		$where = $this->getCondition($param) ;
		return Db::delete(self::TABLE_NAME, $where) ;
	}
	
}
