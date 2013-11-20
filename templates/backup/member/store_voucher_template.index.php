<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
  <div class="ncm-notes">
    <h3><?php echo $lang['nc_explain'].$lang['nc_colon'];?></h3>
    <ul>
      <li><?php echo $lang['voucher_template_list_tip1'];?></li>
      <li><?php echo $lang['voucher_template_list_tip2'];?></li>
      <?php if (!empty($output['current_quota'])){?>
      <li><?php echo sprintf($lang['voucher_template_list_tip3'],'<b>'.@date('Y-m-d',$output['current_quota']['quota_starttime']).' ~ '.@date('Y-m-d',$output['current_quota']['quota_endtime']))."</b>";?></li>
      <?php }?>
    </ul>
  </div>
  <div class="tabmenu">
  	<?php include template('member/member_submenu');?>
  	<?php if(!empty($output['current_quota'])){?>
    <a href="index.php?act=store_voucher&op=templateadd" class="ncu-btn3" title="<?php echo $lang['voucher_templateadd']; ?>"><?php echo $lang['voucher_templateadd']; ?></a>
    <?php }?>
  </div>
  <form method="get">
    <table class="search-form">
      <input type="hidden" id='act' name='act' value='store_voucher' />
      <input type="hidden" id='op' name='op' value='templatelist' />
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['voucher_template_title'].$lang['nc_colon'];?></th>
        <td class="w150"><input type="text" class="text"  value="" id="txt_keyword" name="txt_keyword" /></td>
        <th><?php echo $lang['voucher_template_enddate'].$lang['nc_colon']; ?></th>
        <td class="w180">
        	<input type="text" class="text"  readonly="readonly" value="<?php echo $_GET['txt_startdate'];?>" id="txt_startdate" name="txt_startdate"/>
        	&#8211;
        	<input type="text" class="text"  readonly="readonly" value="<?php echo $_GET['txt_enddate'];?>" id="txt_enddate" name="txt_enddate"/>
        </td>
        <th><?php echo $lang['nc_status'].$lang['nc_colon']; ?></th>
        <td class="w90"><select class="w80" name="select_state">
            <option value="0" <?php if (!$_GET['select_state'] == '0'){ echo 'selected=true';}?>><?php echo $lang['nc_please_choose'];?></option>
            <?php if (!empty($output['templatestate_arr'])){?>
            <?php foreach ($output['templatestate_arr'] as $k=>$v){?>
            <option value="<?php echo $v[0]; ?>" <?php if ($_GET['select_state'] == $v[0]){echo 'selected=true';}?>><?php echo $v[1];?></option>
            <?php }?>
            <?php }?>
          </select></td>
        <td class="tc w90"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['voucher_template_title']; ?></th>
        <th class="w100"><?php echo $lang['voucher_template_orderpricelimit'];?></th>
        <th class="w90"><?php echo $lang['voucher_template_price'];?></th>
        <th class="w200"><?php echo $lang['voucher_template_enddate'];?></th>
        <th class="w80"><?php echo $lang['nc_status'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
        <td></td>
        <td><div class="goods-pic-small"><span class="thumb size60"><i></i><img src="<?php echo $val['voucher_t_customimg'];?>" onload="javascript:DrawImage(this,60,60);" /></span></div></td>
        <td class="tl"><?php echo $val['voucher_t_title'];?></td>
        <td><?php echo $val['voucher_t_limit'];?></td>
        <td class="goods-price"><?php echo $val['voucher_t_price'];?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$val['voucher_t_start_date']).'~'.date("Y-m-d",$val['voucher_t_end_date']);?></td>
        <td><?php if($val['voucher_t_state']== $output['templatestate_arr']['usable'][0]) echo $output['templatestate_arr']['usable'][1];
                  if($val['voucher_t_state']== $output['templatestate_arr']['disabled'][0]) echo $output['templatestate_arr']['disabled'][1]; ?></td>
        <td>
        	<?php if($val['voucher_t_state']==$output['templatestate_arr']['usable'][0] && !$val['voucher_t_giveout']) {//代金券模板有效并且没有领取时可以编辑?>
        		<a href="index.php?act=store_voucher&op=templateedit&tid=<?php echo $val['voucher_t_id'];?>"><?php echo $lang['nc_edit'];?></a>
        	<?php }else {//代金券模板失效或者有领取时可以查看?>
        		<a href="index.php?act=store_voucher&op=templateinfo&tid=<?php echo $val['voucher_t_id'];?>"><?php echo $lang['nc_view'];?></a>
        	<?php }?>
        	<?php if (!$val['voucher_t_giveout']){//该模板没有发放过代金券时可以删除?>
        	<br/><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>','index.php?act=store_voucher&op=templatedel&tid=<?php echo $val['voucher_t_id'];?>');" class="ncu-btn2"><?php echo $lang['nc_del'];?></a>
        	<?php }?>
        </td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script> 
<script type="text/javascript">
$(document).ready(function(){
	$('#txt_startdate').datepicker();
	$('#txt_enddate').datepicker();
});
</script>