<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form method="post" id="cash_form" action="index.php?act=predeposit&op=predepositcash">
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
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['predeposit_cash_price'].$lang['nc_colon']; ?></dt>
        <dd>
          <p>
            <input name="price" type="text" class="text w50 mr5" id="price" maxlength="10" >
            <?php echo $lang['currency_zh'];?></p>
          <p class="hint mt5"><?php echo $lang['predeposit_cash_price_tip'].$lang['nc_colon']; ?><?php echo $output['member_info']['available_predeposit']; ?>&nbsp;&nbsp;<?php echo $lang['currency_zh']; ?></p>
        </dd>
      </dl>
      <dl class="_offline">
        <dt class="required"><em class="pngFix"></em>&nbsp;<?php echo $lang['predeposit_cash_shoukuanname'].$lang['nc_colon'];?></dt>
        <dd>
          <input name="shoukuan_name" type="text" class="text w100" id="shoukuan_name" maxlength="10"/>
        </dd>
      </dl>
      <dl class="_offline">
        <dt class="required"><em class="pngFix"></em><?php echo $lang['predeposit_cash_shoukuanbank'].$lang['nc_colon']; ?></dt>
        <dd>
          <input name="shoukuan_bank" type="text" class="text w200" id="shoukuan_bank" maxlength="20"/>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['predeposit_cash_shoukuanaccount'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input name="account" type="text" class="text w200" id="account" maxlength="20"/>
          </p>
          <p class="hint"><?php echo $lang['predeposit_cash_shoukuanaccount_tip']; ?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['predeposit_memberremark'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea  name="memberremark" rows="3" class="w400" maxlength="150"></textarea>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp; </dt>
        <dd>
          <input type="submit"  class="submit" value="<?php echo $lang['nc_submit']; ?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function(){
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
	$('#cash_form').validate({
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
            shoukuan_name :{
            	notempty   :true
            },
            shoukuan_bank : {
            	notempty   :true
            },
            account      : {
	        	required  : true
	        }
        },
        messages : {
        	payment_sel      : {
                required:  '<?php echo $lang['predeposit_cash_add_paymentnull_error']; ?>'
            },
            price		: {
            	required  :'<?php echo $lang['predeposit_cash_add_pricenull_error']; ?>',
            	number    :'<?php echo $lang['predeposit_cash_add_pricemin_error']; ?>',
            	min    	  :'<?php echo $lang['predeposit_cash_add_pricemin_error']; ?>'
            },
            shoukuan_name :{
            	notempty   :'<?php echo $lang['predeposit_cash_add_shoukuannamenull_error']; ?>'
            },
            shoukuan_bank : {
            	notempty   :'<?php echo $lang['predeposit_cash_add_shoukuanbanknull_error']; ?>'
            },
            account      : {
	        	required  : '<?php echo $lang['predeposit_cash_add_shoukuanaccountnull_error']; ?>'
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