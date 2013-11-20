<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="feededitor">
  <form method="post" action="index.php?act=member_snsindex&op=sharestore" id="sharestore_form">
    <input type="hidden" name="form_submit" value="ok"/>
    <input type="hidden" id="choosestoreid" name="choosestoreid" value="<?php echo intval($output['store_info']['store_id']);?>" />
    <div class="goods">
      <div class="pic"><span class="thumb size90"><i></i><a target="_blank" href="<?php echo $output['store_info']['store_url'];?>"><img title="<?php echo $output['store_info']['store_name']; ?>" src="<?php echo empty($output['store_info']['store_logo']) ? ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_store_logo'] : ATTACH_STORE.DS.$output['store_info']['store_logo'];?>" onload="javascript:DrawImage(this,90,90);"/></a></span></div>
      <dl class="intro">
        <dt><a target="_blank" href="<?php echo $output['store_info']['store_url'];?>"><?php echo $output['store_info']['store_name']; ?></a></dt>
        <dd><?php echo $lang['sns_sharestore_shopkeeper'].$lang['nc_colon']; ?><?php echo $output['store_info']['member_name']; ?></dd>
        <dd><?php echo $lang['sns_sharestore_location'].$lang['nc_colon']; ?><?php echo $output['store_info']['area_info']; ?></dd>
      </dl>
    </div>
    <div class="p10">
      <textarea placeholder="<?php echo $lang['sns_sharestore_contenttip'];?>" name="comment" id="content_ssweibo" resize="none" ></textarea>
      <div class="error form-error"></div>
      <!-- 验证码 -->
        <div id="ss_seccode" class="seccode">
        <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon']; ?></label>
          <input name="captcha" class="text" type="text" size="4" maxlength="4"/>
          <img src="" title="<?php echo $lang['wrong_checkcode_change'];?>" name="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/>
          <span><?php echo $lang['wrong_seccode'];?></span>
          <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
        </div>
        <input type="text" style="display:none;" />
        <!-- 防止点击Enter键提交 -->
      <div class="handle">
        <div id="sscharcount" class="fl"></div>
        
        <input name="<?php echo $lang['nc_snsshare'];?>" type="button" class="button" value="<?php echo $lang['nc_snsshare'];?>" id="weibobtn_store" />
        <div nc_type="formprivacydiv" class="privacy-module fr w100 mr10 mt5"> <span class="privacybtn" nc_type="formprivacybtn"><?php echo $lang['sns_weiboprivacy_default'];?><i></i></span>
          <div class="privacytab" nc_type="formprivacytab" style="display:none;">
            <ul class="menu-bd">
              <li nc_type="formprivacyoption" data-param='{"v":"0","hiddenid":"sprivacy"}'><span class="selected"><?php echo $lang['sns_weiboprivacy_all'];?></span></li>
              <li nc_type="formprivacyoption" data-param='{"v":"1","hiddenid":"sprivacy"}'><span><?php echo $lang['sns_weiboprivacy_friend'];?></span></li>
              <li nc_type="formprivacyoption" data-param='{"v":"2","hiddenid":"sprivacy"}'><span><?php echo $lang['sns_weiboprivacy_self'];?></span></li>
            </ul>
          </div>
          <input type="hidden" name="sprivacy" id="sprivacy" value="0"/>
        </div>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.charCount.js"></script> 
<script>
var max_recordnum = '<?php echo $output['max_recordnum'];?>';
$(function(){
	//分享店铺评论字符个数计算
	$("#content_ssweibo").charCount({
		allowed: 140,
		warning: 10,
		counterContainerID:'sscharcount',
		firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
		endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
		errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
	});
	//分享店铺表单验证
	$('#sharestore_form').validate({
		errorPlacement: function(error, element){
			element.next('.error').append(error);
	    },      
	    rules : {
	    	comment : {
	            maxlength : 140
	        }
	    },
	    messages : {
	    	comment : {
	            maxlength: '<?php echo $lang['sns_content_beyond'];?>'
	        }
	    }
	});
});
</script>