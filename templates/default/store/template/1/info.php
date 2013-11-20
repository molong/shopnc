<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--店铺基本信息 S-->

<div class="ncs-info clearfix">
  <div class="shop-card">
    <h4><?php echo $output['store_info']['store_name']; ?></h4>
    <dl>
      <dt><span class="thumb size60"><i></i><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']),'store',$output['store_info']['store_domain']);?>"><img src="<?php echo $output['store_info']['store_logo'];?>"  onload="javascript:DrawImage(this,60,60);" title="<?php echo $output['store_info']['store_name']; ?>" alt="<?php echo $output['store_info']['store_name']; ?>" /></a></span></dt>
      <dd><a href="<?php echo ncUrl(array('act'=>'show_store','op'=>'credit','id'=>$output['store_info']['store_id']))?>" class="shopkeeper"><?php echo $output['store_info']['member_name'];?></a> <a href="index.php?act=home&op=sendmsg&member_id=<?php echo $output['store_info']['member_id'];?>" class="message text-hidden" title="<?php echo $lang['nc_send_message'];?>"><?php echo $lang['nc_send_message'];?></a></dd>
      <dd class="ncs-level">
        <?php if (empty($output['store_info']['credit_arr'])){ echo $lang['nc_credit_degree'].$output['store_info']['store_credit']; }else {?>
        <span class="seller-<?php echo $output['store_info']['credit_arr']['grade']; ?> level-<?php echo $output['store_info']['credit_arr']['songrade']; ?>"></span>
        <?php }?>
      </dd>
      <dd ><span><?php echo $lang['nc_good_rate'];?></span><?php echo $output['store_info']['praise_rate'];?>%</dd>
    </dl>
  </div>
  <div class="shop-rate">
    <h4><?php echo $lang['nc_dynamic_evaluation'];?></h4>
    <!-- 动态评价 -->
    <dl class="rate">
      <dt><?php echo $lang['nc_description_of'];?></dt>
      <dd class="rate-star"><em><i style=" width: <?php echo $output['store_info']['store_desccredit_rate'];?>%;"></i></em><span><?php echo $output['store_info']['store_desccredit'];?><?php echo $lang['nc_grade'];?></span></dd>
      <dt><?php echo $lang['nc_service_attitude'];?></dt>
      <dd class="rate-star"><em><i style=" width: <?php echo $output['store_info']['store_servicecredit_rate'];?>%;"></i></em><span><?php echo $output['store_info']['store_servicecredit'];?><?php echo $lang['nc_grade'];?></span></dd>
      <dt><?php echo $lang['nc_delivery_speed'];?></dt>
      <dd class="rate-star"><em><i style=" width: <?php echo $output['store_info']['store_deliverycredit_rate'];?>%;"></i></em><span><?php echo $output['store_info']['store_deliverycredit'];?><?php echo $lang['nc_grade'];?></span></dd>
    </dl>
  </div>
  <div class="shop-detail">
    <h4><?php echo $lang['nc_store_information'];?></h4>
    <!-- 店铺信息 -->
    <dl>
      <dt><?php echo $lang['nc_store_addtime'];?></dt>
      <dd><?php echo @date("Y-m-d",$output['store_info']['store_time']);?></dd>
      <dt><?php echo $lang['nc_srore_location'];?></dt>
      <dd><?php echo $output['store_info']['area_info'];?></dd>
      <dt><?php echo $lang['nc_goods_amount'];?></dt>
      <dd><strong><?php echo $output['store_info']['goods_count'];?></strong><?php echo $lang['nc_jian'];?><?php echo $lang['nc_goods'];?></dd>
      <dt><?php echo $lang['nc_store_collect'];?></dt>
      <dd><strong nctype="store_collect"><?php echo $output['store_info']['store_collect']?></strong><?php echo $lang['nc_person'];?><?php echo $lang['nc_collect'];?></dd>
      <?php if($output['store_info']['store_auth'] || $output['store_info']['name_auth']){?>
      <dt><?php echo $lang['nc_identify'];?></dt>
      <dd>
        <?php if($output['store_info']['name_auth']){?>
        <span id="certAutonym" class="text-hidden fl" title="<?php echo $lang['nc_name_identify'];?>"><?php echo $lang['nc_name_identify'];?></span>
        <?php }?>
        <?php if($output['store_info']['store_auth']){?>
        <span id="certMaterial" class="text-hidden fl ml5" title="<?php echo $lang['nc_store_identify'];?>"><?php echo $lang['nc_store_identify'];?></span>
        <?php }?>
      </dd>
      <?php }?>
      <!--详细地址 <?php if(!empty($output['store_info']['store_address'])){?>
      <dt><?php echo $lang['nc_whole_address'];?></dt>
      <dd><?php echo $output['store_info']['store_address'];?></dd>
      <?php }?>--> 
      <!--联系电话 <?php if(!empty($output['store_info']['store_tel'])){?>
      <dt><?php echo $lang['nc_phone'];?></dt>
      <dd><?php echo $output['store_info']['store_tel'];?></dd>
      <?php }?>-->
    </dl>
  </div>
  <div class="shop-im">
    <h4><?php echo $lang['nc_contact_way'];?></h4>
    <p>
      <?php if(!empty($output['store_info']['store_qq'])){?>
      <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $output['store_info']['store_qq'];?>&amp;Site=<?php echo $output['store_info']['store_qq'];?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>:47" alt="<?php echo $lang['nc_message_me'];?>"></a>
      <?php }?>
      <?php if(!empty($output['store_info']['store_ww'])){?>
      <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>"/></a>
      <?php }?>
    </p>
  </div>
  <div class="shop-other" id="shop-other">
    <ul>
      <li class="ncs-info-btn-map"><a href="javascript:void(0)" class="pngFix"><span><?php echo $lang['nc_store_map'];?></span><b></b> <!-- 店铺地图 -->
        <div class="ncs-info-map" id="map_container" style="width:188px;height:320px;"><?php echo $lang['nc_map_loading'];?> </div>
        </a></li>
      <li class="ncs-info-btn-qrcode"><a href="javascript:void(0)" class="pngFix"><span><?php echo $lang['nc_store_qrcode'];?></span><b></b> <!-- 店铺二维码 -->
        <p class="ncs-info-qrcode"><img src="<?php echo SiteUrl.DS.ATTACH_STORE.DS.$output['store_info']['store_code']?>" onerror="this.src='<?php echo SiteUrl.DS.ATTACH_STORE.DS.'default_qrcode.png';?>'" title="<?php echo $lang['nc_store_address'];?><?php if(C('enabled_subdomain')==1 && $output['store_info']['store_domain'] != ''){ echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store', $output['store_info']['store_domain']);}else{ echo SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store', $output['store_info']['store_domain']);}?>" onload="javascript:DrawImage(this,150,150);"><em><?php echo $lang['nc_qrcode_desc'];?></em> </p>
        </a> </li>
    </ul>
  </div>
