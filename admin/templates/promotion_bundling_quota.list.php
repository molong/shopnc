<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_promotion_bundling'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['bundling_quota'];?></span></a></li>
        <li><a href="index.php?act=promotion_bundling&op=bundling_list"><span><?php echo $lang['bundling_list'];?></span></a></li>
        <li><a href="index.php?act=promotion_bundling&op=bundling_setting"><span><?php echo $lang['bundling_setting'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="promotion_bundling">
    <input type="hidden" name="op" value="bundling_quota">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="store_name"><?php echo $lang['bundling_quota_store_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['bundling_store_name'];?>" name="store_name" id="store_name" class="txt" style="width:100px;"></td>
          <th><label for=""><?php echo $lang['nc_state'];?></label></th>
          <td>
              <select name="state">
                  <option><?php echo $lang['bundling_state_all'];?></option>
                  <option <?php if(isset($output['state']) && $output['state'] == 1){?>selected="selected"<?php }?>><?php echo $lang['bundling_state_1'];?></option>
                  <option <?php if(isset($output['state']) && $output['state'] == 0){?>selected="selected"<?php }?>><?php echo $lang['bundling_state_0'];?></option>
              </select>
          </td>
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
        <td><ul>
            <li><?php echo $lang['bundling_quota_list_prompts'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <input type="hidden" id="object_id" name="object_id"  />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['bundling_quota_store_name'];?></th>
          <th class="align-center"><?php echo $lang['bundling_quota_quantity'];?></th>
          <th class="align-center"><?php echo $lang['bundling_quota_starttime'];?></th>
          <th class="align-center"><?php echo $lang['bundling_quota_endtime'];?></th>
          <th class="align-center"><?php echo $lang['nc_status'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
          <td class="align-left"><a href="<?php echo SiteUrl;?>/index.php?act=show_store&id=<?php echo $val['store_id'];?>" target="_blank"><span><?php echo $val['store_name'];?></span></a></td>
          <td class="align-center"><?php echo $val['bl_quota_month'];?></td>
          <td class="align-center"><?php echo date('Y-m-d',$val['bl_quota_starttime']);?></td>
          <td class="align-center"><?php echo date('Y-m-d',$val['bl_quota_endtime']);?></td>
          <td class="align-center yes-onoff">
            <a href="JavaScript:void(0);" class="tooltip <?php echo $val['bl_quota_state']? 'enabled':'disabled';?>" ajax_branch="bl_quota_state" nc_type="inline_edit"  fieldname="bl_quota_state" fieldid="<?php echo $val['bl_quota_id'];?>" fieldvalue="<?php  echo $val['bl_quota_state'] ? '1' : '0';?>" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"></a>
          </td>
          <td class="nowrap align-center">
          	<a href="index.php?act=promotion_bundling&op=bundling_quota_edit&quota_id=<?php echo $val['bl_quota_id'];?>"><?php echo $lang['nc_edit'];?></a> | 
          	<a href="index.php?act=promotion_bundling&op=bundling_list&quota_id=<?php echo $val['bl_quota_id'];?>"><?php echo $lang['nc_view'];?></a>
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
          <td colspan="16"><label>
            <div class="pagination"><?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
</script>