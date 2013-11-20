<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form action="" id="adv_edit_form" method="post">
      <input type="hidden" name="formsubmit" value="ok" />
      <input type="hidden" name="adv_id" value="<?php echo $output['adv_list']['adv_id']; ?>" />
      <dl>
        <dt><?php echo $lang['adv_title']; ?></dt>
        <dd><?php echo $output['adv_list']['adv_title']; ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_endtime']; ?></dt>
        <dd><?php echo date('Y-m-d',$output['adv_list']['adv_end_date']); ?>
          <input type="hidden" name="overtime" value="<?php echo $output['adv_list']['adv_end_date']; ?>" >
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['adv_price']; ?></dt>
        <dd><?php echo $output['ap_list']['ap_price']; ?>&nbsp;&nbsp;<?php echo $lang['adv_price_unit']; ?>
          <input type="hidden" name="ap_price" value="<?php echo $output['ap_list']['ap_price']; ?>">
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em>&nbsp;<?php echo $lang['adv_add_month']; ?></dt>
        <dd>
          <input name="buy_month" type="text" class="text">
          &nbsp;&nbsp;<?php echo $lang['adv_month_info']; ?></dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
	$(function(){
	$('#adv_edit_form').validate({
        rules : {
            buy_month : {
                required : true,
				digits	 : true,
				min		 : 1
            }
        },
        messages : {
            buy_month : {
            	required : '<?php echo $lang['adv_buymonth_cannot_null']; ?>',
				digits   : '<?php echo $lang['adv_buymonth_must_pos_int']; ?>',
				min		 : '<?php echo $lang['adv_buymonth_must_pos_int']; ?>'
            }
        }
    });
	});
</script> 
