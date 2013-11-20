<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">.ncu-table-style tbody td { padding: 6px; text-align: left;}</style>

<div class="wrap">

  <div class="step-title"><em><?php echo $lang['store_deliver_first_step'];?></em><?php echo $lang['store_deliver_confirm_trade'];?></div>
  <form name="deliver_form" method="POST" id="deliver_form" action="index.php?act=deliver&op=send" onsubmit="ajaxpost('deliver_form', '', '', 'onerror');return false;">
    <input type="hidden" value="ok" name="form_submit">
    <input type="hidden" value="<?php echo $_GET['order_id'];?>" name="order_id">
    <input type="hidden" id="shipping_express_id" value="<?php echo $output['order_array']['shipping_express_id'];?>" name="shipping_express_id">
    <input type="hidden" value="<?php echo $output['order_array']['true_name'];?>" name="strue_name" id="strue_name">
    <input type="hidden" value="<?php echo $output['order_array']['area_info'];?>" name="sarea_info" id="sarea_info">
    <input type="hidden" value="<?php echo $output['order_array']['address'];?>" name="saddress" id="saddress">
    <input type="hidden" value="<?php echo $output['order_array']['zip_code'];?>" name="szip_code" id="szip_code">
    <input type="hidden" value="<?php echo $output['order_array']['tel_phone'];?>" name="stel_phone" id="stel_phone">
    <input type="hidden" value="<?php echo $output['order_array']['mob_phone'];?>" name="smob_phone" id="smob_phone">
    <table class="ncu-table-style order deliver">
      <?php if (is_array($output['order_array']) and !empty($output['order_array'])) { ?>
      <tbody>
        <tr>
          <td colspan="20" class="sep-row"></td>
        </tr>
        <tr>
          <th colspan="20"><a href="index.php?act=member_orderprint&order_id=<?php echo $output['order_array']['order_id'];?>" target="_blank" class="fr" title="<?php echo $lang['store_show_order_printorder'];?>"/><i class="print-order"></i></a><span class="fr mr30"></span><span class="ml5"><?php echo $lang['store_order_order_sn'].$lang['nc_colon'];?><span class="goods-num"><?php echo $output['order_array']['order_sn']; ?></span> <span class="ml20"><?php echo $lang['store_order_add_time'].$lang['nc_colon'];?><em class="goods-time"><?php echo date("Y-m-d H:i:s",$output['order_array']['add_time']); ?></em></span> 
        </tr>
        <?php foreach((array)$output['goods_array'] as $k=>$v) { ?>
        <tr>
          <td class="bdl w10"></td>
          <td class="w70"><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="?act=goods&goods_id=<?php echo $v['goods_id'];?>&id=<?php echo  $output['order_array']['store_id'];?>" target="_blank"><img src="<?php echo cthumb($v['goods_image'],'tiny',$output['order_array']['store_id']); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
          <td class="tl goods-info"><dl>
              <dt><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $v['goods_id']; ?>"><?php echo $v['goods_name']; ?></a></dt>
              <dd><?php echo str_replace(':', $lang['nc_colon'], $v['spec_info']); ?></dd>
              <dd class="tr"><?php echo $v['goods_price']; ?>&nbsp;x&nbsp;<?php echo $v['goods_num']; ?></dd>
            </dl></td>
          <?php if ((count($output['goods_array']) > 1 && $k ==0) || (count($output['goods_array']) == 1)){?>
          <td class="bdl bdr order-info w380" rowspan="<?php echo count($output['goods_array']);?>"><dl>
              <dt><?php echo $lang['store_deliver_shipping_sel'].$lang['nc_colon'];?></dt>
              <dd>
              <?php if (!empty($output['order_array']['shipping_fee']) && $output['order_array']['shipping_fee'] != '0.00'){?>
              <?php echo $output['order_array']['shipping_name'];?> (<?php echo $output['order_array']['shipping_fee'];?>)
              <?php }else{?>
              <?php echo $lang['nc_common_shipping_free'];?>
              <?php }?>
              </dd>
            </dl>
            <dl>
              <dt><?php echo $lang['store_deliver_forget'].$lang['nc_colon'];?></dt>
              <dd>
                <textarea name="deliver_explain" cols="100" rows="2" class="w250 tip-t" title="<?php echo $lang['store_deliver_forget_tips'];?>"><?php echo $output['order_array']['deliver_explain'];?></textarea>
              </dd>
            </dl></td>
          <?php }?>
        </tr>
        <?php }?>
        <tr>
          <td colspan="20" class="tl bdl bdr" style="padding:8px" id="address"><strong class="fl"><?php echo $lang['store_deliver_buyer_adress'].$lang['nc_colon'];?></strong><?php echo $output['order_array']['area_info'];?>&nbsp;<?php echo $output['order_array']['address'];?>&nbsp;<?php echo $output['order_array']['zip_code'];?>&nbsp;<?php echo $output['order_array']['true_name'];?>&nbsp;<?php echo $output['order_array']['tel_phone'];?>&nbsp;<?php echo $output['order_array']['mob_phone'];?><a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['store_deliver_modfiy_address'];?>" dialog_id="my_address_edit" uri="index.php?act=deliver&op=buyer_address&order_id=<?php echo encrypt($output['order_array']['order_id'],md5(1));?>" dialog_width="550" class="fr"><?php echo $lang['store_deliver_modfiy_address'];?></a></td>
        </tr>
        <?php } else { ?>
        <tr>
          <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="step-title mt30"><em><?php echo $lang['store_deliver_second_step'];?></em><?php echo $lang['store_deliver_confirm_daddress'];?></div>
    <div class="deliver-sell-info" id="daddress"><strong class="fl"><?php echo $lang['store_deliver_my_daddress'].$lang['nc_colon'];?></strong>
      <?php if (is_null($output['daddress_info'])){?>
      <span class="fl"><?php echo $lang['store_deliver_none_set'];?></span><a title="<?php echo $lang['store_deliver_add_daddress'];?>" dialog_width="550" uri="index.php?act=deliver&op=pop_address" dialog_id="my_address_add" dialog_title="<?php echo $lang['store_deliver_add_daddress'];?>" nc_type="dialog" href="javascript:void(0)" class="fr"><?php echo $lang['store_deliver_add_daddress'];?></a>
      <?php }else{?>
      <a href="javascript:void(0);" onclick="ajax_form('modfiy_daddress', '<?php echo $lang['store_deliver_select_daddress'];?>', 'index.php?act=deliver&op=pop_address&type=select', 640,0);" class="fr"><?php echo $lang['store_deliver_select_ather_daddress'];?></a> <?php echo $output['daddress_info']['area_info'];?>&nbsp;<?php echo $output['daddress_info']['address'];?>&nbsp;<?php echo $output['daddress_info']['zip_code'];?>&nbsp;<?php echo $output['daddress_info']['seller_name'];?>&nbsp;<?php echo $output['daddress_info']['tel_phone'];?>&nbsp;<?php echo $output['daddress_info']['mob_phone'];?>
      <?php }?>
    </div>
    <input type="hidden" name="daddress_id" id="daddress_id" value="<?php echo $output['daddress_info']['address_id'];?>">
    <div class="step-title mt30"><em><?php echo $lang['store_deliver_third_step'];?></em><?php echo $lang['store_deliver_express_select'];?></div><div class="ncm-notes"><i class="lightbulb"></i><?php echo $lang['store_deliver_express_note'];?></div>
    <div class="tabmenu">
      <ul class="tab pngFix">
        <li id="eli1" class="active"><a href="javascript:void(0);" onclick="etab(1)"><?php echo $lang['store_deliver_express_zx'];?></a></li>
        <li id="eli2" class="normal"><a href="javascript:void(0);" onclick="etab(2)"><?php echo $lang['store_deliver_express_wx'];?></a></li>
      </ul>
    </div>
    <table class="ncu-table-style order" id="texpress1">
      <tbody>
        <tr>
          <td class="bdl w150"><?php echo $lang['store_deliver_company_name'];?></td>
          <td class="w250"><?php echo $lang['store_deliver_shipping_code'];?></td>
          <td class="tc"><?php echo $lang['store_deliver_bforget'];?></td>
          <td class="bdr w90 tc"><?php echo $lang['nc_common_button_operate'];?></td>
        </tr>
        <?php if (is_array($output['my_express_list']) && !empty($output['my_express_list'])){?>
        <?php foreach ($output['my_express_list'] as $k=>$v){?>
        <tr>
          <td class="bdl"><?php echo $output['express_list'][$v]['e_name'];?></td>
          <td class="bdl"><input nc_type='eb' nc_value="<?php echo $v;?>" name="shipping_code" type="text" class="text w200 tip-r" title="<?php echo $lang['store_deliver_shipping_code_tips'];?>" /></td>
          <td class="bdl gray" nc_value="<?php echo $v;?>"></td>
          <td class="bdl bdr tc"><a nc_type='eb' nc_value="<?php echo $v;?>" href="javascript:void(0);" class="ncu-btn2"><?php echo $lang['nc_common_button_confirm'];?></a></td>
        </tr>
        <?php }?>
        <?php }?>
      </tbody>
    </table>
    <table class="ncu-table-style order" id="texpress2" style="display:none">
      <tbody>
        <tr>
          <td colspan="2"></td>
        </tr>
        <tr>
          <td class="bdl tr"><i class="lightbulb"></i><?php echo $lang['store_deliver_no_deliver_tips'];?></td>
          <td class="bdr tl w250"><a nc_type='eb' nc_value="e1000" href="javascript:void(0);" class="ncu-btn6"><?php echo $lang['nc_common_button_confirm'];?></a></td>
        </tr>
        <tr>
          <td colspan="2"></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.poshytip.min.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
function etab(t){
	if (t==1){
		$('#eli1').removeClass('normal').addClass('active');
		$('#eli2').removeClass('active').addClass('normal');
		$('#texpress1').css('display','');
		$('#texpress2').css('display','none');
	}else{
		$('#eli1').removeClass('active').addClass('normal');
		$('#eli2').removeClass('normal').addClass('active');
		$('#texpress1').css('display','none');
		$('#texpress2').css('display','');
	}
}
$(function(){
	//表单提示
	$('.tip-t').poshytip({
		className: 'tip-yellowsimple',
		showOn: 'focus',
		alignTo: 'target',
		alignX: 'center',
		alignY: 'top',
		offsetX: 0,
		offsetY: 2,
		allowTipHover: false
	});
	$('.tip-r').poshytip({
		className: 'tip-yellowsimple',
		showOn: 'focus',
		alignTo: 'target',
		alignX: 'right',
		alignY: 'center',
		offsetX: -50,
		offsetY: 0,
		allowTipHover: false
	});
	$('a[nc_type="eb"]').live('click',function(){
		if ($('input[nc_value="'+$(this).attr('nc_value')+'"]').val() == ''){
			alert('<?php echo $lang['store_deliver_shipping_code_pl'];?>');return false;
		}
		$('input[nc_type="eb"]').attr('disabled',true);
		$('input[nc_value="'+$(this).attr('nc_value')+'"]').attr('disabled',false);
		$('#shipping_express_id').val($(this).attr('nc_value'));
		$('#deliver_form').submit();
	});

    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('.checkall_s').click(function(){
        var if_check = $(this).attr('checked');
        $('.checkitem').each(function(){
            if(!this.disabled)
            {
                $(this).attr('checked', if_check);
            }
        });
        $('.checkall_s').attr('checked', if_check);
    });
    <?php if ($output['order_array']['shipping_code'] != ''){?>
    	$('input[nc_value="<?php echo $output['order_array']['shipping_express_id'];?>"]').val('<?php echo $output['order_array']['shipping_code'];?>');
    	$('td[nc_value="<?php echo $output['order_array']['shipping_express_id'];?>"]').html('<?php echo $output['order_array']['deliver_explain'];?>');
    <?php } ?>
});
</script> 
