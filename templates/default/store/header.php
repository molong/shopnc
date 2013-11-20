<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta content="IE=9" http-equiv="X-UA-Compatible">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<meta name="keywords" content="<?php echo $output['seo_keywords']; ?>" />
<meta name="description" content="<?php echo $output['seo_description']; ?>" />
<meta name="author" content="ShopNC">
<meta name="copyright" content="ShopNC Inc. All Rights Reserved">
<link href="<?php echo TEMPLATES_PATH;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/shop.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/home_login.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/store/style/<?php echo $output['store_info']['store_theme'];?>/style.css" rel="stylesheet" type="text/css">
<!--[if IE 6]><style type="text/css">
body {_behavior: url(<?php echo TEMPLATES_PATH;?>/css/csshover.htc);}
</style>
<![endif]-->
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/html5.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/utils.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/shop.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<!--[if IE 6]>
<script src="<?php echo RESOURCE_PATH;?>/js/IE6_PNG.js"></script>
<script>
DD_belatedPNG.fix('.pngFix,.pngFix:hover');
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
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/IE6_MAXMIX.js"></script> 
<![endif]--> 
<script>
COOKIE_PRE = '<?php echo COOKIE_PRE;?>';_CHARSET = '<?php echo strtolower(CHARSET);?>';SITEURL = '<?php echo SiteUrl;?>';
</script>
</head>
<body>
<?php require_once template('layout/layout_top');?>
<header id="header" class="bc">
  <h1 id="shop-logo">
    <?php if($output['store_info']['store_label']){ ?>
    <a class="mall-home" href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store',$output['store_info']['store_domain']);?>" title="<?php echo $GLOBALS['setting_config']['site_name']; ?>"><img src="<?php echo ATTACH_STORE.DS.$output['store_info']['store_label'];?>"  alt="<?php echo $output['store_info']['store_name'];?>" title="<?php echo $output['store_info']['store_name'];?>" /></a>
    <?php }else{ ?>
    <a class="mall-home" href="<?php echo SiteUrl;?>" title="<?php echo $lang['homepage'];?>"><img src="<?php echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['site_logo']; ?>" alt="<?php echo $GLOBALS['setting_config']['site_name']; ?>" title="<?php echo $GLOBALS['setting_config']['site_name']; ?>" class="pngFix"></a><em><?php echo $lang['site_search_store'];?></em>
    <?php }?>
  </h1>
  <div class="shop-wrap">
    <div id="shop-search">
      <form method="get" action="<?php echo SiteUrl.'/';?>index.php" onSubmit="return searchInput();" name="formSearch" id="formSearch">
        <input name="act" id="search_act" value="search" type="hidden" />
        <input name="keyword" id="keyword" type="text" class="ncs-search-input-text" value="<?php echo $lang['nc_searchdefault']; ?>" onFocus="searchFocus(this)" onBlur="searchBlur(this)" x-webkit-speech lang="zh-CN" onwebkitspeechchange="foo()" x-webkit-grammar="builtin:search" />
        <a href="javascript:void(0)" class="ncs-search-btn-mall" nctype="search_in_shop"><span><?php echo $lang['nc_search_in_website'];?></span></a><a href="javascript:void(0)" class="ncs-search-btn-shop" nctype="search_in_store"><span><?php echo $lang['nc_search_in_store'];?></span></a>
      </form>
    </div>
    <div id="shop-info">
      <div class="shop-info-simple"><p><span class="shop-level" title="<?php echo $lang['nc_store_grade'].$lang['nc_colon'];?><?php echo $output['store_info']['grade_name'];?>"><?php echo $output['store_info']['grade_name'];?></span><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store',$output['store_info']['store_domain']);?>" class="shop-name" ><?php echo $output['store_info']['store_name']; ?></a></p>
        <div class="shop-credit"><h5><?php echo $lang['nc_credit_degree'];?></h5>
		<span><?php if (empty($output['store_info']['credit_arr'])){ echo $output['store_info']['store_credit']; }
		else {?>
        <em class="seller-<?php echo $output['store_info']['credit_arr']['grade']; ?> level-<?php echo $output['store_info']['credit_arr']['songrade']; ?>"></em>
       <?php }?></span>
       </div>
       <span class="more"><?php echo $lang['nc_more'];?><i class="pngFix"></i></span>
       </p>
      </div>
      <div class="shop-info-details">
        <dl class="rate">
          <dt><?php echo $lang['nc_description_of'];?></dt>
          <dd class="rate-star"><em><i style="width: <?php echo $output['store_info']['store_desccredit_rate'];?>%;"></i></em><span><?php echo $output['store_info']['store_desccredit'];?><?php echo $lang['nc_grade'];?></span></dd>
          <dt><?php echo $lang['nc_service_attitude'];?></dt>
          <dd class="rate-star"><em><i  style="width: <?php echo $output['store_info']['store_servicecredit_rate'];?>%;"></i></em><span><?php echo $output['store_info']['store_servicecredit'];?><?php echo $lang['nc_grade'];?></span></dd>
          <dt><?php echo $lang['nc_delivery_speed'];?></dt>
          <dd class="rate-star"><em><i  style="width: <?php echo $output['store_info']['store_deliverycredit_rate'];?>%;"></i></em><span><?php echo $output['store_info']['store_deliverycredit'];?><?php echo $lang['nc_grade'];?></span></dd>
        </dl>
        <dl class="basic">
          <dt><?php echo $lang['nc_store_owner'];?></dt>
          <dd><a href="index.php?act=show_store&op=credit&id=<?php echo $output['store_info']['store_id'];?>" class="shopkeeper"><?php echo $output['store_info']['member_name'];?></a> <a href="index.php?act=home&op=sendmsg&member_id=<?php echo $output['store_info']['member_id'];?>" class="message text-hidden" title="<?php echo $lang['nc_send_message'];?>"><?php echo $lang['nc_send_message'];?></a></dd>
          <dt><?php echo $lang['nc_store_addtime'];?></dt>
          <dd class="gray"><?php echo @date("Y-m-d",$output['store_info']['store_time']);?></dd>
          <dt><?php echo $lang['nc_srore_location'];?></dt>
          <dd class="gray"><?php echo $output['store_info']['area_info'];?></dd>
        </dl>
        <dl class="other">
          <dt><?php echo $lang['nc_goods_amount'];?></dt>
          <dd><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store',$output['store_info']['store_domain']);?>" class="btn"><?php echo $lang['nc_around_shop'];?></a><strong><?php echo $output['store_info']['goods_count'];?></strong><?php echo $lang['nc_jian'];?><?php echo $lang['nc_goods'];?></dd>
          <dt><?php echo $lang['nc_store_collect'];?></dt>
          <dd><a href="javascript:collect_store('<?php echo $output['store_info']['store_id'];?>','count','store_collect')" class="btn"><?php echo $lang['nc_me_collect'];?></a><strong nctype="store_collect"><?php echo $output['store_info']['store_collect'];?></strong><?php echo $lang['nc_person'];?><?php echo $lang['nc_collect'];?></dd>
          <dt><?php echo $lang['nc_contact'];?></dt>
          <dd>
            <?php if(!empty($output['store_info']['store_qq'])){?>
            <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $output['store_info']['store_qq'];?>&amp;Site=<?php echo $output['store_info']['store_qq'];?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>:47" alt="<?php echo $lang['nc_message_me'];?>"></a>
            <?php }?>
            <?php if(!empty($output['store_info']['store_ww'])){?>
            <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>"/></a>
            <?php }?></dd>
        </dl>
      </div>
    </div>
  </div>
</header>
<script type="text/javascript">
$(function(){
	$('a[nctype="search_in_store"]').click(function(){
		$('#search_act').val('show_store');
		$('<input type="hidden" value="<?php echo $output['store_info']['store_id'];?>" name="id" /> <input type="hidden" name="op" value="goods_all" />').appendTo("#formSearch");
		$('#formSearch').submit();
	});
	$('a[nctype="search_in_shop"]').click(function(){
		$('#formSearch').submit();
	});
	var store_id = "<?php echo $_GET['id']; ?>";
	var goods_id = "<?php echo $_GET['goods_id']; ?>";
	var act = "<?php echo trim($_GET['act']); ?>";
	var op  = "<?php echo trim($_GET['op']) != ''?trim($_GET['op']):'index'; ?>";
	$.getJSON("index.php?act=show_store&op=ajax_flowstat_record",{id:store_id,goods_id:goods_id,act_param:act,op_param:op},function(result){
	});
});
</script>