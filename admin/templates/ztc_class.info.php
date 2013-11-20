<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_ztc_manage'];?><!-- 直通车管理 --></h3>
      <ul class="tab-base">
      	<li><a href="index.php?act=ztc_class&op=ztc_setting"><span><?php echo $lang['nc_config'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_ztc_list_title'];?><!-- 申请列表 --></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glist"><span><?php echo $lang['admin_ztc_goodslist_title']; //'商品列表'?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glog"><span><?php echo $lang['admin_ztc_loglist_title']; //'金币日志';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- <form id="ztc_form" method="post" action="index.php?act=ztc_class&op=edit_ztc&z_id=<?php echo $output['ztc_info']['ztc_id']; ?>"> -->
  <form id="ztc_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_applytype']; ?><!-- 申请类型 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo $output['ztc_info']['ztc_type'] == 1? $lang['admin_ztc_rechargerecord']:$lang['admin_ztc_applyrecord'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_membername']; ?><!-- 会员名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo $output['ztc_info']['ztc_membername'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_storename']; ?><!-- 店铺名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo $output['ztc_info']['ztc_storename'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_goodsname']; ?><!-- 商品名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo $output['ztc_info']['ztc_goodsname'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_edit_costgold']; ?><!-- 消耗金币 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo $output['ztc_info']['ztc_gold'];?> <?php echo $lang['admin_ztc_goldunit']; ?>" readonly />
            
            <!-- 枚 --></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_edit_remark']; ?><!-- 备注信息 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea rows="6" readonly="readonly" class="readonly tarea"><?php echo $output['ztc_info']['ztc_remark'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_addtime']; ?> <!-- 添加时间 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo date('Y-m-d',$output['ztc_info']['ztc_addtime']);?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_paystate']; ?><!-- 支付状态 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo $output['ztc_info']['ztc_paystate']==1?$lang['admin_ztc_paysuccess']:$lang['admin_ztc_waitpaying'];?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if ($output['ztc_info']['ztc_type'] == 0){?>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_starttime']; ?><!-- 开始时间 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php echo date('Y-m-d',$output['ztc_info']['ztc_startdate']);?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_ztc_auditstate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="readonly txt" value="<?php if ($output['ztc_info']['ztc_state'] == 0){ echo $lang['admin_ztc_auditing'];}?>
            <?php if ($output['ztc_info']['ztc_state'] == 1){ echo $lang['admin_ztc_auditpass'];}?>
            <?php if ($output['ztc_info']['ztc_state'] == 2){ echo $lang['admin_ztc_auditnopass'];}?>" readonly /></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" onclick="window.location.href= 'index.php?act=ztc_class&op=ztc_class'"><span><?php echo $lang['admin_ztc_index_backlist'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
