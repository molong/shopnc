<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想商城系统 项目的一部分
//
// Copyright (c) 2007 - 2012 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : index.php
 * ....安装程序
 *
 * @copyright Copyright (c) 2007 - 2012 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Thu Jul 02 16:26:40 CST 2012
 */
define('InShopNC',true);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
@ini_set ('memory_limit', '512M');
@set_time_limit(1000);
@set_magic_quotes_runtime(0);
include('images/config.ini.php');

//参数设置
define('SOFT_VERSION', '2.4 正式版');
define('SOFT_RELEASE', $config['version']);
define('ROOT_PATH', dirname(__FILE__).'/../');//网站根目录
define('SOFT_NAME', 'ShopNC商城系统'.SOFT_VERSION);
define('DBCHARSET','UTF8');//编码 分为 UTF8 GBK
define('SOFT_DEMO','1');//演示数据 分为 1为可选 2为精减安装
if(function_exists('date_default_timezone_set')){
    date_default_timezone_set('Asia/Shanghai');
}
//----------------------语言包
$lang = array(
'license'=>'<div class="license"><h1>ShopNC商城系统安装协议</h1>
<p>感谢您选择ShopNC商城系统。希望我们的努力能为您提供一个快速搭建功能强大的社区化电子商务平台建设的解决方案。本系统是天津市网城创想科技责任有限公司自主开发，独立拥有版权的一套面向成熟社区、地方门户、大型卖场和行业龙头的企业级社区化网上商城系统。官方网址为 http://www.shopnc.net，官方论坛网址为 http://bbs.shopnc.net。</p>
<p>用户须知：本协议是您与网城创想公司之间关于您安装使用网城创想公司提供的ShopNC商城系统及服务的法律协议。无论您是个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议。请您审阅并接受或不接受本协议条款。如您不同意本协议条款或网城创想公司随时对其的修改，您应不使用或主动取消网城创想公司提供的ShopNC商城系统。否则，您的任何对ShopNC商城系统使用的行为将被视为您对本服务条款全部的完全接受，包括接受网城创想对服务条款随时所做的任何修改。</p>
<p>本服务条款一旦发生变更，网城创想公司将在网页上公布修改内容。修改后的服务条款一旦在网页上公布即有效代替原来的服务条款。如果您选择接受本条款，即表示您同意接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，网城创想公司有权随时中止或终止您对ShopNC商城系统的使用资格并保留追究相关法律责任的权利。</p>
<p>在理解、同意、并遵守本协议的全部条款后，方可开始使用ShopNC商城系统。您可能与网城创想公司直接签订另一书面协议，以补充或者取代本协议的全部或者任何部分。</p>
<p>网城创想拥有本软件的全部知识产权。本软件只供许可协议，并非出售。网城创想只允许您在遵守本协议各项条款的情况下复制、下载、安装、使用或者以其他方式受益于本软件的功能或者知识产权。</p>
<h3>I. 协议许可的权利</h3>
<ol>
<li>您可以在完全遵守本许可协议的基础上，将本软件应用于非商业用途，而不必支付软件版权许可费用。</li>
<li>您可以在协议规定的约束和限制范围内修改ShopNC商城系统源代码(如果被提供的话)或界面风格以适应您的网站要求。</li>
<li>您拥有使用本软件构建的网站中全部会员资料、文章、商品及相关信息的所有权，并独立承担与使用本软件构建的网站内容的审核、注意义务，确保其不侵犯任何人的合法权益，独立承担因使用ShopNC商城系统和服务带来的全部责任，若造成网城创想公司或用户损失的，您应予以全部赔偿。</li>
<li>本协议是您与网城创想公司之间关于您安装使用网城创想公司提供的ShopNC商城系统及服务的法律协议，若您需将ShopNC商城系统或服务用于商业用途，必须另行获得网城创想的授权许可，您在获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权利，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
</ol>
<p></p>
<h3>II. 协议规定的约束和限制</h3>
<ol>
<li>未获网城创想公司商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登录http://www.shopnc.net参考相关说明，也可以致电+86-022-87631069了解详情。</li>
<li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
<li>无论用途如何、是否经过修改或美化、修改程度如何，只要使用ShopNC商城系统的整体或任何部分，未经授权许可，页面页脚处的ShopNC商城系统的版权信息都必须保留，而不能清除或修改。</li>
<li>禁止在ShopNC商城系统的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
<li>如果您未能遵守本协议的条款，您的授权将被终止，所许可的权利将被收回，同时您应承担相应法律责任。</li>
</ol>
<p></p>
<h3>III. 有限担保和免责声明</h3>
<ol>
<li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
<li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
<li>网城创想公司不对使用本软件构建的平台中的会员、商品或文章信息承担责任，全部责任由您自行承担。</li>
<li>网城创想公司对提供的软件和服务之及时性、安全性、准确性不作担保，由于不可抗力因素、网城创想公司无法控制的因素（包括黑客攻击、停断电等）等造成软件使用和服务中止或终止，而给您造成损失的，您同意放弃追究网城创想公司责任的全部权利。</li>
<li>网城创想公司特别提请您注意，网城创想公司为了保障公司业务发展和调整的自主权，网城创想公司拥有随时经或未经事先通知而修改服务内容、中止或终止部分或全部软件使用和服务的权利，修改会公布于网城创想公司网站相关页面上，一经公布视为通知。网城创想公司行使修改或中止、终止部分或全部软件使用和服务的权利而造成损失的，网城创想公司不需对您或任何第三方负责。</li>
</ol>
<p></p>
<p>有关ShopNC商城系统最终用户授权协议、商业授权与技术服务的详细内容，均由网城创想公司独家提供。网城创想公司拥有在不事先通知的情况下，修改授权协议和服务价目表的权利，修改后的协议或价目表对自改变之日起的新授权用户生效。</p>
<p>一旦您开始安ShopNC商城系统，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权利的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权利。</p>
<p></p>
<p align=right>天津市网城创想科技有限责任公司（2013年03月01日）</p>
</div>',
'agreement_yes' => '我同意，继续安装',
'agreement_no' => '我不同意',
'title_install' => ' ShopNC商城系统 V'.SOFT_VERSION.' 安装程序',
'error_quit_msg' => '您必须解决以上问题，安装才可以继续',
'click_to_back' => '点击返回上一步',

'writeable' => '可写',
'nodir' => '目录不存在',
'nofile' => '文件所在目录不可写',
'unwriteable' => '不可写',
'env_check' => '环境检查',
'install_required' => '所需配置',
'install_best' => '推荐',
'curr_server' => '当前服务器',
'priv_check' => '权限检查',
'step1_file' => '目录文件',
'step1_need_status' => '所需状态',
'step1_status' => '当前状态',
'supportted' => '支持',
'none' => '无',
'unsupportted' => '不支持',
'func_depend' => '函数检查',
'check_result' => '检查结果',//检查结果
'suggestion' => '建议',//建议
'old_step' => '上一步',
'new_step' => '下一步',
'notset' => '不限制',
'project' => '项目',
'func_name' => '函数名称',//函数名称

'php_check' => '请使用php 5.2 或 5.3 版本，当前版本为'.phpversion(),
'mysql_connect_comment' => '请检查 mysql 模块是否正确加载',
'file_get_contents_comment' => '该函数需要 php.ini 中 allow_url_fopen 选项开启。请联系空间商，确定开启了此项功能',
'step_env_check_title' => '开始安装',
'step_env_check_desc' => '环境以及文件目录权限检查',
'step_db_init_title' => '安装数据库',
'step_db_init_desc' => '正在执行数据库安装',
'step_app_reg_title' => '设置运行环境',
'step_app_reg_desc' => '检测服务器环境',

'os' => '操作系统',
'php' => 'PHP 版本',
'unlimit' => '不限制',
'version' => '版本',
'gdversion' => 'GD 库',
'allow' => '允许',
'unix' => 'LINUX',
'diskspace' => '磁盘空间',

'tips_siteinfo' => '请填写站点信息',
'sitename' => '站点名称',
'siteurl' => '站点 URL',
'error_message' => '错误信息',
'siteinfo_sitename_invalid' => '站点名称为空，或者格式错误，请检查',

'database_errno_2003' => '无法连接数据库，请检查数据库是否启动，数据库服务器地址是否正确',
'database_errno_1044' => '无法创建新的数据库，请检查数据库名称填写是否正确',
'database_errno_1045' => '无法连接数据库，请检查数据库用户名或者密码是否正确',
'database_errno_1064' => 'SQL 语法错误',
'database_connect_error' => '数据库连接错误',
'database_version_old' => '数据库版本过低，请使用4.1以上版本的数据库',

'dbname_invalid' => '数据库名为空，请填写数据库名称',
'tablepre_invalid' => '数据表前缀为空，或者格式错误，请检查',
'dbport_invvalid' => '数据库端口不能为空，请检查',
'admin_username_invalid' => '非法用户名，用户名长度不应当超过 15 个英文字符，且不能包含特殊字符，一般是中文，字母或者数字',
'admin_password_invalid' => '密码和上面不一致，请重新输入',
'admin_invalid' => '您的信息管理员信息没有填写完整，请仔细填写每个项目',
'tips_dbinfo' => '数据库信息',
'dbhost' => '数据库服务器',
'dbuser' => '数据库用户名',
'dbpw' => '数据库密码',
'dbname' => '数据库名',
'tablepre' => '数据表前缀',
'dbport' =>'数据库端口',
'tips_admininfo' => '网站信息',
'username' => '管理员账号',
'password' => '管理员密码',
'password_comment' => '密码长度最少为6位',
'password2' => '重复密码',

'dbinfo_dbhost_invalid' => '数据库服务器为空，或者格式错误，请检查',
'dbinfo_dbname_invalid' => '数据库名为空，或者格式错误，请检查',
'admininfo_sitename_invalid' => '网站名称不能为空',
'admininfo_username_invalid' => '管理员用户名为空，或者格式错误，请检查',
'admininfo_password_invalid' => '密码长度最少为6位，请填写',
'admininfo_password2_invalid' => '两次密码不一致，请检查',
'install_in_processed' => '正在安装...',
'create_table' => '数据表',
'succeed' => '建立成功',
'install_succeed' => '安装成功，点击进入',
'forceinstall' => '强制安装',
'dbinfo_forceinstall_invalid' => '当前数据库当中已经含有同样表前缀的数据表，您可以修改“表名前缀”来避免删除旧的数据，或者选择强制安装。强制安装会删除旧数据，且无法恢复',
'forceinstall_check_label' => '删除数据，重新安装',
'insert_demo_data' => '演示数据',
'database_nonexistence' => '数据库操作对象不存在',
'method_undefined' => '未定义方法',
'file_all_pass'=>'文件权限全部通过',
'install_succ_remark'=>'<p class=\'nest\'>系统安装完成</p>
		<p class=\'nes\'>1. 请登录<a href=\'http://'.$_SERVER['HTTP_HOST'].trim(str_replace(strstr($_SERVER['SCRIPT_NAME'], '/install'),"",$_SERVER['SCRIPT_NAME'])).'/admin\' target=\'_blank\'>系统后台</a> 》 工具 》 清理缓存 》 清理全部缓存</p>
		<p class=\'nes\'>2. 系统后台地址：<a href=\'http://'.$_SERVER['HTTP_HOST'].trim(str_replace(strstr($_SERVER['SCRIPT_NAME'], '/install'),"",$_SERVER['SCRIPT_NAME'])).'/admin\' target=\'_blank\'>http://'.$_SERVER['HTTP_HOST'].trim(str_replace(strstr($_SERVER['SCRIPT_NAME'], '/install'),"",$_SERVER['SCRIPT_NAME'])).'/admin</a></p>
		<p class=\'nes\'>3. 系统前台地址：<a href=\'http://'.$_SERVER['HTTP_HOST'].trim(str_replace(strstr($_SERVER['SCRIPT_NAME'], '/install'),"",$_SERVER['SCRIPT_NAME'])).'\' target=\'_blank\'>http://'.$_SERVER['HTTP_HOST'].trim(str_replace(strstr($_SERVER['SCRIPT_NAME'], '/install'),"",$_SERVER['SCRIPT_NAME'])).'</a></p>
		<p class=\'nes\'>4. 如果安装了演示数据，<font color=\'FF0000\'>测试账号和密码均为shopnc</font></p>',
'undefine_func'=>'环境不支持的函数',
'php_version_too_low'=>'PHP版本过低，最低版本要求5.2或以上版本',
'confirm_set_remark'=>'我已经仔细阅读了以上说明，可以进入前台了'
);
//-----------------------语言包end

