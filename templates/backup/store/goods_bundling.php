<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['bundling_array']) && is_array($output['bundling_array'])){$i=0;?>

<div class="nc-bundling-container">
  <div class="F-center">
  <?php foreach($output['bundling_array'] as $val){?>
  <?php if(!empty($output['b_goods_array'][$val['id']]) && is_array($output['b_goods_array'][$val['id']])){$i++;?>
  <div class="nc-bundling-list">
  <ul>
    <h3><?php echo $lang['bundling'].$i.$lang['nc_colon'].$val['name'];?></h3>
    <?php ksort($output['b_goods_array'][$val['id']]);foreach($output['b_goods_array'][$val['id']] as $v){?>
    <li>
      <dl>
        <dt class="goods-name" title="<?php echo $v['name'];?>"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['id']), 'goods', $output['store_info']['store_domain']);?>" target="block"><?php echo $v['name'];?></a></dt>
        <dd class="goods-pic"><span class="thumb size100"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['id']), 'goods', $output['store_info']['store_domain']);?>" target="block"><img src="<?php echo cthumb($v['image'], 'small', $v['store_id'])?>" title="<?php echo $v['name'];?>" alt="<?php echo $v['name'];?>" onload="javascript:DrawImage(this,100,100);" /></a></span></dd>
        <dd class="goods-price"><?php echo $lang['goods_index_goods_cost_price'].$lang['nc_colon'].$lang['currency'].$v['price'];?></dd>
      </dl>
    </li>
    <?php }?>
  </ul></div>
  <div class="nc-bundling-price">
    <p class="tcj"><?php echo $lang['bundling_price'];?><span><?php echo $lang['currency'].$val['price'];?></span></p>
    <p class="js"><?php echo $lang['bundling_save'];?><span><?php echo $lang['currency'].ncPriceFormat(floatval($val['cost_price'])-floatval($val['price']));?></span></p>
    <p class="mt5"><a href="index.php?act=bundling&bundling_id=<?php echo $val['id']?>&id=<?php echo $v['store_id'];?>" target="block" class="btn"><?php echo $lang['bundling_buy'];?></a></p>
  </div>
  <?php }?>
  <?php }?>
  </div>
<?php if(count($output['bundling_array']) != 1){?>
<div class="F-prev">&nbsp;</div>
<div class="F-next">&nbsp;</div>
<?php }?>
</div>
<script>
$(function(){
	$('.nc-promotion').show();
	$('#nc-bundling').show();
	$('.nc-bundling-container').F_slider({len:<?php echo $i;?>});
});
</script>
<?php }?>
