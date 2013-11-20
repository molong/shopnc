<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=adv"><span><?php echo $lang['adv_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['adv_wait_check']; ?></span></a></li>
        <li><a href="index.php?act=adv&op=adv_add"><span><?php echo $lang['adv_add'];?></span></a></li>
        <li><a href="index.php?act=adv&op=ap_manage"><span><?php echo $lang['ap_manage'];?></span></a></li>
        <li><a href="index.php?act=adv&op=ap_add"><span><?php echo $lang['ap_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php?act=adv&op=adv_check" name="formSearch">
    <input type="hidden" name="act" value="adv" />
    <input type="hidden" name="op" value="adv_check" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th> <label for="search_name"><?php echo $lang['adv_name']; ?></label></th>
          <td><input class="txt" type="text" name="search_name" id="search_name" value="<?php echo $_GET['search_name'];?>" /></td>
          <th><label for="add_time_from"><?php echo $lang['adv_search_from']; ?></label></th>
          <td><input class="txt date" type="text" id="add_time_from" name="add_time_from" value="<?php echo $_GET['add_time_from'];?>"/>
            <label for="add_time_to">~&nbsp;</label>
            <input class="txt date" type="text" id="add_time_to" name="add_time_to" value="<?php echo $_GET['add_time_to'];?>"/></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv_check'" class="btns tooltip" title="<?php echo $lang['adv_all'];?>"><span><?php echo $lang['adv_all'];?></span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv_check&style=buy'" class="btns tooltip" title="<?php echo $lang['check_adv_buy']; ?>"><span><?php echo $lang['check_adv_buy']; ?></span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv_check&style=order'" class="btns tooltip" title="<?php echo $lang['check_adv_order']; ?>"><span><?php echo $lang['check_adv_order']; ?></span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv_check&style=change'" class="btns tooltip" title="<?php echo $lang['check_adv_change']; ?>"><span><?php echo $lang['check_adv_change']; ?></span></a> <a href="JavaScript:void(0);" onclick="window.location.href='index.php?act=adv&op=adv_check&style=noallo'" class="btns tooltip" title="<?php echo $lang['check_adv_no2']; ?>"><span><?php echo $lang['check_adv_no2']; ?></span></a></td>
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
            <li><?php echo $lang['adv_help4'];?></li>
            <li><?php echo $lang['adv_help5'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th>&nbsp;</th>
        <th><?php echo $lang['adv_name'];?></th>
        <th><?php echo $lang['adv_ap_id'];?></th>
        <th class="align-center"><?php echo $lang['ap_show_style'];?></th>
        <th class="align-center"><?php echo $lang['adv_class'];?></th>
        <th class="align-center"><?php echo $lang['adv_start_time'];?></th>
        <th class="align-center"><?php echo $lang['adv_end_time'];?></th>
        <th><?php echo $lang['adv_owner'];?></th>
        <th class="align-center"><?php echo $lang['check_adv_type'];?></th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['adv_info']) && is_array($output['adv_info'])){ ?>
      <?php foreach($output['adv_info'] as $k => $v){ ?>
      <tr class="hover">
        <td class="w12">&nbsp;</td>
        <td><span title="<?php echo $v['adv_title']; ?>"><?php echo str_cut($v['adv_title'], '28'); ?></span></td>
        <?php 
				 foreach ($output['ap_info'] as $ap_k => $ap_v){
				 	if($v['ap_id'] == $ap_v['ap_id']){
				 		$ap_id = $ap_v['ap_id'];
				 		?>
        <td><span title="<?php echo $ap_v['ap_name']; ?>"><?php echo str_cut($ap_v['ap_name'], '22'); ?></span></td>
        <td class="align-center"><?php
				 		switch ($ap_v['ap_display']){
				 			case '0':echo $lang['ap_slide_show'];break;
							case '1':echo $lang['ap_mul_adv'];break;
							case '2':echo $lang['ap_one_adv'];break;
							default:echo $lang['adv_index_unknown'];break;
				 		}
				 		?></td>
        <td  class="align-center"><?php 
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
        <td class="nowarp align-center"><?php echo date('Y-m-d',$v['adv_start_date']); ?></td>
        <td class="nowarp align-center"><?php echo date('Y-m-d',$v['adv_end_date']); ?></td>
        <td><?php echo $v['member_name']; ?></td>
        <td class="w72 align-center"><?php 
				if($v['is_allow'] == '2'){
					echo $lang['check_adv_no2'];
				}else{
				switch ($v['buy_style']){
					case 'buy':
						echo $lang['check_adv_buy'];
						break;
					case 'order':
						echo $lang['check_adv_order'];
						break;
					case 'change':
						echo $lang['check_adv_change'];
						break;
				}}
				?></td>
        <td class="w72 align-center"><?php 
				if($v['is_allow'] != '2'){
				?>
          <a href="index.php?act=adv&op=adv_check&do=check&adv_id=<?php echo $v['adv_id'];?>"><?php echo $lang['check_adv_view'];?></a>
          <?php	
				}
				?></td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['check_adv_nothing'];?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15"><div class="pagination"> <?php echo $output['page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>