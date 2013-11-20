<div class="wrap-shadow">
  <div class="wrap-all ncu-order-view">
    <h2><?php echo $lang['member_evaluation_toevaluatebuyer'];?></h2>
    <h3 class="mt20"><?php echo $lang['member_evaluation_memberinfotitle'];?> </h3>
    <table class="ncu-table-style">
      <tbody>
        <tr>
          <td class="w70"><div class="thumb size60"><i></i><img src="<?php if(empty($output['member_info']['member_avatar'])){ echo ATTACH_COMMON.DS.C('default_user_portrait'); }else{ echo ATTACH_AVATAR.DS.$output['member_info']['member_avatar']; }?>"  onload="javascript:DrawImage(this,60,60);" title="<?php echo $output['member_info']['member_name']; ?>" alt="<?php echo $output['member_info']['member_name']; ?>" /></div></td>
          <td class="tl"><p><?php echo $lang['member_evaluation_membername'].$lang['nc_colon'];?><?php echo $output['member_info']['member_name'];?><a target="_blank" class="message" href="index.php?act=home&op=sendmsg&member_id=<?php echo $val['buyer_id'];?>" title="<?php echo $lang['nc_member_path_sendmsg']?>"></a></p>
            <p><?php echo $lang['member_evaluation_creditgrade'].$lang['nc_colon'];?>
              <?php if (empty($output['member_info']['credit_arr'])){ echo $output['member_info']['member_credit']; }else {?>
              <span class="buyer-<?php echo $output['member_info']['credit_arr']['grade']; ?> level-<?php echo $output['member_info']['credit_arr']['songrade']; ?>"></span>
              <?php }?>
            </p></td>
        </tr>
      </tbody>
    </table>
    <form id="evalform" method="post" action="index.php?act=store_evaluate&op=add&order_id=<?php echo $_GET['order_id'];?>" onsubmit="return checkform();">
      <h3 class="mt20 mb10"><?php echo $lang['member_evaluation_my_evaluation'];?></h3>
      <div class="ncm-notes">
        <ul>
          <li><?php echo $lang['member_evaluation_rule_seller_1'];?></li>
          <li><?php echo $lang['member_evaluation_rule_seller_2'];?></li>
        </ul>
      </div>
      <table class="ncu-table-style order deliver">
        <tbody>
          <tr>
            <th colspan="20"><span class="ml10"><?php echo $lang['member_evaluation_order_desc'];?></span></th>
          </tr>
          <?php if(!empty($output['order_goods'])){?>
          <?php foreach($output['order_goods'] as $goods){?>
          <tr>
            <td class="bdl w10"></td>
            <td class="w70"><div class="goods-pic-small"><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id']; ?>" target="_blank"><span class="thumb size60"><i></i><img src="<?php echo $goods['goods_image']; ?>" onload="javascript:DrawImage(this,60,60);" /></span></a></div></td>
            <td class="tl goods-info"><dl>
                <dt><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_name'];?></a></dt>
                <dd class="tl"><?php echo $goods['spec_info'];?></dd>
                <dd class="tr"><span class="price"><?php echo $goods['goods_price'];?></span>&nbsp;x&nbsp;<?php echo $goods['goods_num'];?></dd>
              </dl></td>
            <td class="bdr"><div class="ncgeval mb10">
                <label for="g<?php echo $goods['rec_id'];?>_op1" class="ncgeval-good mr10"><span class="ico"></span>
                  <input name="goods[<?php echo $goods['rec_id'];?>][points]" type="radio" id="g<?php echo $goods['rec_id'];?>_op1" value="1" checked="checked"/>
                  <strong style="color: red;"><?php echo $lang['member_evaluation_good'];?></strong>&nbsp;<em class="gray">(<?php echo $lang['member_evaluation_increase1'];?>)</em></label>
                <label for="g<?php echo $goods['rec_id'];?>_op2" class="ncgeval-normal mr10"><span class="ico"></span>
                  <input id="g<?php echo $goods['rec_id'];?>_op2" type="radio" name="goods[<?php echo $goods['rec_id'];?>][points]" value="2" />
                  <strong style="color: green;"><?php echo $lang['member_evaluation_normal'];?></strong>&nbsp;<em class="gray">(<?php echo $lang['member_evaluation_increase0'];?>)</em></label>
                <label for="g<?php echo $goods['rec_id'];?>_op3" class="ncgeval-bad"><span class="ico"></span>
                  <input id="g<?php echo $goods['rec_id'];?>_op3" type="radio" name="goods[<?php echo $goods['rec_id'];?>][points]" value="3" />
                  <strong style="color: #555;"><?php echo $lang['member_evaluation_bad'];?></strong>&nbsp;<em class="gray">(<?php echo $lang['member_evaluation_decrease1'];?>)</em></label>
              </div>
              <div>
                <textarea name="goods[<?php echo $goods['rec_id'];?>][comment]" cols="150" class="w400"></textarea>
              </div></td>
          </tr>
          <?php }?>
          <?php }?>
        </tbody>
      </table>
      <div class="ncu-form-style">
        <dl class="bottom mb30">
          <dt>&nbsp;</dt>
          <dd class="tc">
            <input type="submit"  class="submit" value="<?php echo $lang['member_evaluation_submit'];?>" />
          </dd>
        </dl>
      </div>
    </form>
  </div>
</div>
<script>
function checkform(){
	var result = false;	
	$("#evalform").find(':radio').each(function(){
		if($(this).attr("checked")==true){
			result = true;
		}
	});
	if(result == false){
		alert('<?php echo $lang['member_evaluation_nullerror'];?>');
	}
	return result;
}
</script>