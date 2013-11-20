<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style type="text/css">
.layout { width: 1200px;}
.ui-corner-all {
	background-color: rgba(130, 130, 130, 0.4);
	border-radius: 0px;
	padding:0;
}
.ui-widget-content {border-color: #999; box-shadow: 4px 4px 4px rgba(102,102,102,0.4)}
.ui-dialog {
	padding: 0;
}
.ui-widget-content {
	background: #FFF none;
}
.ui-widget-header {
	color: #666;
	line-height: 16px;
	font-weight: bold;
	background: #F2F2F2 none;
	border: solid #EAEAEA;
	border-width: 0 0 1px 0;
	display: block;
}
.ui-dialog .ui-dialog-titlebar {
	padding: 8px 10px;
	margin: 0;
}
.ui-dialog-title {
	font-size: 14px;
}
.menu-left li {
	font-size: 14px;
	color: #3366CC;
	line-height: 16px;
	padding-top: 4px;
}
.jui_dialog, #content, #style_template {
	display: none;
}
.fixmenu {
	position: fixed;
}
.fixmenu ul {
	width: 75px;
	padding: 8px;
	border: 1px solid #666666;
	background-color: #666;
	box-shadow: 2px 2px 1px rgba(102,102,102,0.1)
}
.fixmenu li {
	font-size: 12px;
	line-height: 24px;
	border-bottom-width: 1px;
	border-bottom-style: solid;
	border-bottom-color: #7C7C7C;
}
.fixmenu li a {
	color: #E0E0E0;
}
.fixmenu li a:hover { color:#FFF;}
</style>
<div style="margin: 0 auto; width:1200px;">
  <div class="fixmenu">
    <ul>
      <li> <a href="javascript:void(0)" onclick="open_dialog('info_dialog');">模板帮助说明</a> </li>
      <li> <a href="javascript:void(0)" onclick="open_dialog('pic_dialog');">插入相册图片</a> </li>
      <li> <a href="javascript:void(0)" onclick="open_dialog('goods_dialog');">插入销售商品</a> </li>
    </ul>
  </div>
  <div class="clear"></div>
<div id="path" style="margin-left:100px;"> <?php echo $lang['nc_current_position'];?>: <a href="index.php"><?php echo $lang['nc_index'];?></a> <span>&gt;</span> <a href="index.php?act=store"><?php echo $lang['nc_seller'];?></a> <span>&gt;</span>
    <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
    <a href="<?php echo $output['menu_sign_url'];?>">
    <?php }?>
    <?php echo $lang['nc_member_path_'.$output['menu_sign']];?>
    <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
    </a><span>&gt;</span><?php echo $lang['nc_member_path_'.$output['menu_sign1']];?>
    <?php }?>
</div>
  <div class="wp">
    <form method="post" action="index.php?act=store_theme" name="store_form">
      <input type="hidden" name="form_submit" value="ok"/>
      <input type="hidden" name="theme_id" value="<?php echo $output['theme']['theme_id'];?>"/>
      <div>
        <?php showEditor('content',$output['theme']['theme_info'],'1000px','600px','','false',$output['editor_multimedia']); ?>
      </div>
      <div class="ncu-form-style" style="text-align:center;">
      <dl class="bottom">
        <input type="submit" class="submit pngFix" value="<?php echo $lang['nc_submit'];?>" />
      </dl>
      </div>
    </form>
  </div>
</div>
<div class="clear"></div>
<div id="info_dialog" title="模板帮助说明" class="jui_dialog"> <?php echo $output['style_info'];?> 
</div>
<div id="pic_dialog" title="插入相册图片(单击选中,可多选)" class="jui_dialog" style="margin: 0 auto;">
  <iframe src="index.php?act=store_theme&op=pic_list" style="border: 0;margin: 0 auto;width:670px;  padding:0; height: 410px;"  scrolling="no"></iframe>
</div>
<div id="goods_dialog" title="插入销售商品(单击选中,可多选)" class="jui_dialog">
  <iframe src="index.php?act=store_theme&op=goods_list" style=" border: 0; margin: 0 auto; padding:0; width:670px; height: 500px;" scrolling="no"></iframe>
</div>
<script>
		function insert_template() {
			KE.html($("#style_template").html());
		}
		function open_dialog(dialog_id) {
			$(".jui_dialog").each(function(i){
			   $(this).dialog("close");
			 });
			$("#"+dialog_id).dialog("open");
		}
		var info_dialog=$("#info_dialog");
		var pic_dialog=$("#pic_dialog");
		var goods_dialog=$("#goods_dialog");
		$(function() {
			info_dialog.dialog({ autoOpen: false,resizable: false,width: 650 });
			pic_dialog.dialog({ autoOpen: false,resizable: false,width: 710 });
			goods_dialog.dialog({ autoOpen: false,resizable: false,width: 710 });
		});
		
	</script>
<div id="style_template"><?php echo $output['style_template'];?></div>
