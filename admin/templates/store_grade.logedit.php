<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_audit" ><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['grade_apply']; ?></span></a></li>
        <li><a href="index.php?act=store&op=store_auth" ><span><?php echo $lang['store_auth_verify'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="ztc_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_storename']; ?><!-- 店铺名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['log_info']['gl_shopname'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_membername']; ?><!-- 会员名称 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['log_info']['gl_membername'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_gradename']; ?><!-- 等级 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['log_info']['gl_sgname'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['grade_sortname']; ?><!-- 级别 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['log_info']['gl_sgsort'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_needcheck']; ?><!-- 需要审核 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['log_info']['gl_sgconfirm'] == 1? $lang['nc_yes'] : $lang['nc_no'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_addtime']; ?><!-- 添加时间 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo date('Y-m-d',$output['log_info']['gl_addtime']);?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_auditstate']; ?><!-- 审核状态 -->:</label></td>
        </tr>
        <tr class="noborder">
          <?php if ( $output['log_info']['gl_allowstate'] == 0 ){//只有一次审核机会，审核之后不可再次点击审核操作?>
          <td class="vatop rowform">
            <input type="radio" name="gl_state" value='0' <?php if ($output['log_info']['gl_allowstate'] == 0){ echo 'checked'; }?>/>
            <?php echo $lang['admin_gradelog_auditing']; ?><!-- 等待审核 -->
            
            <input type="radio" name="gl_state" value='1' <?php if ($output['log_info']['gl_allowstate'] == 1){ echo 'checked'; }?>/>
            <?php echo $lang['admin_gradelog_auditpass']; ?><!-- 通过审核 -->
            
            <input type="radio" name="gl_state" value='2' <?php if ($output['log_info']['gl_allowstate'] == 2){ echo 'checked'; }?>/>
            <?php echo $lang['admin_gradelog_auditnopass']; ?><!-- 审核失败 --> 
            &nbsp;&nbsp;&nbsp;&nbsp;
            </td>
          	<td class="vatop tips"><?php echo $lang['admin_gradelog_audittip']; //注：审核操作只能进行一次?></td>
            <?php }else {?>
            <td class="vatop rowform">
            <?php 
						switch ($output['log_info']['gl_allowstate']){
							case 1:
								echo $lang['admin_gradelog_auditpass'];
								break;
							case 2:
								echo $lang['admin_gradelog_auditnopass'];
								break;
						} ?>
			</td>
			<td class="vatop tips"></td>
			<?php } ?>
        </tr>
      </tbody>
    </table>
    <?php if ( $output['log_info']['gl_allowstate'] == 0 ){//只有一次审核机会，审核之后不可再次点击审核操作?>
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_remark']; ?><!-- 备注 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea rows="6" class="tarea" name="remark"></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><input class="btn btn-green big" name="submit" value="<?php echo $lang['nc_submit'];?>" type="submit"></td>
        </tr>
      </tfoot>
    </table>
    <?php } else {?>
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_auditadmin']; ?><!-- 审核人员 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['log_info']['gl_allowadminname'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_gradelog_remark']; ?><!-- 备注 -->:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['log_info']['gl_allowremark'];?></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><input type="reset" onclick="window.location.href = 'index.php?act=store_grade&op=store_grade_log'" class="btn big" name="reset" value="<?php echo $lang['nc_backlist']; ?>"></td>
        </tr>
        <?php }?>
      </tfoot>
    </table>
  </form>
</div>
