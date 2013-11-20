<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style type="text/css">
.store-name {
	width: 130px;
	display: inline-block;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
}
</style>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="get" action="index.php" target="_self">
    <table class="search-form">
      <input type="hidden" name="act" value="member" />
      <input type="hidden" name="op" value="order" />
      <tr>
        <td></td>
        <th><?php echo $lang['member_order_time'].$lang['nc_colon'];?></th>
        <td class="w180"><input type="text" class="text" name="add_time_from" id="add_time_from" value="<?php echo $_GET['add_time_from']; ?>"/>
          &#8211;
          <input type="text" class="text" name="add_time_to" id="add_time_to" value="<?php echo $_GET['add_time_to']; ?>"/></td>
        <th><?php echo $lang['member_order_sn'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" class="text" name="order_sn" value="<?php echo $_GET['order_sn']; ?>"></td>
        <th><?php echo $lang['member_order_state'].$lang['nc_colon'];?></th>
        <td class="w100"><select name="state_type">
            <option value="all" <?php echo $_GET['state_type']=='all'?'selected':''; ?>><?php echo $lang['member_order_all'];?></option>
            <option value="order_pay" <?php echo $_GET['state_type']=='order_pay'?'selected':''; ?>><?php echo $lang['member_order_wait_pay'];?></option>
            <option value="order_pay_confirm" <?php echo $_GET['state_type']=='order_pay_confirm'?'selected':''; ?>><?php echo $lang['member_order_wait_confirm'];?></option>
            <option value="order_no_shipping" <?php echo $_GET['state_type']=='order_no_shipping'?'selected':''; ?>><?php echo $lang['member_order_wait_ship'];?></option>
            <option value="order_shipping" <?php echo $_GET['state_type']=='order_shipping'?'selected':''; ?>><?php echo $lang['member_order_shipped'];?></option>
            <option value="order_finish" <?php echo $_GET['state_type']=='order_finish'?'selected':''; ?>><?php echo $lang['member_order_finished'];?></option>
            <option value="order_cancal" <?php echo $_GET['state_type']=='order_cancal'?'selected':''; ?>><?php echo $lang['member_order_canceled'];?></option>
            <option value="order_refer" <?php echo $_GET['state_type']=='order_refer'?'selected':''; ?>><?php echo $lang['member_order_refer']; ?></option>
            <option value="order_confirm" <?php echo $_GET['state_type']=='order_confirm'?'selected':''; ?>><?php echo $lang['member_order_confirm']; ?></option>
          </select></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['member_order_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="order ncu-table-style">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w70"></th>
        <th><?php echo $lang['member_order_goods_info'];?></th>
        <th class="w60"><?php echo $lang['member_order_price'];?></th>
        <th class="w40"><?php echo $lang['member_order_amount'];?></th>
        <th class="w90"><?php echo $lang['member_order_service'];?></th>
        <th class="w150"><?php echo $lang['member_order_store_name'];?></th>
        <th class="w100"><?php echo $lang['member_order_sum'];?></th>
        <th class="w110"><?php echo $lang['member_order_handle'];?></th>
      </tr>
    </thead>
    <?php if($output['order_array']) { ?>
    <tbody>
      <?php foreach ($output['order_array'] as $val) { ?>
      <tr>
        <td colspan="19" class="sep-row"></td>
      </tr>
      <tr>
        <th colspan="19"> <span class="fl ml10"><?php echo $lang['member_order_sn'].$lang['nc_colon'];?><span class="goods-num"><em><?php echo $val[0]['order_sn']; ?></em>
          <?php if ($val[0]['order_from'] == 2){?>
          <img src="<?php echo TEMPLATES_PATH;?>/images/mobile.png">
          <?php }?>
          <?php if(!empty($val[0]['group_id'])){ ?>
          <i class="red" title="<?php echo $lang['nc_groupbuy'];?>"><?php echo $lang['nc_groupbuy_flag'];?></i>
          <?php } ?>
          <?php if(!empty($val[0]['xianshi_id'])){ ?>
          <i class="green" title="<?php echo $lang['nc_xianshi'];?>"><?php echo $lang['nc_xianshi_flag'];?></i>
          <?php } ?>
          <?php if(!empty($val[0]['mansong_id'])){ ?>
          <i class="orange" title="<?php echo $lang['nc_mansong'];?>"><?php echo $lang['nc_mansong_flag'];?></i>
          <?php } ?>
          <?php if(!empty($val[0]['bundling_id'])){?>
          <i class="blue" title="<?php echo $lang['nc_bundling'];?>"><?php echo $lang['nc_bundling_flag'];?></i>
          <?php }?>
          </span></span> <span class="fl ml20"><?php echo $lang['member_order_time'].$lang['nc_colon'];?><em class="goods-time"><?php echo date("Y-m-d H:i:s",$val[0]['add_time']); ?></em></span> <span class="fl ml20"><a href="index.php?act=member&op=show_order&order_id=<?php echo $val[0]['order_id']; ?>" target="_blank" class="nc-show-order"><i></i><?php echo $lang['member_order_view_order'];?></a>
          <?php if ($val[0]['shipping_express_id']>0){?>
          <a href='index.php?act=member&op=show_express&order_id=<?php echo $val[0]['order_id']; ?>' class="nc-show-deliver"><i></i><?php echo $lang['member_order_show_deliver']?></a>
          <?php }?>
          </span> <span class="fr"><a href="javascript:void(0)" class="snsshare-btn" nc_type="sharegoods" data-param='{"gid":"<?php echo $val[0]['goods_id'];?>"}'><i></i>
          <h5><?php echo $lang['member_order_snsshare'];?></h5>
          </a></span> </th>
      </tr>
      <?php foreach($val as $k=>$v) { ?>
      <tr>
        <td class="bdl"></td>
        <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $v['goods_id'];?>" target="_blank"><img src="<?php echo thumb($v,'tiny'); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td><dl class="goods-name">
            <dt><a href="index.php?act=goods&goods_id=<?php echo $v['goods_id'];?>" target="_blank"><?php echo $v['goods_name']; ?></a></dt>
            <dd><?php echo $v['spec_info'];?></dd>
          </dl></td>
        <td class="goods-price"><i><?php echo $v['goods_price']; ?></i></td>
        <td><?php echo $v['goods_num']; ?></td>
        <?php if ((count($val) > 1 && $k ==0) || (count($val) == 1)){?>
        <td class="bdl" rowspan="<?php echo count($val);?>"><?php if(($v['order_state'] >= 20 && $v['order_state'] < 40 && $v['payment_code'] != 'cod') && ($v['payment_code'] == 'predeposit' || C('payment') == 0)) { ?>
          <?php if ($v['refund_state'] == 0){?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_order_refund'];?>" dialog_id="member_order_refund" dialog_width="400" uri="index.php?act=member_refund&op=add&order_id=<?php echo $v['order_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_refund"> <?php echo $lang['member_order_refund'];?></a></p>
          <?php } elseif ($v['refund']['refund_state'] == 1){?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_order_refund'];?>" dialog_id="member_order_refund" dialog_width="400" uri="index.php?act=member_refund&op=add&order_id=<?php echo $v['order_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_refund"> <?php echo $lang['member_refund_confirm'];?></a></p>
          <?php }?>
          <?php if ($v['order_state'] == 30 && $v['return_state'] == 0){?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_order_return'];?>" dialog_id="member_order_return" dialog_width="400" uri="index.php?act=member_return&op=add&order_id=<?php echo $v['order_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_return"><?php echo $lang['member_order_return'];?></a></p>
          <?php }?>
          <?php } elseif ($v['order_state'] >= 20 && $v['order_state'] < 40 && $v['payment_code'] != 'cod'){?>
          <p>
            <?php if ($v['refund_state'] == 0){?>
            <a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_order_refund'];?>" dialog_id="member_order_refund" dialog_width="400" uri="index.php?act=member_refund&op=offline_add&order_id=<?php echo $v['order_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_refund"><?php echo $lang['member_order_refund'];?></a>
            <?php } elseif ($v['refund']['refund_state'] == 1){?>
            <a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_order_refund'];?>" dialog_id="member_order_refund" dialog_width="400" uri="index.php?act=member_refund&op=offline_add&order_id=<?php echo $v['order_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_refund"><?php echo $lang['member_refund_confirm'];?></a>
            <?php } elseif ($v['refund']['refund_state'] == 2 && $v['refund']['buyer_confirm'] == 1){?>
            <a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_buyer_confirm'];?>" dialog_id="member_buyer_confirm" dialog_width="400" uri="index.php?act=member_refund&op=buyer_confirm&log_id=<?php echo $v['refund']['log_id']; ?>" id="order<?php echo $v['order_id']; ?>_buyer_confirm"><?php echo $lang['member_buyer_confirm'];?></a>
            <?php }?>
          </p>
          <?php if ($v['order_state'] == 30 && $v['return_state'] == 0){?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_order_return'];?>" dialog_id="member_order_return" dialog_width="400" uri="index.php?act=member_return&op=add&order_id=<?php echo $v['order_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_return"> <?php echo $lang['member_order_return'];?></a> </p>
          <?php } elseif ($v['order_state'] == 30 && $v['return']['return_state'] == 1){?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['member_order_return'];?>" dialog_id="member_order_return" dialog_width="400" uri="index.php?act=member_return&op=view&return_id=<?php echo $v['return']['return_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_return"> <?php echo $lang['member_return_confirm'];?></a> </p>
          <?php }?>
          <?php }?>
          <?php if($v['refund_state']>0 && $v['refund_amount']>0) { ?>
          <p><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['nc_view'].$lang['member_order_refund'];?>" dialog_id="member_order_refund" dialog_width="400" uri="index.php?act=member_refund&op=view&log_id=<?php echo $v['refund']['log_id']; ?>"><?php echo $lang['member_order_refund'].$lang['nc_colon'];?><?php echo $lang['currency'];?><?php echo $v['refund_amount']; ?></a></p>
          <?php }?>
          <?php 
			if(empty($val[0]['finnshed_time'])) {
				$time_limit = true;
				}
			else {
				$time_limit = (intval($val[0]['finnshed_time'])+intval($output['complain_time_limit']))>time();
				}
			if(intval($val[0]['order_state']) >= 20 && $time_limit) {
				?>
          <p><a href="index.php?act=member_complain&op=complain_submit&order_id=<?php echo $val[0]['order_id']; ?>" target="_blank" class="ncu-btn2"><?php echo $lang['member_order_complain'];?></a></p>
          <?php } ?></td>
        <td class="bdl" rowspan="<?php echo count($val);?>"><p class="store-name"><a href="index.php?act=show_store&id=<?php echo $val[0]['store_id']; ?>" target="_blank" title="<?php echo $val[0]['store_name']; ?>"><?php echo $val[0]['store_name']; ?></a></p>
          <p><a href="index.php?act=member_snshome&mid=<?php echo $val[0]['member_id'];?>" title="<?php echo $lang['member_evaluation_storekeeper'];?>"><?php echo $val[0]['member_name'];?></a>&nbsp;<a target="_blank" href="index.php?act=home&op=sendmsg&member_id=<?php echo $val[0]['seller_id']; ?>" class="message" title="<?php echo $lang['nc_message'];?>"></a></p>
          <p>
            <?php if(!empty($val[0]['store_qq'])){?>
            <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $val[0]['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $val[0]['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $val[0]['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
            <?php }?>
            <?php if(!empty($val[0]['store_ww'])){?>
            <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $val[0]['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $val[0]['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
            <?php }?>
          </p></td>
        <td class="bdl" rowspan="<?php echo count($val);?>"><p class="goods-price" id="order<?php echo $val[0]['order_id']; ?>_order_amount"><strong><?php echo $val[0]['order_amount']; ?></strong></p>
          <?php if ($val[0]['payment_name']) { ?>
          <p class="goods-pay" title="<?php echo $lang['member_order_pay_method'].$lang['nc_colon'];?><?php echo $val[0]['payment_name']; ?>"><?php echo $val[0]['payment_name']; ?></p>
          <?php } ?>
          <p class="goods-freight">
            <?php if ($v['shipping_fee'] > 0){?>
            (<?php echo $lang['member_order_shipping_han'].$v['shipping_name'];?> <?php echo $v['shipping_fee'];?>)
            <?php }else{?>
            <?php echo $lang['nc_common_shipping_free'];?>
            <?php }?>
          </p></td>
        <td class="bdl bdr" rowspan="<?php echo count($val);?>"><p><?php echo $val[0]['state_info']; ?><br/>
            <?php if($val[0]['evaluation_status']==1) { ?>
            <br/>
            <?php echo $lang['member_order_evaluated'];?>
            <?php } ?>
          </p>
          <?php if ($val[0]['refund_state'] == 0 && $val[0]['order_state'] == 30) { ?>
          <?php if ($val[0]['payment_direct'] == '1'){?>
          <p><a href="javascript:void(0)" class="ncu-btn7 mt5" nc_type="dialog" dialog_id="buyer_order_confirm_order" dialog_width="400" dialog_title="<?php echo $lang['member_order_ensure_order'];?>" uri="index.php?act=member&op=change_state&state_type=confirm_order&order_sn=<?php echo $val[0]['order_sn']; ?>&order_id=<?php echo $val[0]['order_id']; ?>" id="order<?php echo $val[0]['order_id']; ?>_action_confirm"><?php echo $lang['member_order_ensure_order'];?></a></p>
          <?php }else{?>
          <p><a href="javascript:void(0)" id="order<?php echo $val[0]['order_id']; ?>_action_confirm" onclick="window.open('index.php?act=payment&op=receive&order_id=<?php echo $val[0]['order_id']; ?>');"><?php echo $lang['member_order_ensure_order'];?></a></p>
          <?php }?>
          <?php } ?>
          <?php if ($val[0]['order_state'] == 10) { ?>
          <p><a href="javascript:void(0)" style="color:#F30; text-decoration:underline;" nc_type="dialog" dialog_width="400" dialog_title="<?php echo $lang['member_order_cancel_order'];?>" dialog_id="buyer_order_cancel_order" uri="index.php?act=member&op=change_state&state_type=cancel_order&order_sn=<?php echo $val[0]['order_sn']; ?>&order_id=<?php echo $val[0]['order_id']; ?>"  id="order<?php echo $val[0]['order_id']; ?>_action_cancel"><?php echo $lang['member_order_cancel_order'];?></a></p>
          <?php } ?>
          <?php if ($val[0]['order_state'] == 10) { ?>
          <p><a class="ncu-btn6 mt5" href="index.php?act=cart&op=order_pay&order_id=<?php echo $val[0]['order_id']; ?>" id="order<?php echo $val[0]['order_id']; ?>_action_pay"><?php echo $lang['member_order_pay'];?></a></p>
          <?php } ?>
          <?php if ($val[0]['order_state'] == 40 && $val[0]['refund_state']<2 && $val[0]['able_evaluate']) { ?>
          <p><a class="ncu-btn2 mt5" href="index.php?act=member_evaluate&op=add&order_id=<?php echo $val[0]['order_id']; ?>"><?php echo $lang['member_order_want_evaluate'];?></a><!--我要评价--></p>
          <?php } ?></td>
        <?php }?>
      </tr>
      <?php } ?>
      <?php } } else { ?>
      <tr>
        <td colspan="19" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php if($output['order_array']) { ?>
    <tfoot>
      <tr>
        <td colspan="19"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" ></script> 
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/sns.js" ></script> 
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>