<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_PATH.'/js/search_goods.js';?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH.'/js/jquery.select.park.js';?>" charset="utf-8"></script>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.datalazyload.js" type="text/javascript"></script>

<script type="text/javascript" >
	var defaultSmallGoodsImage = '<?php echo defaultGoodsImage('small');?>';
	var defaultTinyGoodsImage = '<?php echo defaultGoodsImage('tiny');?>';

	$(document).ready(function(){
		$('.squares').children('ul').children('li').bind('mouseenter',function(){
			$('.squares').children('ul').children('li').attr('class','c1');
			$(this).attr('class','c2');
		});
	
		$('.squares').children('ul').children('li').bind('mouseleave',function(){
			$('.squares').children('ul').children('li').attr('class','c1');
		});
	});
</script>
<?php include template('home/cur_local');?>
<div class="content">
  <div class="left">
    <div class="module_sidebar">
      <?php if(isset($output['brand_r']) && is_array($output['brand_r'])){?>
      <h2><b><?php echo $lang['brand_index_recommend_brand'];?></b></h2>
      <div class="wrap">
      <ul class="brands2">
        <?php foreach($output['brand_r'] as $key=>$brand_r){?>
        <li class="picture"><a href="<?php echo ncUrl(array('act'=>'brand','op'=>'list','brand'=>$brand_r['brand_id']));?>" target="_blank"><span class="thumb size-brand-logo"><i></i><img src="<?php if(!empty($brand_r['brand_pic'])){echo ATTACH_BRAND.'/'.$brand_r['brand_pic'];}else{echo TEMPLATES_PATH.'/images/default_brand_image.gif';}?>" onload="javascript:DrawImage(this,88,42);" alt="" title="<?php echo $brand_r['brand_name'];?>" /></span></a></li>
        <?php }?>
      </ul>
      </div>
      <?php }?>
      <div class="clear"></div>
    </div>
  <?php if (C('gold_isuse')==1 && C('ztc_isuse')==1){?>
  <div class="group-hot">
            <div class="module_sidebar">
                <h2 style=" font-size: 14px; color: #C00;"><?php echo $lang['brand_hot_sale'];?></h2>
                <ul>
                    <?php if(is_array($output['ztc_list'])) { $i=0;?>
                    <?php foreach($output['ztc_list'] as $val) { $i++;?>
                    <li <?php if($i == 1){?>style=" border:none"<?php }?>><div class="name"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']),'goods');?>" target="_blank"><?php echo $val['goods_name'];?></a></div>
                    <div class="box" style="height:168px;width:168px;">
                        <div class="price"><span class="l"><?php echo $lang['currency'];?><?php if (intval($val['xianshi_flag']) === 1){ echo ncPriceFormat($val['goods_store_price'] * $val['xianshi_discount'] / 10);}else {echo $val['goods_store_price'];}?></span></div>
                        <div class="mask"></div>
                        <div class="pic" style="height:160px;width:160px;"><span class="thumb" style="height:160px;width:160px;"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']),'goods');?>" target="_blank"><img src="<?php echo thumb($val,'small');?>" onload="javascript:DrawImage(this,160,160);"></a></span></div>
                    </div>
                    <div class="info"><span><?php echo $lang['brand_already_sale'];?><em><?php echo $val['salenum'];?></em><?php echo $lang['brand_index_jian'];?></span><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']),'goods');?>" target="_blank"><?php echo $lang['brand_go_to_see'];?></a></div>
                    </li>
                    <?php } ?>
                    <?php } ?>
                </ul>
        </div></div>
   <?php }?>
    <div class="module_sidebar">
      <script type="text/javascript" src="<?php echo SiteUrl;?>/index.php?act=adv&op=advshow&ap_id=37"></script>
      <div class="clear"></div>
    </div>
    <div class="module_sidebar">
      <h2><b><?php echo $lang['brand_index_viewed_goods']; ?></b></h2>
      <ul class="bowers">
        <?php foreach ($output['viewed_goods'] as $k=>$v){?>
        <li>
          <div class="picture"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods'); ?>"><span class="thumb size60"><i></i><img src="<?php echo thumb($v,'tiny'); ?>" onload="javascript:DrawImage(this,60,60);" title="<?php echo $v['goods_name']; ?>" alt="<?php echo $v['goods_name']; ?>" ></span></a></div>
          <p class="name"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['goods_id']), 'goods'); ?>"><?php echo $v['goods_name']; ?></a></p>
          <p class="price"><span><?php echo $lang['currency'];?><?php echo $v['goods_store_price']; ?></span></p>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
