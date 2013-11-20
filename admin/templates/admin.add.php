<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['admin_index_admin_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=admin&op=admin"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="admin_name"><?php echo $lang['admin_index_username'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="admin_name" name="admin_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['admin_add_username_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="admin_password"><?php echo $lang['admin_inde_password'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="password" id="admin_password" name="admin_password" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['admin_add_password_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2"><table class="table tb-type2 nomargin">
              <thead>
                <tr class="space">
                  <th><?php echo $lang['admin_set_right_manage'];?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($output['function_array'] as $k => $v) { ?>
                <tr>
                  <td class="required"><input id="<?php echo $k;?>" type="checkbox" onclick="selectAll('<?php echo $k;?>')">
                    &nbsp;
                    <label for="<?php echo $k;?>"><?php echo $v[0];?></label></td>
                </tr>
                <tr class="noborder">
                  <td class="vatop rowform"><ul class="nofloat w830">
                      <?php for($i=1,$j=count($v);$i<$j;$i++) { ?>
                      <li class="left w18pre" style="width:auto; margin-left:10px;">
                        <input class="<?php echo $k;?>" type="checkbox" name="permission[<?php echo $v[$i][0];?>]" value="1" 
        <?php if(@in_array($v[$i][0],$output['admin_array']['admin_permission'])){ ?>checked="checked"<?php }?> >
                        &nbsp;
                        <label><?php echo $v[$i][1];?></label>
                      </li>
                      <?php } ?>
                    </ul></td>
                </tr>
                <?php } ?>
              </tbody>
            </table></td>
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
<script>
//按钮先执行验证再提交表
$(function(){$("#submitBtn").click(function(){
    if($("#add_form").valid()){
     $("#add_form").submit();
	}
	});
});
//
function selectAll(name){
    if($('#'+name).attr('checked') == true) {
        $('.'+name).attr('checked',true);
    }
    else {
        $('.'+name).attr('checked',false);
    }
}
$(document).ready(function(){
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            admin_name : {
                required : true,
				minlength: 3,
				maxlength: 20,
				remote	: {
                    url :'index.php?act=admin&op=ajax&branch=check_admin_name',
                    type:'get',
                    data:{
                    	admin_name : function(){
                            return $('#admin_name').val();
                        }
                    }
                }
            },
            admin_password : {
                required : true,
				minlength: 6,
				maxlength: 20
            }
        },
        messages : {
            admin_name : {
                required : '<?php echo $lang['admin_add_username_null'];?>',
				minlength: '<?php echo $lang['admin_add_username_max'];?>',
				maxlength: '<?php echo $lang['admin_add_username_max'];?>',
				remote	 : '<?php echo $lang['admin_add_admin_not_exists'];?>'
            },
            admin_password : {
                required : '<?php echo $lang['admin_add_password_null'];?>',
				minlength: '<?php echo $lang['admin_add_password_max'];?>',
				maxlength: '<?php echo $lang['admin_add_password_max'];?>'
            }
        }
	});
});
</script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.ipassword.js"></script> 
<script type="text/javascript">
$(document).ready(function(){	
	// to enable iPass plugin
	$("input[type=password]").iPass();
});	
</script> 
