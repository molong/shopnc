<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
    <div class="ncm-notes mt10 mb10"><?php echo $lang['store_sns_setting_tips'];?></div>
    <form method="post" id="form_snssetting" action="index.php?act=store_sns&op=setting">
      <input type="hidden" name="form_submit" value="ok" />
      <table class="ncu-table-style">
        <thead>
          <tr>
            <th class="w10"></th>
            <th class="w30"><?php echo $lang['store_sns_auto'];?></th>
            <th class="w100"><?php echo $lang['store_sns_name'];?></th>
            <th><?php echo $lang['store_sns_cotent'];?></th>
          </tr>
        </thead>
        <tbody>
          <tr class="bd-line">
            <td></td>
            <td><input type="checkbox" name="new" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_new'] == 1){?>checked="checked"<?php }?> value="1" /></td>
            <td><?php echo $lang['store_sns_new_selease'];?></td>
            <td class="tl"><textarea nctype="charcount" class="w600 h80" name="new_title" rows="2" id="new_title"><?php echo $output['sauto_info']['sauto_newtitle'];?></textarea>
              <div id="charcount_new_title" class="tr w600"></div></td>
          </tr>
          <tr class="bd-line">
            <td></td>
            <td><input type="checkbox" name="coupon" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_coupon'] == 1){?>checked="checked"<?php }?> value="1" /></td>
            <td><?php echo $lang['store_sns_coupon'];?></td>
            <td class="tl"><textarea nctype="charcount" class="w600 h80" name="coupon_title" rows="2" id="coupon_title"><?php echo $output['sauto_info']['sauto_coupontitle'];?></textarea>
              <div id="charcount_coupon_title" class="tr w600"></div></td>
          </tr>
          <tr class="bd-line">
            <td></td>
            <td><input type="checkbox" name="xianshi" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_xianshi'] == 1){?>checked="checked"<?php }?> value="1" /></td>
            <td><?php echo $lang['store_sns_xianshi'];?></td>
            <td class="tl"><textarea nctype="charcount" class="w600 h80" name="xianshi_title" rows="2" id="xianshi_title"><?php echo $output['sauto_info']['sauto_xianshititle'];?></textarea>
              <div id="charcount_xianshi_title" class="tr w600"></div></td>
          </tr>
          <tr class="bd-line">
            <td></td>
            <td><input type="checkbox" name="mansong" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_mansong'] == 1){?>checked="checked"<?php }?> value="1" /></td>
            <td><?php echo $lang['store_sns_mansong'];?></td>
            <td class="tl"><textarea nctype="charcount" class="w600 h80" name="mansong_title" rows="2" id="mansong_title"><?php echo $output['sauto_info']['sauto_mansongtitle'];?></textarea>
              <div id="charcount_mansong_title" class="tr w600"></div></td>
          </tr>
          <tr class="bd-line">
            <td></td>
            <td><input type="checkbox" name="bundling" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_bundling'] == 1){?>checked="checked"<?php }?> value="1" /></td>
            <td><?php echo $lang['store_sns_bundling'];?></td>
            <td class="tl"><textarea nctype="charcount" class="w600 h80" name="bundling_title" rows="2" id="bundling_title"><?php echo $output['sauto_info']['sauto_bundlingtitle'];?></textarea>
              <div id="charcount_bundling_title" class="tr w600"></div></td>
          </tr>
          <tr class="bd-line">
            <td></td>
            <td><input type="checkbox" name="groupbuy" <?php if(!isset($output['sauto_info']) || $output['sauto_info']['sauto_groupbuy'] == 1){?>checked="checked"<?php }?> value="1" /></td>
            <td><?php echo $lang['store_sns_gronpbuy'];?></td>
            <td class="tl"><textarea nctype="charcount" class="w600 h80" name="groupbuy_title" rows="2" id="groupbuy_title"><?php echo $output['sauto_info']['sauto_bundlingtitle'];?></textarea>
              <div id="charcount_groupbuy_title" class="tr w600"></div></td>
          </tr>
        </tbody>
        <tfoot><tr><td colspan="20" class="tc"><input type="submit" value="<?php echo $lang['nc_common_button_save'];?>" class="submit mt10 mb5"></td></tr></tfoot>
      </table>
    </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript">
$(function(){
	$('#form_snssetting').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('form_snssetting', '', '', 'onerror');
		},
		rules : {
			new_title : {
				maxlength : 140
			},
			coupon_title : {
				maxlength : 140
			},
			xianshi_title : {
				maxlength : 140
			},
			mansong_title : {
				maxlength : 140
			},
			bundling_title : {
				maxlength : 140
			},
			groupbuy_title : {
				maxlength : 140
			}
		},
		messages : {
			new_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			coupon_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			voucher_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			mansong_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			bundling_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			},
			groupbuy_title : {
				maxlength : '<?php echo $lang['store_sns_content_less_than'];?>'
			}
		}
	});

	//评论字符个数动态计算
	$('*[nctype="charcount"]').each(function(){
		$(this).charCount({
			allowed: 140,
			warning: 10,
			counterContainerID:'charcount_'+$(this).attr('id'),
			firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
			endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
			errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
		});
	});
});
</script>