<div class="eject_con">
  <div id="warning"></div>
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
  <?php if ($output['refund']['admin_time'] > 0) { ?>
  <dl>
    <dt><?php echo $lang['refund_admin_message'].$lang['nc_colon'];?></dt>
    <dd> <?php echo $output['refund']['admin_message']; ?> </dd>
  </dl>
  <?php } ?>
  <dl>
    <dt></dt>
    <dd></dd>
  </dl> 
</div>
