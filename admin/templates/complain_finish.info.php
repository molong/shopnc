<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['final_handle_detail'];?></th>
    </tr></thead>
    <tbody>
    	<?php if(!empty($output['refund']) && is_array($output['refund'])) { ?>
    <tr>
      <th><?php echo $lang['refund_state_yes'];?></th>
    </tr>
    <tr class="noborder">
      <td><?php echo ($output['refund']['refund_state']==2) ? $lang['nc_yes']:$lang['nc_no'];?></td>
    </tr>
    	<?php } ?>
    <tr>
      <th><?php echo $lang['final_handle_message'];?></th>
    </tr>
    <tr class="noborder">
      <td><?php echo $output['complain_info']['final_handle_message'];?></td>
    </tr>
    <tr>
      <th><?php echo $lang['final_handle_datetime'];?></th>
    </tr>
    <tr class="noborder">
      <td><?php echo date('Y-m-d H:i:s',$output['complain_info']['final_handle_datetime']);?></td>
    </tr>
  </tbody>
</table>
