<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <?php if($output['unpublish']) { ?>
    <a class="ncu-btn3" href="index.php?act=store_promotion_xianshi&op=choose_goods&xianshi_id=<?php echo $output['xianshi_info']['xianshi_id'];?>"><?php echo $lang['goods_add'];?></a>
    <?php } ?>
  </div>
<table class="ncu-table-style">
    <tbody>
      <tr>
        <td class="w90 tr"><strong><?php echo $lang['xianshi_name'].$lang['nc_colon'];?></strong></td>
        <td class="w120 tl"><?php echo $output['xianshi_info']['xianshi_name'];?></td>
        <td class="w90 tr"><strong><?php echo $lang['start_time'].$lang['nc_colon'];?></strong></td>
        <td class="w120 tl"><?php echo date('Y-m-d',$output['xianshi_info']['start_time']);?></td>
        <td class="w90 tr"><strong><?php echo $lang['end_time'].$lang['nc_colon'];?></strong></td>
        <td class="w120 tl"><?php echo date('Y-m-d',$output['xianshi_info']['end_time']);?></td>
        <td class="w90 tr"><strong><?php echo $lang['nc_state'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['state_list'][$output['xianshi_info']['state']];?></td>
      </tr>
      <tr>
        <td class="tr"><strong><?php echo $lang['text_default'].$lang['xianshi_discount'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['xianshi_info']['discount'].$lang['nc_xianshi_flag'];?></td>
        <td class="tr"><strong><?php echo $lang['xianshi_quota_goods_limit'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['xianshi_info']['goods_limit'];?></td>
        <td class="tr"><strong><?php echo $lang['xianshi_goods_selected'].$lang['nc_colon'];?></strong></td>
        <td class="tl"><?php echo $output['xianshi_goods_count'];?></td>
        <td></td>
        <td></td>
      </tr>
    <tfoot>
      <tr>
        <td colspan="20"></td>
      </tr>
    </tfoot>
  </table>
  <div class="select_div">
    <form method="get">
      <table class="search-form">
        <input type="hidden" name="act" value="store_promotion_xianshi" />
        <input type="hidden" name="op" value="choose_goods" />
        <input type="hidden" name="xianshi_id" value="<?php echo $output['xianshi_info']['xianshi_id'];?>" />
        <tr>
          <td>&nbsp;</td>
          <th><?php echo $lang['goods_name'].$lang['nc_colon'];?></th>
          <td class="w150"><input type="text" class="text" name="goods_name" value="<?php echo $_GET['goods_name'];?>"/></td>
          <td class="w90 tc"><input type="submit" value="<?php echo $lang['nc_search'];?>" class="submit"/></td>
        </tr>
      </table>
    </form>
  </div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w70"></th>
        <th class="tl"><?php echo $lang['goods_name'];?></th>
        <th class="w150"><?php echo $lang['goods_store_price'];?></th>
        <th class="w90"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <?php if(!empty($output['list']) && is_array($output['list'])){?>
    <?php foreach($output['list'] as $key=>$val){?>
    <tbody>
      <tr class="bd-line">
        <td></td>
        <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><img src="<?php echo cthumb($val['goods_image'],'tiny',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
        <td><dl class="goods-name">
            <dt><a href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><?php echo $val['goods_name']; ?></a></dt>
          </dl></td>
        <td class="goods-price"><?php echo $val['goods_store_price'];?></td>
        <td><?php if(in_array($val['goods_id'],$output['xianshi_goods_id_list'])) { ?>
          <?php echo $lang['xianshi_goods_exist'];?>
          <?php } else { ?>
          <a href="javascript:void(0)" id="xianshi_goods_<?php echo $val['goods_id'];?>" class="ncu-btn2" onClick="xianshi_goods_add(<?php echo $val['goods_id'];?>)"><?php echo $lang['text_add'];?></a>
          <?php } ?></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <?php if(!empty($output['list']) && is_array($output['list'])){?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php }?>
    </tfoot>
  </table>
  <div class="ncu-form-style tc mb30">
    <input type="submit"  class="submit" id="submit_group" value="<?php echo $lang['nc_back'].$lang['xianshi_manage'];?>" onclick="window.location='index.php?act=store_promotion_xianshi&op=xianshi_manage&xianshi_id=<?php echo $output['xianshi_info']['xianshi_id'];?>'">
  </div>
</div>
<script type="text/javascript">
function xianshi_goods_add(goods_id) {
   $.get("index.php?act=store_promotion_xianshi&op=xianshi_goods_add", { xianshi_id: <?php echo $output['xianshi_info']['xianshi_id'];?>, goods_id: goods_id },
        function(data){
            if(data == "success") {
                $("#xianshi_goods_"+goods_id).text('<?php echo $lang['xianshi_goods_exist'];?>');
                $("#xianshi_goods_"+goods_id).attr('onClick','');
                $("#xianshi_goods_"+goods_id).attr('class','');
            }
            else {
                alert('<?php echo $lang['xianshi_goods_add_fail'];?>');
            }
        });
}
</script>