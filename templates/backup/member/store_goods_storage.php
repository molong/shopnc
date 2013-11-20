<?php defined('InShopNC') or exit('Access Invalid!');?>

<!-- ajax编辑商品名称样式 -->
<style type="text/css">
.ajax-edit:hover { background-color: #FFF9D4; color:#F30 !important;}
.goods-name textarea { font-family: Tahoma; height: 16px; line-height: 16px; height: 32px !important; background-color:#F9F9F9; padding: 1px 2px 3px 4px !important; padding: 3px 2px 1px 4px; border: solid 1px; border-color: #CCC #DDD #DDD #CCC; box-shadow: 2px 2px 1px 0 #E7E7E7 inset; -moz-box-shadow: 2px 2px 1px 0 #E7E7E7 inset/* if FF*/; -webkit--box-shadow: 2px 2px 1px 0 #E7E7E7 inset/* if Webkie*/;}
.goods-name textarea:hover { background-color:#FFF;}
.goods-name textarea:focus { background-color:#FFF; border-color: #CCC; box-shadow: 1px 1px 1px 0 #E7E7E7; -moz-box-shadow: 1px 1px 1px 0 #E7E7E7/* if FF*/; -webkit--box-shadow: 1px 1px 1px 0 #E7E7E7/* if Webkie*/;}
</style>
<div class="wrap">
<div class="tabmenu">
  <?php include template('member/member_submenu');?>
</div>
<table class="search-form">
  <form method="get" action="index.php">
    <input type="hidden" name="act" value="store_goods" />
    <input type="hidden" name="op" value="goods_storage" />
    <?php if($_GET['type'] == 'state'){?>
    <input type="hidden" name="type" value="state" />
    <?php }?>
    <tr>
      <td>&nbsp;</td>
      <th><?php echo $lang['store_goods_index_store_goods_class'].$lang['nc_colon'];?></th>
      <td class="w160"><select name="stc_id" class="w150">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php if(is_array($output['store_goods_class']) && !empty($output['store_goods_class'])){?>
          <?php foreach ($output['store_goods_class'] as $val) {?>
          <option value="<?php echo $val['stc_id']; ?>" <?php if ($_GET['stc_id'] == $val['stc_id']){ echo 'selected=selected';}?>><?php echo $val['stc_name']; ?></option>
          <?php if (is_array($val['child']) && count($val['child'])>0){?>
          <?php foreach ($val['child'] as $child_val){?>
          <option value="<?php echo $child_val['stc_id']; ?>" <?php if ($_GET['stc_id'] == $child_val['stc_id']){ echo 'selected=selected';}?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
          <?php }?>
          <?php }?>
          <?php }?>
          <?php }?>
        </select></td>
      <th><?php echo $lang['store_goods_index_goods_name'].$lang['nc_colon'];?></th>
      <td class="w160"><input type="text" class="text" name="keyword" value="<?php echo $_GET['keyword']; ?>"/></td>
      <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
    </tr>
  </form>
</table>
  <table id="my_goods" server="index.php?act=store_goods&op=edit_goods_ajax" class="ncu-table-style">
    <thead>
      <tr nc_type="table_header">
        <th class="w30"></th>
        <th class="w70"></th>
        <th coltype="editable" column="goods_name" checker="check_required" inputwidth="230px"><?php echo $lang['store_goods_index_goods_name'];?></th>
        <?php if($_GET['type'] == 'state'){?>
        <th class="w180" coltype="switchable" column="goods_show" onclass="right_ico" offclass="wrong_ico"><?php echo $lang['store_goods_index_close_reason'];?></th>
        <!-- 禁售原因 -->
        <?php }else{?>
        <th class="w180" coltype="switchable" column="goods_show" onclass="right_ico" offclass="wrong_ico"><?php echo $lang['store_goods_index_show'];?></th>
        <!-- 上架 -->
        <?php }?>
        <th  class="w100" coltype="editable" column="goods_store_price" checker="check_number" inputwidth="50px"><?php echo $lang['store_goods_index_price'];?></th>
        <th class="w100" coltype="editable" column="spec_goods_storage" checker="check_pint" inputwidth="50px"><?php echo $lang['store_goods_index_stock'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <?php  if (count($output['list_goods'])>0) { ?>
      <tr>
        <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="10"><label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_goods&op=drop_goods" name="goods_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a>
          <?php if($_GET['type'] != 'state'){?>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_goods&op=goods_show_batch" name="goods_id"><span><?php echo $lang['store_goods_index_show'];?></span></a>
          <?php }?>
      </tr>
    </thead>
    <?php } ?>
    <?php if (count($output['list_goods'])>0) { ?>
    <tbody>
      <?php foreach($output['list_goods'] as $val) { ?>
      <tr>
        <th class="tc"><input type="checkbox" class="checkitem tc" value="<?php echo $val['goods_id']; ?>"/></th>
        <th colspan="20"><?php echo $lang['store_goods_index_goods_no'].$lang['nc_colon'];?><?php echo $val['goods_serial'];?></th>
      </tr>
      <tr nc_type="table_item" idvalue="<?php echo $val['goods_id']; ?>">
        <td></td>
        <td class="w70"><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><img src="<?php echo thumb($val,'tiny');?>" onload="javascript:DrawImage(this,60,60);" /></a></span></span></td>
        <td><dl class="goods-name"><dt class="ajax-edit" nc_type="editobj" inputtype="textarea" style="color:#0579C6"><?php echo $val['goods_name']; ?></dt><dd><?php echo $val['gc_name']; ?></dd></dl></td>
        <?php if($_GET['type'] == 'state'){?>
        <td style=" color: #F60;"><?php echo $val['goods_close_reason'];?></td>
        <!-- 禁售原因 -->
        <?php }else{?>
        <td><a href="javascript:void(0)" onclick="ajax_get_confirm('','index.php?act=store_goods&op=goods_show&goods_id=<?php echo $val['goods_id'];?>')" class="ncu-btn2"><?php echo $lang['store_goods_index_show'];?></a></td>
        <?php }?>
        <td><span class="ajax-edit" <?php if($val['spec_open'] == '1'){?>nctype="prict_selector"<?php }else{?>nc_type="editobj"<?php }?> nc_gid="<?php echo $val['goods_id'];?>"><?php echo $val['goods_store_price']; ?></span></td>
        <td><span class="ajax-edit" <?php if($val['spec_open'] == '1'){?>nctype="stock_selector"<?php }else{?>nc_type="editobj"<?php }?> nc_id="<?php echo $val['goods_id'];?>"><?php echo $output['storage_array'][$val['goods_id']]; ?></span></td>
        <td><p><a href="index.php?act=store_goods&op=edit_goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><?php echo $lang['nc_member_path_edit_goods'];?></a></p><p><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store_goods&op=drop_goods&goods_id=<?php echo $val['goods_id']; ?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php } else { ?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    <tbody>
      <?php } ?>
      <?php  if (count($output['list_goods'])>0) { ?>
    <tfoot>
      <tr>
        <td class="tc"><input type="checkbox" id="all2" class="checkall"/></td>
        <td colspan="10"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=store_goods&op=drop_goods" name="goods_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a>
          <?php if($_GET['type'] != 'state'){?>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_goods&op=goods_show_batch" name="goods_id"><span><?php echo $lang['store_goods_index_show'];?></span></a>
          <?php }?>
          <div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript">
$(function(){
    var t = new EditableTable($('#my_goods'));
	// 存在多规格时的库存修改
	$('span[nctype="stock_selector"]').click(function(){
		id	= $(this).attr('nc_id');
		sum	= $(this).html();
		ajax_form('stock_selector_'+id, '<?php echo $lang['store_goods_stock_change_stock'];?>', SITE_URL + '/index.php?act=store_goods&op=goods_stock_list&goods_id='+id+ '&stock_sum=' +sum, '320');
	});

	// 存在多规格时的价格修改
	$('span[nctype="prict_selector"]').click(function(){
		id	= $(this).attr('nc_gid');
		ajax_form('price_selector_'+id, '<?php echo $lang['store_goods_price_change_price'];?>', SITE_URL + '/index.php?act=store_goods&op=goods_price_list&goods_id='+id, '320');
	});
});

function change_stock_count(id,count) {
	$('span[nc_id="'+id+'"]').html(count);
}
function change_price(id,price) {
	$('span[nc_gid="'+id+'"]').html(number_format(price, 2));
}
</script>