<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=store_promotion_mansong&op=mansong_quota_add');" title="<?php echo $lang['mansong_quota_add'];?>"><?php echo $lang['mansong_quota_add'];?></a></div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th><?php echo $lang['mansong_quota_start_time'];?></th>
        <th><?php echo $lang['mansong_quota_end_time'];?></th>
        <th class="w90"><?php echo $lang['nc_state'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){?>
      <?php foreach($output['list'] as $key=>$val){?>
      <tr class="bd-line">
        <td class="goods-time"><?php echo date("Y-m-d H:i:s",$val['start_time']);?></td>
        <td class="goods-time"><?php echo date("Y-m-d H:i:s",$val['end_time']);?></td>
        <td><?php echo $output['mansong_quota_state_list'][$val['state']];?></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <?php if(!empty($output['list']) && is_array($output['list'])){?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php }?>
    </tfoot>
  </table>
</div>
</div>
