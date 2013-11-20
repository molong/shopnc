<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('store/header');?>
<div class="background clearfix">
  <?php include template('store/top');?>
  <article id="content">
    <section class="layout expanded mt10" >
      <article class="nc-goods-main">
        <div class="nc-s-c-s3 ncg-list">
          <div class="title pngFix">
            <h4>
              <?php if(!empty($_GET['stc_id'])){echo $output['stc_name'];}elseif(!empty($_GET['keyword'])){echo $lang['show_store_index_include'].$_GET['keyword'].$lang['show_store_index_goods'];}else{ echo $lang['nc_whole_goods']; }?>
            </h4>
          </div>
          <form id="search_form" method='get' name="search_form">
            <input name="act" type="hidden" value="show_store" />
            <input name="op" type="hidden" value="goods_all" />
            <input name="id" type="hidden" value="<?php echo $_GET['id'];?>" />
            <?php if($_GET['keyword'] != ''){?>
            <input name="keyword" type="hidden" value="<?php echo $_GET['keyword'];?>" />
            <?php }?>
            <?php if($_GET['stc_id'] != ''){?>
            <input name="stc_id" type="hidden" value="<?php echo $_GET['stc_id'];?>" />
            <?php }?>
            <input name="key" type="hidden" value="<?php echo $_GET['key'];?>" />
            <input name="order" type="hidden" value="<?php echo $_GET['order'];?>" />
          <div class="ncs-goodslist-bar">
          <ul class="ncs-array">
            <li class='<?php echo $_GET['key'] == 'new'?'selected':'';?>'><a class='<?php echo $_GET['key'] == 'new'?$_GET['order']:'';?>' href="javascript:void(0)" onClick="set_form('new')"><?php echo $lang['show_store_all_new'];?></a></li>
            <li class='<?php echo $_GET['key'] == 'price'?'selected':'';?>'><a class='<?php echo $_GET['key'] == 'price'?$_GET['order']:'';?>' href="javascript:void(0)" onClick="set_form('price')"><?php echo $lang['show_store_all_price'];?></a></li>
            <li class='<?php echo $_GET['key'] == 'sale'?'selected':'';?>'><a class='<?php echo $_GET['key'] == 'sale'?$_GET['order']:'';?>' href="javascript:void(0)" onClick="set_form('sale')"><?php echo $lang['show_store_all_sale'];?></a></li>
            <li class='<?php echo $_GET['key'] == 'collect'?'selected':'';?>'><a class='<?php echo $_GET['key'] == 'collect'?$_GET['order']:'';?>' href="javascript:void(0)" onClick="set_form('collect')"><?php echo $lang['show_store_all_collect'];?></a></li>
            <li class='<?php echo $_GET['key'] == 'click'?'selected':'';?>'><a class='<?php echo $_GET['key'] == 'click'?$_GET['order']:'';?>' href="javascript:void(0)" onClick="set_form('click')"><?php echo $lang['show_store_all_click'];?></a></li>
          </ul>
            <div class="price-search">
              <em><?php echo $lang['currency'];?></em>&nbsp;<input type="text" class="w30" name="start_price" value="<?php echo $_GET['start_price'];?>"><i>-</i><input type="text" class="w30" name="end_price" value="<?php echo $_GET['end_price'];?>"><a href="javascript:document.search_form.submit();" ><?php echo $lang['nc_search'];?></a>
            </div></div>
          </form>
          <div class="content">
            <?php if(!empty($output['recommended_goods_list']) && is_array($output['recommended_goods_list'])){?>
            <ul>
              <?php foreach($output['recommended_goods_list'] as $value){?>
              <li>
                <dl>
                  <dt><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$value['goods_id']), 'goods');?>" target="_blank"><?php echo $value['goods_name']?></a></dt>
                  <dd class="ncg-pic pngFix"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$value['goods_id']), 'goods');?>" target="_blank" class="thumb size160"><i></i><img src="<?php echo thumb($value,'small');?>" onload="javascript:DrawImage(this,160,160);" title="<?php echo $value['goods_name'];?>" alt="<?php echo $value['goods_name'];?>" /></a></dd>
                  <dd class="ncg-price"><em class="price"><?php echo $lang['currency'];?>
                      <?php if(intval($value['group_flag']) === 1) { ?>
                      <?php echo $value['group_price']?>
                      <?php } elseif(intval($value['xianshi_flag']) === 1) { ?>
                      <?php echo ncPriceFormat($value['goods_store_price'] * $value['xianshi_discount'] / 10);?>
                      <?php } else { ?>
                      <?php echo $value['goods_store_price']?>
                      <?php } ?>
                  </em></dd>
                  <dd class="ncg-sold"><?php echo $lang['nc_sell_out'];?><strong><?php echo $value['salenum'];?></strong> <?php echo $lang['nc_jian'];?></dd>
                </dl>
              </li>
              <?php }?>
            </ul>
            
            <div class="pagination"><?php echo $output['show_page']; ?></div>
            <?php }else{?>
            <div class="nothing">
              <p><?php echo $lang['show_store_index_no_record'];?></p>
            </div>
            <?php }?>
            <div class="clear"></div>
          </div>
        </div>
      </article>
      <aside class="nc-sidebar">
        <?php include template('store/info');?>
        <?php include template('store/left');?>
      </aside>
    </section>
    <div class="clear"></div>
  </article>
</div>
<?php include template('footer');?>
<script type="text/javascript">
function set_form(set){
	if($('input[name="key"]').val() == set){
		if($('input[name="order"]').val() == 'asc'){
			$('input[name="order"]').val('desc');
		}else{
			$('input[name="order"]').val('asc');
		}
	}else{
		$('input[name="order"]').val('desc');
	}
	$('input[name="key"]').val(set);
	$('#search_form').submit();
}
</script>
</body>
</html>
