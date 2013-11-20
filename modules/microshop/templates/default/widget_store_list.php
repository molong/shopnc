<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['list']) && is_array($output['list'])) {?>
<script type="text/javascript">
$(document).ready(function(){
    $("[nc_type=microshop_like]").microshop_like({type:'store'});
});
</script>
<?php foreach($output['list'] as $key=>$value) {?>

<div class="microshop-store-list">
  <?php if($output['owner_flag'] === TRUE){ ?>
  <?php if($_GET['op'] == 'like_list') { ?>
  <!-- 喜欢删除按钮 -->
  <div class="del"><a nc_type="like_drop" like_id="<?php echo $value['like_id'];?>" href="javascript:void(0)" title="<?php echo $lang['nc_delete'];?>">&nbsp;</a></div>
  <?php } ?>
  <?php } ?>
  <div class="top"><span class="goods-count"><strong><?php echo $value['goods_count'];?></strong><?php echo $lang['microshop_text_jian'].$lang['microshop_text_goods'];?></span>
    <h2><a href="<?php echo MICROSHOP_SITEURL.'/index.php?act=store&op=detail&store_id='.$value['microshop_store_id'];?>"><?php echo $value['store_name'];?></a></h2>
    <?php if (empty($value['credit_arr'])){ ?>
    <h4>- <?php echo $lang['microshop_text_no_credit'];?></h4>
    <?php } else {?>
    <span class="seller-<?php echo $value['credit_arr']['grade']; ?> level-<?php echo $value['credit_arr']['songrade']; ?>"></span>
    <?php }?>
  </div>
  <div style="zoom:1;">
    <div class="microshop-store-info">
      <dl>
        <dt><?php echo $lang['microshop_text_store_member_name'];?><?php echo $lang['nc_colon'];?></dt>
        <dd><?php echo $value['member_name'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['microshop_text_store_area'];?><?php echo $lang['nc_colon'];?></dt>
        <dd><?php echo $value['area_info'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['microshop_text_store_zy'];?><?php echo $lang['nc_colon'];?></dt>
        <dd><?php echo $value['store_zy'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['microshop_text_store_favorites'];?><?php echo $lang['nc_colon'];?></dt>
        <dd><strong nctype="store_collect"><?php echo $value['store_collect']?></strong><?php echo $lang['nc_person'];?><?php echo $lang['nc_collect'];?></dd>
      </dl>
      <div class="handle"><span class="like-btn"><a nc_type="microshop_like" like_id="<?php echo $value['microshop_store_id'];?>" href="javascript:void(0)"><i class="pngFix"></i><span><?php echo $lang['microshop_text_like'];?></span><em><?php echo $value['like_count']<=999?$value['like_count']:'999+';?></em></a></span> <span class="comment"><a href="<?php echo MICROSHOP_SITEURL.'/index.php?act=store&op=detail&store_id='.$value['microshop_store_id'];?>"><i class="pngFix" title="<?php echo $lang['microshop_text_comment'];?>">&nbsp;</i><em><?php echo $value['comment_count']<=999?$value['comment_count']:'999+';?></em></a></span> </div>
    </div>
    <?php if(!empty($value['search_list_goods']) && is_array($value['search_list_goods'])) { ?>
    <div class="microshop-store-info-image">
      <ul>
        <?php $i = 1;?>
        <?php foreach($value['search_list_goods'] as $k=>$v){?>
        <li style="background-image: url(<?php echo thumb($v,'small');?>)" title="<?php echo $v['goods_name'];?>"><a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']),'goods');?>" target="_blank">&nbsp;</a> <em><?php echo $v['goods_store_price'];?></em> </li>
        <?php if($i >=5) break; ?>
        <?php $i++; ?>
        <?php }?>
      </ul>
    </div>
    <?php } else {?>
    <div class="no-content">
        <p><?php echo $lang['microshop_store_commend_goods_none'];?></p>
    </div>
    <?php }?>
</div>
</div>
<?php } ?>
<div class="pagination"> <?php echo $output['show_page'];?> </div>
<?php } else { ?>
<?php if($_GET['op'] == 'like_list') { ?>
<div class="no-content">
<i class="store">&nbsp;</i>
<?php if($output['owner_flag'] === TRUE) { ?>
<p><?php echo $lang['microshop_store_like_list_none_owner'];?></p>
<?php } else { ?>
<p><?php echo $lang['nc_quote1'];?><?php echo $output['member_info']['member_name'];?><?php echo $lang['nc_quote2'];?><?php echo $lang['microshop_store_like_list_none'];?></p>
<?php } ?>
<?php } else { ?>
<div class="no-content">
<i class="store">&nbsp;</i>
<p><?php echo $lang['microshop_store_list_none'];?></p>
<?php } ?>
<?php } ?>
