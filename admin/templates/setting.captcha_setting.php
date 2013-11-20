<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_set'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=setting&op=base_information"><span><?php echo $lang['basic_info'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['manage_about'];?></span></a></li>
        <li><a href="index.php?act=setting&op=creditgrade"><span><?php echo $lang['setting_store_creditrule'];?></span></a></li>
        <li><a href="index.php?act=setting&op=ucenter_setting"><span><?php echo $lang['ucenter_integration'];?></span></a></li>
        <li><a href="index.php?act=setting&op=qq_setting"><span><?php echo $lang['qqSettings'];?></span></a></li>
        <li><a href="index.php?act=setting&op=sina_setting"><span><?php echo $lang['sinaSettings'];?></span></a></li>
        <li><a href="index.php?act=setting&op=login_setting"><span><?php echo $lang['loginSettings'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" id="settingForm" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['allowed_visitors_consult'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="guest_comment_enable" class="cb-enable <?php if($output['list_setting']['guest_comment'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="guest_comment_disabled" class="cb-disable <?php if($output['list_setting']['guest_comment'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="guest_comment_enable" name="guest_comment" <?php if($output['list_setting']['guest_comment'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="guest_comment_disabled" name="guest_comment" <?php if($output['list_setting']['guest_comment'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['allowed_visitors_consult_notice'];?></td>
        </tr>
        <?php if($output['list_setting']['flea_app_open']=='1'){?>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['flea_allow'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
			<label for="flea_allow_1" class="cb-enable <?php if($output['list_setting']['flea_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['flea_allow_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="flea_allow_0" class="cb-disable <?php if($output['list_setting']['flea_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['flea_allow_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="flea_allow_1" name="flea_allow" <?php if($output['list_setting']['flea_isuse'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="flea_allow_0" name="flea_allow" <?php if($output['list_setting']['flea_isuse'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php }?>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['allow_open_store'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="store_allow1" class="cb-enable <?php if($output['list_setting']['store_allow'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_open'];?>"><span><?php echo $lang['nc_open'];?></span></label>
            <label for="store_allow0"class="cb-disable <?php if($output['list_setting']['store_allow'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['gold_isuse_close'];?>"><span><?php echo $lang['nc_close'];?></span></label>
            <input type="radio" id="store_allow1" name="store_allow" value="1" <?php echo $output['list_setting']['store_allow'] ==1?'checked=checked':''; ?>>
            <input type="radio" id="store_allow0" name="store_allow" value="0" <?php echo $output['list_setting']['store_allow'] ==0?'checked=checked':''; ?>></td>
          <td class="vatop tips"></td>
        </tr>      
        <tr>
          <td colspan="2" class="required"><?php echo $lang['open_checkcode'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="checkbox" value="1" name="captcha_status_login" id="captcha_status1" <?php if($output['list_setting']['captcha_status_login'] == '1'){ ?>checked="checked"<?php } ?> />
                <label for="captcha_status1"><?php echo $lang['front_login'];?></label>
              </li>
              <li>
                <input type="checkbox" value="1" name="captcha_status_register" id="captcha_status2" <?php if($output['list_setting']['captcha_status_register'] == '1'){ ?>checked="checked"<?php } ?> />
                <label for="captcha_status2"><?php echo $lang['front_regist'];?></label>
              </li>
              <li>
                <input type="checkbox" value="1" name="captcha_status_goodsqa" id="captcha_status3" <?php if($output['list_setting']['captcha_status_goodsqa'] == '1'){ ?>checked="checked"<?php } ?> />
                <label for="captcha_status3"><?php echo $lang['front_goodsqa'];?></label>
              </li>
              
              <!--</li> <input type="checkbox" value="1" name="captcha_status_backend" id="captcha_status4" <?php if($output['list_setting']['captcha_status_backend'] == '1'){ ?>checked="checked"<?php } ?> /> <label for="captcha_status4"><?php echo $lang['backstage_login'];?></label> </li>-->
            </ul></td>
          <td class="vatop tips" >&nbsp;</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
