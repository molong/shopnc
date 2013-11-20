<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
<div class="tabmenu">
  <?php include template('member/member_submenu');?>
</div>
<div class="ncu-form-style">
  <form action="index.php?act=member_pointsexchange" id="exchange_form" method="post">
    <input type="hidden" value="ok" name="form_submit">
    <?php if ($output['ucenter_type'] == 'phpwind') { ?>
    <h3><?php echo $lang['member_pointorder_exchange_info'];?></h3>
    <dl>
      <dt><?php echo $lang['member_pointorder_exchange_my_credit'].$lang['nc_colon'];?> </dt>
      <dd><?php echo $output['member_points']?></dd>
    </dl>
    <?php } else {?>
    <h3><?php echo $lang['member_pointorder_exchange_app'];?></h3>
    <dl>
      <dt><?php echo $lang['member_pointorder_exchange_my_credit'].$lang['nc_colon'];?> </dt>
      <dd><?php echo $output['member_points']?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_pointorder_exchange_my_password'].$lang['nc_colon'];?></dt>
      <dd>
        <p>
          <input type="password" value="" name="password" >
        </p>
        <p class="hint"><?php echo $lang['member_pointorder_exchange_my_password_info'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_pointorder_exchange_pay_credit'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" value="" name="amount" id="amount"  onkeyup="cal_credit();">
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_pointorder_exchange_exchange_credit'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" disabled="" value="" name="des_amount" id="des_amount" >
        <select name="to_credits" id="to_credits"  onChange="cal_credit();">
          <?php foreach($output['creditsettings'] as $id=>$ecredits){?>
          <?php if ($ecredits[ratio]){?>
          <option value="<?php echo $id?>" unit="<?php echo $ecredits['unit']?>" title="<?php echo $ecredits['title']?>" ratio="<?php echo $ecredits['ratio']?>"><?php echo $ecredits['title']?></option>
          <?php }?>
          <?php }?>
        </select>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_pointorder_exchange_exchange_ratio'].$lang['nc_colon'];?> </dt>
      <dd><span>1</span>&nbsp;<span id="org_creditunit"><?php echo $lang['member_pointorder_exchange_credit'];?></span><span id="org_credittitle"></span>&nbsp;<?php echo $lang['member_pointorder_exchange_exchange'];?>&nbsp;<span id="des_creditamount"></span>&nbsp;<span id="des_creditunit"></span><span id="des_credittitle"></span></dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['member_pointorder_exchange_exchange'].$lang['member_pointorder_exchange_credit'];?>">
    </dl>
    </dl>
    <?php } ?>
  </form>
</div>
<script>
function cal_credit() {
	$('#des_creditunit').html($("select[name='to_credits'] option:selected").attr('unit'));
	$('#des_credittitle').html($("select[name='to_credits'] option:selected").attr('title'));
	var ratio = $("select[name='to_credits'] option:selected").attr('ratio');
	$('#des_creditamount').html(Math.round(1/ratio * 100) / 100);
	$('#amount').val(($('#amount').toInt()));
	if($('#amount').val() != 0) {
		$('#des_amount').val(Math.floor(1/ratio * $('#amount').val()));
	} else {
		$('#des_amount').val($('#amount').val());
	}
}
jQuery.fn.toInt = function() {
	var s = parseInt(jQuery(this).val());
	return isNaN(s) ? 0 : s;
}
$(document).ready(function () {
	cal_credit();

  $('#exchange_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
            $(element).attr('name')=='msg_content' && $(element).after().css({display:'block'});
        },
        rules : {
            password : {
                required   : true
            }
        },
        messages : {
            password : {
                required : ''
            }
        }
    });

});
</script>