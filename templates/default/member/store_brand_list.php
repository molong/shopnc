<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" nc_type="dialog" dialog_title="<?php echo $lang['store_goods_brand_apply'];?>" dialog_id="my_goods_brand_apply" dialog_width="480" uri="index.php?act=store_goods&op=brand_add"><?php echo $lang['store_goods_brand_apply'];?></a></div>
  <table class="search-form">
    <form method="get">
      <input type="hidden" name="act" value="store_goods">
      <input type="hidden" name="op" value="brand_list">
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['store_goods_brand_name'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" class="text" name="brand_name" value="<?php echo $_GET['brand_name']; ?>"/></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </form>
  </table>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w150"><?php echo $lang['store_goods_brand_icon'];?></th>
        <th><?php echo $lang['store_goods_brand_name'];?></th>
        <th><?php echo $lang['store_goods_brand_belong_class'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($output['brand_list'])) { ?>
      <?php foreach($output['brand_list'] as $val) { ?>
      <tr class="bd-line">
        <td><img src="<?php if(!empty($val['brand_pic'])){ echo ATTACH_BRAND.'/'.$val['brand_pic'];}else{echo TEMPLATES_PATH.'/images/default_brand_image.gif';}?>" onload="javascript:DrawImage(this,88,44);" /></td>
        <td><?php echo $val['brand_name']; ?></td>
        <td><?php echo $val['brand_class']; ?></td>
        <td><?php if ($val['brand_apply'] == 0) { ?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['store_goods_brand_edit'];?>" dialog_id="my_goods_brand_edit" dialog_width="480" uri="index.php?act=store_goods&op=brand_add&brand_id=<?php echo $val['brand_id']; ?>"><?php echo $lang['store_goods_brand_edit'];?></a></p><p><a href="javascript:void(0)" class="ncu-btn2 mt5" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store_goods&op=drop_brand&brand_id=<?php echo $val['brand_id']; ?>');"><?php echo $lang['nc_del_&nbsp'];?></a></p>
          <?php } ?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (!empty($output['brand_list'])) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 