<?php
defined('InShopNC') or exit('Access Invalid!');

$style_template = <<<EOT
<table class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0" width="1000">
	<tbody>
		<tr>
			<td>
				<img src="templates/{$tpl_name}/store/style/style7/images/1.jpg" usemap="#Map20120511c" border="0" width="1000" /> 
			</td>
		</tr>
		<tr>
			<td>
				<table style="width:1000px;height:30px;" class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="vertical-align:top;" width="23%">
								<div style="background-color:#E53333;" width="100%">
									<span style="text-align:left;color:#FFFFFF;font-size:20px;">上班时间
8:30-20:30</span> 
								</div>
								<div style="font-size:16px;padding-top:15px;">
									<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=12345&amp;Site=qq&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=2:12345:41" alt="点击这里给我发消息" title="点击这里给我发消息" />客服12345</a> 
								</div>
								<div style="font-size:16px;padding-top:15px;">
									投诉建议
								</div>
							</td>
							<td style="vertical-align:top;">
								<div style="text-align:left;background-color:#E53333;" width="100%">
									<span style="color:#FFFFFF;font-size:20px;font-family:Microsoft YaHei;"><strong>快速导航</strong></span> 
								</div>
								<div style="font-size:16px;padding-top:15px;">
									分类1  子分类
								</div>
								<div style="font-size:16px;padding-top:15px;">
									分类2
								</div>
							</td>
							<td style="vertical-align:top;" width="20%">
								<div style="background-color:#E53333;color:#FFFFFF;font-size:20px;" width="100%">
									最新动态
								</div>
 <a target="_blank" href="$site_url">Shop旗舰店</a>田园家具 田园衣柜 衣橱 推拉门 三门衣柜 实木衣柜 . 
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<img src="templates/{$tpl_name}/store/style/style7/images/2.jpg" usemap="#Map20120511d" border="0" width="1000" /> 
			</td>
		</tr>
		<tr>
			<td>
				<img src="templates/{$tpl_name}/store/style/style7/images/4.jpg" usemap="#Map20120511h" border="0" width="1000" /> 
			</td>
		</tr>
		<tr>
			<td>
				<img src="templates/{$tpl_name}/store/style/style7/images/3.jpg" usemap="#Map20120511j" border="0" width="1000" /> 
			</td>
		</tr>
	</tbody>
</table>
<map name="Map20120511c"><area href="$site_url" shape="rect" target="_blank" coords="2,9,470,515"><area href="$site_url" shape="rect" target="_blank" coords="483,9,950,515"></map>
<map name="Map20120511d"><area href="$site_url" shape="rect" target="_blank" coords="2,4,310,294"><area href="$site_url" shape="rect" target="_blank" coords="319,4,630,293"><area href="$site_url" shape="rect" target="_blank" coords="636,6,949,580"><area href="$site_url" shape="rect" target="_blank" coords="3,303,633,578"></map>
<map name="Map20120511h"><area href="$site_url" shape="rect" target="_blank" coords="4,82,312,403"><area href="$site_url" shape="rect" target="_blank" coords="319,81,633,404"><area href="$site_url" shape="rect" target="_blank" coords="638,82,949,404"></map>
<map name="Map20120511j"><area href="$site_url" shape="rect" target="_blank" coords="2,6,312,325"><area href="$site_url" shape="rect" target="_blank" coords="320,7,630,323"><area href="$site_url" shape="rect" target="_blank" coords="640,6,948,323"></map>
EOT;


$style_info = <<<EOT
	<img alt="" style="width:300px;float:left;margin:0px;" src="templates/{$tpl_name}/store/style/style7/images/style.jpg" border="0" />
  <div style=" float: right;margin: 0 auto;width:300px;  line-height:24px;">
    <p> 可编辑区域的宽度为1000px </p>
    <p> <strong>1</strong>号由一张图片展示，通过“热点”（&lt;area&nbsp;/&gt;标签）实现链接的跳转。  </p>
    <p> <strong>2</strong>号为文字区域，可以填写客服、商品分类、公告等内容。 </p>
    <p> <strong>3</strong>号由一张图片展示，通过“热点”（&lt;area&nbsp;/&gt;标签）实现链接的跳转。 </p>
    <p> <strong>4</strong>号由一张图片展示，通过“热点”（&lt;area&nbsp;/&gt;标签）实现链接的跳转。 </p>
    <p> <strong>5</strong>号由一张图片展示，通过“热点”（&lt;area&nbsp;/&gt;标签）实现链接的跳转。</p>
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