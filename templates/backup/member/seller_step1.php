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
              <dd><?php echo $v['function_str']==''? $lang['nc_nothing']:$v['function_str'];?></dd></td>
            <td><dl>
                <dd><?php echo $v['sg_description']; ?></dd>
              </dl></td>
            <td class="w120"><a href="index.php?act=member_store&op=create&grade_id=<?php echo $v['sg_id']; ?>" class="ncu-btn4 w80 ml10"><?php echo $lang['store_create_create_now'];?></a></td>
          </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr><td colspan="20" class="tc"><a class="ncu-btn5" href="index.php?act=member_snsindex"><?php echo $lang['store_create_back'];?></a></td></tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
