<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['recommend_index_type'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=recommend&op=recommend" ><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['recommend_goods_recommend'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['recommend_index_type'];?></th>
          <td><select onchange="location='index.php?act=recommend&op=recommend_goods&recommend_id=' + this.value" class="infoTableSelect">
              <?php if(!empty($output['recommend_list']) && is_array($output['recommend_list'])){ ?>
              <?php foreach($output['recommend_list'] as $k => $v){ ?>
              <option <?php if($v['recommend_id'] == $output['recommend_id']){ ?>selected=""<?php } ?> value="<?php echo $v['recommend_id'];?>"><?php echo $v['recommend_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
      </tbody>
    </table>
  <form method='post' onsubmit="if(confirm('<?php echo $lang['recommend_goods_ensure_cancel'];?>?')){return true;}else{return false;}" name="postForm">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="recommend_id" value="<?php echo $output['recommend_id'];?>" />
    <table class="table tb-type2">
      <thead><tr class="space">
        <th colspan="15"><?php echo $lang['nc_list'];?></th>
      </tr>
        <tr class="thead">
          <th class="w24"></th>
          <th class="w48"><?php echo $lang['nc_sort'];?></th>
          <th class="w48" colspan="2"><?php echo $lang['recommend_goods_name'];?></th>
          <th><?php echo $lang['recommend_goods_class_name'];?></th>
          <th class="w156"><?php echo $lang['recommend_goods_brand'];?></th>
          <th><?php echo $lang['recommend_goods_click'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>
        <?php foreach($output['goods_list'] as $k => $v){ ?>
        <tr class="hover">
          <td><input type="checkbox" name="goods_id[]" value="<?php echo $v['goods_id'];?>" class="checkitem"></td>
          <td class="sort"><span title="<?php echo $lang['nc_editable'];?>" style="cursor:pointer;"  class="editable" maxvalue="255" datatype="pint" fieldid="<?php echo $v['goods_id'].','.$output['recommend_id'];?>" ajax_branch="sort" fieldname="sort" nc_type="inline_edit"><?php echo $v['sort']?></span></td>
          <td><div class="goods-picture"><span class="thumb size44 "><i></i><img src="<?php echo thumb($v,'tiny');?>"  onload="javascript:DrawImage(this,44,44);"/></span></div></td>
          <td><p><a href="<?php echo SiteUrl."/index.php?act=goods&goods_id=".$v['goods_id'];?>" target="_blank"><?php echo $v['goods_name'];?></a></p>
            <p class="store"><?php echo $lang['recommend_goods_store_name'];?>:<a href="<?php echo SiteUrl."/index.php?act=show_store&id=".$v['store_id'];?>" target="_blank"><?php echo $v['store_name'];?></a></p></td>
          <td><?php echo $v['gc_name'];?></td>
          <td><?php echo $v['brand_name'];?></td>
          <td><?php echo $v['goods_click']?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?><?php echo $lang['recommend_goods_choose'];?> <a href="index.php?act=goods&op=goods&search_show=1" style=" color: red; margin: 0 4px; text-decoration:underline;"><?php echo $lang['recommend_goods_choose1'];?></a> <?php echo $lang['recommend_goods_choose2'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td><input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td colspan="16">
          	<label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label>
          	<a href="JavaScript:void(0);" class="btn" onclick="document.postForm.submit()"><span><?php echo $lang['recommend_goods_cancel_recommend'];?></span></a>
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script>