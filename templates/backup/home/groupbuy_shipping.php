<link href="<?php echo TEMPLATES_PATH;?>/css/home_group.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>
<div id="warning" class="warning" style="display:none;"></div>
<div class="cart-title"><h3><?php echo $lang['cart_step1_receiver_address'];?></h3>
  <div class="btns"><a href="JavaScript:void(0);" id="span_newaddress" onclick="shownewaddress();" class="newadd"><span><?php echo $lang['cart_step1_new_address']; ?></span></a> <a href="index.php?act=member&op=address" target="_blank" class="editadd"><span><?php echo $lang['cart_step1_manage_receiver_address'];?></span></a></div>
  </span> </div>
<div id="addressone_model" style="display:none;">
  <ul class="receive_add address_item">
    <li class="goto"><?php echo $lang['cart_step1_receiver_jsz'];?></li>
    <li address="" buyer=""></li>
  </ul>
</div>
<div id="addresslist" class="mb30">
  <?php foreach((array)$output['address_list'] as $k=>$val){ ?>
  <ul class="receive_add address_item <?php if ($k == 0) echo 'selected_address'; ?>">
    <li class="goto">
      <?php if ($k == 0) echo $lang['cart_step1_receiver_jsz'];else echo '&nbsp;';?>
    </li>
    <li address="<?php echo $val['area_info']; ?>&nbsp;&nbsp;<?php echo $val['address']; ?>" buyer="<?php echo $val['true_name']; ?>&nbsp;&nbsp;<?php if($val['mob_phone']) echo $val['mob_phone']; else echo $val['tel_phone']; ?>">
      <input id="address_<?php echo $val['address_id']; ?>" type="radio" city_id="<?php echo $val['city_id']?>" name="address_options" value="<?php echo $val['address_id']; ?>" <?php if ($k == 0) echo 'checked'; ?>/>
      &nbsp;&nbsp;<?php echo $val['area_info']; ?>&nbsp;&nbsp;<?php echo $val['address']; ?>&nbsp;&nbsp; <?php echo $val['true_name']; ?><?php echo $lang['cart_step1_receiver_shou'];?>&nbsp;&nbsp;
      <?php if($val['mob_phone']) echo $val['mob_phone']; else echo $val['tel_phone']; ?>
    </li>
  </ul>
  <?php } ?>
  <input type="hidden" id="chooseaddressid" name="chooseaddressid" value='<?php echo $output['address_list'][0]['address_id'];?>'/>
</div>
<script type="text/javascript">
$(function(){
    $('.address_item').live('click',function(){
    	$(this).parent().find('.goto').html('&nbsp;');
    	$(this).children().first().html('<?php echo $lang['cart_step1_receiver_jsz'];?>');
        var checked_address_radio = $(this).find("input[name='address_options']");
        $(checked_address_radio).attr('checked', true);
        $('.address_item').removeClass('selected_address');
        $(this).addClass('selected_address');
        $("#chooseaddressid").val($(checked_address_radio).val());
        var _next = $(this).find('li').eq(1);
        $('#confirm_address').html($(_next).attr('address'));
        $('#confirm_buyer').html($(_next).attr('buyer'));
    });    

    <?php if (empty($output['address_list'])){?>
		shownewaddress();
	<?php }else{?>
		//显示寄送至
        var _select = $('.selected_address').find('li').eq(1);
        $('#confirm_address').html($(_select).attr('address'));
        $('#confirm_buyer').html($(_select).attr('buyer'));	
	<?php }?>
});
//计算总金额
function getallprice(){
	var goods_amount = parseFloat(<?php echo $output['store_goods_price']; ?>);
	$('#order_amount').html(price_format(goods_amount));
}
function shownewaddress(){
	var addr_id = $("input[name='address_options']:checked").val();
    ajax_form('newaddressform','<?php echo $lang['cart_step1_new_address'];?>', SITE_URL + '/index.php?act=cart&op=newaddress&addr_id='+addr_id,740);
    return false;
}
$('#order_form').validate({
	errorLabelContainer: $('#warning'),
    invalidHandler: function(form, validator) {
       var errors = validator.numberOfInvalids();
       if(errors)
       {
           $('#warning').show();
       }
       else
       {
           $('#warning').hide();
       }
    },
    rules : {
    	chooseaddressid : {
    		required : true
        }
    },
 	messages : {
    	chooseaddressid : {
            required : '<?php echo $lang['cart_step1_please_chooseaddress'];?>'
        }
    }
});
</script> 
