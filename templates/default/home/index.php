<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo TEMPLATES_PATH;?>/css/home_index.css" rel="stylesheet" type="text/css">
<style type="text/css">
#all-category .category { display: block !important;}
#all-category .title i { display: none!important;}
</style>
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/ie6.js" charset="utf-8"></script>
<![endif]-->
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.KinSlideshow.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.accordion.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/tonjay.js" ></script>
<script src="<?php echo RESOURCE_PATH;?>/js/swfobject_modified.js" type="text/javascript"></script>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.lazyload.mini.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/index.js" charset="utf-8"></script>
<!-- 首页对联广告 -->
<script src="<?php echo RESOURCE_PATH;?>/js/double_adv.js" type="text/javascript"></script>
<script language="JavaScript">
    var tms = [];
    var day = [];
    var hour = [];
    var minute = [];
    var second = [];
    function takeCount() {
        setTimeout("takeCount()", 1000);
        for (var i = 0, j = tms.length; i < j; i++) {
            tms[i] -= 1;
            //计算天、时、分、秒、
            var days = Math.floor(tms[i] / (1 * 60 * 60 * 24));
            var hours = Math.floor(tms[i] / (1 * 60 * 60)) % 24;
            var minutes = Math.floor(tms[i] / (1 * 60)) % 60;
            var seconds = Math.floor(tms[i] / 1) % 60;
            if (days < 0) days = 0;
            if (hours < 0) hours = 0;
            if (minutes < 0) minutes = 0;
            if (seconds < 0) seconds = 0;
            //将天、时、分、秒插入到html中
            document.getElementById(day[i]).innerHTML = days;
            document.getElementById(hour[i]).innerHTML = hours;
            document.getElementById(minute[i]).innerHTML = minutes;
            document.getElementById(second[i]).innerHTML = seconds;
        }
    }
    setTimeout("takeCount()", 1000);
</script>

<div class="advshow_float" style='left:0px; position:absolute; top:69px; display:none; z-index:999;'> 
  <script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=14"></script> 
  <br>
  <a href='JavaScript:;' onclick="$(this).parent().hide();"><img border=0 src="<?php echo TEMPLATES_PATH;?>/images/close.gif"></a> </div>
<div class="advshow_float" style='right:0px; position:absolute; top:69px; display:none; z-index:999;'> 
  <script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=15"></script> 
  <br>
  <a href='JavaScript:;' onclick="$(this).parent().hide();"><img border=0 src="<?php echo TEMPLATES_PATH;?>/images/close.gif"></a> </div>
