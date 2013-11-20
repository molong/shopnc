<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap-shadow">
  <div class="wrap-all ncu-order-view">
    <?php 
    include template('member/complain_order.info');
    include template('member/complain_complain.info');
    if($output['complain_info']['member_status'] === 'accused') {
        include template('member/complain_appeal.submit');
    }
?>
  </div>
</div>
