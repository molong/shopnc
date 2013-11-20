<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_coupon_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=coupon&op=apply"><span><?php echo $lang['coupon_allow_state'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="coupon">
    <input type="hidden" name="op" value="list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_coupon_name"><?php echo $lang['coupon_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['coupon_name_like'];?>" name="search_coupon_name" id="search_coupon_name" class="txt"></td>
          <th><label for="search_store_name"><?php echo $lang['coupon_store_name'];?></label></th>
          <td><input type="text" value="<?php echo $output['search']['store_name'];?>" name="search_store_name" id="search_store_name" class="txt" style="width:100px;"></td>
          <th><label for="time_from"><?php echo $lang['coupon_lifetime'];?></label></th>
          <td><input type="text" <?php if($output['search']['time_from']!=''){?>value="<?php echo date('Y-m-d',$output['search']['time_from']) ; ?>"<?php }?> id="time_from" name="time_from" class="txt date"/>
            <label for="time_to">~</label>
            <input type="text" <?php if($output['search']['time_to']!=''){?>value="<?php echo date('Y-m-d',$output['search']['time_to']) ; ?>"<?php }?> id="time_to" name="time_to" class="txt date"/></td>
          <th><label for=""><?php echo $lang['coupon_class'];?></label></th>
          <td id="gcategory"><select name="coupon_class">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php foreach($output['class_list'] as $val) { ?>
              <option value="<?php echo $val['class_id']; ?>" <?php if($output['search']['coupon_class'] == $val['class_id']){?>selected<?php }?>><?php echo $val['class_name']; ?></option>
              <?php } ?>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="formProcess">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" id="submit_type" name="submit_type" value="" />
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['coupon_help1'];?>,<?php echo $lang['coupon_help2'];?></li>
            <li><?php echo $lang['coupon_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
    <table class="table tb-type2">
      <thead>        
        <tr class="thead">
          <th></th>
          <th class="align-center"><?php echo $lang['coupon_pic'];?></th>
          <th><?php echo $lang['coupon_name'];?></th>
          <th class="align-center"><?php echo $lang['coupon_store_name'];?></th>
          <th class="align-center"><?php echo $lang['coupon_price'];?>(<?php echo $lang['currency_zh']; ?>)</th>
          <th class="align-center"><?php echo $lang['coupon_lifetime'];?></th>
          <th class="align-center"><?php echo $lang['coupon_state'];?></th>
          <th class="align-center"><?php echo $lang['nc_recommend'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" name='coupon_id[]' value="<?php echo $v['coupon_id'];?>" class="checkitem"></td>
          <td class="w96 picture"><div class="size-88x44"><span class="thumb size-88x44"><i></i><img height="44" width="88" src="<?php if(stripos($v['coupon_pic'], 'http://') === false){echo SiteUrl.'/'.$v['coupon_pic'];}else{echo $v['coupon_pic'];}?>" onerror="this.src='<?php echo SiteUrl;?>/templates/<?php echo TPL_NAME;?>/images/default_coupon_image.png'" onload="javascript:DrawImage(this,88,44);"/></span></div></td>
          <td  class="name w270"><?php echo $v['coupon_title'];?></td>
          <td class="align-center"><?php echo $v['store_name'] ;?></td>
          <td class="align-center"><?php echo $v['coupon_price'] ;?></td>
          <td class="nowarp align-center"><p><?php echo date('Y-m-d',$v['coupon_start_date']);?>~<?php echo date('Y-m-d',$v['coupon_end_date']);?></p></td>
          <td class="align-center"><?php
					switch($v['coupon_state']){
						case '1':echo $lang['nc_no'];break;
						case '2':echo $lang['nc_yes'];break ;
					}
				?></td>
          <td class="align-center"><?php
					switch($v['coupon_recommend']){
						case '1':echo $lang['nc_yes'];break;
						case '0':echo $lang['nc_no'];break ;
					}
				?></td>
          <td class="w72 align-center"><a href="index.php?act=coupon&op=edit&coupon_id=<?php echo $v['coupon_id'];?>"><?php echo $lang['nc_edit'];?></a>&nbsp;
          	<?php if($v['coupon_state']=='1'){?>
          	<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=coupon&op=del&coupon_id=<?php echo $v['coupon_id'];?>';}"><?php echo $lang['nc_del'];?></a>
          	<?php }?>
          	</td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <tr>
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td colspan="16"><label for="checkall_2"><?php echo $lang['nc_select_all']; ?></label>
            &nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="submit_form('recommend');"><span><?php echo $lang['nc_recommend'];?></span></a>
            
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/jquery.ui.js" charset="utf-8" ></script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8" ></script>
<link type="text/css" rel="stylesheet" href="<?php echo RESOURCE_PATH."/js/jquery-ui/themes/ui-lightness/jquery.ui.css";?>"/>
<script>
$(function(){

	$('#time_from').datepicker({onSelect:function(dateText,inst){
    	var year2 = dateText.split('-') ;
    	$('#time_to').datepicker( "option", "minDate", new Date(parseInt(year2[0]),parseInt(year2[1])-1,parseInt(year2[2])) );
    }});
    $('#time_to').datepicker({onSelect:function(dateText,inst){
    	var year1 = dateText.split('-') ;
    	$('#time_from').datepicker( "option", "maxDate", new Date(parseInt(year1[0]),parseInt(year1[1])-1,parseInt(year1[2])) );
    }})
	
})

//提交方法
function submit_form(type){
	$('#submit_type').val(type);
	$('#formProcess').submit();
}
</script> 