<?php
require_once(BasePath.DS.'api'.DS.'snsapi'.DS.'qqzone'.DS.'comm'.DS.'config.php');
require_once(BasePath.DS.'api'.DS.'snsapi'.DS.'qqzone'.DS.'comm'.DS.'utils.php');

function get_user_info()
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['qqzone']['access_token']
        . "&oauth_consumer_key=" . $_SESSION['qqzone']["appid"]
        . "&openid=" . $_SESSION['qqzone']["openid"]
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

/*//获取用户基本资料
$arr = get_user_info();
//print_r($arr);

echo "<p>";
echo "Gender:".$arr["gender"];
echo "</p>";
echo "<p>";
echo "NickName:".$arr["nickname"];
echo "</p>";
echo "<p>";
echo "<img src=\"".$arr['figureurl']."\">";
echo "<p>";
echo "<p>";
echo "<img src=\"".$arr['figureurl_1']."\">";
echo "<p>";
echo "<p>";
echo "<img src=\"".$arr['figureurl_2']."\">";
echo "<p>";*/

?>
