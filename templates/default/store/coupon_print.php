<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
	<title><?php echo $output['html_title'];?></title>
	<meta name="author" content="ShopNC">
	<meta name="copyright" content="ShopNC Inc. All Rights Reserved">
	<link href="<?php echo TEMPLATES_PATH;?>/css/base.css" rel="stylesheet" type="text/css">
	<link href="<?php echo TEMPLATES_PATH;?>/css/shop.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common.js" charset="utf-8"></script>
	<script >
    $(function(){
        $('.print').click(function(){
        	window.print();
       });
     })	
	</script>
	</head>

	<body>
    <div id="print_view">
      <div class="info">
        <p><?php echo $lang['store_coupon_choose_print'];?><?php echo $output['num']; ?> <?php echo $lang['store_coupon_print_notice'];?></p>
        <a class="print" title="<?php echo $lang['store_coupon_print_coupon'];?>" href="javascript:void(0)" ><?php echo $lang['store_coupon_print_coupon'];?></a> </div>
      <div id="print_box">
        <div id="divToPrint">
          <?php for($i=0;$i<intval($output['num']);$i++){?>
          <div class="ticket">
            <p><span class="thumb"><i></i><img onerror="this.src='<?php echo TEMPLATES_PATH;?>/images/default_coupon_image.png'" src="<?php echo $output['pic']?>" onload="javascript:DrawImage(this,294,180);"/></span></p>
            <span class="ncs-print-cat"></span> </div>
          <?php }?>
        </div>
      </div>
    </div>
</body>
</html>