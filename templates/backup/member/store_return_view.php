<div class="eject_con">
  <div id="warning"></div>
  <dl>
    <dt><?php echo $lang['return_order_returnsn'].$lang['nc_colon'];?></dt>
    <dd class="goods-num"><?php echo $output['return']['return_sn']; ?></dd>
  </dl>
  <dl>
    <dt><?php echo $lang['return_order_add_time'].$lang['nc_colon'];?></dt>
    <dd class="goods-time"><?php echo date("Y-m-d H:i:s",$output['return']['add_time']);?> </dd>
  </dl>
  <dl>
    <dt><?php echo $lang['return_order_buyer'].$lang['nc_colon'];?></dt>
    <dd><?php echo $output['return']['buyer_name']; ?> </dd>
  </dl>
  <dl>
    <dt><?php echo $lang['return_order_return'].$lang['nc_colon'];?></dt>
    <dd><strong><?php echo $output['return']['return_goodsnum']; ?></strong></dd>
  </dl>
  <?php if ($output['return']['return_type'] == 1) { ?>
  <dl>
    <dt><?php echo $lang['return_buyer_message'].$lang['nc_colon'];?></dt>
    <dd> <?php echo $output['return']['buyer_message']; ?> </dd>
  </dl>
  <?php } ?>
  <dl>
    <dt><?php echo $lang['return_message'].$lang['nc_colon'];?></dt>
    <dd><?php echo $output['return']['return_message']; ?></dd>
  </dl>
  <table class="ncu-table-style order bc mt20 mb10" style="width:96%;">
    <thead>
    </thead>
    <tbody>
      <tr>
        <th colspan="3" class="tc"><?php echo $lang['return_goods_name'];?></th>
        <th class="w70 tc"><?php echo $lang['return_order_return'];?></th>
      </tr>
      <?php if(is_array($output['order_goods_list']) && !empty($output['order_goods_list'])) { foreach($output['order_goods_list'] as $val) { ?>
      <tr><td class="bdl w10"></td><td><div class="goods-pic-small"><span class="thumb size60"><i></i><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><img src="<?php echo thumb($val,'tiny'); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td><dl class="goods-name" style="width:auto;">
          <dt style="width:auto; white-space: normal;"><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><?php echo $val['goods_name']; ?></a></dt>
          <dd style="width:auto;"><?php echo $val['spec_info']; ?></dd></dl></td>
        <td class="bdl bdr"><?php echo $val['goods_returnnum']; ?></td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>
</div>
