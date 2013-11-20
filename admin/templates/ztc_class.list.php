<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_ztc_manage'];?><!-- 直通车管理 --></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=ztc_class&op=ztc_setting"><span><?php echo $lang['nc_config'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_ztc_list_title'];?><!-- 申请列表 --></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glist" ><span><?php echo $lang['admin_ztc_goodslist_title']; //'商品列表'?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glog" ><span><?php echo $lang['admin_ztc_loglist_title']; //'金币日志';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="ztc_class">
    <input type="hidden" name="op" value="ztc_class">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="zg_name"><?php echo $lang['admin_ztc_goodsname']; ?><!-- 商品名称 --></label></th>
          <td><input type="text" name="zg_name" id="zg_name" class="txt" value='<?php echo $_GET['zg_name'];?>'></td>
          <th colspan="1"><label for="zg_membername"><?php echo $lang['admin_ztc_membername']; ?><!-- 会员名称 --></label></th>
          <td><input type="text" name="zg_membername" id="zg_membername" class="txt-short" value='<?php echo $_GET['zg_membername'];?>'></td>
          <th> <label for="zg_storename"><?php echo $lang['admin_ztc_storename']; ?><!-- 店铺名称 --></label></th>
          <td><input type="text" name="zg_storename" id="zg_storename" class="txt-short" value='<?php echo $_GET['zg_storename'];?>'></td>
          <td colspan="3"><select name="zg_state">
              <option value="0" <?php if (!$_GET['zg_state']){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_auditstate']; ?><!-- 审核状态 --></option>
              <option value="1" <?php if ($_GET['zg_state'] == 1){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_auditing']; ?><!-- 等待审核 --></option>
              <option value="2" <?php if ($_GET['zg_state'] == 2){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_auditpass']; ?><!-- 通过审核 --></option>
              <option value="3" <?php if ($_GET['zg_state'] == 3){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_auditnopass']; ?><!-- 审核失败 --></option>
            </select>
            <select name="zg_paystate">
              <option value="0" <?php if (!$_GET['zg_paystate']){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_paystate']; ?><!-- 支付状态 --></option>
              <option value="1" <?php if ($_GET['zg_paystate'] == 1){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_waitpaying']; ?><!-- 等待支付 --></option>
              <option value="2" <?php if ($_GET['zg_paystate'] == 2){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_paysuccess']; ?><!-- 支付成功 --></option>
            </select>
            <select name="zg_type">
              <option value="0" <?php if (!$_GET['zg_type']){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_applytype']; ?><!-- 申请类型 --></option>
              <option value="1" <?php if ($_GET['zg_type'] == 1){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_applyrecord']; ?><!-- 申请记录 --></option>
              <option value="2" <?php if ($_GET['zg_type'] == 2){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_rechargerecord']; ?><!-- 充值记录 --></option>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['admin_ztc_searchtext']; ?>">&nbsp;</a></td>
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
			<li><?php echo $lang['admin_ztc_index_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_ztc" action="index.php">
    <input type="hidden" id="list_act" name="act" value="ztc_class">
    <input type="hidden" id="list_op" name="op" value="dropall_ztc">
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24">&nbsp;</th>
          <th colspan="2"><?php echo $lang['admin_ztc_goodsname']; ?><!-- 商品名称 --></th>
          <th><?php echo $lang['admin_ztc_membername'];?><!-- 会员名称 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_list_gold']; ?><!-- 消耗金币(枚) --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_starttime']; ?><!-- 开始时间 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_applytype']; ?><!-- 申请类型 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_state']; ?><!-- 状态 --></th>
          <th class="align-center"><?php echo $lang['nc_handle']; ?><!-- 操作 --></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['ztc_list']) && is_array($output['ztc_list'])){ ?>
        <?php foreach($output['ztc_list'] as $k => $v){?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" name="z_id[]" value="<?php echo $v['ztc_id'];?>" class="checkitem"></td>
          <!--<td class="w24"><?php echo $v['ztc_id'];?></td>-->
          <td class="w48"><div class="goods-picture"><span class="thumb size-goods"><i></i><img src="<?php echo cthumb($v['ztc_goodsimage'],'small',$v['ztc_storeid']);?>"  onload="javascript:DrawImage(this,44,44);"/></span></div></td>
          <td><p><a href="<?php echo SiteUrl;?>/index.php?act=goods&goods_id=<?php echo $v['ztc_goodsid'];?>" target="_blank" ><?php echo $v['ztc_goodsname'];?></a></p>
            <p class="store"><?php echo $lang['admin_ztc_storename']; ?>:<?php echo $v['ztc_storename'];?></p></td>
          <td><?php echo $v['ztc_membername'];?></td>
          <td class="w84 align-center"><?php echo $v['ztc_gold'];?></td>
          <td class="w84 align-center"><?php if ($v['ztc_startdate']){
				echo date('Y-m-d',$v['ztc_startdate']);
			}else { echo $lang['admin_ztc_null']; }?></td>
          <td class="w84 align-center"><?php if ($v['ztc_type'] == 1) {
              		echo $lang['admin_ztc_rechargerecord'];//echo '充值记录';
              	}else{
              		echo $lang['admin_ztc_applyrecord'];//echo '申请记录';
              	}?></td>
          <td class="w120 align-center"><?php if ($v['ztc_state'] == 0){
              		if ($v['ztc_paystate'] == 1){
              			echo $lang['admin_ztc_list_paysucc_auditing'];//echo '已经支付,待审核';
              		}else{
              			echo $lang['admin_ztc_waitpaying'];//echo '等待支付';
              		}
              	}elseif ($v['ztc_state'] == 1) {
              		echo $lang['admin_ztc_auditpass'];
              	}elseif ($v['ztc_state'] == 2){
              		echo $lang['admin_ztc_auditnopass'];
              	}?></td>
          <td class="w96 align-center"><?php if ($v['ztc_paystate'] == 1 && $v['ztc_state'] == 0 && $v['ztc_type'] == 0){//已经支付并未经过审核并记录类型为新申请记录则可以编辑?>
            <a href="index.php?act=ztc_class&op=edit_ztc&z_id=<?php echo $v['ztc_id']; ?>" class="edit"><?php echo $lang['nc_edit']; ?></a>
            <?php }?>
            <?php if ($v['ztc_paystate'] == 0 && $v['ztc_state'] == 0){?>
            <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){window.location='index.php?act=ztc_class&op=drop_ztc&z_id=<?php echo $v['ztc_id']; ?>';}else{return false;}"><?php echo $lang['nc_del']; ?></a>
            <?php }?>
            <?php //if ($v['ztc_state'] != 0 || $v['ztc_type'] == 1){?>
            <a href="index.php?act=ztc_class&op=info_ztc&z_id=<?php echo $v['ztc_id']; ?>" class="edit"><?php echo $lang['nc_view'];?></a>
            <?php //}?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16" id="batchAction"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('dropall_ztc');"><span><?php echo $lang['nc_del']?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
function submit_form(op){
	if(op=='dropall_ztc'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
	}
	$('#list_op').val(op);
	$('#form_ztc').submit();
}
</script>