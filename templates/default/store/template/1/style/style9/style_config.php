<?php
defined('InShopNC') or exit('Access Invalid!');

$style_template = <<<EOT
<table class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr>
			<td colspan="2">
				<img alt="" src="templates/{$tpl_name}/store/style/style9/images/01.jpg" width="1000" /> 
			</td>
		</tr>
		<tr>
			<td>
				<a href="$site_url" target="_blank"><img alt="" src="templates/{$tpl_name}/store/style/style9/images/02.jpg" border="0" width="500" /></a> 
			</td>
			<td>
				<a href="$site_url" target="_blank"><img alt="" src="templates/{$tpl_name}/store/style/style9/images/03.jpg" border="0" width="500" /></a> 
			</td>
		</tr>
	</tbody>
</table>
<table class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr>
			<td colspan="3">
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/11.jpg" alt="" border="0" height="439" width="1000" /></a> 
			</td>
		</tr>
		<tr>
			<td>
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/12.jpg" alt="" border="0" height="383" width="333" /></a> 
			</td>
			<td>
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/13.jpg" alt="" border="0" height="383" width="333" /></a> 
			</td>
			<td>
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/14.jpg" alt="" border="0" height="383" width="333" /></a> 
			</td>
		</tr>
	</tbody>
</table>
<table style="width:1000px;" class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td style="width:660px;background-color:#F0D7CC;">
				<table style="width:100%;" class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="height:130px;vertical-align:top;">
								<span class="f1" style="font-size:18px;font-family:KaiTi_GB2312;"><strong>热门分类</strong></span><span class="fr" style="font-size:18px;font-family:KaiTi_GB2312;"><strong><a href="$site_url">查看所有宝贝&gt;&gt; </a></strong></span><br />
<br />
<a href="$site_url" target="_blank">半身裙</a> <br />
<br />
<a href="$site_url" target="_blank">T恤</a> <br />
<br />
<a href="$site_url" target="_blank">衬衫</a> 
							</td>
						</tr>
						<tr>
							<td style="height:115px;">
								<span style="font-family:Microsoft YaHei;font-size:16px;color:#337FE5;">在线时间：</span> 周一至周日：8:30-20:30<br />
<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=12345&amp;Site=qq&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:12345:41" alt="点击这里给我发消息" title="点击这里给我发消息" />客服12345</a> <br />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
			<td>
				<a href="$site_url" target="_blank"><img alt="" src="templates/{$tpl_name}/store/style/style9/images/19.jpg" border="0" /></a> 
			</td>
		</tr>
	</tbody>
</table>
<table class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr>
			<td>
				<a target="_blank" href="$site_url"><img style="width:1000px;float:none;margin:0px;" src="templates/{$tpl_name}/store/style/style9/images/0.jpg" /></a><br />
			</td>
		</tr>
	</tbody>
</table>
<table class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<img src="templates/{$tpl_name}/store/style/style9/images/31.gif" border="0" width="200" /> 
			</td>
			<td>
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/1.jpg" border="0" width="200" /></a> 
			</td>
			<td>
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/2.jpg" border="0" width="200" /></a> 
			</td>
			<td>
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/3.jpg" border="0" width="200" /></a> 
			</td>
			<td>
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/4.jpg" border="0" width="200" /></a> 
			</td>
		</tr>
	</tbody>
</table>
<img src="templates/{$tpl_name}/store/style/style9/images/33.jpg" width="1000" /> <br />
<table class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr>
			<td width="350">
				<a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/21.jpg" border="0" /></a> 
			</td>
			<td>
				<img src="templates/{$tpl_name}/store/style/style9/images/22.jpg" width="650" /> <br />
				<div style="text-align:right;">
					<a href="$site_url" target="_blank"><img alt="" src="templates/{$tpl_name}/store/style/style9/images/23.jpg" border="0" /></a><a href="$site_url" target="_blank"><img alt="" src="templates/{$tpl_name}/store/style/style9/images/24.jpg" border="0" /></a><a href="$site_url" target="_blank"><img src="templates/{$tpl_name}/store/style/style9/images/25.jpg" border="0" /></a><br />
				</div>
			</td>
		</tr>
	</tbody>
</table>

EOT;


$style_info = <<<EOT
	<img alt="" style="width:300px;float:left;margin:0px;" src="templates/{$tpl_name}/store/style/style9/images/style.jpg" border="0" />
  <div style=" float: right;margin: 0 auto;width:300px;  line-height:24px;">
    <p> 可编辑区域的宽度为1000px </p>
    <p> <strong>1</strong>号为图片区域，一张横幅图片。  </p>
    <p> <strong>2</strong>号为图片区域，由两张构成，可以分别单独修改。 </p>
    <p> <strong>3</strong>号为图片区域，一张横幅图。  </p>
    <p> <strong>4</strong>号为图片区域，由三张构成，可以分别单独修改。  </p>
    <p> <strong>5</strong>号为文字区域，可以填写商品分类、客服等内容。  </p>
    <p> <strong>6</strong>号为图片区域，一张图片。  </p>
    <p> <strong>7</strong>号为图片区域，一张横幅图片。  </p>
    <p> <strong>8</strong>号为图片区域，由五张构成，可以分别单独修改。  </p>
    <p> <strong>9</strong>号为图片区域，一张横幅图片。  </p>
    <p> <strong>10</strong>号为图片区域，由五张构成，可以分别单独修改。  </p>
    <input type="button" name="" value="恢复默认" onclick="insert_template();">
    <p> <span style="color:#999999;">编辑器使用技巧：</span> </p>
    <p style="margin-left:20px;"> <span style="color:#999999;">1可以用“HTML代码”按钮来查看编辑代码。</span> </p>
    <p style="margin-left:20px;"> <span style="color:#999999;">2如果一行要插入多个图片，可先用“表格”按钮分隔。</span> </p>
    <p style="margin-left:20px;"> <span style="color:#999999;">3默认模板中的链接地址为当前网站地址。</span> </p>
    <p style="margin-left:20px;"> <span style="color:#999999;">4“插入相册图片”的链接地址为当前店铺的地址。</span> </p>
    <p style="margin-left:20px;"> <span style="color:#999999;">5编辑器中图片的链接地址可以在鼠标右键的弹出菜单中选择修改。</span> </p>
    <p style="margin-left:20px;"> <span style="color:#999999;">6编辑器中所有内容均可替换修改。</span> <br />
    </p>
  </div>
EOT;

$style_js = '
		$(".ncsl-nav").after($(".flexslider"));
		$(".flexslider").width(1000);
';
?>