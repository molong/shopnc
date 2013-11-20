<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_index_goods'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=goods&op=goods" ><span><?php echo $lang['goods_index_all_goods'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['goods_index_lock_goods'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="goods" />
    <input type="hidden" name="op" value="goods" />
    <input type="hidden" name="goods_state" value="1" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th> <label for="search_goods_name"><?php echo $lang['goods_index_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['search_goods_name'];?>" name="search_goods_name" id="search_goods_name" class="txt"></td>
          <th><label><?php echo $lang['goods_index_class_name'];?></label></th>
          <td id="gcategory"><input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
            <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            <select>
              <option><?php echo $lang['nc_please_choose'];?>...</option>
              <?php foreach($output['goods_class'] as $val) { ?>
              <option value="<?php echo $val['gc_id']; ?>" <?php if($output['search']['cate_id'] == $val['gc_id']){?>selected<?php }?>><?php echo $val['gc_name']; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <th><label for="search_store_name"><?php echo $lang['goods_index_store_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['search_store_name'];?>" name="search_store_name" id="search_store_name" class="txt"></td>
          <th><label><?php echo $lang['goods_index_brand'];?></label></th>
          <td><select name="search_brand_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(is_array($output['brand_list'])){ ?>
              <?php foreach($output['brand_list'] as $k => $v){ ?>
              <option value="<?php echo $v['brand_id'];?>" <?php if($output['search']['search_brand_id'] == $v['brand_id']){?>selected<?php }?>><?php echo $v['brand_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_goods">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="type" id="type" value="" />
    <input type="hidden" name="goods_state" id="goods_state" value="1" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th colspan="15"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th></th>
          <th colspan="2"><?php echo $lang['goods_index_name'];?></th>
          <th><?php echo $lang['goods_index_brand'];?></th>
          <th><?php echo $lang['goods_index_class_name'];?></th>
          <th class="align-center"><?php echo $lang['goods_index_lock'];?></th>
          <th class="align-center"><?php echo $lang['goods_index_click'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
        <?php foreach($output['goods_list'] as $k => $v){  ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name="del_id[]" value="<?php echo $v['goods_id'];?>" class="checkitem"></td>
          <td class="w60"><div class="goods-picture"><span class="thumb size-goods"><i></i><img src="<?php echo thumb($v,'tiny');?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
          <td class="goods-name w270"><p><span title="<?php echo $lang['nc_editable'];?>" class="editable-tarea tooltip" required="1" ajax_branch_textarea="goods_name" fieldid="<?php echo $v['goods_id'];?>" fieldname="goods_name" nc_type="inline_edit_textarea"><?php echo $v['goods_name'];?></span></p>
            <p class="store"><?php echo $lang['goods_index_store_name'];?>:<?php echo $v['store_name'];?></p></td>
          <td class="w156"><?php echo $v['brand_name'];?></td>
          <td><?php echo $v['gc_name'];?></td>
          <td class="align-center no-onoff"><?php if($v['goods_state'] == '0'){ ?>
            <a href="JavaScript:void(0);" class="tooltip disabled" ajax_branch="goods_state" nc_type="inline_edit" fieldname="goods_state" fieldid="<?php echo $v['goods_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"></a>
            <?php }else { ?>
            <a href="JavaScript:void(0);" class="tooltip enabled" ajax_branch="goods_state" nc_type="inline_edit" fieldname="goods_state" fieldid="<?php echo $v['goods_id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"></a>
            <?php } ?></td>
          <td class="align-center"><?php echo $v['goods_click']?></td>
          <td class="w48 align-center"><a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods');?>" target="_blank"><?php echo $lang['nc_view'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('edit');"><span><?php echo $lang['nc_edit'];?></span></a><a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
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
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('goods');$('#formSearch').submit();
    });	
});
</script>