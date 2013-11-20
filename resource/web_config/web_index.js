
	DialogManager.close = function(id){
		__DIALOG_WRAPPER__[id].hide();
		ScreenLocker.unlock();
  }
	DialogManager.show = function(id){
		if (__DIALOG_WRAPPER__[id]) {
			__DIALOG_WRAPPER__[id].show();
			ScreenLocker.lock();
			return true;
		}
		return false;
  }
  var recommend_max = 3;//推荐数
  var goods_max = 6;//商品数
  var goods_list_max = 7;//商品排行数
  var brand_max = 8;//品牌限制
  var recommend_show = 1;//当前选择的商品推荐
	var titles = new Array();
	titles["category_list"] = '推荐分类';
	titles["brand_list"] = '品牌推荐';
	titles["recommend_list"] = '商品推荐';
	titles["goods_list"] = '商品排行';
	titles["upload_tit"] = '标题图片(210px × 72px)';
	titles["upload_act"] = '活动图片(208px × 128px)';
	titles["upload_adv"] = '广告图片(220px × 100px)';
	
$(function(){
	var obj = $("#picture_act");
	if(obj.find("script").size()>0) obj.html('<img src="'+obj.find("img").attr("src")+'" />');
	obj = $("#picture_adv");
	if(obj.find("script").size()>0) obj.html('<img src="'+obj.find("img").attr("src")+'" />');
});
function show_dialog(id){//弹出框
	if(DialogManager.show(id)) return;
	var d = DialogManager.create(id);//不存在时初始化(执行一次)
	var dialog_html = $("#"+id+"_dialog").html();
	$("#"+id+"_dialog").remove();
	d.setTitle(titles[id]);
	d.setContents('<div id="'+id+'_dialog" class="'+id+'_dialog">'+dialog_html+'</div>');
	d.setWidth(640);
	d.show('center',1);
	update_dialog(id);
}
function replace_url(url){//去当前网址
	return url.replace(SITE_URL+"/", '');
}
function get_input(n,id,k,v){//生成隐藏域代码
	return '<input type="hidden" name="'+n+'['+id+']['+k+']" value="'+v+'">';
}
function update_data(id){//更新
	var get_text = $.ajax({
		type: "POST",
		url: 'index.php?act=web_api&op=code_update',
		data: $("#"+id+"_form").serialize(),
		async: false
		}).responseText;
	return get_text;
}
function update_dialog(id){//初始化数据
	switch (id){
		case "category_list":
			$("#category_list_form").sortable({ items: 'dl' });
			$("#category_list_form dl").sortable({ items: 'dd' });
			break;
		case "recommend_list":
			gcategoryInit("recommend_gcategory");
			$("#recommend_list_form dl dd ul").sortable({ items: 'li' });
			break;
		case "goods_list":
			gcategoryInit("gcategory");
			$("#goods_list_form dl dd ul").sortable({ items: 'li' });
			break;
		case "brand_list":
			$("#show_brand_list").load('index.php?act=web_api&op='+id);//查询数据
			$("#brand_list_form dd ul").sortable();
			break;
		default:
			$("#"+id+"_dialog tr.odd").click(function(){
				$(this).next("tr").toggle();
				$(this).find(".title").toggleClass("ac");
				$(this).find(".arrow").toggleClass("up");
			});
			$("#"+id+"_dialog .type-file-file").change(function(){//初始化图片上传控件
				$("#"+id+"_dialog .type-file-text").val($(this).val());
			});
			break;
	}
}
//分类相关
function get_goods_class(){//查询子分类
	var gc_id = $("#gc_parent_id").val();
	if (gc_id>0) {
		if($("dt[select_class_id='"+gc_id+"']").size()>0) return;//避免重复
		$.get('index.php?act=web_api&op=category_list&id='+gc_id, function(data){
		  $("#category_list_form .category-list").append(data);
		  $("#category_list_form").sortable({ items: 'dl' });
		  $("#category_list_form dl").sortable({ items: 'dd' });
		});
	}
}
function del_gc_parent(gc_id){//删除已选分类
	var obj = $("dt[select_class_id='"+gc_id+"']");
	obj.parent().remove();
}
function del_goods_class(gc_id){//删除已选分类
	var obj = $("dd[gc_id='"+gc_id+"']");
	obj.remove();
}
function update_category(){//更新分类
	var get_text = update_data("category_list");
	if (get_text=='1') {
		$(".home-templates-board-layout .category-list").html('');
		$("#category_list_form .category-list dl").each(function(){
			var obj = $(this);
			var text_append = '';
			var gc_name = obj.find("dt").attr("title");
			text_append = '<dt title="'+gc_name+'">'+gc_name+'</dt>';
			obj.find("dd").each(function(){
				var dd = $(this);
				gc_name = dd.attr("title");
				text_append += '<dd title="'+gc_name+'">'+gc_name+'</dd>';
			});
		  $(".home-templates-board-layout .category-list").append('<dl>'+text_append+'</dl>');
		});
		DialogManager.close("category_list");
	}
}
//商品推荐相关
function show_recommend_dialog(id){//弹出框
	recommend_show = id;
	$("dl[select_recommend_id]").hide();
	$("dl[select_recommend_id='"+id+"']").show();
	show_dialog('recommend_list');
}
function get_recommend_goods(){//查询商品
	var gc_id = 0;
	$('#recommend_gcategory > select').each(function(){
		if ($(this).val()>0) gc_id = $(this).val();
	});
	var goods_name = $.trim($('#recommend_goods_name').val());
	if (gc_id>0 || goods_name!='') {
		$("#show_recommend_goods_list").load('index.php?act=web_api&op=recommend_list&'+$.param({'id':gc_id,'goods_name':goods_name }));
	}
}
function del_recommend(id){//删除商品推荐
	if(confirm('您确定要删除吗?')){
		$(".middle dl[recommend_id='"+id+"']").remove();
		$("dl[select_recommend_id='"+id+"']").remove();
		update_data("recommend_list");//更新数据
	}
}
function add_recommend(){//增加商品推荐
	for (var i = 1; i <= recommend_max; i++){//防止数组下标重复
		if ($(".middle dl[recommend_id='"+i+"']").size()==0) {//编号不存在时添加
			var add_html = '';
			var del_append = '';
			if (i>1) del_append = '<a href="JavaScript:del_recommend('+i+');">删除</a>';//第一个不能删除
			add_html = '<dl recommend_id="'+i+'"><dt><h4>商品推荐</h4>'+del_append+'<a href="JavaScript:show_recommend_dialog('+i+
			');">编辑</a></dt><dd><ul class="goods-list"><li><div class="goods-pic"></div></li><li><div class="goods-pic"></div></li><li><div class="goods-pic"></div></li><li><div class="goods-pic"></div></li><li><div class="goods-pic"></div></li><li><div class="goods-pic"></div></li></ul></dd></dl>';
			$("#btn_add_list").before(add_html);
			$("#add_recommend_list").before('<dl select_recommend_id="'+i+'"><dt><h4 class="dialog-handle-title">商品推荐模块标题名称</h4><div class="dialog-handle-box"><span class="left"><input name="recommend_list['+i+'][recommend][name]" value="商品推荐'+
			'" type="text" class="w200"></span><span class="right">修改该区域中部推荐商品模块选项卡名称，控制名称字符在4-8字左右，超出范围自动隐藏</span><div class="clear"></div></div></dt><dd><h4 class="dialog-handle-title">推荐商品</h4><ul class="dialog-goodslist-s1 goods-list"><div class="s-tips"><i></i>小提示：单击查询出的商品选中，双击已选择的可以删除，最多6个，保存后生效。</div></ul></dd></dl>');
			$("#recommend_list_form dl dd ul").sortable({ items: 'li' });
			break;
		}
	}
}
function select_recommend_goods(goods_id){//商品选择
	var id = recommend_show;
	var obj = $("dl[select_recommend_id='"+id+"']");
	if(obj.find("img[select_goods_id='"+goods_id+"']").size()>0) return;//避免重复
	if(obj.find("img[select_goods_id]").size()>=goods_max) return;
	var goods = $("#show_recommend_goods_list img[goods_id='"+goods_id+"']");
	var text_append = '';
	var goods_pic = goods.attr("src");
	var goods_name = goods.attr("title");
	var goods_price = goods.attr("goods_price");
	var store_id = goods.attr("store_id");	
	text_append += '<div ondblclick="del_recommend_goods('+goods_id+');" class="goods-pic">';
	text_append += '<span class="ac-ico" onclick="del_recommend_goods('+goods_id+');"></span>';
	text_append += '<span class="thumb size-72x72">';
	text_append += '<i></i>';
  	text_append += '<img select_goods_id="'+goods_id+'" title="'+goods_name+'" src="'+goods_pic+'" onload="javascript:DrawImage(this,72,72);" />';
	text_append += '</span></div>';
	text_append += '<div class="goods-name">';
	text_append += '<a href="'+SITE_URL+'/index.php?act=goods&goods_id='+goods_id+'&id='+store_id+'" target="_blank">';
  	text_append += goods_name+'</a>';
	text_append += '</div>';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_id]" value="'+goods_id+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][store_id]" value="'+store_id+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_name]" value="'+goods_name+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_price]" value="'+goods_price+'" type="hidden">';
	text_append += '<input name="recommend_list['+id+'][goods_list]['+goods_id+'][goods_pic]" value="'+replace_url(goods_pic)+'" type="hidden">';
	obj.find("ul").append('<li>'+text_append+'</li>');
}
function del_recommend_goods(goods_id){//删除已选商品
	var id = recommend_show;
	var obj = $("dl[select_recommend_id='"+id+"']");
	obj.find("img[select_goods_id='"+goods_id+"']").parent().parent().parent().remove();
}
function update_recommend(){//更新
	var get_text = update_data("recommend_list");
	if (get_text=='1') {
		var id = recommend_show;
		var obj = $("dl[select_recommend_id='"+id+"']");
		var text_append = '';
		var recommend_name = obj.find("dt input").val();
		$(".middle dl[recommend_id='"+id+"'] dt h4").html(recommend_name);
		obj.find("img").each(function(){
			var goods = $(this);
			var goods_pic = goods.attr("src");
			var goods_name = goods.attr("title");
			text_append += '<li><div class="goods-pic"><img title="'+goods_name+'" src="'+goods_pic
									+'" onload="javascript:DrawImage(this,106,106);" /></div></li>';
		});
	  $("dl[recommend_id='"+id+"'] dd ul").html('');
	  $(".middle dl[recommend_id='"+id+"'] dd ul").append(text_append);
		DialogManager.close("recommend_list");
	}
}
//商品排行
function get_goods_list(){//查询商品
	var gc_id = 0;
	$('#gcategory > select').each(function(){
		if ($(this).val()>0) gc_id = $(this).val();
	});
	var goods_name = $.trim($('#order_goods_name').val());
	var goods_order = $('#goods_order').val();
	if (gc_id>0 || goods_name!='') {
		$("#show_goods_order_list").load('index.php?act=web_api&op=goods_list&'+$.param({'id':gc_id,'goods_order':goods_order,'goods_name':goods_name }));
	}
}
function select_goods_order(goods_id){//商品选择
	var obj = $("#goods_list_form");
	if(obj.find("img[select_goods_id='"+goods_id+"']").size()>0) return;//避免重复
	if(obj.find("img[select_goods_id]").size()>=goods_list_max) return;
	var goods = $("#show_goods_order_list img[goods_id='"+goods_id+"']");
	var text_append = '';
	var goods_pic = goods.attr("src");
	var goods_name = goods.attr("title");
	var goods_price = goods.attr("goods_price");
	var store_id = goods.attr("store_id");
	
	text_append += '<div ondblclick="del_goods_order('+goods_id+');" class="goods-pic">';
	text_append += '<span class="ac-ico" onclick="del_goods_order('+goods_id+');"></span>';
	text_append += '<span class="thumb size-64x64">';
	text_append += '<i></i>';
	text_append += '<img select_goods_id="'+goods_id+'" goods_price="'+goods_price+'" title="'+goods_name+'" src="'+goods_pic+'" onload="javascript:DrawImage(this,64,64);" />';
	text_append += '</span></div>';
	text_append += '<div class="goods-name">';
	text_append += '<a href="'+SITE_URL+'/index.php?act=goods&goods_id='+goods_id+'&id='+store_id+'" target="_blank">';
	text_append += goods_name+'</a>';
	text_append += '</div>';
	text_append += '<input name="goods_list[goods]['+goods_id+'][goods_id]" value="'+goods_id+'" type="hidden">';
	text_append += '<input name="goods_list[goods]['+goods_id+'][store_id]" value="'+store_id+'" type="hidden">';
	text_append += '<input name="goods_list[goods]['+goods_id+'][goods_name]" value="'+goods_name+'" type="hidden">';
	text_append += '<input name="goods_list[goods]['+goods_id+'][goods_price]" value="'+goods_price+'" type="hidden">';
	text_append += '<input name="goods_list[goods]['+goods_id+'][goods_pic]" value="'+replace_url(goods_pic)+'" type="hidden">';
	obj.find("dd ul").append('<li>'+text_append+'</li>');
}
function del_goods_order(goods_id){//删除已选商品
	var obj = $("#goods_list_form");
	obj.find("img[select_goods_id='"+goods_id+"']").parent().parent().parent().remove();
}
function update_goods_order(){//更新
	var get_text = update_data("goods_list");
	if (get_text=='1') {
		var obj = $("#goods_list_form");
		var text_append = '';
		var recommend_name = obj.find("dt input").val();
		$("#goods_order_list dt h4").html(recommend_name);
		obj.find("dd ul img").each(function(i){
			var goods = $(this);
			var goods_pic = goods.attr("src");
			var goods_name = goods.attr("title");
			var goods_price = goods.attr("goods_price");
			if (i<3) {
				text_append += '<li class="goods-list"><div class="goods-pic"><img title="'+goods_name+'" src="'+goods_pic
									+'" onload="javascript:DrawImage(this,60,60);" /></div><div class="goods-name">'+goods_name+
									'</div><div class="goods-price"><em>'+goods_price+'</em></div></li>';
			}else{
				text_append += '<li>'+goods_name+'</li>';
			}
		});
	  $("#goods_order_list dd ol").html('');
	  $("#goods_order_list dd ol").append(text_append);
		DialogManager.close("goods_list");
	}
}
//品牌相关
function select_brand(brand_id){//品牌选择
	if($("img[select_brand_id='"+brand_id+"']").size()>0) return;//避免重复
	if($("img[select_brand_id]").size()>=brand_max) return;
	var obj = $("img[brand_id='"+brand_id+"']");
	var text_append = '';
	var brand_pic = obj.attr("src");
	var brand_id = obj.attr("brand_id");
	var brand_name = obj.attr("title");
	text_append += '<div class="brands-pic"><span class="ac-ico" onclick="del_brand('+brand_id+');"></span>';
	text_append += '<span class="thumb size-68x34">';
	text_append += '<i></i>';
	text_append += '<img ondblclick="del_brand('+brand_id+');" select_brand_id="'+brand_id+'" src="'+brand_pic+'" onload="javascript:DrawImage(this,68,34);" />';
	text_append += '</span></div>';
	text_append += '<div class="brands-name">';
	text_append += brand_name+'</div>';
	text_append += get_input('brand_list',brand_id,'brand_id',brand_id);
	text_append += get_input('brand_list',brand_id,'brand_name',brand_name);
	text_append += get_input('brand_list',brand_id,'brand_pic',replace_url(brand_pic));
	
	$("#brand_list_form dd ul").append('<li>'+text_append+'</li>');
}
function del_brand(brand_id){//删除已选品牌
	var obj = $("img[select_brand_id='"+brand_id+"']");
	obj.parent().parent().parent().remove();
}
function update_brand(){//更新品牌
	var get_text = update_data("brand_list");
	if (get_text=='1') {
		$(".bottom ul").html('');
		$("img[select_brand_id]").each(function(){
			var obj = $(this);
			var text_append = '';
			var brand_pic = obj.attr("src");
			var brand_name = obj.attr("title");
			text_append = '<img title="'+brand_name+'" src="'+brand_pic
										+'" onload="javascript:DrawImage(this,88,44);" />';
		  $(".bottom ul").append('<li><div class="picture">'+text_append+'</div></li>');
		});
		DialogManager.close("brand_list");
	}
}
//图片上传
function update_pic(id,pic){//更新图片
	var obj = $("#picture_"+id);
	obj.html('<img src="'+SITE_URL+'/'+pic+'" />');
	DialogManager.close("upload_"+id);
}
//广告上传
function update_adv_pic(id,ap_id){//更新图片
	var obj = $("#picture_"+id);
	$.get(SITE_URL+'/api.php?act=adv&op=advshow&ap_id='+ap_id, function(data){
		var re = /^document\.write\("(.*)"\);$/g;
		re.exec(data);
		var get_src = $(RegExp.$1).find("img").attr("src");
		obj.html('<img src="'+get_src+'" />');
		DialogManager.close("upload_"+id);
	});
}
function adv_type(id){//广告选择类型
	var obj = $("#upload_"+id+"_form");
	var get_type = obj.find("input:checked").val();
	obj.find("table[id^='upload_"+id+"_type_']").hide();
	$("#upload_"+id+"_type_"+get_type).show();
}