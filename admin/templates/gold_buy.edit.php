<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_gold_buy'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=gold_buy&op=gold_buy"><span><?php echo $lang['gbuy_log'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="gbuy_id" value="<?php echo $output['gold_buy']['gbuy_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['buyer_name'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['gold_buy']['gbuy_membername'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['gbuy_gold'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['member_goldnum'];?> <?php echo $lang['gbuy_num'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['gbuy_price'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['gold_buy']['gbuy_price'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['gbuy_user_remark'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['gold_buy']['gbuy_user_remark'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if ($output['gold_buy']['gbuy_ispay'] == 0) { ?>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['gbuy_gold_num'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="gbuy_num" name="gbuy_num" value="<?php echo $output['gold_buy']['gbuy_num'];?>" class="txt"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_id"><?php echo $lang['gbuy_sys_remark'];?>:</label>
            </th></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="gbuy_sys_remark" id="gbuy_sys_remark" class="tarea" ><?php echo $output['gold_buy']['gbuy_sys_remark']; ?></textarea></td>
          <td class="vatop tips"><?php echo $lang['gbuy_pay_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['gbuy_ispay'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><p>
              <label>
                <input type="radio" value="1" name="gbuy_ispay">
                <?php echo $lang['nc_yes'];?></label>
              <label>
                <input type="radio" checked="checked" value="0" name="gbuy_ispay">
                <?php echo $lang['nc_no'];?></label>
            </p></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"  onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a> <a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
    <?php } else { ?>
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['gbuy_gold_num'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['gold_buy']['gbuy_num'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_id"><?php echo $lang['gbuy_sys_remark'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['gold_buy']['gbuy_sys_remark']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['gbuy_ispay'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><p>
              <label> <?php echo $lang['nc_yes'];?></label>
            </p></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
    <?php } ?>
  </form>
</div>
<script>
$(document).ready(function(){
	$('#post_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
            gbuy_num : {
                required   : true,
                number : true
            }
        },
        messages : {
            gbuy_num : {
                required  : '<?php echo $lang['gbuy_number'];?>',
                number : '<?php echo $lang['gbuy_number'];?>'
            }
        }
    });
});
</script>