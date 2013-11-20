<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <?php if(!$output['mansong_quota_flag']) { ?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=store_promotion_mansong&op=mansong_quota_add');" title="<?php echo $lang['mansong_quota_add'];?>"><?php echo $lang['mansong_quota_add'];?></a>
    <?php } else { ?>
    <a class="ncu-btn3"  href="index.php?act=store_promotion_mansong&op=mansong_add"><?php echo $lang['mansong_add'];?></a>
    <?php } ?>
  </div>
  <?php if(!$output['mansong_quota_flag']) { ?>
  <?php if(!$output['mansong_apply_flag']) { ?>
  <!-- 没有可用套餐，购买 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td colspan="20" class="norecord" style="padding: 50px 200px !important;"><i class="ms pngFix"></i><span style=" width: 350px;"><?php echo $lang['mansong_quota_current_error'];?></span></td>
      </tr>
    </tbody>
  </table>
  <?php } else { ?>
  <!-- 已购买，待审核 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td class="w300 tr"><i class="ms pnfFix mt20"></i></td>
        <td class="tl"><strong><?php echo $lang['mansong_quota_current_error2'];?></strong>
          <p><?php echo $lang['apply_date'].$lang['nc_colon'];?>
            <time><?php echo date('Y-m-d H:i:s',$output['mansong_apply']['apply_date']);?></time>
          </p>
          <p><?php echo $lang['apply_quantity'].$lang['nc_colon'].$output['mansong_apply']['apply_quantity'].$lang['apply_quantity_unit'];?></p></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <?php } else { ?>
  <!-- 有可用套餐，发布活动 -->
  <table class="ncu-table-style ncm-promotion-buy">
    <tbody>
      <tr>
        <td class="w120 tr"><strong><?php echo $lang['start_time'];?><?php echo $lang['nc_colon'];?></strong></td>
        <td class="w150 tl"><?php echo date('Y-m-d H:i:s',$output['current_mansong_quota']['start_time']);?></td>
        <td class="w120 tr"><strong><?php echo $lang['end_time'];?><?php echo $lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo date('Y-m-d H:i:s',$output['current_mansong_quota']['end_time']);?></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="20"></td>
      </tr>
    </tfoot>
  </table>
  <div class="ncm-notes">
    <h3> <?php echo $lang['nc_explain'].$lang['nc_colon'];?></h3>
    <ul>
      <li><?php echo $lang['mansong_explain1'];?></li>
    </ul>
  </div>
  <form method="get">
    <table class="search-form">
      <input type="hidden" name="act" value="store_promotion_mansong" />
      <input type="hidden" name="op" value="mansong_list" />
      <tr>
        <td>&nbsp;</td>
        <th class="w110"><?php echo $lang['mansong_name'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" class="text" name="mansong_name" value="<?php echo $_GET['mansong_name'];?>"/></td>
        <th><?php echo $lang['mansong_status'].$lang['nc_colon'];?></th>
        <td class="w100"><select name="state">
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
        <th class="tl"><?php echo $lang['mansong_name'];?></th>
        <th class="w180"><?php echo $lang['start_time'];?></th>
        <th class="w180"><?php echo $lang['end_time'];?></th>
        <th class="w90"><?php echo $lang['nc_state'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php //$count = count($output['list']) - 1;?>
    <?php foreach($output['list'] as $key=>$val){?>
    <tbody>
      <tr class="bd-line">
        <td></td>
        <td class="tl"><?php echo $val['mansong_name'];?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$val['start_time']);?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$val['end_time']);?></td>
        <td><?php echo $output['state_list'][$val['state']];?></td>
        <td><p><a href="index.php?act=store_promotion_mansong&op=mansong_detail&mansong_id=<?php echo $val['mansong_id'];?>"><?php echo $lang['nc_detail'];?></a></p>
          <?php if(intval($val['state']) !== intval($output['state_cancel'])) { ?>
          <p><a class="ncu-btn2 mt5" href="javascript:return void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_cancel'];?>', 'index.php?act=store_promotion_mansong&op=mansong_cancel&mansong_id=<?php echo $val['mansong_id'];?>');"><?php echo $lang['nc_cancel'];?></a></p>
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
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
    </tbody>
    <?php }?>
  </table>
  <?php } ?>
</div>
