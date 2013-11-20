<div class="eject_con">
  <div id="warning"></div>
  <form id="changeform" method="post" action="index.php?act=store&op=change_state&state_type=store_order_edit_price&order_id=<?php echo $output['order_info']['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="state_info1" value="<?php echo $lang['store_order_modify_price'];?>" />
    <dl>
      <dt><?php echo $lang['store_order_buyer_with'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['order_info']['buyer_name']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_order_sn'].$lang['nc_colon'];?></dt>
      <dd><span class="num"><?php echo $output['order_info']['order_sn']; ?></span></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_order_sum'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" id="order_amount" name="order_amount" value="<?php echo $output['order_info']['order_amount']; ?>"/>
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
    $('#changeform').validate({
    	errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors){ $('#warning').show();}else{ $('#warning').hide(); }
        },
     	submitHandler:function(form){
    		ajaxpost('changeform', '', '', 'onerror'); 
    	},    
	    rules : {
        	order_amount : {
	            required : true,
	            number : true
	        }
	    },
	    messages : {
	    	order_amount : {
	    		required : '<?php echo $lang['store_order_modify_price_gpriceerror'];?>',
            	number : '<?php echo $lang['store_order_modify_price_gpriceerror'];?>'
	        }
	    }
	});
});
</script>