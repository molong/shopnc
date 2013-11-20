<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_predepositmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=predeposit&op=predeposit"><span><?php echo $lang['admin_predeposit_rechargelist']?></span></a></li>
        <li><a href="index.php?act=predeposit&op=cashlist"><span><?php echo $lang['admin_predeposit_cashmanage']; ?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_predeposit_artificial'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="artificial_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="member_name"><?php echo $lang['admin_predeposit_membername']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="member_name" id="member_name" class="txt" onchange="javascript:checkmember();">
            <input type="hidden" name="member_id" id="member_id" value='0'/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr id="tr_memberinfo" class="noborder">
          <td colspan="2"  style="font-weight:bold;" id="td_memberinfo"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_pricetype']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="pricetype" name="pricetype">
              <option value="1"><?php echo $lang['admin_predeposit_pricetype_available'];?></option>
              <option value="2"><?php echo $lang['admin_predeposit_pricetype_freeze'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['admin_predeposit_artificial_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_artificial_operatetype'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select id="operatetype" name="operatetype">
              <option value="1"><?php echo $lang['admin_predeposit_artificial_operatetype_add'];?></option>
              <option value="2"><?php echo $lang['admin_predeposit_artificial_operatetype_reduce'];?></option>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="price"><?php echo $lang['admin_predeposit_price'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="price" name="price" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_predeposit_remark'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="remark" rows="6" class="tarea"></textarea></td>
          <td class="vatop tips"><?php echo $lang['admin_predeposit_cash_remark_tip2'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
function checkmember(){
	var membername = $.trim($("#member_name").val());
	if(membername == ''){
		$("#member_id").val('0');
		alert('<?php echo $lang['admin_predeposit_artificial_membernamenull_error'];?>');
		return false;
	}
	$.getJSON("index.php?act=predeposit&op=checkmember", {'name':membername}, function(data){
	        if (data)
	        {
		        $("#tr_memberinfo").show();
				var msg= "<?php echo $lang['admin_predeposit_artificial_member_tip_1'];?>"+ data.name + "<?php echo $lang['admin_predeposit_artificial_member_tip_2'];?>" + data.availableprice + "<?php echo $lang['admin_predeposit_artificial_member_tip_3'];?>" + data.freezeprice;
				$("#member_name").val(data.name);
				$("#member_id").val(data.id);
		        $("#td_memberinfo").text(msg);
	        }
	        else
	        {
	        	$("#member_name").val('');
	        	$("#member_id").val('0');
		        alert("<?php echo $lang['admin_predeposit_artificial_membername_error'];?>");
	        }
	});
}
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#artificial_form").valid()){
     $("#artificial_form").submit();
	}
	});
});
//
$(function(){
	$("#tr_memberinfo").hide();
	
    $('#artificial_form').validate({
         errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	member_name: {
				required : true
			},
			member_id: {
				required : true
            },
            price   : {
                required : true,
                min : 1
            }
        },
        messages : {
			member_name: {
				required : '<?php echo $lang['admin_predeposit_artificial_membernamenull_error'];?>'
			},
			member_id : {
				required : '<?php echo $lang['admin_predeposit_artificial_membername_error'];?>'
            },
            price  : {
                required : '<?php echo $lang['admin_predeposit_artificial_pricenull_error'];?>',
                min : '<?php echo $lang['admin_predeposit_artificial_pricemin_error'];?>'
            }
        }
    });
});
</script>