<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3> <?php echo $lang['goods_recommend_batch_handle'];?> </h3>
      <ul class="tab-base">
      <li><a href="index.php?act=goods&op=goods" ><span><?php echo $lang['goods_index_all_goods'];?></span></a></li>
      <li><a href="index.php?act=goods&op=goods&goods_state=1" ><span><?php echo $lang['goods_index_lock_goods'];?></span></a></li>
      <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit_all'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" value="<?php echo $output['goods_id'];?>" name="goods_id">
    <input type="hidden" value="<?php echo $output['goods_state'];?>" name="goods_state">
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['goods_index_class_name'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><div id="gcategory" class="change-select-3">
              <select>
                <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
                <?php foreach($output['goods_class'] as $val) { ?>
                <option value="<?php echo $val['gc_id']; ?>"><?php echo $val['gc_name']; ?></option>
                <?php } ?>
              </select>
              <input type="hidden" id="cate_id" name="cate_id" value="" class="mls_id" />
              <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
            </div></td>
          <td class="vatop tips"><?php echo $lang['goods_edit_not_choose'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['goods_index_brand'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="brand_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(is_array($output['brand_list'])){ ?>
              <?php foreach($output['brand_list'] as $k => $v){ ?>
              <option value="<?php echo $v['brand_id'];?>"><?php echo $v['brand_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"><?php echo $lang['goods_edit_keep_blank'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['goods_edit_lock_state'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="radio" checked="checked" value="-1" name="set_goods_state" id="goods_index_unchanged">
                <label for="goods_index_unchanged"><?php echo $lang['goods_index_unchanged'];?></label>
              </li>
              <li>
                <input type="radio" value="1" name="set_goods_state" id="goods_index_lock">
                <label for="goods_index_lock"><?php echo $lang['goods_index_lock'];?></label>
              </li>
              <li>
                <input type="radio" value="0" name="set_goods_state" id="goods_edit_allow_sell">
                <label for="goods_edit_allow_sell"><?php echo $lang['goods_edit_allow_sell'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <tr style="display: none;" id="close_reason">
          <td colspan="2" class="required"><label for="close_reason"><?php echo $lang['goods_edit_lock_reason'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea rows="6" class="tarea" cols="60" name="goods_close_reason" id="goods_close_reason"></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="javascript:document.form1.submit();" class="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
	gcategoryInit("gcategory");
});
</script>