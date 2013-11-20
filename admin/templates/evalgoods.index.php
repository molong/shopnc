<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_goods_evaluate']; ?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_evaluate_list'];?></span></a></li>
        <li><a href="index.php?act=evaluate&op=evalseller_list" ><span><?php echo $lang['admin_evalseller_list'];?></span></a></li>
        <li><a href="index.php?act=evaluate&op=evalstore_list" ><span><?php echo $lang['admin_evalstore_list'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="act" value="evaluate" />
    <input type="hidden" name="op" value="evalgoods_list" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="goods_name"><?php echo $lang['admin_evaluate_goodsname']?></label></th>
          <td><input class="txt" type="text" name="goods_name" id="goods_name" value="<?php echo $_GET['goods_name'];?>" /></td>
          <th><label for="store_name"><?php echo $lang['admin_evaluate_storename']?></label></th>
          <td><input class="txt" type="text" name="store_name" id="store_name" value="<?php echo $_GET['store_name'];?>" /></td>
          <td><select name="grade">
              <option value='' <?php echo $_GET['grade'] == ''?'selected':''; ?>><?php echo $lang['admin_evaluate_grade']; ?></option>
              <?php foreach ((array)$output['evaluate_grade'] as $k=>$v){?>
              <option value="<?php echo $k;?>" <?php echo $_GET['grade'] == "$k"?'selected':''; ?>><?php echo $v;?></option>
              <?php }?>
            </select></td>
          <td><select name="state">
              <option value='' <?php echo $_GET['state'] == ''?'selected':''; ?>><?php echo $lang['admin_evaluate_state'];?></option>
              <?php foreach ((array)$output['evaluate_state'] as $k=>$v){?>
              <option value="<?php echo $k;?>" <?php echo $_GET['state'] == "$k"?'selected':''; ?>><?php echo $v;?></option>
              <?php }?>
            </select></td>
          <td><?php echo $lang['admin_evaluate_addtime']; ?></td>
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
            <li><?php echo $lang['admin_evaluate_help1'];?></li>
            <li><?php echo $lang['admin_evaluate_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <?php if(!empty($output['evalgoods_list'])){?>
    <thead>
      <tr class="thead">
        <th class="w72 align-center"><?php echo $lang['admin_evaluate_grade']; ?></th>
        <th><?php echo $lang['admin_evaluate_buyerdesc']; ?></th>
        <th class="w108 align-center"><?php echo $lang['admin_evaluate_frommembername'];?> </th>
        <th class="w270"><?php echo $lang['admin_evaluate_goodsname'];?> </th>
        <th class="w108 align-center"><?php echo $lang['admin_evaluate_storename'];?></th>
        <th class="align-center"><?php echo $lang['admin_evaluate_state']; ?></th>
        <th class="w72 align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($output['evalgoods_list'] as $v){?>
      <tr class="hover">
      	<td class="align-center"><?php echo $output['evaluate_grade'][$v['geval_scores']];?></td>
      	<td>
      		<div><?php if (empty($v['geval_content'])){ echo $output['evaluate_defaulttext'][$v['geval_scores']]; }else {echo $v['geval_content'];}?></div>
      		<?php if(!empty($v['geval_explain'])){?>
      		<div id="explain_div_<?php echo $v['geval_id'];?>">
      		<span style="color:#996600;padding:5px 0px;">[<?php echo $lang['admin_evaluate_explain']; ?>]<?php echo $v['geval_explain'];?></span>
      		<a class="btns tooltip" onclick="hiddenexplain(<?php echo $v['geval_id'];?>);" href="JavaScript:void(0);" title="<?php echo $lang['admin_evaluate_delexplain'];?>"><span><?php echo $lang['admin_evaluate_delexplain'];?></span></a>
      		</div>
      		<?php }?>
      		<div style="color: #999999; padding-top:3px;">[<?php echo @date('Y-m-d',$v['geval_addtime']);?>]</div>
      	</td>
      	<td class="align-center"><?php echo $v['geval_frommembername'];?></td>
        <td><a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'goods','goods_id'=>$v['geval_goodsid']), 'goods');?>" target="_blank"><?php echo $v['geval_goodsname'];?></a></td>
        <td class="align-center"><?php echo $v['geval_storename'];?></td>
        <td class="align-center"><?php echo $output['evaluate_state'][$v['geval_state']];?></td>
        <td class="align-center">
        	<a href="index.php?act=evaluate&op=evalgoods_info&id=<?php echo $v['geval_id'];?>" ><?php echo $lang['nc_edit'];?></a>
        	<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){window.location='index.php?act=evaluate&op=evalgoods_del&id=<?php echo $v['geval_id']; ?>';}else{return false;}"><?php echo $lang['nc_del']; ?></a>
        </td>
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
function hiddenexplain(id){
	if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){
		$.get("index.php?act=evaluate&op=delexplain", {'id':id}, function(data){
            if (data == 1)
            {
            	$("#explain_div_"+id).hide();
            	alert('<?php echo $lang['admin_evaluate_drop_success'];?>');
            }
            else
            {
            	alert('<?php echo $lang['admin_evaluate_drop_fail'];?>');
            }
        });
	}
}
</script>