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
 * ....升级程序
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
$config = '../../config.ini.php';
include($config);
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
	$file_expire = $config['session_expire'];
	$lang_type = $config['lang_type'];
	$cookie_pre = $config['cookie_pre'];
	$tpl_name = $config['tpl_name'];
}
define('DBCHARSET',$dbcharset);
define('SiteUrl',$site_url);
if ($version != '20130705'){
	@header("Content-type: text/html; charset=UTF-8");
	echo "已经安装完成或版本错误，本程序只适用于“ShopNC 2.4”的系统。";
	exit;
}

$db = new dbstuff();
if (strtoupper(DBCHARSET) == 'GBK'){
	$dbcharset = 'gbk';
}else {
	$dbcharset = 'utf8';
}
$dbserver = $dbserver.":".$dbserver_port;
$db->connect($dbserver, $dbuser, $dbpasswd, $dbname, $dbcharset);
$tablepre = $db_pre;
$current = $_GET['act'];


//新增表和字段
function update_db() {
	if (strtoupper(DBCHARSET) == 'GBK'){
		$sqlfile = 'gbk.sql';
	}else {
		$sqlfile = 'utf8.sql';
	}
	$sql = file_get_contents($sqlfile);
	$sql = str_replace("\r\n", "\n", $sql);
	runquery($sql);
}
//数据
function update_adv() {
	if (strtoupper(DBCHARSET) == 'GBK'){
		$sqlfile = 'gbk_add.sql';
	}else {
		$sqlfile = 'utf8_add.sql';
	}
	$sql = file_get_contents($sqlfile);
	$sql = str_replace("\r\n", "\n", $sql);
	runquery($sql);
}

//执行sql
function runquery($sql) {
	global $tablepre, $db;

	if(!isset($sql) || empty($sql)) return;

	$sql = str_replace("\r", "\n", str_replace('shopnc_', $tablepre, $sql));
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

	foreach($ret as $key => $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$line = explode('`',$query);
				$data_name = $line[1];
				showjsmessage('数据表'.' '.$data_name.' ... '.'建立成功',$key);
				/**
				 * 转码
				 */
				if (strtoupper(DBCHARSET) == 'GBK'){
					$query = iconv('GBK','UTF-8',$query);
				}
				$db->query($query);
			} elseif(substr($query, 0, 11) == 'ALTER TABLE') {
				if (strtoupper(DBCHARSET) == 'GBK'){
					$query = iconv('GBK','UTF-8',$query);
				}
				$db->query($query);
			} else {
				$db->query($query);
			}
		}
	}
}
//JS信息
function showjsmessage($message,$n=1) {
	echo 'setTimeout("showmessage(\''.addslashes($message).' \')",'.($n*30+50).');';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ShopNC 2.4闲置市场功能安装程序</title>
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="update.css" type="text/css" media="all" />
<meta content="ShopNC" name="Copyright" />
</head>
<div class="container">
	<div class="header"></div>
	<div class="main">
	<table class="menu">
			<tr class="menu_tr">
				<td align="center" <?php if($current == '') echo 'class="current"'; ?>>功能安装说明</td>
				<td align="center" <?php if($current == '1') echo 'class="current"'; ?>>数据库更新</td>
				<td align="center" <?php if($current == '2') echo 'class="current"'; ?>>必要数据更新</td>
				<td align="center" <?php if($current == '3') echo 'class="current"'; ?>>功能安装完成</td>
			</tr>
			<tr>
				<td colspan="4" class="menu_td">
				<?php if ($current == ''){ ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;重要说明：本安装包仅针对ShopNC商城系统2.4版本添加闲置市场功能的安装，不包含在原有1.X版本基础上添加闲置市场功能。请在安装前提前做好备份工作，对于在原有系统进行过二次开发的客户，在安装中请注意对于修改过文件的备份及调整。否则直接安装可能会导致系统不能正常运行或页面出现不正常等情况。<span style="color: #FF0000;">如因安装造成您原有二次开发功能的错误或丢失，官方不予承担任何责任及损失，请您慎重操作。
				</span><br /><br />
				
			  <div>
			  	
			  	
			  </div>
				<div class="btnbox marginbot">
					<form method="get" action="index.php">
					<input type="hidden" name="act" value="1">
					<input type="hidden" name="go" value="2">
					<input type="submit" value="确认安装" onclick="javascript:if(!confirm('是否安装闲置市场功能')){return false;}" style="padding: 2px">
					</form>
				</div>
			  <?php } elseif($current == '1') { ?>
			  <div class="btnbox"><textarea name="notice" class="shop-tex"  readonly="readonly" id="notice"></textarea></div>
					<script type="text/javascript">
					function showmessage(message) {
						document.getElementById('notice').value += message + "\r\n";
					}
					<?php update_db();?>
					</script>
			  <?php } elseif($current == '2') { ?>
					<?php update_adv();?>
			  必要数据更新完成。
			  <?php } else { 
			  	?>
			  功能安装完成，进入<a href="<?php echo SiteUrl;?>/admin" target="_blank">系统后台</a>更新缓存后即可使用。
			  <?php } ?>
			  </td>
			</tr>
	</table>
		<div class="footer"><p>Powered by <a href="http://www.shopnc.net" target="_blank">ShopNC </a>© v2.4 2007-2013 <a href="http://www.shopnc.net" target="_blank">网城创想</a> Inc.</p>
		<p>版权所有 天津市网城创想科技有限责任公司 津ICP备080001719号</p>
		<p>软件著作权登记号: 2008SR07843</p></div>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
<?php if ($_GET['go'] == '2'){ ?>
	window.setTimeout("javascript:location.href='index.php?act=2&go=3'", 1500);
<?php } ?>
<?php if ($_GET['go'] == '3'){ ?>
	window.setTimeout("javascript:location.href='index.php?act=3'", 1500);
<?php } ?>
</script>
<?php
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

	function cache_gc() {
		$this->query("DELETE FROM {$this->tablepre}sqlcaches WHERE expiry<$this->time");
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
