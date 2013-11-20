<?php
/**
#	Project: ShopNC Multibuy System
#
#	Site: http://www.shopnc.net
#
#	$Id: pw_api.php 2 2011-01-30 09.40.28Z chinaweilu $
#
#	Copyright (C) 2007-2013 ShopNC Team. All Rights Reserved.
#
*/

define('P_W', true);
define('InShopNC',true);

error_reporting(7);
define('SHOPNC_ROOT',dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('D_P',SHOPNC_ROOT);
define('D_P',R_P);
function_exists('date_default_timezone_set') && date_default_timezone_set('Etc/GMT+0');

$data = require(SHOPNC_ROOT.'cache/setting.php');
require_once SHOPNC_ROOT.'config.ini.php';
if(!empty($config) && is_array($config)){
	$site_url = $config['site_url'];
	$version = $config['version'];
	$setup_date = $config['setup_date'];
	$gip = $config['gip'];
	$dbtype = $config['dbdriver'];
	$dbcharset = $config['db'][1]['dbcharset'];
	$dbserver = $config['db'][1]['dbhost'];
	$dbserver_port = $config['db'][1]['dbport'];
	$dbname = $config['db'][1]['dbname'];
	$db_pre = $config['tablepre'];
	$dbuser = $config['db'][1]['dbuser'];
	$dbpasswd = $config['db'][1]['dbpwd'];
	$lang_type = $config['lang_type'];
	$cookie_pre = $config['cookie_pre'];
	$tpl_name = $config['tpl_name'];
}
@ini_set('session.cookie_domain', $data['subdomain_suffix']);
session_save_path(SHOPNC_ROOT.'cache/session');
session_start();

require_once(SHOPNC_ROOT.'api/pw_api/security.php');
require_once(SHOPNC_ROOT.'api/pw_api/pw_common.php');
require_once(SHOPNC_ROOT.'api/pw_api/class_base.php');

define('UC_CONNECT', ($data['ucenter_connect_type']=='0' ? 'mysql' : 'NULL'));				// 连接 UCenter 的方式: mysql/NULL, 默认为空时为 fscoketopen()
//数据库相关 (mysql 连接时, 并且没有设置 UC_DBLINK 时, 需要配置以下变量)
define('UC_DBHOST', $data['ucenter_mysql_server']);			// UCenter 数据库主机
define('UC_DBUSER', $data['ucenter_mysql_username']);		// UCenter 数据库用户名
define('UC_DBPW',	$data['ucenter_mysql_passwd']);			// UCenter 数据库密码
define('UC_DBNAME', $data['ucenter_mysql_name']);			// UCenter 数据库名称
define('UC_DBCHARSET', strtoupper($dbcharset)=='UTF-8' ? 'utf8' : 'gbk');				// UCenter 数据库字符集
define('UC_DBTABLEPRE', '`'.$data['ucenter_mysql_name'].'`.'.$data['ucenter_mysql_pre']);		// UCenter 数据库表前缀
//通信相关
define('UC_KEY', $data['ucenter_app_key']);					// 与 UCenter 的通信密钥, 要与 UCenter 保持一致
define('UC_API', $data['ucenter_url']);						// UCenter 的 URL 地址, 在调用头像时依赖此常量
define('UC_CHARSET', $dbcharset);								// UCenter 的字符集
define('UC_IP', $data['ucenter_ip']);						// UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
define('UC_APPID', $data['ucenter_app_id']);				// 当前应用的 ID

require_once(SHOPNC_ROOT.'pw_client/class_db.php');
$GLOBALS['db'] = new UcDB($dbserver, $dbuser, $dbpasswd, $dbname, 0, $dbcharset);
$GLOBALS['tablepre'] = '`'.$dbname.'`.'.$db_pre;
unset($dbserver, $dbuser, $dbpasswd, $dbpasswd, $dbname, $db_pre);

$api = new api_client();
$response = $api->run($_POST + $_GET);
if ($response) {
	echo $api->dataFormat($response);
}