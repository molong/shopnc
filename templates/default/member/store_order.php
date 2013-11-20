<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="get" action="index.php" target="_self">
    <table class="search-form">
      <input type="hidden" name="act" value="store" />
      <input type="hidden" name="op" value="store_order" />
      <?php if (trim($_GET['state_type'])!='') { ?>
      <input type="hidden" name="state_type" value="<?php echo trim($_GET['state_type']); ?>" />
      <?php } ?>
      <tr>
        <th><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?></th>
        <td class="w150"><input type="text" class="text" name="order_sn" value="<?php echo trim($_GET['order_sn']); ?>" /></td>
        <th><?php echo $lang['store_order_buyer'].$lang['nc_colon'];?></span></th>
        <td class="w150"><input type="text" class="text" name="buyer_name" value="<?php echo trim($_GET['buyer_name']); ?>" /></td>
        <th><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?></th>
        <td><input type="text" class="text" name="add_time_from" id="add_time_from" value="<?php echo $_GET['add_time_from']; ?>" />
          &#8211;
          <input id="add_time_to" class="text" type="text" name="add_time_to" value="<?php echo $_GET['add_time_to']; ?>" /></td>
        <td class="w90 tc"><input type="submit"  class="submit"value="<?php echo $lang['store_order_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style order">
    <thead>
      <tr>
        <th class="w10"></th>
        <th colspan="2"><?php echo $lang['store_order_goods_detail'];?></th>
        <th class="w70"><?php echo $lang['store_order_goods_single_price'];?></th>
        <th class="w50"><?php echo $lang['store_show_order_amount'];?></th>
        <th class="w90"><?php echo $lang['store_order_sell_back'];?></th>
        <th class="w110"><?php echo $lang['store_order_buyer'];?></th>
        <th class="w110"><?php echo $lang['store_order_sum'];?></th>
        <th class="w110"><?php echo $lang['store_order_order_stateop'];?></th>
      </tr>
    </thead>
    <?php if (is_array($output['goods_array']) and !empty($output['goods_array'])) { ?>
    <?php foreach($output['goods_array'] as $val) { ?>
    <tbody>
      <tr>
        <td colspan="20" class="sep-row"></td>
      </tr>
      <tr>
        <th colspan="20"><span class="fl ml10"><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?><span class="goods-num"><em><?php echo $val[0]['order_sn']; ?></em>
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
          </span> </span> <span class="fl ml20"><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?><em class="goods-time"><?php echo date("Y-m-d H:i:s",$val[0]['add_time']); ?></em></span> <span class="fl ml20"><a href="index.php?act=store&op=show_order&order_id=<?php echo $val[0]['order_id']; ?>" target="_blank" class="nc-show-order fl"><i></i><?php echo $lang['store_order_view_order'];?></a>
          <?php if ($val[0]['shipping_express_id']>0){?>
          <a href='index.php?act=deliver&op=search_deliver&order_sn=<?php echo $val[0]['order_sn']; ?>' class="nc-show-deliver fl"><i></i><?php echo $lang['store_order_show_deliver'];?></a>
          <?php }?>
          </span><span class="fr"><a href="index.php?act=member_orderprint&order_id=<?php echo $val[0]['order_id'];?>" target="_blank" title="<?php echo $lang['store_show_order_printorder'];?>"/><i class="print-order"></i></a></span></th>
      </tr>
      <?php foreach($val as $k=>$v) { ?>
      <tr>
        <td class="bdl"></td>
        <td class="w70"><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $v['goods_id'];?>" target="_blank"><img src="<?php echo thumb($v,'tiny'); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $v['goods_id']; ?>"><?php echo $v['goods_name']; ?></a></dt>
            <dd><?php echo str_replace(':', $lang['nc_colon'], $v['spec_info']); ?></dd>
          </dl></td>
        <td><?php echo $v['goods_price']; ?></td>
        <td><?php echo $v['goods_num']; ?></td>
        <?php if ((count($val) > 1 && $k ==0) || (count($val) == 1)){?>
        <td class="bdl" rowspan="<?php echo count($val);?>"><p>
            <?php if($v['refund']['refund_state'] == 1) { ?>
            <a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['store_order_refund'];?>" dialog_id="seller_order_refund" dialog_width="480" uri="index.php?act=refund&op=edit&log_id=<?php echo $v['refund']['log_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_refund"><?php echo $lang['store_order_refund'];?></a>
            <?php } ?>
            <?php if($v['return']['return_state'] == 1) { ?>
            &nbsp;<a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['store_order_return'];?>" dialog_id="seller_order_return" dialog_width="480" uri="index.php?act=return&op=edit&return_id=<?php echo $v['return']['return_id']; ?>" id="order<?php echo $v['order_id']; ?>_action_return"><?php echo $lang['store_order_return'];?></a>
            <?php } ?>
          </p>
          <?php if($v['refund']['refund_state'] == 2 && $v['refund']['buyer_confirm'] == 1) { ?>
          <p><?php echo $lang['store_buyer_confirm']; ?></p>
          <?php }?>
          <?php if($v['refund_state']>0 && $v['refund_amount']>0) { ?>
          <p><?php echo $lang['store_order_refund'].$lang['nc_colon'];?><?php echo $lang['currency'];?><?php echo $v['refund_amount']; ?></p>
          <?php }?>
          <?php if(empty($v['finnshed_time'])) {
              		$time_limit = true;
              		} else {
              			$time_limit = (intval($v['finnshed_time'])+intval($output['complain_time_limit']))>time();
              		}
              		if(intval($v['order_state']) >= 30 && $time_limit) {
              		?>
          <p><a href="index.php?act=store_complain&op=complain_submit&order_id=<?php echo $v['order_id']; ?>" class="ncu-btn2 mt5" target="_blank" ><?php echo $lang['store_order_complain'];?></a></p>
          <?php } ?></td>
        <td class="bdl" rowspan="<?php echo count($val);?>"><p><?php echo $v['buyer_name']; ?><a target="_blank" class="message" href="index.php?act=home&op=sendmsg&member_id=<?php echo $v['buyer_id'];?>"></a></p>
          <div class="buyer"><?php echo $output['order_array'][$v['order_id']]['true_name'];?>
            <p>
              <?php if(!empty($v['member_info']['member_qq'])){?>
              <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v['member_info']['member_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $v['member_info']['member_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $v['member_info']['member_qq'];?>:52" style=" vertical-align: middle;"/></a>
              <?php }?>
              <?php if(!empty($v['member_info']['member_ww'])){?>
              <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $v['member_info']['member_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $val[0]['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang" style=" vertical-align: middle;" /></a>
              <?php }?>
            </p>
            <div class="buyer-info"> <em></em>
              <div class="con">
                <h3><i></i><span><?php echo $lang['store_order_buyer_info'];?></span></h3>
                <dl>
                  <dt><?php echo $lang['store_order_receiver'].$lang['nc_colon'];?></dt>
                  <dd><?php echo $output['order_array'][$v['order_id']]['true_name'];?></dd>
                </dl>
                <dl>
                  <dt><?php echo $lang['store_order_phone'].$lang['nc_colon'];?></dt>
                  <dd><?php echo $output['order_array'][$v['order_id']]['tel_phone'];?></dd>
                </dl>
                <dl>
                  <dt><?php echo $lang['store_order_mobile'].$lang['nc_colon'];?></dt>
                  <dd><?php echo $output['order_array'][$v['order_id']]['mob_phone'];?></dd>
                </dl>
                <dl>
                  <dt><?php echo $lang['store_order_email'].$lang['nc_colon'];?></dt>
                  <dd><?php echo $v['member_info']['member_email'];?></dd>
                </dl>
                <dl>
                  <dt><?php echo $lang['store_order_area'].$lang['nc_colon'];?></dt>
                  <dd><?php echo $output['order_array'][$v['order_id']]['area_info'];?></dd>
                </dl>
                <dl>
                  <dt><?php echo $lang['store_order_address'].$lang['nc_colon'];?></dt>
                  <dd><?php echo $output['order_array'][$v['order_id']]['address'];?></dd>
                </dl>
                <dl>
                  <dt><?php echo $lang['store_order_zip_code'].$lang['nc_colon'];?></dt>
                  <dd><?php echo $output['order_array'][$v['order_id']]['zip_code'];?></dd>
                </dl>
              </div>
            </div>
          </div></td>
        <td class="bdl" rowspan="<?php echo count($val);?>"><p class="goods-price"><?php echo $v['order_amount']; ?></p>
          <p class="goods-pay"><?php echo $v['payment_name']; ?></p>
          <p class="goods-freight">
            <?php if ($v['shipping_fee'] > 0){?>
            (<?php echo $lang['store_show_order_shipping_han'].$v['shipping_name'];?> <?php echo $v['shipping_fee'];?>)
            <?php }else{?>
            <?php echo $lang['nc_common_shipping_free'];?>
            <?php }?>
          </p>
          <p>
            <?php if( in_array($v['order_state'],array(50,60)) ) { ?>
            <a href="javascript:void(0)" class="ncu-btn2 mt5" uri="index.php?act=store&op=change_state&state_type=store_order_edit_price&order_sn=<?php echo $v['order_sn']; ?>&order_id=<?php echo $v['order_id']; ?>" dialog_width="480" dialog_title="<?php echo $lang['store_order_modify_price'];?>" nc_type="dialog"  dialog_id="seller_order_adjust_fee" id="order<?php echo $v['order_id']; ?>_action_adjust_fee" /><?php echo $lang['store_order_modify_price'];?></a>
            <?php } ?>
          </p></td>
        <td class="bdl bdr" rowspan="<?php echo count($val);?>"><p><?php echo $v['state_info']; ?>
            <?php if($val['evaluation_time']) { ?>
            <br/>
            <?php echo $lang['store_order_evaluated'];?>
            <?php } ?>
          </p>
          <?php if($v['order_state']>0 and $v['order_state']<20) { ?>
          <p><a href="javascript:void(0)" style="color:#F30; text-decoration:underline;" nc_type="dialog" uri="index.php?act=store&op=change_state&state_type=store_order_cancel&order_sn=<?php echo $v['order_sn']; ?>&order_id=<?php echo $v['order_id']; ?>" dialog_title="<?php echo $lang['store_order_cancel_order'];?>" dialog_id="seller_order_cancel_order" dialog_width="400" id="order<?php echo $v['order_id']; ?>_action_cancel" /><?php echo $lang['store_order_cancel_order'];?></a></p>
          <?php if($v['payment_id']>0 and $v['order_state']!='predeposit'){?>
          <p><a href="javascript:void(0)" class="ncu-btn6 mt5" nc_type="dialog" dialog_id="seller_order_received_pay" dialog_width="480" uri="index.php?act=store&op=change_state&state_type=store_order_pay&order_sn=<?php echo $v['order_sn']; ?>&order_id=<?php echo $v['order_id']; ?>" dialog_title="<?php echo $lang['store_order_received_price'];?>" id="order<?php echo $v['order_id']; ?>_action_received_pay" /><?php echo $lang['store_order_received_price'];?></a></p>
          <?php }else{?>
          <p><a href="javascript:void(0)" class="ncu-btn6 mt5" uri="index.php?act=store&op=change_state&state_type=store_order_edit_price&order_sn=<?php echo $v['order_sn']; ?>&order_id=<?php echo $v['order_id']; ?>" dialog_width="480" dialog_title="<?php echo $lang['store_order_modify_price'];?>" nc_type="dialog"  dialog_id="seller_order_adjust_fee" id="order<?php echo $v['order_id']; ?>_action_adjust_fee" /><?php echo $lang['store_order_modify_price'];?></a></p>
          <?php } ?>
          <?php }?>
          <?php if ($v['order_state'] == 40 && $v['refund_state']<2 && $v['able_evaluate']) { ?>
          <p><a href="index.php?act=store_evaluate&op=add&order_id=<?php echo $v['order_id']; ?>" class="ncu-btn2 mt5"><?php echo $lang['store_order_want_evaluate'];?></a></p>
          <?php }?>
          <?php if($v['order_state'] == 50) {?>
          <p><a href="javascript:void(0)" class="ncu-btn2 mt5" dialog_id="<?php echo $v['order_sn']; ?>_order_confirm" uri="index.php?act=store&op=change_state&state_type=order_confirm&order_id=<?php echo $v['order_id']; ?>&order_sn=<?php echo $v['order_sn']; ?>" dialog_title="<?php echo $lang['store_order_order_confirm'];?>" width="480" nc_type="dialog"/><?php echo $lang['store_order_order_confirm'];?></a></p>
          <?php }?>
          <?php if (($v['payment_time'] != '' and $v['shipping_time']=='' and $v['order_state']>11 and $v['order_state']<40) or($v['order_state'] == 60)) { ?>
          <?php if ($v['payment_direct'] == '1' or extension_loaded('openssl')){?>
          <?php if($v['order_state']>=20) { ?>
          <p><a class="ncu-btn7 mt5" href="index.php?act=deliver&op=send&order_id=<?php echo $v['order_id']; ?>"/><?php echo $lang['store_order_send'];?></a></p>
          <?php }?>
          <?php }else{?>
          <p><a href="javascript:void(0)"  class="ncu-btn2 mt5" id="order<?php echo $v['order_id']; ?>_action_shipped" onclick="window.open('index.php?act=payment&op=send&order_id=<?php echo $v['order_id']; ?>');"/><?php echo $lang['store_order_send'];?></a></p>
          <?php }?>
          <?php } ?></td>
        <?php }?>
      </tr>
      <?php }?>
      <?php } } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (is_array($output['goods_array']) and !empty($output['goods_array'])) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
  <iframe name="seller_order" style="display:none;"></iframe>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('.checkall_s').click(function(){
        var if_check = $(this).attr('checked');
        $('.checkitem').each(function(){
            if(!this.disabled)
            {
                $(this).attr('checked', if_check);
            }
        });
        $('.checkall_s').attr('checked', if_check);
    });
});
</script> 