<div class="mb10 warp-all">
  <div class="fl w210"> </div>
  <div class="fr w780">
    <div class="fr w240">
      <?php if($_SESSION['is_login'] == '1'){ ?>
      <div id="userInfo">
        <?php if($output['member_info']['member_avatar'] != ''){ ?>
        <div class="head-portrait"><span class="thumb size32"><i></i><img src="<?php echo ATTACH_AVATAR.'/'.$output['member_info']['member_avatar'];?>" height="32" width="32"/></span></div>
        <?php }?>
        <p class="pngFix"><?php echo $lang['index_index_hello'];?> <span><?php echo str_cut($output['member_info']['member_name'],16);?></span> &gt; <a href="index.php?act=member_snsindex"><?php echo $lang['index_index_user_center'];?></a></p>
        <?php if($GLOBALS['setting_config']['predeposit_isuse'] == 1 || $GLOBALS['setting_config']['points_isuse'] == 1){ ?>
        <p class="pngFix">
          <?php if($GLOBALS['setting_config']['predeposit_isuse'] == 1){ ?>
          <?php echo $lang['index_index_available_predeposit'].$lang['nc_colon'];?><strong title="<?php echo $lang['index_index_available_predeposit'].$lang['nc_colon'];?><?php echo $lang['currency'];?><?php echo $output['member_info']['available_predeposit'];?>"><?php echo $lang['currency'];?><?php echo $output['member_info']['available_predeposit'];?></strong> |
          <?php } ?>
          <?php if($GLOBALS['setting_config']['points_isuse'] == 1){ ?>
          <?php echo $lang['index_index_member_points'].$lang['nc_colon'];?><strong title="<?php echo $lang['index_index_member_points'].$lang['nc_colon'];?><?php echo $output['member_info']['member_points'];?>"><?php echo $output['member_info']['member_points'];?></strong>
          <?php }?>
        </p>
        <?php }?>
      </div>
      <?php }else{ ?>
      <div id="quickLink" class="module-sidebar-style1 mb10"><a class="login" href="index.php?act=login" title="<?php echo $lang['index_index_login'];?>"><i class="pngFix"></i><?php echo $lang['index_index_login'];?></a><a class="register" href="index.php?act=login&op=register" title="<?php echo $lang['index_index_regist'];?>"><i class="pngFix"></i><?php echo $lang['index_index_regist'];?></a><a class="join pngFix" style="width:80px;" href="index.php?act=store&op=create" title="<?php echo $lang['index_index_join'];?>"><i class="pngFix"></i><?php echo $lang['index_index_join'];?></a></div>
      <?php }?>
      <div class="module-sidebar-style1 mb10 nc-home-news" style="min-height:150px;">
        <ul class="tabs-nav">
          <?php if (!empty($output['show_article']) && is_array($output['show_article'])) { 
          	$i = 0;
          	?>
          <?php foreach ($output['show_article'] as $key => $val) { 
          	$i++;
          	?>
          <li class="<?php echo $i==1 ? 'tabs-selected':'';?>"><a href="javascript:void(0)"><?php echo $val['ac_name'];?></a></li>
          <?php }?>
          <?php }?>
        </ul>
        
          <?php if (!empty($output['show_article']) && is_array($output['show_article'])) { 
          	$i = 0;
          	?>
          <?php foreach ($output['show_article'] as $key => $val) { 
          	$i++;
          	?>
        <div class="tabs-panel <?php echo $i>1 ? 'tabs-hide':'';?>">
          <ul class="list-style01">
            <?php
			  	if(!empty($val['list']) && is_array($val['list'])) { 
				foreach($val['list'] as $k => $v){
				?>
            <li><a <?php if(!empty($v['article_url'])){?>target="_blank" <?php }?>href="<?php if(!empty($v['article_url']))echo $v['article_url'];else{ echo ncUrl(array('act'=>'article','article_id'=>$v['article_id']),'article');}?>" title="<?php echo $v['article_title']; ?>"><?php echo str_cut($v['article_title'],24);?>
            </a><span>(<?php echo date('Y-m-d',$v['article_time']);?>)</span>
            </li>
            <?php } } ?>
          </ul>
        </div>
          <?php }?>
          <?php }?>
      </div>
      <div class="nc-home-news module-sidebar-style1 mb10" style="min-height:115px;">
        <ul class="tabs-nav">
          <li class="tabs-selected"><a href="javascript:void(0)"><?php echo $lang['index_index_recommend_store'];?></a></li>
          <?php if(!empty($output['show_favorites_store']) && is_array($output['show_favorites_store'])) { ?>
          <li><a href="javascript:void(0)"><?php echo $lang['index_index_favorites_store'];?></a></li>
          <?php } ?>
          <?php if(!empty($output['show_new_store']) && is_array($output['show_new_store'])) { ?>
          <li><a href="javascript:void(0)"><?php echo $lang['index_index_new_store'];?></a></li>
          <?php } ?>
        </ul>
        <div class="tabs-panel">
          <ul class="nc-index-stores">
            <?php
			if(!empty($output['show_recommend_store']) && is_array($output['show_recommend_store'])) {
				foreach($output['show_recommend_store'] as $val) {
			?>
            <li>
              <dl>
                <dt><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']); ?>" title="<?php echo $val['store_name']; ?>"><?php echo $val['store_name']; ?></a></dt>
                <dd class="picture"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']); ?>"><span class="thumb size70"><i></i><img src="<?php echo $val['store_logo']; ?>" onload="javascript:DrawImage(this,70,70);"></span></a></dd>
              </dl>
            </li>
            <?php } } ?>
          </ul>
        </div>
        <?php if(!empty($output['show_favorites_store']) && is_array($output['show_favorites_store'])) { ?>
        <div class="tabs-panel tabs-hide">
          <ul class="nc-index-stores">
        <?php foreach($output['show_favorites_store'] as $val) { ?>
            <li>
              <dl>
                <dt><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']); ?>" title="<?php echo $val['store_name']; ?>"><?php echo $val['store_name']; ?></a></dt>
                <dd class="picture"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']); ?>"><span class="thumb size70"><i></i><img src="<?php echo $val['store_logo']; ?>" onload="javascript:DrawImage(this,70,70);"></span></a></dd>
              </dl>
            </li>
        <?php } ?>
          </ul>
        	</div>
        <?php } ?>
        <?php if(!empty($output['show_new_store']) && is_array($output['show_new_store'])) { ?>
        <div class="tabs-panel tabs-hide">
          <ul class="nc-index-stores">
        <?php foreach($output['show_new_store'] as $val) { ?>
            <li>
              <dl>
                <dt><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']); ?>" title="<?php echo $val['store_name']; ?>"><?php echo $val['store_name']; ?></a></dt>
                <dd class="picture"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']); ?>"><span class="thumb size70"><i></i><img src="<?php echo $val['store_logo']; ?>" onload="javascript:DrawImage(this,70,70);"></span></a></dd>
              </dl>
            </li>
        <?php } ?>
          </ul>
        	</div>
        <?php } ?>
      </div>
    </div>
    <div class="fl w530"><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=13"></script>
      <div id="mallRecommend" class="clearfix">
        <div id="slideshow" class="clearfix">
          <ul class="fourpics current">
            <li><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=20"></script></li>
            <li><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=21"></script></li>
            <li><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=22"></script></li>
            <li><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=23"></script></li>
          </ul>
          <ul class="twopics normal ">
            <li><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=24"></script></li>
            <li><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=25"></script></li>
          </ul>
          <div id="previous" class="previous pngFix"><a href="JavaScript:void(0);" title="<?php echo $lang['index_index_previous'];?>">&laquo;</a></div>
          <div id="next" class="next pngFix"><a href="JavaScript:void(0);" title="<?php echo $lang['index_index_next'];?>">&raquo;</a></div>
        </div>
      </div>
    </div><div class="clear"></div>
  </div>
  
  <div class="fl w750 nc-home-sale mt10">
    <ul class="tabs-nav">
      <li class="tabs-selected"><a href="JavaScript:void(0);"><?php echo $lang['index_index_special_recommend'];?></a></li>
      <?php if(!empty($output['xianshi_item']) && is_array($output['xianshi_item'])) { ?>
      <li><a href="JavaScript:void(0);"><?php echo $lang['nc_xianshi'];?></a></li>
      <?php } ?>
    </ul>
    <div class="tabs-panel">
      <ul class="specially">
        <?php if(!empty($output['recommend_best_item']) && is_array($output['recommend_best_item'])) { ?>
        <?php foreach($output['recommend_best_item'] as $val) { ?>
        <li>
          <dl>
            <dt class="goods-name"><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods'); ?>" title="<?php echo $val['goods_name']; ?>"><?php echo $val['goods_name']; ?></a></dt>
            </dt>
            <dd class="goods-pic"><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods'); ?>"> <span class="thumb size150"><i></i><img src="<?php echo thumb($val,'small');?>" onload="javascript:DrawImage(this,150,150);" alt="<?php echo $val['goods_name']; ?>" /></span></a></dd>
            <dd class="goods-price"> <?php echo $lang['index_index_store_goods_price'].$lang['nc_colon'];?><em><?php echo $val['goods_store_price']; ?></em><?php echo $lang['currency_zh']; ?></dd>
            <dd class="sale"><?php echo $lang['index_index_special_goods'];?></dd>
          </dl>
        </li>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
        <?php if(!empty($output['xianshi_item']) && is_array($output['xianshi_item'])) { ?>
    <div class="tabs-panel tabs-hide">
      <ul class="specially">
        <?php foreach($output['xianshi_item'] as $val) { ?>
        <li>
          <dl>
            <dt class="goods-name"><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods'); ?>" title="<?php echo $val['goods_name']; ?>"><?php echo $val['goods_name']; ?></a></dt>
            </dt>
            <dd class="goods-pic"><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods'); ?>"> <span class="thumb size150"><i></i><img src="<?php echo thumb($val,'small');?>" onload="javascript:DrawImage(this,150,150);" alt="<?php echo $val['goods_name']; ?>" /></span></a></dd>
            <dd class="goods-price"> <?php echo $lang['index_index_store_goods_price'].$lang['nc_colon'];?><em><?php echo $val['goods_store_price']; ?></em><?php echo $lang['currency_zh']; ?></dd>
            <dd class="sale"><?php echo $val['discount']; ?><br/>
              <?php echo $lang['nc_xianshi_flag'];?></dd>
          </dl>
        </li>
        <?php } ?>
      </ul>
    </div>
        <?php } ?>
  </div>
  <div class="fr w240 mt10">
      <?php if (intval($GLOBALS['setting_config']['groupbuy_allow']) === 1){ ?>
    <div class="module-sidebar-style2">
      <div class="nc-index-groupbuy">
        <div class="title">
          <h3 title="<?php echo $lang['index_index_groupbuy'];?>"><a href="index.php?act=show_groupbuy" target="_blank"><?php echo $lang['index_index_groupbuy'];?></a></h3>
        </div>
        <?php if(is_array($output['group_list'])) { ?>
        <dl>
          <dt class="name"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$output['group_list']['group_id'],'id'=>$output['group_list']['store_id']), 'groupbuy');?>" title="<?php echo $output['group_list']['group_name']; ?>" target="_blank"><?php echo $output['group_list']['group_name']; ?></a></dt>
          <dd class="fixed">
            <div class="picture"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$output['group_list']['group_id'],'id'=>$output['group_list']['store_id']), 'groupbuy');?>" target="_blank"><img src="<?php echo gthumb($output['group_list']['group_pic'],'small');?>" onload="javascript:DrawImage(this,160,160);" alt="<?php echo $output['group_list']['group_name']; ?>"></a></div>
          </dd>
          <dd class="priceLabel"><?php echo $lang['currency'];?><?php echo $output['group_list']['groupbuy_price']; ?></dd>
          <dd class="discount">
            <p><?php echo $lang['index_index_groupdiscount']; ?></p>
            <p><?php echo $output['group_list']['rebate'];?><?php echo $lang['index_index_groupsaveunit']; ?></p>
          </dd>
          <dd class="saveosts">
            <p><?php echo $lang['index_index_groupsaveprice']; ?></p>
            <p><?php echo $lang['currency'];?><?php echo sprintf("%01.2f",$output['group_list']['goods_price']-$output['group_list']['groupbuy_price']);; ?></p>
          </dd>
          <dd class="time"><s class="remain"></s> <span class="time-remain"> <span id="d1">0</span><?php echo $lang['text_tian'];?><span id="h1">0</span><?php echo $lang['text_hour'];?><span id="m1">0</span><?php echo $lang['text_minute'];?><span id="s1">0</span><?php echo $lang['text_second'];?> </span> 
            <script type="text/javascript">
