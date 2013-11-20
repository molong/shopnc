<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('store/header');?>
<div class="background clearfix">
  <?php include template('store/top');?>
  <article id="content">
    <section class="nc-detail">
      <header class="nc-detail-hd clearfix">
        <h3> <?php echo $output['goods']['goods_name']; ?></h3>
        <?php if(!$output['store_self']) { ?>
        <div class="nc-inform"><span><a href="javascript:void(0)" title="<?php echo $lang['goods_index_inform'];?>"><?php echo $lang['goods_index_inform'];?><i></i></a></span>
          <ul>
            <li><a href="index.php?act=member_inform&op=inform_submit&goods_id=<?php echo $output['goods']['goods_id'];?>" title="<?php echo $lang['goods_index_goods_inform'];?>"><?php echo $lang['goods_index_goods_inform'];?></a></li>
          </ul>
        </div>
        <?php } ?>
      </header>
      <div class="nc-detail-bd"> 
        <!-- S 商品图片及收藏分享 -->
        <aside class="nc-gallery">
          <div class="zoom-section"> 
            <!-- S 默认图片触及显示放大镜效果 -->
            <div class="zoom-small-image"><span class="thumb size310"><a href="<?php echo cthumb($output['goods_image'],'max',$output['goods']['store_id']);?>" class = "nc-zoom" id="zoom1" rel="position: 'inside' , showTitle: false"><img src="<?php echo cthumb($output['goods_image'],'mid',$output['goods']['store_id']);?>" alt="" title=""></a></span></div>
            <!-- S 默认图片触及显示放大镜效果 --> 
            <!-- S 关联默认图片的缩略图 -->
            <nav class="zoom-desc">
              <ul>
                <?php if(is_array($output['desc_image']) && !empty($output['desc_image'])){?>
                <?php foreach($output['desc_image'] as $key=>$val){?>
                <?php if($key<1 || !empty($val)){?>
                <!-- S 第一个后其它的有图片时显示 -->
                <li><a href="<?php echo cthumb($val,'max',$output['goods']['store_id']);?>" class="nc-zoom-gallery <?php if($key=='0'){?>hovered<?php }?>" title="" rel="useZoom: 'zoom1', smallImage: '<?php echo cthumb($val,'mid',$output['goods']['store_id']);?>' "> <span class="thumb size40"> <i></i> <img src="<?php echo cthumb($val,'tiny',$output['goods']['store_id']);?>" alt="" onload="javascript:DrawImage(this,40,40);"> </span><b></b> </a></li>
                <?php }?>
                <?php }?>
                <?php }?>
              </ul>
            </nav>
            <!-- E 关联默认图片的缩略图 --> 
          </div>
          <!-- S 收藏与分享 -->
          <div class="ncs_share">
            <div class="ncs-goods-handle fl" >
              <div class="handle-left"><i class="snslike-goods"></i><a href="javascript:void(0);" data-param='{"gid":"<?php echo $output['goods']['goods_id'];?>"}' nc_type="likebtn"><?php echo $lang['goods_index_snslike_goods'];?></a><em nc_type="likecount_<?php echo $output['goods']['goods_id'];?>"><?php echo intval($output['goods']['likenum'])>0?intval($output['goods']['likenum']):0;?></em></div>
              <div class="handle-right" id="handle-l"><span></span>
                <ul >
                  <li class="tab"><span></span></li>
                  <li><i class="snsshare-goods"></i><a href="javascript:void(0);" nc_type="sharegoods" data-param='{"gid":"<?php echo $output['goods']['goods_id'];?>"}'><?php echo $lang['goods_index_snsshare_goods'];?><em nc_type="sharecount_<?php echo $output['goods']['goods_id'];?>"><?php echo intval($output['goods']['sharenum'])>0?intval($output['goods']['sharenum']):0;?></em></a></li>
                </ul>
              </div>
            </div>
            <div class="ncs-goods-handle fl ml10">
              <div class="handle-left"><i class="share-goods"></i><a href="javascript:collect_goods('<?php echo $output['goods']['goods_id']; ?>','count','goods_collect');"><?php echo $lang['goods_index_favorite_goods'];?></a><em nctype="goods_collect"><?php echo $output['goods']['goods_collect']?></em></div>
              <div class="handle-right" id="handle-r"><span></span>
                <ul >
                  <li class="tab"><span></span></li>
                  <li><i class="share-store"></i><a href="javascript:collect_store('<?php echo $output['store_info']['store_id'];?>','count','store_collect')" ><?php echo $lang['goods_index_favorite_store'];?><em nctype="store_collect"><?php echo $output['store_info']['store_collect']?></em></a></li>
                </ul>
              </div>
            </div>
             
          </div>
          
          <!-- E 收藏与分享 --> 
        </aside>
        <!-- E 商品图片及收藏分享 --> 
        <!-- S 商品基本信息 -->
        <article class="nc-wrap">
          <div class="nc-meta"> 
            <!-- S 商品发布价格 -->
            <dl class="nc-detail-price ">
              <dt><?php echo $lang['goods_index_goods_price'];?><?php echo $lang['nc_colon'];?></dt>
              <dd><strong <?php if($output['group_flag'] || ($output['xianshi_flag']&&$output['start_flag'])) echo "class='del'"; ?>nctype="goods_price"><?php echo (($output['goods']['goods_store_price_interval'] == '' || $output['goods']['spec_open'] == '0')? $output['goods']['goods_store_price'] : $output['goods']['goods_store_price_interval']); ?></strong><?php echo $lang['goods_index_yuan'];?></dd>
            </dl>
            <!-- E 商品发布价格 --> 
            <!-- S 商品促销价格 --> 
            <!-- S 团购 -->
            <?php if($output['group_flag']) { ?>
            <dl clsss="nc-promo">
              <dt><?php echo $lang['nc_promotion_join'].$lang['nc_colon'];?></dt>
              <dd><em class="nc-promo-price-type"><?php echo $lang['nc_groupbuy'];?></em><strong class="nc-promo-price"><?php echo $output['group_info']['groupbuy_price'];?></strong><?php echo $lang['goods_index_yuan'];?></dd>
            </dl>
            <?php } ?>
            <!-- E 团购 --> 
            <!-- S 限时折扣 -->
            <?php if($output['xianshi_flag']) { ?>
            <dl clsss="nc-promo">
              <dt><?php echo $lang['nc_promotion_join'];?><?php echo $lang['nc_colon'];?></dt>
              <dd><em class="nc-promo-price-type"><?php echo $lang['nc_xianshi'];?></em>
                <?php if(intval($output['xianshi_info']['start_time']) > time()) { ?>
                <!-- 尚未开始 --> 
                <strong nctype="xianshi_price"><?php echo ncPriceFormat($output['goods']['goods_store_price']*$output['xianshi_goods']['discount']);?></strong><?php echo $lang['goods_index_yuan'];?>
                <?php $time = intval($output['xianshi_info']['start_time']) - time();?>
                <time class="nc-promo-time">(<?php echo floor($time/86400);?><?php echo $lang['nc_day'];?><?php echo floor($time%86400/3600);?><?php echo $lang['nc_hour'];?><?php echo floor($time%86400%3600/60);?><?php echo $lang['nc_minute'].$lang['to_start'];?>)</time>
                <?php } else { ?>
                <!-- 已经开始 --> 
                <strong class="nc-promo-price" nctype="xianshi_price"><?php echo ncPriceFormat($output['goods']['goods_store_price']*$output['xianshi_goods']['discount']);?></strong> <?php echo $lang['goods_index_yuan'];?>
                <?php $time = intval($output['xianshi_info']['end_time']) - time();?>
                <time class="nc-promo-time">(<?php echo floor($time/86400);?><?php echo $lang['nc_day'];?><?php echo floor($time%86400/3600);?><?php echo $lang['nc_hour'];?><?php echo floor($time%86400%3600/60);?><?php echo $lang['nc_minute'].$lang['to_end'];?>)</time>
                <?php } ?>
              </dd>
            </dl>
            <?php } ?>
            <!-- E 限时折扣 --> 
            <!-- E 商品促销价格 --> 
            <!-- S 物流运费 -->
            <dl class="ncs-freight">
              <dt>
                <?php if ($output['goods']['goods_transfee_charge'] == 1){?>
                <?php echo $lang['goods_index_freight'].$lang['nc_colon'];?>
                <?php }else{?>
                <!-- 如果买家承担运费 --> 
                <!-- 如果使用了运费模板 -->
                <?php if ($output['goods']['transport_id'] != '0'){?>
                <?php echo $lang['goods_index_trans_to'];?><a href="javascript:void(0)" id="ncrecive"><?php echo $lang['goods_index_trans_country'];?></a><?php echo $lang['nc_colon'];?>
                <div class="ncs-freight-box" id="transport_pannel">
                  <?php if (is_array($output['area_list'])){?>
                  <?php foreach($output['area_list'] as $k=>$v){?>
                  <a href="javascript:void(0)" nctype="<?php echo $k;?>"><?php echo $v;?></a>
                  <?php }?>
                  <?php }?>
                </div>
                <?php }else{?>
                <?php echo $lang['goods_index_trans_zcountry'];?><?php echo $lang['nc_colon'];?>
                <?php }?>
                <?php }?>
              </dt>
              <dd id="transport_price">
                <?php if($output['group_flag']) { ?>
                <span><?php echo $lang['goods_index_groupbuy_no_shipping_fee'];?></span>
                <?php } else { ?>
                <?php if ($output['goods']['goods_transfee_charge'] == 1){?>
                <?php echo $lang['goods_index_trans_for_seller'];?>
                <?php }else{?>
                <!-- 如果买家承担运费 -->
                <?php if ($output['goods']['py_price'] > 0){?>
                <span><?php echo $lang['transport_type_py']?><?php echo $lang['nc_colon'];?><em id="nc_py"><?php echo $output['goods']['py_price'];?></em><?php echo $lang['goods_index_yuan'];?></span>
                <?php }?>
                <?php if ($output['goods']['kd_price'] > 0){?>
                <span><?php echo $lang['transport_type_kd']?><?php echo $lang['nc_colon'];?><em id="nc_kd"><?php echo $output['goods']['kd_price'];?></em><?php echo $lang['goods_index_yuan'];?></span>
                <?php }?>
                <?php if ($output['goods']['es_price'] > 0){?>
                <span>EMS<?php echo $lang['nc_colon'];?><em id="nc_es"><?php echo $output['goods']['es_price'];?></em><?php echo $lang['goods_index_yuan'];?></span>
                <?php }?>
                <?php }?>
                <?php }?>
              </dd>
              <dd style="color:red;display:none" id="loading_price">loading.....</dd>
            </dl>
            <!-- E 物流运费 ---> 
            <!-- S 累计售出数量 -->
            <dl>
              <dt><?php echo $lang['goods_index_sold'];?><?php echo $lang['nc_colon'];?></dt>
              <dd><em><a href="#ncGoodsTraded"><?php echo $output['goods']['salenum']; ?></a></em> <?php echo $lang['nc_jian'];?></dd>
            </dl>
            <!-- E 累计售出数量 --> 
            <!-- S 描述相符评分及评价数量 -->
            <dl>
              <dt><?php echo $lang['goods_index_evaluation'];?><?php echo $lang['nc_colon'];?></dt>
              <dd><span class="rate-star"><em><i style=" width:<?php echo $output['store_info']['store_desccredit_rate'];?>%;"></i></em></span><?php echo $output['store_info']['store_desccredit'];?><?php echo $lang['credit_unit'];?><i class="ver-line"></i><a href="#ncGoodsRate"><?php echo $output['goods']['commentnum'];?><?php echo $lang['goods_index_number_of_consult'];?></a></dd>
            </dl>
            <!-- E 描述相符评分及评价数量 --> 
            <!-- S 商品类型及浏览数-->
            <dl class="ncs-other">
              <dt><?php echo $lang['goods_index_goods_type'];?><?php echo $lang['nc_colon'];?></dt>
              <dd> <span><em>
                <?php if($output['goods']['goods_form'] == '1'){?>
                <?php echo $lang['goods_index_new'];?>
                <?php }else{?>
                <?php echo $lang['goods_index_used'];?>
                <?php }?>
                </em> <i class="ver-line"></i> <em><?php echo $output['goods']['goods_click']; ?></em> <?php echo $lang['goods_index_ci_browse'];?></span><!-- <span class=" ml100"><?php echo $lang['goods_index_location'];?><?php echo $lang['nc_colon'];?><em><?php echo $output['store_info']['area_info']; ?> </em></span> 商品所在地 --></dd>
            </dl>
            <!-- E 商品类型及浏览数--> 
          </div>
          <div class="sep-line"></div>
          <?php if($output['goods']['goods_state'] == '0' && $output['goods']['goods_show'] == '1'){?>
          <div class="nc-key"> 
          	<div class="nc-spec">
            <!-- S 商品规格值-->
            <?php if(is_array($output['goods']['goods_spec'])){ $i=0;?>
            <?php foreach($output['goods']['spec_name'] as $key=>$val){$i++;?>
            <dl>
              <dt><?php echo $val;?><?php echo $lang['nc_colon'];?></dt>
              <dd>
                <?php if (is_array($output['goods_spec'][$key]) and !empty($output['goods_spec'][$key])) {?>
                <ul nctyle="ul_sign">
                  <?php $j=0;foreach($output['goods_spec'][$key] as $k=>$v) {?>
                  <?php if(is_array($output['goods_col_img']) && isset($output['goods_col_img'][$v]) && $output['goods_col_img'][$v] != ''){?>
                  <!-- 图片类型规格-->
                  <li class="sp-img"><a href="<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$output['goods']['store_id'].DS.str_replace('_tiny', '_mid', $output['goods_col_img'][$v]);?>" onClick="selectSpec(<?php echo $i;?>, this, <?php echo $k;?>)" class="nc-zoom-gallery" title="<?php echo $v;?>" rel="useZoom: 'zoom1', smallImage: '<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$output['goods']['store_id'].DS.str_replace('_tiny', '_mid', $output['goods_col_img'][$v]);?>' " style=" background-image: url(<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$output['goods']['store_id'].DS.$output['goods_col_img'][$v];?>);"><?php echo $v;?><i></i></a></li>
                  <?php }else{?>
                  <!-- 文字类型规格-->
                  <li class="sp-txt"><a href="javascript:void(0)" onClick="selectSpec(<?php echo $i;?>, this, <?php echo $k;?>)" class=""><?php echo $v;?><i></i></a></li>
                  <?php }?>
                  <?php }?>
                </ul>
                <?php }?>
              </dd>
            </dl>
            <?php }?>
            <?php }?>
            <!-- E 商品规格值--> 
            </div>
            <!-- S 购买数量及库存 -->
            <dl>
              <dt><?php echo $lang['goods_index_buy_amount'];?><?php echo $lang['nc_colon'];?></dt>
              <dd class="nc-figure-input"> <a href="javascript:void(0)" class="decrease fl text-hidden">-</a>
                <input type="text" name="" id="quantity" value="1" size="3" maxlength="6" class="fl" style="border-radius:0;">
                <a href="javascript:void(0)" class="increase fl text-hidden">+</a> <em class="fl ml20">(<?php echo $lang['goods_index_stock'];?><strong nctype="goods_stock"><?php echo $output['goods']['spec_goods_storage']; ?></strong><?php echo $lang['nc_jian'];?>)</em> </dd>
            </dl>
            <!-- E 购买数量及库存 --> 
            <!-- S 提示已选规格及库存不足无法购买 -->
            <dl class="nc-point" nctype="goods_prompt" style="display:none;">
            </dl>
            <!-- E 提示已选规格及库存不足无法购买 --> 
            <!-- S 购买按钮 -->
            <div class="nc-btn clearfix">
              <?php if(!empty($output['group_flag'])) { ?>
              <a href="javascript:buy('groupbuy');" class="buynow fl text-hidden" title="<?php echo $lang['goods_index_now_buy'];?>"></a><!-- 团购购买--> 
              <!-- S 加入购物车弹出提示框 -->
              <?php } elseif(!empty($output['xianshi_flag']) && !empty($output['start_flag'])) { ?>
              <a href="javascript:buy('buynow');" class="buynow fl text-hidden" title="<?php echo $lang['goods_index_now_buy'];?>"></a><!-- 立即购买-->
              <?php } else { ?>
              <a href="javascript:buy('buynow');" class="buynow fl text-hidden" title="<?php echo $lang['goods_index_now_buy'];?>"></a><!-- 立即购买--> 
              <a href="javascript:buy('');" class="addcart fl ml10 text-hidden" title="<?php echo $lang['goods_index_add_to_cart'];?>"><!-- 加入购物车--></a> 
              <!-- S 加入购物车弹出提示框 -->
              <div class="ncs_cart_popup">
                <dl>
                  <dt>
                    <h3><?php echo $lang['goods_index_cart_success'];?></h3>
                    <a title="<?php echo $lang['goods_index_close'];?>" onClick="$('.ncs_cart_popup').css({'display':'none'});"><?php echo $lang['goods_index_close'];?></a></dt>
                  <dd>
                    <p class="mb5"><?php echo $lang['goods_index_cart_have'];?> <strong id="bold_num"></strong> <?php echo $lang['goods_index_number_of_goods'];?> <?php echo $lang['goods_index_total_price'];?><?php echo $lang['nc_colon'];?><em id="bold_mly" class="price"></em></p>
                    <p>
                      <input type="submit" class="btn1" name="" value="<?php echo $lang['goods_index_view_cart'];?>" onClick="location.href='<?php echo SiteUrl.DS?>index.php?act=cart'"/>
                      <input type="submit" class="btn2" name="" value="<?php echo $lang['goods_index_continue_shopping'];?>" onClick="$('.ncs_cart_popup').css({'display':'none'});"/>
                    </p>
                  </dd>
                </dl>
              </div>
              <!-- E 加入购物车弹出提示框 -->
              <?php } ?>
            </div>
            <!-- E 购买按钮 --> 
          </div>
          <?php }else{?>
          <dl class="nsg-handle">
            <dt><?php echo $lang['goods_index_is_no_show'];?></dt>
            <dd><?php echo $lang['goods_index_is_no_show_message_one'];?></dd>
            <dd><?php echo $lang['goods_index_is_no_show_message_two_1'];?><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['goods']['store_id']), 'store');?>"><?php echo $lang['goods_index_is_no_show_message_two_2'];?></a><?php echo $lang['goods_index_is_no_show_message_two_3'];?> </dd>
          </dl>
          <?php }?>
        </article>
        <!--E 商品信息 --> 
        <!--S 店铺信息-->
        <div class="ncg-info">
          <?php include template('store/info');?>
        </div>
        <!--E 店铺信息 --> 
      </div>
      <div class="clear"></div>
    </section>
    

    <section class="nc-promotion" <?php if(!$output['mansong_flag']) {?>style="display:none;"<?php }?>>
    <!--S 组合销售 -->
    <div class="nc-bundling" id="nc-bundling" style="display:none;">
    </div>
    <!--E 组合销售 -->
        <!--S 满就送 -->
    <?php if($output['mansong_flag']) { ?>
    <div class="nc-mansong">
      <div class="nc-mansong-container">
        <div class="nc-mansong-ico"></div>
        <dl class="nc-mansong-content">
          <dt>
            <h3><?php echo $output['mansong_info']['mansong_name'];?></h3>
            <time>( <?php echo $lang['nc_promotion_time'];?><?php echo $lang['nc_colon'];?><?php echo date('Y/m/d',$output['mansong_info']['start_time']).'--'.date('Y/m/d',$output['mansong_info']['end_time']);?> )</time>
          </dt>
          <dd>
            <ul class="nc-mansong-rule">
              <?php foreach($output['mansong_rule'] as $rule) { ?>
              <li><?php echo $lang['nc_man'];?><em><?php echo ncPriceFormat($rule['price']);?></em><?php echo $lang['nc_yuan'];?>
                <?php if(!empty($rule['discount'])) { ?>
                ,<?php echo $lang['nc_reduce'];?><?php echo ncPriceFormat($rule['discount']);?><?php echo $lang['nc_yuan'].$lang['nc_cash'];?>
                <?php } ?>
                <?php if(!empty($rule['shipping_free'])) { ?>
                ,<?php echo $lang['nc_shipping_free'];?>
                <?php } ?>
                <?php if(!empty($rule['gift_name'])) { ?>
                ,<?php echo $lang['nc_gift'];?><a href="<?php echo $rule['gift_link'];?>" target="_blank" class="red" ><?php echo $rule['gift_name'];?></a>
                <?php } ?>
              </li>
              <?php } ?>
            </ul>
          </dd>
          <dd class="nc-mansong-remark"><?php echo $output['mansong_info']['remark'];?></dd>
        </dl>
      </div>
    </div>
    <?php } ?>
    <!--E 满就送 -->
    </section>
    <section class="layout expanded" >
      <article class="nc-goods-main" id="main-nav-holder">
        <nav class="tabbar pngFix" id="main-nav">
          <div class="pr" style="z-index: 70;">
            <ul id="categorymenu">
              <li class="current"><a id="tabGoodsIntro" href="#shop-other" ><span><?php echo $lang['goods_index_goods_info'];?></span></a></li>
              <li><a id="tabGoodsRate" href="#shop-other"><span><?php echo $lang['goods_index_goods_consult'];?></span></a></li>
              <li><a id="tabGoodsTraded" href="#shop-other"><span><?php echo $lang['goods_index_sold_record'];?></span></a></li>
              <li><a id="tabGuestbook" href="#shop-other"><span><?php echo $lang['goods_index_product_consult'];?></span></a></li>
            </ul>
            <div class="switch-bar"><a href="javascript:void(0)" id="abc">&nbsp;</a></div>
            <div class="gotop"><a href="#header">&nbsp;</a></div>
          </div>
        </nav>
        <section class="nc-s-c-s4 ncg-intro">
          <div class="content bd" id="ncGoodsIntro">
            <?php if(is_array($output['goods']['goods_attr']) || isset($output['goods']['brand_name'])){?>
            <ul class="nc-goods-sort">
              <?php if(isset($output['goods']['brand_name'])){echo '<li>'.$lang['goods_index_brand'].$lang['nc_colon'].$output['goods']['brand_name'].'</li>';}?>
              <?php if(is_array($output['goods']['goods_attr']) && !empty($output['goods']['goods_attr'])){?>
              <?php foreach ($output['goods']['goods_attr'] as $val){ $val= array_values($val);echo '<li>'.$val[0].$lang['nc_colon'].$val[1].'</li>'; }?>
              <?php }?>
            </ul>
            <?php }?>
            <div class="default"><?php echo $output['goods']['goods_body']; ?></div>
          </div>
        </section>
        <section class="nc-s-c-s4 ncg-comment">
          <div class="title hd">
            <h4><?php echo $lang['goods_index_goods_consult'];?></h4>
          </div>
          <div class="content bd" id="ncGoodsRate">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="t" class="nc-g-r">
              <tr>
                <th><p><?php echo $lang['nc_credit_evalstore_type_1'];?><em><?php echo $output['store_info']['store_desccredit'];?></em><?php echo $lang['nc_grade'];?></p>
                  <dl class="ncs-rate-column">
                    <dt><em style="left:<?php echo $output['store_info']['store_desccredit_rate'];?>%;"><?php echo $output['store_info']['store_desccredit'];?></em></dt>
                    <dd><?php echo $lang['nc_eval_description_of_grade_1'];?></dd>
                    <dd><?php echo $lang['nc_eval_description_of_grade_2'];?></dd>
                    <dd><?php echo $lang['nc_eval_description_of_grade_3'];?></dd>
                    <dd><?php echo $lang['nc_eval_description_of_grade_4'];?></dd>
                    <dd><?php echo $lang['nc_eval_description_of_grade_5'];?></dd>
                  </dl></th>
                <td><a href="index.php?act=show_store&op=credit&id=<?php echo $output['store_info']['store_id']; ?>" target="_blank"><?php echo $lang['nc_eval_storeeval'];?></a></td>
              </tr>
            </table>
            <!-- 商品评价内容部分 -->
            <div id="goodseval"></div>
          </div>
        </section>
        <section class="nc-s-c-s4 ncg-salelog">
          <div class="title hd">
            <h4 class="tooltip"><?php echo $lang['goods_index_sold_record'];?></h4>
          </div>
          <div class="content bd" id="ncGoodsTraded">
            <div class="note">
              <p><em><?php echo $lang['goods_index_goods_cost_price'];?><strong class="price"><?php echo $output['goods']['goods_store_price'];?></strong><?php echo $lang['goods_index_yuan'];?></em><span class="ml50"><?php echo $lang['goods_index_price_note'];?><!-- 购买的价格不同可能是由于店铺往期促销活动引起的，详情可以咨询卖家 --></span></p>
            </div>
            <!-- 成交记录内容部分 -->
            <div id="salelog_demo" class="ncs-loading"> </div>
          </div>
        </section>
        <section class="nc-s-c-s4 ncg-guestbook">
          <div class="title hd">
            <h4 class="titbar"><?php echo $lang['goods_index_product_consult'];?></h4>
          </div>
          <div class="content bd" id="ncGuestbook"> 
            <!-- 咨询留言内容部分 -->
            <div class="ncg-guestbook">
              <div id="cosulting_demo" class="ncs-loading"> </div>
            </div>
          </div>
        </section>
        <?php if(!empty($output['goods_commend']) && is_array($output['goods_commend']) && count($output['goods_commend'])>1){?>
        <section class="nc-s-c-s2 ncg-com-list">
          <div class="title">
            <h4><?php echo $lang['goods_index_goods_commend'];?></h4>
          </div>
          <div class="content">
            <ul>
              <?php foreach($output['goods_commend'] as $goods_commend){?>
              <?php if($output['goods']['goods_id'] != $goods_commend['goods_id']){?>
              <li>
                <dl>
                  <dt><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods_commend['goods_id']), 'goods');?>" target="_blank"><?php echo $goods_commend['goods_name'];?></a></dt>
                  <dd class="ncg-pic"><span class="thumb"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$goods_commend['goods_id']), 'goods');?>" target="_blank"><img height="150" width="150" src="<?php echo thumb($goods_commend,'small');?>" onload="javascript:DrawImage(this,160,160);" title="<?php echo $goods_commend['goods_name'];?>" alt="<?php echo $goods_commend['goods_name'];?>"/></a></span></dd>
                  <dd class="ncg-price"><?php echo $lang['nc_price'];?><em class="price"><?php echo $lang['currency'];?><?php echo $goods_commend['goods_store_price'];?></em></dd>
                </dl>
              </li>
              <?php }?>
              <?php }?>
            </ul>
            <div class="clear"></div>
          </div>
        </section>
        <?php }?>
      </article>
      <aside class="nc-sidebar">
        <?php include template('store/callcenter');?>
        <?php include template('store/left');?>
      </aside>
    </section>
  </article>
  <?php include template('footer');?>
