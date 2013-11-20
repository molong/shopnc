<h3><?php echo $lang['complain_detail'];?></h3>
<h4><?php echo $lang['complain_message'];?></h4>
<dl>
  <dt><?php echo $lang['complain_state'].$lang['nc_colon'];?></dt>
  <dd><?php echo $output['complain_info']['complain_state_text'];?></dd>
  <dt><?php echo $lang['complain_type'].$lang['nc_colon'];?></dt>
  <dd><?php echo $output['complain_info']['complain_type_text'];?></dd>
  <dt><?php echo $lang['complain_subject_content'].$lang['nc_colon'];?></dt>
  <dd><?php echo $output['complain_info']['complain_subject_content'];?></dd>
  <dt><?php echo $lang['complain_accuser'].$lang['nc_colon'];?></dt>
  <dd><?php echo $output['complain_info']['accuser_name'];?></dd>
  <dt><?php echo $lang['complain_evidence'].$lang['nc_colon'];?></dt>
  <dd>
    <?php 
                        if(empty($output['complain_info']['complain_pic1'])&&empty($output['complain_info']['complain_pic2'])&&empty($output['complain_info']['complain_pic3'])) {
                            echo $lang['complain_pic_none'];
                            if((intval($output['complain_info']['complain_state'])<99) && ($output['complain_info']['complain_type'] == 1) && ($output['complain_info']['accuser_id'] == $_SESSION['member_id'])) {
                            ?>
                            <a href="javascript:void(0)" nc_type="dialog" dialog_title="<?php echo $lang['complain_add_pic'];?>" dialog_id="complain_add_pic" dialog_width="400" uri="index.php?act=member_complain&op=complain_add_pic&complain_id=<?php echo $output['complain_info']['complain_id']; ?>" id="complain_add_pic"><?php echo $lang['complain_add_pic'];?></a>
                            <?php
                            }
                        }
                        else {
                            $pic_link = SiteUrl.'/index.php?act=show_pics&type=complain&pics=';
                            if(!empty($output['complain_info']['complain_pic1'])) {
                                $pic_link .= $output['complain_info']['complain_pic1'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic2'])) {
                                $pic_link .= $output['complain_info']['complain_pic2'].'|';
                            }
                            if(!empty($output['complain_info']['complain_pic3'])) {
                                $pic_link .= $output['complain_info']['complain_pic3'].'|';
                            }
                            $pic_link = rtrim($pic_link,'|'); 
                    ?>
    <a href="<?php echo $pic_link;?>" target="_blank"><?php echo $lang['complain_pic_view'];?></a>
    <?php } ?>
  </dd>
  <dt><?php echo $lang['complain_datetime'].$lang['nc_colon'];?></dt>
  <dd><?php echo date('Y-m-d H:i:s',$output['complain_info']['complain_datetime']);?></dd>
</dl>
<h4><?php echo $lang['complain_goods'];?></h4>
<table class="order ncu-table-style">
  <thead>
    <tr>
      <th class="w10"></th>
      <th class="w70"></th>
      <th class="tl"><?php echo $lang['complain_goods_name'];?></th>
      <th class="w200"><?php echo $lang['complain_text_num'];?></th>
      <th class="w200"><?php echo $lang['complain_text_price'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach((array)$output['complain_goods_list'] as $complain_goods) { ?>
    <tr>
      <td class="sep-row" colspan="19"></td>
    </tr>
    <tr>
      <th colspan="20"><span class="ml10"><?php echo $lang['complain_text_problem'].$lang['nc_colon'];?><?php echo $complain_goods['complain_message'];?></span></th>
    </tr>
    <tr>
      <td class="bdl"></td>
      <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$complain_goods['goods_id']), 'goods');?>" target="_blank"> <img onload="javascript:DrawImage(this,60,60);" src="<?php echo cthumb($complain_goods['goods_image'],'tiny',$output['order_info']['store_id']);?>"/> </a></span></div></td>
      <td><dl class="goods-name">
          <dt><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$complain_goods['goods_id']), 'goods');?>" target="_blank"> <?php echo $complain_goods['goods_name'];?> </a></dt>
          <dd><?php echo $complain_goods['spec_info'];?></dd>
        </dl></td>
      <td class="bdl"><?php echo $complain_goods['goods_num'];?></td>
      <td class="bdl bdr"><em class="goods-price"><?php echo $complain_goods['goods_price'];?></em></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20"></td>
    </tr>
  </tfoot>
</table>
<h4><?php echo $lang['complain_content'].$lang['nc_colon'];?></h4>
<dl>
  <dd style="width:90%; padding-left:24px;"><?php echo $output['complain_info']['complain_content'];?></dd>
</dl>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
