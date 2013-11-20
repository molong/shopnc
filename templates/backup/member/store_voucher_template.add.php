<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
	<div class="ncu-form-style">
	  <form id="add_form" method="post" enctype="multipart/form-data">
	  	<input type="hidden" id="act" name="act" value="store_voucher"/>
	  	<?php if ($output['type'] == 'add'){?>
	  	<input type="hidden" id="op" name="op" value="templateadd"/>
	  	<?php }else {?>
	  	<input type="hidden" id="op" name="op" value="templateedit"/>
	  	<input type="hidden" id="tid" name="tid" value="<?php echo $output['t_info']['voucher_t_id'];?>"/>
	  	<?php }?>
	  	<input type="hidden" id="form_submit" name="form_submit" value="ok"/>
	    <dl>
	      <dt class="required"><em class="pngFix"></em><?php echo $lang['voucher_template_title'].$lang['nc_colon']; ?></dt>
	      <dd>
	        <input type="text" class="w300 text" name="txt_template_title" value="<?php echo $output['t_info']['voucher_t_title'];?>">
	        <span class="field_notice"></span>
	      </dd>
	    </dl>	    
	    <dl>
	      <dt><em class="pngFix"></em><?php echo $lang['voucher_template_enddate'].$lang['nc_colon']; ?></dt>
	      <dd>
	      	<input type="text" class="text" id="txt_template_enddate" name="txt_template_enddate" value="" readonly>
	        <span class="field_notice"><?php echo $lang['voucher_template_enddate_tip'];?><b><?php echo @date('Y-m-d',$output['quotainfo']['quota_starttime']);?> ~ <?php echo @date('Y-m-d',$output['quotainfo']['quota_endtime']);?></b></span>
	      </dd>
	    </dl>
	    <dl>
	      <dt><?php echo $lang['voucher_template_price'].$lang['nc_colon']; ?></dt>
	      <dd>
	        <select id="select_template_price" name="select_template_price" class="w50 mr5">
	          <?php if(!empty($output['pricelist'])) { ?>
	          	<?php foreach($output['pricelist'] as $voucher_price) {?>
	          	<option value="<?php echo $voucher_price['voucher_price'];?>" <?php echo $output['t_info']['voucher_t_price'] == $voucher_price['voucher_price']?'selected':'';?>><?php echo $voucher_price['voucher_price'];?></option>
	          <?php } } ?>
	        </select><?php echo $lang['currency_zh'];?>
	        <span class="field_notice"></span>
	      </dd>
	    </dl>
	    <dl>
	      <dt class="required"><em class="pngFix"></em><?php echo $lang['voucher_template_total'].$lang['nc_colon']; ?></dt>
	      <dd>
	        <input type="text" class="w50 text" name="txt_template_total" value="<?php echo $output['t_info']['voucher_t_total']; ?>">
	        <span class="field_notice"></span>
	      </dd>
	    </dl>
	    <dl>
	      <dt class="required"><em class="pngFix"></em><?php echo $lang['voucher_template_eachlimit'].$lang['nc_colon']; ?></dt>
	      <dd>
	      	<select name="eachlimit" class="w50 mr5">
	      		<option value="0"><?php echo $lang['voucher_template_eachlimit_item'];?></option>
	      		<?php for($i=1;$i<=intval(C('promotion_voucher_buyertimes_limit'));$i++){?>
	      		<option value="<?php echo $i;?>" <?php echo $output['t_info']['voucher_t_eachlimit'] == $i?'selected':'';?>><?php echo $i;?><?php echo $lang['voucher_template_eachlimit_unit'];?></option>
	      		<?php }?>
	        </select>
	      </dd>
	    </dl>
	    <dl>
	      <dt class="required"><em class="pngFix"></em><?php echo $lang['voucher_template_orderpricelimit'].$lang['nc_colon']; ?></dt>
	      <dd>
	        <input type="text" name="txt_template_limit" class="text w50 mr5" value="<?php echo $output['t_info']['voucher_t_limit'];?>"><?php echo $lang['currency_zh'];?>
	        <span class="field_notice"></span>
	      </dd>
	    </dl>
	    <dl>
	      <dt class="required"><em class="pngFix"></em><?php echo $lang['voucher_template_describe'].$lang['nc_colon']; ?></dt>
	      <dd>
	        <textarea  name="txt_template_describe" rows="3" class="w300"><?php echo $output['t_info']['voucher_t_desc'];?></textarea>
	        <span class="field_notice"></span>
	      </dd>
	    </dl>
	    <dl>
	      <dt class="required"><em class="pngFix"></em><?php echo $lang['voucher_template_image'].$lang['nc_colon']; ?></dt>
	      <dd>
      		<div style="height:30px;"><input type="file" name="customimg" id="customimg"></div>
      		<div id="customimg_preview" style="clear:both;display:none;">
      			<?php if ($output['t_info']['voucher_t_customimg']){?>
      			<img onload="javascript:DrawImage(this,160,160);" src="<?php echo $output['t_info']['voucher_t_customimg'];?>"/>
      			<?php }else {?>
      			<img onload="javascript:DrawImage(this,160,160);"/>
      			<?php }?>
      		</div>
	      	<div class="ncm-notes" style="clear:both; padding-top:10px;"><?php echo $lang['voucher_template_image_tip'];?></div>
	      </dd>
	      </dl>
	      <?php if ($output['type'] == 'edit'){?>
	      <dl>
	      	<dt><em class="pngFix"></em><?php echo $lang['nc_status'].$lang['nc_colon']; ?></dt>
	      	<dd>
	      		<input type="radio" value="<?php echo $output['templatestate_arr']['usable'][0];?>" name="tstate" <?php echo $output['t_info']['voucher_t_state'] == $output['templatestate_arr']['usable'][0]?'checked':'';?>> <?php echo $output['templatestate_arr']['usable'][1];?>
	      		<input type="radio" value="<?php echo $output['templatestate_arr']['disabled'][0];?>" name="tstate" <?php echo $output['t_info']['voucher_t_state'] == $output['templatestate_arr']['disabled'][0]?'checked':'';?>> <?php echo $output['templatestate_arr']['disabled'][1];?>
	      	</dd>
	    </dl>
	    <?php }?>
	    <dl class="bottom">
	      <dt>&nbsp;</dt>
	      <dd>
	        <input id='btn_add' type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>" />
	      </dd>
	    </dl>
	  </form>
	</div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script> 
