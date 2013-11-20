<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div id="pictureFolder">
    <div class="intro">
      <div class="covers"><span class="thumb size60"><i></i><a href="index.php?act=store_album&op=album_pic_list&id=<?php echo $output['class_info']['aclass_id']?>">
        <?php if($output['class_info']['aclass_cover'] != ''){ ?>
        <img src="<?php echo SiteUrl.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].DS.str_replace('_small', '_tiny', $output['class_info']['aclass_cover']);?>" onload="javascript:DrawImage(this,60,60);">
        <?php }else{?>
        <img src="<?php echo TEMPLATES_PATH.'/images/member/default_image.png';?>" onload="javascript:DrawImage(this,60,60);">
        <?php }?>
        </a></span></div>
      <dl>
        <dt><?php echo $output['class_info']['aclass_name']?></dt>
        <dd><?php echo $output['class_info']['aclass_des']?></dd>
      </dl>
    </div>
    <div id="gallery" class="ad-gallery">
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
            <?php foreach ($output['pic_list'] as $v) {?>
            <li> <a href="<?php echo thumb($v,'max');?>" value="<?php echo $v['apic_id'] ?>"> <span class="thumb size90"><i></i> <img title="<?php echo $v['apic_name']?>" src="<?php echo thumb($v,'tiny');?>" class="image0" onload="javascript:DrawImage(this,90,90);"/>
              <input type="hidden" value="" />
              </span> </a> </li>
            <?php }?>
          </ul>
        </div>
      </div>
      <div class="ad-image-date">
        <dt><?php echo $lang['album_pinfo_img_name'];?></dt>
        <dd id="img_name"><?php echo $output['pic_info']['apic_name'];?></dd>
        <dt><?php echo $lang['album_pinfo_img_attribute'];?></dt>
        <dd>
          <p id="upload_time"><b><?php echo $lang['album_pinfo_upload_time'].$lang['nc_colon'];?></b><?php echo date('Y-m-d',$output['pic_info']['upload_time']);?></p>
          <p><b><?php echo $lang['album_pinfo_class_name'].$lang['nc_colon'];?></b><?php echo str_cut($output['class_info']['aclass_name'],20);?></p>
          <p id="default_size"><b><?php echo $lang['album_pinfo_original_size'].$lang['nc_colon'];?></b><?php echo $output['pic_info']['apic_size'];?>KB</p>
          <p id="default_spec"><b><?php echo $lang['album_pinfo_original_spec'].$lang['nc_colon'];?></b><?php echo $output['pic_info']['apic_spec'];?></p>
          <p><?php echo $lang['album_pinfo_see_src']?><span><a href="JavaScript:void(0);" target="_black" id="default_popup"  class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
          <p><?php echo $lang['album_pinfo_see_max']?><span><a href="JavaScript:void(0);" target="_black" id="max_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
          <p><?php echo $lang['album_pinfo_see_mid']?><span><a href="JavaScript:void(0);" target="_black" id="mid_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
          <p><?php echo $lang['album_pinfo_see_small']?><span><a href="JavaScript:void(0);" target="_black" id="small_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
          <p><?php echo $lang['album_pinfo_see_tiny']?><span><a href="JavaScript:void(0);" target="_black" id="tiny_popup" class="view popup"><?php echo $lang['album_pinfo_see'];?></a></span></p>
        </dd>
      </div>
      <div class="ad-image-wrapper"> </div>
      <div class="ad-controls"> </div>
      <div class="ad-showmode">
        <p><?php echo $lang['album_pinfo_photos_switch_effect'];?>
          <select id="switch-effect">
            <option value="slide-hori"><?php echo $lang['album_pinfo_level_slip_into'];?></option>
            <option value="slide-vert"><?php echo $lang['album_pinfo_vertical_slip_into'];?></option>
            <option value="resize"><?php echo $lang['album_pinfo_contraction_amplification'];?></option>
            <option value="fade"><?php echo $lang['album_pinfo_crossfade'];?></option>
            <option value="none"><?php echo $lang['album_pinfo_null'];?></option>
          </select>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>
<script type="text/javascript" src="<?php echo SiteUrl;?>/resource/js/jquery.ad-gallery.js"></script> 
<script type="text/javascript">
  $(function() {
    
    var galleries = $('.ad-gallery').adGallery({loader_image:'<?php echo TEMPLATES_PATH;?>/images/loading.gif', start_at_index:<?php echo $output['pic_num']?>, slideshow:{enable: false,start_label: '<?php echo $lang['album_pinfo_autoplay'];?>', stop_label: '<?php echo $lang['album_pinfo_suspend'];?>'}});
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
    $('#toggle-description').click(
      function() {
        if(!galleries[0].settings.description_wrapper) {
          galleries[0].settings.description_wrapper = $('#descriptions');
        } else {
          galleries[0].settings.description_wrapper = false;
        }
        return false;
      }
    );
  });
  </script> 
<script>
$(function(){
	//var img_type = '<?php echo $output['img_type'];?>';
	
	//查看原图
	$("#default_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);
		pic = pic.replace('_max.'+img_type,'');				
		$('#default_popup').attr('href',pic);
	});	

	//	查看大图
	$("#max_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);		
		pic = pic.replace('_max.'+img_type,'');	
		$('#max_popup').attr('href',pic+'_max.'+img_type);
	});
	
	//	查看中图
	$("#mid_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);		
		pic = pic.replace('_max.'+img_type,'');				
		$('#mid_popup').attr('href',pic+'_mid.'+img_type);
	});
	//	查看小图
	$("#small_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);		
		pic = pic.replace('_max.'+img_type,'');
		$('#small_popup').attr('href',pic+'_small.'+img_type);
	});	
	//	查看微图
	$("#tiny_popup").click(function(){
		var pic = $(".ad-image > img").attr('src');
		p = pic.lastIndexOf('.')+1;
		img_type = pic.substring(p);		
		pic = pic.replace('_max.'+img_type,'');
		$('#tiny_popup').attr('href',pic+'_tiny.'+img_type);
	});	

	$(".image0").click(function(){
		ajax_change_imgmessage(this.src);
	});
	$(".ad-next").click(function(){
		ajax_change_imgmessage($(".ad-image > img").attr('src'));
	});
	$(".ad-prev").click(function(){
		ajax_change_imgmessage($(".ad-image > img").attr('src'));
	});
});
</script> 
<script type="text/javascript">
function ajax_change_imgmessage(url){

	$.getJSON("<?php echo SiteUrl; ?>/index.php?act=store_album&op=ajax_change_imgmessage", {'url':url}, function(data){
		$("#img_name").html(data.img_name);
		$("#upload_time").html('<b><?php echo $lang['album_pinfo_upload_time'].$lang['nc_colon'];?></b>'+data.upload_time);
		$("#default_size").html('<b><?php echo $lang['album_pinfo_original_size'].$lang['nc_colon'];?></b>'+data.default_size+'KB');
		$("#default_spec").html('<b><?php echo $lang['album_pinfo_original_spec'].$lang['nc_colon'];?></b>'+data.default_spec);
	});
}
</script>