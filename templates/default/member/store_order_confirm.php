<div class="eject_con">
  <div id="warning"></div>
  <form method="post" id="order_confirm_form" onsubmit="ajaxpost('order_confirm_form', '', '', 'onerror');return false;" action="index.php?act=store&op=change_state&state_type=order_confirm&order_id=<?php echo $output['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <h2><?php echo $lang['store_order_shipping_order'];?></h2>
    <dl>
      <dt><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?></dt>
      <dd><?php echo trim($_GET['order_sn']); ?></dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" />
      </dd>
    </dl>
  </form>
</div>

