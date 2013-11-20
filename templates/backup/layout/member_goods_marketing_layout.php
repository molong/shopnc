<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo ($lang['nc_member_path_'.$output['menu_sign']]==''?'':$lang['nc_member_path_'.$output['menu_sign']].'_').$output['html_title'];?></title>
<meta name="keywords" content="<?php echo $GLOBALS['setting_config']['site_keywords']; ?>" />
<meta name="description" content="<?php echo $GLOBALS['setting_config']['site_description']; ?>" />
<meta name="author" content="ShopNC">
<meta name="copyright" content="ShopNC Inc. All Rights Reserved">
<link href="<?php echo TEMPLATES_PATH;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/member.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/member_store.css" rel="stylesheet" type="text/css">
<script>
COOKIE_PRE = '<?php echo COOKIE_PRE;?>';_CHARSET = '<?php echo strtolower(CHARSET);?>';SITEURL = '<?php echo SiteUrl;?>';
</script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/utils.js" charset="utf-8"></script>
<!--<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/tabcontent.js" charset="utf-8"></script>-->
<script type="text/javascript">
	var PRICE_FORMAT = '<?php echo $lang['currency'];?>%s';
$(function(){
	//search
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
  <h1 title="<?php echo $GLOBALS['setting_config']['site_name']; ?>"><a href="<?php echo SiteUrl;?>"><img src="<?php echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['site_logo']; ?>" alt="<?php echo $GLOBALS['setting_config']['site_name']; ?>"></a></h1>
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
            <input name="keyword" id="keyword" type="text" class="textinput" value="<?php echo $lang['nc_searchdefault']; ?>" onFocus="searchFocus(this)" onBlur="searchBlur(this)" maxlength="200"/>
            <input name="" type="submit" class="search-button" value="">
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--<div id="path"> <?php echo $lang['nc_current_position'];?>: <a href="index.php"><?php echo $lang['nc_index'];?></a> <span>&nbsp;</span> <a href="index.php?act=store"><?php echo $lang['nc_seller'];?></a> <span>&nbsp;</span>
    <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
    <a href="<?php echo $output['menu_sign_url'];?>">
    <?php }?>
    <?php echo $lang['nc_member_path_'.$output['menu_sign']];?>
    <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
    </a><span>&nbsp;</span><?php echo $lang['nc_member_path_'.$output['menu_sign1']];?>
    <?php }?>
  </div>-->
</div>
<div class="layout">
<?php require_once($tpl_file); ?>
</div>
<?php
require_once template('footer');
?>
</body>
</html>