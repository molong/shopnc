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
define('ProjectName','modules/microshop');
//是否压缩框架
define('BUILDCORE',false);
require(dirname(dirname(dirname(__FILE__))).'/global.php');
require(dirname(dirname(dirname(__FILE__))).'/config.ini.php');
$config_file = dirname(__FILE__).'/config.ini.php';
if(is_file($config_file)) {
    require($config_file);
} else {
    @header("Location: install/index.php");die;
}

define('MICROSHOP_SITEURL',$config['microshop_site_url']);
if(empty($config['microshop_img_url'])) {
    define('MICROSHOP_IMG_URL',$config['site_url']);
} else {
    define('MICROSHOP_IMG_URL',$config['microshop_img_url']);
}
define('MICROSHOP_RESOURCE_PATH',$config['microshop_site_url'].'/resource');
define('MICROSHOP_TEMPLATES_PATH',$config['microshop_site_url'].'/templates/'.$config['tpl_name']);
define('MICROSHOP_BASE_TPL_PATH',dirname(__FILE__).'/templates/'.$config['tpl_name']);
define('MICROSHOP_SEO_KEYWORD',$config['seo_keywords']);
define('MICROSHOP_SEO_DESCRIPTION',$config['seo_description']);

//微商城框架扩展
require(BasePath.'/'.ProjectName.'/framework/function.php');
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


