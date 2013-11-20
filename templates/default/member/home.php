<?php defined('InShopNC') or exit('Access Invalid!');?>

<div id="home">
  <div class="intro">
    <div class="left">
      <div class="store-pic"><span class="thumb size80"><i></i><img src="<?php if(empty($output['store_info']['store_logo'])){echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_store_logo'];}else{echo ATTACH_STORE.'/'.$output['store_info']['store_logo'];}?>"  onload="javascript:DrawImage(this,80,80);" title="<?php echo $output['store_info']['store_name']; ?>" alt="<?php echo $output['store_info']['store_name']; ?>" /></a></span><em><a href="index.php?act=store&op=store_setting"><?php echo $lang['store_set_logo'];?></a></em></div>
      <dl class="basic">
        <dd class="member-name"><?php echo $_SESSION['member_name']; ?></dd>
        <dd class="cert">
          <?php if($output['store_info']['name_auth'] != 1 && $output['store_info']['store_auth'] != 1){?>
          <a href="index.php?act=store&op=store_certified"><?php echo $lang['store_not_certified'];?></a>
          <?php }?> 
          <img <?php if($output['store_info']['name_auth'] == 1){ echo 'src="'.TEMPLATES_PATH.'/images/member/cert_autonym.gif"';}else{ echo 'src="'.TEMPLATES_PATH.'/images/member/cert_autonym_no.gif" title="'.$lang['store_not_certified'].'" alt="'.$lang['store_not_certified'].'"';}?>/>
          <img <?php if($output['store_info']['store_auth'] == 1){echo 'src="'.TEMPLATES_PATH.'/images/member/cert_material.gif"';}else{ echo 'src="'.TEMPLATES_PATH.'/images/member/cert_material_no.gif" title="'.$lang['store_not_certified'].'" alt="'.$lang['store_not_certified'].'"';}?>/>  
        </dd>
        <dd class="credit"> <span> <?php echo $lang['store_seller_credit'].$lang['nc_colon'];?><?php echo intval($output['store_info']['store_credit']);?></span>
          <?php if (!empty($output['store_info']['credit_arr'])){?>
          <span class="seller-<?php echo $output['store_info']['credit_arr']['grade']; ?> level-<?php echo $output['store_info']['credit_arr']['songrade']; ?>"></span>
          <?php }?>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_name'].$lang['nc_colon'];?></dt>
        <dd><a href="JavaScript:void(0);" onclick="show_store('<?php echo $_SESSION['store_id'];?>');"><?php echo $output['store_info']['store_name'];?></a></dd>
        <dd><?php echo $output['store_info']['area_info'];?></dd>
      </dl>
      <?php if (C('payment')){?>
      <dl>
        <dt><?php echo $lang['store_payment'].$lang['nc_colon'];?></dt>
        <dd>
          <?php if(!empty($output['store_payment']) && is_array($output['store_payment'])){ ?>
          <?php foreach($output['store_payment'] as $key => $val){ ?>
          <span><a href="index.php?act=store&op=add_payment&payment_code=<?php echo $val['code']; ?>"><?php echo $val['name'];?></a></span>
          <?php } ?>
          <?php } else { ?>
          <a href="index.php?act=store&op=payment" class="orange"><?php echo $lang['store_payment_info'];?></a>
          <?php } ?>
        </dd>
      </dl>
      <?php }?>
    </div>
    <div class="right seller-rate">
      <h2><?php echo $lang['store_dynamic_evaluation'].$lang['nc_colon'];?></h2>
      <dl>
        <dt><?php echo $lang['store_description_of'].$lang['nc_colon'];?></dt>
        <dd class="rate-star"><em><i style=" width:<?php echo $output['store_info']['store_desccredit_rate']>0?$output['store_info']['store_desccredit_rate']:0;?>%;"></i></em></dd>
        <dd><?php echo $output['store_info']['store_desccredit']>0?$output['store_info']['store_desccredit']:0;?><?php echo $lang['credit_unit'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_service_attitude'].$lang['nc_colon'];?></dt>
        <dd class="rate-star"><em><i style=" width:<?php echo $output['store_info']['store_servicecredit_rate']>0?$output['store_info']['store_servicecredit_rate']:0;?>%;"></i></em></dd>
        <dd><?php echo $output['store_info']['store_servicecredit']>0?$output['store_info']['store_servicecredit']:0;?><?php echo $lang['credit_unit'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_delivery_speed'].$lang['nc_colon'];?></dt>
        <dd class="rate-star"><em><i style=" width:<?php echo $output['store_info']['store_deliverycredit_rate']>0?$output['store_info']['store_deliverycredit_rate']:0;?>%;"></i></em></dd>
        <dd><?php echo $output['store_info']['store_deliverycredit']>0?$output['store_info']['store_deliverycredit']:0;?><?php echo $lang['credit_unit'];?></dd>
      </dl>
    </div>
  </div>
  <div class="seller-cont">
    <div class="l">
      <div class="stroe-info container">
        <div class="hd">
          <div class="shop-level"><span><?php echo $lang['store_store_grade'].$lang['nc_colon'];?><?php echo $output['store_info']['grade_name']; ?></span> <span><?php echo $lang['store_validity'].$lang['nc_colon'];?><?php echo $output['store_info']['store_end_time'];?></span> <span><?php echo $lang['store_publish_goods'].$lang['nc_colon'];?><?php echo $output['store_info']['grade_goodslimit']; ?></span> <span><?php echo $lang['store_publish_album'].$lang['nc_colon'];?><?php echo $output['store_info']['grade_albumlimit']; ?></span> </div>
          <h2><?php echo $lang['store_owner_info'];?></h2>
        </div>
        <div class="content">
          <dl class="focus">
            <h2><?php echo $lang['store_notice_info'].$lang['nc_colon'];?></h2>
            <dt><?php echo $lang['store_goods_info'].$lang['nc_colon'];?></dt>
            <dd><a href="index.php?act=store_goods&op=goods_storage"><?php echo $lang['store_goods_storage'];?> (<strong id="tj_goods_storage"></strong>)</a></dd>
            <dt><?php echo $lang['store_consult_info'].$lang['nc_colon'];?></dt>
            <dd><a href="index.php?act=store_consult&op=consult_list&type=to_reply"><?php echo $lang['store_to_consult'];?> (<strong id="tj_consult"></strong>)</a></dd>
            <dt><?php echo $lang['store_inform_info'].$lang['nc_colon'];?></dt>
            <dd><a href="index.php?act=store_inform" title="<?php echo $lang['store_inform30'];?>"><?php echo $lang['store_inform'];?> (<strong id="tj_inform">0</strong>)</a></dd>
          </dl>
          <ul>
            <li><a href="index.php?act=store_goods&op=goods_list"><?php echo $lang['store_goods_selling'];?> (<strong id="tj_goods_selling">0</strong>)</a></li>
            <li><a href="index.php?act=store_goods&op=goods_storage&type=state"><?php echo $lang['store_goods_show0'];?> (<strong id="tj_goods_show0">0</strong>)</a></li>
            <?php if (intval(C('gold_isuse')) == 1){ ?>
            <li><a href="index.php?act=store_gbuy"><?php echo $lang['store_member_goldnum'];?> (<strong><?php echo $output['member_info']['member_goldnum'];?></strong>)</a></li>
            <?php } ?>
            <li><a href="index.php?act=store_goods&op=taobao_import"><?php echo $lang['store_taobao_import'];?></a></li>
          </ul>
          
        </div>
      </div>
      <div class="business-info container">
        <div class="hd">
          <h2><?php echo $lang['store_business'];?></h2>
        </div>
        <div class="content">
          <dl class="focus">
            <h2><?php echo $lang['store_business_info'].$lang['nc_colon'];?></h2>
            <dt><?php echo $lang['store_order_info'].$lang['nc_colon'];?></dt>
            <dd><a href="index.php?act=store&op=store_order"><?php echo $lang['store_order_progressing'];?> (<strong id="tj_progressing">0</strong>)</a></dd>
            <dt><?php echo $lang['store_complain_info'].$lang['nc_colon'];?></dt>
            <dd><a href="index.php?act=store_complain&op=complain_accused_list&select_complain_state=1"><?php echo $lang['store_complain'];?> (<strong id="tj_complain">0</strong>)</a></dd>
          </dl>
          <ul>
            <li><a href="index.php?act=store&op=store_order&state_type=order_pay"><?php echo $lang['store_order_pay'];?> (<strong id="tj_pending">0</strong>)</a></li>
            <li><a href="index.php?act=store&op=store_order&state_type=order_no_shipping"><?php echo $lang['store_shipped'];?> (<strong id="tj_shipped">0</strong>)</a></li>
            <li><a href="index.php?act=store&op=store_order&state_type=order_shipping"><?php echo $lang['store_shipping'];?> (<strong id="tj_shipping">0</strong>)</a></li>
            <li><a href="index.php?act=store&op=store_order&state_type=order_finish&eval=1"><?php echo $lang['store_evalseller'];?> (<strong id="tj_evalseller">0</strong>)</a></li>
            <li><a href="index.php?act=refund&add_time_from=<?php echo $output['add_time_from']; ?>&add_time_to=<?php echo $output['add_time_to']; ?>" title="<?php echo $lang['store_refund30'];?>"> <?php echo $lang['store_refund'];?> (<strong id="tj_refund">0</strong>)</a></li>
            <li><a href="index.php?act=return&add_time_from=<?php echo $output['add_time_from']; ?>&add_time_to=<?php echo $output['add_time_to']; ?>" title="<?php echo $lang['store_return30'];?>"> <?php echo $lang['store_return'];?> (<strong id="tj_return">0</strong>)</a></li>
            <li><a href="index.php?act=store&op=store_order&add_time_from=<?php echo $output['add_time_from']; ?>&add_time_to=<?php echo $output['add_time_to']; ?>" title="<?php echo $lang['store_order30'];?>"> <?php echo $lang['store_order_info'];?> (<strong id="tj_order30">0</strong>)</a></li>
          </ul>
          
        </div>
      </div>
      <?php if (C('predeposit_isuse') == 1){ ?>
      <div class="predeposit-info container">
        <div class="hd">
          <h2><?php echo $lang['store_predeposit'];?></h2>
        </div>
        <div class="content">
          <div class="ico pngFix"></div>
          <div class="hint">
            <h3><?php echo $lang['store_available_predeposit'].$lang['nc_colon'];?><?php echo $output['member_info']['available_predeposit'];?> <?php echo $lang['currency_zh'];?></h3>
            <p class="hint"><?php echo $lang['store_predeposit_info'];?></p>
            <a href="index.php?act=predeposit" class="ncu-btn1 ml10 mt5"><span><?php echo $lang['store_predeposit_add'];?></span></a></div>
          <ul style="margin: 0 0 5px 100px">
            <li><a href="index.php?act=predeposit&op=rechargelist"><?php echo $lang['store_rechargelist'];?></a></li>
            <li><a href="index.php?act=predeposit&op=predepositcash"><?php echo $lang['store_predepositcash'];?></a></li>
            <li><a href="index.php?act=predeposit&op=predepositlog"><?php echo $lang['store_predepositlog'];?></a></li>
          </ul>
          
        </div>
      </div>
      <?php } ?>
      <div class="marketing-info container">
        <div class="hd">
          <h2><?php echo $lang['store_market_info'];?></h2>
        </div>
        <div class="content">
          <?php if (C('groupbuy_allow') == 1){ ?>
          <dl class="tghd">
            <dt class="pngFix"><a href="index.php?act=store_groupbuy"><?php echo $lang['store_groupbuy'];?></a></dt>
            <dd><?php echo $lang['store_groupbuy_info'];?></dd>
          </dl>
          <?php } ?>
          <?php if (intval(C('gold_isuse')) == 1 && intval(C('promotion_allow')) == 1){ ?>
          <dl class="xszk">
            <dt class="pngFix"><a href="index.php?act=store_promotion_xianshi&op=xianshi_list"><?php echo $lang['store_xianshi'];?></a></dt>
            <dd><?php echo $lang['store_xianshi_info'];?></dd>
          </dl>
          <dl class="mjs">
            <dt class="pngFix"><a href="index.php?act=store_promotion_mansong&op=mansong_list"><?php echo $lang['store_mansong'];?></a></dt>
            <dd><?php echo $lang['store_mansong_info'];?></dd>
          </dl>
          <dl class="zhxs">
            <dt class="pngFix"><a href="index.php?act=store_promotion_bundling&op=bundling_list"><?php echo $lang['store_bundling'];?></a></dt>
            <dd><?php echo $lang['store_bundling_info'];?></dd>
          </dl>
          <?php } ?>
          <?php if (C('gold_isuse') == 1 && C('ztc_isuse') == 1){?>
          <dl class="ztc">
            <dt class="pngFix"><a href="index.php?act=store_ztc&op=ztc_list"><?php echo $lang['store_ztc'];?></a></dt>
            <dd><?php echo $lang['store_ztc_info'];?></dd>
          </dl>
          <?php } ?>
          <?php if ($GLOBALS['setting_config']['voucher_allow'] == 1){?>
          <dl class="djq">
            <dt class="pngFix"><a href="index.php?act=store_voucher"><?php echo $lang['store_voucher'];?></a></dt>
            <dd><?php echo $lang['store_voucher_info'];?></dd>
          </dl>
          <?php }?>
         <dl class="ggfw">
            <dt class="pngFix"><a href="index.php?act=store_adv&op=adv_manage"><?php echo $lang['store_adv'];?></a></dt>
            <dd><?php echo $lang['store_adv_info'];?></dd>
          </dl>
          <dl class="zthd">
            <dt class="pngFix"><a href="index.php?act=store&op=store_activity"><?php echo $lang['store_activity'];?></a></dt>
            <dd><?php echo $lang['store_activity_info'];?></dd>
          </dl>
          <dl class="yhq">
            <dt class="pngFix"><a href="index.php?act=store&op=store_coupon"><?php echo $lang['store_coupon'];?></a></dt>
            <dd><?php echo $lang['store_coupon_info'];?></dd>
          </dl>
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <div class="r">
      <div class="news container">
        <div class="hd">
          <h2><?php echo $lang['store_article'];?></h2>
        </div>
        <div class="content">
          <ul>
            <?php 
			if(is_array($output['show_article']) && !empty($output['show_article'])) { 
				foreach($output['show_article'] as $val) {
			?>
            <li><a target="_blank" href="<?php if(!empty($val['article_url']))echo $val['article_url'];else{ echo ncUrl(array('act'=>'article','article_id'=>$val['article_id']),'article');}?>" title="<?php echo $val['article_title']; ?>"><?php echo str_cut($val['article_title'],24);?></a></li>
            <?php 
				}
			}
			 ?>
          </ul>
        </div>
      </div>
      <div class="contact container">
        <div class="hd">
          <h2><?php echo $lang['store_site_info'];?></h2>
        </div>
        <div class="content">
          <ul>
            <?php 
			if(is_array($output['phone_array']) && !empty($output['phone_array'])) { 
				foreach($output['phone_array'] as $key => $val) {
			?>
            <li style="width:100%;"><?php echo $lang['store_site_phone'].($key+1).$lang['nc_colon'];?><?php echo $val;?></li>
            <?php 
				}
			}
			 ?>
            <li style="width:100%;"><?php echo $lang['store_site_email'].$lang['nc_colon'];?><?php echo C('site_email');?></li>
          </ul>
        </div>
      </div>
      <script type="text/javascript" src="<?php echo SiteUrl;?>/index.php?act=adv&op=advshow&ap_id=371"></script> 
    </div>
  </div>
  <div class="wrap_line mb5">
    <div class="info"></div>
  </div>
</div>
<script>
$(function(){
	var timestamp=Math.round(new Date().getTime()/1000/60);//异步URL一分钟变化一次
    $.getJSON('index.php?act=store&op=statistics&rand='+timestamp, null, function(data){
    	if (data == null) return false;
		for(var a in data) {
			if(data[a] != 'undefined') {$('#tj_'+a).html(data[a]);}
		}
    });
});
</script>