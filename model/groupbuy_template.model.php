<?php
/**
 * 团购活动模型
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
class groupbuy_templateModel{

    const TABLE_NAME = 'groupbuy_template';
    const PK = 'template_id';

    /**
     * 构造检索条件
     *
     * @param array $condition 检索条件
     * @return string 
     */
    private function getCondition($condition){
        $condition_str = '';
        if (!empty($condition['state'])){
            $condition_str .= "AND state = '".$condition['state']."'";
        }
        if (!empty($condition['template_id'])){
            $condition_str .= "AND template_id = '".$condition['template_id']."'";
        }
        if (!empty($condition['in_template_id'])){
            $condition_str .= " AND template_id in (". $condition['in_template_id'] .")";
        }
        if (!empty($condition['less_than_join_end_time'])){
            $condition_str .= "AND join_end_time > '".$condition['less_than_join_end_time']."'";
        }
        if (!empty($condition['less_than_start_time'])){
            $condition_str .= "AND start_time > '{$condition['less_than_start_time']}'";
        }
        if (!empty($condition['greater_than_end_time'])){
            $condition_str .= "AND end_time < '{$condition['greater_than_end_time']}'";
        }
        if (!empty($condition['in_progress'])){
            $condition_str .= "AND start_time < '{$condition['in_progress']}' AND end_time > '{$condition['in_progress']}'";
        }

        return $condition_str;
    }

    /**
     * 读取列表 
     *
     */
    public function getList($condition = array(), $page = '', $field = '*'){
        $param = array() ;
        $param['table'] = self::TABLE_NAME ;
        $param['where'] = $this->getCondition($condition);
        $param['field'] = $field;
        $param['order'] = $condition['order'] ? $condition['order']: ' '.self::PK.' desc ';
        $param['limit'] = $condition['limit'];
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

    /**
     * 获取最后的结束时间
     *
     * @param int $groupbuy_area_id 地区ID
     * @return array 数组类型的返回结果
     */
    public function getMaxEndTime(){

        $max_end_time = $this->getList(array(),'','MAX(end_time) as max_end_time');
        return $max_end_time[0]['max_end_time']; 
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