</div>
<form id="groupbuy_form" method="get" action="<?php echo SiteUrl;?>/index.php?act=show_groupbuy&op=groupbuy_buy">
  <input id="act" name="act" type="hidden" value="show_groupbuy" />
  <input id="op" name="op" type="hidden" value="groupbuy_buy" />
  <input id="group_id" name="group_id" type="hidden" value="<?php echo $output['group_info']['group_id'];?>" />
  <input id="groupbuy_spec_id" name="groupbuy_spec_id" type="hidden" />
  <input id="groupbuy_quantity" name="groupbuy_quantity" type="hidden" />
</form>
<form id="buynow_form" method="get" action="<?php echo SiteUrl;?>/index.php?act=buynow">
  <input id="act" name="act" type="hidden" value="buynow" />
  <input id="buynow_spec_id" name="buynow_spec_id" type="hidden"/>
  <input id="buynow_quantity" name="buynow_quantity" type="hidden" value='1' />
</form>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/nc-zoom.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.charCount.js"></script> 
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
<script src="<?php echo RESOURCE_PATH;?>/js/sns.js" type="text/javascript" charset="utf-8"></script> 
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.F_slider.js" type="text/javascript" charset="utf-8"></script> 
<script>
// 商品规格选择js部分
var SITE_URL = "<?php if($GLOBALS['setting_config']['enabled_subdomain'] == '1' and $output['store_info']['store_domain']!='') echo "http://".$output['store_info']['store_domain'].'.'.$GLOBALS['setting_config']['subdomain_suffix']; else echo SiteUrl;?>";
function buy(type)
{
	var B = false;
	$('ul[nctyle="ul_sign"]').each(function(){
		if(!$(this).find('a').hasClass('hovered')){
	        B = true;
		}
	});
    if (goodsspec.getSpec() == null || B)
    {
        alert('<?php echo $lang['goods_index_pleasechoosegoods']; ?>');
        return;
    }
    var spec_id = goodsspec.getSpec().id;
    var quantity = parseInt($("#quantity").val());
    if (!quantity>=1)
    {
        alert("<?php echo $lang['goods_index_pleaseaddnum'];?>");
        $("#quantity").val('1');
        return;
    }
    max = parseInt($('[nctype="goods_stock"]').text());
    if(quantity > max){
    	alert("<?php echo $lang['goods_index_add_too_much'];?>");
    	return;
    }
    switch(type) {
    case 'groupbuy' :
        buynow(spec_id,quantity,"groupbuy");
        break;
    case 'buynow':
        buynow(spec_id,quantity,'buynow');
        break;
    default:
        add_to_cart(spec_id, quantity);
        break;
    }
}


