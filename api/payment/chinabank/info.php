<?php
$info_array = array(
	'code'=>'chinabank',//基本信息
	'name'=>'网银在线即时到帐',
	'content'=>'网银在线(www.chinabank.com.cn)以网上转账方式将相应交易款划转到商户指定银行账号中。',
	'is_online'=>'1',
	'website'   => 'http://www.chinabank.com.cn',
	'version'   => '1.0',
	'currency'  => '人民币',
	'config'    => array(
        'chinabank_account'   => array(//帐号
            'text'  => '网银在线商户号',
            'desc'  => '',
            'type'  => 'text',
        ),
        'chinabank_key'       => array(//密匙
            'text'  => '网银在线密钥',
            'desc'  => '',
            'type'  => 'text',
        ),
    ),
);