<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_audit" ><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="index.php?act=store_grade&op=store_grade_log" ><span><?php echo $lang['grade_apply']; ?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit_all'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form1" id="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="id" value="<?php echo $output['id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['location'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><div class="select_add" id="region" style="width:500px;border:1px solide red;">
              <input type="hidden" name="area_id" id="area_id" value="" class="area_ids" />
              <input type="hidden" name="area_info" value="" class="area_names" />
              <select class="d_inline">
              </select>
            </div></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['belongs_level'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="grade_id" name="grade_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(is_array($output['grade_list'])){ ?>
              <?php foreach($output['grade_list'] as $k => $v){ ?>
              <option value="<?php echo $v['sg_id']; ?>"><?php echo $v['sg_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"><?php echo $lang['no_edit_please_no_choose'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['certification'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="radio" checked="checked" value="0" name="certification" id="certification0">
                <label for="certification0"><?php echo $lang['unchanged'];?></label>
              </li>
              <li>
                <input type="radio" value="1" name="certification" id="certification1">
                <label for="certification1"><?php echo $lang['to'];?></label>
                (
                <input type="checkbox" disabled="disabled" class="certification" value="1" id="name_auth" name="name_auth">
                <label for="name_auth"><?php echo $lang['owner_certification'];?></label>
                <input type="checkbox" disabled="disabled" class="certification" id="store_auth" value="1" name="store_auth">
                <label for="store_auth"><?php echo $lang['entity_store_certification'];?></label>
                )</li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['recommended'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="radio" checked="checked" value="-1" name="store_recommend" id="store_recommend-1">
                <label for="store_recommend-1"><?php echo $lang['unchanged'];?></label>
              </li>
              <li>
                <input type="radio" value="1" name="store_recommend" id="store_recommend1">
                <label for="store_recommend1"><?php echo $lang['nc_yes'];?></label>
              </li>
              <li>
                <input type="radio" value="0" name="store_recommend" id="store_recommend0">
                <label for="store_recommend0"><?php echo $lang['nc_no'];?></label>
              </li>
            </ul>
            </p></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="store_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="store_sort" name="store_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['no_edit_please_null'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>
<style type="text/css">
.d_inline{display:inline;}
</style>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
	regionInit("region");
	
	$("#submitBtn").click(function(){
    	if($("#store_form").valid()){
    		$("#store_form").submit();
		}
	});
	$('#store_form').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parentsUntil('tr').parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
		rules : {
			area_id: {
				checkarea : true
			}
		},
		messages : {
			area_id: {
				checkarea: '<?php echo $lang['please_input_address'];?>'
			}
		}
	});
	$('input[name=certification]').click(function(){
		if($(this).val() == 1){
			$('#name_auth').attr('disabled',false);
			$('#store_auth').attr('disabled',false);
		}else {
			$('#name_auth').attr('disabled',true);
			$('#store_auth').attr('disabled',true);
		}
	});
})
</script>