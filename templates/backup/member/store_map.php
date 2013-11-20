<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <div id="container" style="height:600px;border:1px solid gray"><?php echo $lang['member_map_loading'];?></div>
    <form id="post_form" method="post" action="index.php?act=map">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="map_id" value="<?php echo $output['map']['map_id']; ?>" />
      <input type="hidden" name="point_lng" id="point_lng" value="<?php echo $output['map']['point_lng']; ?>" />
      <input type="hidden" name="point_lat" id="point_lat" value="<?php echo $output['map']['point_lat']; ?>" />
      <dl>
        <dd><?php echo $lang['member_map_address'].$lang['nc_colon'];?><?php echo $output['address'];?>
          <input type="submit" class="ml30 submit" value="<?php echo $lang['member_map_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
function setValue(point){
	document.getElementById("point_lng").value = point.lng;
	document.getElementById("point_lat").value = point.lat;
}
window.onload = loadScript;
var cityName = "<?php echo $output['city'];?>";
var address = "<?php echo $output['address'];?>";
var store_name = "<?php echo $output['store_name'];?>"; 
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
	    setValue(cityResult.center);  
	    map.addEventListener("click", function(e){
	    	setPoint(e.point);
	    	setValue(e.point);
			});
	    cityResultName = cityResult.name;
	    if (cityResultName.indexOf(cityName) >= 0) cityName = cityResult.name;
	    <?php if ($output['map']['point_lng'] > 0) {  ?>
	    	var store_point = new BMap.Point(<?php echo $output['map']['point_lng']; ?>, <?php echo $output['map']['point_lat']; ?>);
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
	    map.clearOverlays();
	    var marker = new BMap.Marker(point);
	    marker.enableDragging(true); 
	    var infoWindow = new BMap.InfoWindow("<?php echo $lang['member_map_address'];?>:"+address, opts);  
			marker.addEventListener("click", function(){          
			   this.openInfoWindow(infoWindow);  
			});
	    marker.addEventListener("dragend", function(e){  
			 setValue(e.point);  
			});  
	    map.addOverlay(marker);
			marker.openInfoWindow(infoWindow);
	  }
}
</script> 
