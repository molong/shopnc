<?php
defined('InShopNC') or exit('Access Invalid!');

$style_template = <<<EOT
<table id="style8_nav" style="width:1000px;" class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0">
	<!--id="style8_nav"为页面JS程序调用，请勿修改-->
	<tbody>
		<tr>
			<td style="height:50px;background-color:#FFFFFF;">
				<table style="width:1000px;height:50px;" class="ke-zeroborder" border="0" bordercolor="#000000" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td style="background-color:#FF0000;">
								<a href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/logo_uq_01.gif" width="50" /></a> 
							</td>
							<td width="75">
								<div style="width:70px;height:25px;padding-top:10px;text-align:center;font-size:14px;border-right-style:dotted;border-right-width:2px;border-right-color:#cccccc;">
									<a href="$site_url"><strong><span style="color:#333333;">衬衫</span></strong> </a> 
								</div>
							</td>
							<td width="75">
								<div style="width:70px;height:25px;padding-top:10px;text-align:center;font-size:14px;border-right-style:dotted;border-right-width:2px;border-right-color:#cccccc;">
									<a href="$site_url"><strong><span style="color:#333333;">裙子</span></strong> </a> 
								</div>
							</td>
							<td width="75">
								<div style="width:70px;height:25px;padding-top:10px;text-align:center;font-size:14px;border-right-style:dotted;border-right-width:2px;border-right-color:#cccccc;">
									<a href="$site_url"><strong><span style="color:#333333;">童装</span></strong> </a> 
								</div>
							</td>
							<td width="75">
								<div style="width:70px;height:25px;padding-top:10px;text-align:center;font-size:14px;border-right-style:dotted;border-right-width:2px;border-right-color:#cccccc;">
									<a href="$site_url"><strong><span style="color:#333333;">男鞋</span></strong> </a> 
								</div>
							</td>
							<td width="75">
								<div style="width:70px;height:25px;padding-top:10px;text-align:center;font-size:14px;">
									<a href="$site_url"><strong><span style="color:#333333;">女鞋</span></strong> </a> 
								</div>
							</td>
							<td width="250">
								<br />
							</td>
							<td style="width:120px;padding-top:3px;background-color:#B0ADB2;text-align:center;font-size:16px;">
								<a href="index.php?act=show_store&amp;id={$_SESSION['store_id']}"><span style="color:#FFFFFF;"> <strong>店铺首页</strong> </span></a> 
							</td>
							<td style="width:120px;padding-top:3px;background-color:#807F83;text-align:center;font-size:16px;">
								<a href="index.php?act=show_store&amp;op=credit&amp;id={$_SESSION['store_id']}"><span style="color:#FFFFFF;"><strong>信用评价</strong> </span></a> 
							</td>
							<td style="width:110px;padding-top:3px;background-color:#67666A;text-align:center;font-size:16px;">
								<a href="index.php?act=show_store&amp;op=store_info&amp;id={$_SESSION['store_id']}"><span style="color:#FFFFFF;"><strong>店铺详情</strong> </span></a> 
							</td>
							<td>
								<br />
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td style="background-color:#FFFFFF;border-top:1px solid #dcdcdc;margin-bottom:1px;">
				<table style="width:100%;" class="ke-zeroborder" border="0" bordercolor="#000000" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<td>
								<table style="font-size:12px;color:#000;" class="ke-zeroborder" border="0" cellpadding="0" cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E6%B0%B4%E7%B2%89&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E6%B0%B4%E7%B2%89&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />水粉</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E6%A9%99%E5%AD%90&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E6%A9%99%E5%AD%90&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />橙子</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%AE%9D%E8%93%9D&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%AE%9D%E8%93%9D&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />宝蓝</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E6%A1%83%E7%BA%A2&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E6%A1%83%E7%BA%A2&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />小桃红</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E7%99%BD&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E7%99%BD&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />小白</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E8%97%8F%E9%9D%92&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E8%97%8F%E9%9D%92&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />藏青</a> 
											</td>
										</tr>
										<tr>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E8%A4%90&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E8%A4%90&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />小褐</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E6%B5%B7%E8%93%9D&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E6%B5%B7%E8%93%9D&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />海蓝</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E7%8F%8A%E7%91%9A&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E7%8F%8A%E7%91%9A&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />珊瑚</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E9%93%B6%E5%AD%90&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E9%93%B6%E5%AD%90&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />银子</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E7%BA%A2&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E7%BA%A2&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />小红</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E7%8E%9B%E7%91%99&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E7%8E%9B%E7%91%99&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />玛瑙</a> 
											</td>
										</tr>
										<tr>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E9%BB%84&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E9%BB%84&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />小黄</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E7%BF%A0&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E7%BF%A0&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />小翠</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle" width="16%">
												<a href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E9%BB%91&amp;siteid=cntaobao&amp;status=2&amp;acharset=utf-8" target="_blank"><img alt="点击" src="http://amos.alicdn.com/online.aw?v=2&amp;uid=%E4%BC%98%E8%A1%A3%E5%BA%93%E5%AE%98%E6%96%B9%E6%97%97%E8%88%B0%E5%BA%97%3A%E5%B0%8F%E9%BB%91&amp;site=cntaobao&amp;s=2&amp;charset=utf-8" border="0" />小黑</a> 
											</td>
											<td style="padding-left:5px;" align="left" valign="middle">
												<br />
											</td>
											<td style="padding-left:5px;" align="left" valign="middle">
												<br />
											</td>
											<td style="padding-left:5px;" align="left" valign="middle">
												<br />
											</td>
										</tr>
									</tbody>
								</table>
							</td>
							<td style="border-right:1px solid #DCDCDC;" width="195">
								<img src="templates/{$tpl_name}/store/style/style8/images/01.gif" border="0" /> 
							</td>
							<td style="border-right:1px solid #DCDCDC;" width="316">
								<a href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/02.gif" border="0" /> </a> 
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<table class="ke-zeroborder" border="0" bordercolor="#000000" cellpadding="2" cellspacing="0" width="1000">
	<tbody>
		<tr>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/11.jpg" border="0" width="250" /> </a> 
			</td>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/12.jpg" border="0" width="250" /> </a> 
			</td>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/13.jpg" border="0" width="250" /> </a> 
			</td>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/14.jpg" border="0" width="250" /> </a> 
			</td>
		</tr>
		<tr>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/21.jpg" border="0" width="250" /> </a> 
			</td>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/22.jpg" border="0" width="250" /> </a> 
			</td>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/23.jpg" border="0" width="250" /> </a> 
			</td>
			<td>
				<a target="_blank" href="$site_url"><img src="templates/{$tpl_name}/store/style/style8/images/24.jpg" border="0" width="250" /> </a> 
			</td>
		</tr>
	</tbody>
</table>

EOT;


$style_info = <<<EOT
	<img alt="" style="width:300px;float:left;margin:0px;" src="templates/{$tpl_name}/store/style/style8/images/style.jpg" border="0" />
  <div style=" float: right;margin: 0 auto;width:300px;  line-height:24px;">
    <p> 可编辑区域的宽度为1000px </p>
    <p> <strong>1</strong>号为文字区域，可以填写客服、商品公告等内容。  </p>
    <p> <strong>2</strong>号为图片区域，由八张构成，可以分别单独修改。 </p>
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
		$("#style8_nav").remove();
';
?>