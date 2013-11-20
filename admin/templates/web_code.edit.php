<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
h3.dialog_head {
	margin: 0 !important;
}
.dialog_content {
	width: 610px;
	padding: 0 15px 15px 15px !important;
	overflow: hidden;
}
</style>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['web_config_index'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=web_config&op=web_config"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=web_config&op=web_edit&web_id=<?php echo $_GET['web_id'];?>"><span><?php echo $lang['web_config_web_edit'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['web_config_code_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="tb-type1 noborder">
    <tbody>
      <tr>
        <th><label><?php echo $lang['web_config_web_name'];?>:</label></th>
        <td><label><?php echo $output['web_array']['web_name']?></label></td>
        <th><label><?php echo $lang['web_config_style_name'];?>:</label></th>
        <td><label><?php echo $output['style_array'][$output['web_array']['style_name']];?></label></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['web_config_edit_help1'];?></li>
            <li><?php echo $lang['web_config_edit_help2'];?></li>
            <li><?php echo $lang['web_config_edit_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nohover">
    <tbody>
      <tr>
        <td colspan="2" class="required"><label><?php echo $lang['web_config_edit_html'].$lang['nc_colon'];?></label></td>
      </tr>
      <tr class="noborder">
        <td colspan="2" class="vatop"><div class="home-templates-board-layout">
            <div class="left">
              <dl>
                <dt>
                  <h4><?php echo $lang['web_config_picture_tit'];?></h4>
                  <a href="JavaScript:show_dialog('upload_tit');"><?php echo $lang['nc_edit'];?></a></dt>
                <dd class="tit-pic">
                  <div id="picture_tit" class="picture">
                    <?php if(!empty($output['code_tit']['code_info']['pic'])){ ?>
                    <img src="<?php  echo SiteUrl.'/'.$output['code_tit']['code_info']['pic'];?>"/>
                    <?php } ?>
                  </div>
                </dd>
              </dl>
              <dl>
                <dt>
                  <h4><?php echo $lang['web_config_edit_category'];?></h4>
                  <a href="JavaScript:show_dialog('category_list');"><?php echo $lang['nc_edit'];?></a></dt>
                <dd class="category-list">
                  <?php if (is_array($output['code_category_list']['code_info']) && !empty($output['code_category_list']['code_info'])) { ?>
                  <?php foreach ($output['code_category_list']['code_info'] as $key => $val) { ?>
                  <dl>
                    <dt title="<?php echo $val['gc_parent']['gc_name'];?>"><?php echo $val['gc_parent']['gc_name'];?></dt>
                    <?php if (is_array($val['goods_class']) && !empty($val['goods_class'])) { ?>
                    <?php foreach ($val['goods_class'] as $k => $v) { ?>
                    <dd title="<?php echo $v['gc_name'];?>"><?php echo $v['gc_name'];?></dd>
                    <?php } ?>
                    <?php } ?>
                  </dl>
                  <?php } ?>
                  <?php }else { ?>
                  <dl>
                    <dt><?php echo $lang['web_config_category_name'];?></dt>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                  </dl>
                  <dl>
                    <dt><?php echo $lang['web_config_category_name'];?></dt>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                  </dl>
                  <dl>
                    <dt><?php echo $lang['web_config_category_name'];?></dt>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                    <dd><?php echo $lang['web_config_gc_name'];?></dd>
                  </dl>
                  <?php } ?>
                </dd>
              </dl>
              <dl>
                <dt>
                  <h4><?php echo $lang['web_config_picture_act'];?></h4>
                  <a href="JavaScript:show_dialog('upload_act');"><?php echo $lang['nc_edit'];?></a></dt>
                <dd class="act-pic">
                  <div id="picture_act" class="picture">
                    <?php if($output['code_act']['code_info']['type'] == 'adv' && $output['code_act']['code_info']['ap_id']>0){ ?>
                    <script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=<?php echo $output['code_act']['code_info']['ap_id'];?>"></script>
                    <?php }else { ?>
                    <img src="<?php  echo SiteUrl.'/'.$output['code_act']['code_info']['pic'];?>"/>
                    <?php } ?>
                  </div>
                </dd>
              </dl>
            </div>
            <div class="middle">
              <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
              <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
              <dl recommend_id="<?php echo $key;?>">
                <dt>
                  <h4><?php echo $val['recommend']['name'];?></h4>
                  <?php if($key > 1){ ?>
                  <a href="JavaScript:del_recommend(<?php echo $key;?>);"><?php echo $lang['nc_del'];?></a>
                  <?php } ?>
                  <a href="JavaScript:show_recommend_dialog(<?php echo $key;?>);"><?php echo $lang['nc_edit'];?></a></dt>
                <dd>
                  <ul class="goods-list">
                    <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])){ ?>
                    <?php foreach($val['goods_list'] as $k => $v){ ?>
                    <li>
                      <div class="goods-pic"><span class="thumb size-106x106"><i></i><img title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:SiteUrl."/".$v['goods_pic'];?>" onload="javascript:DrawImage(this,106,106);" /></span></div>
                    </li>
                    <?php } ?>
                    <?php } ?>
                  </ul>
                </dd>
              </dl>
              <?php } ?>
              <?php } ?>
              <div class="add-tab" id="btn_add_list"><a class="btn-add-nofloat" href="JavaScript:add_recommend();"><?php echo $lang['web_config_add_recommend'];?></a><?php echo $lang['web_config_recommend_max'];?></div>
            </div>
            <div class="right">
              <dl id="goods_order_list">
                <dt>
                  <h4><?php echo !empty($output['code_goods_list']['code_info']['name']) ? $output['code_goods_list']['code_info']['name']:$lang['web_config_goods_order'];?></h4>
                  <a href="JavaScript:show_dialog('goods_list');"><?php echo $lang['nc_edit'];?></a></dt>
                <dd class="top-list">
                  <ol>
                    <?php if(!empty($output['code_goods_list']['code_info']['goods']) && is_array($output['code_goods_list']['code_info']['goods'])){ 
					        	$i = 0;
					        	?>
                    <?php foreach($output['code_goods_list']['code_info']['goods'] as $k => $v){ 
							        	$i++;
							        	?>
                    <?php if($i <= 3){ ?>
                    <li class="goods-list">
                      <div class="goods-pic"> <img select_goods_id="<?php echo $v['goods_id'];?>" title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:SiteUrl."/".$v['goods_pic'];?>" onload="javascript:DrawImage(this,60,60);" /></div>
                      <div class="goods-name"><?php echo $v['goods_name'];?></div>
                      <div class="goods-price"><em><?php echo $v['goods_price'];?></em></div>
                    </li>
                    <?php }else { ?>
                    <li><?php echo $v['goods_name'];?></li>
                    <?php } ?>
                    <?php } ?>
                    <?php }else { ?>
                    <li>
                      <div class="goods-pic"></div>
                      <div class="goods-name"><?php echo $lang['web_config_goods_name'];?></div>
                      <div class="goods-price"><?php echo $lang['web_config_goods_price'];?></div>
                    </li>
                    <li>
                      <div class="goods-pic"></div>
                      <div class="goods-name"><?php echo $lang['web_config_goods_name'];?></div>
                      <div class="goods-price"><?php echo $lang['web_config_goods_price'];?></div>
                    </li>
                    <li>
                      <div class="goods-pic"></div>
                      <div class="goods-name"><?php echo $lang['web_config_goods_name'];?></div>
                      <div class="goods-price"><?php echo $lang['web_config_goods_price'];?></div>
                    </li>
                    <li><?php echo $lang['web_config_goods_name'];?></li>
                    <li><?php echo $lang['web_config_goods_name'];?></li>
                    <li><?php echo $lang['web_config_goods_name'];?></li>
                    <li><?php echo $lang['web_config_goods_name'];?></li>
                    <?php } ?>
                  </ol>
                </dd>
              </dl>
              <dl>
                <dt>
                  <h4><?php echo $lang['web_config_picture_adv'];?></h4>
                  <a href="JavaScript:show_dialog('upload_adv');"><?php echo $lang['nc_edit'];?></a></dt>
                <dd class="adv-pic">
                  <div id="picture_adv" class="picture">
                    <?php if($output['code_adv']['code_info']['type'] == 'adv' && $output['code_adv']['code_info']['ap_id']>0){ ?>
                    <script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=<?php echo $output['code_adv']['code_info']['ap_id'];?>"></script>
                    <?php }else { ?>
                    <img src="<?php echo SiteUrl.'/'.$output['code_adv']['code_info']['pic'];?>"/>
                    <?php } ?>
                  </div>
                </dd>
              </dl>
            </div>
            <div class="bottom">
              <dl>
                <dt>
                  <h4><?php echo $lang['web_config_brand_list'];?></h4>
                  <a href="JavaScript:show_dialog('brand_list');"><?php echo $lang['nc_edit'];?></a></dt>
                </dt>
                <dd>
                  <ul class="brands">
                    <?php if (is_array($output['code_brand_list']['code_info']) && !empty($output['code_brand_list']['code_info'])) { ?>
                    <?php foreach ($output['code_brand_list']['code_info'] as $key => $val) { ?>
                    <li>
                      <div class="picture"> <img width="88" height="44" title="<?php echo $val['brand_name'];?>" src="<?php echo SiteUrl.'/'.$val['brand_pic'];?>" onload="javascript:DrawImage(this,88,44);" /> </div>
                    </li>
                    <?php } ?>
                    <?php }else { ?>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <li>
                      <div class="picture"></div>
                    </li>
                    <?php } ?>
                  </ul>
                </dd>
              </dl>
            </div>
          </div></td>
      </tr>
    </tbody>
    <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="index.php?act=web_config&op=web_html&web_id=<?php echo $_GET['web_id'];?>" class="btn" id="submitBtn"><span><?php echo $lang['web_config_web_html'];?></span></a></td>
        </tr>
      </tfoot>
  </table>
