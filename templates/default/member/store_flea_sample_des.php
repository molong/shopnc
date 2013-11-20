
<div class="goods-gallery"> <a class='sample_demo' id="select_s" href="index.php?act=flea_album&op=pic_list&item=des" style="display:none;"><?php echo $lang['nc_submit'];?></a>
  <ul class="list">
    <?php if(!empty($output['pic_list'])){?>
    <?php foreach ($output['pic_list'] as $v){?>
    <li onclick="insert_editor('<?php echo ATTACH_FLEAS.DS.$_SESSION['member_id'].DS.$v['file_name'].'_max.'.get_image_type($v['file_name'])?>');"> <a href="JavaScript:void(0);"> <span class="thumb size90"> <i></i> <img src="<?php echo SiteUrl.DS.ATTACH_FLEAS.DS.$_SESSION['member_id'].DS.$v['file_name'].'_small.'.get_image_type($v['file_name'])?>" onload="javascript:DrawImage(this,90,90);" onerror="this.src='<?php echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_goods_image'];?>'" title='<?php echo $v['file_name']?>'/> </span> </a> </li>
    <?php }?>
    <?php }else{?>
    <?php echo $lang['no_record'];?>
    <?php }?>
  </ul>
  <div class='clear'></div>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:'img',
		loadingMsg:'<?php echo TEMPLATES_PATH;?>/images/loading.gif',
		target:'#des_demo'
	});
	$('#jump_menu').change(function(){
		$('#select_s').attr('href',$('#select_s').attr('href')+"&id="+$('#jump_menu').val());
		$('.sample_demo').ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo TEMPLATES_PATH;?>/images/loading.gif',
			target:'#des_demo'
		});
		$('#select_s').click();
	});
});
</script>