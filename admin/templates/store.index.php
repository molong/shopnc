<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_audit" ><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="index.php?act=store_grade&op=store_grade_log" ><span><?php echo $lang['grade_apply']; ?></span></a></li>
        <li><a href="index.php?act=store&op=store_auth" ><span><?php echo $lang['store_auth_verify'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
  <input type="hidden" value="store" name="act">
  <input type="hidden" value="store" name="op">
  <table class="tb-type1 noborder search">
  <tbody>
    <tr>
      <th><label for="store_name"><?php echo $lang['store_name'];?></label></th>
      <td><input type="text" value="<?php echo $output['store_name'];?>" name="store_name" id="store_name" class="txt"></td>
      <th><label for="owner_and_name"><?php echo $lang['store_user'];?></label></th>
      <td><input type="text" value="<?php echo $output['owner_and_name'];?>" name="owner_and_name" id="owner_and_name" class="txt"></td>
      <th><label><?php echo $lang['belongs_level'];?></label></th>
      <td><select name="grade_id">
          <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
          <?php if(!empty($output['grade_list']) && is_array($output['grade_list'])){ ?>
          <?php foreach($output['grade_list'] as $k => $v){ ?>
          <option value="<?php echo $v['sg_id'];?>" <?php if($output['grade_id'] == $v['sg_id']){?>selected<?php }?>><?php echo $v['sg_name'];?></option>
          <?php } ?>
          <?php } ?>
        </select></td>
      <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
      <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
        <?php if($output['owner_and_name'] != '' or $output['store_name'] != '' or $output['grade_id'] != ''){?>
        <a href="index.php?act=store&op=store" class="btns tooltip" title="<?php echo $lang['nc_cancel_search'];?>"><span><?php echo $lang['nc_cancel_search'];?></span></a>
        <?php }?></td>
    </tr></tbody>
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
            <li><?php echo $lang['store_help1'];?></li>
            <li><?php echo $lang['store_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['store_name'];?></th>
          <th><?php echo $lang['store_user_name'];?></th>
          <th><?php echo $lang['location'];?></th>
          <th class="align-center"><?php echo $lang['belongs_level'];?></th>
          <th class="align-center"><?php echo $lang['period_to'];?></th>
          <th class="align-center"><?php echo $lang['state'];?></th>
          <th class="align-center"><?php echo $lang['recommended'];?></th>
          <th class="align-center"><?php echo $lang['operation'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
        <?php foreach($output['store_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td><input type="checkbox" value="<?php echo $v['store_id'];?>" name="del_id[]" class="checkitem"></td>
          <td class="w48 sort"><span title="<?php echo $lang['editable'];?>" fieldid="<?php echo $v['store_id'];?>"  ajax_branch='store_sort' fieldname="store_sort" nc_type="inline_edit" class="node_name editable"><?php echo $v['store_sort'];?></span></td>
          <td>
          	<a href="<?php echo SiteUrl;?>/index.php?act=show_store&id=<?php echo $v['store_id']?>" target="_blank">
          	<?php echo $v['store_name'];?>
          	</a>
          	&nbsp;
            <?php if($v['name_auth'] == 2 || $v['store_auth'] == 2){?>
            (<?php echo $lang['authing'];?>)
            <?php }?></td>
          <td><?php echo $v['member_name'];?></td>
          <td class="w150"><?php echo $v['area_info'];?></td>
          <td class="align-center"><?php echo $v['grade_name'];?></td>
          <td class="nowarp align-center"><?php echo $v['store_end_time'];?></td>
          <td class="align-center"><?php echo $v['state'];?></td>
          <td class="align-center yes-onoff">
            <a href="JavaScript:void(0);" class="tooltip <?php echo $v['store_recommend']? 'enabled':'disabled'?>" ajax_branch='store_recommend' <?php echo $v['store_state'] ? 'nc_type="inline_edit"':'';?> fieldname="store_recommend" fieldid="<?php echo $v['store_id']?>" fieldvalue="<?php echo $v['store_recommend']? 1:'0'?>" title="<?php echo $v['store_state'] ? $lang['editable'] : $lang['recommended_tips'];?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"></a></td>
          <td class="align-center"><a href="index.php?act=store&op=store_edit&store_id=<?php echo $v['store_id']?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['are_you_sure_del_store'];?>')){location.href='index.php?act=store&op=store_del&store_id=<?php echo $v['store_id']?>';}"><?php echo $lang['nc_del'];?></a></td>
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
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="batchEdit();"><span><?php echo $lang['nc_edit'];?></span></a>
            <div class="pagination"><?php echo $output['page'];?></div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script>
function batchEdit(){
	var id='';
	$('input[type=checkbox]:checked').each(function(){
		if(!isNaN($(this).val())){
			id += $(this).val()+'|';
		}
	});
	if(id == ''){
		alert('<?php echo $lang['please_sel_edit_store'];?>');
		return false;
	}
	location.href='index.php?act=store&op=store_batch_edit&id='+id;
	return true;
}
$(function(){
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('store');$('#formSearch').submit();
    });
});
</script> 
