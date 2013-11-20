<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['groupbuy_index_manage'];?></h3>
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
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['groupbuy_recommend_help1'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method="post">
    <input type="hidden" id="group_id" name="group_id"  />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th colspan="2"><?php echo $lang['groupbuy_index_name'];?></th>
          <th><?php echo $lang['groupbuy_template_name'];?></th>
          <th class="align-center"><?php echo $lang['groupbuy_index_start_time'];?></th>
          <th class="align-center"><?php echo $lang['groupbuy_index_end_time'];?></th>
          <th class="align-center"><?php echo $lang['groupbuy_index_state'];?></th>
          <th class="align-center"><?php echo $lang['groupbuy_index_click'];?></th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $val){ ?>
        <tr class="hover">
          <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><a target="_blank" href="<?php echo SiteUrl."/index.php?act=show_groupbuy&op=groupbuy_detail&group_id=".$val['group_id'];?>"><img src="<?php echo SiteUrl.'/upload/groupbuy/'.$val['group_pic'];?>"  onload="javascript:DrawImage(this,56,56);"/></a></span></div></td>
          <td class="group"><p><a target="_blank" href="<?php echo SiteUrl."/index.php?act=show_groupbuy&op=groupbuy_detail&group_id=".$val['group_id'];?>"><?php echo $val['group_name'];?></a></p>
            <p class="goods"><?php echo $lang['groupbuy_index_goods_name'];?>:<a target="_blank" href="<?php echo SiteUrl."/index.php?act=goods&goods_id=".$val['goods_id'];?>" title="<?php echo $val['goods_name'];?>"><?php echo $val['goods_name'];?></a></p>
            <p class="store"><?php echo $lang['groupbuy_index_store_name'];?>:<a target="_blank" href="<?php echo SiteUrl."/index.php?act=show_store&id=".$val['store_id'];?>" title="<?php echo $val['store_name'];?>"><?php echo $val['store_name'];?></a></p></td>
          <td><?php echo $val['template_name'];?></td>
          <td  class="align-center nowarp"><?php echo date('Y'.$lang['nc_year'].'m'.$lang['nc_month'].'d'.$lang['nc_day'],$val['start_time']);?></td>
          <td  class="align-center nowarp"><?php echo $val['end_time']==0?$lang['groupbuy_index_long_group']:date('Y'.$lang['nc_year'].'m'.$lang['nc_month'].'d'.$lang['nc_day'],$val['end_time']);?></td>
          <td class="align-center"><?php 
$group_state = $val['state'];
echo $output['state_list'][$group_state];
?></td>
          <td class="align-center"><?php echo $val['views']==0?'0':$val['views'];?></td>
          <td class="yes-onoff align-center"><?php if($val['recommended'] == '0'){ ?>
            <a href="JavaScript:void(0);" class="tooltip disabled" ajax_branch='recommended' nc_type="inline_edit" fieldname="recommended" fieldid="<?php echo $val['group_id']?>" fieldvalue="0" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"></a>
            <?php }else { ?>
            <a href="JavaScript:void(0);" class="tooltip enabled" ajax_branch='recommended' nc_type="inline_edit" fieldname="recommended" fieldid="<?php echo $val['group_id']?>" fieldvalue="1" title="<?php echo $lang['nc_editable'];?>"><img src="<?php echo TEMPLATES_PATH;?>/images/transparent.gif"></a>
            <?php } ?></td>
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
          <td colspan="16"><label>
            &nbsp;&nbsp; 
            <div class="pagination"><?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
