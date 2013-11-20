<link href="<?php echo TEMPLATES_PATH;?>/css/member.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js"></script>
<script type="text/javascript">
/* 插入编辑器 */
function insert_editor(file_src){
	top.KE.insertHtml(''+ file_src + '');
}
function insert_pic(){
	var info_table='<table class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0"><tbody>';
	var info_table2='	</tbody></table>';
	var file_src='';
	var pic_width=$('#pic_width').val();
	var pic_height=$('#pic_height').val();
	var pic_size=$('#pic_size').val();
	var pic_list=$('#pic_list').val();
	$('.pic_selected img').each(function(i){
		var img_src=$(this).attr("src");
		var goods_id=$(this).attr("goods_id");
		var goods_name=$(this).attr("title");
		var goods_url="index.php?act=goods&goods_id="+goods_id;
		var img='<a href="'+goods_url+'" target="_blank"><img src="'+img_src+'" title="'+goods_name+'" width="'+pic_width+'" height="'+pic_height+'"/></a>';
	  file_src=file_src+'<tr><td>'+img+'</td></tr>';
	});
	if(pic_size == '_mid') file_src=file_src.replace(/_small/g, pic_size);
	if(pic_list == 'td') file_src=file_src.replace(/<\/tr><tr>/g, '');
	file_src=info_table+file_src+info_table2;
	insert_editor(file_src);
}
$(function(){
	$('.list li').each(function(i){
	   $(this).click(function() {
			  $(this).toggleClass("pic_selected");
			});
	});
	
	$('#gc_id').change(function(){
		window.location="index.php?act=store_theme&op=goods_list&gc_id="+$(this).val();
	});
});
</script>
<style type="text/css">
html {min-height:101%; } 
body { font-size: 12px; font-family: Arial, Helvetica, "宋体";}
a.preview , a.preview:hover {text-decoration:none;}
a.preview img{margin:20px 10px;}

* { padding:0; margin:0; }
h1, h2, h3, h4, h5, h6 { font-size:14px; }

img, table, td, th { padding: 0; margin: 0; border:0;}
ul, ol { list-style:none; }
a { color:#36C; text-decoration: none;}
a:hover { color:#F50; }
.goods-gallery { width: 858px; clear: both; border-bottom: solid 1px #E7E7E7;}
.goods-gallery .nav { line-height: 24px;  width: 834px; height: 24px;  padding: 5px 10px 0px 10px; margin: 0;}
.goods-gallery .nav .l { color: #9E9E9E; float: left;}
.goods-gallery .nav .r { float: right;}
.goods-gallery .list { width: 858px; padding: 0px;}
.goods-gallery .list li { width: 98px; height: 98px; float: left; padding: 4px 0 4px 8px; }
.goods-gallery .list li a { background-color: #FFF; /* if IE7/8/9*/ *text-align: center; display: inline; width: 90px; height: 90px; float: left; padding: 1px; margin:1px; border: solid 1px #F5F5F5; overflow: hidden; }
.goods-gallery .list li a:hover { margin: 0; border: solid 2px #09F;}
.goods-gallery .pagination { display:inline; margin-right:10px;}
.pic_list .bottom { line-height: 0px; background: url(../images/member/goods_pictures_bg.png) no-repeat right bottom; width: 768px; height: 4px; clear: both;}


.pic_selected {
	border-color: #F90 !important;
}

</style>

<div class="goods-gallery" style="width:670px;">
  <div style="width:660px; line-height:22px; padding: 5px 5px 8px 5px; border-bottom: solid 1px #E7E7E7;">
    <select name="gc_id" id="gc_id" style=" height: 22px; width:100px;">
    <option value="0">选择分类</option>
        <?php foreach($output['gc_list'] as $gc){?>
        <option value="<?php echo $gc['gc_id'];?>" <?php if($gc['gc_id']==$_GET['gc_id']){echo 'selected'; }?>><?php echo $gc['gc_name'];?></option>
        <?php }?>
    </select>
    图片宽度 <input name="pic_width" type="text" id="pic_width" style=" height: 22px;" value="<?php echo C('thumb_mid_width');?>" size="3">
    图片高度 <input name="pic_height" type="text" id="pic_height" style=" height: 22px;" value="<?php echo C('thumb_mid_height');?>" size="3">
    <select name="pic_size" id="pic_size" style=" height: 22px;">
   	  <option value="_small">小图(<?php echo C('thumb_small_width');?>px×<?php echo C('thumb_small_height');?>px)</option>
    	<option value="_mid" selected>中图(<?php echo C('thumb_mid_width');?>px×<?php echo C('thumb_mid_height');?>px)</option>
    </select>
    <select name="pic_list" id="pic_list" style=" height: 22px;">
    	<option value="td">横排显示</option>
    	<option value="tr">坚排显示</option>
    </select><input type="button" name="" value="确定插入" onclick="insert_pic();" style=" margin-left: 4px;">
    </div>
  <ul class="list" style="width:660px;  padding: 5px;">
  <?php if(!empty($output['goods_list'])){?>
  	<?php foreach ($output['goods_list'] as $v){?>
    <li style="width:150; height: 200px; margin-right: 5px; margin-bottom: 5px; padding:0px; border: solid 4px #FFF;">
    	<a href="JavaScript:void(0);" style="width:150; height:150; padding:0px; margin:0; border:0;">
    	<span class="thumb size90">
    		<img goods_id="<?php echo $v['goods_id'];?>" src="<?php echo cthumb($v['goods_image'],'small',$v['store_id']);?>" onload="javascript:DrawImage(this,150,150);" title='<?php echo $v['goods_name']?>'/></span></a>
    		
        <a href="index.php?act=goods&goods_id=<?php echo $v['goods_id'];?>" target="_blank" style="width:140px; height:32px; line-height: 16px; border:0; margin:0; padding:0 5px;"><?php echo $v['goods_name'];?></a>
          
    </li>
	<?php }?>
  <?php }else{?>
  	<?php echo $lang['no_record'];?>
  <?php }?>
  </ul>
  <div class='clear'></div>
  <div class="pagination" style=" border:0; margin-top:5px;"><?php echo $output['show_page']; ?></div>
</div>