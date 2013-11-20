<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="<?php echo $output['display_mode'];?>" nc_type="current_display_mode">
  <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
  <ul class="list_pic">
    <?php foreach($output['goods_list'] as $goods){?>
    <li class="item">
      <dl nctype_goods="<?php echo $goods['goods_id'];?>" nctype_store="<?php echo $goods['store_id'];?>">
        <dt><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods['goods_id']),'goods',$goods['store_domain']);?>" target="_blank" title="<?php echo $goods['goods_name'];?>"><?php echo str_cut($goods['goods_name'],40,'...');?></a></dt>
        <dd class="picture"><span class="thumb"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods['goods_id']),'goods',$goods['store_domain']);?>" target="_blank" title="<?php echo $goods['goods_name'];?>"><img src="<?php echo thumb($goods,'small');?>" onload="javascript:DrawImage(this,160,160);" title="<?php echo $goods['goods_name'];?>" alt="<?php echo $goods['goods_name'];?>" /></a></span></dd>
        <dd class="bargain"><?php echo $lang['goods_class_index_deal'];?><?php echo $goods['salenum'];?><?php echo $lang['goods_class_index_jian'];?></dd>
        <!-- S 促销价格显示 -->
        <?php if(intval($goods['group_flag']) === 1) { ?>
        <!-- 团购 -->
        <dd class="promotion-price" title="<?php echo $lang['goods_class_index_promotion_goods_price'].$lang['nc_colon'].$lang['currency'];?><?php echo $goods['group_price'];?>"><?php echo $lang['currency'];?><span><?php echo $goods['group_price'];?></span></dd>
        <dd class="del-price" title="<?php echo $lang['goods_class_index_normal_goods_price'].$lang['nc_colon'].$lang['currency'];?><?php echo $goods['goods_store_price'];?>"><?php echo $goods['goods_store_price'];?></dd>
        <?php } elseif(intval($goods['xianshi_flag']) === 1) { ?>
        <!-- 限时折扣 -->
        <?php $xianshi_price = ncPriceFormat($goods['goods_store_price'] * $goods['xianshi_discount'] / 10);?>
        <dd class="promotion-price" title="<?php echo $lang['goods_class_index_promotion_goods_price'].$lang['nc_colon'].$lang['currency'];?><?php echo $xianshi_price;?>"><?php echo $lang['currency'];?><span><?php echo $xianshi_price;?></span></dd>
        <dd class="del-price" title="<?php echo $lang['goods_class_index_normal_goods_price'].$lang['nc_colon'].$lang['currency'];?><?php echo $goods['goods_store_price'];?>"><?php echo $goods['goods_store_price'];?></dd>
        <?php } else { ?>
        <dd class="price" title="<?php echo $lang['goods_class_index_store_goods_price'].$lang['nc_colon'].$lang['currency'];?><?php echo $goods['goods_store_price'];?>"><?php echo $lang['currency'];?><span><?php echo $goods['goods_store_price'];?></span></dd>
        <?php } ?>
        <!-- E 促销价格显示 -->
        <dd class="shop"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$goods['store_id']),'store');?>" title="<?php echo $goods['store_name'];?>"><?php echo $goods['store_name'];?></a></dd>
        <dd class="freight" title="<?php echo $lang['goods_class_index_freight'].$lang['nc_colon'].$lang['currency'];?><?php if(floatval($goods['kd_price']) > 0){echo $goods['kd_price'];}elseif (floatval($goods['py_price']) > 0){echo $goods['py_price'];}else{echo $goods['es_price'];}?>"><?php echo $lang['goods_class_index_freight'];?> <?php if(floatval($goods['kd_price']) > 0){echo $goods['kd_price'];}elseif (floatval($goods['py_price']) > 0){echo $goods['py_price'];}else{echo $goods['es_price'];}?></dd>
        <dd class="location" title="<?php echo $output['area_array'][$goods['province_id']]['area_name'];?>&nbsp;<?php echo $output['area_array'][$goods['city_id']]['area_name'];?>"><?php echo $output['area_array'][$goods['province_id']]['area_name'];?>&nbsp;<?php echo $output['area_array'][$goods['city_id']]['area_name'];?></dd>
        <dd class="seller-intro">
          <ul>
            <li><span><?php echo $lang['goods_class_index_goods_evaluate'].$lang['nc_colon'];?></span><span><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods['goods_id']),'goods',$goods['store_domian']);?>#ncGoodsRate"><?php echo $lang['goods_class_index_comment'];?><?php echo $goods['commentnum'];?><?php echo $lang['goods_class_index_number_of_consult'];?></a></span></li>
            <li><span><?php echo $lang['goods_class_index_praise_rate'].$lang['nc_colon'];?></span><span><?php echo $goods['praise_rate']?>%</span></li>
            <li><span><?php echo $lang['goods_class_index_store_credit'].$lang['nc_colon'];?></span>
              <?php if($goods['store_credit'] == 0){echo $goods['store_credit'];}else{$credit_arr	= getCreditArr($goods['store_credit']);?>
              <span class="seller-<?php echo $credit_arr['grade']; ?> level-<?php echo $credit_arr['songrade']; ?>"></span>
              <?php }?>
            </li>
            <li><span><?php echo $lang['goods_class_index_description_of'].$lang['nc_colon'];?></span><span><?php echo $goods['store_desccredit'];?><?php echo $lang['credit_unit']?></span></li>
          </ul>
        </dd>
        <dd class="promotion"><!-- 活动标志 -->
          <?php if(!empty($goods['group_flag'])){?>
          <span class="gb mr5" title="<?php echo $lang['goods_class_index_groupbuy'];?>"><?php echo $lang['goods_class_index_groupbuy'];?></span>
          <?php } ?>
          <?php if(!empty($goods['xianshi_flag'])){ ?>
          <span class="xs" title="<?php echo $lang['goods_class_index_xianshi'];?>"><?php echo $lang['goods_class_index_xianshi'];?></span>
          <?php } ?>
        </dd>
      </dl>
    </li>
    <?php }?>
    <div class="clear"></div>
  </ul>
  <?php }else{?>
  <div id="no_results"><?php echo $lang['goods_class_index_no_record'];?></div>
  <?php }?>
</div>