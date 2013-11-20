<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/swfupload/js/handlers.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH;?>/js/swfupload/css/default.css"/>
<script type="text/javascript">
//<!CDATA[
function sgcInit(){
	var sgcate	= $("select[name='stc_id[]']").clone();
	$("select[name='stc_id[]']").remove();
	sgcate.clone().appendTo('#div_sgcate');
	$("#add_sgcategory").click(function(){
		sgcate.clone().appendTo('#div_sgcate');
	});
}
//上传图片回调时用到
function add_uploadedfile(file_data){}
var GOODS_SWFU;
$(document).ready(function(){
	sgcInit();
	GOODS_SWFU = new SWFUpload({
		upload_url: "<?php echo SiteUrl;?>/index.php?act=iswfupload&op=import_pic_upload",
		flash_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/swfupload.swf",
		post_params: {
            'sid': <?php echo $_SESSION['store_id']?>,
            "HTTP_USER_AGENT":"Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-CN; rv:1.9.2.4) Gecko/20100611 Firefox/3.6.4 GTB7.1",
            'category_id': <?php echo $output['aclass_info']['0']['aclass_id']?>
		},
		file_size_limit: "2 MB",
		file_types: "*.tbi",
		custom_settings: {
			upload_target: "divFileProgressContainer",
			if_multirow: 0
		},
	
		// Button Settings
		button_image_url: "<?php echo RESOURCE_PATH;?>/js/swfupload/images/SmallSpyGlassWithTransperancy_17x18.png",
		button_width: 86,
		button_height: 18,
		button_text: '<span class="button"><?php echo $lang['store_goods_index_batch_upload'];?></span>',
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
    $('#goods_form').validate({
        rules : {
            csv : {
                required : true,
                accept: 'csv'
            },
            gc_id : {
                required : true,
                remote   : {
                    url  : 'index.php?act=store_goods&op=check_class',
                    type : 'get',
                    data : {
                        cate_id : function(){
                            return $("#gc_id").val();
                        }
                    }
                }
            }
        },
        messages : {
            csv : {
                required : '<?php echo $lang['store_goods_import_choose_file'];?>',
                accept : '<?php echo $lang['store_goods_import_choose_file'];?>'
            },
            gc_id : {
                required : '<?php echo $lang['store_goods_import_wrong_class2'];?>',
                remote : '<?php echo $lang['store_goods_import_wrong_class2'];?>'
            }
        }
    });
	$('#sel').change(function(){
		GOODS_SWFU.setPostParams({'category_id':$("#sel").val(),'sid': <?php echo $_SESSION['store_id']?>});
	});
	gcategoryInit("gcategory");
	var area_select = $("#province_id");
	areaInit(area_select,0);//初始化地区
	// 选择地区
	$("#province_id").change(provinceChange);
	function provinceChange(){
	   // 删除后面的select
	   $(this).nextAll("select").remove();
	   if (this.value > 0){
	        var text = $(this).get(0).options[$(this).get(0).selectedIndex].text;
	        var area_id = this.value;
	        var EP = new Array();
	        EP[1]= true;EP[2]= true;EP[9]= true;EP[22]= true;EP[34]= true;EP[35]= true;
	        if(typeof(nc_a[area_id]) != 'undefined'){//数组存在
	        	var areas = new Array();
	        	var option = "";
	        	areas = nc_a[area_id];
          	if (typeof(EP[area_id]) == 'undefined'){
          		option = "<option value='0'>"+text+"(*)</option>";
          	}
          	$("<select name='city_id' id='city_id'>"+option+"</select>").insertAfter(this);
	        	for (i = 0; i <areas.length; i++){
	        		$(this).next("select").append("<option value='" + areas[i][0] + "'>" + areas[i][1] + "</option>");
	        	}
	        }
	   }	 	
	}
});

function upload_complete(){
	$('#import_step2_ok').css('display','');
	$('#ul_import_step3').css('display','');
}
//]]>
</script>
<div class="wrap">
<div class="tabmenu">
  <?php include template('member/member_submenu');?>
</div>
<div class="ncu-form-style">
  <form method="post" action="index.php?act=store_goods&op=taobao_import" enctype="multipart/form-data" id="goods_form">
    <h3> <?php echo $lang['store_goods_import_step1'];?>
      <?php if($output['step'] == '2'){?>
      <label class="error right">OK!</label>
      <?php }?>
    </h3>
    <ul <?php if($output['step'] == '2'){?> style="display:none"<?php }?>>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_import_choose_csv'];?></dt>
        <dd>
          <p>
            <input type="file" name="csv" id="csv" />
          </p>
          <p class="hint"><?php echo $lang['store_goods_import_title_csv'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_import_goods_class'];?></dt>
        <dd>
          <p id="gcategory">
            <select>
              <option value="0"><?php echo $lang['nc_please_choose'];?></option>
              <?php if(!empty($output['gc_list']) && is_array($output['gc_list']) ) {?>
              <?php foreach ($output['gc_list'] as $gc) {?>
              <option value="<?php echo $gc['gc_id'];?>"><?php echo $gc['gc_name'];?></option>
              <?php }?>
              <?php }?>
            </select>
            <input type="hidden" id="gc_id" name="gc_id" value="" class="mls_id" />
            <input type="hidden" name="cate_name" value="" class="mls_names"/>
          <p>
          <p class="hint"><?php echo $lang['store_goods_import_wrong_class'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_import_area'];?></dt>
        <dd>
          <p id="region">
            <select class="d_inline" name="province_id" id="province_id">
            </select>
          </p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_import_store_goods_class'];?></dt>
        <dd>
          <p id="div_sgcate">
            <select name="stc_id[]" class="sgcategory fl mr5" onchange='preventSelectDisabled(this);'>
              <option value="0"><?php echo $lang['nc_please_choose'];?></option>
              <?php foreach ($output['store_goods_class'] as $val) {?>
              <option value="<?php echo $val['stc_id']; ?>"><?php echo $val['stc_name']; ?></option>
              <?php if (is_array($val['child']) && count($val['child'])>0){?>
              <?php foreach ($val['child'] as $child_val){?>
              <option value="<?php echo $child_val['stc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
              <?php }?>
              <?php }?>
              <?php }?>
            </select>
            <a class="ncu-btn2" id="add_sgcategory" href="javascript:void(0)"><?php echo $lang['store_goods_import_new_class'];?></a>
          <p class="hint"><?php echo $lang['store_goods_import_belong_multiple_store_class'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_import_unicode'];?></dt>
        <dd>
          <p>unicode </p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_import_file_type'];?></dt>
        <dd>
          <p><?php echo $lang['store_goods_import_file_csv'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_import_desc'];?></dt>
        <dd>
          <p><?php echo $lang['store_goods_import_csv_desc'];?></p>
        </dd>
      </dl>
      <dl>
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['store_goods_import_submit'];?>" />
      </dd>
    </ul>
    <h3><?php echo $lang['store_goods_import_step2'];?></h3>
    <ul id="ul_import_step2" <?php if($output['step'] != '2'){?> style="display:none;" <?php }?>>
      <dl>
        <dt><?php echo $lang['store_goods_import_upload_album'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <select id="sel">
              <?php if(!empty($output['aclass_info']) && is_array($output['aclass_info'])){?>
              <?php foreach ($output['aclass_info'] as $v){?>
              <option value='<?php echo $v['aclass_id']?>'  style="width:80px;"><?php echo $v['aclass_name']?></option>
              <?php }?>
              <?php }?>
            </select>
          </p>
          <p class="hint"><?php echo $lang['store_goods_import_tbi_desc'];?></p>
        </dd>
      </dl>
      <dl id="trUploadContainer">
        <dt>&nbsp;</dt>
        <dd style="height:80px;">
          <div id="divSwfuploadContainer">
            <div id="divButtonContainer"> <span id="spanButtonPlaceholder"></span> </div>
            <div id="divFileProgressContainer"></div>
          </div>
          <div id="warning"></div>
        </dd>
      </dl>
    </ul>
    <h3> <?php echo $lang['store_goods_import_step3'];?> </h3>
    <ul id="ul_import_step3" style="display:none">
      <dl>
        <dt><?php echo $lang['store_goods_import_step3'];?></dt>
        <dd><span><?php echo $lang['store_goods_import_remind'];?>?</span><span class="red"><?php echo $lang['store_goods_import_remind2'];?></span></dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd>
          <input name="" type="submit" class="submit" value="<?php echo $lang['store_goods_import_pack'];?>" onclick="if(confirm('<?php echo $lang['store_goods_import_remind'];?>')){window.location.href='index.php?act=store_goods&op=date_pack&goods_id_str='+'<?php echo $output['goods_id_str'];?>';}"/>
        </dd>
      </dl>
    </ul>
  </form>
</div>
<script>
function preventSelectDisabled(oSelect)
{
   //得到当前select选中项的disabled属性。
   var isOptionDisabled = oSelect.options[oSelect.selectedIndex].disabled;
   //如果是有disabled属性的话
   if(isOptionDisabled)
   {
      //让他恢复上一次选择的状态，oSelect.defaultSelectedIndex属性是前一次选中的选项index
      //oSelect.selectedIndex = oSelect.defaultSelectedIndex;
	  //让他恢复未选择状态
	  oSelect.selectedIndex = '0';
      return false;
   }
  //如果没有disabled属性的话
   else
   {
	   var currentvalue = oSelect.value;
	   //为了实现下面的验证,先清空选择的项
       oSelect.value = '0';
	   if(checkselected(currentvalue)){
		 	//oSelect.defaultSelectedIndex属性，设置成当前选择的index
	        oSelect.value = currentvalue;   
	   }else{
		   //alert("该分类已经选择,请选择其他分类");
		   alert('<?php echo $lang['store_goods_index_add_sclasserror']; ?>');
	   }
       return true;
   }
}
function checkselected(currentvalue){
	var result = true;
	jQuery.each($(".sgcategory"),function(){
		if(currentvalue!=0 && currentvalue == $(this).val()){
			result = false;
		}
	});
	return result;
}
</script> 
</div>
