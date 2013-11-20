<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=store_promotion_xianshi&op=xianshi_add');" title="<?php echo $lang['nc_new'];?>"><?php echo $lang['xianshi_add'];?></a> </div>
  <form method="get">
    <table class="search-form">
      <input type="hidden" name="act" value="store_promotion_xianshi" />
      <input type="hidden" name="op" value="xianshi_list" />
      
      <tr><td></td>
        <td class="w150"><input type="text" class="text" name="xianshi_name" value="<?php echo $_GET['xianshi_name'];?>"/></td>
        <td class="w100 tr"><select name="state">
            <?php if(is_array($output['state_list'])) { ?>
            <?php foreach($output['state_list'] as $key=>$val) { ?>
            <option value="<?php echo $key;?>" <?php if(intval($key) === intval($_GET['state'])) echo 'selected';?>><?php echo $val;?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        <td class="w90 tc"><input type="submit " class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th><?php echo $lang['xianshi_name'];?></th>
        <th><?php echo $lang['start_time'];?></th>
        <th><?php echo $lang['end_time'];?></th>
        <th><?php echo $lang['xianshi_discount'];?></th>
        <th><?php echo $lang['xianshi_buy_limit'];?></th>
        <th><?php echo $lang['nc_state'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php if(!empty($output['list']) && is_array($output['list'])){?>
    <tbody>
      <?php foreach($output['list'] as $key=>$val){?>
      <tr class="bd-line">
        <td><?php echo $val['xianshi_name'];?></td>
        <td><?php echo date("Y-m-d",$val['start_time']);?></td>
        <td><?php echo date("Y-m-d",$val['end_time']);?></td>
        <td><?php echo $val['discount'];?></td>
        <td><?php echo $val['buy_limit'];?></td>
        <td><?php echo $output['state_list'][$val['state']];?></td>
        <td><a class="edit" href="index.php?act=store_promotion_xianshi&op=xianshi_manage&xianshi_id=<?php echo $val['xianshi_id'];?>"><?php echo $lang['nc_manage'];?></a></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td class="norecord" colspan="16"><?php echo $lang['no_record'];?></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="16"> <div class="pagination"> <?php echo $output['show_page']; ?> </div>
        </th>
      </tr>
    </tfoot>
  </table>
</div>
</div>
