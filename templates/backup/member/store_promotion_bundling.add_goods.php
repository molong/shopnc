<div class="ncu-add-goods">
  <table class="search-form">
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['bundling_goods_store_class'].$lang['nc_colon'];?></th>
        <td class="w160"><select name="stc_id" class="w150">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php if (!empty($output['store_goods_class'])){?>
            <?php foreach ($output['store_goods_class'] as $val) { ?>
            <option value="<?php echo $val['stc_id']; ?>" <?php if($val['stc_id'] == $output['stc_id']) echo 'selected="selected"';?>><?php echo $val['stc_name']; ?></option>
            <?php if (is_array($val['child']) && count($val['child'])>0){?>
            <?php foreach ($val['child'] as $child_val){?>
            <option value="<?php echo $child_val['stc_id']; ?>" <?php if($child_val['stc_id'] == $output['stc_id']) echo 'selected="selected"';?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
            <?php }}}}?>
          </select></td>
        <th><?php echo $lang['bundling_goods_name'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" name="b_search_keyword" class="text" value="<?php echo $output['b_search_keyword'];?>" /></td>
        <td class="tc w90"><a nctype="search_a" href="index.php?act=store_promotion_bundling&op=bundling_add_goods" class="submit"><?php echo $lang['nc_search'];?></a></td>
      </tr>
    </tbody>
  </table>
  <table class="ncu-table-style">
    <thead>
      <tr><th class="w10">&nbsp;</th>
        <th class="w70"></th>
        <th><?php echo $lang['bundling_goods_name'].'/'.$lang['bundling_goods_code'];?></th>
        <th class="w80"><?php echo $lang['bundling_goods_price'];?></th>
        <th class="w80"><?php echo $lang['bundling_goods_storage'];?></th>
        <th class="w100"><?php echo $lang['bundling_operate'];?></th>
      </tr>
    </thead>
    <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
    <tbody nctype="bundling_goods_add_tbody" class="bd-line">
      <?php foreach ($output['goods_list'] as $val){?>
      <tr goods_id="<?php echo $val['goods_id'];?>">
      <td>&nbsp;</td>
        <td nctype="name"><div class="goods-pic-small"><span class="thumb size60"><i></i><img src="<?php echo cthumb($val['goods_image'], 'tiny', $_SESSION['store_id']);?>" nctype="<?php echo $val['goods_image'];?>" /></span></div></td>
        <td nctype="serial"><dl class="goods-name"><dt nctype="gname_dt"><?php echo $val['goods_name'];?></dt><?php if($val['goods_serial'] != ''){?><dd><?php echo $lang['bundling_goods_code'].$lang['nc_colon'].$val['goods_serial'];?></dd><?php }?></dl></td>
        <td nctype="price" class="goods-price"><?php echo $val['goods_store_price'];?></td>
        <td nctype="storage"><?php echo $output['storage_array'][$val['goods_id']];?></td>
        <td nctype_gid="<?php echo $val['goods_id'];?>"><a href="JavaScript:void(0);" class="ncu-btn7" onclick="<?php if($output['storage_array'][$val['goods_id']] == '0'){?>alert('<?php echo $lang['bundling_goods_storage_not_enough'];?>')<?php }else{?>bundling_goods_add($(this))<?php }?>"><?php echo $lang['bundling_goods_add_bundling'];?></a></td>
      </tr>
      <?php }?>
    <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    
    <?php }?></tbody>
    <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
    <tfoot>
      <tr>
        <td colspan="20"> <div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
    </tfoot>
    <?php }?>
  </table>
</div>
<script type="text/javascript">
$(function(){
	/* ajax添加商品  */
	$('.demo').unbind().ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:SITE_URL+"/templates/default/images/loading.gif",
		target:'#bundling_add_goods_ajaxContent'
	});

	$('a[nctype="search_a"]').click(function(){
		$(this).attr('href', $(this).attr('href')+'&stc_id='+$('select[name="stc_id"]').val()+'&keyword='+$('input[name="b_search_keyword"]').val());
		$('a[nctype="search_a"]').ajaxContent({
			event:'dblclick', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo TEMPLATES_PATH;?>/images/loading.gif',
			target:'#bundling_add_goods_ajaxContent'
		});
		$(this).dblclick();
		return false;
	});


	// 验证商品是否已经被选择。
	O = $('input[nctype="goods_id"]');
	A = new Array();
	if(typeof(O) != 'undefined'){
		O.each(function(){
			A[$(this).val()] = $(this).val();
		});
	}
	T = $('tbody[nctype="bundling_goods_add_tbody"] tr');
	if(typeof(T) != 'undefined'){
		T.each(function(){
			if(typeof(A[$(this).attr('goods_id')]) != 'undefined'){
				$(this).children(':last').html('<a href="JavaScript:void(0);" onclick="bundling_operate_delete($(\'#bundling_tr_'+$(this).attr('goods_id')+'\'), '+$(this).attr('goods_id')+')" class="ncu-btn2"><?php echo $lang['bundling_goods_add_bundling_exit'];?></a>')
			}
		});
	}
});

/* 添加商品 */
function bundling_goods_add(o){
	// 验证商品是否已经添加。
	O = $('tbody[nctype="bundling_data"] tr');
	if(typeof(O) != 'undefined'){
		if(O.length == <?php echo C('promotion_bundling_goods_sum');?>){
			alert('<?php printf($lang['bundling_goods_add_enough_prompt'], C('promotion_bundling_goods_sum'));?>');
			return false;
		}
	}

	// 插入数据
	parents = o.parents('tr:first');
	strs = new Array();
	strs[0] = o.parent().attr('nctype_gid');
	strs[1] = parents.find('img').attr('src');
	strs[2] = parents.find('dt[nctype="gname_dt"]').html();
	strs[4] = parents.find('td[nctype="price"]').html();
	strs[5] = parents.find('td[nctype="storage"]').html();
	strs[6] = parents.find('img').attr('nctype');
	$('<tr id="bundling_tr_'+strs[0]+'" class="bd-line"><input type="hidden" nctype="goods_id" name="goods[g_'+strs[0]+'][goods_id]" value="'+strs[0]+'" />'
		+'<input type="hidden" name="img_more[]" value="'+strs[6]+'" />'
		+'<td class="w10"></td>'
		+'<td class="w70 tc"><div class="goods-pic-small"><span class="thumb size60"><i></i><img nctype="bundling_data_img" ncname="'+strs[6]+'" src="'+strs[1]+'"  onload="javascript:DrawImage(this,60,60);"/></span></div></td>'
		+'<td class="w340 tl"><input type="text" name="goods[g_'+strs[0]+'][goods_name]" value="'+strs[2]+'" class="text w300" /></td>'
		+'<td nctype="bundling_data_price" class="w90 goods-price">'+strs[4]+'</td>'
		+'<td class="w90"><a href="JavaScript:void(0);" onclick="bundling_operate_delete($(\'#bundling_tr_'+strs[0]+'\'), '+strs[0]+')" class="ncu-btn2"><?php echo $lang['bundling_goods_remove'];?></a></td></tr>')
		.appendTo('tbody[nctype="bundling_data"]');

	$('tr[goods_id="'+strs[0]+'"]').children(':last').html('<a href="JavaScript:void(0);" class="ncu-btn2" onclick="bundling_operate_delete($(\'#bundling_tr_'+strs[0]+'\'), '+strs[0]+')"><?php echo $lang['bundling_goods_add_bundling_exit'];?></a>');
	count_cost_price_sum();
	goods_img_add();
}

</script> 