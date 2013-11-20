<div class="eject_con">

    <div id="warning"></div>
    <form id="post_form" method="post" action="index.php?act=store_gbuy&op=payment">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="gbuy_id" value="<?php echo $output['gold_buy']['gbuy_id']; ?>" />
      <dl>
        <dt><?php echo $lang['store_gbuy_price'].$lang['nc_colon'];?></dt>
        <dd class="goods-price"><?php echo $output['gold_buy']['gbuy_price']; ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_gbuy_payment'].$lang['nc_colon'];?></dt>
        <dd>
          <ul class="checked">
            <?php foreach ($output['payment_list'] as $key => $val) { ?>
            <li>
              <p>
                <label>
                  <input type="radio" name="gbuy_check_type" value="<?php echo $val['payment_code'];?>" <?php if ($key==0) echo 'checked="checked"'; ?> />
                  <?php echo $val['payment_name'];?> </label>
              </p>
              <?php if ($val['payment_code']=='offline') { ?>
              <p class="hint">(<?php echo $lang['store_gbuy_payment_info'].$lang['nc_colon'];?><?php echo $val['payment_info'];?>)</p>
              <?php } ?>
              <?php if ($val['payment_code']=='predeposit') { ?>
              <p class="hint">(<?php echo $lang['store_gbuy_predeposit_cash_price'].$lang['nc_colon'];?><?php echo $output['member_info']['available_predeposit'];?>
              	&nbsp;&nbsp;
              	<a href="index.php?act=predeposit"><?php echo $lang['store_gbuy_predeposit_add'];?></a>)</p>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_gbuy_user_remark'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea name="gbuy_user_remark" rows="3" class="w300" ><?php echo $output['gold_buy']['gbuy_user_remark']; ?></textarea>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt><dd><input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" /></dd>
      </dl>
    </form>
  </div>

<script type="text/javascript">
$(function(){
    $('#post_form').validate({
    });
});
</script> 