//-----------------------变量参数
$func_items = array(
'mysql_connect',
'fsockopen',
'gethostbyname',
'file_get_contents'
);

$env_items = array(
'php' => array('c' => 'PHP_VERSION', 'r' => '5.2', 'b' => '5.3'),
'gdversion' => array('r' => '1.0', 'b' => '2.0'),
'diskspace' => array('r' => '100M', 'b' => 'notset'),
);
$dirfile_items = array(
'cache' => array('type' => 'dir', 'path' => './cache'),
'cache_adv' => array('type' => 'dir', 'path' => './cache/adv'),
'cache_adv_change' => array('type' => 'dir', 'path' => './cache/adv_change'),
'cache_brand' => array('type' => 'dir', 'path' => './cache/brand'),
'cache_category' => array('type' => 'dir', 'path' => './cache/category'),
'cache_class_tag' => array('type' => 'dir', 'path' => './cache/class_tag'),
'cache_flea_area' => array('type' => 'dir', 'path' => './cache/flea_area'),
'cache_groupbuy' => array('type' => 'dir', 'path' => './cache/groupbuy'),
'cache_rec_position' => array('type' => 'dir', 'path' => './cache/rec_position'),
'cache_session' => array('type' => 'dir', 'path' => './cache/session'),
'cache_setting' => array('type' => 'file', 'path' => './cache/setting.php'),
'resource_clickswf' => array('type' => 'file', 'path' => './resource/clickswf/adv_click.xml'),
'resource_phpqrcode' => array('type' => 'dir', 'path' => './resource/phpqrcode/temp'),
'upload' => array('type' => 'dir', 'path' => './upload'),
'upload_activity' => array('type' => 'dir', 'path' => './upload/activity'),
'upload_adv' => array('type' => 'dir', 'path' => './upload/adv'),
'upload_article' => array('type' => 'dir', 'path' => './upload/article'),
'upload_auth' => array('type' => 'dir', 'path' => './upload/auth'),
'upload_avatar' => array('type' => 'dir', 'path' => './upload/avatar'),
'upload_brand' => array('type' => 'dir', 'path' => './upload/brand'),
'upload_common' => array('type' => 'dir', 'path' => './upload/common'),
'upload_complain' => array('type' => 'dir', 'path' => './upload/complain'),
'upload_coupon' => array('type' => 'dir', 'path' => './upload/coupon'),
'upload_editor' => array('type' => 'dir', 'path' => './upload/editor'),
'upload_flea' => array('type' => 'dir', 'path' => './upload/flea'),
'upload_groupbuy' => array('type' => 'dir', 'path' => './upload/groupbuy'),
'upload_inform' => array('type' => 'dir', 'path' => './upload/inform'),
'upload_link' => array('type' => 'dir', 'path' => './upload/link'),
'upload_pointprod' => array('type' => 'dir', 'path' => './upload/pointprod'),
'upload_rec_position' => array('type' => 'dir', 'path' => './upload/rec_position'),
'upload_spec' => array('type' => 'dir', 'path' => './upload/spec'),
'upload_store' => array('type' => 'dir', 'path' => './upload/store'),
'upload_watermark' => array('type' => 'dir', 'path' => './upload/watermark'),
'config' => array('type' => 'file', 'path' => './config.ini.php'),
'install' => array('type' => 'dir', 'path' => './install'),
'sql_back' => array('type' => 'dir', 'path' => './sql_back'),
'uc_client' => array('type' => 'dir', 'path' => './uc_client'),
'api_payment' => array('type' => 'file', 'path' => './api/payment/payment.inc.php')
);

