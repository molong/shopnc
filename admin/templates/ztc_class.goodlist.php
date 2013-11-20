<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_ztc_manage'];?><!-- 直通车管理 --></h3>
      <ul class="tab-base">
      	<li><a href="index.php?act=ztc_class&op=ztc_setting"><span><?php echo $lang['nc_config'];?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_class" ><span><?php echo $lang['admin_ztc_list_title'];?><!-- 申请列表 --></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_ztc_goodslist_title']; //'商品列表'?></span></a></li>
        <li><a href="index.php?act=ztc_class&op=ztc_glog" ><span><?php echo $lang['admin_ztc_loglist_title']; //'金币日志';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="ztc_class">
    <input type="hidden" name="op" value="ztc_glist">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="zg_name"><?php echo $lang['admin_ztc_goodsname']; ?><!-- 商品名称 --></label></th>
          <td><input type="text" name="zg_name" id="zg_name" class="txt" value='<?php echo $_GET['zg_name'];?>'></td>
          <th><label for="zg_sname"><?php echo $lang['admin_ztc_storename']; ?><!-- 店铺名称 --></label></th>
          <td><input type="text" name="zg_sname" id="zg_sname" class="txt-short" value='<?php echo $_GET['zg_sname'];?>'></td>
          <td><select name="goods_type">
              <option value="0" <?php if (!$_GET['goods_type']){echo 'selected=selected';}?>><?php echo $lang['admin_ztc_state']?><!-- 状态 --></option>
              <option value="goods_open" <?php if($_GET['goods_type'] == 'goods_open') { ?>selected="selected"<?php } ?>><?php echo $lang['admin_ztc_glist_goodsshow']; ?><!-- 上架 --></option>
              <option value="goods_close" <?php if($_GET['goods_type'] == 'goods_close') { ?>selected="selected"<?php } ?>><?php echo $lang['admin_ztc_glist_goodsunshow']; ?><!-- 下架 --></option>
              <option value="goods_ban" <?php if($_GET['goods_type'] == 'goods_ban') { ?>selected="selected"<?php } ?>><?php echo $lang['admin_ztc_glist_goodslock']; ?><!-- 禁售 --></option>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_ztc" action="index.php">
    <input type="hidden" id="list_act" name="act" value="ztc_class">
    <input type="hidden" id="list_op" name="op" value="">
    <table class="table tb-type2">
      <thead>       
        <tr class="thead">
          <th class="w24"></th>
          <th colspan="2" class="w60"><?php echo $lang['admin_ztc_goodsname']; ?><!-- 商品名称 --></th>
          <th><?php echo $lang['admin_ztc_membername']; ?><!-- 会员名称 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_glist_goldresidue']; ?><!-- 剩余金币(枚) --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_starttime']; ?><!-- 开始时间 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_glist_goodsshow']; ?><!-- 上架 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_glist_goodslock']; ?><!-- 禁售 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_glist_goodsclick']; ?><!-- 浏览数 --></th>
          <th class="align-center"><?php echo $lang['admin_ztc_gstate_ztc']; ?><!-- 直通车 --></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list_goods']) && is_array($output['list_goods'])){ ?>
        <?php foreach($output['list_goods'] as $k => $v){?>
        <tr class="hover">
          <td><input type="checkbox" name="gid[]" value="<?php echo $v['goods_id'];?>" class="checkitem"></td>
          <td class="w48"><div class="goods-picture"><span class="thumb size-goods"><i></i><a href="<?php echo SiteUrl;?>/index.php?act=goods&goods_id=<?php echo $v['goods_id']; ?>" target="_blank"><img src="<?php echo thumb($v,'tiny');?>" onload="javascript:DrawImage(this,44,44);"/></a></span></div></td>
          <td><p><a href="<?php echo SiteUrl;?>/index.php?act=goods&goods_id=<?php echo $v['goods_id'];?>" target="_blank" ><?php echo $v['goods_name'];?></a></p>
            <p class="store"><?php echo $lang['admin_ztc_storename']; ?>:<?php echo $v['store_name'];?></p></td>
          <td><?php echo $v['member_name'];?></td>
          <td class="align-center"><?php echo $v['goods_goldnum'];?></td>
          <td class="nowarp align-center"><?php echo date('Y-m-d',$v['goods_ztcstartdate']);?></td>
          <td class="align-center"><?php if($v['goods_show'] == '0') { echo $lang['admin_ztc_glist_goodsshow_no']; }else { echo $lang['admin_ztc_glist_goodsshow_yes'];}?></td>
          <td class="align-center"><?php if($v['goods_state'] == '0'){ echo $lang['admin_ztc_glist_goodslock_yes']; }else { echo $lang['admin_ztc_glist_goodslock_no'];}?></td>
          <td class="align-center"><?php echo $v['goods_click'];?></td>
          <td class="align-center"><?php if ($v['goods_ztcstate'] == '1'){ echo $lang['admin_ztc_gstate_ztcstate_open'];} else {echo $lang['admin_ztc_gstate_ztcstate_close'];}?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16" id="batchAction"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;
            <select name='type'>
              <option value='open'><?php echo $lang['admin_ztc_gstate_ztcstate_open']; ?></option>
              <option value='close'><?php echo $lang['admin_ztc_gstate_ztcstate_close']; ?></option>
            </select>
            <a href="JavaScript:void(0);" class="btn" onclick="submit_form('ztc_gstate');"><span><?php echo $lang['nc_submit']?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
function submit_form(op){
	$('#list_op').val(op);
	$('#form_ztc').submit();
}
</script>