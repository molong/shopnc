<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.tooltip.js"></script>

<div class="wrap-shadow">
  <div class="wrap-all ncu-order-view">
    <h2><?php echo $lang['member_evaluation_toevaluategoods'];?></h2>
    <h3 class="mt20"><?php echo $lang['member_evaluation_storeinfotitle'];?></h3>
    <table class="ncu-table-style">
      <tbody>
        <tr>
          <td rowspan="4" class="w70"><div class="thumb size60"><i></i><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']),'store',$output['store_info']['store_domain']);?>"><img src="<?php if(empty($output['store_info']['store_logo'])){echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_store_logo'];}else{echo ATTACH_STORE.'/'.$output['store_info']['store_logo'];}?>"  onload="javascript:DrawImage(this,60,60);" title="<?php echo $output['store_info']['store_name']; ?>" alt="<?php echo $output['store_info']['store_name']; ?>" /></a></div></td>
          <td class="tl w200"><p><?php echo $lang['member_evaluation_store_name'].$lang['nc_colon'];?><a href="index.php?act=show_store&id=<?php echo $output['store_info']['store_id'];?>" target="_blank"><?php echo $output['store_info']['store_name'];?></a></p>
            <p><?php echo $lang['member_evaluation_tostorename'].$lang['nc_colon']; ?><?php echo $output['store_info']['member_name'];?><a target="_blank" class="message" href="index.php?act=home&op=sendmsg&member_id=<?php echo $output['store_info']['member_name'];?>" title="<?php echo $lang['nc_member_path_sendmsg']?>"></a></p>
            <p><?php echo $lang['member_evaluation_creditgrade'].$lang['nc_colon'];?>
              <?php if (empty($output['store_info']['credit_arr'])){ echo $output['store_info']['store_credit']; }else {?>
              <span class="seller-<?php echo $output['store_info']['credit_arr']['grade']; ?> level-<?php echo $output['store_info']['credit_arr']['songrade']; ?>"></span>
              <?php }?>
            </p></td>
          <td class="tl"><a href="<?php echo SiteUrl;?>/index.php?act=show_store&op=credit&id=2" target="_blank" class="ml20"><?php echo $lang['member_evaluation_storeevalstat'];?></a></td>
        </tr>
    </table>
    <form id="evalform" method="post" action="index.php?act=member_evaluate&op=add&order_id=<?php echo $_GET['order_id'];?>" onsubmit="return checkform();">
      <h3 class="mt20 mb10"><?php echo $lang['member_evaluation_my_evaluation'];?></h3>
      <div class="ncm-notes">
        <ul>
          <li><?php echo $lang['member_evaluation_rule_1'];?></li>
          <li><?php echo $lang['member_evaluation_rule_2'];?></li>
          <li><?php echo $lang['member_evaluation_rule_3'];?></li>
          <li><?php echo $lang['member_evaluation_rule_4'];?></li>
        </ul>
      </div>
      <table class="ncu-table-style order deliver">
        <tbody>
          <tr>
            <th colspan="20"><span class="ml10"><?php echo $lang['member_evaluation_order_desc'];?></span><span class="fr mr20">
              <input type="checkbox" value="1" name="goods[<?php echo $goods['rec_id'];?>][anony]">
              &nbsp;<?php echo $lang['member_evaluation_modtoanonymous'];?></span>
              </tg>
          </tr>
          <?php if(!empty($output['order_goods'])){?>
          <?php foreach($output['order_goods'] as $goods){?>
          <tr>
            <td class="bdl w10"></td>
            <td class="w70"><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id']; ?>" target="_blank"><img src="<?php echo $goods['goods_image']; ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
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
                <label for="g<?php echo $goods['rec_id'];?>_op3" class="ncgeval-bad mr10"><span class="ico"></span>
                  <input id="g<?php echo $goods['rec_id'];?>_op3" type="radio" name="goods[<?php echo $goods['rec_id'];?>][points]" value="3" />
                  <strong style="color: #555;"><?php echo $lang['member_evaluation_bad'];?></strong>&nbsp;<em class="gray">(<?php echo $lang['member_evaluation_decrease1'];?>)</em></label>
              </div>
              <div>
                <textarea name="goods[<?php echo $goods['rec_id'];?>][comment]" cols="150" class="w400"></textarea>
              </div></td>
          </tr>
        </tbody>
        <?php }?>
        <?php }?>
        <tfoot>
          <tr>
            <td colspan="20"></td>
          </tr>
        </tfoot>
      </table>
      <h3><?php echo $lang['member_evaluation_storeevalstat'];?></h3>
      <div class="ncu-form-style">
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_1'].$lang['nc_colon'];?></dt>
          <dd style=" width:750px;">
            <ul>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_description_of_gradetip_5'];?>">
                <input name="store[matchpoint]" type="radio" class="fl mr5 mt5" id="matchpoint_1" value="5" checked="checked">
                <label for="matchpoint_1"class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:100%;"></i></em>(5<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_description_of_gradetip_4'];?>">
                <input id="matchpoint_2" type="radio" value="4" name="store[matchpoint]" class="fl mr5 mt5">
                <label for="matchpoint_2" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:80%;"></i></em>(4<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_description_of_gradetip_3'];?>">
                <input id="matchpoint_3" type="radio" value="3" name="store[matchpoint]" class="fl mr5 mt5">
                <label for="matchpoint_3" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:60%;"></i></em>(3<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_description_of_gradetip_2'];?>">
                <input id="matchpoint_4" type="radio" value="2" name="store[matchpoint]" class="fl mr5 mt5">
                <label for="matchpoint_4" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:40%;"></i></em>(2<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl" title="<?php echo $lang['member_evaluation_description_of_gradetip_1'];?>">
                <input id="matchpoint_5" type="radio" value="1" name="store[matchpoint]" class="fl mr5 mt5">
                <label for="matchpoint_5" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:20%;"></i></em>(1<?php echo $lang['credit_unit'];?>) </label>
              </li>
            </ul>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_2'].$lang['nc_colon'];?></dt>
          <dd style=" width:750px;">
            <ul>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_serviceattitude_gradetip_5'];?>">
                <input name="store[servicepoint]" type="radio" class="fl mr5 mt5" id="servicepoint_1" value="5" checked="checked">
                <label for="servicepoint_1" class="rate-star"><em class="fl mr5" style="margin-top:5px;"><i style="width:100%;"></i></em>(5<?php echo $lang['credit_unit'];?>)</label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_serviceattitude_gradetip_4'];?>">
                <input id="servicepoint_2" type="radio" value="4" name="store[servicepoint]" class="fl mr5 mt5">
                <label for="servicepoint_2" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:80%;"></i></em>(4<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_serviceattitude_gradetip_3'];?>">
                <input id="servicepoint_3" type="radio" value="3" name="store[servicepoint]" class="fl mr5 mt5">
                <label for="servicepoint_3" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:60%;"></i></em>(3<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_serviceattitude_gradetip_2'];?>">
                <input id="servicepoint_4" type="radio" value="2" name="store[servicepoint]" class="fl mr5 mt5">
                <label for="servicepoint_4" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:40%;"></i></em>(2<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl" title="<?php echo $lang['member_evaluation_serviceattitude_gradetip_1'];?>">
                <input id="servicepoint_5" type="radio" value="1" name="store[servicepoint]" class="fl mr5 mt5">
                <label for="servicepoint_5" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:20%;"></i></em>(1<?php echo $lang['credit_unit'];?>) </label>
              </li>
            </ul>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_3'].$lang['nc_colon'];?></dt>
          <dd style=" width:750px;">
            <ul>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_deliveryspeed_gradetip_5'];?>">
                <input name="store[shippingspeed]" type="radio" class="fl mr5 mt5" id="shippingspeed_1" value="5" checked="checked">
                <label for="shippingspeed_1" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:100%;"></i></em>(5<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_deliveryspeed_gradetip_4'];?>">
                <input id="shippingspeed_2" type="radio" value="4" name="store[shippingspeed]" class="fl mr5 mt5">
                <label for="shippingspeed_2" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:80%;"></i></em>(4<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_deliveryspeed_gradetip_3'];?>">
                <input id="shippingspeed_3" type="radio" value="3" name="store[shippingspeed]" class="fl mr5 mt5">
                <label for="shippingspeed_3" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:60%;"></i></em>(3<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl mr20" title="<?php echo $lang['member_evaluation_deliveryspeed_gradetip_2'];?>">
                <input id="shippingspeed_4" type="radio" value="2" name="store[shippingspeed]" class="fl mr5 mt5">
                <label for="shippingspeed_4" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:40%;"></i></em>(2<?php echo $lang['credit_unit'];?>) </label>
              </li>
              <li class="tooltip fl" title="<?php echo $lang['member_evaluation_deliveryspeed_gradetip_1'];?>">
                <input id="shippingspeed_5" type="radio" value="1" name="store[shippingspeed]" class="fl mr5 mt5">
                <label for="shippingspeed_5" class="rate-star"> <em class="fl mr5" style="margin-top:5px;"><i style=" width:20%;"></i></em>(1<?php echo $lang['credit_unit'];?>) </label>
              </li>
            </ul>
          </dd>
        </dl>
        <dl class="bottom mt30">
          <dt>&nbsp;</dt>
          <dd class="tc">
            <input type="submit" class="submit" value="<?php echo $lang['member_evaluation_submit'];?>"/>
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