<div class="eject_con">
  <div id="warning"></div>
  <form id="post_form" method="post" action="index.php?act=refund&op=add&order_id=<?php echo $output['order']['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['refund_order_amount'].$lang['nc_colon'];?></dt>
      <dd><?php echo ncPriceFormat($output['order']['order_amount']+$output['order']['refund_amount']); ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['refund_refund_amount'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['order']['refund_amount']; ?> (<?php echo $lang['refund_pay_refund'].$lang['nc_colon'];?><?php echo $output['order']['order_amount']; ?>)</dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['refund_order_refund'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="order_refund" value="<?php echo $output['order']['order_amount']; ?>"  />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['refund_payment'].$lang['nc_colon'];?></dt>
      <dd>
        <?php if ($output['order']['payment_code'] == 'predeposit'){?>
        <?php if($output['order']['order_state']<40) { ?>
        <label>
          <input type="radio" name="refund_paymentcode" value="predeposit" checked="checked" />
          <?php echo $lang['refund_payment_predeposit'];?> </label>
        <?php }else{?>
        <label>
          <input type="radio" name="refund_paymentcode" value="offline" checked="checked" />
          <?php echo $lang['refund_payment_offline'];?> </label>
        <?php if($output['order']['order_amount']<=$output['available_predeposit']) { ?>
        <label>
          <input type="radio" name="refund_paymentcode" value="predeposit" />
          <?php echo $lang['refund_payment_predeposit'];?> </label>
        <?php }?>
        <?php }?>
        <?php }else{?>
        <label>
          <input type="radio" name="refund_paymentcode" value="offline" checked="checked" />
          <?php echo $lang['refund_payment_offline'];?> </label>
        <?php }?>
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['refund_message'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="refund_message" rows="3" class="textarea w300"></textarea>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" />
      </dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
$(function(){
    $('#cancel_button').click(function(){
        DialogManager.close('seller_order_refund');
    });
    $('#post_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
		submitHandler:function(form){
			ajaxpost('post_form', '', '', 'onerror') 
		},
        rules : {
            order_refund : {
                required   : true,
                number   : true,
                min:0.01,
                max:<?php echo $output['order']['order_amount']; ?>
            },
            refund_message : {
                required   : true
            }
        },
        messages : {
            order_refund  : {
                required  : '<?php echo $lang['refund_pay_refund'];?> <?php echo $output['order']['order_amount']; ?>',
                number   : '<?php echo $lang['refund_pay_refund'];?> <?php echo $output['order']['order_amount']; ?>',
                min   : '<?php echo $lang['refund_pay_min'];?> 0.01',
	              max   : '<?php echo $lang['refund_pay_refund'];?> <?php echo $output['order']['order_amount']; ?>'
            },
            refund_message  : {
                required   : '<?php echo $lang['refund_message_null'];?>'
            }
        }
    });
});
</script> 
