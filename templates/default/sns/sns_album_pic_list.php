<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SiteUrl?>/resource/js/swfupload/css/default.css" rel="stylesheet" type="text/css">

<div class="sns-main-all">
  <div class="tabmenu">
    <?php include template('sns/sns_submenu'); ?>
  </div>
  <div id="pictureFolder" class="album">
    <div class="intro">
      <div class="covers"><span class="thumb size60"><i></i>
        <?php if($output['class_info']['ac_cover'] != ''){ ?>
        <img id="aclass_cover" src="<?php echo SiteUrl.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$output['class_info']['ac_cover'];?>"  onerror="this.src='<?php echo TEMPLATES_PATH.'/images/member/default_image.png';?>'" onload="javascript:DrawImage(this,60,60);">
        <?php }else{?>
        <img id="aclass_cover" src="<?php echo TEMPLATES_PATH.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,60,60);">
        <?php }?>
        </span></div>
      <dl>
        <dt><?php echo $output['class_info']['ac_name']?></dt>
        <dd><?php echo $output['class_info']['ac_des']?></dd>
      </dl>
      <?php if($output['relation'] == 3){?>
      <div id="open_uploader" class="button"><a href="JavaScript:void(0);"><?php echo $lang['sns_upload_more_pic'];?></a></div>
      <div id="uploader" style="display:none"> <i class="arrow"></i>
        <div class="upload-con" >
          <div class="upload-wrap">
            <ul>
              <li class="btn1">
                <div id="divSwfuploadContainer">
                  <div id="divButtonContainer"> <span id="spanButtonPlaceholder"></span> </div>
                </div>
              </li>
            </ul>
            <div id="remote" class="upload-file" style="display:none">
              <iframe src="index.php?act=store_goods&op=image_swupload&id=<?php echo intval($output['goods']['goods_id']); ?>&belong=2&instance=goods_image&upload_type=remote_image" width="208" height="39" scrolling="no" frameborder="0"></iframe>
            </div>
            <div id="goods_upload_progress"></div>
            <div class="upload-txt"><?php echo $lang['album_batch_upload_description'].$GLOBALS['setting_config']['image_max_filesize'].'KB'.$lang['album_batch_upload_description_1'];?></div>
          </div>
        </div>
      </div>
      <?php }?>
    </div>
  </div>
  <?php if(is_array($output['pic_list']) && !empty($output['pic_list'])){?>
    <ul class="nc-sns-pinterest masoned mt20"  id="snsPinterest">
      <?php foreach($output['pic_list'] as $v){?>
      <li class="item">
        <?php if(is_array($output['pic_list']) && !empty($output['pic_list']) && $output['relation'] == 3){?>
        <ul class="handle">
          <li class="cover"><a href="JavaScript:void(0);" onclick="cover(<?php echo $v['ap_id'];?>)"><i></i><?php echo $lang['album_plist_set_to_cover'];?></a></li>
          <li class="delete"><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['album_plist_delete_confirm_message'];?>','index.php?act=sns_album&op=album_pic_del&id=<?php echo $v['ap_id'];?>');"><i></i><?php echo $lang['nc_delete'];?></a></li>
        </ul>
        <?php }?>
        <dl>
          <dt class="goodspic"><span class="thumb size233"><i></i><a href="index.php?act=sns_album&op=album_pic_info&id=<?php echo $v['ap_id'];?>&class_id=<?php echo $v['ac_id']?>&mid=<?php echo $output['master_id'];?><?php if(!empty($_GET['sort'])){?>&sort=<?php echo $_GET['sort']; }?>" title="<?php echo $v['ap_name']?>"> <img id="img_<?php echo $v['ap_id'];?>" src="<?php echo SiteUrl.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$v['ap_cover'].'_240x240.'.get_image_type($v['ap_cover']);?>"></a></span> </dt>
          <dd> <span class="pinterest-addtime"><?php echo $lang['album_plist_upload_time'].$lang['nc_colon'].date("Y-m-d",$v['upload_time'])?></span><!--<span class="ops-comment"><a href="index.php?act=member_snshome&op=goodsinfo&type=like&mid=<?php echo $v['share_memberid'];?>&id=<?php echo $v['share_id'];?>" title="<?php echo $lang['sns_comment'];?>"><i></i></a><em><?php echo $v['share_commentcount'];?></em> </span>--> 
          </dd>
        </dl>
      </li>
      <?php }?>
    </ul>
  <div class="clear" style="padding-top:20px;"></div>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
  <div class="clear"></div>
  <?php }else{?>
  <?php if ($output['relation'] == 3){?>
  <div class="sns-norecord"><i class="pictures pngFix">&nbsp;</i><span><?php echo $lang['sns_no_pic_tips1'];?></span></div>
  <?php }else {?>
  <div class="sns-norecord"><i class="pictures pngFix">&nbsp;</i><span><?php echo $lang['sns_no_pic_tips2'];?></span></div>
  <?php }?>
  <?php }?>
  <script type="text/javascript">
