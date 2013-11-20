<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w30"></th>
        <th class="w60"><?php echo $lang['store_goods_class_sort'];?></th>
        <th class="w10"></th>
        <th class="tl"><?php echo $lang['store_navigation_name'];?></th>
        <th class="w120"><?php echo $lang['store_navigation_display'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <?php if(!empty($output['navigation_list'])){?>
      <tr>
        <td class="w30 tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="20"><label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store&op=store_navigation&drop=all" name="sn_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <?php }?>
    </thead>
    <tbody>
      <?php if(!empty($output['navigation_list'])){?>
      <?php foreach($output['navigation_list'] as $key=> $value){?>
      <tr class="bd-line">
        <td><input type="checkbox" class="checkitem" value="<?php echo $value['sn_id'];?>" /></td>
        
        <td><?php echo $value['sn_sort'];?></td><td></td>
        <td class="tl"><?php echo $value['sn_title'];?></td>
        <td><?php if($value['sn_if_show']){echo $lang['nc_yes'];}else{echo $lang['nc_no'];}?></td>
        <td><p><a href="<?php echo SiteUrl?>/index.php?act=store&op=store_navigation_add&type=edit&sn_id=<?php echo $value['sn_id']; ?>" ><?php echo $lang['store_navigation_edit'];?></a></p>
          <p><a href="javascript:;" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store&op=store_navigation&drop=single&sn_id=<?php echo $value['sn_id'];?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <?php if(!empty($output['navigation_list'])){?>
      <tr>
        <td class="tc"><input id="all2" type="checkbox" class="checkall" /></td>
        <td colspan="20"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store&op=store_navigation&drop=all" name="sn_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <?php }?>
    </tfoot>
  </table>
</div>
