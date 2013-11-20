<link href="<?php echo TEMPLATES_PATH;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<style type="text/css">
#navBar {
	display: none !important;
}
</style>
<ul class="flow-chart">
  <li class="step a2" title="<?php echo $lang['cart_index_ensure_order'];?>"></li>
  <li class="step b1" title="<?php echo $lang['cart_index_ensure_info'];?>"></li>
  <li class="step c2" title="<?php echo $lang['cart_index_buy_finish'];?>"></li>
</ul>
<form method="post" id="order_form" name="order_form" action="index.php?act=show_groupbuy&op=groupbuy_order">
  <input name="group_id" type="hidden" value="<?php echo $output['groupbuy_info']['group_id'];?>"/>
  <input name="spec_id" type="hidden" value="<?php echo $output['spec_id'];?>" />
  <input name="quantity" type="hidden" value="<?php echo $output['quantity'];?>"/>
  <div class="content">
    <?php include template('home/groupbuy_shipping');?>
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
      <h3><?php echo $lang['cart_step1_selected_goods'];?></h3>
    </div>
    <table class="buy-table">
      <thead>
        <tr>
          <th colspan="2"><?php echo $lang['cart_index_store_goods'];?>
            <hr/></th>
          <th class="w120"><?php echo $lang['cart_index_price'].'('.$lang['currency_zh'].')';?>
            <hr/></th>
          <th class="w120"><?php echo $lang['cart_index_amount'];?>
            <hr/></th>
          <th class="w120"><?php echo $lang['cart_index_sum'].'('.$lang['currency_zh'].')';?>
            <hr/></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="w70"><div class="cart-goods-pic"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$output['groupbuy_info']['group_id'],'id'=>$output['groupbuy_info']['store_id']), 'groupbuy');?>" target="_blank"><span class="thumb size60"><i></i><img src="<?php echo gthumb($output['groupbuy_info']['group_pic'],'small'); ?>" alt="<?php echo $output['groupbuy_info']['goods_name']; ?>" onload="javascript:DrawImage(this,60,60);"/></span></a></div></td>
          <td class="tl vt"><dl class="cart-goods-info">
              <dt class="cart-goods-info-name"><a target="_blank" href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$output['groupbuy_info']['group_id'],'id'=>$output['groupbuy_info']['store_id']), 'groupbuy');?>"><?php echo $output['groupbuy_info']['goods_name']; ?></a>
              <dt>
                <?php if(!empty($output['spec_text'])) { ?>
              <dd class="cart-goods-info-spec"><?php echo $output['spec_text'];?> </dd>
              <?php } ?>
              <dd><?php echo $lang['cart_step1_store'];?><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['groupbuy_info']['store_id']), 'store');?>" target="_blank"><?php echo $output['groupbuy_info']['store_name']; ?></a></dd>
            </dl></td>
          <td><span class="cart-goods-price"><?php echo sprintf( "%01.2f ",$output['groupbuy_info']['groupbuy_price']); ?></span></td>
          <td><?php echo $output['quantity']; ?><?php echo $lang['cart_index_jian'];?></td>
          <td><span class="cart-goods-price"><em><?php echo sprintf( "%01.2f ",$output['groupbuy_info']['groupbuy_price'] * $output['quantity']); ?></em></span></td>
        </tr>
      </tbody>
      <tfoot><tr><td colspan="2"><label><?php echo $lang['cart_step1_message_to_seller'].$lang['nc_colon'];?></label>
        <input type="text" class="w400 text" id="postscript" onclick="postscript_activation(this);" value="<?php echo $lang['cart_step1_message_advice'];?>" /></td><td class="tc"><?php echo $lang['cart_step1_transport_fee'];?></td><td colspan="2"></td></tr></tfoot>
    </table>
    <div class="cart-bottom">
  <div class="confirm-popup">
    <div class="confirm-box">
      <dl>
        <dt><?php echo $lang['cart_step2_prder_price'];?></dt>
        <dd class="cart-goods-price-b"><em id="order_amount"><?php echo sprintf( "%01.2f ",$output['groupbuy_info']['groupbuy_price'] * $output['quantity']); ?></em></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['cart_step2_prder_trans_to'];?></dt>
        <dd id="confirm_address"></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['cart_step2_prder_trans_receive'];?></dt>
        <dd id="confirm_buyer"></dd>
      </dl>
    </div>
  </div>
  <div class="cart-buttons">
    <a href="javascript:void($('#order_form').submit());" class="cart-button"><?php echo $lang['cart_step1_finish_order_to_pay'];?></a> </div>
</div>
    
</form>
