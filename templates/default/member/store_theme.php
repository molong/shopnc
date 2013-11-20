<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="templet">
    <div class="nonce"><img src="<?php echo $output['curr_theme']['curr_image'];?>"  onload="javascript:DrawImage(this,200,200);" id="current_theme_img" /></div>
    <div class="txt">
      <p><?php echo $lang['store_create_store_name'];?><?php echo $lang['nc_colon'];?><span><?php echo $output['store_info']['store_name'];?></span><a href="index.php?act=show_store&id=<?php echo $output['store_info']['store_id'];?>" target="_blank" class="btn"><?php echo $lang['store_theme_homepage'];?></a></p>
      <p><?php echo $lang['store_theme_tpl_name'];?><?php echo $lang['nc_colon'];?><b id="current_template"><?php echo $output['curr_theme']['curr_name'];?></b></p>
      <p><?php echo $lang['store_theme_style_name'];?><?php echo $lang['nc_colon'];?><b id="current_style"><?php echo $output['curr_theme']['curr_truename'];?></b></p>
          <p><b id="store_style"></b></p>
    </div>
  </div>
  <h5 class="motif_title"><?php echo $lang['store_theme_valid'];?></h5>
  <div class="motif">
    <ul>
      <?php foreach((array)$output['theme_list'] as $theme){?>
      <li>
        <p><a href="javascript:void(0)" onclick="preview_theme('<?php echo $theme['name'];?>');"><img id="themeimg_<?php echo $theme['name'];?>" src="<?php echo $theme['image'];?>"  onload="javascript:DrawImage(this,200,200);"></a></p>
        <h2><span style="float:left; width:30%;padding-left:20px;"><?php echo $lang['store_theme_tpl_name1'];?><?php echo $lang['nc_colon'];?></span><span style="float:left;text-align:left;"><b><?php echo $theme['name'];?></b></span></h2>
        <h2><span style="float:left; width:30%;padding-left:20px;"><?php echo $lang['store_theme_style_name1'];?><?php echo $lang['nc_colon'];?></span><span style="float:left;text-align:left;"><b><?php echo $theme['truename'];?></b></span></h2>
        <span class="btn"> <a href="javascript:use_theme('<?php echo $theme['name'];?>','<?php echo $theme['truename'];?>');" class="employ"><?php echo $lang['store_theme_use'];?></a> <a href="javascript:preview_theme('<?php echo $theme['name'];?>');" class="preview"><?php echo $lang['store_theme_preview'];?></a> </span> </li>
      <?php }?>
    </ul>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript">
var curr_template_name = '<?php echo $output['curr_theme']['curr_name'];?>';
var curr_style_name    = '<?php echo $output['curr_theme']['curr_name'];?>';
var preview_img = new Image();
var store_theme = ' <a href="index.php?act=store_theme" target="_blank">当前主题可自定义广告（点击进入）</a>';
<?php if(intval($output['style_state']) === 1) { ?>
	$('#store_style').html(store_theme);
<?php }?>
preview_img.onload = function(){
    var d = DialogManager.get('preview_image');
    if (!d)
    {
        return;
    }

    if (d.getStatus() != 'loading')
    {

        return;
    }

    d.setWidth(this.width + 50);
    d.setPosition('center');
    d.setContents($('<img src="' + this.src + '" alt="" />'));
    ScreenLocker.lock();
};
preview_img.onerror= function(){
    alert('<?php echo $lang['store_theme_load_preview_fail'];?>');
    DialogManager.close('preview_image');
};
function preview_theme(style_name){
    var screenshot = '<?php echo TEMPLATES_PATH;?>/store/style/' + style_name + '/screenshot.jpg';

    var d = DialogManager.create('preview_image');
    d.setTitle('<?php echo $lang['store_theme_effect_preview'];?>');
    d.setContents('loading', {'text':'<?php echo $lang['store_theme_loading1'];?>...'});
    d.setWidth(270);
    d.show('center');

    preview_img.src = screenshot;
}
function use_theme(style,truename){
    ajaxget('index.php?act=store&op=set_theme&style_name=' + style);
}
</script> 