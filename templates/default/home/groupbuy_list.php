<link href="<?php echo TEMPLATES_PATH;?>/css/home_group.css" rel="stylesheet" type="text/css">
<script src="<?php echo RESOURCE_PATH; ?>/js/jquery.cookie.js" type="text/javascript"></script>
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
                 var days = Math.floor(tms[i] / (1* 60 * 60 * 24));
                 var hours = Math.floor(tms[i] / (1* 60 * 60)) % 24;
                 var minutes = Math.floor(tms[i] / (1* 60)) % 60;
                 var seconds = Math.floor(tms[i] / 1) % 60;
                 if (days < 0)
                     days = 0;
                 if (hours < 0)
                     hours = 0;
                 if (minutes < 0)
                     minutes = 0;
                 if (seconds < 0)
                     seconds = 0;
                 //将天、时、分、秒插入到html中
                 document.getElementById(day[i]).innerHTML = days;
                 document.getElementById(hour[i]).innerHTML = hours;
                 document.getElementById(minute[i]).innerHTML = minutes;
                 document.getElementById(second[i]).innerHTML = seconds;
             }
         }
         setTimeout("takeCount()", 1000);
</script>
<script language="JavaScript">
//鼠标触及更替li样式
$(document).ready(function(){
    $("#list").hide();
    $("#button_show").click(function(){
        $("#list").toggle();
    });
    $("#button_close").click(function(){
        $("#list").hide();
    });
    $('.group-list').children('ul').children('li').bind('mouseenter',function(){
        $('.group-list').children('ul').children('li').attr('class','c1');
        $(this).attr('class','c2');
    });
    $('.group-list').children('ul').children('li').bind('mouseleave',function(){
        $('.group-list').children('ul').children('li').attr('class','c1');
    });
    var area = $.cookie('<?php echo COOKIE_PRE;?>groupbuy_area');
   if(area == null) {
        $("#show_area_name").html("<?php echo $lang['text_country'];?>");
        $("#groupbuy_area").val('');
    }
   else {
        area_array = area.split(",");
        $("#show_area_name").html(area_array[1]);
        $("#groupbuy_area").val(area);
    }
});

//提交查询
function submit_search() {
        $('#search_form').attr('method','get');
        $('#search_form').submit();
}
//团购地区筛选
function set_groupbuy_area(area) {
    if(area == '') { 
        $("#groupbuy_area").val('');
        $.cookie('<?php echo COOKIE_PRE;?>groupbuy_area',null);
    }
    else {
        area_array = area.split(",");
        $("#groupbuy_area").val(area_array[0]);
        $.cookie('<?php echo COOKIE_PRE;?>groupbuy_area',area);
    }
    submit_search();
}
//团购分类筛选
function set_groupbuy_class(class_id) {
    $("#groupbuy_class").val(class_id);
    submit_search();
}
//团购价格筛选
function set_groupbuy_price(price_range) {
    $("#groupbuy_price").val(price_range);
    submit_search();
} 
//团购价格筛选
function set_groupbuy_order(order_key) {
    if(order_key == $("#groupbuy_order_key").val()) {
        change_groupbuy_order();
    }
    else {
        $("#groupbuy_order").val('asc');
    }
    $("#groupbuy_order_key").val(order_key);
    submit_search();
} 
//团购排序筛选
function change_groupbuy_order() {
    if($("#groupbuy_order").val() == 'asc') {
        $("#groupbuy_order").val('desc');
    }
    else {
        $("#groupbuy_order").val('asc');
    }
}
</script>

<div id="headRelative">
  <div class="title">
    <h1><?php echo $lang['text_groupbuy'];?></h1>
    <div class="city"> <a href="javascript:void(0)" id="button_show">
      <h2 id="show_area_name">&nbsp;</h2>
      </a> </div>
  </div>
  <div id="list" class="list" style="display:none;"><a id="button_close" class="close" href="javascript:void(0)" >x</a>
    <ul>
      <li><a href="javascript:void(0)" onClick="set_groupbuy_area('')" ><?php echo $lang['text_country'];?></a></li>
      <?php if(is_array($output['area_list'])) { ?>
      <?php foreach($output['area_list'] as $groupbuy_area) { ?>
      <?php if(intval($groupbuy_area['deep']) === 0) { ?>
      <li><a href="javascript:void(0)" onClick="set_groupbuy_area('<?php echo $groupbuy_area['area_id'].','.$groupbuy_area['area_name'];?>')" ><?php echo $groupbuy_area['area_name'];?></a></li>
      <?php } ?>
      <?php } ?>
      <?php } ?>
    </ul>
  </div>
