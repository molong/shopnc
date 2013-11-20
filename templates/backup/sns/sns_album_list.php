<?php defined('InShopNC') or exit('Access Invalid!');?>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH;?>/js/swfupload/css/default.css"/>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/js/handlers.js"></script>
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
            'category_id': <?php echo $output['ac_list']['0']['ac_id']?>
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
        button_text: '<span class="button-text"><?php echo $lang['album_batch_upload']; ?></span>',
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
$(function(){
	$('#sel').change(function(){
		GOODS_SWFU.setPostParams({'category_id':$("#sel").val(),'mid': <?php echo $_SESSION['member_id']?>});
	});
});
</script>
<?php }?>
<script type="text/javascript">
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
</script>
<script type="text/javascript">
		/*鼠标触及li显示dd内的控制按钮*/
			$(document).ready(function(){
				$('.album').children('li').bind('mouseenter',function(){
					$('.album').children('li').attr('class','hidden');
						$(this).attr('class','show');
				});
			$('.album').children('li').bind('mouseleave',function(){
				$('.album').children('li').attr('class','hidden');
				});
			})
        </script>
<script type="text/javascript">
		$(function(){
			$("#img_sort").change(function(){
				$('#select_sort').submit();
			}); 
		});
		</script>
<div class="sns-main-all">
  <div class="tabmenu">
    <?php include template('sns/sns_submenu'); ?>
  </div>
  <div id="pictureIndex" class="picture-index">
    <?php if($output['relation'] == '3'){?>
    <div class="album-info">
      <div class="build-album">
        <div class="button"><a uri="index.php?act=sns_album&op=album_add" nc_type="dialog" dialog_title="<?php echo $lang['album_new_class_add'];?>" class="btn" ><i></i><?php echo $lang['album_new_class_add'];?></a></div>
      </div>
      <div class="upload-photo"> 
        <!-- 上传图片部分 S -->
        <?php if(!empty($output['ac_list']) && $output['relation'] == '3'){?>
        <div id="open_uploader" class="button"><a href="JavaScript:void(0);"><?php echo $lang['sns_upload_more_pic'];?></a></div>
        <div id="uploader" style="display: none;"> <i class="arrow"></i><div class="upload-con">
          <div class="upload-wrap"><?php echo $lang['album_plist_move_album_change'];?>
            <select id="sel" style="width: 120px;">
              <?php foreach ($output['ac_list'] as $v){?>
              <option value='<?php echo $v['ac_id']?>' style=" max-width: 180px;"><?php echo $v['ac_name']?></option>
              <?php }?>
            </select>
          </div>
          <div class="upload-wrap">
            <ul>
              <li class="btn1">
                <div id="divSwfuploadContainer">
                  <div id="divButtonContainer"> <span id="spanButtonPlaceholder"></span> </div>
                </div>
              </li>
            </ul>
            <div id="remote" class="upload_file" style="display:none">
              <iframe src="index.php?act=store_goods&op=image_swupload&id=<?php echo intval($output['goods']['goods_id']); ?>&belong=2&instance=goods_image&upload_type=remote_image" width="208" height="39" scrolling="no" frameborder="0"></iframe>
            </div>
            <div id="goods_upload_progress"></div>
            <div class="upload-txt"><?php echo $lang['album_batch_upload_description'].$GLOBALS['setting_config']['image_max_filesize'].'KB'.$lang['album_batch_upload_description_1'];?></div>
          </div>
        </div></div>
        <?php }?>
        <!-- 上传图片部分 E --> 
      </div>
      <div class="stat"><?php if(C('malbum_max_sum') > 0){?>
      <?php printf($lang['sns_batch_upload_tips1'], count($output['ac_list']), $output['count'], (10-count($output['ac_list'])), (C('malbum_max_sum')-intval($output['count'])))?>
      <?php }else{?>
      <?php printf($lang['sns_batch_upload_tips2'], count($output['ac_list']), (10-count($output['ac_list'])))?>
      <?php }?></div>
    </div>
    <?php }?>
    <?php if(!empty($output['ac_list'])){?>
    <?php foreach ($output['ac_list'] as $v){?>
    <div class="album-cover">
      <div class="cover"> <span class="thumb size190"><i></i><a href="index.php?act=sns_album&op=album_pic_list&id=<?php echo $v['ac_id']?>&mid=<?php echo $output['master_id'];?>">
        <?php if($v['ac_cover'] != ''){ ?>
        <img src="<?php echo SiteUrl.DS.ATTACH_MALBUM.DS.$output['master_id'].DS.$v['ac_cover'];?>" onerror="this.src='<?php echo TEMPLATES_PATH.'/images/member/default_image.png';?>'" >
        <?php }else{?>
        <img src="<?php echo TEMPLATES_PATH.'/images/member/default_image.png';?>" onload=>
        <?php }?>
        </a></span></div>
      <div class="title">
        <h3><?php echo $v['ac_name'];?></h3>
        <em>(<?php echo $v['count']?>)</em></div>
      <?php if($output['relation'] == '3'){?>
      <div class="handle"><a href="JavaScript:void(0);" class="edit" nc_type="dialog" dialog_title="<?php echo $lang['album_class_deit'];?>" dialog_id='album_<?php echo $v['ac_id'];?>' dialog_width="480" uri="index.php?act=sns_album&op=album_edit&id=<?php echo $v['ac_id'];?>"><i></i><?php echo $lang['album_class_edit'];?></a>
        <?php if($v['is_default'] != '1'){?>
        <a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['album_class_delete_confirm_message'];?>', 'index.php?act=sns_album&op=album_del&id=<?php echo $v['ac_id'];?>');" class="del"><i></i><?php echo $lang['album_class_delete'];?></a>
        <?php }?>
      </div>
      <?php }?>
    </div>
    <?php }?>
    <div class="clear"></div>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <div class="clear"></div>
    <?php }else{?>
    <dl>
      <dd class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></dd>
    </dl>
    <?php }?>
  </div>
</div>
