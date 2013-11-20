<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="get" action="index.php" target="_self">
    <table class="search-form">
      <input type="hidden" name="act" value="deliver" />
      <input type="hidden" name="op" value="search_deliver" />
      <?php if (trim($_GET['state_type'])!='') { ?>
      <input type="hidden" name="state_type" value="<?php echo trim($_GET['state_type']); ?>" />
      <?php } ?>
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?></th>
        <td class="w150"><input type="text" class="text" name="order_sn" value="<?php echo trim($_GET['order_sn']); ?>"  placeholder="<?php echo $lang['store_order_order_sn_search']; ?>" /></td>
        <td class="w90 tc"><input type="submit"  class="submit"value="<?php echo $lang['store_order_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <?php if (is_array($output['goods_array']) and !empty($output['goods_array'])) { ?>
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
  <?php } ?>
  <table class="ncu-table-style order deliver">
    <?php if (is_array($output['order_array']) and !empty($output['order_array'])) { ?>
    <?php foreach($output['order_array'] as $key=>$val) { ?>
    <tbody>
      <tr>
        <td colspan="20" class="sep-row"></td>
      </tr>
      <tr>
        <th colspan="20"><a href="index.php?act=member_orderprint&order_id=<?php echo $val['order_id'];?>" target="_blank" class="fr" title="<?php echo $lang['store_show_order_printorder'];?>"/><i class="print-order"></i></a><span class="fr mr30"></span><span class="ml5"><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?><span class="goods-num"><?php echo $val['order_sn']; ?></span> <span class="ml20"><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?><em class="goods-time"><?php echo date("Y-m-d H:i:s",$val['add_time']); ?></em></span> <span class="ml20">
          <?php if ($val['shipping_express_id']>0){?>
          <a href='index.php?act=deliver&op=search_deliver&order_sn=<?php echo $val['order_sn']; ?>' class="nc-show-deliver"><i></i><?php echo $lang['store_order_show_deliver'];?></a>
          <?php }?>
          </span></th>
      </tr>
      <?php foreach((array)$val['goods'] as $k=>$v) { ?>
      <tr>
        <td class="bdl w10"></td>
        <td class="w70"><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="?act=goods&goods_id=<?php echo $v['goods_id'];?>&id=<?php echo $val['store_id'];?>" target="_blank"><img src="<?php echo cthumb($v['goods_image'],'tiny',$val['store_id']); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td class="tl goods-info"><dl>
            <dt><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $v['goods_id']; ?>"><?php echo $v['goods_name']; ?></a></dt>
            <dd><?php echo str_replace(':', $lang['nc_colon'], $v['spec_info']); ?></dd>
            <dd class="tr"><?php echo $v['goods_price']; ?>&nbsp;x&nbsp;<?php echo $v['goods_num']; ?></dd>
          </dl></td>
        <?php if ((count($val['goods']) > 1 && $k ==0) || (count($val['goods']) == 1)){?>
        <td class="bdl bdr order-info w400" rowspan="<?php echo count($val['goods']);?>"><dl>
            <dt><?php echo $lang['store_deliver_buyer_name'].$lang['nc_colon'];?></dt>
            <dd class="vm"><?php echo $val['buyer_name']; ?> <a target="_blank" class="message" href="index.php?act=home&op=sendmsg&member_id=<?php echo $val['buyer_id'];?>" title="<?php echo $lang['nc_member_path_sendmsg']?>"></a>
              <?php if(!empty($output['member_array'][$val['buyer_id']]['member_qq'])){?>
              <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['member_array'][$val['buyer_id']]['member_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $output['member_array'][$val['buyer_id']]['member_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['member_array'][$val['buyer_id']]['member_qq'];?>:52" style=" vertical-align: middle;"/></a>
              <?php }?>
              <?php if(!empty($output['member_array'][$val['buyer_id']]['member_ww'])){?>
              <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $output['member_array'][$val['buyer_id']]['member_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['member_array'][$val['buyer_id']]['member_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang" style=" vertical-align: middle;"/></a>
              <?php }?>
            </dd>
          </dl>
          <dl>
            <dt><?php echo $lang['store_deliver_buyer_address'].$lang['nc_colon'];?></dt>
            <dd class="ts"><span><?php echo $val['area_info'];?><?php echo $val['address'].$lang['nc_comma'];?></span><span class="ml5"><?php echo $val['zip_code'].$lang['nc_comma'];?></span><span class="ml5"><?php echo $val['true_name'].$lang['nc_comma'];?></span><span class="ml10"><?php echo $val['tel_phone'];?></span><span class="ml10"><?php echo $val['mob_phone'];?></span></dd>
          </dl>
          <dl>
            <dt><?php echo $lang['store_deliver_shipping_sel'].$lang['nc_colon'];?></dt>
            <dd>
              <?php if (!empty($val['shipping_fee']) && $val['shipping_fee'] != '0.00'){?>
              <?php echo $val['shipping_name'];?> (<?php echo $val['shipping_fee'];?>)
              <?php }else{?>
              <?php echo $lang['nc_common_shipping_free'];?>
              <?php }?>
            </dd>
          </dl>
          <dl>
            <?php if ($val['shipping_express_name'] != '') {?>
            <dt><?php echo $lang['store_deliver_express_title'].$lang['nc_colon'];?></dt>
            <dd><?php echo $val['shipping_express_name'];?></dd>
            <?php }?>
            <?php if ($val['order_state'] == 20) {?>
            <dt>&nbsp;</dt>
            <dd><a href="index.php?act=deliver&op=send&order_id=<?php echo $val['order_id'];?>" class="ncu-btn6 mr10 fr"><?php echo $lang['store_order_send'];?></a></dd>
            <?php }elseif ($val['order_state'] == 30){?>
            <dt>&nbsp;</dt>
            <dd><a href="index.php?act=deliver&op=send&order_id=<?php echo $val['order_id'];?>" class="ncu-btn2 mr10 fr"><?php echo $lang['store_deliver_modify_info'];?></a></dd>
            <?php }?>
          </dl></td>
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
      <?php if (is_array($output['order_array']) and !empty($output['order_array'])) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
