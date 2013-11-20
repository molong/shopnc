<?php defined('InShopNC') or exit('Access Invalid!');?>
<form action="index.php?act=pointprod&op=pointprod_iframe_upload" method="post" enctype="multipart/form-data" style="display: inline;" id="image_form">
	<input type="hidden" name="form_submit" value="ok" />
	<input name="item_id" value="<?php echo $output['item_id'];?>" type="hidden">
	<input name="file" type="file">
	<input value="<?php echo $lang['admin_pointprod_add_upload'];?>" type="submit">
</form>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $('input[type="file"]').change(function(){
			var filepath=$(this).val();
			var extStart=filepath.lastIndexOf(".");
			var ext=filepath.substring(extStart,filepath.length).toUpperCase();		
			if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
				alert("<?php echo $lang['admin_pointprod_add_upload_img_error'];?>");
				$(this).attr('value','');
				return false;
			}
    });
});
//]]>
</script>