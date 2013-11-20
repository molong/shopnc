<link href="<?php echo TEMPLATES_PATH;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<style type="text/css">#navBar { display: none !important;}</style>
<ul class="flow-chart">
  <li class="step a2" title="<?php echo $lang['cart_index_ensure_order'];?>"></li>
  <li class="step b1" title="<?php echo $lang['cart_index_ensure_info'];?>"></li>
  <li class="step c2" title="<?php echo $lang['cart_index_buy_finish'];?>"></li>
</ul>
<?php if($output['buynow'] == '1'){?>
<form method="post" id="order_form" name="order_form" action="index.php?act=buynow&op=step2">
<input type="hidden" name="buynow_spec_id" value="<?php echo intval($_GET['buynow_spec_id']);?>">
<input type="hidden" name="buynow_quantity" value="<?php echo intval($_GET['buynow_quantity']);?>">
<?php }elseif($output['bundling'] == '1'){?>
<form method="post" id="order_form" name="order_form" action="index.php?act=buynow&op=bundling_step2">
<input type="hidden" name="bundling_id" value="<?php echo $output['bundling_id'];?>" />
<input type="hidden" name="spec" value='<?php echo $output['spec'];?>' />
<input type="hidden" name="quantity" value="<?php echo $output['quantity'];?>" />
<?php }else{?>
<form method="post" id="order_form" name="order_form" action="index.php?act=cart&op=step2">
  <?php }?>
  <input type="hidden" name="store_id" value="<?php echo intval($_GET['store_id']); ?>" />
  <div class="content">
    <?php include template('home/cart_shipping');?>
    <?php if($output['xianshi_flag'] == false && $output['mansong_flag'] == false && $output['bundling_flag'] == false) { ?>
    <?php include template('home/cart_voucher');?>
    <?php } elseif($output['promotion_explain']) { ?>
    <dl class="cart-discount">
      <dt><?php echo $lang['cart_step1_youhui'];?><i></i></dt>
      <dd><?php echo $output['promotion_explain'];?></dd>
    </dl>
    <?php } ?>
    <?php include template('home/cart_amount');?>
    <div class="clear"></div>
  </div>
</form>
