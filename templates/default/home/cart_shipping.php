<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>

<div id="warning" class="warning" style="display:none;"></div>
<div class="cart-title">
  <h3><?php echo $lang['cart_step1_receiver_address'];?></h3>
  <div class="btns"><a href="JavaScript:void(0);" id="span_newaddress" onclick="shownewaddress();" class="newadd"><i></i><?php echo $lang['cart_step1_new_address']; ?></a> <a href="index.php?act=member&op=address" target="_blank" class="editadd"><?php echo $lang['cart_step1_manage_receiver_address'];?></a></div>
</div>
<div id="addressone_model" style="display:none;">
  <ul class="receive_add address_item">
    <li class="goto"><?php echo $lang['cart_step1_receiver_jsz'];?></li>
    <li address="" buyer=""></li>
  </ul>
</div>
<div id="addresslist">
  <?php foreach((array)$output['address_list'] as $k=>$val){ ?>
  <ul class="receive_add address_item <?php if ($k == 0) echo 'selected_address'; ?>">
    <li class="goto">
      <?php if ($k == 0) echo $lang['cart_step1_receiver_jsz'];else echo '&nbsp;';?>
    </li>
    <li address="<?php echo $val['area_info']; ?>&nbsp;&nbsp;<?php echo $val['address']; ?>" buyer="<?php echo $val['true_name']; ?>&nbsp;&nbsp;<?php if($val['mob_phone']) echo $val['mob_phone']; else echo $val['tel_phone']; ?>">
      <input id="address_<?php echo $val['address_id']; ?>" type="radio" city_id="<?php echo $val['city_id']?>" name="address_options" value="<?php echo $val['address_id']; ?>" <?php if ($k == 0) echo 'checked'; ?>/>
      &nbsp;&nbsp;<?php echo $val['area_info']; ?>&nbsp;&nbsp;<?php echo $val['address']; ?>&nbsp;&nbsp; <?php echo $val['true_name']; ?><?php echo $lang['cart_step1_receiver_shou'];?>&nbsp;&nbsp;
      <?php if($val['mob_phone']) echo $val['mob_phone']; else echo $val['tel_phone']; ?>
    </li>
  </ul>
  <?php } ?>
  <input type="hidden" id="chooseaddressid" name="chooseaddressid" value='<?php echo $output['address_list'][0]['address_id'];?>'/>
</div>
<div class="buytable">
  <?php if(is_array($output['cart_array']) and !empty($output['cart_array'])) {?>
  <div class="cart-title">
    <h3><?php echo $lang['cart_step1_order_info'];?></h3>
  </div>
  <table class="buy-table">
    <thead>
      <tr>
        <th colspan="2"><?php echo $lang['cart_index_store_goods'];?>
          <hr></th>
        <th class="w120"><?php echo $lang['cart_index_price'].'('.$lang['currency_zh'].')';?>
          <hr></th>
        <th class="w120"><?php echo $lang['cart_index_amount'];?>
          <hr></th>
        <th class="w120"><?php echo $lang['cart_index_sum'].'('.$lang['currency_zh'].')';?>
          <hr></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th colspan="20"><?php echo $lang['cart_step1_store'].$lang['nc_colon'];?><a target="_blank" href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['cart_array'][0]['store_id']),'store',$output['cart_array'][0]['store_domain']);?>"><?php echo $output['cart_array'][0]['store_name']; ?></a></th>
      </tr>
      <?php foreach($output['cart_array'] as $v) { ?>
      <tr id="cart_item_<?php echo $v['spec_id'];?>">
        <td class="w70"><div class="cart-goods-pic"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods');?>" target="_blank" ><span class="thumb size60"><i></i><img src="<?php echo thumb($v,'tiny'); ?>" alt="<?php echo $v['goods_name']; ?>" onload="javascript:DrawImage(this,60,60);" /></span></a></div></td>
        <td class="tl vt"><dl class="cart-goods-info">
            <dt class="cart-goods-info-name"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods');?>" target="_blank"><?php echo $v['goods_name']; ?></a></dt>
            <dd class="cart-goods-info-spec"><?php echo $v['cart_spec_info']; ?></dd>
          </dl></td>
        <td class="tc"><span class="cart-goods-price-s"><?php echo $v['spec_goods_price']; ?></span></td>
        <td class="tc"><?php echo $v['goods_num']; ?></td>
        <td><span class="cart-goods-price"><em><?php echo $v['goods_all_price']; ?></em></span></td>
      </tr>
      
      <!-- if buyer cheng dan -->
      <?php if ($v['goods_transfee_charge']==0){?>
      <?php if ($v['py_price']==0 && $v['kd_price']==0 && $v['es_price']==0 && $v['transport_id'] == 0){?>
      <?php }else{?>
      <?php $if_free = false;?>
      <!-- 记录运费模板ID和购买数量，异步求运费用到 -->
      <?php if ($v['transport_id'] > 0){?>
      <!-- 使用运费模板 -->
      <?php $g_tid .=','.$v['transport_id'];?>
      <?php $g_num .=','.$v['goods_num'];?>
      <?php }else{?>
      <!-- 不使用运费模板，直接定义三种运费价格 -->
      <?php $g_trans .= ','.$v['py_price'].'_'.$v['kd_price'].'_'.$v['es_price'];?>
      <?php }?>
      <?php }?>
      <?php }?>
      <?php }?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="tl"><!-- 给卖家留言 --><script type="text/javascript">function postscript_activation(tt){if (!tt.name){tt.value = '';tt.name = 'order_message';}}</script>
          <label><?php echo $lang['cart_step1_message_to_seller'].$lang['nc_colon'];?>
            <input type="text" id="postscript" onclick="postscript_activation(this);" value="<?php echo $lang['cart_step1_message_advice'];?>" maxlength="200" class="text w400" />
          </label>
          <?php }?></td>
        <td colspan="3" class="tr"><i class="transport-ico"></i><span>
          <?php if($output['bundling'] == 1){?>
          <!-- 组合销售商品直接显示运费 --><?php echo floatval($output['bl_freight']) == 0?$lang['cart_step1_transport_fee']:$lang['cart_index_freight'].$lang['nc_colon']."&nbsp;".$lang['currency'].ncPriceFormat($output['bl_freight']);?></span>
          <?php }else{?>
          <span>
          <?php if ($if_free === false){?>
          <?php echo $lang['cart_step1_transport_type'].$lang['nc_colon'];?>
          <?php }?>
          <!-- 显示运费 -->
          
          <?php if ($if_free !== false){?>
          <?php echo $lang['cart_step1_transport_fee'];?>
          <?php }else{?>
          <select name="transport_type">
          </select>
          <?php }?>
          </span>
          <?php }?>
          <em id="trans_total" class="cart-goods-price ml5 mr20"><?php echo $output['bundling'] == 1?(floatval($output['bl_freight']) == 0?'':ncPriceFormat($output['bl_freight'])):'';?></em></td>
      </tr>
    </tfoot>
  </table>
