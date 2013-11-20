<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store&op=store" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="index.php?act=store&op=store_audit" ><span><?php echo $lang['pending'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['grade_apply']; ?></span></a></li>
        <li><a href="index.php?act=store&op=store_auth" ><span><?php echo $lang['store_auth_verify'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name='searchform' id='searchform'>
    <input type="hidden" name="act" value="store_grade">
    <input type="hidden" name="op" value="store_grade_log">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th> <label for="storename"><?php echo $lang['admin_gradelog_storename']; ?></label></th>
          <td><input type="text" value="<?php echo $_GET['storename'];?>" name="storename" id="storename" class="txt-short"></td>
          <th colspan="1"><label for="membername"><?php echo $lang['admin_gradelog_membername']; ?></label></th>
          <td><input type="text" value="<?php echo $_GET['membername'];?>" name="membername" id="membername" class="txt-short"></td>
          <th><label for="gradename"><?php echo $lang['admin_gradelog_gradename']; ?></label></th>
          <td><input type="text" value="<?php echo $_GET['gradename'];?>" name="gradename" id="gradename" class="txt-short"></td>
          <td><select name="allowstate">
              <option value='0' <?php echo $_GET['allowstate'] == 0? 'selected' : ''; ?>><?php echo $lang['admin_gradelog_auditstate']; ?></option>
              <option value='1' <?php echo $_GET['allowstate'] == 1? 'selected' : ''; ?>><?php echo $lang['admin_gradelog_auditing']; ?></option>
              <option value='2' <?php echo $_GET['allowstate'] == 2? 'selected' : ''; ?>><?php echo $lang['admin_gradelog_auditpass']; ?></option>
              <option value='3' <?php echo $_GET['allowstate'] == 3? 'selected' : ''; ?>><?php echo $lang['admin_gradelog_auditnopass']; ?></option>
            </select></td>
          <td><a href="javascript:document.searchform.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
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
            <li><?php echo $lang['store_grade_help1'];?></li>
            <li><?php echo $lang['store_grade_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_glog" action="index.php">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" id="list_act" name="act" value="store_grade">
    <input type="hidden" id="list_op" name="op" value="sg_logdel">
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th><?php echo $lang['admin_gradelog_list_number']; ?> </th>
          <th><?php echo $lang['admin_gradelog_storename']; ?> </th>
          <th><?php echo $lang['admin_gradelog_membername']; ?> </th>
          <th><?php echo $lang['admin_gradelog_gradename']; ?> </th>
          <th class="align-center"><?php echo $lang['admin_gradelog_needcheck']; ?> </th>
          <th class="align-center"><?php echo $lang['admin_gradelog_addtime']; ?> </th>
          <th class="align-center"><?php echo $lang['admin_gradelog_auditstate']; ?> </th>
          <th class="align-center"><?php echo $lang['nc_handle'];?> </th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['log_list']) && is_array($output['log_list'])){ ?>
        <?php foreach($output['log_list'] as $k => $v){ ?>
        <tr class="hover">
          <td><input type="checkbox" name='check_gl_id[]' value="<?php echo $v['gl_id'];?>" class="checkitem"></td>
          <td class="w36"><?php echo $v['gl_id'];?></td>
          <td><?php echo $v['gl_shopname'];?></a></td>
          <td><?php echo $v['gl_membername'];?></td>
          <td><?php echo $v['gl_sgname'];?></td>
          <td class="align-center"><?php echo $v['gl_sgconfirm'] == 1? $lang['nc_yes']:$lang['nc_no']; ?></td>
          <td class="nowarp align-center"><?php echo date('Y-m-d',$v['gl_addtime']);?></td>
          <td class="align-center"><?php if($v['gl_allowstate'] == '1'){
								echo $lang['admin_gradelog_auditpass']; 
							}elseif ($v['gl_allowstate'] == '2') {
								echo $lang['admin_gradelog_auditnopass'];
							}else {
								echo $lang['admin_gradelog_auditing'];
							} ?></td>
          <td class="w96 align-center"><?php if ($v['gl_allowstate'] == 0) {?>
            <a href="index.php?act=store_grade&op=sg_logedit&id=<?php echo $v['gl_id'];?>"><?php echo $lang['nc_edit']; ?></a>
            <?php } else {?>
            <a href="index.php?act=store_grade&op=sg_logedit&id=<?php echo $v['gl_id'];?>"><?php echo $lang['nc_view']; ?></a>
            <?php }?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16" id="batchAction"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('sg_logdel');"><span><?php echo $lang['nc_del']?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
function submit_form(op){
	if(op=='sg_logdel'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
	}
	$('#list_op').val(op);
	$('#form_glog').submit();
}
</script>