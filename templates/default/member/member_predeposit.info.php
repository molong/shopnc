<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <dl>
      <dt><?php echo $lang['predeposit_rechargesn'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_sn']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_payment'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['payment_info']['payment_name']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_recharge_price'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_price']; ?><?php echo $lang['currency_zh']; ?></dd>
    </dl>
    <?php if ($output['info']['pdr_payment'] == 'offline'){?>
    <dl>
      <dt><?php echo $lang['predeposit_recharge_huikuanname'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_remittancename']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_recharge_huikuanbank'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_remittancebank']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_recharge_huikuandate'].$lang['nc_colon'];?></dt>
      <dd><?php echo @date('Y-m-d',$output['info']['pdr_remittancedate']); ?></dd>
    </dl>
    <?php }?>
    <dl>
      <dt><?php echo $lang['predeposit_addtime'].$lang['nc_colon'];?></dt>
      <dd><?php echo @date('Y-m-d',$output['info']['pdr_addtime']); ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_memberremark'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['pdr_memberremark']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['predeposit_paystate'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['rechargepaystate'][$output['info']['pdr_paystate']]; ?></dd>
    </dl>
    <dl class="sumbit">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit"  class="submit" value="<?php echo $lang['predeposit_backlist'];?>" onclick="window.location='<?php echo $_SERVER['HTTP_REFERER'];?>'"/>
      </dd>
    </dl>
  </div>
</div>
