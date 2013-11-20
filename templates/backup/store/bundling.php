<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('store/header');?>
<link href="<?php echo TEMPLATES_PATH;?>/css/home_login.css" rel="stylesheet" type="text/css">
<div class="background clearfix">
  <?php include template('store/top');?>
  <article id="content">
    <section class="layout expanded mt10" >
      <form id="bundling_form" method="post" action="index.php?act=buynow&op=bundling">
        <input name="bundling_id" type="hidden" value="<?php echo $output['bundling_info']['bl_id'];?>" />
        <input name="bl_price" type="hidden" value="<?php echo $output['bundling_info']['bl_discount_price'];?>" />
        <article class="nc-bundling-main"> 
          <!-- S套餐信息 -->
          <div class="nc-bundling-box"> 
            <!-- S图片 -->
            <div class="nc-bundling-gallery">
              <div class="zoom-section"> 
                <!-- S 默认图片触及显示放大镜效果 -->
                <div class="zoom-small-image"><span class="thumb size310"><a href="<?php echo cthumb($output['bundling_info']['bl_img_more'][0],'max',$output['store_info']['store_id']);?>" class = "nc-zoom" id="zoom1" rel="position: 'inside' , showTitle: false"><img src="<?php echo cthumb($output['bundling_info']['bl_img_more'][0],'mid',$output['store_info']['store_id']);?>" alt="" title=""></a></span></div>
                <!-- S 默认图片触及显示放大镜效果 --> 
                <!-- S 关联默认图片的缩略图 -->
                <nav class="zoom-desc">
                  <ul>
                    <?php if(is_array($output['bundling_info']['bl_img_more']) && !empty($output['bundling_info']['bl_img_more'])){?>
                    <?php foreach($output['bundling_info']['bl_img_more'] as $key=>$val){?>
                    <!-- S 第一个后其它的有图片时显示 -->
                    <li><a href="<?php echo cthumb($val,'max',$output['store_info']['store_id']);?>" class="nc-zoom-gallery <?php if($key=='0'){?>hovered<?php }?>" title="" rel="useZoom: 'zoom1', smallImage: '<?php echo cthumb($val,'mid',$output['store_info']['store_id']);?>' "> <span class="thumb size40"> <i></i> <img src="<?php echo cthumb($val,'tiny',$output['store_info']['store_id']);?>" alt="" onload="javascript:DrawImage(this,40,40);"> </span><b></b> </a></li>
                    <?php }?>
                    <?php }?>
                  </ul>
                </nav>
                <!-- E 关联默认图片的缩略图 --> 
              </div>
            </div>
            <!-- E图片 --> 
            <!-- S基本信息 -->
            <div class="nc-bundling-intro">
              <h3><?php echo $output['bundling_info']['bl_name'];?></h3>
              <dl>
                <dt><?php echo $lang['bundling_cost_price'].$lang['nc_colon'];?></dt>
                <dd><span class="basic-price"><?php echo $output['bundling_info']['bl_cost_price'];?></span><?php echo $lang['currency_zh'];?></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['bundling_price'].$lang['nc_colon'];?></dt>
                <dd><span class="sale-name"><?php echo $lang['bundling_bundling']?></span><span class="sale-price"><?php echo $output['bundling_info']['bl_discount_price'];?></span><?php echo $lang['currency_zh'];?></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['bundling_saving'].$lang['nc_colon'];?></dt>
                <dd><span class="sale="><?php echo ncPriceFormat(intval($output['bundling_info']['bl_cost_price'])-intval($output['bundling_info']['bl_discount_price']));?></span><?php echo $lang['currency_zh'];?></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['bundling_freight'].$lang['nc_colon'];?></dt>
                <dd><?php if($output['bundling_info']['bl_freight_choose'] == '1'){ echo $lang['bundling_freight_free'];}else{ echo $output['bundling_info']['bl_freight'].$lang['currency_zh'];}?></dd>
              </dl>
            </div>
            <!-- E基本信息 --> 
          </div>
          <!-- E套餐信息 --> 
        <!--S 满就送 -->
              <?php if($output['mansong_flag']) { ?>
        <section class="nc-promotion mt10">
    <div class="nc-mansong">
      <div class="nc-mansong-container">
        <div class="nc-mansong-ico"></div>
        <dl class="nc-mansong-content">
          <dt>
            <h3><?php echo $output['mansong_info']['mansong_name'];?></h3>
            <time>( <?php echo $lang['nc_promotion_time'];?><?php echo $lang['nc_colon'];?><?php echo date('Y/m/d',$output['mansong_info']['start_time']).'--'.date('Y/m/d',$output['mansong_info']['end_time']);?> )</time>
          </dt>
          <dd>
            <ul class="nc-mansong-rule">
              <?php foreach($output['mansong_rule'] as $rule) { ?>
              <li><?php echo $lang['nc_man'];?><em><?php echo ncPriceFormat($rule['price']);?></em><?php echo $lang['nc_yuan'];?>
                <?php if(!empty($rule['discount'])) { ?>
                ,<?php echo $lang['nc_reduce'];?><?php echo ncPriceFormat($rule['discount']);?><?php echo $lang['nc_yuan'].$lang['nc_cash'];?>
                <?php } ?>
                <?php if(!empty($rule['shipping_free'])) { ?>
                ,<?php echo $lang['nc_shipping_free'];?>
                <?php } ?>
                <?php if(!empty($rule['gift_name'])) { ?>
                ,<?php echo $lang['nc_gift'];?><a href="<?php echo $rule['gift_link'];?>" target="_blank" class="red" ><?php echo $rule['gift_name'];?></a>
                <?php } ?>
              </li>
              <?php } ?>
            </ul>
          </dd>
          <dd class="nc-mansong-remark"><?php echo $output['mansong_info']['remark'];?></dd>
        </dl>
      </div>
    </div>
    </section>
    <?php } ?>
    <!--E 满就送 -->
          <!-- S商品信息 -->
          <div class="nc-bundling-goods">
            <h4><?php echo $lang['bundling_include_goods'];?></h4>
            <ul nctype="goods_list">
              <?php if(!empty($output['b_goods_array'])){?>
              <?php foreach($output['b_goods_array'] as $value){?>
              <li nctype="nc_li">
                <dl class="goods-info">
                  <dt class="goods-name"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$value['goods_id']), 'goods', $output['store_info']['store_domain']);?>" target="block"><?php echo $value['goods_name']?></a></dt>
                  <dd class="goods-pic">
                    <div class="small"><span class="thumb size60"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$value['goods_id']), 'goods', $output['store_info']['store_domain']);?>" target="block"> <img src="<?php echo cthumb($value['goods_image'], 'tiny', $value['store_id']);?>" onload="javascript:DrawImage(this,60,60);"/></a></span> </div>
                    <div class="arrow"></div>
                    <div class="middle"><span class="thumb size160"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$value['goods_id']), 'goods', $output['store_info']['store_domain']);?>" target="block"> <img src="<?php echo cthumb($value['goods_image'], 'small', $value['store_id']);?>" onload="javascript:DrawImage(this,160,160);"/></a></span></div>
                  </dd>
                  <dd class="goods-price"><?php echo $lang['nc_price'];?><em class="price"><?php echo $lang['currency'].$value['goods_store_price'];?></em></dd>
                  <dd class="goods-storage"><?php echo $lang['bundling_storage'];?><span nctype="goods-storage"><?php echo $value['spec_goods_storage'];?></span><?php echo $lang['piece'];?></dd>
                </dl>
                <div class="nc-key">
                  <div class="nc-spec"> 
                    <!-- S 商品规格值-->
                    <?php if(is_array($value['goods_spec'])){ $i=0;?>
                    <?php foreach($value['spec_name'] as $key=>$val){$i++;?>
                    <dl>
                      <dt><?php echo $val;?><?php echo $lang['nc_colon'];?></dt>
                      <dd>
                        <?php if (is_array($value['goods_spec'][$key]) and !empty($value['goods_spec'][$key])) {?>
                        <ul nctyle="ul_sign">
                          <?php $j=0;foreach($value['goods_spec'][$key] as $k=>$v) {$j++;?>
                          <?php if(is_array($value['goods_col_img']) && isset($value['goods_col_img'][$v]) && $value['goods_col_img'][$v] != ''){?>
                          <!-- 图片类型规格-->
                          <li class="sp-img"><a href="javascript:void(0)" onClick="selectSpec(<?php echo $i;?>, this, <?php echo $k;?>, <?php echo $value['goods_id'];?>)" class="<?php if($j==1){echo 'hovered';}?>" title="<?php echo $v;?>" style=" background-image: url(<?php echo SiteUrl.DS.ATTACH_SPEC.DS.$value['store_id'].DS.$value['goods_col_img'][$v];?>);"><?php echo $v;?><i></i></a></li>
                          <?php }else{?>
                          <!-- 文字类型规格-->
                          <li class="sp-txt"><a href="javascript:void(0)" onClick="selectSpec(<?php echo $i;?>, this, <?php echo $k;?>, <?php echo $value['goods_id'];?>)" class="<?php if($j==1){echo 'hovered';}?>"><?php echo $v;?><i></i></a></li>
                          <?php }?>
                          <?php }?>
                        </ul>
                        <?php }?>
                      </dd>
                    </dl>
                    <?php }?>
                    <?php }?>
                    <p nc_type="goods_prompt" class="goods-prompt"></p>
                    <!-- S 加入购物车 --><p nc_type="add_cart" class="add-cart"><?php echo $lang['bundling_add_to_cart'];?></p><!-- E 加入购物车 -->
                    <input type="hidden" nctype="goods_spec_id" name="spec[<?php echo $value['goods_id'];?>]" value="<?php echo $value['spec_id'];?>" />
                    <!-- E 商品规格值--> 
                    <!-- S 加入购物车弹出提示框 -->
		              <div class="ncs_cart_popup">
		                <dl>
		                  <dt>
		                    <h3><?php echo $lang['goods_index_cart_success'];?></h3>
		                    <a title="<?php echo $lang['goods_index_close'];?>" onClick="$('.ncs_cart_popup').css({'display':'none'});"><?php echo $lang['goods_index_close'];?></a></dt>
		                  <dd>
		                    <p class="mb5"><?php echo $lang['goods_index_cart_have'];?> <strong id="bold_num"></strong> <?php echo $lang['goods_index_number_of_goods'];?> <?php echo $lang['goods_index_total_price'];?><?php echo $lang['nc_colon'];?><em id="bold_mly" class="price"></em></p>
		                    <p>
		                      <input type="submit" class="btn1" name="" value="<?php echo $lang['goods_index_view_cart'];?>" onClick="location.href='<?php echo SiteUrl.DS?>index.php?act=cart'"/>
		                      <input type="submit" class="btn2" name="" value="<?php echo $lang['goods_index_continue_shopping'];?>" onClick="$('.ncs_cart_popup').css({'display':'none'});"/>
		                    </p>
		                  </dd>
		                </dl>
		              </div>
		              <!-- E 加入购物车弹出提示框 -->
                  </div>
                </div>
              </li>
              <?php }?>
              <?php }?>
            </ul>
            <div class="clear"></div>
            <?php if($output['bundling_info']['bl_state']){?>
            <div class="nc-bundling-buy">
              <p><?php echo $lang['bundling_buy'];?><input type="text" nctype="bundling_quantity" name="quantity" value="1" class="w40 mr5"/><?php echo $lang['bundling_tao'];?></p>
              <a class="buynow" nctype="buynow" title="<?php echo $lang['bundling_buy_now'];?>" href="javascript:buynow();"></a> <span class="no-buynow" nctype="buynow" style="display:none;"></span> </div>
          	<?php }?>
          </div>
          
          <!-- E商品信息 --> 
          <!-- S套餐描述 -->
          <section class="nc-s-c-s4 ncg-intro">
            <div class="title hd">
              <h4><?php echo $lang['bundling_desc'];?></h4>
            </div>
            <div class="content bd" id="ncGoodsIntro">
              <div class="default"><?php echo html_entity_decode($output['bundling_info']['bl_desc']);?></div>
            </div>
          </section>
          <!-- E套餐描述 --> 
          <!-- S推荐套餐 -->
          <?php if(is_array($output['other_bundling'])){?>
          <section class="nc-s-c-s2 ncg-com-list">
            <div class="title">
              <h4><?php echo $lang['bundling_other'];?></h4>
            </div>
            <div class="content">
              <ul>
                <?php foreach($output['other_bundling'] as $val){?>
                <li>
                  <dl>
                    <dt><a href="index.php?act=bundling&bundling_id=<?php echo $val['bl_id']?>&id=<?php echo $val['store_id']?>" target="_blank"><?php echo $val['bl_name'];?></a></dt>
                    <dd class="ncg-pic"><span class="thumb"><i></i><a href="index.php?act=bundling&bundling_id=<?php echo $val['bl_id']?>&id=<?php echo $val['store_id']?>" target="_blank"><img height="150" width="150" src="<?php echo cthumb($val['bl_img_more'],'small',$val['store_id']);?>" onload="javascript:DrawImage(this,160,160);" title="<?php echo $val['bl_name'];?>" alt="<?php echo $val['bl_name'];?>"/></a></span></dd>
                    <dd class="ncg-price"><?php echo $lang['nc_price'];?><em class="price"><?php echo $lang['currency'];?><?php echo $val['bl_discount_price'];?></em></dd>
                  </dl>
                </li>
                <?php }?>
              </ul>
              <div class="clear"></div>
            </div>
          </section>
          <?php }?>
          <!-- E推荐套餐 --> 
        </article>
      </form>
      <aside class="nc-sidebar">
        <?php include template('store/info');?>
        <?php include template('store/left');?>
      </aside>
    </section>
  </article>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/nc-zoom.js"></script> 
