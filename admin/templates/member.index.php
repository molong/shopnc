<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['member_index_manage']?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage']?></span></a></li>
        <li><a href="index.php?act=member&op=member_add" ><span><?php echo $lang['nc_new']?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" value="member" name="act">
    <input type="hidden" value="member" name="op">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <td><select name="search_field_name" >
              <option <?php if($output['search_field_name'] == 'member_name'){ ?>selected='selected'<?php } ?> value="member_name"><?php echo $lang['member_index_name']?></option>
              <option <?php if($output['search_field_name'] == 'member_email'){ ?>selected='selected'<?php } ?> value="member_email"><?php echo $lang['member_index_email']?></option>
              <option <?php if($output['search_field_name'] == 'member_truename'){ ?>selected='selected'<?php } ?> value="member_truename"><?php echo $lang['member_index_true_name']?></option>
            </select></td>
          <td><input type="text" value="<?php echo $output['search_field_value'];?>" name="search_field_value" class="txt"></td>
          <td><select name="search_sort" >
              <option value=""><?php echo $lang['nc_sort']?></option>
              <option <?php if($output['search_sort'] == 'member_login_time desc'){ ?>selected='selected'<?php } ?> value="member_login_time desc"><?php echo $lang['member_index_last_login']?></option>
              <option <?php if($output['search_sort'] == 'member_login_num desc'){ ?>selected='selected'<?php } ?> value="member_login_num desc"><?php echo $lang['member_index_login_time']?></option>
            </select></td>
          <td><select name="search_state" >
              <option <?php if($_GET['search_state'] == ''){ ?>selected='selected'<?php } ?> value=""><?php echo $lang['member_index_state']; ?></option>
              <option <?php if($_GET['search_state'] == 'no_informallow'){ ?>selected='selected'<?php } ?> value="no_informallow"><?php echo $lang['member_index_inform_deny']; ?></option>
              <option <?php if($_GET['search_state'] == 'no_isbuy'){ ?>selected='selected'<?php } ?> value="no_isbuy"><?php echo $lang['member_index_buy_deny']; ?></option>
              <option <?php if($_GET['search_state'] == 'no_isallowtalk'){ ?>selected='selected'<?php } ?> value="no_isallowtalk"><?php echo $lang['member_index_talk_deny']; ?></option>
              <option <?php if($_GET['search_state'] == 'no_memberstate'){ ?>selected='selected'<?php } ?> value="no_memberstate"><?php echo $lang['member_index_login_deny']; ?></option>
            </select></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
          <a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?></span></a>
            <?php if($output['search_field_value'] != '' or $output['search_sort'] != ''){?>
            <a href="index.php?act=member&op=member" class="btns tooltip"><span><?php echo $lang['nc_cancel_search']?></span></a>
            <?php }?></td>
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
            <li><?php echo $lang['member_index_help1'];?></li>
            <li><?php echo $lang['member_index_help2'];?></li>
            <li><?php echo $lang['member_index_help3'];?></li>
            <li><?php echo $lang['member_index_help4'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="form_member">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="thead">
          <th>&nbsp;</th>
          <th colspan="2"><?php echo $lang['member_index_name']?></th>
          <th class="align-center"><span fieldname="logins" nc_type="order_by"><?php echo $lang['member_index_login_time']?></span></th>
          <th class="align-center"><span fieldname="last_login" nc_type="order_by"><?php echo $lang['member_index_last_login']?></span></th>
          <th class="align-center"><?php echo $lang['member_index_points']; ?></th>
          <th class="align-center"><?php echo $lang['member_index_prestore'];?></th>
          <th class="align-center"><?php echo $lang['member_index_login']; ?></th>
          <th class="align-center"><?php echo $lang['member_index_store']; ?></th>
          <th class="align-center"><?php echo $lang['nc_handle']; ?></th>
        </tr>
      <tbody>
        <?php if(!empty($output['member_list']) && is_array($output['member_list'])){ ?>
        <?php foreach($output['member_list'] as $k => $v){ ?>
        <tr class="hover member">
          <td class="w24"><input type="checkbox" name='del_id[]' value="<?php echo $v['member_id']; ?>" class="checkitem"></td>
          <td class="w48 picture"><div class="size-44x44"><span class="thumb size-44x44"><i></i><img src="<?php if ($v['member_avatar'] != ''){ echo SiteUrl.DS. ATTACH_AVATAR.DS.$v['member_avatar'];}else { echo 'templates/images/default_user_portrait.gif';}?>"  onload="javascript:DrawImage(this,44,44);"/></span></div></td>
          <td><p class="name"><strong><?php echo $v['member_name']; ?></strong>(<?php echo $lang['member_index_true_name']?>: <?php echo $v['member_truename']; ?>)</p>
            <p class="smallfont"><?php echo $lang['member_index_reg_time']?>:&nbsp;<?php echo $v['member_time']; ?></p>
            
              <div class="im"><span class="email" >
                <?php if($v['member_email'] != ''){ ?>
                <a href="mailto:<?php echo $v['member_email']; ?>" class="tooltip yes" title="<?php echo $lang['member_index_email']?>:<?php echo $v['member_email']; ?>"><?php echo $v['member_email']; ?></a></span>
                <?php }else { ?>
                <a href="JavaScript:void(0);" class="tooltip" title="<?php echo $lang['member_index_null']?>" ><?php echo $v['member_email']; ?></a></span>
                <?php } ?>
                <?php if($v['member_ww'] != ''){ ?>
                <a target="_blank" href="http://web.im.alisoft.com/msg.aw?v=2&uid=<?php echo $v['member_ww'];?>&site=cnalichn&s=11" class="tooltip" title="WangWang: <?php echo $v['member_ww'];?>"><img border="0" src="http://web.im.alisoft.com/online.aw?v=2&uid=<?php echo $v['member_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" /></a>
                <?php } ?>
                <?php if($v['member_qq'] != ''){ ?>
                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v['member_qq'];?>&site=qq&menu=yes" class="tooltip" title="QQ: <?php echo $v['member_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $v['member_qq'];?>:45"></a>
                <?php } ?>
              </div></td>
          <td class="align-center"><?php echo $v['member_login_num']; ?></td>
          <td class="w150 align-center"><p><?php echo $v['member_login_time']; ?></p>
            <p><?php echo $v['member_login_ip']; ?></p></td>
          <td class="align-center"><?php echo $v['member_points']; ?></td>
          <td class="align-center"><p><?php echo $lang['member_index_available'];?>:&nbsp;<strong class="red"><?php echo $v['available_predeposit']; ?></strong>&nbsp;<?php echo $lang['currency_zh']; ?></p>
            <p><?php echo $lang['member_index_frozen'];?>:&nbsp;<strong class="red"><?php echo $v['freeze_predeposit']; ?></strong>&nbsp;<?php echo $lang['currency_zh']; ?></p></td>
          <td class="align-center"><?php echo $v['member_state'] == 1?$lang['member_edit_allow']:$lang['member_edit_deny']; ?></td>
          <td class="align-center"><?php if($v['store_id'] != 0){ ?>
            <a onclick="parent.openItem('store','store','store');" href="index.php?act=store&op=store_edit&store_id=<?php echo $v['store_id']; ?>"><?php echo $lang['member_index_to_store']?></a>
            <?php } ?></td>
          <td class="align-center"><a href="index.php?act=member&op=member_edit&member_id=<?php echo $v['member_id']; ?>"><?php echo $lang['nc_edit']?></a> | <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']?>')){location.href='index.php?act=member&op=member_del&member_id=<?php echo $v['member_id']; ?>'}"><?php echo $lang['nc_del']?></a> | <a href="index.php?act=notice&op=notice&member_name=<?php echo ltrim(base64_encode($v['member_name']),'='); ?>"><?php echo $lang['member_index_to_message'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="11"><?php echo $lang['nc_no_record']?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot class="tfoot">
        <?php if(!empty($output['member_list']) && is_array($output['member_list'])){ ?>
        <tr>
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['nc_ensure_del']?>')){$('#form_member').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(function(){
    $('#ncexport').click(function(){
    	$('input=[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    $('#ncsubmit').click(function(){
    	$('input=[name="op"]').val('member');$('#formSearch').submit();
    });	
});
</script>