$form_app_reg_items = array(
	'siteinfo' => array(
	'sitename' => array('type' => 'text', 'required' => 1, 'reg' => '/^.*$/', 'value' => array('type' => 'constant', 'var' => 'SOFT_NAME')),
	)
);

$form_db_init_items = array(
	'dbinfo' => array(
		'dbhost' => array('type' => 'text', 'required' => 1, 'reg' => '/^.+$/', 'value' => array('type' => 'var', 'var' => 'dbhost')),
		'dbname' => array('type' => 'text', 'required' => 1, 'reg' => '/^.+$/', 'value' => array('type' => 'var', 'var' => 'dbname')),
		'dbuser' => array('type' => 'text', 'required' => 0, 'reg' => '/^.*$/', 'value' => array('type' => 'var', 'var' => 'dbuser')),
		'dbpw' => array('type' => 'text', 'required' => 0, 'reg' => '/^.*$/', 'value' => array('type' => 'var', 'var' => 'dbpw')),
		'tablepre' => array('type' => 'text', 'required' => 0, 'reg' => '/^.*+/', 'value' => array('type' => 'var', 'var' => 'tablepre')),
		'dbport' => array('type' => 'text', 'required' => 1, 'reg' => '/^.*+/', 'value' => array('type' => 'var', 'var' => 'dbport')),
	),
	'admininfo' => array(
		'sitename' => array('type' => 'text', 'required' => 1, 'reg' => '/^.*$/','value' => array('type' => 'var', 'var' => 'shopnc_name')),
		'username' => array('type' => 'text', 'required' => 1, 'reg' => '/^.*$/'),
		'password' => array('type' => 'password', 'required' => 1, 'reg' => '/^.{6,}$/'),
		'password2' => array('type' => 'password', 'required' => 0, 'reg' => '/^.+$/'),
	)
);

