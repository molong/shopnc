<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
<div class="tabmenu"><?php include template('member/member_submenu');?></div>
  <div class="ncu-form-style">
    <form method="post" action="index.php?act=store&op=store_navigation" target="_parent" name="store_navigation_form" id="store_navigation_form" enctype="multipart/form-data">
      <input type="hidden" name="form_submit" value="ok"/>
      <input type="hidden" name="sn_id" value="<?php echo $output['sn_info']['sn_id'];?>"/>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_navigation_name'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="w150 text" name="sn_title" value="<?php echo $output['sn_info']['sn_title'];?>" />
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_navigation_display'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="radio" name="sn_if_show" value="1"<?php if($output['sn_info']['sn_if_show'] == '1' || $output['sn_info']['sn_if_show'] == ''){?> checked="checked"<?php }?>/>
          <?php echo $lang['store_payment_yes'];?>
          <input type="radio" name="sn_if_show" value="0"<?php if($output['sn_info']['sn_if_show'] == '0'){?> checked="checked"<?php }?>/>
          <?php echo $lang['store_payment_no'];?></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_goods_class_sort'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="text" class="w50 text" name="sn_sort" value="<?php if($output['sn_info']['sn_sort'] != ''){ echo $output['sn_info']['sn_sort'];}else{echo '255';}?>"/>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_navigation_content'].$lang['nc_colon'];?></dt>
        <dd>
          <?php showEditor('sn_content',$output['sn_info']['sn_content'],'600px','300px','','false',$output['editor_multimedia']); ?>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_navigation_url'].$lang['nc_colon']; ?></dt>
        <dd>
          <p>
            <input type="text" class="w300 text" name="sn_url" />
          </p>
          <p class="hint"><?php echo $lang['store_navigation_url_tip']; ?></p>
          </td>
      </dl>
      <dl>
        <dt><?php echo $lang['store_navigation_new_open'].$lang['nc_colon']; ?></dt>
        <dd>
          <input type="radio" name="sn_new_open" value="1" checked="checked">
          <?php echo $lang['store_navigation_new_open_yes']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="sn_new_open" value="0">
          <?php echo $lang['store_navigation_new_open_no']; ?></dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script>
$(document).ready(function(){
	$('#store_navigation_form').validate({
        rules : {
            sn_title : {
                required   : true
            }
        },
        messages : {
            sn_title : {
                required   : '<?php echo $lang['store_navigation_name_null'];?>'
            }
        }
    });
});
</script>