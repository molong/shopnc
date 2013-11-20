<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo TEMPLATES_PATH;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<style type="text/css">
#navBar {
	display: none !important;
}
</style>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/pgoods_cart.js" charset="utf-8"></script>

<ul class="point-chart">
  <li class="step a1" title="<?php echo $lang['pointcart_ensure_order'];?>"></li>
  <li class="step b2" title="<?php echo $lang['pointcart_ensure_info'];?>"></li>
  <li class="step c2" title="<?php echo $lang['pointcart_exchange_finish'];?>"></li>
</ul>
<div class="content">
  <?php if (is_array($output['cart_array']) && count($output['cart_array'])>0){ ?>
  <div class="giftStep">
    <div class="cart-title">
      <h3><?php echo $lang['pointcart_cart_chooseprod_title']; ?></h3>
    </div>
    <table class="buy-table">
      <thead>
        <tr>
          <th colspan="2"><?php echo $lang['pointcart_goodsname']; ?>
            <hr/></th>
          <th class="w120"><?php echo $lang['pointcart_exchangepoint']; ?>
            <hr/></th>
          <th class="w120"><?php echo $lang['pointcart_exchangenum']; ?>
            <hr/></th>
          <th class="w120"><?php echo $lang['pointcart_pointoneall']; ?>
            <hr/></th>
          <th class="w120"><?php echo $lang['pointcart_cart_handle'] ?>
            <hr/></th>
        </tr>
      </thead>
      <?php foreach ($output['cart_array'] as $k=>$v){ ?>
      <tr id="pcart_item_<?php echo $v['pcart_id']; ?>">
        <td class="w70"><p class="ware_pic"><a href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$v['pgoods_id']; ?>" target="_blank"><span class="thumb size-60"><i></i><img src="<?php echo $v['pgoods_image']; ?>" onerror="this.src='<?php echo defaultGoodsImage('tiny');?>'" alt="<?php echo $v['pgoods_name']; ?>" onload="javascript:DrawImage(this,60,60);" /></span></a></p></td>
        <td class="tl vt"><dl class="cart-goods-info">
            <dt class="cart-goods-info-name"><a href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$v['pgoods_id']; ?>" target="_blank"><?php echo $v['pgoods_name']; ?></a></dt>
          </dl></td>
        <td><span class="price1"><?php echo $v['pgoods_points']; ?></span></td>
        <td><a href="JavaScript:void(0);" onclick="pcart_decrease_quantity(<?php echo $v['pcart_id']; ?>);" title="<?php echo $lang['pointcart_cart_reduse'];?>" class="subtract">&nbsp;</a>
          <input id="input_item_<?php echo $v['pcart_id']; ?>" value="<?php echo $v['pgoods_choosenum']; ?>" changed="<?php echo $v['pgoods_choosenum']; ?>" onkeyup="pcart_change_quantity('<?php echo $v['pcart_id']; ?>', this);" class="text1 w30" type="text" style="text-align:center;"/>
          <a  href="JavaScript:void(0);" onclick="pcart_add_quantity(<?php echo $v['pcart_id']; ?>);" title="<?php echo $lang['pointcart_cart_increase'];?>" class="adding">&nbsp;</a></td>
        <td><span id="item_<?php echo $v['pcart_id']; ?>_subtotal" class="cart-point mr5"><?php echo $v['pgoods_pointone']; ?></span><?php echo $lang['points_unit']; ?></td>
        <td><a class="del" href="javascript:void(0)" onclick="drop_pcart_item(<?php echo $v['pcart_id']; ?>);"><?php echo $lang['pointcart_cart_del']; ?></a></td>
      </tr>
      <?php } ?>
    </table>
    <div class="cart-bottom">
      <p><?php echo $lang['pointcart_cart_allpoints'].$lang['nc_colon']; ?><span class="cart-point-b mr5" id="pcart_amount"><?php echo $output['pgoods_pointall']; ?></span><?php echo $lang['points_unit']; ?></p>
      <p><a class="cart-back-button mr10" href="index.php?act=pointprod"><?php echo $lang['pointcart_cart_continue']; ?></a><a href="index.php?act=pointcart&op=step1" class="cart-button"><?php echo $lang['pointcart_cart_submit']; ?></a></p>
    </div>
  </div>
  <?php } else { ?>
  <div class="null-shopping"><i class="ico-gift"></i>
    <h4><?php echo $lang['pointcart_cart_null'];?></h4>
    <p><a href="index.php?act=pointprod" class="cart-button mr10"><?php echo $lang['pointcart_cart_exchangenow'];?></a> <a href="index.php?act=member_pointorder" class="cart-back-button"><?php echo $lang['pointcart_cart_exchanged_list'];?></a></p>
  </div>
  <?php } ?>
</div>
