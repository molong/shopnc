<?php
/**
 * 运费模板
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
class transportModel extends Model {

	public function __construct(){
		parent::__construct('transport');
	}
	/**
	 * 增加运费模板
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	public function add($data){
		return DB::insert('transport',$data);
	}

	/**
	 * 增加各地区详细运费设置
	 *
	 * @param unknown_type $data
	 * @return unknown
	 */
	public function addExtend($data){
		return DB::insertAll('transport_extend',$data);
	}

	/**
	 * 取得一条运费模板信息
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function getRow($id){
		$param	= array();
		$param['table']	= 'transport';
		$param['field']	= 'id';
		$param['value']	= $id;
		$result	= Db::getRow($param);
		return $result;
	}

	/**
	 * 取得一条运费模板扩展信息
	 *
	 * @param unknown_type $transport_id
	 * @return unknown
	 */
	public function getExtendRow($transport_id){
		$param	= array();
		$param['table']	= 'transport_extend';
		$param['field']	= 'transport_id';
		$param['value']	= $transport_id;
		$result	= Db::getRow($param);
		return $result;
	}

	/**
	 * 删除运费模板
	 *
	 * @param unknown_type $id
	 * @return unknown
	 */
	public function del($id){
		return DB::delete('transport','id='.$id);
	}

	/**
	 * 删除运费模板扩展信息
	 *
	 * @param unknown_type $transport_id
	 * @return unknown
	 */
	public function delExtend($transport_id){
		return DB::delete('transport_extend','transport_id='.$transport_id);
	}

	/**
	 * 取得运费模板列表
	 *
	 * @param unknown_type $condition
	 * @param unknown_type $page
	 * @param unknown_type $order
	 * @return unknown
	 */
	public function getList($condition=array(),$page='',$order='id desc'){
		return $this->where(array('member_id'=>$_SESSION['member_id']))->order('id desc')->page(4)->select();
	}

	/**
	 * 取得扩展信息列表
	 *
	 * @param unknown_type $condition
	 * @param unknown_type $order
	 * @return unknown
	 */
	public function getExtendList($condition=array(), $order='type desc,is_default'){
		return $this->table('transport_extend')->where($condition)->order($order)->select();
	}

	public function transUpdate($data){
		return DB::update('transport',$data,'id='.$data['id']);
	}

	/**
	 * 检测运费模板是否正在被使用
	 *
	 */
	public function isUsing($id){
		if (!is_numeric($id)) return false;
		$param	= array();
		$param['table']	= 'goods';
		$param['where']	= 'transport_id='.$id;
		$param['limit'] = '1';
		$param['field'] = 'goods_id';
		$list = Db::select($param);
		if($list){
			return true;
		}else{
			return false;
		}
	}

	private function getCondition($condition){
		$condition_str = '';
		if (is_array($condition['transport_id'])){
			$condition_str .= ' and transport_id in ('.implode(',',$condition['transport_id']).')';
		}
		if (is_numeric($condition['member_id'])){
			$condition_str .= ' and member_id='.$condition['member_id'];
		}
		if (is_numeric($condition['is_default'])){
			$condition_str .= ' and is_default='.$condition['is_default'];
		}
		return $condition_str;
	}
}
?>