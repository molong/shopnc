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
class point_shopControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}

    /**
     * 积分中心设置
     *
     */
	public function point_shop_settingOp(){
		$model_setting = Model('setting');
		//保存信息
		if (chksubmit()){
			//构造更新数据数组
			$update_array = array();
			//站外分享功能
			$update_array['pointprod_isuse'] = trim($_POST['pointprod_isuse']);
			$update_array['voucher_allow'] = trim($_POST['voucher_allow']);
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				showMessage(Language::get('nc_common_save_succ'));
			}else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		//读取设置内容 $list_setting
		$list_setting = $model_setting->getListSetting();
		//模板输出
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('setting.pointshop_setting');
	}



}
