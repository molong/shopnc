<div class="goods-gallery" nctype="bundling_album_des" style="width:625px;"> <a class="sample_demo" id="select_s_desc" href="index.php?act=store_album&op=pic_list&item=bundling_add_desc" style="display:none;"><?php echo $lang['nc_submit'];?></a>
  <div class="nav" style="width:593px;"><span class="l"><?php echo $lang['store_goods_album_users'];?> >
    <?php if(isset($output['class_name']) && $output['class_name'] != ''){echo $output['class_name'];}else{?>
    <?php echo $lang['store_goods_album_all_photo'];?>
    <?php }?>
    </span><span class="r">
    <select name="jumpMenu_des" id="jump_menu_des" style="width:100px;">
      <option value="0" style="width:80px;"><?php echo $lang['nc_please_choose'];?></option>
      <?php foreach($output['class_list'] as $val) { ?>
      <option style="width:80px;" value="<?php echo $val['aclass_id']; ?>" <?php if($val['aclass_id']==$_GET['id']){echo 'selected';}?>><?php echo $val['aclass_name']; ?></option>
      <?php } ?>
    </select>
    </span></div>
  <ul class="list" style="width:610px;">
    <?php if(!empty($output['pic_list'])){?>
    <?php foreach ($output['pic_list'] as $v){?>
    <li onclick="insert_editor('<?php echo cthumb($v['apic_cover'],'max',$_SESSION['store_id']);?>');" style="padding: 4px 0 4px 3px;"><a href="JavaScript:void(0);"><span class="thumb size90"><i></i><img src="<?php echo cthumb($v['apic_cover'],'tiny',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,90,90);" title='<?php echo $v['apic_name']?>'/></span></a></li>
    <?php }?>
    <?php }else{?>
    <div class="norecord mb30"><i> </i><span><?php echo $lang['no_record'];?></span></div>
    <?php }?>
  </ul>
  <div class="clear"></div>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	/* 从图片空间选择图片 */
	$('div[nctype="bundling_album_des"]').find('.demo').unbind().ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:SITE_URL+"/templates/default/images/loading.gif",
		target:'#des_demo'
	});
	$('#jump_menu_des').unbind().live('change',function(){
		$('#select_s_desc').attr('href',$('#select_s_desc').attr('href')+"&id="+$('#jump_menu_des').val());
		$('#select_s_desc').ajaxContent({
			event:'click', //mouseover
			loaderType:'img',
			loadingMsg:'<?php echo TEMPLATES_PATH;?>/images/loading.gif',
			target:'#des_demo'
		});
		$('#select_s_desc').click();
	});
});
</script>