<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form id="add_form" action="index.php?act=store_groupbuy&op=groupbuy_save" method="post" enctype="multipart/form-data">
      <input name="group_id" type="hidden" value="<?php echo $output['group_info']['group_id'];?>"/>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['group_template'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <select id="input_groupbuy_template" name="input_groupbuy_template">
              <?php foreach($output['template_list'] as $groupbuy_template) { ?>
              <option value="<?php echo $groupbuy_template['template_id'];?>" <?php if($output['group_info']['template_id'] == $groupbuy_template['template_id']) echo 'selected'; ?>><?php echo $groupbuy_template['template_name'].'('.date('Y/m/d',$groupbuy_template['start_time']).'-'.date('Y/m/d',$groupbuy_template['end_time']).')';?></option>
              <?php } ?>
            </select>
            <span></span></p>
          <p class="hint"><?php echo $lang['group_template_tip'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['group_name'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="w400 text" name="input_group_name" type="text" id="input_group_name" value="<?php echo $output['group_info']['group_name'];?>" maxlength="30"  />
            <span></span> </p>
          <span></span>
          <p class="hint"><?php echo $lang['group_name_tip'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['groupbuy_goods'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="w400 text" style=" cursor: pointer;" id="input_goods_name" name="input_goods_name" gs_id="input_goods_id" gs_name="input_goods_name" gs_callback="gs_callback" gs_title="<?php echo $lang['group_goods_sel'];?>" gs_width="480" gs_op="get_select_goods"  nc_type="gselector" type="text" value="<?php echo $output['group_info']['goods_name'];?>" readonly/>
            <span></span></p>
          <p class="hint"><?php echo $lang['groupbuy_goods_explain'];?></p>
          <input id="input_goods_id" name="input_goods_id" type="hidden" value="<?php echo $output['group_info']['goods_id'];?>"/>
        </dd>
      </dl>
      <dl class="groupbuy_goods_info">
        <dt><?php echo $lang['groupbuy_index_store_price'].$lang['nc_colon'];?></dt>
        <dd> <?php echo $lang['currency'];?> <span id="goods_store_price" ></span> </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['groupbuy_price'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="w60 text" id="input_groupbuy_price" name="input_groupbuy_price" type="text" value="<?php echo $output['group_info']['groupbuy_price'];?>"/>
            <span></span> </p>
          <p class="hint"><?php echo $lang['groupbuy_price_tip'];?></p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['group_pic'].$lang['nc_colon'];?></dt>
        <dd> <img src="<?php if(empty($output['group_info']['group_pic'])){ echo TEMPLATES_PATH.'/images/transparent.gif';}else{ echo SiteUrl.'/upload/groupbuy/'.$output['group_info']['group_pic'];}?>"  onload="javascript:DrawImage(this,480,350);" nc_type="group_pic" />
          <p>
            <input  type="file" id="input_group_pic" name="input_group_pic" nc_type="change_group_pic"/>
            <span></span> </p>
          <p class="hint"><?php echo $lang['group_pic_explain'];?></p>
        </dd>
      </dl>
      <dl class="groupbuy_goods_info">
        <dt><?php echo $lang['goods_storage'].$lang['nc_colon'];?></dt>
        <dd> <span id="goods_storage"></span>
          <input name="goods_storage_input" id="goods_storage_input" type="hidden" readonly />
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['max_num'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="w60 text" id="input_max_num" name="input_max_num" type="text" value="<?php echo $output['group_info']['max_num'];?>"/>
            <span></span></p>
          <p class="hint"><?php echo $lang['max_num_explain'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['groupbuy_class'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <select id="input_class_id" name="input_class_id">
              <option value="0"><?php echo $lang['text_no_limit'];?></option>
              <?php if(is_array($output['class_list'])) { ?>
              <?php foreach($output['class_list'] as $groupbuy_class) { ?>
              <?php if(intval($groupbuy_class['deep']) === 0) { ?>
              <option value="<?php echo $groupbuy_class['class_id'];?>" <?php if($output['group_info']['class_id'] == $groupbuy_class['class_id']) echo 'selected'; ?>><?php echo $groupbuy_class['class_name'];?></option>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </select>
            <span></span></p>
          <p class="hint"><?php echo $lang['groupbuy_class_tip'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['groupbuy_area'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <select id="input_area_id" name="input_area_id">
              <option value="0"><?php echo $lang['text_no_limit'];?></option>
              <?php if(is_array($output['area_list'])) { ?>
              <?php foreach($output['area_list'] as $groupbuy_area) { ?>
              <?php if(intval($groupbuy_area['deep']) === 0) { ?>
              <option value="<?php echo $groupbuy_area['area_id'];?>" <?php if($output['group_info']['area_id'] == $groupbuy_area['area_id']) echo 'selected'; ?>><?php echo $groupbuy_area['area_name'];?></option>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </select>
            <span></span> </p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['virtual_quantity'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="w60 text" id="input_virtual_quantity" name="input_virtual_quantity" type="text" value="<?php echo empty($output['group_info']['virtual_quantity'])?0:$output['group_info']['virtual_quantity'];?>"/>
            <span></span></p>
          <p class="hint"><?php echo $lang['virtual_quantity_explain'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['sale_quantity'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="w60 text" id="input_sale_quantity" name="input_sale_quantity" type="text" value="<?php echo empty($output['group_info']['sale_quantity'])?0:$output['group_info']['sale_quantity'];?>"/>
            <span></span></p>
          <p class="hint"><?php echo $lang['sale_quantity_explain'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['group_intro'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <?php showEditor('input_group_intro',$output['group_info']['group_intro'],'600px','300px','','false',false);?>
          </p>
          <p class="info-album"><a class="des_demo" href="index.php?act=store_album&op=pic_list&item=groupbuy"><?php echo $lang['store_goods_album_insert_users_photo'];?></a></p>
          <p id="des_demo" style="width:640px;display:none;"></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <p>
            <input id="groupbuy_agreement" type="checkbox" name="groupbuy_agreement"/>
            <label for="groupbuy_agreement" class="ml5"><?php echo $lang['text_read_agree1'];?> <a href="<?php echo ncUrl(array('act'=>'document','code'=>'groupbuy'), 'document');?>" target="_blank" class="agreement"><?php echo $lang['text_agreement'];?></a> <?php echo $lang['text_read_agree2'];?></label>
            <span></span></p>
          <p class="mt10">
            <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>">
          </p>
        </dd>
      </dl>
    </form>
  </div>
</div>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript">
$(document).ready(function(){
    $(".groupbuy_goods_info").hide();

	$('input[nc_type="change_group_pic"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="group_pic"]').attr('src', src);
	});
    $('.des_demo').ajaxContent({
        event:'click', //mouseover
            loaderType:"img",
            loadingMsg:"<?php echo TEMPLATES_PATH;?>/images/loading.gif",
            target:'#des_demo'
    });
    <?php if(!empty($output['group_info'])) { ?>
    query_spec(<?php echo $output['group_info']['goods_id'];?>);
    <?php } ?>
    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('p').children('span');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
            rules : {
                input_group_name: {
                    required : true
                },
                input_goods_name: {
                    required : true
                },
                input_groupbuy_price: { 
                    required : true,
                    number : true,
                    min : 0.01,
                    max : 1000000
                },
                input_virtual_quantity: {
                    required : true,
                    digits : true
                },
                input_sale_quantity: {
                    required : true,
                    digits : true
                },
                input_max_num: {
                    required : true,
                    digits : true,
                    min : 1,
                    max : function() { return $("#goods_storage_input").val(); }
                },
                <?php if(empty($output['group_info']['group_pic'])){ ?>
                input_group_pic: {
                    required : true,
                    accept : 'jpg|jpeg|gif|png' 
                },
                <?php } ?>
                groupbuy_agreement: {
                    required : true
                }
            },
                messages : {
                    input_group_name: {
                        required : '<?php echo $lang['group_name_error'];?>' 
                    },
                    input_goods_name: {
                        required : '<?php echo $lang['group_goods_error'];?>' 
                    },
                    input_groupbuy_price: { 
                        required : '<?php echo $lang['groupbuy_price_error'];?>',
                        number : '<?php echo $lang['groupbuy_price_error'];?>',
                        min : '<?php echo $lang['groupbuy_price_error'];?>',
                        max : '<?php echo $lang['groupbuy_price_error'];?>'
                    },
                    input_virtual_quantity: {
                        required : '<?php echo $lang['virtual_quantity_error'];?>',
                        digits : '<?php echo $lang['virtual_quantity_error'];?>'
                    },
                    input_sale_quantity: {
                        required : '<?php echo $lang['sale_quantity_error'];?>',
                        digits : '<?php echo $lang['sale_quantity_error'];?>'
                    },
                    input_max_num: {
                        required : '<?php echo $lang['max_num_error'];?>',
                        digits : '<?php echo $lang['max_num_error'];?>',
                        min : '<?php echo $lang['max_num_error'];?>',
                        max : '<?php echo $lang['max_num_error'];?>'
                    },
                    input_group_pic: {
                        required : '<?php echo $lang['group_pic_error'];?>',
                        accept : '<?php echo $lang['group_pic_error'];?>'
                    },
                    groupbuy_agreement: {
                        required : '<?php echo $lang['agree_must'];?>'
                    }
                }
    });
});

function gs_callback(){
    query_spec($('#input_goods_id').val());
}
function query_spec(goods_id){
    $.getJSON('index.php?act=store_groupbuy&op=getGoodsInfo',{
        'goods_id':goods_id
        },
        function(data){
            if(data.done){
                var goods = data.retval;
                $(".groupbuy_goods_info").show();
                $("#goods_store_price").html(goods.goods_store_price);
                $("#goods_storage").html(goods.goods_storage);
                $("#goods_storage_input").val(goods.goods_storage);
            }
        });
}
$(function(){
	$('#li_1').click(function(){
		$('#li_1').attr('class','active');
		$('#li_2').attr('class','');
		$('#demo').hide();
	});
	$('#goods_demo').click(function(){
		$('#li_1').attr('class','');
		$('#li_2').attr('class','active');
		$('#demo').show();
	});

	$('.des_demo').click(function(){
		if($('#des_demo').css('display') == 'none'){
            $('#des_demo').show();
        }else{
            $('#des_demo').hide();
        }
	});
});

function insert_editor(file_path){
	KE.appendHtml('goods_body', '<img src="'+ file_path + '">');
}
</script> 
