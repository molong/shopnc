<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" nc_type="dialog" dialog_title="<?php echo $lang['store_daddress_new_address'];?>" dialog_id="my_address_add"  uri="index.php?act=deliver&op=daddress&type=add" dialog_width="550" title="<?php echo $lang['store_daddress_new_address'];?>"><?php echo $lang['store_daddress_new_address'];?></a></div>
    <div></div>
  <table class="ncu-table-style" >
    <thead>
      <tr>
        <th class="w70"><?php echo $lang['store_daddress_deliver_address'];?></th>
        <th class="w90"><?php echo $lang['store_daddress_receiver_name'];?></th>
        <th class="w150"><?php echo $lang['store_daddress_location'];?></th>
        <th class="tl"><?php echo $lang['store_daddress_address'];?></th>
        <th class="w90"><?php echo $lang['store_daddress_zipcode'];?></th>
        <th class="w150"><?php echo $lang['store_daddress_phone'];?>/<?php echo $lang['store_daddress_mobile'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php if(!empty($output['address_list']) && is_array($output['address_list'])){?>
    <tbody>
      <?php foreach($output['address_list'] as $key=>$address){?>
      <tr class="bd-line">
      	
        <td><input type="radio" name="is_default" <?php if ($address['is_default'] == 1) echo 'checked';?> value="<?php echo $address['address_id'];?>"> <?php echo $lang['store_daddress_default'];?></td>
        <td><?php echo $address['seller_name'];?></td>
        <td><?php echo $address['area_info'];?></td>
        <td class="tl"><?php echo $address['address'];?></td>
        <td><?php echo $address['zip_code'];?></td>
        <td><span class="tel"><?php echo $address['tel_phone'];?></span> <br/>
          <span class="mob"><?php echo $address['mob_phone']; ?></span></td>
        <td><p><a href="javascript:void(0);" dialog_id="my_address_edit" dialog_width="550" dialog_title="<?php echo $lang['store_daddress_edit_address'];?>" nc_type="dialog" uri="index.php?act=deliver&op=daddress&type=edit&id=<?php echo $address['address_id'];?>"><?php echo $lang['store_daddress_edit_address'];?></a></p><p><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=deliver&op=daddress&id=<?php echo $address['address_id'];?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot><tr><td colspan="20">&nbsp;</td></tr></tfoot>
  </table>
</div>
<script>
$(function (){
	$('input[name="is_default"]').bind('click',function(){
		$.get('index.php?act=deliver&op=ajax&type=daddress&id='+$(this).val(),function(result){})
	});
});
</script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
