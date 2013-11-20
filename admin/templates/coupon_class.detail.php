<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_coupon_class_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=coupon_class"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <?php if($output['type']=='add'){?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
        <?php }
		else 
		if($output['type']=='edit'){?>
        <li><a href="index.php?act=coupon_class&op=update"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a> </li>
        <?php }?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="coupon_class" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="class_id" value="<?php echo $output['class']['class_id']; ?>" />
    <input type="hidden" name="old_name" value="<?php echo $output['class']['class_name']; ?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="class_name"><?php echo $lang['coupon_class_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class']['class_name']; ?>" name="class_name" id="class_name" class="txt"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['coupon_class_name_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="class_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class']['class_sort']?$output['class']['class_sort']:0; ?>" name="class_sort" id="class_sort" class="txt"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['coupon_class_sort_notice'];?></span></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_display'];?>:</label></td>
        </tr>
        <?php if($output['type']=='add'){?>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="class_show1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="class_show0" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label>
            <input type="radio" checked="checked" value="1" name="class_show" id="class_show1">
            <input type="radio" value="0" name="class_show" id="class_show0"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['coupon_class_show_notice'];?></span></td>
        </tr>
        <?php }
		else 
		if($output['type']=='edit'){?>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="class_show1" class="cb-enable <?php if($output['class']['class_show']=='1'){?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="class_show0" class="cb-disable <?php if($output['class']['class_show']=='0'){?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input type="radio" <?php if($output['class']['class_show']=='1'){?>checked="checked"<?php }?> value="1" name="class_show" id="class_show1">
            <input type="radio" <?php if($output['class']['class_show']=='0'){?>checked="checked"<?php }?> value="0" name="class_show" id="class_show0"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['coupon_class_show_notice'];?></span></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr class="tfoot"><td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#coupon_class").valid()){
     $("#coupon_class").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#coupon_class').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
           class_name : {
                required : true,
	                remote   : {                
	                url :'index.php?act=coupon_class&op=ajax&branch=coupon_class_name',
	                type:'get',
	                data:{
	                    class_name : function(){
	                        return $('#class_name').val();
	                    },
	                    old_name : function(){
							return $('input[name=old_name]').val() ;
		                }
	                  }
	                }
                
            },
            class_sort : {
                required : true,
                digits   : true,
                min : 0,
                max : 255
            }
        },
        messages : {
            class_name : {
                required : '<?php echo $lang['coupon_class_name_null'];?>',
                remote   : '<?php echo $lang['coupon_class_name_error'];?>'
            },
            class_sort  : {
                required   : '<?php echo $lang['coupon_class_sort_null'];?>',
                digits   : '<?php echo $lang['coupon_class_sort_null'];?>',
                min: '<?php echo $lang['coupon_class_sort_min'];?>',
                max: '<?php echo $lang['coupon_class_sort_max'];?>'
            }
        }
    });
});
</script>