<script type="text/javascript">
//判断是否显示预览模块
<?php if (!empty($output['t_info']['voucher_t_customimg'])){?>
$('#customimg_preview').show();
<?php }?>
//日期控件
$('#txt_template_enddate').datepicker();
var year = <?php echo date('Y',$output['quotainfo']['quota_endtime']);?>;
var month = <?php echo intval(date('m',$output['quotainfo']['quota_endtime']));?>;
var day = <?php echo intval(date('d',$output['quotainfo']['quota_endtime']));?>;
$('#txt_template_enddate').datepicker( "option", "maxDate", new Date(year,month-1,day));
$('#txt_template_enddate').val("<?php echo $output['t_info']['voucher_t_end_date']?@date('Y-m-d',$output['t_info']['voucher_t_end_date']):'';?>");
$(document).ready(function(){
    $('#customimg').change(function(){
		var src = getFullPath($(this)[0]);
		if(navigator.userAgent.indexOf("Firefox")>0){
			$('#customimg_preview').show();
			$('#customimg_preview').find('img').attr('src', src);
		}
	});	
    //表单验证
    $('#add_form').validate({
        errorPlacement: function(error, element){
	    	var error_td = element.parent('dd');
	        error_td.find('.field_notice').append(error);
	    },
        rules : {
            txt_template_title: {
                required : true,
                rangelength:[0,100]
            },
            txt_template_total: {
                required : true,
                digits : true
            },
            txt_template_limit: {
                required : true,
                number : true
            },
            txt_template_describe: {
                required : true
            }
        },
        messages : {
            txt_template_title: {
                required : '<?php echo $lang['voucher_template_title_error'];?>',
                rangelength : '<?php echo $lang['voucher_template_title_error'];?>'
            },
            txt_template_total: {
                required : '<?php echo $lang['voucher_template_total_error'];?>',
                digits : '<?php echo $lang['voucher_template_total_error'];?>'
            },
            txt_template_limit: {
                required : '<?php echo $lang['voucher_template_limit_error'];?>',
                number : '<?php echo $lang['voucher_template_limit_error'];?>'
            },
            txt_template_describe: {
                required : '<?php echo $lang['voucher_template_describe_error'];?>'
            }
        }
    });
});
</script>