<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap"> 
  
  <!-- 评分统计start -->
  <div class="personal-rating">
    <h4><?php echo $lang['member_evaluation_storeevalstat'];?></h4>
    <table class="seller-rate-info" id="sixmonth">
      <tbody>
        <tr>
          <th><p><?php echo $lang['member_evaluation_evalstore_type_1'];?></p>
            <p class="rate-star mt5"><em><i style=" width:<?php echo $output['storestat_list'][1]['rate']>0?$output['storestat_list'][1]['rate']:0;?>%;"></i></em></p></th>
          <td><dl class="ncs-rate-column">
              <dt><em style="left:<?php echo $output['storestat_list'][1]['rate']>0?$output['storestat_list'][1]['rate']:0;?>%;"><?php echo $output['storestat_list'][1]['evalstat_average']>0?$output['storestat_list'][1]['evalstat_average']:0;?></em></dt>
              <dd><?php echo $lang['member_evaluation_description_of_grade_1'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_2'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_3'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_4'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_5'];?></dd>
            </dl></td>
        </tr>
        <tr>
          <th><p><?php echo $lang['member_evaluation_evalstore_type_2'];?></p>
            <p class="rate-star mt5"><em><i style="width:<?php echo $output['storestat_list'][2]['rate']>0?$output['storestat_list'][2]['rate']:0;?>%;"></i></em></p></th>
          <td><dl class="ncs-rate-column">
              <dt><em style="left:<?php echo $output['storestat_list'][2]['rate']>0?$output['storestat_list'][2]['rate']:0;?>%;"><?php echo $output['storestat_list'][2]['evalstat_average']>0?$output['storestat_list'][2]['evalstat_average']:0;?></em></dt>
              <dd><?php echo $lang['member_evaluation_description_of_grade_1'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_2'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_3'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_4'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_5'];?></dd>
            </dl></td>
        </tr>
        <tr>
          <th><p><?php echo $lang['member_evaluation_evalstore_type_3'];?></p>
            <p class="rate-star mt5"><em><i style="width:<?php echo $output['storestat_list'][3]['rate']>0?$output['storestat_list'][3]['rate']:0;?>%;"></i></em></p></th>
          <td><dl class="ncs-rate-column">
              <dt><em style="left:<?php echo $output['storestat_list'][3]['rate']>0?$output['storestat_list'][3]['rate']:0;?>%;"><?php echo $output['storestat_list'][3]['evalstat_average']>0?$output['storestat_list'][3]['evalstat_average']:0;?></em></dt>
              <dd><?php echo $lang['member_evaluation_description_of_grade_1'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_2'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_3'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_4'];?></dd>
              <dd><?php echo $lang['member_evaluation_description_of_grade_5'];?></dd>
            </dl></td>
        </tr>
      </tbody>
    </table>
    <?php if ($_GET['act'] == 'store_evaluate'){?>
    <h4><strong><?php echo $lang['member_evaluation_storecredittitle'];?><?php echo $lang['nc_colon'];?><?php echo intval($output['store_info']['store_credit']);?></strong>
      <?php if (!empty($output['store_info']['credit_arr'])){?>
      <span class="seller-<?php echo $output['store_info']['credit_arr']['grade']; ?> level-<?php echo $output['store_info']['credit_arr']['songrade']; ?>"></span>
      <?php }?>
      <span class="rate-summary"><?php echo $lang['member_evaluation_storepraise_rate'];?><?php echo $lang['nc_colon'];?><strong><?php echo intval($output['store_info']['praise_rate']);?>%</strong></span> </h4>
    <table class="buyer-rate-info ncgeval">
      <thead>
        <tr>
          <th>&nbsp;</th>
          <th class="ncgeval-good"><span class="ico"></span><?php echo $lang['member_evaluation_good'];?></th>
          <th class="ncgeval-normal"><span class="ico"></span><?php echo $lang['member_evaluation_normal'];?></th>
          <th class="ncgeval-bad"><span class="ico"></span><?php echo $lang['member_evaluation_bad'];?></th>
          <th><?php echo $lang['member_evaluation_amountto'];?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $lang['member_evaluation_lastweek'];?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level1num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level2num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level3num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][0]['gevalstat_level1num'])+intval($output['goodsstat_list'][0]['gevalstat_level2num'])+intval($output['goodsstat_list'][0]['gevalstat_level3num']);?></td>
        </tr>
        <tr>
          <td><?php echo $lang['member_evaluation_lastmonth'];?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level1num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level2num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level3num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][1]['gevalstat_level1num'])+intval($output['goodsstat_list'][1]['gevalstat_level2num'])+intval($output['goodsstat_list'][1]['gevalstat_level3num']);?></td>
        </tr>
        <tr>
          <td><?php echo $lang['member_evaluation_lastsix_month'];?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level1num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level2num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level3num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][2]['gevalstat_level1num'])+intval($output['goodsstat_list'][2]['gevalstat_level2num'])+intval($output['goodsstat_list'][2]['gevalstat_level3num']);?></td>
        </tr>
        <tr>
          <td><?php echo $lang['member_evaluation_sixmonth_before'];?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level1num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level2num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level3num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][3]['gevalstat_level1num'])+intval($output['goodsstat_list'][3]['gevalstat_level2num'])+intval($output['goodsstat_list'][3]['gevalstat_level3num']);?></td>
        </tr>
        <tr>
          <td><?php echo $lang['member_evaluation_amountto'];?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][4]['gevalstat_level1num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][4]['gevalstat_level2num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][4]['gevalstat_level3num']);?></td>
          <td bgcolor="#FFFFFF"><?php echo intval($output['goodsstat_list'][4]['gevalstat_level1num'])+intval($output['goodsstat_list'][4]['gevalstat_level2num'])+intval($output['goodsstat_list'][4]['gevalstat_level3num']);?></td>
        </tr>
      </tbody>
    </table>
    <?php } ?>
    <!-- 评分统计end --> 
  </div>
  <div class="tabmenu">
    <ul id="listpj" class="tab">
      <li class="<?php if ($_GET['type'] == ''){echo 'active';}else {echo 'normal';}?>"><a href="index.php?act=<?php echo $output['pj_act'];?>&op=list#listpj"><?php echo $lang['member_evaluation_frombuyer'];?></a></li>
      <li class="<?php if ($_GET['type'] == 'fromseller'){echo 'active';}else {echo 'normal';}?>"><a href="index.php?act=<?php echo $output['pj_act'];?>&op=list&type=fromseller#listpj"><?php echo $lang['member_evaluation_fromseller'];?></a></li>
      <li class="<?php if ($_GET['type'] == 'toothers'){echo 'active';}else {echo 'normal';}?>"><a href="index.php?act=<?php echo $output['pj_act'];?>&op=list&type=toothers#listpj"><?php echo $lang['member_evaluation_toother'];?></a></li>
    </ul>
  </div>
  <form id="goodsevalform" method="get">
    <input type="hidden" name="act" value="<?php echo $output['pj_act'];?>"/>
    <input type="hidden" name="op" value="list"/>
    <input type="hidden" name="type" value="<?php echo $_GET['type'];?>"/>
    <table class="ncu-table-style">
      <thead>
        <tr>
          <th class="w70"><select name="evalscore" nc_type="sform">
              <option value="0" <?php if (!$_GET['evalscore']){echo 'selected=selected';}?>><?php echo $lang['member_evaluation_title'];?></option>
              <option value="1" <?php if ($_GET['evalscore'] == 1){echo 'selected=selected';}?>><?php echo $lang['member_evaluation_good'];?></option>
              <option value="2" <?php if ($_GET['evalscore'] == 2){echo 'selected=selected';}?>><?php echo $lang['member_evaluation_normal'];?></option>
              <option value="3" <?php if ($_GET['evalscore'] == 3){echo 'selected=selected';}?>><?php echo $lang['member_evaluation_bad'];?></option>
            </select>
          </th>
          <th class="w200 tl"> <select name="havecontent" nc_type="sform">
              <option value="0" <?php if (!$_GET['havecontent']){echo 'selected=selected';}?>><?php echo $lang['member_evaluation_comment'];?></option>
              <option value="1" <?php if ($_GET['havecontent'] == 1){echo 'selected=selected';}?>><?php echo $lang['member_evaluation_havecomment'];?></option>
              <option value="2" <?php if ($_GET['havecontent'] == 2){echo 'selected=selected';}?>><?php echo $lang['member_evaluation_nohavecomment'];?></option>
            </select>
          </th>
          <th class="w180"><?php echo $lang['member_evaluation_frommembertitle'];?></th>
          <th class="tl"><?php echo $lang['member_evaluation_goodsinfo_title'];?></th>
          <th class="w90"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <?php if (is_array($output['goodsevallist']) && !empty($output['goodsevallist'])) { ?>
      <?php if ($_GET['type'] == 'toothers'){include template("member/member_evaluation_2");}elseif ($_GET['type'] == 'fromseller'){include template("member/member_evaluation_3");}else {include template("member/member_evaluation_1");} ?>
      <tfoot>
        <tr>
          <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
        </tr>
      </tfoot>
      <?php } else { ?>
      <tbody>
        <tr>
          <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function()
{
	$('*[nc_type="sform"]').change(function(){
		$("#goodsevalform").submit();
	});
});
</script>