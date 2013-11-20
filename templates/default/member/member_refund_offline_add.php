<div class="eject_con">
  <div id="warning"></div>
  <form id="post_form" method="post" action="index.php?act=member_refund&op=offline_add&order_id=<?php echo $output['order']['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['refund_order_amount'].$lang['nc_colon'];?></dt>
      <dd><?php echo ncPriceFormat($output['order']['order_amount']); ?></dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['refund_order_refund'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text w50" name="order_refund" value="<?php echo $output['refund']['order_refund']>0?$output['refund']['order_refund']:$output['order']['order_amount']; ?>"  />
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['refund_buyer_message'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="buyer_message" rows="3" class="textarea w250"><?php echo $output['refund']['buyer_message']; ?></textarea>
      </dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd>
        <p class="hint"><?php echo $lang['refund_offline_buyer_desc'];?></p>
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
        DialogManager.close('member_order_refund');
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
            buyer_message : {
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
            buyer_message  : {
                required   : '<?php echo $lang['refund_buyer_message_null'];?>'
            }
        }
    });
});
</script> 
