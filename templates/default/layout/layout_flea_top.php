<div id="page">
  <div id="topNav" class="warp-all">
    <?php if($_SESSION['is_login'] == '1'){?>
    <dl class="user-entry">
      <dt><?php echo $lang['nc_hello'];?><span><a href="<?php echo SiteUrl.'/';?>index.php?act=member_snsindex"><?php echo str_cut($_SESSION['member_name'],20);?></a></span>,<?php echo $lang['welcome_to_site'];?><span><?php echo $GLOBALS['setting_config']['flea_site_name']; ?></span></dt>
      <dd>[<a href="<?php echo SiteUrl.'/';?>index.php?act=login&op=logout"><?php echo $lang['nc_logout'];?></a>]</dd>
    </dl>
    <?php }else{?>
    <dl class="user-entry">
      <dt><?php echo $lang['nc_hello'];?>,<?php echo $lang['welcome_to_site'];?><span><?php echo $GLOBALS['setting_config']['flea_site_name']; ?></span></dt>
      <dd>[<a href="<?php echo SiteUrl.'/';?>index.php?act=login"><?php echo $lang['nc_login'];?></a>]</dd>
      <dd>[<a href="<?php echo SiteUrl.'/';?>index.php?act=login&op=register"><?php echo $lang['nc_register'];?></a>]</dd>
    </dl>
    <?php }?>
    <ul class="quick-menu">
      <li class="user-center">
        <div class="menu"><a class="menu-hd" href="<?php echo SiteUrl.'/';?>index.php?act=member_snsindex" target="_top" title="<?php echo $lang['nc_user_center'];?>" ><?php echo $lang['nc_user_center'];?><i></i></a>
          <div class="menu-bd">
            <ul>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=member&op=order" target="_top" title="<?php echo $lang['nc_buying_goods'];?>" ><?php echo $lang['nc_buying_goods'];?></a></li>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=member_snshome" target="_top" title="<?php echo $lang['nc_mysns'];?>"><?php echo $lang['nc_mysns'];?></a></li>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=member_snsfriend&op=find" target="_top" title="<?php echo $lang['nc_myfriends'];?>" ><?php echo $lang['nc_myfriends'];?></a></li>
            </ul>
          </div>
        </div>
      </li>
      <li class="seller-center">
        <div class="menu"><a class="menu-hd" href="<?php echo SiteUrl.'/';?>index.php?act=store" target="_top" title="<?php echo $lang['nc_seller'];?>" ><?php echo $lang['nc_seller'];?><i></i></a>
          <div class="menu-bd">
            <ul>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=store&op=store_order" target="_top" title="<?php echo $lang['nc_selled_goods'];?>" ><?php echo $lang['nc_selled_goods'];?></a></li>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=store_goods&op=goods_list" target="_top" title="<?php echo $lang['nc_selling_goods'];?>" ><?php echo $lang['nc_selling_goods'];?></a></li>
              <?php if($_SESSION['store_id'] > 0){?>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=show_store&id=<?php echo $_SESSION['store_id'];?>" target="_top" title="<?php echo $lang['nc_mystroe'];?>" ><?php echo $lang['nc_mystroe'];?></a></li>
              <?php }?>
            </ul>
          </div>
        </div>
      </li>
      <li class="cart">
        <div class="menu" ><span class="menu-hd"><s></s><?php echo $lang['nc_cart'];?><strong class="goods_num"><?php echo intval($output['goods_num']); ?></strong><?php echo $lang['nc_kindof_goods'];?><i></i></span>
          <div class="menu-bd" id="top_cartlist"></div>
        </div>
      </li>
      <!-- �ղؼ� -->
      <li class="favorite">
        <div class="menu"><a class="menu-hd" href="<?php echo SiteUrl.'/';?>index.php?act=member_favorites&op=fglist" title="<?php echo $lang['nc_favorites'];?>" target="_top" ><?php echo $lang['nc_favorites'];?><i></i></a>
          <div class="menu-bd">
            <ul>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=member_favorites&op=fglist" target="_top" title="<?php echo $lang['nc_favorites_goods'];?>" ><?php echo $lang['nc_favorites_goods'];?></a></li>
              <li><a href="<?php echo SiteUrl.'/';?>index.php?act=member_favorites&op=fslist" target="_top" title="<?php echo $lang['nc_favorites_stroe'];?>" ><?php echo $lang['nc_favorites_stroe'];?></a></li>
            </ul>
          </div>
        </div>
      </li>
      <!-- վ���� -->
      <li class="pm"><a href="<?php echo SiteUrl.'/';?>index.php?act=home&op=message" title="<?php echo $lang['nc_message'];?>" target="_top" > <?php echo $lang['nc_message'];?>
        <?php if ($output['message_num']>0) echo "(<span style=\"color: #FE5400;\">".$output['message_num']."</span>)" ?>
        </a></li>
      <?php 
      if(!empty($output['nav_list']) && is_array($output['nav_list'])){
	      foreach($output['nav_list'] as $nav){
	      if($nav['nav_location']<1){
	      	$output['nav_list_top'][] = $nav;
	      }
	      }
      }
      if(!empty($output['nav_list_top']) && is_array($output['nav_list_top'])){
      	?>
      <li class="links" >
        <div class="menu"><a class="menu-hd" href="<?php echo SiteUrl;?>" target="_top" title="<?php echo $lang['nc_more_links'];?>" ><?php echo $lang['nc_more_links'];?><b></b></a>
          <div class="menu-bd">
            <ul>
              <?php foreach($output['nav_list_top'] as $nav){?>
              <?php ?>
              <li><a <?php if($nav['nav_new_open']){?>target="_blank" <?php }?>href="<?php echo SiteUrl.'/';?><?php switch($nav['nav_type']){
    	case '0':echo $nav['nav_url'];break;
    	case '1':echo ncUrl(array('act'=>'search','nav_id'=>$nav['nav_id'],'cate_id'=>$nav['item_id']));break;
    	case '2':echo ncUrl(array('act'=>'article','nav_id'=>$nav['nav_id'],'ac_id'=>$nav['item_id']));break;
    	case '3':echo ncUrl(array('act'=>'activity','activity_id'=>$nav['item_id'],'nav_id'=>$nav['nav_id']), 'activity');break;
    }?>" title="<?php echo $nav['nav_title'];?>"><?php echo $nav['nav_title'];?></a></li>
              <?php }?>
            </ul>
          </div>
        </div>
      </li>
      <?php }?>
    </ul>
  </div>
</div>