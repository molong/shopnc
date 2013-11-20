<div class="eject_con">

    <div id="warning"></div>
    <form method="post" target="_parent" action="index.php?act=store_goods&op=<?php if ($output['brand_array']['brand_id']!='') echo 'brand_edit'; else echo 'brand_save'; ?>"enctype="multipart/form-data" id="brand_apply_form">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="brand_id" value="<?php echo $output['brand_array']['brand_id']; ?>" />
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_brand_name'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text" name="brand_name" value="<?php echo $output['brand_array']['brand_name']; ?>" id="brand_name" />
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_brand_class'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text"  class="text" name="brand_class" value="<?php echo $output['brand_array']['brand_class']; ?>" />
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_brand_icon'].$lang['nc_colon'];?></dt>
        <dd><p><span class="sign"><img src="<?php if ($output['brand_array']['brand_pic']!='') echo ATTACH_BRAND.'/'.$output['brand_array']['brand_pic']; else echo TEMPLATES_PATH.'/images/member/default.gif'; ?>" onload="javascript:DrawImage(this,88,44)" nc_type="logo1"/></span></p>
          <p><input type="file" maxlength="0" hidefocus="true" nc_type="logo" name="brand_pic" id="brand_pic"/></p>
          </dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd>
          <p class="hint"><?php echo $lang['store_goods_brand_upload_tip'];?></p>
        </dd>
      </dl>
      <dl class="bottom"><dt>&nbsp;</dt>
        <dd><input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"/></dd>
      </dl>
    </form>
  </div>

<script type="text/javascript">
$(function(){
    $('#brand_apply_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('brand_apply_form', '', '', 'onerror') 
    	},
        rules : {
            brand_name : {
                required : true,
                rangelength: [0,100]
            }
			<?php if ($output['brand_array']['brand_id']=='') { ?>
			,
            brand_pic : {
                required : true
			}
			<?php } ?>		
        },
        messages : {
            brand_name : {
                required : '<?php echo $lang['store_goods_brand_input_name'];?>',
                rangelength: '<?php echo $lang['store_goods_brand_name_error'];?>'
            }
			<?php if ($output['brand_array']['brand_id']=='') { ?>
			,
            brand_pic : {
                required : '<?php echo $lang['store_goods_brand_icon_null'];?>'
			}
			<?php } ?>
        }
    });
	$('input[nc_type="logo"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="logo1"]').attr('src', src);
	});
});


</script> 
