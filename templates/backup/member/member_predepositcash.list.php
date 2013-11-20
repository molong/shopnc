<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="get" action="index.php">
    <table class="search-form">
      <input type="hidden" name="act" value="predeposit" />
      <input type="hidden" name="op" value="cashlist" />
      <tr>
        <th><?php echo $lang['predeposit_payment'].$lang['nc_colon']; ?></th>
        <td><select name="payment_search" id="payment_search">
            <option value=""><?php echo $lang['nc_please_choose'];?></option>
            <?php if (is_array($output['payment_array']) && count($output['payment_array'])>0){?>
            <?php foreach ($output['payment_array'] as $k=>$v){?>
            <option value="<?php echo $k;?>" <?php if($_GET['payment_search'] == $k) { ?>selected="selected"<?php } ?> title="<?php echo $v['payment_info'];?>"><?php echo $v['payment_name'];?></option>
            <?php }?>
            <?php }?>
          </select></td>
        <th><?php echo $lang['predeposit_paystate'].$lang['nc_colon']; ?></th>
        <td><select id="paystate_search" name="paystate_search">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php if (is_array($output['cashpaystate']) && count($output['cashpaystate'])>0){?>
            <?php foreach ($output['cashpaystate'] as $k=>$v){?>
            <option value="<?php echo $k+1; ?>" <?php if($_GET['paystate_search'] == $k+1 ) { ?>selected="selected"<?php } ?>><?php echo $v;?></option>
            <?php }?>
            <?php }?>
          </select></td>
        <th><?php echo $lang['predeposit_cashsn'].$lang['nc_colon'];?></th>
        <td><input type="text" class="text" name="sn_search" value="<?php echo $_GET['sn_search'];?>"/></td>
        <td><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th><?php echo $lang['predeposit_cashsn']; ?></th>
        <th class="w150"><?php echo $lang['predeposit_addtime']; ?></th>
        <th class="w100"><?php echo $lang['predeposit_payment']; ?></th>
        <th class="w90"><?php echo $lang['predeposit_cash_price']; ?>(<?php echo $lang['currency_zh']; ?>)</th>
        <th class="w90"><?php echo $lang['predeposit_paystate']; ?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php  if (count($output['cash_list'])>0) { ?>
      <?php foreach($output['cash_list'] as $val) { ?>
      <tr class="bd-line">
        <td class="goods-num"><?php echo $val['pdcash_sn'];?></td>
        <td class="goods-time"><?php echo @date('Y-m-d',$val['pdcash_addtime']);?></td>
        <td><?php echo $output['payment_array'][$val['pdcash_payment']]['payment_name'];?></td>
        <td class="goods-price"><?php echo $val['pdcash_price'];?></td>
        <td><?php echo $output['cashpaystate'][$val['pdcash_paystate']]; ?></td>
        <td><p><a href="index.php?act=predeposit&op=cashinfo&id=<?php echo $val['pdcash_id']; ?>"><?php echo $lang['nc_view']; ?></a></p>
          <?php if ($val['pdcash_paystate'] == 0){?>
          <p><a href="javascript:drop_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=predeposit&op=cashdel&id=<?php echo $val['pdcash_id']; ?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p>
          <?php }?></td>
      </tr>
      <?php } ?>
      <?php } else {?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['cash_list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
