<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
.evallist .date { color: #999999; padding-top:3px;}
.rate-star em {
    background-position: left top;
    display: block;
    float: left;
    margin: 8px 100px;
    position: relative;
    width: 70px;
    z-index: 1;
}
.rate-star em, .rate-star em i {
    background-image: url("templates/images/rate_star.gif");
    background-repeat: repeat-x;
    height: 12px;
}
.rate-star em i {
    background-position: left bottom;
    left: 0;
    position: absolute;
    top: 0;
    z-index: 1;
}
</style>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_goods_evaluate']; ?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=evaluate&op=evalgoods_list" ><span><?php echo $lang['admin_evaluate_list'];?></span></a></li>
        <li><a href="index.php?act=evaluate&op=evalseller_list" ><span><?php echo $lang['admin_evalseller_list'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_evalstore_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="act" value="evaluate" />
    <input type="hidden" name="op" value="evalstore_list" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name"><?php echo $lang['admin_evaluate_storename'];?></label></th>
          <td><input class="txt" type="text" name="store_name" id="store_name" value="<?php echo $_GET['store_name'];?>" /></td>
          <th><label for="from_name"><?php echo $lang['admin_evaluate_frommembername'];?></label></th>
          <td><input class="txt" type="text" name="from_name" id="from_name" value="<?php echo $_GET['from_name'];?>" /></td>
          <td><select name="grade">
              <option value='' <?php echo $_GET['grade'] == ''?'selected':''; ?>><?php echo $lang['admin_evalstore_score'];?></option>
              <?php for ($i=1; $i<=5; $i++){?>
              <option value="<?php echo $i;?>" <?php echo $_GET['grade'] == "$i"?'selected':''; ?>><?php echo $i;?><?php echo $lang['admin_evalstore_score_unit'];?></option>
              <?php }?>
            </select></td>
          <td><?php echo $lang['admin_evaluate_addtime'];?></td>
          <td><input class="txt date" type="text" name="stime" id="stime" value="<?php echo $_GET['stime'];?>" />~
          	<input class="txt date" type="text" name="etime" id="etime" value="<?php echo $_GET['etime'];?>" />
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['admin_evalstore_help1'];?></li>
            <li><?php echo $lang['admin_evalstore_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 evallist">
    <?php if(is_array($output['evalstore_list'])){?>
    <thead>
      <tr class="thead">
        <th><?php echo $lang['admin_evaluate_storename'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evaluate_ordersn'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evaluate_frommembername'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evalstore_type'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evalstore_score'];?></th>
        <th class="w150 align-center"><?php echo $lang['admin_evaluate_addtime'];?></th>
        <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($output['evalstore_list'] as $v){?>
      <tr class="hover">
      	<td><?php echo $v['seval_storename'];?></td>
      	<td class="align-center"><?php echo $v['seval_orderno'];?></td>
      	<td class="align-center"><?php echo $v['seval_membername'];?></td>
      	<td class="align-center"><?php echo $output['evalstore_type'][$v['seval_type']];?></td>
      	<td class="align-center"><dd class="rate-star" title="<?php echo $v['seval_scores'];?><?php echo $lang['admin_evalstore_score_unit'];?>"><em><i style=" width:<?php echo round($v['seval_scores']/5*100,2); ?>%;"></i></em></dd></td>
      	<td class="align-center"><?php echo @date('Y-m-d',$v['seval_addtime']);?></td>
        <td class="align-center"><a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){window.location='index.php?act=evaluate&op=evalstore_del&id=<?php echo $v['seval_id']; ?>';}else{return false;}"><?php echo $lang['nc_del']; ?></a></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"><?php echo $output['show_page'];?></div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#stime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#etime').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>