</div>
<div class="clear"></div>
<!--店铺基本信息 E--> 
<script type="text/javascript">
var cityName = "<?php echo $output['store_info']['city'];?>";
var address = "<?php echo $output['store_info']['store_address'];?>";
var store_name = "<?php echo $output['store_info']['store_name'];?>"; 
var map = "";
var localCity = "";
function initialize() {
	map = new BMap.Map("map_container");
	localCity = new BMap.LocalCity();
	
	map.enableScrollWheelZoom(); 
	localCity.get(function(cityResult){
	  if (cityResult) {
	  	var level = cityResult.level;
	  	if (level < 13) level = 13;
	    map.centerAndZoom(cityResult.center, level);
	    cityResultName = cityResult.name;
	    if (cityResultName.indexOf(cityName) >= 0) cityName = cityResult.name;
	    <?php if ($output['store_info']['map']['point_lng'] > 0) {  ?>
	    	var store_point = new BMap.Point(<?php echo $output['store_info']['map']['point_lng']; ?>, <?php echo $output['store_info']['map']['point_lat']; ?>);
	    	setPoint(store_point);
	    <?php }else{ ?>
	    	getPoint();
	    <?php } ?>
	  }
	});
}
 
function loadScript() {
	var script = document.createElement("script");
	script.src = "http://api.map.baidu.com/api?v=1.2&callback=initialize";
	document.body.appendChild(script);
}
function getPoint(){
	var myGeo = new BMap.Geocoder();
	myGeo.getPoint(address, function(point){
	  if (point) {
	    setPoint(point);
	  }
	}, cityName);
}
function setPoint(point){
	  if (point) {
	    map.centerAndZoom(point, 16);
	    var marker = new BMap.Marker(point);
	    map.addOverlay(marker);
	  }
}

// 当鼠标放在店铺地图上再加载百度地图。
$(function(){
	$('.ncs-info-btn-map').one('mouseover',function(){
		loadScript();
	});
});
</script> 
