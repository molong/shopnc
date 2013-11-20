<?php
/**
 * 订单管理
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
class orderModel{

	private $product_sn;	//订单编号


	/**
	 * 购物车商品加入订单
	 *
	 * @param	array	$param	购物车商品信息，加入订单表后会删除购物车内的信息
	 * @return bool
	 */
	public function addOrder($param) {
		if(is_array($param) and !empty($param)) {
			return Db::insert('order',$param);
		} else {
			return false;
		}
	}
	/**
	 * 订单配送地址添加
	 *
	 * @param	array	$param	订单配送地址信息
	 * @return bool
	 */
	public function addAddressOrder($param) {
		if(is_array($param) and !empty($param)) {
			return Db::insert('order_address',$param);
		} else {
			return false;
		}
	}
	/**
	 * 订单商品添加
	 *
	 * @param	array	$param	订单商品信息
	 * @return bool
	 */
	public function addGoodsOrder($param) {
		if(is_array($param) and !empty($param)) {
			return Db::insert('order_goods',$param);
		} else {
			return false;
		}
	}
	/**
	 * 店铺的订单商品列表，卖家订单商品
	 *
	 */
	public function OrderGoodsList($param,$obj_page='',$field='*') {
		$array		= array();
		$condition_str	= $this->getCondition($param);
		$array['table']		= 'order,order_goods,store,order_address';
		$array['field']		= '`order`.*,`order_goods`.*,`store`.*,`order_address`.*';
		$array['join_type']	= 'LEFT JOIN';
		$array['join_on']	= array('order.order_id=order_goods.order_id','order.store_id=store.store_id','order.order_id=order_address.order_id');
		$array['where'] 	= $condition_str;
		$array['order'] 	= " {$param['order']}order.add_time DESC";
		$order_list	= Db::select($array,$obj_page);
		return $order_list;
	}
	/**
	 * 店铺的订单总数
	 *
	 */
	public function OrderCount($param) {
		$array		= array();
		$condition_str	= $this->getCondition($param);
		$ordercount	= Db::getCount('order',$condition_str);
		return $ordercount;
	}
	/**
	 * 店铺的订单商品单条数据
	 *
	 */
	public function OrderGoodsRowByID($id) {
		if (intval($id) > 0){
			$array = array();
			$array['table'] = 'order_goods';
			$array['field'] = 'rec_id';
			$array['value'] = $id;
			$result = Db::getRow($array);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 根据指定条件查询订单列表
	 *
	 * @param array $param		查询条件数组
	 * @param obj $obj_page		分页对象
	 * @param string $field		查询字段
	 * @return array			结果数组
	 */
	public function getOrderList($param,$obj_page='',$field='*'){
		$array		= array();
		$condition_str	= $this->getCondition($param);
		$array['table']		= 'order';
		$array['where'] 	= $condition_str;
		$array['order'] 	= " ".(empty($param['order'])?"":($param['order'].","))."`order`.add_time DESC";
		$array['field']   = $field;
        $array['limit'] = $param['limit'];
        $order_list	= Db::select($array,$obj_page);
		return $order_list;
	}
	/**
	 * 订单商品
	 *
	 */
	public function getOrderGoodsList($param,$page='') {
		$array				= array();
		$condition_str		= $this->getCondition($param);
		$array['table']		= 'order,order_goods';
		$array['join_type']	= 'LEFT JOIN';
		$array['join_on']	= array('order.order_id=order_goods.order_id');
		$array['order'] 	= empty($param['order'])?"`order`.add_time DESC":$param['order'];
		$array['where'] 	= $condition_str;
		$order_list			= Db::select($array,$page);
		return $order_list;
	}
	/**
	 * 订单完成阶段
	 *
	 * @param	int	$order_step		完成阶段
	 * @param	string	$message	阶段描述
	 * @return bool
	 */
	public function addLogOrder($order_step,$order_id,$message='',$lang=array()) {
		Language::read('model_lang_index');
		$lang	= Language::getLangContent();
		$log_array	= array();
		switch ($order_step) {
			case 10:
				$log_array['order_state']	= $lang['order_state_submitted'];
				$log_array['change_state']	= $lang['order_state_pending_payment'];
				break;
			case 11:
				$log_array['order_state']	= $lang['order_state_submitted'];
				$log_array['change_state']	= $lang['order_state_pending_payment'];
				break;
			case 0:
				$log_array['order_state']	= $lang['order_state_canceled'];
				$log_array['change_state']	= $lang['order_state_null'];
				break;
			case 20:
				$log_array['order_state']	= $lang['order_state_paid'];
				$log_array['change_state']	= $lang['order_state_to_be_shipped'];
				break;
			case 30:
				$log_array['order_state']	= $lang['order_state_shipped'];
				$log_array['change_state']	= $lang['order_state_be_receiving'];
				break;
			case 40:
				$log_array['order_state']	= $lang['order_state_completed'];
				$log_array['change_state']	= $lang['order_state_to_be_evaluated'];
				break;
		      case 50:
		        $log_array['order_state'] = $lang['order_state_submitted'];
		        $log_array['change_state'] = $lang['order_state_to_be_confirmed'];
		        break;
		      case 60:
		        $log_array['order_state'] = $lang['order_state_confirmed'];
		        $log_array['change_state'] = $lang['order_state_to_be_shipped'];
		        break;
					default:
						$log_array['order_state']	= $lang['order_state_unknown'];
						$log_array['change_state']	= $lang['order_state_unknown'];
				}
		
		$log_array['order_id']		= $order_id;
		$log_array['state_info']	= is_null($message) ? '' : $message;
		$log_array['log_time']		= time();
		$log_array['operator']		= $_SESSION['member_name'];
		return $this->addOrderLog($log_array);
	}
	/**
	 * 添加订单日志
	 */
	public function addOrderLog($param) {
		if(empty($param)) {
			return false;
		}
		$result	= Db::insert('order_log',$param);
		return $result;
	}
	/**
	 * 更改订单信息
	 *
	 * @param	array	$param	订单信息
	 * @param	int		$order_id	订单id
	 * @return bool
	 */
	public function updateOrder($param,$order_id) {
		if(is_array($param) and !empty($param)) {
			$where = " order_id = '$order_id'";
			return Db::update('order',$param,$where);
		} else {
			return false;
		}
	}
	/**
	 * 更改订单商品信息
	 *
	 * @param	array	$param	订单商品信息
	 * @param	int		$rec_id	订单商品id
	 * @return bool
	 */
	public function updateOrderGoods($param,$rec_id) {
		if(is_array($param) and !empty($param)) {
			$where = " rec_id = '$rec_id'";
			return Db::update('order_goods',$param,$where);
		} else {
			return false;
		}
	}
	/**
	 * 更改订单商品配送信息
	 *
	 * @param	array	$param		配送信息
	 * @param	int		$order_id	订单商品id
	 * @return bool
	 */
	public function updateOrderAddress($param,$order_id) {
		if(is_array($param) and !empty($param)) {
			$where = " order_id = '$order_id'";
			return Db::update('order_address',$param,$where);
		} else {
			return false;
		}
	}
	/**
	 * 订单操作历史列表
	 *
	 * @return string
	 */
	public function orderLoglist($order_id) {
		$array		= array();
		$array['table']		= 'order_log';
		$array['where'] 	= "where order_id='$order_id'";
		$array['order']     = 'log_id';
		$log_list	= Db::select($array);
		return $log_list;
	}
	/**
	 * 生成订单编号
	 *
	 * @return string
	 */
	public function snOrder() {
		//$this->product_sn = date('Ymd').substr( implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))) , 0 , 8);
		$this->product_sn = date('Ymd').substr( implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))) , -8 , 8);
		return $this->product_sn;
	}
	/**
	 * 生成外部订单编号
	 *
	 * @return string
	 */
	public function outSnOrder() {
		if($this->product_sn) {
			return $this->product_sn;
		}
	}
	/**
	 * 根据订单编号查询指定订单
	 *
	 * @param int $order_id
	 * @return array
	 */
	public function getOrderById($order_id,$type='all',$condition=array()){
		$param	= array();
		$condition_str	= $this->getCondition($condition);
		switch($type){
			case 'all':
				$param['table']	= 'order,order_address';
				$param['join_type']	= 'inner join';
				$param['join_on']	= array('`order`.order_id=`order_address`.order_id');
				$param['cache'] = false;
				break;
			case 'simple':
				$param['table']	= 'order';
				break;
			default:
				break;
		}
		$param['where']	= 'where `order`.order_id='.$order_id.$condition_str;
		$order_list	= Db::select($param);
		return $order_list[0];
	}

	/**
	 * 检查订单是否属于指定店铺 
	 *
     * @param int $order_id
     * @param int $store_id
	 * @return bool 
	 */
    public function checkOrderBelongStore($order_id,$store_id){

        $order_info = self::getOrderById($order_id,$type='simple');
        if(!empty($order_info) && intval($order_info['store_id']) === intval($store_id)) {
            return true;
        }
        else {
            return false;
        }
    }

	/**
	 * 根据外部支付编号查询订单
	 *
	 * @param array $param
	 * @return array
	 */
	public function getOrderByOutSn($out_sn,$type='all'){
		$param	= array();
		switch($type){
			case 'all':
				$param['table']	= 'order,order_address';
				$param['join_type']	= 'inner join';
				$param['join_on']	= array('`order`.order_id=`order_address`.order_id');
				break;
			case 'simple':
				$param['table']	= 'order';
				break;
			default:
				break;
		}
		$param['where']	= "where `order`.out_sn='".$out_sn."'";
		$order_list	= Db::select($param);
		return $order_list[0];
	}
	/**
	 * 根据店铺删除订单
	 *
	 * @param	array $param 列表条件
	 * @param	int $order_id_str 订单id
	 */
	public function dropOrderByOrder($order_id_str) {
		if(empty($order_id_str)) {
			return false;
		}
		$order_id = explode(',',$order_id_str);
		foreach ($order_id as $v){
			//删除订单
			$where = " order_id = '". intval($v) ."'";
			$result = Db::delete('order',$where);
			//删除订单商品
			$where = " order_id = '". intval($v) ."'";
			$result = Db::delete('order_goods',$where);
		}

		return $result;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if($condition_array['store_id'] != ''){
			$condition_sql	.= " and `order`.store_id='{$condition_array['store_id']}'";
		}
		if(!empty($condition_array['group_id'])) {
			$condition_sql	.= " and order.group_id ='{$condition_array['group_id']}'";
		}
		if($condition_array['buyer_id'] != '') {
			$condition_sql	.= " and order.buyer_id='{$condition_array['buyer_id']}'";
		}
		if($condition_array['seller_id'] != '') {
			$condition_sql	.= " and order.seller_id='{$condition_array['seller_id']}'";
		}
		if($condition_array['evaluation_status'] != ''){
			$condition_sql	.= " and `order`.evaluation_status = '{$condition_array['evaluation_status']}'";
		}
		if($condition_array['evalseller_status'] != ''){
			$condition_sql	.= " and `order`.evalseller_status = '{$condition_array['evalseller_status']}'";
		}
		if($condition_array['order_id'] != ''){
			$condition_sql	.= " and `order`.order_id='{$condition_array['order_id']}'";
		}
		if($condition_array['order_ids'] != ''){
			$condition_sql	.= " and `order`.order_id in(".$condition_array['order_ids'].")";
		}
		if($condition_array['store_name'] != ''){
			$condition_sql	.= " and `order`.store_name like '%".$condition_array['store_name']."%'";
		}
		if($condition_array['buyer_name'] != ''){
			$condition_sql	.= " and `order`.buyer_name like '%".$condition_array['buyer_name']."%'";
		}
		if($condition_array['payment_name'] != ''){
			$condition_sql	.= " and `order`.payment_name like '%".$condition_array['payment_name']."%'";
		}
		if($condition_array['order_sn'] != ''){
			$condition_sql	.= " and `order`.order_sn like '%".$condition_array['order_sn']."%'";
		}
		if($condition_array['in_order_sn'] != ''){
			$condition_sql	.= " and `order`.order_sn in (".$condition_array['in_order_sn'].")";
		}
		if($condition_array['status'] != ''){
			$condition_sql	.= " and `order`.order_state='{$condition_array['status']}'";
		}
		if($condition_array['status_no'] != ''){
			$condition_sql	.= " and `order`.order_state > 0";
		}
		if($condition_array['add_time_from'] != ''){
			$condition_sql	.= " and `order`.add_time >= '{$condition_array['add_time_from']}'";
		}
		if($condition_array['add_time_to'] != ''){
			$condition_sql	.= " and `order`.add_time <= '{$condition_array['add_time_to']}'";
		}
		if($condition_array['order_amount_from'] != ''){
			$condition_sql	.= " and `order`.order_amount >= '{$condition_array['order_amount_from']}'";
		}
		if($condition_array['order_amount_to'] != ''){
			$condition_sql	.= " and `order`.order_amount <= '{$condition_array['order_amount_to']}'";
		}
		if($condition_array['order_state'] == 'order_cancal') {
			$condition_sql	.= ' and order.order_state=0';
		}
		if($condition_array['order_state'] == 'order_submit') {
			$condition_sql	.= ' and order.order_state=10';
		}
		if($condition_array['order_state'] == 'order_pay') {
			$condition_sql	.= ' and order.order_state>0 and order.order_state<20';
		}
		if($condition_array['order_state'] == 'order_no_shipping') {
			$condition_sql	.= ' and order.order_state=20';
		}
		if($condition_array['order_state'] == 'order_shipping') {
			$condition_sql	.= ' and order.order_state=30';
		}
		if($condition_array['order_state'] == 'order_finish') {
			$condition_sql	.= ' and order.order_state=40';
		}
		if($condition_array['refund_state'] == 'able_evaluate') {
			$condition_sql	.= ' and order.refund_state<2';
		}
        if($condition_array['order_state'] == 'order_refer') {
            $condition_sql .= ' and order.order_state=50';
        }
        if($condition_array['order_state'] == 'order_confirm') {
            $condition_sql .= ' and order.order_state=60';
        }
		if($condition_array['`order`.store_id'] > 0) {
			$condition_sql	.= " and `order`.store_id='{$condition_array['`order`.store_id']}'";
		}
		if($condition_array['`order`.evaluation_status'] > 0) {
			$condition_sql	.= " and `order`.evaluation_status='{$condition_array['`order`.evaluation_status']}'";
		}
		if($condition_array['`order_goods`.evaluation'] > 0) {
			$condition_sql	.= " and `order_goods`.evaluation='{$condition_array['`order_goods`.evaluation']}'";
		}
		if($condition_array['`order_goods`.goods_id'] > 0) {
			$condition_sql	.= " and `order_goods`.goods_id='{$condition_array['`order_goods`.goods_id']}'";
		}
		//订单商品名称
		if($condition_array['ordergoods_goodsnamelike'] !='') {
			$condition_sql	.= " and `order_goods`.goods_name like '%{$condition_array['ordergoods_goodsnamelike']}%'";
		}
		//订单商品评价状态
		if($condition_array['ordergoods_evaluationstate'] != '') {
			$condition_sql	.= " and `order_goods`.evaluation_state = '{$condition_array['ordergoods_evaluationstate']}' ";
		}
		//订单商品评价状态
		if(isset($condition_array['ordergoods_evaluationstate_in'])) {
			if($condition_array['ordergoods_evaluationstate_in'] == '') {
				$condition_sql	.= " and `order_goods`.evaluation_state in ('') ";
			}else {
				$condition_sql	.= " and `order_goods`.evaluation_state in ({$condition_array['ordergoods_evaluationstate_in']})";
			}
		}
		//订单商品序号
		if($condition_array['ordergoods_rec_id'] != '') {
			$condition_sql	.= " and `order_goods`.rec_id = '{$condition_array['ordergoods_rec_id']}' ";
		}
		//待卖家评价订单(交易成功 并且 卖家没有评价 并且 (1.十五天内 或者 2.买家评价后十五天内))
		if($condition_array['order_evalseller_able'] != '') {
			$condition_sql	.= " and order.order_state=40 and order.refund_state<2 and order.evalseller_status = 0 and (((order.finnshed_time+60*60*24*15)>".time().") or ((order.evaluation_time+60*60*24*15)>".time().")) ";
		}
		//交易中的订单(没有取消 并且 没有完成(10未付款,11线下付款,20:已付款,30:已发货,50:已提交,60已确认))
		if($condition_array['order_progressing'] != '') {
			$condition_sql	.= " and order.order_state>0 and order.order_state<>40";
		}
		return $condition_sql;
	}
}
?>
