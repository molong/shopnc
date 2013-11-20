<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo ($lang['nc_member_path_'.$output['menu_sign']]==''?'':$lang['nc_member_path_'.$output['menu_sign']].'_').$output['html_title'];?></title>
<meta name="keywords" content="<?php echo C('site_keywords'); ?>" />
<meta name="description" content="<?php echo C('site_description'); ?>" />
<meta name="author" content="ShopNC">
<meta name="copyright" content="ShopNC Inc. All Rights Reserved">
<link href="<?php echo TEMPLATES_PATH;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/member.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/member_user.css" rel="stylesheet" type="text/css">
<!--[if IE 6]><style type="text/css">
body {_behavior: url(<?php echo TEMPLATES_PATH;?>/css/csshover.htc);}
</style>
<![endif]-->
<script>
COOKIE_PRE = '<?php echo COOKIE_PRE;?>';_CHARSET = '<?php echo strtolower(CHARSET);?>';SITEURL = '<?php echo SiteUrl;?>';
</script>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_PATH;?>/js/member.js" charset="utf-8"></script>

<!--[if IE]>
<script src="<?php echo RESOURCE_PATH;?>/js/html5.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo RESOURCE_PATH;?>/js/IE6_PNG.js"></script>
<script>
DD_belatedPNG.fix('.pngFix');
</script>
<script> 
// <![CDATA[ 
if((window.navigator.appName.toUpperCase().indexOf("MICROSOFT")>=0)&&(document.execCommand)) 
try{ 
document.execCommand("BackgroundImageCache", false, true); 
   } 
catch(e){} 
// ]]> 
</script> 
<![endif]-->

</head>
<body>
<?php require_once template('layout/layout_top');?>
<header id="header" class="pngFix">
  <div class="wrapper">
    <h1 id="logo" title="<?php echo C('site_name'); ?>"><a href="<?php echo SiteUrl;?>"><img src="<?php echo C('member_logo') == ''?ATTACH_COMMON.DS.C('site_logo'):ATTACH_COMMON.DS.C('member_logo'); ?>" alt="<?php echo C('site_name'); ?>" class="pngFix"></a></h1>
    <nav>
      <ul>
        <li class="frist"><a <?php if($output['header_menu_sign'] == 'snsindex'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=member_snsindex" title="<?php echo $lang['nc_member_path_buyerindex'];?>"><?php echo $lang['nc_member_path_buyerindex'];?></a></li>
        <li><a <?php if($output['header_menu_sign'] == 'snshome'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=member_snshome" title="<?php echo $lang['nc_member_path_myspace'];?>"><?php echo $lang['nc_member_path_myspace'];?></a></li>
        <li><a <?php if($output['header_menu_sign'] == 'friend'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=member_snsfriend&op=find" title="<?php echo $lang['nc_member_path_friend'];?>"><?php echo $lang['nc_member_path_friend'];?></a></li>
        <li><a <?php if($output['header_menu_sign'] == 'message'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=home&op=message" title="<?php echo $lang['nc_member_path_message'];?>"><?php echo $lang['nc_member_path_message'];?>
        	<?php if (intval($output['message_num']) > 0){ ?>
        	<i class="new-message"><?php echo intval($output['message_num']); ?></i>
        	<?php }?></a></li>
        <li><a <?php if($output['header_menu_sign'] == 'setting'){ echo "class='active'";}else{ echo "class='normal'";}?> href="index.php?act=home&op=member" title="<?php echo $lang['nc_member_path_setting'];?>"><?php echo $lang['nc_member_path_setting'];?></a></li>
      </ul>
      <div class="search-box">
        <form method="get" action="index.php" onSubmit="return searchInput();">
          <input name="act" id="search_act" value="search" type="hidden">
          <input name="keyword" id="keyword" type="text" class="text"  placeholder="<?php echo $lang['nc_searchdefault']; ?>" maxlength="200"/>
          <input name="" type="submit" value="" class="submit pngFix">
        </form>
      </div>
    </nav>
  </div>
</header>
<div id="container" class="wrapper">
  <div class="layout">
    <div class="sidebar">
    <div class="member-handle"><h3><?php echo $lang['nc_member_path_accountsettings'];?></h3>
      <ul>
        <li <?php if($output['menu_sign'] == 'profile'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=home&op=member"><?php echo $lang['nc_member_path_profile'];?></a></li>
        <li <?php if($output['menu_sign'] == 'address'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=member&op=address"><?php echo $lang['nc_member_path_address'];?></a></li>
        <?php if (C('qq_isuse') == 1){?>
        <li <?php if($output['menu_sign'] == 'qq_bind'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=member_qqconnect&op=qqbind"><?php echo $lang['nc_member_path_qq_bind'];?></a></li>
        <?php }?>
        <?php if (C('sina_isuse') == 1){?>
        <li <?php if($output['menu_sign'] == 'sina_bind'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=member_sconnect&op=sinabind"><?php echo $lang['nc_member_path_sina_bind'];?></a></li>
        <?php }?>
        <?php if (C('predeposit_isuse') == 1){ ?>
        <li <?php if($output['menu_sign'] == 'predepositrecharge'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=predeposit"><?php echo $lang['nc_member_path_predepositrecharge'];?></a></li>
        <li <?php if($output['menu_sign'] == 'predepositcash'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=predeposit&op=predepositcash"><?php echo $lang['nc_member_path_predepositcash'];?></a></li>
        <li <?php if($output['menu_sign'] == 'predepositlog'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=predeposit&op=predepositlog"><?php echo $lang['nc_member_path_predepositlog'];?></a></li>
        <?php }?>
        <?php if (C('share_isuse') == 1){ ?>
        <li <?php if($output['menu_sign'] == 'sharemanage'){ echo "class='active'";}else{ echo "class='normal'";}?>><a href="index.php?act=member_sharemanage"><?php echo $lang['nc_member_path_sharemanage'];?></a></li>
        <?php }?>
      </ul></div>
    </div>
    <div class="right-content">
      <div class="path">
        <div><a href="index.php?act=member_snsindex"><?php echo $lang['nc_user_center'];?></a><span>&raquo;</span>
          <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
          <a href="<?php echo $output['menu_sign_url'];?>"/>
          <?php }?>
          <?php echo $lang['nc_member_path_'.$output['menu_sign']];?>
          <?php if($output['menu_sign_url'] != '' and $lang['nc_member_path_'.$output['menu_sign1']] != ''){?>
          </a><span>&raquo;</span><?php echo $lang['nc_member_path_'.$output['menu_sign1']];?>
          <?php }?>
        </div>
      </div>
      <div class="main">
        <?php
		require_once($tpl_file);
		?>
      </div>
    </div>
  </div>
</div>
<?php require_once template('footer'); ?>
</body>
</html>
