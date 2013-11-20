<div class="eject_con">
  <div id="warning"></div>
  <form id="post_form" method="post" action="index.php?act=store_gbuy&op=add">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['store_gbuy_ratio'].$lang['nc_colon'];?></dt>
      <dd><?php echo $lang['store_gbuy_rmbratio'];?> <?php echo $output['gold_rmbratio']; ?> <?php echo $lang['store_gbuy_num'];?></dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_gbuy_price'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" name="gbuy_price" class="text w50 mr5"/><?php echo $lang['currency_zh'];?><span class="field_notice"></span>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
      </dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
$(function(){
    $('#post_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('post_form', '', '', 'onerror') 
    	},
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
            gbuy_price : {
                required   : true,
                number   : true,
                min:1
            }
        },
        messages : {
            gbuy_price  : {
                required  : '<?php echo $lang['store_gbuy_price_null'];?>',
                number   : '<?php echo $lang['store_gbuy_price_number'];?>',
                min   : '<?php echo $lang['store_gbuy_price_number'];?>'
            }
        }
    });
});
</script> 
