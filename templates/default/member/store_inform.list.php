<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th class="w10"></th>
        <th class="w200 tl"><?php echo $lang['inform_goods_name'];?></th>
        <th class="w100"><?php echo $lang['inform_type'];?></th>
        <th><?php echo $lang['inform_subject'];?></th>
        <th class="w70"><?php echo $lang['inform_pic'];?></th>
        <th class="w100"><?php echo $lang['inform_datetime'];?></th>
        <th class="w80"><?php echo $lang['inform_handle_type'];?></th>
        <th class="w70"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php  if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
        <td></td>
        <td class="tl"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$val['inform_goods_id']), 'goods');?>" target="_blank"> <?php echo $val['inform_goods_name']; ?> </a></td>
        <td><?php echo $val['inform_subject_type_name'];?></td>
        <td><?php echo $val['inform_subject_content'];?></td>
        <td><?php 
                        if(empty($val['inform_pic1'])&&empty($val['inform_pic2'])&&empty($val['inform_pic3'])) {
                            echo $lang['inform_pic_none'];
                        }
                        else {
                            $pic_link = SiteUrl.'/index.php?act=show_pics&type=inform&pics=';
                            if(!empty($val['inform_pic1'])) {
                                $pic_link .= $val['inform_pic1'].'|';
                            }
                            if(!empty($val['inform_pic2'])) {
                                $pic_link .= $val['inform_pic2'].'|';
                            }
                            if(!empty($val['inform_pic3'])) {
                                $pic_link .= $val['inform_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|'); 
                    ?>
          <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['inform_pic_view'];?></a>
          <?php } ?></td>
        <td class="goods-time"><?php echo date("Y-m-d",$val['inform_datetime']);?></td>
        <td><?php 
                          if($val['inform_handle_type']==='1') echo $lang['inform_handle_type_unuse'];
                          if($val['inform_handle_type']==='2') echo $lang['inform_handle_type_venom']; 
                          if($val['inform_handle_type']==='3') echo $lang['inform_handle_type_valid']; 
                      ?></td>
        <td><a href="javascript:void(0)" class="show_detail"><?php echo $lang['nc_detail'];?></a></td>
      </tr>
      <tr class="inform_detail">
        <td colspan="20"><div class="shadow">
            <dl>
              <dt><?php echo $lang['inform_content'].$lang['nc_colon'];?></dt>
              <dd><?php echo $val['inform_content'];?></dd>
            </dl>
            <dl style="border-bottom:0;">
              <dt><?php echo $lang['inform_handle_message'].$lang['nc_colon']?></dt>
              <dd>
                <?php 
                          if(empty($val['inform_handle_message'])) {
                              echo $lang['inform_text_none'];
                          }
                          else {
                              echo $val['inform_handle_message'].'('.date("Y-m-d",$val['inform_handle_datetime']).')';
                          }
                      ?>
              </dd>
            </dl>
            <div class="close_detail"><a href="JavaScript:void(0);" title="<?php echo $lang['nc_close'];?>"><?php echo $lang['nc_close'];?></a></div>
          </div></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $(".inform_detail").hide();
    $(".show_detail").click(function(){
        $(".inform_detail").hide();
        $(this).parents("tr").next(".inform_detail").show();
    });
    $(".close_detail").click(function(){
        $(this).parents(".inform_detail").hide();
    });
});
</script> 
