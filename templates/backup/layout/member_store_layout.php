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
<!--[if IE 6]><style type="text/css">
body {_behavior: url(<?php echo TEMPLATES_PATH;?>/css/csshover.htc);}
</style>
<![endif]-->
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/utils.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<!--[if IE]>
<script src="<?php echo RESOURCE_PATH;?>/js/html5.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo RESOURCE_PATH;?>/js/IE6_PNG.js"></script>
<script>
DD_belatedPNG.fix('.pngFix');
</script>
<script> 
// <![CDATA[ 
if((window.navigator.appName.toUpperCase().indexOf("MICROSOFT")>=0)&&(document.execCommand)) 
try{ 
document.execCommand("BackgroundImageCache", false, true); 
   } 
catch(e){} 
// ]]> 
</script> 
<![endif]-->
<script type="text/javascript">
COOKIE_PRE = '<?php echo COOKIE_PRE;?>';_CHARSET = '<?php echo strtolower(CHARSET);?>';SITEURL = '<?php echo SiteUrl;?>';
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
function show_store(store_id){
	var store_url="<?php echo SiteUrl;?>/index.php?act=show_store&id=";
	var s_id=store_id;
	$.get("api.php?act=get_session&key=store_id", function(data){
	  if(data != '') s_id=data;
	});
	if(s_id > 0) window.open(store_url+s_id,'','');
}
</script>
</head>
<body>
<?php require_once template('layout/layout_top');?>
<div id="header">
  <h1 title="<?php echo $GLOBALS['setting_config']['site_name']; ?>"><a href="<?php echo SiteUrl;?>"><img src="<?php echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['site_logo']; ?>" alt="<?php echo $GLOBALS['setting_config']['site_name']; ?>" class="pngFix"></a><i><?php echo $lang['nc_seller'];?></i></h1>
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
</div>
<nav class="navmenu pngFix"><span class="left-side pngFix"></span><span class="right-side pngFix"></span>
  <?php if ($_SESSION['store_id']){?>
  <div class="quicklink-set" ><a onclick="CUR_DIALOG = ajax_form('quicklink', '<?php echo $lang['nc_account_set_quicklink'];?>', 'index.php?act=store&op=quicklink', 722,0);" href="javascript:void(0);"><?php echo $lang['nc_account_set_quicklink'];?></span></a></div>
  <?php }?>
  <ul>
    <li><a href="index.php?act=store" class="selected"><span><?php echo $lang['nc_seller'];?></span></a></li>
    <li><a class="" href="index.php?act=member_snsindex"><span><?php echo $lang['nc_buyer'];?></span></a></li>
    <li><a class="" href="index.php?act=home&op=member"><span><?php echo $lang['nc_account_set'];?></span></a></li>
  </ul>
  <?php if (isset($output['quick_link'])){?>
  <div class="sub-quikc" >
    <?php foreach((array)$output['quick_link'] as $value){?>
    <?php $svalue = explode('||',$value)?>
    <a href="<?php echo $svalue[1];?>"><?php echo $svalue[2];?></a>
    <?php }?>
  </div>
  <?php }?>
