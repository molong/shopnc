<?php
/**
 * 网银在线返回地址
 *
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
$_GET['act']	= 'payment';
$_GET['op']		= 'return';

//商户系统内部订单号
$_GET['out_trade_no'] = $_POST['v_oid'];

require_once('../../../index.php');
?>