</div>
<input id="store_goods_price" type="hidden" value="<?php echo $output['store_goods_price'];?>" />
<script type="text/javascript">
	var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
    //选择已经存在的收货人地址
    $('.address_item').live('click',function(){
    	$(this).parent().find('.goto').html('&nbsp;');
    	$(this).children().first().html('<?php echo $lang['cart_step1_receiver_jsz'];?>');
        var checked_address_radio = $(this).find("input[name='address_options']");
        $(checked_address_radio).attr('checked', true);
        $('.address_item').removeClass('selected_address');
        $(this).addClass('selected_address');
        $("#chooseaddressid").val($(checked_address_radio).val());
        getTransport();
        var _next = $(this).find('li').eq(1);
        $('#confirm_address').html($(_next).attr('address'));
        $('#confirm_buyer').html($(_next).attr('buyer'));
    });
    //当选择代金券重新计算应付金额
    $('.voucheritem').live('click',function(){
        $(this).find("input[name='voucher_id']").attr('checked',true);
        $('.voucheritem').removeClass('selected_voucher');
        $(this).addClass('selected_voucher');
        getallprice();
    });

    <?php if (empty($output['address_list'])){?>
    //弹出填写收货地址
		shownewaddress();
	<?php } ?>

	//选择不同的配送方式，总价不同
	$('select[name="transport_type"]').bind('change',function(){
		//显示运费
		var value = $(this).val().split('|');
		$('#trans_total').html(value[1]);
		//显示总价
		getallprice();
	});

	//异步取得各运费价格
	function getTransport(){

		//显示寄送至
        var _select = $('.selected_address').find('li').eq(1);
        $('#confirm_address').html($(_select).attr('address'));
        $('#confirm_buyer').html($(_select).attr('buyer'));

        //如果购买的商品没有使用运费模板
        <?php if (!isset($g_tid) && !isset($g_trans)){?>
	    	//显示当前选择的运送方式到span
	    	$('select[name="transport_type"]').each(function(){
				var value = $(this).val().split('|');
				$('#trans_total').html(value[1]);
	    	});
			getallprice();
			return false;
        <?php }?>
		var url = SITE_URL + '/index.php?act=cart&op=calc_buy&rand='+Math.random();
		var area_id = $('input[name="address_options"]:checked').attr('city_id');
		var hash = "<?php echo encrypt(implode('-',array(trim($g_tid,','),trim($g_num,','),trim($g_trans,','))),MD5_KEY.'CART');?>";
	    $.getJSON(url, {'hash':hash,'area_id':area_id}, function(data){
	    	if (data == null) return false;

	    	//显示运费到select
    		var str = '';
    		if(typeof(data['py']) != 'undefined'){ str += '<option value="py|'+data['py']+'"><?php echo $lang['transport_type_py'];?> '+data['py']+'</option>';}
    		if(typeof(data['kd']) != 'undefined'){ str += '<option value="kd|'+data['kd']+'"><?php echo $lang['transport_type_kd'];?> '+data['kd']+'</option>';}
    		if(typeof(data['es']) != 'undefined'){ str += '<option value="es|'+data['es']+'">EMS '+data['es']+'</option>';}
    		if (str != ''){
    			$('select[name="transport_type"]').html(str);
    		}else{
    			$('select[name="transport_type"]').html('');
    		}
	    	//显示当前选择的配送价格
	    	$('select[name="transport_type"]').each(function(){
				var value = $(this).val().split('|');
				$('#trans_total').html(value[1]);
	    	});
			getallprice();
	    });
	}
	getTransport();

});

//计算总金额
function getallprice(){
	var order_amount = 0;
    <?php if(!$output['rule_shipping_free']) { ?>
	if ($('#trans_total').html() != ''){
		order_amount += parseFloat($('#trans_total').html());
	}
    <?php } ?>
    order_amount += parseFloat($("#store_goods_price").val());
	var voucher = parseFloat($(".selected_voucher").children(".pay").children(".money").attr('value'));
	if(voucher > 0){
		order_amount = order_amount - voucher;
	}
	$('#order_amount').html(number_format(order_amount,2));
}
function shownewaddress(){
	var addr_id = $("input[name='address_options']:checked").val();
    ajax_form('newaddressform','<?php echo $lang['cart_step1_new_address'];?>', SITE_URL + '/index.php?act=cart&op=newaddress&addr_id='+addr_id,740);
    return false;
}
</script>