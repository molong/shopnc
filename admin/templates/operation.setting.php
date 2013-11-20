<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_operation_set']?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_operation_set']?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <!-- 预存款开启 -->
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['open_predeposit_isuse'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="predeposit_isuse_1" class="cb-enable <?php if($output['list_setting']['predeposit_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="predeposit_isuse_0" class="cb-disable <?php if($output['list_setting']['predeposit_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input id="predeposit_isuse_1" name="predeposit_isuse" <?php if($output['list_setting']['predeposit_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="predeposit_isuse_0" name="predeposit_isuse" <?php if($output['list_setting']['predeposit_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['open_predeposit_isuse_notice'];?></td>
        </tr>
        <!-- 金币启用 -->
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['gold_isuse'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="gold_isuse_1" class="cb-enable <?php if($output['list_setting']['gold_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_open'];?>"><span><?php echo $lang['gold_isuse_open'];?></span></label>
            <label for="gold_isuse_0"class="cb-disable <?php if($output['list_setting']['gold_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_close'];?>"><span><?php echo $lang['gold_isuse_close'];?></span></label>
            <input type="radio" id="gold_isuse_1" name="gold_isuse" value="1" <?php echo $output['list_setting']['gold_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="gold_isuse_0" name="gold_isuse" value="0" <?php echo $output['list_setting']['gold_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['gold_isuse_notice'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="site_name"><?php echo $lang['gold_rmbratio'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span><?php echo $lang['gold_rmbratiodesc_1'];?> </span>
            <input id="gold_rmbratio" name="gold_rmbratio" value="<?php echo $output['list_setting']['gold_rmbratio'];?>" class="txt" type="text" style=" width:50px;">
            <span><?php echo $lang['gold_rmbratiodesc_2'];?></span></td>
          <td class="vatop tips">&nbsp;</td>
        </tr>
        <!-- 积分启用 -->
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['points_isuse'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="points_isuse_1" class="cb-enable <?php if($output['list_setting']['points_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_open'];?>"><span><?php echo $lang['points_isuse_open'];?></span></label>
            <label for="points_isuse_0" class="cb-disable <?php if($output['list_setting']['points_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_close'];?>"><span><?php echo $lang['points_isuse_close'];?></span></label>
            <input type="radio" id="points_isuse_1" name="points_isuse" value="1" <?php echo $output['list_setting']['points_isuse'] ==1?'checked=checked':''; ?>>
            <input type="radio" id="points_isuse_0" name="points_isuse" value="0" <?php echo $output['list_setting']['points_isuse'] ==0?'checked=checked':''; ?>>
          <td class="vatop tips"><?php echo $lang['points_isuse_notice'];?></td>
        </tr>
        
        
        <tr >
          <td colspan="2" class="required"><?php echo $lang['open_pointshop_isuse'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="pointshop_isuse_1" class="cb-enable <?php if($output['list_setting']['pointshop_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="pointshop_isuse_0" class="cb-disable <?php if($output['list_setting']['pointshop_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input id="pointshop_isuse_1" name="pointshop_isuse" <?php if($output['list_setting']['pointshop_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="pointshop_isuse_0" name="pointshop_isuse" <?php if($output['list_setting']['pointshop_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo sprintf($lang['open_pointshop_isuse_notice'],"index.php?act=setting&op=pointshop_setting");?></td>
        </tr>
        <!-- 促销开启 -->
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['promotion_allow'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="promotion_allow_1" class="cb-enable <?php if($output['list_setting']['promotion_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="promotion_allow_0" class="cb-disable <?php if($output['list_setting']['promotion_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input type="radio" id="promotion_allow_1" name="promotion_allow" value="1" <?php echo $output['list_setting']['promotion_allow'] ==1?'checked=checked':''; ?>>
            <input type="radio" id="promotion_allow_0" name="promotion_allow" value="0" <?php echo $output['list_setting']['promotion_allow'] ==0?'checked=checked':''; ?>>
          <td class="vatop tips"><?php echo $lang['promotion_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['groupbuy_allow'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="groupbuy_allow_1" class="cb-enable <?php if($output['list_setting']['groupbuy_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="groupbuy_allow_0" class="cb-disable <?php if($output['list_setting']['groupbuy_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input id="groupbuy_allow_1" name="groupbuy_allow" <?php if($output['list_setting']['groupbuy_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="groupbuy_allow_0" name="groupbuy_allow" <?php if($output['list_setting']['groupbuy_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['groupbuy_isuse_notice'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>

$(function(){$("#submitBtn").click(function(){
    if($("#settingForm").valid()){
     $("#settingForm").submit();
	}
	});
});
//
$(document).ready(function(){
	$("#settingForm").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            gold_rmbratio : {
                required : true,
                digits   : true,
                min    :1
            }
        },
        messages : {
            gold_rmbratio  : {
                required : '<?php echo $lang['gold_rmbratio_isnum'];?>',
                digits   : '<?php echo $lang['gold_rmbratio_isnum'];?>',
                min    :'<?php echo $lang['gold_rmbratio_min'];?>'
            }
        }
	});
});
</script> 
