<div class="eject_con">
  <div id="warning"></div>
  <form id="post_form" method="post" action="index.php?act=return&op=edit&return_id=<?php echo $output['return']['return_id']; ?>">
    <input type="hidden" name="form_submit" value="ok" />
  <table class="ncu-table-style order bc mt20 mb10" style="width:96%;">
    <thead>
    </thead>
    <tbody>
      <tr>
        <th colspan="3" class="tc"><?php echo $lang['return_goods_name'];?></th>
        <th class="w70 tc"><?php echo $lang['return_order_return'];?></th>
      </tr>
      <?php if(is_array($output['order_goods_list']) && !empty($output['order_goods_list'])) { foreach($output['order_goods_list'] as $val) { ?>
      <tr><td class="bdl w10"></td><td><div class="goods-pic-small"><span class="thumb size60"><i></i><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><img src="<?php echo thumb($val,'tiny'); ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td><dl class="goods-name" style="width:auto;">
          <dt style="width:auto; white-space: normal;"><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>"><?php echo $val['goods_name']; ?></a></dt>
          <dd style="width:auto;"><?php echo $val['spec_info']; ?></dd></dl></td>
        <td class="bdl bdr"><?php echo $val['goods_returnnum']; ?></td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>
  <dl>
    <dt><?php echo $lang['return_buyer_message'].$lang['nc_colon'];?></dt>
    <dd><?php echo $output['return']['buyer_message']; ?></dd>
  </dl>
    <dl>
      <dt class="required"><em class="pngFix"></em><?php echo $lang['return_seller_confirm'].$lang['nc_colon'];?></dt>
      <dd>
        <label>
          <input type="radio" name="return_state" value="2" />
          <?php echo $lang['nc_yes'];?> </label>
        <label>
          <input type="radio" name="return_state" value="3" />
          <?php echo $lang['nc_no'];?> </label>
      </dd>
    </dl>
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
			    	ajaxpost('post_form', '', '', 'onerror'); 
				 },
        rules : {
            return_state : {
                required   : true
            },
            return_message : {
                required   : true
            }
        },
        messages : {
            return_state  : {
                required  : '<?php echo $lang['return_seller_confirm_null'];?>'
            },
            return_message  : {
                required   : '<?php echo $lang['return_message_null'];?>'
            }
        }
	    });
});
</script> 
