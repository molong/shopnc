<?php defined('InShopNC') or exit('Access Invalid!');?>


<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['adv_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=adv&op=adv&type=normal"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="adv_form" enctype="multipart/form-data" method="post" action="index.php">
    <input type="hidden" name="act" value="adv"/>
    <input type="hidden" name="op" value="updateFocus"/>
    <input type="hidden" name="form_submit" value="ok" />
    <?php foreach ($output['adv_list'] as $adv) {?>
    <input type="hidden" name="adv_id_<?php echo $adv['adv_id'];?>" value="<?php echo $adv['adv_id'];?>"/>
    <input type="hidden" name="old_pic_<?php echo $adv['adv_id'];?>" value="<?php echo $adv['adv_pic'];?>"/>
    <table class="table tb-type2 nobdb">
      <tr>
        <td colspan="2" class="required"><label for="adv_title_<?php echo $adv['adv_id'];?>"><?php echo $lang['adv_edit_desc'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><input type="text" name="adv_title_<?php echo $adv['adv_id'];?>" id="adv_title_<?php echo $adv['adv_id'];?>" value="<?php echo $adv['adv_title'];?>" class="txt"/></td>
        <td class="vatop tips"><?php echo $lang['adv_edit_desc_tip'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['adv_focus_pic'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><input type="file" name="adv_pic_<?php echo $adv['adv_id'];?>"/></td>
        <td class="vatop tips"><?php echo $lang['adv_edit_support'];?>gif,jpg,jpeg,png;<?php echo $lang['adv_focus_r_size'];?>:550px*270px<br>
          <?php echo $lang['adv_edit_remote'];?></td>
      </tr>
      <?php if($adv['adv_pic'] != ''){?>
      <tr class="noborder">
        <td colspan="2"><img src="<?php echo SiteUrl."/".ATTACH_ADV."/".$adv['adv_pic'];?>" width="275" height="135"/></td>
      </tr>
      <?php }?>
      <tr>
        <td colspan="2" class="required"><label for="adv_url_<?php echo $adv['adv_id'];?>"><?php echo $lang['adv_edit_url'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><input type="text" name="adv_url_<?php echo $adv['adv_id'];?>" id="adv_url_<?php echo $adv['adv_id'];?>" value="<?php echo $adv['adv_url'];?>" class="txt"/></td>
        <td class="vatop tips"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['adv_edit_state'];?>:</td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><input type="radio" name="adv_state_<?php echo $adv['adv_id'];?>" value="1" <?php if($adv['adv_state']=='1'){?>checked<?php }?>/>
          <?php echo $lang['adv_edit_open'];?>
          <input type="radio" name="adv_state_<?php echo $adv['adv_id'];?>" value="0" <?php if($adv['adv_state']=='0'){?>checked<?php }?>/>
          <?php echo $lang['adv_edit_close'];?></td>
        <td class="vatop tips"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="adv_sort_<?php echo $adv['adv_id'];?>"><?php echo $lang['nc_sort'];?>:</label></td>
      </tr>
      <tr class="noborder">
        <td class="vatop rowform"><input type="text" name="adv_sort_<?php echo $adv['adv_id'];?>" id="adv_sort_<?php echo $adv['adv_id'];?>" value="<?php echo $adv['adv_sort'];?>" class="txt"/></td>
        <td class="vatop tips"><?php echo $lang['adv_edit_sort_tip'];?></td>
      </tr>
    </table>
    <?php }?>
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td><input class="btn btn-green big" name="submit" value="<?php echo $lang['adv_focus_update'];?>" type="submit"></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $('input[type="file"]').change(function(){
			var filepath=$(this).val();
			var extStart=filepath.lastIndexOf(".");
			var ext=filepath.substring(extStart,filepath.length).toUpperCase();		
			if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
				alert("<?php echo $lang['adv_edit_img_wrong'];?>");
				$(this).attr('value','');
				return false;
			}
    });
});
//]]>
</script>