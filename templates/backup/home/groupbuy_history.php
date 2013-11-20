<link href="<?php echo TEMPLATES_PATH;?>/css/home_group.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
//鼠标触及更替li样式
	$(document).ready(function(){
		$('.group-history-list').children('ul').children('li').bind('mouseenter',function(){
			$('.group-history-list').children('ul').children('li').attr('class','c1');
			$(this).attr('class','c2');
		});
		$('.group-history-list').children('ul').children('li').bind('mouseleave',function(){
			$('.group-history-list').children('ul').children('li').attr('class','c1');
		});
})</script>

<div class="mb10 warp-all">
  <div class="group-nav">
    <ul class="menu">
      <li><a href="index.php?act=show_groupbuy&op=groupbuy_list"><?php echo $lang['groupbuy_title'];?></a></li>
      <li><a href="index.php?act=show_groupbuy&op=groupbuy_soon"><?php echo $lang['groupbuy_soon'];?></a></li>
      <li class="select"><a href="javascript:void(0)"><?php echo $lang['groupbuy_history'];?></a></li>
    </ul>
  </div>
  <div class="clear"></div>
</div>
<div class="mb10 warp-all content">
  <?php if(is_array($output['groupbuy_template'])) { ?>
  <!-- 历史团购 -->
  <div class="left2">
    <?php foreach($output['groupbuy_template'] as $template) { ?>
    <div class="group-history-list">
      <div class="title">
        <h2><?php echo $lang['text_di'];?><em><?php echo $template['template_name'];?></em><?php echo $lang['text_qi'].$lang['text_groupbuy'];?></h2>
        <span class="time"><?php echo date('Y'.$lang['text_year'].'m'.$lang['text_month'].'d'.$lang['text_day'].' H:i',$template['start_time']);?></span><span><?php echo $lang['text_to'];?></span><span class="time"><?php echo date('Y'.$lang['text_year'].'m'.$lang['text_month'].'d'.$lang['text_day'].' H:i',$template['end_time']);?></span></div>
      <ul>
        <?php if(is_array($output['groupbuy_list'])) { ?>
        <?php foreach($output['groupbuy_list'] as $groupbuy) { ?>
        <?php if($groupbuy['template_id'] == $template['template_id']) { ?>
        <li class="c1">
          <div class="box">
            <div class="name"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$groupbuy['group_id'],'id'=>$groupbuy['store_id']), 'groupbuy');?>" target="_blank"><?php echo $groupbuy['group_name'];?></a></div>
            <div class="mask"></div>
            <div class="pic"><span class="thumb size120x88"><i></i><img src="<?php echo ATTACH_GROUPBUY.'/'.$groupbuy['group_pic'];?>" alt="" onload="javascript:DrawImage(this,120,88);"></span></div>
          </div>
          <div class="price"><?php echo $lang['currency'];?><?php echo $groupbuy['groupbuy_price'];?></div>
          <div class="info"><?php echo $lang['text_buy'];?><?php echo $hot_groupbuy['def_quantity']+$hot_groupbuy['virtual_quantity'];?><?php echo $lang['text_piece'];?></div>
        </li>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>
    <?php if(is_array($output['groupbuy_template'])) { ?>
    <div class="pagination"> <?php echo $output['show_page'];?> </div>
    <?php } ?>
  </div>
  <!-- 往期热销 -->
  <div class="right2 group-top10">
    <div class="module_sidebar">
      <h2 style=" font-size: 14px; color: #C00;"><?php echo $lang['history_hot'];?></h2>
      <ol>
        <?php if(is_array($output['hot_groupbuy_list'])) { ?>
        <?php $i=1;?>
        <?php foreach($output['hot_groupbuy_list'] as $hot_groupbuy) { ?>
        <li>
          <div class="box">
            <div class="num"><?php echo sprintf("%02d",$i);$i++;?></div>
            <div class="pic"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$hot_groupbuy['group_id'],'id'=>$hot_groupbuy['store_id']), 'groupbuy');?>" target="_blank"><img src="<?php echo ATTACH_GROUPBUY.'/'.$hot_groupbuy['group_pic'];?>" alt="" onload="javascript:DrawImage(this,123,90);"></a></div>
          </div>
          <dl>
            <dt class="name"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$hot_groupbuy['group_id'],'id'=>$hot_groupbuy['store_id']), 'groupbuy');?>" target="_blank"><?php echo $hot_groupbuy['group_name'];?></a></dt>
            <dd class="price"><?php echo $lang['currency'];?><?php echo $hot_groupbuy['groupbuy_price'];?></dd>
            <dd class="info"><?php echo $lang['text_buy'];?><?php echo $hot_groupbuy['def_quantity']+$hot_groupbuy['virtual_quantity'];?><?php echo $lang['text_piece'];?></dd>
            <dd class="time"></dd>
          </dl>
        </li>
        <?php } ?>
        <?php } ?>
      </ol>
    </div>
    <?php } else { ?>
    <div class="content">
      <p class="no_info"><?php echo $lang['no_groupbuy_template_history'];?></p>
    </div>
    <?php } ?>
  </div>
</div>
<div class="clear"></div>
