<?php
/**
 * 闲置市场闲置信息页面电话号码
 */
$pnum = $_GET['pnum'];
$im = imagecreate(120, 16);
$bg = imagecolorallocate($im, 247, 247, 247);
$textcolor = imagecolorallocate($im, 101, 101, 101);
imagestring($im, 5, 0, 0, $pnum, $textcolor);
header("Content-type: image/png");
imagepng($im);
