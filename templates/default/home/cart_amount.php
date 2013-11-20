<div class="cart-bottom">
  <div class="confirm-popup">
    <div class="confirm-box">
      <dl>
        <dt><?php echo $lang['cart_step2_prder_price'];?></dt>
        <dd class="cart-goods-price-b"><em id="order_amount"></em></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['cart_step2_prder_trans_to'];?></dt>
        <dd id="confirm_address"></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['cart_step2_prder_trans_receive'];?></dt>
        <dd id="confirm_buyer"></dd>
      </dl>
    </div>
  </div>
  <div class="cart-buttons">
    <?php if($output['type'] != 'groupbuy'){?>
    <a href="index.php?act=cart" class="cart-back-button mr10"><?php echo $lang['cart_step1_back_to_cart'];?></a>
    <?php }?>
    <a href="javascript:void(0)" id='submitToPay' class="cart-button mr10"><?php echo $lang['cart_step1_finish_order_to_pay'];?></a> </div>
</div>
<script>
$(function(){
	$('#submitToPay').click(function(){
		ifsubmit = true;
		if ($('input[name="address_options"]:checked').val() == null){
		    <?php if (empty($output['address_list'])){?>
				shownewaddress();
			<?php }else{ ?>
				alert('<?php echo $lang['cart_step1_please_set_address'];?>');
			<?php }?>
			return false;
		}
		$('select[nc_type="sel_transport"]').each(function(){
			if($(this).val() == '' || $(this).val() == null){
				alert('<?php echo $lang['cart_step1_transport_none'];?>');
				ifsubmit = false;
			}
		});
		if (ifsubmit == true){
			$('#order_form').submit();
		}
	});
});
</script>