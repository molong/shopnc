<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form method="post" id="recharge_form" action="index.php?act=predeposit">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['predeposit_payment'].$lang['nc_colon']; ?></dt>
        <dd>
          <?php if (is_array($output['payment_array']) && count($output['payment_array'])>0){?>
          <select name="payment_sel" id="payment_sel">
            <option value=""><?php echo $lang['nc_please_choose']; ?></option>
            <?php foreach ($output['payment_array'] as $k=>$v){?>
            <option value="<?php echo $v['payment_code'];?>" title="<?php echo $v['payment_info'];?>"><?php echo $v['payment_name'];?></option>
            <?php }?>
          </select>
          <?php }?>
        </dd>
      </dl>
      <?php if (is_array($output['payment_array']) && count($output['payment_array'])>0){?>
      <?php foreach ($output['payment_array'] as $k=>$v){?>
      <?php if ($v['payment_code'] == 'offline'){?>
      <pre><h3 class="_offline"><?php echo $v['payment_info'];?> </h3></pre>
      <?php }?>
      <?php }?>
      <?php }?>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['predeposit_recharge_price'].$lang['nc_colon']; ?></dt>
        <dd>
          <input name="price" type="text" class="text w50 mr5" id="price" maxlength="10"/>
          <?php echo $lang['currency_zh'];?> </dd>
      </dl>
      <dl class="_offline">
        <dt class="required"><em class="pngFix"></em><?php echo $lang['predeposit_recharge_huikuanname'].$lang['nc_colon']; ?></dt>
        <dd>
          <input name="huikuan_name" type="text" id="huikuan_name" maxlength="10" class="text w100" />
        </dd>
      </dl>
      <dl class="_offline">
        <dt class="required"><em class="pngFix"></em>&nbsp;<?php echo $lang['predeposit_recharge_huikuanbank'].$lang['nc_colon']; ?></dt>
        <dd>
          <input name="huikuan_bank" type="text" class="text w200" id="huikuan_bank" maxlength="20"/>
        </dd>
      </dl>
      <dl class="_offline">
        <dt class="required"><em class="pngFix"></em><?php echo $lang['predeposit_recharge_huikuandate'].$lang['nc_colon']; ?></dt>
        <dd>
          <input type="text" class="text" name="huikuan_date" id="huikuan_date"/>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['predeposit_recharge_memberremark'].$lang['nc_colon']; ?></dt>
        <dd>
          <textarea name="memberremark" rows="3" class="w400" maxlength="150" ></textarea>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp; </dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['nc_submit']; ?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" ></script> 
<script type="text/javascript">
$(function(){
	$('#huikuan_date').datepicker({dateFormat: 'yy-mm-dd'});
	//线下内容显示与隐藏
	showofflinetr();
	$("#payment_sel").change(function(){ showofflinetr(); });
	//表单验证
	jQuery.validator.addMethod("notempty", function(value, element, param) {
		var payment_sel = $("#payment_sel").val();
		if(payment_sel == 'offline' && $.trim(value) == ''){
			return false;
		}else{
			return true;
		}
	}, "");
	$('#recharge_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
        	payment_sel      : {
	        	required  : true
	        },
        	price      : {
	        	required  : true,
	            number    : true,
	            min       : 0.01
            },
            huikuan_name :{
            	notempty   :true
            },
            huikuan_bank : {
            	notempty   :true
            },
            huikuan_date : {
            	notempty   :true
            }
        },
        messages : {
        	payment_sel      : {
                required:  '<?php echo $lang['predeposit_recharge_add_paymentnull_error']?>'
            },
            price		: {
            	required  :'<?php echo $lang['predeposit_recharge_add_pricenull_error']; ?>',
            	number    :'<?php echo $lang['predeposit_recharge_add_pricemin_error']; ?>',
                min    	  :'<?php echo $lang['predeposit_recharge_add_pricemin_error']; ?>'
            },
            huikuan_name :{
            	notempty   :'<?php echo $lang['predeposit_recharge_add_huikuannamenull_error']; ?>'
            },
            huikuan_bank : {
            	notempty   :'<?php echo $lang['predeposit_recharge_add_huikuanbanknull_error']; ?>'
            },
            huikuan_date : {
            	notempty   :'<?php echo $lang['predeposit_recharge_add_huikuandatenull_error']; ?>'
            }
        }
    });
});
function showofflinetr(){
	var payment_sel = $("#payment_sel").val();
	if(payment_sel == 'offline'){
		$("._offline").show();
	}else{
		$("._offline").hide();
	}
}
</script>