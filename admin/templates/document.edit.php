<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['document_index_document'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=document&op=document"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="doc_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="doc_id" value="<?php echo $output['doc']['doc_id'];?>" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['document_index_title'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['doc']['doc_title'];?>" name="doc_title" id="doc_title" class="infoTableInput"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['document_index_content'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php showEditor('doc_content',$output['doc']['doc_content']);?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['document_index_pic_upload'];?>:</td>
        </tr>
        <tr>
          <td colspan="2"><div id="divUploadTypeContainer">
              <input name="upload_types" id="bat_upload" type="radio" value="bat_upload" checked="checked" />
              <label for="bat_upload"><?php echo $lang['document_index_batch_upload'];?></label>
              <input name="upload_types" id="com_upload" type="radio" value="com_upload" />
              <label for="com_upload"><?php echo $lang['document_index_normal_upload'];?></label>
            </div>
            <div id="divSwfuploadContainer">
              <div id="divButtonContainer"> <span id="spanButtonPlaceholder"></span> </div>
              <div id="divFileProgressContainer"></div>
            </div>
            <iframe id="divComUploadContainer" style="display:none;" src="index.php?act=document&op=document_iframe_upload&doc_id=<?php echo $output['doc']['doc_id'];?>" width="500" height="46" scrolling="no" frameborder="0"> </iframe></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['document_index_uploaded_pic'];?>:</td>
        </tr>
        <tr>
          <td colspan="2" ><div class="tdare">
              <table width="600px" cellspacing="0" class="dataTable">
                <tbody id="thumbnails">
                  <?php if(is_array($output['file_upload'])){?>
                  <?php foreach($output['file_upload'] as $k => $v){ ?>
                  <tr id="<?php echo $v['upload_id'];?>" class="tatr2">
                    <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                    <td><img width="40px" height="40px" src="<?php echo $v['upload_path'];?>" /></td>
                    <td><?php echo $v['file_name'];?></td>
                    <td><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['document_index_insert'];?></a> | <a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </tbody>
              </table>
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
    if($("#doc_form").valid()){
     $("#doc_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#doc_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            doc_title : {
                required   : true
            },
			doc_content : {
                required   : true
            }
        },
        messages : {
            doc_title : {
                required   : '<?php echo $lang['document_index_title_null'];?>'
            },
			doc_content : {
                required   : '<?php echo $lang['document_index_content_null'];?>'
            }
        }
    });

	new SWFUpload({
		upload_url: "index.php?act=swfupload&op=document_pic_upload",
		flash_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.swf",
		post_params: {
			"PHPSESSID": "<?php echo $output['PHPSESSID'];?>",
			'item_id': <?php echo $output['doc']['doc_id'];?>
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
		button_text: '<span class="button"><?php echo $lang['document_index_batch_upload'];?></span>',
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
    var newImg = '<tr id="' + file_data.file_id + '" class="tatr2"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><td><img width="40px" height="40px" src="<?php echo SiteUrl.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" /></td><td>' + file_data.file_name + '</td><td><a href="javascript:insert_editor(\'<?php echo SiteUrl.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '\');"><?php echo $lang['document_index_insert'];?></a> | <a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></td></tr>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('doc_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=document&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['document_index_del_fail'];?>');
        }
    });
}
</script>