<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SiteUrl?>/resource/js/swfupload/css/default.css" rel="stylesheet" type="text/css">
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
            'category_id': <?php echo $output['class_info']['aclass_id']?>
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
	alert('<?php echo $lang['album_upload_complete_one'];?>'+num+'<?php echo $lang['album_upload_complete_two'];?>');
}
function img_refresh(id){
	$('#img_'+id).attr('src',$('#img_'+id).attr('src')+"?"+100*Math.random());
}
function img_replace_error(error){
	alert(error);
}
</script>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu'); ?>
  </div>
  <div id="pictureFolder">
    <div class="intro">
      <div class="covers"><span class="thumb size60"><i></i>
        <?php if($output['class_info']['aclass_cover'] != ''){ ?>
        <img id="aclass_cover" src="<?php echo cthumb($output['class_info']['aclass_cover'],'tiny',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,60,60);">
        <?php }else{?>
        <img id="aclass_cover" src="<?php echo TEMPLATES_PATH.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,60,60);">
        <?php }?>
        </span></div>
      <dl>
        <dt><?php echo $output['class_info']['aclass_name']?></dt>
        <dd><?php echo $output['class_info']['aclass_des']?></dd>
      </dl>
    </div>
    <div class="picture-control">
      <?php if(is_array($output['pic_list']) && !empty($output['pic_list'])){?>
      <dl class="batch">
        <dt id="batchTab"><a href="JavaScript:void(0);" class="btn1" onClick="Effect('batchSub',this.parentNode.id);"><?php echo $lang['album_plist_batch_processing'];?></a></dt>
        <dd id="batchSub" style=" display:none;"> <a href="JavaScript:void(0);" onClick="checkAll()"><?php echo $lang['album_plist_check_all'];?></a>| <a href="JavaScript:void(0);" onClick="uncheckAll()"><?php echo $lang['album_plist_cancel'];?></a>| <a href="JavaScript:void(0);" onClick="switchAll()"><?php echo $lang['album_plist_inverse'];?></a>| <a href="JavaScript:void(0);" onClick="submit_form('del')"><?php echo $lang['album_class_delete'];?></a>| <a href="JavaScript:void(0);" id="img_move"><?php echo $lang['album_plist_move_album'];?></a>
        <?php if (!C('ftp_open') && C('thumb.save_type')!=3){?>
        | <a href="JavaScript:void(0);" onClick="submit_form('watermark')"><?php echo $lang['album_plist_add_watermark'];?></a><?php }?> </dd>
        <dd id="batchClass" style=" display:none;">
          <?php if(!empty($output['class_list'])){?>
          <span><?php echo $lang['album_plist_move_album_change'].$lang['nc_colon'];?></span>
          <select name="cid" id="cid" style="width:100px;">
            <?php foreach ($output['class_list'] as $v){?>
            <option value="<?php echo $v['aclass_id']?>" style="width:80px;"><?php echo $v['aclass_name']?></option>
            <?php }?>
          </select>
          <input type="button" onClick="submit_form('move')" value="<?php echo $lang['album_plist_move_album_begin'];?>" />
          <?php }else{?>
          <span><?php echo $lang['album_plist_move_album_only_one'];?><a href="JavaScript:void(0);" uri="index.php?act=store_album&op=album_add" nc_type="dialog" dialog_title="<?php echo $lang['album_class_add'];?>"><?php echo $lang['album_class_add'];?></a><?php echo $lang['album_plist_move_album_only_two'];?></span>
          <?php }?>
        </dd>
      </dl>
      <?php }?>
      <div class="sortord">
        <?php if(is_array($output['pic_list']) && !empty($output['pic_list'])){?>
        <form name="select_sort" id="select_sort">
          <input type="hidden" name="act" value="store_album" />
          <input type="hidden" name="op" value="album_pic_list" />
          <input type="hidden" name="id" value="<?php echo $output['class_info']['aclass_id']?>" />
          <?php echo $lang['album_sort'].$lang['nc_colon'];?>
          <select name="sort" id="img_sort">
            <option value="0"  <?php if($_GET['sort'] == '0'){?>selected <?php }?> ><?php echo $lang['album_sort_upload_time_desc'];?></option>
            <option value="1"  <?php if($_GET['sort'] == '1'){?>selected <?php }?> ><?php echo $lang['album_sort_upload_time_asc'];?></option>
            <option value="2"  <?php if($_GET['sort'] == '2'){?>selected <?php }?> ><?php echo $lang['album_sort_img_size_desc'];?></option>
            <option value="3"  <?php if($_GET['sort'] == '3'){?>selected <?php }?> ><?php echo $lang['album_sort_img_siza_asc'];?></option>
            <option value="4"  <?php if($_GET['sort'] == '4'){?>selected <?php }?> ><?php echo $lang['album_sort_img_name_desc'];?></option>
            <option value="5"  <?php if($_GET['sort'] == '5'){?>selected <?php }?> ><?php echo $lang['album_sort_img_name_asc'];?></option>
          </select>
        </form>
        <?php }?>
      </div>
      <div id="open_uploader" class="upload"><a href="JavaScript:void(0);" class="hide"><?php echo $lang['album_class_list_img_upload'];?></a></div>
      <div class="upload-con" id="uploader" style="display:none">
        <div class="upload-con-top"></div>
        <div class="upload-wrap"> <?php echo $lang['album_class_list_sel_img_class'].$lang['nc_colon'].str_cut($output['class_info']['aclass_name'],18);?> </div>
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
          <div class="upload-txt"> <span><?php echo $lang['album_batch_upload_description'].$GLOBALS['setting_config']['image_max_filesize'].'KB'.$lang['album_batch_upload_description_1'];?></span> </div>
        </div>
        <div class="upload-con-bottom"></div>
      </div>
    </div>
    <div class="clear" style=" height:10px; border-bottom: solid 1px #E7E7E7;"></div>
    <div class="change-info">
      <p class="ico"><?php echo $lang['album_plist_replace_same_type'];?></p>
    </div>
    <?php if(is_array($output['pic_list']) && !empty($output['pic_list'])){?>
    <form name="checkboxform" id="checkboxform">
      <input type="hidden" name="act" value="store_album" />
      <input type="hidden" name="op" id="op" value="" />
      <ul class="picture-list">
        <?php foreach($output['pic_list'] as $v){?>
        <li class="normal">
          <dl>
            <dt>
              <div class="picture"><span class="thumb size160"><i></i><a href="index.php?act=store_album&op=album_pic_info&id=<?php echo $v['apic_id'];?>&class_id=<?php echo $v['aclass_id']?><?php if(!empty($_GET['sort'])){?>&sort=<?php echo $_GET['sort']; }?>"> <img id="img_<?php echo $v['apic_id'];?>" src="<?php echo thumb($v,'small');?>" onload="javascript:DrawImage(this,160,160);"></a></span></div>
              <input id="C<?php echo $i=$i?$i:1;$i++;?>" name="id[]" value="<?php echo $v['apic_id'];?>" type="checkbox" class="checkbox" style="display:none"/>
              <input id="<?php echo $v['apic_id'];?>" class="editInput1" readonly onDblClick="$(this).unbind();_focus($(this));" value="<?php echo $v['apic_name']?>" title="<?php echo $lang['album_plist_double_click_edit'];?>" style="cursor:pointer;">
              <span class="edit-ico" onDblClick="_focus($(this).prev());" title="<?php echo $lang['album_plist_double_click_edit'];?>"></span> </dt>
            <dd class="date">
              <p><?php echo $lang['album_plist_upload_time'].$lang['nc_colon'].date("Y-m-d",$v['upload_time'])?></p>
              <p><?php echo $lang['album_plist_original_size'].$lang['nc_colon'].$v['apic_spec']?></p>
            </dd>
            <dd class="buttons"> <span class="change-btn">
              <iframe src="index.php?act=store_album&op=replace_image_upload&id=<?php echo intval($v['apic_id']); ?>" width="84" height="20" scrolling="no" frameborder="0"></iframe>
              </span><a href="JavaScript:void(0);" class="remove" nc_type="dialog" dialog_title="<?php echo $lang['album_plist_move_album'];?>" uri="index.php?act=store_album&op=album_pic_move&cid=<?php echo $output['class_info']['aclass_id']?>&id=<?php echo $v['apic_id']?>"><?php echo $lang['album_plist_move_album'];?></a> <a href="JavaScript:void(0);" onclick="cover(<?php echo $v['apic_id'];?>)" class="cover"><?php echo $lang['album_plist_set_to_cover'];?></a> <a class="delete" href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['album_plist_delete_confirm_message'];?>','index.php?act=store_album&op=album_pic_del&id=<?php echo $v['apic_id'];?>');"><?php echo $lang['album_plist_delete_img'];?></a> </dd>
          </dl>
        </li>
        <?php }?>
      </ul>
    </form>
    <div class="clear" style="padding-top:20px;"></div>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <div class="clear"></div>
    <?php }else{?>
    <dl>
      <dt class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></dt>
    </dl>
    <?php }?>
    <script type="text/javascript">
		  