<script type="text/javascript">
function buynow()
{
	<?php if ($_SESSION['is_login'] !== '1'){?>
	login_dialog();
	<?php }else{?>
	sign = checkedGoodsStorage();
	if(sign){
		$('#bundling_form').submit();
	}
	<?php }?>
}

// 验证商品库存
function checkedGoodsStorage(){
	var sign = true;
	var quantity= parseInt($('input[nctype="bundling_quantity"]').val());
	$('input[nctype="goods_spec_id"]').each(function(){
		var storage = parseInt($(this).parents('li[nctype="nc_li"]:first').find('span[nctype="goods-storage"]').html());
		if(parseInt($(this).val()) <= 0 || storage < quantity){
			sign = false;
			$(this).prevAll('p[nc_type="goods_prompt"]').show().html('<?php echo $lang['bundling_goods_error_tip'];?>');
		}
	});

	if(sign){
		$('a[nctype="buynow"]').css('display','');
		$('span[nctype="buynow"]').css('display','none');
	}else{
		$('a[nctype="buynow"]').css('display','none');
		$('span[nctype="buynow"]').css('display','');
	}
	return sign;
}

/* spec对象 */
function spec(id, gid, spec, price, stock)
{
    this.id    = id;
    this.gid   = gid;
    this.spec  = spec;
    this.price = price;
    this.stock = stock;
}
/* goodsspec对象 */
function goodsspec(specs)
{
    this.specs = specs;
    <?php for ($i=1; $i<=$output['spec_count'];$i++){?>
    this.spec<?php echo $i?> = null;
    this.gid<?php echo $i?> = null;
    <?php }?>

    // 取得选中的spec
    this.getSpec = function()
    {
        for (var i = 0; i < this.specs.length; i++)
        {
            <?php for ($i=1; $i<=$output['spec_count'];$i++){?>
            if (this.specs[i].spec[<?php echo (intval($i)-1);?>] == this.spec<?php echo $i?> && this.specs[i].gid == this.gid<?php echo $i?>) return this.specs[i];
            <?php }?>
        }
        return null;
    }

}

