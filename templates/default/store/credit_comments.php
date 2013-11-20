<?php defined('InShopNC') or exit('Access Invalid!');?>

<table width="998" border="0" cellpadding="0" cellspacing="0" class="nc-comment" id="t">
  <thead class="type">
    <tr>
      <td colspan="2"><div>
          <input name="evalscore" id="allRate" type="radio" value="0" <?php echo $_GET['evalscore']?'':'checked'; ?> nc_type="sform" href="index.php?act=show_store&op=comments&id=<?php echo $_GET['id'];?><?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="allRate"><?php echo $lang['nc_credit_all'];?></label>
          <input name="evalscore" id="goodRate" type="radio" value="1" <?php echo $_GET['evalscore'] == 1?'checked':''; ?> nc_type="sform" href="index.php?act=show_store&op=comments&id=<?php echo $_GET['id'];?>&evalscore=1<?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="goodRate"><?php echo $lang['nc_credit_good'];?></label>
          <input name="evalscore" id="mediumRate" type="radio" value="2" <?php echo $_GET['evalscore'] == 2?'checked':''; ?> nc_type="sform" href="index.php?act=show_store&op=comments&id=<?php echo $_GET['id'];?>&evalscore=2<?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="mediumRate"><?php echo $lang['nc_credit_normal'];?></label>
          <input name="evalscore" id="worstRate" type="radio" value="3" <?php echo $_GET['evalscore'] == 3?'checked':''; ?> nc_type="sform" href="index.php?act=show_store&op=comments&id=<?php echo $_GET['id'];?>&evalscore=3<?php if ($_GET['havecontent']){?>&havecontent=1<?php } ?>">
          <label for="worstRate"><?php echo $lang['nc_credit_bad'];?></label>
        </div></td>
      <td class="tc w150"><div><?php echo $lang['show_store_credit_eval_member'];?></div></td>
      <td class="w400"><div><?php echo $lang['show_store_credit_eval_goodsinfo'];?></div></td>
    </tr>
  </thead>
  <?php if(!empty($output['goodsevallist']) && is_array($output['goodsevallist'])){?>
  <tbody class="detail">
    <?php foreach($output['goodsevallist'] as $k=>$v){?>
    <tr><th class="w40 tc"><em class="pngFix ncse-<?php echo $v['geval_scoressign'];?>" title="<?php echo $lang['nc_credit_'.$v['geval_scoressign']];?>"></em></th>
      <td><p><?php echo $v['geval_content'];?> </p>
        <?php if (!empty($v['geval_explain'])){?>
        <p class="ncs-explain">[<?php echo $lang['nc_credit_explain'];?>]<?php echo $v['geval_explain'];?></p>
        <?php }?>
        <time pubdate="pubdate">[<?php echo @date('Y-m-d',$v['geval_addtime']);?>]</time></td>
      <td><dl class="ncs-fromm-ember">
          <dd><?php echo $v['geval_frommembername'];?></dd>
          <?php if (empty($v['credit_arr'])){echo  $lang['nc_credit_buyer_credit'].$v['member_credit']; }else {?>
          <span class="buyer-<?php echo $v['credit_arr']['grade']; ?> level-<?php echo $v['credit_arr']['songrade']; ?>"></span>
          <?php }?>
        </dl></td>
      <td><dl class="goodsinfo">
          <dd><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$v['geval_goodsid']), 'goods'); ?>"><?php echo $v['geval_goodsname']?></a> <br/>
            <?php echo $v['geval_goodsprice'];?><?php echo $lang['currency_zh'];?></dd>
        </dl></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="10"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
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