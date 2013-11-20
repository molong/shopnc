<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <dl>
      <dt><?php echo $lang['predeposit_cashsn'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['info']['pdcash_sn']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_payment'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['payment_info']['payment_name']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_cash_price'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['info']['pdcash_price']; ?><?php echo $lang['currency_zh']; ?></dd>
    </dl>
    <?php if ($output['info']['pdcash_payment'] == 'offline'){?>
    <dl>
      <dt><?php echo $lang['predeposit_cash_shoukuanname'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdcash_toname']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_cash_shoukuanbank'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['info']['pdcash_tobank']; ?></dd>
    </dl>
    <?php }?>
    <dl>
      <dt><?php echo $lang['predeposit_cash_shoukuanaccount'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdcash_paymentaccount']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_addtime'].$lang['nc_colon'];?></dt>
      <dd><?php echo @date('Y-m-d',$output['info']['pdcash_addtime']); ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_memberremark'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdcash_memberremark']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_paystate'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['cashpaystate'][$output['info']['pdcash_paystate']]; ?></dd>
    </dl>
    <?php if ($output['info']['pdcash_remark'] != ''){?>
    <dl>
      <dt><?php echo $lang['predeposit_adminremark'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['info']['pdcash_remark']; ?></dd>
    </dl>
    <?php }?>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['predeposit_backlist']; ?>" onclick="window.location='index.php?act=predeposit&op=cashlist'"/>
      </dd>
    </dl>
  </div>
</div>
