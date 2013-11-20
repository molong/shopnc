<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form id="add_form" action="index.php?act=store_promotion_bundling&op=bundling_quota_add" method="post">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['bundling_quota_add_quantity'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input id="bundling_quota_quantity" name="bundling_quota_quantity" type="text" class="text w50 mr5" />
            <?php echo $lang['nc_month'];?><span class="ml5"></span> </p>
          <p class="hint"><?php echo $lang['bundling_price_explain1'];?></p>
          <p class="hint"><?php printf($lang['bundling_price_explain2'], intval(C('promotion_bundling_price')));?></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input id="submit_button" type="submit" value="<?php echo $lang['nc_submit'];?>" class="submit">
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			var error_td = element.parent('p').children('span');
			error_td.find('.field_notice').hide();
			error_td.append(error);
		},
		submitHandler:function(form){
			var unit_price = parseInt(<?php echo C('promotion_bundling_price');?>);
			var quantity = parseInt($("#bundling_quota_quantity").val());
			var price = unit_price * quantity;
			showDialog('<?php echo $lang['bundling_quota_add_confirm'];?>'+price+'<?php echo $lang['bundling_gold'];?>', 'confirm', '', function(){ajaxpost('add_form', '', '', 'onerror');});
		},
		rules : {
			bundling_quota_quantity : {
				required : true,
				digits : true,
				min : 1,
				max : 12
			}
		},
		messages : {
			bundling_quota_quantity : {
				required : '<?php echo $lang['bundling_quota_quantity_error'];?>',
				digits : '<?php echo $lang['bundling_quota_quantity_error'];?>',
				min : '<?php echo $lang['bundling_quota_quantity_error'];?>',
				max : '<?php echo $lang['bundling_quota_quantity_error'];?>'
			}
		}
	});
});
</script> 
