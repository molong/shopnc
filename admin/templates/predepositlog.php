<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_predepositlog'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_member_predepositlog'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="predeposit">
    <input type="hidden" name="op" value="predepositlog">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label><?php echo $lang['admin_predeposit_membername'];?></label></th>
          <td><input type="text" name="mname" class="txt" value='<?php echo $_GET['mname'];?>'></td>
                    
          <th><label><?php echo $lang['admin_predeposit_addtime']; ?></label></th>
          <td><input type="text" id="stime" name="stime" class="txt date" value="<?php echo $_GET['stime'];?>" >
            <label>~</label>
            <input type="text" id="etime" name="etime" class="txt date" value="<?php echo $_GET['etime'];?>" ></td>
          
        </tr><tr><th><label><?php echo $lang['admin_predeposit_adminname'];?></label></th>
          <td><input type="text" name="aname" class="txt" value='<?php echo $_GET['aname'];?>'></td><th><label><?php echo $lang['admin_predeposit_log_desc'];?></label></th>
          <td><input type="text" id="description" name="description" class="txt2" value="<?php echo $_GET['description'];?>" ></td></tr>
          <tr><th><?php echo $lang['admin_predeposit_pricetype']; ?></th><td><select name="recordtype" style=" width:150px;">
              <option value="0" <?php if (!$_GET['recordtype']){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_pricetype']; ?></option>
              <option value="1" <?php if ($_GET['recordtype'] == '1'){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_pricetype_available']; ?></option>
              <option value="2" <?php if ($_GET['recordtype'] == '2'){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_pricetype_freeze']; ?></option>
            </select></td><th><?php echo $lang['admin_predeposit_log_stage']; ?></th><td><select name="stage" style=" width:150px;">
              <option value="" <?php if (!$_GET['stage']){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_log_stage']; ?></option>
              <option value="recharge" <?php if ($_GET['stage'] == 'recharge'){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_log_stage_recharge'];?></option>
              <option value="cash" <?php if ($_GET['stage'] == 'cash'){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_log_stage_cash'];?></option>
              <option value="order" <?php if ($_GET['stage'] == 'order'){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_log_stage_order'];?></option>
              <option value="admin" <?php if ($_GET['stage'] == 'admin'){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_log_stage_artificial'];?></option>
              <option value="system" <?php if ($_GET['stage'] == 'system'){echo 'selected=selected';}?>><?php echo $lang['admin_predeposit_log_stage_system']; ?></option>
            </select><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
            </td></tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['admin_predeposit_log_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['admin_predeposit_membername'];?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_addtime']; ?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_price'];?>(<?php echo $lang['currency_zh'];?>)</th>
        <th class="align-center"><?php echo $lang['admin_predeposit_pricetype']; ?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_adminname'];?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_log_stage'];?></th>
        <th><?php echo $lang['admin_predeposit_log_desc'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list_log']) && is_array($output['list_log'])){ ?>
      <?php foreach($output['list_log'] as $k => $v){?>
      <tr class="hover">
        <td><?php echo $v['pdlog_membername'];?></td>
        <td class="nowarp align-center"><?php echo @date('Y-m-d',$v['pdlog_addtime']);?></td>
        <td class="align-center"><?php echo $v['pdlog_price'];?></td>
        <td class="align-center"><?php echo $v['pdlog_type'] == 1?$lang['admin_predeposit_pricetype_freeze']:$lang['admin_predeposit_pricetype_available'];?></td>
        <td class="align-center"><?php echo $v['pdlog_adminname'];?></td>
        <td class="align-center"><?php 
				switch ($v['pdlog_stage']){
              		case 'recharge':
              			echo $lang['admin_predeposit_log_stage_recharge'];
              			break;
              		case 'cash':
              			echo $lang['admin_predeposit_log_stage_cash'];
              			break;
              		case 'order':
              			echo $lang['admin_predeposit_log_stage_order'];
              			break;
              		case 'admin':
              			echo $lang['admin_predeposit_log_stage_artificial'];
              			break;
              		case 'system':
              			echo $lang['admin_predeposit_log_stage_system'];
              			break;
	          }?></td>
        <td><?php echo $v['pdlog_desc'];?></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="16" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?></div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script language="javascript">
$(function(){
	$('#stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#etime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_mx_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('predepositlog');$('#formSearch').submit();
    });	
});
</script>