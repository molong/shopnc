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

class goods_albumControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('goods_album');
	}
	/**
	 * 相册列表
	 */
	public function listOp(){
		$model = Model();
		if (chksubmit()){
			if (is_array($_POST['aclass_id'])){
				foreach ($_POST['aclass_id'] as $k=>$v) {
					if (!is_numeric($v)){
						unset($_POST['aclass_id'][$k]);
					}
				}
			}
			if (!empty($_POST['aclass_id'])){
				$pic = $model->table('album_pic')->field('apic_cover')->where(array('aclass_id'=>array('in',$_POST['aclass_id'])))->select();
				if (is_array($pic)){
					foreach ($pic as $v) {
						$this->del_file($v['apic_cover']);
					}
				}
				$model->table('album_pic')->where(array('aclass_id'=>array('in',$_POST['aclass_id'])))->delete();
				$model->table('album_class')->where(array('aclass_id'=>array('in',$_POST['aclass_id'])))->delete();
				showMessage(Language::get('nc_common_del_succ'));				
			}
		}
		$condiiton = array();
		if (is_numeric($_GET['keyword'])){
			$condiiton['store.store_id'] = $_GET['keyword'];
			$store_name = $model->table('store')->getfby_store_id($_GET['keyword'],'store_name');
		}elseif (!empty($_GET['keyword'])){
			$store_name = $_GET['keyword'];
			$store_id = $model->table('store')->getfby_store_name($_GET['keyword'],'store_id');
			if (is_numeric($store_id)){
				$condiiton['store.store_id'] = $store_id;
			}else{
				$condiiton['store.store_id'] = 0;
			}
		}

		$model->table('album_class,store')->where($condiiton)->join('inner')->on('album_class.store_id=store.store_id');
		$list = $model->field('album_class.*,store.store_name')->page(10)->select();
		Tpl::output('page',$model->showpage());

		$model->cls()->table('album_pic')->field('aclass_id,count(*) as pcount')->group('aclass_id');
		if (is_array($list) && !empty($list)){
			foreach ($list as $v) {
				$class[] = $v['aclass_id'];
			}
			$model->where(array('aclass_id'=>array('in',implode(',',$class))));
		}
		$count = $model->select();
		if (is_array($count)){
			foreach ($count as $v) {
				$pic_count[$v['aclass_id']] = $v['pcount'];
			}
		}
		Tpl::output('pic_count',$pic_count);
		Tpl::output('list',$list);
		Tpl::output('store_name',$store_name);
		Tpl::showpage('goods_album.index');
	}
	/**
	 * 图片列表
	 */
	public function pic_listOp(){
		$model = Model();
		$condiiton = array();
		if (is_numeric($_GET['keyword'])){
			$condiiton['store_id'] = $_GET['keyword'];
			$store_name = $model->table('store')->getfby_store_id($_GET['keyword'],'store_name');
		}elseif (!empty($_GET['keyword'])){
			$store_name = $_GET['keyword'];
			$store_id = $model->table('store')->getfby_store_name($_GET['keyword'],'store_id');
			if (is_numeric($store_id)){
				$condiiton['store_id'] = $store_id;
			}else{
				$condiiton['store_id'] = 0;
			}
		}elseif (is_numeric($_GET['aclass_id'])){
			$condiiton['aclass_id'] = $_GET['aclass_id'];
		}
		$list = $model->table('album_pic')->where($condiiton)->page(40)->select();
		$show_page = $model->showpage();
		Tpl::output('page',$show_page);
		Tpl::output('list',$list);
		Tpl::output('store_name',$store_name);
		Tpl::showpage('goods_album.pic_list');
	}
	/**
	 * 删除相册
	 */
	public function aclass_delOp(){
		$aclass_id = intval($_GET['aclass_id']);
		if (!is_numeric($aclass_id)){
			showMessage(Language::get('wrong_argument'));
		}
		$model = Model();
		$pic = $model->table('album_pic')->field('apic_cover')->where(array('aclass_id'=>$aclass_id))->select();
		if (is_array($pic)){
			foreach ($pic as $v) {
				$this->del_file($v['apic_cover']);
			}
		}
		$model->table('album_pic')->where(array('aclass_id'=>$aclass_id))->delete();
		$model->table('album_class')->where(array('aclass_id'=>$aclass_id))->delete();
		showMessage(Language::get('nc_common_del_succ'));
	}

	/**
	 * 删除一张图片及其对应记录
	 *
	 */
	public function del_album_picOp(){
		list($apic_id,$filename) = @explode('|',$_GET['key']);
		if (!is_numeric($apic_id) || empty($filename)) exit('0');
		$this->del_file($filename);
		Model('album_pic')->where(array('apic_id'=>$apic_id))->delete();
		exit('1');
	}
	/**
	 * 删除多张图片
	 *
	 */
	public function del_more_picOp(){
		$model= Model('album_pic');
		$list = $model->where(array('apic_id'=>array('in',$_POST['delbox'])))->select();
		if (is_array($list)){
			foreach ($list as $v) {
				$this->del_file($v['apic_cover']);
			}
		}
		$model->where(array('apic_id'=>array('in',$_POST['delbox'])))->delete();
		redirect();
	}
	/**
	 * 删除图片文件
	 * 
	 */
	private function del_file($filename){
		//取店铺ID
		if (preg_match('/^(\d+_)/',$filename)){
			$store_id = substr($filename,0,strpos($filename,'_'));
		}else{
			$store_id = Model()->cls()->table('album_pic')->getfby_apic_cover($filename,'store_id');
		}
		$path = BasePath.'/'.ATTACH_GOODS.'/'.$store_id.'/'.$filename;
		
		$ext = strrchr($path, '.');
		$type = array('_tiny','_small','_mid','_max','_240x240');
		foreach ($type as $v) {
			if (is_file($fpath = $path.$v.$ext)){
				unlink($fpath);
			}
		}
		if (is_file($path)) unlink($path);
		if (C('ftp_open') && C('thumb.save_type')==3){
			import('function.ftp');			
			$image_full_path = ATTACH_GOODS.'/'.$store_id.'/'.$filename;
			if(!ftpcmd('error')) ftpcmd('delete', $image_full_path);
			if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_max'.$ext);
			if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_mid'.$ext);
			if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_small'.$ext);
			if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_tiny'.$ext);
			if(!ftpcmd('error')) ftpcmd('delete', $image_full_path.'_240x240'.$ext);
		}
	}
}