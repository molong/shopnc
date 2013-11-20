<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
.upload-button {
	line-height: 28px;
	text-decoration: none;
	color: #555;
	text-align: center;
	display: inline-block;
	height: 28px;
	border: solid 1px #D8D8D8;
	border-radius: 5px;
	width: 78px;
}
a:hover.upload-button {
	color: #06C;
}
/*焦点图轮换
*********************************/ 
.flex-container a:active, .flexslider a:active {
	outline: none;
}
.slides, .flex-control-nav, .flex-direction-nav {
	margin: 0;
	padding: 0;
	list-style: none;
}
.flexslider {
	width: 790px;
	clear: both;
	margin: 5px 5px;
*margin: 0 auto 5px auto;
	padding: 0;
}
.flexslider .slides > li {
	display: none;
}
.flexslider .slides img {
	max-width: 100%;
	display: block;
}
.flex-pauseplay span {
	text-transform: capitalize;
}
.slides:after {
	content: ".";
	display: block;
	clear: both;
	visibility: hidden;
	line-height: 0;
	height: 0;
}
html[xmlns] .slides {
	display: block;
}
* html .slides {
	height: 1%;
}
.no-js .slides > li:first-child {
	display: block;
}
.flexslider {
	background: #fff;
	position: relative;
	zoom: 1;
}
.flexslider .slides {
	zoom: 1;
}
.flexslider .slides > li {
	position: relative;
}
.flex-container {
	zoom: 1;
	position: relative;
}
.flex-direction-nav li a {
	text-indent: -9999px;
	background-color: transparent;
	display: block;
	width: 36px;
	height: 36px;
	padding: 0;
	margin: -8px 0 0 0;
	position: absolute;
	top: 45%;
	cursor: pointer;
	opacity: 0.3;
	filter: alpha(opacity=30);
}
.flex-direction-nav li a:hover {
	opacity: 0.9;
	filter: alpha(opacity=90)
}
.flex-direction-nav li .next {
	font-size: 0px;
	line-height: 0;
	width: 0px;
	height: 0px;
	border: 16px solid;
	border-color: transparent transparent transparent #333;
	right: 0px;
}
.flex-direction-nav li .prev {
	font-size: 0px;
	line-height: 0;
	width: 0px;
	height: 0px;
	border: 16px solid;
	border-color: transparent #333 transparent transparent;
	left: 0px;
}
.flex-direction-nav li .disabled {
	opacity: .3;
	filter: alpha(opacity=30);
	cursor: default;
}
.flex-control-nav {
	width: 100%;
	position: absolute;
	bottom: -20px;
*bottom: 5px;
	text-align: center;
}
.flex-control-nav li {
	margin: 0 0 0 9px;
	_margin-left: 4px;
	display: inline-block;
	zoom: 1;
*display: inline;
}
.flex-control-nav li:first-child {
	margin: 0;
}
.flex-control-nav li a {
	width: 10px;
	height: 10px;
	line-height: 10px;
	display: block;
	background-color: #EEE;
	cursor: pointer;
	text-indent: -9999px;
	border-radius: 5px;
}
.flex-control-nav li a:hover {
	background-color: #FC0;
}
.flex-control-nav li a.active {
	background-color: #F60;
	cursor: default;
	box-shadow: 1px 1px 1px #CC3300 inset;
}
</style>

<div class="wrap" style="_overflow:hidden;">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <div class="flexslider">
      <ul class="slides">
        <?php if(!empty($output['store_slide']) && is_array($output['store_slide'])){?>
        <?php for($i=0;$i<5;$i++){?>
        <?php if($output['store_slide'][$i] != ''){?>
        <li><a <?php if($output['store_slide_url'][$i] != '' && $output['store_slide_url'][$i] != 'http://'){?>href="<?php echo $output['store_slide_url'][$i];?>"<?php }?>><img src="<?php echo ATTACH_SLIDE.DS.$output['store_slide'][$i];?>"></a></li>
        <?php }?>
        <?php }?>
        <?php }else{?>
        <li> <img src="<?php echo ATTACH_SLIDE.DS;?>f01.jpg"> </li>
        <li> <img src="<?php echo ATTACH_SLIDE.DS;?>f02.jpg"> </li>
        <li> <img src="<?php echo ATTACH_SLIDE.DS;?>f03.jpg"> </li>
        <li> <img src="<?php echo ATTACH_SLIDE.DS;?>f04.jpg"> </li>
        <?php }?>
      </ul>
    </div>
    <form action="index.php?act=store&op=store_slide" id="store_slide_form" method="post" onsubmit="ajaxpost('store_slide_form', '', '', 'onerror');return false;">
      <input type="hidden" name="form_submit" value="ok" />
      <!-- 图片上传部分 -->
      <ul class="ncs-slider" id="goods_images">
        <?php for($i=0;$i<5;$i++){?>
        <li nc_type="handle_pic" id="thumbnail_<?php echo $i;?>">
          <div class="picture"><span class="thumb size142-80"><i></i> <img nctype="file_<?php echo $i;?>"  src="<?php echo ATTACH_SLIDE.DS.$output['store_slide'][$i];?>" onerror="this.src='<?php echo TEMPLATES_PATH;?>/images/member/default_sildeshow.gif'" onload="javascript:DrawImage(this,142,80);"/>
            <input type="hidden" name="image_path[]" nctype="file_<?php echo $i;?>" value="<?php echo $output['store_slide'][$i];?>" />
            </span></div>
          <div nc_type="handler" class="bg" id="<?php echo $i;?>">
            <p class="operation"><span class="delete" nctype="drop_image" title="<?php echo $lang['nc_del'];?>"></span></p>
          </div>
          <div class="url">
            <label><?php echo $lang['store_slide_image_url'];?></label>
            <input type="text" class="text" name="image_url[]" value="<?php if($output['store_slide_url'][$i] == ''){  echo 'http://';}else{echo $output['store_slide_url'][$i];}?>" />
          </div>
          <div class="upload-btn"><a href="javascript:void(0);"> <span style="width: 80px; height: 30px; position: absolute; left: 0; top: 0; z-index: 999; cursor:pointer; ">
            <input type="file" name="file_<?php echo $i;?>" id="file_<?php echo $i;?>" file_id="0" style="width:80px; height: 30px; cursor: pointer; opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" maxlength="0" />
            </span>
            <div class="upload-button"><?php echo $lang['store_slide_image_upload'];?></div>
            <input id="submit_button" style="display:none" type="button" value="<?php echo $lang['store_slide_image_upload'];?>" onClick="submit_form($(this))" />
            </a></div>
        </li>
        <?php } ?>
      </ul>
      <div class="ncm-notes">
        <ul>
          <li><?php echo $lang['store_slide_description_one'];?></li>
          <li><?php printf($lang['store_slide_description_two'],intval(C('image_max_filesize'))/1024);?></li>
          <li><?php echo $lang['store_slide_description_three'];?></li>
          <li><?php echo $lang['store_slide_description_fore'];?></li>
        </ul>
      </div>
      
      <!-- 图片上传部分 -->
      <input type="submit" class="btn" value="<?php echo $lang['store_slide_submit'];?>" style=" margin: 20px;"/>
    </form>
  </div>
</div>
<script src="<?php echo RESOURCE_PATH;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script> 
<script src="<?php echo RESOURCE_PATH;?>/js/store_slide.js" charset="utf-8"></script> 
<!-- 引入幻灯片JS --> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.flexslider-min.js"></script> 
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl;?>";
</script> 
