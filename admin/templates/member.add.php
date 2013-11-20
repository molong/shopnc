<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['member_index_manage']?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=member&op=member" ><span><?php echo $lang['nc_manage']?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new']?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="user_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="member_name"><?php echo $lang['member_index_name']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="member_name" id="member_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="member_passwd"><?php echo $lang['member_edit_password']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="member_passwd" name="member_passwd" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="member_email"><?php echo $lang['member_index_email']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" id="member_email" name="member_email" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="member_truename"><?php echo $lang['member_index_true_name']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" id="member_truename" name="member_truename" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label> <?php echo $lang['member_edit_sex']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul>
              <li>
                <label>
                  <input type="radio" checked="checked" value="0" name="member_sex">
                  <?php echo $lang['member_edit_secret']?></label>
              </li>
              <li>
                <label>
                  <input type="radio" value="1" name="member_sex">
                  <?php echo $lang['member_edit_male']?></label>
              </li>
              <li>
                <label>
                  <input type="radio" value="2" name="member_sex">
                  <?php echo $lang['member_edit_female']?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="member_qq">QQ:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" id="member_qq" name="member_qq" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="member_ww"><?php echo $lang['member_edit_wangwang']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" id="member_ww" name="member_ww" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_edit_pic']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-box">
            <input type="file" class="type-file-file" id="member_avatar" name="member_avatar" size="30">
            </span>
            <input name="link_pic" type="file" class="type-file-file" id="link_pic" size="30">
            </span></td>
          <td class="vatop tips"><?php echo $lang['member_edit_support']?>gif,jpg,jpeg,png</td>
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
<script type="text/javascript">
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#user_form").valid()){
     $("#user_form").submit();
	}
	});
});
//
$(function(){
    $('#user_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
			member_name: {
				required : true,
				minlength: 3,
				maxlength: 20,
				remote   : {
                    url :'index.php?act=member&op=ajax&branch=check_user_name',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#member_name').val();
                        },
                        member_id : ''
                    }
                }
			},
            member_passwd: {
                maxlength: 20,
                minlength: 6
            },
            member_email   : {
                required : true,
                email : true,
				remote   : {
                    url :'index.php?act=member&op=ajax&branch=check_email',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#member_email').val();
                        },
                        member_id : '<?php echo $output['member_array']['member_id'];?>'
                    }
                }
            },
			member_qq : {
				digits: true,
				minlength: 5,
				maxlength: 11
			}
        },
        messages : {
			member_name: {
				required : '<?php echo $lang['member_add_name_null']?>',
				maxlength: '<?php echo $lang['member_add_name_length']?>',
				minlength: '<?php echo $lang['member_add_name_length']?>',
				remote   : '<?php echo $lang['member_add_name_exists']?>'
			},
            member_passwd : {
                maxlength: '<?php echo $lang['member_edit_password_tip']?>',
                minlength: '<?php echo $lang['member_edit_password_tip']?>'
            },
            member_email  : {
                required : '<?php echo $lang['member_edit_email_null']?>',
                email   : '<?php echo $lang['member_edit_valid_email']?>',
				remote : '<?php echo $lang['member_edit_email_exists']?>'
            },
			member_qq : {
				digits: '<?php echo $lang['member_edit_qq_wrong']?>',
				minlength: '<?php echo $lang['member_edit_qq_wrong']?>',
				maxlength: '<?php echo $lang['member_edit_qq_wrong']?>'
			}
        }
    });
});

$(function(){
	var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#member_avatar");
    $("#member_avatar").change(function(){
	$("#textfield1").val($("#member_avatar").val());
    });
});
</script>