/* spec对象 */
function spec(id, spec, price, stock)
{
    this.id    = id;
    this.spec  = spec;
    this.price = price;
    this.stock = stock;
}
/* goodsspec对象 */
function goodsspec(specs, specQty, defSpec)
{
    this.specs = specs;
    this.specQty = specQty;
    this.defSpec = defSpec;
    <?php for ($i=1; $i<=$output['spec_count'];$i++){?>
    this.spec<?php echo $i?> = null;
    <?php }?>
    if (this.specQty >= 1)
    {
        for(var i = 0; i < this.specs.length; i++)
        {
            if (this.specs[i].id == this.defSpec)
            {
                <?php for ($i=1; $i<=$output['spec_count'];$i++){?>
                this.spec<?php echo $i?> = this.specs[i].spec[<?php echo (intval($i)-1);?>];
                <?php }?>
                break;
            }
        }
    }


    // 取得选中的spec
    this.getSpec = function()
    {
        for (var i = 0; i < this.specs.length; i++)
        {
            <?php for ($i=1; $i<=$output['spec_count'];$i++){?>
            if (this.specs[i].spec[<?php echo (intval($i)-1);?>] != this.spec<?php echo $i?>) continue;
            <?php }?>
            return this.specs[i];
        }
        return null;
    }

}

