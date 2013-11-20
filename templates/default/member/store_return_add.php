<div class="eject_con">
  <div id="warning"></div>
  <form id="post_form" method="post" action="index.php?act=return&op=add&order_id=<?php echo $output['order']['order_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="order ncu-table-style bc mt20" style="width:96%;" >
      <tbody>
        <tr>
          <th colspan="3" class="tc"><?php echo $lang['return_goods_name'];?></th>
          <th class="tc"><?php echo $lang['return_add_return'];?></th>
          <th class="tc"><?php echo $lang['return_number'];?></th>
        </tr>
        <?php if(is_array($output['order_goods_list']) && !empty($output['order_goods_list'])) {
		foreach($output['order_goods_list'] as $val) {
	?>
        <tr>
          <td class="bdl w10"></td>
          <td class="w70"><div class="goods-pic-small"><span class="thumb size60"><i></i><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><img src="<?php echo thumb($val,'tiny'); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
          <td><dl class="goods-name" style=" width:auto;">
              <dt style=" width:auto; white-space: normal;"><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><?php echo $val['goods_name']; ?></a></dt>
              <dd style=" width:auto;"><?php echo $val['spec_info']; ?></dd>
            </dl></td>
          <td class="w90 bdl"><?php echo $val['goods_num']-$val['goods_returnnum']; ?></td>
          <td class="w90 bdl bdr"><input type="text" class="w50 text" name="goods_<?php echo $val['goods_id']; ?>" value="<?php echo $val['goods_num']-$val['goods_returnnum']; ?>" /></td>
        </tr>
        <?php } } ?>
      </tbody>
    </table>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['return_message'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="return_message" class="textarea w300"></textarea>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" id="confirm_button" name="confirm_button" value="<?php echo $lang['nc_ok'];?>" />
      </dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
$(function(){
    $('#cancel_button').click(function(){
        DialogManager.close('seller_order_return');
    });
    $('#post_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
         submitHandler: function(form) {
			    	var goods_num = 0;
			    	$("input[name^='goods_']").each(function(i){
						  goods_num += parseInt(this.value);
						});
						if (goods_num < 1) {
							alert('<?php echo $lang['return_desc'];?>');
							return false;
						} else {
							ajaxpost('post_form', '', '', 'onerror'); 
						}
				 },
	        rules : {
            return_message : {
                required   : true
            },
	        <?php if(is_array($output['order_goods_list']) && !empty($output['order_goods_list'])) {
							foreach($output['order_goods_list'] as $val) {
					?>
	            goods_<?php echo $val['goods_id']; ?> : {
                	required   : true,
	                digits   : true,
	                min:0,
	                max:<?php echo $val['goods_num']-$val['goods_returnnum']; ?>
	            },
	        <?php
						}
					}
					?>
            form_submit : {
                required   : true
            }
	        },
	        messages : {
            return_message  : {
                required   : '<?php echo $lang['return_message_null'];?>'
            },
	        <?php if(is_array($output['order_goods_list']) && !empty($output['order_goods_list'])) {
							foreach($output['order_goods_list'] as $val) {
					?>
	            goods_<?php echo $val['goods_id']; ?>  : {
	                required   : '<?php echo $val['goods_name']; ?> <?php echo $lang['return_add_return'];?> <?php echo $val['goods_num']-$val['goods_returnnum']; ?>',
	                digits   : '<?php echo $val['goods_name']; ?> <?php echo $lang['return_add_return'];?> <?php echo $val['goods_num']-$val['goods_returnnum']; ?>',
	                min   : '<?php echo $val['goods_name']; ?> <?php echo $lang['return_number_min'];?> 0',
	                max   : '<?php echo $val['goods_name']; ?> <?php echo $lang['return_number_max'];?> <?php echo $val['goods_num']-$val['goods_returnnum']; ?> '
	            },
	        <?php
						}
					}
					?>
            form_submit  : {
                required   : '<?php echo $lang['nc_ok'];?>'
            }
	        }
	    });
});
</script> 
