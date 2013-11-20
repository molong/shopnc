<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo TEMPLATES_PATH;?>/css/home_point.css" rel="stylesheet" type="text/css">
<link href="<?php echo TEMPLATES_PATH;?>/css/home_login.css" rel="stylesheet" type="text/css">
<div class="nc-layout-all">
  <div class="nc-layout-left">
    <div class="nc-user-info" style="background: #DEE6D8;">
      <?php if($_SESSION['is_login'] == '1'){?>
      <dl>
        <dt class="user-pic"><span class="thumb size60"><i></i><img src="<?php if ($output['member_info']['member_avatar']!='') { echo ATTACH_AVATAR.DS.$output['member_info']['member_avatar']; } else { echo ATTACH_COMMON.DS.C('default_user_portrait'); } ?>" onload="javascript:DrawImage(this,60,60);"/></span></dt>
        <dd class="user-name"><?php echo $lang['pointprod_list_hello_tip1']; ?><?php echo $_SESSION['member_name'];?></dd>
        <dd class="user-pointprod"><?php echo $lang['pointprod_list_hello_tip2']; ?><strong><?php echo $output['member_info']['member_points']; ?></strong>&nbsp;<?php echo $lang['points_unit']; ?></dd>
        <dd class="user-pointprod-log"><a href="index.php?act=member_points" target="_blank"><?php echo $lang['pointprod_pointslog'];?></a></dd>
      </dl>
      <ul>
        <li><?php echo $lang['pointprod_list_hello_tip3']; ?>&nbsp;<a href="index.php?act=pointcart"><strong><?php echo $output['pcartnum']; ?></strong></a>&nbsp;<?php echo $lang['pointprod_pointprod_unit']; ?></li>
      </ul>
      <?php } else { ?>
      <dl>
      	<dt class="user-pic"><span class="thumb size60"><i></i><img src="<?php echo ATTACH_COMMON.DS.C('default_user_portrait'); ?>" onload="javascript:DrawImage(this,60,60);"/></span></dt>
        <dd class="user-login"><?php echo $lang['pointprod_list_hello_tip5']; ?></dd>
        <dd class="user-login-btn"><a href="javascript:login_dialog();"><?php echo $lang['pointprod_list_hello_login']; ?></a></dd>
      </dl>
      <ul>
        <li><a href="<?php echo SiteUrl.DS.'index.php?act=article&article_id=41'?>" target="_blank"><?php echo $lang['pointprod_list_hello_pointrule']; ?></a></li>
        <li><a href="<?php echo SiteUrl.DS.'index.php?act=article&article_id=42'?>" target="_blank"><?php echo $lang['pointprod_list_hello_pointexrule']; ?></a></li>
      </ul>
      <?php }?>
    </div>
    <div class="nc-exchange-info">
      <dl>
        <dt>
          <h3><?php echo $lang['pointprod_ad_text1'];?></h3>
          <span><?php echo $lang['pointprod_ad_text2'];?></span></dt>
        <dd>
          <h4><?php echo $lang['pointprod_list_top3']; ?></h4>
          <ul>
            <?php if (is_array($output['converlist']) && count($output['converlist'])){?>
            <?php foreach ($output['converlist'] as $v){?>
            <li>
              <dl class="nc-exchange-gift">
                <dt class="gift-name"><a href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$v['pgoods_id']?>" target="_blank"><?php echo $v['pgoods_name']; ?></a></dt>
                <dd class="gift-pic"><i></i><a href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$v['pgoods_id']?>" target="_blank"><img src="<?php echo $v['pgoods_image'] ?>" onload="javascript:DrawImage(this,160,160);" title="<?php echo $v['pgoods_name']; ?>" alt="<?php echo $v['pgoods_name']; ?>"></a></dd>
                <dd class="gift-price"><?php echo $lang['pointprod_goodsprice'].$lang['nc_colon']; ?><em><?php echo $lang['currency'].$v['pgoods_price']; ?></em></dd>
                <dd class="gift-pointpord"><?php echo $lang['pointprod_exchange_point'].$lang['nc_colon']; ?><span><?php echo $v['pgoods_points']; ?></span><?php echo $lang['points_unit']; ?></dd>
              </dl>
            </li>
            <?php } ?>
            <?php }?>
          </ul>
        </dd>
      </dl>
    </div>
  </div>
  <div class="nc-layout-right">
    <div class="nc-exchange-list">
      <div class="title">
        <h3><?php echo $lang['pointprod_list_allprod'];?></h3>
      </div>
      <div id="div_lazyload"  class="nc-layout-right">
      <textarea  class="text-lazyload" style="display: none;">
        <?php if (is_array($output['pointprod_list']) && count($output['pointprod_list'])){?>
      <ul>
        <?php foreach ($output['pointprod_list'] as $v){?>
        <li class="item">
          <dl class="nc-exchange-gift">
            <dt class="gift-name"><a href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$v['pgoods_id']?>" ><?php echo $v['pgoods_name']; ?></a></dt>
            <dd class="gift-pic"><i></i><a href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$v['pgoods_id']?>"  > <img src="<?php echo $v['pgoods_image'] ?>" onerror="this.src='<?php echo defaultGoodsImage('small');?>'" onload="javascript:DrawImage(this,128,128);" title="<?php echo $v['pgoods_name']; ?>" alt="<?php echo $v['pgoods_name']; ?>"></a></dd>
            <dd class="gift-price"><?php echo $lang['pointprod_goodsprice'].$lang['nc_colon']; ?><span><?php echo $lang['currency'].$v['pgoods_price']; ?></span></dd>
            <dd class="gift-pointpord"><?php echo $lang['pointprod_pointsname'].$lang['nc_colon'];?><?php echo $v['pgoods_points']; ?><?php echo $lang['points_unit']; ?></dd>
          </dl>
        </li>
        <?php } ?>
      </ul>
      <?php }else{?>
      <div class="norecord"><?php echo $lang['pointprod_list_null'];?></div>
      <?php }?>
      </textarea>
      </div>
    </div>
  </div>
</div>
</div>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.datalazyload.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/home.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	//列表延时加载
    $('#div_lazyload').datalazyload({dataItem: '.item', loadType: 'item', effect: 'fadeIn', effectTime: 1000 });
});
</script>