<div class="right">
  <div class="shop_con_list" id="main-nav-holder">
    <nav class="nc-gl-sort-bar" id="main-nav">
      <div class="sort-bar">
        <div class="bar-r">
          <div class="select-layer">
            <div class="holder"><em><?php echo $output['form']?$output['form']:$lang['brand_form']?></em></div>
            <div class="selected"><a><?php echo $output['form']?$output['form']:$lang['brand_form']?></a></div>
            <i class="direction"></i>
            <ul class="options">
              <li><a href="javascript:void(0)" onClick="javascript:replaceParam('form','1');" title="<?php echo $lang['brand_form_new'];?>"><?php echo $lang['brand_form_new'];?></a></li>
              <li><a href="javascript:void(0)" onClick="javascript:replaceParam('form','2');" title="<?php echo $lang['brand_form_used'];?>"><?php echo $lang['brand_form_used'];?></a></li>
              <li class="order-default"><a href="javascript:void(0)" onClick="javascript:dropParam('form');" title="<?php echo $lang['brand_unlimit'];?>"><?php echo $lang['brand_unlimit'];?></a></li>
            </ul>
          </div>
          <div class="select-layer">
            <div class="holder"><em><?php echo $output['promotion']?$output['promotion']:$lang['brand_index_promotion']?></em></div>
            <div class="selected"><a><?php echo $output['promotion']?$output['promotion']:$lang['brand_index_promotion']?></a></div>
            <i class="direction"></i>
            <ul class="options">
              <li><a href="javascript:void(0)" onClick="javascript:replaceParam('promotion','groupbuy');" title="<?php echo $lang['brand_index_groupbuy'];?>"><?php echo $lang['brand_index_groupbuy'];?></a></li>
              <li><a href="javascript:void(0)" onClick="javascript:replaceParam('promotion','xianshi');" title="<?php echo $lang['brand_index_xianshi'];?>"><?php echo $lang['brand_index_xianshi'];?></a></li>
              <li class="order-default"><a href="javascript:void(0)" onClick="javascript:dropParam('promotion');" title="<?php echo $lang['brand_unlimit'];?>"><?php echo $lang['brand_unlimit'];?></a></li>
            </ul>
          </div>
          <div class="select-layer">
            <div class="holder"><em nc_type="area_name"><?php echo $lang['brand_index_area']; ?><!-- 所在地 --></em></div>
            <div class="selected"><a nc_type="area_name"><?php echo $lang['brand_index_area']; ?><!-- 所在地 --></a></div>
            <i class="direction"></i>
			<ul class="options">
          <?php require(BASE_TPL_PATH.'/home/goods_class_area_'.(strtolower(CHARSET)=='utf-8'?'utf-8':'gbk').'.html');?>
          </ul>
          </div>
        </div>
        <div class="bar-l"> 
          <!-- 查看方式S -->
          <div class="switch"><span <?php if($output['display_mode'] == 'squares'){?>class="selected"<?php }?>><a href="" class="pm" nc_type="display_mode" ecvalue="squares" title="<?php echo $lang['brand_index_by_pane'];?>"><?php echo $lang['brand_index_pane'];?></a></span><span <?php if($output['display_mode'] == 'list'){?>class="selected"<?php }?> style="border-left:none;"><a href="" class="lm" nc_type="display_mode" ecvalue="list" title="<?php echo $lang['brand_index_by_list'];?>"><?php echo $lang['brand_index_list'];?></a></span></div>
          <!-- 查看方式E --> 
          <!-- 排序方式S -->
          <ul class="array">
            <li <?php if(!$_GET['key']){?>class="selected"<?php }?>><a href="javascript:void(0)" class="nobg" onClick="javascript:dropParam(['key','order'],'','array');" title="<?php echo $lang['brand_index_default_sort'];?>"><?php echo $lang['brand_index_default'];?></a></li>
            <li <?php if($_GET['key'] == 'sales'){?>class="selected"<?php }?>><a href="javascript:void(0)" <?php if($_GET['key'] == 'sales'){?>class="<?php echo $_GET['order'];?>"<?php }?> onClick="javascript:replaceParam(['key','order'],['sales','<?php echo ($_GET['order'] == 'desc' && $_GET['key'] == 'sales')?'asc':'desc' ?>'],'array');" title="<?php echo ($_GET['order'] == 'desc' && $_GET['key'] == 'sales')?$lang['brand_index_sold_asc']:$lang['brand_index_sold_desc']; ?>"><?php echo $lang['brand_index_sold']	;?></a></li>
            <li <?php if($_GET['key'] == 'click'){?>class="selected"<?php }?>><a href="javascript:void(0)" <?php if($_GET['key'] == 'click'){?>class="<?php echo $_GET['order'];?>"<?php }?> onClick="javascript:replaceParam(['key','order'],['click','<?php  echo ($_GET['order'] == 'desc' && $_GET['key'] == 'click')?'asc':'desc' ?>'],'array');" title="<?php  echo ($_GET['order'] == 'desc' && $_GET['key'] == 'click')?$lang['brand_index_click_asc']:$lang['brand_index_click_desc']; ?>"><?php echo $lang['brand_index_click']?></a></li>
            <li <?php if($_GET['key'] == 'credit'){?>class="selected"<?php }?>><a href="javascript:void(0)" <?php if($_GET['key'] == 'credit'){?>class="<?php echo $_GET['order'];?>"<?php }?> onClick="javascript:replaceParam(['key','order'],['credit','<?php echo ($_GET['order'] == 'desc' && $_GET['key'] == 'credit')?'asc':'desc' ?>'],'array');" title="<?php echo ($_GET['order'] == 'desc' && $_GET['key'] == 'credit')?$lang['brand_index_credit_asc']:$lang['brand_index_credit_desc']; ?>"><?php echo $lang['brand_index_credit'];?></a></li>
            <li <?php if($_GET['key'] == 'price'){?>class="selected"<?php }?>><a href="javascript:void(0)" <?php if($_GET['key'] == 'price'){?>class="<?php echo $_GET['order'];?>"<?php }?> onClick="javascript:replaceParam(['key','order'],['price','<?php echo ($_GET['order'] == 'desc' && $_GET['key'] == 'price')?'asc':'desc' ?>'],'array');" title="<?php echo ($_GET['order'] == 'desc' && $_GET['key'] == 'price')?$lang['brand_index_price_asc']:$lang['brand_index_price_desc']; ?>"><?php echo $lang['brand_index_price'];?></a></li>
          </ul>
          <!-- 排序方式E --> 
          <!-- 价格段S -->
          <div class="prices">
            <em>&yen;</em><input  type="text" class="w30" value="<?php echo $output['price_interval'][0];?>" /><em>-</em><input type="text" class="w30" value="<?php echo $output['price_interval'][1];?>" /><input id="search_by_price" type="submit" value="<?php echo $lang['brand_affirm'];?>" />
          </div>
          <!-- 价格段E --> 
        </div>
      </div>
    </nav>
    <!-- 商品列表循环  -->
	<div id="div_lazyload">
		<textarea class="text-lazyload" style="display: none;">
        <?php require_once (BASE_TPL_PATH.'/home/brand_goods_'.$output['display_mode'].'.php');?>
		</textarea>
	</div>
    <div class="clear"></div>
    <div class="pagination"> <?php echo $output['show_page']; ?> </div>
  </div>
</div>
</div>