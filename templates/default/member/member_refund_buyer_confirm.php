<div class="eject_con">
  <div id="warning"></div>
  <form id="post_form" method="post" action="index.php?act=member_refund&op=buyer_confirm&&log_id=<?php echo $output['refund']['log_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="buyer_confirm" value="2" />
  <dl>
    <dt><?php echo $lang['member_order_store_name'].$lang['nc_colon'];?></dt>
    <dd><?php echo $output['refund']['store_name']; ?></dd>
  </dl>
  <dl>
    <dt><?php echo $lang['refund_order_refundsn'].$lang['nc_colon'];?></dt>
    <dd class="goods-num"><?php echo $output['refund']['refund_sn'];?></dd>
  </dl>
  <dl>
    <dt><?php echo $lang['refund_buyer_add_time'].$lang['nc_colon'];?></dt>
    <dd class="goods-time"><?php echo date("Y-m-d H:i:s",$output['refund']['add_time']);?></dd>
  </dl>
  <dl>
    <dt><?php echo $lang['refund_order_refund'].$lang['nc_colon'];?></dt>
    <dd class="goods-price"><?php echo $output['refund']['order_refund']; ?></dd>
  </dl>
  <?php if ($output['refund']['refund_type'] == 1) { ?>
  <dl>
    <dt><?php echo $lang['refund_buyer_message'].$lang['nc_colon'];?></dt>
    <dd> <?php echo $output['refund']['buyer_message']; ?> </dd>
  </dl>
  <?php } ?>
  <dl>
    <dt><?php echo $lang['refund_state'].$lang['nc_colon'];?></dt>
    <dd> <?php echo $output['state_array'][$output['refund']['refund_state']]; ?> </dd>
  </dl>
  <dl>
    <dt><?php echo $lang['refund_seller_message'].$lang['nc_colon'];?></dt>
    <dd> <?php echo $output['refund']['refund_message']; ?> </dd>
  </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd>
        <p class="hint"><?php echo $lang['refund_offline_buyer_confirm_desc'];?></p>
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
        DialogManager.close('member_buyer_confirm');
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
            form_submit : {
                required   : true
            }
	        },
	        messages : {
            form_submit  : {
                required   : '<?php echo $lang['nc_ok'];?>'
            }
	        }
    });
});
</script> 
