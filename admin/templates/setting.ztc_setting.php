<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_ztc_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_config'];?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_class"><span><?php echo $lang['admin_ztc_list_title'];?><!-- 申请列表 --></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glist" ><span><?php echo $lang['admin_ztc_goodslist_title']; //'商品列表'?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glog" ><span><?php echo $lang['admin_ztc_loglist_title']; //'金币日志';?></span></a></li>        
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['ztc_isuse'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="ztc_isuse_1" class="cb-enable <?php if($output['list_setting']['ztc_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['ztc_isuse_open'];?>"><span><?php echo $lang['ztc_isuse_open'];?></span></label>
            <label for="ztc_isuse_0" class="cb-disable <?php if($output['list_setting']['ztc_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['ztc_isuse_close'];?>"><span><?php echo $lang['ztc_isuse_close'];?></span></label>
            <input type="radio" id="ztc_isuse_1" name="ztc_isuse" value="1" <?php echo $output['list_setting']['ztc_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="ztc_isuse_0" name="ztc_isuse" value="0" <?php echo $output['list_setting']['ztc_isuse']==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"><?php echo $lang['ztc_isuse_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="site_name"><?php echo $lang['ztc_dayprod'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="ztc_dayprod" name="ztc_dayprod" value="<?php echo $output['list_setting']['ztc_dayprod'];?>" class="infoTableInput" type="text" style="width:50px;">
            <?php echo $lang['ztc_unit'];?></td>
          <td class="vatop tips"></td>
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
//按钮先执行验证再提交表单
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
            ztc_dayprod : {
                required : true,
                digits   : true,
                min    :1
            }
        },
        messages : {
            ztc_dayprod  : {
                required : '<?php echo $lang['ztc_dayprod_isnum'];?>',
                digits   : '<?php echo $lang['ztc_dayprod_isnum'];?>',
                min    :'<?php echo $lang['ztc_dayprod_min'];?>'
            }
        }
	});
});
</script>