<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
$(document).ready(function(){
	
    $(".complain_dialog").hide();
    $("#verify_button").click(function(){
         if(confirm("<?php echo $lang['verify_submit_message'];?>")) {
             $("#verify_form").submit();
         }
    });
    $("#close_button").click(function(){
        $("final_handle_message").text('');
        $(".complain_dialog").show();
        $("#close_complain").hide();
    });
    $("#btn_handle_submit").click(function(){
        if($("#final_handle_message").val()=='') {
            alert("<?php echo $lang['final_handle_message_error'];?>");
        }
        else {
            if(confirm("<?php echo $lang['complain_close_confirm'];?>")) {
                $("#close_form").submit();
            }
        }
    });
    $("#btn_close_cancel").click(function(){
        $(".complain_dialog").hide();
        $("#close_complain").show();
    });

});
</script>

<div class="page">
<div class="fixed-bar">
  <div class="item-title">
    <h3><?php echo $lang['complain_manage_title'];?></h3>
    <ul class="tab-base">
      <?php 
		foreach($output['menu'] as $menu) { 
		if($menu['menu_type'] == 'text') {
        ?>
      <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
      <?php
		}
		 else {
        ?>
      <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
      <?php 
		}
		} 
        ?>
    </ul>
  </div>
</div>
<div class="fixed-empty"></div>
<?php 
        include template('complain_order.info',ProjectName);
        include template('complain_complain.info',ProjectName);
        if(!empty($output['complain_info']['appeal_message'])) {
            include template('complain_appeal.info',ProjectName);
        }
        if(intval($output['complain_info']['complain_state'])>20) {
            include template('complain_talk.info',ProjectName);
        }
        if(!empty($output['complain_info']['final_handle_message'])) {
            include template('complain_finish.info',ProjectName);
        }
    ?>
<?php if(intval($output['complain_info']['complain_state']) !== 99) { ?>
<table class="table tb-type2 order mtw">
  <thead class="thead">
    <tr class="space">
      <th><?php echo $lang['complain_handle'];?></th>
    </tr>
  </thead>
  <tbody>
  <tr id="close_complain">
      <td>
          <form method='post' id="verify_form" action="index.php?act=complain&op=complain_verify">
              <input name="complain_id" type="hidden" value="<?php echo $output['complain_info']['complain_id'];?>" />
              <?php if(intval($output['complain_info']['complain_state']) === 10) { ?>
              <a id="verify_button" class="btn" href="javascript:void(0)"><span><?php echo $lang['complain_text_verify'];?></span></a>
              <?php } ?>
              <?php if(intval($output['complain_info']['complain_state']) !== 99) { ?>
              <a id="close_button" class="btn" href="javascript:void(0)"><span><?php echo $lang['complain_text_close'];?></span></a>
              <?php } ?>
          </form>
      </td>
  </tr>
  <form method='post' id="close_form" action="index.php?act=complain&op=complain_close">
  	<?php if(!empty($output['refund']) && is_array($output['refund'])) { ?>
    <tr class="complain_dialog">
      <th><?php echo $lang['refund_state_yes'];?>:</th>
    </tr>
    <tr class="noborder complain_dialog">
      <td class="vatop rowform onoff">
      	<input name="log_id" type="hidden" value="<?php echo $output['refund']['log_id'];?>" />
      	<label for="refund_state2" class="cb-enable" title="<?php echo $lang['nc_yes'];?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="refund_state3" class="cb-disable selected" title="<?php echo $lang['nc_no'];?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input type="radio" id="refund_state2" value="2" name="refund_state">
            <input type="radio" id="refund_state3" checked="checked" value="3" name="refund_state"></td>
    </tr>
  	<?php } ?>
    <tr class="complain_dialog">
      <th><?php echo $lang['final_handle_message'];?>:</th>
    </tr>
    <input name="complain_id" type="hidden" value="<?php echo $output['complain_info']['complain_id'];?>" />
    <tr class="noborder complain_dialog">
      <td><textarea id="final_handle_message" name="final_handle_message" class="tarea"></textarea></td>
    </tr>
    <tr class="complain_dialog">
        <td>
            <a id="btn_handle_submit" class="btn" href="javascript:void(0)"><span><?php echo $lang['nc_submit'];?></span></a>
            <a id="btn_close_cancel" class="btn" href="javascript:void(0)"><span><?php echo $lang['nc_cancel'];?></span></a>
        </td>
    </tr>
  </form>
    </tbody>
</table>
<?php } ?>
