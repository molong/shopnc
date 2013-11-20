<?php
session_start();
//判断是否已经登录
if(isset($_SESSION['slast_key'])) 
{
	@header("Location:".SiteUrl."/index.php");
	exit;
}
include_once(BasePath.DS.'api'.DS.'sina'.DS.'config.php' );
include_once(BasePath.DS.'api'.DS.'sina'.DS.'saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );
@header("location:$code_url");
exit;
?>