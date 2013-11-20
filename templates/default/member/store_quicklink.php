<?php defined('InShopNC') or exit('Access Invalid!');?>

<div id="links_box" class="links-box">
  <form name='quicklink' id="quicklink" onsubmit="ajaxpost('quicklink','','','onerror');return false;" method="POST" action="index.php?act=store&op=quicklink">
    <input type="hidden" value="ok" name="form_submit">
    <dl>
      <dt><i></i><?php echo $lang['nc_seller_goods_manage'];?></dt>
      <dd>
        <ul>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=1 value="1||index.php?act=store_goods&op=add_goods&step=one||<?php echo $lang['nc_member_path_goods_sell'];?>">
              <?php echo $lang['nc_member_path_goods_sell'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=2 value="2||index.php?act=store_goods&op=goods_list||<?php echo $lang['nc_member_path_goods_selling'];?>">
              <?php echo $lang['nc_member_path_goods_selling'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=3 value="3||index.php?act=store_goods&op=goods_storage||<?php echo $lang['nc_member_path_goods_storage'];?>">
              <?php echo $lang['nc_member_path_goods_storage'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=4 value="4||index.php?act=store_goods&op=brand_list||<?php echo $lang['nc_member_path_brand_list'];?>">
              <?php echo $lang['nc_member_path_brand_list'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=6 value="6||index.php?act=store&op=store_goods_class||<?php echo $lang['nc_member_path_store_goods_class'];?>">
              <?php echo $lang['nc_member_path_store_goods_class'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=5 value="5||index.php?act=store_goods&op=taobao_import||<?php echo $lang['nc_member_path_taobao_import'];?>">
              <?php echo $lang['nc_member_path_taobao_import'];?></label>
          </li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt><i></i><?php echo $lang['nc_seller_order_manage'];?></dt>
      <dd>
        <ul>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=7 value="7||index.php?act=store&op=store_order||<?php echo $lang['nc_member_path_store_order'];?>">
              <?php echo $lang['nc_member_path_store_order'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=71 value="71||index.php?act=deliver&op=index||<?php echo $lang['nc_member_path_deliver'];?>">
              <?php echo $lang['nc_member_path_deliver'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=72 value="72||index.php?act=deliver&op=daddress||<?php echo $lang['nc_member_path_daddress'];?>">
              <?php echo $lang['nc_member_path_daddress'];?></label>
          </li>
          <?php if (C('payment')){?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=8 value="8||index.php?act=store&op=payment||<?php echo $lang['nc_member_path_payment'];?>">
              <?php echo $lang['nc_member_path_payment'];?></label>
          </li>
          <?php }?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=9 value="9||index.php?act=transport||<?php echo $lang['nc_member_path_transport'];?>">
              <?php echo $lang['nc_member_path_transport'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=10 value="10||index.php?act=store_evaluate&op=list||<?php echo $lang['nc_member_path_evalmanage'];?>">
              <?php echo $lang['nc_member_path_evalmanage'];?></label>
          </li>
        </ul>
    </dl>
    <dl>
      <dt><i></i><?php echo $lang['nc_seller_promotion_manage'];?></dt>
      <dd>
        <ul>
          <?php if (C('groupbuy_allow') == 1){ ?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=11 value="11||index.php?act=store_groupbuy||<?php echo $lang['nc_member_path_groupbuy_manage'];?>">
              <?php echo $lang['nc_member_path_groupbuy_manage'];?></label>
          </li>
          <?php } ?>
          <?php if (intval(C('gold_isuse')) == 1 && intval(C('promotion_allow')) == 1){ ?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=12 value="12||index.php?act=store_promotion_xianshi&op=xianshi_list||<?php echo $lang['nc_seller_promotion_xianshi_list'];?>">
              <?php echo $lang['nc_seller_promotion_xianshi_list'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=13 value="13||index.php?act=store_promotion_mansong&op=mansong_list||<?php echo $lang['nc_seller_promotion_mansong_list'];?>">
              <?php echo $lang['nc_seller_promotion_mansong_list'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=30 value="30||index.php?act=store_promotion_bundling&op=bundling_list||<?php echo $lang['nc_seller_promotion_bundling_list'];?>">
              <?php echo $lang['nc_seller_promotion_bundling_list'];?></label>
          </li>
          <?php } ?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=14 value="14||index.php?act=store&op=store_coupon||<?php echo $lang['nc_member_path_store_coupon'];?>">
              <?php echo $lang['nc_member_path_store_coupon'];?></label>
          </li>
          <?php if ($GLOBALS['setting_config']['voucher_allow'] == 1){?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=15 value="15||index.php?act=store_voucher||<?php echo $lang['nc_member_path_store_voucher'];?>">
              <?php echo $lang['nc_member_path_store_voucher'];?></label>
          </li>
          <?php } ?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=16 value="16||index.php?act=store&op=store_activity||<?php echo $lang['nc_member_path_store_activity'];?>">
              <?php echo $lang['nc_member_path_store_activity'];?></label>
          </li>
          <?php if (C('gold_isuse') == 1 && C('ztc_isuse') == 1){?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=17 value="17||index.php?act=store_ztc&op=ztc_list||<?php echo $lang['nc_member_path_store_ztc'];?>">
              <?php echo $lang['nc_member_path_store_ztc'];?></label>
          </li>
          <?php }?>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt><i></i><?php echo $lang['nc_seller_store_manage'];?></dt>
      <dd>
        <ul>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=18 value="18||index.php?act=store&op=store_setting||<?php echo $lang['nc_member_path_store_setting'];?>">
              <?php echo $lang['nc_member_path_store_setting'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=19 value="19||index.php?act=store&op=theme||<?php echo $lang['nc_member_path_store_theme'];?>">
              <?php echo $lang['nc_member_path_store_theme'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=20 value="20||index.php?act=store&op=store_navigation||<?php echo $lang['nc_member_path_store_navigation'];?>">
              <?php echo $lang['nc_member_path_store_navigation'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=21 value="21||index.php?act=store&op=store_partner||<?php echo $lang['nc_member_path_store_partner'];?>">
              <?php echo $lang['nc_member_path_store_partner'];?></label>
          </li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt><i></i><?php echo $lang['nc_seller_store_consult_manage'];?></dt>
      <dd>
        <ul>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=22 value="22||index.php?act=store_consult&op=consult_list||<?php echo $lang['nc_member_path_consult_manage'];?>">
              <?php echo $lang['nc_member_path_consult_manage'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=23 value="23||index.php?act=refund||<?php echo $lang['nc_member_path_store_refund'];?>">
              <?php echo $lang['nc_member_path_store_refund'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=24 value="24||index.php?act=return||<?php echo $lang['nc_member_path_store_return'];?>">
              <?php echo $lang['nc_member_path_store_return'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=25 value="25||index.php?act=store_complain&op=list||<?php echo $lang['nc_member_path_complain'];?>">
              <?php echo $lang['nc_member_path_complain'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=26 value="26||index.php?act=store_inform||<?php echo $lang['nc_member_path_store_inform'];?>">
              <?php echo $lang['nc_member_path_store_inform'];?></label>
          </li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt><i></i><?php echo $lang['nc_seller_other_manage'];?></dt>
      <dd>
        <ul>
          <?php if (C('gold_isuse') == 1){?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=27 value="27||index.php?act=store_gbuy||<?php echo $lang['nc_member_path_store_gbuy'];?>">
              <?php echo $lang['nc_member_path_store_gbuy'];?></label>
          </li>
          <?php }?>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=28 value="28||index.php?act=store_adv&op=adv_manage||<?php echo $lang['nc_member_path_adv'];?>">
              <?php echo $lang['nc_member_path_adv'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=29 value="29||index.php?act=store_album&op=album_cate||<?php echo $lang['nc_member_path_album'];?>">
              <?php echo $lang['nc_member_path_album'];?></label>
          </li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt><i></i><?php echo $lang['nc_member_path_store_statistics'];?></dt>
      <dd>
        <ul>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=901 value="901||index.php?act=statistics&op=flow_statistics||<?php echo $lang['nc_member_path_flow_statistics'];?>">
              <?php echo $lang['nc_member_path_flow_statistics'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=902 value="902||index.php?act=statistics&op=sale_statistics||<?php echo $lang['nc_member_path_sale_statistics'];?>">
              <?php echo $lang['nc_member_path_sale_statistics'];?></label>
          </li>
          <li>
            <label>
              <input type="checkbox" name="doc_content[]" qkey=903 value="903||index.php?act=statistics&op=probability_statistics||<?php echo $lang['nc_member_path_probability_statistics'];?>">
              <?php echo $lang['nc_member_path_probability_statistics'];?></label>
          </li>
        </ul>
      </dd>
    </dl>
    <div class="bottom">
      <input type="submit" class="submit ml30" value="<?php echo $lang['nc_common_button_save'];?>">
    </div>
  </form>
</div>
<script>
$(document).ready(function(){
$('input[name="doc_content[]"]').live('click',function(){
	if($('#links_box').find('input:checked').size() >=9){
		alert('<?php echo $lang['nc_member_path_quicklinke_max_note'];?>');
		return false;
	}
});
<?php if (isset($output['quick_link'])){?>
	<?php foreach((array)$output['quick_link'] as $value){?>
		<?php $svalue = explode('||',$value)?>
		$('input[qkey="<?php echo $svalue[0];?>"]').attr('checked',true);
	<?php }?>
<?php }?>
});
</script>