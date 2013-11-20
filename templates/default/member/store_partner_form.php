<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div id="warning"></div>
  <form method="post" action="index.php?act=store&op=store_partner" target="_parent" enctype="multipart/form-data" id="store_partner_form">
    <input type="hidden" name="form_submit" value="ok"/>
    <input type="hidden" name="sp_id" value="<?php echo $output['sp_info']['sp_id'];?>"/>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_partner_title'].$lang['nc_colon'];?></dt>
      <dd>
        <input name="sp_title" type="text" class="w200 text" value="<?php echo $output['sp_info']['sp_title'];?>" maxlength="15"/>
      </dd>
    </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['store_partner_href'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w200 text" name="sp_link" type="text" value="<?php if(!empty($output['sp_info']['sp_link'])){ echo $output['sp_info']['sp_link'];}else{ echo 'http://'; }?>" maxlength="100" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_goods_class_sort'].$lang['nc_colon'];?></dt>
      <dd>
        <p>
          <input name="sp_sort" type="text" class="w50 text" value="<?php echo $output['sp_info']['sp_sort'] ? $output['sp_info']['sp_sort'] : '255' ;?>" maxlength="3" />
        </p>
        <p class="hint"><?php echo $lang['store_partner_href_tip'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_partner_sign'].$lang['nc_colon'];?></dt>
      <dd>
        <p>
          <input type="text" class="w200 text" name="sp_logo" value="<?php echo $output['sp_info']['sp_logo'];?>"/>
        </p>
        <p class="hint mt10"> <?php echo $lang['store_partner_des_one'];?><a target="_blank" href="index.php?act=store_album&op=album_cate" class="ncu-btn2 ml5 mr5"><?php echo $lang['nc_member_path_album'];?></a><?php echo $lang['store_partner_des_two'];?></p>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit"  class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" />
      </dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $('input[nc_type="logo"]').change(function(){
            var src = getFullPath($(this)[0]);
            $('img[nc_type="logo1"]').attr('src' , src);
            $(this).removeAttr('name');
            $(this).attr('name' , 'logo');
    });
});
//]]>
</script> 
<script>
$(document).ready(function(){
	$('#store_partner_form').validate({
		errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
    	submitHandler:function(form){
    		ajaxpost('store_partner_form', '', '', 'onerror') 
    	},
        rules : {
            sp_title : {
                required	: true
            },
            sp_link : {
                required	: true,
                url			: true
            }
        },
        messages : {
            sp_title : {
                required	: '<?php echo $lang['store_partner_title_null'];?>'
            },
            sp_link : {
                required	: '<?php echo $lang['store_partner_href_null'];?>',
                url			: '<?php echo $lang['store_partner_wrong_href'];?>'
            }
        }
    });
});
</script>