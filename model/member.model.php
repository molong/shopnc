<?php
/**
 * 会员管理
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
class memberModel extends Model {
	public function __construct(){
		parent::__construct('member');
	}
	/**
	 * 注册商城会员
	 *
	 * @param	array $param 会员信息
	 * @return	array 数组格式的返回结果
	 */
	public function addMember($param) {
		if(empty($param)) {
			return false;
		}
		$member_info	= array();
		$member_info['member_id']			= $param['member_id'];
		$member_info['member_name']			= trim($param['member_name']);
		$member_info['member_passwd']		= md5(trim($param['member_passwd']));
		$member_info['member_email']		= trim($param['member_email']);
		$member_info['member_time']			= time();
		$member_info['member_login_time'] 	= $member_info['member_time'];
		$member_info['member_old_login_time'] = $member_info['member_time'];
		$member_info['member_login_ip']		= getIp();
		$member_info['member_old_login_ip']	= $member_info['member_login_ip'];
		
		$member_info['member_truename']		= $param['member_truename'];
		$member_info['member_qq']			= $param['member_qq'];
		$member_info['member_sex']			= $param['member_sex'];
		$member_info['member_avatar']		= $param['member_avatar'];
		$member_info['member_qqopenid']		= $param['member_qqopenid'];
		$member_info['member_qqinfo']		= $param['member_qqinfo'];
		$member_info['member_sinaopenid']	= $param['member_sinaopenid'];
		$member_info['member_sinainfo']	= $param['member_sinainfo'];		
		$result	= Db::insert('member',$member_info);
		if($result) {
			return Db::getLastId();
		} else {
			return false;
		}
	}
	/**
	 * 获取会员信息
	 *
	 * @param	array $param 会员条件
	 * @param	string $field 显示字段
	 * @return	array 数组格式的返回结果
	 */
	public function infoMember($param,$field='*') {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$param	= array();
		$param['table']	= 'member';
		$param['where']	= $condition_str;
		$param['field']	= $field;
		$param['limit'] = 1;
		$member_info	= Db::select($param);
		return $member_info[0];
	}
	/**
	 * 更新会员信息
	 *
	 * @param	array $param 更改信息
	 * @param	int $member_id 会员条件 id
	 * @return	array 数组格式的返回结果
	 */
	public function updateMember($param,$member_id) {
		if(empty($param)) {
			return false;
		}
		$update		= false;
		//得到条件语句
		$condition_str	= " member_id='{$member_id}' ";
		$update		= Db::update('member',$param,$condition_str);
		return $update;
	}
	/**
	 * 会员登录检查
	 *
	 */
	public function checkloginMember() {
		if($_SESSION['is_login'] == '1') {
			@header("Location: index.php");
			exit();
		}
	}

    /**
	 * 检查会员是否允许举报商品
	 *
	 */
	public function isMemberAllowInform($member_id) {
        
        $condition = array();
        $condition['member_id'] = $member_id; 
        $member_info = $this->infoMember($condition,'inform_allow');
        if(intval($member_info['inform_allow']) === 1) {
            return true;
        }
        else {
            return false;
        }
	}


	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $conditon_array
	 * @return	string
	 */
	private function getCondition($conditon_array){
		$condition_sql = '';
		if($conditon_array['member_id'] != '') {
			$condition_sql	.= " and member_id= '" .intval($conditon_array['member_id']). "'";
		}
		if($conditon_array['member_name'] != '') {
			$condition_sql	.= " and member_name='".$conditon_array['member_name']."'";
		}
		if($conditon_array['member_passwd'] != '') {
			$condition_sql	.= " and member_passwd='".$conditon_array['member_passwd']."'";
		}
		//是否允许举报
		if($conditon_array['inform_allow'] != '') {
			$condition_sql	.= " and inform_allow='{$conditon_array['inform_allow']}'";
		}
		//是否允许购买
		if($conditon_array['is_buy'] != '') {
			$condition_sql	.= " and is_buy='{$conditon_array['is_buy']}'";
		}
		//是否允许发言
		if($conditon_array['is_allowtalk'] != '') {
			$condition_sql	.= " and is_allowtalk='{$conditon_array['is_allowtalk']}'";
		}
		//是否允许登录
		if($conditon_array['member_state'] != '') {
			$condition_sql	.= " and member_state='{$conditon_array['member_state']}'";
		}
		if($conditon_array['friend_list'] != '') {
			$condition_sql	.= " and member_name IN (".$conditon_array['friend_list'].")";
		}
		if($conditon_array['member_email'] != '') {
			$condition_sql	.= " and member_email='".$conditon_array['member_email']."'";
		}
		if($conditon_array['no_member_id'] != '') {
			$condition_sql	.= " and member_id != '".$conditon_array['no_member_id']."'";
		}
		if($conditon_array['like_member_name'] != '') {
			$condition_sql	.= " and member_name like '%".$conditon_array['like_member_name']."%'";
		}
		if($conditon_array['like_member_email'] != '') {
			$condition_sql	.= " and member_email like '%".$conditon_array['like_member_email']."%'";
		}
		if($conditon_array['like_member_truename'] != '') {
			$condition_sql	.= " and member_truename like '%".$conditon_array['like_member_truename']."%'";
		}
		if($conditon_array['in_member_id'] != '') {
			$condition_sql	.= " and member_id IN (".$conditon_array['in_member_id'].")";
		}
		if($conditon_array['in_member_name'] != '') {
			$condition_sql	.= " and member_name IN (".$conditon_array['in_member_name'].")";
		}
		if($conditon_array['member_qqopenid'] != '') {
			$condition_sql	.= " and member_qqopenid = '{$conditon_array['member_qqopenid']}'";
		}
		if($conditon_array['member_sinaopenid'] != '') {
			$condition_sql	.= " and member_sinaopenid = '{$conditon_array['member_sinaopenid']}'";
		}
		
		return $condition_sql;
	}
	
	/**
	 * 会员列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $obj_page 分页对象
	 * @return array 数组类型的返回结果
	 */
	public function getMemberList($condition,$obj_page='',$field='*'){
		$condition_str = $this->getCondition($condition);
		$param = array();
		$param['table'] = 'member';
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'member_id desc';
		$param['field'] = $field;
		$param['limit'] = $condition['limit'];
		$member_list = Db::select($param,$obj_page);
		return $member_list;
	}
	
	/**
	 * 删除会员
	 *
	 * @param int $id 记录ID
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " member_id = '". intval($id) ."'";
			$result = Db::delete('member',$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 查询会员总数
	 */
	public function countMember($condition){
		//得到条件语句
		$condition_str	= $this->getCondition($condition);
		$count = Db::getCount('member',$condition_str);
		return $count;
	}
}
