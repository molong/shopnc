<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_class_index_class'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=goods_class&op=goods_class"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=goods_class&op=goods_class_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=goods_class&op=goods_class_export" ><span><?php echo $lang['goods_class_index_export'];?></span></a></li>
        <li><a href="index.php?act=goods_class&op=goods_class_import" ><span><?php echo $lang['goods_class_index_import'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['goods_class_index_tag'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['goods_class_tag_prompts_one'];?></li>
            <li><?php echo $lang['goods_class_tag_prompts_two'];?></li>
            <li><?php echo $lang['goods_class_tag_prompts_three'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_tag">
    <input type="hidden" value="ok" name="form_submit" />
    <input type="hidden" value="" id="submit_type" name="submit_type" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w33pre"><?php echo $lang['goods_class_tag_name'];?></th>
          <th><?php echo $lang['goods_class_tag_value'];?></th>
          <th class="w48"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['tag_list']) && is_array($output['tag_list'])){ ?>
        <?php foreach($output['tag_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><input class="checkitem" type="checkbox" value="<?php echo $v['gc_tag_id'];?>" name="tag_id[]"></td>
          <td class="name"><?php echo $v['gc_tag_name'];?></td>
          <td class="tag"><span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['gc_tag_id'];?>" ajax_branch="goods_class_tag_value" fieldname="gc_tag_value" nc_type="inline_edit" class="tooltip editable"><?php echo $v['gc_tag_value'];?></span></td>
          <td><a href="javascript:if(confirm('<?php echo $lang['goods_class_tag_del_confirm'];?>'))window.location = 'index.php?act=goods_class&op=tag_del&tag_id=<?php echo $v['gc_tag_id']?>';"><?php echo $lang['nc_del'];?></a></td>
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
          <td><input id="checkallBottom" class="checkall" type="checkbox"></td>
          <td colspan="18"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="submit_form('del')"><span><?php echo $lang['nc_del'];?></span></a> <a href="JavaScript:void(0);" class="btn" onclick="$('#dialog').show();location.href='index.php?act=goods_class&op=update_tag_name'"><span><?php echo $lang['goods_class_tag_update'];?></span></a> <a class="btn" href="JavaScript:void(0);" onclick="if(confirm('<?php echo $lang['goods_class_tag_reset_confirm'];?>')){location.href='index.php?act=goods_class&op=reset_tag'}"> <span><?php echo $lang['goods_class_tag_reset'];?></span> </a>
            <?php if(!empty($output['tag_list']) && is_array($output['tag_list'])){ ?>
            <div class="pagination"> <?php echo $output['page'];?> </div>
            <?php } ?></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<div id="dialog" style="display: none; top: 344px; left: 430px;"><?php echo $lang['goods_class_tag_update_prompt'];?></div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.goods_class.js" charset="utf-8"></script> 
<script type="text/javascript">
function submit_form(type){
	var id='';
	$('input[type=checkbox]:checked').each(function(){
		if(!isNaN($(this).val())){
			id += $(this).val();
		}
	});
	if(id == ''){
		alert('<?php echo $lang['goods_class_tag_choose_data'];?>');
		return false;
	}
	if(type == 'del'){
		if(!confirm('<?php echo $lang['goods_class_tag_del_confirm'];?>')){
			return false;
		}
	}
	$('#submit_type').val(type);
	$('#form_tag').submit();
}
</script>