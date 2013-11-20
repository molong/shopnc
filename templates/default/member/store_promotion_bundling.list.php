<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <?php if(!$output['bundling_quota_flag']) { ?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=store_promotion_bundling&op=bundling_quota_add');" title="<?php echo $lang['bundling_quota_add'];?>"><?php echo $lang['bundling_quota_add'];?></a>
    <?php } else if((isset($output['bundling_surplus']) && intval($output['bundling_surplus']) != 0 ) || C('promotion_bundling_sum') == 0) { ?>
    <a class="ncu-btn3"  href="index.php?act=store_promotion_bundling&op=bundling_add"><?php echo $lang['bundling_add'];?></a>
    <?php } ?>
  </div>
  <?php if($output['bundling_quota_flag']) { ?>
  <!-- 有可用套餐，发布活动 -->
  <table class="ncu-table-style">
    <tbody>
      <tr>
        <td class="w150 tr"><strong><?php echo $lang['bundling_start_time'].$lang['nc_colon'];?></strong></td>
        <td class="w120 tl"><?php echo date('Y-m-d H:i:s',$output['bundling_quota']['bl_quota_starttime']);?></td>
        <td class="w120 tr"><strong><?php echo $lang['bundling_end_time'].$lang['nc_colon'];?></strong></td>
        <td class="w150 tl"><?php echo date('Y-m-d H:i:s',$output['bundling_quota']['bl_quota_endtime']);?></td>
        <td class="w150 tr"><strong><?php echo $lang['bundling_published'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['bundling_published'];?></td>
      </tr>
      <?php if(intval(C('promotion_bundling_sum')) != 0){?>
      <tr>
        <td class="tr"><strong><?php echo $lang['bundling_surplus'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['bundling_surplus'];?></td>
        <td colspan="20"></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="20"></td>
      </tr>
    </tfoot>
  </table>
  <form method="get">
    <input type="hidden" name="act" value="store_promotion_bundling" />
    <input type="hidden" name="op" value="bundling_list" />
    <table class="search-form">
      <tr>
        <td>&nbsp;</td>
        <th class="w110"><?php echo $lang['bundling_name'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" class="text" name="bundling_name" value="<?php echo $output['bundling_name'];?>"/></td>
        <th><?php echo $lang['bundling_status'].$lang['nc_colon'];?></th>
        <td class="w100"><select name="state">
            <option value='all'><?php echo $lang['bundling_status_all'];?></option>
            <option value='0' <?php if(isset($output['state']) && $output['state'] == 0){?>selected="selected"<?php }?>><?php echo $lang['bundling_status_0'];?></option>
            <option value='1' <?php if(isset($output['state']) && $output['state'] == 1){?>selected="selected"<?php }?>><?php echo $lang['bundling_status_1'];?></option>
          </select></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <?php if(empty($output['list'])) { ?>
  <!-- 没有添加活动 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td colspan="20" class="norecord" style="padding: 50px 200px !important;"><i></i><span style=" width: 350px;"><?php echo $lang['bundling_list_null'];?></span></td>
      </tr>
    </tbody>
  </table>
  <?php } else { ?>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w70"></th>
        <th class="tl w340"><?php echo $lang['bundling_name'];?></th>
        <th class="w180"><?php echo $lang['bundling_add_price'];?></th>
        <th class="w180"><?php echo $lang['bundling_list_goods_count'];?></th>
        <th class="w90"><?php echo $lang['nc_state'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <tr>
        <td class="w30 tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="20"><label for="all" ><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_promotion_bundling&op=drop_bundling" name="bundling_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
    </thead>
    <?php foreach($output['list'] as $key=>$val){?>
    <tbody>
      <tr class="bd-line">
        <td><input type="checkbox" class="checkitem tc" value="<?php echo $val['bl_id'];?>"/></td>
        <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=bundling&bundling_id=<?php echo $val['bl_id'];?>&id=<?php echo $val['store_id'];?>" target="black"><img src="<?php echo $val['img'];?>"  onload="javascript:DrawImage(this,60,60);"/></a></span></div></td>
        <td class="tl w340"><a href="index.php?act=bundling&bundling_id=<?php echo $val['bl_id'];?>&id=<?php echo $val['store_id'];?>" target="black"><?php echo $val['bl_name'];?></a></td>
        <td class="goods-price"><?php echo $val['bl_discount_price'];?></td>
        <td class=""><?php echo $val['count'];?></td>
        <td><?php echo $output['state_array'][$val['bl_state']];?></td>
        <td class='tc'><a href="index.php?act=store_promotion_bundling&op=bundling_add&bundling_id=<?php echo $val['bl_id'];?>"><?php echo $lang['bundling_edit'];?></a><br /><a class="ncu-btn2 mt5" href='index.php?act=store_promotion_bundling&op=drop_bundling&bundling_id=<?php echo $val['bl_id'];?>'><?php echo $lang['nc_del'];?></a></td>
      </tr>
    </tbody>
    <?php }?>
    <tfoot>
      <tr>
        <td class="w30 tc"><input type="checkbox" id="all" class="checkall"/></td>
        <td colspan="20"><label for="all" ><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_promotion_bundling&op=drop_bundling" name="bundling_id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
  </table>
  <?php } ?>
  <?php }else{?>
  <!-- 没有可用套餐，购买 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td colspan="20" class="norecord" style="padding: 50px 200px !important;"><i></i><span style=" width: 350px;"><?php echo $lang['bundling_quota_current_error'];?></span></td>
      </tr>
    </tbody>
  </table>
  <?php }?>
</div>
