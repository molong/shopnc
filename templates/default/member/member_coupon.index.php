<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" nc_type="dialog" dialog_title="<?php echo $lang['store_coupon_add'];?>" dialog_id="coupon_add" dialog_width="480" uri="index.php?act=store&op=store_coupon&type=add" title="<?php echo $lang['store_coupon_add'];?>"> <?php echo $lang['store_coupon_add'];?></a></div>
  <form method="get" action="index.php" target="_self">
    <table class="search-form">
      <input type="hidden" name="act" value="store" />
      <input type="hidden" name="op" value="store_coupon" />
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['store_coupon_name'].$lang['nc_colon'];?></th>
        <td class="w150"><input type="text" class="text" id="in" name="key" value="" /></td>
        <th><?php echo $lang['store_coupon_period'];?></th>
        <td class="w180"><input type="text" class="text" name="add_time_from" id="add_time_from_index" value="<?php echo $_GET['add_time_from']; ?>" readonly="readonly" />
          &#8211;
          <input type="text" class="text" name="add_time_to" id="add_time_to_index" value="<?php echo $_GET['add_time_to']; ?>" readonly="readonly" /></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr><th class="w10"></th>
        <th class="w120"><?php echo $lang['store_coupon_pic'];?></th>
        <th class="tl"><?php echo $lang['store_coupon_name'];?></th>
        <th class="w60"><?php echo $lang['store_coupon_price'];?></th>
        <th class="w180"><?php echo $lang['store_coupon_lifetime'];?></th>
        <th class="w60"><?php echo $lang['store_coupon_state'];?></th>
        <th class="w80"><?php echo $lang['store_coupon_allow'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($output['coupons']) && !empty($output['coupons'])){?>
      <?php foreach($output['coupons'] as $k=>$coupon){?>
      <tr class="bd-line">
      <td></td>
        <td><span href="<?php echo $coupon['pic']; ?>" title="<?php echo $coupon['coupon_title']; ?>"> <img src="<?php echo $coupon['pic']; ?>" onerror="this.src='<?php echo TEMPLATES_PATH;?>/images/default_coupon_image.png'" onload="javascript:DrawImage(this,100,60);" /> </span></td>
        <td class="tl"><a href="index.php?act=coupon_store&op=detail&coupon_id=<?php echo $coupon['coupon_id']; ?>&id=<?php echo $coupon['store_id'];?>" target="_blank"><?php echo $coupon['coupon_title']; ?></a></td>
        <td class="goods-price"><?php echo $coupon['coupon_price']; ?></td>
        <td class="goods-time"><?php echo date('Y-m-d',$coupon['coupon_start_date']); ?>~<?php echo date('Y-m-d',$coupon['coupon_end_date']); ?></td>
        <td><?php echo $coupon['state']; ?></td>
        <td><?php echo $coupon['allowstate']; ?></td>
        <td><p><a href='javascript:void(0)' onclick="opendialog(<?php echo $coupon['coupon_id']; ?>)"><?php echo $lang['store_coupon_edit'];?></a></p>
          <?php if ($coupon['coupon_allowstate'] != 1){?>
          <p><a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store&op=store_coupon&coupon_id=<?php echo $coupon['coupon_id']; ?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p>
          <?php }?></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    </tbody>
    <?php }?>
    <tfoot>
      <?php if($output['count']){?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php }?>
    </tfoot>
  </table>
</div>
<div title="<?php echo $lang['nc_edit'];?>"><b class="edit" nc_type="dialog" dialog_title="<?php echo $lang['nc_edit'];?>" dialog_id="coupon_edit" dialog_width="480" uri="index.php?act=store&op=store_coupon&type=edit"></b></div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.imagePreview.1.0.js"></script> 
<script>
$(function(){
	$("span.preview").preview();
	$('#add_time_from_index').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to_index').datepicker({dateFormat: 'yy-mm-dd'});
    $("#in").focus(function(){
    	   if($("#in").val()=='<?php echo $lang['store_coupon_name'];?>'){
    	   $("#in").val("")};
    	  }).blur(function(){
    	   if($("#in").val()==''){
    	   $("#in").val("<?php echo $lang['store_coupon_name'];?>").css("color","#ccc")};
    });
    
});
</script> 
<script>
		function opendialog(id){
			var coupon_id = id;
			var url = 'index.php?act=store&op=store_coupon&type=edit&coupon_id='+coupon_id ;			
			$('.edit').attr('uri',url) ;
			$('.edit').click() ;
		}
		var id = '' ;
		 function show(cid){
				id = cid;
				$('#'+id).show() ;
				setTimeout("hide("+id+")",3000) ;

		 }
		 function hide(id){
				$('#'+id).hide() ;
		
		 }
//缩放图片到合适大小
function ResizeImages()
{
   var myimg,oldwidth,oldheight;
   var maxwidth=60;
   var maxheight=20;
   var imgs = $('.preview img');

   for(i=0;i<imgs.length;i++){
     myimg = imgs[i];

     if(myimg.width > myimg.height)
     {
         if(myimg.width > maxwidth)
         {
            oldwidth = myimg.width;
            myimg.height = myimg.height * (maxwidth/oldwidth);
            myimg.width = maxwidth;
         }
     }else{
         if(myimg.height > maxheight)
         {
            oldheight = myimg.height;
            myimg.width = myimg.width * (maxheight/oldheight);
            myimg.height = maxheight;
         }
     }
   }
}
//缩放图片到合适大小
ResizeImages();
</script> 
