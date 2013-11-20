<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo RESOURCE_PATH;?>/js/jcarousel/skins/tango/skin.css" rel="stylesheet" type="text/css">
<style type="text/css">
.jcarousel-skin-tango { background-color: #F4F9FD; border: solid 1px #AED2FF;}
.jcarousel-skin-tango a { background-color: #FFF; width: 120px; height: 120px; display: inline-block; border: solid 1px #C4D5E0; }
.jcarousel-skin-tango .jcarousel-clip-horizontal { width: 660px !important; height: 130px !important;}
.jcarousel-skin-tango .jcarousel-item { height: 130px !important;}
.jcarousel-skin-tango .jcarousel-container-horizontal { width: 660px !important;}
</style>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w30"></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['favorite_store_name'];?></th>
        <th class="w120"><?php echo $lang['favorite_store_new_goods'];?></th>
        <th class="w150"><?php echo $lang['favorite_popularity'];?></th>
        <th class="w90"><?php echo $lang['favorite_popularity'];?></th>
        <th class="w90"><?php echo $lang['favorite_handle'];?></th>
      </tr>
      <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
      <tr>
        <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="20"><label for="all"><span class="all"><?php echo $lang['nc_select_all'];?></span></label>
          <a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=member_favorites&op=delfavorites&type=store" name="fav_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <?php }?>
    </thead>
    <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
    <tbody>
      <?php foreach($output['favorites_list'] as $key=>$favorites){?>
      <tr class="bd-line">
        <td class="tc"><input type="checkbox" class="checkitem" value="<?php echo $favorites['fav_id'];?>"/></td>
        <td><div class="goods-pic-small"> <span class="thumb size60"> <i></i><a href="index.php?act=show_store&id=<?php echo $favorites['store']['store_id'];?>" target="_blank"><img src="<?php echo $favorites['store']['store_logo'];?>" onload="javascript:DrawImage(this,60,60);"/></a></span></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a href="index.php?act=show_store&id=<?php echo $favorites['store']['store_id'];?>" target="_blank"><?php echo $favorites['store']['store_name'];?></a>
            	<p><?php echo $favorites['store']['area_info'];?></p>
            	</dt>
            <dd><?php echo $favorites['store']['member_name'];?><a target="_blank" href="index.php?act=home&op=sendmsg&member_id=<?php echo $favorites['store']['member_id'];?>" class="email" title="<?php echo $lang['nc_message'];?>"></a></dd>
          </dl></td>
        <td><a href="javascript:get_store_goods('<?php echo $favorites['store']['store_id'];?>','<?php echo $favorites['store']['goods_count'];?>');" class="favorites-new-goods"><?php echo $lang['favorite_new_goods'];?>(<?php echo $favorites['store']['goods_count'];?>)<i id="store-arrow-<?php echo $favorites['store']['store_id'];?>" class="arrow-down">&nbsp;</i></a></td>
        <td class="goods-time"><?php echo date("Y-m-d",$favorites['fav_time']);?></td>
        <td><?php echo $favorites['store']['store_collect'];?></td>
        <td><p><a href="javascript:void(0);" nc_type="sharestore" data-param='{"sid":"<?php echo $favorites['store']['store_id'];?>"}'><?php echo $lang['nc_snsshare'];?></a></p>
          <a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=member_favorites&op=delfavorites&type=store&fav_id=<?php echo $favorites['fav_id'];?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></td>
      </tr>
      
      <tr id="store-goods-<?php echo $favorites['store']['store_id'];?>" class="shop-new-goods" style="display:none;">
        <td colspan="20" style=" padding-top: 0;" ><div class="fr pr"><div class="arrow"></div>
            <ul class="jcarousel-skin-tango"></ul>
          </div></td>
      </tr>
      
      <?php }?>
    </tbody>
    <?php }else{?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    </tbody>
    <?php }?>
    <?php if(!empty($output['favorites_list']) && is_array($output['favorites_list'])){?>
    <tfoot>
      <tr>
        <td class="tc"><input type="checkbox" id="all2" class="checkall"/></td>
        <td colspan="7"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" uri="index.php?act=member_favorites&op=delfavorites&type=store" name="fav_id" confirm="<?php echo $lang['nc_ensure_del'];?>" nc_type="batchbutton"><span><?php echo $lang['nc_del'];?></span></a>
          <div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php }?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/sns.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jcarousel/jquery.jcarousel.min.js"></script> 
<script type="text/javascript">
function get_store_goods(store_id,goods_count){
	if(goods_count < 1) return ;
	var store=$("#store-goods-"+store_id);
	var store_arrow=$("#store-arrow-"+store_id);
	var store_display=store.css("display");
	var store_goods=store.find("ul").html();
	if(store_goods == '') {
		store.find("ul").html('<li><img src="<?php echo TEMPLATES_PATH;?>/images/loading.gif" alt="loading..." ></li>');
		store.show();
		store_arrow.attr("class","arrow-up");
		var ajaxurl = 'index.php?act=member_favorites&op=store_goods&store_id='+store_id;
		var store_goods = $.ajax({url: ajaxurl,async: false}).responseText;
		store.find("ul").html(store_goods);
		store.find("ul").jcarousel({visible: 5});//图片轮换
	}else{
		if(store_display == 'none') {
			store_arrow.attr("class","arrow-up");
			store.show();
		}else{
			store_arrow.attr("class","arrow-down");
			store.hide();
		}
	}
}
</script>
