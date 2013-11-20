<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['admin_updatestat'];?></h3>
    </div>
  </div>
  <div class="fixed-empty"></div>
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
    	<thead>
    		<tr class="noborder">
    			<td><?php echo $lang['points_item']; ?></td>
    			<td><?php echo $lang['admin_fornum'];?></th>
    		</tr>
    	</thead>
    	<tbody>
    		<tr class="hover">
    			<td class="w150"><?php echo $lang['admin_buyerevalstat']; ?></td>
    			<td class="w200"><input id="buyerevalnum" value="100" class="txt" type="text" style="width:100px;"></td>
    			<td><input type="button" class="btn" value="<?php echo $lang['admin_update']; ?>" onclick="submitform('buyereval');"></td>
    		</tr>
    		<tr class="hover">
    			<td class="w150"><?php echo $lang['admin_sellerevalstat'];?></td>
    			<td><input id="sellerevalnum" value="100" class="txt" type="text" style="width:100px;"></td>
    			<td><input type="button" class="btn" value="<?php echo $lang['admin_update']; ?>" onclick="submitform('sellereval');"></td>
    		</tr>
    		<tr class="hover">
    			<td class="w150"><?php echo $lang['admin_storeevalstat']; ?></td>
    			<td><input id="storeevalnum" value="100" class="txt" type="text" style="width:100px;"></td>
    			<td><input type="button" class="btn" value="<?php echo $lang['admin_update']; ?>" onclick="submitform('storeeval');"></td>
    		</tr>
    		<tr class="hover">
    			<td class="w150"><?php echo $lang['admin_goodsevalcount']; ?></td>
    			<td><input id="goodsevalnum" value="100" class="txt" type="text" style="width:100px;"></td>
    			<td><input type="button" class="btn" value="<?php echo $lang['admin_update']; ?>" onclick="submitform('goodseval');"></td>
    		</tr>
    	</tbody>
    </table>
</div>
<script>
function submitform(type){
	var url ='index.php?act=updatestat';
	if(type != ''){
		var num = $("#"+type+"num").val();
		num = parseInt(num) > 0? parseInt(num) : 100;
		url = url+'&op='+type+"&num="+num;
	}
	window.location=url;
}
</script>