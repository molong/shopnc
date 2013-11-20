<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div class="adds">
    <div id="warning"></div>
    <form method="post" action="index.php?act=deliver&op=buyer_address&order_id=<?php echo $_GET['order_id'];?>" id="address_form" target="_parent">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt class="required"><?php echo $lang['member_address_receiver_name'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" class="text" name="true_name" id="true_name" value="<?php echo $output['address']['true_name'];?>"/>
          </p>
          <p class="hint"><?php echo $lang['member_address_input_name'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><?php echo $lang['member_address_location'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="text w300" type="text" name="area_info" id="area_info" value="<?php echo $output['address']['area_info'];?>"/>
          </p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><?php echo $lang['member_address_address'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="text w300" type="text" name="vaddress" id="vaddress" value="<?php echo $output['address']['address'];?>"/>
          </p>
          <p class="hint"><?php echo $lang['member_address_not_repeat'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['member_address_zipcode'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text" name="zip_code" id="zip_code" maxlength="6" value="<?php echo $output['address']['zip_code'];?>" />
        </dd>
      </dl>
      <dl>
        <dt class="required"></em><?php echo $lang['member_address_phone_num'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input type="text" class="text" name="tel_phone" id="tel_phone" value="<?php echo $output['address']['tel_phone'];?>"/>
          </p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><?php echo $lang['member_address_mobile_num'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="text" name="mob_phone" id="mob_phone" value="<?php echo $output['address']['mob_phone'];?>"/>
        </dd>
      </dl>
      <dl class="bottom"><dt>&nbsp;</dt><dd>
        <input type="button" id='ebutton' class="submit" value="<?php echo $lang['nc_common_button_save'];?>" />
      </dd></dl>
    </form>
  </div>
</div>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(document).ready(function(){
	$('#ebutton').bind('click',function(){
		$('#strue_name').val($('#true_name').val());
		$('#sarea_info').val($('#area_info').val());
		$('#saddress').val($('#vaddress').val());
		$('#szip_code').val($('#zip_code').val());
		$('#stel_phone').val($('#tel_phone').val());
		$('#smob_phone').val($('#mob_phone').val());
		var content = '<strong class="fl"><?php echo $lang['store_deliver_buyer_adress'].$lang['nc_colon'];?></strong>'+$('#sarea_info').val()+'&nbsp;'+$('#saddress').val()+'&nbsp;'+$('#szip_code').val()+'&nbsp;'+$('#strue_name').val()+'&nbsp;'+$('#stel_phone').val()+'&nbsp;'+$('#smob_phone').val();
		content += "<a href=\"javascript:void(0);\" onclick=\"ajax_form(\'my_address_edit\', \'<?php echo Language::get('store_deliver_modfiy_address');?>\', \'index.php?act=deliver&op=buyer_address&order_id=<?php echo $_GET['order_id'];?>\', 550,0);\" class=\"fr\"><?php echo Language::get('store_deliver_modfiy_address');?></a>";
		$('#address').html(content);
		DialogManager.close('my_address_edit');
//		return false;
	});
	
	
		$('#true_name').val($('#strue_name').val());
		$('#area_info').val($('#sarea_info').val());
		$('#vaddress').val($('#saddress').val());
		$('#zip_code').val($('#szip_code').val());
		$('#tel_phone').val($('#stel_phone').val());
		$('#mob_phone').val($('#smob_phone').val());	
	
	
//    $('#address_form').validate({
//    	submitHandler:function(form){
//    		$('#strue_name').val($('#true_name').val());
//    		$('#sarea_info').val($('#area_info').val());
//    		$('#saddress').val($('#vaddress').val());
//    		$('#szip_code').val($('#zip_code').val());
//    		$('#stel_phone').val($('#tel_phone').val());
//    		$('#smob_phone').val($('#mob_phone').val());
//    		$('#address').html($('#strue_name').val()+$('#sarea_info').val()+$('#saddress').val()+$('#szip_code').val()+$('#stel_phone')()+$('#smob_phone').val());
//    		DialogManager.close('my_address_edit');
//    		return false;
//    	},
//        errorLabelContainer: $('#warning'),
//        invalidHandler: function(form, validator) {
//           var errors = validator.numberOfInvalids();
//           if(errors)
//           {
//               $('#warning').show();
//           }
//           else
//           {
//               $('#warning').hide();
//           }
//        },
//        rules : {
//            true_name : {
//                required : true
//            },
//            address : {
//                required : true
//            },
//			zip_code : {
//				digits : true,
//				minlength : 6,
//				maxlength : 6
//			},
//            tel_phone : {
//                required : check_phone,
//                minlength : 6,
//				maxlength : 20
//            },
//            mob_phone : {
//                required : check_phone,
//                minlength : 6,
//				maxlength : 20,
//                digits : true
//            }
//        },
//        messages : {
//            true_name : {
//                required : '<?php echo $lang['member_address_input_receiver'];?>'
//            },
//            address : {
//                required : '<?php echo $lang['member_address_input_address'];?>'
//            },
//			zip_code : {
//				digits : '<?php echo $lang['member_address_zip_code'];?>',
//				minlength : '<?php echo $lang['member_address_zip_code']?>',
//				maxlength : '<?php echo $lang['member_address_zip_code']?>'
//			},
//            tel_phone : {
//                required : '<?php echo $lang['member_address_phone_and_mobile'];?>',
//                minlength: '<?php echo $lang['member_address_phone_rule'];?>',
//				maxlength: '<?php echo $lang['member_address_phone_rule'];?>'
//            },
//            mob_phone : {
//                required : '<?php echo $lang['member_address_phone_and_mobile'];?>',
//                minlength: '<?php echo $lang['member_address_wrong_mobile'];?>',
//				maxlength: '<?php echo $lang['member_address_wrong_mobile'];?>',
//                digits : '<?php echo $lang['member_address_wrong_mobile'];?>'
//            }
//        },
//        groups : {
//            phone:'tel_phone mob_phone'
//        }
//    });
});
function check_phone(){
    return ($('[name="tel_phone"]').val() == '' && $('[name="mob_phone"]').val() == '');
}
</script>