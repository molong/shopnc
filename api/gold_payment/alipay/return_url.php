<?php
/**
 * 支付宝返回地址
 *
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
/*//测试参数
$_GET['out_trade_no'] = 'p2011082939810198';
$_GET['extra_common_param'] = '2';*/

if (trim($_GET['extra_common_param']) == '2'){//积分兑换
	$_GET['act']	= 'pointorder_payment';
} elseif (trim($_GET['extra_common_param']) == '3'){//预存款
	$_GET['act']	= 'predeposit_payment';
}else {
	$_GET['act']	= 'gold_payment';
}
$_GET['op']		= 'return';
require_once(dirname(__FILE__).'/../../../index.php');
?>