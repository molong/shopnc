<?php
require_once (BasePath.DS.'api'.DS.'snsapi'.DS.'renren'.DS.'class'.DS.'config.inc.php');
require_once (BasePath.DS.'api'.DS.'snsapi'.DS.'renren'.DS.'class'.DS.'RenrenOAuthApiService.class.php');
require_once (BasePath.DS.'api'.DS.'snsapi'.DS.'renren'.DS.'class'.DS.'RenrenRestApiService.class.php');

$code = $_GET["code"];
if($code)
{
	//获取accesstoken
	$oauthApi = new RenrenOAuthApiService;
	$post_params = array('client_id'=>$configrenren->APIKey,
		'client_secret'=>$configrenren->SecretKey,
		'redirect_uri'=>$configrenren->redirecturi,
		'grant_type'=>'authorization_code',
		'code'=>$code
	);
	$token_url='http://graph.renren.com/oauth/token';
	//$access_info=$oauthApi->rr_post_curl($token_url,$post_params);//使用code换取token
	$access_info=$oauthApi->rr_post_fopen($token_url,$post_params);//如果你的环境无法支持curl函数，可以用基于fopen函数的该函数发送请求
	$_SESSION['renren']["access_token"]	=$access_info["access_token"];
	$_SESSION['renren']["expires_in"]		=$access_info["expires_in"];
	$_SESSION['renren']["refresh_token"]	=$access_info["refresh_token"];
	$_SESSION['renren']["uid"]		=$access_info["user"]['id'];
	$_SESSION['renren']["uname"]	=$access_info["user"]['name'];
	
	//刷新代码：
	/*//用refreshtoken刷新accesstoken（在同步新鲜事的时候取出对应网站用户的人人accesstoken，如果用当前时间的秒数-expires_in>获取token的时间的秒数,则accesstoken过期，用refreshtoken刷新accesstoken）
	$post_params = array('client_id'=>$configrenren->APIKey,
		'client_secret'=>$configrenren->SecretKey,
		'refresh_token'=>$refresh_token,
		'grant_type'=>'refresh_token'
	);
	//$access_info=$oauthApi->rr_post_curl($token_url,$post_params);//使用code换取token
	$access_info=$oauthApi->rr_post_fopen($token_url,$post_params);//如果你的环境无法支持curl函数，可以用基于fopen函数的该函数发送请求
	$access_token=$access_info["access_token"];
	$expires_in=$access_info["expires_in"];
	$refresh_token=$access_info["refresh_token"];*/
}
else
{
	//如果获取不到code，将错误信息打出来
	echo "<script>alert('授权失败。');</script>";
	echo "<script>window.close();</script>";
	exit;
}
?>