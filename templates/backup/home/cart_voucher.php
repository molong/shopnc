<?php if (C('voucher_allow') == 1) { ?>

<dl class="cart-discount">
  <dt><?php echo $lang['cart_step1_select_voucher'];?><i></i></dt>
  <dd>
    <?php if(empty($output['voucher_list'])) {?>
    <div><?php echo $lang['cart_step1_none_voucher'];?><?php echo $lang['cart_step1_voucher_price'];?><span class="money" nc_type="shipping_fee" value="0">0.00</span> </div>
    <?php } else { ?>
    <div>
      <input type="radio" value="0" name="voucher_id" rel="voucher" checked>
      <?php echo $lang['cart_step1_notuse_voucher'];?> </div>
    <?php  foreach($output['voucher_list'] as $voucher) { ?>
    <div title="<?php echo $lang['cart_step1_voucher_usecondition'].$voucher['voucher_limit'].$lang['currency_zh'].$lang['cart_step1_voucher'].$lang['nc_colon'].$voucher['voucher_code'];?>">
      <input type="radio" value="<?php echo $voucher['voucher_id'];?>" name="voucher_id" rel="voucher">
      <?php echo $lang['cart_step1_voucher_save'];?><span class="cart-goods-price" nc_type="shipping_fee" value="<?php echo $voucher['voucher_price'];?>"><em><?php echo ncPriceFormat($voucher['voucher_price']);?></em></span>&nbsp;(<?php echo $voucher['voucher_desc'];?>)</div>
    <?php } } ?>
  </dd>
</dl>
<?php } ?>
