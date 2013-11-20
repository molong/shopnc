<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script>

<div class="wrap-shadow">
  <div class="wrap-all">
    <div class="chart">
      <div class="pos_x1 bg_a1" title="<?php echo $lang['store_create_choose_store_class'];?>"></div>
      <div class="pos_x2 bg_b2" title="<?php echo $lang['store_create_input_owner_info'];?>"></div>
      <div class="pos_x3 bg_c" title="<?php echo $lang['store_create_finish'];?>"></div>
    </div>
    <div class="ncu-form-style grade-shop">
      <form method="post" enctype="multipart/form-data" id="apply_form" action="index.php?act=member_store&op=save">
        <input type="hidden" name="form_submit" value="ok" />
        <input type="hidden" name="grade_id" value="<?php echo intval($_GET['grade_id']) ?>" />
        <dl>
          <dt class="required"><em class="pngFix"></em><?php echo $lang['store_create_store_name'].$lang['nc_colon'] ;?></dt>
          <dd>
            <p>
              <input class="w400 text" type="text" name="store_name" id="store_name" maxlength="20"/>
              <span></span></p>
            <p class="hint"><?php echo $lang['store_create_name_rule'];?></p>
          </dd>
        </dl>
        <dl>
          <dt class="required"><em class="pngFix"></em><?php echo $lang['store_create_store_class'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <select name="sc_id" id="sc_id">
                <option value=""><?php echo $lang['nc_please_choose'];?></option>
                <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
                <?php foreach($output['parent_list'] as $k => $v){ ?>
                <option value="<?php echo $v['sc_id'];?>"><?php echo $v['sc_name'];?></option>
                <?php } ?>
                <?php } ?>
              </select>
              <span></span></p>
          </dd>
        </dl>
        <dl>
          <dt class="required"><?php echo $lang['store_setting_store_zy'].$lang['nc_colon']; ?></dt>
          <dd>
            <p>
              <textarea name="store_zy" rows="2" class="textarea w400" maxlength="50" ><?php echo $output['store_info']['store_zy'];?></textarea>
              <span></span> </p>
            <p class="hint"><?php echo $lang['store_create_store_zy_hint'];?></p>
          </dd>
        </dl>
        <dl>
          <dt class="required"><em class="pngFix"></em><?php echo $lang['store_create_location'].$lang['nc_colon'];?></dt>
          <dd>
            <p id="region">
              <input type="hidden" name="area_id" id="area_id" value="" class="area_ids" />
              <input type="hidden" name="area_info" value="" class="area_names" />
              <select class="d_inline">
              </select>
              <span></span> </p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_create_address'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input class="w400 text" type="text" name="store_address"/>
              <span></span></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_create_zipcode'].$lang['nc_colon'];?></dt>
          <dd>
            <input type="text" class="text w200" name="store_zip"/>
          </dd>
        </dl>
        <dl>
          <dt class="required"><em class="pngFix"></em><?php echo $lang['store_create_phone'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input type="text" class="text w200" name="store_tel" maxlength="20" />
              <span></span></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_create_card_no'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input type="text" class="text w200" name="store_owner_card"/>
              <span></span></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_create_upload_paper'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input type="file" name="image" />
              <span class="field_notice"><a target="_blank" href="<?php echo ncUrl(array('act'=>'document','code'=>'real_name'), 'document');?>"><?php echo $lang['store_create_true_name_intro'];?>?</a></span></p>
            <p class="hint"><?php echo $lang['store_create_upload_rule'];?></p>
          </dd>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_create_upload_licence'].$lang['nc_colon'];?></dt>
          <dd>
            <p>
              <input type="file" name="image1" />
              <span class="field_notice"><a target="_blank" href="<?php echo ncUrl(array('act'=>'document','code'=>'real_store'), 'document');?>"><?php echo $lang['store_create_true_store_intro'];?>?</a></span></p>
            <p class="hint"><?php echo $lang['store_create_upload_rule'];?></p>
          </dd>
        </dl>
        <dl class="bottom">
          <dt>&nbsp;</dt>
          <dd>
            <p class="mb10">
              <input name="notice" type="checkbox" id="notice" value="1" checked="checked" />
              <label for="notice"><?php echo $lang['store_create_read_agreement1'];?><a href="<?php echo ncUrl(array('act'=>'document','code'=>'open_store') ,'document');?>" target="_blank"><?php echo $lang['store_create_store_agreement'];?></a><?php echo $lang['store_create_read_agreement2'];?></label>
            <span></span> </p>
            <p class="mb10">
              <input type="submit" class="submit" value="<?php echo $lang['store_create_create_now'];?>" />
            </p>
          </dd>
        </dl>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
    regionInit("region");
	
    $("#apply_form").validate({
        errorPlacement: function(error, element){
           var error_td = element.parent('p').children('span');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        submitHandler:function(form){
            ajaxpost('apply_form', '', '', 'onerror');
        },
        rules: {
            store_owner_card: {
            	minlength: 18,
            	maxlength: 18
            },
            store_name: {
                required: true,
            	maxlength: 20,
                remote : {
                    url  : 'index.php?act=member_store&op=checkname&column=ok',
                    type : 'get',
                    data : {
                        store_name : function(){
                            return $('#store_name').val();
                        }
                    }
                }
            },
            store_tel: {
                required: true,
                minlength:6
            },
			sc_id: {
				required: true
			},
			area_id: {
				required: true,
				checkarea : true
			},
			store_zip: {
				number: true,
            	minlength: 6,
            	maxlength: 6
			},
            image: {
                accept: "jpg|jpeg|png|gif"
            },
            image1: {
                accept: "jpg|jpeg|png|gif"
            },
            notice: {
                required : true
            }
        },
        messages: {
            store_owner_card: {
            	minlength: '<?php echo $lang['store_create_input_store_card']?>',
            	maxlength: '<?php echo $lang['store_create_input_store_card']?>'
            },
            store_name: {
                required: '<?php echo $lang['store_create_input_store_name'];?>',
            		maxlength: '<?php echo $lang['store_create_name_rule']?>',
                remote: '<?php echo $lang['store_create_store_name_exists'];?>'
            },
            store_tel: {
                required: '<?php echo $lang['store_create_input_phone'];?>',
                minlength: '<?php echo $lang['store_create_phone_rule'];?>'
            },
			sc_id: {
				required: '<?php echo $lang['store_create_choose_store_class'];?>'
			},
			area_id: {
				required: '<?php echo $lang['store_create_choose_area'];?>',
				checkarea: '<?php echo $lang['store_create_choose_area'];?>'
			},
			store_zip: {
				number: '<?php echo $lang['store_create_input_zip_code_is_number'];?>',
            	minlength: '<?php echo $lang['store_create_input_zip_code'];?>',
            	maxlength: '<?php echo $lang['store_create_input_zip_code'];?>'
			},
            image: {
                accept: '<?php echo $lang['store_create_upload_type'];?>'
            },
            image1: {
                accept: '<?php echo $lang['store_create_upload_type'];?>'
            },
            notice: {
                required: '<?php echo $lang['store_create_read_agreement'];?>'
            }
        }
    });
});
//]]>
</script>