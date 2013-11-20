<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['mailtemplates_index_notice']?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=mailtemplates&op=mailtemplates" ><span><?php echo $lang['mailtemplates_index_mail']?></span></a></li>
        <li><a href="index.php?act=mailtemplates&op=msgtemplates" ><span><?php echo $lang['mailtemplates_index_message']?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit']?><?php echo $lang['mailtemplates_index_message']?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="form_templates" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="code" value="<?php echo $output['templates_array']['code'];?>" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label>
            <label class="validation" for="link"><?php echo $lang['mailtemplates_msg_edit_content']?>:</label>
            </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="content" rows="6" class="tarea"><?php echo $output['templates_array']['content'];?></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
