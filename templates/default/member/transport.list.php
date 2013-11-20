<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo TEMPLATES_PATH;?>/css/transport.css" rel="stylesheet" type="text/css">

<div class="wrap">
<div class="tabmenu">
  <?php include template('member/member_submenu');?>
  <a class="ncu-btn3" href="index.php?act=transport&op=add&type=<?php echo $_GET['type'];?>"><?php echo $lang['transport_tpl_add'];?> </a> </div>
<!-----------------list begin------------------------>
<div id="postage-tpl" style="padding: 20px 0;">
  <div id="J_TemplateList" class="manage-list">
    <?php if (is_array($output['list'])){?>
    <?php foreach ($output['list'] as $v){?>
    <div class="section J_Section">
      <div class="tbl-prefix"> <span class="meta"> <?php echo $lang['transport_tpl_edit_time'].$lang['nc_colon'];?><span class="J_LastModified"><?php echo date('Y-m-d H:i:s',$v['update_time']);?></span> <a  class="J_Clone" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><?php echo $lang['transport_tpl_copy'];?></a> | <a class="J_Modify" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><?php echo $lang['transport_tpl_edit'];?></a> | <a class="J_Delete" href="javascript:void(0)" data-id="<?php echo $v['id'];?>"><?php echo $lang['transport_tpl_del'];?></a></span>
        <h3 class="J_Title"> <?php echo $v['title'];?> </h3>
      </div>
      <div class="tbl-head">
        <table cellspacing="0" cellpadding="0" border="0">
          <colgroup>
          <col class="col-express">
          <col class="col-area">
          <col class="col-starting">
          <col class="col-postage">
          <col class="col-plus">
          <col class="col-postageplus">
          </colgroup>
          <tbody>
            <tr>
              <th><?php echo $lang['transport_type'];?></th>
              <th class="cell-area"><?php echo $lang['transport_to'];?></th>
              <th><?php echo $lang['transport_snum'];?></th>
              <th><?php echo $lang['transport_price'];?></th>
              <th><?php echo $lang['transport_xnum'];?></th>
              <th><?php echo $lang['transport_price'];?></th>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="entity">
        <table cellspacing="0" cellpadding="0" border="0">
          <colgroup>
          <col class="col-express">
          <col class="col-area">
          <col class="col-starting">
          <col class="col-postage">
          <col class="col-plus">
          <col class="col-postageplus">
          </colgroup>
          <tbody>
            <?php if (is_array($output['extend'])){?>
            <?php foreach ($output['extend'] as $value){?>
            <?php if ($value['transport_id'] == $v['id']){?>
            <tr>
              <td><?php echo str_replace(array('kd','py','es'),array($lang['transport_type_kd'],$lang['transport_type_py'],'EMS'),$value['type']);?></td>
              <td class="cell-area"><?php echo $value['area_name'];?></td>
              <td><?php echo $value['snum'];?></td>
              <td><?php echo $value['sprice'];?></td>
              <td><?php echo $value['xnum'];?></td>
              <td><?php echo $value['xprice'];?></td>
            </tr>
            <?php }?>
            <?php }?>
            <?php }?>
          </tbody>
        </table>
      </div>
      <?php if ($_GET['type'] == "select"){?>
      <div class="tbl-attach"><a class="ncu-btn2" enty-data="<?php echo $v['title'];?>|||<?php echo $v['id'];?>" href="javascript:void(0)"><span><?php echo $lang['transport_applay'];?></span></a></div>
      <?php }?></div>
      <?php }?>
      <?php }?>
    </div>
    <?php if (is_array($output['list'])){?>
    <div class="list-attach">
      <p class="position2">
      <div class="pagination"><?php echo $output['show_page']; ?></div>
      </p>
    </div>
    <?php }?>
  </div>
  
  <!-----------------list end----------------------->
</div>
<div class="clear">&nbsp;</div>
<script>
$(function(){	
	$('a[class="J_Delete"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		if (!confirm('<?php echo $lang['transport_del_confirm'];?>'))return false;
		$(this).attr('href','<?php echo SiteUrl;?>/index.php?act=transport&op=delete&type=<?php echo $_GET['type'];?>&id='+id);
		return true;
	});

	$('a[class="J_Modify"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		$(this).attr('href','<?php echo SiteUrl;?>/index.php?act=transport&op=edit&type=<?php echo $_GET['type'];?>&id='+id);
		return true;
	});
	
	$('a[class="J_Clone"]').click(function(){
		var id = $(this).attr('data-id');
		if(typeof(id) == 'undefined') return false;
		$(this).attr('href','<?php echo SiteUrl;?>/index.php?act=transport&op=clone&type=<?php echo $_GET['type'];?>&id='+id);
		return true;
	});
	$('a[class="ncu-btn2"]').click(function(){
		var data = $(this).attr('enty-data');
		if(typeof(data) == 'undefined') return false;
		data = data.split('|||');
//		opener.document.getElementById("postageName").innerHTML=data[0];
		$("#postageName", opener.document).css('display','inline').html(data[0]);
		$("#transport_id", opener.document).val(data[1]);
		window.close();
	});	

});
</script>