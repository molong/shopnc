<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form method="post"  action="index.php?act=store&op=store_setting" enctype="multipart/form-data" id="my_store_form">
      <input type="hidden" name="form_submit" value="ok" />
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_create_store_name'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input class="text w400" id="store_name" type="text"  name="store_name" value="<?php echo $output['store_info']['store_name'];?>" maxlength="20"/>
          </p>
          <p class="hint"> <?php echo $lang['store_create_store_name_hint'];?> </p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_setting_grade'].$lang['nc_colon'];?></dt>
        <dd>
          <p><?php echo $output['store_grade']['sg_name']; ?>
            <?php if (count($output['gradelog'])>0){?>
            <!-- 店铺等级升级为··的申请，正在审核中 --> 
            &nbsp;&nbsp;&nbsp;&nbsp;<font style="font-weight:bold;" ><?php echo $lang['store_upgrade_exist_tip_1']; //店铺等级升级为?> &nbsp;"<?php echo $output['gradelog']['gl_sgname']; ?>"&nbsp;<?php echo $lang['store_upgrade_exist_tip_2'];//的申请，正在审核中...?></font>
            <?php }else {?>
            <a href="index.php?act=member_store&op=update_grade" class="ncu-btn2" target="_blank" title="<?php echo $lang['store_setting_upgrade'];?>"><?php echo $lang['store_setting_upgrade'];?></a>
            <?php }?>
          </p>
          </dt>
      </dl>
      <dl>
        <dt><?php echo $lang['store_setting_store_zy'].$lang['nc_colon']; ?></dt>
        <dd>
          <p>
            <textarea name="store_zy" rows="2" class="textarea w400"  maxlength="50" ><?php echo $output['store_info']['store_zy'];?></textarea>
          </p>
          <p class="hint"><?php echo $lang['store_create_store_zy_hint'];?></p>
        </dd>
      </dl>
      <dl class="setup store-label">
        <dt><?php echo $lang['store_setting_change_label'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="hidden" name="store_old_label" value="<?php echo $output['store_info']['store_label'];?>" />
          <p class="picture"><span class="thumb" style="width:200px; height:60px;"><i></i><img src="<?php if(empty($output['store_info']['store_label'])){ echo TEMPLATES_PATH.'/images/member/storelogo.png';}else{ echo ATTACH_STORE.'/'.$output['store_info']['store_label'];}?>"  onload="javascript:DrawImage(this,200,60);" nc_type="store_label" /></span> </p>
          <p>
            <input name="store_label" type="file"  hidefocus="true" id="storeLablePic" nc_type="change_store_label"/>
          </p>
          <p class="hint"><?php echo $lang['store_setting_label_tip'];?></p>
        </dd>
      </dl>
      <dl class="setup store-top-banner">
        <dt><?php echo $lang['store_setting_change_banner'].$lang['nc_colon'];?> </dt>
        <dd>
          <input type="hidden" name="store_old_banner" value="<?php echo $output['store_info']['store_banner'];?>" />
          <p class="picture"><span class="thumb" style="width:638px; height:158px;"><i></i><img src="<?php if(empty($output['store_info']['store_banner'])){ echo TEMPLATES_PATH.'/images/member/banner.PNG';}else{ echo ATTACH_STORE.'/'.$output['store_info']['store_banner'];}?>"  onload="javascript:DrawImage(this,638,158);" nc_type="store_banner" /></span></p>
          <p>
            <input name="store_banner" type="file"  hidefocus="true" id="storeBannerPic" nc_type="change_store_banner"/>
          </p>
          <p class="hint"><?php echo $lang['store_setting_banner_tip'];?></p>
        </dd>
      </dl>
      <dl class="setup store-logo">
        <dt><?php echo $lang['store_setting_change_sign'].$lang['nc_colon'];?> </dt>
        <dd>
          <input type="hidden" name="store_old_logo" value="<?php echo $output['store_info']['store_logo'];?>" />
          <p class="picture"><span class="thumb" style="width:100px; height:100px;"><i></i><img src="<?php if(empty($output['store_info']['store_logo'])){ echo ATTACH_COMMON.DS.$GLOBALS['setting_config']['default_store_logo'];}else{ echo ATTACH_STORE.'/'.$output['store_info']['store_logo'];}?>"  onload="javascript:DrawImage(this,100,100);" nc_type="store_logo" /></span> </p>
          <p>
            <input name="store_logo" type="file"  hidefocus="true"id="storeLogoPic" nc_type="change_store_logo"/>
          </p>
          <p class="hint"><?php echo $lang['store_setting_sign_tip'];?></p>
        </dd>
      </dl>
      <?php if($output['subdomain'] == '1'){?>
      <dl>
        <dt><?php echo $lang['store_setting_uri'].$lang['nc_colon'];?></dt>
        <dd>
          <?php if($output['subdomain_edit'] == '1' || empty($output['store_info']['store_domain'])){?>
          <p>
            <input type="text" class="text"  name="store_domain" value="<?php echo $output['store_info']['store_domain'];?>"  />
            &nbsp;<?php echo '.'.$GLOBALS['setting_config']['subdomain_suffix'];?> &nbsp;</p>
          <p class="hint"><?php echo $lang['store_setting_uri_tip'];?>: <?php echo $GLOBALS['setting_config']['subdomain_length'];?>
            <?php if($output['subdomain_edit'] == '1'){?>
            &nbsp; &nbsp;<?php echo $lang['store_setting_domain_times'];?>: <?php echo $output['store_info']['store_domain_times'];?> &nbsp; &nbsp;<?php echo $lang['store_setting_domain_times_max'];?>: <?php echo $output['subdomain_times'];?>
            <?php }else {?>
            &nbsp; &nbsp;<?php echo $lang['store_setting_domain_notice'];?>
            <?php }?>
          </p>
          <?php }else {?>
          <p><?php echo $output['store_info']['store_domain'];?><?php echo '.'.$GLOBALS['setting_config']['subdomain_suffix'];?> &nbsp;</p>
          <p class="hint"><?php echo $lang['store_setting_domain_tip'];?>
            <?php if($GLOBALS['setting_config']['subdomain_edit'] == '1'){?>
            &nbsp; &nbsp;<?php echo $lang['store_setting_domain_times'];?>: <?php echo $output['store_info']['store_domain_times'];?> &nbsp; &nbsp;<?php echo $lang['store_setting_domain_times_max'];?>: <?php echo $output['subdomain_times'];?>
            <?php }?>
          </p>
          <?php }?>
        </dd>
      </dl>
      <?php }?>
      <dl>
        <dt><?php echo $lang['store_create_card_no'].$lang['nc_colon'];?></dt>
        <dd>
          <p><?php echo $output['store_info']['store_owner_card'];?> </p>
        </dd>
      </dl>
      <dl>
        <dt class="required"><em class="pngFix"></em><?php echo $lang['store_create_location'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="select_add" id="region" style="width:500px;border:1px solide red;">
            <?php if(!empty($output['store_info']['area_id'])){?>
            <span><?php echo $output['store_info']['area_info'];?></span>
            <input type="button" value="<?php echo $lang['nc_edit'];?>" class="edit_region" />
            <select style="display:none;">
            </select>
            <?php }else{?>
            <select>
            </select>
            <?php }?>
            <input type="hidden" name="area_id" id="area_id" value="<?php echo $output['store_info']['area_id']?$output['store_info']['area_id']:'';?>" class="area_ids" />
            <input type="hidden" name="area_info" id="area_info" value="<?php echo $output['store_info']['area_info'];?>" class="area_names" />
          </div>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_create_address'].$lang['nc_colon'];?></dt>
        <dd>
          <p>
            <input name="store_address" type="text" class="text w400"  id="store_address" value="<?php echo $output['store_info']['store_address'];?>"/>
          </p>
          <p class="hint"><?php echo $lang['store_setting_location_tip'];?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_create_phone'].$lang['nc_colon'];?></dt>
        <dd>
          <input class="text w200" name="store_tel" type="text"  id="store_tel" value="<?php echo $output['store_info']['store_tel'];?>" maxlength="20"/>
        </dd>
      </dl>
      <dl>
        <dt>QQ<?php echo $lang['nc_colon'];?></dt>
        <dd>
          <input class="w200 text" name="store_qq" type="text"  id="store_qq" value="<?php echo $output['store_info']['store_qq'];?>" />
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_setting_wangwang'].$lang['nc_colon'];?></dt>
        <dd>
          <input class="text w200" name="store_ww" type="text"  id="store_ww" value="<?php echo $output['store_info']['store_ww'];?>" />
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_setting_intro'].$lang['nc_colon'];?></dt>
        <dd>
          <?php showEditor('store_description',$output['store_info']['description'],'600px','300px','','false',$output['editor_multimedia']); ?>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_setting_seo_keywords'].$lang['nc_colon']; ?></dt>
        <dd>
          <p>
            <input class="text w400" name="seo_keywords" type="text"  value="<?php echo $output['store_info']['store_keywords'];?>" />
          </p>
          <p class="hint"><?php echo $lang['store_setting_seo_keywords_help']; ?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_setting_seo_description'].$lang['nc_colon']; ?></dt>
        <dd>
          <p>
            <textarea name="seo_description" rows="3" class="textarea w400" id="remark_input" ><?php echo $output['store_info']['store_description'];?></textarea>
          </p>
          <p class="hint"><?php echo $lang['store_setting_seo_description_help']; ?></p>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['store_setting_store_code'].$lang['nc_colon']?></dt>
        <dd>
          <p><span style="background:url('<?php echo TEMPLATES_PATH;?>/images/loading.gif') no-repeat 50% 50%; display:inline-block; min-width:100px; min-height:100px; float:left;"><img id="img_store_code" src="<?php echo ATTACH_STORE.DS.$output['store_info']['store_code']?>" onerror="this.src='<?php echo SiteUrl.DS.ATTACH_STORE.DS.'default_qrcode.png';?>'" /></span><a id="a_store_code" href="index.php?act=store&op=ajax_change_store_code" style=" border:solid 1px #CCC; border-radius: 4px; padding: 2px 12px;float:left; margin-top: 70px; color: #777; box-shadow: 2px 2px 0 rgba(51,51,51,0.1)"><?php echo $lang['store_setting_store_code_update'];?></a> </p>
          <p><?php echo $lang['store_setting_store_url'];?>
            <?php
            if($output['subdomain']==1 && $output['store_info']['store_domain'] != ''){
                echo ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store', $output['store_info']['store_domain']);
            }else{
                echo SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$output['store_info']['store_id']), 'store', $output['store_info']['store_domain']);
            }
            ?>
          </p>
          <p class="hint"><?php echo $lang['store_setting_store_code_help'];?></p>
        </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['store_goods_class_submit'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
	regionInit("region");
	$('input[nc_type="change_store_logo"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="store_logo"]').attr('src', src);
	});
	$('input[nc_type="change_store_banner"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="store_banner"]').attr('src', src);
	});
	$('input[nc_type="change_store_label"]').change(function(){
		var src = getFullPath($(this)[0]);
		$('img[nc_type="store_label"]').attr('src', src);
	});
	$('input[class="edit_region"]').click(function(){
		$(this).css('display','none');
		$('#area_id').val('');
		$(this).parent().children('select').css('display','');
		$(this).parent().children('span').css('display','none');
	});
	jQuery.validator.addMethod("domain", function(value, element) {
			return this.optional(element) || /^[\w\-]+$/i.test(value);
		}, ""); 
	$('#my_store_form').validate({
    	submitHandler:function(form){
    		ajaxpost('my_store_form', '', '', 'onerror')
    	},
		rules : {
        	<?php if(($output['subdomain'] == '1') && ($output['subdomain_edit'] == '1' || empty($output['store_info']['store_domain']))){?>
					store_domain: {
						domain: true,
		        rangelength:[<?php echo $output['subdomain_length'][0];?>, <?php echo $output['subdomain_length'][1];?>]
					},
          <?php }?>
        	store_name: {
                required: true,
                remote : {
                    url  : 'index.php?act=store&op=checkname&column=ok',
                    type : 'get',
                    data : {
                        store_name : function(){
                            return $('#store_name').val();
                        }
                    }
                }
            },
            area_id: {
				required: true,
				checkarea : true
			}
        },
        messages : {
        	<?php if(($output['subdomain'] == '1') && ($output['subdomain_edit'] == '1' || empty($output['store_info']['store_domain']))){?>
					store_domain: {
						domain: '<?php echo $lang['store_setting_domain_valid'];?>',
		        rangelength:'<?php echo $lang['store_setting_domain_rangelength'];?>'
					},
          <?php }?>
        	store_name: {
                required: '<?php echo $lang['store_create_input_store_name'];?>',
                remote: '<?php echo $lang['store_create_store_name_exists'];?>'
            },
            area_id: {
            	required: '<?php echo $lang['store_create_choose_area'];?>',
            	checkarea: '<?php echo $lang['store_create_choose_area'];?>'
			}
        }
    });
    
    // ajax 修改店铺二维码
    $('#a_store_code').click(function(){
    	$('#img_store_code').attr('src','');
		$.getJSON($(this).attr('href'),function(data){
			$('#img_store_code').attr('src','<?php echo ATTACH_STORE.DS;?>'+data);
		});
		return false;
    });    
    
});
</script> 
