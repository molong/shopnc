<style type="text/css">
.ncu-form-style dl dt { width: 120px;}
</style>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form action="" method="post" id="adv_edit_form" enctype="multipart/form-data">
      <input type="hidden" value="ok" name="formsubmit">
      <input type="hidden" value="<?php echo $output['adv_info']['adv_id']; ?>" name="adv_id">
      <input type="hidden" value="<?php echo $output['ap_info']['ap_class']; ?>" name="ap_class">
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['adv_title']; ?></dt>
        <dd>
          <input name="adv_title" type="text" value="<?php echo $output['adv_info']['adv_title']; ?>" id="adv_title" class="text w200" >
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_ap_name']; ?></dt>
        <dd><?php echo $output['ap_info']['ap_name']; ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_style']; ?> </dt>
        <dd>
          <?php 
 switch ($output['ap_info']['ap_class']){
 	case '0':
 		echo $lang['ap_pic'];
 		break;
 	case '1':
 		echo $lang['ap_word'];
 		break;
 	case '2':
 		echo $lang['ap_slide'];
 		break;
 	case '3':
 		echo "Flash";
 		break;
 }
 ?>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_start_date']; ?> </dt>
        <dd><?php echo date('Y-m-d',$output['adv_info']['adv_start_date']); ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_end_date']; ?> </dt>
        <dd><?php echo date('Y-m-d',$output['adv_info']['adv_end_date']); ?></dd>
      </dl>
      <?php 
  switch ($output['ap_info']['ap_class']){
 	case '0':
 		$pic_content = unserialize($output['adv_info']['adv_content']);
		$pic         = $pic_content['adv_pic'];
		$url         = $pic_content['adv_pic_url'];
 ?>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['adv_pic_upload']; ?></dt>
        <dd>
          <input type="file" name="adv_pic" id="adv_content1" onchange ="setImg()"/>
          <input type="hidden" name="pic_ori" value="<?php echo $pic; ?>" />
        </dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd><img src="<?php echo SiteUrl."/".ATTACH_ADV."/".$pic;?>" width="<?php echo $output['ap_info']['ap_width']>500?500:$output['ap_info']['ap_width'];?>" id="oriimgshow"/></dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd><img id="imgView" src="" style="display:none" onload="javascript:DrawImage(this,350,200);"/></dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['adv_url'] ;?> </dt>
        <dd>
          <input type="text" name="adv_pic_url" value="<?php echo $url;?>" id="adv_url" class="text w400"/ >
        </dd>
      </dl>
      <?php 		
 		break;
 	case '1':
 		$word_content = unserialize($output['adv_info']['adv_content']);
		$word         = $word_content['adv_word'];
		$url          = $word_content['adv_word_url'];
 ?>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['adv_word_info']; ?></dt>
        <dd>
          <input type="text" name="adv_word" value="<?php echo $word; ?>" class="text w400" />
          <input type="hidden" name="adv_word_len" value="<?php echo $output['ap_info']['ap_width']; ?>" >
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_url'] ;?> </dt>
        <dd>
          <input type="text" name="adv_word_url" value="<?php echo $url; ?>" id="adv_url" class="text w400"/>
        </dd>
      </dl>
      <?php 		
 		break;
 	case '2':
 		$slide_content = unserialize($output['adv_info']['adv_content']);
		$pic           = $slide_content['adv_slide_pic'];
		$url           = $slide_content['adv_slide_url'];
 ?>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['adv_slidepic_upload']; ?> </dt>
        <dd>
          <input type="file" name="adv_slide_pic"  id="adv_content1" onchange ="setImg()"/>
          <input type="hidden" name="slide_ori" value="<?php echo $pic; ?>" />
        </dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd><img src="<?php echo SiteUrl."/".ATTACH_ADV."/".$pic;?>" width="<?php echo $output['ap_info']['ap_width']>500?500:$output['ap_info']['ap_width'];?>" id="oriimgshow"/></dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd><img id="imgView" src="" style="display:none" onload="javascript:DrawImage(this,500,300);"/></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_url'] ;?> </dt>
        <dd>
          <input type="text" name="adv_slide_url" value="<?php echo $url;?>" id="adv_url" clsss="text w400" />
        </dd>
      </dl>
      <?php		
 		break;
    case '3':
    	$flash_content = unserialize($output['adv_info']['adv_content']);
		$flash         = $flash_content['flash_swf'];
		$url           = $flash_content['flash_url'];
 ?>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['please_upload_swf']; ?></dt>
        <dd>
          <input type="file" name="flash_swf" id="adv_content1"/>
          &nbsp;&nbsp;<span style="color:#999">(<?php echo $output['ap_info']['ap_width']; ?><?php echo $lang['adv_px']; ?>*<?php echo $output['ap_info']['ap_height']; ?><?php echo $lang['adv_px']; ?>)</span></dd>
      </dl>
      <dl>
        <dt>&nbsp;</dt>
        <dd>
          <input type="hidden" name="flash_ori" value="<?php echo $flash;?>">
          <a href="http://<?php echo $url; ?>" target="_blank">
          <button style="width:<?php echo $ap_v['ap_width']; ?>px; height:<?php echo $ap_v['ap_height']; ?>px; border:none; padding:0; background:none;" disabled>
          <object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="<?php echo $output['ap_info']['ap_width']; ?>" height="<?php echo $output['ap_info']['ap_height']; ?>">
            <param name="movie" value="<?php echo SiteUrl."/".ATTACH_ADV."/".$flash;?>" />
            <param name="quality" value="high" />
            <param name="wmode" value="opaque" />
            <param name="swfversion" value="9.0.45.0" />
            <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 -->
            <param name="expressinstall" value="<?php echo RESOURCE_PATH;?>/js/expressInstall.swf" />
            <!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 --> 
            <!--[if !IE]>-->
            <object type="application/x-shockwave-flash" data="<?php echo SiteUrl."/".ATTACH_ADV."/".$flash;?>" width="<?php echo $ap_v['ap_width']; ?>" height="<?php echo $ap_v['ap_height']; ?>">
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
          </button>
          </a> 
          <script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
</script></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_url']; ?></dt>
        <dd>
          <p>
            <input type="text" name="flash_url" value="<?php echo $url; ?>" id="adv_content2" class="text w400"/>
          </p>
          <p class="hint"><?php echo $lang['do_not_add_http']; ?></p>
        </dd>
      </dl>
      <?php	}?>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
	$(function(){
	$('#adv_edit_form').validate({
        rules : {
        	adv_title : {
                required : true
            },
            adv_pic_url  : {
                required : true
            },
            adv_word_url  : {
                required : true
            },
            adv_slide_url  : {
                required : true
            }
        },
        messages : {
        	adv_title : {
                required : '<?php echo $lang['advtitle_can_not_null']; ?>'
            },
            adv_pic_url  : {
                required : '<?php echo $lang['adv_url_can_not_null']; ?>'
            },
            adv_word_url  : {
                required : '<?php echo $lang['adv_url_can_not_null']; ?>'
            },
            adv_slide_url  : {
                required : '<?php echo $lang['adv_url_can_not_null']; ?>'
            }
        }
    });
	});
</script> 
<script>
            function setImg()
            {
             document.getElementById("imgView").style.display='';
             document.getElementById("oriimgshow").style.display='none';
             
             var isIE = document.all?true:false;
             var isIE7 = isIE && (navigator.userAgent.indexOf('MSIE 7.0') != -1);  
             var isIE8 = isIE && (navigator.userAgent.indexOf('MSIE 8.0') != -1);  
             var upLoadImgFile = document.getElementById("adv_content1");
              
              var imgView = document.getElementById("imgView");
              if(isIE){
               
              if(isIE7 || isIE8)
              {  
              upLoadImgFile.select();
              imgView.src = document.selection.createRange().text;  
              document.selection.empty();  
              }else{ imgView.src = upLoadImgFile.value;}
              }else{
              //imgView.src = upLoadImgFile.files.item(0).getAsDataURL();
                  imgView.src = window.URL.createObjectURL(upLoadImgFile.files.item(0));
              }
                
            }
  </script> 
