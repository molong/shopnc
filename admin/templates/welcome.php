<div class="page">
  <div class="item-title">
    <h3><?php echo $lang['dashboard_welcome_welcome'];?>,<?php echo $output['admin_info']['admin_name'];?>,<?php echo $lang['dashboard_welcome_to_use'];?>.  <?php echo $lang['dashboard_welcome_lase_login'];?><?php echo $output['admin_info']['admin_login_time'];?></h3>
  </div>
  <table class="table tb-type2">
    <thead class="thead">
      <tr class="space">
        <th colspan="10"><?php echo $lang['dashboard_welcome_week_info'];?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="w12"></td>
        <td class="w108"><strong><?php echo $lang['dashboard_welcome_new_member'];?>:</strong></td>
        <td class="w25pre"><span id="statistics_week_add_member">0</span></td>
        <td class="w120"><strong><?php echo $lang['dashboard_welcome_new_store'];?>/<?php echo $lang['dashboard_welcome_new_apply'];?>:</strong></td>
        <td><span id="statistics_week_add_store">0</span>/<span id="statistics_week_add_audit_store">0</span></td>
      </tr>
      <tr>
        <td></td>
        <td><strong><?php echo $lang['dashboard_welcome_new_goods'];?>:</strong></td>
        <td><span id="statistics_week_add_product">0</span></td>
        <td><strong><?php echo $lang['dashboard_welcome_new_order'];?>:</strong></td>
        <td><span id="statistics_week_add_order_num">0</span></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="10" class="tfoot">
        <iframe src="http://www.shopnc.net/update/update2.4.html" frameborder="0" scrolling="No" width="1000px" height="40px"></iframe>
        </td>
      </tr>
    </tfoot>
  </table>
  <table class="table tb-type2" style="margin-top:0px">
    <thead class="thead">
      <tr class="space">
        <th colspan="10"><?php echo $lang['dashboard_welcome_total_info'];?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="w12"></td>
        <td class="w108"><strong><?php echo $lang['dashboard_welcome_total_member'];?>:</strong></td>
        <td class="w25pre"><span id="statistics_member">0</span></td>
        <td class="w120"><strong><?php echo $lang['dashboard_welcome_total_store'];?>/<?php echo $lang['dashboard_welcome_total_apply'];?>:</strong></td>
        <td><span id="statistics_store">0</span>/<span id="statistics_audit_store">0</span></td>
      </tr>
      <tr>
        <td></td>
        <td><strong><?php echo $lang['dashboard_welcome_total_goods'];?>:</strong></td>
        <td><span id="statistics_goods">0</span></td>
        <td><strong><?php echo $lang['dashboard_welcome_total_order'];?>:</strong></td>
        <td><span id="statistics_order">0</span></td>
      </tr>
      <tr>
        <td></td>
        <td><strong><?php echo $lang['dashboard_welcome_total_price'];?>:</strong></td>
        <td><span id="statistics_order_amount">0</span></td>
        <td></td>
        <td></td>
      </tr>
    </tbody> <tfoot>
      <tr class="tfoot">
        <td colspan="10"></td>
      </tr>
    </tfoot>
  </table>
  <table class="table tb-type2">
    <thead class="thead">
      <tr class="space">
        <th colspan="10"><?php echo $lang['dashboard_welcome_sys_info'];?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="w12"></td>
        <td class="w108"><strong><?php echo $lang['dashboard_welcome_server_os'];?>:</strong></td>
        <td class="w25pre"><?php echo $output['statistics']['os'];?></td>
        <td class="w120"><strong>WEB <?php echo $lang['dashboard_welcome_server'];?>:</strong></td>
        <td><?php echo $output['statistics']['web_server'];?></td>
      </tr>
      <tr>
        <td></td>
        <td><strong>PHP <?php echo $lang['dashboard_welcome_version'];?>:</strong></td>
        <td><?php echo $output['statistics']['php_version'];?></td>
        <td><strong>MYSQL <?php echo $lang['dashboard_welcome_version'];?>:</strong></td>
        <td><?php echo $output['statistics']['sql_version'];?></td>
      </tr>
      <tr>
        <td></td>
        <td><strong>ShopNC <?php echo $lang['dashboard_welcome_version'];?>:</strong></td>
        <td><?php echo $output['statistics']['shop_version'];?></td>
        <td><strong><?php echo $lang['dashboard_welcome_install_date'];?>:</strong></td>
        <td><?php echo $output['statistics']['setup_date'];?></td>
      </tr>
    </tbody> <tfoot>
      <tr class="tfoot">
        <td colspan="10"></td>
      </tr>
    </tfoot>
  </table>
</div>

<script type="text/javascript"> 
$(function(){
	$.getJSON("index.php?act=dashboard&op=statistics", function(data){
	  $.each(data, function(k,v){
	    $("#statistics_"+k).html(v);
	  });
	});
});
</script>