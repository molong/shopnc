<?php
/**
 * 预存款
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class predepositModel{
	/**
	 * 生成充值订单编号
	 * @return string
	 */
	public function recharge_snOrder() {
		$recharge_sn = 'pre'.date('Ymd').substr( implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))) , -8 , 8);
		return $recharge_sn;
	}
	/**
	 * 操作预存款
	 * @author ShopNC Develop Team     
	 * @param  string $stage 操作阶段 system(系统),recharge(充值),cash(提现),order(下单)admin(管理员)
	 * @param  array $insertarr 该数组可能包含信息 array('memberid'=>'会员编号','membername'=>'会员名称','adminid'=>'管理员编号','adminname'=>'管理员名称','logtype'='1','price'=>'预存款','desc'=>'描述','order_sn'=>'订单编号','order_id'=>'订单序号');
	 * @param  bool $if_repeat 是否可以重复记录的信息,true可以重复记录，false不可以重复记录，默认为true
	 * @return bool
	 */
	function savePredepositLog($stage,$insertarr){
		if (!$insertarr['memberid']){
			return false;
		}
		//记录原因文字
		switch ($stage){
			case 'recharge':
				if (!$insertarr['desc']){
					$insertarr['desc'] = Language::get('predepositrechargedesc');
				}
				break;
			case 'cash':
				if (!$insertarr['desc']){
					$insertarr['desc'] = Language::get('predepositcashdesc');
				}
				break;
			case 'admin':
				if (!$insertarr['desc']){
					$insertarr['desc'] = Language::get('predepositadmindesc');
				}
				break;
		}
		//新增日志
		$value_array = array();
		$value_array['pdlog_memberid'] = $insertarr['memberid'];
		$value_array['pdlog_membername'] = $insertarr['membername'];
		if ($insertarr['adminid']){
			$value_array['pdlog_adminid'] = $insertarr['adminid'];
		}
		if ($insertarr['adminname']){
			$value_array['pdlog_adminname'] = $insertarr['adminname'];
		}
		$value_array['pdlog_stage'] = $stage;
		$value_array['pdlog_type'] = $insertarr['logtype'];//日志类型 0表示可用金额 1表示冻结金额
		$value_array['pdlog_price'] = $insertarr['price'];
		$value_array['pdlog_addtime'] = time();
		$value_array['pdlog_desc'] = $insertarr['desc'];
		$result = self::addPredepositLog($value_array);
		if ($result){
			//更新member内容
			$obj_member = Model('member');
			$upmember_array = array();
			if ($insertarr['logtype'] == 1){
				$upmember_array['freeze_predeposit'] = array('sign'=>'increase','value'=>$insertarr['price']);//冻结预存款
			} else {
				$upmember_array['available_predeposit'] = array('sign'=>'increase','value'=>$insertarr['price']);//可用预存款
			}
			$obj_member->updateMember($upmember_array,$insertarr['memberid']);
			return true;
		}else {
			return false;
		}
	}
	/**
	 * 预存款充值单条记录
	 *
	 * @param $condition 条件
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getRechargeRow($condition,$field='*'){
		$condition_str	= $this->getCondition($condition);
		$array			= array();
		$array['table']	= 'predeposit_recharge';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$info			= Db::select($array);
		return $info[0];
	}
	/**
	 * 预存款充值记录列表
	 *
	 * @param $condition 条件
	 * @param $page 分页
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getRechargeList($condition,$page='',$field='*'){
		$condition_str	= $this->getCondition($condition);
		$param	= array();
		$param['table']	= 'predeposit_recharge';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'predeposit_recharge.pdr_id desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 预存款充值记录新增
	 *
	 * @param $param 添加信息数组
	 * @return 返回结果
	 */
	public function rechargeAdd($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$result = Db::insert('predeposit_recharge',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 预存款充值记录更新
	 *
	 * @param $condition 条件
	 * @param $param 更新信息
	 * @return
	 */
	public function rechargeUpdate($condition,$param){
		if(empty($param)) {
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$result = Db::update('predeposit_recharge',$param,$condition_str);
		return $result;
	}
	/**
	 * 预存款充值记录删除
	 *
	 * @param $condition 条件
	 * @return
	 */
	public function rechargeDel($condition){
		$condition_str = $this->getCondition($condition);
		$result = Db::delete('predeposit_recharge',$condition_str);
		return $result;
	}
	/**
	 * 添加预存款日志信息
	 *
	 * @param array $param 添加信息数组
	 */
	public function addPredepositLog($param) {
		if(empty($param)) {
			return false;
		}
		$result	= Db::insert('predeposit_log',$param);
		return $result;
	}
	/**
	 * 预存款日志信息列表
	 *
	 * @param array $condition 条件数组
	 * @param array $page   分页
	 * @param array $field   查询字段
	 * @param array $page   分页 
	 */
	public function predepositLogList($condition,$page='',$field='*'){
		$condition_str	= $this->getLogCondition($condition);
		$param	= array();
		$param['table']	= 'predeposit_log';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'pdlog_id desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 预存款扣除是否合法
	 * 
	 * @param int $memberid 会员编号
	 * @param float $price   金额
	 * @param int $type   类型 0扣除可用金额 1扣除冻结金额
	 */
	public function predepositDecreaseCheck($memberid,$price,$type=0){
		if (intval($memberid) <= 0){
			return false;
		}
		//查询会员信息
		$member_model = Model('member');
		$member_info = $member_model->infoMember(array('member_id'=>$memberid),'member_id,available_predeposit,freeze_predeposit');
		if (!is_array($member_info) || count($member_info)<=0){
			return false;
		}
		if ($type == 1 && floatval($member_info['freeze_predeposit'])>=$price){
			return true;
		}
		if ($type != 1 && floatval($member_info['available_predeposit'])>=$price){
			return true;
		}
		return false;
	}
	/**
	 * 生成提现订单编号
	 * @return string
	 */
	public function cash_snOrder() {
		$cash_sn = 'cash'.date('Ymd').substr( implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))) , -8 , 8);
		return $cash_sn;
	}
	/**
	 * 预存款提现记录新增
	 *
	 * @param $param 添加信息数组
	 * @return 返回结果
	 */
	public function cashAdd($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$result = Db::insert('predeposit_cash',$param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 预存款提现记录列表
	 *
	 * @param $condition 条件
	 * @param $page 分页
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getCashList($condition,$page='',$field='*'){
		$condition_str	= $this->getCashCondition($condition);
		$param	= array();
		$param['table']	= 'predeposit_cash';
		$param['where']	= $condition_str;
		$param['field'] = $field;
		$param['order'] = $condition['order'] ? $condition['order'] : 'predeposit_cash.pdcash_id desc';
		$param['limit'] = $condition['limit'];
		$param['group'] = $condition['group'];
		return Db::select($param,$page);
	}
	/**
	 * 预存款提现单条记录
	 *
	 * @param $condition 条件
	 * @param $field 查询字段
	 * @return array 数组格式的返回结果
	 */
	public function getCashRow($condition,$field='*'){
		$condition_str	= $this->getCashCondition($condition);
		$array			= array();
		$array['table']	= 'predeposit_cash';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$info			= Db::select($array);
		return $info[0];
	}
	/**
	 * 预存款提现记录删除
	 *
	 * @param $condition 条件
	 * @return
	 */
	public function cashDel($condition){
		$condition_str = $this->getCashCondition($condition);
		$result = Db::delete('predeposit_cash',$condition_str);
		return $result;
	}
	/**
	 * 预存款提现记录更新
	 *
	 * @param $condition 条件
	 * @param $param 更新信息
	 * @return
	 */
	public function cashUpdate($condition,$param){
		if(empty($param)) {
			return false;
		}
		$condition_str = $this->getCashCondition($condition);
		$result = Db::update('predeposit_cash',$param,$condition_str);
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
		//充值记录序号
		if($condition_array['pdr_id'] != '') {
			$condition_sql	.= " and pdr_id = '".$condition_array['pdr_id']."'";
		}
		//充值记录编号
		if($condition_array['pdr_sn_like'] != '') {
			$condition_sql	.= " and pdr_sn like '%".$condition_array['pdr_sn_like']."%'";
		}
		//充值记录编号
		if($condition_array['pdr_sn'] != '') {
			$condition_sql	.= " and pdr_sn = '".$condition_array['pdr_sn']."'";
		}
		//会员编号
		if($condition_array['pdr_memberid'] != '') {
			$condition_sql	.= " and pdr_memberid = '".$condition_array['pdr_memberid']."'";
		}
		//支付方式
		if($condition_array['pdr_payment'] != '') {
			$condition_sql	.= " and pdr_payment = '".$condition_array['pdr_payment']."'";
		}
		//支付状态
		if($condition_array['pdr_paystate'] != '') {
			$condition_sql	.= " and pdr_paystate = '".$condition_array['pdr_paystate']."'";
		}
		//会员姓名
		if ($condition_array['pdr_membername_like'] !=''){
			$condition_sql	.= " and pdr_membername like '%".$condition_array['pdr_membername_like']."%'";
		}
		//汇款人姓名
		if ($condition_array['pdr_remittancename_like'] !=''){
			$condition_sql	.= " and pdr_remittancename like '%".$condition_array['pdr_remittancename_like']."%'";
		}
		//汇款银行
		if ($condition_array['pdr_remittancebank_like'] !=''){
			$condition_sql	.= " and pdr_remittancebank like '%".$condition_array['pdr_remittancebank_like']."%'";
		}
		//创建时间
		if ($condition_array['saddtime']){
			$condition_sql	.= " and pdr_addtime >= '{$condition_array['saddtime']}'";
		}
		if ($condition_array['eaddtime']){
			$condition_sql	.= " and pdr_addtime <= '{$condition_array['eaddtime']}'";
		}
		return $condition_sql;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getLogCondition($condition_array){
		$condition_sql = '';
		//会员编号
		if ($condition_array['pdlog_memberid'] !=''){
			$condition_sql	.= " and pdlog_memberid = '".$condition_array['pdlog_memberid']."'";
		}
		//会员姓名
		if ($condition_array['pdlog_membername_like'] !=''){
			$condition_sql	.= " and pdlog_membername like '%".$condition_array['pdlog_membername_like']."%'";
		}
		//管理员姓名
		if ($condition_array['pdlog_adminname_like'] !=''){
			$condition_sql	.= " and pdlog_adminname like '%".$condition_array['pdlog_adminname_like']."%'";
		}
		//阶段
		if ($condition_array['pdlog_stage'] !=''){
			$condition_sql	.= " and pdlog_stage ='{$condition_array['pdlog_stage']}'";
		}
		//类型
		if ($condition_array['pdlog_type'] !=''){
			$condition_sql	.= " and pdlog_type ='{$condition_array['pdlog_type']}'";
		}
		//添加时间
		if ($condition_array['saddtime']){
			$condition_sql	.= " and pdlog_addtime >= '{$condition_array['saddtime']}'";
		}
		if ($condition_array['eaddtime']){
			$condition_sql	.= " and pdlog_addtime <= '{$condition_array['eaddtime']}'";
		}
		//描述
		if ($condition_array['pdlog_desc_like']){
			$condition_sql	.= " and pdlog_desc like '%{$condition_array['pdlog_desc_like']}%'";
		}
		return $condition_sql;
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCashCondition($condition_array){
		$condition_sql = '';
		//提现记录编号
		if($condition_array['pdcash_id'] != '') {
			$condition_sql	.= " and pdcash_id = '".$condition_array['pdcash_id']."'";
		}
		//充值记录编号
		if($condition_array['pdcash_sn_like'] != '') {
			$condition_sql	.= " and pdcash_sn like '%".$condition_array['pdcash_sn_like']."%'";
		}
		//支付方式
		if($condition_array['pdcash_payment'] != '') {
			$condition_sql	.= " and pdcash_payment = '".$condition_array['pdcash_payment']."'";
		}
		//支付状态
		if($condition_array['pdcash_paystate'] != '') {
			$condition_sql	.= " and pdcash_paystate = '".$condition_array['pdcash_paystate']."'";
		}
		//会员编号
		if ($condition_array['pdcash_memberid'] !=''){
			$condition_sql	.= " and pdcash_memberid = '".$condition_array['pdcash_memberid']."'";
		}
		//会员姓名
		if ($condition_array['pdcash_membername_like'] !=''){
			$condition_sql	.= " and pdcash_membername like '%".$condition_array['pdcash_membername_like']."%'";
		}
		//收款人姓名
		if ($condition_array['pdcash_toname_like'] !=''){
			$condition_sql	.= " and pdcash_toname like '%".$condition_array['pdcash_toname_like']."%'";
		}
		//收款银行
		if ($condition_array['pdcash_tobank_like'] !=''){
			$condition_sql	.= " and pdcash_tobank like '%".$condition_array['pdcash_tobank_like']."%'";
		}
		//添加时间
		if ($condition_array['saddtime']){
			$condition_sql	.= " and pdcash_addtime >= '{$condition_array['saddtime']}'";
		}
		if ($condition_array['eaddtime']){
			$condition_sql	.= " and pdcash_addtime <= '{$condition_array['eaddtime']}'";
		}
		return $condition_sql;
	}
}