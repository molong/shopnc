<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
function submit_cancel_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_cancel(items);
    }  
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_cancel(id){
    if(confirm('<?php echo $lang['nc_ensure_cancel'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=promotion_xianshi&op=xianshi_quota_cancel');
        $('#object_id').val(id);
        $('#list_form').submit();
    }
}
</script>

<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['promotion_xianshi'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['xianshi_name'].':'.$output['xianshi_info']['xianshi_name'];?></li>
            <li>
            <?php echo $lang['start_time'].':'.date('Y-m-d',$output['xianshi_info']['start_time']).' '.$lang['end_time'].':'.date('Y-m-d',$output['xianshi_info']['end_time']).'  '.$lang['nc_state'].':'.$output['state_list'][$output['xianshi_info']['state']];?>
            </li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <!-- 列表 -->
  <form id="list_form" method="post">
    <input type="hidden" id="object_id" name="object_id"  />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
        <th width="50"></th>
        <th class="align-left"><span><?php echo $lang['goods_name'];?></span></th>
        <th class="align-center" width="120"><span><?php echo $lang['goods_store_price'];?></span></th>
        <th class="align-center" width="120"><span><?php echo $lang['xianshi_discount'];?></span></th>
        <th class="align-center" width="120"><span><?php echo $lang['xianshi_buy_limit'];?></span></th>
        <th class="align-center" width="60"><span><?php echo $lang['nc_state'];?></span></th>
          </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
            <td valign="middle" class="align2"><a href="<?php echo SiteUrl.DS;?>index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><img src="<?php echo $val['goods_image'];?>" onload="javascript:DrawImage(this,50,50);" /></a></td>
            <td class="align-left"><a href="<?php echo SiteUrl.DS;?>index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><span><?php echo $val['goods_name']; ?></span></a></td>
        <td class="align-center"><span><?php echo $val['goods_store_price'];?></span></td>
        <td class="align-center"><span><?php echo $val['discount'];?></span></td>
        <td class="align-center"><span><?php echo $val['buy_limit'];?></span></td>
        <td class="align-center"><span><?php echo $output['xianshi_goods_state_list'][$val['state']];?></span></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="16"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td colspan="16">
              <div class="pagination"> <?php echo $output['show_page'];?> </div>
      </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
