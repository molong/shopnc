<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_pointshop_setting'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_pointshop_setting'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="settingForm" id="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['open_pointprod_isuse'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="pointprod_isuse_1" class="cb-enable <?php if($output['list_setting']['pointprod_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="pointprod_isuse_0" class="cb-disable <?php if($output['list_setting']['pointprod_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input id="pointprod_isuse_1" name="pointprod_isuse" <?php if($output['list_setting']['pointprod_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="pointprod_isuse_0" name="pointprod_isuse" <?php if($output['list_setting']['pointprod_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['open_pointprod_isuse_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['voucher_allow'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="voucher_allow_1" class="cb-enable <?php if($output['list_setting']['voucher_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="voucher_allow_0" class="cb-disable <?php if($output['list_setting']['voucher_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input id="voucher_allow_1" name="voucher_allow" <?php if($output['list_setting']['voucher_allow'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="voucher_allow_0" name="voucher_allow" <?php if($output['list_setting']['voucher_allow'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['voucher_allow_notice'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(function(){$("#submitBtn").click(function(){
     $("#settingForm").submit();
});
});
</script> 
