<link href="<?php echo TEMPLATES_PATH;?>/css/home_group.css" rel="stylesheet" type="text/css">
<div class="mb10 warp-all">
  <div class="group-nav">
    <ul class="menu">
      <li><a href="index.php?act=show_groupbuy&op=groupbuy_list"><?php echo $lang['groupbuy_title'];?></a></li>
      <li class="select"><a href="javascript:void(0)"><?php echo $lang['groupbuy_soon'];?></a></li>
      <li><a href="index.php?act=show_groupbuy&op=groupbuy_history"><?php echo $lang['groupbuy_history'];?></a></li>
    </ul>
    <div class="clear"></div>
  </div>
  <div class="mb10 warp-all group-soon-list">
    <?php if(!empty($output['groupbuy_template'])) { ?>
    <h2 class="info"><?php echo $lang['text_di'];?><em><?php echo $output['groupbuy_template']['template_name'];?></em><?php echo $lang['text_qi'].$lang['text_groupbuy'];?><?php echo $lang['text_jiangyu'];?><span><?php echo date('Y'.$lang['text_year'].'m'.$lang['text_month'].'d'.$lang['text_day'].' H:i',$output['groupbuy_template']['start_time']);?></span><?php echo $lang['text_start'];?></h2>
    <?php if(is_array($output['groupbuy_list'])) { ?>
    <ul>
      <?php foreach($output['groupbuy_list'] as $groupbuy) { ?>
      <li>
        <div class="pic"><span class="thumb"><i></i><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$groupbuy['group_id'],'id'=>$groupbuy['store_id']), 'groupbuy');?>" target="_blank"><img src="<?php echo ATTACH_GROUPBUY.'/'.$groupbuy['group_pic'];?>" alt="" onload="javascript:DrawImage(this,168,123);"></a></span></div>
        <div class="name"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$groupbuy['group_id'],'id'=>$groupbuy['store_id']), 'groupbuy');?>" target="_blank"><?php echo $groupbuy['group_name'];?></a></div>
        <div class="price"><em><?php echo $lang['currency'];?><?php echo $groupbuy['groupbuy_price'];?></em><span><?php echo $lang['currency'];?><?php echo $groupbuy['goods_price'];?></span></div>
        <div class="btns"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$groupbuy['goods_id']), 'goods')?>" target="_blank"><span><?php echo $lang['see_goods'];?></span></a><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$groupbuy['store_id']), 'store');?>" target="_blank"><span><?php echo $lang['see_store'];?></span></a></div>
      </li>
      <?php } ?>
      <div class="clear"></div>
    </ul>
    <?php } ?>
    <?php } else {?>
    <div class="content">
      <p class="no_info"><?php echo $lang['no_groupbuy_template_soon'];?></p>
    </div>
    <?php } ?>
  </div>
</div>
