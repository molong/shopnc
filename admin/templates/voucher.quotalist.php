<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
function submit_cancel_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_cancel(items);
    }  
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_cancel(id){
    if(confirm('<?php echo $lang['admin_voucher_cancel_confirm'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=voucher&op=quota_cancel');
        $('#object_id').val(id);
        $('#list_form').submit();
    }
}
</script>

<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_voucher_price_manage'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_key'] == $output['menu_key']) { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </ul>
    </div>
  </div>
  <!--  搜索 -->
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="voucher">
    <input type="hidden" name="op" value="quotalist">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name"><?php echo $lang['admin_voucher_storename'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['store_name'];?>" name="store_name" id="store_name" class="txt" style="width:100px;"></td>
          <th><label for=""><?php echo $lang['nc_state'];?></label></th>
          <td>
          	<select name="state">
          		<option value="0" <?php if(0 === intval($_GET['state'])) echo 'selected';?>><?php echo $lang['nc_status'];?></option>
          		<?php if(is_array($output['quotastate_arr'])) { ?>
          		<?php foreach($output['quotastate_arr'] as $key=>$val) { ?>
          			<option value="<?php echo $val[0];?>" <?php if(intval($val[0]) === intval($_GET['state'])) echo 'selected';?>><?php echo $val[1];?></option>
          		<?php } ?>
          		<?php } ?>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul><li><?php echo $lang['admin_voucher_quota_tip1'];?></li></ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <input type="hidden" id="object_id" name="object_id"  />
    <table class="table tb-type2">
      <thead>
          <tr class="thead">
              <th class="w24"></th>
              <th class="align-left"><span><?php echo $lang['admin_voucher_storename'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_quota_startdate'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_quota_enddate'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_quota_timeslimit'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_quota_publishedtimes'];?></span></th>
              <th class="align-center"><span><?php echo $lang['admin_voucher_quota_residuetimes'];?></span></th>
              <th class="align-center"><span><?php echo $lang['nc_state'];?></span></th>
              <th class="align-center"><span><?php echo $lang['nc_handle'];?></span></th>
          </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
            <td><input type="checkbox" name='quota_checkbox' value="<?php echo $val['quota_id'];?>" class="checkitem"></td>
            <td class="align-left"><a href="<?php echo SiteUrl;?>/index.php?act=show_store&id=<?php echo $val['quota_storeid'];?>" target="_blank"><span><?php echo $val['quota_storename'];?></span></a></td>
            <td class="align-center"><span><?php echo date("Y-m-d",$val['quota_starttime']);?></span></td>
            <td class="align-center"><span><?php echo date("Y-m-d",$val['quota_endtime']);?></span></td>
            <td class="align-center"><span><?php echo $val['quota_timeslimit'];?></span></td>
            <td class="align-center"><span><?php echo $val['quota_publishedtimes'];?></span></td>
            <td class="align-center"><span><?php echo intval($val['quota_timeslimit'])-intval($val['quota_publishedtimes']);?></span></td>            
            <td class="align-center"><span>
            <?php foreach($output['quotastate_arr'] as $k=>$v){
            	if($val['quota_state'] == $v[0]){
            		echo $v[1];
            	}
            } ?>
            </span></td>
            <td class="nowrap align-center">
                <!-- 取消按钮 --> 
                <?php if(intval($val['quota_state']) == intval($output['quotastate_arr']['activity'][0])) { ?>
                <a href="javascript:void(0)" onclick="submit_cancel('<?php echo $val['quota_id'];?>');"><?php echo $lang['nc_cancel'];?></a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td>
          	<?php if(!empty($output['list']) && is_array($output['list'])){ ?>
            <input type="checkbox" class="checkall">
            <?php } ?>
          </td>
          <td colspan="16">
          	<label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_cancel_batch()"><span><?php echo $lang['nc_cancel']?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div>
          </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>