<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['admin_index_admin_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=admin&op=admin"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_index_edit_right'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="admin_form" method="post" name="adminForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="space">
          <th><?php echo $lang['admin_index_username'];?>:<?php echo $output['admin_info']['admin_name'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($output['function_array'] as $k => $v) { ?>
        <tr>
          <td class="required"><input id="<?php echo $k;?>" type="checkbox" onclick="selectAll('<?php echo $k;?>')">
            &nbsp;
            <label for="<?php echo $k;?>"><?php echo $v[0];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat w830">
              <?php for($i=1,$j=count($v);$i<$j;$i++) { ?>
              <li class="left w18pre" style="width:auto; margin-left:10px;">
                <label><input class="<?php echo $k;?>" type="checkbox" name="permission[<?php echo $v[$i][0];?>]" value="1" 
        <?php if(@in_array($v[$i][0],$output['admin_array']['admin_permission'])){ ?>checked="checked"<?php }?> >
                <?php echo $v[$i][1];?></label>
              </li>
              <?php } ?>
            </ul></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
        
          <td><a href="JavaScript:void(0);" class="btn" onclick="document.adminForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
function selectAll(name){
    if($('#'+name).attr('checked') == true) {
        $('.'+name).attr('checked',true);
    }
    else {
        $('.'+name).attr('checked',false);
    }
}
</script> 
