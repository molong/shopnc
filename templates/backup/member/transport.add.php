<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo TEMPLATES_PATH;?>/css/transport.css" rel="stylesheet" type="text/css">
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?></div>
  <div class="ncu-form-style">
    <div id="dialog_batch" class="ks-ext-position ks-overlay ks-dialog dialog-batch" style="left: 0px; top:0px; z-index: 9999;display:none">
      <div class="ks-contentbox">
        <div class="ks-stdmod-header"></div>
        <div class="ks-stdmod-body">
          <form method="post">
            <?php echo $lang['transport_note_1'].$lang['nc_colon'];?>
            <input class="w50 text" type="text" maxlength="4" autocomplete="off" data-field="start" value="1" name="express_start">
            <?php echo $lang['transport_note_2'];?>
            <input class="w50 text" type="text" maxlength="6" autocomplete="off" value="0.00" name="express_postage" data-field="postage">
            <?php echo $lang['transport_note_3'];?>
            <input class="w50 text" type="text" maxlength="4" autocomplete="off" value="1" data-field="plus" name="express_plus">
            <?php echo $lang['transport_note_4'];?>
            <input class="w50 text" type="text" maxlength="6" autocomplete="off" value="0.00" data-field="postageplus" name="express_postageplus">
            <?php echo $lang['transport_note_5'];?>
            <div class="J_DefaultMessage"></div>
            <div class="btns">
              <button class="J_SubmitPL" type="button"><?php echo $lang['transport_tpl_ok'];?></button>
              <button class="J_Cancel" type="button"><?php echo $lang['transport_tpl_cancel'];?></button>
            </div>
          </form>
        </div>
        <div class="ks-stdmod-footer"></div>
        <a class="ks-ext-close" href="javascript:void(0)"> <span class="ks-ext-close-x">X</span> </a> </div>
    </div>
    <form method="post" id="tpl_form" name="tpl_form" action="index.php?act=transport&op=save">
      <input type="hidden" name="transport_id" value="<?php echo $output['transport']['id'];?>" />
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="type" value="<?php echo $_GET['type'];?>">
      <div class="postage-tpl-head">
        <ul>
          <li class="form-elem">
            <label for="J_TemplateTitle" class="label-like"><?php echo $lang['transport_tpl_name'].$lang['nc_colon'];?></label>
            <input type="text"  class="text"  id="title" autocomplete="off"  value="<?php echo $output['transport']['title'];?>" name="title">
            <p class="msg" style="display:none" error_type="title"> <span class="error"><?php echo $lang['transport_tpl_name_note'];?></span> </p>
            <!--  <li class="form-elem"> <span class="label-like">发货地址：</span> <span id="J_AddressField"> 北京北京市东城区红旗路220号
    <input type="hidden" value="110101" name="code">
    <input type="hidden" value="北京北京市东城区红旗路220号" name="addr">
    <input type="hidden" value="20439393" name="uid">
    </span> <a aria-haspopup="true" aria-controls="J_DialogAddress" data-acc="event:enter" class="acc_popup" id="J_ChangeAddress" href="javascript:void(0)">修改地址</a> </li>--> 
            <!--  <li class="form-elem calc-method"> <span class="label-like">计价方式：</span> <span>
    <input type="radio" id="J_CalcRuleNumber" data-type="number" class="J_CalcRule" value="0" checked="" name="valuation">
    <label for="J_CalcRuleNumber">&nbsp;按件数</label>
    </span>--> 
          </li>
          <li class="form-elem express"> <span class="label-like"><?php echo $lang['transport_type'].$lang['nc_colon'];?></span> <span class="field-note"><?php echo $lang['transport_type_description']?></span>
            <p class="msg" style="display:none" error_type="trans_type"> <span class="error"><?php echo $lang['transport_type_note'];?></span> </p>
          </li>
        </ul>
      </div>
      <!-----------------------POST begin--------------------------------------->
      <div class="postage-tpl">
        <p class="trans-line">
          <input id="Deliverypy" type="checkbox" value="py" name="tplType[]">
          <label for="Deliverypy"><?php echo $lang['transport_type_py'];?></label>
        </p>
      </div>
      <!-----------------------EXPRESS begin--------------------------------------->
      <div class="postage-tpl">
        <p class="trans-line">
          <input id="Deliverykd" type="checkbox" value="kd" name="tplType[]">
          <label for="Deliverykd"><?php echo $lang['transport_type_kd'];?></label>
        </p>
      </div>
      <!-----------------------EMS begin--------------------------------------->
      <div class="postage-tpl">
        <p class="trans-line">
          <input id="Deliveryes" type="checkbox" value="es" name="tplType[]">
          <label for="Deliveryes">EMS</label>
        </p>
      </div>
      <!-----------------------EMS end--------------------------------------->
      <div class="trans-submit">
        <input type="submit" id="submit_tpl"  class="submit" value="<?php echo $lang['transport_tpl_save'];?>" />
      </div>
    </form>
    
  </div>
  <div class="ks-ext-mask" style="position: absolute; left: 0px; top: 0px; width: 100%; height: 5000px; z-index: 9998;display:none"></div>
