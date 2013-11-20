<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_coupon_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=coupon&op=list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['coupon_name'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="coupon_title" name="coupon_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_price'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="coupon_exchange" name="coupon_exchange" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_store_name'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="coupon_store" name="coupon_store" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['coupon_store_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_class'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="coupon_class">
              <?php if(is_array($output['coupon_class'])&&!empty($output['coupon_class'])){?>
              <?php foreach($output['coupon_class'] as $key=>$class){?>
              <option value="<?php echo $class['class_id']; ?>"> <?php echo $class['class_name']?></option>
              <?php }?>
              <?php }?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_lifetime'];?>:
            </th></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="coupon_start_date" name="coupon_start_date" readonly="readonly" />
            ~
            <input type="text" id="coupon_end_date" name="coupon_end_date" readonly="readonly" /></td>
          <td class="vatop tips"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_pic'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="file" id="coupon_banner" name="coupon_banner"></td>
          <td class="vatop tips"><?php echo $lang['coupon_coupon_pic_notice'];?></td>
          
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_notice'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea class="tarea" name="coupon_desc" rows="6" id="coupon_desc"></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_coupon_state'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="state1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="state" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label></td>
          <input type="radio" name="coupon_state" value="2" id="state1" checked="checked"/>
          <input type="radio" name="coupon_state" value="1" id="state0" />
          <td class="vatop tips"><?php echo $lang['coupon_state_notice'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_lock'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          <label for="lock1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="lock2" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label>
          <input type="radio" name="coupon_lock" value="2" id="lock2" checked="checked"/>
          <input type="radio" name="coupon_lock" value="1" id="lock1" /></td>
          <td class="vatop tips"><?php echo $lang['coupon_lock_notice'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot"><td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script src="<?php echo RESOURCE_PATH."/js/jquery-ui/jquery.ui.js";?>" charset="utf-8"></script> 
<script src="<?php echo RESOURCE_PATH."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#add_form").valid()){
     $("#add_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#coupon_start_date').datepicker({onSelect:function(dateText,inst){
    	var year2 = dateText.split('-') ;
    	$('#coupon_end_date').datepicker( "option", "minDate", new Date(parseInt(year2[0]),parseInt(year2[1])-1,parseInt(year2[2])) );
    }});
    $('#coupon_end_date').datepicker({onSelect:function(dateText,inst){
    	var year1 = dateText.split('-') ;
    	$('#coupon_start_date').datepicker( "option", "maxDate", new Date(parseInt(year1[0]),parseInt(year1[1])-1,parseInt(year1[2])) );
    }})
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
        	coupon_title: {
        		required : true
        	},
        	coupon_exchange: {
				required : true 
            },
            coupon_store: {
				required : true ,
				remote   : {
	               	url :'index.php?act=coupon&op=ajax&branch=check_store_name',
	                type:'get',
	                data:{
	                    store_name : function(){
	                        return $('#coupon_store').val();
	                        }
	                    }
	            }
            },
            coupon_banner : {
				required : true 
            },
        	coupon_desc: {
        		required : true
        	},
        	coupon_start_date: {
				required : true 
            },
            coupon_end_date: {
            	required : true 
            },
            coupon_class : {
				required : true
            }
        },
        messages : {
      		coupon_title: {
       			required : '<?php echo $lang['coupon_name_null'];?>'
	    	},
	    	coupon_exchange: {
				required : '<?php echo $lang['coupon_price_error'];?>'
		    },
		    coupon_store: {
				required : '<?php echo $lang['coupon_store_null'];?>',
				remote : '<?php echo $lang['coupon_store_name_null'];?>'
			},
			coupon_banner : {
				required : '<?php echo $lang['coupon_pic_null'];?>' 
            },
        	coupon_desc: {
        		required : '<?php echo $lang['coupon_notice_null'];?>'
        	},
        	coupon_start_date: {
        		required : '<?php echo $lang['coupon_start_time_null'];?>'
            },
            coupon_end_date: {
            	required : '<?php echo $lang['coupon_end_time_null'];?>'
            },
            coupon_class : {
				required : '<?php echo $lang['coupon_class_null'];?>'
            }
        }
	});
});
</script> 
