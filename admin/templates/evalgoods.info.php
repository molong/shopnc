<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_goods_evaluate']; ?></h3>
      <ul class="tab-base">
      	<?php if ($_GET['type']=='seller'){?>
      	<li><a href="index.php?act=evaluate&op=evalseller_list" ><span><?php echo $lang['admin_evalseller_list'];?></span></a></li>
      	<?php }else {?>
      	<li><a href="index.php?act=evaluate&op=evalgoods_list" ><span><?php echo $lang['admin_evaluate_list'];?></span></a></li>
        <?php }?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_evaluate_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="evaluateForm">
    <input type="hidden" name="form_submit" value="ok"/>
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_goodsname'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><a href="<?php echo SiteUrl.DS.ncUrl(array('act'=>'goods','goods_id'=>$output['info']['geval_goodsid']), 'goods');?>" target="_blank"><?php echo $output['info']['geval_goodsname']; ?></a></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_goods_specinfo']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['geval_specinfo']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_ordersn']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['geval_orderno'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_storename']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['geval_storename'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_frommembername'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['geval_frommembername']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_tomembername'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['info']['geval_tomembername']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_grade']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['evaluate_grade'][$output['info']['geval_scores']]; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_addtime']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo @date('Y-m-d',$output['info']['geval_addtime']); ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_buyerdesc']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php if (empty($output['info']['geval_content'])){ echo $output['evaluate_defaulttext'][$output['info']['geval_scores']]; }else {echo $output['info']['geval_content'];}?><br>
          	<?php if(!empty($output['info']['geval_explain'])){?>
          	<div id="explain_div">
          		<span style="color:#996600;padding:5px 0px;">[<?php echo $lang['admin_evaluate_explain']; ?>]<?php echo $output['info']['geval_explain'];?></span>
          		<a class="btns tooltip" onclick="hiddenexplain(<?php echo $output['info']['geval_id'];?>);" href="JavaScript:void(0);" title="<?php echo $lang['admin_evaluate_delexplain'];?>"><span><?php echo $lang['admin_evaluate_delexplain'];?></span></a>
          	</div>
          	<?php }?>
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_state'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">          
          <?php foreach ((array)$output['evaluate_state'] as $k=>$v){?>
          	<input type="radio" name="state" value="<?php echo $k;?>" <?php echo $k == $output['info']['geval_state']? "checked=checked":'';?>/>&nbsp;<?php echo $v;?>
          <?php }?>
          </td>
          <td class="vatop tips"><?php echo $lang['admin_evaluate_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['admin_evaluate_adminremark']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea class="tarea" name="admin_remark" rows="6"><?php echo $output['info']['geval_remark'];?></textarea></td><td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn" onclick="document.evaluateForm.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
function hiddenexplain(id){
	if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){
		$.get("index.php?act=evaluate&op=delexplain", {'id':id}, function(data){
            if (data == 1)
            {
            	$("#explain_div").hide();
            	alert('<?php echo $lang['admin_evaluate_drop_success'];?>');
            }
            else
            {
            	alert('<?php echo $lang['admin_evaluate_drop_fail'];?>');
            }
        });
	}
}
</script>