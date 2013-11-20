<?php
/**
 * api入口文件
 *
 * 统一入口，进行初始化信息
 * 
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net/
 * @link       http://www.shopnc.net/
 * @since      File available since Release v1.1
 */

error_reporting(7);
/**
 * 绝对路径
 */
define('BasePath',dirname(dirname(__FILE__)));
/**
 * 目录间隔符
 */
define('DS','/');
/**
 * 程序运行标识
 */
define('InShopNC',true);
/**
 * session 路径设置
 */
session_save_path(BasePath.DS.'cache'.DS.'session');
/**
 * 安装判断
 */
if (file_exists(BasePath."/config.ini.php")){
	require_once(BasePath.DS.'framework'.DS.'function'.DS.'core.php');
	require_once(BasePath.DS.'framework'.DS.'core'.DS.'shopncbase.php');
	require_once(BasePath.DS.'framework'.DS.'libraries'.DS.'language.php');//语言包类
	require_once(BasePath.DS.'framework'.DS.'libraries'.DS.'page.php');
	/**
	 * api类(所有外部调用的应该继承)
	 */
	class APIControl extends ShopNCBase {
		
		public function __construct(){
			parent::__construct();
			define('ATTACH_GOODS',ATTACH_PATH.'/store/goods');
		}
		/**
		 * 设置声明编码
		 */
		public function setHeader(){
			@header("Content-type: text/html; charset=".CHARSET);
		}
		/**
		* 格式化价格
		*
		* @param int	$price
		* @return string	$price_format
		*/
		public function getPriceFormat($price) {
			$price_format	= 0;
			$price_format	= number_format($price,2,'.','');
			return $price_format;
		}
		
		/**
		 * 语言包文件中语言内容
		 */
		public function readLanguage($file='common'){
			return Language::read($file);
		}
		/**
		 * 返回指定下标的数组内容
		 */
		public function getLanguage($key){
			return Language::get($key);
		}
		/**
		 * 返回包含商品路径的数组
		 */
		public function getGoodsImage($goods_array){
			require_once(BasePath.DS.'framework'.DS.'function'.DS.'goods.php');
			$goods_array['goods_image']	= thumb($goods_array);
			return $goods_array;
		}
	}
}else {
	exit('Access Invalid!');
}

