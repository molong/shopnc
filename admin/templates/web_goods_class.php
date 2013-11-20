<?php defined('InShopNC') or exit('Access Invalid!');?>

<dl>
  <dt select_class_id="<?php echo $output['gc_parent']['gc_id'];?>" title="<?php echo $output['gc_parent']['gc_name'];?>" ondblclick="del_gc_parent(<?php echo $output['gc_parent']['gc_id'];?>);"><i onclick="del_gc_parent(<?php echo $output['gc_parent']['gc_id'];?>);"></i><?php echo $output['gc_parent']['gc_name'];?></dt>
  <div class="clear"></div>
  <input name="category_list[<?php echo $output['gc_parent']['gc_id'];?>][gc_parent][gc_id]" value="<?php echo $output['gc_parent']['gc_id'];?>" type="hidden">
  <input name="category_list[<?php echo $output['gc_parent']['gc_id'];?>][gc_parent][gc_name]" value="<?php echo $output['gc_parent']['gc_name'];?>" type="hidden">
  <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
  <?php foreach($output['goods_class'] as $k => $v){ ?>
  <dd gc_id="<?php echo $v['gc_id'];?>" title="<?php echo $v['gc_name'];?>" ondblclick="del_goods_class(<?php echo $v['gc_id'];?>);"> 
  	<i onclick="del_goods_class(<?php echo $v['gc_id'];?>);"></i><?php echo $v['gc_name'];?>
    <input name="category_list[<?php echo $output['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_id]" value="<?php echo $v['gc_id'];?>" type="hidden">
    <input name="category_list[<?php echo $output['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_name]" value="<?php echo $v['gc_name'];?>" type="hidden">
  </dd>
  <?php } ?>
  <?php } ?>
</dl>
