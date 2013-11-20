<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncsl-nav">
  	<?php if($output['store_info']['store_theme'] == 'style8' && !empty($output["theme"]["theme_info"])){?>
  	<div id="theme_nav" style="display: none;">
  		<?php echo $output["theme"]["theme_info"];?>
		  <nav id="nav" class="pngFix">
		    <ul class="pngFix">
		      <li class="<?php if($output['page'] == 'index'){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']),'store',$output['store_info']['store_domain']);?>"><span><?php echo $lang['nc_store_index'];?><i></i></span></a></li>
		      <?php if($output['page'] == 'goods'){?>
		      <li class="active"><a href="JavaScript:void(0);"><span><?php echo $lang['nc_goods_info'];?><i></i></span></a></li>
		      <?php }?>
		      <?php if($output['page'] == 'coupon'){?>
		      <li class="active"><a href="JavaScript:void(0);"><span><?php echo $lang['nc_coupon'];?><i></i></span></a></li>
		      <?php }?>
		      <li class="<?php if($output['page'] == 'credit'){?>active<?php }else{?>normal<?php }?>" ><a href="<?php echo ncUrl(array('act'=>'show_store','op'=>'credit','id'=>$output['store_info']['store_id']));?>"><span><?php echo $lang['nc_credit'];?><i></i></span></a></li>
		      <li class="<?php if($output['page'] == 'map'){?>active<?php }else{?>normal<?php }?> pngFix"><a href="<?php echo ncUrl(array('act'=>'show_store','op'=>'store_info','id'=>$output['store_info']['store_id']));?>"><span><?php echo $lang['nc_store_info'];?><i></i></span></a></li>
		      <?php if(!empty($output['store_navigation_list']) && is_array($output['store_navigation_list'])){?>
		      <?php foreach($output['store_navigation_list'] as $value){
		        if($value['sn_url'] != ''){?>
		      <li class="<?php if($output['page'] == $value['sn_id']){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo $value['sn_url']; ?>" <?php if($value['sn_new_open']){?>target="_blank"<?php }?>><span><?php echo $value['sn_title'];?><i></i></span></a></li>
		      <?php 
		        }else{
		        	?>
		      <li class="<?php if($output['page'] == $value['sn_id']){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id'],'article'=>$value['sn_id']));?>"><span><?php echo $value['sn_title'];?><i></i></span></a></li>
		      <?php }}?>
		      <?php }?>
		    </ul>
		  </nav>
  	</div>
  	<script type="text/javascript">
  	var banner_src=$("#style8_nav").html();
  	if(banner_src != null){
  		$(".ncsl-nav").append('<table style="width:1000px;" class="style8_nav" border="0" cellpadding="0" cellspacing="0">'+banner_src+'</table>');
  	}else{
  		$(".ncsl-nav").append($("#nav"));
  	}
  	$("#theme_nav").remove();
  	</script>
    <?php }else{?>
  <div class="banner">
	  	<a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store', $output['store_info']['store_domain']);?>" class="img">
	    <?php if(!empty($output['store_info']['store_banner'])){?>
	    <img src="<?php echo ATTACH_STORE.'/'.$output['store_info']['store_banner'];?>" alt="<?php echo $output['store_info']['store_name']; ?>" title="<?php echo $output['store_info']['store_name']; ?>" class="pngFix">
	    <?php }else{?>
	    <div class="ncs-default-banner pngFix"></div>
	    <?php }?>
	    </a>
    </div>
  <nav id="nav" class="pngFix">
    <ul class="pngFix">
      <li class="<?php if($output['page'] == 'index'){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']),'store',$output['store_info']['store_domain']);?>"><span><?php echo $lang['nc_store_index'];?><i></i></span></a></li>
      <?php if($output['page'] == 'goods'){?>
      <li class="active"><a href="JavaScript:void(0);"><span><?php echo $lang['nc_goods_info'];?><i></i></span></a></li>
      <?php }?>
      <?php if($output['page'] == 'coupon'){?>
      <li class="active"><a href="JavaScript:void(0);"><span><?php echo $lang['nc_coupon'];?><i></i></span></a></li>
      <?php }?>
      <?php if($output['page'] == 'bundling'){?>
      <li class="active"><a href="JavaScript:void(0);"><span><?php echo $lang['nc_bundling'];?><i></i></span></a></li>
      <?php }?>
      <li class="<?php if($output['page'] == 'credit'){?>active<?php }else{?>normal<?php }?>" ><a href="<?php echo ncUrl(array('act'=>'show_store','op'=>'credit','id'=>$output['store_info']['store_id']));?>"><span><?php echo $lang['nc_credit'];?><i></i></span></a></li>
      <li class="<?php if($output['page'] == 'map'){?>active<?php }else{?>normal<?php }?> pngFix"><a href="<?php echo ncUrl(array('act'=>'show_store','op'=>'store_info','id'=>$output['store_info']['store_id']));?>"><span><?php echo $lang['nc_store_info'];?><i></i></span></a></li>
      <?php if(!empty($output['store_info']['nav'])){
      		foreach($output['store_info']['nav'] as $value){
      			if($value['sn_url'] != ''){?>
      			<li class="<?php if($output['page'] == $value['sn_id']){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo $value['sn_url']; ?>" <?php if($value['sn_new_open']){?>target="_blank"<?php }?>><span><?php echo $value['sn_title'];?><i></i></span></a></li>
      			<?php }else{ ?>
      			<li class="<?php if($output['page'] == $value['sn_id']){?>active<?php }else{?>normal<?php }?>"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id'],'article'=>$value['sn_id']));?>"><span><?php echo $value['sn_title'];?><i></i></span></a></li>
      <?php }}} ?>
    </ul>
  </nav>
    <?php }?>
</div>
