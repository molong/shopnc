<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['complain_message'];?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th><?php echo $lang['final_handle_message'];?></th>
    </tr>
    <tr class="noborder hover">
      <td><ul>
          <li><strong><?php echo $lang['complain_state'];?>:</strong><b><?php echo $output['complain_info']['complain_state_text'];?></b></li>
          <li><strong><?php echo $lang['complain_type'];?>:</strong><?php echo $output['complain_info']['complain_type_text'];?></li>
          <li><strong><?php echo $lang['complain_subject_content'];?>:</strong><?php echo $output['complain_info']['complain_subject_content'];?></li>
          <li><strong><?php echo $lang['complain_accuser'];?>:</strong><?php echo $output['complain_info']['accuser_name'];?></li>
          <li><strong><?php echo $lang['complain_evidence'];?>:</strong>
            <?php 
                        if(empty($output['complain_info']['complain_pic1'])&&empty($output['complain_info']['complain_pic2'])&&empty($output['complain_info']['complain_pic3'])) {
                            echo $lang['complain_pic_none'];
                        }
                        else {
                            $pic_link = '/index.php?act=show_pics&type=complain&pics=';
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
          </li>
          <li><strong><?php echo $lang['complain_datetime'];?>:</strong><?php echo date('Y-m-d H:i:s',$output['complain_info']['complain_datetime']);?></li>
        </ul></td>
    </tr>
    <tr>
      <th><?php echo $lang['complain_goods'];?></th>
    </tr>
    <tr class="noborder">
      <td><table class="table tb-type2 goods ">
          <tr>
            <th colspan="2"><?php echo $lang['complain_goods_name'];?></th>
            <th><?php echo $lang['complain_text_num'];?></th>
            <th><?php echo $lang['complain_text_price'];?></th>
          </tr>
          <?php foreach((array)$output['complain_goods_list'] as $complain_goods) { ?>
          <tr>
            <td width="65" align="center" valign="middle"><a style="text-decoration:none;" href="<?php echo SiteUrl.'/index.php?act=goods&goods_id='.$complain_goods['goods_id'];?>" target="_blank">
              <img width="50" src="<?php echo cthumb($complain_goods['goods_image'],'tiny',$output['order_info']['store_id']);?>" />
              </a></td>
            <td class="intro"><p><a href="<?php echo  SiteUrl.'/index.php?act=goods&goods_id='.$complain_goods['goods_id'];?>" target="_blank"> <?php echo $complain_goods['goods_name'];?> </a></p>
              <p><span><?php echo $complain_goods['spec_info'];?></span> </p></td>
            <td width="10%"><?php echo $complain_goods['goods_num'];?></td>
            <td width="10%"><?php echo $lang['currency'].$complain_goods['goods_price'];?></td>
          </tr>
          <tr class="problem_desc">
            <td colspan="4"><div class="complain-tit"><span><?php echo $lang['complain_text_problem'];?>:</span><?php echo $complain_goods['complain_message'];?></div></td>
          </tr>
          <?php } ?>
        </table></td>
    </tr>
    <tr>
      <th><?php echo $lang['complain_content'];?></th>
    </tr>
    <tr class="noborder">
      <td><div class="complain-intro" style=" color: #06C; border-color: #A7CAED; "><?php echo $output['complain_info']['complain_content'];?></div></td>
    </tr>
  </tbody>
</table>
<?php if(!empty($output['refund']) && is_array($output['refund'])) { ?>
<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['refund_message'];?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo $lang['refund_order_refund'];?>:<?php echo $lang['currency'].$output['refund']['order_refund'];?></td>
    </tr>
    <tr>
      <th><?php echo $lang['refund_buyer_message'];?></th>
    </tr>
    <tr class="noborder">
      <td><div class="complain-intro" style=" color: #06C; border-color: #A7CAED; "><?php echo $output['refund']['buyer_message'];?></div></td>
    </tr>
    <tr>
      <th><?php echo $lang['refund_seller_message'];?></th>
    </tr>
    <tr class="noborder">
      <td><div class="complain-intro" style=" color: #06C; border-color: #A7CAED; "><?php echo $output['refund']['refund_message'];?></div></td>
    </tr>
  </tbody>
</table>
<?php } ?>