<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_class_export_data'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=flea_class&op=goods_class"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=flea_class&op=goods_class_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['goods_class_index_export'];?></span></a></li>
        <li><a href="index.php?act=flea_class&op=goods_class_import"><span><?php echo $lang['goods_class_index_import'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['goods_class_export_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="if_convert" value="1" />
    <table class="table tb-type2">
    <thead>
        <tr class="thead">
          <th><?php echo $lang['goods_class_export_if_trans'];?>?</th>
      </tr></thead>
      <tfoot><tr class="tfoot">
        <td><a href="JavaScript:document.form1.submit();" class="btn"><span><?php echo $lang['goods_class_export_export'];?></span></a></td>
      </tr></tfoot>
    </table>
  </form>
</div>
