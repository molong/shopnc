<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="store-sns-radio"> <strong><?php echo $lang['store_sns_type'].$lang['nc_colon'];?></strong>
    <ul>
      <li>
        <label>
          <input type="radio" name="sns_type" value="normal" id="sns_normal" checked="checked" class="vm mr5" />
          <?php echo $lang['store_sns_normal'];?></label>
      </li>
      <li>
        <label>
          <input type="radio" name="sns_type" value="recommend" id="sns_recommend" class="vm mr5" />
          <?php echo $lang['store_sns_recommend'];?></label>
      </li>
      <li>
        <label>
          <input type="radio" name="sns_type" value="hotsell" id="sns_hotsell" class="vm mr5" />
          <?php echo $lang['store_sns_hotsell'];?></label>
      </li>
      <li>
        <label>
          <input type="radio" name="sns_type" value="new" id="sns_new" class="vm mr5" />
          <?php echo $lang['store_sns_new'];?></label>
      </li>
    </ul>
  </div>
  <div class="ncu-form-style store-sns-display" nctype="normal" style=" display: none;">
    <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="normal_form">
      <input type="hidden" name="type" value="2" />
      <dl>
        <dt><?php echo $lang['store_sns_image'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="picture"><span class="thumb size160"><i></i> <img nctype="normal_img" src="<?php echo TEMPLATES_PATH?>/images/member/default_image.png" onload="javascript:DrawImage(this,160,160);"/></span>
            <input type="hidden" name="sns_image" id="sns_image" value="" />
          </div>
          <div class="normal_upload">
            <div class="upload-note"><?php printf($lang['store_sns_normal_tips'],intval(C('image_max_filesize'))/1024);?></div>
            <div class="upload-btn"> <a href="javascript:void(0);"> <span style="width: 66px; height: 28px; position: absolute; left: 0; top: 0px; z-index: 999; cursor:pointer; ">
              <input type="file" id="normal_file" name="normal_file" style="width: 66px; height: 28px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" maxlength="0">
              </span>
              <div class="upload-button"><?php echo $lang['store_sns_upload_image'];?></div>
              <input id="submit_button" style="display:none" type="button" value="<?php echo $lang['nc_submit'];?>">
              </a> </div>
            <div class="select-btn"><a id="get_img" href="index.php?act=store_album&op=pic_list&item=store_sns_normal"><?php echo $lang['store_sns_form_album'];?></a></div>
          </div>
          <div id="get_img_ajaxContent" class="ajax-albume"></div>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea name="content" class="textarea w450 h100" id="content_normal" nctype="normal"></textarea>
          <p class="w450"><span class="smile"><em></em><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"normal"}'><?php echo $lang['store_sns_face'];?></a></span> <span id="weibocharcount_normal" class="weibocharcount"></span></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" />
        </dd>
      </dl>
    </form>
  </div>
  <div class="ncu-form-style store-sns-display" nctype="recommend" style="display: none;">
    <div class="ncm-notes">
      <h3><?php echo $lang['store_sns_explain'].$lang['nc_colon'];?></h3>
      <ul>
        <li><?php echo $lang['store_sns_explain_notes1'];?></li>
      </ul>
    </div>
    <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="recommend_form">
      <input type="hidden" name="type" value="9" />
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_sns_goods'].$lang['nc_colon']?></dt>
        <dd>
          <p>
            <input type="text" class="text w400" name="goods_url" value="" placeholder="<?php echo $lang['store_sns_input_goods_url'];?>" />
          </p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea name="content" class="textarea w400 h100" nctype="recommend" id="content_recommend"></textarea>
          <p class="w400"><span class="smile"><em></em><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"recommend"}'><?php echo $lang['store_sns_face'];?></a> </span> <span id="weibocharcount_recommend" class="weibocharcount"></span></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" />
        </dd>
      </dl>
    </form>
  </div>
  <div class="ncu-form-style store-sns-display" nctype="hotsell" style="display: none;" >
    <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="hotsell_form">
      <input type="hidden" name="type" value="10" />
      <h3><?php echo $lang['store_sns_hotsell_h3'];?></h3>
      <?php if(!empty($output['hotsell_list']) && is_array($output['hotsell_list'])){  ?>
      <ul class="goods-list">
        <?php foreach ($output['hotsell_list'] as $val){?>
        <li>
          <div class="picture"><span class="thumb size160"><i></i><img src="<?php echo cthumb($val['goods_image'], 'small', $val['store_id']);?>" onload="javascript:DrawImage(this,160,160);" /></span></div>
          <div class="name">
            <input type="checkbox" class="checkbox" name="goods_id[]" value="<?php echo $val['goods_id'];?>" />
            <?php echo $val['goods_name'];?></div>
        </li>
        <?php }?>
      </ul>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea name="content" class="textarea w450 h100" nctype="hotsell" id="content_hotsell"></textarea>
          <p class="w450"><span class="smile"> <em></em><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"hotsell"}'><?php echo $lang['store_sns_face'];?></a> </span> <span id="weibocharcount_hotsell" class="weibocharcount"></span></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" />
        </dd>
      </dl>
      <?php }else{?>
      <div class="norecord"><i>&nbsp;</i><span><?php echo $lang['store_sns_hotsell_null'];?>
        <label for="sns_recommend"><a><?php echo $lang['store_sns_self_recommend'];?></a></label>
        </span></div>
      <?php }?>
    </form>
  </div>
  <div class="ncu-form-style store-sns-display" nctype="new" style="display: none;" >
    <form method="post" action="index.php?act=store_sns&op=store_sns_save" id="new_form">
      <input type="hidden" name="type" value="3" />
      <h3><?php echo $lang['store_sns_recommend_h3'];?></h3>
      <?php if(!empty($output['new_list']) && is_array($output['new_list'])){  ?>
      <ul class="goods-list">
        <?php foreach ($output['new_list'] as $val){?>
        <li>
          <div class="picture"><span class="thumb size160"><i></i><img src="<?php echo cthumb($val['goods_image'], 'small', $val['store_id']);?>" onload="javascript:DrawImage(this,160,160);" /></span></div>
          <div class="name">
            <input type="checkbox" class="checkbox" name="goods_id[]" value="<?php echo $val['goods_id'];?>" />
            <?php echo $val['goods_name'];?> </div>
        </li>
        <?php }?>
      </ul>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea name="content" class="textarea w450 h100" nctype="new" id="content_new"></textarea>
          <p class="w450"><span class="smile"> <em></em><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"new"}'><?php echo $lang['store_sns_face'];?></a> </span> <span id="weibocharcount_new" class="weibocharcount"></span></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" />
        </dd>
      </dl>
      <?php }else{?>
      <div class="norecord"><i>&nbsp;</i><span><?php echo $lang['store_sns_new_null'];?>
        <label for="sns_recommend"><a><?php echo $lang['store_sns_self_recommend'];?></a></label>
        </span> </div>
      <?php }?>
    </form>
  </div>
  <!-- 表情弹出层 -->
  <div id="smilies_div" class="smilies-module"></div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/sns_store.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/smilies/smilies_data.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/smilies/smilies.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.caretInsert.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.ajaxContent.pack.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/ajaxfileupload/ajaxfileupload.js"></script> 
