<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_gold_buy'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['gbuy_log'];?></span></a></li>
        <li><a href="index.php?act=gold_buy&op=gold_log" ><span><?php echo $lang['gold_log'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" id="formSearch" name="formSearch">
    <input type="hidden" name="act" value="gold_buy" />
    <input type="hidden" name="op" value="gold_buy" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="storename"><?php echo $lang['store_name'];?></label></th>
          <td><input class="txt" type="text" value="<?php echo $output['search']['storename'];?>" id="storename" name="storename" /></td>
          <th><label for="membername"><?php echo $lang['buyer_name'];?></label></th>
          <td><input class="txt" type="text" value="<?php echo $output['search']['membername'];?>" id="membername" name="membername" /></td>
          <td>
          	<select name="payment">
          		<option value="" <?php echo $output['search']['payment'] == ''?'selected':''; ?>><?php echo $lang['payment'];?></option>
			<?php if (!empty($output['payment_array'])){ ?>
          		<?php foreach ($output['payment_array'] as $k=>$v){?>
          			<option value="<?php echo $k;?>" <?php echo $output['search']['payment'] == $k?'selected':''; ?>><?php echo $v;?></option>
          		<?php }?>
          	<?php }?>
          	</select>
          </td>
          <td>
          	<select name="ispay">
          		<option value="" <?php echo $output['search']['ispay'] == ''?'selected':''; ?>><?php echo $lang['gbuy_state'];?></option>
          		<option value="0" <?php echo $output['search']['ispay'] == '0'?'selected':''; ?>><?php echo $lang['gbuy_pay'].','.$lang['gbuy_pay_offline'];?></option>
          		<option value="1" <?php echo $output['search']['ispay'] == '1'?'selected':''; ?>><?php echo $lang['gbuy_pay_success'];?></option>
          	</select>
          </td>
          <th><label for="add_time_from"><?php echo $lang['gbuy_time_from'];?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['add_time_from'];?>" id="add_time_from" name="add_time_from" />
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['add_time_to'];?>" id="add_time_to" name="add_time_to"  /></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
          <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2">
    <thead>
     
      <tr class="thead">
        <th></th>
        <th><?php echo $lang['gbuy_add_time'];?></th>
        <th><?php echo $lang['store_name'];?></th>
        <th class="w156 align-center"><?php echo $lang['buyer_name'];?></th>
        <th class="align-center"><?php echo $lang['gbuy_price'];?></th>
        <th class="align-center"><?php echo $lang['gbuy_gold_num'];?></th>
        <th class="align-center"><?php echo $lang['payment'];?></th>
        <th class="align-center"><?php echo $lang['gbuy_state'];?></th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($output['gbuy_list'])>0){?>
      <?php foreach($output['gbuy_list'] as $key => $val){?>
      <tr class="hover">
        <td class="w12"></td>
        <td class="w156"><?php echo date('Y-m-d H:i:s',$val['gbuy_addtime']);?></td>
        <td class="w18pre"><?php echo $val['gbuy_storename'];?></td>
        <td class="align-center"><?php echo $val['gbuy_membername'];?></td>
        <td class="w120 align-center"><?php echo $val['gbuy_price'];?></td>
        <td class="w120 align-center"><?php echo $val['gbuy_num'];?></td>
        <td class="w120 align-center">
        	<?php if (empty($val['gbuy_check_type'])) { ?>
        	<?php echo $lang['gbuy_pay_null'];?>
        	<?php } else { ?>
        	<?php echo $output['payment_array'][$val['gbuy_check_type']];?>
        	<?php } ?>
        	</td>
        <td class="w120 align-center"><?php if ($val['gbuy_ispay'] == 0) { ?>
          <?php if ($val['gbuy_check_type'] == 'offline') { ?>
          <?php echo $lang['gbuy_pay_offline'];?>
          <?php } else { ?>
          <?php echo $lang['gbuy_pay'];?>
          <?php } ?>
          <?php } ?>
          <?php if ($val['gbuy_ispay'] == 1) { ?>
          <?php echo $lang['gbuy_pay_success'];?>
          <?php } ?></td>
        <td class="w132 align-center"><?php if ($val['gbuy_ispay'] == 0) { ?>
          <?php if (!empty($val['gbuy_check_type'])) { ?>
          <a href="index.php?act=gold_buy&op=edit&gbuy_id=<?php echo $val['gbuy_id'];?>"><?php echo $lang['nc_edit'];?></a> | 
          <?php } ?>
          <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')) window.location = 'index.php?act=gold_buy&op=del&gbuy_id=<?php echo $val['gbuy_id'];?>';"> <?php echo $lang['nc_del'];?></a>
          <?php } ?>
          <?php if ($val['gbuy_ispay'] == 1) { ?>
          <a href="index.php?act=gold_buy&op=edit&gbuy_id=<?php echo $val['gbuy_id'];?>"><?php echo $lang['nc_view'];?></a>
          <?php } ?></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    
	$('#formSearch').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
            gbuy_num_from : {
                number : true,
                min:1
            },
            gbuy_num_to : {
                number   : true,
                min:1
            }
        },
        messages : {
            gbuy_num_from : {
                number : '<?php echo $lang['gbuy_number'];?>',
                min   : '<?php echo $lang['gbuy_number'];?>'
            },
            gbuy_num_to  : {
                number   : '<?php echo $lang['gbuy_number'];?>',
                min   : '<?php echo $lang['gbuy_number'];?>'
            }
        }
    });
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('gold_buy');$('#formSearch').submit();
    });
});
</script>