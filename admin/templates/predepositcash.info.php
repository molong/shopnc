<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_predepositmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=predeposit&op=predeposit"><span><?php echo $lang['admin_predeposit_rechargelist']?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_predeposit_cashmanage']; ?></span></a></li>
        <li><a href="index.php?act=predeposit&op=artificial"><span><?php echo $lang['admin_predeposit_artificial'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2 nobdb">
    <tbody>
      <tr class="noborder">
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_sn'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_sn']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_membername'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_membername']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_payment'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['payment_info']['payment_name']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_price'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_price']; ?>&nbsp;<?php echo $lang['currency_zh'];?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php if ($output['info']['pdcash_payment'] == 'offline'){?>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_shoukuanname']?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_toname']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_shoukuanbank']; ?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_tobank']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_cash_shoukuanaccount'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_paymentaccount']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_addtime']; ?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo @date('Y-m-d',$output['info']['pdcash_addtime']); ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_memberremark'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_memberremark'];?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_paystate'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['cashpaystate'][$output['info']['pdcash_paystate']];?></td>
        <td class="vatop tips"></td>
      </tr>
      <!-- 显示管理员名称 -->
      <?php if (trim($output['info']['pdcash_adminname']) != ''){ ?>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_adminname'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_adminname']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php }?>
      <?php if (trim($output['info']['pdcash_adminremark']) != ''){ ?>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_adminremark']; ?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_adminremark'];?>
          &nbsp;<?php echo $lang['admin_predeposit_cash_remark_tip1'];?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php }?>
      <?php if (trim($output['info']['pdcash_remark']) != ''){ ?>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_remark'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['info']['pdcash_remark'];?>
          &nbsp;<?php echo $lang['admin_predeposit_cash_remark_tip2'];?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php }?>
    </tbody>
  
    <tfoot>
      <tr class="tfoot">
        <td colspan="15"><a href="JavaScript:void(0);" class="btn" onclick="window.location.href='index.php?act=predeposit&op=cashlist'"><span><?php echo $lang['admin_predeposit_backlist'];?></span></a></td>
      </tr>
    </tfoot>
  </table>
</div>
