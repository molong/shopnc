<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_gold_buy'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=gold_buy&op=gold_buy" ><span><?php echo $lang['gbuy_log'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['gold_log'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" id="formSearch" name="formSearch">
    <input type="hidden" name="act" value="gold_buy" />
    <input type="hidden" name="op" value="gold_log" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="storename"><?php echo $lang['store_name'];?></label></th>
          <td><input class="txt" type="text" value="<?php echo $output['search']['storename'];?>" id="storename" name="storename" /></td>
          <th><label for="membername"><?php echo $lang['buyer_name'];?></label></th>
          <td><input class="txt" type="text" value="<?php echo $output['search']['membername'];?>" id="membername" name="membername" /></td>
          <th><label for="add_time_from"><?php echo $lang['glog_add_time_from'];?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['add_time_from'];?>" id="add_time_from" name="add_time_from"/>
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['add_time_to'];?>" id="add_time_to" name="add_time_to" /></td>
          <td><select name="method">
              <option value="" <?php if($output['search']['method'] == ''){?>selected<?php }?>><?php echo $lang['glog_method']; ?></option>
              <option value="1" <?php if($output['search']['method'] == '1'){?>selected<?php }?>><?php echo $lang['glog_method1']; ?></option>
              <option value="2" <?php if($output['search']['method'] == '2'){?>selected<?php }?>><?php echo $lang['glog_method2']; ?></option>
            </select></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
          <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th></th>
        <th><?php echo $lang['glog_add_time'];?></th>
        <th><?php echo $lang['store_name'];?>
          </td>
        <th><?php echo $lang['buyer_name'];?></th>
        <th><?php echo $lang['gbuy_gold_num'];?></th>
        <th><?php echo $lang['glog_method'];?></th>
        <th><?php echo $lang['glog_handle_desc'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($output['glog_list'])>0){?>
      <?php foreach($output['glog_list'] as $key => $val){?>
      <tr class="hover">
        <td class="w12"></td>
        <td><?php echo date('Y-m-d H:i:s',$val['glog_addtime']);?></td>
        <td><?php echo $val['glog_storename'];?></td>
        <td><?php echo $val['glog_membername'];?></td>
        <td><?php echo $val['glog_goldnum'];?></td>
        <td><?php if ($val['glog_method'] == 2) { ?>
          <?php echo $lang['glog_method2'];?>
          <?php } ?>
          <?php if ($val['glog_method'] == 1) { ?>
          <?php echo $lang['glog_method1'];?>
          <?php } ?></td>
        <td><?php echo $val['glog_desc'];?></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="16"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_log_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('gold_log');$('#formSearch').submit();
    });
});
</script>