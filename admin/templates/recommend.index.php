<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['recommend_index_type'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=recommend&op=recommend_add" ><span><?php echo $lang['nc_add'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="recommend" />
    <input type="hidden" name="op" value="recommend" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['recommend_index_type_name'];?></th>
          <td><input type="text" value="<?php echo $output['search_recommend_name']?>" name="search_recommend_name" class="txt"></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['recommend_index_help1'];?></li>
            <li><?php echo $lang['recommend_index_help2'];?></li>
            <li><?php echo $lang['recommend_index_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' onsubmit="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){return true;}else{return false;}">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          <th><?php echo $lang['recommend_index_type_name'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['recommend_list']) && is_array($output['recommend_list'])){ ?>
        <?php foreach($output['recommend_list'] as $k => $v){ ?>
        <tr class="hover">
          <td><!-- <input value="<?php echo $v['recommend_id']?>" class="checkitem" type="checkbox" name="del_recommend_id[]"> --></td>
          <td><?php echo $v['recommend_name'];?></td>
          <td class="w270 align-center"><a href="index.php?act=recommend&op=recommend_edit&recommend_id=<?php echo $v['recommend_id'];?>"><?php echo $lang['nc_edit'];?></a>
            <?php if (!in_array($v['recommend_code'],$output['recommend_retrieval'])){?>
            | <a href="javascript:if(confirm('<?php echo $lang['nc_ensure_del'];?>')){window.location='index.php?act=recommend&op=recommend_del&del_recommend_id=<?php echo $v['recommend_id'];?>';}"><?php echo $lang['nc_del'];?></a>
            <?php } ?>
            | <a href="index.php?act=recommend&op=recommend_goods&recommend_id=<?php echo $v['recommend_id'];?>"><?php echo $lang['recommend_index_view_goods'];?></a> | <a href="javascript:void(0)" onclick="prompt('<?php echo $lang['recommend_show'];?>', '<script type=&quot;text/javascript&quot; src=&quot;<?php echo SiteUrl;?>/api/goods/index.php?id=<?php echo $v['recommend_id'];?>&quot;></script>')"><?php echo $lang['recommend_http'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['recommend_list']) && is_array($output['recommend_list'])){ ?>
        <tr class="tfoot">
          <td colspan="15"><!--<input type="checkbox" class="checkall" id="checkallBottom"></td>
          <td><label for="checkallBottom"><?php echo $lang['nc_select_all']; ?></label></td>
          <td> <input type="submit" value="<?php echo $lang['nc_del'];?>" class="btn btn-red"> -->
            
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>

