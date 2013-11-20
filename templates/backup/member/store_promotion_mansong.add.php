<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<input id="level2_flag" type="hidden" value="false" />
<input id="level3_flag" type="hidden" value="false" />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncm-notes mt10">
    <h3><?php echo $lang['nc_explain'].$lang['nc_colon'];?></h3>
    <ul>
      <li><?php echo $lang['mansong_add_explain1'];?></li>
      <li><?php echo $lang['mansong_add_explain2'];?></li>
      <li><?php echo $lang['mansong_add_explain3'];?></li>
    </ul>
  </div>
  <div class="ncu-form-style"> 
    <!-- 说明 -->
    
    <form id="add_form" action="index.php?act=store_promotion_mansong&op=mansong_save" method="post">
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['mansong_name'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="mansong_name" name="mansong_name" type="text" maxlength="25" class="w400 text"/>
            <span></span> </p>
          <p class="hint"><?php echo $lang['mansong_name_explain'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['start_time'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="start_time" name="start_time" type="text" class="text"/>
            <span></span></p>
          <p class="hint"><?php echo sprintf($lang['mansong_add_start_time_explain'],date('Y-m-d',$output['start_time']));?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['end_time'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="end_time" name="end_time" type="text" class="text"/>
            <span></span> </p>
          <p class="hint"><?php echo sprintf($lang['mansong_add_end_time_explain'],date('Y-m-d',$output['end_time']));?></p>
        </dd>
      </dl>
      <!-- 级别1 -->
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['text_level'].'1';?><?php echo $lang['nc_colon'];?></dt>
        <dd>
          <p> <?php echo $lang['text_level_condition'];?>
            <input name="level1_price" type="text" class="text w50 mr5" id="level1_price" maxlength="10"/>
            <?php echo $lang['text_yuan'];?></p>
          <p class="mt10">
            <input id="level1_discount_flag" name="level1_discount_flag" type="checkbox" />
            <?php echo $lang['text_reduce'];?>&nbsp;
            <input name="level1_discount" type="text" class="text w50 mr5" id="level1_discount" maxlength="10"/>
            <?php echo $lang['text_yuan'].$lang['text_cash'];?></p>
          <p class="mt10">
            <input id="level1_shipping_free_flag" name="level1_shipping_free_flag" type="checkbox" />
            <?php echo $lang['shipping_free'];?> </p>
          <p class="mt10">
            <input id="level1_gift_flag" name="level1_gift_flag" type="checkbox" />
            <?php echo $lang['text_give'];?>
            <input id="level1_gift_name" name="level1_gift_name" type="text" maxlength="25" class="text w100"/>
            <?php echo $lang['text_gift'].$lang['nc_comma'];?><?php echo $lang['text_gift'].$lang['text_link'];?>
            <input id="level1_gift_link" name="level1_gift_link" type="text" placeholder="<?php echo $lang['link_explain'];?>" maxlength="100" class="text w300 ml5"/>
          </p>
          <p class="mt20"><a id="btn_level2_switch" href="javascript:void(0)" class="ncu-btn1"><span><?php echo $lang['text_new_level'];?></span></a> </p>
        </dd>
      </dl>
      <!-- 级别2 -->
      <dl class="level2" style="display:none;">
        <dt class="required"><em class="pngFix"></em><?php echo $lang['text_level'].'2'.$lang['nc_colon'];?></dt>
        <dd>
          <p><?php echo $lang['text_level_condition'];?>
            <input id="level2_price" name="level2_price" type="text" class="text w50 mr5" maxlength="10" />
            <?php echo $lang['text_yuan'];?></p>
          <p class="mt10">
            <input id="level2_discount_flag" name="level2_discount_flag" type="checkbox" />
            <?php echo $lang['text_reduce'];?>&nbsp;
            <input id="level2_discount" name="level2_discount" type="text" class="text w50 mr5"/>
            <?php echo $lang['text_yuan'].$lang['text_cash'];?></p>
          <p class="mt10">
            <input id="level2_shipping_free_flag" name="level2_shipping_free_flag" type="checkbox" />
            <?php echo $lang['shipping_free'];?></p>
          <p class="mt10">
            <input id="level2_gift_flag" name="level2_gift_flag" type="checkbox" />
            <?php echo $lang['text_give'];?>
            <input id="level2_gift_name" name="level2_gift_name" type="text" maxlength="25" class="text w100"/>
            <?php echo $lang['text_gift'].$lang['nc_comma'];?><?php echo $lang['text_gift'].$lang['text_link'];?>
            <input id="level2_gift_link" name="level2_gift_link" type="text" placeholder="<?php echo $lang['link_explain'];?>" maxlength="100" class="text w300"/>
          </p>
          <p  class="mt20"><a id="btn_level3_switch" href="javascript:void(0)" class="ncu-btn1 mr20"><span><?php echo $lang['text_new_level'];?></span></a> <a id="btn_level2_close" href="javascript:void(0)" class="ncu-btn1"><span><?php echo $lang['nc_cancel'];?></span></a> </p>
        </dd>
      </dl>
      <!-- 级别3 -->
      <dl class="level3" style="display:none;">
        <dt class="required"><em class="pngFix"></em><?php echo $lang['text_level'].'3'.$lang['nc_colon'];?></dt>
        <dd>
          <p><?php echo $lang['text_level_condition'];?>
            <input name="level3_price" type="text" class="text w50 mr5" id="level3_price" maxlength="10" />
            <?php echo $lang['text_yuan'];?></p>
          <p class="mt10">
            <input id="level3_discount_flag" name="level3_discount_flag" type="checkbox" />
            <?php echo $lang['text_reduce'];?>&nbsp;
            <input name="level3_discount" type="text" id="level3_discount" maxlength="10" clas="text w50 mr5" />
            <?php echo $lang['text_yuan'].$lang['text_cash'];?></p>
          <p class="mt10">
            <input id="level3_shipping_free_flag" name="level3_shipping_free_flag" type="checkbox" clas="w50 mr5" />
            <?php echo $lang['shipping_free'];?></p>
          <p class="mt10">
            <input id="level3_gift_flag" name="level3_gift_flag" type="checkbox" class="text" />
            <?php echo $lang['text_give'];?>
            <input id="level3_gift_name" name="level3_gift_name" type="text" maxlength="25" class="w100"/>
            <?php echo $lang['text_gift'].$lang['nc_comma'];?><?php echo $lang['text_gift'].$lang['text_link'];?>
            <input id="level3_gift_link" name="level3_gift_link" type="text" placeholder="<?php echo $lang['link_explain'];?>" maxlength="100" class="w300 text"/>
          </p>
          <p class="mt20"><a id="btn_level3_close" href="javascript:void(0)" class="ncu-btn1"><span><?php echo $lang['nc_cancel'];?></span></a></p>
          </p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['text_remark'].$lang['nc_colon'];?></dt>
        <dd>
          <p class="textarea">
            <textarea name="remark" rows="3" id="remark" maxlength="100" class="textarea w400"></textarea>
          </p>
          <p class="hint"><?php echo $lang['mansong_remark_explain'];?></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>"  class="submit">
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript">
$(document).ready(function(){
    $('#start_time').datepicker();
    $('#end_time').datepicker();

    //级别限时控制

    $("#btn_level2_switch").click(function(){
        $(".level2").show();
        $("#btn_level2_switch").hide();
        $("#level2_flag").val('true');
    });
    $("#btn_level3_switch").click(function(){
        $(".level3").show();
        $("#btn_level3_switch").hide();
        $("#btn_level2_close").hide();
        $("#level3_flag").val('true');
    });
    $("#btn_level2_close").click(function(){
        $(".level2").hide();
        $("#level2_price").val('');
        $("#level2_discount").val('');
        $("#level2_gift_name").val('');
        $("#level2_gift_link").val('');
        $("#level2_discount_flag").attr("checked",false);
        $("#level2_shipping_free_flag").attr("checked",false);
        $("#level2_gift_flag").attr("checked",false);
        $("#btn_level2_switch").show();
        $("#level2_flag").val('false');
    });
    $("#btn_level3_close").click(function(){
        $(".level3").hide();
        $("#level3_price").val('');
        $("#level3_discount").val('');
        $("#level3_gift_name").val('');
        $("#level3_gift_link").val('');
        $("#level3_discount_flag").attr("checked",false);
        $("#level3_shipping_free_flag").attr("checked",false);
        $("#level3_gift_flag").attr("checked",false);
        $("#btn_level3_switch").show();
        $("#btn_level2_close").show();
        $("#level3_flag").val('false');
    });

    $("#submit_button").click(function(){
        var level1_price = $("#level1_price").val();
        var level2_price = $("#level2_price").val();
        var level3_price = $("#level3_price").val();
        var flag = true;
        if(level1_price != '') {
            flag = check_rule_select('level1');
            if(level2_price != '' && flag == true) {
                if(parseInt(level2_price) <= parseInt(level1_price)) {
                    flag = false;
                    alert('<?php echo $lang['mansong_level_error'];?>');
                }
                else {
                    flag = check_rule_select('level2');
                    if(level3_price != '' && flag == true) {
                        if(parseInt(level3_price) <= parseInt(level2_price)) {
                            flag = false;
                            alert('<?php echo $lang['mansong_level_error'];?>');
                        }
                        else {
                            flag = check_rule_select('level3');
                        }
                    }

                }
            }
        }
        if(flag) {
        	if($("#add_form").valid()){
        		ajaxpost('add_form', '', '', 'onerror');
        		return false;
            }
        }else{
        	return false;
        }
    });

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
     	/*submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},*/
            rules : {
                mansong_name : {
                    required : true
                },
                start_time : {
                    required : true,
                    dateISO : true,
                    greaterThanDate : '<?php echo date('Y-m-d',$output['start_time']);?>'
                },
                end_time : {
                    required : true,
                    dateISO : true,
                    lessThanDate : '<?php echo date('Y-m-d',$output['end_time']);?>',
                    greaterThanStartDate : true 
                },
                level1_price : {
                    required : true,
                    digits : true,
                    min : 0
                },
                level1_discount : {
                    required : function() { return $("#level1_discount_flag").attr('checked');} ,
                    digits : true,
                    min : 0
                },
                level1_gift_name : {
                    required : function() { return $("#level1_gift_flag").attr('checked');} 
                },
                level2_price : {
                    required : function() { return $("#level2_flag").val() == 'true';} ,
                    digits : true,
                    min : 0
                },
                level2_discount : {
                    required : function() { return $("#level2_discount_flag").attr('checked');} ,
                    digits : true,
                    min : 0
                },
                level2_gift_name : {
                    required : function() { return $("#level2_gift_flag").attr('checked');}
                },
                level3_price : {
                    required : function() { return $("#level3_flag").val() == 'true';} ,
                    digits : true,
                    min : 0
                },
                level3_discount : {
                    required : function() { return $("#level3_discount_flag").attr('checked');} ,
                    digits : true,
                    min : 0
                },
                level3_gift_name : {
                    required : function() { return $("#level3_gift_flag").attr('checked');} 
                }
            },
                messages : {
                    mansong_name : {
                        required : '<?php echo $lang['mansong_name_error'];?>'
                    },
                    start_time : {
                        required : '<?php echo sprintf($lang['mansong_add_start_time_explain'],date('Y-m-d',$output['start_time']));?>',
                        dateISO : '<?php echo $lang['time_error'];?>',
                        greaterThanDate : '<?php echo sprintf($lang['mansong_add_start_time_explain'],date('Y-m-d',$output['start_time']));?>'
                    },
                    end_time : {
                        required : '<?php echo sprintf($lang['mansong_add_end_time_explain'],date('Y-m-d',$output['end_time']));?>',
                        dateISO : '<?php echo $lang['time_error'];?>',
                        lessThanDate : '<?php echo sprintf($lang['mansong_add_end_time_explain'],date('Y-m-d',$output['end_time']));?>',
                        greaterThanStartDate : '<?php echo $lang['greater_than_start_time'];?>'
                    },
                    level1_price : {
                        required : '<?php echo $lang['mansong_level_price_error'];?>',
                        digits : '<?php echo $lang['mansong_level_price_error'];?>',
                        min : '<?php echo $lang['mansong_level_price_error'];?>'
                    },
                    level1_discount : {
                        required : '<?php echo $lang['mansong_level_discount_null'];?>',
                        digits : '<?php echo $lang['mansong_level_discount_error'];?>',
                        min : '<?php echo $lang['mansong_level_discount_error'];?>'
                    },
                    level1_gift_name : {
                        required : '<?php echo $lang['mansong_level_gift_error'];?>'
                    },
                    level2_price : {
                        required : '<?php echo $lang['mansong_level_price_error'];?>',
                        digits : '<?php echo $lang['mansong_level_price_error'];?>',
                        min : '<?php echo $lang['mansong_level_price_error'];?>'
                    },
                    level2_discount : {
                        required : '<?php echo $lang['mansong_level_discount_null'];?>',
                        digits : '<?php echo $lang['mansong_level_discount_error'];?>',
                        min : '<?php echo $lang['mansong_level_discount_error'];?>'
                    },
                    level2_gift_name : {
                        required : '<?php echo $lang['mansong_level_gift_error'];?>'
                    },
                    level3_price : {
                        required : '<?php echo $lang['mansong_level_price_error'];?>',
                        digits : '<?php echo $lang['mansong_level_price_error'];?>',
                        min : '<?php echo $lang['mansong_level_price_error'];?>'
                    },
                    level3_discount : {
                        required : '<?php echo $lang['mansong_level_discount_null'];?>',
                        digits : '<?php echo $lang['mansong_level_discount_error'];?>',
                        min : '<?php echo $lang['mansong_level_discount_error'];?>'
                    },
                    level3_gift_name : {
                        required : '<?php echo $lang['mansong_level_gift_error'];?>'
                    }
                }
    });
});

//检查级别选中状态
function check_rule_select(level) {
    if($("#"+level+"_discount_flag").attr("checked") == false && $("#"+level+"_shipping_free_flag").attr("checked") == false && $("#"+level+"_gift_flag").attr("checked") == false) {
        alert('<?php echo $lang['mansong_level_rule_select_error'];?>');
        return false;
    }
    else {
        return true;
    }
}
</script>