</div>
<form id="search_form">
  <input name="act" type="hidden" value="show_groupbuy" />
  <input name="op" type="hidden" value="groupbuy_list" />
  <input id="groupbuy_area" name="groupbuy_area" type="hidden" value="<?php echo $_GET['groupbuy_area'];?>"/>
  <input id="groupbuy_class" name="groupbuy_class" type="hidden" value="<?php echo $_GET['groupbuy_class'];?>"/>
  <input id="groupbuy_price" name="groupbuy_price" type="hidden" value="<?php echo $_GET['groupbuy_price'];?>"/>
  <input id="groupbuy_order_key" name="groupbuy_order_key" type="hidden" value="<?php echo $_GET['groupbuy_order_key'];?>"/>
  <input id="groupbuy_order" name="groupbuy_order" type="hidden" value="<?php echo $_GET['groupbuy_order'];?>"/>
</form>
<div class="mb10 warp-all">
  <div class="group-nav">
    <h2><a href="index.php?act=show_groupbuy&op=groupbuy_list"><?php echo $lang['groupbuy_title'];?></a></h2>
    <?php if(is_array($output['groupbuy_template'])) { ?>
    <div class="info">
      <h4><?php echo $lang['text_di'];?><em><?php echo $output['groupbuy_template']['template_name'];?></em><?php echo $lang['text_qi'].$lang['text_groupbuy'];?>:</h4>
      <span class="time"><?php echo date('Y'.$lang['text_year'].'m'.$lang['text_month'].'d'.$lang['text_day'].' H:i',$output['groupbuy_template']['start_time']);?></span><span><?php echo $lang['text_to'];?></span><span class="time"><?php echo date('Y'.$lang['text_year'].'m'.$lang['text_month'].'d'.$lang['text_day'].' H:i',$output['groupbuy_template']['end_time']);?></span> </div>
    <?php } ?>
    <ul>
      <li><a href="index.php?act=show_groupbuy&op=groupbuy_soon" target="_blank"><?php echo $lang['groupbuy_soon'];?></a></li>
      <li><a href="index.php?act=show_groupbuy&op=groupbuy_history" target="_blank"><?php echo $lang['groupbuy_history'];?></a></li>
    </ul>
  </div>
  <?php if(is_array($output['groupbuy_template'])) { ?>
  <div class="group-screen">
    <div class="dc"> 
      <!-- 倒计时 距离本期结束 -->
      <h5><?php echo $lang['text_end_time'];?></h5>
      <p><span id="d1">0</span><strong><?php echo $lang['text_tian'];?></strong><span id="h1">0</span><strong><?php echo $lang['text_hour'];?></strong><span id="m1">0</span><strong><?php echo $lang['text_minute'];?></strong><span id="s1">0</span><strong><?php echo $lang['text_second'];?></strong></p>
      <script type="text/javascript">
                 tms[tms.length] = "<?php echo $output['count_down'];?>";
                 day[day.length] = "d1";
                 hour[hour.length] = "h1";
                 minute[minute.length] = "m1";
                 second[second.length] = "s1";
             </script> 
    </div>
    <!-- 分类过滤列表 -->
    <dl>
      <dt><?php echo $lang['text_class'];?>:</dt>
      <dd class="nobg <?php echo empty($_GET['groupbuy_class'])?'selected':''?>"><a href="javascript:void(0)" onClick="set_groupbuy_class('')"><?php echo $lang['text_no_limit'];?></a></dd>
      <?php if(is_array($output['class_list'])) { ?>
      <?php foreach($output['class_list'] as $groupbuy_class) { ?>
      <?php if(intval($groupbuy_class['deep']) === 0) { ?>
      <dd <?php echo $_GET['groupbuy_class'] == $groupbuy_class['class_id']?"class='selected'":'';?>> <a href="javascript:void(0)" onClick="set_groupbuy_class('<?php echo $groupbuy_class['class_id'];?>')"><?php echo $groupbuy_class['class_name'];?></a> </dd>
      <?php } ?>
      <?php } ?>
      <?php } ?>
    </dl>
    <!-- 价格过滤列表 -->
    <dl>
      <dt><?php echo $lang['text_price'];?>:</dt>
      <dd class="nobg <?php echo empty($_GET['groupbuy_price'])?'selected':''?>"><a href="javascript:void(0)" onClick="set_groupbuy_price('')" ><?php echo $lang['text_no_limit'];?></a></dd>
      <?php if(is_array($output['price_list'])) { ?>
      <?php foreach($output['price_list'] as $groupbuy_price) { ?>
      <dd <?php echo $_GET['groupbuy_price'] == $groupbuy_price['range_id']?"class='selected'":'';?>> <a href="javascript:void(0)" onClick="set_groupbuy_price('<?php echo $groupbuy_price['range_id'];?>')"><?php echo $groupbuy_price['range_name'];?></a> </dd>
      <?php } ?>
      <?php } ?>
    </dl>
    <!-- 排序 --> 
  </div>
  <ul class="group-sortord">
    <!--<?php echo $lang['text_order'];?>-->
    <li class="nobg <?php echo empty($_GET['groupbuy_order_key'])?'selected':''?>"><a href="JavaScript:void(0);" onClick="set_groupbuy_order('')"><?php echo $lang['text_default'];?></a></li>
    <li <?php echo $_GET['groupbuy_order_key'] == 'price'?"class='selected'":'';?>><a <?php echo $_GET['groupbuy_order_key'] == 'price'?"class='".$_GET['groupbuy_order']."'":'';?> href="javascript:void(0)" onClick="set_groupbuy_order('price')"><?php echo $lang['text_price'];?></a></li>
    <li <?php echo $_GET['groupbuy_order_key'] == 'rebate'?"class='selected'":'';?>><a <?php echo $_GET['groupbuy_order_key'] == 'rebate'?"class='".$_GET['groupbuy_order']."'":'';?> href="javascript:void(0)" onClick="set_groupbuy_order('rebate')"><?php echo $lang['text_rebate'];?></a></li>
    <li <?php echo $_GET['groupbuy_order_key'] == 'sale'?"class='selected'":'';?>><a <?php echo $_GET['groupbuy_order_key'] == 'sale'?"class='".$_GET['groupbuy_order']."'":'';?> href="javascript:void(0)" onClick="set_groupbuy_order('sale')"><?php echo $lang['text_sale'];?></a></li>
  </ul>
  <div class="clear"></div>
</div>
<?php if(is_array($output['groupbuy_list'])) { ?>
<!-- 团购活动列表 -->
<div class="mb10 warp-all group-list">
  <ul>
    <?php foreach($output['groupbuy_list'] as $groupbuy) { ?>
    <li class="c1">
      <div>
        <h2><a title="<?php echo $groupbuy['group_name'];?>" href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$groupbuy['group_id'],'id'=>$groupbuy['store_id']), 'groupbuy');?>" target="_blank"><?php echo $groupbuy['group_name'];?></a></h2>
        <div class="box">
          <div class="pic size296x216"><span class="thumb size296x216"><i></i><a title="<?php echo $groupbuy['group_name'];?>" href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$groupbuy['group_id'],'id'=>$groupbuy['store_id']), 'groupbuy');?>" target="_blank"><img src="<?php echo gthumb($groupbuy['group_pic'],'mid');?>" alt="" onload="javascript:DrawImage(this,296,216);"></a></span></div>
          <div class="intro"><span class="l"><?php echo $lang['text_goods_price'];?>:&nbsp;<?php echo $lang['currency'].$groupbuy['goods_price'];?></span><span class="r"><?php echo $lang['text_discount'];?>:&nbsp;<?php echo $groupbuy['rebate'];?>&nbsp;<?php echo $lang['text_zhe'];?></span></div>
          <div class="intro-bg"></div>
        </div>
        <?php if($groupbuy['state'] == '3') { ?>
        <div class="buy-now"> <span class="price"><?php echo $lang['currency'];?><?php echo $groupbuy['groupbuy_price'];?></span> <a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$groupbuy['group_id'],'id'=>$groupbuy['store_id']), 'groupbuy');?>" style="cursor:pointer" target="_blank"><span><?php echo $lang['groupbuy_buy'];?></span></a> </div>
        <?php } else { ?>
        <div class="closed"> <span class="price"><?php echo $lang['currency'];?><?php echo $groupbuy['groupbuy_price'];?></span> <a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$groupbuy['group_id'],'id'=>$groupbuy['store_id']), 'groupbuy');?>" style="cursor:pointer" target="_blank"><span><?php echo $lang['groupbuy_close'];?></span></a> </div>
        <?php } ?>
        <div class="info"><span class="l"><?php echo $lang['text_save'];?>:&nbsp;<?php echo $lang['currency'];?><?php echo sprintf("%01.2f",$groupbuy['goods_price']-$groupbuy['groupbuy_price']);?></span><span class="r"><?php echo $lang['text_buy'];?><em><strong><?php echo $groupbuy['def_quantity']+$groupbuy['virtual_quantity'];?></strong></em><?php echo $lang['text_piece'];?></span></div>
      </div>
    </li>
    <?php } ?>
  </ul>
  <?php } else { ?>
  <div class="content">
    <p class="no_info"><?php echo $lang['no_groupbuy_info'];?></p>
  </div>
  <?php } ?>
  <?php } else { ?>
  <div class="content">
    <p class="no_info"><?php echo $lang['no_groupbuy_template_in_progress'];?></p>
  </div>
  <?php } ?>
</div>
<?php if(is_array($output['groupbuy_template'])) { ?>
<?php if(is_array($output['groupbuy_list'])) { ?>
<div class="mb10 warp-all">
  <div class="pagination"> <?php echo $output['show_page'];?> </div>
</div>
<?php } ?>
<?php } ?>
