
<div class="eject_con">
  <form method="post" action="index.php?act=store&op=store_goods_class&type=export" target="seller_order">
    <input type="hidden" name="form_submit" value="ok"/>
    <input type="hidden" name="if_convert" value="1"/>
    <h3><?php echo $lang['store_goods_class_problem'];?>?</h3>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" id="confirm_button" value="<?php echo $lang['nc_ok'];?>" />
      </dd>
    </dl>
  </form>
</div>
<script type="text/javascript">
$(function(){
        $('#cancel_button').click(function(){
            DialogManager.close('my_category_export');
         });
});
</script> 
