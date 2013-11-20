<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_index_goods'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['goods_index_all_goods'];?></span></a></li>
        <li><a href="index.php?act=goods&op=goods&goods_state=1" ><span><?php echo $lang['goods_index_lock_goods'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="goods">
    <input type="hidden" name="op" value="goods">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_goods_name"> <?php echo $lang['goods_index_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['search_goods_name'];?>" name="search_goods_name" id="search_goods_name" class="txt"></td>
          <th><label><?php echo $lang['goods_index_brand'];?></label></th>
          <td><select name="search_brand_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['brand_list']) && is_array($output['brand_list'])){ ?>
              <?php foreach($output['brand_list'] as $k => $v){ ?>
              <option value="<?php echo $v['brand_id'];?>" <?php if($output['search']['search_brand_id'] == $v['brand_id']){?>selected<?php }?>><?php echo $v['brand_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <th><label><?php echo $lang['goods_index_class_name'];?></label></th>
          <td id="gcategory"><input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select class="querySelect">
              <option><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
              <?php foreach($output['goods_class'] as $val) { ?>
              <option value="<?php echo $val['gc_id']; ?>" <?php if($output['search']['cate_id'] == $val['gc_id']){?>selected<?php }?>><?php echo $val['gc_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <th><label for="search_store_name"><?php echo $lang['goods_index_store_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['search_store_name'];?>" name="search_store_name" id="search_store_name" class="txt"></td>
          <th><label><?php echo $lang['goods_index_show'];?></label></th>
          <td><select name="search_show">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <option value="1" <?php if($output['search']['search_show'] == '1'){?>selected<?php }?>><?php echo $lang['nc_yes'];?></option>
              <option value="0" <?php if($output['search']['search_show'] == '0'){?>selected<?php }?>><?php echo $lang['nc_no'];?></option>
            </select></td>
          <th><label><?php echo $lang['goods_index_lock'];?></label></th>
          <td><select name="search_lock">
              <option><?php echo $lang['nc_please_choose'];?>...</option>
              <option value="1" <?php if($output['search']['search_lock'] == '1'){?>selected<?php }?>><?php echo $lang['nc_yes'];?></option>
              <option value="0" <?php if($output['search']['search_lock'] == '0'){?>selected<?php }?>><?php echo $lang['nc_no'];?></option>
            </select>
            <a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['goods_index_help1'];?></li>
            <li><?php echo $lang['goods_index_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_goods">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" id="type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th colspan="2"><?php echo $lang['goods_index_name'];?></th>
          <th class="w156"><?php echo $lang['goods_index_brand'];?></th>
          <th><?php echo $lang['goods_index_class_name'];?></th>
          <th class="align-center"><?php echo $lang['goods_index_lock'];?></th>
          <th class="align-center"><?php echo $lang['goods_index_click'];?></th>
          <th class="w48 align-center"><?php echo $lang['nc_handle'];?> </th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
        <?php foreach($output['goods_list'] as $k => $v){?>
        <tr class="hover edit">
          <td><input type="checkbox" name="del_id[]" value="<?php echo $v['goods_id'];?>" class="checkitem"></td>
          <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><img src="<?php echo thumb($v,'tiny');?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
          <td class="goods-name w270"><p><span title="<?php echo $lang['nc_editable'];?>" class="editable-tarea tooltip" required="1" ajax_branch_textarea="goods_name" fieldid="<?php echo $v['goods_id'];?>" fieldname="goods_name" nc_type="inline_edit_textarea"><?php echo $v['goods_name'];?></span></p>
            <p class="store"><?php echo $lang['goods_index_store_name'];?>:<?php echo $v['store_name'];?></p></td>
          <td><?php echo $v['brand_name'];?></td>
          <td><?php echo $v['gc_name'];?></td>
          <td class="align-center no-onoff">
            <a href="JavaScript:void(0);" class="<?php echo $v['goods_state']? 'enabled' : 'disabled' ;?>" ajax_branch="goods_state" nc_type="inline_edit" fieldname="goods_state" fieldid="<?php echo $v['goods_id']?>" fieldvalue="<?php echo $v['goods_state']? '1' : '0' ;?>" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"></a>
          </td>
          <td class="align-center"><?php echo $v['goods_click']?></td>
          <td class="align-center"><a href="<?php echo SiteUrl;?>/index.php?act=goods&goods_id=<?php echo $v['goods_id'];?>" target="_blank"><?php echo $lang['nc_view'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('recommend');"><span><?php echo $lang['nc_recommend'];?></span></a><a href="JavaScript:void(0);" class="btn" onclick="submit_form('edit');"><span><?php echo $lang['nc_edit'];?></span></a><a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
function submit_form(type){
	if(type=='del'){
		if(!confirm('<?php echo $lang['goods_index_ensure_handle'];?>?')){
			return false;
		}
	}
	$('#type').val(type);
	$('#form_goods').submit();
}
$(function(){
	gcategoryInit("gcategory");
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('goods');$('#formSearch').submit();
    });	
});
</script>
