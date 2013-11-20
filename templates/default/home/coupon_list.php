<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('home/cur_local');?>
<script type="text/javascript" src="<?php echo RESOURCE_PATH.'/js/jquery.accordion.js';?>" charset="utf-8"></script>
<Script type="text/javascript" >
$(function () {
		$('ol.hot_consumes').accordion({
			header: 'h3.hot_consume-handle',
            selectedClass: 'open',
            event: 'mouseover'
        });
    });
</Script>

<div class="content">
  <div class="left">
    <div class="module_sidebar">
      <h2><b><?php echo $lang['coupon_index_hot_coupon'];?></b></h2>
      <?php if(!empty($output['hot'])){?>
      <ol class="hot_consumes">
        <?php foreach($output['hot'] as $key => $val){?>
        <li class="hot_consume">
          <h3 class="hot_consume-handle <?php if($key==0){?>open<?php }?>"><?php echo str_cut($val['coupon_title'],20); ?></h3>
          <div class="hot_consume_intro">
            <div class="picture"><a target="_blank" href="<?php echo ncUrl(array('act'=>'coupon_store','op'=>'detail','coupon_id'=>$val['coupon_id'],'id'=>$val['store_id']), 'coupon_info'); ?>" title="<?php echo $val['coupon_desc']; ?>" class="thumb size184"><i></i><img src="<?php if($val['coupon_pic'] == ''){ echo SiteUrl.DS.ATTACH_COUPON.DS.'default.gif';}else if(stripos( $val['coupon_pic'] , 'http://') === false ){echo SiteUrl.'/'.$val['coupon_pic'];}else{echo $val['coupon_pic'];}?>" alt="<?php echo $val['coupon_title']; ?>" onerror="this.src='<?php echo TEMPLATES_PATH."/images/default_coupon_image.png"?>'" onload="javascript:DrawImage(this,184,114);"/></a></div>
            <p class="mt5"><a href="<?php echo ncUrl(array('act'=>'coupon_store','op'=>'detail','coupon_id'=>$val['coupon_id'],'id'=>$val['store_id']), 'coupon_info'); ?>"><?php echo str_cut($val['coupon_title'],20); ?></a></p>
            <p class="xi1"><?php echo date('Y-m-d',$val['coupon_start_date']); ?> <?php echo $lang['coupon_index_to'];?> <?php echo date('Y-m-d',$val['coupon_end_date']); ?></p>
          </div>
        </li>
        <?php }?>
      </ol>
      <?php }?>
      <div id="starStore" style="clear: both; padding-top:24px;">
        <h2><b><?php echo $lang['coupon_index_recommend_store'];?></b></h2>
        <?php if(!empty($output['recommend'])){?>
        <?php foreach($output['recommend'] as $key=>$val){?>
        <div class="store" style="padding-bottom: 12px;">
          <div class="picture"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']);?>"><span class="thumb size72"><i></i><img src="<?php echo $val['store_logo']; ?>" onload="javascript:DrawImage(this,72,72);"></span></a></div>
          <dl>
            <dt><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$val['store_id']),'store',$val['store_domain']);?>" title="<?php echo $val['store_name']; ?>"><?php echo str_cut($val['store_name'], 20); ?></a></dt>
            <dd><?php echo $lang['coupon_index_store_owner'];?><?php echo $val['member_name']; ?></dd>
            <dd><?php echo $lang['coupon_index_goods'];?><?php echo $val['goods_count']; ?></dd>
            <dd>
              <?php if (empty($val['credit_arr'])){ echo  $lang['coupon_index_credit'].$val['store_credit']; }else {?>
              <span class="seller-<?php echo $val['credit_arr']['grade']; ?> level-<?php echo $val['credit_arr']['songrade']; ?>"></span>
              <?php }?>
            </dd>
          </dl>
        </div>
        <?php }?>
        <?php }?>
      </div>
    </div>
  </div>
  <div class="right">
    <div class="consume_filter">
      <div class="consume_filter_line"> <span class="filter_stat"><?php echo $lang['coupon_index_result'];?> <strong><?php echo $output['num']?></strong> <?php echo $lang['coupon_index_num'];?></span>
        <div class="clear"></div>
        <dl>
          <dt><?php echo $lang['coupon_index_choose_class'];?></dt>
          <dd>
            <?php if(!empty($output['class'])){?>
            <ul>
              <?php foreach($output['class'] as $val){?>
              <li><a href="index.php?act=coupon&catid=<?php echo $val['class_id']; ?>&coupon_keyword=<?php echo $output['coupon_keyword']; ?>" ><?php echo $val['class_name']?> (<?php echo $val['num']?>)</a></li>
              <?php }?>
            </ul>
            <?php }?>
          </dd>
          <div class="clear"></div>
        </dl>
        <div class="contain_list" nc_type="dropdown_filter_content" ecvalue="brand" style="display:none">
          <ul nc_type="ul_brand">
            <li><a href="javascript:void(0);" title="" id="">&nbsp;</a></li>
          </ul>
        </div>
        <div class="contain_list" nc_type="dropdown_filter_content" ecvalue="price" style="display:none">
          <ul nc_type="ul_price">
            <li><?php echo $output['price'];?></li>
          </ul>
        </div>
        <div class="contain_list" nc_type="dropdown_filter_content" ecvalue="region" style="display:none">
          <ul nc_type="ul_region">
            <li><a href="javascript:void(0);" id="<?php echo $area['area_id'];?>" title="<?php echo $area['area_info'].' ('.$area['goods_count'].')';?>"><?php echo $area['area_info'];?> (<?php echo $area['goods_count'];?>)</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="consume_con">
      <div class="shop_con_list">
        <div class="box">
          <div class="title"><?php echo $lang['coupon_index_coupon_list'];?></div>
          <form id="form_search_goods" method="get" action="index.php?act=coupon">
            <div class="sidebox" style=" background-image: none; float:right;">
              <div class="selectbox">
                <input type="hidden" name="act" value="coupon" />
                <input class="text" type="text" name="coupon_keyword" id="coupon_keyword" value="<?php echo $output['coupon_keyword']?>" style=" width: 160px;" />
                <button type="submit" class="btn"><?php echo $lang['coupon_index_search'];?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="consume_list" >
      <?php if(!empty($output['list'])){?>
      <ul>
        <?php foreach($output['list'] as $key => $val){?>
        <li>
          <div class="pics">
            <div class="v_ineffect"><?php echo $lang['coupon_index_valid'];?></div>
            <div class="thumb"> <a href="<?php echo ncUrl(array('act'=>'coupon_store','op'=>'detail','coupon_id'=>$val['coupon_id'],'id'=>$val['store_id']), 'coupon_info'); ?>" target="_blank"><img src="<?php if( $val['coupon_pic'] == ''){echo SiteUrl.DS.ATTACH_COUPON.DS.'default.gif';}else if(stripos($val['coupon_pic'], 'http://') === false){ echo SiteUrl.'/'.$val['coupon_pic'];}else{ echo $val['coupon_pic'];}?>" alt="<?php echo $val['coupon_desc']; ?>" onload="javascript:DrawImage(this,210,128);"  border="0" onerror="this.src='<?php echo TEMPLATES_PATH."/images/default_coupon_image.png"?>'" /></a> </div>
          </div>
          <p class="mt5"><a href="<?php echo ncUrl(array('act'=>'coupon_store','op'=>'detail','coupon_id'=>$val['coupon_id'],'id'=>$val['store_id']), 'coupon_info'); ?>" title="<?php echo $val['coupon_desc']; ?>" target="_blank"><?php echo str_cut($val['coupon_title'], 20); ?></a></p>
          <p class="xi1"><?php echo $lang['coupon_index_period'];?> <?php echo date('Y-m-d',$val['coupon_start_date']); ?> <?php echo $lang['coupon_index_to'];?> <?php echo date('Y-m-d',$val['coupon_end_date']); ?></p>
        </li>
        <?php }?>
      </ul>
      <?php }?>
      <div class="clear"></div>
    </div>
  </div>
  <div class="clear"></div>
  <?php if(!empty($output['list'])){?>
  <div class="pagination"> <?php echo $output['show_page'];?> </div>
  <?php }?>
</div>
