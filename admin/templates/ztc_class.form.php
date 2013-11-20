<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_ztc_manage'];?><!-- 直通车管理 --></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_ztc_list_title'];?><!-- 申请列表 --></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glist" ><span><?php echo $lang['admin_ztc_goodslist_title']; //'商品列表'?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glog" ><span><?php echo $lang['admin_ztc_loglist_title']; //'金币日志';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- <form id="ztc_form" method="post" action="index.php?act=ztc_class&op=edit_ztc&z_id=<?php echo $output['ztc_info']['ztc_id']; ?>"> -->
  <form id="ztc_form" method="post" name="ztc_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="admin_ztc_applyrecord"><?php echo $lang['admin_ztc_applytype']; ?><!-- 申请类型 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" id="admin_ztc_applyrecord" value="<?php echo $output['ztc_info']['ztc_type'] == 1? $lang['admin_ztc_rechargerecord']:$lang['admin_ztc_applyrecord'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ztc_membername"><?php echo $lang['admin_ztc_membername']; ?><!-- 会员名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" id="ztc_membername" value="<?php echo $output['ztc_info']['ztc_membername'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ztc_storename"><?php echo $lang['admin_ztc_storename']; ?><!-- 店铺名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" id="ztc_storename" value="<?php echo $output['ztc_info']['ztc_storename'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ztc_goodsname"><?php echo $lang['admin_ztc_goodsname']; ?><!-- 商品名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea rows="6" readonly="readonly" class="readonly tarea" id="ztc_goodsname"><?php echo $output['ztc_info']['ztc_goodsname'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="admin_ztc_goldunit"><?php echo $lang['admin_ztc_edit_costgold']; ?><!-- 消耗金币 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" id="admin_ztc_goldunit" value="<?php echo $output['ztc_info']['ztc_gold'];?> <?php echo $lang['admin_ztc_goldunit']; ?>" readonly />
            
            <!-- 枚 --></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ztc_remark"><?php echo $lang['admin_ztc_edit_remark']; ?><!-- 备注信息 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" id="ztc_remark" value="<?php echo $output['ztc_info']['ztc_remark'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_addtime']; ?> <!-- 添加时间 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" id="ztc_membername" value="<?php echo date('Y-m-d',$output['ztc_info']['ztc_addtime']);?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="ztc_paystate"><?php echo $lang['admin_ztc_paystate']; ?><!-- 支付状态 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" id="ztc_paystate" value="<?php //echo $output['ztc_info']['ztc_paystate']==1?'已经支付':'未支付';
					echo $output['ztc_info']['ztc_paystate']==1?$lang['admin_ztc_paysuccess']:$lang['admin_ztc_waitpaying'];
				?>" readonly /></td><td class="vatop tips"></td>
        </tr>
        <?php if ($output['ztc_info']['ztc_type'] == 0){?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_starttime']; ?><!-- 开始时间 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="ztc_stime" id="ztc_stime" type="text" class="txt date" value="<?php echo date('Y-m-d',$output['ztc_info']['ztc_startdate']);?>"/>
            <input name="ztc_nowdate" id="ztc_nowdate" type="hidden" value="<?php echo $output['nowdate'];?>"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_auditstate'];?><!-- 审核状态 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="radio" name="ztc_state" value='0' <?php if ($output['ztc_info']['ztc_state'] == 0){ echo 'checked'; }?>/>
                <?php echo $lang['admin_ztc_auditing']; ?><!-- 未审核 --></li>
              <li>
                <input type="radio" name="ztc_state" value='1' <?php if ($output['ztc_info']['ztc_state'] == 1){ echo 'checked'; }?>/>
                <?php echo $lang['admin_ztc_auditpass']; ?><!-- 审核通过 --></li>
              <li>
                <input type="radio" name="ztc_state" value='2' <?php if ($output['ztc_info']['ztc_state'] == 2){ echo 'checked'; }?>/>
                <?php echo $lang['admin_ztc_auditnopass']; ?><!-- 审核失败 --></li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
      </tbody>
      <tbody>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" onclick="document.ztc_form.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
          </tfoot>
        
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script>
$(function(){
	$('#ztc_stime').datepicker({dateFormat: 'yy-mm-dd'});
	
	/*jQuery.validator.addMethod("greater", function(value, element, param) {
		var comparetext = $.trim($(param).val());
		//申请类型
		var t = '<?php echo $output['ztc_info']['ztc_type'];?>';
		if(t == '0'){
			if(value == ''){return false;}else{
				if(value && comparetext){return comparetext <= value;}else{return true;}
			}
		}else{ return true;}
	}, "<?php echo $lang['admin_ztc_edit_starttime_error'];?>");
	
	$('#ztc_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
            ztc_stime : {
            	greater   : "#ztc_nowdate"
            }
        },
        messages : {
        	ztc_stime       : {
        		greater    : '<?php echo $lang['admin_ztc_edit_starttime_error']; ?>'
        	}
        }
    });*/
});


</script> 
