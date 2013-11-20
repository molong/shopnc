<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.jcarousel-skin-tango .jcarousel-clip-horizontal { width: 400px !important; height: 92px !important;}
.jcarousel-skin-tango .jcarousel-item { height: 92px !important;}
.jcarousel-skin-tango .jcarousel-container-horizontal { width: 400px !important;}
</style>
<div class="feededitor">			
  <form method="post" action="index.php?act=member_snsindex&op=sharegoods<?php if($_GET['irefresh'] == 1){?>&irefresh=1<?php }?>" id="sharegoods_form">
    <input type="hidden" name="form_submit" value="ok"/>
    <!-- 商品图片start -->
    <?php if (!empty($output['goods_list'])){?>
    <ul id="mycarousel" class="snsgoodsimglist jcarousel-skin-tango">
      <?php foreach ($output['goods_list'] as $v) {?>
      <li><a href="javascript:void(0);" value="<?php echo $v['goods_id'] ?>"> <span class="thumb size90"><?php if($v['order']){?><i class="b"></i><?php }?><?php if($v['favorites']){?><i class="f"></i><?php }?> <img title="<?php echo $v['goods_name']?>" src="<?php echo thumb($v,'small');?>" onload="javascript:DrawImage(this,90,90);"/>
        <p class="extra"><?php echo $lang['sns_selected'];?></p>
        </span> </a></li>
      <?php }?>
    </ul>
    <?php } else{?>
    <div class="sns-norecord"><?php echo $lang['sns_sharegoods_notbuygoods'];?></div>
    <?php }?>
    <input type="hidden" id="choosegoodsid" name="choosegoodsid" value="<?php echo intval($output['goods_list'][0]['goods_id']);?>" />
    <div class="error"></div>
    <!-- 商品图片end -->
    <div class="p10">
      <textarea placeholder="<?php echo $lang['sns_sharegoods_contenttip'];?>" name="comment" id="content_sgweibo" resize="none"></textarea>
      <div class="error form-error"></div>
      <!-- 验证码 -->
      <div id="sg_seccode" class="seccode">
        <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon']; ?></label>
        <input name="captcha" type="text" class="text" size="4" maxlength="4"/>
        <img src="" title="<?php echo $lang['wrong_checkcode_change'];?>" name="codeimage" border="0" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/>
        <span><?php echo $lang['wrong_seccode'];?></span>
        <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
      </div>
      <input type="text" style="display:none;" />
      <!-- 防止点击Enter键提交 -->
      <div class="handle">
        <div id="sgcharcount" class="fl"></div>
        <input name="<?php echo $lang['nc_snsshare'];?>" type="button" class="button" value="<?php echo $lang['nc_snsshare'];?>" id="weibobtn_goods" />
        <div nc_type="formprivacydiv" class="privacy-module w100 fr mr10 mt5"><span class="privacybtn" style="width:55px;" nc_type="formprivacybtn"><i></i><?php echo $lang['sns_weiboprivacy_default'];?></span>
          <div class="privacytab" nc_type="formprivacytab" style="display:none;">
            <ul class="menu-bd">
              <li nc_type="formprivacyoption" data-param='{"v":"0","hiddenid":"gprivacy"}'><span class="selected"><?php echo $lang['sns_weiboprivacy_all'];?></span></li>
              <li nc_type="formprivacyoption" data-param='{"v":"1","hiddenid":"gprivacy"}'><span><?php echo $lang['sns_weiboprivacy_friend'];?></span></li>
              <li nc_type="formprivacyoption" data-param='{"v":"2","hiddenid":"gprivacy"}'><span><?php echo $lang['sns_weiboprivacy_self'];?></span></li>
            </ul>
          </div>
        </div>
      </div>
     
    </div> <input type="hidden" name="gprivacy" id="gprivacy" value="0"/>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jcarousel/jquery.jcarousel.min.js" charset="utf-8"></script> 
<script type="text/javascript">
$(function(){
	//图片轮换
    $('#mycarousel').jcarousel({visible: 4,itemFallbackDimension: 300});
	//初始化选择的商品
	$(".snsgoodsimglist").find('a').eq(0).addClass("selected");
	//商品列表绑定事件
	$(".snsgoodsimglist").find('a').bind("click",function(){
		$(".snsgoodsimglist").find('a').removeClass('selected');
		$(this).addClass("selected");
		var gid = $(this).attr('value');
		$("#choosegoodsid").val(gid);
	});
	//分享商品评论字符个数计算
	$("#content_sgweibo").charCount({
		allowed: 140,
		warning: 10,
		counterContainerID:'sgcharcount',
		firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
		endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
		errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
	});
	//分享商品表单验证
	$('#sharegoods_form').validate({
		errorPlacement: function(error, element){
			element.next('.error').append(error);
	    },      
	    rules : {
	    	choosegoodsid:{
	    		min:1
	    	},
	    	comment : {
	            maxlength : 140
	        }
	    },
	    messages : {
	    	choosegoodsid:{
	    		min:'<?php echo $lang['sns_sharegoods_choose'];?>'
	    	},
	    	comment : {
	            maxlength: '<?php echo $lang['sns_content_beyond'];?>'
	        }
	    }
	});
});
</script>
