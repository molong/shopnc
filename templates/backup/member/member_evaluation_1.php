<?php defined('InShopNC') or exit('Access Invalid!');?>

<tbody>
  <?php foreach ((array)$output['goodsevallist'] as $k=>$v){?>
  <tr class="bd-line ncgeval">
    <td class="<?php echo 'ncgeval-'.$v['geval_scoressign'];?>"><span class="ico"></span></td>
    <td class="tl"><p><?php echo $v['geval_content'];?></p>
      <?php if (!empty($v['geval_explain'])){?>
      <p style="color:#996600;padding:5px 0px;">[<?php echo $lang['member_evaluation_explain'];?>]<?php echo $v['geval_explain'];?></p>
      <?php }?>
      <p class="date">[<?php echo @date('Y-m-d H:i:s',$v['geval_addtime']);?>]</p></td>
    <td><p><?php echo $v['geval_frommembername'];?> </p>
      <p>
        <?php if (empty($v['credit_arr'])){ echo $lang['member_evaluation_buyer_credit'].$lang['nc_colon'].$v['member_credit']; }else {?>
        <span class="buyer-<?php echo $v['credit_arr']['grade']; ?> level-<?php echo $v['credit_arr']['songrade']; ?>"></span>
        <?php }?>
      </p></td>
    <td class="tl"><p><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['geval_goodsid']), 'goods'); ?>"><?php echo $v['geval_goodsname']?></a></p>
      <p> <?php echo $v['geval_goodsprice'];?><?php echo $lang['currency_zh'];?></p></td>
    <td><?php if ($v['able_explain'] && $v['geval_scores']<1 && empty($v['geval_explain'])){?>
      <a href="javascript:void(0)" onclick="window.location='index.php?act=<?php echo $output['pj_act'];?>&op=explain&id=<?php echo $v['geval_id'];?>'" class="ncu-btn2"><?php echo $lang['member_evaluation_explain'];?></a>
      <?php }?></td>
  </tr>
  <?php }?>
</tbody>