</div>
<div id="dialog_areas" class="ks-ext-position ks-overlay ks-dialog dialog-areas" style="left: 112px; top: 307.583px; z-index: 9999;display:none">
  <div class="ks-contentbox">
    <div class="ks-stdmod-header">
      <div class="title"><?php echo $lang['transport_tpl_select_area'];?></div>
    </div>
    <div class="ks-stdmod-body">
      <form method="post">
        <ul id="J_CityList">
          <?php require(template('member/transport_area_'.(strtolower(CHARSET)=='utf-8'?'utf-8':'gbk')));?>
        </ul>
        <div class="btns">
          <button class="J_Submit" type="button"><?php echo $lang['transport_tpl_ok'];?></button>
          <button class="J_Cancel" type="button"><?php echo $lang['transport_tpl_cancel'];?></button>
        </div>
      </form>
    </div>
    <div class="ks-stdmod-footer"> <a class="ks-ext-close" href="javascript:void(0)"><span class="ks-ext-close-x">X</span></a></div>
  </div>
</div><script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/transport.js" charset="utf-8"></script>
<script>
$(function(){
	$('div[class="postage-tpl"]').each(function(){
		var tplType = $(this).find('input[name="tplType[]"]').attr('value');
		<?php if (is_array($output['tpltype'])){?>
			<?php foreach ($output['tpltype'] as $v) {?>
				if (tplType=='<?php echo $v;?>'){
					$('#Delivery<?php echo $v;?>').attr('checked',true); $('#Delivery<?php echo $v;?>').click().attr('checked',true);
					$(this).find('.tbl-except').append(RuleHead);
					<?php if (is_array($output['extend'])){?>
					<?php foreach ($output['extend'] as $value){?>

					if (tplType=='<?php echo $value['type'];?>'){

						<?php if ($value['is_default']==1){?>
							
							var cur_tr = $(this).find('.tbl-except').prev();
							$(cur_tr).find('input[data-field="start"]').val('<?php echo $value['snum'];?>');
							$(cur_tr).find('input[data-field="postage"]').val('<?php echo $value['sprice'];?>');
							$(cur_tr).find('input[data-field="plus"]').val('<?php echo $value['xnum'];?>');
							$(cur_tr).find('input[data-field="postageplus"]').val('<?php echo $value['xprice'];?>');							
						
						<?php }else{?>
							
							StartNum +=1;
							cell = RuleCell.replace(/CurNum/g,StartNum); 
							cell = cell.replace(/TRANSTYPE/g,'<?php echo $v;?>');
							$(this).find('.tbl-except').find('table').append(cell);
							$(this).find('.J_ToggleBatch').css('display','').html('<?php echo $lang['transport_tpl_pl_op'];?>');
							
							var cur_tr = $(this).find('.tbl-except').find('table').find('tr:last');
							$(cur_tr).find('.area-group>p').html('<?php echo $value['area_name'];?>');
							$(cur_tr).find('input[type="hidden"]').val('<?php echo trim($value['area_id'],',');?>|||<?php echo $value['area_name'];?>');
							$(cur_tr).find('input[data-field="start"]').val('<?php echo $value['snum'];?>');
							$(cur_tr).find('input[data-field="postage"]').val('<?php echo $value['sprice'];?>');
							$(cur_tr).find('input[data-field="plus"]').val('<?php echo $value['xnum'];?>');
							$(cur_tr).find('input[data-field="postageplus"]').val('<?php echo $value['xprice'];?>');
						
						<?php }?>
					}
					<?php }?>
					<?php }?>

				}
			<?php }?>
		<?php }?>
	});
});
</script>