<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="POST" id='express_form' action="index.php?act=deliver&op=express" onsubmit="ajaxpost('express_form', '', '', 'onerror');return false;">
    <input value="ok" name="form_submit" type="hidden">
    <table class="ncu-table-style" >
      <thead>
        <tr>
          <th class="w20"></th>
          <th colspan="4" class="tm"><?php echo $lang['store_deliver_express_title'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['express_list']) && is_array($output['express_list'])){?>
        <tr class="bd-line">
          <td></td>
          <?php $i = 1;?>
          <?php foreach($output['express_list'] as $key=>$value){?>
          <td class="tl"><label>
              <input type="checkbox" name="cexpress[]" <?php if (in_array($key,$output['express_select'])) echo 'checked';?> value="<?php echo $key;?>">
              <?php echo $value['e_name'];?></label></td>
          <?php if ($i%4 == 0){?>
        </tr>
        <tr>
          <td></td>
          <?php };$i++;?>
          <?php }?>
        </tr>
        <?php }else{?>
        <tr>
          <td colspan="5" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="5"><input class="submit pngFix ml20 mt10" type="submit" value="<?php echo $lang['nc_common_button_save'];?>"></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