<!-- Begin
function checkAll() {
	$('#batchClass').hide();
	for (var j = 1; j <= 12; j++) {
		box = eval("document.checkboxform.C" + j); 
		if (box.checked == false) box.checked = true;
   }
}

function uncheckAll() {
	$('#batchClass').hide();
	for (var j = 1; j <= 12; j++) {
		box = eval("document.checkboxform.C" + j); 
		if (box.checked == true) box.checked = false;
   }
}

function switchAll() {
	$('#batchClass').hide();
	for (var j = 1; j <= 12; j++) {
		box = eval("document.checkboxform.C" + j); 
		box.checked = !box.checked;
   }
}
//  End -->
//控制Li鼠标触及时更替显示样式
$(document).ready(function(){
		$('.picture-list').children('li').bind('mouseenter',function(){
			$('.picture-list').children('li').attr('class','normal');
			$(this).attr('class','active');
		});
		$('.picture-list').children('li').bind('mouseleave',function(){
			$('.picture-list').children('li').attr('class','normal');
		});
})
var obj;
//控制图片名称input焦点可编辑
function _focus(o){
	var name;
        obj = o;
        name=obj.val();
        obj.attr('readonly','');
        obj.attr('class','editInput2');
        obj.select();
        obj.blur(function(){
			if(name != obj.val()){
               _save(this);
			}else{
				obj.attr('class','editInput1');
				obj.attr('readonly','readonly');
			}
        });
}
function _save(obj){
		$.post('index.php?act=store_album&op=change_pic_name', {id:obj.id,name:obj.value}, function(data) {
			if(data == 'false'){
				showError('<?php echo $lang['nc_common_op_fail'];?>');
			}else{
				showDialog('<?php echo $lang['nc_common_op_succ']?>','succ');
			}
		});
        obj.className = "editInput1";
        obj.readOnly = true;
}
</script> 
    <script>
