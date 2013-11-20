<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('home/cur_local');?>

<div class="content">
  <div class="commodity_assort">
    <div class="module_sidebar">
      <h2><b title="<?php echo $lang['category_index_goods_class'];?>"><?php echo $lang['category_index_goods_class'];?></b></h2>
      <div class="wrap">
        <div class="recommend">
          <dl class="shop_assort">
            <?php if(!empty($output['gc_list']) && is_array($output['gc_list'])){?>
            <?php foreach($output['gc_list'] as $key=>$gc_list){?>
            <?php if ($gc_list['gc_parent_id'] != '0') break;?>
            <dt class="bg_color1"><a href="index.php?act=search&cate_id=<?php echo $gc_list['gc_id'];?>"><?php echo $gc_list['gc_name'];?></a></dt>
            <dd style=" width:944px;">
              <?php if($gc_list['childchild'] != ''){?>
              <?php foreach(explode(',',$gc_list['childchild']) as $key=>$child){?>
              <a href="index.php?act=search&cate_id=<?php echo $child;?>"><?php echo $output['gc_list'][$child]['gc_name'];?></a>
              <?php }?>
              <?php }?>
            </dd>
            <?php }?>
            <?php }?>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>
