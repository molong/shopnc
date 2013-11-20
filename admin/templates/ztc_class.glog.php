<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_ztc_manage'];?></h3>
      <ul class="tab-base">
      	<li><a href="index.php?act=ztc_class&op=ztc_setting"><span><?php echo $lang['nc_config'];?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_class" ><span><?php echo $lang['admin_ztc_list_title'];?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glist" ><span><?php echo $lang['admin_ztc_goodslist_title'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_ztc_loglist_title']; //'金币日志';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="ztc_class">
    <input type="hidden" name="op" value="ztc_glog">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="zg_name"><?php echo $lang['admin_ztc_goodsname']; ?><!-- 商品名称 --></label></th>
          <td><input type="text" name="zg_name" id="zg_name" class="txt" value='<?php echo $_GET['zg_name'];?>'></td>
          <th><label for="zg_sname"><?php echo $lang['admin_ztc_storename']; ?><!-- 店铺名称 --></label></th>
          <td><input type="text" name="zg_sname" id="zg_sname" class="txt-short" value='<?php echo $_GET['zg_sname'];?>'></td>
          <th><label for="zg_stime"><?php echo $lang['admin_ztc_addtime']; ?><!-- 添加时间 --></label></th>
          <td><input type="text" id="zg_stime" name="zg_stime" class="txt date" value="<?php echo $_GET['zg_stime'];?>" >
            <label for="zg_etime"><?php echo $lang['admin_ztc_addtime_to']; ?><!-- 至 --></label>
            <input type="text" id="zg_etime" name="zg_etime" class="txt date" value="<?php echo $_GET['zg_etime'];?>" ></td>
          <td><select name="zg_type">
              <option value="0" <?php if (!$_GET['zg_type']){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_glog_recordtype']; ?><!-- 类型 --></option>
              <option value="1" <?php if ($_GET['zg_type'] == 1){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_glog_recordtype_add']; ?><!-- 增加 --></option>
              <option value="2" <?php if ($_GET['zg_type'] == 2){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_glog_recordtype_reduce']; ?><!-- 减少 --></option>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_ztc" action="index.php">
    <input type="hidden" id="list_act" name="act" value="ztc_class">
    <input type="hidden" id="list_op" name="op" value="dropall_ztc">
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w32"><?php echo $lang['admin_ztc_list_number']; ?><!-- 序号 --></th>
          <th><?php echo $lang['admin_ztc_goodsname']?><!-- 商品名称 --></th>
          <th><?php echo $lang['admin_ztc_storename']; ?><!-- 店铺名称 --></th>
          <th><?php echo $lang['admin_ztc_membername']; ?><!-- 会员名称 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_glog_list_goldnum']; ?><!-- 金币数量(枚) --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_addtime']; ?><!-- 添加时间 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_glog_recordtype']; ?><!-- 类型 --></th>
          <th><?php echo $lang['admin_ztc_glog_list_desc']; ?><!-- 描述 --></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list_log']) && is_array($output['list_log'])){ ?>
        <?php foreach($output['list_log'] as $k => $v){?>
        <tr class="hover">
          <td><?php echo $v['glog_id']; ?></td>
          <td><a href="<?php echo SiteUrl;?>/index.php?act=goods&goods_id=<?php echo $v['glog_goodsid'];?>" target="_blank" ><?php echo $v['glog_goodsname'];?></a></td>
          <td><?php echo $v['glog_storename'];?></td>
          <td><?php echo $v['glog_membername'];?></td>
          <td class="align-center"><?php echo $v['glog_goldnum'];?></td>
          <td class="nowarp align-center"><?php echo date('Y-m-d',$v['glog_addtime']);?></td>
          <td class="align-center"><?php if ($v['glog_type'] == 1){ echo $lang['admin_ztc_glog_recordtype_add'];}else {echo $lang['admin_ztc_glog_recordtype_reduce'];}?></td>
          <td><?php echo $v['glog_desc'];?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="16"><div class="pagination"><?php echo $output['show_page'];?></div></td>
        </tr>
      </tfoot>
    </table>
    <div class="clear"></div>
  </form>
</div>
<script language="javascript">
$(function(){
	$('#zg_stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#zg_etime').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>