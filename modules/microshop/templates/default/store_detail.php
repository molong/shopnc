<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
    //喜欢
    $("[nc_type=microshop_like]").microshop_like({type:'store',count_target:$(".like em")});

    //图片延迟加载
    $(".lazy").microshop_lazyload();
});
</script>
<div class="microshop-store-top">
  <div class="left-box">
    <dl class="store-intro">
      <dt>
        <h2><a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$output['detail']['store_id']));?>" target="_blank"><?php echo $output['detail']['store_name'];?></a></h2>
        <?php if (empty($output['detail']['credit_arr'])){ ?>
        <h4>- <?php echo $lang['microshop_text_no_credit'];?></h4>
        <?php } else {?>
        <span class="seller-<?php echo $output['detail']['credit_arr']['grade']; ?> level-<?php echo $output['detail']['credit_arr']['songrade']; ?>"></span>
        <?php }?>
        <span><?php echo $lang['microshop_text_store_member_name'];?><?php echo $lang['nc_colon'];?><?php echo $output['detail']['member_name'];?></span></dt>
      <dd><span><?php echo $lang['microshop_text_store_area'];?><?php echo $lang['nc_colon'];?><?php echo $output['detail']['area_info'];?></span><span><?php echo $lang['microshop_text_store_zy'];?><?php echo $lang['nc_colon'];?><?php echo $output['detail']['store_zy'];?></span> </dd>
      <dd><span><?php echo $lang['microshop_text_store_favorites'];?><?php echo $lang['nc_colon'];?><em nctype="store_collect"><?php echo $output['detail']['store_collect']?></em><?php echo $lang['nc_person'];?><?php echo $lang['nc_collect'];?></span></dd>
    </dl>
    <div class="handle">
      <ul>
        <li class="goods"><i class="pngFix"></i><?php echo $lang['microshop_text_goods'];?><em><?php echo $output['detail']['goods_count'];?></em></li>
        <li class="like"><i class="pngFix"></i><?php echo $lang['microshop_text_like'];?><em><?php echo $output['detail']['like_count']<=999?$output['detail']['like_count']:'999+';?></em></li>
      </ul>
      <div class="btn">
          <a nc_type="microshop_like" like_id="<?php echo $output['detail']['microshop_store_id'];?>" href="javascript:void(0)" class="like mr5"><i class="pngFix"></i><?php echo $lang['microshop_text_like'].$lang['microshop_text_store'];?></a>
          <a id="btn_sns_share" href="javascript:void(0)" class="share"><i class="pngFix"></i><?php echo $lang['microshop_text_share'];?></a></div>
    </div>
  </div>
  <div class="right-box">
    <div class="arrow pngFix"></div>
    <div class="store-logo">
        <a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$output['detail']['store_id']));?>" target="_blank"> 
            <?php if(empty($output['detail']['store_label'])) { ?>
            <img src="<?php echo $output['detail']['store_logo'];?>" alt="<?php echo $output['detail']['store_name'];?>" />
            <?php } else { ?>
            <img src="<?php echo SiteUrl.DS.ATTACH_STORE.DS.$output['detail']['store_label'];?>" alt="<?php echo $output['detail']['store_name'];?>" />
            <?php } ?>
        </a>
    </div>
    <p><a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$output['detail']['store_id']));?>" target="_blank"><?php echo $lang['microshop_text_enter'].$lang['microshop_text_store'];?><i></i></a></p>
  </div>
</div>
<div class="store-goods-list-content">
  <div class="store-goods-list-box">
    <?php $list_length = count($output['list']); ?>
    <?php for ($j = 0; $j < 4; $j++) { ?>
    <div class="store-goods-list">
      <?php if($j === 3) { ?>
      <div class="store-goods-list-comment">
        <?php require('widget_comment.php');?>
      </div>
      <?php } ?>
      <?php for ($i = $j; $i < $list_length; $i+=4) { ?>
      <div class="store-goods-item">
        <div class="picture"> <a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'goods','goods_id'=>$output['list'][$i]['goods_id']),'goods');?>" target="_blank">
          <?php $image_url = cthumb($output['list'][$i]['goods_image'],'240x240',$output['list'][$i]['store_id']);?>
          <?php list($width, $height, $type, $attr) = getimagesize($image_url);?>
          <?php if($width > 220) {$height = $height*220/$width;$width=220;} ?>
          <img class="lazy" height="<?php echo $height;?>" width="<?php echo $width;?>" src="<?php echo MICROSHOP_TEMPLATES_PATH;?>/images/loading.gif" data-src="<?php echo $image_url;?>" title="<?php echo $output['list'][$i]['goods_name'];?>" alt="<?php echo $output['list'][$i]['goods_name'];?>" /> </a>
          <div class="price"> <?php echo $lang['currency'];?><strong><?php echo ncPriceFormat($output['list'][$i]['goods_store_price']);?></strong></div>
        </div>
        <div class="goods-title"> <a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'goods','goods_id'=>$output['list'][$i]['goods_id']),'goods');?>" target="_blank"> <?php echo $output['list'][$i]['goods_name'];?> </a> </div>
        <div class="goods-salenum"><?php echo $lang['microshop_store_selled'];?><em><?php echo $output['list'][$i]['salenum'];?></em><?php echo $lang['microshop_text_jian'];?></div>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>
<div class="pagination"> <?php echo $output['show_page'];?> </div>
<?php require('widget_sns_share.php');?>
