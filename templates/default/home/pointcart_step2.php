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
<ul class="point-chart">
  <li class="step a2" title="<?php echo $lang['pointcart_ensure_order'];?>"></li>
  <li class="step b2" title="<?php echo $lang['pointcart_ensure_info'];?>"></li>
  <li class="step c1" title="<?php echo $lang['pointcart_exchange_finish'];?>"></li>
</ul>
<div class="content">
  <form action="index.php?act=pointcart&op=payment&order_id=<?php echo $output['order_arr']['order_id']; ?>" method="POST" id="goto_pay" onsubmit="return false;">
    <div class="cart-order-info">
      <div class="title"><span class="all-goods-name"><?php echo @implode('+',$output['order_arr']['output_goods_name']);?></span><span class="goto-order"><a href="index.php?act=member_pointorder&op=order_info&order_id=<?php echo $output['order_arr']['order_id'];?>" target="_blank"> <?php echo $lang['pointcart_step2_view_order'];?></a></span> <?php if ($output['order_arr']['pgoods_freightcharge'] == 1){?>
        <span class="freight"><?php echo $lang['pointcart_shipfee'].$lang['nc_colon'];?><em><?php echo $output['order_arr']['pgoods_freightall']; ?></em></span>
        <?php } ?><span class="all-points"><?php echo $lang['pointcart_step2_order_allpoints'].$lang['nc_colon'];?><em><?php echo $output['order_arr']['pgoods_pointall']; ?></em></span>
        
         </div>
      <div class="intro">
        <?php if ($_GET['op'] == 'step2'){?>
        <h4><?php echo $lang['pointcart_step2_exchange_success'];?></h4>
        <h5><?php echo $lang['pointcart_step2_order_created'];?></h5>
        <?php }?>
      </div>
    </div>
    <?php if ($output['order_arr']['pgoods_freightcharge'] == 1){?>
    <?php if (empty($output['online_array']) && empty($output['offine_array'])){?>
    <div class="cart-title">
      <div class="nopay"><?php echo $lang['pointcart_step2_paymentnull']; ?></div>
    </div>
    <?php } else {?>
    <div class="cart-order-pay">
      <div class="title">
        <h3><?php echo $lang['pointcart_step2_choose_method_to_pay'];?></h3>
        <ul class="tabs-nav">
          <?php if(!empty($output['online_array'])){?>
          <li class="tabs-selected"><a href="javascript:void(0)"><?php echo $lang['pointcart_step2_pay_online'];?></a></li>
          <?php }?>
          <?php if(!empty($output['offine_array'])){?>
          <li><a href="javascript:void(0)"><?php echo $lang['pointcart_step2_pay_offline'];?></a></li>
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
      <?php }?>
      <div class="ml50 mb30"><a href="javascript:check();" class="cart-button"><?php echo $lang['pointcart_step2_ensure_pay'];?></a></div>
      <?php }?>
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
});
</script>