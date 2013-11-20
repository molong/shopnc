<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form method="post" action="index.php?act=store&op=store_printsetup" enctype="multipart/form-data" id="my_store_form">
      <input type="hidden" name="form_submit" value="ok" />
      <dl class="setup">
        <dt><?php echo $lang['store_printsetup_desc'].$lang['nc_colon'];?></dt>
        <dd>
          <p><textarea name="store_printdesc" cols="150" rows="3" class="textarea w400" id="store_printdesc"><?php echo $output['store_info']['store_printdesc'];?></textarea></p>
          <p class="hint"><?php echo $lang['store_printsetup_tip1'];?></p>
        </dd>
      </dl>
      <dl class="setup">
        <dt><?php echo $lang['store_printsetup_stampimg'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="hidden" name="store_stamp_old" value="<?php echo $output['store_info']['store_stamp'];?>" />
          <p class="picture">
          	<span class="thumb size120"><i></i>
          	<img src="<?php if(!empty($output['store_info']['store_stamp'])){echo ATTACH_STORE.'/'.$output['store_info']['store_stamp'];}?>"  onload="javascript:DrawImage(this,120,120);" nc_type="store_stamp" /></span> </p>
          <p>
            <input name="store_stamp" type="file"  hidefocus="true" nc_type="change_store_stamp"/>
          </p>
          <p class="hint"><?php echo $lang['store_printsetup_tip2'];?>
          </p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>

<script type="text/javascript">
$(function(){
	$('input[nc_type="change_store_stamp"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="store_stamp"]').attr('src', src);
	});
	$('#my_store_form').validate({
    	submitHandler:function(form){
    		ajaxpost('my_store_form', '', '', 'onerror')
    	},
		rules : {
    		store_printdesc: {
    			required: true,
    			rangelength:[0,100]
    	    },
        },
        messages : {
        	store_printdesc: {
        		required: '<?php echo $lang['store_printsetup_desc_error'];?>',
		        rangelength:'<?php echo $lang['store_printsetup_desc_error'];?>'
		    }
        }
    });
});
</script>