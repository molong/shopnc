<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.d_inline {
	display:inline;
}
</style>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store"><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_audit" ><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="index.php?act=store_grade&op=store_grade_log" ><span><?php echo $lang['grade_apply']; ?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $_GET['type'] == 'auth'?$lang['store_verify_auth']:$lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="store_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="store_id" value="<?php echo $output['store_array']['store_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['store_user_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['store_array']['member_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_owner_card"><?php echo $lang['store_user_id'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_owner_card'];?>" id="store_owner_card" name="store_owner_card" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="store_name"> <?php echo $lang['store_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_name'];?>" id="store_name" name="store_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['belongs_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="sc_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(is_array($output['class_list'])){ ?>
              <?php foreach($output['class_list'] as $k => $v){ ?>
              <option <?php if($output['store_array']['sc_id'] == $v['sc_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['sc_id']; ?>"><?php echo $v['sc_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label> <?php echo $lang['location'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><div id="region" class="change-select-2">
              <?php if(!empty($output['store_array']['area_id'])){?>
              <span><?php echo $output['store_array']['area_info'];?></span>
              <input type="button" value="<?php echo $lang['nc_edit'];?>" class="edit_region" />
              <select style="display:none">
              </select>
              <?php }else{?>
              <select>
              </select>
              <?php }?>
              <input type="hidden" name="area_id" id="area_id" value="<?php echo $output['store_array']['area_id'];?>" class="area_ids" />
              <input type="hidden" name="area_info" value="<?php echo $output['store_array']['area_info'];?>" class="area_names" />
            </div></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_address"><?php echo $lang['details_address'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_address'];?>" id="store_address" name="store_address" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_zip"><?php echo $lang['zip'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_zip'];?>" id="store_zip" name="store_zip" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_tel"><?php echo $lang['tel_phone'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_tel'];?>" id="store_tel" name="store_tel" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td colspan="2" class="required"><label>
            <label for="grade_id"> <?php echo $lang['belongs_level'];?>: </label>
            </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="grade_id" name="grade_id">
              <?php if(is_array($output['grade_list'])){ ?>
              <?php foreach($output['grade_list'] as $k => $v){ ?>
              <option <?php if($output['store_array']['grade_id'] == $v['sg_id']){ ?>selected="selected"<?php } ?> value="<?php echo $v['sg_id']; ?>"><?php echo $v['sg_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['period_to'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_end_time'];?>" id="end_time" name="end_time" class="txt date"></td>
          <td class="vatop tips"><?php echo $lang['formart'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>
            <label for="state"><?php echo $lang['state'];?>:</label>
            </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="store_state1" class="cb-enable <?php if($output['store_array']['store_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="store_state0" class="cb-disable <?php if($output['store_array']['store_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="store_state1" name="store_state" <?php if($output['store_array']['store_state'] == '1'){ ?>checked="checked"<?php } ?> onclick="$('#tr_store_close_info').hide();" value="1" type="radio">
            <input id="store_state0" name="store_state" <?php if($output['store_array']['store_state'] == '0'){ ?>checked="checked"<?php } ?> onclick="$('#tr_store_close_info').show();" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody id="tr_store_close_info">
        <tr >
          <td colspan="2" class="required"><label for="store_close_info"><?php echo $lang['close_reason'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="store_close_info" rows="6" class="tarea" id="store_close_info"><?php echo $output['store_array']['store_close_info'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_auth'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
              <label for="name_auth1" class="cb-enable <?php if($output['store_array']['name_auth'] != '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['store_pass'];?></span></label>
              <label for="name_auth0" class="cb-disable <?php if($output['store_array']['name_auth'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['store_fail'];?></span></label>
              <input id="name_auth1" name="name_auth" <?php if($output['store_array']['name_auth'] != '0'){ ?>checked="checked"<?php } ?> value="1" type="radio">
              <input id="name_auth0" name="name_auth" <?php if($output['store_array']['name_auth'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
              <?php if ($output['store_array']['store_image'] != '') {?>
              &nbsp;<a id="store_image" href="../<?php echo ATTACH_AUTH.DS.$output['store_array']['store_image']; ?>" target="_blank"><?php echo $lang['view_owner_certification_file'];?></a>
              &nbsp;<span id="store_image_del" onclick="if(confirm('<?php echo $lang['owner_certification_del'];?>')){del_auth('store_image');}"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$lang['nc_del']; ?></span>
              <?php } ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['store_auth'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
              <label for="store_auth1" class="cb-enable <?php if($output['store_array']['store_auth'] != '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['store_pass'];?></span></label>
              <label for="store_auth0" class="cb-disable <?php if($output['store_array']['store_auth'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['store_fail'];?></span></label>
              <input id="store_auth1" name="store_auth" <?php if($output['store_array']['store_auth'] != '0'){ ?>checked="checked"<?php } ?> value="1" type="radio">
              <input id="store_auth0" name="store_auth" <?php if($output['store_array']['store_auth'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
              <?php if ($output['store_array']['store_image1'] != '') {?>
              &nbsp;<a id="store_image1" href="../<?php echo ATTACH_AUTH.DS.$output['store_array']['store_image1']; ?>" target="_blank"><?php echo $lang['view_entity_store_certification_file'];?></a>
              &nbsp;<span id="store_image1_del" onclick="if(confirm('<?php echo $lang['entity_store_certification_del'];?>')){del_auth('store_image1');}"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$lang['nc_del']; ?></span>
              <?php } ?>
            </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['recommended'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="store_recommend1" class="cb-enable <?php if($output['store_array']['store_recommend'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="store_recommend0" class="cb-disable <?php if($output['store_array']['store_recommend'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_no'];?></span></label>
            <input id="store_recommend1" name="store_recommend" <?php if($output['store_array']['store_recommend'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="store_recommend0" name="store_recommend" <?php if($output['store_array']['store_recommend'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['recommended_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['store_array']['store_sort'];?>" id="store_sort" name="store_sort" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_PATH."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
function del_auth(key){
var store_id='<?php echo $output['store_array']['store_id'];?>';
	$.get("index.php?act=store&&op=del_auth",{'key':key,'store_id':store_id},function(date){
		if(date){
			$("#"+key).remove();
			$("#"+key+"_del").remove();
			alert('<?php echo $lang['certification_del_success'];?>');
		}
		else{
			alert('<?php echo $lang['certification_del_fail'];?>');
		}
	});
}
$(function(){
	
	$('#end_time').datepicker();
	$('input[name=store_state][value=<?php echo $output['store_array']['store_state'];?>]').trigger('click');
	regionInit("region");
	$('input[class="edit_region"]').click(function(){
		$(this).css('display','none');
		$(this).parent().children('select').css('display','');
		$(this).parent().children('span').css('display','none');
	});
//按钮先执行验证再提交表单

	$("#submitBtn").click(function(){
    	if($("#store_form").valid()){
    		$("#store_form").submit();
		}
	});

//		
	$('#store_form').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parentsUntil('tr').parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
		rules : {
			store_name: {
				required : true
			},
			area_id: {
				required: true,
				checkarea : true
			},
			end_time	: {
				date	: false
			}
		},
		messages : {
			store_name: {
				required: '<?php echo $lang['please_input_store_name'];?>'
			},
            area_id: {
            	required: '<?php echo $lang['please_input_address'];?>',
            	checkarea: '<?php echo $lang['please_input_address'];?>'
			}
		}
	});
});
</script>