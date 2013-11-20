<script type="text/javascript">
    function check()
    {
        var pay_message = $('#pay_message');
        if( pay_message.length <= 0 || $.trim(pay_message.val()) == '') {
            alert('<?php echo $lang['payment_index_input_pay_info'];?>');
            return false;
        } else {
            return true;
        }
    }
</script>
<style type="text/css">
.payment_desc {
	margin: 10px 10px 20px 10px;
	padding: 5px;
}
.payment_desc h3 {
	margin: 5px;
	border-bottom: #ddd 1px dotted;
	padding-bottom: 5px;
}
.table_form {
	margin: 0px 10px;
}
.table_form td {
	padding: 5px;
	border: none;
}
.table_form .desc {
	color: #888;
	font-style: italic;
}
</style>
<div class="content">
  <div class="buy payment_desc">
    <h3><?php echo $output['payment_info']['payment_name'];?></h3>
    <form id="pay_message_form" action="index.php?act=payment&op=<?php echo $output['payment_info']['payment_code'];?>_pay&order_id=<?php echo $output['order_info']['order_id'];?>" method="POST">
      <table class="table_form" width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td><strong><?php echo $output['payment_info']['payment_info']==''?$output['payment_info']['payment_name']:$output['payment_info']['payment_info'];?></strong></td>
        </tr>
        <tr>
          <td style=" color:#F90;"><?php echo $lang['payment_index_input_pay_info'];?> (<?php echo $lang['payment_index_pay_method_tip'];?>) :</td>
        </tr>
        <tr>
          <td><textarea id="pay_message" name="pay_message" cols="60" rows="5" style=" font-size:12px; padding: 5px;" class="text"><?php echo $output['order_info']['pay_message'];?></textarea></td>
        </tr>
        <tr>
          <td class="cart-bottom"><p>
              <input onclick="return check()" type="submit" style="float:left;" class="btn" value="<?php echo $lang['payment_index_submit'];?>&nbsp;&raquo;" />
            </p></td>
        </tr>
      </table>
    </form>
  </div>
</div>