tms[tms.length] = "<?php echo $output['count_down'];?>";
day[day.length] = "d1";
hour[hour.length] = "h1";
minute[minute.length] = "m1";
second[second.length] = "s1";
</script> 
          </dd>
          <dd class="btn"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$output['group_list']['group_id'],'id'=>$output['group_list']['store_id']), 'groupbuy');?>" title="<?php echo $output['group_list']['group_name']; ?>" target="_blank"><?php echo $lang['index_index_groupbuy']; ?></a></dd>
        </dl>
        <?php } ?>
      </div>
    </div>
      <?php } ?>
  </div>
  <div class="clear"></div>
  <?php echo $output['web_html'];?>
  
  <div class="mt10"><script type="text/javascript" src="<?php echo SiteUrl;?>/api.php?act=adv&op=advshow&ap_id=9"></script></div>
  <div class="full_module">
    <h2><b><?php echo $lang['index_index_link'];?></b></h2>
    <div class="piclink">
      <?php 
		  if(is_array($output['show_flink']) && !empty($output['show_flink'])) {
		  	foreach($output['show_flink'] as $val) {
		  		if($val['link_pic'] != ''){
		  ?>
      <span><a href="<?php echo $val['link_url']; ?>" target="_blank"><img src="<?php echo $val['link_pic']; ?>" title="<?php echo $val['link_title']; ?>" alt="<?php echo $val['link_title']; ?>" width="88" height="31" ></a></span>
      <?php
		  		}
		 	}
		 }
		 ?>
      <div class="clear"></div>
    </div>
    <div class="textlink">
      <?php 
		  if(is_array($output['show_flink']) && !empty($output['show_flink'])) {
		  	foreach($output['show_flink'] as $val) {
		  		if($val['link_pic'] == ''){
		  ?>
      <span><a href="<?php echo $val['link_url']; ?>" target="_blank" title="<?php echo $val['link_title']; ?>"><?php echo str_cut($val['link_title'],16);?></a></span>
      <?php
		  		}
		 	}
		 }
		 ?>
      <div class="clear"></div>
    </div>
  </div>
  
  <div id="faq">
    <?php if(is_array($output['article_list']) && !empty($output['article_list'])){ ?>
    <?php foreach ($output['article_list'] as $k=>$article_class){ ?>
    <?php if(!empty($article_class)){ ?>
    <ul class="s<?php echo ''.$k+1;?>">
      <h3>
        <?php if(is_array($article_class['class'])) echo $article_class['class']['ac_name'];?>
      </h3>
      <?php if(is_array($article_class['list']) && !empty($article_class['list'])){ ?>
      <?php foreach ($article_class['list'] as $article){ ?>
      <li><a href="<?php if($article['article_url'] != '')echo $article['article_url'];else echo ncUrl(array('act'=>'article','article_id'=>$article['article_id']) ,'article');?>" title="<?php echo $article['article_title']; ?>"> <?php echo str_cut($article['article_title'],13);?> </a></li>
      <?php }?>
      <?php }?>
    </ul>
    <?php }?>
    <?php }?>
    <?php }?>
    <div class="clear"></div>
  </div>
</div>
