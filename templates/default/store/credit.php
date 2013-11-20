<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('store/header');?>
<div class="background clearfix">
  <?php include template('store/top');?>
  <article id="content">
    <section class="layout expanded mt10">
      <article class="nc-goods-main"> 
        <!-- 商品评分统计信息S -->
        <div class="nc-s-c-s2">
          <div class="title">
            <h4><?php echo $lang['show_store_credit_good_rate'];?> ( <?php echo $output['store_info']['praise_rate'];?> % )</h4>
          </div>
          <div class="content">
            <table class="ncs-evaluation-tb">
              <thead>
                <tr>
                  <th></th>
                  <td class="ncse-good"><span class="ico pngFix"></span><?php echo $lang['nc_credit_good'];?></td>
                  <td class="ncse-normal"><span class="ico pngFix"></span><?php echo $lang['nc_credit_normal'];?></td>
                  <td class="ncse-bad"><span class="ico pngFix"></span><?php echo $lang['nc_credit_bad'];?></td>
                  <td class="ncse-sum"><?php echo $lang['show_store_credit_sum'];?></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th><?php echo $lang['show_store_credit_week'];?></th>
                  <td class="ncse-good"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level1num']);?></td>
                  <td class="ncse-normal"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level2num']);?></td>
                  <td class="ncse-bad"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level3num']);?></td>
                  <td class="ncse-sum"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level1num'])+intval($output['goodsstat_list'][0]['gevalstat_level2num'])+intval($output['goodsstat_list'][0]['gevalstat_level3num']);?></td>
                </tr>
                <tr>
                  <th><?php echo $lang['show_store_credit_month'];?></th>
                  <td class="ncse-good"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level1num']);?></td>
                  <td class="ncse-normal"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level2num']);?></td>
                  <td class="ncse-bad"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level3num']);?></td>
                  <td class="ncse-sum"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level1num'])+intval($output['goodsstat_list'][1]['gevalstat_level2num'])+intval($output['goodsstat_list'][1]['gevalstat_level3num']);?></td>
                </tr>
                <tr>
                  <th><?php echo $lang['show_store_credit_six_month'];?></th>
                  <td class="ncse-good"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level1num']);?></td>
                  <td class="ncse-normal"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level2num']);?></td>
                  <td class="ncse-bad"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level3num']);?></td>
                  <td class="ncse-sum"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level1num'])+intval($output['goodsstat_list'][2]['gevalstat_level2num'])+intval($output['goodsstat_list'][2]['gevalstat_level3num']);?></td>
                </tr>
                <tr>
                  <th><?php echo $lang['show_store_credit_before_six'];?></th>
                  <td class="ncse-good"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level1num']);?></td>
                  <td class="ncse-normal"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level2num']);?></td>
                  <td class="ncse-bad"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level3num']);?></td>
                  <td class="ncse-sum"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level1num'])+intval($output['goodsstat_list'][3]['gevalstat_level2num'])+intval($output['goodsstat_list'][3]['gevalstat_level3num']);?></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th><?php echo $lang['show_store_credit_sum'];?></th>
                  <td><?php echo intval($output['goodsstat_list'][4]['gevalstat_level1num']);?></td>
                  <td><?php echo intval($output['goodsstat_list'][4]['gevalstat_level2num']);?></td>
                  <td><?php echo intval($output['goodsstat_list'][4]['gevalstat_level3num']);?></td>
                  <td><?php echo intval($output['goodsstat_list'][4]['gevalstat_level1num'])+intval($output['goodsstat_list'][4]['gevalstat_level2num'])+intval($output['goodsstat_list'][4]['gevalstat_level3num']);?></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <!-- 商品评分统计信息E -->
        <div class="nc-s-c-s2 mt10">
          <div class="title">
            <h4><?php echo $lang['show_store_credit_storestat_title'];?></h4>
          </div>
          <div class="content">
            <div class="ncs-rate clearfix">
              <ul class="ncs-rate-tab">
                <li class="current"><a href="javascript:void(0);"><?php echo $lang['nc_credit_evalstore_type_1'].$lang['nc_colon'];?>&nbsp;&nbsp;<em><?php echo $output['storestat_list'][1]['evalstat_average'];?></em><?php echo $lang['nc_grade'];?></a></li>
                <li><a href="javascript:void(0);"><?php echo $lang['nc_credit_evalstore_type_2'].$lang['nc_colon'];?>&nbsp;&nbsp;<em><?php echo $output['storestat_list'][2]['evalstat_average'];?></em><?php echo $lang['nc_grade'];?></a></li>
                <li><a href="javascript:void(0);"><?php echo $lang['nc_credit_evalstore_type_3'].$lang['nc_colon'];?>&nbsp;&nbsp;<em><?php echo $output['storestat_list'][3]['evalstat_average'];?></em><?php echo $lang['nc_grade'];?></a></li>
              </ul>
              <dl class="ncs-rate-icos">
                <dd class="rate-star"><em><i style="width: 100%"></i></em><span>5<?php echo $lang['nc_grade'];?></span></dd>
                <dd class="rate-star"><em><i style="width: 80%"></i></em><span>4<?php echo $lang['nc_grade'];?></span></dd>
                <dd class="rate-star"><em><i style="width: 60%"></i></em><span>3<?php echo $lang['nc_grade'];?></span></dd>
                <dd class="rate-star"><em><i style="width: 40%"></i></em><span>2<?php echo $lang['nc_grade'];?></span></dd>
                <dd class="rate-star"><em><i style="width: 20%"></i></em><span>1<?php echo $lang['nc_grade'];?></span></dd>
              </dl>
              <?php foreach ($output['storestat_list'] as $k=>$v){?>
              	<ul class="ncs-rate-panel <?php echo $k == 1?'':'hide'?>">
              	<?php foreach ($v as $sonk=>$sonv){?>
              		<?php if(in_array("$sonk",array('evalstat_onenum_rate','evalstat_twonum_rate','evalstat_threenum_rate','evalstat_fournum_rate','evalstat_fivenum_rate'))){?>
              			<li>
              			<?php if ($sonv>0){?>
              				<em style="width:<?php echo $sonv;?>px;"></em><i><?php echo $sonv;?>%</i>
              			<?php }else { echo $lang['show_store_credit_storeevalnull'];}?>
              			</li>
              		<?php }?>
              	<?php }?>
              	</ul>
              <?php }?>
            </div>
          </div>
        </div>
      </article>
      <aside class="nc-sidebar">
        <?php include template('store/info');?>
      </aside>
    </section>
    <div class="clear"></div>
    <!-- 商品评价列表S -->
    <div class="nc-s-c-s3 ncs-comment mt10">
      <div class="title">
        <h4><?php echo $lang['show_store_credit_credit'];?></h4>
      </div>
      <div class="content">
        <div id="goodseval" class="ncs-loading"></div>
        <script type="text/javascript">
			$("#goodseval").load('index.php?act=show_store&op=comments&id=<?php echo $_GET['id'];?>');
	  </script> 
      </div>
    </div>
  </article>
</div>
<?php include template('footer');?>
<script src="<?php echo RESOURCE_PATH;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script> 
