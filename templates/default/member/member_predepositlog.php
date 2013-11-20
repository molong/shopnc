<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
     <div class="text-intro"><?php echo $lang['predeposit_pricetype_available'].$lang['nc_colon']; ?><?php echo $output['member_info']['available_predeposit']; ?>&nbsp;<?php echo $lang['currency_zh'];?></div></div>
  <form method="get" action="index.php">
    <table class="search-form">
      <input type="hidden" name="act" value="predeposit" />
      <input type="hidden" name="op" value="predepositlog" />
      <tr>
        <td></td>
        <th><?php echo $lang['predeposit_log_stage'].$lang['nc_colon']; ?></th>
        <td class="w80"><select name="stage">
            <option value="" <?php if (!$_GET['stage']){echo 'selected=selected';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="recharge" <?php if ($_GET['stage'] == 'recharge'){echo 'selected=selected';}?>><?php echo $lang['predeposit_log_stage_recharge'];?></option>
            <option value="cash" <?php if ($_GET['stage'] == 'cash'){echo 'selected=selected';}?>><?php echo $lang['predeposit_log_stage_cash'];?></option>
            <option value="order" <?php if ($_GET['stage'] == 'order'){echo 'selected=selected';}?>><?php echo $lang['predeposit_log_stage_order'];?></option>
            <option value="admin" <?php if ($_GET['stage'] == 'admin'){echo 'selected=selected';}?>><?php echo $lang['predeposit_log_stage_artificial'];?></option>
            <option value="system" <?php if ($_GET['stage'] == 'system'){echo 'selected=selected';}?>><?php echo $lang['predeposit_log_stage_system'];?></option>
            <option value="income" <?php if ($_GET['stage'] == 'income'){echo 'selected=selected';}?>><?php echo $lang['predeposit_log_stage_income'];?></option>
          </select></td>
        <!-- <td><select name="recordtype">
					<option value="0" <?php if (!$_GET['recordtype']){echo 'selected=selected';}?>><?php echo $lang['predeposit_pricetype'];?></option>
					<option value="1" <?php if ($_GET['recordtype'] == '1'){echo 'selected=selected';}?>><?php echo $lang['predeposit_pricetype_available']; ?></option>
					<option value="2" <?php if ($_GET['recordtype'] == '2'){echo 'selected=selected';}?>><?php echo $lang['predeposit_pricetype_freeze']; ?></option>
	            </select></td> -->
        <th><?php echo $lang['predeposit_addtime'].$lang['nc_colon']; ?></th>
        <td class="w180"><input type="text" class="text" id="stime" name="stime" value="<?php echo $_GET['stime'];?>" >&#8211;
          <input type="text" class="text" id="etime" name="etime" value="<?php echo $_GET['etime'];?>" ></td>
        <th><?php echo $lang['predeposit_log_desc'].$lang['nc_colon'];?></th>
        <td class="w150"><input class="text" type="text" id="description" name="description" value="<?php echo $_GET['description'];?>" ></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr>
      	<th class="w10"></th>
        <th class="w100"><?php echo $lang['predeposit_price'];?>(<?php echo $lang['currency_zh'];?>)</th>
        <th class="w150"><?php echo $lang['predeposit_addtime']; ?></th>
        <th class="w150"><?php echo $lang['predeposit_log_stage']?></th>
        <th class="tl"><?php echo $lang['predeposit_log_desc'];?></th>
      </tr>
    </thead>
    
    <tbody><?php  if (count($output['list_log'])>0) { ?>
      <?php foreach($output['list_log'] as $v) { ?>
      <tr class="bd-line">
      	<td></td>
        <td class="goods-price"><?php echo $v['pdlog_price'];?></td>
        <td class="goods-time"><?php echo @date('Y-m-d H:i:s',$v['pdlog_addtime']);?></td>
        <td><?php 
					switch ($v['pdlog_stage']){
	              		case 'recharge':
	              			echo $lang['predeposit_log_stage_recharge'];
	              			break;
	              		case 'cash':
	              			echo $lang['predeposit_log_stage_cash'];
	              			break;
	              		case 'order':
	              			echo $lang['predeposit_log_stage_order'];
	              			break;
	              		case 'admin':
	              			echo $lang['predeposit_log_stage_artificial'];
	              			break;
	              		case 'system':
	              			echo $lang['predeposit_log_stage_system'];
	              			break;
	              		case 'income':
	              			echo $lang['predeposit_log_stage_income'];
	              			break;
		          }?></td>
        <td class="tl"><?php echo $v['pdlog_desc'];?></td>
      </tr>
      <?php } ?>
      <?php } else {?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list_log'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script language="javascript">
$(function(){
	$('#stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#etime').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>