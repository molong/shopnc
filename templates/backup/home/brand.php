<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('home/cur_local');?>

<div class="content" style="margin-bottom:10px; ">
  <div class="left">
    <div class="module_sidebar">
      <h2><b><?php echo $lang['brand_index_recommend_brand'];?></b></h2>
      <ul class="brands2">
        <?php if(!empty($output['brand_r']) && is_array($output['brand_r'])){?>
        <?php foreach($output['brand_r'] as $key=>$brand_r){?>
        <li class="picture"><a href="<?php echo ncUrl(array('act'=>'brand','op'=>'list','brand'=>$brand_r['brand_id']));?>" target="_blank"><span class="thumb size-brand-logo"><i></i><img src="<?php if(!empty($brand_r['brand_pic'])){echo ATTACH_BRAND.'/'.$brand_r['brand_pic'];}else{echo TEMPLATES_PATH.'/images/default_brand_image.gif';}?>" onload="javascript:DrawImage(this,88,42);" alt="" title="<?php echo $brand_r['brand_name'];?>" /></span></a></li>
        <?php }?>
        <?php }?>
      </ul>
      <div id="starStore">
        <h2><b><?php echo $lang['brand_index_recommend_store'];?></b></h2>
        <?php if(!empty($output['store_r']) && is_array($output['store_r'])){?>
        <?php foreach($output['store_r'] as $key=>$store_r){?>
        <div class="store" style="padding-bottom: 12px;">
          <div class="picture"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$store_r['store_id']),'store',$store_r['store_domain']);?>" target="_blank"><span class="thumb size72"><i></i><img src="<?php if(!empty($store_r['store_logo'])){echo $store_r['store_logo'];}else{ echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_store_logo']; }?>" onload="javascript:DrawImage(this,72,72);"/></span></a></div>
          <dl>
            <dt><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$store_r['store_id']),'store',$store_r['store_domain']);?>" target="_blank"><?php echo $store_r['store_name'];?></a></dt>
            <dd><?php echo $lang['brand_index_store_owner'].$lang['nc_colon'].$store_r['member_name'];?></dd>
            <dd><?php echo $lang['brand_index_goods'].$lang['nc_colon'].$store_r['goods_count'];?></dd>
            <dd>
              <?php if (empty($store_r['credit_arr'])){ echo  $lang['brand_index_credit'].$lang['nc_colon'].$store_r['store_credit']; }else {?>
              <span class="seller-<?php echo $store_r['credit_arr']['grade']; ?> level-<?php echo $store_r['credit_arr']['songrade']; ?>"></span>
              <?php }?>
            </dd>
          </dl>
        </div>
        <?php }?>
        <?php }?>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <div class="right">
    <div class="module_sidebar" style=" width:768px;"> 
      <h2><b><?php echo $lang['brand_index_brand_list'];?></b></h2>
      <?php if(!empty($output['brand_c']) && is_array($output['brand_c'])){?>
      <?php foreach($output['brand_c'] as $key=>$brand_c){?>
      <div class="wrap">
        <div class="brands_list">
          <h3 class="bg_color1"><a href="#"><?php echo $key=='other'?'':$key;?>(<?php echo $brand_c['brand_class'];?>)</a></h3>
          <ul class="brands_pic">
            <?php if(!empty($brand_c['brand']) && is_array($brand_c['brand'])){?>
            <?php foreach($brand_c['brand'] as $key=>$brand){?>
            <li><a href="<?php echo ncUrl(array('act'=>'brand','op'=>'list','brand'=>$brand['brand_id']));?>" target="_blank" class="picture"><span class="thumb size-brand-logo"><i></i><img src="<?php if(!empty($brand['brand_pic'])){echo ATTACH_BRAND.'/'.$brand['brand_pic'];}else{echo TEMPLATES_PATH.'/images/default_brand_image.gif';}?>" alt="<?php echo $brand['brand_name'];?>"  onload="javascript:DrawImage(this,88,42);"/></span></a></li>
            <?php }?>
            <?php }?>
          </ul>
          <div class="clear"></div>
        </div>
      </div>
      <?php }?>
      <?php }?>
    </div>
  </div>
</div>