/* 选中某规格 num=1,2 */
function selectSpec(num, liObj, SID)
{
	goodsspec['spec' + num] = SID;
    $(liObj).addClass("hovered");
    $(liObj).parents('li').siblings().find('a').removeClass("hovered");
    var spec = goodsspec.getSpec();
    var sign = 't';
    $('ul[nctyle="ul_sign"]').each(function(){
		if($(this).find('.hovered').html() == null ){
			sign = 'f';
		}
    });
    if (spec != null && sign == 't')
    {
        $('[nctype="goods_price"]').html(number_format(spec.price,2));
        //限时折扣价格
        <?php if(!empty($output['xianshi_flag']) && !empty($output['xianshi_goods'])) { ?>
        var discount = <?php echo $output['xianshi_goods']['discount'];?>;
        $('[nctype="xianshi_price"]').html(number_format((spec.price*discount).toFixed(2),2));
        <?php } ?>
        $('[nctype="goods_stock"]').html(spec.stock);
        if(parseInt(spec.stock) == 0){
        	$('[nctype="goods_prompt"]').show().html('<dt><?php echo $lang['goods_index_prompt'];?></dt><dd><em class="no fl"><?php echo $lang['goods_index_understock_prompt'];?></em></dd>');
        }else{
            SP_V = '';
            $('ul[nctyle="ul_sign"]').find('li > .hovered').each(function(i){
				SP_V += $(this).text()+'<?php echo $lang['nc_comma'];?>';
            });
            SP_V = SP_V.substr(0,SP_V.length-1);
        	$('[nctype="goods_prompt"]').show().html('<dt><?php echo $lang['goods_index_prompt'];?></dt><dd><em class="yes fl"><?php echo $lang['goods_index_you_choose'];?>'+SP_V+'</em></dd>');
        }
     }
}

