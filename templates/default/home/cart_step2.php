<link href="<?php echo TEMPLATES_PATH;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<style type="text/css">
#navBar {
	display: none !important;
}
</style>
<script type="text/javascript" >
$(function() {
$(".tabs-nav > li > a").mouseover(function(e) {
	if (e.target == this) {
		var tabs = $(this).parent().parent().children("li");
		var panels = $(this).parent().parent().parent().parent().children(".tabs-panel");
		var index = $.inArray(this, $(this).parent().parent().parent().find("a"));
	if (panels.eq(index)[0]) {
		tabs.removeClass("tabs-selected")
			.eq(index).addClass("tabs-selected");
		panels.addClass("tabs-hide")
			.eq(index).removeClass("tabs-hide");
		}
	}
}); 
});
</script>
<ul class="flow-chart">
  <li class="step a2" title="<?php echo $lang['cart_index_ensure_order'];?>"></li>
  <li class="step b2" title="<?php echo $lang['cart_index_ensure_info'];?>"></li>
  <li class="step c1" title="<?php echo $lang['cart_index_buy_finish'];?>"></li>
</ul>
<div class="content">
  <form action="index.php?act=payment&order_id=<?php echo $output['order']['order_id']; ?>" method="POST" id="goto_pay" onsubmit="return false;">
    <div class="cart-order-info">
      <div class="title"><span class="all-goods-name"><?php echo @implode('+',$output['goods_name']);?></span><span class="goto-order"><a href="index.php?act=member&op=show_order&order_id=<?php echo $output['order']['order_id']; ?>" target="_blank"><?php echo $lang['cart_step2_order_info'];?></a></span> <span class="refresh"><?php echo $lang['cart_step2_order_refresh_tip'];?><a href="javascript:void(0);" id="refresh"><?php echo $lang['cart_step2_order_refresh'];?></a></span><span class="order-price" title="<?php echo $lang['cart_step2_prder_price'];?>" id="order_amount"><?php echo ncPriceFormat($output['order']['order_amount']); ?></span></div>
      <div class="intro">
        <dl>
          <dt><?php echo $lang['cart_step1_store'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order']['store_name']; ?></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['cart_step2_store_user'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['order']['seller_name']; ?> <a target="_blank" href="index.php?act=home&op=sendmsg&member_id=<?php echo $output['order']['seller_id']; ?>" class="message" title="<?php echo $lang['nc_message'];?>"></a></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['cart_step2_time'].$lang['nc_colon'];?></dt>
          <dd><?php echo date('Y-m-d:H:i:s',$output['order']['add_time']);?></dd>
        </dl>
        <?php if (!empty($output['order']['voucher_price'])) { ?>
        <dl>
          <dt><?php echo $lang['cart_step2_order_voucher_price'].$lang['nc_colon'];?> </dt>
          <dd><?php echo $lang['currency'];?><?php echo $output['order']['voucher_price'].'.00';?></dd> 
        </dl>
        <dl>
        	<dt><?php echo $lang['cart_step2_order_voucher_code'].$lang['nc_colon'];?> </dt>
        	<dd><?php echo $output['order']['voucher_code'];?>
          </dd>
        </dl>
        <?php } ?>
      </div>
    </div>
    <?php if (empty($output['online_array']) && empty($output['offine_array'])){?>
    <div class="cart-title">
      <div class="nopay"><?php echo $lang['cart_step2_paymentnull_1']; ?>
        <?php if (C('payment')){?>
        <a href="index.php?act=home&op=sendmsg&member_id=<?php echo $output['order']['seller_id'];?>"><?php echo $lang['cart_step2_paymentnull_2'];?></a>
        <?php }else{?>
        <?php echo $lang['cart_step2_paymentnull_4'];?>
        <?php }?>
        <?php echo $lang['cart_step2_paymentnull_3'];?></div>
    </div>
    <?php } else {?>
    <div class="cart-order-pay">
      <div class="title">
        <h3><?php echo $lang['cart_step2_choose_method_to_pay'];?></h3>
        <ul class="tabs-nav">
          <?php if(!empty($output['online_array'])){?>
          <li class="tabs-selected"><a href="javascript:void(0)"><?php echo $lang['cart_step2_online_pay'];?></a></li>
          <?php }?>
          <?php if(!empty($output['offine_array'])){?>
          <li <?php if(empty($output['online_array'])){?>class="tabs-selected"<?php }?>><a href="javascript:void(0)"><?php echo $lang['cart_step2_offline_pay'];?></a></li>
          <?php }?>
        </ul>
      </div>
      <?php if(!empty($output['online_array'])) { ?>
      <!-- online begin -->
      <div class="tabs-panel">
        <ul class="cart-defray">
          <?php foreach($output['online_array'] as $val) { ?>
          <li>
            <label class="radio">
              <input id="payment_<?php echo $val['payment_code']; ?>" type="radio" name="payment_id" value="<?php echo $val['payment_id']; ?>" extendattr="<?php echo $val['payment_code']; ?>"/>
            </label>
            <span class="logo"><img src="api/payment/<?php echo $val['payment_code']; ?>/logo.gif" alt="<?php echo $val['payment_name']; ?>-<?php echo $val['payment_info']; ?>" title="<?php echo $val['payment_name']; ?>-<?php echo $val['payment_info']; ?>" onload="javascript:DrawImage(this,125,50);" /></span>
            <dl class="explain">
              <dt></dt>
              <dd><?php echo $val['payment_info']; ?></dd>
            </dl>
          </li>
          <?php } ?>
        </ul>
      </div>
      <!-- online end -->
      <?php } ?>
      <?php if(!empty($output['offine_array'])){ ?>
      <!-- offine begin -->
      <div class="tabs-panel <?php if (empty($output['online_array']) && !empty($output['offine_array'])){}else{?>tabs-hide<?php }?>">
        <ul class="cart-defray">
          <?php foreach($output['offine_array'] as $val){ ?>
          <li>
            <label class="radio">
              <input type="radio" id="payment_<?php echo $val['payment_code']; ?>" name="payment_id" value="<?php echo $val['payment_id']; ?>" extendattr="<?php echo $val['payment_code']; ?>"/>
            </label>
            <span class="logo"><img alt="<?php echo $val['payment_name']; ?>-<?php echo $val['payment_info']; ?>" title="<?php echo $val['payment_name']; ?>-<?php echo $val['payment_info']; ?>" src="api/payment/<?php echo $val['payment_code']; ?>/logo.gif" onload="javascript:DrawImage(this,125,50);"  /> </span>
            <dl class="explain">
              <dt></dt>
              <dd><?php echo $val['payment_info']; ?></dd>
            </dl>
          </li>
          <?php } ?>
        </ul>
        <!--yinhanghuikuan input begin--->
        <div id="paymessagediv" style="display:none;" class="cart-paymessage"> <?php echo $lang['cart_step2_paymebankinfo'];?>
          <dl>
            <dt><?php echo $lang['pay_bank_user'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" name="offline[user]" maxlength="30" value="" class="text w90">
            </dd>
          </dl>
          <dl>
            <dt><?php echo $lang['pay_bank_bank'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" name="offline[bank]" maxlength="40" value="" class="text w200">
            </dd>
            <?php echo $lang['pay_bank_bank_tips'];?>
          </dl>
          <dl>
            <dt><?php echo $lang['pay_bank_account'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" name="offline[account]" maxlength="30" value="" class="text w200">
            </dd>
          </dl>
          <dl>
            <dt><?php echo $lang['pay_bank_num'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" name="offline[num]" maxlength="10" value="" class="text w60">
            </dd>
          </dl>
          <dl>
            <dt><?php echo $lang['pay_bank_order'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" name="offline[order]" maxlength="20" value="" class="text w200">
            </dd>
          </dl>
          <dl>
            <dt><?php echo $lang['pay_bank_date'].$lang['nc_colon'];?></dt>
            <dd>
              <input type="text" name="offline[date]" maxlength="12" value="" class="text w90">
            </dd>
          </dl>
          <dl>
            <dt><?php echo $lang['pay_bank_extend'].$lang['nc_colon'];?></dt>
            <dd>
              <textarea name="offline[extend]" rows="2" class="textarea w200"></textarea>
            </dd>
          </dl>
        </div>
        <!--yinhanghuikuan input end---> 
      </div>
      <!--offine end-->
      <?php } ?>
      <div class="ml50 mb30"><a href="javascript:check();" class="cart-button"><?php echo $lang['cart_step2_ensure_pay'];?></a></div>
      <?php }?>
      <div class="clear"></div>
    </div>
  </form>
</div>
<script type="text/javascript">
function check(){
	var flag = false;
	$.each($("input[name='payment_id']"),function(i,n){
		if($(n).attr('checked')){
			flag = true;
			return false;
		}
	});
	if(flag){
		var code = $('input:radio[name="payment_id"]:checked').attr('extendattr');
		if(code=="offline" && ($('input[name="offline[user]"]').val() == '' || $('input[name="offline[account]"]').val() == '' || $('input[name="offline[num]"]').val() == '')){
			alert("<?php echo $lang['cart_step2_paymessage_nullerror']; ?>");
		}else{
			$('#goto_pay').submit();
		}
	}else{
		alert('<?php echo $lang['cart_step2_choose_pay_method'];?>');
	}
}

function showmsgdiv(){
	var code = $('input:radio[name="payment_id"]:checked').attr('extendattr');
	if(code=="offline"){
		$("#paymessagediv").show();	
	}else{
		$("#paymessagediv").hide();
	}
}
$(function(){
	$('input:radio[name="payment_id"]').bind('change',showmsgdiv);
	$('#refresh').click(function(){
		$('#order_amount').load('index.php?act=cart&op=order_amout&order_id=<?php echo $output['order']['order_id']; ?>');
	});
});

</script>