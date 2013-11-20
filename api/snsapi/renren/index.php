<?php
require_once (BasePath.DS.'api'.DS.'snsapi'.DS.'renren'.DS.'class'.DS.'config.inc.php');
$url = "https://graph.renren.com/oauth/authorize?client_id={$configrenren->APPID}&response_type=code&scope={$configrenren->scope}"; 
$url.= "&redirect_uri=".urlencode($configrenren->redirecturi);
@header("location:$url");
exit;
?>