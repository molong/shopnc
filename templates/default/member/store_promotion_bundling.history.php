<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <?php if(empty($output['quota_list'])) { ?>
  <!-- 没有可用套餐，购买 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td colspan="20" class="norecord" style="padding: 50px 200px !important;"><i></i><span style=" width: 350px;"><?php echo $lang['bundling_quota_current_error'];?></span></td>
      </tr>
    </tbody>
  </table>
  <?php } else { ?>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="tl"><?php echo $lang['bundling_start_time'];?></th>
        <th class="w180"><?php echo $lang['bundling_end_time'];?></th>
        <th class="w180"><?php echo $lang['bundling_history_quantity'];?></th>
        <th class="w90"><?php echo $lang['bundling_history_consumption_gold'];?></th>
        <th><?php echo $lang['nc_state'];?></th>
      </tr>
    </thead>
    <?php foreach($output['quota_list'] as $key=>$val){?>
    <tbody>
      <tr class="bd-line">
        <td></td>
        <td class="tl"><?php echo date('Y-m-d H:i:s', $val['bl_quota_starttime']);?></td>
        <td class=""><?php echo date('Y-m-d H:i:s', $val['bl_quota_endtime']);?></td>
        <td class=""><?php echo $val['bl_quota_month'];?></td>
        <td><?php echo $val['bl_pay_gold'];?></td>
        <td>
        <?php 
        switch ($val['bl_quota_state']){
        	case 0:
        		echo $lang['bundling_status_0'];
        		break;
        	case 1:
        		echo $lang['bundling_status_1'];
        		break;
        }
        ?>
        </td>
      </tr>
    </tbody>
    <?php }?>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
  </table>
  <?php } ?>
</div>
