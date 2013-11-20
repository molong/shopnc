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
  <form method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok"/>
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_sn']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_sn']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_membername']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_membername']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_payment'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['payment_info']['payment_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <!-- 显示线上支付的交易流水号 -->
        <?php if (trim($output['info']['pdr_onlinecode']) !='' && intval($output['payment_info']['payment_online']) == 1){?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_recharge_onlinecode'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_onlinecode']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_recharge_price'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_price']; ?><?php echo $lang['currency_zh'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if ($output['info']['pdr_payment'] == 'offline'){?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_recharge_huikuanname'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_remittancename']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_recharge_huikuanbank'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_remittancebank']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_recharge_huikuandate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo @date('Y-m-d',$output['info']['pdr_remittancedate']); ?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_addtime']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo @date('Y-m-d',$output['info']['pdr_addtime']); ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_memberremark'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_memberremark'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_paystate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php if (intval($output['payment_info']['payment_online']) === 0){//线下支付方式 ?>
            <?php if (is_array($output['rechargepaystate']) && count($output['rechargepaystate'])>0){?>
            <?php foreach ($output['rechargepaystate'] as $k=>$v){?>
            <input type="radio" name="paystate" class="paystateclass" value="<?php echo $k;?>" <?php echo $k == $output['info']['pdr_paystate']? "checked=checked":'';?>/>
            &nbsp;<?php echo $v;?>
            <?php }?>
            <?php }?>
            <?php } else {
						 //线上支付方式 
						 echo $output['rechargepaystate'][$output['info']['pdr_paystate']]; } ?>
            <input type="hidden" id="paystate_hidden" name="paystate_hidden" value="<?php echo $output['info']['pdr_paystate']; ?>"/></td>
          <td class="vatop tips"></td>
        </tr>
        <!-- 显示管理员名称 -->
        <?php if (trim($output['info']['pdr_adminname']) != ''){ ?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_adminname'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['pdr_adminname']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_adminremark'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="admin_remark" rows="6" class="tarea"><?php echo $output['info']['pdr_adminremark'];?></textarea></td>
          <td class="vatop tips"><?php echo $lang['admin_predeposit_recharge_notice'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(function(){
	$('[name="paystate"]').change(function(){
	var paystate = $('input[name="paystate"]:checked').val();
	$("#paystate_hidden").val(paystate);
	});
});
</script>