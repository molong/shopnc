<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_admin_search_set'];?></h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
	<table id="prompt" class="table tb-type2">
	<tbody>
	<tr class="space odd" style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
	<th class="nobg" colspan="12">
	<div class="title">
	<h5><?php echo $lang['fulltext_set'];?></h5>
	<span class="arrow"></span>
	</div>
	</th>
	</tr>
	<tr class="odd" style="background: none repeat scroll 0% 0% rgb(255, 255, 255); display: table-row;">
	<td>
	<ul>
	<li><?php echo $lang['fulltext_set_prompt1'];?></li>
	<li><?php echo $lang['fulltext_set_prompt2'];?></li>
	<li><?php echo $lang['fulltext_set_prompt3'];?></li>
	</ul>
	</td>
	</tr>
	</tbody>
	</table>
  <form id="form" method="post" enctype="multipart/form-data" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label for="hot_search"><?php echo $lang['hot_search'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="hot_search" name="hot_search" value="<?php echo $output['list_setting']['hot_search'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['field_notice'];?></span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.settingForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
