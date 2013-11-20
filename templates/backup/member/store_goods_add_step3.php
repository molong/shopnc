<div class="wp">
  <ul class="flow-chart">
    <li class="step a2" title="<?php echo $lang['store_goods_index_flow_chart_step1'];?>"></li>
    <li class="step b2" title="<?php echo $lang['store_goods_index_flow_chart_step2'];?>"></li>
    <li class="step c1" title="<?php echo $lang['store_goods_index_flow_chart_step3'];?>"></li>
  </ul>
  <div class="goods-release-success">
    <h2><?php echo $lang['store_goods_step3_goods_release_success'];?></h2>
    <p><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$output['goods_id']), 'goods')?>"><?php echo $lang['store_goods_step3_viewed_product'];?>&gt;&gt;</a><a href="index.php?act=store_goods&op=edit_goods&goods_id=<?php echo $output['goods_id']; ?>"><?php echo $lang['store_goods_step3_edit_product'];?>&gt;&gt;</a></p>
    <dl>
      <dt><?php echo $lang['store_goods_step3_more_actions'];?></dt>
      <dd>1. <?php echo $lang['store_goods_step3_continue'];?> &quot; <a href="index.php?act=store_goods&op=add_goods&step=one"><?php echo $lang['store_goods_step3_release_new_goods'];?></a>&quot;</dd>
      <dd>2. <?php echo $lang['store_goods_step3_access'];?> &quot; <?php echo $lang['nc_user_center'];?>&quot; <?php echo $lang['store_goods_step3_manage'];?> &quot;<a href="index.php?act=store_goods&op=goods_list"><?php echo $lang['nc_member_path_goods_list'];?></a>&quot;</dd>
      <dd>3. <?php echo $lang['store_goods_step3_access'];?> &quot; <a href="index.php?act=store_ztc&op=ztc_list"><?php echo $lang['nc_member_path_store_ztc'];?></a> &quot; <?php echo $lang['store_goods_step3_choose_product_add'];?></dd>
      <dd>4. <?php echo $lang['store_goods_step3_choose_add'];?> &quot; <a href="index.php?act=store_groupbuy&op=groupbuy_add"><?php echo $lang['store_goods_step3_groupbuy_activity'];?></a> &quot;</dd>
      <dd>5. <?php echo $lang['store_goods_step3_participation'];?> &quot; <a href="index.php?act=store&op=store_activity"><?php echo $lang['store_goods_step3_special_activities'];?></a> &quot;</dd>
    </dl>
  </div>
</div>
