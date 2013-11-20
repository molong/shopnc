<?php defined('InShopNC') or exit('Access Invalid!');?>

  <div class="nc-home-pattern style-<?php echo $output['style_name'];?>">
    <div class="rightbar">
      <div class="title">
        <h3><?php echo $output['code_goods_list']['code_info']['name'];?></h3>
      </div>
      <ol class="saletop-list">
					        <?php if(!empty($output['code_goods_list']['code_info']['goods']) && is_array($output['code_goods_list']['code_info']['goods'])){ 
					        	$i = 0;
					        	?>
							        <?php foreach($output['code_goods_list']['code_info']['goods'] as $key => $val){ 
							        	$i++;
							        	?>
										        	<?php if($i <= 3){ ?>
        <li class="top">
          <dl>
            <dt class="goods-name"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods'); ?>" target="_blank" title="<?php echo $val['goods_name'];?>">
            	<?php echo $val['goods_name'];?></a></dt>
            <dd class="nokey"><?php echo $i;?></dd>
            <dd class="goods-pic"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods'); ?>" target="_blank" title="<?php echo $val['goods_name'];?>"><span class="thumb size60"><i></i>
            <img src="<?php echo strpos($val['goods_pic'],'http')===0 ? $val['goods_pic']:SiteUrl."/".$val['goods_pic'];?>" title="<?php echo $val['goods_name'];?>" onload="javascript:DrawImage(this,60,60);" target="_blank">
            </span></a></dd>
            <dd class="goods-price"><em><?php echo $val['goods_price'];?></em></dd>
          </dl>
        </li>
										        	<?php }else { ?>
        <li class="normal"><i><?php echo $i;?></i>
        	<a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods'); ?>" target="_blank" title="<?php echo $val['goods_name'];?>"><?php echo $val['goods_name'];?></a></li>
										        	<?php } ?>
							        <?php } ?>
              		<?php } ?>
      </ol>
      <div class="ad-banner">
      	<?php if($output['code_adv']['code_info']['type'] == 'adv' && $output['code_adv']['code_info']['ap_id']>0){ ?>
      	<script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=<?php echo $output['code_adv']['code_info']['ap_id'];?>"></script>
      	<?php }else { ?>
      	<a href="<?php echo $output['code_adv']['code_info']['url'];?>" target="_blank">
      	<img border=0 src="<?php  echo SiteUrl.'/'.$output['code_adv']['code_info']['pic'];?>">
      	</a>
      	<?php } ?>
      </div>
    </div>
    <div class="leftbar">
      <div class="title">
      	<?php if (!empty($output['code_tit']['code_info']['url'])) { ?>
      	<a href="<?php echo $output['code_tit']['code_info']['url'];?>" target="_blank">
      	<img border=0 src="<?php  echo SiteUrl.'/'.$output['code_tit']['code_info']['pic'];?>" >
      	</a>
      	<?php }else { ?>
      	<img border=0 src="<?php  echo SiteUrl.'/'.$output['code_tit']['code_info']['pic'];?>" >
      	<?php } ?>
      </div>
      <div class="category">
      	
                  <?php if (!empty($output['code_category_list']['code_info']) && is_array($output['code_category_list']['code_info'])) { ?>
                  <?php foreach ($output['code_category_list']['code_info'] as $key => $val) { ?>
        <dl>
          <dt><a href="index.php?act=search&cate_id=<?php echo $val['gc_parent']['gc_id'];?>" title="<?php echo $val['gc_parent']['gc_name'];?>" target="_blank"><?php echo $val['gc_parent']['gc_name'];?></a></dt>
		                  <?php if (!empty($val['goods_class']) && is_array($val['goods_class'])) { ?>
		                  <?php foreach ($val['goods_class'] as $k => $v) { ?>
          <dd><a href="index.php?act=search&cate_id=<?php echo $v['gc_id'];?>" title="<?php echo $v['gc_name'];?>" target="_blank"><?php echo $v['gc_name'];?></a></dd>
		                  <?php } ?>
		                  <?php } ?>
        </dl>
                  <?php } ?>
                  <?php } ?>
      </div>
      <div class="sale-pic">
      	<?php if($output['code_act']['code_info']['type'] == 'adv' && $output['code_act']['code_info']['ap_id']>0){ ?>
      	<script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=<?php echo $output['code_act']['code_info']['ap_id'];?>"></script>
      	<?php }else { ?>
      	<a href="<?php echo $output['code_act']['code_info']['url'];?>" target="_blank">
      	<img border=0 src="<?php  echo SiteUrl.'/'.$output['code_act']['code_info']['pic'];?>">
      	</a>
      	<?php } ?>
      </div>
    </div>
    <div class="middle">
      <ul class="tabs-nav">
      	
                  <?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) { ?>
                  <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
        <li class="<?php echo $key==1 ? 'tabs-selected':'';?>"><a href="JavaScript:void(0);"><?php echo $val['recommend']['name'];?></a></li>
                  <?php } ?>
                  <?php } ?>
      </ul>
      
                  <?php if (!empty($output['code_recommend_list']['code_info']) && is_array($output['code_recommend_list']['code_info'])) { ?>
                  <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
      <div class="tabs-panel <?php echo $key==1 ? '':'tabs-hide';?>">
        <ul>
        <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])){ ?>
        <?php foreach($val['goods_list'] as $k => $v){ ?>
          <li>
            <dl>
              <dt class="goods-name"><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']),'goods'); ?>" title="<?php echo $v['goods_name']; ?>">
              	<?php echo $v['goods_name']; ?></a></dt>
              <dd class="goods-pic"><span class="thumb size120"><i></i>
              	<a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id'],'id'=>$v['store_id']),'goods'); ?>">
              	<img src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:SiteUrl."/".$v['goods_pic'];?>" alt="<?php echo $v['goods_name']; ?>"  onload="javascript:DrawImage(this,120,120);" />
              	</a></span></dd>
              <dd class="goods-price"><?php echo $lang['index_index_store_goods_price'].$lang['nc_colon'];?><em><?php echo $v['goods_price']; ?></em><?php echo $lang['currency_zh']; ?></dd>
            </dl>
          </li>
        <?php } ?>
        <?php } ?>
        </ul>
      </div>
                  <?php } ?>
                  <?php } ?>
    </div>
    <div class="bottom-bar">
      <ul class="brands">
                  <?php if (!empty($output['code_brand_list']['code_info']) && is_array($output['code_brand_list']['code_info'])) { ?>
                  <?php foreach ($output['code_brand_list']['code_info'] as $key => $val) { ?>
        <li>
          <div class="brands-logo"><i></i><a href="<?php echo ncUrl(array('act'=>'brand','op'=>'list','brand'=>$val['brand_id'])); ?>" target="_blank">
          	<img src="<?php  echo SiteUrl.'/'.$val['brand_pic'];?>" alt="<?php echo $val['brand_name']; ?>"  onload="javascript:DrawImage(this,88,44);"></a></div>
          <div class="brands-name"><a href="<?php echo ncUrl(array('act'=>'brand','op'=>'list','brand'=>$val['brand_id'])); ?>" target="_blank" title="<?php echo $val['brand_name']; ?>"><?php echo $val['brand_name']; ?></a></div>
        </li>
                  <?php } ?>
                  <?php } ?>
      </ul>
    </div>
  </div>