<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="wrap">
  <div class="tabmenu"><?php include template('member/member_submenu');?></div>
  <div class="ncu-form-style">
    <dl>
      <dt><?php echo $lang['store_ztc_applytype'].$lang['nc_colon']; ?><!-- 申请类型 --></dt>
      <dd>
        <?php if ($output['ztc_info']['ztc_type'] == 1){
                        		echo $lang['store_ztc_add_applytype_recharge'];//echo '直通车充值';
                        	}else {
                        		echo $lang['store_ztc_add_applytype_new'];//echo '直通车申请';
                        	}?>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_ztc_add_choose_goods'].$lang['nc_colon'];?></dt>
      <dd><?php echo $output['ztc_info']['ztc_goodsname'];?></dd>
      </p>
    </dl>
    <dl>
      <dt><?php echo $lang['store_ztc_add_usegold'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['ztc_info']['ztc_gold'];?> <?php echo $lang['store_ztc_goldunit']; ?></dd>
    </dl>
    <dl id="starttime_div">
      <dt><?php echo $lang['store_ztc_starttime'].$lang['nc_colon']; ?></dt>
      <dd>
        <?php if ($output['ztc_info']['ztc_startdate']){echo date('Y-m-d',$output['ztc_info']['ztc_startdate']);}?>
      </dd>
      </p>
    </dl>
    <dl>
      <dt><?php echo $lang['store_ztc_add_remark'].$lang['nc_colon']; ?></dt>
      <dd><?php echo $output['ztc_info']['ztc_remark'];?></dd>
    </dl>
    <dl id="starttime_div">
      <dt><?php echo $lang['store_ztc_paystate'].$lang['nc_colon']; ?></dt>
      <dd>
        <?php 
                        	switch ($output['ztc_info']['ztc_paystate']){
                        		case 1:
                        			echo $lang['store_ztc_paysuccess'];//支付成功
                        			break;
                        		default:
                        			echo $lang['store_ztc_waitpaying'];//等待支付
                        			break;	
                        	}
                        ?>
      </dd>
    </dl>
    <dl id="starttime_div">
      <dt><?php echo $lang['store_ztc_auditstate'].$lang['nc_colon']; ?></dt>
      <dd>
        <?php 
                        	switch ($output['ztc_info']['ztc_state']){
                        		case 1:
                        			echo $lang['store_ztc_auditpass'];//'通过审核'
                        			break;
                        		case 2:
                        			echo $lang['store_ztc_auditnopass'];//'审核失败'
                        			break;
                        		default:
                        			echo $lang['store_ztc_auditing'];//'等待审核
                        			break;	
                        	}
                        ?>
      </dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd>
        <input id="submit_group" type="submit"  class="submit" value="<?php echo $lang['store_ztc_index_backlist']; ?>" onclick="window.location='index.php?act=store_ztc&op=ztc_list'"/>
      </dd>
    </dl>
  </div>
</div>
<script>
//根据不同的申请类型显示不同的内容
function ztctype_change(){
	if(<?php echo $output['ztc_info']['ztc_type']; ?> == 1){
		//选择了充值类型隐藏开始时间
		$("#starttime_div").hide();		
	}else{
		//选择了申请新纪录类型显示开始时间
		$("#starttime_div").show();
	}
}
$(function(){
	ztctype_change();	
}); 
</script>