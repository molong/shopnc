<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="javascript:void(0)"><?php echo $lang['store_payment_add'];?></a></li>
    </ul>
  </div>
  <div class="ncu-form-style">
    <div id="warning"></div>
    <form id="post_form" method="post" action="index.php?act=store&op=add_payment&submit=ok" target="_parent">
      <input type="hidden" name="payment_code" value="<?php echo $output['payment_info']['code']; ?>" />
      <input type="hidden" name="payment_online" value="<?php echo $output['payment_info']['is_online']; ?>" />
      <input type="hidden" name="payment_name" value="<?php echo $output['payment_info']['name']; ?>" />
      <?php if ($output['payment_info']['payment_id'] != '') { ?>
      <input type="hidden" name="payment_id" value="<?php echo $output['payment_info']['payment_id']; ?>" />
      <?php } ?>
      <dl>
        <dt><?php echo $lang['store_payment_name'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['payment_info']['name']; ?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_payment_info'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <textarea name="payment_desc" rows="5" ><?php echo $output['payment_info']['payment_info']; ?></textarea>
          </p>
          <p class="hint"><?php echo $lang['store_payment_display'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_payment_enable'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="radio" name="payment_state" value="1" <?php if ($output['payment_info']['payment_state'] == 1 || $output['payment_info']['payment_state'] == '') { ?>checked="checked"<?php } ?> />
          <?php echo $lang['store_payment_yes'];?>
          <input type="radio" name="payment_state" value="2" <?php if ($output['payment_info']['payment_state'] == 2) { ?>checked="checked"<?php } ?> />
          <?php echo $lang['store_payment_no'];?></dd>
      </dl>
      <?php if (is_array($output['payment_info']['config']) and !empty($output['payment_info']['config'])) { ?>
      <?php foreach ($output['payment_info']['config'] as $key => $info) { ?>
      <dl>
        <dt class="required">
          <?php if($output['payment_info']['code'] != 'cod') { ?>
          <em></em>
          <?php } ?>
          <?php echo $info['text'].$lang['nc_colon']; ?></dt>
        <dd>
          <?php if($info['type'] == 'text') { ?>
          <p>
            <input type="text" class="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo $info['value']; ?>"  />
          </p>
          <?php } elseif ($info['type'] == 'select') { ?>
          <p>
            <select <?php if ($_GET['payment_code'] == 'alipay') echo "nc_type='pidKey'";?> name="<?php echo $key; ?>" id="<?php echo $key; ?>">
              <?php foreach($info['items'] as $k => $v) { ?>
              <option value="<?php echo $k; ?>" <?php if($k==$info['value']) { ?>selected="selected"<?php } ?> ><?php echo $v ?></option>
              <?php } ?>
            </select>
          </p>
          <?php } elseif ($info['type'] == 'textarea') { ?>
          <p>
            <textarea name="<?php echo $key; ?>" rows="5"  id="<?php echo $key; ?>" ><?php echo $info['value']; ?></textarea>
          </p>
          <?php } elseif ($info['type'] == 'radios') { ?>
          <?php foreach($info['items'] as $k => $v) { ?>
          <p>
            <input type="radio" name="<?php echo $key; ?>" value="<?php echo $k; ?>" <?php if($k==$info['value']) { ?>checked="checked"<?php } ?> />
            &nbsp;<?php echo $v; ?>
            <?php } ?>
            <?php } elseif ($info['type'] == 'checkbox') { ?>
            <?php foreach($info['items'] as $k => $v) { ?>
            <input type="checkbox" name="<?php echo $key; ?>" value="<?php echo $k; ?>" <?php if($k==$info['value']) { ?>checked="checked"<?php } ?> />
            &nbsp;</p>
          <?php echo $v; ?>
          <?php } ?>
          <?php } ?>
          <p class="hint"><?php echo $info['desc'];  ?></p>
        </dd>
      </dl>
      <?php
		   		}
		   } ?>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$('#post_form').validate({
     	submitHandler:function(form){
    		ajaxpost('post_form', '', '', 'onerror')
    	},
		<?php if($output['payment_info']['code'] == 'chinabank') { ?>
        rules : {
            chinabank_account : {
                required   : true
            },
            chinabank_key : {
                required   : true
            }
        },
        messages : {
            chinabank_account  : {
                required  : '<?php echo $output['payment_info']['config']['chinabank_account']['text'];?><?php echo $lang['store_payment_edit_not_null']; ?>'
            },
            chinabank_key  : {
                required   : '<?php echo $output['payment_info']['config']['chinabank_key']['text'];?><?php echo $lang['store_payment_edit_not_null']; ?>'
            }
        }
		<?php } elseif ($output['payment_info']['code'] == 'tenpay') { ?>
        rules : {
            tenpay_account : {
                required   : true
            },
            tenpay_key : {
                required   : true
            }
        },
        messages : {
            tenpay_account  : {
                required  : '<?php echo $output['payment_info']['config']['tenpay_account']['text'];?><?php echo $lang['store_payment_edit_not_null']; ?>'
            },
            tenpay_key  : {
                required   : '<?php echo $output['payment_info']['config']['tenpay_key']['text'];?><?php echo $lang['store_payment_edit_not_null']; ?>'
            }
        }
			
		<?php } elseif ($output['payment_info']['code'] == 'alipay') { ?>
        rules : {
            alipay_account : {
                required   : true
            },
            alipay_key : {
                required   : true
            },
            alipay_partner : {
                required   : true
            }
        },
        messages : {
            alipay_account  : {
                required  : '<?php echo $output['payment_info']['config']['alipay_account']['text'];?><?php echo $lang['store_payment_edit_not_null']; ?>'
            },
            alipay_key  : {
                required   : '<?php echo $output['payment_info']['config']['alipay_key']['text'];?><?php echo $lang['store_payment_edit_not_null']; ?>'
            },
            alipay_partner  : {
                required   : '<?php echo $output['payment_info']['config']['alipay_partner']['text'];?><?php echo $lang['store_payment_edit_not_null']; ?>'
            }
        }
		<?php } ?>
    });
    $("select[nc_type='pidKey']").change(function(){
    	if ($(this).val() == 'trade_create_by_buyer'){
    		$('#pidKey').attr('href','https://b.alipay.com/order/pidKey.htm?pid=2088001525694587&product=dualpay');
    	}else if ($(this).val() == 'create_partner_trade_by_buyer'){
    		$('#pidKey').attr('href','https://b.alipay.com/order/pidKey.htm?pid=2088001525694587&product=escrow');
    	}else if ($(this).val() == 'create_direct_pay_by_user'){
    		$('#pidKey').attr('href','https://b.alipay.com/order/pidKey.htm?pid=2088001525694587&product=fastpay');
    	}
    });
});
</script>