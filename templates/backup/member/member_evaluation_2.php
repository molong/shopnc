<?php defined('InShopNC') or exit('Access Invalid!');?>

<tbody>
  <?php foreach ((array)$output['goodsevallist'] as $k=>$v){?>
  <tr class="bd-line ncgeval">
    <td class="<?php echo 'ncgeval-'.$v['geval_scoressign'];?>"><span class="ico"></span></td>
    <td class="tl"><p><?php echo $v['geval_content'];?></p>
      <?php if (!empty($v['geval_explain'])){?>
      <p>[<?php echo $lang['member_evaluation_explain'];?>]<?php echo $v['geval_explain'];?></p>
      <?php }?>
      <p class="goods-time">[<?php echo @date('Y-m-d H:i:s',$v['geval_addtime']);?>]</p></td>
    <td><p><a target="_blank" href="<?php echo ncUrl(array('act'=>'show_store','id'=>$v['store_id']),'store',$v['store_domain']);?>"><?php echo $v['geval_storename'];?></a></p>
      <p>
        <?php if (empty($v['credit_arr'])){ echo  $lang['member_evaluation_seller_credit'].$lang['nc_colon'].$v['store_credit']; }else {?>
        <span class="seller-<?php echo $v['credit_arr']['grade']; ?> level-<?php echo $v['credit_arr']['songrade']; ?>"></span>
        <?php }?>
      </p></td>
    <td class="tl"><p><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['geval_goodsid']), 'goods'); ?>"><?php echo $v['geval_goodsname']?></a></p>
      <p><?php echo $v['geval_goodsprice'];?><?php echo $lang['currency_zh'];?></p></td>
    <td><?php if ($v['able_edit']){?>
      <?php if ($v['geval_scores']<1){//评价为中差时可以修改为好评或者删除?>
      <a href="javascript:void(0)" onclick="window.location='index.php?act=<?php echo $output['pj_act'];?>&op=editgood&id=<?php echo $v['geval_id'];?>'">
      	<?php echo $lang['member_evaluation_modtogood'];?></a> <a href="javascript:void(0)" class="ncu-btn2 mt5" onclick="ajax_get_confirm('<?php echo $lang['member_evaluation_delrecord'];?>', 'index.php?act=<?php echo $output['pj_act'];?>&op=del&id=<?php echo $v['geval_id'];?>');"><?php echo $lang['nc_delete'];?></a>
      <?php }?>
      <?php if ($v['geval_isanonymous'] == '0' && $v['geval_type']==1){?>
      <a href="javascript:void(0)" class="ncu-btn2 mt5" onclick="window.location='index.php?act=<?php echo $output['pj_act'];?>&op=editanony&id=<?php echo $v['geval_id'];?>'"><?php echo $lang['member_evaluation_modtoanonymous'];?></a>
      <?php }?>
      <?php }?></td>
  </tr>
  <?php }?>
</tbody>
