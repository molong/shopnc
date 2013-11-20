<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['article_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=article&op=article"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="article_form" method="post" name="articleForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['article_index_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="article_title" id="article_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="cate_id"><?php echo $lang['article_add_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="ac_id" id="ac_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
              <?php foreach($output['parent_list'] as $k => $v){ ?>
              <option <?php if($output['ac_id'] == $v['ac_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['ac_id'];?>"><?php echo $v['ac_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="articleForm"><?php echo $lang['article_add_url'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="article_url" id="article_url" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['article_add_url_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['article_add_show'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="article_show1" class="cb-enable selected" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="article_show0" class="cb-disable" ><span><?php echo $lang['nc_no'];?></span></label>
            <input id="article_show1" name="article_show" checked="checked" value="1" type="radio">
            <input id="article_show0" name="article_show" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_sort'];?>: 
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="255" name="article_sort" id="article_sort" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['article_add_content'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><?php showEditor('article_content');?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['article_add_upload'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul id="divUploadTypeContainer">
              <li>
                <input name="upload_types" id="bat_upload" type="radio" value="bat_upload" checked="checked" />
                <label for="bat_upload"><?php echo $lang['article_add_batch_upload'];?></label>
              </li>
              <li>
                <input name="upload_types" id="com_upload" type="radio" value="com_upload" />
                <label for="com_upload"><?php echo $lang['article_add_normal_upload'];?></label>
              </li>
            </ul>
            <div id="divSwfuploadContainer">
              <div id="divButtonContainer"> <span id="spanButtonPlaceholder"></span> </div>
              <div id="divFileProgressContainer"></div>
            </div>
            <iframe id="divComUploadContainer" style="display:none;" src="index.php?act=article&op=article_iframe_upload&article_id=<?php echo $output['article_array']['article_id'];?>" width="500" height="46" scrolling="no" frameborder="0"> </iframe></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['article_add_uploaded'];?>:</td>
        <tr>
          <td colspan="2"><ul id="thumbnails" class="thumblists">
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['article_add_insert'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul><div class="tdare">
              
          </div></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.js"></script> 
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/js/handlers.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH;?>/js/swfupload/css/default.css"/>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#article_form").valid()){
     $("#article_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#article_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            article_title : {
                required   : true
            },
			ac_id : {
                required   : true
            },
			article_url : {
				url : true
            },
			article_content : {
                required   : true
            },
            article_sort : {
                number   : true
            }
        },
        messages : {
            article_title : {
                required   : '<?php echo $lang['article_add_title_null'];?>'
            },
			ac_id : {
                required   : '<?php echo $lang['article_add_class_null'];?>'
            },
			article_url : {
				url : '<?php echo $lang['article_add_url_wrong'];?>'
            },
			article_content : {
                required   : '<?php echo $lang['article_add_content_null'];?>'
            },
            article_sort  : {
                number   : '<?php echo $lang['article_add_sort_int'];?>'
            }
        }
    });

	new SWFUpload({
		upload_url: "index.php?act=swfupload&op=article_pic_upload",
		flash_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.swf",
		post_params: {
			"PHPSESSID": "<?php echo $output['PHPSESSID'];?>",
			'item_id': 0
		},
		file_size_limit: "2 MB",
		file_types: "*.gif;*.jpg;*.jpeg;*.png",
		custom_settings: {
			upload_target: "divFileProgressContainer",
			if_multirow: 0
		},

		// Button Settings
		button_image_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",
		button_width: 86,
		button_height: 18,
		button_text: '<span class="button"><?php echo $lang['article_add_batch_upload'];?></span>',
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

	$("input[name='upload_types']").click(
		function()
		{
			$('#divSwfuploadContainer').hide();
			$('#divComUploadContainer').hide();
			$('#divRemUploadContainer').hide();
			switch($(this).val())
			{
				case 'com_upload' :  $('#divComUploadContainer').show(); break;
				case 'bat_upload' :  $('#divSwfuploadContainer').show(); break;
				case 'rem_upload' :  $('#divRemUploadContainer').show(); break;
			}
		}
	);
	
});


function add_uploadedfile(file_data)
{
	file_data = jQuery.parseJSON(file_data);
    var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo SiteUrl.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo SiteUrl.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '\');"><?php echo $lang['article_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('article_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=article&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['article_add_del_fail'];?>');
        }
    });
}


</script>