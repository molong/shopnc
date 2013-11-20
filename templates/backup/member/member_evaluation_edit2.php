<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="ncm-notes">
    <h3><?php echo $lang['member_evaluation_explain_tip'].$lang['nc_colon']; ?></h3>
    <ul>
      <li><?php echo $lang['member_evaluation_explain_tip1'];?></li>
    </ul>
  </div>
  <div class="tabmenu">
    <ul class="tab">
      <li class="active"><a href="javascript:void(0)"><?php echo $lang['member_evaluation_explain_title'];?></a></li>
    </ul>
  </div>
  <div class="ncu-form-style">
  <form id="explainform" method="post" action="index.php?act=<?php echo $output['pj_act'];?>&op=explain&id=<?php echo $output['info']['geval_id']; ?>">
    <input type="hidden" name="form_submit" value="ok"/>
    <dl>
      <dt><?php echo $lang['member_evaluation_frommembertitle'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['info']['geval_frommembername'];?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_relatedgoods'].$lang['nc_colon'];?></dt>
      <dd><a target="_blank" href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$output['info']['geval_goodsid']), 'goods'); ?>"><?php echo $output['info']['geval_goodsname']?></a></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_title'].$lang['nc_colon'];?></dt>
      <dd><?php echo $lang['member_evaluation_'.$output['info']['geval_scoressign']];?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_addtime'].$lang['nc_colon'];?></dt>
      <dd><?php echo @date('Y-m-d H:i:s',$output['info']['geval_addtime'])?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_content'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['info']['geval_content'];?></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['member_evaluation_wanttoexplain'].$lang['nc_colon'];?></dt>
      <dd>
        <textarea name="content" rows="3" class="w600"></textarea>
        <div><?php echo $lang['member_evaluation_explain_maxerror'];?></div>
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
</div>
<script>
$(function(){
	$('#explainform').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        rules : {
        	content : {
                required : true
            }
        },
        messages : {
        	content	: {
            	required :'<?php echo $lang['member_evaluation_explain_nullerror'];?>'
            }
        }
    });
}); 
</script>