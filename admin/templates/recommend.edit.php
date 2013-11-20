<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['recommend_index_type'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=recommend&op=recommend" ><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=recommend&op=recommend_add" ><span><?php echo $lang['nc_add'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="form_add" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="recommend_id" value="<?php echo $output['recommend_array']['recommend_id'];?>" />
    <input type="hidden" name="config_name" value="css_class,width,height,limit" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="recommend_name"><?php echo $lang['recommend_index_type_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['recommend_array']['recommend_name'];?>" id="recommend_name" name="recommend_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['recommend_index_type_name'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="css_class"><?php echo $lang['recommend_css_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['config_array']['css_class'];?>" id="css_class" name="css_class" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['recommend_css_class_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="width"><?php echo $lang['recommend_add_width'];?></label>
            -
            <label for="height"><?php echo $lang['recommend_add_height'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['config_array']['width'];?>" name="width" id="width" class="txt2">
            -&nbsp;&nbsp;
            <input type="text" value="<?php echo $output['config_array']['height'];?>" name="height" id="height" class="txt2"></td>
          <td class="vatop tips"><?php echo $lang['recommend_css_class_px'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="limit"><?php echo $lang['recommend_add_limit'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['config_array']['limit'];?>" name="limit" id="limit" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['recommend_add_limit_max'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="recommend_desc"><?php echo $lang['recommend_desc'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea rows="6" class="tarea" name="recommend_desc" id="recommend_desc"><?php echo $output['recommend_array']['recommend_desc'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="recommend_http"><?php echo $lang['recommend_http'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea rows="6" class="tarea" id="recommend_http" readonly="readonly" onclick="this.select()"><script type="text/javascript" src="<?php echo SiteUrl;?>/api/goods/index.php?id=<?php echo $output['recommend_array']['recommend_id'];?>"></script></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#form_add").valid()){
     $("#form_add").submit();
	}
	});
});
//
$(document).ready(function(){
	$("#form_add").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            recommend_name : {
                required : true,
                remote   : {
               	url :'index.php?act=recommend&op=ajax&type=check_recommend',
                type:'get',
                data:{
                    brand_name : function(){
                        return $('#recommend_name').val();
                        },
                    	id  : '<?php echo $output['recommend_array']['recommend_id'];?>'
                    }
                }
            },
            css_class : {
                required : true
            },
            width : {
                required : true,
                digits   : true
            },
            height : {
                required : true,
                digits   : true
            },
            limit : {
                required : true,
                digits   : true,
                min    :1,
                max    :20
            }
        },
        messages : {
            recommend_name : {
                required : '<?php echo $lang['recommend_add_name_null'];?>',
                remote   : '<?php echo $lang['recommend_add_name_exists'];?>'
            },
            css_class  : {

                required   : '<?php echo $lang['recommend_css_class_null'];?>'
            },
            width  : {
                required : '<?php echo $lang['recommend_add_width_int'];?>',
                digits   : '<?php echo $lang['recommend_add_width_int'];?>'
            },
            height  : {
                required : '<?php echo $lang['recommend_add_height_int'];?>',
                digits   : '<?php echo $lang['recommend_add_height_int'];?>'
            },
            limit  : {
                required : '<?php echo $lang['recommend_add_limit_int'];?>',
                digits   : '<?php echo $lang['recommend_add_limit_int'];?>',
                min    :'<?php echo $lang['recommend_add_limit_minerror'];?>',
                max    :'<?php echo $lang['recommend_add_limit_maxerror'];?>'
            }
        }
	});
});
</script>