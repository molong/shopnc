<?php
/**
 * 系统后台入口
 *
 * 入口程序
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */

//项目目录名，必须与当前目录名一致
define('ProjectName','admin');
//管理后台标识
define('NC_ADMIN', true);

//是否允许运行压缩后的框架
define('BUILDCORE',false);

require(dirname(__FILE__).'/../global.php');
require(dirname(__FILE__).'/../config.ini.php');

//引入control父类
require(BasePath.'/'.ProjectName.'/control/control.php');

if (BUILDCORE === true && file_exists(BasePath.'/cache/setting.php')){
	if (!file_exists(RUNCOREPATH)){
		require(BasePath.'/framework/core/runtime.php');
	}else{
		require(RUNCOREPATH);exit();
	}
}
require(BasePath.'/framework/core/runtime.php');