<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form method="post" id="profile_form" action="index.php?act=home&op=member">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_info']['member_avatar']; ?>" />
      <dl>
        <dt><?php echo $lang['home_member_username'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['member_info']['member_name']; ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_email'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['member_info']['member_email']; ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_truename'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" class="text" maxlength="30" name="member_truename" value="<?php echo $output['member_info']['member_truename']; ?>" />
          </p>
          <p class="hint"></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_sex'].$lang['nc_colon'];?></dt>
        <dd>
          <label>
            <input type="radio" name="member_sex" value="3" <?php if($output['member_info']['member_sex']==3 or ($output['member_info']['member_sex']!=2 and $output['member_info']['member_sex']!=1)) { ?>checked="checked"<?php } ?> />
            <?php echo $lang['home_member_secret'];?></label>
          <label>
            <input type="radio" name="member_sex" value="2" <?php if($output['member_info']['member_sex']==2) { ?>checked="checked"<?php } ?> />
            <?php echo $lang['home_member_female'];?></label>
          <label>
            <input type="radio" name="member_sex" value="1" <?php if($output['member_info']['member_sex']==1) { ?>checked="checked"<?php } ?> />
            <?php echo $lang['home_member_male'];?></label>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_birthday'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text" name="birthday" maxlength="10" id="birthday" value="<?php echo $output['member_info']['member_birthday']; ?>" />
        </dd>
      </dl>
      <dl>
        <dt class="required"><?php echo $lang['home_member_areainfo'].$lang['nc_colon'];?></dt>
        <dd>
          <div id="region">
            <input type="hidden" value="<?php echo $output['member_info']['member_provinceid'];?>" name="province_id" id="province_id">
            <input type="hidden" value="<?php echo $output['member_info']['member_cityid'];?>" name="city_id" id="city_id">
            
            
            <input type="hidden" value="<?php echo $output['member_info']['member_areaid'];?>" name="area_id" id="area_id" class="area_ids" />
            <input type="hidden" value="<?php echo $output['member_info']['member_areainfo'];?>" name="area_info" id="area_info" class="area_names" />
            <?php if(!empty($output['member_info']['member_areaid'])){?>
            <span><?php echo $output['member_info']['member_areainfo'];?></span>
            <input type="button" value="<?php echo $lang['nc_edit'];?>" class="edit_region" />
            <select style="display:none;"> </select>
            <?php }else{?>
            <select></select>
            <?php }?>
          </div>
        </dd>
      </dl>
      <dl>
        <dt>QQ<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" class="text" maxlength="30" name="member_qq" value="<?php echo $output['member_info']['member_qq']; ?>" />
          </p>
          <p class="hint"></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['home_member_wangwang'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input name="member_ww" type="text" class="text" maxlength="50" id="member_ww" value="<?php echo $output['member_info']['member_ww'];?>" />
          </p>
          <p class="hint"></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['home_member_save_modify'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript">
//注册表单验证
$(function(){
	regionInit("region");
	$('#birthday').datepicker({dateFormat: 'yy-mm-dd'});
    $('#profile_form').validate({
    	submitHandler:function(form){
    		$('#province_id').val($('select[class="valid"]').eq(0).val());
			$('#city_id').val($('select[class="valid"]').eq(1).val());
			ajaxpost('profile_form', '', '', 'onerror')
		},
        errorPlacement: function(error, element){
            var error_td = element.parent('p').next('p');
            error_td.append(error);
        },
        rules : {
            member_truename : {
				minlength : 2,
                maxlength : 20
            },
            member_qq : {
				digits  : true,
                minlength : 5,
                maxlength : 12
            }
        },
        messages : {
            member_truename : {
				minlength : '<?php echo $lang['home_member_username_range'];?>',
                maxlength : '<?php echo $lang['home_member_username_range'];?>'
            },
            member_qq  : {
				digits    : '<?php echo $lang['home_member_input_qq'];?>',
                minlength : '<?php echo $lang['home_member_input_qq'];?>',
                maxlength : '<?php echo $lang['home_member_input_qq'];?>'
            }
        }
    });
});
</script> 
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" ></script>