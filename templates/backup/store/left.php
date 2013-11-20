<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="nc-s-c-s1 ncs-search-bar mt10">
  <div class="title">
    <h4><?php echo $lang['nc_search_in_store'];?></h4>
  </div>
  <div class="content">
    <form id="" name="searchShop" method="get" action="index.php">
      <input type="hidden" name="act" value="show_store" />
      <input type="hidden" name="op" value="goods_all" />
      <input type="hidden" name="id" value="<?php echo $output['store_info']['store_id'];?>" />
      <table class="ncs-search">
        <tr>
          <th><?php echo $lang['nc_keyword'];?></th>
          <td><input type="text" class="w90" name="keyword"></td>
        </tr>
        <tr>
          <th><?php echo $lang['nc_price'];?></th>
          <td><input type="text" class="w30" name="start_price">
            -
            <input type="text" class="w30" name="end_price"></td>
        </tr>
        <tr>
          <th>&nbsp;</th>
          <td><a href="javascript:document.searchShop.submit();" ><?php echo $lang['nc_search'];?></a></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<div class="nc-s-c-s1 ncs-class-bar mt10">
  <div class="title">
    <h4><?php echo $lang['nc_goods_class'];?></h4>
  </div>
  <div class="content">
    <p><span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&key=new&order=desc"><?php echo $lang['nc_by_new'];?></a></span><span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&key=price&order=desc"><?php echo $lang['nc_by_price'];?></a></span><span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&key=sale&order=desc"><?php echo $lang['nc_by_sale'];?></a></span><span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&key=click&order=desc"><?php echo $lang['nc_by_click'];?></a></span></p>
    <ul class="ncs-submenu">
      <li><span class="ico-none"><em>-</em></span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>"><?php echo $lang['nc_whole_goods'];?></a></li>
      <?php if(!empty($output['goods_class_list']) && is_array($output['goods_class_list'])){?>
      <?php foreach($output['goods_class_list'] as $value){?>
      <?php if(!empty($value['children']) && is_array($value['children'])){?>
      <li><span class="ico-none" onclick="class_list(this);" span_id="<?php echo $value['stc_id'];?>" style="cursor: pointer;"><em>-</em></span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&stc_id=<?php echo $value['stc_id'];?>"><?php echo $value['stc_name'];?></a>
        <ul id="stc_<?php echo $value['stc_id'];?>">
          <?php foreach($value['children'] as $value1){?>
          <li><span class="ico-sub">&nbsp;</span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&stc_id=<?php echo $value1['stc_id'];?>"><?php echo $value1['stc_name'];?></a></li>
          <?php }?>
        </ul>
      </li>
      <?php }else {?>
      <li> <span class="ico-none"><em>-</em></span><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&stc_id=<?php echo $value['stc_id'];?>"><?php echo $value['stc_name'];?></a></li>
      <?php }?>
      <?php }?>
      <?php }?>
    </ul>
    <div class="clear mb10"></div>
  </div>
</div>
<div class="nc-s-c-s1 ncs-top-bar mt10">
  <div class="title">
    <h4><?php echo $lang['nc_goods_rankings'];?></h4>
  </div>
  <div class="content">
    <ul class="ncs-top-tab pngFix">
      <li class="current"><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&key=sale&order=desc"><?php echo $lang['nc_hot_goods_rankings'];?></a></li>
      <li><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>&key=collect&order=desc"><?php echo $lang['nc_hot_collect_rankings'];?></a></li>
    </ul>
    <div class="ncs-top-panel">
      <?php if(is_array($output['hot_sales']) && !empty($output['hot_sales'])){?>
      <ol>
        <?php foreach($output['hot_sales'] as $val){?>
        <li>
          <dl>
            <dt><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods');?>"><?php echo $val['goods_name']?></a></dt>
            <dd class="goods-pic"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods');?>"><span class="thumb size40"><i></i><img src="<?php echo thumb($val,'tiny');?>"  onload="javascript:DrawImage(this,40,40);"></span></a>
              <p><span class="thumb size100"><i></i><img src="<?php echo thumb($val,'small');?>" onload="javascript:DrawImage(this,100,100);" title="<?php echo $val['goods_name']?>"><big></big><small></small></span></p>
            </dd>
            <dd class="price pngFix"><?php echo $val['goods_store_price']?></dd>
            <dd class="selled pngFix"><?php echo $lang['nc_sell_out'];?><strong><?php echo $val['salenum'];?></strong><?php echo $lang['nc_bi'];?></dd>
          </dl>
        </li>
        <?php }?>
      </ol>
      <?php }?>
    </div>
    <div class="ncs-top-panel hide">
      <?php if(is_array($output['hot_collect']) && !empty($output['hot_collect'])){?>
      <ol>
        <?php foreach($output['hot_collect'] as $val){?>
        <li>
          <dl>
            <dt><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods');?>"><?php echo $val['goods_name']?></a></dt>
            <dd class="goods-pic"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['goods_id']), 'goods');?>" title=""><span class="thumb size40"><i></i> <img src="<?php echo thumb($val,'tiny');?>" onload="javascript:DrawImage(this,40,40);"></span></a>
              <p><span class="thumb size100"><i></i><img src="<?php echo thumb($val,'small');?>" onload="javascript:DrawImage(this,100,100);" title="<?php echo $val['goods_name']?>"><big></big><small></small></span></p>
            </dd>
            <dd class="price pngFix"><?php echo $val['goods_store_price']?></dd>
            <dd class="collection pngFix"><?php echo $lang['nc_collection_popularity'];?><strong><?php echo $val['goods_collect'];?></strong></dd>
          </dl>
        </li>
        <?php }?>
      </ol>
      <?php }?>
    </div>
    <p><a href="index.php?act=show_store&op=goods_all&id=<?php echo $_GET['id'];?>"><?php echo $lang['nc_look_more_store_goods'];?></a></p>
  </div>
</div>
<?php if($output['page'] == 'index'){?>
<div class="nc-s-c-s1 ncs-link-bar mt10">
  <div class="title">
    <h4><?php echo $lang['nc_blogroll'];?></h4>
  </div>
  <div class="content">
    <ul>
      <?php if(!empty($output['store_partner_list']) && is_array($output['store_partner_list'])){?>
      <?php foreach($output['store_partner_list'] as $value){ if($value['sp_logo'] != ''){?>
      <li class="pngFix"><a href="<?php echo $value['sp_link'];?>" target="_blank" title="<?php echo $value['sp_title']; ?>" ><img src="<?php echo $value['sp_logo']; ?>" onerror="this.src='<?php echo TEMPLATES_PATH."/images/member/default.gif"?>'" onload="javascript:DrawImage(this,150,50);" alt="<?php echo $value['sp_title']; ?>" /></a></li>
      <?php }}?>
      <?php foreach($output['store_partner_list'] as $value){ if($value['sp_logo'] == ''){?>
      <li class="pngFix"><a href="<?php echo $value['sp_link'];?>" title="<?php echo $value['sp_title']; ?>"  target="_blank" ><?php echo $value['sp_title']; ?></a></li>
      <?php }}?>
      <?php }?>
    </ul>
  </div>
</div>
<?php }?>
