<?php
/**
 * 网站设置
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
class point_ruleControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}

	/**
	 * 积分设置
	 */
	public function point_rule_settingOp(){
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
		if (chksubmit()){
			/*
			 * 构造更新数据数组
			 */
			$update_array = array();
			$update_array['points_reg'] = intval($_POST['points_reg'])?$_POST['points_reg']:0;
			$update_array['points_login'] = intval($_POST['points_login'])?$_POST['points_login']:0;
			$update_array['points_comments'] = intval($_POST['points_comments'])?$_POST['points_comments']:0;
			$update_array['points_orderrate'] = intval($_POST['points_orderrate'])?$_POST['points_orderrate']:0;
			$update_array['points_ordermax'] = intval($_POST['points_ordermax'])?$_POST['points_ordermax']:0;
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				showMessage(Language::get('points_update_success'));
			}else {
				showMessage(Language::get('points_update_fail'));
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
		Tpl::showpage('setting.points_setting');
	}

}
