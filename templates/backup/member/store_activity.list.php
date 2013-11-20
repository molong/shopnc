<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style">
      <?php if(!empty($output['list']) && is_array($output['list'])){?>
      <thead>
        <tr><th class="w20">&nbsp;</th>
          <th class="tl w200"><?php echo $lang['store_activity_theme'];?></th>
          <th class="tl"><?php echo $lang['store_activity_intro'];?></th>
          <th class="w150"><?php echo $lang['store_activity_start_time'];?></th>
          <th class="w150"><?php echo $lang['store_activity_end_time'];?></th>
          <th class="w90"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <?php foreach($output['list'] as $k => $v){?>
      <tbody>
        <tr><td></td>
          <td class="tl"><a target="_blank" href="index.php?act=activity&activity_id=<?php echo $v['activity_id'];?>"><?php echo $v['activity_title']; ?></a></td>
          <td class="tl"><?php echo $v['activity_desc'];?></td>
          <td class="goods-time"><?php echo @date('Y-m-d',$v['activity_start_date']);?></td>
          <td class="goods-time"><?php echo @date('Y-m-d',$v['activity_end_date']);?></td>
          <td><a id="a_<?php echo $v['activity_id'];?>" href="index.php?act=store&op=activity_apply&activity_id=<?php echo $v['activity_id'];?>" class="ncu-btn2"><?php echo $lang['store_activity_join'];?></a></td>
        </tr>
      </tbody>
      <?php } } else { ?>
      <tbody>
        <tr>
          <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
        </tr>
      <tbody>
        <?php } ?>
        <?php if(!empty($output['list']) && is_array($output['list'])){?>
      <tfoot>
        <tr>
          <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
        </tr>
      </tfoot>
      <?php }?>
    </table>
  </div>
