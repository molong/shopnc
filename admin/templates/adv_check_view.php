<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=adv"><span><?php echo $lang['adv_manage'];?></span></a></li>
       <li><a href="index.php?act=adv&op=adv_check"><span><?php echo $lang['adv_wait_check']; ?></span></a></li>
        <li><a href="index.php?act=adv&op=adv_add"><span><?php echo $lang['adv_add'];?></span></a></li>
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=ap_add"><span><?php echo $lang['ap_add'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['check_adv_submit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2 nobdb" id="main_table">
    <tbody>
      <tr class="noborder">
        <td colspan="2" class="required"><label><?php echo $lang['adv_name'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['adv_list']['adv_title']; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['adv_ap_id'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $output['ap_info']['ap_name'];?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['adv_class'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php 
				 		 switch ($output['ap_info']['ap_class']){
				 		 	case '0':
				 		 		echo $lang['adv_pic'];
				 		 		break;
				 		 	case '1':
				 		 		echo $lang['adv_word'];
				 		 		break;
				 		 	case '2':
				 		 		echo $lang['adv_slide'];
				 		 		break;
				 		 }
			    ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['adv_start_time'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo date('Y-m-d',$output['adv_list']['adv_start_date']); ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['adv_end_time'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo date('Y-m-d',$output['adv_list']['adv_end_date']); ?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php 
			     if($output['adv_list']['buy_style'] != 'change'){
			     	$adv_content = $output['adv_list']['adv_content'];
				 }else{
				 	$cache_file = BasePath.DS.'cache'.DS.'adv_change'.DS.'adv_'.$output['adv_list']['adv_id'].'.change.php';
				 	include $cache_file;
				 	$adv_content = $content;
				 }	
				 		 switch ($output['ap_info']['ap_class']){			 		 		 		 	
				 		 	case '0':
				 		 		$pic_content = unserialize($adv_content);
		                        $pic         = $pic_content['adv_pic'];
		                        $url         = $pic_content['adv_pic_url'];
				 		 		?>
      <tr>
        <td><img src="<?php echo SiteUrl."/".ATTACH_ADV."/".$pic;?>" width="<?php echo $output['ap_info']['ap_width']>500?500:$output['ap_info']['ap_width'];?>"/>
          <input type="hidden" name="pic_ori" value="<?php echo $pic;?>"></td>
        <td></td>
      </tr>
      <tr id="adv_pic_url">
        <td colspan="2" class="required"><?php echo $lang['adv_url'];?>:</td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $url; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php
				 		 		break;
				 		 	case '1':
				 		$word_content = unserialize($adv_content);
						$word         = $word_content['adv_word'];
						$url          = $word_content['adv_word_url'];
				 		 		?>
      <tr id="adv_word">
        <td colspan="2" class="required"><?php echo $lang['adv_word_content'];?>:</td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $word; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <tr id="adv_word_url">
        <td colspan="2" class="required"><?php echo $lang['adv_url'];?>:</td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><label><?php echo $url; ?></label></td>
        <td class="vatop tips"></td>
      </tr>
      <?php 
				 		 		break;
				 		 	case '2':
				 		 		$pic_content = unserialize($adv_content);
						        $pic         = $pic_content['adv_slide_pic'];
						        $url         = $pic_content['adv_slide_url'];
				 		 		?>
      <tr>
        <td class="vatop rowform"><img src="<?php echo SiteUrl."/".ATTACH_ADV."/".$pic;?>" width="<?php echo $output['ap_info']['ap_width']>500?500:$output['ap_info']['ap_width'];?>"/>
          <input type="hidden" name="pic_ori" value="<?php echo $pic;?>"></td>
        <td class="vatop tips"></td>
      </tr>
      <tr id="adv_slide_url">
        <td colspan="2" class="required"><?php echo $lang['adv_url'];?>:</td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><?php echo $url; ?></td>
        <td class="vatop tips"></td>
      </tr>
      <?php 
				 		 		break;
                            case '3':
                            $flash_content = unserialize($adv_content);
		                    $flash         = $flash_content['flash_swf'];
		                    $url           = $flash_content['flash_url'];
		                    ?>
      <tr id="adv_flash_swf">
        <td colspan="2" class="required"><label><?php echo $lang['adv_flash_upload'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><input type="file" name="flash_swf" /></td>
        <td class="vatop tips"><?php echo $lang['adv_please_upload_swf_file']; ?></td>
      </tr>
      <tr>
        <td class="vatop rowform"><input type="hidden" name="flash_ori" value="<?php echo $flash;?>">
          <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $ap_v['ap_width']; ?>" height="<?php echo $output['ap_info']['ap_height']; ?>">
            <param name="movie" value="<?php echo SiteUrl."/".ATTACH_ADV."/".$flash;?>" />
            <param name="quality" value="high" />
            <param name="wmode" value="opaque" />
            <param name="swfversion" value="9.0.45.0" />
            <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
            <param name="expressinstall" value="<?php echo RESOURCE_PATH;?>/js/expressInstall.swf" />
            <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 --> 
            <!--[if !IE]>-->
            <object type="application/x-shockwave-flash" data="<?php echo SiteUrl."/".ATTACH_ADV."/".$flash;?>" width="<?php echo $output['ap_info']['ap_width']; ?>" height="<?php echo $output['ap_info']['ap_height']; ?>">
              <!--<![endif]-->
              <param name="quality" value="high" />
              <param name="wmode" value="opaque" />
              <param name="swfversion" value="9.0.45.0" />
              <param name="expressinstall" value="<?php echo RESOURCE_PATH;?>/js/expressInstall.swf" />
              <!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 -->
              <div>
                <h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4>
                <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="获取 Adobe Flash Player" width="112" height="33" /></a></p>
              </div>
              <!--[if !IE]>-->
            </object>
            <!--<![endif]-->
          </object>
          <script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script></td>
        <td class="vatop tips"></td>
      </tr>
      <tr id="adv_flash_url">
        <td colspan="2" class="required"><?php echo $lang['adv_url'];?>:</td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><input type="text" name="flash_url" class="txt" value="<?php echo $url; ?>"></td>
        <td class="vatop tips"><?php echo $lang['adv_url_donotadd'];?></td>
      </tr>
      <?php
		break;
		}
		?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn" onclick=window.location.href='index.php?act=adv&op=adv_check&savecheck=yes&ap_id=<?php echo $output['adv_list']['ap_id']; ?>&adv_id=<?php echo $output['adv_list']['adv_id']; ?>'><span><?php echo $lang['check_adv_yes'];?></span></a> <a href="JavaScript:void(0);" class="btn" id="submitBtn" onclick=window.location.href='index.php?act=adv&op=adv_check&savecheck=no&adv_id=<?php echo $output['adv_list']['adv_id']; ?>'><span><?php echo $lang['check_adv_no'];?></span></a>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/swfobject_modified.js"></script> 
