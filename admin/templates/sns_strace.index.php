<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['admin_snstrace_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_snstrace_tracelist'];?></span></a></li>
        <li><a href="index.php?act=sns_strace&op=scomm_list"><span><?php echo $lang['admin_snstrace_commentlist'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="formSearch">
    <input type="hidden" name="act" value="sns_strace">
    <input type="hidden" name="op" value="stracelist">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_uname"><?php echo $lang['admin_snsstrace_storename'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['search_sname'];?>" name="search_sname" id="search_sname" class="txt"></td>
          <th><label for="search_content"><?php echo $lang['admin_snstrace_content'];?></label></th>
          <td><input type="text" value="<?php echo $_GET['search_scontent'];?>" name="search_scontent" id="search_scontent" class="txt"></td>
          <th><label><?php echo $lang['store_sns_trace_type'];?></label></th>
          <td><select name="search_type">
              <option value=''><?php echo $lang['nc_please_choose'];?>...</option>
              <option value="normal" <?php echo $_GET['search_type'] == 'normal'?'selected="selected"':''; ?>><?php echo $lang['store_sns_normal'];?></option>
              <option value="new" <?php echo $_GET['search_type'] == 'new'?'selected="selected"':''; ?>><?php echo $lang['store_sns_new'];?></option>
              <option value="coupon" <?php echo $_GET['search_type'] == 'coupon'?'selected="selected"':''; ?>><?php echo $lang['store_sns_coupon'];?></option>
              <option value="xianshi" <?php echo $_GET['search_type'] == 'xianshi'?'selected="selected"':''; ?>><?php echo $lang['store_sns_xianshi'];?></option>
              <option value="mansong" <?php echo $_GET['search_type'] == 'mansong'?'selected="selected"':''; ?>><?php echo $lang['store_sns_mansong'];?></option>
              <option value="bundling" <?php echo $_GET['search_type'] == 'bundling'?'selected="selected"':''; ?>><?php echo $lang['store_sns_bundling'];?></option>
              <option value="groupbuy" <?php echo $_GET['search_type'] == 'groupbuy'?'selected="selected"':''; ?>><?php echo $lang['store_sns_groupbuy'];?></option>
              <option value="recommend" <?php echo $_GET['search_type'] == 'recommend'?'selected="selected"':''; ?>><?php echo $lang['store_sns_recommend'];?></option>
              <option value="hotsell" <?php echo $_GET['search_type'] == 'hotsell'?'selected="selected"':''; ?>><?php echo $lang['store_sns_hotsell'];?></option>
            </select></td>
          <th><label for="search_stime"><?php echo $lang['admin_snstrace_addtime'];?></label></th>
          <td><input type="text" class="txt date" value="<?php echo $_GET['search_stime'];?>" name="search_stime" id="search_stime" class="txt">
            <label for="search_etime">~</label>
            <input type="text" class="txt date" value="<?php echo $_GET['search_etime'];?>" name="search_etime" id="search_etime" class="txt">
            <a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
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
            <li><?php echo $lang['admin_snstrace_tracelisttip1'];?></li>
            <li><?php echo $lang['admin_snstrace_tracelisttip2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_trace" action="">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <?php if(!empty($output['strace_list']) && is_array($output['strace_list'])){ ?>
        <?php foreach($output['strace_list'] as $k => $v){?>
        <tr class="hover edit">
          <td style="vertical-align:top;"><input type="checkbox" name="st_id[]" value="<?php echo $v['strace_id'];?>" class="checkitem"></td>
          <td class="fd-list">
          <!-- 动态列表start -->
            <li>
              <div class="fd-aside">
              	<span class="thumb size60">
					<a href="<?php echo SiteUrl;?>/index.php?act=store_snshome&sid=<?php echo $v['strace_storeid'];?>" target="_blank">
						<img src="<?php echo $v['strace_storelogo']!='' ? SiteUrl.'/'.ATTACH_STORE.DS.$v['strace_storelogo'] : SiteUrl.'/'.ATTACH_COMMON.DS.C('default_store_logo');  ?>" onload="javascript:DrawImage(this,60,60);">
					</a>
              	</span>
              </div>
              <dl class="fd-wrap">
                <dt>
					<h3><a href="<?php echo SiteUrl;?>/index.php?act=store_snshome&sid=<?php echo $v['strace_storeid'];?>" target="_blank"><?php echo $v['strace_storename'];?></a><?php echo $lang['nc_colon'];?></h3>
					<h5><?php echo parsesmiles($v['strace_title']);?></h5>
                </dt>
                <dd>
                  <?php echo parsesmiles($v['strace_content']);?>
                </dd>
                <dd>
                  <span class="fc-time fl"><?php echo date('Y-m-d H:i',$v['strace_time']);?></span> <span class="fr"><?php echo $lang['admin_snstrace_forward'];?>&nbsp;|&nbsp;<a href="index.php?act=sns_strace&op=scomm_list&st_id=<?php echo $v['strace_id'];?>"><?php echo $lang['admin_snstrace_comment']; ?><?php echo $v['strace_comment']>0?"({$v['strace_comment']})":'';?></a></span>&nbsp;&nbsp;<?php echo $lang['admin_snstrace_state'].$lang['nc_colon'];?><?php echo $v['strace_state']==0?"<font style='color:red;'>{$lang['admin_snstrace_statehide']}</font>":"{$lang['admin_snstrace_stateshow']}";?></span> 
                </dd>
                <div class="clear"></div>
              </dl>
            </li>
            <!-- 动态列表end -->
            </td>
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
          <td class="w24"><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp; <a href="JavaScript:void(0);" class="btn" onclick="submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a> <a href="JavaScript:void(0);" class="btn" onclick="submit_form('hide');"><span><?php echo $lang['admin_snstrace_statehide'];?></span></a> <a href="JavaScript:void(0);" class="btn" onclick="submit_form('show');"><span><?php echo $lang['admin_snstrace_stateshow'];?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#search_stime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#search_etime').datepicker({dateFormat: 'yy-mm-dd'});
});
function submit_form(type){
	if(type=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
		$('#form_trace').attr('action','index.php?act=sns_strace&op=strace_del');
	}else if(type=='hide'){
		$('#form_trace').attr('action','index.php?act=sns_strace&op=strace_edit&type=hide');
	}else{
		$('#form_trace').attr('action','index.php?act=sns_strace&op=strace_edit&type=show');
	}
	$('#form_trace').submit();
}
</script>