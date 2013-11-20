<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_predepositmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_predeposit_rechargelist']?></span></a></li>
        <li><a href="index.php?act=predeposit&op=cashlist"><span><?php echo $lang['admin_predeposit_cashmanage']; ?></span></a></li>
        <li><a href="index.php?act=predeposit&op=artificial"><span><?php echo $lang['admin_predeposit_artificial'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="predeposit">
    <input type="hidden" name="op" value="predeposit">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['admin_predeposit_membername'];?> </th>
          <td><input type="text" name="mname" class="txt" value='<?php echo $_GET['mname'];?>'></td>
          <th><?php echo $lang['admin_predeposit_addtime'];?> </th>
          <td colspan="2"><input type="text" id="stime" name="stime" class="txt date" value="<?php echo $_GET['stime'];?>" >
            <label>~</label>
            <input type="text" id="etime" name="etime" class="txt date" value="<?php echo $_GET['etime'];?>" ></td>
        </tr>
        <tr>
          <th><?php echo $lang['admin_predeposit_recharge_huikuanname'];?></th>
          <td><input type="text" name="huikuan_name" class="txt" value='<?php echo $_GET['huikuan_name'];?>'></td>
          <th><?php echo $lang['admin_predeposit_recharge_huikuanbank'];?></th>
          <td><input type="text" name="huikuan_bank" class="txt2" value='<?php echo $_GET['huikuan_bank'];?>'></td>
        </tr>
        <tr><th><?php echo $lang['admin_predeposit_recharge_searchtitle'];?></th>
          <td colspan="3"><?php if (is_array($output['payment_array']) && count($output['payment_array'])>0){?>
            <select name="payment_search" id="payment_search">
              <option value=""><?php echo $lang['admin_predeposit_payment'];?></option>
              <?php foreach ($output['payment_array'] as $k=>$v){?>
              <option value="<?php echo $k;?>" <?php if($_GET['payment_search'] == $k) { ?>selected="selected"<?php } ?> title="<?php echo $v['payment_info'];?>"><?php echo $v['payment_name'];?></option>
              <?php }?>
            </select>
            <?php }?>
            <select id="paystate_search" name="paystate_search">
              <option value=""><?php echo $lang['admin_predeposit_paystate']; ?></option>
              <?php if (is_array($output['rechargepaystate']) && count($output['rechargepaystate'])>0){?>
              <?php foreach ($output['rechargepaystate'] as $k=>$v){?>
              <option value="<?php echo $k; ?>" <?php if($_GET['paystate_search'] === $k ) { ?>selected="selected"<?php } ?>><?php echo $v;?></option>
              <?php }?>
              <?php }?>
            </select>
            <a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a></td>
        </tr>
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
            <li><?php echo $lang['admin_predeposit_recharge_help1'];?></li>
            <li><?php echo $lang['admin_predeposit_recharge_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['admin_predeposit_sn'];?></th>
        <th><?php echo $lang['admin_predeposit_membername'];?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_addtime']; ?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_payment']; ?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_recharge_price']; ?>(<?php echo $lang['currency_zh']; ?>)</th>
        <th class="align-center"><?php echo $lang['admin_predeposit_paystate']; ?></th>
        <th class="align-center"><?php echo $lang['nc_handle']; ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['recharge_list']) && is_array($output['recharge_list'])){ ?>
      <?php foreach($output['recharge_list'] as $k => $v){?>
      <tr class="hover">
        <td><?php echo $v['pdr_sn']; ?></td>
        <td><?php echo $v['pdr_membername']; ?></td>
        <td class="nowarp align-center"><?php echo @date('Y-m-d',$v['pdr_addtime']);?></td>
        <td class="align-center"><?php echo $output['payment_array'][$v['pdr_payment']]['payment_name'];?></td>
        <td class="align-center"><?php echo $v['pdr_price'];?></td>
        <td class="align-center"><?php echo $output['rechargepaystate'][$v['pdr_paystate']]; ?></td>
        <td class="w90 align-center">
          <?php if ($v['pdr_paystate'] == 0){?>
          <a href="index.php?act=predeposit&op=rechargeedit&id=<?php echo $v['pdr_id']; ?>" class="edit"><?php echo $lang['nc_edit']; ?></a>
          <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){window.location='index.php?act=predeposit&op=rechargedel&id=<?php echo $v['pdr_id']; ?>';}else{return false;}"><?php echo $lang['nc_del']; ?></a>
          <?php }?>
          <a href="index.php?act=predeposit&op=rechargeinfo&id=<?php echo $v['pdr_id']; ?>" class="edit"><?php echo $lang['nc_view']; ?></a></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
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
<script language="javascript">
$(function(){
	$('#stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#etime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('predeposit');$('#formSearch').submit();
    });	
});
</script>