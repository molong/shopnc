<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
<div class="tabmenu">
  <?php include template('member/member_submenu');?>
</div>
<div class="ncu-form-style">
  <form method="post" enctype="multipart/form-data" action="index.php?act=store&op=store_certified" onsubmit="ajaxpost('my_store_form', '', '', 'onerror');return false;" id="my_store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <?php if (!empty($output['store_info']['store_image']) || !empty($output['store_info']['store_image1'])){?>
    <h3><?php echo $lang['member_store_cert_state'];?></h3>
    <?php if (!empty($output['store_info']['store_image'])){?>
    <dl>
      <dt><?php echo $lang['member_store_cert_name_show'].$lang['nc_colon'];?></dt>
      <dd>
        <span class="fl mr10"><img <?php if($output['store_info']['name_auth'] == 1){ echo 'src="'.TEMPLATES_PATH.'/images/member/cert_autonym.gif"';}else{ echo 'src="'.TEMPLATES_PATH.'/images/member/cert_autonym_no.gif" title="'.$lang['member_store_cert_not_certified'].'" alt="'.$lang['member_store_cert_not_certified'].'"';}?>/></span>
        <a href="<?php echo ATTACH_AUTH.'/'.$output['store_info']['store_image'];?>" target="_blank" class="fl mr10"><?php echo $lang['member_store_cert_view_file'];?></a>
        <?php if ($output['store_info']['name_auth'] == 2){?>
        <span class="hint fl"> (<?php echo $lang['member_store_cert_audit'];?>)
        <?php }else if($output['store_info']['name_auth'] == 1){?>
        (<?php echo $lang['member_store_cert_audit_complate'];?>)
        <?php }else{?>
        (<?php echo $lang['member_store_cert_not_certified'];?>)</span>
        <?php }?>
      </dd>
    </dl>
    <?php }?>
    <?php if (!empty($output['store_info']['store_image1'])){?>
    <dl>
      <dt><?php echo $lang['member_store_cert_store_show'].$lang['nc_colon'];?></dt>
      <dd>
        <span class="fl mr10"><img <?php if($output['store_info']['store_auth'] == 1){echo 'src="'.TEMPLATES_PATH.'/images/member/cert_material.gif"';}else{ echo 'src="'.TEMPLATES_PATH.'/images/member/cert_material_no.gif" title="'.$lang['member_store_cert_not_certified'].'" alt="'.$lang['member_store_cert_not_certified'].'"';}?>/></span>
        <a href="<?php echo ATTACH_AUTH.'/'.$output['store_info']['store_image1'];?>" target="_blank" class="fl mr10"><?php echo $lang['member_store_cert_view_file'];?></a>
        <?php if ($output['store_info']['store_auth'] == 2){?>
        <span class="hint"> (<?php echo $lang['member_store_cert_audit'];?>)
        <?php }else if($output['store_info']['store_auth'] == 1){?>
        (<?php echo $lang['member_store_cert_audit_complate'];?>)
        <?php }else{?>
        (<?php echo $lang['member_store_cert_not_certified'];?>)</span>
        <?php }?>
      </dd>
    </dl>
    <?php }}?>
    <?php if (empty($output['store_info']['store_image']) || empty($output['store_info']['store_image1']) || $output['store_info']['store_auth'] != '2' || $output['store_info']['name_auth'] != '2'){?>
    <h3><?php echo $lang['member_store_cert_re'];?></h3>
    <?php if ($output['store_info']['name_auth'] != '2'){?>
    <dl>
      <dt><?php echo $lang['member_store_cert_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input name="cert_autonym" type="file"/>
      </dd>
    </dl>
    <?php }?>
    <?php if ($output['store_info']['store_auth'] != '2'){?>
    <dl>
      <dt><?php echo $lang['member_store_cert_store'].$lang['nc_colon'];?></dt>
      <dd>
        <input name="cert_material" type="file"/>
      </dd>
    </dl>
    <?php }?>
    <?php if($output['store_info']['store_auth'] == 1 ||$output['store_info']['name_auth'] == 1){?>
    <dl>
      <dt class="required"><em class="pngFix"></em></dt>
      <dd><?php echo $lang['member_store_cert_re_notes'];?></dd>
    </dl>
    <?php }?>
    <dl class="bottom">
    <dt>&nbsp;</dt>
    <dd>
      <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
    </dd>
    <?php }?>
  </form>
</div>
</div>