var specs = new Array();
var source_goods_price = <?php echo $output['goods']['goods_store_price']; ?>;
<?php if (is_array($output['spec_array']) and !empty($output['spec_array'])) { 
	foreach($output['spec_array'] as $val) {
?>
specs.push(new spec(<?php echo $val['spec_id']; ?>, [<?php echo $val['spec_goods_spec']?>], <?php echo $val['spec_goods_price']; ?>, <?php echo $val['spec_goods_storage']; ?>));
<?php
	}
 }
?>
var specQty = <?php if($output['goods']['spec_open'] == 1) echo $output['spec_count']; else echo '0'; ?>;
var defSpec = <?php echo intval($output['spec_array'][0]['spec_id']); ?>;
var goodsspec = new goodsspec(specs, specQty, defSpec);
</script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/waypoints.js"></script> 
<script type="text/javascript">
    //浮动导航  waypoints.js
    $('#main-nav-holder').waypoint(function(event, direction) {
        $(this).parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
    }); 
    
// 立即购买js
function buynow(spec_id,quantity,type){
<?php if ($_SESSION['is_login'] !== '1'){?>
	login_dialog();
<?php }else{?>
    	$("#"+type+"_spec_id").val(spec_id);
    	$("#"+type+"_quantity").val(quantity);
    	$("#"+type+"_form").submit();
<?php }?>
}
$(function(){

    //选择地区查看运费
    $('#transport_pannel>a').click(function(){
    	var id = $(this).attr('nctype');
    	if (id=='undefined') return false;
    	var _self = this,tpl_id = '<?php echo $output['goods']['transport_id'];?>';
	    var url = 'index.php?act=goods&op=calc&rand='+Math.random();
	    $('#transport_price').css('display','none');
	    $('#loading_price').css('display','');
	    $.getJSON(url, {'id':id,'tid':tpl_id}, function(data){
	    	if (data == null) return false;
	        if(data.kd != 'undefined') {$('#nc_kd').html(data.kd);}else{$('#nc_kd').html('');}
	        if(data.py != 'undefined') {$('#nc_py').html(data.py);}else{$('#nc_py').html('');}
	        if(data.es != 'undefined') {$('#nc_es').html(data.es);}else{$('#nc_es').html('');}
	        $('#transport_price').css('display','');
	    	$('#loading_price').css('display','none');
	        $('#ncrecive').html($(_self).html());
	    });
    });
    <?php if($output['goods']['goods_state'] == '0' && $output['goods']['goods_show'] == '1'){?>
	$("#nc-bundling").load('index.php?act=goods&op=get_bundling&goods_id=<?php echo $output['goods']['goods_id'];?>&id=<?php echo $output['goods']['store_id'];?>');
	<?php }?>
  	$("#goodseval").load('index.php?act=goods&op=comments&goods_id=<?php echo $output['goods']['goods_id'];?>&id=<?php echo $output['goods']['store_id'];?>');
	$("#salelog_demo").load('index.php?act=goods&op=salelog&goods_id=<?php echo $output['goods']['goods_id'];?>&id=<?php echo $output['goods']['store_id'];?>');
	$("#cosulting_demo").load('index.php?act=goods&op=cosulting&goods_id=<?php echo $output['goods']['goods_id'];?>&id=<?php echo $output['goods']['store_id'];?>');
});
</script> 
<script type="text/javascript">
//收藏分享处下拉操作
	jQuery.divselect = function(divselectid,inputselectid) {
		var inputselect = $(inputselectid);
			$(divselectid).click(function(){
		var ul = $(divselectid+" ul");
			if(ul.css("display")=="none"){
				ul.slideDown("fast");
			}
		});
	$(document).click(function(){
		$(divselectid+" ul").hide();
		});
	};
