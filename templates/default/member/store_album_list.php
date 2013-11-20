<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/js/handlers.js"></script>
<script type="text/javascript">
var GOODS_SWFU;
$(function(){
    GOODS_SWFU = new SWFUpload({
        upload_url: "index.php?act=swfupload2&op=swfupload&instance=goods_image",
        flash_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.swf",
        post_params: {
            'sid': <?php echo $_SESSION['store_id']?>,
          	"PHPSESSID": "<?php echo $output['PHPSESSID'];?>",
            "HTTP_USER_AGENT":"Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-CN; rv:1.9.2.4) Gecko/20100611 Firefox/3.6.4 GTB7.1",
            'category_id': <?php echo $output['aclass_info']['0']['aclass_id']?>
        },
        file_size_limit: "2 MB",
        file_types: "*.gif;*.jpg;*.jpeg;*.png",
        custom_settings: {
            upload_target: "goods_upload_progress",
            if_multirow: 1
        },

        // Button Settings
        button_image_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",
        button_width: 86,
        button_height: 18,
        button_text: '<span class="button"><?php echo $lang['album_batch_upload'];?></span>',
        button_text_style: '.button {font-family: Helvetica, Arial, sans-serif; font-size: 12pt; font-weight: bold; color: #3F3D3E;} .buttonSmall {font-size: 10pt;}',
        button_text_top_padding: 0,
        button_text_left_padding: 18,
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
		GOODS_SWFU.setPostParams({'category_id':$("#sel").val(),'sid': <?php echo $_SESSION['store_id']?>});
	});
});
</script>
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
	if (num == 0){
		alert('<?php echo $lang['album_upload_file_tips'];?>');
	}else{
		alert('<?php echo $lang['album_upload_complete_one'];?>'+num+'<?php echo $lang['album_upload_complete_two'];?>');
	}
}
</script>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH;?>/js/swfupload/css/default.css"/>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu'); ?>
  </div>
  <div id="pictureIndex">
    <div class="picture-control">
      <div class="newalbum"><a uri="index.php?act=store_album&op=album_add" nc_type="dialog" dialog_title="<?php echo $lang['album_class_add'];?>" class="btn" ><?php echo $lang['album_class_add'];?></a></div>
      <div class="sortord">
        <form name="select_sort" id="select_sort">
          <input type="hidden" name="act" value="store_album" />
          <input type="hidden" name="op" value="album_cate" />
          <?php echo $lang['album_sort'];?>:
          <select  name="sort" id="img_sort">
            <option value="4" <?php if($_GET['sort'] == '4' || !isset($_GET['sort'])){?>selected <?php }?> ><?php echo $lang['album_sort_desc'];?></option>
            <option value="5" <?php if($_GET['sort'] == '5'){?>selected <?php }?> ><?php echo $lang['album_sort_asc']?></option>
            <option value="0" <?php if($_GET['sort'] == '0'){?>selected <?php }?> ><?php echo $lang['album_sort_time_desc'];?></option>
            <option value="1" <?php if($_GET['sort'] == '1'){?>selected <?php }?> ><?php echo $lang['album_sort_time_asc'];?></option>
            <option value="2" <?php if($_GET['sort'] == '2'){?>selected <?php }?> ><?php echo $lang['album_sort_class_name_desc'];?></option>
            <option value="3" <?php if($_GET['sort'] == '3'){?>selected <?php }?> ><?php echo $lang['album_sort_class_name_asc']?></option>
          </select>
        </form>
      </div>
      <?php if(!empty($output['aclass_info'])){?>
      <div id="open_uploader" class="upload"><a href="JavaScript:void(0);" class="hide"><?php echo $lang['album_class_list_img_upload'];?></a></div>
      <div class="upload-con" id="uploader" style=" display: none;">
        <div class="upload-con-top"></div>
        <div class="upload-wrap"> <?php echo $lang['album_class_list_sel_img_class'].$lang['nc_colon'];?>
          <select id="sel" style="width:100px;">
            <?php foreach ($output['aclass_info'] as $v){?>
            <option value='<?php echo $v['aclass_id']?>' style="width:80px;"><?php echo $v['aclass_name']?></option>
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
          <div class="upload-txt"><span><?php echo $lang['album_batch_upload_description'].$GLOBALS['setting_config']['image_max_filesize'].'KB'.$lang['album_batch_upload_description_1'];?></span> </div>
        </div>
        <div class="upload-con-bottom"></div>
      </div>
      <?php }?>
    </div>
    <div class="clear" style=" border-bottom: solid 1px #E7E7E7;">&nbsp;</div>
    <?php if(!empty($output['aclass_info'])){?>
    <ul class="album">
      <?php foreach ($output['aclass_info'] as $v){?>
      <li class="hidden">
        <dl>
          <dt>
            <div class="covers"><a href="index.php?act=store_album&op=album_pic_list&id=<?php echo $v['aclass_id']?>"> <span class="thumb size150"><i></i>
              <?php if($v['aclass_cover'] != ''){ ?>
              <img id="aclass_cover" src="<?php echo cthumb($v['aclass_cover'],'small',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,150,150);">
              <?php }else{?>
              <img src="<?php echo TEMPLATES_PATH.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,150,150);">
              <?php }?>
              </span></a></div>
            <h3 class="title"><a href="index.php?act=store_album&op=album_pic_list&id=<?php echo $v['aclass_id']?>"><?php echo $v['aclass_name'];?></a></h3>
            <h5 class="quantity"><?php echo $lang['album_class_pic_altogether'];?><?php echo $v['count']?><?php echo $lang['album_class_pic_folio'];?></h5>
          </dt>
          <dd class='table'> <span  nc_type="dialog" dialog_title="<?php echo $lang['album_class_deit'];?>" dialog_id='album_<?php echo $v['aclass_id'];?>' dialog_width="480" uri="index.php?act=store_album&op=album_edit&id=<?php echo $v['aclass_id'];?>"><a href="JavaScript:void(0);" class="edit2"  ><?php echo $lang['album_class_edit'];?></a></span>
            <?php if($v['is_default'] != '1'){?>
            <a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['album_class_delete_confirm_message'];?>', 'index.php?act=store_album&op=album_del&id=<?php echo $v['aclass_id'];?>');" class="del"><?php echo $lang['album_class_delete'];?></a>
            <?php }?>
          </dd>
        </dl>
      </li>
      <?php }?>
    </ul>
    <div class="clear"></div>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <div class="clear"></div>
    <?php }else{?>
    <dl>
      <dd class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></dd>
    </dl>
    <?php }?>
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
  </div>
</div>