<script>
$(function(){
	/* ajax添加商品  */
	$('#get_img').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:SITE_URL+"/templates/default/images/loading.gif",
		target:'#get_img_ajaxContent'
	});
	
	$('body').click(function(){ $("#smilies_div").html(''); $("#smilies_div").hide();});
	$('input[name="sns_type"]').each(function(){
		if($(this).attr('checked') == true){
			$('.ncu-form-style').hide();
			$('.ncu-form-style[nctype="'+$(this).val()+'"]').show();
		}
	});
	
	$('input[name="sns_type"]').change(function(){
		$('.ncu-form-style').hide();
		$('.ncu-form-style[nctype="'+$(this).val()+'"]').show();
	});

	$('textarea[name="content"]').each(function(){
		$(this).charCount({
			allowed: 140,
			warning: 10,
			counterContainerID:	'weibocharcount_'+$(this).attr('nctype'),
			firstCounterText:	'<?php echo $lang['sns_charcount_tip1'];?>',
			endCounterText:		'<?php echo $lang['sns_charcount_tip2'];?>',
			errorCounterText:	'<?php echo $lang['sns_charcount_tip3'];?>'
		});
	});

	$('#normal_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('normal_form', '', '', 'onerror') 
		},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});
    
	$('#recommend_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('recommend_form', '', '', 'onerror')
		},
		rules : {
			content : {
				required : true
			},
			goods_url : {
				required : true,
				url : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			},
			goods_url : {
				required : '<?php echo $lang['store_sns_input_goods_url'];?>',
				url : '<?php echo $lang['store_sns_input_goods_url'];?>'
			}
		}
	});
    
	$('#hotsell_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			// 验证是否选中商品
			if($('#hotsell_form').find('input[type="checkbox"]:checked').length == 0){
				$('#hotsell_form').find('ul').after('<label class="error" for="content" generated="true"><?php echo $lang['store_sns_choose_goods'];?></label>');
				return false;
			}else{
				$('#hotsell_form').find('ul').next('label').remove();
			}
			ajaxpost('hotsell_form', '', '', 'onerror')
		},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});
    
	$('#new_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
    	submitHandler:function(form){
    		// 验证是否选中商品
			if($('#new_form').find('input[type="checkbox"]:checked').length == 0){
				$('#new_form').find('ul').after('<label class="error" for="content" generated="true"><?php echo $lang['store_sns_choose_goods'];?></label>');
				return false;
			}else{
				$('#new_form').find('ul').next().remove('label');
			}
    		ajaxpost('new_form', '', '', 'onerror')
    	},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});

	// 图片上传js
	$('#normal_file').unbind().live('change', function(){
		$('img[nctype="normal_img"]').attr('src',SITE_URL+"/templates/default/images/loading.gif");

		$.ajaxFileUpload
		(
			{
				url:'index.php?act=store_goods&op=image_upload',
				secureuri:false,
				fileElementId:'normal_file',
				dataType: 'json',
				data:{id:'normal_file'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefind'){
						small_img = data.file_name.replace('_tiny.', '_small.');
						small_img = data.image_cover+small_img;
						$('img[nctype="normal_img"]').attr('src',small_img);
						$('#sns_image').val(small_img);
					}else{
						alert(data.error);
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;

	});
});
//从图片空间中插入图片
function sns_insert(data){
	$('img[nctype="normal_img"]').attr('src',data);
	$('#sns_image').val(data);
}
</script>