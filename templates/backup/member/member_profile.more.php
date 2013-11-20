<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="ncu-form-style">
    <form method="post" id="profile_more" action="index.php?act=home&op=more">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_info']['member_avatar']; ?>" />
      <h4 class="w230 mb10 tip" title="<?php echo $lang['home_memner_more_tag_list_title'];?>"><?php echo $lang['home_member_more_tag_list'];?></h4>
      <div nctype="list" class="user-tag-optional">
        <?php if(!empty($output['mtag_list']) && is_array($output['mtag_list'])){
        			foreach ($output['mtag_list'] as $val){?>
        <span nctype="able" data-param='{"id":"<?php echo $val['mtag_id'];?>"}'><?php echo $val['mtag_name'];?></span>
        <?php }
        			}?>
      </div>
      <h4 class="w90 mt20 mb10 tip" title="<?php echo $lang['home_member_more_my_tag_title'];?>"><?php echo $lang['home_member_more_my_tag'];?></h4>
      <div nctype="choose" class="user-tag-selected">
        <?php if(!empty($output['mtm_list']) && is_array($output['mtm_list'])){
        			foreach ($output['mtm_list'] as $val){?>
        <span nctype="able" data-param='{"id":"<?php echo $val['mtag_id'];?>"}'><?php echo $val['mtag_name'];?><a href="javascript:void(0)" nctype="delTag">
        <input type="hidden" name="mid[]" value="<?php echo $val['mtag_id'];?>" />
        X</a></span>
        <?php }
        			}?>
        <span nctype="ep" class="ep">&nbsp;</span> </div>
      <dl class="bottom">
        <dd>
          <input type="submit" class="submit" value="<?php echo $lang['home_member_save_modify'];?>" />
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.poshytip.min.js" charset="utf-8"></script> 
<script type="text/javascript">
//注册表单验证
$(function(){
	var $list = $('div[nctype="list"]');
	var $choose = $('div[nctype="choose"]');
	var $ep = $('span[nctype="ep"]');
	$('span[nctype="able"]', $list).draggable({ 
		cancel: "a.ui-icon",
        revert: "invalid",
        containment: "document",
       	helper: "clone",
        cursor: "move"
	});
	$('span[nctype="able"]', $choose).draggable({ 
		cancel: "a.ui-icon",
        revert: "invalid",
        containment: "document",
       	helper: "clone",
        cursor: "move"
	});
	$choose.droppable({
		accept: 'div[nctype="list"] span',
		activeClass: "ui-state-highlight",
		drop: function( event, ui ) {
            chooseTeg(ui.draggable);
        }
    });
	$list.droppable({
		accept: 'div[nctype="choose"] span',
		activeClass: "custom-state-active",
        drop: function( event, ui ) {
        	recycleIeg(ui.draggable);
        }
    });

    function chooseTeg($item){
    	$item.fadeOut('fast',function(){
        	eval("data_param = "+($item.attr('data-param')));
    		$item.append('<a href="javascript:void(0)" nctype="delTag"><input type="hidden" name="mid[]" value="'+data_param.id+'" />X</a>')
    		.insertBefore($ep).fadeIn('fast').removeAttr('style');
        });
		
    }
    function recycleIeg($item){
    	$item.fadeOut('fast',function(){
    		$item.find('a').remove().end()
    		.appendTo($list).fadeIn('fast').removeAttr('style');
        });
    }

	$('a[nctype="delTag"]').live('click', function(){
		recycleIeg($(this).parent());
	});

	$('div[nctype="list"]').find('span').live('click', function(){
		chooseTeg($(this));
	});

	$('#profile_more').submit(function(){
		ajaxpost('profile_more', '', '', 'onerror');
		return false;
	});
	$('.tip').poshytip({//Ajax提示
		className: 'tip-yellowsimple',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'right',
		alignY: 'center',
		offsetY: 5,
		allowTipHover: false
	});
});
</script> 