<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div><?php echo $lang['mansong_apply'];?></div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th><?php echo $lang['mansong_apply_date'];?></th>
        <th><?php echo $lang['mansong_apply_quantity'];?></th>
        <th><?php echo $lang['nc_state'];?></span></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){?>
      <?php foreach($output['list'] as $key=>$val){?>
      <tr class="bd-line">
        <td><?php echo date("Y-m-d H:i:s",$val['apply_date']);?></td>
        <td><?php echo $val['apply_quantity'];?></td>
        <td><?php echo $output['apply_state_list'][$val['state']];?></td>
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
        <th colspan="20"> <div class="pagination"> <?php echo $output['show_page']; ?> </div>
        </th>
      </tr>
      <?php }?>
    </tfoot>
  </table>
</div>