//---------------------------------安装部分

//步骤
$allow_method = array('show_license', 'env_check', 'db_init');
$step = intval(getgpc('step', 'R')) ? intval(getgpc('step', 'R')) : 0;
$method = isset($allow_method[$step]) ? $allow_method[$step] : '';

//检测标识文件是否存在，如果存在，那么停止安装
if (file_exists('lock')){
	@header("Content-type: text/html; charset=UTF-8");
	echo "系统已经安装过了，如果要重新安装，那么请删除install目录下的lock文件";
	exit;
}

if(empty($method)) {
	show_msg('method_undefined', $method, 0);
}
if(!class_exists('dbstuff')) {
	show_msg('database_nonexistence', '', 0);
}

if($method == 'show_license') {//声明
	show_license();
} elseif($method == 'env_check') {//检测环境
	$php_version = intval(substr(str_replace('.','',phpversion()),0,2));
	if($php_version < 52) {
		show_msg('php_check','',0);
	}

	function_check($func_items);

	env_check($env_items);

	dirfile_check($dirfile_items);

	show_env_result($env_items, $dirfile_items);

} elseif($method == 'db_init') {//数据库信息
	$submit = true;
	$error_msg = array();

	if(isset($form_db_init_items) && is_array($form_db_init_items)) {
		foreach($form_db_init_items as $key => $items) {
			$$key = getgpc($key, 'p');
			if(!isset($$key) || !is_array($$key)) {
				$submit = false;
				break;
			}
			foreach($items as $k => $v) {
				$tmp = $$key;
				$$k = $tmp[$k];
				if(empty($$k) || !preg_match($v['reg'], $$k)) {
					if(empty($$k) && !$v['required']) {
						continue;
					}
					$submit = false;
					$error_msg[$key][$k] = 1;
				}
			}
		}
	} else {
		$submit = false;
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if($password != $password2) {
			$error_msg['admininfo']['password2'] = 1;
			$submit = false;
		}
		$forceinstall = isset($_POST['dbinfo']['forceinstall']) ? $_POST['dbinfo']['forceinstall'] : '';
		$dbname_not_exists = true;
		if(!empty($dbhost) && empty($forceinstall)) {
			$dbname_not_exists = check_db($dbhost, $dbuser, $dbpw, $dbname, $tablepre,$dbport);
			if(!$dbname_not_exists) {
				$form_db_init_items['dbinfo']['forceinstall'] = array('type' => 'checkbox', 'required' => 0, 'reg' => '/^.*+/');
				$error_msg['dbinfo']['forceinstall'] = 1;
				$submit = false;
				$dbname_not_exists = false;
			}
		}
	}

	if($submit) {

		$step = $step + 1;
		if(empty($dbname)) {
			show_msg('dbname_invalid', $dbname, 0);
		} else {
			if(!@mysql_connect($dbhost.":".$dbport, $dbuser, $dbpw)) {
				$errno = mysql_errno();
				$error = mysql_error();
				if($errno == 1045) {
					show_msg('database_errno_1045', $error, 0);
				} elseif($errno == 2003) {
					show_msg('database_errno_2003', $error, 0);
				} else {
					show_msg('database_connect_error', $error, 0);
				}
			}

			if(mysql_get_server_info() > '4.1') {
				mysql_query("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET ".DBCHARSET);
			} else {
				show_msg('database_version_old', $error, 0);
			}

			if(mysql_errno()) {
				show_msg('database_errno_1044', mysql_error(), 0);
			}
			//mysql_close();
		}

		if(strpos($tablepre, '.') !== false) {
			show_msg('tablepre_invalid', $tablepre, 0);
		}

		if($username && $password) {
			if(strlen($username) > 15 || preg_match("/^$|^c:\\con\\con$|　|[,\"\s\t\<\>&]|^游客|^Guest/is", $username)) {
				show_msg('admin_username_invalid', $username, 0);
			}
		} else {
			show_msg('admininfo_invalid', '', 0);
		}

		config_edit();
		//入库
		$db = new dbstuff;
		$db->connect($dbhost.":".$dbport, $dbuser, $dbpw, $dbname, DBCHARSET);

		if (strtoupper(DBCHARSET) == 'GBK'){
			$sqlfile = 'sql/shopnc_gbk.sql';
			//演示数据
			if (getgpc('demo_date', 'R') == '1'){
				$demo_sqlfile = 'sql/shopnc_data_gbk.sql';
			}
		}else {
			$sqlfile = 'sql/shopnc_utf8.sql';
			//演示数据
			if (getgpc('demo_date', 'R') == '1'){
				$demo_sqlfile = 'sql/shopnc_data_utf8.sql';
			}
		}
		$sql = file_get_contents($sqlfile);
		$sql = str_replace("\r\n", "\n", $sql);

		show_header();

		show_install();
		show_footer(0);

		runquery($sql);
		if (getgpc('demo_date', 'R') == '1'){
			$demo_sql = file_get_contents($demo_sqlfile);
			$demo_sql = str_replace("\r\n", "\n", $demo_sql);
			runquery($demo_sql);
		}
		//系统设置中网站名称的修改
		/**
		 * 转码
		 */
		if (strtoupper(DBCHARSET) == 'GBK'){
			$sitename = iconv('UTF-8','GBK',$sitename);
			$username = iconv('UTF-8','GBK',$username);
			$password = iconv('UTF-8','GBK',$password);
		}
		/**
		 * 产生随机的md5_key，来替换系统默认的md5_key值
		 */
		$md5_key = md5(random(4).substr(md5($_SERVER['SERVER_ADDR'].$_SERVER['HTTP_USER_AGENT'].$dbhost.$dbuser.$dbpw.$dbname.substr(time(), 0, 6)), 8, 6).random(10));
		$db->query("UPDATE {$tablepre}setting SET value='".$sitename."' WHERE name='site_name'");
		$db->query("UPDATE {$tablepre}setting SET value='".$md5_key."' WHERE name='md5_key'");
		//管理员帐号密码
		$db->query("INSERT INTO {$tablepre}admin (`admin_id`,`admin_permission`,`admin_name`,`admin_password`,`admin_login_time`,`admin_login_num`,`admin_is_super`) VALUES ('1', 'login|setting|region|payment|mailtemplates|admin|goods_class|brand|goods|recommend|groupbuy|goods_stat|store_grade|store_class|store|member|notice|trade|article_class|article|document|link|navigation|db|consulting|adv|share_link|activity|coupon|coupon_class|clear_cache','$username','". md5($password) ."', '".time()."' ,'0',1);");
		//新增一个标识文件，用来屏蔽重新安装
		$fp = @fopen(ROOT_PATH.'install/lock','wb+');
		@fclose($fp);
		exit();
	}
	$dbhost = 'localhost';
	$dbname = 'shopnc';
	$dbuser = 'root';
	$dbpw = 'root';
	$tablepre = 'shopnc_';
	$dbport = '3306';
	$shopnc_name = 'ShopNC商城系统演示站';
	show_form($form_db_init_items, $error_msg);
}

