<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('store/header');?>
<div class="background clearfix">
  <?php include template('store/top');?>
  <article id="content">
    <section class="layout" >
      <article class="nc-goods-main">
        <div class="nc-s-c-s3 mt15">
          <div class="title">
            <h4><?php echo $lang['nc_store_info'];?></h4>
          </div>
          <div class="content pt10 pb20">
            <div class="default" style="float:none; margin: auto;" ><?php echo $output['store_info']['description'];?></div>
            <div class="clear mb50"></div>
            <div class="ncu-intro">
              <div class="top"></div>
              <div class="content clearfix">
                <h2 class="ncu-name"><?php echo $output['store_info']['member_name'];?></h2>
                <dl class="ncu-shop-info">
                  <dt><span class="thumb size80"><i></i><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']),'store',$output['store_info']['store_domain']);?>"><img src="<?php echo $output['store_info']['store_logo'];?>"  onload="javascript:DrawImage(this,80,80);" title="<?php echo $output['store_info']['store_name']; ?>" alt="<?php echo $output['store_info']['store_name']; ?>" /></a></span></dt>
                  <dd class="base">
                    <p><?php echo $lang['show_store_index_store_name'];?><?php echo $output['store_info']['store_name'];?></p>
                    <!-- 店铺名称 -->
                    <p><?php echo $lang['show_store_index_store_grade'];?><?php echo $output['store_info']['grade_name'];?></p>
                    <!-- 店铺等级 -->
                    <p><span class="fl"><?php echo $lang['nc_identify'];?></span> <!-- 认证信息 -->
                      <?php if($output['store_info']['name_auth']){?>
                      <span id="certAutonym" class="text-hidden fl" title="<?php echo $lang['nc_name_identify'];?>"><?php echo $lang['nc_name_identify'];?></span>
                      <?php }?>
                      <?php if($output['store_info']['store_auth']){?>
                      <span id="certMaterial" class="text-hidden fl ml5" title="<?php echo $lang['nc_store_identify'];?>"><?php echo $lang['nc_store_identify'];?></span>
                      <?php }?>
                    </p>
                    </ul>
                  </dd>
                  <dd class="qrcode"> <!-- 二维码 -->
                    <div>
                      <p><img src="<?php echo SiteUrl.DS.ATTACH_STORE.DS.$output['store_info']['store_code']?>" onerror="this.src='<?php echo SiteUrl.DS.ATTACH_STORE.DS.'default_qrcode.png';?>'" onload="javascript:DrawImage(this,90,90);"></p>
                      <p><?php echo $lang['show_store_index_store_qrcode_collect'];?></p>
                    </div>
                  </dd>
                </dl>
                <dl class="nus-basic-info">
                  <dt><?php echo $lang['show_store_index_essential_information'];?></dt>
                  <!-- 基本信息 -->
                  <dd><span style=" float:left;"><?php echo $lang['nc_credit_degree'];?></span>
                    <?php if (empty($output['store_info']['credit_arr'])){ echo $output['store_info']['store_credit']; }else {?>
                    <span style=" float:left; margin-top:8px;" class="seller-<?php echo $output['store_info']['credit_arr']['grade']; ?> level-<?php echo $output['store_info']['credit_arr']['songrade']; ?>"></span>
                    <?php }?>
                  </dd>
                  <dd><span style=" float:left;"><?php echo $lang['nc_credit_buyer_credit'];?></span>
                    <?php if (empty($output['member_info']['credit_arr'])){echo $output['member_info']['member_credit']; }else {?>
                    <span style=" float:left; margin-top:8px;" class="buyer-<?php echo $output['member_info']['credit_arr']['grade']; ?> level-<?php echo $output['member_info']['credit_arr']['songrade']; ?>"></span>
                    <?php }?>
                  </dd>
                  <!-- <dd>商品信息：出售中的商品</dd> -->
                  <dd><?php echo $lang['show_store_index_register_time'];?><?php echo @date("Y-m-d",$output['member_info']['member_time']);?></dd>
                  <dd><?php echo $lang['nc_store_addtime'];?><?php echo @date("Y-m-d",$output['store_info']['store_time']);?></dd>
                  <dd><?php echo $lang['show_store_index_last_login_time']?><?php echo @date("Y-m-d",$output['member_info']['member_old_login_time']);?></dd>
                </dl>
                <dl class="nus-contact">
                  <dt><?php echo $lang['nc_contact_way'];?></dt>
                  <!-- 联系方式 -->
                  <dd><?php echo $lang['nc_srore_location'];?><?php echo $output['store_info']['area_info'];?></dd>
                  <dd><?php echo $lang['nc_whole_address'];?><?php echo $output['store_info']['store_address'];?></dd>
                  <dd><?php echo $lang['nc_phone'];?><?php echo $output['store_info']['store_tel'];?></dd>
                  <dd><?php echo $lang['shoe_store_index_email'];?><?php echo $output['member_info']['member_email'];?></dd>
                  <?php if($output['store_info']['store_qq'] != ''){?>
                  <dd><?php echo $lang['shoe_store_index_qq'];?><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $output['store_info']['store_qq'];?>&amp;Site=<?php echo $output['store_info']['store_qq'];?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>:47" alt="<?php echo $lang['nc_message_me'];?>"></a></dd>
                  <?php }?>
                  <?php if($output['store_info']['store_ww'] != ''){?>
                  <dd><?php echo $lang['shoe_store_index_wangwang'];?><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&amp;uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=1&charset=<?php echo CHARSET;?>" alt="<?php echo $lang['nc_message_me'];?>"/></a></dd>
                  <?php }?>
                </dl>
              </div>
            </div>
            <div class="module_special ncs-map" id="container" style=" width:750px;height:600px; margin: 0 auto 30px auto;" ><?php echo $lang['nc_map_loading'];?></div>
          </div>
        </div>
      </article>
    </section>
    <div class="clear"></div>
  </article>
</div>
<?php include template('footer');?>
<script type="text/javascript">
var cityName = "<?php echo $output['store_info']['city'];?>";
var address = "<?php echo $output['store_info']['store_address'];?>";
var store_name = "<?php echo $output['store_info']['store_name'];?>"; 
var map = "";
var localCity = "";
var opts = {width : 150,height: 50,title : "<?php echo $lang['member_map_store_name'];?>:"+store_name}
function initialize() {
	map = new BMap.Map("container");
	localCity = new BMap.LocalCity();
	
	map.enableScrollWheelZoom(); 
	map.addControl(new BMap.NavigationControl());  
	map.addControl(new BMap.ScaleControl());  
	map.addControl(new BMap.OverviewMapControl()); 
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
	    var infoWindow = new BMap.InfoWindow("<?php echo $lang['member_map_address'];?>:"+address, opts);  
			marker.addEventListener("click", function(){          
			   this.openInfoWindow(infoWindow);  
			});
	    map.addOverlay(marker);
			marker.openInfoWindow(infoWindow);
	  }
}
loadScript();
</script>
</body>
</html>
