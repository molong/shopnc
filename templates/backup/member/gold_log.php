<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="search-form">
    <form method="get" action="index.php">
      <tr>
        <input type="hidden" name="act" value="store_gbuy" />
        <input type="hidden" name="op" value="gold_log" />
        <td>&nbsp;</td>
        <th><?php echo $lang['store_glog_method'].$lang['nc_colon']; ?></th>
        <td class="w90"><select name="method">
            <option value="" <?php if($output['search']['method'] == ''){?>selected<?php }?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="1" <?php if($output['search']['method'] == '1'){?>selected<?php }?>><?php echo $lang['store_glog_method1']; ?></option>
            <option value="2" <?php if($output['search']['method'] == '2'){?>selected<?php }?>><?php echo $lang['store_glog_method2']; ?></option>
          </select></td>
        <th><?php echo $lang['store_glog_add_time'].$lang['nc_colon'];?></th>
        <td class="w180"><input type="text" class="text" name="add_time_from" id="add_time_from" value="<?php echo $output['search']['add_time_from']; ?>" />
          &#8211;
          <input type="text" class="text" id="add_time_to" name="add_time_to" value="<?php echo $output['search']['add_time_to']; ?>" /></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </form>
  </table>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w100"><?php echo $lang['store_gbuy_gold_num'];?></th>
        <th class="w150"><?php echo $lang['store_glog_method']; ?></th>
        <th class="w200"><?php echo $lang['store_glog_add_time'];?></th>
        <th class="tl"><?php echo $lang['store_glog_handle_desc'];?></th>
      </tr>
    </thead>
    <?php if (!empty($output['glog_list'])) { ?>
    <tbody id="treet1">
      <?php foreach ($output['glog_list'] as $key => $val) { ?>
      <tr class="bd-line">
        <td><span><?php echo $val['glog_goldnum']; ?></span></td>
        <td><?php if ($val['glog_method'] == 2) { ?>
          <?php echo $lang['store_glog_method2']; ?>
          <?php } ?>
          <?php if ($val['glog_method'] == 1) { ?>
          <?php echo $lang['store_glog_method1']; ?>
          <?php } ?></td>
        <td><?php echo date("Y-m-d H:i:s",$val['glog_addtime']);?></td>
        <td class="tl"><?php echo $val['glog_desc'];?></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php } else { ?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></td>
      </tr>
    </tbody>
    <?php } ?>
    <?php if (!empty($output['glog_list'])) { ?>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript">
	$(function(){
	    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
	    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>