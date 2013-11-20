<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" nc_type="dialog" dialog_title="<?php echo $lang['store_goods_class_new_class'];?>" dialog_id="my_category_add" dialog_width="480" uri="index.php?act=store&op=store_goods_class&type=ok" title="<?php echo $lang['store_goods_class_new_class'];?>"><?php echo $lang['store_goods_class_new_class'];?></a></div>
  <table class="ncu-table-style" id="my_category" server="index.php?act=store&op=goods_class_ajax" >
    <?php if (!empty($output['goods_class'])) { ?>
    <thead>
      <tr nc_type="table_header">
        <th class="w30"></th>
        <th coltype="editable" column="stc_name" checker="check_required" inputwidth="50%"><?php echo $lang['store_goods_class_name'];?></th>
        <th class="w60" coltype="editable" column="stc_sort" checker="check_max" inputwidth="30px"><?php echo $lang['store_goods_class_sort'];?></th>
        <th class="w120" coltype="switchable" column="stc_state" checker="" onclass="showclass-ico-btn" offclass="noshowclass-ico-btn"><?php echo $lang['nc_display'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <tr>
        <td class="tc"><input id="all" type="checkbox" class="checkall" /></td>
        <td colspan="20"><label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0)" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store&op=drop_goods_class" name="class_id" confirm="<?php echo $lang['store_goods_class_ensure_del'];?>?"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
    </thead>
    <tbody id="treet1">
      <?php foreach ($output['goods_class'] as $key => $val) { ?>
      <tr class="bd-line" nc_type="table_item" idvalue="<?php echo $val['stc_id']; ?>" >
        <td class="tc"><input type="checkbox" class="checkitem" value="<?php echo $val['stc_id']; ?>" /></td>
        <td class="tl"><span class="ml5" nc_type="editobj" ><?php echo $val['stc_name']; ?></span>
          <?php if ($val['stc_parent_id'] == 0) { ?>
          <span class="add_ico_a"><a href="javascript:void(0)" nc_type="dialog" dialog_width="480" dialog_title="<?php echo $lang['store_goods_class_add_sub'];?>" dialog_id="my_category_add" uri="index.php?act=store&op=store_goods_class&top_class_id=<?php echo $val['stc_id']; ?>&type=ok" ><?php echo $lang['store_goods_class_add_sub'];?></a></span>
          <?php } ?></td>
        <td><span nc_type="editobj"><?php echo $val['stc_sort']; ?></span></td>
        <td>
        <span nc_type="editobj" 
		<?php if ($val['stc_state'] == 1) { ?>
        class="showclass-ico-btn" status="on"
		<?php } else { ?>
        class="noshowclass-ico-btn" status="off"
		<?php } ?>>
        </span>
        </td>
        <td>
        <p><a href="javascript:void(0)" nc_type="dialog" dialog_width="480" dialog_title="<?php echo $lang['store_goods_class_edit_class'];?>" dialog_id="my_category_edit" uri="index.php?act=store&op=store_goods_class&class_id=<?php echo $val['stc_id']; ?>&type=ok"><?php echo $lang['store_goods_class_edit_class'];?></a></p>
        <p><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['store_goods_class_ensure_del'];?>?', 'index.php?act=store&op=drop_goods_class&class_id=<?php echo $val['stc_id']; ?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php } else { ?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    </tbody>
    <?php } ?>
    <?php if (!empty($output['goods_class'])) { ?>
    <tfoot>
      <tr>
        <td class="tc"><input id="all2" type="checkbox" class="checkall" /></td>
        <td colspan="15"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0)" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store&op=drop_goods_class" name="class_id" confirm="<?php echo $lang['store_goods_class_ensure_del'];?>?"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<style>
<!--
.collapsed{display:none;}
-->
</style>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jqtreetable.js"></script> 
<script type="text/javascript">
$(function()
{
    var map = [<?php echo $output['map']; ?>];
    var path = "<?php echo TEMPLATES_PATH;?>/images/";
    if (map.length > 0)
    {
        var option = {openImg: path + "treetable/tv-collapsable.gif", shutImg: path + "treetable/tv-expandable.gif", leafImg: path + "treetable/tv-item.gif", lastOpenImg: path + "treetable/tv-collapsable-last.gif", lastShutImg: path + "treetable/tv-expandable-last.gif", lastLeafImg: path + "treetable/tv-item-last.gif", vertLineImg: path + "treetable/vertline.gif", blankImg: path + "treetable/blank.gif", collapse: false, column: 1, striped: false, highlight: false, state:false};
        $("#treet1").jqTreeTable(map, option);
    }
    var t = new EditableTable($('#my_category'));
});
</script>