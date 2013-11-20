<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form action="index.php?act=store_adv&op=adv_buy_save" method="post" enctype="multipart/form-data" id="adv_buy_form">
      <input name="ap_id" value="<?php echo $output['ap_info']['ap_id']; ?>" type="hidden" />
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['adv_title']; ?></dt>
        <dd>
          <input name="adv_title" type="text" id="adv_title" class="w200 text">
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_ap_name']; ?></dt>
        <dd><?php echo $output['ap_info']['ap_name'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_style']; ?></dt>
        <dd>
          <?php 
 switch ($output['ap_info']['ap_class']){
 	case '0':
 		echo $lang['ap_pic'];
 		echo "<input type='hidden' name='advclass' value='0'>";
 		break;
 	case '1':
 		echo $lang['ap_word'];
 		echo "<input type='hidden' name='advclass' value='1'>";
 		break;
 	case '2':
 		echo $lang['ap_slide'];
 		echo "<input type='hidden' name='advclass' value='2'>";
 		break;
 	case '3':
 		echo "Flash";
 		echo "<input type='hidden' name='advclass' value='3'>";
 		break;
 }
 ?>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em>&nbsp;<?php echo $lang['adv_start_date']; ?></dt>
        <dd>
          <?php 
  switch ($output['style']){
  	case 'buy':
  ?>
          <input type="text" name="adv_start_date" id="adv_start_date" class="text"/>
          <?php
  		break;
  	case 'order':
  		echo date('Y-m-d',$output['ordertime']);
  		echo "<input type='hidden' name='adv_start_date' value='".date('Y-m-d',$output['ordertime'])."'>";
?>
          <input type="hidden" name="adv_order_flag" value="1" />
          <?php
  		break;
  }
 ?>
          </dt>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_buy_style']; ?></dt>
        <dd>
          <?php
 switch ($output['style']){
 	case 'buy':
 		echo $lang['adv_buy_direct_buy'];
 		break;
 	case 'order';
 	    echo $lang['adv_buy_order'];
 	    break;
 }
 ?>
          <p>
            <input type="hidden" name="style" value="<?php echo $output['style']; ?>" />
          </p>
          <p class="hint red" >
            <?php if($output['member_array']['member_goldnum']<$output['ap_info']['ap_price']){?>
            <?php echo $lang['you_now_have_goldnum_is']; ?><?php echo $output['member_array']['member_goldnum']; ?><?php echo $lang['gold_unit'];?><?php echo $lang['goldnum_is_not_enough'];?>
            <?php }else{?>
            <?php echo $lang['you_now_have_goldnum_is']; ?><?php echo $output['member_array']['member_goldnum']; ?><?php echo $lang['gold_unit']; ?>
            <?php }?>
          </p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_price']; ?></dt>
        <dd><?php echo $output['ap_info']['ap_price']; ?>&nbsp;&nbsp;<?php echo $lang['adv_price_unit']; ?>
          <input type="hidden" name="ap_price" value="<?php echo $output['ap_info']['ap_price']; ?>">
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['adv_buy_month']; ?></dt>
        <dd>
          <input name="buy_month" type="text" id="buy_month" class="text w50 mr5"><?php echo $lang['adv_month_info']; ?> </dd>
      </dl>
      <?php 
 switch ($output['ap_info']['ap_class']){
 	case '0':
 ?>
      <dl>
        <dt><?php echo $lang['adv_pic_upload']; ?></dt>
        <dd>
          <input type="file" name="adv_pic" id="adv_content1" onchange ="setImg()" />
          &nbsp;&nbsp;<span style="color:#999">(<?php echo $lang['please_you_choose'];?><?php echo $output['ap_info']['ap_width']; ?><?php echo $lang['adv_px']; ?>*<?php echo $output['ap_info']['ap_height']; ?><?php echo $lang['adv_px']; ?><?php echo $lang['appoint_pixel'];?>)</span>
          </dt>
      </dl>
      <dl>
        <dt></dt>
        <dd><img id="imgView" src="" style="display:none" onload="javascript:DrawImage(this,350,200);"/></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_url']; ?> </dt>
        <dd>
          <p>
            <input type="text" name="adv_pic_url" id="adv_content2" class="text w400"/>
          </p>
          <p class="hint"><?php echo $lang['do_not_add_http']; ?></p>
        </dd>
      </dl>
      <?php 
 		break;
 	case '1':
 ?>
      <dl>
        <dt><?php echo $lang['adv_word_info']; ?></dt>
        <dd>
          <p>
            <input type="text" name="adv_word" id="adv_content_word" class="text w400" />
            <input type="hidden" name="word_len_limit" value="<?php echo $output['ap_info']['ap_width']; ?>" />
          </p>
          <p class="hint"><?php echo $lang['wordadv_info_too_long_left']; ?><?php echo $output['ap_info']['ap_width']; ?><?php echo $lang['wordadv_info_too_long_right']; ?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_url']; ?></dt>
        <dd>
          <p>
            <input type="text" name="adv_word_url" id="adv_content2" class="text w400"/>
          </p>
          <p class="hint"><?php echo $lang['do_not_add_http']; ?></p>
        </dd>
      </dl>
      <?php
 		break;
 	case '2':
 ?>
      <dl>
        <dt><?php echo $lang['adv_slidepic_upload']; ?></dt>
        <dd>
          <input type="file" name="adv_slide_pic" id="adv_content1" onchange ="setImg()"/>
          &nbsp;&nbsp;<span style="color:#999">(<?php echo $lang['please_you_choose'];?><?php echo $output['ap_info']['ap_width']; ?><?php echo $lang['adv_px']; ?>*<?php echo $output['ap_info']['ap_height']; ?><?php echo $lang['adv_px']; ?><?php echo $lang['appoint_pixel'];?>)</span>
          </dt>
      </dl>
      <dl>
        <dt></dt>
        <dd><img id="imgView" src="" style="display:none" onload="javascript:DrawImage(this,350,200);"/></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_url']; ?></dt>
        <dd>
          <p><input type="text" name="adv_slide_url" id="adv_content2"  class="text w400"/></p>
          <p class="hint"><?php echo $lang['do_not_add_http']; ?></p></dd>
      </dl>
      <?php
 		break;
    case '3':
 ?>
      <dl>
        <dt><?php echo $lang['please_upload_swf']; ?></dt>
        <dd>
          <input type="file" name="flash_swf" id="adv_content1"/>
          <p class="hint">(<?php echo $lang['please_you_choose'];?><?php echo $output['ap_info']['ap_width']; ?><?php echo $lang['adv_px']; ?>*<?php echo $output['ap_info']['ap_height']; ?><?php echo $lang['adv_px']; ?><?php echo $lang['appoint_pixel'];?>)</p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_url']; ?></dt>
        <dd>
          <input type="text" name="flash_url" id="adv_content2" class="text w400" />
          <p class="hint"><?php echo $lang['do_not_add_http']; ?></p>
        </dd>
      </dl>
      <?php
 }
 ?>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <p class="hint orange mb10">(<?php echo $lang['adv_buy_tip']; ?>)</p>
          <p>
            <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
          </p>
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
	$(function(){
	    $('#adv_start_date').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script> 
<script>
$(document).ready(function(){
	jQuery.validator.addMethod('addmethod',function(value,element){
		var tn=parseInt('<?php echo $output['member_array']['member_goldnum'];?>')-parseInt('<?php echo $output['ap_info']['ap_price'];?>'*value);
		if(tn>=0){
			return true;
		}else{
			return false;
		}
	},'<?php echo $lang['sorry_you_have_no_gold'];?>');
	$('#adv_buy_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
    	submitHandler:function(form){
    		ajaxpost('adv_buy_form', '', '', 'onerror'); 
    	},        
        rules : {
        	adv_title : {
                required : true
            },
            adv_start_date  : {
                required : true
            },
            buy_month : {
                required : true,
				digits	 : true,
				min		 : 1,
				addmethod: true
            }
        },
        messages : {
        	adv_title : {
                required : '<?php echo $lang['advtitle_can_not_null']; ?>'
            },
            adv_start_date  : {
                required : '<?php echo $lang['adv_start_date_cannot_null']; ?>'
            },
            buy_month : {
            	required : '<?php echo $lang['adv_buymonth_cannot_null']; ?>',
				digits   : '<?php echo $lang['adv_buymonth_must_pos_int']; ?>',
				min		 : '<?php echo $lang['adv_buymonth_must_pos_int']; ?>'
            }
        }
    });
    <?php 
    switch (CHARSET){
			case 'UTF-8':
				$charrate = 3;
				break;
			case 'GBK':
				$charrate = 2;
				break;
		}
    ?>
    
});
</script> 
<script>
$(document).ready(function(){
$('#adv_content_word').blur(function(){
	if($(this).val().length > <?php echo $output['ap_info']['ap_width'];?>){
		$("#wordlong_tip").html("<span style='color:red; font-size:12px'><?php echo $lang['wordadv_info_too_long'];?></span>");
	}else{
		$("#wordlong_tip").html("<?php echo $lang['wordadv_info_too_long_left']; ?><?php echo $output['ap_info']['ap_width']; ?><?php echo $lang['wordadv_info_too_long_right']; ?>");
	}
});
});
</script> 
<script>
            function setImg()
            {
             document.getElementById("imgView").style.display='';
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