/* 选中某规格 num=1,2 */
function selectSpec(num, liObj, SID, GID)
{
	goodsspec['spec' + num] = SID;
	goodsspec['gid' + num] = GID;
    $(liObj).parents('li:first').siblings().find('a').removeClass("hovered");
    $(liObj).addClass("hovered");
    var spec = goodsspec.getSpec();
    var sign = 't';
    $('ul[nctyle="ul_sign"]').each(function(){
		if($(this).find('.hovered').html() == null ){
			sign = 'f';
		}
    });
    if (spec != null && sign == 't')
    {
        $(liObj).parents('li[nctype="nc_li"]').find('span[nctype="goods-storage"]').html(spec.stock);
        var $parent = $(liObj).parents('div[class="nc-spec"]:first');
        if(parseInt(spec.stock) == 0 || parseInt(spec.stock) < parseInt($('input[nctype="bundling_quantity"]').val())){
            $parent.find('p[nc_type="goods_prompt"]').css('display','block');			// 提示框隐藏
			$('p[nc_type="goods_prompt"]').html('<?php echo $lang['bundling_storage_not_enough'];?>');
        }else{
            $parent.find('input[nctype="goods_spec_id"]').val(spec.id);					// 选中的规格id
            $parent.find('p[nc_type="goods_prompt"]').css('display','none');			// 提示框隐藏
        }
        checkedGoodsStorage();
     }
}

