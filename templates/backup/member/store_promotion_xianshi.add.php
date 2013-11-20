<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="wrap"><!-- 说明 -->
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form id="add_form" action="index.php?act=store_promotion_xianshi&op=xianshi_save" method="post">
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['xianshi_name'];?><?php echo $lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="xianshi_name" name="xianshi_name" type="text"  maxlength="25" class="text w400"/>
            <span></span> </p>
          <p class="hint"><?php echo $lang['xianshi_name_explain'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['start_time'];?><?php echo $lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="start_time" name="start_time" type="text" class="text" />
            <span></span> </p>
          <p class="hint"><?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d',$output['current_xianshi_quota']['start_time']));?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['end_time'];?><?php echo $lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="end_time" name="end_time" type="text" class="text"/>
            <span></span> </p>
          <p class="hint"><?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d',$output['current_xianshi_quota']['end_time']));?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['xianshi_discount'];?><?php echo $lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="discount" name="discount" type="text" class="text w70"/>
            <span></span> </p>
          <p class="hint"><?php echo $lang['xianshi_discount_explain'];?></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input id="submit_button" type="submit"  class="submit" value="<?php echo $lang['nc_submit'];?>">
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript">
$(document).ready(function(){
    $('#start_time').datepicker();
    $('#end_time').datepicker();

    jQuery.validator.methods.greaterThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };
    jQuery.validator.methods.lessThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 > date2;
    };
    jQuery.validator.methods.greaterThanStartDate = function(value, element) {
        var start_date = $("#start_time").val();
        var date1 = new Date(Date.parse(start_date.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };


    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('p').children('span');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
            rules : {
                xianshi_name : {
                    required : true
                },
                start_time : {
                    required : true,
                    dateISO : true,
                    greaterThanDate : '<?php echo date('Y-m-d',$output['current_xianshi_quota']['start_time']);?>'
                },
                end_time : {
                    required : true,
                    dateISO : true,
                    lessThanDate : '<?php echo date('Y-m-d',$output['current_xianshi_quota']['end_time']);?>',
                    greaterThanStartDate : true 
                },
                discount : {
                    required : true,
                    number : true,
                    max : 9.9,
                    min : 0.1
                }
            },
                messages : {
                    xianshi_name : {
                        required : '<?php echo $lang['xianshi_name_error'];?>'
                    },
                    start_time : {
                        required : '<?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d',$output['current_xianshi_quota']['start_time']));?>',
                        dateISO : '<?php echo $lang['time_error'];?>',
                        greaterThanDate : '<?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d',$output['current_xianshi_quota']['start_time']));?>'
                    },
                    end_time : {
                        required : '<?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d',$output['current_xianshi_quota']['end_time']));?>',
                        dateISO : '<?php echo $lang['time_error'];?>',
                        lessThanDate : '<?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d',$output['current_xianshi_quota']['end_time']));?>',
                        greaterThanStartDate : '<?php echo $lang['greater_than_start_time'];?>'
                    },
                    discount : {
                        required : '<?php echo $lang['xianshi_discount_explain'];?>',
                        number : '<?php echo $lang['xianshi_discount_explain'];?>',
                        max : '<?php echo $lang['xianshi_discount_explain'];?>',
                        min : '<?php echo $lang['xianshi_discount_explain'];?>'
                    }
                }
    });
});
</script>