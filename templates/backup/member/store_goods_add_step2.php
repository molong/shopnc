<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo RESOURCE_PATH;?>/js/store_goods.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style>
.box_arr .table_btn { width: 222px;}
.box_arr .table_btn a { float: left;}
.box_arr .table_btn a.disable_spec { background: url(<?php echo TEMPLATES_PATH;?>/images/member/btn.gif) repeat 0 -1018px; float: right;}
.dialog_body { border: 0px;}
.add_spec .add_link { color: #919191;}
.add_spec .add_link:hover { color: red;}
.add_spec h2 { padding-left: 10px;}
.f_l { float: left; line-height: 24px;}
.mls_id { width: 0; filter: alpha(opacity=0); opacity: 0;}
.noSelect { color: #B9B9B9 !important;}
</style>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
var DEFAULT_GOODS_IMAGE = "<?php echo defaultGoodsImage('tiny');?>";

/* 插入商品图片 */
function insert_img(name,url){
	var obj = $('#goods_images').find('input[type="hidden"][value=""]:first');
	obj.next('img').attr('src',SITE_URL+"/templates/<?php echo TPL_NAME;?>/images/loading.gif");
	var error = '';
	var i = 0;
	$('#goods_images').find('input[type="hidden"]').each(function(){
		if($(this).val() == name){
			error = '<?php echo $lang['store_goods_index_goods_the_same']; ?>';
		}
		if($(this).val() != ''){
			i++;
		}
	});
	if(i == 5){
		error = '<?php echo $lang['store_goods_index_goods_not_add']; ?>';
	}
	if(error != ''){
		alert(error);
	}else{
	$.getScript("./resource/js/store_goods.js");
	obj.val(name).next('img').attr('src',url);
	}
}
$(function(){
    jQuery.validator.addMethod("pyPrice",
    function(value, element) {
        if ($('#whops_buyer').attr('checked') && $('#isApplyPostage_false').attr('checked')){
        	if ($('#py_price').val()==''){
        		return false;
        	}else{
        		return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
        	}
        }else{
        	return true;
        }}
    );
    jQuery.validator.addMethod("kdPrice",
    function(value, element) {
        if ($('#whops_buyer').attr('checked') && $('#isApplyPostage_false').attr('checked')){
        	if ($('#kd_price').val()==''){
        		return false;
        	}else{
        		return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
        	}
        }else{
        	return true;
        }}
    );
    jQuery.validator.addMethod("emsPrice",
    function(value, element) {
        if ($('#whops_buyer').attr('checked') && $('#isApplyPostage_false').attr('checked')){
	        	if ($('#es_price').val() != ''){
	        		return this.optional(element) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/.test(value);
	        	}else{
	        		return true;
	        	}
        }else{
        	return true;
        }}
    );
    jQuery.validator.addMethod("transportId",
    function(value, element) {
        if ($('#whops_buyer').attr('checked') && $('#isApplyPostage_true').attr('checked')){
	        	if ($('#transport_id').val() == '' || $('#transport_id').val() == '0'){
	        		return false;
	        	}else{
	        		return true;
	        	}
        }else{
        	return true;
        }}
    );        
     $('#goods_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
            goods_name : {
                required	: true,
                minlength 	: 3,
                maxlength	: 50
            },
            goods_store_price : {
				required   : true,
                number     : true,
                min        : 0.01,
                max		   : 1000000
            },
//            goods_weight : {
//                required   : true,
//                number     : true
//            },
            goods_storage  : {
				required	: true,
                digits		: true,
                min			: 1,
                max			: 1000000000
            },
            transport_id:{
            	transportId:true
            },
            py_price	:{
            	pyPrice:true
            },
            kd_price	:{
            	kdPrice:true
            },
            es_price	:{
            	emsPrice:true
            }                
        },
        messages : {
            goods_name  : {
                required	: '<?php echo $lang['store_goods_index_goods_name_null'];?>',
                minlength 	: '<?php echo $lang['store_goods_index_goods_name_help'];?>',
                maxlength 	: '<?php echo $lang['store_goods_index_goods_name_help'];?>'
            },
            goods_store_price : {
				required: '<?php echo $lang['store_goods_index_store_price_null'];?>',
                number     : '<?php echo $lang['store_goods_index_store_price_error'];?>',
                min		   : '<?php echo $lang['store_goods_index_store_price_interval'];?>',
                max		   : '<?php echo $lang['store_goods_index_store_price_interval'];?>'
            },
//            goods_weight:{
//                required : '<?php echo $lang['store_goods_index_goods_weight_null']; ?>',
//                number : '<?php echo $lang['store_goods_index_goods_weight_error']; ?>'
//            },
            goods_storage : {
				required: '<?php echo $lang['store_goods_index_goods_stock_null'];?>',
                digits  : '<?php echo $lang['store_goods_index_goods_stock_error'];?>',
                min		: '<?php echo $lang['store_goods_index_goods_stock_checking'];?>',
                max		: '<?php echo $lang['store_goods_index_goods_stock_checking'];?>'
            },
            py_price	:{
            	pyPrice:'<?php echo $lang['store_goods_index_goods_pyprice_null'];?>'
            },
            kd_price	:{
            	kdPrice:'<?php echo $lang['store_goods_index_goods_kdprice_null'];?>'
            },
            es_price	:{
            	emsPrice:'<?php echo $lang['store_goods_index_goods_emsprice_error'];?>'
            },
            transport_id:{
            	transportId:'<?php echo $lang['store_goods_index_goods_select_tpl'];?>'
            }                  
        }
    });

});
</script>
<div class="wp">
  <ul class="flow-chart">
    <li class="step a2" title="<?php echo $lang['store_goods_index_flow_chart_step1'];?>"></li>
    <li class="step b1" title="<?php echo $lang['store_goods_index_flow_chart_step2'];?>"></li>
    <li class="step c2" title="<?php echo $lang['store_goods_index_flow_chart_step3'];?>"></li>
  </ul>
  <div class="item-publish">
    <form method="post" id="goods_form" enctype="multipart/form-data" action="index.php?act=store_goods&op=<?php if ($output['goods']['goods_id']!='') echo 'edit_save_goods'; else echo 'save_goods'; ?>">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="goods_id" value="<?php echo $output['goods']['goods_id'];?>" />
      <input type="hidden" name="spec_id" value="<?php echo $output['goods']['spec_id'];?>" />
      <input type="hidden" name="type_id" value="<?php echo $output['goods_class']['type_id'];?>" />
      <div class="goods-attribute">
        <dl class="tit">
          <h3><?php echo $lang['store_goods_index_goods_base_info']?></h3>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_class'].$lang['nc_colon'];?></dt>
          <dd id="gcategory">
            <?php if (!empty($output['goods']['gc_id'])) { ?>
            <span class="f_l"><?php echo $output['goods_class']['gc_tag_name'];?></span> <a class="edit_gcategory ncu-btn1 ml10" href="index.php?act=store_goods&op=add_goods&step=one&goods_id=<?php echo $output['goods']['goods_id']?>"><span><?php echo $lang['nc_edit'];?></span></a>
            <?php } else { ?>
            <span class="f_l"><?php echo $output['goods_class']['gc_tag_name'];?></span> <a class="edit_gcategory ncu-btn1 ml10" href="index.php?act=store_goods&op=add_goods&step=one"><span><?php echo $lang['nc_edit'];?></span></a>
            <?php } ?>
            <input type="text" id="cate_id" name="cate_id" value="<?php echo $output['goods_class']['gc_id'];?>" class="mls_id text" />
            <input type="hidden" name="cate_name" value="<?php echo $output['goods_class']['gc_tag_name'];?>" class="mls_names text"/>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_step2_goods_form'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <label style="padding-right:8px;">
                <input name="goods_form" value="1" <?php if($output['goods']['goods_form'] == '1' || !isset($output['goods']['goods_form'])){?>checked="checked"<?php }?> type="radio" />
                <?php echo $lang['store_goods_step2_brand_new'];?></label>
              <label>
                <input name="goods_form" value="2" <?php if($output['goods']['goods_form'] == '2'){?>checked="checked"<?php }?> type="radio" />
                <?php echo $lang['store_goods_step2_second_hand'];?></label>
            </p>
          </dd>
        </dl>
        <dl>
          <dt class="required"><span class="red">*</span><?php echo $lang['store_goods_index_goods_name'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input name="goods_name" type="text" class="text w400" title="" value="<?php echo $output['goods']['goods_name']; ?>" />
            <p>
            <p class="hint"><?php echo $lang['store_goods_index_goods_name_help'];?></p>
          </dd>
        </dl>
        <dl>
          <dt nc_type="no_spec"><span class="red">*</span><?php echo $lang['store_goods_index_store_price'].$lang['nc_colon'];?></dt>
          <dd nc_type="no_spec">
            <p>
              <input name="goods_store_price" value="<?php echo $output['goods']['goods_store_price']; ?>" type="text"  class="text" />
              <input name="goods_store_price_interval" value="<?php echo $output['goods']['goods_store_price_interval']; ?>" type="hidden"  />
              <!-- 价格区间 --> 
            </p>
            <p class="hint"><?php echo $lang['store_goods_index_store_price_help'];?></p>
          </dd>
        </dl>
        <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
        <?php $i = '0';?>
        <?php foreach ($output['spec_list'] as $k=>$val){?>
        <dl nc_type="spec_group_dl_<?php echo $i;?>" nctype="spec_group_dl" class="spec-bg" <?php if($k == '1'){?>spec_img="t"<?php }?>>
          <dt>
            <input type="hidden" name="sp_name[<?php echo $k;?>]" value="<?php echo $val['sp_name']?>" />
            <?php echo $val['sp_name'].$lang['nc_colon']?></dt>
          <?php if(is_array($val['value']) && !empty($val['value'])){?>
          <dd <?php if($k == '1'){?>nctype="sp_group_val"<?php }?>>
            <ul class="spec">
              <?php foreach ($val['value'] as $v){?>
              <li><span nctype="input_checkbox" class="checkbox">
                <input type="checkbox" value="<?php echo $v['sp_value_name']?>" nc_type="<?php echo $v['sp_value_id']?>" <?php if($k == '1'){?>class="sp_val"<?php }?> name="sp_val[<?php echo $k;?>][<?php echo $v['sp_value_id']?>]">
                </span>
                <?php if($val['sp_format'] == 'image'){?>
                <span class="img"><img src="<?php echo ATTACH_SPEC.DS.$v['sp_value_image']?>" onerror="this.src='<?php echo TEMPLATES_PATH;?>/images/transparent.gif'"></span>
                <?php }?>
                <span nctype="pv_name" class="pvname"><?php echo $v['sp_value_name'];?></span></li>
              <?php }?>
            </ul>
            <?php if($k == '1'){?>
            <div class="clear"></div>
            <table border="0" cellpadding="0" cellspacing="0" class="spec_table" style="display:none;" nctype="col_img_table">
              <thead>
                <tr>
                  <th><?php echo $val['sp_name']?></th>
                  <th class="w250"><?php echo $lang['store_goods_step2_image'];?></th>
                  <?php if(isset($output['goods']['goods_col_img'])){?>
                  <th><?php echo $lang['store_goods_step2_exist_image'];?></th>
                  <?php }?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($val['value'] as $v){?>
                <tr style="display:none;" nctype="file_tr_<?php echo $v['sp_value_id'];?>">
                  <td><span class="img"><img src="<?php echo ATTACH_SPEC.DS.$v['sp_value_image']?>" onerror="this.src='<?php echo TEMPLATES_PATH;?>/images/transparent.gif'"></span><span class="pvname" nctype="pv_name"><?php echo $v['sp_value_name'];?></span></td>
                  <td class="w300"><span class="pvname">
                    <input type="file" name="<?php echo $v['sp_value_name'];?>" />
                    </span> <span><img class="spec-img" style="border:0;" src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif" /></span></td>
                  <?php if(isset($output['goods']['goods_col_img'])){?>
                  <td><?php if(isset($output['goods']['goods_col_img'][$v['sp_value_id']])){?>
                    <input type="hidden" name="goods_col_img[<?php echo $v['sp_value_id'];?>]" value="<?php echo $output['goods']['goods_col_img'][$v['sp_value_id']];?>" />
                    <img class="spec-img" src="<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$output['goods']['store_id'].DS.$output['goods']['goods_col_img'][$v['sp_value_id']];?>" />
                    <?php }else{ echo $lang['store_goods_step2_exist_image_null'];}?></td>
                  <?php }?>
                </tr>
                <?php }?>
                <tr>
                  <td colspan="15"><p class="hint" style="padding-left:10px;"><?php printf($lang['store_goods_step2_spec_img_help'],intval(C('image_max_filesize'))/1024);?></p></td>
                </tr>
              </tbody>
            </table>
            <?php }?>
          </dd>
          <?php }?>
        </dl>
        <?php $i++;?>
        <?php }?>
        <?php }?>
        <dl nc_type="spec_dl" class="spec-bg" style="display:none">
          <dt><?php echo $lang['srore_goods_index_goods_stock_set'].$lang['nc_colon'];?></dt>
          <dd class="spec-dd">
            <table border="0" cellpadding="0" cellspacing="0" class="spec_table">
              <thead>
                <?php if(is_array($output['spec_list']) && !empty($output['spec_list'])){?>
                <?php foreach ($output['spec_list'] as $k=>$val){?>
              <th><?php echo $val['sp_name'];?></th>
                <?php }?>
                <?php }?>
                <th><span class="red">*</span><?php echo $lang['store_goods_index_price'];?></th>
                <th><span class="red">*</span><?php echo $lang['store_goods_index_stock'];?></th>
                <th><?php echo $lang['store_goods_index_goods_no'];?></th>
                  </thead>
              <tbody nc_type="spec_table">
              </tbody>
            </table>
          </dd>
        </dl>
        <dl>
          <dt nc_type="no_spec"><span class="red">*</span><?php echo $lang['store_goods_index_goods_stock'].$lang['nc_colon'];?></dt>
          <dd  nc_type="no_spec">
            <p>
              <input name="goods_storage" value="<?php echo $output['goods_storage']; ?>" type="text"  class="text" />
            </p>
            <p class="hint"><?php echo $lang['store_goods_index_goods_stock_help'];?></p>
          </dd>
        </dl>
        <dl>
          <dt nc_type="no_spec"><?php echo $lang['store_goods_index_goods_no'].$lang['nc_colon'];?></dt>
          <dd nc_type="no_spec">
            <p>
              <input name="goods_serial" value="<?php echo $output['goods']['goods_serial']; ?>" type="text"  class="text"  />
            </p>
            <p class="hint"><?php echo $lang['store_goods_index_goods_no_help'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_album_goods_pic'].$lang['nc_colon'];?></dt>
          <dd>
            <div class="pic_list">
              <ul id="menu" class="menu">
                <li class="active" id="li_1"><a href="javascript:void(0);"><?php echo $lang['store_goods_album_goods_pic'];?></a></li>
                <li id='li_2'><a class="goods_demo" id="goods_demo" href="index.php?act=store_album&op=pic_list&item=goods"><?php echo $lang['store_goods_album_select_from_album'];?></a></li>
              </ul>
              <div class="content">
                <div id="demo"></div>
                <div class="standard">
                  <div class="small_pic" >
                    <ul id="goods_images">
                      <?php for($i=0;$i<5;$i++){?>
                      <li nc_type="handle_pic" id="thumbnail_<?php echo $i;?>">
                        <div class="arrow-left"></div>
                        <div class="picture"><span class="thumb size60"><i></i>
                          <input type="hidden" name="image_path[]" nctype="file_<?php echo $i;?>" value="<?php echo $output['goods']['goods_image_more'][$i];?>" />
                          <img nctype="file_<?php echo $i;?>" src="<?php echo cthumb($output['goods']['goods_image_more'][$i],'tiny',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,60,60);"/> </span></div>
                        <div class="arrow-right"></div>
                        <div nc_type="handler" class="bg" id="<?php echo $i;?>"><span class="arrow-left-op" nctype="left" title="<?php echo $lang['store_goods_index_left'];?>"></span><span class="delete" nctype="drop_image" title="<?php echo $lang['nc_del'];?>"><?php echo $lang['nc_del'];?></span><span class="arrow-right-op" nctype="right" title="<?php echo $lang['store_goods_index_right'];?>"></span></div>
                        <div class="upload-btn"><a href="javascript:void(0);"><span style="width: 66px; height: 28px; position: absolute; left: 0; top: 0; z-index: 999; cursor:pointer; ">
                          <input type="file" name="file_<?php echo $i;?>" id="file_<?php echo $i;?>" style="width: 66px; height: 28px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" maxlength="0">
                          </span>
                          <div class="upload-button"><?php echo $lang['store_goods_img_upload'];?></div>
                          <input id="submit_button" style="display:none" type="button" value="<?php echo $lang['nc_submit'];?>" onClick="submit_form($(this))">
                          </a></div>
                      </li>
                      <?php } ?>
                    </ul>
                  </div>
                  <div class="help">
                    <p class="ico"><?php echo $lang['store_goods_step2_description_one'];?></p>
                    <p><?php printf($lang['store_goods_step2_description_two'],intval(C('image_max_filesize'))/1024);?></p>
                    <p><?php echo $lang['store_goods_step2_description_three'];?></p>
                    <p><?php echo $lang['store_goods_step2_description_four'];?></p>
                  </div>
                  <div class="clear"></div>
                </div>
                <div class="upload_btn" style=" display: none;"> </div>
              </div>
            </div>
          </dd>
        </dl>
        <!--        <dl>
          <dt class="required"><em class="pngFix"></em><?php echo $lang['store_goods_index_goods_weight'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input type="text" name="goods_weight" value="<?php if(isset($output['goods']['goods_weight'])){ echo $output['goods']['goods_weight'];}else{ echo '0';} ?>" />
            </p>
            <p class="hint"><?php echo $lang['store_goods_index_goods_weight_tag']; ?></p>
          </dd>
        </dl>-->
        
        <dl class="tit">
          <h3><?php echo $lang['store_goods_index_goods_detail_info']?></h3>
        </dl>
        <?php if(is_array($output['attr_list']) && !empty($output['attr_list'])){?>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_attr'].$lang['nc_colon']; ?></dt>
          <dd>
            <?php foreach ($output['attr_list'] as $k=>$val){?>
            <div class="attr">
              <label><?php echo $val['attr_name']?></label>
              <input type="hidden" name="attr[<?php echo $k;?>][name]" value="<?php echo $val['attr_name']?>" />
              <?php if(is_array($val) && !empty($val)){?>
              <select name="" attr="attr[<?php echo $k;?>][__NC__]" nc_type="attr_select">
                <option value='' nc_type='0'></option>
                <?php foreach ($val['value'] as $v){?>
                <option value="<?php echo $v['attr_value_name']?>" <?php if(isset($output['attr_checked']) && in_array($v['attr_value_id'], $output['attr_checked'])){?>selected="selected"<?php }?> nc_type="<?php echo $v['attr_value_id'];?>"><?php echo $v['attr_value_name'];?></option>
                <?php }?>
              </select>
              <?php }?>
            </div>
            <div class="clear"></div>
            <?php }?>
          </dd>
        </dl>
        <?php }?>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_brand'].$lang['nc_colon'];?></dt>
          <dd>
            <select name="brand_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?></option>
              <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])){?>
              <?php foreach($output['brand_list'] as $val) { ?>
              <option value="<?php echo $val['brand_id']; ?>" <?php if ($val['brand_id'] == $output['goods']['brand_id']) { ?>selected="selected"<?php } ?>><?php echo $val['brand_name']; ?></option>
              <?php } ?>
              <?php }?>
            </select>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_desc'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <?php showEditor('goods_body',$output['goods']['goods_body'],'100%','400px','visibility:hidden;',"false",$output['editor_multimedia']);?>
            </p>
            <p class="info-album"><a class="des_demo" href="index.php?act=store_album&op=pic_list&item=des"><?php echo $lang['store_goods_album_insert_users_photo'];?></a></p>
            <p id="des_demo" style="display:none;"></p>
          </dd>
        </dl>
        <!--transport info begin-->
        <dl class="tit">
          <h3><?php echo $lang['store_goods_index_goods_transport']?></h3>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_szd'].$lang['nc_colon']?></dt>
          <dd>
            <p id="region">
              <select class="d_inline" name="province_id" id="province_id">
              </select>
            </p>
            <div class="clear"></div>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_transfee_charge'].$lang['nc_colon']; ?></dt>
          <dd>
            <p style="float:left;  clear:both; margin-top:8px;">
              <input type="radio" value="1" <?php if ($output['goods']['goods_transfee_charge'] == '1' && $output['goods']['goods_id'] != '') { ?>checked="checked" <?php } ?> name="goods_transfee_charge" id="whops_seller">
              <label for="whops_seller"><?php echo $lang['store_goods_index_goods_transfee_charge_seller']; ?></label>
            </p>
            <p style="float:left;  clear:both; margin-top:8px;">
              <input type="radio" value="0" <?php if ($output['goods']['goods_transfee_charge'] == '0' || $output['goods']['goods_id'] == '') { ?>checked="checked" <?php } ?> name="goods_transfee_charge" id="whops_buyer">
              <label for="whops_buyer"><?php echo $lang['store_goods_index_goods_transfee_charge_buyer']; ?></label>
            </p>
            <div class="transport_tpl" id="whops_buyer_box">
              <ul style="line-height:30px">
                <li>
                  <input id="isApplyPostage_true" name="isApplyPostage" class="radio" type="radio" value="1">
                  <label for="isApplyPostage_true"><?php echo $lang['store_goods_index_use_tpl'];?></label>
                  <div id="Postage" style="display:none">
                    <input id="transport_id" type="hidden" value="<?php echo $output['goods']['transport_id'];?>" name="transport_id">
                    <div class="freight-template"> <span class="template-name" id="postageName"></span>
                      <input onclick="window.open('index.php?act=transport&type=select')" type="button" value="<?php echo $lang['store_goods_index_select_tpl'];?>" class="select-templ" id="postageButton">
                    </div>
                  </div>
                </li>
                <li>
                  <input id="isApplyPostage_false" name="isApplyPostage" class="radio" type="radio" checked="" value="0">
                  <label for="isApplyPostage_false"><?php echo $lang['transport_type_py'].$lang['nc_colon']?></label>
                  <input id="py_price" class="w50 text" nc_type='transport' type="text" value="<?php echo $output['goods']['goods_id']; ?>" name="py_price">
                  <?php echo $lang['currency_zh'];?>
                  <label class="ml10"><?php echo $lang['transport_type_kd'].$lang['nc_colon'];?></label>
                  <input id="kd_price" class="w50 text" nc_type='transport' type="text" value="" name="kd_price">
                  <?php echo $lang['currency_zh'];?>
                  <label class="ml10">EMS<?php echo $lang['nc_colon'];?></label>
                  <input id="es_price" class="w50 text" nc_type='transport' type="text" value="" name="es_price">
                  <?php echo $lang['currency_zh'];?> </li>
              </ul>
            </div>
          </dd>
        </dl>
        <!--transport info end-->
        <dl class="tit">
          <h3><?php echo $lang['store_goods_index_goods_other_info']?></h3>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_store_goods_class'].$lang['nc_colon'];?></dt>
          <dd>
            <p><span class="new_add"><a href="javascript:void(0)" id="add_sgcategory" class="ncu-btn1 mr10"><span><?php echo $lang['store_goods_index_new_class'];?></span></a> </span>
              <?php if (!empty($output['store_class_goods'])) { ?>
              <?php foreach ($output['store_class_goods'] as $v) { ?>
              <select name="sgcate_id[]" class="sgcategory" onchange='preventSelectDisabled(this);'>
                <option value="0"><?php echo $lang['nc_please_choose'];?></option>
                <?php foreach ($output['store_goods_class'] as $val) { ?>
                <option value="<?php echo $val['stc_id']; ?>" <?php if ($v['stc_id']==$val['stc_id']) { ?>selected="selected"<?php } ?> <?php //if (is_array($val['child']) && count($val['child'])>0){echo 'disabled=disabled'." class='noSelect'";}?>><?php echo $val['stc_name']; ?></option>
                <?php if (is_array($val['child']) && count($val['child'])>0){?>
                <?php foreach ($val['child'] as $child_val){?>
                <option value="<?php echo $child_val['stc_id']; ?>" <?php if ($v['stc_id']==$child_val['stc_id']) { ?>selected="selected"<?php } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
                <?php }?>
                <?php }?>
                <?php } ?>
              </select>
              <?php } ?>
              <?php } else { ?>
              <select name="sgcate_id[]" class="sgcategory" onchange='preventSelectDisabled(this);'>
                <option value="0"><?php echo $lang['nc_please_choose'];?></option>
                <?php if (!empty($output['store_goods_class'])){?>
                <?php foreach ($output['store_goods_class'] as $val) { ?>
                <option value="<?php echo $val['stc_id']; ?>" <?php //if (is_array($val['child']) && count($val['child'])>0){echo 'disabled=disabled'." class='noSelect'";}?>><?php echo $val['stc_name']; ?></option>
                <?php if (is_array($val['child']) && count($val['child'])>0){?>
                <?php foreach ($val['child'] as $child_val){?>
                <option value="<?php echo $child_val['stc_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
                <?php }?>
                <?php }?>
                <?php } ?>
                <?php } ?>
              </select>
              <?php } ?>
              </p>
            <p class="hint"><?php echo $lang['store_goods_index_belong_multiple_store_class'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_show'].$lang['nc_colon'];?></dt>
          <dd>
            <p class="mt5">
              <label>
                <input name="goods_show" value="1" type="radio" checked="checked" />
                <?php echo $lang['store_goods_index_immediately_sales'];?></label>
            </p>
            <p class="mt5">
              <label>
                <input name="goods_show" value="2" type="radio" />
                <?php echo $lang['store_goods_step2_start_time'];?> </label>
              <input type="text" class="w80 text" name="starttime" disabled="disabled"  id="starttime" value="<?php echo date('Y-m-d');?>" />
              <select disabled="disabled"  name="starttime_H" id="starttime_H">
                <?php foreach ($output['hour_array'] as $val){?>
                <option value="<?php echo $val;?>" <?php if($val>=date('H') && $sign_H != 1){?>selected="selected"<?php $sign_H = 1;}?>><?php echo $val;?></option>
                <?php }?>
              </select>
              <?php echo $lang['store_goods_step2_hour'];?>
              <select disabled="disabled"  name="starttime_i" id="starttime_i">
                <?php foreach ($output['minute_array'] as $val){?>
                <option value="<?php echo $val;?>" <?php if($val>=date('i') && $sign_i != 1){?>selected="selected"<?php $sign_i = 1;}?>><?php echo $val;?></option>
                <?php }?>
              </select>
              <?php echo $lang['store_goods_step2_minute'];?> </p>
            <p class="mt5">
              <label>
                <input name="goods_show" value="0" type="radio" />
                <?php echo $lang['store_goods_index_in_warehouse'];?></label>
            </p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_recommend'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <label style="padding-right:8px;">
                <input name="goods_commend" value="1" <?php if ($output['goods']['goods_commend'] == 1 or $output['goods']['goods_id'] == '') { ?>checked="checked" <?php } ?> type="radio" />
                <?php echo $lang['nc_yes'];?></label>
              <label>
                <input name="goods_commend" value="0" <?php if ($output['goods']['goods_commend'] == 0 and $output['goods']['goods_id'] != '') { ?>checked="checked" <?php } ?> type="radio"/>
                <?php echo $lang['nc_no'];?></label>
            </p>
            <p class="hint"><?php echo $lang['store_goods_index_recommend_tip'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_seo_keywords'].$lang['nc_colon']; ?></dt>
          <dd >
            <p>
              <input name="seo_keywords" type="text" class="w400 text" value="<?php echo $output['goods']['goods_keywords']; ?>" />
            </p>
            <p class="hint"><?php echo $lang['store_goods_index_goods_seo_keywords_help']; ?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_goods_index_goods_seo_description'].$lang['nc_colon']; ?></dt>
          <dd>
            <p>
              <textarea class="w400" name="seo_description" rows="3" id="remark_input" ><?php echo $output['goods']['goods_description']; ?></textarea>
            </p>
            <p class="hint"><?php echo $lang['store_goods_index_goods_seo_description_help']; ?></p>
          </dd>
        </dl>
        <div class="clear">
          <p>&nbsp;</p>
          <p>&nbsp;</p>
        </div>
        <div class="ncu-form-style tc mb30">
          <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
        </div>
      </div>
    </form>
  </div>
</div>
<script>
function preventSelectDisabled(oSelect)
{
   //得到当前select选中项的disabled属性。
   var isOptionDisabled = oSelect.options[oSelect.selectedIndex].disabled;
   //如果是有disabled属性的话
   if(isOptionDisabled)
   {
      //让他恢复上一次选择的状态，oSelect.defaultSelectedIndex属性是前一次选中的选项index
      //oSelect.selectedIndex = oSelect.defaultSelectedIndex;
	  //让他恢复未选择状态
	  oSelect.selectedIndex = '0';
      return false;
   }
  //如果没有disabled属性的话
   else
   {
	   var currentvalue = oSelect.value;
	   //为了实现下面的验证,先清空选择的项
       oSelect.value = '0';
	   if(checkselected(currentvalue)){
		 	//oSelect.defaultSelectedIndex属性，设置成当前选择的index
	        oSelect.value = currentvalue;   
	   }else{
		   //alert("该分类已经选择,请选择其他分类");
		   alert('<?php echo $lang['store_goods_index_add_sclasserror']; ?>');
	   }
       return true;
   }
}
function checkselected(currentvalue){
	var result = true;
	jQuery.each($(".sgcategory"),function(){
		if(currentvalue!=0 && currentvalue == $(this).val()){
			result = false;
		}
	});
	return result;
}
</script> 
<script>

// 按规格存储规格值数据
var spec_group_checked = [<?php for ($i=0; $i<$output['sign_i']; $i++){if($i+1 == $output['sign_i']){echo "''";}else{echo "'',";}}?>];
var str = '';
var V = new Array();

<?php for ($i=0; $i<$output['sign_i']; $i++){?>
var spec_group_checked_<?php echo $i;?> = new Array();
<?php }?>

$(function(){
	$('tbody[nc_type="spec_table"]').find('input[type="text"]').live('change',function(){
		s = $(this).attr('nc_type');
		V[s] = $(this).val();
	});

	// 商品属性
	attr_selected();
	$('select[nc_type="attr_select"]').change(function(){
		id = $(this).find('option:selected').attr('nc_type');
		name = $(this).attr('attr').replace(/__NC__/g,id);
		$(this).attr('name',name);
	});
	
	
	$('span[nctype="input_checkbox"] > input[type="checkbox"]').click(function(){
		into_array();
	});
//	recursionSpec()方法生成的function形式参考 （ 2个规格）
//	$('input[type="checkbox"]').click(function(){
//		str = '';
//		for (var i=0; i<spec_group_checked[0].length; i++ ){
//			td_1 = spec_group_checked[0][i];
//			for (var j=0; j<spec_group_checked[1].length; j++){
//				td_2 = spec_group_checked[1][j];
//				str += '<tr><td>'+td_1[0]+'</td><td>'+td_2[0]+'</td><td><input type="text" /></td><td><input type="text" /></td><td><input type="text" /></td>';
//			}
//		}
//		$('table[class="spec_table"] > tbody').empty().html(str);
//	});


	// 生成tr
	$('span[nctype="input_checkbox"] > input[type="checkbox"]').click(function(){
//	$('input[type="checkbox"]').click(function(){
		goods_stock_set();
	});

	// 计算商品库存
	$('input[data_type="stock"]').live('change',function(){
		stock_sum();
	});

	// 计算商品价格区间
	$('input[data_type="price"]').live('change',function(){
		price_interval();
	});

	// 提交后不没有填写的价格或库存的库存配置设为默认价格和0
	// 库存配置隐藏式 里面的input加上disable属性
	$('input[type="submit"]').click(function(){
		$('input[data_type="price"]').each(function(){
			if($(this).val() == ''){
				$(this).val($('input[name="goods_store_price"]').val());
			}
		});
		$('input[data_type="stock"]').each(function(){
			if($(this).val() == ''){
				$(this).val('0');
			}
		});
		if($('dl[nc_type="spec_dl"]').css('display') == 'none'){
			$('dl[nc_type="spec_dl"]').find('input').attr('disabled','disabled');
		}
	});
	
});

// 将选中的规格放入数组
function into_array(){
<?php for ($i=0; $i<$output['sign_i']; $i++){?>
		
		spec_group_checked_<?php echo $i;?> = new Array();
		$('dl[nc_type="spec_group_dl_<?php echo $i;?>"]').find('input[type="checkbox"]:checked').each(function(){
			i = $(this).attr('nc_type');
			v = $(this).val();
			spec_group_checked_<?php echo $i;?>[spec_group_checked_<?php echo $i;?>.length] = [v,i];
		});

		spec_group_checked[<?php echo $i;?>] = spec_group_checked_<?php echo $i;?>;

<?php }?>
}

// 生成库存配置
function goods_stock_set(){
	//  店铺价格 商品库存改为只读
	$('input[name="goods_store_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
	$('input[name="goods_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');
	
	$('dl[nc_type="spec_dl"]').show();
	str = '<tr>';
	<?php recursionSpec(0,$output['sign_i']);?>
	if(str == '<tr>'){
		//  店铺价格 商品库存取消只读
		$('input[name="goods_store_price"]').attr('readonly','').css('background','');
		$('input[name="goods_storage"]').attr('readonly','').css('background','');
		$('dl[nc_type="spec_dl"]').hide();
	}
	$('tbody[nc_type="spec_table"]')
		.empty()
		.html(str)
		.find('input[type="text"]').each(function(){
			s = $(this).attr('nc_type');
			try{$(this).val(V[s])}catch(ex){$(this).val('')};
			if($(this).attr('data_type') == 'price' && $(this).val() == ''){
				$(this).val($('input[name="goods_store_price"]').val());
			}
		});
	stock_sum();		// 计算商品库存
	price_interval();	// 计算价格区间
}

// 计算商品库存
function stock_sum(){
	var stock = 0;
	$('input[data_type="stock"]').each(function(){
		if($(this).val() != ''){
			stock += parseInt($(this).val());
		}
	});
	$('input[name="goods_storage"]').val(stock);
}

// 计算价格区间
function price_interval(){
	var max = 0.01;
	var min = 10000000;
	$('input[data_type="price"]').each(function(){
		if($(this).val() != ''){
			max = Math.max(max,$(this).val());
			min = Math.min(min,$(this).val());
		}
	});
	if(max > min){
		$('input[name="goods_store_price_interval"]').val(number_format(min,2)+' - '+number_format(max,2));
	}else {
		$('input[name="goods_store_price_interval"]').val('');
	}
	if(min != 10000000){
		$('input[name="goods_store_price"]').val(number_format(min,2));
	}
}


function attr_selected(){
	$('select[nc_type="attr_select"] option:selected').each(function(){
		id = $(this).attr('nc_type');
		name = $(this).parents('select').attr('attr').replace(/__NC__/g,id);
		$(this).parents('select').attr('name',name);
	});
}

</script>
<?php 
//  生成需要的js循环。递归调用	PHP
function recursionSpec($len,$sign) {
	if($len < $sign){
		echo "for (var i_".$len."=0; i_".$len."<spec_group_checked[".$len."].length; i_".$len."++){td_".(intval($len)+1)." = spec_group_checked[".$len."][i_".$len."];\n";
		$len++;
		recursionSpec($len,$sign);
	}else{
		echo "var spec_bunch = 'i_';\n";
		for($i=0; $i< $len; $i++){
			echo "spec_bunch += td_".($i+1)."[1];\n";
		}
		for($i=0; $i< $len; $i++){
			echo "str +='<td><input type=\"hidden\" name=\"spec['+spec_bunch+'][sp_value]['+td_".($i+1)."[1]+']\" value='+td_".($i+1)."[0]+' />'+td_".($i+1)."[0]+'</td>';\n";
		}
		echo "str +='<td><input class=\"text\" type=\"text\" name=\"spec['+spec_bunch+'][price]\" data_type=\"price\" nc_type=\"'+spec_bunch+'|price\" value=\"\" /></td><td><input class=\"text\" type=\"text\" name=\"spec['+spec_bunch+'][stock]\" data_type=\"stock\" nc_type=\"'+spec_bunch+'|stock\" value=\"\" /></td><td><input class=\"text\" type=\"text\" name=\"spec['+spec_bunch+'][sku]\" nc_type=\"'+spec_bunch+'|sku\" value=\"\" /></td></tr>';\n";
		for($i=0; $i< $len; $i++){
			echo "}\n";
		}
	}
}

?>
<script>
// 修改规格名称 上传颜色图片JS
$(function(){
	// 修改规格名称
	$('dl[nctype="spec_group_dl"]').find('input[type="checkbox"]').click(function(){
		pv = $(this).parents('li').find('span[nctype="pv_name"]');
		if(typeof(pv.find('input').val()) == 'undefined'){
			pv.html('<input type="text" maxlength="20" value="'+pv.html()+'" />');
		}else{
			pv.html(pv.find('input').val());
		}		
	});
	
	$('span[nctype="pv_name"] > input').live('change',function(){
		change_img_name($(this));	// 修改相关的颜色名称
		into_array();		// 将选中的规格放入数组
		goods_stock_set();	// 生成库存配置
	});
	

	// 上传颜色图片
	$('dd[nctype="sp_group_val"]').find('input[type="checkbox"]').click(function(){
		file_table_show($(this));
	});

	$('table[nctype="col_img_table"]').find('input[type="file"]').live('change',function(){
		src = getFullPath($(this)[0]);
		$(this).parents('tr').find('.spec-img').attr('src',src).show();
	});
	
});

// 修改相关的颜色名称
function change_img_name(Obj){
	var S = Obj.parents('li').find('input[type="checkbox"]');
	S.val(Obj.val());
	var V = $('tr[nctype="file_tr_'+S.attr('nc_type')+'"]');
	V.find('span[nctype="pv_name"]').html(Obj.val());
	V.find('input[type="file"]').attr('name', Obj.val());
}

// 选中意思后显示图片上传框js
function file_table_show(Obj){
	var V = $('dl[spec_img="t"]').find('input[type="checkbox"]:checked');
	if(V.length == 0){	// 长度为零table隐藏
		$('table[nctype="col_img_table"]').hide();
	}else{				// 否则显示table
		$('table[nctype="col_img_table"]').show();
	}
	var S = $('tr[nctype="file_tr_'+Obj.attr('nc_type')+'"]');
	if(S.css('display') == 'none'){
		S.show();
	}else{
		S.hide();
	}
}


</script>
<?php if ($output['goods']['goods_id'] != ''){?>
<script>
<?php if($output['goods']['spec_open'] == '1'){?>
//  编辑商品时处理JS
$(function(){
	var E_SP = new Array();
	var E_SPV = new Array();
	<?php
	$string = '';
	if(is_array($output['spec_checked']) && !empty($output['spec_checked'])){
		foreach ($output['spec_checked'] as $v) {
			$string .= "E_SP[".$v['sp_value_id']."] = '".$v['sp_value_name']."';";
		}
	}
	echo $string;
	echo "\n";
	$string = '';
	if(is_array($output['sp_value']) && !empty($output['sp_value'])){
		foreach ($output['sp_value'] as $k=>$v) {
			$string .= "E_SPV['{$k}'] = '{$v}';";
		}
	}
	echo $string;
	?>
	V = E_SPV;
	$('.goods-attribute').find('input[type="checkbox"]').each(function(){
		$('dl[nc_type="spec_dl"]').show();
		//  店铺价格 商品库存改为只读
		$('input[name="goods_store_price"]').attr('readonly','readonly').css('background','#E7E7E7 none');
		$('input[name="goods_storage"]').attr('readonly','readonly').css('background','#E7E7E7 none');
		s = $(this).attr('nc_type');
		if (!(typeof(E_SP[s]) == 'undefined')){
			$(this).attr('checked',true);
			v = $(this).parents('li').find('span[nctype="pv_name"]');
			if(E_SP[s] != ''){
				$(this).val(E_SP[s]);
				v.html('<input type="text" maxlength="20" value="'+E_SP[s]+'" />');
			}else{
				v.html('<input type="text" maxlength="20" value="'+v.html()+'" />');
			}
			change_img_name($(this));			// 修改相关的颜色名称
		}
	});

	into_array();	// 将选中的规格放入数组

	str = '<tr>';
	<?php recursionSpec(0,$output['sign_i']);?>
	if(str == '<tr>'){
		$('dl[nc_type="spec_dl"]').hide();
		$('input[name="goods_store_price"]').attr('readonly','').css('background','');
		$('input[name="goods_storage"]').attr('readonly','').css('background','');
	}

	$('tbody[nc_type="spec_table"]')
		.empty()
		.html(str)
		.find('input[type="text"]').each(function(){
			s = $(this).attr('nc_type');
			try{$(this).val(E_SPV[s])}catch(ex){$(this).val('')};
		});

	stock_sum();	// 计算商品库存
	$('dd[nctype="sp_group_val"]').find('input[type="checkbox"]:checked').each(function(){
		file_table_show($(this));
	});
});
<?php }?>
</script>
<?php }?>
<script>
$(function(){
	$('input[name="goods_transfee_charge"]').click(function(){
		if($(this).val() == 1){
			$('#whops_buyer_box').css('display','none');
		}else{
			$('#whops_buyer_box').css('display','');
		}
	});
	$('input[name="isApplyPostage"]').click(function(){
		if($(this).val() == 1){
			$('#Postage').css('display','');
			$('input[nc_type="transport"]').attr('disabled','disabled').css('background','#ECE9D8');
		}else{
			$('#Postage').css('display','none');
			$('input[nc_type="transport"]').removeAttr('disabled').css('background','');
		}
	});
	$('#starttime').datepicker({dateFormat: 'yy-mm-dd'});

	$('input[name="goods_show"]').click(function(){
		if($(this).val() == '2'){
			$('#starttime').removeAttr('disabled').css('background','');
			$('#starttime_H').removeAttr('disabled').css('background','');
			$('#starttime_i').removeAttr('disabled').css('background','');
		}else{
			$('#starttime').attr('disabled','disabled').css('background','#E7E7E7 none');
			$('#starttime_H').attr('disabled','disabled').css('background','#E7E7E7 none');
			$('#starttime_i').attr('disabled','disabled').css('background','#E7E7E7 none');
		}
	});

	var area_select = $("#province_id");
	areaInit(area_select,0);//初始化地区
	$("#province_id").change(provinceChange);
	 function provinceChange(){
	    // 删除后面的select
	    $(this).nextAll("select").remove();
	    if (this.value > 0){
	        var text = $(this).get(0).options[$(this).get(0).selectedIndex].text;
	        var area_id = this.value;
	        var EP = new Array();
	        EP[1]= true;EP[2]= true;EP[9]= true;EP[22]= true;EP[34]= true;EP[35]= true;
	        if(typeof(nc_a[area_id]) != 'undefined'){//数组存在
	        	var areas = new Array();
	        	var option = "";
	        	areas = nc_a[area_id];
          	if (typeof(EP[area_id]) == 'undefined'){
          		option = "<option value='0'>"+text+"(*)</option>";
          	}
          	$("<select name='city_id' id='city_id'>"+option+"</select>").insertAfter(this);
	        	for (i = 0; i <areas.length; i++){
	        		$(this).next("select").append("<option value='" + areas[i][0] + "'>" + areas[i][1] + "</option>");
	        	}
	        }
	    }
	 }
	 <?php if ($output['goods']['province_id'] > 0){?>
	 	$('#province_id').val('<?php echo $output['goods']['province_id'];?>');
	 	$('#province_id').change();
	 	$('#city_id').val('<?php echo $output['goods']['city_id'];?>');
	 <?php }?>
	 
	var P_ID = '<?php echo $output['goods']['goods_id']; ?>';
	var TRANS_TYPE = '<?php echo $output['goods']['goods_transfee_charge']; ?>';
	var TRANS_ID = '<?php echo $output['goods']['transport_id']; ?>';
	if (P_ID != ''){
		if (TRANS_TYPE==1){
			$('#whops_seller').attr('checked',true);
			$('#whops_buyer_box').css('display','none');
		}else{
			if (TRANS_ID == '0'){
				$('#isApplyPostage_false').attr('checked',true);
				$('#py_price').val('<?php echo $output['goods']['py_price']; ?>');
				$('#kd_price').val('<?php echo $output['goods']['kd_price']; ?>');
				$('#es_price').val('<?php echo $output['goods']['es_price']==0?'':$output['goods']['es_price'];?>');
			}else{
				$('#postageName').html('<?php echo $output['goods']['transport_title'];?>').css('display','inline');
				$('#isApplyPostage_true').attr('checked',true);
				$('input[nc_type="transport"]').attr('disabled','disabled').css('background','#ECE9D8').val('');
				$('#Postage').css('display','');
			}
		}
	}	 
	 

	<?php if(C('spec_model')){?>
	$('span[nctype="pv_name"]').find('input').attr('disabled','disabled');
	<?php }?>
	
});

</script>