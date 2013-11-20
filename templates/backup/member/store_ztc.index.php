<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=store_ztc&op=ztc_add');" title="<?php echo $lang['nc_member_path_ztc_add'];?>"><?php echo $lang['nc_member_path_ztc_add'];?></a></div>
  <form method="get" action="index.php" onsubmit="return ztc_searchInput();">
    <table class="search-form">
      <input type="hidden" name="act" value="store_ztc" />
      <input type="hidden" name="op" value="ztc_list" />
      <tr><td>&nbsp;</td>
        <th><?php echo $lang['store_ztc_auditstate'].$lang['nc_colon']; ?></th>
        <td><select name="zg_state" class="w100">
            <option value="0" <?php if (!$_GET['zg_state']){echo 'selected=selected';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="1" <?php if ($_GET['zg_state'] == 1){echo 'selected=selected';}?>><?php echo $lang['store_ztc_auditing'];?></option>
            <option value="2" <?php if ($_GET['zg_state'] == 2){echo 'selected=selected';}?>><?php echo $lang['store_ztc_auditpass'];?></option>
            <option value="3" <?php if ($_GET['zg_state'] == 3){echo 'selected=selected';}?>><?php echo $lang['store_ztc_auditnopass'];?></option>
          </select></td>
        <th><?php echo $lang['store_ztc_paystate'].$lang['nc_colon'];?></th>
        <td><select name="zg_paystate" class="w100">
            <option value="0" <?php if (!$_GET['zg_paystate']){echo 'selected=selected';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="1" <?php if ($_GET['zg_paystate'] == 1){echo 'selected=selected';}?>><?php echo $lang['store_ztc_waitpaying'];?></option>
            <option value="2" <?php if ($_GET['zg_paystate'] == 2){echo 'selected=selected';}?>><?php echo $lang['store_ztc_paysuccess'];?></option>
          </select></td>
        <th><?php echo $lang['store_ztc_applytype'].$lang['nc_colon'];?></th>
        <td><select name="zg_type" class="w100">
            <option value="0" <?php if (!$_GET['zg_type']){echo 'selected=selected';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="1" <?php if ($_GET['zg_type'] == 1){echo 'selected=selected';}?>><?php echo $lang['store_ztc_applyrecord'];?></option>
            <option value="2" <?php if ($_GET['zg_type'] == 2){echo 'selected=selected';}?>><?php echo $lang['store_ztc_rechargerecord'];?></option>
          </select></td>
        <td class="w160"><input type="text"  class="text" id="zg_name" name="zg_name" onblur="ztc_searchBlur(this)" onfocus="ztc_searchFocus(this)" value="<?php if ($_GET['zg_name']){echo $_GET['zg_name'];}else {echo $lang['store_ztc_goodsname'];}?>"></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr nc_type="table_header">
        <th class="w30"></th>
        <th class="w30"><?php echo $lang['store_ztc_list_number'];?></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['store_ztc_goodsname'];?></th>
        <th class="w80"><?php echo $lang['store_ztc_list_gold'];?></th>
        <th class="w80"><?php echo $lang['store_ztc_starttime'];?></th>
        <th class="w80"><?php echo $lang['store_ztc_applytype'];?></th>
        <th class="w150"><?php echo $lang['store_ztc_paystate'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <?php if (count($output['ztc_list'])>0) {?>
      <tr>
        <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="20"><label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_ztc&op=dropall_ztc" name="z_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a>
          </th></td>
      </tr>
      <?php } ?>
    </thead>
    <tbody>
      <?php if (count($output['ztc_list'])>0) {?>
      <?php foreach($output['ztc_list'] as $val) { ?>
      <tr class="bd-line">
        <td class="tc"><input type="checkbox" class="checkitem" value="<?php echo $val['ztc_id']; ?>"/></td>
        <td class="tc"><?php echo $val['ztc_id']; ?></td>
        <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><img src="<?php echo thumb($val,'tiny'); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td class="tl"><a href="index.php?act=goods&goods_id=<?php echo $val['ztc_goodsid']; ?>" target="_blank"><?php echo $val['ztc_goodsname']; ?></a></td>
        <td><?php echo $val['ztc_gold']; ?></td>
        <td class="goods-time"><?php if ($val['ztc_startdate']){ echo date('Y-m-d',$val['ztc_startdate']); }else{ echo $lang['store_ztc_index_list_startnow']; } ?></td>
        <td><span nc_type="editobj">
          <?php if ($val['ztc_type'] == 1) {
	              		echo $lang['store_ztc_rechargerecord'];
	              	}else{
	              		echo $lang['store_ztc_applyrecord'];
	              	}?>
          </span></td>
        <td><span nc_type="editobj">
          <?php if ($val['ztc_state'] == 0){
	              		if ($val['ztc_paystate'] == 1){
	              			//echo '已经支付,待审核<a class="ncu-btn2 mt5" href="index.php?act=store_ztc&op=ztc_pay&zid='.$val['ztc_id'].'">点击取消支付</a>';
	              			echo $lang['store_ztc_index_list_paysucc_auditing'].'<a class="ncu-btn2 mt5" href="index.php?act=store_ztc&op=ztc_pay&zid='.$val['ztc_id'].'">'.$lang['store_ztc_index_list_click_cancelpay'].'</a>';
	              		}else{
	              			//echo '未支付&nbsp;<a <a class="ncu-btn2 mt5" href="index.php?act=store_ztc&op=ztc_pay&zid='.$val['ztc_id'].'">点击支付</a>';
	              			echo $lang['store_ztc_waitpaying'].'<br/><a class="ncu-btn2 mt5" href="index.php?act=store_ztc&op=ztc_pay&zid='.$val['ztc_id'].'">'.$lang['store_ztc_index_list_click_pay'].'</a>';
	              		}
	              	}elseif ($val['ztc_state'] == 1) {
	              		//echo '通过审核';
	              		echo $lang['store_ztc_auditpass'];
	              	}elseif ($val['ztc_state'] == 2){
	              		//echo '审核失败';
	              		echo $lang['store_ztc_auditnopass'];
	              	}?>
          </span></td>
        <td><?php if ($val['ztc_paystate'] == 0 && $val['ztc_state'] == 0){?>
          <a href="index.php?act=store_ztc&op=edit_ztc&z_id=<?php echo $val['ztc_id']; ?>" ><?php echo $lang['store_ztc_index_edit_content'];?></a> <a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store_ztc&op=drop_ztc&z_id=<?php echo $val['ztc_id']; ?>');"	class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a>
          <?php }else{?>
          <a href="index.php?act=store_ztc&op=info_ztc&z_id=<?php echo $val['ztc_id']; ?>"><?php echo $lang['nc_view'];//查看 ?></a>
          <?php }?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php  if (count($output['ztc_list'])>0) { ?>
    <tfoot>
      <tr>
        <td class="tc"><input type="checkbox" id="all2" class="checkall"/></td>
        <td colspan="20"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=store_ztc&op=dropall_ztc" name="z_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a>
          <div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script language="javascript">
var ztc_searchTxt = '<?php echo $lang['store_ztc_goodsname']; ?>';
ztc_searchTxt = $.trim(ztc_searchTxt);
//var ztc_searchTxt = '商品名称';
function ztc_searchFocus(e){
	if(e.value == ztc_searchTxt){
		e.value='';
		$('#zg_name').css("color","");
	}
}
function ztc_searchBlur(e){
	if(e.value == ''){
		e.value=ztc_searchTxt;
		$('#zg_name').css("color","#999999");
	}
}
function ztc_searchInput() {
	if($('#zg_name').val()==ztc_searchTxt)
		$('#zg_name').attr("value","");
	return true;
}
</script> 
