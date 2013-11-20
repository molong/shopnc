<?php
/**
 * 网站设置
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class binding_settingControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		//Language::read('binding_setting');
	}
	/**
	 * 绑定接口列表
	 */
	public function indexOp(){
		$api_arr = array();
		$api_arr['qqzone'] = array('name'=>'QQ空间','url'=>"http://qzone.qq.com");
		$api_arr['qqweibo'] = array('name'=>'腾讯微博','url'=>"http://t.qq.com");
		$api_arr['sinaweibo'] = array('name'=>'新浪微博','url'=>"http://www.weibo.com");
		$api_arr['renren'] = array('name'=>'人人网','url'=>"http://www.renren.com");
		
		$model_setting = Model('setting');
		$list_setting = $model_setting->getListSetting();
		//qqzone
		if($list_setting['qqzone_isuse']){
			$api_arr['qqzone']['isuse'] = '1';
		}
		//sina
		if($list_setting['qqweibo_isuse']){
			$api_arr['qqweibo']['isuse'] = '1';
		}
		//qqweibo
		if($list_setting['sinaweibo_isuse']){
			$api_arr['sinaweibo']['isuse'] = '1';
		}
		//renren
		if($list_setting['renren_isuse']){
			$api_arr['renren']['isuse'] = '1';
		}
		Tpl::output('api_arr',$api_arr);
		Tpl::showpage('binding_setting');
	}
	
	/**
	 * sina微博设置
	 */
	public function sina_settingOp(){
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
				array("input"=>$_POST["sina_wb_akey"], "require"=>"true","message"=>Language::get('sina_wb_akey_error')),
				array("input"=>$_POST["sina_wb_skey"], "require"=>"true","message"=>Language::get('sina_wb_skey_error'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/*
				 * 构造更新数据数组
				 */
				$update_array = array();
				$update_array['sina_isuse'] = trim($_POST['sina_isuse']);
				$update_array['sina_wb_akey'] = trim($_POST['sina_wb_akey']);
				$update_array['sina_wb_skey'] = trim($_POST['sina_wb_skey']);
				$update_array['sina_appcode'] = trim($_POST['sina_appcode']);
				$result = $model_setting->updateSetting($update_array);
				if ($result === true){
					showMessage(Language::get('sina_update_success'));
				}else {
					showMessage(Language::get('sina_update_fail'));
				}
			}
		}
		$is_exist = function_exists('curl_init');
		if ($is_exist){
			/**
			 * 读取设置内容 $list_setting
			 */
			$list_setting = $model_setting->getListSetting();
			Tpl::output('list_setting',$list_setting);
		}
		Tpl::output('is_exist',$is_exist);
		/**
		 * 模板输出
		 */
		Tpl::showpage('setting.sina_setting');
	}
	/**
	 * QQ互联设置
	 */
	public function qq_settingOp(){
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
				array("input"=>$_POST["qq_appid"], "require"=>"true","message"=>Language::get('qq_appid_error')),
				array("input"=>$_POST["qq_appkey"], "require"=>"true","message"=>Language::get('qq_appkey_error'))
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/*
				 * 构造更新数据数组
				 */
				$update_array = array();
				$update_array['qq_isuse'] = trim($_POST['qq_isuse']);
				$update_array['qq_appcode'] = trim($_POST['qq_appcode']);
				$update_array['qq_appid'] = trim($_POST['qq_appid']);
				$update_array['qq_appkey'] = trim($_POST['qq_appkey']);
				$result = $model_setting->updateSetting($update_array);
				if ($result === true){
					showMessage(Language::get('qq_update_success'));
				}else {
					showMessage(Language::get('qq_update_fail'));
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
		Tpl::showpage('setting.qq_setting');
	}
}
