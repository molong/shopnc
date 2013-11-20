<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_type_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=type&op=type"><span><?php echo $lang['nc_list'];?></span></a></li>
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="type_form" method="post">
    <table id="prompt" class="table tb-type2">
      <tbody>
        <tr class="space odd">
          <th colspan="12" class="nobg"> <div class="title">
              <h5><?php echo $lang['nc_prompts'];?></h5>
              <span class="arrow"></span> </div>
          </th>
        </tr>
        <tr class="odd">
          <td><ul>
              <li><?php echo $lang['type_add_prompts_one'];?></li>
              <li><?php echo $lang['type_add_prompts_two'];?></li>
              <li><?php echo $lang['type_add_prompts_three'];?></li>
              <li><?php echo $lang['type_add_prompts_four'];?></li>
            </ul></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" value="ok" name="form_submit">
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td class="required" colspan="2"><label class="validation" for="t_mane"><?php echo $lang['type_index_type_name']?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="t_mane" id="t_mane" /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label class="validation" for="t_sort"><?php echo $lang['nc_sort'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="t_sort" id="t_sort" /></td>
          <td class="vatop tips"><?php echo $lang['type_add_sort_desc'];?></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2">
      
      <thead class="thead">
        <tr class="space">
          <th class="required" colspan="15"><label><?php echo $lang['type_add_related_spec'];?></label></th>
        </tr>
      <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
        <tr>
          <th></th>
          <th><?php echo $lang['type_add_spec_name'];?></th>
          <th><?php echo $lang['type_add_spec_value'];?></th>
        </tr>
      <?php }?>
      <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
      </thead>
      <tbody>
        <?php foreach($output['spec_list'] as $val){?>
        <tr class="hover edit">
          <td class="w24"><input class="checkitem" nc_type="change_default_spec_value" type="checkbox" value="<?php echo $val['sp_id'];?>" name="spec_id[]"></td>
          <td class="w18pre"><?php echo $val['sp_name'];?></td>
          <td><?php echo $val['sp_value'];?></td>
        </tr>
        <?php }?>
      </tbody>
      <?php }else{?>
      <tbody>
        <tr>
          <td class="tips" colspan="15"><?php echo $lang['type_add_spec_null_one'];?><a href="JavaScript:void(0);" onclick="window.parent.openItem('spec,spec,goods')"><?php echo $lang['nc_spec_manage'];?></a><?php echo $lang['type_add_spec_null_two']?></td>
        </tr>
      </tbody>
      <?php }?>
      
    </table>
    <table class="table tb-type2">
      <thead class="thead">
        <tr class="space">
          <th colspan="2"><label for="member_name"><?php echo $lang['type_add_related_brand'];?></label></th>
        </tr>
      </thead>
      <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])) {?>
      <tbody>
      <?php foreach ($output['brand_list'] as $k=>$val){?>
        <tr class="hover">
          <td>
            <h6 class="clear"><?php echo $k;?></h6>
            <ul class="nofloat">
              <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])) {?>
              <?php foreach ($val as $bval){?>
              <li class="left w25pre h36">
                <input type="checkbox" name="brand_id[]" value="<?php echo $bval['brand_id']?>" id="brand_<?php echo $bval['brand_id'];?>" />
                <label for="brand_<?php echo $bval['brand_id'];?>"><?php echo $bval['brand_name']?></label>
              </li>
              <?php }?>
              <?php }?>
            </ul>
            </td>
        </tr>
      <?php }?>
      </tbody>
      <?php }else{?>
      <tbody>
        <tr>
          <td class="tips" colspan="15"><?php echo $lang['type_add_brand_null_one'];?><a href="JavaScript:void(0);" onclick="window.parent.openItem('brand,brand,goods')"><?php echo $lang['nc_brand_manage'];?></a><?php echo $lang['type_add_brand_null_two']?></td>
        </tr>
      </tbody>
      <?php }?>
    </table>
    <table class="table tb-type2 mtw">
      <thead class="thead">
        <tr class="space">
          <th colspan="15"><?php echo $lang['type_add_attr_add'];?></th>
        </tr>
        <tr>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['type_add_attr_name'];?></th>
          <th><?php echo $lang['type_add_attr_value'];?></th>
          <th class="align-center"><?php echo $lang['nc_display'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="tr_model">
      	<tr></tr>
        <tr class="hover edit">
          <td class="w48 sort"><input type="text" name="at_value[key][sort]" value="0" /></td>
          <td class="w25pre name"><input type="text" name="at_value[key][name]" value="" /></td>
          <td class="w50pre name"><input type="text" name="at_value[key][value]" value="" /></td>
          <td class="align-center power-onoff"><input type="checkbox" checked="checked" nc_type="checked_show" />
            <input type="hidden" name="at_value[key][show]" value="1" /></td>
          <td class="align-center w60"><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo $lang['type_add_remove'];?></a></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td colspan="15"><a id="add_type" class="btn-add marginleft" href="JavaScript:void(0);"> <span><?php echo $lang['type_add_attr_add_one'];?></span> </a></td>
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
<script>
$(function(){
	var i = 0;
	var tr_model = '<tr class="hover edit">'+
		'<td class="w48 sort"><input type="text" name="at_value[key][sort]" value="0" /></td>'+
		'<td class="w25pre name"><input type="text" name="at_value[key][name]" value="" /></td>'+
		'<td class="w50pre name"><input type="text" name="at_value[key][value]" value="" /></td>'+
		'<td class="align-center power-onoff"><input type="checkbox" checked="checked" nc_type="checked_show" /><input type="hidden" name="at_value[key][show]" value="1" /></td>'+
		'<td class="align-center w60"><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo $lang['type_add_remove'];?></a></td>'+
	'</tr>';
	$("#add_type").click(function(){
		$('#tr_model > tr:last').after(tr_model.replace(/key/g, i));
		$.getScript("../resource/js/admincp.js");
		i++;
	});

	$('input[nc_type="checked_show"]').live('click', function(){
		var o = $(this).next();
		//alert(o.val());
		if(o.val() == '1'){
			o.val('0');
		}else if(o.val() == '0'){
			o.val('1');
		}
	});


	//表单验证
    $('#type_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
        	t_mane: {
        		required : true,
                maxlength: 10,
                minlength: 1
            },
            t_sort: {
				required : true,
				digits	 : true
            }
        },
        messages : {
        	t_mane : {
        		required : '<?php echo $lang['type_add_name_no_null'];?>',
        		maxlength: '<?php echo $lang['type_add_name_max'];?>',
        		minlength: '<?php echo $lang['type_add_name_max'];?>' 
            },
            t_sort: {
            	required : '<?php echo $lang['type_add_sort_no_null'];?>',
            	digits : '<?php echo $lang['type_add_sort_no_digits'];?>' 
            }
        }
    });

    //按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
    	spec_check();
        if($("#type_form").valid()){
        	$("#type_form").submit();
    	}
    });
    
});

function spec_check(){
	var id='';
	$('input[nc_type="change_default_spec_value"]:checked').each(function(){
		if(!isNaN($(this).val())){
			id += $(this).val();
		}
	});
	if(id != ''){
		$('#spec_checkbox').val('ok');
	}else{
		$('#spec_checkbox').val('');
	}
}


function remove_tr(o){
	o.parents('tr:first').remove();
}
</script>