<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_points_set'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['pointssettings'];?></span></a></li>     
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
       
        <tr>
          <td class="" colspan="2"><table class="table tb-type2 nomargin">
              <thead>
                <tr class="space">
                  <th colspan="16"><?php echo $lang['points_ruletip']; ?>:</th>
                </tr>
                <tr class="thead">
                  <th><?php echo $lang['points_item']; ?></th>
                  <th><?php echo $lang['points_number']; ?></th>
                </tr>
              </thead>
              <tbody>
                <tr class="hover">
                  <td class="w200"><?php echo $lang['points_number_reg']; ?></td>
                  <td><input id="points_reg" name="points_reg" value="<?php echo $output['list_setting']['points_reg'];?>" class="txt" type="text" style="width:60px;"></td>
                </tr>
                <tr class="hover">
                  <td><?php echo $lang['points_number_login'];?></td>
                  <td><input id="points_login" name="points_login" value="<?php echo $output['list_setting']['points_login'];?>" class="txt" type="text" style="width:60px;"></td>
                </tr>
                <tr class="hover">
                  <td><?php echo $lang['points_number_comments']; ?></td>
                  <td><input id="points_comments" name="points_comments" value="<?php echo $output['list_setting']['points_comments'];?>" class="txt" type="text" style="width:60px;"></td>
                </tr>
              </tbody>
            </table>
            <table class="table tb-type2 nomargin">
              <thead>
                <tr class="thead">
                  <th colspan="2"><?php echo $lang['points_number_order']; ?></th>
                </tr>
              </thead>
              <tbody>
                <tr class="hover">
                  <td class="w200"><?php echo $lang['points_number_orderrate'];?></td>
                  <td><input id="points_orderrate" name="points_orderrate" value="<?php echo $output['list_setting']['points_orderrate'];?>" class="txt" type="text" style="width:60px;">
                    <?php echo $lang['points_number_orderrate_tip']; ?></td>
                </tr>
                <tr class="hover">
                  <td><?php echo $lang['points_number_ordermax']; ?></td>
                  <td><input id="points_ordermax" name="points_ordermax" value="<?php echo $output['list_setting']['points_ordermax'];?>" class="txt" type="text" style="width:60px;">
                    <?php echo $lang['points_number_ordermax_tip'];?></td>
                </tr>
              </tbody>
            </table></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
