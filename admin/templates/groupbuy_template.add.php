<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<script type="text/javascript">
$(document).ready(function(){
    $("#submit").click(function(){
        $("#add_form").submit();
    });
    jQuery.validator.methods.greaterThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };

    jQuery.validator.methods.endDate = function(value, element) {
        var startDate = $("#start_time").val();
        var date1 = new Date(Date.parse(startDate.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };
    
    
    //团购活动起始时间
    $('#start_time').datepicker();
    $('#end_time').datepicker();
    $('#join_end_time').datepicker();
    
	$('#add_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            template_name : {
                required : true
            },
            start_time : {
                required : true,
                dateISO : true,
                greaterThanDate :  '<?php echo date('Y-m-d',$output['max_end_time']);?>'
            },
            end_time : {
                required : true,
                dateISO : true,
                endDate : true
            },
            join_end_time : {
                required : true,
                dateISO : true
            }
        },
        messages : {
            template_name : {
                required :  '<?php echo $lang['template_name_error'];?>'
            },
            start_time : {
                required : '<?php echo $lang['start_time_error'];?>',
                dateISO :  '<?php echo $lang['start_time_error'];?>',
                greaterThanDate :  '<?php echo $lang['start_time_overlap'];?>'
            },
            end_time : {
                required : '<?php echo $lang['end_time_error'];?>',
                dateISO :  '<?php echo $lang['end_time_error'];?>',
                endDate :  '<?php echo $lang['end_time_error'];?>'
            },
            join_end_time : {
                required : '<?php echo $lang['join_end_time_error'];?>',
                dateISO :  '<?php echo $lang['join_end_time_error'];?>'
            }
        }
    });
});
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['groupbuy_index_manage'];?></h3>
      <ul class="tab-base">
          <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
          <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
          <?php }  else { ?>
          <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
          <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
      <tbody>
      <tr class="space odd">
          <th colspan="12" class="nobg"><div class="title">
                  <h5><?php echo $lang['nc_prompts'];?></h5>
                  <span class="arrow"></span></div></th>
      </tr>
      <tr>
          <td><ul>
                  <li><?php echo $lang['groupbuy_template_add_help1'];?></li>
                  <li><?php echo $lang['groupbuy_template_add_help2'];?></li>
          </ul></td>
      </tr>
      </tbody>
  </table>
  <form id="add_form" method="post" action="index.php?act=groupbuy&op=groupbuy_template_save">
      <input name="template_id" type="hidden" value="<?php echo $output['template_info']['template_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="template_name"><?php echo $lang['groupbuy_template_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['template_info']['template_name'];?>" name="template_name" id="template_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang[''];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="start_time"><?php echo $lang['start_time'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" value="" name="start_time" id="start_time" class="txt date-short"><?php echo $lang['day'];?> <select name="start_time_hour" class="valid" style="width:60px; margin-left:8px; margin-left:4px;">
                    <?php
                        foreach ($output['hour_list'] as $key) {
                    ?>
                    <option value="<?php echo $key;?>"><?php echo $key;?></option>
                    <?php } ?>
                </select><?php echo $lang['hour'];?>
        </td>
          <td class="vatop tips"><?php if(!empty($output['max_end_time'])) {echo $lang['groupbuy_start_time_explain'].date('Y-m-d',$output['max_end_time']);} ?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="end_time"><?php echo $lang['end_time'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" value="<?php echo $output['template_info']['end_time'];?>" name="end_time" id="end_time" class="txt date-short"><?php echo $lang['day'];?>
                <select name="end_time_hour" class="valid" style="width:60px; margin-left:8px; margin-left:4px;">
                    <?php
                        foreach ($output['hour_list'] as $key) {
                    ?>
                  <option value="<?php echo $key;?>"><?php echo $key;?></option>
                    <?php } ?>
                </select><?php echo $lang['hour'];?></td>
          <td class="vatop tips"><?php echo $lang[''];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="join_end_time"><?php echo $lang['join_end_time'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform">
                <input type="text" value="<?php echo $output['template_info']['join_end_time'];?>" name="join_end_time" id="join_end_time" class="txt date-short"><?php echo $lang['day'];?>
                <select name="join_end_time_hour" class="valid" style="width:60px; margin-left:8px; margin-left:4px;">
                    <?php
                        foreach ($output['hour_list'] as $key) {
                    ?>
                  <option value="<?php echo $key;?>"><?php echo $key;?></option>
                    <?php } ?>
                </select><?php echo $lang['hour'];?></td>
          <td class="vatop tips"><?php echo $lang[''];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a id="submit" href="javascript:void(0)" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>

