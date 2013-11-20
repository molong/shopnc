<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo CHARSET;?>">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php if ($output['goods_title']){ echo $output['goods_title'].' - '.$GLOBALS['setting_config']['flea_site_title'];}else{echo $GLOBALS['setting_config']['flea_site_title'];}?> - Powered by ShopNC</title>
<meta name="keywords" content="<?php if ($output['seo_keywords']){ echo $output['seo_keywords'].',';}echo $GLOBALS['setting_config']['flea_site_keywords']; ?>" />
<meta name="description" content="<?php if ($output['seo_description']){ echo $output['seo_description'].',';}echo $GLOBALS['setting_config']['flea_site_description']; ?>" />
<meta name="author" content="ShopNC">
<meta name="copyright" content="ShopNC Inc. All Rights Reserved">
<?php echo html_entity_decode($GLOBALS['setting_config']['qq_appcode'],ENT_QUOTES); ?>
<link href="<?php echo TEMPLATES_PATH;?>/css/flea.css" rel="stylesheet" type="text/css">
<!--[if IE]>
<script src="<?php echo RESOURCE_PATH;?>/js/html5.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script>
<!--弹出层-->
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/flea/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.flea_area.js" charset="utf-8"></script>
<script type="text/javascript">
	var PRICE_FORMAT = '<?php echo $lang['currency'];?>%s';
COOKIE_PRE = '<?php echo COOKIE_PRE;?>';_CHARSET = '<?php echo strtolower(CHARSET);?>';SITEURL = '<?php echo SiteUrl;?>';
$(function(){
	$("#close").click(function(){
	     $("#j_headercitylist").css("display","none");
	});
	if ($.cookie('flea_area') != null && $.cookie('flea_area') != ''){
		$('#cityname').html($.cookie('flea_area'));
		$('#show_area').html('<?php echo $lang['flea_index_area']; ?>');
	}else{
		$('#show_area').html('<?php echo $lang['flea_all_country']?>');
	}
});

</script>
<style type="text/css">
<!--
body { font-size:12px;}
ul,li { list-style:none; padding:0; margin:0;}
-->
</style>
</head>
<body>
<?php require_once template('layout/layout_flea_top');?>
<header id="topHeader">
  <div class="site-logo"><a href="<?php echo SiteUrl;?>"><img src="<?php echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['site_logo']; ?>"></a>  </div>
  <!--地区-->
  <span id="cityname"></span>
  <div id="cityblock">
  <div id="show_area"></div>
  <ul id="j_headercitylist">
  <li onclick="areaGo(0,'')"><?php echo $lang['flea_all_country']?></li>
   <?php if($output['area_one_level']){?>
	 <?php foreach($output['area_one_level'] as $val){?>
		<li id="<?php echo $val['flea_area_id'];?>">
			<?php echo $val['flea_area_name'];?>
		</li>
	 <?php };?>
   <?php };?>
   <a id="close" href="javascript:void(0)">X</a>
  </ul>
  <ul id="citylist"></ul>
  </div>

  <!--地区-->
  <div id="search" class="search">
    <div class="details" id="details">
      <div id="a1" class="form">
        <form action="index.php" onSubmit="return searchInput();" method="get">
          <input name="act" id="search_act" value="flea_class" type="hidden">
          <div class="formstyle">
            <input id="keyword" name="key_input" type="text" class="textinput" maxlength="60" value="<?php echo $lang['nc_searchdefault']; ?>" onFocus="searchFocus(this)" onBlur="searchBlur(this)" maxlength="200"/>
            <input name="" type="submit" class="search-button" value="">
          </div>
        </form>
      </div>
      <div class="tag">
        <?php if(is_array($output['flea_hot_search']) and !empty($output['flea_hot_search'])) { foreach($output['flea_hot_search'] as $val) { ?>
        <a href="index.php?act=flea_class&key_input=<?php echo urlencode($val);?>"><?php echo $val; ?></a>
        <?php } }?>
      </div>
    </div>
  </div>
