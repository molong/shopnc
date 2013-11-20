<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_class_index_class'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=goods_class&op=goods_class"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=goods_class&op=goods_class_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['goods_class_edit_prompts_one'];?></li>
            <li><?php echo $lang['goods_class_edit_prompts_two'];?></li>
            <li><?php echo $lang['goods_class_edit_prompts_three'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="goods_class_form" name="goodsClassForm" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="gc_id" value="<?php echo $output['class_array']['gc_id'];?>" />
    <input type="hidden" name="gc_parent_id" id="gc_parent_id" value="<?php echo $output['class_array']['gc_parent_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="gc_name validation"><?php echo $lang['goods_class_index_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['gc_name'];?>" name="gc_name" id="gc_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="gc_name"><?php echo $lang['goods_class_add_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
          <input type="hidden" name="t_name" id="t_name" value="<?php echo $output['class_array']['type_name'];?>" />
          <input type="hidden" name="t_sign" id="t_sign" value="" />
          <select name="t_id" id="t_id">
          	<option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
          	<?php if(is_array($output['type_list']) && !empty($output['type_list'])){?>
          	<?php foreach($output['type_list'] as $val){?>
          	<option value="<?php echo $val['type_id'];?>" <?php if($output['class_array']['type_id'] == $val['type_id']){?>selected="selected"<?php }?>><?php echo $val['type_name'];?></option>
          	<?php }?>
          	<?php }?>
          </select>
          <div class=" mtm"><input type="checkbox" name="t_associated" value="1" checked="checked" id="t_associated" /><label for="t_associated"><?php echo $lang['goods_class_edit_related_to_subclass'];?></label></div>
          </td>
          <td class="vatop tips"><?php echo $lang['goods_class_add_type_desc_one'];?><a onclick="window.parent.openItem('type,type,goods')" href="JavaScript:void(0);"><?php echo $lang['nc_type_manage'];?></a><?php echo $lang['goods_class_add_type_desc_two'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_display'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="gc_show1" class="cb-enable <?php if($output['class_array']['gc_show'] == '1'){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="gc_show0" class="cb-disable <?php if($output['class_array']['gc_show'] == '0'){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="gc_show1" name="gc_show" <?php if($output['class_array']['gc_show'] == '1'){ ?>checked="checked"<?php }?> value="1" type="radio">
            <input id="gc_show0" name="gc_show" <?php if($output['class_array']['gc_show'] == '0'){ ?>checked="checked"<?php }?> value="0" type="radio">
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="gc_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['gc_sort'] == ''?0:$output['class_array']['gc_sort'];?>" name="gc_sort" id="gc_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['goods_class_add_update_sort'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot"><td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(document).ready(function(){
	//按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
	    if($("#goods_class_form").valid()){
	     $("#goods_class_form").submit();
		}
	});

	$('#t_id').change(function(){
		// 标记类型时候修改 修改为ok
		var t_id = <?php echo $output['class_array']['type_id'];?>;
		if(t_id != $(this).val()){
			$('#t_sign').val('ok');
		}else{
			$('#t_sign').val('');
		}
			
		if($(this).val() == '0'){
			$('#t_name').val('');
		}else{
			$('#t_name').val($(this).find('option:selected').text());
		}
	});
	
	$('#goods_class_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            gc_name : {
                required : true,
                remote   : {                
                url :'index.php?act=goods_class&op=ajax&branch=check_class_name',
                type:'get',
                data:{
                    gc_name : function(){
                        return $('#gc_name').val();
                    },
                    gc_parent_id : function() {
                        return $('#gc_parent_id').val();
                    },
                    gc_id : '<?php echo $output['class_array']['gc_id'];?>'
                  }
                }
            },
            gc_sort : {
                number   : true
            }
        },
        messages : {
             gc_name : {
                required : '<?php echo $lang['goods_class_add_name_null'];?>',
                remote   : '<?php echo $lang['goods_class_add_name_exists'];?>'
            },
            gc_sort  : {
                number   : '<?php echo $lang['goods_class_add_sort_int'];?>'
            }
        }
    });

    
});
</script>