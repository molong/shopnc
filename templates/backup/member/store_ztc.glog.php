<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="get" action="index.php" onsubmit="return ztc_searchInput();">
    <table class="search-form">
      <input type="hidden" name="act" value="store_ztc" />
      <input type="hidden" name="op" value="ztc_glog" />
      <tr>
        <th><?php echo $lang['store_ztc_goodsname'].$lang['nc_colon']; ?></th>
        <td><input type="text" class="text"  id="zg_name" name="zg_name" value="<?php echo $_GET['zg_name'];?>"></td>
        <th><?php echo $lang['store_ztc_glog_recordtype'].$lang['nc_colon']; ?></th>
        <td><select class="w150" name="zg_type">
            <option value="0" <?php if (!$_GET['zg_type']){echo 'selected=selected';}?>><?php echo $lang['nc_please_choose'];?></option>
            <option value="1" <?php if ($_GET['zg_type'] == 1){echo 'selected=selected';}?>><?php echo $lang['store_ztc_glog_recordtype_add']; ?><!-- 增加 --></option>
            <option value="2" <?php if ($_GET['zg_type'] == 2){echo 'selected=selected';}?>><?php echo $lang['store_ztc_glog_recordtype_reduce']; ?><!-- 减少 --></option>
          </select></td>
        <th><?php echo $lang['store_ztc_addtime'].$lang['nc_colon']; ?></th>
        <td><input type="text"  class="text"  id="zg_stime" name="zg_stime" value="<?php echo $_GET['zg_stime'];?>">
          &nbsp;<?php echo $lang['admin_ztc_addtime_to']; ?>
          <input type="text" class="text"  id="zg_etime" name="zg_etime" value="<?php echo $_GET['zg_etime'];?>"></td>
        <td><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
      <thead>
        <tr nc_type="table_header">
          <th><?php echo $lang['store_ztc_list_number']; ?><!-- 序号 --></th>
          <th><?php echo $lang['store_ztc_goodsname']; ?><!-- 商品名称 --></th>
          <th><?php echo $lang['store_ztc_glog_list_goldnum']; ?><!-- 金币数量(枚) --></th>
          <th><?php echo $lang['store_ztc_glog_recordtype']; ?><!-- 类型 --></th>
          <th><?php echo $lang['store_ztc_addtime']; ?><!-- 添加时间 --></th>
          <th><?php echo $lang['store_ztc_glog_list_desc']; ?><!-- 描述 --></th>
        </tr>
      </thead>
      <?php if (count($output['list_log'])>0) { ?>
      <?php foreach($output['list_log'] as $val) { ?>
      <tbody>
        <tr>
          <td><?php echo $val['glog_id']; ?></td>
          <td><a href="index.php?act=goods&goods_id=<?php echo $val['glog_goodsid']; ?>" target="_blank"><?php echo $val['glog_goodsname']; ?></a></td>
          <td><?php echo $val['glog_goldnum']; ?></td>
          <td><?php if ($val['glog_type'] == 1){ echo $lang['store_ztc_glog_recordtype_add'];}else {echo $lang['store_ztc_glog_recordtype_reduce'];}?></td>
          <td><?php echo date('Y-m-d',$val['glog_addtime']);?></td>
          <td><?php echo $val['glog_desc'];?></td>
        </tr>
      </tbody>
      <?php } ?>
      <?php } else { ?>
      <tbody>
        <tr>
          <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
        </tr>
      </tbody>
      <?php } ?>
      <?php  if (count($output['list_log'])>0) { ?>
      <tfoot>
        <tr>
          <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
        </tr>
      </tfoot>
      <?php } ?> </table>
  </div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script language="javascript">
$(function(){
	$('#zg_stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#zg_etime').datepicker({dateFormat: 'yy-mm-dd'});
});
//var ztc_searchTxt = '商品名称';
var ztc_searchTxt = '<?php echo $lang['store_ztc_goodsname']; ?>';
function ztc_searchFocus(e){
	if(e.value == ztc_searchTxt){
		e.value='';
		$('#zg_name').css("color","");
	}
}
function ztc_searchBlur(e){
	if(e.value == ''){
		e.value=ztc_searchTxt;
		$('#zg_name').css("color","#999999");
	}
}
function ztc_searchInput() {
	if($('#zg_name').val()==ztc_searchTxt)
		$('#zg_name').attr("value","");
	return true;
}
</script> 
