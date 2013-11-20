<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div class="adds" style=" min-height:240px;">
    <table class="ncu-table-style">
      <thead>
        <tr>
          <th class="w80"><?php echo $lang['nc_common_button_operate'];?></th>
          <th><?php echo $lang['store_deliver_daddress'];?></th>
          <th class="w60"><?php echo $lang['store_deliver_post'];?></th>
          <th class="w100"><?php echo $lang['store_deliver_telphone'];?></th>
          <th class="w100"><?php echo $lang['store_deliver_mobphone'];?></th>
          <th class="w80"><?php echo $lang['nc_common_button_operate'];?></th>
        </tr>
      </thead>
      <?php if (is_array($output['daddress_list']) && is_array($output['daddress_list'])){?>
      <tbody>
        <?php foreach ($output['daddress_list'] as $key => $value) {?>
        <tr class="bd-line">
          <td class="tc"><?php echo $value['seller_name'];?></td>
          <td><?php echo $value['area_info'];?> <?php echo $value['address'];?></td>
          <td class="tc"><?php echo $value['zip_code'];?></td>
          <td class="tc"><?php echo $value['tel_phone'];?></td>
          <td class="tc"><?php echo $value['mob_phone'];?></td>
          <td class="tc"><a href="javascript:void(0);" nc_type="select" class="ncu-btn2" nc_id="<?php echo $value['address_id'];?>" nc_value="<?php echo $value['area_info'].'&nbsp;'.$value['address'].'&nbsp;'.$value['zip_code'].'&nbsp;'.$value['seller_name'].'&nbsp;'.$value['tel_phone'].'&nbsp;'.$value['mob_phone'];?>"><?php echo $lang['nc_common_button_select'];?></a></td>
        </tr>
        <?php }?>
        <tr class="bd-line">
          <td colspan="20"></td>
        </tr>
      </tbody>
      <?php }?>
    </table>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('a[nc_type="select"]').bind('click',function(){
		$('#daddress_id').val($(this).attr('nc_id'));
		var content = $(this).attr('nc_value')+ '<a href=\"javascript:void(0);\" onclick=\"ajax_form(\'modfiy_daddress\', \'<?php echo $lang['store_deliver_select_daddress'];?>\', \'index.php?act=deliver&op=pop_address&type=select\', 550,0);\" class=\"fr\"><?php echo $lang['store_deliver_select_ather_daddress'];?></a>';
		$('#daddress').html(content);
		 DialogManager.close('modfiy_daddress');
	});
});
</script>