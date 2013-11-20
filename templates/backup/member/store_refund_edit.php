<div class="eject_con">
  <div id="warning"></div>
  <form id="post_form" method="post" action="index.php?act=refund&op=edit&log_id=<?php echo $output['refund']['log_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><?php echo $lang['refund_order_amount'].$lang['nc_colon'];?></dt>
      <dd><?php echo ncPriceFormat($output['refund']['order_amount']); ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['refund_order_refund'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['refund']['order_refund']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['refund_buyer_message'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['refund']['buyer_message']; ?></dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['refund_seller_confirm'].$lang['nc_colon'];?></dt>
      <dd>
        <label>
          <input type="radio" name="refund_state" value="2" />
          <?php echo $lang['nc_yes'];?> </label>
        <label>
          <input type="radio" name="refund_state" value="3" />
          <?php echo $lang['nc_no'];?> </label>
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['refund_message'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="refund_message" rows="3" class="textarea w300"></textarea>
      </dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd>
        <p class="hint"><?php echo $lang['refund_seller_desc'];?></p>
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
            refund_state : {
                required   : true
            },
            refund_message : {
                required   : true
            }
        },
        messages : {
            refund_state  : {
                required  : '<?php echo $lang['refund_seller_confirm_null'];?>'
            },
            refund_message  : {
                required   : '<?php echo $lang['refund_message_null'];?>'
            }
        }
    });
});
</script> 
