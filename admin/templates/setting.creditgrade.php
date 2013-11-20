<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=setting&op=base_information"><span><?php echo $lang['basic_info'];?></span></a></li>
        <li><a href="index.php?act=setting&op=captcha_setting"><span><?php echo $lang['manage_about'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['setting_store_creditrule'];?></span></a></li>
        <li><a href="index.php?act=setting&op=ucenter_setting"><span><?php echo $lang['ucenter_integration'];?></span></a></li>
        <li><a href="index.php?act=setting&op=qq_setting"><span><?php echo $lang['qqSettings'];?></span></a></li>
        <li><a href="index.php?act=setting&op=sina_setting"><span><?php echo $lang['sinaSettings'];?></span></a></li>
        <li><a href="index.php?act=setting&op=login_setting"><span><?php echo $lang['loginSettings'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" id="form_email" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />          
    <table class="table tb-type2 nomargin">
        <thead>
          <!-- <tr class="space">
            <th colspan="16"><?php echo $lang['setting_store_creditrule']; ?></th>
          </tr> -->
          <tr class="thead">
            <th><?php echo $lang['setting_store_creditrule_grade']; ?></th>
            <th><?php echo $lang['setting_store_creditrule_gradenum']; ?></th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i=1;$i<=5;$i++){?>
          <tr class="hover">
            <td class="w200"><span class="heart level-<?php echo $i;?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"/></span></td>
            <td><input name="credit[heart][<?php echo $i;?>][0]" type="text" class="txt" value="<?php echo $output['list_setting']['creditrule_arr']['heart'][$i][0];?>" style=" width:60px;" >
              -&nbsp;&nbsp;
              <input name="credit[heart][<?php echo $i;?>][1]" value="<?php echo $output['list_setting']['creditrule_arr']['heart'][$i][1];?>" class="txt" type="text" style=" width:60px;" ></td>
          </tr>
          <?php }?>
          <?php for ($i=1;$i<=5;$i++){?>
          <tr class="hover">
            <td><span class="diamond level-<?php echo $i;?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"/></span></td>
            <td><input name="credit[diamond][<?php echo $i;?>][0]" value="<?php echo $output['list_setting']['creditrule_arr']['diamond'][$i][0];?>" class="txt" type="text" style=" width:60px;" >
              -&nbsp;&nbsp;
              <input name="credit[diamond][<?php echo $i;?>][1]" value="<?php echo $output['list_setting']['creditrule_arr']['diamond'][$i][1];?>" class="txt" type="text" style=" width:60px;" ></td>
          </tr>
          <?php }?>
          <?php for ($i=1;$i<=5;$i++){?>
          <tr class="hover">
            <td><span class="crown level-<?php echo $i;?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"/></span></td>
            <td><input name="credit[crown][<?php echo $i;?>][0]" value="<?php echo $output['list_setting']['creditrule_arr']['crown'][$i][0];?>" class="txt" type="text" style=" width:60px;" >
              -&nbsp;&nbsp;
              <input name="credit[crown][<?php echo $i;?>][1]" value="<?php echo $output['list_setting']['creditrule_arr']['crown'][$i][1];?>" class="txt" type="text" style=" width:60px;" ></td>
          </tr>
          <?php }?>
        </tbody>
        <tfoot>
	    <tr class="tfoot">
	      <td colspan="2"><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
	    </tr>
	  </tfoot>
 	</table>
 </form>
</div>
