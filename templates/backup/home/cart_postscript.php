<script type="text/javascript">
function postscript_activation(tt){
    if (!tt.name)
    {
        tt.value    = '';
        tt.name = 'order_message';
    }

}
</script>

<div class="cart-title">
  <h3><?php echo $lang['cart_step1_message_to_seller'].$lang['nc_colon'];?></h3>
</div>
<textarea class="textarea w400 mt10" id="postscript" maxlength="200" onclick="postscript_activation(this);"><?php echo $lang['cart_step1_message_advice'];?></textarea>