function cover(id){
	if($('#aclass_cover').attr('src') != $('#img_'+id).attr('src')){
		ajaxget('index.php?act=sns_album&op=change_album_cover&id='+id);
	}else{
		showError('<?php echo $lang['album_plist_not_set_same_image'];?>');
	}
}
</script> 
</div>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.masonry.js" type="text/javascript"></script> 
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js"></script> 
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.js"></script> 
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/js/handlers.js"></script> 
<script type="text/javascript">
$(function(){
	$("#snsPinterest").imagesLoaded( function(){
		$("#snsPinterest").masonry({
			itemSelector : '.item'
		});
	});
});
</script> 
<?php if($output['relation'] == '3'){?>
<script type="text/javascript">
var GOODS_SWFU;
$(function(){
    GOODS_SWFU = new SWFUpload({
        upload_url: "index.php?act=sns_swfupload&op=swfupload",
        flash_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.swf",
        post_params: {
            'mid': <?php echo $_SESSION['member_id']?>,
//            "HTTP_USER_AGENT":"Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-CN; rv:1.9.2.4) Gecko/20100611 Firefox/3.6.4 GTB7.1",
            'category_id': <?php echo $output['class_info']['ac_id']?>
        },
        file_size_limit: "<?php echo C('image_max_filesize')/1024;?> MB",
        file_types: "*.gif;*.jpg;*.jpeg;*.png",
        custom_settings: {
            upload_target: "goods_upload_progress",
            if_multirow: 1
        },

        // Button Settings
         button_image_url: "",
        button_width: 170,
        button_height: 50,
        button_text: '<span class="button-text"><?php echo $lang['album_batch_upload'];?></span>',
        button_text_style: '.button-text {font-family: "<?php echo $lang['sns_font_Microsoft_YaHei'];?>","<?php echo $lang['sns_font_Song_typeface'];?>"; font-size: 18px; font-weight: 400; color: #1290CD;}',
        button_text_top_padding: 8,
        button_text_left_padding: 50,
        button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
        button_cursor: SWFUpload.CURSOR.HAND,

        // The event handler functions are defined in handlers.js
        file_queue_error_handler: fileQueueError,
        file_dialog_complete_handler: fileDialogComplete,
        upload_progress_handler: uploadProgress,
        upload_error_handler: uploadError,
        upload_success_handler: uploadSuccess,
        upload_complete_handler: uploadComplete,
        button_placeholder_id: "spanButtonPlaceholder",
        file_queued_handler : fileQueued
    });
});
</script> 
<?php }?>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
var num=0;
function add_uploadedfile(file_data)
{
	file_data = jQuery.parseJSON(file_data);
	if(file_data.state == 'true') {
		num++;
		if(GOODS_SWFU.getStats().files_queued == 0){
            window.setTimeout(function(){
                $('#uploader').hide();
                $('#open_uploader').find('.show').attr('class','hide');
                history.go(0);
            },4000);
        }
		return false;
	} 
}
function upload_complete(){
	alert('<?php echo $lang['album_upload_complete_one'];?>'+num+'<?php echo $lang['album_upload_complete_two'];?>');
}
function img_refresh(id){
	$('#img_'+id).attr('src',$('#img_'+id).attr('src')+"?"+100*Math.random());
}
</script> 
