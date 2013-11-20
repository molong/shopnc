<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="open-store">
    <h1><?php echo $lang['welcome_to_site'];?><?php echo $GLOBALS['setting_config']['site_name']; ?><?php echo $lang['nc_seller'];?></h1>
    <h3><?php echo $lang['store_not_seller'].$lang['nc_colon'];?></h3>
    <div><em></em>
      <dl>
        <dt><a href="index.php?act=member_store&op=create"><?php echo $lang['store_apply'];?>&nbsp;&#8250;</a></dt>
        <dd><?php echo $lang['store_apply_info'];?></dd>
      </dl>
    </div>
  </div>
</div>
