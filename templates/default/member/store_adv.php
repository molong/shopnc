<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="post" id="store_form" action="index.php?act=store_adv&op=adv_del">
    <table class="ncu-table-style">
      <thead>
        <tr>
          <th><?php echo $lang['adv_title_nocolon']; ?></th>
          <th class="w150"><?php echo $lang['adv_ap_name_nocolon']; ?></th>
          <th class="w90"><?php echo $lang['adv_style_nocolon']; ?></th>
          <th class="w100"><?php echo $lang['adv_start_date_nocolon']; ?></th>
          <th class="w100"><?php echo $lang['adv_end_date_nocolon']; ?></th>
          <th class="w80"><a href="index.php?act=store_adv&op=adv_manage&order=clicknum"><?php echo $lang['adv_click_num']; ?></a></th>
          <th class="w80"><?php echo $lang['adv_check_state']; ?></th>
          <th class="w90"><?php echo $lang['ap_option']; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ foreach ($output['list'] as $k=>$v){ ?>
        <tr class="bd-line">
          <td title="<?php echo $v['adv_title'];?>"><?php echo str_cut($v['adv_title'],'16'); ?></td>
          <?php foreach ($output['ap_list'] as $ap_k=>$ap_v){ if($v['ap_id'] == $ap_v['ap_id']){ $display = $ap_v['ap_display']; ?>
          <td title="<?php echo $ap_v['ap_name'];?>"><?php echo str_cut($ap_v['ap_name'],'18'); ?></td>
          <td><?php
        switch ($ap_v['ap_class']){
        	case '0':
        		echo $lang['ap_pic'];
        		break;
        	case '1':
        		echo $lang['ap_word'];
        		break;
        	case '2':
        		echo $lang['ap_slide'];
        		break;
        	case '3':
        		echo "Flash";
        		break;
        }
        ?></td>
          <?php }} ?>
          <td class="goods-time"><?php echo date('Y-m-d',$v['adv_start_date']); ?></td>
          <td class="goods-time"><?php echo date('Y-m-d',$v['adv_end_date']); ?></td>
          <td><a href="index.php?act=store_adv&op=adv_click_chart&adv_id=<?php echo $v['adv_id']; ?>"><?php echo $v['click_num']; ?></a></td>
          <td><?php
       switch ($v['is_allow']){
       	case '0':
       		echo "<span style='color:red'>".$lang['adv_not_check']."</span>";
       		break;
       	case '1':
       		echo "<span style='color:green'>".$lang['adv_check_yes']."</span>";
       		break;
       	case '2':
       		echo "<span style='color:red'>".$lang['adv_check_no']."</span>";
       		break;
       }
       ?></td>
          <td><?php if($v['is_allow'] == '1' || $v['is_allow'] == '3'){ ?>
            <p><a href="index.php?act=store_adv&op=adv_edit&adv_id=<?php echo $v['adv_id'];?>"><?php echo $lang['adv_info_change']; ?></a></p>
            <?php }?>
            <?php } if($v['is_allow'] == '1'&&$display != '2'){ ?>
            <p><a href="index.php?act=store_adv&op=adv_addtime&adv_id=<?php echo $v['adv_id'];?>" class="ncu-btn2 mt5"><?php echo $lang['adv_add_time_s']; ?></a></p>
            <?php } ?>
            <?php if($v['is_allow'] == '0'||$v['is_allow'] == '2'){ ?>
            <p><a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=store_adv&op=adv_del&adv_id=<?php echo $v['adv_id'];?>';" class="ncu-btn2 mt5"><?php echo $lang['nc_del_&nbsp'];?></a></p>
            <?php } ?></td>
        </tr>
        <?php }else{ ?>
        <tr>
          <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record']; ?></span></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
