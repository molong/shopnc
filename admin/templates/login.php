<?php defined('InShopNC') or exit('Access Invalid!');?>

<div id="loginBox">
  <form method="post" id="form_login">
    <?php Security::getToken();?>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="SiteUrl" id="SiteUrl" value="<?php echo SiteUrl;?>" />
    <div class="username">
      <h5><?php echo $lang['login_index_username'];?>:</h5>
      <input class="text" id="user_name" name="user_name" autocomplete="off" type="text" style="width:300px;">
    </div>
    <div class="password">
      <h5><?php echo $lang['login_index_password'];?>:</h5>
      <input class="text" name="password" id="password" autocomplete="off"  type="password" style="width:300px;">
    </div>
    <div class="code">
      <h5><?php echo $lang['login_index_checkcode'];?>:</h5>
      <input class="text" name="captcha" id="captcha" autocomplete="off"  type="text" style="width:120px;"><span><a href="JavaScript:void(0);" onclick="javascript:document.getElementById('codeimage').src='../index.php?act=seccode&op=makecode&admin=1&nchash=<?php echo $output['nchash'];?>&t=' + Math.random();"> <img src="../index.php?act=seccode&op=makecode&admin=1&nchash=<?php echo $output['nchash'];?>" title="<?php echo $lang['login_index_change_checkcode'];?>" name="codeimage" border="0" id="codeimage" onclick="this.src='../index.php?act=seccode&op=makecode&admin=1&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()" /></a></span>
    </div>
    <div class="button">
    <input name="nchash" type="hidden" value="<?php echo $output['nchash'];?>" />
      <input class="btnEnter" value="" type="submit">
    </div>
    <div class="back"><a href="<?php echo SiteUrl;?>" target="_blank"><?php echo $lang['login_index_back_to_homepage'];?></a></div>
  </form>
</div>
<script>
$(document).ready(function(){
	if(top.location!=this.location)	top.location=this.location;//跳出框架在主窗口登录
	$('#user_name').focus();
	if ($.browser.msie && $.browser.version=="6.0"){
		window.location.href='templates/ie6update.html';
	}
});
</script>