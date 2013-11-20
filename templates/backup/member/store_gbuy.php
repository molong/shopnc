<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <div class="text-intro" style=" right:100px;"><?php echo $lang['store_gbuy_gold'];?> <?php echo $output['member_goldnum'];?> <?php echo $lang['store_gbuy_num'];?></div>
    <a href="javascript:void(0)" class="ncu-btn3" nc_type="dialog" dialog_title="<?php echo $lang['store_gbuy_add'];?>" dialog_id="gold_buy" dialog_width="480" uri="index.php?act=store_gbuy&op=add"><?php echo $lang['store_gbuy_add'];?></a></div>
  <form method="get" action="index.php">
    <table class="search-form">
      <input type="hidden" name="act" value="store_gbuy" />
      <input type="hidden" name="op" value="index" />
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['store_gbuy_add_time'].$lang['nc_colon'];?></th>
        <td class="w180"><input type="text" class="text" name="add_time_from" id="add_time_from" value="<?php echo $_GET['add_time_from']; ?>" />
          &#8211;
          <input type="text" class="text" id="add_time_to" name="add_time_to" value="<?php echo $_GET['add_time_to']; ?>" /></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <?php if (!empty($output['gbuy_list'])) { ?>
    <thead>
      <tr class="gray">
        <th class="w150"><?php echo $lang['store_gbuy_gold_num'];?></th>
        <th><?php echo $lang['store_gbuy_price'];?></th>
        <th class="w200"><?php echo $lang['store_gbuy_add_time'];?></th>
        <th class="w150"><?php echo $lang['store_gbuy_payment'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody id="treet1">
      <?php foreach ($output['gbuy_list'] as $key => $val) { ?>
      <tr class="bd-line">
        <td><?php echo $val['gbuy_num']; ?></td>
        <td class="goods-price"><?php echo $val['gbuy_price']; ?></td>
        <td class="goods-time"><?php echo date("Y-m-d H:i:s",$val['gbuy_addtime']);?></td>
        <td>
        	<?php if (empty($val['gbuy_check_type'])) { ?>
        	<?php echo $lang['store_gbuy_pay_null'];?>
        	<?php } else { ?>
        	<?php echo $output['payment_array'][$val['gbuy_check_type']];?>
        	<?php } ?>
        	</td>
        <td><?php if ($val['gbuy_ispay'] == 0) { ?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_width="480" dialog_title="<?php echo $lang['store_gbuy_pay'];?>" dialog_id="store_gbuy_payment" uri="index.php?act=store_gbuy&op=payment&gbuy_id=<?php echo $val['gbuy_id']; ?>; ?>">
          <?php if ($val['gbuy_check_type'] == 'offline') { ?>
          <?php echo $lang['store_gbuy_pay_offline'];?>
          <?php } else { ?>
          <?php echo $lang['store_gbuy_pay'];?>
          <?php } ?>
          </a></p>
          <p><a href="javascript:void(0)" class="ncu-btn2 mt5" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>','index.php?act=store_gbuy&op=del&gbuy_id=<?php echo $val['gbuy_id']; ?>');"><?php echo $lang['nc_del_&nbsp'];?></a></p>
          <?php } ?>
          <?php if ($val['gbuy_ispay'] == 1) { ?>
          <?php echo $lang['store_gbuy_pay_success'];?>
          <?php } ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
    </tfoot>
    <?php } else { ?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></td>
      </tr>
    </tbody>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript">
	$(function(){
	    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
	    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>