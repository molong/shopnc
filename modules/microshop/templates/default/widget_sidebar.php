<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="title mt10">
  <h3><?php echo $lang['microshop_text_new'].$lang['nc_microshop_goods'].$lang['microshop_text_commend'];?></h3>
  <span><a href="<?php echo MICROSHOP_SITEURL.DS?>index.php?act=home&op=goods&member_id=<?php echo $output['detail']['commend_member_id'];?>"><?php echo $lang['nc_common_more'];?></a></span> </div>
<div class="sidebar-style01">
  <?php if(!empty($output['sidebar_goods_list']) && is_array($output['sidebar_goods_list'])) {?>
  <ul>
    <?php foreach($output['sidebar_goods_list'] as $key=>$value) {?>
    <li>
      <div class="picture"><span class="thumb size60"><i></i><a href="<?php echo MICROSHOP_SITEURL;?>/index.php?act=goods&op=detail&goods_id=<?php echo $value['commend_id'];?>" target="_blank" titel="<?php echo $value['commend_goods_name'];?>">
        <?php $image_url = cthumb($value['commend_goods_image'],'tiny',$value['commend_goods_store_id']);?>
        <img src="<?php echo $image_url;?>" title="<?php echo $value['commend_goods_name'];?>" alt="<?php echo $value['commend_goods_name'];?>" /> </a></span> </div>
      <div class="price"> <?php echo $lang['currency'];?><strong><?php echo ncPriceFormat($value['commend_goods_price']);?></strong></div>
    </li>
    <?php } ?>
  </ul>
  <?php } else { ?>
  <div class="no-content"><?php echo $lang['microshop_goods_none'];?></div>
  <?php } ?>
</div>
<div class="title mt50">
  <h3><?php echo $lang['microshop_text_new'].$lang['nc_microshop_personal'].$lang['microshop_text_commend'];?></h3>
  <span><a href="<?php echo MICROSHOP_SITEURL.DS?>index.php?act=home&op=personal&member_id=<?php echo $output['detail']['commend_member_id'];?>"><?php echo $lang['nc_common_more'];?></a></span> </div>
<div class="sidebar-style02">
  <?php if(!empty($output['sidebar_personal_list']) && is_array($output['sidebar_personal_list'])) {?>
  <ul id="pinterest">
    <?php foreach($output['sidebar_personal_list'] as $key=>$value) {?>
    <li class="show">
      <div class="picture"> <a href="<?php echo MICROSHOP_SITEURL;?>/index.php?act=personal&op=detail&personal_id=<?php echo $value['personal_id'];?>" target="_blank">
        <?php $personal_image_array = getPersonalImageUrl($value,'tiny');?>
        <?php list($width, $height, $type, $attr) = getimagesize($personal_image_array[0]);?>
        <?php $height = $height*60/$width;$width=60; ?>
        <img height="<?php echo $height;?>" width="<?php echo $width;?>" src="<?php echo $personal_image_array[0];?>" /> </a> </div>
      <div class="add-time"><?php echo date('Y-m-d',$value['commend_time']);?></div>
    </li>
    <?php } ?>
  </ul>
  <?php } else { ?>
  <div class="no-content"><?php echo $lang['microshop_personal_none'];?></div>
  <?php } ?>
</div>
