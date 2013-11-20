<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_coupon_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=coupon&op=list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['coupon_allow_state'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method='post' id="formProcess">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" id="coupon_allowstate" name="coupon_allowstate" value="0" />
    <table class="table tb-type2 nobdb">
      <thead>
        <tr class="space">
          <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th></th>
          <th class="align-center"><?php echo $lang['coupon_pic'];?></th>
          <th><?php echo $lang['coupon_name'];?></th>
          <th class="align-center"><?php echo $lang['coupon_store_name'];?></th>
          <th class="align-center"><?php echo $lang['coupon_price'];?>(<?php echo $lang['currency_zh']; ?>)</th>
          <th class="align-center"><?php echo $lang['coupon_lifetime'];?></th>
          <th class="align-center"><?php echo $lang['coupon_allow'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name='coupon_id[]' value="<?php echo $v['coupon_id'];?>" class="checkitem"></td>
          <td class="w96 picture"><div class="size-88x44"><span class="thumb size-88x44"><i></i><img src="<?php if(stripos($v['coupon_pic'], 'http://') === false){echo SiteUrl.'/'.$v['coupon_pic'];}else{echo $v['coupon_pic'];}?>" onerror="this.src='<?php echo SiteUrl;?>/templates/<?php echo TPL_NAME;?>/images/default_coupon_image.png'" onload="javascript:DrawImage(this,88,44);"/></span></div></td>
          <td  class="name w270"><?php echo $v['coupon_title'];?></td>
          <td class="align-center"><?php echo $v['store_name'] ;?></td>
          <td class="align-center"><?php echo $v['coupon_price'] ;?></td>
          <td class="nowarp align-center"><p><?php echo date('Y-m-d',$v['coupon_start_date']);?>~<?php echo date('Y-m-d',$v['coupon_end_date']);?></p></td>
          <td class="align-center"><?php
					switch($v['coupon_allowstate']){
						case '0':echo $lang['coupon_allow_state'];break;
						case '1':echo $lang['coupon_allow_yes'];break;
						case '2':echo $lang['coupon_allow_no'];break ;
					}
				?></td>
          <td class="w72 align-center"><a href="index.php?act=coupon&op=apply_edit&coupon_id=<?php echo $v['coupon_id'];?>"><?php echo $lang['nc_edit'];?></a>&nbsp;</td>
        </tr>
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
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td colspan="16"><label for="checkall_2"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('1');"><span><?php echo $lang['nc_pass'];?></span></a>
            
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script>
function submit_form(state){
	$('#coupon_allowstate').val(state);
	$('#formProcess').submit();
}
</script> 