<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
	$('#cosulting_demo').find('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:"<?php echo TEMPLATES_PATH;?>/images/transparent.gif",
		target:'#cosulting_demo'
	});
});
</script>
<?php if(!empty($output['consult_list'])) { ?>

<ul>
  <?php foreach($output['consult_list'] as $k=>$v){ ?>
  <li>
    <dl class="ask">
      <dt><?php echo $lang['goods_index_consult_content'];?><?php echo $lang['nc_colon'];?></dt>
      <dd>
        <p><?php echo nl2br($v['consult_content']);?></p>
        <span class="mr10">
        <?php if($v['member_id']== '0') echo $lang['nc_guest']; else {?>
        <span title="<?php echo $v['isanonymous'] == 1?str_cut($v['cmember_name'],2).'***':$v['cmember_name'];?>"> <?php echo $v['isanonymous'] == 1?str_cut($v['cmember_name'],2).'***':str_cut($v['cmember_name'],8);?></span>
        <?php }?>
        </span>
        <time datetime="<?php echo date("Y-m-d H:i:s",$v['consult_addtime']);?>" pubdate="pubdate">[<?php echo date("Y-m-d H:i:s",$v['consult_addtime']);?>]</time>
      </dd>
    </dl>
    <?php if($v['consult_reply']!=""){?>
    <dl class="reply">
      <dt><?php echo $lang['goods_index_seller_reply'];?></dt>
      <dd>
        <p><?php echo nl2br($v['consult_reply']);?></p>
        <time datetime="<?php echo date("Y-m-d H:i:s",$v['consult_reply_time']);?>" pubdate="pubdate">[<?php echo date("Y-m-d H:i:s",$v['consult_reply_time']);?>]</time>
      </dd>
    </dl>
    <?php }?>
  </li>
  <?php }?>
  <div class="pagination"> <?php echo $output['show_page'];?> </div>
  <div class="clear"></div>
</ul>
<?php } else { ?>
<div class="ncs-norecord"><?php echo $lang['goods_index_no_reply'];?></div>
<?php } ?>
<?php if($output['consult_able']) { ?>
<div class="clear"></div>
<form method="post" id="message" action="index.php?act=goods&op=save_consult&id=<?php echo $_GET['id']; ?>">
  <?php if($output['type_name']==''){?>
  <input type="hidden" name="goods_id" value="<?php echo $_GET['goods_id']; ?>"/>
  <?php }?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <td><?php if($_SESSION['member_id']){ ?>
          <span>
          <label><strong><?php echo $lang['goods_index_member_name'].$lang['nc_colon'];?></strong><?php echo $_SESSION['member_name'];?></label>
          <input type="hidden" name="email" id="gbTextfield" class="w100"  value="<?php echo $_SESSION['member_email']; ?>" />
          </span><span>
          <input type="checkbox"  name="hide_name" value="hide" id="gbCheckbox" class="mt5 ml20">
          <label for="gbCheckbox"><?php echo $lang['goods_index_anonymous_publish'];?></label>
          </span>
          <?php }else{ ?>
          <span>
          <label for="gbTextfield"><strong><?php echo $lang['goods_index_email'];?></strong></label>
          <input type="text" name="email" id="gbTextfield" class="w100"  value="" />
          </span>
          <?php }?>
          <?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
          <span>
          <label for="captcha" class="ml20"><strong><?php echo $lang['goods_index_checkcode'];?></strong></label>
          <input name="captcha" style="float:left; width:84px;font-size: 14px;padding:4px" class="text" type="text" id="captcha" size="4" maxlength="4"/>
          <a href="javascript:void(0)" class="ml5"><img src="index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>" title="<?php echo $lang['goods_index_change_checkcode'];?>" name="codeimage" border="0" id="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"  style="float:left; padding-left:4px;"/>
          </span>
          <?php } ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
        	<span>
        		<textarea name="goods_content" id="textfield3"></textarea>
        		<input name="nchash" type="hidden" id="nchash" value="<?php echo $output['nchash'];?>" />
        	</span>
        	<span id="consultcharcount"></span>
        	<span class="button">
        		<a href="JavaScript:void(0);" nc_type="consult_submit" title="<?php echo $lang['goods_index_publish_consult'];?>" class="btn"><?php echo $lang['goods_index_publish_consult'];?></a>
        	</span>
        </td>
      </tr>
    </tbody>
  </table>
</form>
<script type="text/javascript">
$(function(){
	$('a[nc_type="consult_submit"]').click(function(){
	    if($("#message").valid()){
			$.getJSON('index.php?act=goods&op=save_consultajax',{
					'id':'<?php echo $_GET['id']; ?>'
					<?php if($output['type_name']==''){?>
		    		,'goods_id':'<?php echo $_GET['goods_id']; ?>'
					<?php }?>
					,'email':$("#gbTextfield").val()
					<?php if($_SESSION['member_id']){ ?>
					,'hide_name':$("#message input:checked").val()
					<?php }?>
					<?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
					,'captcha':$("#captcha").val()
					,'nchash':$("#nchash").val()
					<?php }?>
					,'goods_content':$("#textfield3").val()
				}, function(data){
					if(data.done == 'true'){
						$("#cosulting_demo").load('index.php?act=goods&op=cosulting&goods_id=<?php echo $_GET['goods_id']; ?>');
					}else{
						alert(data.msg);
					}
		    	});
	   	}
	});
	$('#message').validate({
		errorPlacement: function(error, element){
			var error_td = element.parent('span');
			error_td.next('.field_notice').hide();
			error_td.append(error);
	    },      
	    rules : {
	    	goods_content : {
	            required : true,
	            maxlength : 120
	        },
	        email : {
	            email : true          
	        }
	        <?php if(C('captcha_status_goodsqa') == '1') { ?>
	        	,captcha: {
	        		required : true,
	        		remote   : {
	                    url : 'index.php?act=seccode&op=check&nchash=<?php echo $output['nchash'];?>',
	                    type:'get',
	                    data:{
	                    	captcha : function(){
	                            return $('#captcha').val();
	                        }
	                    }
	                }
	        	}
	        <?php }?>
	    },
	    messages : {
	    	goods_content : {
	            required : '<?php echo $lang['goods_index_cosult_not_null'];?>',
	            maxlength: '<?php echo $lang['goods_index_max_120'];?>'
	        },
	        email : {
	            email : '<?php echo $lang['goods_index_cosult_email_error'];?>'
	        }
	        <?php if($output['setting_config']['captcha_status_goodsqa'] == '1') { ?>
	        	,captcha: {
	        		required : '<?php echo $lang['goods_index_captcha_no_noll'];?>',
	        		remote   : '<?php echo $lang['goods_index_captcha_error'];?>'
	            }
	        <?php }?>
	    }
	});

	// textarea 字符个数动态计算
	$("#textfield3").charCount({
		allowed: 120,
		warning: 10,
		counterContainerID:'consultcharcount',
		firstCounterText:'<?php echo $lang['goods_index_textarea_note_one'];?>',
		endCounterText:'<?php echo $lang['goods_index_textarea_note_two'];?>',
		errorCounterText:'<?php echo $lang['goods_index_textarea_note_three'];?>'
	});
});
</script>
<?php } ?>
