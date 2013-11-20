<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/admincp.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.tooltip.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.cookie.js"></script>
<link href="<?php echo TEMPLATES_PATH;?>/css/skin_0.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript">
//换肤
cookie_skin = $.cookie("MyCssSkin");
if (cookie_skin) {
	$('#cssfile2').attr("href","<?php echo TEMPLATES_PATH;?>/css/"+ cookie_skin +".css");
} 
</script>
</head>
<body>
<?php
	require_once($tpl_file);
?>
<?php if ($GLOBALS['setting_config']['debug'] == 1){?>
<div id="think_page_trace" class="trace">
  <fieldset id="querybox">
    <legend><?php echo $lang['nc_debug_trace_title'];?></legend>
    <div>
      <?php print_r(Tpl::showTrace());?>
    </div>
  </fieldset>
</div>
<?php }?>
<script>
$(function(){
	$(function(){
		// 商品自动上下架
		var COOKIE_NAME = 'goods_commodity_scanning'; 
		var date = new Date();
		date.setTime(date.getTime() + ( 60 * 60 * 1000 ));	// cookie过期时间  单位毫秒 默认1小时
		if(!$.cookie(COOKIE_NAME)){
			$('body').append('<iframe style="display:none" src="<?php echo SiteUrl.DS.ProjectName;?>/index.php?act=index&op=goods_commodity_scanning"></iframe>');
			$.cookie(COOKIE_NAME, 'test', { path: '/', expires: date });
		}

		
		// 过期店铺自动关闭，商品自动下架
		var	COOKIE_NAME_S = 'shops_shut_down';
		date.setTime(date.getTime() + ( 24 * 60 * 60 * 1000 ));	// cookie过期时间 单位毫秒 默认1天
		if(!$.cookie(COOKIE_NAME_S)){
			$('body').append('<iframe style="display:none" src="<?php echo SiteUrl.DS.ProjectName?>/index.php?act=index&op=shops_shut_down"></iframe>');
			$.cookie(COOKIE_NAME_S, 'test', { path: '/', expires: date});
		}
	});
});
</script>
</body>
</html>