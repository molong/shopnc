<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncu-form-style evaledit_form">
  <h4 style="padding-left:20px;height:30px;"><?php echo $lang['member_evaluation_modtogood'];?></h4>
  <div class="ncm-notes">
    <h3><?php echo $lang['member_evaluation_modtogood_tip'].$lang['nc_colon'];?></h3>
    <ul>
      <li><?php echo $lang['member_evaluation_modtogood_tip1'];?></li>
      <li><?php echo $lang['member_evaluation_modtogood_tip2'];?></li>
    </ul>
  </div>
  <form method="post" action="index.php?act=<?php echo $output['pj_act'];?>&op=editgood&id=<?php echo $output['info']['geval_id']; ?>">
    <input type="hidden" name="form_submit" value="ok"/>
    <dl>
      <dt><?php echo $lang['member_evaluation_tomembertitle'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['geval_tomembername'];?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_relatedgoods'].$lang['nc_colon'];?></dt>
      <dd><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$output['info']['geval_goodsid']), 'goods'); ?>"><?php echo $output['info']['geval_goodsname']?></a></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_title'].$lang['nc_colon'];?></dt>
      <dd>
        <input name='score' checked="checked" type="radio"/>
        <?php echo $lang['member_evaluation_good']; ?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_comment'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $lang['member_evaluation_modtogood_tip3'];?><br>
        <textarea name="content" rows="3" class="w600"><?php echo $output['info']['geval_content'];?></textarea>
      </dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd>
        <input id="submit_group" type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
      </dd>
    </dl>
  </form>
</div>