</nav>
<script type="text/javascript">
// 收缩展开效果
$(document).ready(function(){
	$(".sidebar dl dt").click(function(){
		$(this).toggleClass("hou");
		var sidebar_id = $(this).attr("id");
		var sidebar_dd = $(this).next("dd");
		sidebar_dd.slideToggle("slow",function(){
				$.cookie(COOKIE_PRE+sidebar_id, sidebar_dd.css("display"), { expires: 7, path: '/'});
		 });
	});
<?php if(!$_SESSION['is_seller']){ ?>
	$('.sidebar').find('dd').css('display','none');
<?php }?>
});
</script>
<div class="layout">
  <?php if($output['left_show'] != 'order_view') { ?>
  <div class="sidebar">
    <dl>
      <dt id="sidebar_goods_manage" <?php if(cookie('sidebar_goods_manage') == 'none'){ echo "class='hou'";}?>><i class="pngFix"></i><?php echo $lang['nc_seller_goods_manage'];?></dt>
      <dd style="display: <?php echo cookie('sidebar_goods_manage');?>;">
        <ul>
          <li><a class='normal' href="index.php?act=store_goods&op=add_goods&step=one" target="_blank"><?php echo $lang['nc_member_path_goods_sell'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'goods_selling'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_goods&op=goods_list"><?php echo $lang['nc_member_path_goods_selling'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'goods_storage'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_goods&op=goods_storage"><?php echo $lang['nc_member_path_goods_storage'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'brand_list'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_goods&op=brand_list"><?php echo $lang['nc_member_path_brand_list'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'taobao_import'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_goods&op=taobao_import"><?php echo $lang['nc_member_path_taobao_import'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_goods_class'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=store_goods_class"><?php echo $lang['nc_member_path_store_goods_class'];?></a></li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt id="sidebar_order_manage" <?php if(cookie('sidebar_order_manage') == 'none'){ echo "class='hou'";}?>><i class="pngFix"></i><?php echo $lang['nc_seller_order_manage'];?></dt>
      <dd style="display: <?php echo cookie('sidebar_order_manage');?>;">
        <ul>
          <li><a <?php if($output['menu_sign'] == 'store_order'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=store_order"><?php echo $lang['nc_member_path_store_order'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'deliver'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=deliver&op=index"><?php echo $lang['nc_member_path_deliver'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'daddress'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=deliver&op=daddress"><?php echo $lang['nc_member_path_daddress'];?></a></li>
          <?php if (C('payment')){?>
          <li><a <?php if($output['menu_sign'] == 'payment'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=payment"><?php echo $lang['nc_member_path_payment'];?></a></li>
          <?php }?>
          <li><a <?php if($output['menu_sign'] == 'transport'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=transport"><?php echo $lang['nc_member_path_transport'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'evaluatemanage'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_evaluate&op=list"><?php echo $lang['nc_member_path_evalmanage'];?></a></li>
        </ul>
    </dl>
    <dl>
      <dt id="sidebar_promotion_manage" <?php if(cookie('sidebar_promotion_manage') == 'none'){ echo "class='hou'";}?>><i class="pngFix"></i><?php echo $lang['nc_seller_promotion_manage'];?></dt>
      <dd style="display: <?php echo cookie('sidebar_promotion_manage');?>;">
        <ul>
          <?php if (C('groupbuy_allow') == 1){ ?>
          <li><a <?php if($output['menu_sign'] == 'groupbuy_manage'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_groupbuy"><?php echo $lang['nc_member_path_groupbuy_manage'];?></span></a></li>
          <?php } ?>
          <?php if (intval(C('gold_isuse')) == 1 && intval(C('promotion_allow')) == 1){ ?>
          <li><a <?php if($output['menu_sign'] == 'xianshi'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_promotion_xianshi&op=xianshi_list"><?php echo $lang['nc_seller_promotion_xianshi_list'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'mansong'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_promotion_mansong&op=mansong_list"><?php echo $lang['nc_seller_promotion_mansong_list'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'bundling'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_promotion_bundling&op=bundling_list"><?php echo $lang['nc_seller_promotion_bundling_list'];?></a></li>
          <?php } ?>
          <li><a <?php if($output['menu_sign'] == 'store_coupon'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=store_coupon"><?php echo $lang['nc_member_path_store_coupon'];?></a></li>
          <?php if ($GLOBALS['setting_config']['voucher_allow'] == 1){?>
          <li><a <?php if($output['menu_sign'] == 'store_voucher'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_voucher"><span class="ico29"><?php echo $lang['nc_member_path_store_voucher'];?></span></a></li>
          <?php } ?>
          <li><a <?php if($output['menu_sign'] == 'store_activity'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=store_activity"><?php echo $lang['nc_member_path_store_activity'];?></a></li>
          <?php if (C('gold_isuse') == 1 && C('ztc_isuse') == 1){?>
          <li><a <?php if($output['menu_sign'] == 'store_ztc'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_ztc&op=ztc_list"><?php echo $lang['nc_member_path_store_ztc'];?></a></li>
          <?php }?>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt id="sidebar_store_manage" <?php if(cookie('sidebar_store_manage') == 'none'){ echo "class='hou'";}?>><i class="pngFix"></i><?php echo $lang['nc_seller_store_manage'];?></dt>
      <dd style="display: <?php echo cookie('sidebar_store_manage');?>;">
        <ul>
          <li><a class='normal' href="JavaScript:void(0);" onclick="show_store('<?php echo $_SESSION['store_id'];?>');"><?php echo $lang['nc_member_my_store'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_setting'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=store_setting"><?php echo $lang['nc_member_path_store_setting'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_theme'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=theme"><?php echo $lang['nc_member_path_store_theme'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_navigation'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=store_navigation"><?php echo $lang['nc_member_path_store_navigation'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_partner'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store&op=store_partner"><?php echo $lang['nc_member_path_store_partner'];?></a></li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt id="sidebar_consult_manage" <?php if(cookie('sidebar_consult_manage') == 'none'){ echo "class='hou'";}?>><i class="pngFix"></i><?php echo $lang['nc_seller_store_consult_manage'];?></dt>
      <dd style="display: <?php echo cookie('sidebar_consult_manage');?>;">
        <ul>
          <li><a <?php if($output['menu_sign'] == 'consult_manage'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_consult&op=consult_list"><?php echo $lang['nc_member_path_consult_manage'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_refund'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=refund"><?php echo $lang['nc_member_path_store_refund'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_return'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=return"><?php echo $lang['nc_member_path_store_return'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'complain'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_complain&op=list"><?php echo $lang['nc_member_path_complain'];?></a></li>
          <li><a <?php if($output['menu_sign'] == 'store_inform'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_inform"><?php echo $lang['nc_member_path_store_inform'];?></a></li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt id="sidebar_other_manage" <?php if(cookie('sidebar_other_manage') == 'none'){ echo "class='hou'";}?>><i class="pngFix"></i><?php echo $lang['nc_seller_other_manage'];?></dt>
      <dd style="display: <?php echo cookie('sidebar_other_manage');?>;">
        <ul>
          <?php if (C('gold_isuse') == 1){?>
          <li><a <?php if($output['menu_sign'] == 'store_gbuy'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_gbuy"><?php echo $lang['nc_member_path_store_gbuy'];?></a></li>
          <?php }?>
          <li><a <?php if($output['menu_sign'] == 'adv'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_adv&op=adv_manage"><?php echo $lang['nc_member_path_adv']; ?></a></li>
          <li><a <?php if($output['menu_sign'] == 'album') { echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=store_album&op=album_cate"><?php echo $lang['nc_member_path_album']; ?></a></li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt id="sidebar_store_statistics" <?php if(cookie('sidebar_other_manage') == 'none'){ echo "class='hou'";}?>><i class="pngFix"></i><?php echo $lang['nc_member_path_store_statistics']; ?></dt>
      <dd style="display: <?php echo cookie('sidebar_store_statistics');?>;">
        <ul>
          <li><a <?php if($output['menu_sign'] == 'flow_statistics'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=statistics&op=flow_statistics"><?php echo $lang['nc_member_path_flow_statistics']; ?></a></li>
          <li><a <?php if($output['menu_sign'] == 'sale_statistics'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=statistics&op=sale_statistics"><?php echo $lang['nc_member_path_sale_statistics']; ?></a></li>
          <li><a <?php if($output['menu_sign'] == 'probability_statistics') { echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=statistics&op=probability_statistics"><?php echo $lang['nc_member_path_probability_statistics']; ?></a></li>
        </ul>
      </dd>
    </dl>
  </div>
  <div class="right-content">
    <?php if ($_SESSION['store_id']){?>
    <div class="path">
      <div><a href="index.php?act=store"><?php echo $lang['nc_seller'];?></a> <span>></span>
        <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
        <a href="<?php echo $output['menu_sign_url'];?>"/>
        <?php }?>
        <?php echo $lang['nc_member_path_'.$output['menu_sign']];?>
        <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
        </a><span>></span><?php echo $lang['nc_member_path_'.$output['menu_sign1']];?>
        <?php }?>
      </div>
    </div>
    <?php }?>
    <div class="main">
      <?php
		require_once($tpl_file);
		?>
    </div>
  </div>
  <?php
} else {
	require_once($tpl_file);
}
?>
  <div class="clear"></div>
</div>
<?php
require_once template('footer');
?>
</body>
</html>