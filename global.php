<?php
/**
 * 入口文件
 *
 * 统一入口，进行初始化信息
 * 
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net/
 * @link       http://www.shopnc.net/
 * @since      File available since Release v1.1
 */

error_reporting(E_ALL & ~E_NOTICE);
/**
 * 绝对路径
 */
define('BasePath',str_replace('\\','/',dirname(__FILE__)));
/**
 * 目录间隔符
 */
define('DS','/');
/**
 * 程序运行标识
 */
define('InShopNC',true);
/**
 * 计算运行时间
 */
define('StartTime',microtime(true));
define('TIMESTAMP',time());
/**
 * 安装判断
 */
if (!is_file(BasePath."/install/lock") && is_file(BasePath."/install/index.php")){
	if (ProjectName != ''){
		@header("location: ../install/index.php");
	}else{
		@header("location: install/index.php");
	}
	exit;
}
/**
 * 压缩后的框架路径
 */
define('RUNCOREPATH',BasePath.'/cache/~shopnc.php');