</header>
<div id="navBar" class="mb10">
  <ul>
    <li class="fn-left none" <?php echo $output['index_sign'] == 'index' && $output['index_sign'] != '0'?'class="current"':'class="link"'; ?> ><a href="<?php echo SiteUrl;?>"><span><?php echo $lang['nc_index'];?></span><span class="line"></span></a></li>
    <?php if($GLOBALS['setting_config']['flea_isuse']=='1'){;?>
    <li class="fn-left link" <?php echo $output['index_sign'] == 'flea' && $output['index_sign'] != '0'?'class="current"':'class="link"'; ?> ><a href="<?php echo SiteUrl;?>/index.php?act=flea"><span><?php echo $lang['nc_flea_index'];?></span><span class="line"></span></a></li>
    <?php }?>     
    <?php if (intval($GLOBALS['setting_config']['groupbuy_allow']) === 1){ ?>
    <li class="fn-left" <?php echo $output['index_sign'] == 'groupbuy' && $output['index_sign'] != '0'?'class="current"':'class="link"'; ?> ><a href="<?php echo SiteUrl;?>/index.php?act=show_groupbuy"><span><?php echo $lang['nc_groupbuy'];?></span><span class="line"></span></a></li>
    <?php }?>  
    <li class="fn-left" <?php echo $output['index_sign'] == 'brand' && $output['index_sign'] != '0'?'class="current"':'class="link"'; ?>><a href="<?php echo SiteUrl;?>/index.php?act=brand"><span><?php echo $lang['nc_brand'];?></span><span class="line"></span></a></li>
    <li class="fn-left" <?php echo $output['index_sign'] == 'coupon' && $output['index_sign'] != '0'?'class="current"':'class="link"'; ?> ><a href="<?php echo SiteUrl;?>/index.php?act=coupon"><span><?php echo $lang['nc_coupon'];?></span><span class="line"></span></a></li>
      <?php if ($GLOBALS['setting_config']['points_isuse'] == 1 && $GLOBALS['setting_config']['pointprod_isuse'] == 1){ ?>
          <li class="fn-left" <?php echo $output['index_sign'] == 'pointprod' && $output['index_sign'] != '0'?'class="current"':'class="link"'; ?> ><a href="<?php echo SiteUrl;?>/index.php?act=pointprod"><span><?php echo $lang['nc_pointprod'];?></span><span class="line"></span></a></li>
  <?php } ?>
    <?php if(!empty($output['nav_list']) && is_array($output['nav_list'])){?>
    <?php foreach($output['nav_list'] as $nav){?>
    <?php if($nav['nav_location'] == '1'){?>
    <li class="fn-left" <?php if($nav['nav_new_open']){?>target="_blank" <?php }?> <?php if($output['index_sign'] == $nav['nav_id']){echo 'class="current"';}else{echo 'class="link"';} ?>><a href="<?php switch($nav['nav_type']){
    	case '0':echo $nav['nav_url'];break;
    	case '1':echo ncUrl(array('act'=>'goods_class','nav_id'=>$nav['nav_id'],'cate_id'=>$nav['item_id']));break;
    	case '2':echo ncUrl(array('act'=>'article','nav_id'=>$nav['nav_id'],'ac_id'=>$nav['item_id']));break;
    	case '3':echo ncUrl(array('act'=>'activity','activity_id'=>$nav['item_id'],'nav_id'=>$nav['nav_id']), 'activity');break;
    }?>"><span><?php echo $nav['nav_title'];?></span></a></li>
    <?php }?>
    <?php }?>
    <?php }?>
  </ul>
  <!--地区-->
  <?php if($output['area_two_level']){?>
	<?php foreach($output['area_two_level'] as $val){?>
	  <div style="display:none;" id="hidden_<?php echo $val['id'];?>"><?php echo $val['content'];?></div>
	<?php };?>
  <?php };?>
  <!--地区-->
</div>
<?php require_once($tpl_file);?>
<?php require_once template('flea_footer');?>
</body>
</html>