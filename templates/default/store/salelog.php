<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
		$('#salelog_demo').find('.demo').ajaxContent({
			event:'click', //mouseover
			loaderType:"img",
			loadingMsg:"<?php echo TEMPLATES_PATH;?>/images/transparent.gif",
			target:'#salelog_demo'
		});

});
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class=" mt10">
  <thead>
    <tr>
      <th class="w200"><?php echo $lang['goods_index_buyer'];?></th>
      <th class="w100"><?php echo $lang['goods_index_buy_price'];?></th>
      <th><?php echo $lang['goods_index_design_and_model'];?></th>
      <th class="w100"><?php echo $lang['goods_index_buy_amount'];?></th>
      <th class="w200"><?php echo $lang['goods_index_buy_time'];?></th>
    </tr>
  </thead>
  <?php if(!empty($output['sales']) && is_array($output['sales'])){?>
  
  <tbody><?php foreach($output['sales'] as $key=>$sale){?>
    <tr>
      <td><?php echo $sale['buyer_name'];?></td>
      <td>
          <em class="price"><?php echo $sale['goods_price'];?></em>
          <?php if(!empty($sale['xianshi_id'])) { ?>
          <i style="color:red;"><?php echo $lang['nc_xianshi_flag'];?></i>
          <?php } ?>
      </td>
      <td>
      <?php if($sale['spec_info'] == ''){ echo $lang['goods_index_default_spec'];}else{?>
      	<?php foreach (explode(';', $sale['spec_info']) as $spec){?>
        <span><?php echo $spec?></span>
        <?php }?>
      <?php }?>
      </td>
      <td><?php echo $sale['goods_num'];?></td>
      <td><time><?php echo date('Y-m-d H:i:s',$sale['add_time']);?></time></td>
    </tr><?php }?>
  </tbody>
  <tfoot>
  <tr>
  <td colspan="10">
  
	<div class="pagination"> <?php echo $output['show_page'];?> </div></td></tr></tfoot>
  <?php }else{?>
  <tbody>
    <tr>
      <td colspan="10" class="ncs-norecord"><?php echo $lang['no_record'];?></td>
    </tr>
  </tbody>
  <?php }?>
</table>
