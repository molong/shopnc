<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <a href="javascript:void(0)" class="ncu-btn3" onclick="go('index.php?act=store_groupbuy&op=groupbuy_add');" title="<?php echo $lang['groupbuy_index_new_group'];?>"><?php echo $lang['groupbuy_index_new_group'];?></a></div>
  <table class="search-form">
    <form method="get">
      <input type="hidden" name="act" value="store_groupbuy" />
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['group_name'].$lang['nc_colon'];?></th>
        <td class="w160"><input class="text" type="text" name="group_name" value="<?php echo $_GET['group_name'];?>"/></td>
        <th><?php echo $lang['groupbuy_index_activity_state'].$lang['nc_colon'];?></th>
        <td class="w100"><select name="groupbuy_state" class="w90">
            <?php if(is_array($output['state_list'])) { ?>
            <?php foreach($output['state_list'] as $key=>$val) { ?>
            <option value="<?php echo $key;?>" <?php if($key == $_GET['groupbuy_state']) { echo 'selected';}?>><?php echo $val;?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </form>
  </table>
  <table class="ncu-table-style">
    <thead>
      <tr><th class="w10"></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['group_name'];?></th>
        <th class="w200"><?php echo $lang['group_template'];?></th>
        <th class="w90"><?php echo $lang['groupbuy_index_group_num'];?></th>
        <th class="w90"><?php echo $lang['groupbuy_index_activity_state'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php if(!empty($output['group']) && is_array($output['group'])){?>
    <?php foreach($output['group'] as $key=>$group){?>
    <tbody>
      <tr class="bd-line"><td></td>
        <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$group['group_id'],'id'=>$group['store_id']), 'groupbuy');?>" target="_blank"><img src="<?php echo SiteUrl.'/upload/groupbuy/'.$group['group_pic'];?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td class="tl"><dl class="goods-name">
        <dt><a target="_blank" href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$group['group_id'],'id'=>$group['store_id']), 'groupbuy');?>"><?php echo $group['group_name'];?></a></dt></dl></td>
        <td><strong><?php echo $group['template_name'];?></strong>
        <p class="goods-time"><?php echo date('Y-m-d',$group['start_time']);?>~<?php echo date('Y-m-d',$group['end_time']);?></p></td>
        <td><?php echo $group['def_quantity'];?></td>
        <td><?php $group_state = $group['state']; echo $output['state_list'][$group_state]; ?></td>
        <td><?php if($group['state'] == '1' || $group['state'] == '4'){?>
          <a href="index.php?act=store_groupbuy&op=groupbuy_edit&group_id=<?php echo $group['group_id'];?>"><?php echo $lang['group_edit'];?></a> <a href="javascript:void(0);" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>','index.php?act=store_groupbuy&op=groupbuy_drop&group_id=<?php echo $group['group_id'];?>')" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a>
          <?php }?></td>
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
</div>