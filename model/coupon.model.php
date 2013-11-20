<?php 
/**
 * 优惠券
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
class couponModel{
     /*
      * 根据店铺id
      * 
      * @param int $store_id 店铺id
      * @param obj $page
      * @return array 
      */
     public function getCouponByStoreId($store_id,$page){
     
           $param = array(
           
                'table'=>'coupon',
                'filed'=>'*',
                'where'=>$this->_condition(array('store_id'=>$store_id)) ,
                'order'=>'coupon_start_date' 
                         
           ) ;

           $result = Db::select($param,$page);
           return  $result;
     
     }
     
     /*
      * 构造条件
      * 
      * @param array $condition 
      * @return string 
      */
     private function _condition($condition){

     	   $condition_str = '' ;
           $condition['store_id'] != '' && $condition_str .= " and store_id = '".intval($condition['store_id'])."'";
           $condition['store_name'] != '' && $condition_str .= " and `store`.store_name like '%".$condition['store_name']."%'" ;
		   $condition['coupon_id'] != '' && $condition_str .= " and coupon_id = '".intval($condition['coupon_id'])."'";
		   $condition['coupon_state'] != '' && $condition_str .= " and coupon_state = '".$condition['coupon_state']."'";
		   isset($condition['coupon_recommend']) && $condition_str .= " and coupon_recommend = '".$condition['coupon_recommend']."'";
		   $condition['coupon_lock'] != '' && $condition_str .= " and coupon_lock = '".$condition['coupon_lock']."'";
           //$condition['coupon_id_in'] !='' && $condition_str .= " and coupon_id in (".$condition['coupon_id_in'].")" ;
           $condition['coupon_novalid'] != '' && $condition_str .= " and coupon_end_date < '".time()."'";//已经结束的优惠券
           $condition['coupon_valid'] != '' && $condition_str .= " and coupon_end_date >= '".time()."'";//有效期内的优惠券
     	   $condition['time_from'] != '' && $condition_str	.= " and coupon_start_date >= '".$condition['time_from']."'";
		   $condition['time_to'] != '' && $condition_str	.= " and coupon_end_date <= '".$condition['time_to']."'";
		   $condition['coupon_name_like'] != '' && $condition_str	.= " and coupon_title like '%".$condition['coupon_name_like']."%'";
		   $condition['coupon_class'] != '' && $condition_str	.= " and coupon_class_id = ".intval($condition['coupon_class']);
		   $condition['coupon_allowstate'] != '' && $condition_str	.= " and coupon_allowstate = '".$condition['coupon_allowstate']."'";
		   $condition['coupon_allowstate2'] != '' && $condition_str	.= " and coupon_allowstate <> '1'";
		   if (isset($condition['coupon_id_in'])){
		   		if ($condition['coupon_id_in'] == ''){
		   			$condition_str	.= " and coupon_id in('') ";
		   		}else {
		   			$condition_str	.= " and coupon_id in({$condition['coupon_id_in']}) ";
		   		}
		   }
           return $condition_str ;
         
     }
      
     /*
      * 增加优惠券
      * 
      * @param array $param 
      * @return bool
      */

    public function add_coupon($param){    
    	if(!empty($param)){
			return Db::insert('coupon',$param) ;    	 	
    	}    	
    	return false ;    
    }
    
    /*
     * 删除优惠券
     * 
     * @param array $param
     * @return bool
     */
    
    public function del_coupon($param){
    	if(!empty($param)){
    		$where = $this->_condition($param) ;
	    	return Db::delete('coupon', $where) ;
    	}
    	return false ;   
    }
	
    /*
     * 得到优惠券
     * 
     * @param array $where_array
     * @param page obj $page
     * @param string $type //连表类型
     * @return array
     */
    
    public function getCoupon($where_array,$page='',$type='simple'){
    	if($type=='simple'){
	    	$param = array() ;
	    	$param['table'] = 'coupon' ;
	    	$param['where'] = $this->_condition($where_array) ;
	    	$param['group'] = $where_array['group'];
			$param['order'] = $where_array['order'] ? $where_array['order']: ' coupon_id desc ';
			$where_array['limit'] !='' && $param['limit'] = $where_array['limit'] ;
    	}elseif($type=='store'){	//连表查询store
    		$param = array() ;
    		$param['table'] = 'coupon,store';
    		$param['join_type'] = 'left join';
    		$param['join_on'] = array('coupon.store_id=store.store_id');
    		$param['field'] = 'coupon.*,store.store_name,store.description,store.store_logo,store.store_domain';
    		$param['where'] = $this->_condition($where_array) ;
    		$param['order'] = $where_array['order'] ? $where_array['order']: ' coupon_id desc ';
    		$where_array['limit'] !='' && $param['limit'] = $where_array['limit'] ;
    	}
    	
    	$result = Db::select($param, $page) ;
    	return $result ; 
    }
    /*
     * 根据ID得到优惠券
     * 
     * @param int $coupon_id
     * @return array
     */
    
    public function getOneById($coupon_id){
    
    	if(intval($coupon_id)>0){
    	
	    	$param = array() ;
	    	$param['table'] = 'coupon';
	    	$param['field'] = 'coupon_id' ;
	    	$param['value'] = intval($coupon_id) ;
	    	return Db::getRow($param) ;
	    	    	
    	}
    	
    	return false ;
    
    }

    /*
     * 判断优惠券是否属于指定店铺
     *
     * @param int $coupon_id
     * @param int $store_id
     * @return bool
     */
    public function checkCouponBelongStore($coupon_id,$store_id) {

        $coupon_info = self::getOneById($coupon_id);
        if(!empty($coupon_info) && intval($coupon_info['store_id']) === intval($store_id)) {
            return true;
        }
        else {
            return false;
        }
    }
 
    /*
     * 更新优惠券
     * 
     * @param array $update
     * @param array $where_array
     * @return bool
     */
    
    public function update_coupon($update,$where_array){
    
    	$where = $this->_condition($where_array) ; 	
    	return Db::update('coupon',$update,$where) ;
  
    }

}
