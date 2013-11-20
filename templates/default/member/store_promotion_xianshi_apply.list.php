<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <!-- <div><?php echo $lang['xianshi_apply'];?></div>-->
  
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th><?php echo $lang['xianshi_apply_date'];?></th>
        <th><?php echo $lang['xianshi_apply_quantity'];?></th>
        <th class="w90"><?php echo $lang['nc_state'];?></th>
      </tr>
    </thead>
    <?php if(!empty($output['list']) && is_array($output['list'])){?>
    <tbody>
      <?php foreach($output['list'] as $key=>$val){?>
      <tr class="bd-line">
        <td><?php echo date("Y-m-d H:i:s",$val['apply_date']);?></td>
        <td><?php echo $val['apply_quantity'];?></td>
        <td><?php 
                switch(intval($val['state'])) {
                    case 1:
                        echo $lang['state_new'];
                        break;
                    case 2:
                        echo $lang['state_verify'];
                        break;
                    case 3:
                        echo $lang['state_cancel'];
                        break;
                    case 4:
                        echo $lang['state_verify_fail'];
                        break;
                }
              ?></td>
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
