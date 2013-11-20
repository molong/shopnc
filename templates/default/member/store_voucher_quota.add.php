<?php defined('InShopNC') or exit('Access Invalid!'); ?>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form id="add_form" action="index.php?act=store_voucher&op=quotaadd" method="post">
    	<input type="hidden" name="form_submit" value="ok"/>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['voucher_apply_addnum'].$lang['nc_colon'];?></dt>
        <dd>
          <p><input id="quota_quantity" name="quota_quantity" type="text" class="text w50 mr5" /><?php echo $lang['nc_month'];?><span class="ml5"></span> </p>
          <p class="hint"><?php echo $lang['voucher_apply_add_tip1'];?></p>
          <p class="hint"><?php echo sprintf($lang['voucher_apply_add_tip2'],C('promotion_voucher_price'));?></p>
          <p class="hint"><?php echo sprintf($lang['voucher_apply_add_tip3'],C('promotion_voucher_storetimes_limit'));?></p>          
          <p class="hint"><?php echo $lang['voucher_apply_add_tip4'];?></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>"  class="submit">
        </dd>
      </dl>
    </form>
  </div>
</div> 
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('p').children('span');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
    	submitHandler:function(form){
            var unit_price = parseInt(<?php echo C('promotion_voucher_price');?>);
            var quantity = parseInt($("#quota_quantity").val());
            var price = unit_price * quantity;
            showDialog('<?php echo $lang['voucher_apply_add_confirm1'];?>'+price+'<?php echo $lang['voucher_apply_add_confirm2'];?>', 'confirm', '', function(){
            	ajaxpost('add_form', '', '', 'onerror');
            });
    	},
        rules : {
            quota_quantity : {
                required : true,
                digits : true,
                min : 1,
                max : 12
            }
        },
        messages : {
            quota_quantity : {
            	required : '<?php echo $lang['voucher_apply_num_error'];?>', 
            	digits : '<?php echo $lang['voucher_apply_num_error'];?>', 
            	min : '<?php echo $lang['voucher_apply_num_error'];?>',
            	max : '<?php echo $lang['voucher_apply_num_error'];?>'
            }
       	}
    });
});
</script> 
