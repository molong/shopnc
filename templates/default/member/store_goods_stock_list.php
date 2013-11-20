
<div class="eject_con">
  <div id="warning"></div>
  <form method="POST" target="_parent" action="">
    <input type="hidden" name="goods_id" value="<?php echo $output['goods_id'];?>" />
    <dl>
      <dt><?php echo $lang['store_goods_stock_stock_sum'];?></dt>
      <dd id="stock_sum" ><?php echo $output['stock_sum'];?></dd>
    </dl>
    <?php if (is_array($output['stock_array']) && !empty($output['stock_array'])){?>
    <?php foreach ($output['stock_array'] as $val){?>
    <dl>
      <dt><?php echo $val['spec_goods_spec'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" nctype="stock_num" name="<?php echo $val['spec_id'];?>" value="<?php echo $val['spec_goods_storage'];?>" />
      </dd>
    </dl>
    <?php }?>
    <?php }?>
    <?php if(intval($output['stock_count']) > 10){?>
    <dl>
      <dt><a href="index.php?act=store_goods&op=edit_goods&goods_id=<?php echo $output['goods_id'];?>" target="_blank"><?php echo $lang['store_goods_stock_change_more_stock'];?>:</a></dt>
      <dd id="surplus_sum"><?php echo $output['surplus_sum']?></dd>
    </dl>
    <?php }?>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
      </dd>
    </dl>
  </form>
</div>
<script>
$(function(){
	var id = <?php echo $output['goods_id'];?>;
	$('input[type="submit"]').click(function(){
		var arr = '';
		$('input[nctype="stock_num"]').each(function(){
			arr +=$(this).attr('name')+':'+$(this).val()+';'
		});
		$.post('index.php?act=store_goods&op=goods_stock_ajax_save',{goods_id : id,name : arr}, 
			function(date){
				eval(' change_stock_count("'+id+'","'+$('#stock_sum').html()+'")');
				DialogManager.close('stock_selector_'+id);
			});
		return false;
	});

	// 动态修改商品总库存显示
	$('input[type="text"]').change(function(){
		if($('#warning').css('display')){
			$('#warning').removeAttr('style');
		}
		if( !(/^\d*$/.test( $(this).val() ) ) ){		// 正则验证时候为数字
			$('#warning').html('<?php echo $lang['store_goods_stock_input_error'];?>').show();
			$(this).val('0');
		}
		var sum = 0;
		$('input[nctype="stock_num"]').each(function(){
			sum += parseInt($(this).val());
		});
		<?php if(intval($output['stock_count']) > 10){?>
		$('#stock_sum').html( sum + parseInt($('#surplus_sum').html()) );
		<?php }else{?>
		$('#stock_sum').html( sum );
		<?php }?>
	});
});
</script> 
