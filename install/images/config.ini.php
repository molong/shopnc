<?php

defined('InShopNC') or exit('Access Invalid!');

$config = array();

//网站地址，最后不要斜杠
$config['site_url'] = '===url===';

//版本号
$config['version'] = '20130705';

//安装日期
$config['setup_date'] = '===setup_date===';

//gzip压缩 0为关闭 1为开启
$config['gip'] = 0;

//***********************数据库设置*****************************//


//数据库连接驱动  mysqli,mysql,pdo_mysql
$config['dbdriver'] 	= '===dbdriver===';
$config['tablepre']		= '===tablepre===';
/**
 * 数据库主服务器设置（目前系统暂不采用分表部署策略默认只使用一台主数据库服务器）
 * @example
 * $config['db'][1]['dbhost']    = 'localhost';
 * $config['db'][1]['dbport']    = 3306;
 * $config['db'][1]['dbuser']    = 'root';
 * $config['db'][1]['dbpwd']     = 'root';
 * $config['db'][1]['dbname']    = 'shopnc_v2.4';
 * $config['db'][1]['dbcharset'] = 'UTF-8';
 */

$config['db'][1]['dbhost']  	= '===dbhost===';
$config['db'][1]['dbport']		= '===dbport===';
$config['db'][1]['dbuser']  	= '===dbuser===';
$config['db'][1]['dbpwd'] 	 	= '===dbpwd===';
$config['db'][1]['dbname']  	= '===dbname===';                  //在设置主从服务器部署或者使用pdo时，该项均必须填写正确且所有服务器的数据库名须与此设置相同！
$config['db'][1]['dbcharset']   = '===dbcharset===';

/**
 * 数据库从服务器设置( slave, 只读 ), 支持多组服务器设置, 当设置多组服务器时, 系统每次随机使用
 * @example
 * $config['db']['slave'][1]['dbhost']    = 'localhost';
 * $config['db']['slave'][1]['dbport']    = 3306;
 * $config['db']['slave'][1]['dbuser']    = 'root';
 * $config['db']['slave'][1]['dbpwd']     = 'root';
 * $config['db']['slave'][1]['dbname']    = 'shopnc_v2.3';
 * $config['db']['slave'][1]['dbcharset'] = 'UTF-8';
 *
 * $config['db']['slave'][2]['dbhost']  = 'localhost';
 * ...
 *
 */
$config['db']['slave'] = array();

//文件过期时间 单位：秒
$config['session_expire'] = 3600;

//语言包类型
$config['lang_type'] = 'zh_cn';

//cookie前缀
$config['cookie_pre'] = '===cookie_pre===';

//当前风格
$config['tpl_name'] = 'default';

/**
 * 商品图片存储方式
 * 
 * 1 本地存储(默认)
 * @example 
 * $config['thumb']['save_type'] = 1;
 * 2 本地存储，使用独立URL访问，指向网站商品附件目录（默认为upload），如http://pic.shopnc.net
 * @example 
 * $config['thumb']['save_type'] = 2;
 * $config['thumb']['url'] = 'http://pic.shopnc.net';
 * 3 后台开启了远程上传，并正确配置FTP，上传商品图片时会FTP上传远程服务器，同时删除本地图片
 * @example 
 * $config['thumb']['save_type'] = 3;
 * 
 */
$config['thumb']['save_type'] = 1;

/**
 * 缓存存储类型 支持类型为 file,memcache,xcache,apc,eaccelerator，默认为 file(文件缓存)
 * 商城基本配置信息始终为文件缓存
 * 
 */
$config['cache']['type'] = 'file';
/**
 * memcache 设置，可配置多台memcache服务器
 * @example 
 * $config['memcache']['prefix'] = '';				// memcache存取时值时，自动添加的前缀
 * $config['memcache'][1]['port'] = 11211;			// memcache 监听端口号
 * $config['memcache'][1]['host'] = '127.0.0.1';	// memcache服务器IP地址
 * $config['memcache'][1]['pconnect'] = 0;			// 是否长连接
 * 
 * $config['memcache'][2]......;
 * 
 */
$config['memcache']['prefix']      = '';
$config['memcache'][1]['port']     = 11211;
$config['memcache'][1]['host']     = '127.0.0.1';
$config['memcache'][1]['pconnect'] = 0;

/**
 * 全文检索设置
 * @example 
 * $config['fullindexer']['open'] 			= 0;				//0 关闭 1 开启
 * $config['fullindexer']['host']			= '127.0.0.1';		//Sphinx 主机名，或者 Sphinx 服务 socket 地址
 * $config['fullindexer']['port']			= 9312;				//Sphinx 主机端口,默认9312
 * $config['fullindexer']['index_product']	= 'product';		//Sphinx 配置中的商品索引名：例如，“product”。多个索引使用半角逗号 "," 隔开
 * $config['fullindexer']['index_shop']		= 'store';			//Sphinx 配置中的店铺索引名：例如，“shop”。多个索引使用半角逗号 "," 隔开
 * $config['fullindexer']['maxquerytime']	= 0;				//Sphinx 最大搜索时间，以毫秒为单位。参数必须是非负整数。默认值为 0，意思是不做限制
 * $config['fullindexer']['matchmode']		= SPH_MATCH_ANY;	//Sphinx 匹配模式,可选值为[0,1,2] 分别表示匹配所有查询词(AND查找)、表示匹配查询词中的任意一个(OR查找)、将整个查询看作一个词组，按顺序完整匹配。建议值为SPH_MATCH_ANY
 * $config['fullindexer']['querylimit']		= 1000;				//Sphinx 最大匹配数, 默认1000
 */
$config['fullindexer']['open'] 			= 0;
$config['fullindexer']['host']			= '127.0.0.1';
$config['fullindexer']['port']			= 9312;
$config['fullindexer']['index_product']	= 'main_product';
$config['fullindexer']['index_shop']	= 'main_store';
$config['fullindexer']['maxquerytime']	= 0;
$config['fullindexer']['matchmode']		= 1;
$config['fullindexer']['querylimit']	= 1000;
/**
 * 规格模式
 * @example
 * $config['spec_model']	= '0';		//（默认）卖家可以自由定义规格值名称
 * $config['spec_model']	= '1';		//卖家不可以定义规格值名称，前台规格值名称显示随后台规格设置动态修改
 */
$config['spec_model']	= '0';

/**
 * 买家购物支付到: 1支付到店铺 0支付到平台
 */
$config['payment'] = 1;

/**
 * 是否在底部输出系统运行信息true/false
 */
$config['debug'] = false;
/**
 * 商品上架有效期
 */
$config['product_indate'] = 7;