//输出声明
function show_license() {
	global $step;
	$next = $step + 1;
	show_header();
	$license = str_replace('  ', '&nbsp; ', lang('license'));
	$lang_agreement_yes = lang('agreement_yes');
	$lang_agreement_no = lang('agreement_no');
	echo <<<EOT
		</div>
		<div class="main">
			<div class="licenseblock">$license</div>
			<div class="btnbox marginbot">
				<form method="post" action="index.php">
				<input type="hidden" name="step" value="$next">
				<input type="submit" name="submit" value="{$lang_agreement_yes}" style="padding: 2px">&nbsp;
				<input type="button" name="exit" value="{$lang_agreement_no}" style="padding: 2px" onclick="javascript: window.close(); return false;">
				</form>
			</div>
EOT;
	show_footer();
}
//输出页头
function show_header() {
	global $step;
	$version = SOFT_VERSION;
	$release = SOFT_RELEASE;
	$title = lang('title_install');
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>$title</title>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<meta content="ShopNC" name="Copyright" />
<script type="text/javascript">
	function $(id) {
		return document.getElementById(id);
	}
	function showmessage(message) {
		$('notice').value += message + "\\r\\n";
	}
</script>

</head>
<div class="container">
	<div class="header">
		<h1>$title</h1>
		<span>V$version $release</span>
EOT;

	$step > 0 && show_step($step);
}
//输出页脚
function show_footer($quit = true) {
?>
			<div class="footer"><p>Powered by <a href="http://www.shopnc.net" target="_blank">ShopNC </a>© v2.4 2007-2013 <a href="http://www.shopnc.net" target="_blank">网城创想</a> Inc.</p>
				<p>版权所有 天津市网城创想科技有限责任公司 津ICP备080001719号</p>
				<p>软件著作权登记号: 2008SR07843</p></div>
		</div>
		</div>
		</body>
		</html>
<?php
	$quit && exit();
}
//安装内容
function show_install() {
?>
		<script type="text/javascript">
		var message_t = 0;
		function showmessage(message) {
			document.getElementById('notice').value += message + "\r\n";
			message_t = message_t + 1;
			if(message_t > 125){
				document.getElementById("message1").style.display = 'block';
				document.getElementById("message2").style.display = 'block';
				document.getElementById("message3").style.display = 'block';
			}
		}
		function initinput() {
			window.open('../');
		}
		function change_input(){
			if(document.getElementById("checkbox_install_succ").checked == true){
				document.getElementById("laststep").className = 'las-2';
				document.getElementById("laststep").disabled = false;
			}else{
				document.getElementById("laststep").className = 'las-1';
				document.getElementById("laststep").disabled = true;
			}
		}
		</script>
	<div class="main">
		<div class="btnbox"><textarea name="notice" class="shop-tex"  readonly="readonly" id="notice"></textarea></div>
		<div class="btnbox marginbot" style="display: none;" id="message1">
			<?php echo lang('install_succ_remark');?>
		</div>
		<div class="btnbox marginbot" style="display: none;" id="message2">
			<input type="checkbox" id="checkbox_install_succ" onclick="change_input();"><label class="ziti-c" for="checkbox_install_succ"><?php echo lang('confirm_set_remark');?></label>
		</div>
		<div class="btnbox marginbot" style="display: none;" id="message3">
	<input type="button" class="las-1" name="submit"  disabled style="height: 25" id="laststep" onclick="initinput()">
	</div>
<?php
}
//----------------------方法集
function getgpc($k, $t='GP') {
	$t = strtoupper($t);
	switch($t) {
		case 'GP' : isset($_POST[$k]) ? $var = &$_POST : $var = &$_GET; break;
		case 'G': $var = &$_GET; break;
		case 'P': $var = &$_POST; break;
		case 'C': $var = &$_COOKIE; break;
		case 'R': $var = &$_REQUEST; break;
	}
	return isset($var[$k]) ? $var[$k] : '';
}
//产生随机字符
function random($length, $numeric = 0) {
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}
//语言包
function lang($lang_key, $force = true) {
	return isset($GLOBALS['lang'][$lang_key]) ? $GLOBALS['lang'][$lang_key] : ($force ? $lang_key : '');
}

