<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
  <div class="tabmenu">
  	<?php include template('member/member_submenu');?>
  	<?php if($output['newapply_flag'] === false){?>
    <a href="index.php?act=store_voucher&op=quotaadd" class="ncu-btn3" title="<?php echo $lang['voucher_applyadd'];?>"><?php echo $lang['voucher_applyadd'];?></a>
    <?php }?>
  </div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w180"><?php echo $lang['voucher_quota_startdate'];?></th>
        <th class="w180"><?php echo $lang['voucher_quota_enddate'];?></th>
        <th class="w100"><?php echo $lang['voucher_quota_timeslimit'];?></th>
        <th><?php echo $lang['voucher_quota_publishedtimes'];?></th>
        <th class="w100"><?php echo $lang['voucher_quota_residuetimes'];?></th>
        <th class="w70"><?php echo $lang['nc_state'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
        <td class="goods-time"><?php echo @date("Y-m-d h:i:s",$val['quota_starttime']);?></td>
        <td class="goods-time"><?php echo @date("Y-m-d h:i:s",$val['quota_endtime']);?></td>
        <td><?php echo $val['quota_timeslimit'];?></td>
        <td><?php echo $val['quota_publishedtimes'];?></td>
        <td><?php echo intval($val['quota_timeslimit'])-intval($val['quota_publishedtimes']);?></td>
        <td><?php foreach($output['quotastate_arr'] as $k=>$v){ if($v[0] == $val['quota_state']){echo $v[1];} }?></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>