function $G(Read_Id) { return document.getElementById(Read_Id) }

function Effect(ObjectId,parentId){
  if ($G(ObjectId).style.display == 'none'){
  $('.checkbox').show();
  Start(ObjectId,'Opens');
  $G(parentId).innerHTML = "<a href='JavaScript:void(0);' class='btn2' onClick=javascript:Effect('"+ObjectId+"','"+parentId+"'); ><?php echo $lang['album_plist_cancel_batch_processing'];?></a>"
  }else{
  $('.checkbox').hide();
  Start(ObjectId,'Close');
  $G(parentId).innerHTML = "<a href='JavaScript:void(0);' class='btn1' onClick=javascript:Effect('"+ObjectId+"','"+parentId+"'); ><?php echo $lang['album_plist_batch_processing'];?></a>"
  }
}

function Start(ObjId,method){
var BoxHeight = $G(ObjId).offsetHeight;         //获取对象高度
var MinHeight = 5;                  //定义对象最小高度
var MaxHeight = 28;                 //定义对象最大高度
var BoxAddMax = 1;                  //递增量初始值
var Every_Add = 0.05;                //每次的递(减)增量  [数值越大速度越快]
var Reduce = (BoxAddMax - Every_Add);
var Add    = (BoxAddMax + Every_Add);

if (method == "Close"){
var Alter_Close = function(){            //构建一个虚拟的[递减]循环
  BoxAddMax /= Reduce;
  BoxHeight -= BoxAddMax;
  if (BoxHeight <= MinHeight){
    $G(ObjId).style.display = "none";
    $('#batchClass').hide();
    window.clearInterval(BoxAction);
  }
  else $G(ObjId).style.height = BoxHeight;
}
var BoxAction = window.setInterval(Alter_Close,1);
}

else if (method == "Opens"){
var Alter_Opens = function(){            //构建一个虚拟的[递增]循环
  BoxAddMax *= Add;
  BoxHeight += BoxAddMax;
  if (BoxHeight >= MaxHeight){
    $G(ObjId).style.height = MaxHeight;
    window.clearInterval(BoxAction);
  }else{
  $G(ObjId).style.display= "block";
  $G(ObjId).style.height = BoxHeight;
  }
}
var BoxAction = window.setInterval(Alter_Opens,1);
}

}
</script> 
    <script type="text/javascript">
function submit_form(type){
	if(type != 'move'){
		$('#batchClass').hide();
	}
	var id='';
	$('input[type=checkbox]:checked').each(function(){
		if(!isNaN($(this).val())){
			id += $(this).val();
		}
	});
	if(id == ''){
		alert('<?php echo $lang['album_plist_select_img']?>');
		return false;
	}
	if(type=='del'){
		if(!confirm('<?php echo $lang['album_plist_delete_confirm_message'];?>')){
			return false;
		}
	}
	$('#op').val('album_pic_'+type);
	if(type='move'){
		$('#checkboxform').append('<input type="hidden" name="form_submit" value="ok" /><input type="hidden" name="cid" value="'+$('#cid').val()+'" />');
	}
	$('#checkboxform').submit();
}
function cover(id){
	if($('#aclass_cover').attr('src') != $('#img_'+id).attr('src')){
		ajaxget('index.php?act=store_album&op=change_album_cover&id='+id);
	}else{
		showError('<?php echo $lang['album_plist_not_set_same_image'];?>');
	}
}
</script> 
    <script type="text/javascript">
$(function(){
	$("#img_sort").change(function(){
		$('#select_sort').submit();
	}); 
	$("#img_move").click(function(){
		if($('#batchClass').css('display') == 'none'){
			$('#batchClass').show();
		}else {
			$('#batchClass').hide();
		}
	});
});
</script> 
  </div>
</div>
