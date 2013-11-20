<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div id="seller_groupbuy_form" class="wrap">
  <div class="tabmenu"><?php include template('member/member_submenu');?></div>
  <div class="ncu-form-style">
    <form method="post" id='ztc_form' action="index.php?act=store_ztc&op=edit_ztc&z_id=<?php echo intval($_GET['z_id']);?>">
      <input type="hidden" name="form_submit" value="ok"/>
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
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_ztc_add_choose_goods'].$lang['nc_colon'];?><!-- 选择商品 --></dt>
        <dd>
          <input class="text w400" gs_id="gselect_div" gs_name="goods_name" gs_callback="gs_callback" gs_title="gselector" gs_width="480" gs_op="getselectgoods" nc_type="ztcgselector" type="text" name="ztc_gname" id="ztc_gname"  value="<?php echo $output['ztc_info']['ztc_goodsname'];?>"/>
          <input type="hidden" id="goods_id" name="goods_id" value="<?php echo $output['ztc_info']['ztc_goodsid'];?>"/>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_ztc_add_usegold'].$lang['nc_colon']; ?><!-- 消耗金币 --></dt>
        <dd>
          <input type="text" class="w50 text" name="ztc_goldnum" id="ztc_goldnum" value="<?php echo $output['ztc_info']['ztc_gold'];?>"/>
          &nbsp;&nbsp;<?php echo $lang['store_ztc_add_havegold_text']; ?><!-- 您当前拥有金币 -->&nbsp;<font style="font-weight:bold;"><?php echo $output['member_array']['member_goldnum'];?></font>&nbsp;<?php echo $lang['store_ztc_goldunit']; ?>
          <input type="hidden" name="goldnumall" id="goldnumall" value="<?php echo $output['member_array']['member_goldnum'];?>">
        </dd>
      </dl>
      <?php if ($output['ztc_info']['ztc_type'] == 0){?>
      <dl id="starttime_div">
        <dt><?php echo $lang['store_ztc_starttime'].$lang['nc_colon']; ?><!-- 开始时间 --></dt>
        <dd>
          <input name="ztc_stime" id="ztc_stime" type="text"  class="text"  style="width:150px;" value="<?php if ($output['ztc_info']['ztc_startdate']){echo date('Y-m-d',$output['ztc_info']['ztc_startdate']);}?>"/>
          <input name="ztc_nowdate" id="ztc_nowdate" type="hidden" value="<?php echo $output['nowdate'];?>"/>
        </dd>
      </dl>
      <?php } ?>
      <dl id="group_intro">
        <dt> <?php echo $lang['store_ztc_add_remark']; ?><!-- 备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注  -->:</dt>
        <dd>
          <textarea name="ztc_remark" rows="3" id="ztc_remark" class="textarea w400" ><?php echo $output['ztc_info']['ztc_remark'];?></textarea>
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
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script>
$(function(){
	$('#ztc_stime').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('*[nc_type="ztcgselector"]').click(function(){
	    var id = $(this).attr('gs_id');
	    var callback = $(this).attr('gs_callback');
	    var op = $(this).attr('gs_op');
	    var title = $(this).attr('gs_title') ? $(this).attr('title') : '';
	    var width = $(this).attr('gs_width');
	    //申请类型
	    var t = <?php echo $output['ztc_info']['ztc_type'];?>;
	    ajax_form(id, title, SITE_URL + '/index.php?act=store_ztc&op=' + op + '&dialog=1&title=' + title + '&id=' + id + '&callback=' + callback +'&t= '+ t, width);
	    return false;
	});

	jQuery.validator.addMethod("greater", function(value, element, param) {
		var comparetext = $.trim($(param).val());
		//申请类型
		var t = '<?php echo $output['ztc_info']['ztc_type'];?>';
		if(t == '0'){
			if(value == ''){return false;}else{
				if(value && comparetext){return comparetext < value;}else{return true;}
			}
		}else{ return true;}
	}, "<?php echo $lang['store_ztc_add_starttime_error'];?>");
	
	$('#ztc_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
     	submitHandler:function(form){
    		ajaxpost('ztc_form', '', '', 'onerror'); 
    	},
        rules : {
            goods_id      : {
                required     : true,
                min    : 1
            },
            ztc_goldnum :{
                required   :true,
                min    :1,
                max    :<?php echo $output['member_array']['member_goldnum'];?>
            },
            ztc_remark : {
                maxlength   : 100
            },
            ztc_stime : {
            	greater   : "#ztc_nowdate"
            }
        },
        messages : {
            goods_id      : {
                required:  '<?php echo $lang['store_ztc_add_search_goodserror'];?>',
                min   : '<?php echo $lang['store_ztc_add_search_goodserror'];?>'
            },
            ztc_goldnum		: {
            	required   :'<?php echo $lang['store_ztc_add_goldnum_nullerror'];?>',
                min    :'<?php echo $lang['store_ztc_add_goldnum_minerror'];?>',
                max    :'<?php echo $lang['store_ztc_add_goldnum_maxerror'];?>'
            },
            ztc_remark       : {
            	maxlength    : '<?php echo $lang['store_ztc_add_remarkerror'];?>'
            }
        }
    });
}); 
</script>