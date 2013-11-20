<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" uri="index.php?act=store&op=store_partner&type=add" nc_type="dialog" dialog_id="my_partner_add" dialog_width="480" dialog_title="<?php echo $lang['store_partner_add'];?>"><?php echo $lang['store_partner_add'];?></a></div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w30"></th>
        <th class="w50"><?php echo $lang['store_goods_class_sort'];?></th>
        <th class="w150"><?php echo $lang['store_partner_sign'];?></th>
        <th class="200 tl"><?php echo $lang['store_partner_title'];?></th>
        <th class="tl"><?php echo $lang['store_partner_href'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <?php if(!empty($output['partner_list'])){?>
      <tr>
        <td class="tc"><input id="all" type="checkbox" class="checkall" /></td>
        <td colspan="21"><label for="all"><?php echo $lang['nc_select_all'];?></label><a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=store&op=store_partner&drop=all" name="sp_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <?php }?>
    </thead>
    <?php if(!empty($output['partner_list'])){?>
    <tbody>
      <?php foreach($output['partner_list'] as $key=> $value){?>
      <tr class="bd-line">
        <td><input type="checkbox" class="checkitem" value="<?php echo $value['sp_id'];?>" /></td>
        <td><?php echo $value['sp_sort'];?></td>
        <td><?php if(!empty($value['sp_logo'])){?>
          <img src="<?php echo $value['sp_logo'];?>" onload="javascript:DrawImage(this,88,32);" onerror="this.src='<?php echo TEMPLATES_PATH."/images/member/default.gif"?>'" />
          <?php }?></td>
        <td class="tl"><?php echo $value['sp_title'];?></td>
        <td class="tl"><a href="<?php echo $value['sp_link'];?>" target="_blank"><?php echo $value['sp_link'];?></a></td>
        <td class="w90"><p><a href="javascript:void(0);" uri="index.php?act=store&op=store_partner&type=edit&sp_id=<?php echo $value['sp_id'];?>" dialog_id="store_partner_edit" dialog_title="<?php echo $lang['store_partner_edit'];?>" dialog_width="460" nc_type="dialog"><?php echo $lang['store_partner_edit'];?></a></p>
          <p><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store&op=store_partner&drop=single&sp_id=<?php echo $value['sp_id'];?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p></td>
      </tr>
      <?php }?>
    </tbody>
    <?php } else { ?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    </tbody>
    <?php }?>
    <?php if(!empty($output['partner_list'])){?>
    <tfoot>
      <tr>
        <td class="tc"><input id="all2" type="checkbox" class="checkall" /></td>
        <td colspan="21"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=store&op=store_partner&drop=all" name="sp_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a></th></td>
      </tr>
    </tfoot>
    <?php }?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>