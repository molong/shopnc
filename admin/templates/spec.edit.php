<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_spec_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=spec&op=spec"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=spec&op=spec_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="spec_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="s_id" value="<?php echo $output['sp_list']['sp_id']?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td class="required" colspan="2"><label class="validation" for="s_name"><?php echo $lang['spec_index_spec_name'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="s_name" id="s_name" value="<?php echo $output['sp_list']['sp_name'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['spec_index_spec_name_desc'];?></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label class="validation" for="s_sort"><?php echo $lang['nc_sort'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="s_sort" id="s_sort" value="<?php echo $output['sp_list']['sp_sort'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['spec_index_spec_sort_desc'];?></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label><?php echo $lang['spec_index_spec_type'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul>
          	<?php if($output['sp_list']['sp_id'] != '1'){?>
              <li>
                <input type="radio" name="s_dtype" id="s_dtype_text" value="text" <?php if($output['sp_list']['sp_format'] == 'text'){?> checked="checked" <?php }?> />
                <label for="s_dtype_text"><?php echo $lang['spec_index_text'];?></label>
              </li>
            <?php }?>
              <li>
                <input type="radio" name="s_dtype" id="s_dtype_image" value="image" <?php if($output['sp_list']['sp_format'] == 'image'){?> checked="checked" <?php }?> />
                <label for="s_dtype_image"><?php echo $lang['spec_index_image'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"><?php echo $lang['spec_index_spec_type_desc'];?></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2 ">
      <thead class="thead">
        <tr class="space">
          <th colspan="15"><?php echo $lang['spec_add_spec_add'];?></th>
        </tr>
        <tr class="noborder">
          <th><?php echo $lang['nc_del'];?></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['spec_index_spec_value'];?></th>
          <th class="image_display"><?php echo $lang['spec_add_spec_image'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="tr_model">
        <tr></tr>
        <?php if(is_array($output['sp_value']) && !empty($output['sp_value'])) {?>
        <?php foreach($output['sp_value'] as $val) {?>
        <tr class="hover edit">
          <input type="hidden" nc_type="submit_value" name='s_value[<?php echo $val['sp_value_id'];?>][form_submit]' value='' />
          <input type="hidden" nc_type="ajax_spec_value_id" value="<?php echo $val['sp_value_id'];?>" />
          <td class="w48"><input type="checkbox" name="s_del[<?php echo $val['sp_value_id'];?>]" value="<?php echo $val['sp_value_id'];?>" /></td>
          <td class="w48 sort"><input type="text" nc_type="change_default_submit_value" name="s_value[<?php echo $val['sp_value_id'];?>][sort]" value="<?php echo $val['sp_value_sort'];?>" /></td>
          <td class="w270 name"><input type="text" nc_type="change_default_submit_value" name="s_value[<?php echo $val['sp_value_id'];?>][name]" value="<?php echo $val['sp_value_name'];?>" /></td>
          <td class="w300 vatop rowform image_display">
            <?php if($val['sp_value_image'] != ''){?>
              <input type="hidden" name='s_value[<?php echo $val['sp_value_id'];?>][image]' value='<?php echo $val['sp_value_image']?>' />
            <?php }?>
            <span class="type-file-show"><img class="low_source" width="16" height="16" src="<?php if($val['sp_value_image'] == ''){echo TEMPLATES_PATH.'/images/transparent.gif';}else{echo SiteUrl.'/'.ATTACH_SPEC.'/'.$val['sp_value_image'];} ?>" /></span><span class="type-file-box">
            <input type="text" name="textfield" class="type-file-text" /><input type="button" name="button" value="" class="type-file-button" />
            <input class="type-file-file" type="file" title="" nc_type="change_default_goods_image" hidefocus="true" size="30" name="s_value_<?php echo $val['sp_value_id'];?>" id="s_value_key">
            </span></td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['spec_edit_spec_value_null'];?></td>
        </tr>
        <?php }?>
      </tbody>
      <tbody>
        <tr>
          <td colspan="15"><a class="btn-add marginleft" id="add_type" href="JavaScript:void(0);"> <span><?php echo $lang['spec_add_spec_add_one'];?></span> </a></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['spec_edit_type_off_shelf'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="off_shelf1" class="cb-enable"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="off_shelf0" class="cb-disable selected"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="off_shelf1" name="off_shelf" value="1" type="radio" />
            <input id="off_shelf0" name="off_shelf" checked="checked" value="0" type="radio" />
          </td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a id="submitBtn" class="btn" href="JavaScript:void(0);"> <span><?php echo $lang['nc_submit'];?></span> </a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function(){
    var i=0;
	var tr_model = '<tr class="hover edit">'+
		'<td></td><td class="w48 sort"><input type="text" name="s_value[key][sort]" value="0" /></td>'+
		'<td class="w270 name"><input type="text" name="s_value[key][name]" value="" /></td>'+
		'<td class="w300 image_display vatop rowform">'+
			'<span class="type-file-show">'+
				'<img class="low_source" width="16" height="16" src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif" />'+
			'</span>'+
			'<span class="type-file-box">'+
				'<input type="text" name="textfield" class="type-file-text" /><input type="button" name="button" value="" class="type-file-button" />'+
				'<input class="type-file-file" type="file" title="" nc_type="change_default_goods_image" hidefocus="true" size="30" name="s_value_key" id="s_value_key">'+
			'</span>'+
		'</td>'+
		'<td></td><td class="w150 align-center"><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo $lang['nc_del'];?></a></td>'+
	'</tr>';
	$("#add_type").click(function(){
		$('#tr_model > tr:last').after(tr_model.replace(/key/g,'s_'+i));
		if($('.image_display').is(":hidden")){
			$('.image_display').hide();
		}
		<?php if(empty($output['sp_value'])) {?>
		$('.no_data').hide();
		<?php }?>
		$.getScript("../resource/js/admincp.js");
		i++;
	});

	//规格图片显示与隐藏操作
	<?php if($output['sp_list']['sp_format'] == 'text'){?>
	$('.image_display').hide();
	<?php }?>
	$('#s_dtype_image').click(function(){
		$('.image_display').show();
	});
	$('#s_dtype_text').click(function(){
		$('.image_display').hide();
	});

	//表单验证
    $('#spec_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
        	s_name: {
        		required : true,
                maxlength: 10,
                minlength: 1
            },
            s_sort: {
				required : true,
				digits	 : true
            }
        },
        messages : {
        	s_name : {
            	required : '<?php echo $lang['spec_add_name_no_null'];?>',
                maxlength: '<?php echo $lang['spec_add_name_max'];?>',
                minlength: '<?php echo $lang['spec_add_name_max'];?>'
            },
            s_sort: {
				required : '<?php echo $lang['spec_add_sort_no_null'];?>',
				digits   : '<?php echo $lang['spec_add_sort_no_digits'];?>'
            }
        }
    });

    //按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
        if($("#spec_form").valid() && confirm('<?php echo $lang['spec_edit_confirm_desc'];?>')){
        	$("#spec_form").submit();
    	}
    });

    //预览图片
    $("input[nc_type='change_default_goods_image']").live("change", function(){
		var src = getFullPath($(this)[0]);
		$(this).parent().prev().find('.low_source').attr('src',src);
	});

    $("input[nc_type='change_default_goods_image']").change(function(){
		$(this).parents('tr:first').find("input[nc_type='submit_value']").val('ok');
	});

    $("input[nc_type='change_default_submit_value']").change(function(){
    	$(this).parents('tr:first').find("input[nc_type='submit_value']").val('ok');
    });
	
});

function remove_tr(o){
	o.parents('tr:first').remove();
}
</script> 
<script type="text/javascript">
$(function(){
	$('input[nc_type="change_default_goods_image"]').live("change", function(){
		$(this).parent().find('input[class="type-file-text"]').val($(this).val());
	});
});
</script> 