<?php defined('InShopNC') or exit('Access Invalid!');?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="nc-comment" id="t">
  <thead class="type">
    <tr>
      <th colspan="2"><div>
          <input name="evalscore" id="allRate" type="radio" value="0" <?php echo $_GET['evalscore']?'':'checked'; ?> nc_type="sform" href="index.php?act=goods&op=comments&goods_id=<?php echo $output['goods_info']['goods_id'];?>&id=<?php echo $output['goods_info']['store_id'];?><?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="allRate"><?php echo $lang['nc_credit_all'];?></label>
          <input name="evalscore" id="goodRate" type="radio" value="1" <?php echo $_GET['evalscore'] == 1?'checked':''; ?> nc_type="sform" href="index.php?act=goods&op=comments&goods_id=<?php echo $output['goods_info']['goods_id'];?>&id=<?php echo $output['goods_info']['store_id'];?>&evalscore=1<?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="goodRate"><?php echo $lang['nc_credit_good'];?></label>
          <input name="evalscore" id="mediumRate" type="radio" value="2" <?php echo $_GET['evalscore'] == 2?'checked':''; ?> nc_type="sform" href="index.php?act=goods&op=comments&goods_id=<?php echo $output['goods_info']['goods_id'];?>&id=<?php echo $output['goods_info']['store_id'];?>&evalscore=2<?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="mediumRate"><?php echo $lang['nc_credit_normal'];?></label>
          <input name="evalscore" id="worstRate" type="radio" value="3" <?php echo $_GET['evalscore'] == 3?'checked':''; ?> nc_type="sform" href="index.php?act=goods&op=comments&goods_id=<?php echo $output['goods_info']['goods_id'];?>&id=<?php echo $output['goods_info']['store_id'];?>&evalscore=3<?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="worstRate"><?php echo $lang['nc_credit_bad'];?></label>
        </div></th>
      <td><div>
          <input name="havecontent" type="checkbox"  value="1" <?php echo $_GET['havecontent'] == 1?'checked':''; ?> nc_type="sform" href="index.php?act=goods&op=comments&goods_id=<?php echo $output['goods_info']['goods_id'];?>&id=<?php echo $output['goods_info']['store_id'];?><?php if ($_GET['evalscore']){?>&evalscore=<?php echo $_GET['evalscore']; } ?><?php if ($_GET['havecontent']){?>&havecontent=0<?php }else { ?>&havecontent=1<?php } ?>">
          <?php echo $lang['nc_eval_show_havecontent'];?></div></td>
    </tr>
  </thead>
  
  <tbody class="detail"><?php if(!empty($output['goodsevallist']) && is_array($output['goodsevallist'])){?>
    <?php foreach($output['goodsevallist'] as $k=>$v){?>
    <tr>
      <th class="w40"><em class="ncse-<?php echo $v['geval_scoressign'];?>" title="<?php echo $lang['nc_credit_'.$v['geval_scoressign']];?>"></em></th>
      <td><p><?php echo $v['geval_content'];?></p>
        <?php if (!empty($v['geval_explain'])){?>
        <p class="ncs-explain">[<?php echo $lang['nc_credit_explain'];?>]<?php echo $v['geval_explain'];?></p>
        <?php }?>
        <time pubdate="pubdate">[<?php echo @date('Y-m-d',$v['geval_addtime']);?>]</time>
        <span class="ml20"><?php echo $v['geval_specinfo'];?></span></td>
      <td class="w150"><dl>
          <dt><span class="thumb size40"><img src="<?php if ($v['member_avatar']!='') { echo ATTACH_AVATAR.DS.$v['member_avatar']; } else {  echo ATTACH_COMMON.DS.C('default_user_portrait').'_small.'.get_image_type(C('default_user_portrait')); } ?>" onload="javascript:DrawImage(this,40,40);"></span></dt>
          <dd><?php echo $v['geval_frommembername'];?></dd>
          <dd>
            <?php if (empty($v['credit_arr'])){echo  $lang['nc_credit_buyer_credit'].$v['member_credit']; }else {?>
            <span class="buyer-<?php echo $v['credit_arr']['grade']; ?> level-<?php echo $v['credit_arr']['songrade']; ?>"></span>
            <?php }?>
          </dd>
        </dl></td>
    </tr><?php }?>
  </tbody>
  
  <tfoot>
    <tr>
      <td colspan="10"><div class="pagination"> <?php echo $output['show_page'];?></div></td>
    </tr>
  </tfoot>
  <?php }else{?>
  <tbody>
    <tr>
      <td colspan="10" class="ncs-norecord"><?php echo $lang['no_record'];?></td>
    </tr>
  </tbody>
  <?php }?>
</table>
<script type="text/javascript">
$(document).ready(function(){
	$('#goodseval').find('.demo').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:"<?php echo TEMPLATES_PATH;?>/images/transparent.gif",
		target:'#goodseval'
	});
	$('#goodseval').find('*[nc_type="sform"]').ajaxContent({
		event:'change', //mouseover
		loaderType:"img",
		loadingMsg:"<?php echo TEMPLATES_PATH;?>/images/transparent.gif",
		target:'#goodseval'
	});
});
</script>