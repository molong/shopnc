<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style order">
    <thead>
      <tr>
        <th class="w30"></th>
        <th><?php echo $lang['store_consult_reply'];?></th>
        <th class="w30"></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
      <?php if (count($output['list_consult'])>0) { ?>
      <tr>
        <td class="tc"><input id="all" type="checkbox" class="checkall" /></td>
        <td colspan="20"><label for="all"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_consult&op=drop_consult" name="id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a></td>
      </tr>
      <?php }?>
    </thead>
    <tbody>
      <?php if (count($output['list_consult'])>0) { ?>
      <?php foreach($output['list_consult'] as $consult){?>
      <tr>
        <td colspan="19" class="sep-row"></td>
      </tr>
      <tr>
        <th colspan="20" class="tl"><input type="checkbox"  value="<?php echo $consult['consult_id'];?>" class="checkitem ml10 mr10" />
          <span><a href="index.php?act=goods&goods_id=<?php echo $consult['goods_id'];?>" target="_blank"><?php echo $consult['cgoods_name'];?></a></span><span class="ml20"><?php echo $lang['store_consult_list_consult_member'].$lang['nc_colon'];?></span>
          <?php if($consult['member_id'] == "0"){ echo $lang['nc_guest']; } else { echo $consult['isanonymous'] == 1?str_cut($consult['cmember_name'],2).'***':$consult['cmember_name']; }?>
          <span class="ml20"><?php echo $lang['store_consult_list_consult_time'].$lang['nc_colon'];?><em class="goods-time"><?php echo date("Y-m-d H:i:s",$consult['consult_addtime']);?></em></span></th>
      </tr>
      <tr>
        <td class="bdl w30"></td>
        <td class="tl"><strong><?php echo $lang['store_consult_list_consult_content'].$lang['nc_colon'];?></strong><span class="gray"><?php echo nl2br($consult['consult_content']);?></span></td>
        <td></td>
        <td rowspan="
		<?php if($consult['consult_reply'] == ''){?>1<?php }else{?>2<?php }?>" class="bdl bdr"><?php if($consult['consult_reply'] == ''){?>
          <p><a href="javascript:void(0);" class="edit" nc_type="dialog" dialog_id="my_qa_reply" dialog_title="<?php echo $lang['store_consult_list_reply_consult'];?>" dialog_width="460" uri="index.php?act=store_consult&op=reply_consult&id=<?php echo $consult['consult_id'];?>"><?php echo $lang['store_consult_list_reply'];?></a></p>
          <?php }else{?>
          <p><a href="javascript:void(0);" class="edit" nc_type="dialog" dialog_id="my_qa_edit_reply" dialog_title="<?php echo $lang['store_consult_list_reply_consult'];?>" dialog_width="480" uri="index.php?act=store_consult&op=reply_consult&id=<?php echo $consult['consult_id'];?>"><?php echo $lang['store_consult_list_edit_reply'];?></a></p>
          <?php }?>
          <p> <a href="javascript:void(0)" onclick="ajax_get_confirm('<?php echo $lang['nc_ensure_del'];?>', 'index.php?act=store_consult&op=drop_consult&id=<?php echo $consult['consult_id'];?>');" class="ncu-btn2 mt5"><?php echo $lang['nc_del'];?></a> </p></td>
      </tr>
      <?php if($consult['consult_reply']!=""){?>
      <tr>
        <td class="bdl"></td>
        <td class="tl"><strong><?php echo $lang['store_consult_list_my_reply'].$lang['nc_colon'];?></strong><span class="gray"><?php echo nl2br($consult['consult_reply']);?></span><span class="ml10 goods-time">(<?php echo date("Y-m-d H:i:s",$consult['consult_reply_time']);?>)</span></td>
        <td></td>
      </tr>
      <?php }?>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <?php if (count($output['list_consult'])>0) { ?>
      <tr>
        <td class="tc"><input id="all" type="checkbox" class="checkall" /></td>
        <td colspan="20"><label for="all2"><?php echo $lang['nc_select_all'];?></label>
          <a href="javascript:void(0);" class="ncu-btn1" nc_type="batchbutton" uri="index.php?act=store_consult&op=drop_consult" name="id" confirm="<?php echo $lang['nc_ensure_del'];?>"><span><?php echo $lang['nc_del'];?></span></a>
          <div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php }?>
    </tfoot>
  </table>
</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" ></script> 