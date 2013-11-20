<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/ie6.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.tscookie.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js"></script>
<link href="<?php echo TEMPLATES_PATH;?>/css/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
require_once($tpl_file);
?>
</body>
</html>