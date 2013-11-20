<?php
/*
 * 总体配置文件，包括API Key, Secret Key，以及所有允许调用的API列表
 * This file for configure all necessary things for invoke, including API Key, Secret Key, and all APIs list
 *
 * @Modified by mike on 17:54 2011/12/21.
 * @Modified by Edison tsai on 16:34 2011/01/13 for remove call_id & session_key in all parameters.
 * @Created: 17:21:04 2010/11/23
 * @Author:	Edison tsai<dnsing@gmail.com>
 * @Blog:	http://www.timescode.com
 * @Link:	http://www.dianboom.com
 */
header('Content-Type: text/html; charset=UTF-8');
session_start();

//包含配置信息
$data = require(BasePath.DS.'cache'.DS.'setting.php');
//判读站外分析是否开启
if($data['share_isuse'] != 1 || $data['share_renren_isuse'] != 1){
	echo "<script>alert('系统未开启该功能');</script>";
	echo "<script>window.close();</script>";	
	exit;
}
global $configrenren;		
$configrenren = new stdClass;
$configrenren->APIURL		= 'http://api.renren.com/restserver.do'; //RenRen网的API调用地址，不需要修改
$configrenren->APPID		= trim($data['share_renren_appid']);	//你的API ID，请自行申请
$configrenren->APIKey		= trim($data['share_renren_appkey']);	//你的API Key，请自行申请
$configrenren->SecretKey	= trim($data['share_renren_secretkey']);	//你的API 密钥
$configrenren->APIVersion	= '1.0';	//当前API的版本号，不需要修改
$configrenren->decodeFormat	= 'json';	//默认的返回格式，根据实际情况修改，支持：json,xml
$configrenren->redirecturi= SiteUrl.DS.'index.php?act=member_sharemanage&op=share_renren';//你的获取code的回调地址，也是accesstoken的回调地址
$configrenren->scope='publish_feed,photo_upload';
?>