<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="nc-s-c-s1 ncs-message-bar">
  <div class="title">
    <h4><?php echo $lang['nc_message_center'];?></h4>
  </div>
  <div class="content">
    <?php if(!empty($output['store_info']['store_presales'])){?>
    <dl>
      <dt><?php echo $lang['nc_message_presales'];?></dt>
      <?php foreach($output['store_info']['store_presales'] as $val){?>
      <dd><span><?php echo $val['name']?></span><span><?php if($val['type'] == 1){?>
      <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $val['num'];?>&amp;Site=<?php echo $val['num'];?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:<?php echo $val['num'];?>:41" alt="<?php echo $lang['nc_message_me'];?>"></a>
      <?php }elseif($val['type'] == 2){?>
      <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $val['num'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $val['num'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>"/></a>
      <?php }?>
      </span></dd>
      <?php }?>
    </dl>
    <?php }?>
    <?php if(!empty($output['store_info']['store_aftersales'])){?>
    <dl>
      <dt><?php echo $lang['nc_message_service'];?></dt>
      <?php foreach($output['store_info']['store_aftersales'] as $val){?>
      <dd><span><?php echo $val['name']?></span><span><?php if($val['type'] == 1){?>
      <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $val['num'];?>&amp;Site=<?php echo $val['num'];?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:<?php echo $val['num'];?>:41" alt="<?php echo $lang['nc_message_me'];?>"></a>
      <?php }elseif($val['type'] == 2){?>
      <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $val['num'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $val['num'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>"/></a>
      <?php }?>
      </span></dd>
      <?php }?>
    </dl>
    <?php }?>
    <?php if($output['store_info']['store_workingtime'] !=''){?>
    <dl>
      <dt><?php echo $lang['nc_message_working'];?></dt>
      <dd><p><?php echo html_entity_decode($output['store_info']['store_workingtime']);?></p></dd>
    </dl>
    <?php }?>
  </div>
</div>