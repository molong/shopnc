<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
<div class="tabmenu">
  <?php include template('member/member_submenu');?>
</div>
<form method="post" enctype="multipart/form-data" id="profile_form" action="index.php?act=home&op=avatar">
  <input type="hidden" name="form_submit" value="ok" />
  <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_info']['member_avatar']; ?>" />
  <div class="ncu-form-style">
    <dl><dd><img src="<?php if ($output['member_info']['member_avatar']!='') { echo ATTACH_AVATAR.DS.$output['member_info']['member_avatar']; } else { echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_user_portrait']; } ?>" width="120" height="120" alt="" nc_type="avatar" /></dd>
    </dl>
    <dl>
      <dd><?php echo $output['avatarflash']; ?> </dd>
    </dl>
  </div>
</form>
<script type="text/javascript">
function updateavatar() {
window.location='index.php?act=home&op=avatar&avatar=1';
}
</script> 
