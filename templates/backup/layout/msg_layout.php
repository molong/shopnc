<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<meta name="keywords" content="<?php echo $GLOBALS['setting_config']['site_keywords']; ?>" />
<meta name="description" content="<?php echo $GLOBALS['setting_config']['site_description']; ?>" />
<meta name="author" content="ShopNC">
<meta name="copyright" content="ShopNC Inc. All Rights Reserved">
<link href="<?php echo TEMPLATES_PATH;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/member.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/member_store.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background: #FFF none no-repeat 0 0 scroll !important;
}
.msg {
	font-family: "微软雅黑";
	font-size: 20px;
	color: #555;
	font-weight: 600;
	line-height: 48px;
	text-align: center;
	margin: 100px;
}
</style>
<script>COOKIE_PRE = '<?php echo COOKIE_PRE;?>';_CHARSET = '<?php echo strtolower(CHARSET);?>';SITEURL = '<?php echo SiteUrl;?>';</script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js"></script>
<script type="text/javascript">
$(function(){
	$("#details").children('ul').children('li').click(function(){
		$(this).parent().children('li').removeClass("current");
		$(this).addClass("current");
		$('#search_act').attr("value",$(this).attr("act"));
	});
	var search_act = $("#details").find("li[class='current']").attr("act");
	$('#search_act').attr("value",search_act);
	$("#keyword").blur();
});
</script>
</head>
<body>
<?php require_once template('layout/layout_top');?>
<div id="header">
  <h1 title="ShopNC"><a href="<?php echo SiteUrl;?>"><img src="<?php echo SiteUrl.DS.ATTACH_COMMON.DS.$GLOBALS['setting_config']['site_logo']; ?>" alt="<?php echo $GLOBALS['setting_config']['site_name']; ?>"></a></h1>
  <div id="search" class="search">
    <div class="details" id="details">
      <ul class="tab">
        <li <?php if($_GET['act'] != 'search' ) echo 'class="current"'; ?> act="search"><span><?php echo $lang['site_search_goods'];?></span></li>
        <li <?php if($_GET['act'] == 'shop_search') echo 'class="current"'; ?> act="shop_search"><span><?php echo $lang['site_search_store'];?></span></li>
      </ul>
      <div id="a1" class="form">
        <form method="get" action="index.php" onSubmit="return searchInput();">
          <input name="act" id="search_act" value="search" type="hidden">
          <div class="formstyle">
            <input name="keyword" id="keyword" type="text" class="textinput" maxlength="60" value="<?php echo $lang['nc_searchdefault']; ?>" onFocus="searchFocus(this)" onBlur="searchBlur(this)"/>
            <input name="" type="submit" class="search-button" value="">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="content">
  <div class="wrap-shadow">
    <div class="wrap-all" >
      <?php if($output['msg_type'] == 'error'){ ?>
      <p class="msg defeated">
        <?php }else { ?>
      <p class="msg success">
        <?php } ?>
        <span>
        <?php require_once($tpl_file);?>
        </span> </p>
    </div>
  </div>
</div>
<script type="text/javascript">
<?php if (!empty($output['url'])){
?>
	window.setTimeout("javascript:location.href='<?php echo $output['url'];?>'", <?php echo $time;?>);
<?php
}else{
?>
	window.setTimeout("javascript:history.back()", <?php echo $time;?>);
<?php
}?>
</script>
<?php
require_once template('footer');
?>
</body>
</html>