</div>

<!-- 标题图片 -->
<div id="upload_tit_dialog" style="display:none;">
  <table class="table tb-type2">
    <tbody>
      <tr class="space odd" id="prompt">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['web_config_prompt_tit'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="upload_tit_form" name="upload_tit_form" enctype="multipart/form-data" method="post" action="index.php?act=web_api&op=upload_pic" target="upload_pic">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="web_id" value="<?php echo $output['code_tit']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_tit']['code_id'];?>">
    <input type="hidden" name="tit[pic]" value="<?php echo $output['code_tit']['code_info']['pic'];?>">
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['web_config_upload_tit'].$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="pic" id="pic" type="file" class="type-file-file" size="30">
            </span></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_tit_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['web_config_upload_url'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="tit[url]" value="<?php echo !empty($output['code_tit']['code_info']['url']) ? $output['code_tit']['code_info']['url']:SiteUrl;?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_url_tips'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" onclick="$('#upload_tit_form').submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<!-- 推荐分类模块 -->
<div id="category_list_dialog" style="display:none;">
  <div class="dialog-handle">
    <h4 class="dialog-handle-title"><?php echo $lang['web_config_category_title'];?></h4>
    <p><span class="handle">
      <select name="gc_parent_id" id="gc_parent_id" class=" w200" onchange="get_goods_class();">
        <option value="0">-<?php echo $lang['nc_please_choose'];?>-</option>
        <?php if(!empty($output['parent_goods_class']) && is_array($output['parent_goods_class'])){ ?>
        <?php foreach($output['parent_goods_class'] as $k => $v){ ?>
        <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
        <?php } ?>
        <?php } ?>
      </select>
      </span> <span class="note"><?php echo $lang['web_config_category_note'];?></span></p>
  </div>
  <form id="category_list_form">
    <input type="hidden" name="web_id" value="<?php echo $output['code_category_list']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_category_list']['code_id'];?>">
      <div class="s-tips"><i></i><?php echo $lang['web_config_category_tips'];?></div>
    <div class="category-list category-list-edit">
      <?php if (is_array($output['code_category_list']['code_info']) && !empty($output['code_category_list']['code_info'])) { ?>
      <?php foreach ($output['code_category_list']['code_info'] as $key => $val) { ?>
      <dl>
        <dt select_class_id="<?php echo $val['gc_parent']['gc_id'];?>" title="<?php echo $val['gc_parent']['gc_name'];?>" ondblclick="del_gc_parent(<?php echo $val['gc_parent']['gc_id'];?>);">
        	<i onclick="del_gc_parent(<?php echo $val['gc_parent']['gc_id'];?>);"></i><?php echo $val['gc_parent']['gc_name'];?></dt>
        <div class="clear"></div>
        <input name="category_list[<?php echo $val['gc_parent']['gc_id'];?>][gc_parent][gc_id]" value="<?php echo $val['gc_parent']['gc_id'];?>" type="hidden">
        <input name="category_list[<?php echo $val['gc_parent']['gc_id'];?>][gc_parent][gc_name]" value="<?php echo $val['gc_parent']['gc_name'];?>" type="hidden">
        <?php if(!empty($val['goods_class']) && is_array($val['goods_class'])){ ?>
        <?php foreach($val['goods_class'] as $k => $v){ ?>
        <dd gc_id="<?php echo $v['gc_id'];?>" title="<?php echo $v['gc_name'];?>" ondblclick="del_goods_class(<?php echo $v['gc_id'];?>);">
        	<i onclick="del_goods_class(<?php echo $v['gc_id'];?>);"></i><?php echo $v['gc_name'];?>
          <input name="category_list[<?php echo $val['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_id]" value="<?php echo $v['gc_id'];?>" type="hidden">
          <input name="category_list[<?php echo $val['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_name]" value="<?php echo $v['gc_name'];?>" type="hidden">
        </dd>
        <?php } ?>
        <?php } ?>
      </dl>
      <?php } ?>
      <?php } ?>
    </div>
    <a href="JavaScript:void(0);" onclick="update_category();" class="btn ml30"><span><?php echo $lang['web_config_save'];?></span></a>
  </form>
</div>
<!-- 活动图片 -->
<div id="upload_act_dialog" class="upload_act_dialog" style="display:none;">
  <table class="table tb-type2">
    <tbody>
      <tr class="space odd" id="prompt">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['web_config_prompt_act'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="upload_act_form" name="upload_act_form" enctype="multipart/form-data" method="post" action="index.php?act=web_api&op=upload_pic" target="upload_pic">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="web_id" value="<?php echo $output['code_act']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_act']['code_id'];?>">
    <input type="hidden" name="act[pic]" value="<?php echo $output['code_act']['code_info']['pic'];?>">
	  <table class="table tb-type2" id="upload_adv_type">
	    <tbody>
	      <tr>
	        <td colspan="2" class="required"><?php echo $lang['web_config_upload_type'].$lang['nc_colon'];?>
	          </td>
	      </tr>
	      <tr class="noborder">
	        <td class="vatop rowform">
	        	<label title="<?php echo $lang['web_config_upload_pic'];?>">
	        		<input type="radio" name="act[type]" value="pic" onclick="adv_type('act');" <?php if($output['code_act']['code_info']['type'] != 'adv'){ ?>checked="checked"<?php } ?>>
	        	<span><?php echo $lang['web_config_upload_pic'];?></span></label>
	          <label title="<?php echo $lang['web_config_upload_adv'];?>">
	          	<input type="radio" name="act[type]" value="adv" onclick="adv_type('act');" <?php if($output['code_act']['code_info']['type'] == 'adv'){ ?>checked="checked"<?php } ?>>
	          	<span><?php echo $lang['web_config_upload_adv'];?></span></label>
	        </td>
	        <td class="vatop tips"></td>
	      </tr>
	  </tbody>
	  </table>
    <table class="table tb-type2" id="upload_act_type_pic" <?php if($output['code_act']['code_info']['type'] == 'adv'){ ?>style="display:none;"<?php } ?>>
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['web_config_upload_act'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="pic" id="pic" type="file" class="type-file-file" size="30">
            </span></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_act_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['web_config_upload_url'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="act[url]" value="<?php echo !empty($output['code_act']['code_info']['url']) ? $output['code_act']['code_info']['url']:SiteUrl;?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_act_url'];?></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2" id="upload_act_type_adv" <?php if($output['code_act']['code_info']['type'] != 'adv'){ ?>style="display:none;"<?php } ?>>
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform">
		        <select name="act[ap_id]" class="w200">
		          <option value="0">-<?php echo $lang['nc_please_choose'];?>-</option>
		          <?php if(!empty($output['act_adv_list']) && is_array($output['act_adv_list'])){ ?>
		          <?php foreach($output['act_adv_list'] as $k => $v){ ?>
		          <option value="<?php echo $v['ap_id'];?>" <?php if($output['code_act']['code_info']['ap_id'] == $v['ap_id']){ ?>selected<?php } ?>><?php echo $v['ap_name'];?></option>
		          <?php } ?>
		          <?php } ?>
		        </select>
          	</td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_act_adv'];?></td>
        </tr>
	  	</tbody>
    </table>
    <a href="JavaScript:void(0);" onclick="$('#upload_act_form').submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a>
  </form>
</div>
<!-- 商品推荐模块 -->
<div id="recommend_list_dialog" style="display:none;">
  <form id="recommend_list_form">
    <input type="hidden" name="web_id" value="<?php echo $output['code_recommend_list']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_recommend_list']['code_id'];?>">
    <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
    <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
    <dl select_recommend_id="<?php echo $key;?>">
      <dt>
        <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_title'];?></h4>
        <div class="dialog-handle-box"><span class="left">
          <input name="recommend_list[<?php echo $key;?>][recommend][name]" value="<?php echo $val['recommend']['name'];?>" type="text" class="w200">
          </span><span class="right"><?php echo $lang['web_config_recommend_tips'];?></span>
          <div class="clear"></div>
        </div>
      </dt>
      <dd>
        <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_goods'];?></h4>
          <div class="s-tips"><i></i><?php echo $lang['web_config_recommend_goods_tips'];?></div>
        <ul class="dialog-goodslist-s1 goods-list">
          <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])){ ?>
          <?php foreach($val['goods_list'] as $k => $v){ ?>
          <li>
            <div ondblclick="del_recommend_goods(<?php echo $v['goods_id'];?>);" class="goods-pic">
            <span class="ac-ico" onclick="del_recommend_goods(<?php echo $v['goods_id'];?>);"></span> <span class="thumb size-72x72"><i></i><img select_goods_id="<?php echo $v['goods_id'];?>" title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:SiteUrl."/".$v['goods_pic'];?>" onload="javascript:DrawImage(this,72,72);" /></span></div>
            <div class="goods-name"><a href="<?php echo SiteUrl."/index.php?act=goods&goods_id=".$v['goods_id'];?>" target="_blank"><?php echo $v['goods_name'];?></a></div>
            <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_id]" value="<?php echo $v['goods_id'];?>" type="hidden">
            <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][store_id]" value="<?php echo $v['store_id'];?>" type="hidden">
            <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_name]" value="<?php echo $v['goods_name'];?>" type="hidden">
            <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_price]" value="<?php echo $v['goods_price'];?>" type="hidden">
            <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_pic]" value="<?php echo $v['goods_pic'];?>" type="hidden">
          </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </dd>
    </dl>
    <?php } ?>
    <?php } ?>
    <div id="add_recommend_list" style="display:none;"></div>
    <h4 class="dialog-handle-title"><?php echo $lang['web_config_recommend_add_goods'];?></h4>
    <div class="dialog-show-box">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label><?php echo $lang['web_config_recommend_gcategory'];?></label></th>
          <td class="dialog-select-bar" id="recommend_gcategory">
		        <input type="hidden" id="cate_id" name="cate_id" value="0" class="mls_id" />
		        <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
		        <select>
		          <option value="0">-<?php echo $lang['nc_please_choose'];?>-</option>
		          <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
		          <?php foreach($output['goods_class'] as $k => $v){ ?>
		          <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
		          <?php } ?>
		          <?php } ?>
		        </select>
		      </td>
        </tr>
        <tr>
          <th><label for="recommend_goods_name"><?php echo $lang['web_config_recommend_goods_name'];?></label></th>
          <td><input type="text" value="" name="recommend_goods_name" id="recommend_goods_name" class="txt">
		        <a href="JavaScript:void(0);" onclick="get_recommend_goods();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>"></a> 
          	</td>
        </tr>
      </tbody>
    </table>
      <div id="show_recommend_goods_list" class="show-recommend-goods-list"></div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <a href="JavaScript:void(0);" onclick="update_recommend();" class="btn"><span><?php echo $lang['web_config_save'];?></span></a>
  </form>
