<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=member_flea&op=add_goods');" title="<?php echo $lang['store_goods_index_new_goods'];?>"><?php echo $lang['store_goods_index_new_flea'];?></a> </div>
  <form method="get" action="index.php">
    <table class="search-form">
      <input type="hidden" name="act" value="member_flea" />
      <input type="hidden" name="op" value="flea_list" />
      <tr>
        <td>&nbsp;</td>
        <th style="width:90px;"><?php echo $lang['flea_goods_name'].$lang['nc_colon'];?></th>
        <td class="w150"><input type="text" class="text" name="keyword" value="<?php echo $_GET['keyword']; ?>"/></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr nc_type="table_header">
        <th class="w30"></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['flea_goods_name'];?></th>
        <th class="w200"><?php echo $lang['flea_goods_gc_name'];?></th>
        <th class="w100"><?php echo $lang['flea_goods_price'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <?php if (count($output['list_goods'])>0) { ?>
      <tr>
        <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="20"><label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0)" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=member_flea&op=drop_goods" name="goods_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <?php } ?>
    </thead>
    <tbody>
      <?php  if (count($output['list_goods'])>0) { ?>
      <?php foreach($output['list_goods'] as $val) { ?>
      <tr class="bd-line">
        <td><input type="checkbox" class="checkitem" value="<?php echo $val['goods_id']; ?>"/></td>
        <td><div class="goods-pic-small"> <span class="thumb size60"> <i></i><a href="index.php?act=flea_goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><img height="50" width="50" src="<?php if ($val['goods_image']) { echo $val['goods_image']; } else { echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_goods_image']; } ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><?php echo $val['goods_name']; ?></dt>
          </dl></td>
        <td><?php echo $val['gc_name']; ?></td>
        <td><?php echo $val['goods_store_price']; ?></td>
        <td><p><a href="index.php?act=member_flea&op=edit_goods&goods_id=<?php echo $val['goods_id']; ?>"><?php echo $lang['store_goods_index_edit_flea'];?></a></p>
          <p><a href="javascript:drop_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=member_flea&op=drop_goods&goods_id=<?php echo $val['goods_id']; ?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del'];?></a></p></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list_goods'])>0) { ?>
      <tr>
        <td class="tc"><input type="checkbox" id="all2" class="checkall"/></td>
        <td colspan="2"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0)" class="ncu-btn1" uri="index.php?act=member_flea&op=drop_goods" name="goods_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a></td>
        <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>