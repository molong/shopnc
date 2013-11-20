<div class="eject_con">
  <div id="warning"></div>
  <form method="POST" target="_parent" action="" name="ajax_change_price">
    <input type="hidden" name="goods_id" value="<?php echo $output['goods_id'];?>" />
    <?php if (is_array($output['price_array']) && !empty($output['price_array'])){?>
    <?php foreach ($output['price_array'] as $val){?>
    <dl>
      <dt><?php echo $val['spec_goods_spec'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" nctype="stock_num" name="<?php echo $val['spec_id'];?>" value="<?php echo $val['spec_goods_price'];?>" />
      </dd>
    </dl>
    <?php }?>
    <?php }?>
    <?php if(intval($output['price_count']) > 10){?>
    <dl>
      <dt><a href="index.php?act=store_goods&op=edit_goods&goods_id=<?php echo $output['goods_id'];?>" target="_blank"><?php echo $lang['store_goods_price_change_more_price'];?></a></dt>
    </dl>
    <?php }?>
    <dl class="bottom">
      <dt>&nbsp;</dt><dd><input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" /></dd>
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
		$.post('index.php?act=store_goods&op=goods_price_ajax_save',{goods_id : id,name : arr}, 
			function(date){
				// 获取最低价格
				var min = 10000000;
				$('form[name="ajax_change_price"]').find('input[type="text"]').each(function(){
					if(parseFloat($(this).val()) < min) min = parseFloat($(this).val());
				});
				eval(' change_price("'+id+'","'+min+'")');
				DialogManager.close('price_selector_'+id);
			});
		return false;
	});

	// 动态修改商品总库存显示
	$('input[type="text"]').change(function(){
		if($('#warning').css('display')){
			$('#warning').removeAttr('style');
		}
		if(  isNaN( $(this).val() ) ){
			$('#warning').html('<?php echo $lang['store_goods_price_input_error']; ?>').show();
			$(this).val('0');
		}
		var sum = 0;
		$('input[nctype="stock_num"]').each(function(){
			sum += parseInt($(this).val());
		});
		<?php if(intval($output['price_count']) > 10){?>
		$('#stock_sum').html( sum + parseInt($('#surplus_sum').html()) );
		<?php }else{?>
		$('#stock_sum').html( sum );
		<?php }?>
	});
});
</script> 
