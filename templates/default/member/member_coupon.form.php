<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<div class="eject_con">
  <div id="warning"></div>
  <form method="post" action="index.php?act=store&op=store_coupon" id="coupon_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" value="<?php echo $output['type']; ?>" />
    <input type="hidden" name="coupon_id" value="<?php echo $output['coupon']['coupon_id']; ?>" />
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_coupon_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="w300 text" name="coupon_name" value="<?php echo $output['coupon']['coupon_title'];?>"/>
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_coupon_price'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text w50 mr5"  name="coupon_value" value="<?php echo $output['coupon']['coupon_price']?$output['coupon']['coupon_price']:10; ?>" /><?php echo $lang['currency_zh'];?>
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_coupon_class'].$lang['nc_colon'];?></dt>
      <dd>
        <select name="coupon_class">
          <?php if(is_array($output['coupon_class'])&&!empty($output['coupon_class'])){?>
          <?php foreach($output['coupon_class'] as $key=>$class){?>
          <option value="<?php echo $class['class_id']; ?>" <?php if($class['class_id']==$output['coupon']['coupon_class_id']){?>selected="selected"<?php }?> > <?php echo $class['class_name']?></option>
          <?php }?>
          <?php }?>
        </select>
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_coupon_pic'].$lang['nc_colon'];?></dt>
      <dd>
        <p>
          <textarea name="coupon_pic" rows="2" class="textarea w300"><?php echo $output['coupon']['coupon_pic'];?></textarea>
        </p>
        <p class="hint"><?php echo $lang['store_coupon_coupon_pic_notice'];?><br/><?php echo $lang['store_coupon_coupon_pic_notice_one'];?><a target="_blank" href="index.php?act=store_album&op=album_cate"><strong class="orange ml5 mr5"><?php echo $lang['nc_member_path_album'];?></strong></a><?php echo $lang['store_coupon_coupon_pic_notice_two'];?></p>
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_coupon_lifetime'].$lang['nc_colon'];?></dt>
      <?php if($output['coupon']!=''){?>
      <dd>
        <p>
          <input type="text" class="text"  name="start_time"  id="add_time_from" readonly="readonly" value=<?php echo $output['coupon']['coupon_start_date']; ?> />
          <?php echo $lang['store_coupon_to'];?>
          <input type="text" class="text"  name="end_time"  id="add_time_to" readonly="readonly" value=<?php echo $output['coupon']['coupon_end_date']; ?> />
        </p>
        <?php }else{?>
        <p>
          <input type="text" class="text" name="start_time"  id="add_time_from" readonly="readonly"  />
          <?php echo $lang['store_coupon_to'];?>
          <input type="text" class="text" name="end_time"  id="add_time_to" readonly="readonly"  />
        </p>
        <?php }?>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_coupon_notice'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea class="w300" name="coupon_desc" rows="3" ><?php echo $output['coupon']['coupon_desc']; ?></textarea>
      </dd>
    </dl>
    <?php if($output['coupon']['coupon_allowstate']==2&&!empty($output['coupon']['coupon_allowremark'])){?>
    <dl>
      <dt><?php echo $lang['store_coupon_allow_remark'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['coupon']['coupon_allowremark']; ?></dd>
    </dl>
    <?php }?>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <p><input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" /></p>
        <?php if($output['coupon']['coupon_allowstate']==1){?>
        <p class="hint"><?php echo $lang['store_coupon_allow_notice'];?></p>
        <?php }?>
      </dd>
    </dl>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script> 
<script type="text/javascript" charset="utf-8" >
//<!CDATA[
$(function(){
    $('#coupon_form').validate({
         errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
     	submitHandler:function(form){
    		ajaxpost('coupon_form', '', '', 'onerror'); 
    	},
        rules : {
            coupon_name : {
                required : true
            },
            coupon_value : {
                required : true,
                number : true,
                min : 1
            },
            coupon_pic : {
                required : true
            },
            start_time : {
                required : true
            },
            end_time : {
                required : true
            }
        },
            messages : {
            coupon_name : {
                required : '<?php echo $lang['store_coupon_name_null'];?>'
            },
            coupon_value : {
                required : '<?php echo $lang['store_coupon_price_error'];?> ',
                number : '<?php echo $lang['store_coupon_price_min'];?>',
                min : '<?php echo $lang['store_coupon_price_min'];?>'
            },
            coupon_pic : {
								required : '<?php echo $lang['store_coupon_pic_null'];?>'
            },
            start_time : {
                required : '<?php echo $lang['store_coupon_start_time_null'];?>'
            },
            end_time : {
                required : '<?php echo $lang['store_coupon_end_time_null'];?>'
            }
        }
    });
    $('#add_time_from').datepicker({onSelect:function(dateText,inst){
    	var year2 = dateText.split('-') ;
    	$('#add_time_to').datepicker( "option", "minDate", new Date(parseInt(year2[0]),parseInt(year2[1])-1,parseInt(year2[2])) );
    }});
    $('#add_time_to').datepicker({onSelect:function(dateText,inst){
    	var year1 = dateText.split('-') ;
    	$('#add_time_from').datepicker( "option", "maxDate", new Date(parseInt(year1[0]),parseInt(year1[1])-1,parseInt(year1[2])) );
    }})        
})


//]]>
</script>