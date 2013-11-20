<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form id="add_form" action="index.php?act=store_promotion_mansong&op=mansong_quota_add_save" method="post">
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['mansong_quota_add_quantity'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="mansong_quota_quantity" name="mansong_quota_quantity" type="text" class="text w50 mr5" />
            <?php echo $lang['text_month'];?><span class="ml5"></span> </p>
          <p class="hint"><?php echo $lang['mansong_price_explain1'];?></p>
          <p class="hint"><?php echo $lang['mansong_price_explain2'].$GLOBALS['setting_config']['promotion_mansong_price'].$lang['text_gold'];?></p>
          <p class="hint"><?php echo $lang['mansong_price_explain3'];?></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>" class="submit">
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
            var unit_price = <?php echo $GLOBALS['setting_config']['promotion_mansong_price'];?>;
            var quantity = $("#mansong_quota_quantity").val();
            var price = unit_price * quantity;
             showDialog('<?php echo $lang['mansong_quota_add_confirm'];?>'+price+'<?php echo $lang['text_gold'];?>', 'confirm', '', function(){ajaxpost('add_form', '', '', 'onerror');});
    	},
            rules : {
                mansong_quota_quantity : {
                    required : true,
                    digits : true,
                    min : 1,
                    max : 12
                }
            },
                messages : {
                    mansong_quota_quantity : {
                        required : '<?php echo $lang['mansong_quota_quantity_error'];?>', 
                        digits : '<?php echo $lang['mansong_quota_quantity_error'];?>', 
                        min : '<?php echo $lang['mansong_quota_quantity_error'];?>', 
                        max : '<?php echo $lang['mansong_quota_quantity_error'];?>' 
                    }
                }
    });
});
</script> 
