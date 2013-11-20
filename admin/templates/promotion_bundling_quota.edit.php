<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_PATH."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(document).ready(function(){
	$('#quota_endtime').datepicker();
	
    jQuery.validator.addMethod('dateValidate', function(value, element) {
    	var date1 = new Date(Date.parse('<?php echo date('Y/m/d', $output['quota_info']['bl_quota_starttime']);?>'));
        var date2 = new Date(Date.parse($('#quota_endtime').val().replace(/-/g, "/")));
        return date1 < date2;
    });

    $("#submitBtn").click(function(){
        $("#add_form").submit();
    });
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
		},
		success: function(label){
			label.addClass('valid');
		},
		rules : {
			quota_endtime: {
				required : true,
				dateValidate : true
				
			}
		},
		messages : {
			quota_endtime: {
				required : '<?php echo $lang['bundling_quota_endtime_required'];?>',
				dateValidate : '<?php echo $lang['bundling_quota_endtime_dateValidate'];?>'
			}
		}
	});
});
</script> 
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_promotion_bundling'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=promotion_bundling&op=bundling_quota"><span><?php echo $lang['bundling_quota'];?></span></a></li>
        <li><a href="index.php?act=promotion_bundling&op=bundling_list"><span><?php echo $lang['bundling_list'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post">
    <input type="hidden" id="form_submit" name="form_submit" value="ok" />
    <input type="hidden" name="quota_id" value="<?php echo $output['quota_info']['bl_quota_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['bundling_quota_store_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
            	<?php echo $output['quota_info']['store_name'];?>
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['bundling_quota_quantity'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <?php echo $output['quota_info']['bl_quota_month'];?>
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['bundling_quota_starttime'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
            	<?php echo date('Y-m-d', $output['quota_info']['bl_quota_starttime']);?>
            </td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="quota_endtime"><?php echo $lang['bundling_quota_endtime'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
            	<input type="text" name="quota_endtime" id="quota_endtime" class="txt" value="<?php echo date('Y-m-d', $output['quota_info']['bl_quota_endtime']);?>" />
            </td>
            <td class="vatop tips"><?php echo $lang['bundling_quota_endtime_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="quota_endtime"><?php echo $lang['nc_state'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform onoff">
            	<label for="quota_state1" class="cb-enable <?php if($output['quota_info']['bl_quota_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['bundling_state_1'];?></span></label>
            	<label for="quota_state0" class="cb-disable <?php if($output['quota_info']['bl_quota_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['bundling_state_0'];?></span></label>
            	<input id="quota_state1" name="quota_state" <?php if($output['quota_info']['bl_quota_state'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            	<input id="quota_state0" name="quota_state" <?php if($output['quota_info']['bl_quota_state'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio">
            </td>
          	<td class="vatop tips"><?php echo $lang['bundling_quota_state_tips'];?></td>
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

