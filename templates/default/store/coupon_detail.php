<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('store/header');?>

<div class="background clearfix">
  <?php include template('store/top');?>
  <article id="content">
    <section class="layout expanded mt10" >
      <article class="nc-goods-main"> 
        <!-- 店铺优惠券内容介绍S -->
        <div class="nc-s-c-s4">
          <div class="title">
            <h4><?php echo $output['detail']['coupon_title']; ?></h4>
          </div>
          <div class="content ncs-coupon">
            <dl>
              <dt><span class="thumb"><i></i><img id="divToPrint" src="<?php if(stripos( $output['detail']['coupon_pic'] , 'http://') === false){ echo SiteUrl.'/'.$output['detail']['coupon_pic']; }else{ echo $output['detail']['coupon_pic'];}?>" alt="<?php echo $output['detail']['coupon_title']; ?>" onload="javascript:DrawImage(this,580,353);" onerror="this.src='<?php echo TEMPLATES_PATH."/images/default_coupon_image.png"?>'" /></span><em><?php echo $lang['coupon_index_valid'];?></em></dt>
              <dd>
                <p><?php echo $lang['coupon_index_coupon_num'];?><strong><?php echo $output['detail']['coupon_click']?></strong><?php echo $lang['coupon_index_coupon_click'];?><strong><?php echo $output['detail']['coupon_usage']; ?></strong> <?php echo $lang['coupon_index_coupon_usage'];?></p>
              </dd>
              <dd class="print clearfix"><span class="l">
                <p class="info"><?php echo $lang['coupon_index_choose'];?></p>
                <select id="Select" class="select" name="selectcount">
                  <option value="0"><?php echo $lang['coupon_index_choose_piece'];?></option>
                  <option value="1">1<?php echo $lang['coupon_index_piece'];?></option>
                  <option value="2">2<?php echo $lang['coupon_index_piece'];?></option>
                  <option value="3">3<?php echo $lang['coupon_index_piece'];?></option>
                  <option value="4">4<?php echo $lang['coupon_index_piece'];?></option>
                  <option value="5">5<?php echo $lang['coupon_index_piece'];?></option>
                  <option value="6">6<?php echo $lang['coupon_index_piece'];?></option>
                  <option value="7">7<?php echo $lang['coupon_index_piece'];?></option>
                  <option selected="selected" value="8">8<?php echo $lang['coupon_index_piece'];?></option>
                </select>
                </span> <span class="r"><a class="btn" target="_blank" title="<?php echo $lang['coupon_index_print'];?>" href="index.php?act=coupon_store&op=coupon_print&coupon_id=<?php echo $output['detail']['coupon_id']; ?>" id="print" ><?php echo $lang['coupon_index_print'];?></a></span> </dd>
            </dl>
            <div class="clear"></div>
          </div>
        </div>
        <div class="nc-s-c-s4">
          <div class="title">
            <h4><?php echo $lang['coupon_index_coupon_info'];?></h4>
          </div>
          <?php if(trim('type')=='' or !in_array($_GET['type'],array('consulting'))) { ?>
          <div class="content option_box">
            <div class="default">
              <ul class="cons_intro">
                <li><span><?php echo $lang['coupon_index_coupon_desc'];?></span> <strong><?php echo $output['detail']['coupon_desc']; ?></strong></li>
                <li><span><?php echo $lang['coupon_index_period'];?> </span> <strong><?php echo date('Y-m-d',$output['detail']['coupon_start_date']); ?>&nbsp;&nbsp; <?php echo $lang['coupon_index_to'];?>&nbsp;&nbsp;<?php echo date('Y-m-d',$output['detail']['coupon_end_date']); ?></strong></li>
                <li><span><?php echo $lang['coupon_index_store_name'];?> </span> <a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']),'store',$output['store_info']['store_domain']);?>"> <?php echo $output['store_info']['store_name']?></a></li>
                <li><span><?php echo $lang['coupon_index_add_date'];?> </span> <?php echo date('Y-m-d',$output['detail']['coupon_add_date']); ?></li>
                <li class="cons_notice"><span><?php echo $lang['coupon_index_notice'];?> </span><?php echo $lang['coupon_index_notice_desc'];?></li>
              </ul>
            </div>
          </div>
          <?php }?>
        </div>
        <div class="nc-s-c-s2">
          <div class="title">
            <h4><?php echo $lang['coupon_index_new'];?> </h4>
          </div>
          <div class="content">
            <?php if(!empty($output['new'])){?>
            <ul class="consume_list">
              <?php foreach($output['new'] as $val){?>
              <li>
                <div class="pics">
                  <div class="v_ineffect"><?php echo $lang['coupon_index_valid'];?></div>
                  <div class="thumb"> <a href="<?php echo ncUrl(array('act'=>'coupon_store','op'=>'detail','coupon_id'=>$val['coupon_id'],'id'=>$val['store_id']), 'coupon_info'); ?>" target="_blank"> <img src="<?php  if(stripos( $val['coupon_pic'], 'http://') === false){ echo SiteUrl.'/'.$val['coupon_pic']; }else{ echo $val['coupon_pic'];} ?>" alt="<?php echo $val['coupon_desc']; ?>" onload="javascript:DrawImage(this,210,130);" onerror="this.src='<?php echo TEMPLATES_PATH."/images/default_coupon_image.png"?>'" /></a> </div>
                </div>
                <p class="mtn"><a href="<?php echo ncUrl(array('act'=>'coupon_store','op'=>'detail','coupon_id'=>$val['coupon_id'],'id'=>$val['store_id']), 'coupon_info'); ?>" title="<?php echo $val['coupon_title']; ?>" target="_blank"> <?php echo $val['coupon_title']; ?></a></p>
                <p class="xi1"><?php echo $lang['coupon_index_period'];?> <?php echo date('Y-m-d',$val['coupon_start_date']); ?> <?php echo $lang['coupon_index_to'];?> <?php echo date('Y-m-d',$val['coupon_end_date']); ?></p>
              </li>
              <?php }?>
            </ul>
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
  </article>
</div>
<?php include template('footer');?>
<script type="text/javascript">
var SITE_URL = "<?php if($GLOBALS['setting_config']['enabled_subdomain'] == '1' and $output['store_info']['store_domain']!='') echo "http://".$output['store_info']['store_domain'].'.'.$GLOBALS['setting_config']['subdomain_suffix']; else echo SiteUrl;?>";
</script> 
<script>
	$(function(){

		$('#print').click(function(){
			var select = $('#Select').val() ;
			if(select==0) {
				return false ;
			}else{
				var url = $('#print').attr('href') ;
				url = url+'&num='+select ;
				$('#print').attr('href',url) ;
				return true ;
			}		
		})
		
	})
</script> 
