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
class operationControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('setting');
	}

	/**
	 * 金币设置
	 */
	public function settingOp(){
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
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gold_isuse"], "require"=>"true","message"=>$lang['gold_isuse_check']),
				array("input"=>$_POST["gold_rmbratio"], "require"=>"true", "validator"=>"Number", "message"=>$lang['gold_rmbratio_isnum'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/*
				 * 构造更新数据数组
				 */
				$update_array = array();
				$update_array['promotion_allow'] = trim($_POST['promotion_allow']);
				$update_array['points_isuse'] = trim($_POST['points_isuse']);
				$update_array['gold_isuse'] = trim($_POST['gold_isuse']);
				$update_array['gold_rmbratio'] = trim($_POST['gold_rmbratio']);
				$update_array['predeposit_isuse'] = trim($_POST['predeposit_isuse']);
				$update_array['groupbuy_allow'] = trim($_POST['groupbuy_allow']);
				//积分中心
				$update_array['pointshop_isuse'] = trim($_POST['pointshop_isuse']);
				if(C('payment') != 1) $update_array['predeposit_isuse'] = 1;//支付到平台时强制开启预存款功能
				$result = $model_setting->updateSetting($update_array);
				if ($result === true){
					showMessage($lang['nc_common_save_succ']);
				}else {
					showMessage($lang['nc_common_save_fail']);
				}
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
		Tpl::showpage('operation.setting');
	}
}