var specs = new Array();
<?php if (is_array($output['spec_array']) and !empty($output['spec_array'])) { 
	foreach($output['spec_array'] as $val) {
?>
specs.push(new spec(<?php echo $val['spec_id']; ?>, <?php echo $val['goods_id']?>, [<?php echo $val['spec_goods_spec']?>], <?php echo $val['spec_goods_price']; ?>, <?php echo $val['spec_goods_storage']; ?>));
<?php
	}
 }
?>
var goodsspec = new goodsspec(specs);

$(function(){
	//  计算li高度，同行高度一样
	$('ul[nctype="goods_list"] > li:even').each(function(){
		$this_H = $(this).height();
		$next_H = $(this).next().height();
		H = $this_H > $next_H?$this_H:$next_H;
		$(this).height(H).next().height(H);
	});

	$('input[nctype="bundling_quantity"]').change(function(){
		$('p[nc_type="goods_prompt"]').hide().html('');
		$('a[nctype="buynow"]').css('display','');
		$('span[nctype="buynow"]').css('display','none');
	});


	// 单个商品加入购物车
	$('p[nc_type="add_cart"]').click(function(){
		<?php if ($_SESSION['is_login'] !== '1'){?>
		login_dialog();
		<?php }else{?>
		obj_li = $(this).parents('li:first');
		if(parseInt(obj_li.find('span[nctype="goods-storage"]').html()) <= 0){
			obj_li.find('p[nc_type="goods_prompt"]').show().html('<?php echo $lang['bundling_storage_not_enough'];?>');
		}else{
		    var url = 'index.php?act=cart&op=add';
		    $.getJSON(url, {'spec_id':obj_li.find('input[nctype="goods_spec_id"]').val(), 'quantity':1}, function(data){
		    	if(data != null){
		    		if (data.done)
		            {
		    			showDialog('<h3><?php echo $lang['bundling_add_cart_prompt_one'];?></h3><p><?php echo $lang['bundling_add_cart_prompt_two'];?><strong>'+data.num+'</strong> <?php echo $lang['bundling_add_cart_prompt_three'];?><em>'+price_format(data.amount)+'</em></p>', 'succ', '');
		            }
		            else
		            {
		                alert(data.msg);
		            }
		    	}
		    });
		}
		<?php }?>
	});


	// 验证库存
	checkedGoodsStorage();
});
function bundlingSlideUp_fn()
{
    $('#append_parent').slideUp('slow').html('');
}

</script>
<?php include template('footer');?>
</body></html>