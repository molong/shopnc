<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <table class="table tb-type2 order">
    <tbody>
      <tr class="space">
        <th colspan="15"><?php echo $lang['order_state'];?></th>
      </tr>
      <tr>
        <td colspan="2"><ul>
            <li>
            <strong><?php echo $lang['order_number'];?>:</strong><?php echo $output['list'][0]['order_sn'];?>
            </li>
            <li><strong><?php echo $lang['order_state'];?>:</strong><?php echo orderStateInfo($output['list'][0]['order_state'],$output['list'][0]['refund_state']);?></li>
            <li><strong><?php echo $lang['order_total_price'];?>:</strong><span class="red_common"><?php echo $lang['currency'].$output['list'][0]['order_amount'];?> </span>
            	<?php if($output['list'][0]['refund_state']>0 && $output['list'][0]['refund_amount']>0) { ?>
            	(<?php echo $lang['order_refund'];?>:<?php echo $lang['currency'].$output['list'][0]['refund_amount'];?>)
            	<?php } ?></li>
            <li><strong><?php echo $lang['order_total_transport'];?>:</strong><?php echo $lang['currency'].$output['list'][0]['shipping_fee'];?></li>
          </ul></td>
      </tr>
      <tr class="space">
        <th colspan="2"><?php echo $lang['order_detail'];?></th>
      </tr>
      <tr>
        <th><?php echo $lang['order_info'];?></th>
      </tr>
      <tr>
        <td><ul>
            <li><strong><?php echo $lang['buyer_name'];?>:</strong><?php echo $output['list'][0]['buyer_name'];?></li>
            <li><strong><?php echo $lang['seller_name'];?>:</strong><?php echo $output['list'][0]['member_name'];?></li>
            <?php if($output['list'][0]['payment_name'] != ''){?>
            <li><strong><?php echo $lang['payment'];?>:</strong><?php echo $output['list'][0]['payment_name'];?></li>
            <?php }?>
            <?php if($output['list'][0]['pay_message'] != ''){?>
            <li><strong><?php echo $lang['pay_message'];?>:</strong>
		      	<?php $tmp = unserialize($output['list'][0]['pay_message']);?>
	      		<?php if ($tmp !== false){?>
		      	<?php if ($tmp['user']) echo $lang['pay_bank_user'].' '.stripslashes($tmp['user']);?>
		      	<?php if ($tmp['bank']) echo $lang['pay_bank_bank'].' '.stripslashes($tmp['bank']);?>
		      	<?php if ($tmp['account']) echo $lang['pay_bank_account'].' '.stripslashes($tmp['account']);?>
		      	<?php if ($tmp['num']) echo $lang['pay_bank_num'].' '.stripslashes($tmp['num']);?>
		      	<?php if ($tmp['date']) echo $lang['pay_bank_date'].' '.stripslashes($tmp['date']);?>
		      	<?php if ($tmp['order']) echo $lang['pay_bank_order'].' '.stripslashes($tmp['order']);?>
		      	<?php if ($tmp['extend']) echo $lang['pay_bank_extend'].' '.stripslashes($tmp['extend']);?>
		      <?php }else{?>
		     	<?php echo $output['list'][0]['pay_message'];?>
		      <?php } ?>
            </li>
            <?php }?>
            <li><strong><?php echo $lang['order_time'];?>:</strong><?php echo date('Y-m-d H:i:s',$output['list'][0]['add_time']);?></li>
            <?php if($output['list'][0]['payment_time'] != ''){?>
            <li><strong><?php echo $lang['payment_time'];?>:</strong><?php echo date('Y-m-d H:i:s',$output['list'][0]['payment_time']);?></li>
            <?php }?>
            <?php if($output['list'][0]['shipping_time'] != ''){?>
            <li><strong><?php echo $lang['ship_time'];?>:</strong><?php echo date('Y-m-d H:i:s',$output['list'][0]['shipping_time']);?></li>
            <?php }?>
            <?php if($output['list'][0]['finnshed_time'] != ''){?>
            <li><strong><?php echo $lang['complate_time'];?>:</strong><?php echo date('Y-m-d H:i:s',$output['list'][0]['finnshed_time']);?></li>
            <?php }?>
            <?php if($output['list'][0]['order_message'] != ''){?>
            <li><strong><?php echo $lang['buyer_message'];?>:</strong><?php echo $output['list'][0]['order_message'];?></li>
            <?php }?>
          </ul></td>
      </tr>
      <tr>
        <th><?php echo $lang['consignee_ship_order_info'];?></th>
      </tr>
      <tr>
        <td><ul>
            <li><strong><?php echo $lang['consignee_name'];?>:</strong><?php echo $output['list'][0]['true_name'];?></li>
            <li><strong><?php echo $lang['region'];?>:</strong><?php echo $output['list'][0]['area_info'];?></li>
            <li><strong><?php echo $lang['zip'];?>:</strong><?php echo $output['list'][0]['zip_code'];?></li>
            <li><strong><?php echo $lang['tel_phone'];?>:</strong><?php echo $output['list'][0]['tel_phone'];?></li>
            <li><strong><?php echo $lang['mob_phone'];?>:</strong><?php echo $output['list'][0]['mob_phone'];?></li>
            <li><strong><?php echo $lang['address'];?>:</strong><?php echo $output['list'][0]['address'];?></li>
            <li><strong><?php echo $lang['ship_method'];?>:</strong><?php echo $output['list'][0]['shipping_name'];?></li>
            <?php if($output['list'][0]['shipping_code'] != ''){?>
            <li><strong><?php echo $lang['ship_code'];?>:</strong><?php echo $output['list'][0]['shipping_code'];?></li>
            <?php }?>
          </ul></td>
      </tr>
      <tr>
        <th><?php echo $lang['product_info'];?></th>
      </tr>
      <tr>
        <td><table class="table tb-type2 goods ">
            <tbody>
              <tr>
                <th></th>
                <th><?php echo $lang['product_info'];?></th>
                <th class="align-center"><?php echo $lang['product_spec'];?></th>
                <th class="align-center"><?php echo $lang['product_price'];?></th>
                <th class="align-center"><?php echo $lang['product_num'];?></th>
              </tr>
              <?php foreach($output['list'] as $goods){?>
              <tr>
                <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><a href="<?php echo SiteUrl;?>/index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><img alt="<?php echo $lang['product_pic'];?>" src="<?php echo thumb($goods,'tiny');?>" onload="javascript:DrawImage(this,56,56);"/> </a></span></div></td>
                <td class="w50pre"><a href="<?php echo SiteUrl;?>/index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_name'];?></a></td>
                <td class="align-center"><?php echo $goods['spec_info'];?></td>
                <td class="w96 align-center"><span class="red_common"><?php echo $lang['currency'].$goods['goods_price'];?></span></td>
                <td class="w96 align-center"><?php echo $goods['goods_num'];?></td>
              </tr>
              <?php }?>
            </tbody>
          </table></td>
      </tr>
      <tr>
      	<th><?php echo $lang['nc_promotion'];?></th>
      </tr>
      <tr>
          <td>
  <!-- S 促销信息 -->
      <?php if(!empty($output['list'][0]['group_id'])){ ?>
      <span style="color:red"><?php echo $lang['nc_groupbuy'];?></span>
      <a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$output['list'][0]['group_id'],'id'=>$output['list'][0]['store_id']), 'groupbuy');?>" target="_blank"><?php echo $lang['nc_groupbuy_view'];?></a>
      <?php } ?>
      <?php if(!empty($output['list'][0]['xianshi_id'])){ ?>
      <span style="color:red"><?php echo $output['list'][0]['xianshi_explain'];?></span>
      <?php } ?>
      <?php if(!empty($output['list'][0]['mansong_id'])){ ?>
      <span style="color:red"><?php echo $output['list'][0]['mansong_explain'];?></span>
      <?php } ?>
      <?php if(!empty($output['list'][0]['bundling_id'])){ ?>
      <span style="color:red"><?php echo $output['list'][0]['bundling_explain'];?></span>
      <?php } ?>
  <!-- E 促销信息 -->

          </td>
      </tr>
    <?php if(is_array($output['refund_list']) and !empty($output['refund_list'])) { ?>
    
      <tr>
      	<th><?php echo $lang['order_refund'];?></th>
      </tr>
      <tr>
        <td><ul>
      <?php foreach($output['refund_list'] as $val) { ?>
      <li><span><?php echo date("Y-m-d H:i:s",$val['add_time']); ?></span> <?php echo $val['refund_paymentname'].$lang['nc_colon'];?><?php echo $lang['currency'];?><?php echo $val['order_refund']; ?> </li>
      <?php } ?>
          </ul></td>
      </tr>
    <?php } ?>
    <?php if(is_array($output['return_list']) and !empty($output['return_list'])) { ?>
    
      <tr>
      	<th><?php echo $lang['order_return'];?></th>
      </tr>
      <tr>
        <td><ul>
      <?php foreach($output['return_list'] as $val) { ?>
      <li><span><?php echo date("Y-m-d H:i:s",$val['add_time']); ?></span> <?php echo $val['goods_name'];?> <span><?php echo $val['spec_info']; ?></span> <?php echo $lang['order_amount'].$lang['nc_colon'];?><?php echo $val['goods_returnnum']; ?> </li>
      <?php } ?>
          </ul></td>
      </tr>
    <?php } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td><a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a></td>
      </tr>
    </tfoot>
  </table>
</div>
