<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['promotion_mansong'];?></h3>
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
            <li><?php echo $lang['mansong_name'].':'.$output['mansong_info']['mansong_name'];?></li>
            <li>
            <?php echo $lang['start_time'].':'.date('Y-m-d',$output['mansong_info']['start_time']).' '.$lang['end_time'].':'.date('Y-m-d',$output['mansong_info']['end_time']).'  '.$lang['nc_state'].':'.$output['mansong_state_list'][$output['mansong_info']['state']];?>
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
        <th class="align-center" width="90"><span><?php echo $lang['text_level'];?></span></th>
        <th class="align-center" width="90"><span><?php echo $lang['level_price'];?></span></th>
        <th class="align-center" width="90"><span><?php echo $lang['shipping_free'];?></span></th>
        <th class="align-center" width="90"><span><?php echo $lang['level_discount'];?></span></th>
        <th class="align-left"><span><?php echo $lang['gift_name'];?></span></th>
          </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
        <td class="align-center"><span><?php echo $val['level'];?></span></td>
        <td class="align-center"><span><?php echo $val['price'];?></span></td>
        <td class="align-center"><span><?php echo empty($val['shipping_free'])?$lang['nc_no']:$lang['nc_yes'];?></span></td>
        <td class="align-center"><span><?php echo empty($val['discount'])?$lang['text_not_join']:$val['discount'];?></span></td>
        <?php if(empty($val['gift_name'])) { ?>
        <td class="align-left"><span><?php echo $lang['text_not_join'];?></span></td>
        <?php } else { ?>
        <td class="align-left">
            <span><?php echo $val['gift_name'];?></span>
            <?php if(!empty($val['gift_link'])) { ?>
            <a href="<?php echo $val['gift_link'];?>" target="_blank"><?php echo $lang['text_gift'].$lang['text_link'];?></a>
            <?php } ?>
        </td>
        <?php } ?>
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