//检测函数是否存在
function function_check(&$func_items) {
	$func = array();
	foreach($func_items as $item) {
		if(!function_exists($item)) $func[] = $item;
	}
	if(!empty($func)) show_msg('undefine_func', $func);
}
//抛出信息
function show_msg($error_no, $error_msg = 'ok', $success = 1, $quit = TRUE) {
	show_header();
	global $step;

	$title = lang($error_no);
	$comment = '';

	if($error_msg) {
		if(!empty($error_msg)) {
			foreach ((array)$error_msg as $k => $v) {
				if(is_numeric($k)) {
					$comment .= "<li><em class=\"red\">".lang($v)."</em></li>".lang($v.'_comment', false);
				}
			}
		}
	}

	if($step > 0) {
		echo "<div class=\"desc\"><b>$title</b><ul>$comment</ul>";
	} else {
		echo "</div><div class=\"main\" style=\"margin-top: -123px;\"><b>$title</b><ul style=\"line-height: 200%; margin-left: 30px;\">$comment</ul>";
	}

	if($quit) {
		echo '<br /><span class="red">'.lang('error_quit_msg').'</span><br /><br /><br />';
	}

	echo '<input type="button" onclick="history.back()" value="'.lang('click_to_back').'" /><br /><br /><br />';

	echo '</div>';

	$quit && show_footer();
}
//系统环境检查
function env_check(&$env_items) {
	foreach($env_items as $key => $item) {
		if($key == 'php') {
			$env_items[$key]['current'] = PHP_VERSION;
		} elseif($key == 'gdversion') {
			$tmp = function_exists('gd_info') ? gd_info() : array();
			$env_items[$key]['current'] = empty($tmp['GD Version']) ? 'noext' : $tmp['GD Version'];
			unset($tmp);
		} elseif($key == 'diskspace') {
			if(function_exists('disk_free_space')) {
				$env_items[$key]['current'] = floor(disk_free_space(ROOT_PATH) / (1024*1024)).'M';
			} else {
				$env_items[$key]['current'] = 'unknow';
			}
		} elseif(isset($item['c'])) {
			$env_items[$key]['current'] = constant($item['c']);
		}

		$env_items[$key]['status'] = 1;
		if($item['r'] != 'notset' && strcmp($env_items[$key]['current'], $item['r']) < 0) {
			$env_items[$key]['status'] = 0;
		}
	}
}
//文件权限检查
function dirfile_check(&$dirfile_items) {
	foreach($dirfile_items as $key => $item) {
		$item_path = $item['path'];
		if($item['type'] == 'dir') {
			if(!dir_writeable(ROOT_PATH.$item_path)) {
				if(is_dir(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nodir';
				}
			} else {
				$dirfile_items[$key]['status'] = 1;
				$dirfile_items[$key]['current'] = '+r+w';
			}
		} else {
			if(file_exists(ROOT_PATH.$item_path)) {
				if(is_writable(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				}
			} else {
				if ($fp = @fopen(ROOT_PATH.$item_path,'wb+')){
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
					@fclose($fp);
					@unlink(ROOT_PATH.$item_path);
				}else {
					$dirfile_items[$key]['status'] = -2;
					$dirfile_items[$key]['current'] = 'nofile';
				}
			}
		}
	}
}
function dir_writeable($dir) {
	$writeable = 0;
	if(!is_dir($dir)) {
		@mkdir($dir, 0755);
	}else {
		@chmod($dir,0755);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}

//环境检查输出
function show_env_result(&$env_items, &$dirfile_items) {

	$env_str = $file_str = $dir_str ='';

	foreach($env_items as $key => $item) {
		if($key == 'php' && strcmp($item['current'], $item['r']) < 0) {
			show_msg('php_version_too_low', $item['current'], 0);
		}
		$status = 1;
		if($item['r'] != 'notset') {
			if(intval($item['current']) && intval($item['r'])) {
				if(intval($item['current']) < intval($item['r'])) {
					$status = 0;
					$env_wrong_sign = true;//是否进行下一步，这里为报错
				}
			} else {
				if(strcmp($item['current'], $item['r']) < 0) {
					$status = 0;
					$env_wrong_sign = true;//是否进行下一步，这里为报错
				}
			}
		}
		$env_str .= "<tr>\n";
		$env_str .= "<td>".lang($key)."</td>\n";
		$env_str .= "<td class=\"padleft\">".lang($item['r'])."</td>\n";
		$env_str .= "<td class=\"padleft\">".lang($item['b'])."</td>\n";
		$env_str .= ($status ? "<td class=\"pdleft1\">" : "<td class=\"red pdleft1\">").$item['current']."</td>\n";
		$env_str .= "</tr>\n";
	}

	foreach($dirfile_items as $key => $item) {
		$tagname = $item['type'] == 'file' ? 'File' : 'Dir';
		if ($item['status'] !== 1){
			$variable = $item['type'].'_str';
			$$variable .= "<tr>\n";
			$$variable .= "<td>$item[path]</td><td class=\"pdleft1\">".lang('writeable')."</td>\n";
			if($item['status'] == 1) {
				$$variable .= "<td class=\"pdleft1\">".lang('writeable')."</td>\n";
			} elseif($item['status'] == -1) {
				$dir_wrong_sign = true;//是否进行下一步，这里为报错
				$$variable .= "<td class=\"red pdleft1\">".lang('nodir')."</td>\n";
			}  elseif($item['status'] == -2) {
				$dir_wrong_sign = true;//是否进行下一步，这里为报错
				$$variable .= "<td class=\"red pdleft1\">".lang('nofile')."</td>\n";
			} else {
				$dir_wrong_sign = true;//是否进行下一步，这里为报错
				$$variable .= "<td class=\"red pdleft1\">".lang('unwriteable')."</td>\n";
			}
			$$variable .= "</tr>\n";
		}
	}
	//通过检测
	if (empty($$variable)){
		$file_str .= "<tr>\n";
		$file_str .= "<td colspan='3' align='center'>".lang('file_all_pass')."</td>\n";
		$file_str .= "</tr>\n";
	}

	show_header();

	echo "<h2 class=\"title\">".lang('env_check')."</h2>\n";
	echo "<table class=\"tb\" style=\"margin:20px 0 20px 55px;\">\n";
	echo "<tr>\n";
	echo "\t<th>".lang('project')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('install_required')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('install_best')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('curr_server')."</th>\n";
	echo "</tr>\n";
	echo $env_str;
	echo "</table>\n";

	echo "<h2 class=\"title\">".lang('priv_check')."</h2>\n";
	echo "<table class=\"tb\" style=\"margin:20px 0 20px 55px;width:90%;\">\n";
	echo "\t<tr>\n";
	echo "\t<th>".lang('step1_file')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('step1_need_status')."</th>\n";
	echo "\t<th class=\"padleft\">".lang('step1_status')."</th>\n";
	echo "</tr>\n";
	echo $file_str;
	echo $dir_str;
	echo "</table>\n";
	if ($env_wrong_sign == true || $dir_wrong_sign == true || $fun_wrong_sign == true){
		show_next_step(1);
	}else {
		show_next_step(2);
	}
	show_footer();
}
//显示下一步
function show_next_step($step) {
	echo "<form action=\"index.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"step\" value=\"$step\" />";
	$nextstep = "<input type=\"button\" onclick=\"history.back();\" value=\"".lang('old_step')."\"><input type=\"submit\" value=\"".lang('new_step')."\">\n";
	echo "<div class=\"btnbox marginbot\">".$nextstep."</div>\n";
	echo "</form>\n";
}
//当前步骤
function show_step($step) {

	global $method;

	$laststep = 4;
	$title = lang('step_'.$method.'_title');
	$comment = lang('step_'.$method.'_desc');

	$stepclass = array();
	for($i = 1; $i <= $laststep; $i++) {
		$stepclass[$i] = $i == $step ? 'current' : ($i < $step ? '' : 'unactivated');
	}
	$stepclass[$laststep] .= ' last';

	echo <<<EOT
	<div class='dress dress$step'><h3>$title</h3><p>$comment</p></div>
</div>
<div class="main">
EOT;
}
//输出表单
function show_form(&$form_items, $error_msg) {
	global $step;
	if(empty($form_items) || !is_array($form_items)) {
		return;
	}
	show_header();
	show_setting('start');
	show_setting('hidden', 'step', $step);
	$is_first = 1;

	foreach($form_items as $key => $items) {
		global ${'error_'.$key};
		if($is_first == 0) {
			echo '</table>';
		}

		if(!${'error_'.$key}) {
			show_tips('tips_'.$key);
		} else {
			show_error('tips_admin_config', ${'error_'.$key});
		}

		echo '<table class="tb2">';

		foreach($items as $k => $v) {
			global $$k;
			if(!empty($error_msg)) {
				$value = isset($_POST[$key][$k]) ? $_POST[$key][$k] : '';
			} else {
				if(isset($v['value']) && is_array($v['value'])) {
					if($v['value']['type'] == 'constant') {
						$value = defined($v['value']['var']) ? constant($v['value']['var']) : '';
					} else {
						$value = $GLOBALS[$v['value']['var']];
					}
				} else {
					$value = '';
				}
			}
			if($v['type'] == 'checkbox') {
				$value = '1';
			}

			show_setting($k, $key.'['.$k.']', $value, $v['type'], isset($error_msg[$key][$k]) ? $key.'_'.$k.'_invalid' : '');
		}

		//当为环境配置的步骤时，单独输出是否增加演示数据
		if ($step == 2 && $key == 'dbinfo'){
			if ($_POST['demo_date'] == '1'){
				$demo_check = "checked='checked'";
			}
			echo "\n".'<tr><th class="tbopt">&nbsp;'.lang('insert_demo_data').':'."</th>\n<td>";
			echo SOFT_DEMO == '1'?"<input type='checkbox' name='demo_date' id='demo_date' $demo_check value='1' checked='checked' /><label for='demo_date'>". lang('insert_demo_data') ."</label>\n":lang('none');
			echo "&nbsp;</td>\n<td>&nbsp;";
			if($error) {
				$comment = '<span class="red">'.(is_string($error) ? lang($error) : lang($setname.'_error')).'</span>';
			} else {
				$comment = lang($setname.'_comment', false);
			}
			echo "$comment</td>\n</tr>\n";
		}

		if($is_first) {
			$is_first = 0;
		}
	}
	show_setting('', 'submitname', 'new_step', 'submit');
	show_setting('end');
	show_footer();
}
//设置html内容样式
function show_setting($setname, $varname = '', $value = '', $type = 'text|password|checkbox', $error = '') {
	if($setname == 'start') {
		echo "<form method=\"post\" action=\"index.php\">\n";
		return;
	} elseif($setname == 'end') {
		echo "\n</table>\n</form>\n";
		return;
	} elseif($setname == 'hidden') {
		echo "<input type=\"hidden\" name=\"$varname\" value=\"$value\">\n";
		return;
	}

	echo "\n".'<tr><th class="tbopt'.($error ? ' red' : '').'">&nbsp;'.(empty($setname) ? '' : lang($setname).':')."</th>\n<td>";
	if($type == 'text' || $type == 'password') {
		$value = htmlspecialchars($value);
		echo "<input type=\"$type\" name=\"$varname\" value=\"$value\" size=\"35\" class=\"txt\">";
	} elseif($type == 'submit') {
		$value = empty($value) ? 'next_step' : $value;
		echo "<input type=\"submit\" name=\"$varname\" value=\"".lang($value)."\" class=\"btn\">\n";
	} elseif($type == 'checkbox') {
		if(!is_array($varname) && !is_array($value)) {
			echo'<label><input type="checkbox" name="'.$varname.'" value="'.$value."\" style=\"border: 0\">".lang($setname.'_check_label')."</label>\n";
		}
	} else {
		echo $value;
	}

	echo "</td>\n<td>&nbsp;";
	if($error) {
		$comment = '<span class="red">'.(is_string($error) ? lang($error) : lang($setname.'_error')).'</span>';
	} else {
		$comment = lang($setname.'_comment', false);
	}
	echo "$comment</td>\n</tr>\n";
	return true;
}

function show_tips($tip, $title = '', $comment = '', $style = 1) {
	global $lang;
	$title = empty($title) ? lang($tip) : $title;
	$comment = empty($comment) ? lang($tip.'_comment', FALSE) : $comment;
	if($style) {
		echo "<div class=\"desc\"><b>$title</b>";
	} else {
		echo "</div><div class=\"main\">$title<div class=\"desc1 marginbot\"><ul>";
	}
	$comment && print('<br>'.$comment);
	echo "</div>";
}
//检查数据库
function check_db($dbhost, $dbuser, $dbpw, $dbname, $tablepre, $dbport) {
	if(!function_exists('mysql_connect')) {
		show_msg('undefine_func', 'mysql_connect', 0);
	}
	if(!@mysql_connect($dbhost.":".$dbport, $dbuser, $dbpw)) {
		$errno = mysql_errno();
		$error = mysql_error();
		if($errno == 1045) {
			show_msg('database_errno_1045', $error, 0);
		} elseif($errno == 2003) {
			show_msg('database_errno_2003', $error, 0);
		} else {
			show_msg('database_connect_error', $error, 0);
		}
	} else {
		if($query = mysql_query("SHOW TABLES FROM $dbname")) {
			while($row = mysql_fetch_row($query)) {
				if(preg_match("/^$tablepre/", $row[0])) {
					return false;
				}
			}
		}
	}
	return true;
}
//写入config文件
function config_edit() {
	extract($GLOBALS, EXTR_SKIP);
	$config = 'images/config.ini.php';

	$configfile = @file_get_contents($config);
	$configfile = trim($configfile);
	$configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;

	if (strtoupper(DBCHARSET) == 'GBK'){
		$charset = 'GBK';
	}else {
		$charset = 'UTF-8';
	}
	$dbtype = 'mysql';
	$HttpHost   = "http://".$_SERVER['HTTP_HOST'];
	$ScriptName = $_SERVER['SCRIPT_NAME'];
	$SubPath    = trim(str_replace(strstr($ScriptName, '/install'),"",$ScriptName));
	$SubPath    = $SubPath != "" ? $SubPath : "";
	$url    = $HttpHost.$SubPath;

	/**
	 * 检测mysqli安装
	 */
	if (extension_loaded('mysqli')){
		$dbtype = 'mysqli';
	}
	$cookie_pre = strtoupper(substr(md5(random(6).substr($_SERVER['HTTP_USER_AGENT'].md5($_SERVER['SERVER_ADDR'].$dbhost.$dbuser.$dbpw.$dbname.substr(time(), 0, 6)), 8, 6).random(5)),0,4)).'_';
	$configfile = str_replace("===url===",			$url, $configfile);
	$configfile = str_replace("===tablepre===",		$tablepre, $configfile);
	$configfile = str_replace("===dbdriver===",	$dbtype, $configfile);
	$configfile = str_replace("===dbcharset===",	$charset, $configfile);
	$configfile = str_replace("===dbhost===",		$dbhost, $configfile);
	$configfile = str_replace("===dbuser===",		$dbuser, $configfile);
	$configfile = str_replace("===dbpwd===",			$dbpw, $configfile);
	$configfile = str_replace("===dbname===",		$dbname, $configfile);
	$configfile = str_replace("===dbport===",		$dbport, $configfile);
	$configfile = str_replace("===setup_date===",	date("Y-m-d H:i:s",time()), $configfile);
	$configfile = str_replace("===cookie_pre===",	$cookie_pre, $configfile);

	if (phpversion() > 5.0){
		@file_put_contents('../config.ini.php', $configfile);
	}
}
//执行sql
function runquery($sql) {
	global $lang, $tablepre, $db;

	if(!isset($sql) || empty($sql)) return;

	$sql = str_replace("\r", "\n", str_replace('#__', $tablepre, $sql));
	$ret = array();
	$num = 0;
	foreach(explode(";\n", trim($sql)) as $query) {
		$ret[$num] = '';
		$queries = explode("\n", trim($query));
		foreach($queries as $query) {
			$ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
		}
		$num++;
	}
	unset($sql);

	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$line = explode('`',$query);
				$data_name = $line[1];
				showjsmessage(lang('create_table').' '.$data_name.' ... '.lang('succeed'));
				$db->query(droptable($data_name));
				/**
				 * 转码
				 */
				if (strtoupper(DBCHARSET) == 'GBK'){
					$query = iconv('GBK','UTF-8',$query);
				}
				$db->query(createtable($query));
				unset($line,$data_name);
			} else {
				$db->query($query);
			}
		}
	}
}
//抛出JS信息
function showjsmessage($message) {
	echo '<script type="text/javascript">showmessage(\''.addslashes($message).' \');</script>'."\r\n";
	flush();
	ob_flush();
}

