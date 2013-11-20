<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/goods_cart.js" charset="utf-8"></script>
<link href="<?php echo TEMPLATES_PATH;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<ul class="flow-chart">
  <li class="step a1" title="<?php echo $lang['cart_index_ensure_order'];?>"></li>
  <li class="step b2" title="<?php echo $lang['cart_index_ensure_info'];?>"></li>
  <li class="step c2" title="<?php echo $lang['cart_index_buy_finish'];?>"></li>
</ul>
<div class="content">
        <?php 
		if(is_array($output['cart_array']) and !empty($output['cart_array'])) {?>
        <?php	foreach($output['cart_array'] as $val) {?>
        <div class="cart-title">
          <h3><?php echo $lang['cart_step1_order_info_conf'];?></h3>
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
              <th class="w120"><?php echo $lang['cart_index_sum'];?>
                <hr/></th>
              <th class="w120"><?php echo $lang['cart_index_handle'];?>
                <hr/></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="20"><?php echo $lang['cart_step1_store'].$lang['nc_colon'];?><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val[0]['store_id']),'store',$val[0]['store_domain']);?>"><?php echo $val[0]['store_name']; ?></a></th>
            </tr>
            <?php foreach($val as $v) { ?>
            <tr id="cart_item_<?php echo $v['spec_id'];?>">
              <td class="w70"><div class="cart-goods-pic"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods');?>" target="_blank"><span class="thumb size60"><i></i><img src="<?php echo thumb($v,'tiny');?>" alt="<?php echo $v['goods_name']; ?>" onload="javascript:DrawImage(this,60,60);" /></span></a></div></td>
              <td class="tl vt"><dl class="cart-goods-info">
                  <dt class="cart-goods-info-name"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods');?>" target="_blank"><?php echo $v['goods_name']; ?></a> </dt>
                  <dd class="cart-goods-info-spec"><?php echo $v['spec_info']; ?></dd>
                </dl></td>
              <td><span class="cart-goods-price-s"><em><?php echo $v['goods_store_price']; ?></em></span></td>
              <td><a href="JavaScript:void(0);" onclick="decrease_quantity(<?php echo $v['cart_id']; ?>);" title="<?php echo $lang['cart_index_reduse'];?>" class="subtract">&nbsp;</a>
                <input id="input_item_<?php echo $v['cart_id']; ?>" value="<?php echo $v['goods_num']; ?>" orig="<?php echo $v['goods_num']; ?>" changed="<?php echo $v['goods_num']; ?>" onkeyup="change_quantity(<?php echo $v['store_id']; ?>, <?php echo $v['cart_id']; ?>, <?php echo $v['spec_id']; ?>, this);" class="text1 w30 vm" type="text"  style=" *float: left;"/>
                <a href="JavaScript:void(0);" onclick="add_quantity(<?php echo $v['cart_id']; ?>);" title="<?php echo $lang['cart_index_increase'];?>" class="adding" >&nbsp;</a></td>
              <td><span class="cart-goods-price" ><em id="item<?php echo $v['cart_id']; ?>_subtotal"><?php echo $v['goods_all_price']; ?></em></span></td>
              <td><a href="javascript:collect_goods('<?php echo $v['goods_id']; ?>');"><?php echo $lang['cart_index_favorite'];?></a> <a href="javascript:void(0)" onclick="drop_cart_item(<?php echo $v['store_id']; ?>, <?php echo $v['spec_id']; ?>);"><?php echo $lang['cart_index_del'];?></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
          <?php $mansong = $output['mansong'][$val[0]['store_id']];?>
          <?php if($mansong['mansong_flag']) { ?>
        <dl class="cart-discount">
          <dt><?php echo $lang['cart_step1_youhui'];?><i></i></dt>
          <dd>          
              <?php foreach($mansong['mansong_rule'] as $rule) { ?>
            <?php echo $lang['nc_man'];?><em><?php echo ncPriceFormat($rule['price']);?></em><?php echo $lang['nc_yuan'];?>
                <?php if(!empty($rule['discount'])) { ?>
                <?php echo $lang['nc_comma'].$lang['nc_reduce'];?><?php echo ncPriceFormat($rule['discount']);?><?php echo $lang['nc_yuan'].$lang['nc_cash'];?>
                <?php } ?>
                <?php if(!empty($rule['shipping_free'])) { ?>
                <?php echo $lang['nc_comma'].$lang['nc_shipping_free'];?>
                <?php } ?>
                <?php if(!empty($rule['gift_name'])) { ?>
                <?php echo $lang['nc_comma'].$lang['nc_gift'];?><a href="<?php echo $rule['gift_link'];?>" target="_blank"><?php echo $rule['gift_name'];?></a>
                <?php } ?>
              <?php } ?>
          </dd>
        </dl>
          <?php }?>

        <div class="cart-bottom storemodule_<?php echo $val[0]['store_id'];?>">
          <p><?php echo $lang['cart_index_goods_sumary'];?><span class="cart-goods-price-b mr10" ><em id="cart<?php echo $v['store_id']; ?>_amount"><?php echo $val[0]['store_all_price']; ?></em></span></p>
          <p><a href="index.php" class="cart-back-button mr10"><?php echo $lang['cart_index_continue_shopping'];?></a><a href="index.php?act=cart&op=step1&store_id=<?php echo $v['store_id']; ?>" class="cart-button"><?php echo $lang['cart_index_input_ensure_order'];?></a></p>
        </div>
        <?php } } ?>
    <div class="full_module" >
      <div id="content" class="infocontent">
        <div id="top" class="infolist"></div>
        <span class="ad_middle"> 
        <script type="text/javascript" src="<?php echo SiteUrl;?>/index.php?act=adv&op=advshow&ap_id=16"></script> 
        </span><span class="ad_middle"> 
        <script type="text/javascript" src="<?php echo SiteUrl;?>/index.php?act=adv&op=advshow&ap_id=17"></script> 
        </span><span class="ad_middle"> 
        <script type="text/javascript" src="<?php echo SiteUrl;?>/index.php?act=adv&op=advshow&ap_id=18"></script> 
        </span><span class="ad_middle"> 
        <script type="text/javascript" src="<?php echo SiteUrl;?>/index.php?act=adv&op=advshow&ap_id=19"></script> 
        </span>
        <div id="bottom" class="infolist"></div>
      </div>
      <div class="clear"> </div>
      <p><a href="<?php echo SiteUrl;?>/index.php?act=store_adv&op=adv_buy"><?php echo $lang['cart_i_want_to_be_here']; ?></a></p>
    </div>
 
</div>
