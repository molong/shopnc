<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
<div class="fixed-bar">
  <div class="item-title">
    <h3><?php echo $lang['nc_coupon_class_manage'];?></h3>
    <ul class="tab-base">
      <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
      <li><a href="index.php?act=coupon_class&op=update"><span><?php echo $lang['nc_new'];?></span></a></li>
    </ul>
  </div>
</div>
<div class="fixed-empty"></div>
<div class="info2">
  <form method='post' id="list">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2" id="prompt">
      <tbody>
        <tr class="space odd">
          <th colspan="12"><div class="title">
              <h5><?php echo $lang['nc_prompts'];?></h5>
              <span class="arrow"></span></div></th>
        </tr>
        <tr>
          <td><ul>
              <li><?php echo $lang['coupon_class_help1'];?></li>
            </ul></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th><?php echo $lang['coupon_class_sort'];?></th>
          <th><?php echo $lang['coupon_class_name'];?></th>
          <th class="align-center"><?php echo $lang['nc_display'];?> </th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover">
          <td class="w48"><?php echo $v['class_sort'];?></td>
          <td class="w50pre"><?php echo $v['class_name'];?></td>
          <td class="align-center"><?php switch($v['class_show']){
					case '0':
						echo $lang['nc_no'];
						break ;
					case '1':
						echo $lang['nc_yes'];
						break ;
				}?></td>
          <td class="w150 align-center"><a href="index.php?act=coupon_class&op=update&class_id=<?php echo $v['class_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=coupon_class&form_submit=ok&class_id=<?php echo $v['class_id'];?>';}else{return false;}"><?php echo $lang['nc_del'];?></a></td>
          <?php } ?>
          <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr>
          <td id="batchAction" colspan="16"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
