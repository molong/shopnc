<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_coupon_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=coupon&op=list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="filename" value="<?php echo $output['coupon']['coupon_pic']; ?>" />
    <input type="hidden" name="coupon_id" value="<?php echo $output['coupon']['coupon_id']; ?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['coupon_name'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['coupon']['coupon_title']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_price'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $lang['currency'].$output['coupon']['coupon_price']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_store_name'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['coupon']['store_name']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_class'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['class_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_lifetime'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo date('Y-m-d',$output['coupon']['coupon_start_date']); ?> ~ <?php echo date('Y-m-d',$output['coupon']['coupon_end_date']) ; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_pic'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show" style=" float:left;"><img src="<?php if(stripos($output['coupon']['coupon_pic'] ,'http://') === false ){ echo SiteUrl.'/'.$output['coupon']['coupon_pic'];}else{ echo $output['coupon']['coupon_pic'];  }?>" onload="javascript:DrawImage(this,320,145);" />
            <div class="type-file-preview"><img src="<?php if(stripos($output['coupon']['coupon_pic'] ,'http://') === false ){ echo SiteUrl.'/'.$output['coupon']['coupon_pic'];}else{ echo $output['coupon']['coupon_pic'];  }?>"></div>
            </span></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_notice'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['coupon']['coupon_desc']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['coupon_state'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="state1" class="cb-enable <?php if($output['coupon']['coupon_state'] == '2'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="state0" class="cb-disable <?php if($output['coupon']['coupon_state'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="state1" name="coupon_state" <?php if($output['coupon']['coupon_state'] == '2'){ ?>checked="checked"<?php } ?>  value="2" type="radio">
            <input id="state0" name="coupon_state" <?php if($output['coupon']['coupon_state'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['coupon_help1'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_recommend'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="lock1" class="cb-enable <?php if($output['coupon']['coupon_recommend'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="lock2" class="cb-disable <?php if($output['coupon']['coupon_recommend'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="lock1" name="coupon_recommend" <?php if($output['coupon']['coupon_recommend'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="lock2" name="coupon_recommend" <?php if($output['coupon']['coupon_recommend'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['coupon_help3'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(function(){$("#submitBtn").click(function(){
    $("#add_form").submit();
	});
});
</script>