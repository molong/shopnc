<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['upload_set'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=setting&op=image_setting"><span><?php echo $lang['upload_pic_base'];?></span></a></li>
        <li><a href="index.php?act=setting&op=font_setting"><span><?php echo $lang['font_set'];?></span></a></li>
        <li><a href="index.php?act=setting&op=base_setting"><span><?php echo $lang['upload_set_base'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['upload_set_ftp'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form1" id="form1" action="index.php?act=setting&op=ftp_test">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['ftp_state'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="ftp_open1" class="cb-enable <?php if($output['list_setting']['ftp_open'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="ftp_open0" class="cb-disable <?php if($output['list_setting']['ftp_open'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="ftp_open1" name="ftp_open" <?php if($output['list_setting']['ftp_open'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="ftp_open0" name="ftp_open" <?php if($output['list_setting']['ftp_open'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_state_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="site_name"><?php echo $lang['ftp_ssl_state'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform onoff"><label for="ftp_ssl_state1" class="cb-enable <?php if($output['list_setting']['ftp_ssl_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open'];?></span></label>
            <label for="ftp_ssl_state0" class="cb-disable <?php if($output['list_setting']['ftp_ssl_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['close'];?></span></label>
            <input id="ftp_ssl_state1" name="ftp_ssl_state" <?php if($output['list_setting']['ftp_ssl_state'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="ftp_ssl_state0" name="ftp_ssl_state" <?php if($output['list_setting']['ftp_ssl_state'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_ssl_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_server"><?php echo $lang['ftp_server'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform"><input id="ftp_server" name="ftp_server" value="<?php echo $output['list_setting']['ftp_server'];?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_server_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_port"><?php echo $lang['ftp_port'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform"><input id="ftp_port" name="ftp_port" value="<?php echo ($port = $output['list_setting']['ftp_port']) ? $port : '21';?>" class="txt" type="text" /></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_port_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_username"><?php echo $lang['ftp_username'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform"><input id="ftp_username" name="ftp_username" value="<?php echo $output['list_setting']['ftp_username'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_username_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_password"><?php echo $lang['ftp_password'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform"><input id="ftp_password" name="ftp_password" value="<?php echo $output['list_setting']['ftp_password'];?>" class="txt" type="password"></td>
          <td class="vatop tips"><span class="vatop rowform"></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_pasv"><?php echo $lang['ftp_pasv'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform onoff"><label for="ftp_pasv1" class="cb-enable <?php if($output['list_setting']['ftp_pasv'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['open_yes'];?></span></label>
            <label for="ftp_pasv0" class="cb-disable <?php if($output['list_setting']['ftp_pasv'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['open_no'];?></span></label>
            <input id="ftp_pasv1" name="ftp_pasv" <?php if($output['list_setting']['ftp_pasv'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="ftp_pasv0" name="ftp_pasv" <?php if($output['list_setting']['ftp_pasv'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_pasv_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_attach_dir"><?php echo $lang['ftp_attach_dir'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform"><input id="ftp_attach_dir" name="ftp_attach_dir" value="<?php echo $output['list_setting']['ftp_attach_dir'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_attach_dir_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_access_url"><?php echo $lang['ftp_access_url'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform"><input id="ftp_access_url" name="ftp_access_url" value="<?php echo $output['list_setting']['ftp_access_url'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_access_url_tip'];?></span></td>
        </tr>
         <tr class="_ftp">
          <td colspan="2" class="required"><label for="ftp_timeout"><?php echo $lang['ftp_timeout'];?>:</label></td>
        </tr>
        <tr class="noborder _ftp">
          <td class="vatop rowform"><input id="ftp_timeout" name="ftp_timeout" value="<?php echo ($ttl = $output['list_setting']['ftp_timeout'])? $ttl : '0';?>" class="txt" type="text"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_timeout_tip'];?></span></td>
        </tr>
        <tr class="_ftp">
          <td class="vatop rowform">
          <input id="ftp_test" name="ftp_test" value="<?php echo $lang['ftp_test'];?>" class="btn" type="button"></td>
          <td class="vatop tips"><span class="vatop rowform"><?php echo $lang['ftp_test_tip'];?></span></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.action='index.php?act=setting&op=ftp_setting';document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function(){
	$('#ftp_test').click(function(){
		$(this).val('loading......');
		$(this).attr('disabled',true);
		if ($('#ftp_ssl_state1').attr('checked')){
			ftp_ssl_state = 1;
		}else{
			ftp_ssl_state = 0;
		}
		if ($('#ftp_pasv1').attr('checked')){
			ftp_pasv = 1;
		}else{
			ftp_pasv = 0;
		}
		$.ajax({
			type:'POST',
			url:'index.php',
			data:'act=setting&op=ftp_test&ftp_ssl_state='+ftp_ssl_state+'&ftp_port='+$('#ftp_port').val()+'&ftp_server='+$('#ftp_server').val()+'&ftp_username='+$('#ftp_username').val()+'&ftp_password='+$('#ftp_password').val()+'&ftp_pasv='+ftp_pasv+'&ftp_attach_dir='+$('#ftp_attach_dir').val()+'&ftp_access_url='+$('#ftp_access_url').val()+'&ftp_timeout='+$('#ftp_timeout').val(),
			error:function(){
					alert('<?php echo $lang['ftp_error-102'];?>');
					$('#ftp_test').val('<?php echo $lang['ftp_test'];?>');
					$('#ftp_test').attr('disabled',false);
				},
			success:function(html){
				alert(html.msg);
				$('#ftp_test').val('<?php echo $lang['ftp_test'];?>');
				$('#ftp_test').attr('disabled',false);
			},
			dataType:'json'
		});
	});
	$('#ftp_open1').click(function(){
		$('._ftp').css('display','');
	});
	$('#ftp_open0').click(function(){
		$('._ftp').css('display','none');
	});
	<?php if($output['list_setting']['ftp_open'] == '0') {?>
		$('._ftp').css('display','none');
	<?php }?>
});

</script>