function droptable($table_name){
	return "DROP TABLE IF EXISTS `". $table_name ."`;";
}

function createtable($sql) {
	preg_match("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*COMMENT=(.*)$/isU", $sql,$match);
	list(,,$type,$comment) = $match;
	$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
	(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=".DBCHARSET : " TYPE=$type")." COMMENT=$comment";
}

//---------------------方法集 end
//---------------------数据库操作类
class dbstuff {
	var $querynum = 0;
	var $link;
	var $histories;
	var $time;
	var $tablepre;

	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset, $pconnect = 0, $tablepre='', $time = 0) {
		$this->time = $time;
		$this->tablepre = $tablepre;
		if($pconnect) {
			if(!$this->link = mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$this->halt('Can not connect to MySQL server');
			}
		} else {
			if(!$this->link = mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
				$this->halt('Can not connect to MySQL server');
			}
		}

		if($this->version() > '4.1') {
			if($dbcharset) {
				mysql_query("SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->link);
			}

			if($this->version() > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->link);
			}
		}

		if($dbname) {
			mysql_select_db($dbname, $this->link);
		}

	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function result_first($sql, &$data) {
		$query = $this->query($sql);
		$data = $this->result($query, 0);
	}

	function fetch_first($sql, &$arr) {
		$query = $this->query($sql);
		$arr = $this->fetch_array($query);
	}

	function fetch_all($sql, &$arr) {
		$query = $this->query($sql);
		while($data = $this->fetch_array($query)) {
			$arr[] = $data;
		}
	}

	function query($sql, $type = '', $cachetime = FALSE) {
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querynum++;
		$this->histories[] = $sql;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '', $sql = '') {
		//		echo mysql_error();echo "<br />";
	}
}
//----------------------数据库操作类 end
?>