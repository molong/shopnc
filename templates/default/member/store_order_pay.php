<div class="eject_con">
  <div id="warning"></div>
  <form method="post" onsubmit="ajaxpost('store_order_pay','','','onerror')" id="store_order_pay" action="index.php?act=store&op=change_state&state_type=store_order_pay&order_id=<?php echo $output['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <h2><?php echo $lang['store_order_ensure_receive_fee'];?>?</h2>
    <dl>
      <dt><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?></dt>
      <dd><span class="num"><?php echo trim($_GET['order_sn']); ?></span></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_order_handle_desc'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea id="remark_input" name="state_info" cols="40"></textarea>
      </dd>
    </dl>
    <dl class="bottom">
    <dt>&nbsp;</dt>
    <dd>
      <input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" /></dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
$(function(){
    $('#cancel_button').click(function(){
        DialogManager.close('seller_order_received_pay');
    });
});
</script> 
