<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['order_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="trade" />
    <input type="hidden" name="op" value="order_manage" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label><?php echo $lang['order_state'];?></label></th>
          <td colspan="4"><select name="status" class="querySelect">
              <option value="" <?php if($output['search']['status'] == ''){?>selected<?php }?>><?php echo $lang['nc_please_choose'];?></option>
              <option value="10"<?php if($output['search']['status'] == '10'){?>selected<?php }?>><?php echo $lang['pending_payment'];?></option>
              <option value="11"<?php if($output['search']['status'] == '11'){?>selected<?php }?>><?php echo $lang['pending_recive'];?></option>
              <option value="20"<?php if($output['search']['status'] == '20'){?>selected<?php }?>><?php echo $lang['pending_ship'];?></option>
              <option value="30"<?php if($output['search']['status'] == '30'){?>selected<?php }?>><?php echo $lang['shipped'];?></option>
              <option value="40"<?php if($output['search']['status'] == '40'){?>selected<?php }?>><?php echo $lang['complated'];?></option>
              <option value="0"<?php if($output['search']['status'] == '0'){?>selected<?php }?>><?php echo $lang['cancelled'];?></option>
              <option value="50"<?php if($output['search']['status'] == '50'){?>selected<?php }?>><?php echo $lang['pended_payment'];?></option>
            </select>
            <label style=" margin-left:20px;"><?php echo $lang['type'];?></label>
            <select name="field" class="querySelect">
              <option value="store_name" <?php if($output['search']['field'] == 'store_name'){?>selected<?php }?>><?php echo $lang['store_name'];?></option>
              <option value="buyer_name" <?php if($output['search']['field'] == 'buyer_name'){?>selected<?php }?>><?php echo $lang['buyer_name'];?></option>
              <option value="payment_name" <?php if($output['search']['field'] == 'payment_name'){?>selected<?php }?>><?php echo $lang['payment'];?></option>
              <option value="order_sn" <?php if($output['search']['field'] == 'order_sn'){?>selected<?php }?>><?php echo $lang['order_number'];?></option>
            </select>
            <input class="txt2" type="text" name="search_name" value="<?php echo $output['search']['search_name'];?>" /></td>
        </tr>
        <tr>
          <th><label for="add_time_from"><?php echo $lang['order_time_from'];?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $output['search']['add_time_from'];?>" id="add_time_from" name="add_time_from">
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $output['search']['add_time_to'];?>" id="add_time_to" name="add_time_to"/></td>
          <th><label for="order_amount_from"><?php echo $lang['order_price_from'];?></label></th>
          <td><input class="txt-short" type="text" value="<?php echo $output['search']['order_amount_from'];?>" name="order_amount_from" id="order_amount_from"/>
            <label for="order_amount_to">~</label>
            <input class="txt-short" type="text" value="<?php echo $output['search']['order_amount_to'];?>" name="order_amount_to" id="order_amount_to"/></td>
          <td><a href="javascript:viod(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <?php if($output['filterd']){?>
            <a class="btns" href="index.php?act=trade&op=order_manage"><span><?php echo $lang['cancel_search'];?></span></a>
            <?php }?>
            <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['order_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['order_number'];?></th>
        <th><?php echo $lang['store_name'];?></th>
        <th><?php echo $lang['buyer_name'];?></th>
        <th class="align-center"><?php echo $lang['order_time'];?></th>
        <th class="align-center"><?php echo $lang['order_total_price'];?></th>
        <th class="align-center"><?php echo $lang['payment'];?></th>
        <th class="align-center"><?php echo $lang['order_state'];?></th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(count($output['order_list'])>0){?>
      <?php foreach($output['order_list'] as $order){?>
      <tr class="hover">
        <td>
            <?php echo $order['order_sn'];?>
            <?php if(!empty($order['group_id'])) { echo "<span class='red' title='".$lang['nc_groupbuy']."'>(".$lang['nc_groupbuy_flag'].")</span>"; }?>
            <?php if(!empty($order['mansong_id'])) { echo "<span class='red' title='".$lang['nc_mansong']."'>(".$lang['nc_mansong_flag'].")</span>"; }?>
            <?php if(!empty($order['xianshi_id'])) { echo "<span class='red' title='".$lang['nc_xianshi']."'>(".$lang['nc_xianshi_flag'].")</span>"; }?>
            <?php if(!empty($order['bundling_id'])) { echo "<span class='red' title='".$lang['nc_bundling']."'>(".$lang['nc_bundling_flag'].")</span>"; }?>
        </td>
        <td><?php echo $order['store_name'];?></td>
        <td><?php echo $order['buyer_name'];?></td>
        <td class="nowrap align-center"><?php echo date('Y-m-d H:i:s',$order['add_time']);?></td>
        <td class="align-center"><?php echo $order['order_amount'];?></td>
        <td class="align-center"><?php echo $order['payment_name'];?></td>
        <td class="align-center"><?php echo orderStateInfo($order['order_state'],$order['refund_state']);?></td>
        <td class="w60 align-center"><a href="index.php?act=trade&op=show_order&order_id=<?php echo $order['order_id'];?>"><?php echo $lang['nc_view'];?></a></td>
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
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
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
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('order_manage');$('#formSearch').submit();
    });
});
</script> 
