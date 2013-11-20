<div class="wrap-shadow">
  <div class="wrap-all ncu-order-view">
      <h2><?php echo $lang['store_show_order_detail'];?></h2>
      <dl>
        <dt><?php echo $lang['store_order_state'].$lang['nc_colon'];?></dt>
        <dd><strong><?php echo $output['order_info']['state_info']; ?></strong></dd>
        <dt><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?></dt>
        <dd> <?php echo $output['order_info']['order_sn']; ?> </dd>
        <dt><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?></dt>
        <dd><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></dd>
      </dl>
      <h3><?php echo $lang['store_show_order_seller_info'];?></h3>
      <dl>
        <dt><?php echo $lang['store_show_order_store_name'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['store_name']; ?></dd>
        <dt><?php echo $lang['store_order_phone'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['store_tel']; ?></dd>
        <dt><?php echo $lang['store_create_location'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['area_info']; ?></dd>
        <dt>QQ<?php echo $lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['store_qq']; ?></dd>
        <dt><?php echo $lang['store_show_order_wangwang'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['store_info']['store_ww']; ?></dd>
        <dt class="cb"><?php echo $lang['store_create_address'].$lang['nc_colon'];?></dt>
        <dd style="width:90%"><?php echo $output['store_info']['store_address']; ?></dd>
      </dl>
      <h3><?php echo $lang['store_show_order_info'];?></h3>
      <table class="ncu-table-style">
        <thead>
          <tr>
            <th class="w10">&nbsp;</th>
            <th class="w70">&nbsp;</th>
            <th class="tl"><?php echo $lang['store_show_order_goods_name'];?></th>
            <th class="w150"><?php echo $lang['store_show_order_amount'];?></th>
            <th class="w150"><?php echo $lang['store_show_order_price'];?></th>
          </tr>
        </thead>
        <tbody>
          <?php if(is_array($output['order_goods_list']) and !empty($output['order_goods_list'])) {
						foreach($output['order_goods_list'] as $val) {
				?>
          <tr class="bd-line">
            <td></td>
            <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><img src="<?php echo thumb($val,'tiny'); ?>" /></a></span></div></td>
            <td class="tl"><dl class="goods-name">
                <dt><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><?php echo $val['goods_name']; ?></a></dt>
                <dd><?php echo str_replace(':', $lang['nc_colon'], $val['spec_info']); ?></dd>
              </dl></td>
            <td><?php echo $val['goods_num']; ?></td>
            <td><?php echo $lang['currency'];?><?php echo $val['goods_price']; ?></td>
          </tr>
          <?php }  }  ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="20" class="transportation">
         <?php if(!empty($output['order_info']['shipping_fee']) && $output['order_info']['shipping_fee'] != '0.00'){ ?>
            <?php echo $lang['store_show_order_tp_fee'];?>: <span><?php echo $lang['currency'];?><?php echo $output['order_info']['shipping_fee']; ?></span> 
         <?php }else{?>
         	<?php echo $lang['nc_common_shipping_free'];?>
         <?php }?>
         <?php echo $lang['store_order_sum'].$lang['nc_colon'];?><b><?php echo $lang['currency'];?><?php echo $output['order_info']['order_amount']; ?></b>
              <?php if($val['refund_state']>0 && $val['refund_amount']>0) { ?>
              &nbsp;&nbsp;<?php echo $lang['store_order_refund'].$lang['nc_colon'];?><b><?php echo $lang['currency'];?><?php echo $val['refund_amount']; ?></b>
              <?php } ?></td>
          </tr>
        </tfoot>
      </table>
      <ul class="order_detail_list">
        <?php if($output['order_info']['payment_name']) { ?>
        <li><?php echo $lang['store_order_pay_method'].$lang['nc_colon'];?><?php echo $output['order_info']['payment_name']; ?></li>
        <?php } ?>        
	      <?php if($output['order_info']['pay_message']) { ?>
	      <li>
	       <?php echo $lang['store_show_order_pay_message'].$lang['nc_colon'];?>
		      	<?php $tmp = unserialize($output['order_info']['pay_message']);?>
	      		<?php if (is_array($tmp)){?>
		      	<?php if ($tmp['user']) echo $lang['pay_bank_user'].' '.stripslashes($tmp['user']);?>
		      	<?php if ($tmp['bank']) echo $lang['pay_bank_bank'].' '.stripslashes($tmp['bank']);?>
		      	<?php if ($tmp['account']) echo $lang['pay_bank_account'].' '.stripslashes($tmp['account']);?>
		      	<?php if ($tmp['num']) echo $lang['pay_bank_num'].' '.stripslashes($tmp['num']);?>
		      	<?php if ($tmp['date']) echo $lang['pay_bank_date'].' '.stripslashes($tmp['date']);?>
		      	<?php if ($tmp['order']) echo $lang['pay_bank_order'].' '.stripslashes($tmp['order']);?>
		      	<?php if ($tmp['extend']) echo $lang['pay_bank_extend'].' '.stripslashes($tmp['extend']);?>
		      <?php }else{?>
		     	<?php echo $output['order_info']['pay_message']; ?></li>
		      <?php } ?>
		   <?php } ?>
        <li><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?><?php echo date("Y-m-d H:i:s",$output['order_info']['add_time']); ?></li>
        <?php if($output['order_info']['payment_time']) { ?>
        <li><?php echo $lang['store_show_order_pay_time'].$lang['nc_colon'];?><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']); ?></li>
        <?php } ?>
        <?php if($output['order_info']['shipping_time']) { ?>
        <li><?php echo $lang['store_show_order_send_time'].$lang['nc_colon'];?><?php echo date("Y-m-d H:i:s",$output['order_info']['shipping_time']); ?></li>
        <?php } ?>
        <?php if($output['order_info']['finnshed_time']) { ?>
        <li><?php echo $lang['store_show_order_finish_time'].$lang['nc_colon'];?><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></li>
        <?php } ?>
      </ul>
      <h3><?php echo $lang['nc_promotion'];?></h3>
      <!-- S 促销信息 -->
      <div style="height:30px;line-height:30px;">
        <?php if(!empty($output['order_info']['group_id'])){ ?>
        <span style="color:red"><?php echo $lang['nc_groupbuy'];?></span> <?php echo $output['group_name'];?> <a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$output['order_info']['group_id'],'id'=>$output['order_info']['store_id']), 'groupbuy');?>" target="_blank"><?php echo $lang['nc_groupbuy_view'];?></a>
        <?php } ?>
        <?php if(!empty($output['order_info']['xianshi_id'])){ ?>
        <span style="color:red"><?php echo $output['order_info']['xianshi_explain'];?></span>
        <?php } ?>
        <?php if(!empty($output['order_info']['mansong_id'])){ ?>
        <span style="color:red"><?php echo $output['order_info']['mansong_explain'];?></span>
        <?php } ?>
        <?php if(!empty($output['order_info']['bundling_id'])){ ?>
        <span style="color:red"><?php echo $output['order_info']['bundling_explain'];?></span>
        <?php } ?>
      </div>
      <!-- E 促销信息 -->
      <h3><?php echo $lang['store_show_order_shipping_info'];?></h3>
      <dl>
        <dt><?php echo $lang['store_show_order_receiver'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['order_info']['true_name']; ?></dd>
        <dt><?php echo $lang['store_create_zipcode'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['order_info']['zip_code']; ?>&nbsp;</dd>
        <dt><?php echo $lang['store_order_phone'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['order_info']['tel_phone']; ?>&nbsp;</dd>
        <dt><?php echo $lang['store_show_order_mobile'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['order_info']['mob_phone']; ?>&nbsp;</dd>
        <?php if($output['order_info']['shipping_code']) { ?>
        <dt><?php echo $lang['store_order_shipping_no'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['order_info']['shipping_code']; ?>&nbsp;</dd>
        <?php } ?>
        <?php if($output['order_info']['order_message']) { ?>
        <dt><?php echo $lang['store_show_order_buyer_message'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['order_info']['order_message']; ?>&nbsp;</dd>
        <?php } ?>
        <dt class="cb"><?php echo $lang['store_show_order_receiver_address'].$lang['nc_colon'];?></dt>
        <dd style="width:90%"><?php echo $output['order_info']['area_info']; ?><?php echo $output['order_info']['address']; ?></dd>
        <div class="clear"></div>
      </dl>
      <?php if(is_array($output['order_log']) and !empty($output['order_log']) and $output['order_info']['seller_id'] == $_SESSION['member_id']) { ?>
      <h3><?php echo $lang['store_show_order_handle_history'];?></h3>
      <ul class="log-list">
        <?php foreach($output['order_log'] as $val) { ?>
        <li> <span class="operator">
          <?php if($val['operator'] == '') { ?>
          <span style="color:green;"><?php echo $lang['store_show_system'];?></span>
          <?php } else { echo $val['operator']; } ?>
          </span> <?php echo $lang['store_show_order_at'];?> <span class="log-time"><?php echo date("Y-m-d H:i:s",$val['log_time']); ?></span> <?php echo $lang['store_show_order_cur_state'].$lang['nc_colon'];?><span class="order-status"><?php echo $val['order_state']; ?></span> <?php echo $lang['store_show_order_next_state'].$lang['nc_colon'];?><span class="order-status"><?php echo $val['change_state']; ?></span>
          <?php if($val['state_info']!='') {  ?>
          <?php echo $lang['store_show_order_reason'].$lang['nc_colon'];?><span class="reason"><?php echo $val['state_info']; ?></span>
          <?php } ?>
        </li>
        <?php } ?>
      </ul>
      <?php } ?>
      <?php if(is_array($output['refund_list']) and !empty($output['refund_list'])) { ?>
      <h3><?php echo $lang['store_order_refund'];?></h3>
      <ul class="log-list">
        <?php foreach($output['refund_list'] as $val) { ?>
        <li> <span class="log-time"><?php echo date("Y-m-d H:i:s",$val['add_time']); ?></span> <a href="index.php?act=refund&type=refund_sn&key=<?php echo $val['refund_sn']; ?>"><?php echo $val['refund_sn'];?></a> <?php echo $val['refund_paymentname'].$lang['nc_colon'];?><strong><?php echo $lang['currency'];?><?php echo $val['order_refund']; ?></strong> </li>
        <?php } ?>
      </ul>
      <?php } ?>
      <?php if(is_array($output['return_list']) and !empty($output['return_list'])) { ?>
      <h3><?php echo $lang['store_order_return'];?></h3>
      <ul class="log-list">
        <?php foreach($output['return_list'] as $val) { ?>
        <li><span class="log-time"><?php echo date("Y-m-d H:i:s",$val['add_time']); ?></span> <a href="index.php?act=return&type=return_sn&key=<?php echo $val['return_sn']; ?>"><?php echo $val['return_sn'];?></a> <?php echo $val['goods_name'];?> <span class="order-status"><?php echo $val['spec_info']; ?></span> <?php echo $lang['store_show_order_amount'].$lang['nc_colon'];?><strong><?php echo $val['goods_returnnum']; ?></strong> </li>
        <?php } ?>
      </ul>
      <?php } ?>
    </div>
</div>
