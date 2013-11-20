<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w150"><?php echo $lang['store_payment_name'];?></th>
        <th class="tl"><?php echo $lang['store_payment_intro'];?></th>
        <th class="w90"><?php echo $lang['store_payment_enable'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['payment_list']) && is_array($output['payment_list'])){ ?>
      <?php foreach($output['payment_list'] as $k => $v){ if(@in_array($v['code'],$output['payment_inc'])){ ?>
      <tr class="bd-line">
        <td><?php echo $v['name']; ?></td>
        <td class="tl"><?php echo $v['content']; ?></td>
        <td><?php if ($v['payment_state'] == 1)  echo $lang['store_payment_yes']; else echo $lang['store_payment_no']; ?></td>
        <td><?php if ($v['install'] == 1) { ?>
          <a href="index.php?act=store&op=add_payment&payment_code=<?php echo $v['code']; ?>"><?php echo $lang['store_payment_config'];?></a> <a href="javascript:void(0);" onclick="ajax_get_confirm('<?php echo $lang['store_payment_ensure_uninstall'];?>?', 'index.php?act=store&op=uninstall_payment&payment_id=<?php echo $v['payment_id']; ?>');" class="ncu-btn2 mt5"><?php echo $lang['store_payment_uninstall'];?></a>
          <?php } else { ?>
          <a href="index.php?act=store&op=add_payment&payment_code=<?php echo $v['code']; ?>" class="ncu-btn2 mt5"><?php echo $lang['store_payment_install'];?></a>
          <?php } ?></td>
      </tr>
      <?php } } } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>