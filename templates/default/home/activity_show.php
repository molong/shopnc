<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo TEMPLATES_PATH;?>/css/home_activity.css" rel="stylesheet" type="text/css">
<script type="text/javascript" >
	$(document).ready(function(){
		$('#sale').children('ul').children('li').bind('mouseenter',function(){
			$('#sale').children('ul').children('li').attr('class','c1');
			$(this).attr('class','c2');
		});
	
		$('#sale').children('ul').children('li').bind('mouseleave',function(){
			$('#sale').children('ul').children('li').attr('class','c1');
		});
})
</script>
<div class="content">
  <div id="banner_box">
    <div class="pic"><img src="<?php if(is_file(BasePath.DS.ATTACH_ACTIVITY.DS.$output['activity']['activity_banner'])){echo SiteUrl."/".ATTACH_ACTIVITY."/".$output['activity']['activity_banner'];}else{echo TEMPLATES_PATH."/images/sale_banner.jpg";}?>" width="980" height="330" /></div>
    <div class="zs"></div>
    <div class="info_box"><?php echo nl2br($output['activity']['activity_desc']);?></div>
  </div>
  <div class="sale" id="sale">
    <ul class="list_pic">
      <?php if(is_array($output['list']) and !empty($output['list'])){?>
      <?php foreach ($output['list'] as $v) {?>
      <li class="c1">
        <dl>
          <dt class="goodspic"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods');?>" target="_blank"><img src="<?php echo thumb($v,'small');?>" onload="javascript:DrawImage(this,160,160);" /></a></dt>
          <dd class="goodsname"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods');?>" target="_blank" title="<?php echo $v['goods_name'];?>"><?php echo $v['goods_name'];?></a></dd>
          <dd class="price">
            <h4><?php echo $lang['currency'];?><?php echo $v['goods_store_price'];?></h4>
          </dd>
        </dl>
      </li>
      <?php }?>
      <?php }?>
    </ul>
  </div>
</div>
