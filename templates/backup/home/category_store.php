<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('home/cur_local');?>

<div class="content">
  <div class="left">
    <div class="module_sidebar">
      <h2><b><?php echo $lang['category_index_recommend_store'];?></b></h2>
      <div class="wrap">
        <ul class="particular">
          <?php if(!empty($output['recommend_store']) && is_array($output['recommend_store'])){?>
          <?php foreach($output['recommend_store'] as $key=>$store){?>
          <li>
            <div style="float:left;width=65px;"><i></i><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$store['store_id']),'store',$store['store_domain']);?>" target="_blank"><img src="<?php echo $store['store_logo'];?>"  onload="javascript:DrawImage(this,64,64);"/></a></div>
            <dl>
              <dt><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$store['store_id']),'store',$store['store_domain']);?>" target="_blank"><?php echo $store['store_name'];?></a></dt>
              <dd><?php echo $lang['category_index_store_owner'];?>: <?php echo $store['store_name'];?></dd>
              <dd><?php echo $lang['category_index_goods'];?>: <?php echo $store['goods_count'];?></dd>
              <dd><?php echo $lang['category_index_credit'];?>: <?php echo $store['store_credit'];?></dd>
            </dl>
          </li>
          <?php }?>
          <?php }?>
        </ul>
      </div>
      <h2><b><?php echo $lang['category_index_new_store'];?></b></h2>
      <div class="wrap">
        <ul class="particular">
          <?php if(!empty($output['new_store']) && is_array($output['new_store'])){?>
          <?php foreach($output['new_store'] as $key=>$store){?>
          <li>
            <div style="float:left;width=65px;"><i></i><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$store['store_id']),'store',$store['store_domain']);?>" target="_blank"><img src="<?php echo $store['store_logo'];?>"  onload="javascript:DrawImage(this,64,64);" /></a></div>
            <dl>
              <dt><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$store['store_id']),'store',$store['store_domain']);?>" target="_blank"><?php echo $store['store_name'];?></a></dt>
              <dd><?php echo $lang['category_index_store_owner'];?>: <?php echo $store['store_name'];?></dd>
              <dd><?php echo $lang['category_index_goods'];?>: <?php echo $store['goods_count'];?></dd>
              <dd><?php echo $lang['category_index_credit'];?>: <?php echo $store['store_credit'];?></dd>
            </dl>
          </li>
          <?php }?>
          <?php }?>
        </ul>
      </div>
    </div>
  </div>
  <div class="right">
    <div class="module_sidebar">
      <h2><b><?php echo $lang['category_index_store_list'];?></b></h2>
      <div class="wrap">
        <div class="recommend">
          <dl class="shop_assort">
            <?php if(!empty($output['sc_list']) && is_array($output['sc_list'])){?>
            <?php foreach($output['sc_list'] as $key=>$sc_list){?>
            <dt class="bg_color1"><a href="index.php?act=shop_search&cate_id=<?php echo $sc_list['sc_id'];?>"><?php echo $sc_list['sc_name'];?></a></dt>
            <dd>
              <?php if(!empty($sc_list['child']) && is_array($sc_list['child'])){?>
              <?php foreach($sc_list['child'] as $key=>$child){?>
              <?php if($sc_list['sc_id'] != $child['sc_id']){?>
              <a href="index.php?act=shop_search&cate_id=<?php echo $child['sc_id'];?>"><?php echo $child['sc_name'];?></a>
              <?php }?>
              <?php }?>
            </dd>
            <?php }?>
            <?php }?>
            <?php }?>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>
