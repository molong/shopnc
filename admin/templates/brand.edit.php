<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['brand_index_brand'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=brand&op=brand"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=brand&op=brand_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=brand&op=brand_apply"><span><?php echo $lang['brand_index_to_audit'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="brand_form" enctype="multipart/form-data" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="old_brand_pic" value="<?php echo $output['brand_array']['brand_pic']?>" />
    <input type="hidden" name="brand_id" value="<?php echo $output['brand_array']['brand_id']?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['brand_index_name'];?>:</label>
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['brand_array']['brand_name']?>" name="brand_name" id="brand_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['brand_index_class'];?>:
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['brand_array']['brand_class']?>" name="brand_class" id="brand_class" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['brand_index_pic_sign'];?>:
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php if(!empty($output['brand_array']['brand_pic'])){ ?>
            <span class="type-file-show"><img class="show_image" src="<?php echo TEMPLATES_PATH;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo SiteUrl.'/'.ATTACH_BRAND.'/'.$output['brand_array']['brand_pic']; ?>"></div>
            </span>
            <?php } ?>
            <span class="type-file-box">
            <input name="brand_pic" id="brand_pic" type="file" class="type-file-file" size="30">
            </span></td>
          <td class="vatop tips"><?php echo $lang['brand_add_support_type'];?>gif,jpg,jpeg,png</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['brand_add_if_recommend'];?>:
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="brand_recommend1" class="cb-enable <?php if($output['brand_array']['brand_recommend'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="brand_recommend0" class="cb-disable <?php if($output['brand_array']['brand_recommend'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="brand_recommend1" name="brand_recommend" <?php if($output['brand_array']['brand_recommend'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="brand_recommend0" name="brand_recommend" <?php if($output['brand_array']['brand_recommend'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_sort'];?>:
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['brand_array']['brand_sort']?>" name="brand_sort" id="brand_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['brand_add_update_sort'];?></td>
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
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#brand_form").valid()){
     $("#brand_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$("#brand_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            brand_name : {
                required : true,
                remote   : {
               	url :'index.php?act=brand&op=ajax&branch=check_brand_name',
                type:'get',
                data:{
						brand_name : function(){
							return $('#brand_name').val();
							},
						id  : '<?php echo $output['brand_array']['brand_id']?>'
                    }
                }
            },
            brand_sort : {
                number   : true
            }
        },
        messages : {
            brand_name : {
                required : '<?php echo $lang['brand_add_name_null'];?>',
                remote   : '<?php echo $lang['brand_add_name_exists'];?>'
            },
            brand_sort  : {
                number   : '<?php echo $lang['brand_add_sort_int'];?>'
            }
        }
	});
});


$(function(){
    var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
		$(textButton).insertBefore("#brand_pic");
		$("#brand_pic").change(function(){
		$("#textfield1").val($("#brand_pic").val());
	});
});
</script> 
