<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['adv_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=adv_check"><span><?php echo $lang['adv_wait_check']; ?></span></a></li>
        <li><a href="index.php?act=adv&op=adv_add"><span><?php echo $lang['adv_add'];?></span></a></li>
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=ap_add"><span><?php echo $lang['ap_add'];?></span></a></li>
        <li><a href="index.php?act=adv&op=adv_cache_refresh"><span><?php echo $lang['adv_cache_refresh']; ?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php?act=adv&op=adv" name="formSearch">
    <input type="hidden" name="act" value="adv" />
    <input type="hidden" name="op" value="adv" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['adv_name']; ?></th>
          <td><input class="txt" type="text" name="search_name" value="<?php echo $_GET['search_name'];?>" /></td>
          <th><?php echo $lang['adv_search_from']; ?></th>
          <td><input class="txt date" type="text" id="add_time_from" name="add_time_from" value="<?php echo $_GET['add_time_from'];?>"/>
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" id="add_time_to" name="add_time_to" value="<?php echo $_GET['add_time_to'];?>"/></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a><a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv'" class="btns tooltip" title="<?php echo $lang['adv_all'];?>"><span><?php echo $lang['adv_all'];?></span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv&overtime=0'" class="btns tooltip" title="<?php echo $lang['adv_not_overtime'];?>"><span><?php echo $lang['adv_not_overtime'];?></span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv&overtime=1'" class="btns tooltip" title="<?php echo $lang['adv_overtime'];?>"><span><?php echo $lang['adv_overtime'];?></span></a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['adv_help1'];?></li>
            <li><?php echo $lang['adv_help2'];?></li>
            <li><?php echo $lang['adv_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['adv_name'];?></th>
          <th><?php echo $lang['adv_ap_id'];?></th>
          <th class="align-center"><?php echo $lang['adv_class'];?></th>
          <th class="align-center"><?php echo $lang['adv_start_time'];?></th>
          <th class="align-center"><?php echo $lang['adv_end_time'];?></th>
          <th class="align-center"><span class="paixv"><a href="index.php?act=adv&op=adv&order=clicknum"><?php echo $lang['adv_click_num'];?></a></span></th>
          <th><?php echo $lang['adv_owner'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['adv_info']) && is_array($output['adv_info'])){ ?>
        <?php foreach($output['adv_info'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w24"><input type="checkbox" class="checkitem" name="del_id[]" value="<?php echo $v['adv_id']; ?>" /></td>
          <td><span title="<?php echo $v['adv_title']; ?>"><?php echo str_cut($v['adv_title'], '36'); ?></span></td>
          <?php 
				 foreach ($output['ap_info'] as $ap_k => $ap_v){
				 	if($v['ap_id'] == $ap_v['ap_id']){
				 		?>
          <td><span title="<?php echo $ap_v['ap_name']; ?>"><?php echo str_cut($ap_v['ap_name'], '22'); ?></span></td>
          <td class="align-center"><?php 
				 		 switch ($ap_v['ap_class']){
				 		 	case '0':
				 		 		echo $lang['adv_pic'];
				 		 		break;
				 		 	case '1':
				 		 		echo $lang['adv_word'];
				 		 		break;
				 		 	case '2':
				 		 		echo $lang['adv_slide'];
				 		 		break;
				 		 	case '3':
				 		 		echo "Flash";
				 		 		break;
				 		 }
				 		?></td>
          <?php }}?>
          <td class="align-center nowrap"><?php echo date('Y-m-d',$v['adv_start_date']); ?></td>
          <td class="align-center nowrap"><?php echo date('Y-m-d',$v['adv_end_date']); ?></td>
          <td class="align-center"><?php
				echo "<a href='index.php?act=adv&op=click_chart&adv_id=".$v['adv_id']."'>".$v['click_num']."</a>"; ?></td>
          <td><?php 
				 if($v['member_name'] != ''){
				 	echo $v['member_name']; 
				 }else{
				 	echo $lang['adv_admin_add'];
				 }
				?></td>
          <td class="w72 align-center"><a href="index.php?act=adv&op=adv_edit&adv_id=<?php echo $v['adv_id'];?>"><?php echo $lang['adv_edit'];?></a>&nbsp;|&nbsp;<a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>'))window.location = 'index.php?act=adv&op=adv_del&adv_id=<?php echo $v['adv_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall"/></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['adv_del_sure'];?>')){$('#store_form').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>