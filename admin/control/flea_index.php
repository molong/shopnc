<?php
/**
 * 闲置主页seo设置
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.4
 */
defined('InShopNC') or exit('Access Invalid!');
class flea_indexControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('setting,flea_index_setting');
		if($GLOBALS['setting_config']['flea_isuse']!='1'){
			showMessage(Language::get('flea_isuse_off_tips'),'index.php?act=dashboard&op=welcome');
		}
	}
	function flea_indexOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();
		
		/**
		 * 实例化模型
		 */
		$model_setting = Model('setting');
		/**
		 * 保存信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			$update_array = array();
			$update_array['flea_site_name'] = trim($_POST['flea_site_name']);
			$update_array['flea_site_title'] = trim($_POST['flea_site_title']);
			$update_array['flea_site_description'] = trim($_POST['flea_site_description']);
			$update_array['flea_site_keywords'] = trim($_POST['flea_site_keywords']);
			$update_array['flea_hot_search'] = str_replace('，',',',trim($_POST['flea_hot_search']));

			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				showMessage($lang['nc_common_save_succ']);
			}else {
				showMessage($lang['nc_common_save_fail']);
			}
		}
		/**
		 * 读取设置内容 $list_setting
		 */
		$list_setting = $model_setting->getListSetting();
		/**
		 * 模板输出
		 */
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('setting.flea_index');	
	}
	
}