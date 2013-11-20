<?php
/**
 * 直通车管理
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

class ztcModel {
	/**
	 * 添加直通车申请信息
	 *
	 * @param array $param 添加信息数组
	 */
	public function addZtcGoods($param) {
		if(empty($param)) {
			return false;
		}		
		$result	= Db::insert('ztc_goods',$param);
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
	public function getZtcList($condition,$page='',$field='*'){
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		$param['table']	= 'ztc_goods';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'ztc_goods.ztc_id desc';
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
	public function getZtcInfo($condition,$field='*'){
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$array			= array();
		$array['table']	= 'ztc_goods';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$goods_info		= Db::select($array);
		return $goods_info[0];
	}
	/**
	 * 直通车申请信息修改
	 *
	 * @param	array $param 修改信息数组
	 * @param	int $ztc_id 团购商品id
	 */
	public function updateZtcOne($param,$condition) {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$result	= Db::update('ztc_goods',$param,$condition_str);
		return $result;
	}
	/**
	 * 删除直通车申请信息
	 * @param	mixed $ztc_id 删除申请记录编号
	 */
	public function dropZtcById($ztc_id){
		if(empty($ztc_id)) {
			return false;
		}
		$condition_str .= " ztc_id = '{$ztc_id}' ";
		$result = Db::delete('ztc_goods',$condition_str);
		return $result;
	}
	/**
	 * 删除直通车申请信息
	 * @param	mixed $ztc_id 删除申请记录编号
	 */
	public function dropZtcByCondition($condition_arr){
		if(empty($condition_arr)) {
			return false;
		}
		$condition_str = $this->getCondition($condition_arr);
		$result = Db::delete('ztc_goods',$condition_str);
		return $result;
	}
	/**
	 * 更新直通车商品信息
	 * @param string $langname 添加到数据库的操作信息
	 * @param mixed $store_id 店铺编号
	 * @param mixed $store_id 商品编号
	 */
	public function updateZtcGoods($langtext,$store_id = '',$goods_id = ''){
		//条件
		$condition_arr = array();
		//店铺编号
		if ($store_id){
			$condition_arr['store_id'] = $store_id;
		}
		//商品编号
		if (isset($goods_id)){
			if (is_array($goods_id)){
				$condition_arr['goods_id_in'] = implode(',',$goods_id);
			}else{
				$condition_arr['goods_id'] = $goods_id;
			}
		}
		$condition_arr['goods_isztc'] = '1';
		$condition_arr['goods_ztcstate'] = '1';//直通车状态
		//当前时间
		$datetime = date('Y-m-d',time());
		$datetime = strtotime($datetime);
		$condition_arr['lesstime'] = $datetime;
				
		$goods_model = Model('goods');
		//查询直通车商品并更新信息
		$alllist_goods	= $goods_model->getGoods($condition_arr,'','*','store');
		$up_goods = array();
		if (is_array($alllist_goods) && count($alllist_goods)>0){
			foreach ($alllist_goods as $k=>$v){
				/**
				 * 计算应扣除的金币
				 */
				//应该更新的天数
				$v['goods_ztclastdate'] = intval($v['goods_ztclastdate']);
				$day = ($datetime - $v['goods_ztclastdate'])/(3600*24);
				//扣除金币数
				$up_goods[$k]['minusnum'] = intval($GLOBALS['setting_config']['ztc_dayprod'])*$day;
				//如果应扣除金币数大于或者等于现有金币数，扣除全部金币并将直通车状态更新为关闭
				if ($up_goods[$k]['minusnum'] >= intval($v['goods_goldnum'])){
					$up_goods[$k]['minusnum'] = intval($v['goods_goldnum']);
					$up_goods[$k]['goods_goldnum'] = 0;
					$up_goods[$k]['goods_isztc'] = 0;
				}else {
					$up_goods[$k]['goods_goldnum'] = intval($v['goods_goldnum']) - intval($up_goods[$k]['minusnum']);
					$up_goods[$k]['goods_isztc'] = 1;
				}
				$up_goods[$k]['goods_id'] = $v['goods_id'];
				$up_goods[$k]['goods_name'] = $v['goods_name'];
				$up_goods[$k]['goods_ztclastdate'] = $datetime;
				$up_goods[$k]['oldtime'] = $v['goods_ztclastdate'];
				$up_goods[$k]['member_id'] = $v['member_id'];
				$up_goods[$k]['member_name'] = $v['member_name'];
				$up_goods[$k]['store_id'] = $v['store_id'];
				$up_goods[$k]['store_name'] = $v['store_name'];
			}
			//记录直通车消费日志
			$ztcgoldlog_model = Model('ztc_glodlog');
			foreach ($up_goods as $k=>$v){
				//更新直通车商品信息
				$one_goods = array();
				$one_goods['goods_goldnum'] = $v['goods_goldnum'];
				$one_goods['goods_isztc'] = $v['goods_isztc'];
				$one_goods['goods_ztclastdate'] = $v['goods_ztclastdate'];
				$result = $goods_model->updateGoodsAllUser($one_goods,$v['goods_id']);
				if ($result){
					$logarr = array();
					$logarr['glog_goodsid'] = $v['goods_id'];
					$logarr['glog_goodsname'] = $v['goods_name'];
					$logarr['glog_memberid'] = $v['member_id'];
					$logarr['glog_membername'] = $v['member_name'];
					$logarr['glog_storeid'] = $v['store_id'];
					$logarr['glog_storename'] = $v['store_name'];
					$logarr['glog_type'] = 2;
					$logarr['glog_goldnum'] = $v['minusnum'];
					$logarr['glog_addtime'] = time();
					//$logarr['glog_desc'] = '参与直通车,商品消耗金币';
					//$logarr['glog_desc'] = Language::get('admin_ztc_glist_glog_desc');
					$logarr['glog_desc'] = $langtext;
					$ztcgoldlog_model->addlog($logarr);
					unset($logarr);
				}
				unset($one_goods);
			}
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
		//直通车申请记录编号
		if ($condition_array['ztc_id']) {
			$condition_sql	.= " and `ztc_goods`.ztc_id= '{$condition_array['ztc_id']}'";
		}
		//直通车申请记录编号
		if (isset($condition_array['ztc_id_in'])) {
			if ($condition_array['ztc_id_in'] == ''){
				$condition_sql	.= " and `ztc_goods`.ztc_id in('') ";
			}else {
				$condition_sql	.= " and `ztc_goods`.ztc_id in({$condition_array['ztc_id_in']})";
			}
		}
		//直通车申请记录编号
		if (isset($condition_array['ztc_id_in_del'])) {
			if ($condition_array['ztc_id_in_del'] == ''){
				$condition_sql	.= " and ztc_id in('') ";
			}else {
				$condition_sql	.= " and ztc_id in({$condition_array['ztc_id_in_del']})";
			}
		}
		//商品编号
		if ($condition_array['ztc_goodsid']) {
			$condition_sql	.= " and `ztc_goods`.ztc_goodsid= '{$condition_array['ztc_goodsid']}'";
		}
		//会员编号
		if ($condition_array['ztc_memberid']) {
			$condition_sql	.= " and `ztc_goods`.ztc_memberid = '{$condition_array['ztc_memberid']}'";
		}
		//会员名称
		if ($condition_array['ztc_membername']) {
			$condition_sql	.= " and `ztc_goods`.ztc_membername like '%{$condition_array['ztc_membername']}%' ";
		}
		//店铺名称
		if ($condition_array['ztc_storename']) {
			$condition_sql	.= " and `ztc_goods`.ztc_storename like '%{$condition_array['ztc_storename']}%' ";
		}
		//直通车审核状态
		if (isset($condition_array['ztc_state'])) {
			$condition_sql	.= " and `ztc_goods`.ztc_state='{$condition_array['ztc_state']}'";
		}
		//直通车申请类型
		if (isset($condition_array['ztc_type'])) {
			$condition_sql	.= " and `ztc_goods`.ztc_type= '{$condition_array['ztc_type']}'";
		}
		//直通车商品名称
		if ($condition_array['ztc_goodsname']) {
			$condition_sql	.= " and `ztc_goods`.ztc_goodsname like '%".$condition_array['ztc_goodsname']."%'";
		}
		//直通车支付类型
		if (isset($condition_array['ztc_paystate'])) {
			$condition_sql	.= " and `ztc_goods`.ztc_paystate= '{$condition_array['ztc_paystate']}' ";
		}
		return $condition_sql;
	}
}