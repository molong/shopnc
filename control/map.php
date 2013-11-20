<?php
/**
 * 地图标记
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

class mapControl extends BaseMemberStoreControl {
	public function __construct() {
		parent::__construct();
	}
	/**
	 * 地图标记页
	 *
	 */
	public function indexOp(){
		/**
		 * 实例化模型
		 */
		$store_model = Model('store');
		$store_info = $store_model->shopStore(array('store_id'=>$_SESSION['store_id']));
		$area_array	= array();
		$area_array = explode("\t",$store_info["area_info"]);
		$city	= '';
		$address	= $store_info['store_address'];
		$store_name	= $store_info['store_name'];
		$map_city	= Language::get('member_map_city');
		if(strpos($area_array[0], $map_city) !== false){
			$city	= $area_array[0];
		}else {
			$city	= $area_array[1];
		}
		$map_model = Model('map');
		/**
		 * 保存信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			$map_array = array();
			$map_array['member_id'] = $store_info['member_id'];
			$map_array['member_name'] = $store_info['member_name'];
			$map_array['store_id'] = $store_info['store_id'];
			$map_array['store_name'] = $store_info['store_name'];
			$map_array['area_id'] = $store_info['area_id'];
			$map_array['area_info'] = $store_info['area_info'];
			$map_array['address'] = $store_info['store_address'];
			$map_array['point_lng'] = $_POST['point_lng'];
			$map_array['point_lat'] = $_POST['point_lat'];
			$map_array['map_api'] = 'baidu';
			
			if(intval($_POST['map_id']) > 0){
				$map_model->update(array('map_id'=>intval($_POST['map_id'])),$map_array);
			}else {
				$map_model->add($map_array);
			}
			showMessage(Language::get('member_map_success'),'index.php?act=map');//保存成功
		}
		$condition = array();
		$condition['member_id'] = $_SESSION['member_id'];
		$condition['store_id'] = $_SESSION['store_id'];
		$map_list = $map_model->getList($condition);
		/**
		 * 页面输出
		 */
		self::profile_menu('store_setting','store_map');
		Tpl::output('map',$map_list[0]);
		Tpl::output('city',$city);
		Tpl::output('address',$address);
		Tpl::output('store_name',$store_name);
		Tpl::output('menu_sign','store_setting');
		Tpl::output('menu_sign_url','index.php?act=store&op=store_setting');
		Tpl::output('menu_sign1','store_map');
		Tpl::showpage('store_map');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array	= array();
		switch ($menu_type) {
			case 'store_setting':
				$menu_array	= array(
				1=>array('menu_key'=>'store_setting','menu_name'=>Language::get('nc_member_path_store_config'),'menu_url'=>'index.php?act=store&op=store_setting'),
				2=>array('menu_key'=>'store_callcenter','menu_name'=>Language::get('nc_member_path_store_callcenter'),'menu_url'=>'index.php?act=store_callcenter'),
				3=>array('menu_key'=>'store_certified','menu_name'=>Language::get('nc_member_path_store_cert'),'menu_url'=>'index.php?act=store&op=store_certified'),
				4=>array('menu_key'=>'store_map','menu_name'=>Language::get('nc_member_path_store_map'),'menu_url'=>'index.php?act=map'),
				5=>array('menu_key'=>'store_slide','menu_name'=>Language::get('nc_member_path_store_slide'),'menu_url'=>'index.php?act=store&op=store_slide'),
				6=>array('menu_key'=>'store_printsetup','menu_name'=>Language::get('nc_member_path_store_printsetup'),'menu_url'=>'index.php?act=store&op=store_printsetup')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