</div>
<!-- 排行类型模块 -->
<div id="goods_list_dialog" style="display:none;">
  <form id="goods_list_form">
    <input type="hidden" name="web_id" value="<?php echo $output['code_goods_list']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_goods_list']['code_id'];?>">
    <dl>
      <dt>
        <h4 class="dialog-handle-title"><?php echo $lang['web_config_goods_order_title'];?></h4>
        <div class="dialog-handle-box"><span class="left">
          <input name="goods_list[name]" value="<?php echo !empty($output['code_goods_list']['code_info']['name']) ? $output['code_goods_list']['code_info']['name']:$lang['web_config_goods_order'];?>" type="text" class="w200">
          </span><span class="right"><?php echo $lang['web_config_goods_order_tips'];?></span>
          <div class="clear"></div>
        </div>
      </dt>
      <dd class="top-list">
        <h4 class="dialog-handle-title"><?php echo $lang['web_config_goods_list'];?></h4>
          <div class="s-tips"><i></i><?php echo $lang['web_config_goods_list_tips'];?></div>
        <ul class="dialog-goodslist-s3">
          <?php if(!empty($output['code_goods_list']['code_info']['goods']) && is_array($output['code_goods_list']['code_info']['goods'])){ ?>
          <?php foreach($output['code_goods_list']['code_info']['goods'] as $k => $v){ ?>
          <li>
            <div ondblclick="del_goods_order(<?php echo $v['goods_id'];?>);" class="goods-pic"><span class="ac-ico" onclick="del_goods_order(<?php echo $v['goods_id'];?>);"></span><span class="thumb size-64x64"><i></i><img select_goods_id="<?php echo $v['goods_id'];?>" goods_price="<?php echo $v['goods_price'];?>" title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:SiteUrl."/".$v['goods_pic'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
            <div class="goods-name"><a href="<?php echo SiteUrl."/index.php?act=goods&goods_id=".$v['goods_id'];?>" target="_blank"><?php echo $v['goods_name'];?></a></div>
            <input name="goods_list[goods][<?php echo $v['goods_id'];?>][goods_id]" value="<?php echo $v['goods_id'];?>" type="hidden">
            <input name="goods_list[goods][<?php echo $v['goods_id'];?>][store_id]" value="<?php echo $v['store_id'];?>" type="hidden">
            <input name="goods_list[goods][<?php echo $v['goods_id'];?>][goods_name]" value="<?php echo $v['goods_name'];?>" type="hidden">
            <input name="goods_list[goods][<?php echo $v['goods_id'];?>][goods_price]" value="<?php echo $v['goods_price'];?>" type="hidden">
            <input name="goods_list[goods][<?php echo $v['goods_id'];?>][goods_pic]" value="<?php echo $v['goods_pic'];?>" type="hidden">
          </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </dd>
    </dl>
    <h4 class="dialog-handle-title"><?php echo $lang['web_config_goods_order_add'];?></h4>
    <div class="dialog-show-box">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label><?php echo $lang['web_config_goods_order_gcategory'];?></label></th>
          <td colspan="3" class="dialog-select-bar" id="gcategory">
		        <input type="hidden" id="cate_id" name="cate_id" value="0" class="mls_id" />
		        <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
		        <select>
		          <option value="0">-<?php echo $lang['nc_please_choose'];?>-</option>
		          <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
		          <?php foreach($output['goods_class'] as $k => $v){ ?>
		          <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
		          <?php } ?>
		          <?php } ?>
		        </select>
		      </td>
        </tr>
        <tr>
          <th><label><?php echo $lang['web_config_goods_order_type'];?></label></th>
          <td>
          	<select name="goods_order" id="goods_order">
              <option value="salenum" selected><?php echo $lang['web_config_goods_order_sale'];?></option>
              <option value="goods_click" ><?php echo $lang['web_config_goods_order_click'];?></option>
              <option value="commentnum" ><?php echo $lang['web_config_goods_order_comment'];?></option>
              <option value="goods_collect" ><?php echo $lang['web_config_goods_order_collect'];?></option>
            </select>
          	</td>
          <th><label for="order_goods_name"><?php echo $lang['web_config_goods_order_name'];?></label></th>
          <td><input type="text" value="" name="order_goods_name" id="order_goods_name" class="txt">
		        <a href="JavaScript:void(0);" onclick="get_goods_list();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>"></a> 
          	</td>
        </tr>
      </tbody>
    </table>
      <div id="show_goods_order_list"></div>
    </div>
    <a href="JavaScript:void(0);" onclick="update_goods_order();" class="btn"><span><?php echo $lang['web_config_save'];?></span></a>
  </form>
</div>
<!-- 品牌模块 -->
<div id="brand_list_dialog" class="brand_list_dialog" style="display:none;">
  <form id="brand_list_form">
    <input type="hidden" name="web_id" value="<?php echo $output['code_brand_list']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_brand_list']['code_id'];?>">
    <dd>
      <h4 class="dialog-handle-title"><?php echo $lang['web_config_brand_title'];?></h4>
          <div class="s-tips"><i></i><?php echo $lang['web_config_brand_tips'];?></div>
      <ul class="brands dialog-brandslist-s1">
        <?php if (is_array($output['code_brand_list']['code_info']) && !empty($output['code_brand_list']['code_info'])) { ?>
        <?php foreach ($output['code_brand_list']['code_info'] as $key => $val) { ?>
        <li>
          <div class="brands-pic"><span class="ac-ico" onclick="del_brand(<?php echo $val['brand_id'];?>);"></span><span class="thumb size-68x34"><i></i><img ondblclick="del_brand(<?php echo $val['brand_id'];?>);" select_brand_id="<?php echo $val['brand_id'];?>" src="<?php  echo SiteUrl.'/'.$val['brand_pic'];?>" onload="javascript:DrawImage(this,68,34);" /></span></div>
          <div class="brands-name"><?php echo $val['brand_name'];?></div>
          <input name="brand_list[<?php echo $val['brand_id'];?>][brand_id]" value="<?php echo $val['brand_id'];?>" type="hidden">
          <input name="brand_list[<?php echo $val['brand_id'];?>][brand_name]" value="<?php echo $val['brand_name'];?>" type="hidden">
          <input name="brand_list[<?php echo $val['brand_id'];?>][brand_pic]" value="<?php  echo $val['brand_pic'];?>" type="hidden">
        </li>
        <?php } ?>
        <?php } ?>
      </ul>
    </dd>
    <h4 class="dialog-handle-title"><?php echo $lang['web_config_brand_list'];?></h4>
    <div class="dialog-show-box">
    <div id="show_brand_list"></div></div>
    
    <a href="JavaScript:void(0);" onclick="update_brand();" class="btn"><span><?php echo $lang['web_config_save'];?></span></a>
  </form>
</div>
<!-- 广告图片 -->
<div id="upload_adv_dialog" class="upload_adv_dialog" style="display:none;">
  <table class="table tb-type2">
    <tbody>
      <tr class="space odd" id="prompt">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['web_config_upload_adv_tips'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="upload_adv_form" name="upload_adv_form" enctype="multipart/form-data" method="post" action="index.php?act=web_api&op=upload_pic" target="upload_pic">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="web_id" value="<?php echo $output['code_adv']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_adv']['code_id'];?>">
    <input type="hidden" name="adv[pic]" value="<?php echo $output['code_adv']['code_info']['pic'];?>">
	  <table class="table tb-type2" id="upload_adv_type">
	    <tbody>
	      <tr>
	        <td colspan="2" class="required"><?php echo $lang['web_config_upload_type'].$lang['nc_colon'];?>
	          </td>
	      </tr>
	      <tr class="noborder">
	        <td class="vatop rowform">
	        	<label title="<?php echo $lang['web_config_upload_pic'];?>">
	        		<input type="radio" name="adv[type]" value="pic" onclick="adv_type('adv');" <?php if($output['code_adv']['code_info']['type'] != 'adv'){ ?>checked="checked"<?php } ?>>
	        	<span><?php echo $lang['web_config_upload_pic'];?></span></label>
	          <label title="<?php echo $lang['web_config_upload_adv'];?>">
	          	<input type="radio" name="adv[type]" value="adv" onclick="adv_type('adv');" <?php if($output['code_adv']['code_info']['type'] == 'adv'){ ?>checked="checked"<?php } ?>>
	          	<span><?php echo $lang['web_config_upload_adv'];?></span></label>
	        </td>
	        <td class="vatop tips"></td>
	      </tr>
	  </tbody>
	  </table>
    <table class="table tb-type2" id="upload_adv_type_pic" <?php if($output['code_adv']['code_info']['type'] == 'adv'){ ?>style="display:none;"<?php } ?>>
      <tbody>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['web_config_upload_adv_pic'].$lang['nc_colon'];?></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type='text' name='textfield' id='textfield1' class='type-file-text' />
            <input type='button' name='button' id='button1' value='' class='type-file-button' />
            <input name="pic" id="pic" type="file" class="type-file-file" size="30">
            </span></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_pic_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['web_config_upload_adv_url'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="adv[url]" value="<?php echo !empty($output['code_adv']['code_info']['url']) ? $output['code_adv']['code_info']['url']:SiteUrl;?>" class="txt" type="text"></td>
          <td class="vatop tips"><?php echo $lang['web_config_upload_pic_url_tips'];?></td>
        </tr>
      </tbody>
	  </table>
    <table class="table tb-type2" id="upload_adv_type_adv" <?php if($output['code_adv']['code_info']['type'] != 'adv'){ ?>style="display:none;"<?php } ?>>
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform">
		        <select name="adv[ap_id]" class="w200">
		          <option value="0">-<?php echo $lang['nc_please_choose'];?>-</option>
		          <?php if(!empty($output['adv_list']) && is_array($output['adv_list'])){ ?>
		          <?php foreach($output['adv_list'] as $k => $v){ ?>
		          <option value="<?php echo $v['ap_id'];?>" <?php if($output['code_adv']['code_info']['ap_id'] == $v['ap_id']){ ?>selected<?php } ?>><?php echo $v['ap_name'];?></option>
		          <?php } ?>
		          <?php } ?>
		        </select>
          	</td>
          <td class="vatop tips"><?php echo $lang['web_config_adv_url_tips'];?></td>
        </tr>
	  	</tbody>
    </table>
    <a href="JavaScript:void(0);" onclick="$('#upload_adv_form').submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a>
  </form>
</div>
<iframe style="display:none;" src="" name="upload_pic"></iframe>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.ajaxContent.pack.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/web_config/web_index.js" charset="utf-8"></script> 