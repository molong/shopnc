<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap-shadow">
  <div class="wrap-all">
    <div class="chart">
      <div class="pos_x1 bg_a2" title="<?php echo $lang['store_create_choose_store_class'];?>"></div>
      <div class="pos_x2 bg_b1" title="<?php echo $lang['store_create_input_owner_info'];?>"></div>
      <div class="pos_x3 bg_c" title="<?php echo $lang['store_create_finish'];?>"></div>
    </div>
    <div class="grade-shop">
      <table>
        <tbody>
          <?php foreach ($output['grade_list'] as $v) { ?>
          <tr>
            <th class="w100"><?php echo $v['sg_name']; ?></th>
            <td class="w150"><dl>
                <dt><?php echo $lang['store_create_goods_num'].$lang['nc_colon'];?></dt>
                <dd><?php echo $v['sg_goods_limit']; ?></dd>
              </dl>
              
              <!--<p><?php echo $lang['store_create_upload_space'];?>(MB):  <span class="fontColor1"><?php echo $v['sg_space_limit']; ?></span></p>-->
              
              <dl>
                <dt><?php echo $lang['store_create_template_num'].$lang['nc_colon'];?></dt>
                <dd><?php echo $v['sg_template_number']; ?></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['store_create_charge_standard'].$lang['nc_colon'];?></dt>
                <dd><?php echo $v['sg_price']; ?></dd>
              </dl>
              <dl>
                <dt><?php echo $lang['store_create_need_audit'].$lang['nc_colon'];?></dt>
                <dd>
                  <?php if ($v['sg_confirm'] == 1) echo $lang['store_create_yes']; else echo $lang['store_create_no']; ?>
                </dd>
              </dl></td>
            <td class="w120"><dl>
                <dt><?php echo $lang['store_create_additional_function'].$lang['nc_colon'];?></dt>
                <dd><?php echo $v['function_str'];?></dd>
              </dl></td>
            <td><dl>
                <dd><?php echo $v['sg_description']; ?></dd>
              </dl></td>
            <td class="w120 tc"><?php if ($output['store_info']['grade_id'] == $v['sg_id']) { 
                			echo '<h3>'.$lang['store_upgrade_cur_grade'].'</h3>'; 
                			}
                		elseif ($output['store_info']['sg_sort'] < $v['sg_sort']) { ?>
              <a href="javascript:void(0);" onclick="showDialog('<?php echo $lang['store_upgrade_tip'];?>', 'confirm', '', function(){ window.location = 'index.php?act=member_store&op=update_grade&grade_id=<?php echo $v['sg_id']; ?>';});"  class="ncu-btn4 w80 ml10"><?php echo $lang['store_upgrade_now'];?></a>
              <?php } ?></td>
          </tr>
          <?php } ?>
      </table>
    </div>
  </div>
</div>
