<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="<?php echo $output['display_mode'];?>" nc_type="current_display_mode">
  <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
  <ul class="list_pic">
    <?php foreach($output['goods_list'] as $goods){?>
    <li class="item">
      <dl nctype_goods="<?php echo $goods['goods_id'];?>" nctype_store="<?php echo $goods['store_id'];?>">
        <dt><!-- 活动标志 -->
          <?php if(!empty($goods['group_flag'])){?><em class="promotion">
          <span class="gb" title="<?php echo $lang['brand_index_groupbuy'];?>" style="margin-right:6px;"><?php echo $lang['brand_index_groupbuy'];?></span></em>
          <?php } ?>
          <?php if(!empty($goods['xianshi_flag'])){ ?><em class="promotion">
          <span class="xs" title="<?php echo $lang['brand_index_xianshi'];?>"><?php echo $lang['brand_index_xianshi'];?></span></em>
          <?php } ?>
          <a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods['goods_id']),'goods',$goods['store_domain']);?>" target="_blank" title="<?php echo $goods['goods_name'];?>"><?php echo $goods['goods_name'];?></a></dt>
        <dd class="pic-layout">
          <div class="picture"><span class="thumb"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods['goods_id']),'goods',$goods['store_domain']);?>" target="_blank"><img src="<?php echo thumb($goods,'tiny');?>" onload="javascript:DrawImage(this,60,60);" alt="<?php echo $goods['goods_name'];?>" /></a></span> </div>
        </dd>
        <dd class="shop"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$goods['store_id']),'store');?>" title="<?php echo $goods['store_name'];?>"><?php echo $goods['store_name'];?></a><!--<em class="type"><?php echo $goods['grade_name'];?></em>--></dd>
        <!-- S 促销价格显示 -->
        <?php if(intval($goods['group_flag']) === 1) { ?>
        <!-- 团购 -->
        <dd class="promotion-price" title="<?php echo $lang['currency'];?><?php echo $goods['group_price'];?>"><?php echo $lang['currency'];?><span><?php echo $goods['group_price'];?></span></dd>
        <dd class="del-price" title="<?php echo $lang['currency'];?><?php echo $goods['goods_store_price'];?>"><?php echo $lang['currency'];?><?php echo $goods['goods_store_price'];?></dd>
        <?php } elseif(intval($goods['xianshi_flag']) === 1) { ?>
        <!-- 限时折扣 -->
        <?php $xianshi_price = ncPriceFormat($goods['goods_store_price'] * $goods['xianshi_discount'] / 10);?>
        <dd class="promotion-price" title="<?php echo $lang['currency'];?><?php echo $xianshi_price;?>"><?php echo $lang['currency'];?><span><?php echo $xianshi_price;?></span></dd>
        <dd class="del-price" title="<?php echo $lang['currency'];?><?php echo $lang['currency'];?><?php echo $goods['goods_store_price'];?>"><?php echo $lang['currency'];?><?php echo $goods['goods_store_price'];?></dd>
        <?php } else { ?>
        <dd class="price" title="<?php echo $lang['currency'];?><?php echo $goods['goods_store_price'];?>"><?php echo $lang['currency'];?><span><?php echo $goods['goods_store_price'];?></span></dd>
        <?php } ?>
        <!-- E 促销价格显示 -->
        <dd class="freight" title="<?php echo $lang['currency'];?><?php if(floatval($goods['kd_price']) > 0){echo $goods['kd_price'];}elseif (floatval($goods['py_price']) > 0){echo $goods['py_price'];}else{echo $goods['es_price'];}?>"><?php echo $lang['brand_index_freight'];?> <?php if(floatval($goods['kd_price']) > 0){echo $goods['kd_price'];}elseif (floatval($goods['py_price']) > 0){echo $goods['py_price'];}else{echo $goods['es_price'];}?></dd>
        <dd class="location" title="<?php echo $output['area_array'][$goods['province_id']]['area_name'];?>&nbsp;<?php echo $output['area_array'][$goods['city_id']]['area_name'];?>"><?php echo $output['area_array'][$goods['province_id']]['area_name'];?>&nbsp;<?php echo $output['area_array'][$goods['city_id']]['area_name'];?></dd>
        <dd class="state"><?php echo $lang['brand_index_deal'];?><?php echo $goods['salenum'];?><?php echo $lang['brand_index_jian'];?></dd>
        <dd class="comment"><span><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods['goods_id']),'goods',$goods['store_domian']);?>#ncGoodsRate"><?php echo $lang['brand_index_comment'];?><?php echo $goods['commentnum'];?><?php echo $lang['brand_index_number_of_consult'];?></a></span></dd>
      </dl>
      <ul class="seller-intro">
        <li><span><?php echo $lang['brand_index_description_of'].$lang['nc_colon'];?></span><span><?php echo $goods['store_desccredit'];?><?php echo $lang['credit_unit']?></span></li>
        <li><span><?php echo $lang['brand_index_praise_rate'].$lang['nc_colon'];?></span><span><?php echo $goods['praise_rate']?>%</span></li>
        <li><span><?php echo $lang['brand_index_store_credit'].$lang['nc_colon'];?></span>
          <?php if($goods['store_credit'] == 0){echo $goods['store_credit'];}else{$credit_arr	= getCreditArr($goods['store_credit']);?>
          <span class="seller-<?php echo $credit_arr['grade']; ?> level-<?php echo $credit_arr['songrade']; ?>"></span>
          <?php }?>
        </li>
      </ul>
    </li>
    <?php }?>
    <div class="clear"></div>
  </ul>
  <?php }else{?>
  <div id="no_results"><?php echo $lang['brand_index_no_record'];?></div>
  <?php }?>
</div>
    