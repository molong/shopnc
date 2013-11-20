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
<link href="<?php echo TEMPLATES_PATH;?>/css/sns_store.css" rel="stylesheet" type="text/css">
<!--[if IE 6]><style type="text/css">
body {_behavior: url(<?php echo TEMPLATES_PATH;?>/css/csshover.htc);}
</style>
<![endif]-->
<script type="text/javascript">
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var SITEURL = '<?php echo SiteUrl;?>';var MAX_RECORDNUM = <?php echo $output['max_recordnum'];?>;
</script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.charCount.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/utils.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/sns.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/sns_store.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/smilies/smilies_data.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/smilies/smilies.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.caretInsert.js" charset="utf-8"></script>
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
    <h1 id="logo" title="<?php echo C('site_name'); ?>"><a href="<?php echo SiteUrl;?>"><img src="<?php echo ATTACH_COMMON.DS.C('site_logo'); ?>" alt="<?php echo C('site_name'); ?>" class="pngFix"></a></h1>
  </div>
</header>
<div id="container" class="ssns-layout-bg">
  <div class="ssns-layout">
    <div class="sidebar">
      <div class="keynote">
        <h3><?php echo $lang['store_sns_popularity'].$lang['nc_colon'].$output['store_info']['store_collect'];?></h3>
      </div>
      <div class="store-intro">
        <h3><?php echo $lang['nc_store_information'];?></h3>
        <dl>
          <dt><?php echo $lang['nc_srore_location'];?></dt>
          <dd><?php echo $output['store_info']['area_info'];?></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_sns_contact_number'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['store_info']['store_tel'];?></dd>
        </dl>
        <dl class="tc">
          <a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']),'store',$output['store_info']['store_domain']);?>" class="btn"><?php echo $lang['store_sns_enter_the_store'];?></a>
        </dl>
        <dl>
          <dt><?php echo $lang['store_sns_shopkeeper'].$lang['nc_colon']?></dt>
          <dd><?php echo $output['store_info']['member_name'];?><a href="index.php?act=home&op=sendmsg&member_id=<?php echo $output['store_info']['member_id'];?>" class="message" title="<?php echo $lang['store_sns_message'];?>">&nbsp;</a>
             <?php if(!empty($output['store_info']['store_qq'])){?>
               <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $output['store_info']['store_qq'];?>&amp;Site=<?php echo $output['store_info']['store_qq'];?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>}:45" alt="<?php echo $lang['nc_message_me'];?>"></a>
             <?php }?>
             <?php if(!empty($output['store_info']['store_ww'])){?>
               <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>"/></a>
             <?php }?>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['nc_goods_amount'];?></dt>
          <dd><?php echo $output['store_info']['goods_count'];?></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_sns_main_operate'].$lang['nc_colon'];?></dt>
          <dd><?php echo $output['store_info']['store_zy'];?></dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_sns_share'].$lang['nc_colon'];?></dt>
          <dd><a nc_type="sharestore" data-param='{"sid":"<?php echo $output['store_info']['store_id'];?>"}' href="javascript:void(0);"><?php echo $lang['store_sns_share_store'];?></a></dd>
        </dl>
      </div>
    </div>
    <div class="left-content">
      <div class="store-info">
        <div class="picture"><span class="thumb size160"><i></i><img src="<?php if(empty($output['store_info']['store_logo'])){echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_store_logo'];}else{echo $output['store_info']['store_logo'];}?>" onload="javascript:DrawImage(this,160,160);" /></span></div>
        <dl class="store-name">
          <dt>
            <h2><?php echo $output['store_info']['store_name'];?></h2>
            <span>
              <a class="btn" href="javascript:collect_store('<?php echo $output['store_info']['store_id'];?>','count','store_collect')"><?php echo $lang['store_sns_will_collect'];?></a>
            </span>
          </dt>
          <dd>
          <span id="sCopyContent">
          <?php 
          	if($output['subdomain']==1 && $output['store_info']['store_domain'] != ''){
                echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store', $output['store_info']['store_domain']);
            }else{
                echo SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store', $output['store_info']['store_domain']);
            }?>
          </span>
          	<a href="javascript:void(0);" id="sCopy"><?php echo $lang['store_sns_copy'];?></a>
          </dd>
        </dl>
        <div class="info-text"><?php if($output['store_info']['store_description'] != ''){ echo $output['store_info']['store_description'];}else{echo $lang['store_sns_introduce_is_null']; }?></div>
      </div>
      <div class="store-sns-tab">
        <ul>
          <li><a href="index.php?act=store_snshome&sid=<?php echo $output['store_info']['store_id'];?>" <?php if($_GET['type'] == ''){?>class="selected"<?php }?>><?php echo $lang['store_sns_all_trends'];?></a></li>
          <li><a href="index.php?act=store_snshome&sid=<?php echo $output['store_info']['store_id'];?>&type=promotion" <?php if($_GET['type'] == 'promotion'){?>class="selected"<?php }?>><?php echo $lang['store_sns_sales_promotion'];?></a></li>
          <li><a href="index.php?act=store_snshome&sid=<?php echo $output['store_info']['store_id'];?>&type=new" <?php if($_GET['type'] == 'new'){?>class="selected"<?php }?>><?php echo $lang['store_sns_new_goods'];?></a></li>
          <li><a href="index.php?act=store_snshome&sid=<?php echo $output['store_info']['store_id'];?>&type=hotsell" <?php if($_GET['type'] == 'hotsell'){?>class="selected"<?php }?>><?php echo $lang['store_sns_hot_sale'];?></a></li>
          <li><a href="index.php?act=store_snshome&sid=<?php echo $output['store_info']['store_id'];?>&type=recommend" <?php if($_GET['type'] == 'recommend'){?>class="selected"<?php }?>><?php echo $lang['store_sns_recommended'];?></a></li>
        </ul>
      </div>
      <div class="main">
        <?php
		require_once($tpl_file);
		?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<?php
require_once template('footer');
?>
<script type="text/javascript" language="javascript">
$(function(){	
	$('#sCopy').click(function() {
        var copyContent = $("#sCopyContent").html();
        copyToClipBoard(copyContent);
    });
});

//复制到剪切板js代码
function copyToClipBoard(s) {
  //alert(s);
  if (window.clipboardData) {
      window.clipboardData.setData("Text", s);
      alert("<?php echo $lang['store_sns_has_not_copied'];?>"+ "\n" + s);
  } else if (navigator.userAgent.indexOf("Opera") != -1) {
      window.location = s;
  } else {
      alert("<?php echo $lang['store_sns_copy_error'];?>");
  }
}
</script>
</body>
</html>
