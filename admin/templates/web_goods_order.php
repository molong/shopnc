<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>

<ul class="dialog-goodslist-s2">
  <?php foreach($output['goods_list'] as $k => $v){ ?>
  <li>
    <div onclick="select_goods_order(<?php echo $v['goods_id'];?>);" class="goods-pic"><span class="ac-ico"></span><span class="thumb size-72x72"><i></i><img goods_id="<?php echo $v['goods_id'];?>" store_id="<?php echo $v['store_id'];?>" goods_price="<?php echo $v['goods_store_price'];?>" title="<?php echo $v['goods_name'];?>" src="<?php echo thumb($v,'small');?>" onload="javascript:DrawImage(this,72,72);" /></span></div>
    <div class="goods-name"><a href="<?php echo SiteUrl."/index.php?act=goods&goods_id=".$v['goods_id'];?>" target="_blank"><?php echo $v['goods_name'];?></a></div>
  </li>
  <?php } ?>
</ul>
<div class="clear"></div>
<div id="show_goods_order" class="pagination"> <?php echo $output['show_page'];?> </div>
<?php }else { ?>
<p class="no-record"><?php echo $lang['nc_no_record'];?></p>
<?php } ?>
<div class="clear"></div>
<script type="text/javascript">
	$('#show_goods_order .demo').ajaxContent({
		target:'#show_goods_order_list'
	});
</script>