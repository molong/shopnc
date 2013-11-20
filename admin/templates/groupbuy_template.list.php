<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
function submit_delete_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_delete(items);
    }  
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_delete(id){
    if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=groupbuy&op=groupbuy_template_drop');
        $('#template_id').val(id);
        $('#list_form').submit();
    }
}

</script>
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
        </div>
    </div>
    <div class="fixed-empty"></div>
    <!-- 操作说明 -->
    <table class="table tb-type2" id="prompt">
        <tbody>
        <tr class="space odd">
            <th colspan="12" class="nobg"><div class="title">
                    <h5><?php echo $lang['nc_prompts'];?></h5>
                    <span class="arrow"></span></div></th>
        </tr>
        <tr>
            <td><ul>
                    <li><?php echo $lang['groupbuy_template_help1'];?></li>
                    <li><?php echo $lang['groupbuy_template_help2'];?></li>
                    <li><?php echo $lang['groupbuy_template_help3'];?></li>
                    <li><?php echo $lang['groupbuy_template_help4'];?></li>
            </ul></td>
        </tr>
        </tbody>
    </table>
    <form id="list_form" method='post'>
        <input id="template_id" name="template_id" type="hidden" />
        <table class="table tb-type2">
            <thead>
                <tr class="space">
                    <th colspan="15" class="nobg"><?php echo $lang['nc_list'];?></th>
                </tr>
                <tr class="thead">
                    <th></th>
                    <th><?php echo $lang['groupbuy_template_name'];?></th>
                    <th class="align-center"><?php echo $lang['start_time'];?></th>
                    <th class="align-center"><?php echo $lang['end_time'];?></th>
                    <th class="align-center"><?php echo $lang['join_end_time'];?></th>
                    <th class="align-center"><?php echo $lang['nc_status'];?></th>
                    <th class="align-center"><?php echo $lang['nc_handle'];?></th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
            <?php foreach($output['list'] as $val){ ?>
            <tr class="hover edit <?php echo $val['class_parent_id']=='0'?'':'two';?> <?php echo 'parent'.$val['class_parent_id'];?>">
                <td class="w36">
                    <input type="checkbox" value="<?php echo $val['template_id'];?>" class="checkitem">
                </td>
                <td><?php echo $val['template_name'];?></td>
                <td class="align-center"><?php echo date("Y-m-d H:i",$val['start_time']);?></td>
                <td class="align-center"><?php echo date("Y-m-d H:i",$val['end_time']);?></td>
                <td class="align-center"><?php echo date("Y-m-d H:i",$val['join_end_time']);?></td>
                <td class="align-center">
                <?php 
                if(intval($val['state']) === 1) {
                    if(intval($val['start_time']) > time()) {
                        echo $lang['state_text_notstarted'];
                    } else {
                        if(intval($val['end_time']) > time()) {
                            echo $lang['state_text_in_progress'];
                        } else {
                            echo $lang['state_text_closed'];
                        }
                    }
                } else {
                    echo $lang['state_text_closed'];
                }
                ?>
                </td>
                <td class="w156 align-center">
                    <a href="index.php?act=groupbuy&op=groupbuy_verify_list&template_id=<?php echo $val['template_id'];?>"><?php echo $lang['nc_manage'];?></a> 
                    <?php if(intval($val['state']) === 1) { ?>
                    <?php if(intval($val['start_time']) > time()) { ?>
                    |
                    <a href="javascript:void(0)" onclick="submit_delete('<?php echo $val['template_id'];?>');"><?php echo $lang['nc_del'];?></a> 
                    <?php } else { ?>

                    <?php if(intval($val['end_time']) > time()) { ?>
                    |
                    <a href="index.php?act=groupbuy&op=groupbuy_template_close&template_id=<?php echo $val['template_id'];?>"><?php echo $lang['nc_close'];?></a> 
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            <?php }else { ?>
            <tr class="no_data">
                <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
            </tr>
            <?php } ?>
            </tbody>
            <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
            <tfoot>
                <tr class="tfoot">
                    <td><input type="checkbox" class="checkall" id="checkall_1"></td>
                    <td id="batchAction" colspan="15"><span class="all_checkbox">
                            <label for="checkall_1"><?php echo $lang['nc_select_all'];?></label>
                        </span>&nbsp;&nbsp;
                        <a href="javascript:void(0)" class="btn" onclick="submit_delete_batch();"><span><?php echo $lang['nc_del'];?></span></a>
<div class="pagination"><?php echo $output['show_page'];?></div>
                    </tr>
                </tfoot>
                <?php } ?>
            </table>
        </form>
    </div>
