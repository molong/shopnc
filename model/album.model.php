<?php
/**
 * 相册管理
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
class albumModel{
	/**
	 * 分类列表
	 *
	 * @param array $condition 查询条件
	 * @param obj $page 分页对象
	 * @return array 二维数组
	 */
	public function getClassList($condition,$page=''){
		$param	= array();
		$param['table']			= 'album_class,album_pic';
		$param['field']			= 'album_class.*,count(album_pic.aclass_id) as count';
		$param['join_type']		= 'left join';
		$param['join_on']		= array('album_class.aclass_id = album_pic.aclass_id');
		$param['where']			= $this->getCondition($condition);
		$param['order']			= $condition['order'] ? $condition['order'] : 'album_class.aclass_sort desc';
		$param['group']			= 'album_class.aclass_id';
		return Db::select($param,$page);
	}
	/**
	 * 计算分类数量
	 * 
	 * @param int id
	 * @return array 一维数组
	 */
	public function countClass($id){
		$param	= array();
		$param['table']			= 'album_class';
		$param['field']			= 'count(*) as count';
		$param['where']			= " and store_id = '$id'";
		$return = Db::select($param);
		return $return['0'];
	}
	/**
	 * 验证相册
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function checkAlbum($condition) {
		/**
		 * 验证是否为当前合作伙伴
		 */
		$check_array = self::getClassList($condition,'');
		if (!empty($check_array)){
			unset($check_array);
			return true;
		}
		unset($check_array);
		return false;
	}
	/**
	 * 图片列表
	 *
	 * @param array $condition 查询条件
	 * @param obj $page 分页对象
	 * @return array 二维数组
	 */
	public function getPicList($condition, $page='', $field='*'){
		$param	= array();
		$param['table']			= 'album_pic';
		$param['where']			= $this->getCondition($condition);
		$param['order']			= $condition['order'] ? $condition['order'] : 'apic_id desc';
		$param['field']			= $field;
		return Db::select($param,$page);
	}
	/**
	 * 添加相册分类
	 *
	 * @param array $input
	 * @return bool
	 */
	public function addClass($input){
		if(is_array($input) && !empty($input)){
			return Db::insert('album_class',$input);
		}else{
			return false;
		}
	}
	/**
	 * 添加相册图片
	 *
	 * @param array $input
	 * @return bool
	 */
	public function addPic($input){
		if(is_array($input) && !empty($input)){
			return Db::insert('album_pic',$input);
		}else{
			return false;
		}
	}
	/**
	 * 更新相册分类
	 *
	 * @param array $input
	 * @param int $id
	 * @return bool
	 */
	public function updateClass($input,$id){
		if(is_array($input) && !empty($input)){
			return Db::update('album_class',$input," aclass_id='$id' ");
		}else{
			return false;
		}
	}
	/**
	 * 更新相册图片
	 *
	 * @param array $input
	 * @param int $id
	 * @return bool
	 */
	public function updatePic($input,$condition){
		if(is_array($input) && !empty($input)){
			return Db::update('album_pic',$input,$this->getCondition($condition));
		}else{
			return false;
		}
	}
	/**
	 * 删除分类
	 *
	 * @param string $id
	 * @return bool
	 */
	public function delClass($id){
		if(!empty($id)) {
			return Db::delete('album_class'," aclass_id ='".$id."' ");
		}else{
			return false;
		}
	}
	/**
	 * 根据店铺id删除图片空间相关信息
	 * 
	 * @param int $id
	 * @return bool
	 */
	public function delAlbum($id){
		$id	= intval($id);
		Db::delete('album_class'," store_id= ".$id);
		$pic_info = $this->getPicList(array(" store_id= ".$id),'','apic_cover');
		if(!empty($pic_info) && is_array($pic_info)){
			foreach($pic_info as $v){
				@unlink(BasePath.DS.ATTACH_GOODS.DS.$id.DS.$v['apic_cover']);
				@unlink(BasePath.DS.ATTACH_GOODS.DS.$id.DS.$v['apic_cover']."_tiny.".get_image_type($v['apic_cover']));
				@unlink(BasePath.DS.ATTACH_GOODS.DS.$id.DS.$v['apic_cover']."_small.".get_image_type($v['apic_cover']));
				@unlink(BasePath.DS.ATTACH_GOODS.DS.$id.DS.$v['apic_cover']."_mid.".get_image_type($v['apic_cover']));
				@unlink(BasePath.DS.ATTACH_GOODS.DS.$id.DS.$v['apic_cover']."_max.".get_image_type($v['apic_cover']));
				@unlink(BasePath.DS.ATTACH_GOODS.DS.$id.DS.$v['apic_cover']."_240x240.".get_image_type($v['apic_cover']));
			}
		}
		Db::delete('album_pic'," store_id= ".$id);
	}
	/**
	 * 删除图片
	 *
	 * @param string $id
	 * @return bool
	 */
	public function delPic($id){
		$pic_list = $this->getPicList(array('in_apic_id'=>$id),'','apic_cover');
		
		/**
		 * 删除图片
		 */
		foreach ($pic_list as $v) {
			@unlink(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$v['apic_cover']);
			@unlink(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$v['apic_cover']."_tiny.".get_image_type($v['apic_cover']));
			@unlink(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$v['apic_cover']."_small.".get_image_type($v['apic_cover']));
			@unlink(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$v['apic_cover']."_mid.".get_image_type($v['apic_cover']));
			@unlink(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$v['apic_cover']."_max.".get_image_type($v['apic_cover']));
			@unlink(BasePath.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$v['apic_cover']."_240x240.".get_image_type($v['apic_cover']));
			if (C('ftp_open') && C('thumb.save_type')==3){
				import('function.ftp');			
				$image_full_path = ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$v['apic_cover'];
				$_ext = '.'.get_image_type($image_full_path);
				if(!ftpcmd('error')) ftpcmd('delete', $image_full_path);
				if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_max'.$_ext);
				if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_mid'.$_ext);
				if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_small'.$_ext);
				if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_tiny'.$_ext);
				if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_240x240'.$_ext);
			}
		}
		if(!empty($id)) {
			return Db::delete('album_pic','apic_id in('.$id.')');
		}else{
			return false;
		}
	}
	/**
	 * 查询单条分类信息
	 *
	 * @param int $id 活动id
	 * @return array 一维数组
	 */
	public function getOneClass($param){
		if(is_array($param) && !empty($param)) {
			return Db::getRow(array_merge(array('table'=>'album_class'),$param));
		}else{
			return false;
		}
	}
	/**
	 * 根据id查询一张图片
	 *
	 * @param int $id 活动id
	 * @return array 一维数组
	 */
	public function getOnePicById($param){
		if(is_array($param) && !empty($param)) {
			return Db::getRow(array_merge(array('table'=>'album_pic'),$param));
		}else{
			return false;
		}
	}
	/**
	 * 构造查询条件
	 *
	 * @param array $condition 条件数组
	 * @return $condition_sql
	 */
	private function getCondition($condition){
		$condition_sql	= '';
		if($condition['apic_id'] != '') {
			$condition_sql .= " and apic_id= '{$condition['apic_id']}'";
		}
		if($condition['apic_name'] != '') {
			$condition_sql .= " and apic_name='".$condition['apic_name']."'";
		}
		if($condition['apic_tag'] != '') {
			$condition_sql .= " and apic_tag like '%".$condition['apic_tag']."%'";
		}
		if($condition['aclass_id'] != '') {
			$condition_sql .= " and aclass_id= '{$condition['aclass_id']}'";
		}
		if($condition['album_aclass.store_id'] != '') {
			$condition_sql .= " and `album_class`.store_id = '{$condition['album_aclass.store_id']}'";
		}
		if($condition['album_aclass.aclass_id'] != '') {
			$condition_sql .= " and `album_class`.aclass_id= '{$condition['album_aclass.aclass_id']}'";
		}
		if($condition['album_pic.store_id'] != '') {
			$condition_sql .= " and `album_pic`.store_id= '{$condition['album_pic.store_id']}'";
		}
		if($condition['album_pic.apic_id'] != '') {
			$condition_sql .= " and `album_pic`.apic_id= '{$condition['album_pic.apic_id']}'";
		}
		if($condition['store_id'] != '') {
			$condition_sql .= " and store_id= '{$condition['store_id']}'";
		}
		if($condition['aclass_name'] != '') {
			$condition_sql .= " and aclass_name='".$condition['aclass_name']."'";
		}
		if($condition['in_apic_id'] != '') {
			$condition_sql .= " and apic_id in (".$condition['in_apic_id'].")";
		}
		if($condition['gt_apic_id'] != '') {
			$condition_sql .= " and apic_id > '{$condition['gt_apic_id']}'";
		}
		if($condition['like_cover'] != '') {
			$condition_sql .= " and apic_cover like '%".$condition['like_cover']."%'";
		}
		if($condition['is_default'] != '') {
			$condition_sql .= " and is_default= '{$condition['is_default']}'";
		}
		if($condition['album_class.un_aclass_id'] != '') {
			$condition_sql .= " and `album_class`.aclass_id <> '{$condition['album_class.un_aclass_id']}'";
		}
		return $condition_sql;
	}
}
?>