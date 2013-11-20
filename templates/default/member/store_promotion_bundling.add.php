<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.ajaxContent.pack.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<style>
.pic_list .small_pic ul li {
	height: 100px;
}
.ui-sortable-helper {
	border: dashed 1px #F93;
	box-shadow: 2px 2px 2px rgba(153,153,153, 0.25);
	filter: alpha(opacity=75); -moz-opacity: 0.75; opacity: .75; 
	cursor: ns-resize;
}
.ui-sortable-helper td {
	background-color: #FFC !important;
}
.ajaxload { display: block; width:16px; height:16px; margin: 100px 300px;}
.norecord { padding: 30px 0 30px 180px !important;}
</style>
<input id="level2_flag" type="hidden" value="false" />
<input id="level3_flag" type="hidden" value="false" />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncm-notes mt10">
    <h3><?php echo $lang['nc_explain'].$lang['nc_colon'];?></h3>
    <ul>
      <?php if(intval(C('promotion_bundling_sum')) != 0){?>
      <li><?php printf($lang['bundling_add_explain1'], C('promotion_bundling_sum'), C('promotion_bundling_goods_sum'));?></li>
      <?php }else{?>
      <li><?php printf($lang['bundling_add_explain2'], C('promotion_bundling_goods_sum'));?></li>
      <?php }?>
    </ul>
  </div>
  <div class="ncu-form-style"> 
    <!-- 说明 -->
    
    <form id="add_form" method="post" action="index.php?act=store_promotion_bundling&op=bundling_add">
      <input type="hidden" name="form_submit" value="ok" />
      <?php if (!empty($output['bundling_info'])){?>
      <input type="hidden" name="bundling_id" value="<?php echo $output['bundling_info']['bl_id'];?>" />
      <?php }?>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['bundling_name'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="bundling_name" name="bundling_name" type="text" maxlength="25" class="w400 text" value="<?php echo $output['bundling_info']['bl_name'];?>" />
            <span></span> </p>
          <p class="hint"><?php echo $lang['bundling_name_explain'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['bundling_goods'].$lang['nc_colon'];?></dt>
        <dd>
          <p><input id="bundling_goods" type="hidden" value="" name="bundling_goods">
			<span></span></p>
          <table class="ncu-table-style">
            <thead>
              <tr>
                <th class="w10"></th>
                <th class="w70"><?php echo $lang['bundling_goods'];?></th>
                <th><?php echo $lang['bundling_show_name'];?></th>
                <th class="w90"><?php echo $lang['bundling_cost_price'];?></th>
                <th class="w90"><?php echo $lang['bundling_operate'];?></th>
              </tr>
            </thead>
            <tbody nctype="bundling_data"  class="bd-line tip" title="<?php echo $lang['bundling_add_goods_explain'];?>">
              <?php if(!empty($output['b_goods_list']) && is_array($output['b_goods_list'])){?>
              <?php $old_array_id = array(); foreach($output['b_goods_list'] as $val){ $old_array_id[] = $val['goods_id'];?>
              <tr id="bundling_tr_<?php echo $val['goods_id']?>" class="off-shelf">
                <input type="hidden" value="<?php echo $val['bl_goods_id'];?>" name="goods[<?php echo $val['goods_id'];?>][bundling_goods_id]" />
                <input type="hidden" value="<?php echo $val['goods_id'];?>" name="goods[<?php echo $val['goods_id'];?>][goods_id]" nctype="goods_id">
                <input type="hidden" value="<?php echo $val['goods_image'];?>" name="img_more[]">
                <td class="w10"></td>
                <td class="w70"><div class="goods-pic-small pr"><span class="thumb size60"><i></i><img src="<?php echo cthumb($val['goods_image'], 'tiny', $_SESSION['store_id']);?>" ncname="<?php echo $val['goods_image'];?>" nctype="bundling_data_img" onload="javascript:DrawImage(this,60,60);" ></span><?php if($val['goods_show'] != 1){?><em class="ico"></em><?php }?></div></td>
                <td class="w340 tl"><p><input type="text" value="<?php echo $val['goods_name'];?>" name="goods[<?php echo $val['goods_id'];?>][goods_name]" class="text w300"></p>
                <?php if($val['goods_show'] != 1){?><p class="note"><?php echo $lang['bundling_add_goods_show_note'];?></p></td><?php }?>
                <td class="w90 goods-price" nctype="bundling_data_price"><?php echo $val['goods_store_price'];?></td>
                <td class="w90"><a onclick="bundling_operate_delete($('#bundling_tr_<?php echo $val['goods_id']?>'), <?php echo $val['goods_id']?>)" href="JavaScript:void(0);" class="ncu-btn2"><?php echo $lang['bundling_goods_remove'];?></a></td>
              </tr>
              <?php }?>
            <input type="hidden" name="old_array_id" value="<?php echo implode(',', $old_array_id);?>" />
            <?php }?>
              </tbody>
            
          </table>
          <p></p>
          <p id="bundling_add_goods_ajaxContent"></p>
          <p><a id="bundling_add_goods" href="index.php?act=store_promotion_bundling&op=bundling_add_goods" class="ncu-btn6 mt10"><?php echo $lang['bundling_goods_add'];?></a></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['bundling_add_price'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="discount_price" name="discount_price" type="text" class="text tip2 w60 mr5" value="<?php echo $output['bundling_info']['bl_discount_price'];?>" title="<?php echo $lang['bundling_add_price_title'];?>"/>
            <?php echo $lang['currency_zh'];?> <span></span> </p>
          <p class="hint mt10"><?php echo $lang['bundling_cost_price'];?><span nctype="cost_price" class="price mr5 ml5"><?php echo $output['bundling_info']['bl_cost_price'];?></span><?php echo $lang['currency_zh'].$lang['bundling_cost_price_note'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><?php echo $lang['bundling_add_img'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="bundling-pic-list tip" title="<?php echo $lang['bundling_add_pic_list_tip'];?>">
              <ul id="goods_images">
                <?php for($i=0;$i<5;$i++){?>
                <li nc_type="handle_pic" id="thumbnail_<?php echo $i;?>">
                <div nctype="drop_image" class="delete" id="<?php echo $i;?>" title="<?php echo $lang['nc_del'];?>"></div>
                  <div class="picture"><span class="thumb size60"><i></i>
                    <input type="hidden" name="image_path[]" nctype="bundling_pic_input" value="<?php echo $output['bundling_info']['bl_img_more'][$i];?>" />
                    <img nctype="bundling_pic_img" src="<?php echo isset($output['bundling_info']['bl_img_more'][$i]) && $output['bundling_info']['bl_img_more'][$i] != ''? cthumb($output['bundling_info']['bl_img_more'][$i], 'tiny', $_SESSION['store_id']):defaultGoodsImage(tiny);?>" onload="javascript:DrawImage(this,60,60);"/> </span></div>
                 
                </li>
                <?php } ?>
              </ul>
          </div>
          <p class="info-album"> <a class="albun_demo" href="index.php?act=store_album&op=pic_list&item=bundling_add"><?php echo $lang['bundling_add_form_album'];?></a> </p>
          <p id="albun_demo"></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['bundling_add_freight_method'].$lang['nc_colon'];?></dt>
        <dd>
          <label for="whops_seller"><input id="whops_seller" type="radio" name="bundling_freight_choose" <?php if(!isset($output['bundling_info']) || $output['bundling_info']['bl_freight_choose'] == '1'){ ?>checked="checked"<?php }?> value="1" /><?php echo $lang['bundling_add_freight_method_seller'];?></label>&nbsp;&nbsp;
          <label for="whops_buyer"><input id="whops_buyer" type="radio" name="bundling_freight_choose" <?php if(isset($output['bundling_info']) && $output['bundling_info']['bl_freight_choose'] == '0'){ ?>checked="checked"<?php }?> value="0" /><?php echo $lang['bundling_add_freight_method_buyer'];?></label>
          <div id="whops_buyer_box" class="transport_tpl" style="<?php if(!isset($output['bundling_info']) || $output['bundling_info']['bl_freight_choose'] == '1'){ ?>display:none;<?php }?>"><ul style="line-height:30px"><li><input class="w50 text" type="text" name="bundling_freight" value="<?php echo $output['bundling_info']['bl_freight'];?>" />&nbsp;<?php echo $lang['currency_zh'];?></li></ul></div>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['bundling_add_desc'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <?php showEditor('bundling_desc',$output['bundling_info']['bl_desc'],'100%','400px','visibility:hidden;',"false",$output['editor_multimedia']);?>
          </p>
          <p class="info-album"><a class="des_demo" href="index.php?act=store_album&op=pic_list&item=bundling_add_desc"><?php echo $lang['bundling_add_form_album_to_desc'];?></a></p>
          <p id="des_demo"></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['bundling_status'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <label for="bundling_status_1">
              <input type="radio" name="state" value="1" id="bundling_status_1" <?php if(!isset($output['bundling_info']) || $output['bundling_info']['bl_state'] == 1) echo 'checked="checked"'; ?> />
              <?php echo $lang['bundling_status_1'];?></label>
            <label for="bundling_status_0">
              <input type="radio" name="state" value="0" id="bundling_status_0" <?php if(isset($output['bundling_info']) && $output['bundling_info']['bl_state'] == 0) echo 'checked="checked"'; ?> />
              <?php echo $lang['bundling_status_0'];?></label>
          </p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>"  class="submit">
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/store_bundling.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.poshytip.min.js" charset="utf-8"></script> 
<script type="text/javascript">
var DEFAULT_GOODS_IMAGE = '<?php echo defaultGoodsImage('tiny');?>';
$(document).ready(function(){
		jQuery.validator.addMethod('bundling_goods', function(value, element){
			return $('tbody[nctype="bundling_data"] > tr').length >0?true:false;
		});
	//Ajax提示
$('.tip').poshytip({
	className: 'tip-yellowsimple',
	showTimeout: 1,
	alignTo: 'target',
	alignX: 'left',
	alignY: 'top',
	offsetX: 5,
	offsetY: -78,
	allowTipHover: false
});
$('.tip2').poshytip({
	className: 'tip-yellowsimple',
	showTimeout: 1,
	alignTo: 'target',
	alignX: 'right',
	alignY: 'center',
	offsetX: 5,
	offsetY: 0,
	allowTipHover: false
});
	    //页面输入内容验证
	    $("#add_form").validate({
	        errorPlacement: function(error, element){
	            var error_td = element.parent('p').children('span');
	            error_td.find('.field_notice').hide();
	            error_td.append(error);
	        },
	     	submitHandler:function(form){
	    		ajaxpost('add_form', '', '', 'onerror')
	    	},
	            rules : {
	                bundling_name : {
	                    required : true
	                },
	                bundling_goods : {
						bundling_goods : true
			        },
	                discount_price : {
						required : true,
						number : true
		            }
	            },
	            messages : {
	                bundling_name : {
	                    required : '<?php echo $lang['bundling_add_name_error'];?>'
	                },
	                bundling_goods : {
	                	bundling_goods : '<?php echo $lang['bundling_add_goods_error'];?>'
		            },
	                discount_price : {
						required : '<?php echo $lang['bundling_add_price_error_null'];?>',
						number : '<?php echo $lang['bundling_add_price_error_not_num'];?>'
		            }
                
	            }
	    });

		$('input[name="bundling_freight_choose"]').click(function(){
			if($(this).val() == '0'){
				$('#whops_buyer_box').show();
			}else{
				$('#whops_buyer_box').hide();
			}
		});

	    <?php if(!empty($output['bundling_info'])){?>
	    count_cost_price_sum(); // 计算商品原价
	    <?php }?>
});



/* 选择套餐图片 */
function bundling_insert(file_path, file_name){
	$('input[nctype="bundling_pic_input"]').each(function(e){
		if($(this).val() == ''){
			if(e == 5) {alert('<?php echo $lang['bundling_add_not_add_img'];?>');return false;}
			$(this).val(file_name);
			$('img[nctype="bundling_pic_img"]:eq('+e+')').attr('src', file_path);
			$.getScript('./resource/js/store_bundling.js');
			return false;
		}
	});
}

/* 删除商品 */
function bundling_operate_delete(o , id){
	o.remove();
	$('tr[goods_id="'+id+'"]').children(':last').html('<a href="JavaScript:void(0);" onclick="bundling_goods_add($(this))" class="ncu-btn7"><?php echo $lang['bundling_goods_add_bundling'];?></a>')
	count_cost_price_sum();
}
</script>