<link href="<?php echo TEMPLATES_PATH;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<style type="text/css">
#navBar {
	display: none !important;
}
</style>
<ul class="point-chart">
  <li class="step a2" title="<?php echo $lang['pointcart_ensure_order'];?>"></li>
  <li class="step b1" title="<?php echo $lang['pointcart_ensure_info'];?>"></li>
  <li class="step c2" title="<?php echo $lang['pointcart_exchange_finish'];?>"></li>
</ul>
<form method="post" id="porder_form" name="porder_form" action="index.php?act=pointcart&op=step2">
  <div class="content"> 
    <!-- 收货人地址start -->
    <div class="cart-title">
  <h3><?php echo $lang['pointcart_step1_receiver_address'];?></h3>
  <div class="btns"><a href="JavaScript:void(0);" id="span_newaddress" onclick="shownewaddress();" class="newadd"><i></i><?php echo $lang['pointcart_step1_new_address']; ?></a> <a href="index.php?act=member&op=address" target="_blank" class="editadd"><?php echo $lang['pointcart_step1_manage_receiver_address'];?></a></div>
      </span> </div>
    <!-- 已经存在的收获地址start -->
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
    <!-- 已经存在的收获地址end --> 
    
    <!-- 留言start -->
    <div class="cart-title">
      <h3><?php echo $lang['pointcart_step1_chooseprod'];?></h3>
    </div>
    <!-- 已经选择礼品start -->
    
    <table class="buy-table">
      <thead>
        <tr>
          <th colspan="2"><?php echo $lang['pointcart_step1_goods_info'];?>
            <hr/></th>
          <th class="w120"><?php echo $lang['pointcart_step1_goods_point'];?>
            <hr/></th>
          <th class="w120"><?php echo $lang['pointcart_step1_goods_num'];?>
            <hr/></th>         
        </tr>
      </thead>
      <tbody>
        <?php 
	  			if(is_array($output['pointprod_arr']['pointprod_list']) and count($output['pointprod_arr']['pointprod_list'])>0) {
				foreach($output['pointprod_arr']['pointprod_list'] as $val) {
			?>
        <tr>
          <td class="w70"><div class="cart-goods-pic"><span class="thumb size60"><i></i><a href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$val['pgoods_id']; ?>" target="_blank"><img src="<?php echo $val['pgoods_image_new']; ?>" onerror="this.src='<?php echo defaultGoodsImage('tiny');?>'" alt="<?php echo $val['pgoods_name']; ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
          <td class="tl vt"><dl class="cart-goods-info">
              <dt class="cart-goods-info-name"><a target="_blank" href="<?php echo SiteUrl.DS.'index.php?act=pointprod&op=pinfo&id='.$val['pgoods_id']; ?>"><?php echo $val['pgoods_name']; ?></a></dt>
            </dl></td>
          <td><span class="money"><?php echo $val['onepoints']; ?><?php echo $lang['points_unit']; ?></span></td>
          <td><?php echo $val['quantity']; ?></td>
        </tr>
        <?php } }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><label><?php echo $lang['pointcart_step1_message'];?>
              <input type="text" class="w400 text" onclick="pcart_messageclear(this);" value="<?php echo $lang['pointcart_step1_message_advice'];?>" />
            </label></td>
          <td class="tc"><?php if ($output['pointprod_arr']['pgoods_freightcharge'] == true){ ?><?php echo $lang['pointcart_shipfee'];?><?php } ?></td>
          <td class="tc"><?php if ($output['pointprod_arr']['pgoods_freightcharge'] == true){ ?>
            <?php echo $lang['currency'];?><?php echo $output['pointprod_arr']['pgoods_freightall']; ?>
            <?php } ?></td>
        </tr>
      </tfoot>
    </table>
    <!-- 已经选择礼品end --> 

    <!-- 订单金额统计start -->
    <div class="cart-bottom">
      <div class="confirm-popup">
        <div class="confirm-box">
          <dl>
            <dt><?php echo $lang['pointcart_cart_allpoints'].$lang['nc_colon'];?>
            <dt>
            <dd><span class="cart-point-b mr5"><?php echo $output['pointprod_arr']['pgoods_pointall']; ?></span><?php echo $lang['points_unit']; ?></dd>
          </dl>
          <dl>
            <dt><?php echo $lang['pointcart_step2_prder_trans_to'].$lang['nc_colon'];?></dt>
            <dd id="confirm_address"></dd>
          </dl>
          <dl>
            <dt><?php echo $lang['pointcart_step2_prder_trans_receive'].$lang['nc_colon'];?></dt>
            <dd id="confirm_buyer"></dd>
          </dl>
        </div>
      </div>
      <p><a href="index.php?act=cart" class="cart-back-button mr10"><?php echo $lang['pointcart_step1_return_list'];?></a><a href="javascript:void($('#porder_form').submit());" class="cart-button"><?php echo $lang['pointcart_step1_submit'];?></a></p>
    </div>
    <!-- 订单金额统计end --> 
  </div>
</form>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript">
	//<![CDATA[
	var SITE_URL = "<?php echo SiteUrl; ?>";
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
    <?php if (empty($output['address_list'])){?>
    //弹出填写收货地址
		shownewaddress();
	<?php } ?>
	function pcart_messageclear(tt){
		if (!tt.name)
		{
			tt.value    = '';
			tt.name = 'pcart_message';
		}
	}
	function shownewaddress(){
		var addr_id = $("input[name='address_options']:checked").val();
	    ajax_form('newaddressform','<?php echo $lang['pointcart_step1_new_address'];?>', SITE_URL + '/index.php?act=cart&op=newaddress&addr_id='+addr_id,740);
	    return false;
	}
	function getTransport(){
		//显示寄送至
        var _select = $('.selected_address').find('li').eq(1);
        $('#confirm_address').html($(_select).attr('address'));
        $('#confirm_buyer').html($(_select).attr('buyer'));
	}
	getTransport();   
</script>