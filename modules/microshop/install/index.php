<?php
/**
 * FILE_NAME : index.php
 * 微商城安装程序
 *
 * @copyright Copyright (c) 2007 - 2013 www.shopnc.net 
 * @author ShopNC Develop Team 
 */
define('InShopNC',true); 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
@ini_set ('memory_limit', '512M');
@set_time_limit(1000);
@set_magic_quotes_runtime(0);

$config = '../../../config.ini.php';
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
if(is_file('../config.ini.php') && $current != '2') {
    @header("Content-type: text/html; charset=UTF-8");
    echo "您已经安装过微商城模块。";
    exit;
}

//新增表
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

//插入数据
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

//写入配置文件
function config_edit() {
    global $site_url;
    $configfile = @file_get_contents('config.ini.php');
    $configfile = trim($configfile);
    $configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
    $configfile = str_replace("===microshop_site_url===",$site_url.'/modules/microshop',$configfile);
    if (phpversion() > 5.0){
        @file_put_contents('../config.ini.php', $configfile);
    }
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
        <title>ShopNC商城系统微商城模块安装程序</title>
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
                    <td align="center" <?php if($current == '2') echo 'class="current"'; ?>>功能安装完成</td>
                </tr>
                <tr>
                    <td colspan="4" class="menu_td">
                        <?php if ($current == ''){ ?>
                        <p style="text-indent:2em;line-height:20px;">微商城是与ShopNC商城系统紧密结合的购物分享模块，通过流行的瀑布流展示方式，在一个垂直的领域内，通过关注、喜欢、分享、评论让有相同兴趣爱好的人聚集在一个社区，而商品的链接可以来自本商城或者外部网站，比如淘宝、天猫，社区自身通过展示广告、点击购买分成取得收入。</p>
                        <p style="text-indent:2em;line-height:20px;">这种模式将相同兴趣爱好的人聚集在一起， 这些人相互之间可以分享经验、推荐商品。在为用户提供讨论场所的同时，也为商家找到了精准用户，从商业模式的角度来说，这是一种链条非常短，非常高效的商业模式。</p>
                        <p style="text-indent:2em;line-height:20px;"><span style="color: #FF0000;">请提前做好数据备份，如因安装造成您原有二次开发功能的错误或丢失，官方不予承担任何责任及损失，请您慎重操作。</span></p>
                        <div class="btnbox marginbot">
                            <form method="get" action="index.php">
                                <input type="hidden" name="act" value="1">
                                <input type="submit" value="确认安装" onclick="javascript:if(!confirm('确认安装微商城模块？')){return false;}" style="padding: 2px">
                            </form>
                        </div>
                        <?php } elseif($current == '1') { ?>
                        <div class="btnbox"><textarea name="notice" class="shop-tex"  readonly="readonly" id="notice"></textarea></div>
                        <script type="text/javascript">
                        function showmessage(message) {
                            document.getElementById('notice').value += message + "\r\n";
                        }
                        window.setTimeout("javascript:location.href='index.php?act=2'", 2000);
                        <?php update_db();?>
                        <?php update_adv();?>
                        <?php config_edit();?>
                        </script>
                        <?php } else { 
                        ?>
                        微商城模块安装完成，请首先进入后台更新站点缓存，然后<a href="<?php echo SiteUrl;?>/modules/microshop" target="_blank">点击进入微商城</a>。
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
