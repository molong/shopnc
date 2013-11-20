<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <?php if(!$output['xianshi_quota_flag']) { ?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=store_promotion_xianshi&op=xianshi_quota_add');" title="<?php echo $lang['xianshi_quota_add'];?>"><?php echo $lang['xianshi_quota_add'];?></a>
    <?php } else { ?>
    <a class="ncu-btn3" href="index.php?act=store_promotion_xianshi&op=xianshi_add"><?php echo $lang['xianshi_add'];?></a>
    <?php } ?>
  </div>
  <?php if(!$output['xianshi_quota_flag']) { ?>
  <?php if(!$output['xianshi_apply_flag']) { ?>
  <!-- 没有套餐，限时购买套餐按钮 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td colspan="20" class="norecord" style="padding: 50px 120px !important;"><i class="xs pngFix"></i><span style=" width:500px; line-height: 24px;"><?php echo $lang['xianshi_quota_current_error1'];?></span></td>
      </tr>
    </tbody>
  </table>
  <?php } else { ?>
  <!-- 已购买套餐待审核 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td class="w200 tr"><i class="xs pnfFix mt20"></i></td>
        <td class="tl"><strong><?php echo $lang['xianshi_quota_current_error2'];?></strong>
          <p><?php echo $lang['apply_date'].$lang['nc_colon'];?>
            <time><?php echo date('Y-m-d H:i:s',$output['xianshi_apply']['apply_date']);?></time>
            </time>
          </p>
          <p><?php echo $lang['apply_quantity'].$lang['nc_colon'].$output['xianshi_apply']['apply_quantity'].$lang['apply_quantity_unit'];?></p></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <?php } else { ?>
  <?php if($output['current_publish_flag']) { ?>
  <!-- 可发布活动 -->
  <table class="ncu-table-style">
    <tbody>
      <tr>
        <td class="w100 tr"><strong><?php echo $lang['start_time'].$lang['nc_colon'];?></strong></td>
        <td class="w150 tl"><?php echo date('Y-m-d H:s:i',$output['xianshi_quota_info']['start_time']);?></td>
        <td class="w100 tr"><strong><?php echo $lang['end_time'].$lang['nc_colon'];?></strong></td>
        <td class="w150 tl"><?php echo date('Y-m-d H:s:i',$output['xianshi_quota_info']['end_time']);?></td>
        <td class="w100 tr"><strong><?php echo $lang['xianshi_quota_times_limit'].$lang['nc_colon'];?></strong></td>
        <td class="w150 tl"><?php echo $output['xianshi_quota_info']['times_limit'];?></td>
      </tr>
      <tr>
        <td class="tr"><strong><?php echo $lang['xianshi_quota_times_published'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['xianshi_quota_info']['published_times'];?></td>
        <td class="tr"><strong><?php echo $lang['xianshi_quota_times_publish'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['remain_times'];?></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="20"></td>
      </tr>
    </tfoot>
  </table>
  <?php } else {?>
  <!-- 套餐已用完 -->
  <p><?php echo $lang['xianshi_quota_current_error3'];?></p>
  <?php } ?>
  <form method="get">
    <table class="search-form">
      <input type="hidden" name="act" value="store_promotion_xianshi" />
      <input type="hidden" name="op" value="xianshi_list" />
      <tr>
        <td>&nbsp;</td>
        <th class="w110"><?php echo $lang['xianshi_name'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" class="text" name="xianshi_name" value="<?php echo $_GET['xianshi_name'];?>"/></td>
        <th><?php echo $lang['xianshi_active_status'].$lang['nc_colon'];?></th>
        <td class="w100"><select name="state" class="w90">
            <?php if(is_array($output['state_list'])) { ?>
            <?php foreach($output['state_list'] as $key=>$val) { ?>
            <option value="<?php echo $key;?>" <?php if(intval($key) === intval($_GET['state'])) echo 'selected';?>><?php echo $val;?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <?php if(!empty($output['list']) && is_array($output['list'])){?>
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="tl"><?php echo $lang['xianshi_name'];?></th>
        <th class="w180"><?php echo $lang['start_time'];?></th>
        <th class="w180"><?php echo $lang['end_time'];?></th>
        <th class="w90"><?php echo $lang['xianshi_discount'];?></th>
        <th class="w90"><?php echo $lang['nc_state'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php $count = count($output['list']) - 1;?>
    <?php foreach($output['list'] as $key=>$val){?>
    <tbody>
      <tr class="bd-line">
        <td></td>
        <td class="tl"><?php echo $val['xianshi_name'];?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$val['start_time']);?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$val['end_time']);?></td>
        <td class="goods-price"><?php echo ncPriceFormat($val['discount']);?><?php echo $lang['nc_xianshi_flag'];?></td>
        <td><?php echo $output['state_list'][$val['state']];?></td>
        <td><a href="index.php?act=store_promotion_xianshi&op=xianshi_manage&xianshi_id=<?php echo $val['xianshi_id'];?>"><?php echo $lang['nc_manage'];?></a>
          <?php if(intval($val['state']) === intval($output['state_published'])) { ?>
          <a class="ncu-btn2 mt5" href="javascript:if(confirm('<?php echo $lang['nc_ensure_cancel'];?>'))window.location = 'index.php?act=store_promotion_xianshi&op=xianshi_cancel&xianshi_id=<?php echo $val['xianshi_id'];?>';"><?php echo $lang['nc_cancel'];?></a>
          <?php } ?></td>
      </tr>
    </tbody>
    <?php }?>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php }else{?>
    <tbody>
      <tr>
        <td class="norecord" colspan="16"><i></i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    </tbody>
    <?php }?>
  </table>
</div>
<?php } ?>
<!-- 历史记录查看 --> 
<!--<a class="btn" href="index.php?act=store_promotion_xianshi&op=xianshi_apply_list"><?php echo $lang['xianshi_apply'];?></a>-->

</div>
