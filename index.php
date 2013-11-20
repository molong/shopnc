<?php
/**
 * 商城板块初始化文件
 *
 * 商城板块初始化文件，引用框架初始化文件
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
define('ProjectName','');
//是否压缩框架
define('BUILDCORE',false);
require(dirname(__FILE__).'/global.php');
require(dirname(__FILE__).'/config.ini.php');


if (BUILDCORE === true && file_exists(BasePath.'/cache/setting.php')){
	if (!file_exists(RUNCOREPATH)){
		require(BasePath.'/framework/function/build.php');
		$args = array('dbdriver'=>$config['dbdriver'], 'cache_type'=>$config['cache']['type'], 'lang_type'=>$config['lang_type']);
		build($args);
		header('Location: /');exit();
	}else{
		require(RUNCOREPATH);exit();
	}
}
require(BasePath.'/framework/core/runtime.php');