<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_set'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=setting&op=base_information"><span><?php echo $lang['basic_info'];?></span></a></li>
        <li><a href="index.php?act=setting&op=captcha_setting"><span><?php echo $lang['manage_about'];?></span></a></li>
        <li><a href="index.php?act=setting&op=creditgrade"><span><?php echo $lang['setting_store_creditrule'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['ucenter_integration'];?></span></a></li>
        <li><a href="index.php?act=setting&op=qq_setting"><span><?php echo $lang['qqSettings'];?></span></a></li>
        <li><a href="index.php?act=setting&op=sina_setting"><span><?php echo $lang['sinaSettings'];?></span></a></li>
        <li><a href="index.php?act=setting&op=login_setting"><span><?php echo $lang['loginSettings'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['ucenter_integration'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="ucenter_status1" class="cb-enable <?php if($output['list_setting']['ucenter_status'] == '1'){ ?>selected<?php } ?>"><span><?php echo $lang['ztc_isuse_open'];?></span></label>
            <label for="ucenter_status0" class="cb-disable <?php if($output['list_setting']['ucenter_status'] == '0'){ ?>selected<?php } ?>"><span><?php echo $lang['ztc_isuse_close'];?></span></label>
            <input type="radio" id="ucenter_status1" name="ucenter_status" value="1" <?php echo $output['list_setting']['ucenter_status']==1?'checked=checked':''; ?>>
            <input type="radio" id="ucenter_status0" name="ucenter_status" value="0" <?php echo $output['list_setting']['ucenter_status']==0?'checked=checked':''; ?>>
            &nbsp;&nbsp; <a href="http://bbs.shopnc.net/viewthread.php?tid=8663&extra=page%3D1" target="_blank"><?php echo $lang['ucenter_help_url']; ?></a></td>
          <td class="vatop tips">&nbsp;</td>
        </tr>
        <tr class="member_clear">
          <td colspan="2" class="required"><?php echo $lang['user_info_del'];?>:</td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><a href="JavaScript:void(0);" onclick="javascript:if(confirm('<?php echo $lang['user_info_clear'];?>'))window.location ='index.php?act=setting&op=member_clear';" class="btns tooltip" title="<?php echo $lang['click_clear'];?>"><span><?php echo $lang['click_clear'];?></span></a> &nbsp;<?php echo $lang['first_integration'];?>&nbsp; <a href="JavaScript:void(0);" onclick="javascript:window.location ='index.php?act=db&op=db';" class="btns tooltip" title="<?php echo $lang['click_bak'];?>"><span><?php echo $lang['click_bak'];?></span></a></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ucenter_app_id"><?php echo $lang['ucenter_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <ul class="nofloat">
              <li>
                <input id="ucenter_type_dx" name="ucenter_type" <?php if($output['list_setting']['ucenter_type'] != 'phpwind'){ ?>checked="checked"<?php } ?> value="discuz" type="radio">
                <label for="ucenter_type_dx"><?php echo $lang['ucenter_uc_discuz'];?></label>
              </li>
              <li>
                <input id="ucenter_type_pw" name="ucenter_type" <?php if($output['list_setting']['ucenter_type'] == 'phpwind'){ ?>checked="checked"<?php } ?> value="phpwind" type="radio">
                <label for="ucenter_type_pw"><?php echo $lang['ucenter_uc_phpwind'];?></label>
              </li>
            </ul>
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ucenter_app_id"><?php echo $lang['ucenter_application_id'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_app_id" name="ucenter_app_id" value="<?php echo $output['list_setting']['ucenter_app_id'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_application_id_tips']?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="ucenter_url"><?php echo $lang['ucenter_address'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_url" name="ucenter_url" value="<?php echo $output['list_setting']['ucenter_url'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_address_tips']?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['ucenter_key'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_app_key" name="ucenter_app_key" value="<?php echo $output['list_setting']['ucenter_app_key'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['ucenter_ip'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_ip" name="ucenter_ip" value="<?php echo $output['list_setting']['ucenter_ip'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_ip_tips']?></td>
        </tr>
        <tr class="db_type">
          <td colspan="2" class="required"><label for="ucenter_mysql_server"><?php echo $lang['ucenter_mysql_server'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_mysql_server" name="ucenter_mysql_server" value="<?php echo $output['list_setting']['ucenter_mysql_server'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_mysql_server_tips']?></td>
        </tr>
        <tr class="db_type">
          <td colspan="2" class="required"><label for="ucenter_mysql_username"><?php echo $lang['ucenter_mysql_username'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_mysql_username" name="ucenter_mysql_username" value="<?php echo $output['list_setting']['ucenter_mysql_username'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_mysql_username_tips']?></td>
        </tr>
        <tr class="db_type">
          <td colspan="2" class="required"><label for="ucenter_mysql_passwd"><?php echo $lang['ucenter_mysql_passwd'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_mysql_passwd" name="ucenter_mysql_passwd" value="<?php echo $output['list_setting']['ucenter_mysql_passwd'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_mysql_passwd_tips']?></td>
        </tr>
        <tr class="db_type">
          <td colspan="2" class="required"><label for="ucenter_mysql_name"><?php echo $lang['ucenter_mysql_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_mysql_name" name="ucenter_mysql_name" value="<?php echo $output['list_setting']['ucenter_mysql_name'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_mysql_name_tips']?></td>
        </tr>
        <tr class="db_type">
          <td colspan="2" class="required"><label for="ucenter_mysql_pre"><?php echo $lang['ucenter_mysql_pre'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ucenter_mysql_pre" name="ucenter_mysql_pre" value="<?php echo $output['list_setting']['ucenter_mysql_pre'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['ucenter_mysql_pre_tips']?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" >
          <input type="hidden" name="ucenter_connect_type" value="0" />
          <a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script language="javascript">
function change_type(type) {
	if(type == 1) {
		$(".db_type").css("display","none");
	} else {
		$(".db_type").css("display","");
	}
}
<?php
if($output['list_setting']['ucenter_connect_type'] == '1') {
?>
change_type(1);
<?php
}
?>
</script>