</script> 
<script type="text/javascript">
$(function(){
	$.divselect("#handle-l");
	$.divselect("#handle-r");
});
</script>
<script type="text/javascript">
// 规格属性
	$.getJSON('index.php?act=goods&op=get_s_a&goods_id=<?php echo $output['goods']['goods_id']; ?>&id=<?php echo $output['goods']['store_id']; ?>', function(data){
		if(data != null){

			<?php if(C('spec_model') == 1){?>
			// 规格
			var SPEC = '';
			if(data['spec_name'] != 'null' &&  data['goods_spec'] != null){
				$.each( data['spec_name'], function(prop_SN, prop_v){
					i++;
					SPEC += '<dl><dt>'+data['spec_name'][prop_SN]+'<?php echo $lang['nc_colon']; ?></dt><dd><ul nctyle="ul_sign">';
					var j=0;
					$.each( data['goods_spec'][prop_SN], function(prop_GS, prop_n){
						P_GS = data['goods_spec'][prop_SN][prop_GS];
						if(typeof(P_GS['name']) == 'undefined' || typeof(P_GS['id']) == 'undefined') return true;
						if(data['goods_col_img'] != 'null' && typeof(data['goods_col_img'][P_GS['name']]) != 'undefined' && data['goods_col_img'][P_GS['name']] != ''){
							SPEC += '<li class="sp-img"><a href="<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$output['goods']['store_id'].DS; ?>'+data['goods_col_img'][P_GS['name']].replace(/_tiny/,"_mid")+'" onClick="selectSpec('+i+', this, '+P_GS['id']+')" class="nc-zoom-gallery" title="'+P_GS['name']+'" rel="useZoom: \'zoom1\', smallImage : \'<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$output['goods']['store_id'].DS; ?>'+data['goods_col_img'][P_GS['name']].replace(/_tiny/, '_mid')+'\'" style=" background-image: url(<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$output['goods']['store_id'].DS;?>'+data['goods_col_img'][P_GS['name']]+');">'+P_GS['name']+'</i></a></li>';
						}else{
							SPEC += '<li class="sp-txt"><a href="javascript:void(0)" onClick="selectSpec('+i+', this, '+P_GS['id']+')" class="">'+P_GS['name']+'<i></i></a></li>';
						}
					});
				  SPEC += '</ul></dd></dl>';
				});
			}
			$('div.nc-spec').html(SPEC);
			$('.nc-zoom-gallery').NCZoom();		// 绑定zoom
			<?php }?>
			
			// 属性
			data['goods_attr'];
			var ATTR = '<?php if(isset($output['goods']['brand_name'])){echo '<li>'.$lang['goods_index_brand'].$lang['nc_colon'].$output['goods']['brand_name'].'</li>'; }?>';
			if(data['goods_attr'] != 'null'){
				for (var pron_A in data['goods_attr']){
					P_A = data['goods_attr'][pron_A];
					if(typeof(P_A['name']) == 'undefined' || typeof(P_A['value']) == 'undefined') continue;
					ATTR += '<li>'+P_A['name']+'<?php echo $lang['nc_colon']; ?>'+P_A['value']+'</li> ';
				}
			}
			$('ul[class="nc-goods-sort"]').html(ATTR);
		}
	});
</script>
</body></html>