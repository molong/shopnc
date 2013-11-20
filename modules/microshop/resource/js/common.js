var SITE_URL = window.location.toString().split('/index.php')[0];
SITE_URL = SITE_URL.replace(/(\/+)$/g, '');
jQuery.extend({
  getCookie : function(sName) {
  	sName = COOKIE_PRE + sName;
    var aCookie = document.cookie.split("; ");
    for (var i=0; i < aCookie.length; i++){
      var aCrumb = aCookie[i].split("=");
      if (sName == aCrumb[0]) return decodeURIComponent(aCrumb[1]);
    }
    return '';
  },
  setCookie : function(sName, sValue, sExpires) {
  	sName = COOKIE_PRE + sName;
    var sCookie = sName + "=" + encodeURIComponent(sValue);
    if (sExpires != null) sCookie += "; expires=" + sExpires;
    document.cookie = sCookie;
  },
  removeCookie : function(sName) {
  	sName = COOKIE_PRE + sName;
    document.cookie = sName + "=; expires=Fri, 31 Dec 1999 23:59:59 GMT;";
  }
});
function drop_confirm(msg, url){
    if(confirm(msg)){
        window.location = url;
    }
}


function go(url){
    window.location = url;
}
/* 格式化金额 */
function price_format(price){
    if(typeof(PRICE_FORMAT) == 'undefined'){
        PRICE_FORMAT = '&yen;%s';
    }
    price = number_format(price, 2);

    return PRICE_FORMAT.replace('%s', price);
}

function number_format(num, ext){
    if(ext < 0){
        return num;
    }
    num = Number(num);
    if(isNaN(num)){
        num = 0;
    }
    var _str = num.toString();
    var _arr = _str.split('.');
    var _int = _arr[0];
    var _flt = _arr[1];
    if(_str.indexOf('.') == -1){
        /* 找不到小数点，则添加 */
        if(ext == 0){
            return _str;
        }
        var _tmp = '';
        for(var i = 0; i < ext; i++){
            _tmp += '0';
        }
        _str = _str + '.' + _tmp;
    }else{
        if(_flt.length == ext){
            return _str;
        }
        /* 找得到小数点，则截取 */
        if(_flt.length > ext){
            _str = _str.substr(0, _str.length - (_flt.length - ext));
            if(ext == 0){
                _str = _int;
            }
        }else{
            for(var i = 0; i < ext - _flt.length; i++){
                _str += '0';
            }
        }
    }

    return _str;
}
/* 火狐下取本地全路径 */
function getFullPath(obj)
{
    if(obj)
    {
        //ie
        if (window.navigator.userAgent.indexOf("MSIE")>=1)
        {
            obj.select();
            if(window.navigator.userAgent.indexOf("MSIE") == 25){
            	obj.blur();
            }
            return document.selection.createRange().text;
        }
        //firefox
        else if(window.navigator.userAgent.indexOf("Firefox")>=1)
        {
            if(obj.files)
            {
                //return obj.files.item(0).getAsDataURL();
            	return window.URL.createObjectURL(obj.files.item(0)); 
            }
            return obj.value;
        }
        return obj.value;
    }
}

/* 转化JS跳转中的 ＆ */
function transform_char(str)
{
    if(str.indexOf('&'))
    {
        str = str.replace(/&/g, "%26");
    }
    return str;
}

//导航条用户下拉菜单
$(document).ready(function(){
	$(".sub-menu li").hover(function(){
			$(this).addClass("hover");
			$(this).children("ul li").attr('class','');
		},function(){
			$(this).removeClass("hover");  
			$(this).children("ul li").attr('class','');
		}
	); 
	$(".sub-menu li.no_sub").hover(function(){
			$(this).addClass("hover1");
		},function(){
			$(this).removeClass("hover1");  
		}
	); 
})


//图片比例缩放控制
function DrawImage(ImgD,FitWidth,FitHeight){
	var image=new Image();
	image.src=ImgD.src;
	if(image.width>0 && image.height>0)
    {
		if(image.width/image.height>= FitWidth/FitHeight)
        {
            if(image.width>FitWidth)
            {
                ImgD.width=FitWidth;
                ImgD.height=(image.height*FitWidth)/image.width;
            }
            else
            {
                ImgD.width=image.width;  
                ImgD.height=image.height;  
            }
		}
        else
        {
	       if(image.height>FitHeight)
           {
                ImgD.height=FitHeight;
                ImgD.width=(image.width*FitHeight)/image.height;
	       }
           else
           {
                ImgD.width=image.width;
                ImgD.height=image.height;
            }
		}  
	}
}

/**
* 浮动DIV定时显示提示信息,如操作成功, 失败等
* @param string tips (提示的内容)
* @param int height 显示的信息距离浏览器顶部的高度
* @param int time 显示的时间(按秒算), time > 0
* @sample <a href="javascript:void(0);" onclick="showTips( '操作成功', 100, 3 );">点击</a>
* @sample 上面代码表示点击后显示操作成功3秒钟, 距离顶部100px
* @copyright ZhouHr 2010-08-27
*/
function showTips( tips, height, time ){
var windowWidth = document.documentElement.clientWidth;
var tipsDiv = '<div class="tipsClass">' + tips + '</div>';

$( 'body' ).append( tipsDiv );
$( 'div.tipsClass' ).css({
'top' : 200 + 'px',
'left' : ( windowWidth / 2 ) - ( tips.length * 13 / 2 ) + 'px',
'position' : 'fixed',
'padding' : '20px 50px',
'background': '#EAF2FB',
'font-size' : 14 + 'px',
'margin' : '0 auto',
'text-align': 'center',
'width' : 'auto',
'color' : '#333',
'border' : 'solid 1px #A8CAED',
'opacity' : '0.90',
'z-index' : '9999'
}).show();
setTimeout( function(){$( 'div.tipsClass' ).fadeOut().remove();}, ( time * 1000 ) );
}

function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}
//弹出框登录
function login_dialog(){
	CUR_DIALOG = ajax_form('login','登录','index.php?act=login&inajax=1',360,1)
}

/* 显示Ajax表单 */
function ajax_form(id, title, url, width, model)
{
    if (!width)	width = 480;
    if (!model) model = 1;
    var d = DialogManager.create(id);
    d.setTitle(title);
    d.setContents('ajax', url);
    d.setWidth(width);
    d.show('center',model);
    return d;
}
function ajax_notice(id, title, url, width, model) {
    if (!width)	width = 480;
    if (!model) model = 0;
    var d = DialogManager.create(id);
    d.setTitle(title);
    d.setContents('ajax_notice', url);
    d.setWidth(width);
    d.show('center',model);
    return d;
}
//显示一个正在等待的消息
function loading_form(id, title, _text, width, model) {
    if (!width)	width = 480;
    if (!model) model = 0;
    var d = DialogManager.create(id);
    d.setTitle(title);
    d.setContents('loading', { text: _text });
    d.setWidth(width);
    d.show('center',model);
    return d;
}
//显示一个提示消息
function message_notice(id, title, _text, width, model) {
    if (!width)	width = 480;
    if (!model) model = 0;
    var d = DialogManager.create(id);
    d.setTitle(title);
    d.setContents('message', { type: 'notice', text: _text });
    d.setWidth(width);
    d.show('center',model);
    return d;
}
//显示一个带确定、取消按钮的消息
function message_confirm(id, title, _text, width, model) {
    if (!width)	width = 480;
    if (!model) model = 0;
    var d = DialogManager.create(id);
    d.setTitle(title);
    d.setContents('message', { type: 'confirm', text: _text });
    d.setWidth(width);
    d.show('center',model);
    return d;
}
//显示一个内容为自定义HTML内容的消息
function html_form(id, title, _html, width, model) {
    if (!width)	width = 480;
    if (!model) model = 0;
    var d = DialogManager.create(id);
    d.setTitle(title);
    d.setContents(_html);
    d.setWidth(width);
    d.show('center',0);
    return d;
}
//显示一个消息 消息的内容为IFRAME方式
function iframe_form(id, title, _url, width, height,fresh) {
    if (!width)	width = 480;
    var rnd=Math.random();
    rnd=Math.floor(rnd*10000);

    var d = DialogManager.create(id);
    d.setTitle(title);
    var _html = "<iframe id='iframe_"+rnd+"' src='" + _url + "' width='" + width + "' height='" + height + "' frameborder='0'></iframe>";
    d.setContents(_html);
    d.setWidth(width + 20);
    d.setHeight(height + 60);
    d.show('center');

    $("#iframe_"+rnd).attr("src",_url);
    return d;
}

//动态加载js，css
//$.include(['http://www.shopnc.net/script/a.js','/css/css.css']);
$.extend({
    include: function(file)
    {
        var files = typeof file == "string" ? [file] : file;
        
        for (var i = 0; i < files.length; i++)
        {
            var name = files[i].replace(/^\s|\s$/g, "");
            var att = name.split('.');
            var ext = att[att.length - 1].toLowerCase();
            var isCSS = ext == "css";
            var tag = isCSS ? "link" : "script";
            var attr = isCSS ? " type='text/css' rel='stylesheet' " : " language='javascript' type='text/javascript' ";
            var link = (isCSS ? "href" : "src") + "='" + SITE_URL+'/' + name + "'";
            if ($(tag + "[" + link + "]").length == 0) $('body').append("<" + tag + attr + link + "></" + tag + ">");
        }
    }
});

//common2.2.js
DIALOGIMGDIR  = SITEURL+"/"+'templates/default/images/dialog';

var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
browserVersion({'ie':'msie','firefox':'','chrome':'','opera':'','safari':'','mozilla':'','webkit':'','maxthon':'','qq':'qqbrowser'});
if(BROWSER.safari) {
	BROWSER.firefox = true;
}
BROWSER.opera = BROWSER.opera ? opera.version() : 0;

HTMLNODE = document.getElementsByTagName('head')[0].parentNode;
if(BROWSER.ie) {
	BROWSER.iemode = parseInt(typeof document.documentMode != 'undefined' ? document.documentMode : BROWSER.ie);
	HTMLNODE.className = 'ie_all ie' + BROWSER.iemode;
}

var JSLOADED = [];
var JSMENU = [];
JSMENU['active'] = [];
JSMENU['timer'] = [];
JSMENU['drag'] = [];
JSMENU['layer'] = 0;
JSMENU['zIndex'] = {'win':1000,'menu':1100,'dialog':1200,'prompt':1300};
JSMENU['float'] = '';
var CURRENTSTYPE = null;
var EXTRAFUNC = [], EXTRASTR = '';

if(BROWSER.firefox && window.HTMLElement) {
	HTMLElement.prototype.__defineGetter__( "innerText", function(){
		var anyString = "";
		var childS = this.childNodes;
		for(var i=0; i <childS.length; i++) {
			if(childS[i].nodeType==1) {
				anyString += childS[i].tagName=="BR" ? '\n' : childS[i].innerText;
			} else if(childS[i].nodeType==3) {
				anyString += childS[i].nodeValue;
			}
		}
		return anyString;
	});
	HTMLElement.prototype.__defineSetter__( "innerText", function(sText){
		this.textContent=sText;
	});
	HTMLElement.prototype.__defineSetter__('outerHTML', function(sHTML) {
			var r = this.ownerDocument.createRange();
		r.setStartBefore(this);
		var df = r.createContextualFragment(sHTML);
		this.parentNode.replaceChild(df,this);
		return sHTML;
	});

	HTMLElement.prototype.__defineGetter__('outerHTML', function() {
		var attr;
		var attrs = this.attributes;
		var str = '<' + this.tagName.toLowerCase();
		for(var i = 0;i < attrs.length;i++){
			attr = attrs[i];
			if(attr.specified)
			str += ' ' + attr.name + '="' + attr.value + '"';
		}
		if(!this.canHaveChildren) {
			return str + '>';
		}
		return str + '>' + this.innerHTML + '</' + this.tagName.toLowerCase() + '>';
		});

	HTMLElement.prototype.__defineGetter__('canHaveChildren', function() {
		switch(this.tagName.toLowerCase()) {
			case 'area':case 'base':case 'basefont':case 'col':case 'frame':case 'hr':case 'img':case 'br':case 'input':case 'isindex':case 'link':case 'meta':case 'param':
			return false;
			}
		return true;
	});
}

function $$(id) {
	return !id ? null : document.getElementById(id);
}

function _attachEvent(obj, evt, func, eventobj) {
	eventobj = !eventobj ? obj : eventobj;
	if(obj.addEventListener) {
		obj.addEventListener(evt, func, false);
	} else if(eventobj.attachEvent) {
		obj.attachEvent('on' + evt, func);
	}
}

function browserVersion(types) {
	var other = 1;
	for(i in types) {
		var v = types[i] ? types[i] : i;
		if(USERAGENT.indexOf(v) != -1) {
			var re = new RegExp(v + '(\\/|\\s)([\\d\\.]+)', 'ig');
			var matches = re.exec(USERAGENT);
			var ver = matches != null ? matches[2] : 0;
			other = ver !== 0 && v != 'mozilla' ? 0 : other;
		}else {
			var ver = 0;
		}
		eval('BROWSER.' + i + '= ver');
	}
	BROWSER.other = other;
}

function getEvent() {
	if(document.all) return window.event;
	func = getEvent.caller;
	while(func != null) {
		var arg0 = func.arguments[0];
		if (arg0) {
			if((arg0.constructor  == Event || arg0.constructor == MouseEvent) || (typeof(arg0) == "object" && arg0.preventDefault && arg0.stopPropagation)) {
				return arg0;
			}
		}
		func=func.caller;
	}
	return null;
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function strlen(str) {
	return (BROWSER.ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}

function Ajax(recvType, waitId) {

	var aj = new Object();

	aj.loading = '请稍候...';
	aj.recvType = recvType ? recvType : 'XML';
	aj.waitId = waitId ? $$(waitId) : null;

	aj.resultHandle = null;
	aj.sendString = '';
	aj.targetUrl = '';

	aj.setLoading = function(loading) {
		if(typeof loading !== 'undefined' && loading !== null) aj.loading = loading;
	};

	aj.setRecvType = function(recvtype) {
		aj.recvType = recvtype;
	};

	aj.setWaitId = function(waitid) {
		aj.waitId = typeof waitid == 'object' ? waitid : $$(waitid);
	};

	aj.createXMLHttpRequest = function() {
		var request = false;
		if(window.XMLHttpRequest) {
			request = new XMLHttpRequest();
			if(request.overrideMimeType) {
				request.overrideMimeType('text/xml');
			}
		} else if(window.ActiveXObject) {
			var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
			for(var i=0; i<versions.length; i++) {
				try {
					request = new ActiveXObject(versions[i]);
					if(request) {
						return request;
					}
				} catch(e) {}
			}
		}
		return request;
	};

	aj.XMLHttpRequest = aj.createXMLHttpRequest();
	aj.showLoading = function() {
		if(aj.waitId && (aj.XMLHttpRequest.readyState != 4 || aj.XMLHttpRequest.status != 200)) {
			aj.waitId.style.display = '';
			aj.waitId.innerHTML = '<span><img src="' + DIALOGIMGDIR + '/loading.gif" class="vm"> ' + aj.loading + '</span>';
		}
	};

	aj.processHandle = function() {
		if(aj.XMLHttpRequest.readyState == 4 && aj.XMLHttpRequest.status == 200) {
			if(aj.waitId) {
				aj.waitId.style.display = 'none';
			}
			if(aj.recvType == 'HTML') {
				aj.resultHandle(aj.XMLHttpRequest.responseText, aj);
			} else if(aj.recvType == 'XML') {
				if(!aj.XMLHttpRequest.responseXML || !aj.XMLHttpRequest.responseXML.lastChild || aj.XMLHttpRequest.responseXML.lastChild.localName == 'parsererror') {
					aj.resultHandle('<a href="' + aj.targetUrl + '" target="_blank" style="color:red">内部错误，无法显示此内容</a>' , aj);
				} else {
					aj.resultHandle(aj.XMLHttpRequest.responseXML.lastChild.firstChild.nodeValue, aj);
				}
			}
		}
	};

	aj.get = function(targetUrl, resultHandle) {
		targetUrl = hostconvert(targetUrl);
		setTimeout(function(){aj.showLoading()}, 250);
		aj.targetUrl = targetUrl;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		var attackevasive = isUndefined(attackevasive) ? 0 : attackevasive;
		if(window.XMLHttpRequest) {
			aj.XMLHttpRequest.open('GET', aj.targetUrl);
			aj.XMLHttpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			aj.XMLHttpRequest.send(null);
		} else {
			aj.XMLHttpRequest.open("GET", targetUrl, true);
			aj.XMLHttpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			aj.XMLHttpRequest.send();
		}
	};
	aj.post = function(targetUrl, sendString, resultHandle) {
		targetUrl = hostconvert(targetUrl);
		setTimeout(function(){aj.showLoading()}, 250);
		aj.targetUrl = targetUrl;
		aj.sendString = sendString;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		aj.XMLHttpRequest.open('POST', targetUrl);
		aj.XMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		aj.XMLHttpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		aj.XMLHttpRequest.send(aj.sendString);
	};
	return aj;
}

function getHost(url) {
	var host = "null";
	if(typeof url == "undefined"|| null == url) {
		url = window.location.href;
	}
	var regex = /^\w+\:\/\/([^\/]*).*/;
	var match = url.match(regex);
	if(typeof match != "undefined" && null != match) {
		host = match[1];
	}
	return host;
}

function hostconvert(url) {
	if(!url.match(/^http?:\/\//)) url = SITEURL.replace(/(\/+)$/g, '') + '/' + url;
	var url_host = getHost(url);
	var cur_host = getHost().toLowerCase();
	if(url_host && cur_host != url_host) {
		url = url.replace(url_host, cur_host);
	}
	return url;
}

function newfunction(func) {
	var args = [];
	for(var i=1; i<arguments.length; i++) args.push(arguments[i]);
	return function(event) {
		doane(event);
		window[func].apply(window, args);
		return false;
	}
}

function evalscript(s) {
	if(s.indexOf('<script') == -1) return s;
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	var arr = [];
	while(arr = p.exec(s)) {
		var p1 = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:charset=\"([\w\-]+?)\")?><\/script>/i;
		var arr1 = [];
		arr1 = p1.exec(arr[0]);
		if(arr1) {
			appendscript(arr1[1], '', arr1[2], arr1[3]);
		} else {
			p1 = /<script(.*?)>([^\x00]+?)<\/script>/i;
			arr1 = p1.exec(arr[0]);
			appendscript('', arr1[2], arr1[1].indexOf('reload=') != -1);
		}
	}
	return s;
}

var evalscripts = [];

function appendscript(src, text, reload, charset) {
	var id = hash(src + text);
	if(!reload && in_array(id, evalscripts)) return;
	if(reload && $$(id)) {
		$$(id).parentNode.removeChild($$(id));
	}

	evalscripts.push(id);
	var scriptNode = document.createElement("script");
	scriptNode.type = "text/javascript";
	scriptNode.id = id;
	scriptNode.charset = charset ? charset : (BROWSER.firefox ? document.characterSet : document.charset);
	try {
		if(src) {
			scriptNode.src = src;
			scriptNode.onloadDone = false;
			scriptNode.onload = function () {
				scriptNode.onloadDone = true;
				JSLOADED[src] = 1;
			};
			scriptNode.onreadystatechange = function () {
				if((scriptNode.readyState == 'loaded' || scriptNode.readyState == 'complete') && !scriptNode.onloadDone) {
					scriptNode.onloadDone = true;
					JSLOADED[src] = 1;
				}
			};
		} else if(text){
			scriptNode.text = text;
		}
		document.getElementsByTagName('head')[0].appendChild(scriptNode);
	} catch(e) {}
}

function ajaxupdateevents(obj, tagName) {
	tagName = tagName ? tagName : 'A';
	var objs = obj.getElementsByTagName(tagName);
	for(k in objs) {
		var o = objs[k];
		ajaxupdateevent(o);
	}
}

function ajaxupdateevent(o) {
	if(typeof o == 'object' && o.getAttribute) {
		if(o.getAttribute('ajaxtarget')) {
			if(!o.id) o.id = Math.random();
			var ajaxevent = o.getAttribute('ajaxevent') ? o.getAttribute('ajaxevent') : 'click';
			var ajaxurl = o.getAttribute('ajaxurl') ? o.getAttribute('ajaxurl') : o.href;
			_attachEvent(o, ajaxevent, newfunction('ajaxget', ajaxurl, o.getAttribute('ajaxtarget'), o.getAttribute('ajaxwaitid'), o.getAttribute('ajaxloading'), o.getAttribute('ajaxdisplay')));
			if(o.getAttribute('ajaxfunc')) {
				o.getAttribute('ajaxfunc').match(/(\w+)\((.+?)\)/);
				_attachEvent(o, ajaxevent, newfunction(RegExp.$1, RegExp.$2));
			}
		}
	}
}

function ajaxget(url, showid, waitid, loading, display, recall) {
	waitid = typeof waitid == 'undefined' || waitid === null ? showid : waitid;
	var x = new Ajax();
	x.setLoading(loading);
	x.setWaitId(waitid);
	x.display = typeof display == 'undefined' || display == null ? '' : display;
	x.showId = $$(showid);

	if(url.substr(strlen(url) - 1) == '#') {
		url = url.substr(0, strlen(url) - 1);
		x.autogoto = 1;
	}

	var url = url + '&inajax=1&ajaxtarget=' + showid;
	x.get(url, function(s, x) {
		var evaled = false;
		if(s.indexOf('ajaxerror') != -1) {
			evalscript(s);
			evaled = true;
		}
		if(!evaled && (typeof ajaxerror == 'undefined' || !ajaxerror)) {
			if(x.showId) {
				x.showId.style.display = x.display;
				ajaxinnerhtml(x.showId, s);
				ajaxupdateevents(x.showId);
				if(x.autogoto) scroll(0, x.showId.offsetTop);
			}
		}

		ajaxerror = null;
		if(recall && typeof recall == 'function') {
			recall();
		} else if(recall) {
			eval(recall);
		}
		if(!evaled) evalscript(s);
	});
}

function ajaxpost(formid, showid, waitid, showidclass, submitbtn, recall) {
	var waitid = typeof waitid == 'undefined' || waitid === null ? showid : (waitid !== '' ? waitid : '');
	var showidclass = !showidclass ? '' : showidclass;
	var ajaxframeid = 'ajaxframe';
	var ajaxframe = $$(ajaxframeid);
	var formtarget = $$(formid).target;

	var handleResult = function() {
		var s = '';
		var evaled = false;

		showloading('none');
		try {	
			s = $$(ajaxframeid).contentWindow.document.XMLDocument.text;
		} catch(e) {
			try {
				s = $$(ajaxframeid).contentWindow.document.documentElement.firstChild.wholeText;
			} catch(e) {
				try {
					s = $$(ajaxframeid).contentWindow.document.documentElement.firstChild.nodeValue;
				} catch(e) {
					s = '内部错误，无法显示此内容';
				}
			}
		}
		if( s != ''  && s.indexOf('ajaxerror') != -1) {
			evalscript(s);
			evaled = true;
		}
		if(showidclass) {
			if(showidclass != 'onerror') {
				$$(showid).className = showidclass;
			} else {
				showError(s);
				ajaxerror = true;
			}
		}
		if(submitbtn) {
			submitbtn.disabled = false;
		}
		if(!evaled && (typeof ajaxerror == 'undefined' || !ajaxerror)) {
			ajaxinnerhtml($$(showid), s);
		}
		ajaxerror = null;
		if($$(formid)) $$(formid).target = formtarget;
		if(typeof recall == 'function') {
			recall();
		} else {
			eval(recall);
		}
		if(!evaled) evalscript(s);
		ajaxframe.loading = 0;
		$$('append_parent').removeChild(ajaxframe.parentNode);
	};
	if(!ajaxframe) {
		var div = document.createElement('div');
		div.style.display = 'none';
		div.innerHTML = '<iframe name="' + ajaxframeid + '" id="' + ajaxframeid + '" loading="1"></iframe>';
		$$('append_parent').appendChild(div);
		ajaxframe = $$(ajaxframeid);
	} else if(ajaxframe.loading) {
		return false;
	}

	_attachEvent(ajaxframe, 'load', handleResult);

	showloading();
	$$(formid).target = ajaxframeid;
	var action = $$(formid).getAttribute('action');
	action = hostconvert(action);
	$$(formid).action = action.replace(/\&inajax\=1/g, '')+'&inajax=1';
	$$(formid).submit();
	if(submitbtn) {
		submitbtn.disabled = true;
	}
	doane();
	return false;
}

function hash(string, length) {
	var length = length ? length : 32;
	var start = 0;
	var i = 0;
	var result = '';
	filllen = length - string.length % length;
	for(i = 0; i < filllen; i++){
		string += "0";
	}
	while(start < string.length) {
		result = stringxor(result, string.substr(start, length));
		start += length;
	}
	return result;
}

function stringxor(s1, s2) {
	var s = '';
	var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var max = Math.max(s1.length, s2.length);
	for(var i=0; i<max; i++) {
		var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
		s += hash.charAt(k % 52);
	}
	return s;
}

function showloading(display, waiting) {
	var display = display ? display : 'block';
	var waiting = waiting ? waiting : '请稍候...';
	$$('ajaxwaitid').innerHTML = waiting;
	$$('ajaxwaitid').style.display = display;
}

function ajaxinnerhtml(showid, s) {
	if(showid.tagName != 'TBODY') {
		showid.innerHTML = s;
	} else {
		while(showid.firstChild) {
			showid.firstChild.parentNode.removeChild(showid.firstChild);
		}
		var div1 = document.createElement('DIV');
		div1.id = showid.id+'_div';
		div1.innerHTML = '<table><tbody id="'+showid.id+'_tbody">'+s+'</tbody></table>';
		$$('append_parent').appendChild(div1);
		var trs = div1.getElementsByTagName('TR');
		var l = trs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(trs[0]);
		}
		var inputs = div1.getElementsByTagName('INPUT');
		var l = inputs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(inputs[0]);
		}
		div1.parentNode.removeChild(div1);
	}
}

function doane(event, preventDefault, stopPropagation) {
	var preventDefault = isUndefined(preventDefault) ? 1 : preventDefault;
	var stopPropagation = isUndefined(stopPropagation) ? 1 : stopPropagation;
	e = event ? event : window.event;
	if(!e) {
		e = getEvent();
	}
	if(!e) {
		return null;
	}
	if(preventDefault) {
		if(e.preventDefault) {
			e.preventDefault();
		} else {
			e.returnValue = false;
		}
	}
	if(stopPropagation) {
		if(e.stopPropagation) {
			e.stopPropagation();
		} else {
			e.cancelBubble = true;
		}
	}
	return e;
}

function showMenu(v) {
	var ctrlid = isUndefined(v['ctrlid']) ? v : v['ctrlid'];
	var showid = isUndefined(v['showid']) ? ctrlid : v['showid'];
	var menuid = isUndefined(v['menuid']) ? showid + '_menu' : v['menuid'];
	var ctrlObj = $$(ctrlid);
	var menuObj = $$(menuid);
	if(!menuObj) return;
	var mtype = isUndefined(v['mtype']) ? 'menu' : v['mtype'];
	var evt = isUndefined(v['evt']) ? 'mouseover' : v['evt'];
	var pos = isUndefined(v['pos']) ? '43' : v['pos'];
	var layer = isUndefined(v['layer']) ? 1 : v['layer'];
	var duration = isUndefined(v['duration']) ? 2 : v['duration'];
	var timeout = isUndefined(v['timeout']) ? 250 : v['timeout'];
	var maxh = isUndefined(v['maxh']) ? 600 : v['maxh'];
	var cache = isUndefined(v['cache']) ? 1 : v['cache'];
	var drag = isUndefined(v['drag']) ? '' : v['drag'];
	var dragobj = drag && $$(drag) ? $$(drag) : menuObj;
	var fade = isUndefined(v['fade']) ? 0 : v['fade'];
	var cover = isUndefined(v['cover']) ? 0 : v['cover'];
	var zindex = isUndefined(v['zindex']) ? JSMENU['zIndex']['menu'] : v['zindex'];
	var ctrlclass = isUndefined(v['ctrlclass']) ? '' : v['ctrlclass'];
	var winhandlekey = isUndefined(v['win']) ? '' : v['win'];
	zindex = cover ? zindex + 500 : zindex;
	if(typeof JSMENU['active'][layer] == 'undefined') {
		JSMENU['active'][layer] = [];
	}

	for(i in EXTRAFUNC['showmenu']) {
		try {
			eval(EXTRAFUNC['showmenu'][i] + '()');
		} catch(e) {}
	}

	if(evt == 'click' && in_array(menuid, JSMENU['active'][layer]) && mtype != 'win') {
		hideMenu(menuid, mtype);
		return;
	}
	if(mtype == 'menu') {
		hideMenu(layer, mtype);
	}

	if(ctrlObj) {
		if(!ctrlObj.getAttribute('initialized')) {
			ctrlObj.setAttribute('initialized', true);
			ctrlObj.unselectable = true;

			ctrlObj.outfunc = typeof ctrlObj.onmouseout == 'function' ? ctrlObj.onmouseout : null;
			ctrlObj.onmouseout = function() {
				if(this.outfunc) this.outfunc();
				if(duration < 3 && !JSMENU['timer'][menuid]) {
					JSMENU['timer'][menuid] = setTimeout(function () {
						hideMenu(menuid, mtype);
					}, timeout);
				}
			};

			ctrlObj.overfunc = typeof ctrlObj.onmouseover == 'function' ? ctrlObj.onmouseover : null;
			ctrlObj.onmouseover = function(e) {
				doane(e);
				if(this.overfunc) this.overfunc();
				if(evt == 'click') {
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				} else {
					for(var i in JSMENU['timer']) {
						if(JSMENU['timer'][i]) {
							clearTimeout(JSMENU['timer'][i]);
							JSMENU['timer'][i] = null;
						}
					}
				}
			};
		}
	}

	if(!menuObj.getAttribute('initialized')) {
		menuObj.setAttribute('initialized', true);
		menuObj.ctrlkey = ctrlid;
		menuObj.mtype = mtype;
		menuObj.layer = layer;
		menuObj.cover = cover;
		if(ctrlObj && ctrlObj.getAttribute('fwin')) {menuObj.scrolly = true;}
		menuObj.style.position = 'absolute';
		menuObj.style.zIndex = zindex + layer;
		menuObj.onclick = function(e) {
			return doane(e, 0, 1);
		};
		if(duration < 3) {
			if(duration > 1) {
				menuObj.onmouseover = function() {
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				};
			}
			if(duration != 1) {
				menuObj.onmouseout = function() {
					JSMENU['timer'][menuid] = setTimeout(function () {
						hideMenu(menuid, mtype);
					}, timeout);
				};
			}
		}
		if(cover) {
			var coverObj = document.createElement('div');
			coverObj.id = menuid + '_cover';
			coverObj.style.position = 'absolute';
			coverObj.style.zIndex = menuObj.style.zIndex - 1;
			coverObj.style.left = coverObj.style.top = '0px';
			coverObj.style.width = '100%';
			coverObj.style.height = Math.max(document.documentElement.clientHeight, document.body.offsetHeight) + 'px';
			coverObj.style.backgroundColor = '#000';
			coverObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=20)';
			coverObj.style.opacity = 0.2;
			coverObj.onclick = function () { hideMenu(); };
			$$('append_parent').appendChild(coverObj);
			_attachEvent(window, 'load', function () {
				coverObj.style.height = Math.max(document.documentElement.clientHeight, document.body.offsetHeight) + 'px';
			}, document);
		}
	}
	if(drag) {
		dragobj.style.cursor = 'move';
		dragobj.onmousedown = function(event) {try{dragMenu(menuObj, event, 1);}catch(e){}};
	}

	if(cover) $$(menuid + '_cover').style.display = '';
	if(fade) {
		var O = 0;
		var fadeIn = function(O) {
			if(O > 100) {
				clearTimeout(fadeInTimer);
				return;
			}
			menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
			menuObj.style.opacity = O / 100;
			O += 20;
			var fadeInTimer = setTimeout(function () {
				fadeIn(O);
			}, 40);
		};
		fadeIn(O);
		menuObj.fade = true;
	} else {
		menuObj.fade = false;
	}
	menuObj.style.display = '';
	if(ctrlObj && ctrlclass) {
		ctrlObj.className += ' ' + ctrlclass;
		menuObj.setAttribute('ctrlid', ctrlid);
		menuObj.setAttribute('ctrlclass', ctrlclass);
	}
	if(pos != '*') {
		setMenuPosition(showid, menuid, pos);
	}
	if(BROWSER.ie && BROWSER.ie < 7 && winhandlekey && $$('fwin_' + winhandlekey)) {
		$$(menuid).style.left = (parseInt($$(menuid).style.left) - parseInt($$('fwin_' + winhandlekey).style.left)) + 'px';
		$$(menuid).style.top = (parseInt($$(menuid).style.top) - parseInt($$('fwin_' + winhandlekey).style.top)) + 'px';
	}
	if(maxh && menuObj.scrollHeight > maxh) {
		menuObj.style.height = maxh + 'px';
		if(BROWSER.opera) {
			menuObj.style.overflow = 'auto';
		} else {
			menuObj.style.overflowY = 'auto';
		}
	}

	if(!duration) {
		setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
	}

	if(!in_array(menuid, JSMENU['active'][layer])) JSMENU['active'][layer].push(menuid);
	menuObj.cache = cache;
	if(layer > JSMENU['layer']) {
		JSMENU['layer'] = layer;
	}
}
var dragMenuDisabled = false;
function dragMenu(menuObj, e, op) {
	e = e ? e : window.event;
	if(op == 1) {
		if(dragMenuDisabled || in_array(e.target ? e.target.tagName : e.srcElement.tagName, ['TEXTAREA', 'INPUT', 'BUTTON', 'SELECT'])) {
			return;
		}
		JSMENU['drag'] = [e.clientX, e.clientY];
		JSMENU['drag'][2] = parseInt(menuObj.style.left);
		JSMENU['drag'][3] = parseInt(menuObj.style.top);
		document.onmousemove = function(e) {try{dragMenu(menuObj, e, 2);}catch(err){}};
		document.onmouseup = function(e) {try{dragMenu(menuObj, e, 3);}catch(err){}};
		doane(e);
	}else if(op == 2 && JSMENU['drag'][0]) {
		var menudragnow = [e.clientX, e.clientY];
		menuObj.style.left = (JSMENU['drag'][2] + menudragnow[0] - JSMENU['drag'][0]) + 'px';
		menuObj.style.top = (JSMENU['drag'][3] + menudragnow[1] - JSMENU['drag'][1]) + 'px';
		menuObj.removeAttribute('top_');menuObj.removeAttribute('left_');
		doane(e);
	}else if(op == 3) {
		JSMENU['drag'] = [];
		document.onmousemove = null;
		document.onmouseup = null;
	}
}
function setMenuPosition(showid, menuid, pos) {
	var showObj = $$(showid);
	var menuObj = menuid ? $$(menuid) : $$(showid + '_menu');
	if(isUndefined(pos) || !pos) pos = '43';
	var basePoint = parseInt(pos.substr(0, 1));
	var direction = parseInt(pos.substr(1, 1));
	var important = pos.indexOf('!') != -1 ? 1 : 0;
	var sxy = 0, sx = 0, sy = 0, sw = 0, sh = 0, ml = 0, mt = 0, mw = 0, mcw = 0, mh = 0, mch = 0, bpl = 0, bpt = 0;

	if(!menuObj || (basePoint > 0 && !showObj)) return;
	if(showObj) {
		sxy = fetchOffset(showObj);
		sx = sxy['left'];
		sy = sxy['top'];
		sw = showObj.offsetWidth;
		sh = showObj.offsetHeight;
	}
	mw = menuObj.offsetWidth;
	mcw = menuObj.clientWidth;
	mh = menuObj.offsetHeight;
	mch = menuObj.clientHeight;

	switch(basePoint) {
		case 1:
			bpl = sx;
			bpt = sy;
			break;
		case 2:
			bpl = sx + sw;
			bpt = sy;
			break;
		case 3:
			bpl = sx + sw;
			bpt = sy + sh;
			break;
		case 4:
			bpl = sx;
			bpt = sy + sh;
			break;
	}
	switch(direction) {
		case 0:
			menuObj.style.left = (document.body.clientWidth - menuObj.clientWidth) / 2 + 'px';
			mt = (document.documentElement.clientHeight - menuObj.clientHeight) / 2;
			break;
		case 1:
			ml = bpl - mw;
			mt = bpt - mh;
			break;
		case 2:
			ml = bpl;
			mt = bpt - mh;
			break;
		case 3:
			ml = bpl;
			mt = bpt;
			break;
		case 4:
			ml = bpl - mw;
			mt = bpt;
			break;
	}
	var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
	var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
	if(!important) {
		if(in_array(direction, [1, 4]) && ml < 0) {
			ml = bpl;
			if(in_array(basePoint, [1, 4])) ml += sw;
		} else if(ml + mw > scrollLeft + document.body.clientWidth && sx >= mw) {
			ml = bpl - mw;
			if(in_array(basePoint, [2, 3])) {
				ml -= sw;
			} else if(basePoint == 4) {
				ml += sw;
			}
		}
		if(in_array(direction, [1, 2]) && mt < 0) {
			mt = bpt;
			if(in_array(basePoint, [1, 2])) mt += sh;
		} else if(mt + mh > scrollTop + document.documentElement.clientHeight && sy >= mh) {
			mt = bpt - mh;
			if(in_array(basePoint, [3, 4])) mt -= sh;
		}
	}
	if(pos.substr(0, 3) == '210') {
		ml += 69 - sw / 2;
		mt -= 5;
		if(showObj.tagName == 'TEXTAREA') {
			ml -= sw / 2;
			mt += sh / 2;
		}
	}
	if(direction == 0 || menuObj.scrolly) {
		if(BROWSER.ie && BROWSER.ie < 7) {
			if(direction == 0) mt += scrollTop;
		} else {
			if(menuObj.scrolly) mt -= scrollTop;
			menuObj.style.position = 'fixed';
		}
	}
	if(ml) menuObj.style.left = ml + 'px';
	if(mt) menuObj.style.top = mt + 'px';
	if(direction == 0 && BROWSER.ie && !document.documentElement.clientHeight) {
		menuObj.style.position = 'absolute';
		menuObj.style.top = (document.body.clientHeight - menuObj.clientHeight) / 2 + 'px';
	}
	if(menuObj.style.clip && !BROWSER.opera) {
		menuObj.style.clip = 'rect(auto, auto, auto, auto)';
	}
}

function hideMenu(attr, mtype) {
	attr = isUndefined(attr) ? '' : attr;
	mtype = isUndefined(mtype) ? 'menu' : mtype;
	if(attr == '') {
		for(var i = 1; i <= JSMENU['layer']; i++) {
			hideMenu(i, mtype);
		}
		return;
	} else if(typeof attr == 'number') {
		for(var j in JSMENU['active'][attr]) {
			hideMenu(JSMENU['active'][attr][j], mtype);
		}
		return;
	}else if(typeof attr == 'string') {
		var menuObj = $$(attr);
		if(!menuObj || (mtype && menuObj.mtype != mtype)) return;
		var ctrlObj = '', ctrlclass = '';
		if((ctrlObj = $$(menuObj.getAttribute('ctrlid'))) && (ctrlclass = menuObj.getAttribute('ctrlclass'))) {
			var reg = new RegExp(' ' + ctrlclass);
			ctrlObj.className = ctrlObj.className.replace(reg, '');
		}
		clearTimeout(JSMENU['timer'][attr]);
		var hide = function() {
			if(menuObj.cache) {
				if(menuObj.style.visibility != 'hidden') {
					menuObj.style.display = 'none';
					if(menuObj.cover) $$(attr + '_cover').style.display = 'none';
				}
			}else {
				menuObj.parentNode.removeChild(menuObj);
				if(menuObj.cover) $$(attr + '_cover').parentNode.removeChild($$(attr + '_cover'));
			}
			var tmp = [];
			for(var k in JSMENU['active'][menuObj.layer]) {
				if(attr != JSMENU['active'][menuObj.layer][k]) tmp.push(JSMENU['active'][menuObj.layer][k]);
			}
			JSMENU['active'][menuObj.layer] = tmp;
		};
		if(menuObj.fade) {
			var O = 100;
			var fadeOut = function(O) {
				if(O == 0) {
					clearTimeout(fadeOutTimer);
					hide();
					return;
				}
				menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
				menuObj.style.opacity = O / 100;
				O -= 20;
				var fadeOutTimer = setTimeout(function () {
					fadeOut(O);
				}, 40);
			};
			fadeOut(O);
		} else {
			hide();
		}
	}
}

function getCurrentStyle(obj, cssproperty, csspropertyNS) {
	if(obj.style[cssproperty]){
		return obj.style[cssproperty];
	}
	if (obj.currentStyle) {
		return obj.currentStyle[cssproperty];
	} else if (document.defaultView.getComputedStyle(obj, null)) {
		var currentStyle = document.defaultView.getComputedStyle(obj, null);
		var value = currentStyle.getPropertyValue(csspropertyNS);
		if(!value){
			value = currentStyle[cssproperty];
		}
		return value;
	} else if (window.getComputedStyle) {
		var currentStyle = window.getComputedStyle(obj, "");
		return currentStyle.getPropertyValue(csspropertyNS);
	}
}

function fetchOffset(obj, mode) {
	var left_offset = 0, top_offset = 0, mode = !mode ? 0 : mode;

	if(obj.getBoundingClientRect && !mode) {
		var rect = obj.getBoundingClientRect();
		var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
		if(document.documentElement.dir == 'rtl') {
			scrollLeft = scrollLeft + document.documentElement.clientWidth - document.documentElement.scrollWidth;
		}
		left_offset = rect.left + scrollLeft - document.documentElement.clientLeft;
		top_offset = rect.top + scrollTop - document.documentElement.clientTop;
	}
	if(left_offset <= 0 || top_offset <= 0) {
		left_offset = obj.offsetLeft;
		top_offset = obj.offsetTop;
		while((obj = obj.offsetParent) != null) {
			position = getCurrentStyle(obj, 'position', 'position');
			if(position == 'relative') {
				continue;
			}
			left_offset += obj.offsetLeft;
			top_offset += obj.offsetTop;
		}
	}
	return {'left' : left_offset, 'top' : top_offset};
}

var showDialogST = null;
function showDialog(msg, mode, t, func, cover, funccancel, leftmsg, confirmtxt, canceltxt, closetime, locationtime) {
	if (mode == 'js'){
		eval(func);
		//hideMenu(menuid, 'dialog');
		return ;
	}

	clearTimeout(showDialogST);
	cover = isUndefined(cover) ? (mode == 'info' ? 0 : 1) : cover;
	leftmsg = isUndefined(leftmsg) ? '' : leftmsg;
	mode = in_array(mode, ['confirm', 'notice', 'info', 'succ']) ? mode : 'alert';
	var menuid = 'fwin_dialog';
	var menuObj = $$(menuid);
	var showconfirm = 1;
	confirmtxtdefault = '确定';
	closetime = isUndefined(closetime) ? '' : closetime;
	closefunc = function () {
		if(typeof func == 'function') func();
		else eval(func);
		hideMenu(menuid, 'dialog');
	};
	if(closetime) {
		leftmsg = closetime + ' 秒后窗口关闭';
		showDialogST = setTimeout(closefunc, closetime * 1000);
		showconfirm = 0;
	}
	locationtime = isUndefined(locationtime) ? '' : locationtime;
	if(locationtime) {
		leftmsg = locationtime + ' 秒后页面跳转';
		showDialogST = setTimeout(closefunc, locationtime * 1000);
		showconfirm = 0;
	}
	confirmtxt = confirmtxt ? confirmtxt : confirmtxtdefault;
	canceltxt = canceltxt ? canceltxt : '取消';

	if(menuObj) hideMenu('fwin_dialog', 'dialog');
	menuObj = document.createElement('div');
	menuObj.style.display = 'none';
	menuObj.className = 'fwinmask';
	menuObj.id = menuid;
	$$('append_parent').appendChild(menuObj);
	var hidedom = '';
	if(!BROWSER.ie) {
		hidedom = '<style type="text/css">object{visibility:hidden;}</style>';
	}
	var s = hidedom + '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l">&nbsp;</td><td class="m_c"><h3 class="flb"><div class="flb_title">';
	s += t ? t : '提示信息';
	s += '</div><span><a href="javascript:void(0)" id="fwin_dialog_close" class="flbc" onclick="hideMenu(\'' + menuid + '\', \'dialog\')" title="关闭">关闭</a></span></h3>';
	if(mode == 'info') {
		s += msg ? msg : '';
	} else {
		s += '<div class="c altw"><div class="' + (mode == 'alert' ? 'alert_error' : (mode == 'succ' ? 'alert_right' : 'alert_info')) + '"><p>' + msg + '</p></div></div>';
		s += '<p class="o pns">' + (leftmsg ? '<span class="z xg1">' + leftmsg + '</span>' : '') + (showconfirm ? '<button id="fwin_dialog_submit" value="true" class="pn pnc"><strong>'+confirmtxt+'</strong></button>' : '');
		s += mode == 'confirm' ? '<button id="fwin_dialog_cancel" value="true" class="pn" onclick="hideMenu(\'' + menuid + '\', \'dialog\')"><strong>'+canceltxt+'</strong></button>' : '';
		s += '</p>';
	}
	s += '</td><td class="m_r"></td></tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></table>';
	menuObj.innerHTML = s;
	if($$('fwin_dialog_submit')) $$('fwin_dialog_submit').onclick = function() {
		if(typeof func == 'function') func();
		else eval(func);
		hideMenu(menuid, 'dialog');
	};
	if($$('fwin_dialog_cancel')) {
		$$('fwin_dialog_cancel').onclick = function() {
			if(typeof funccancel == 'function') funccancel();
			else eval(funccancel);
			hideMenu(menuid, 'dialog');
		};
		$$('fwin_dialog_close').onclick = $$('fwin_dialog_cancel').onclick;
	}
	showMenu({'mtype':'dialog','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['dialog'],'cache':0,'cover':cover});
	try {
		if($$('fwin_dialog_submit')) $$('fwin_dialog_submit').focus();
	} catch(e) {}
}

function showWindow(k, url,title, mode, cache, menuv,func) {
	mode = isUndefined(mode) ? 'get' : (!mode ? 'get' : mode);
	cache = isUndefined(cache) ? 1 : (!cache ? 1 : cache);
	title = isUndefined(title) ? '' : (!title ? '' : title);
	func = isUndefined(func) ? '' : (!func ? '' : func);
	var menuid = 'fwin_' + k;
	var menuObj = $$(menuid);
	var drag = null;
	var loadingst = null;
	var hidedom = '';

	var fetchContent = function() {
		if(mode == 'get') {
			menuObj.url = url;
			url += (url.search(/\?/) > 0 ? '&' : '?') + 'infloat=yes&handlekey=' + k;
			url += cache == -1 ? '&t='+(+ new Date()) : '';
			ajaxget(url, 'fwin_content_' + k, null, '', '', function() {initMenu();show();func != '' ? eval(func) : '';});
		} else if(mode == 'post') {
			menuObj.act = $$(url).action;
			ajaxpost(url, 'fwin_content_' + k, '', '', '', function() {initMenu();show();});
		}
		if(parseInt(BROWSER.ie) != 6) {
			loadingst = setTimeout(function() {showDialog('', 'info', '<img src="' + DIALOGIMGDIR + '/loading.gif"> 请稍候...')}, 3);
		}
	};
	var initMenu = function() {
		clearTimeout(loadingst);
		var objs = menuObj.getElementsByTagName('*');
		var fctrlidinit = false;
		for(var i = 0; i < objs.length; i++) {
			if(objs[i].id) {
				objs[i].setAttribute('fwin', k);
			}
			if(objs[i].className == 'flb' && !fctrlidinit) {
				if(!objs[i].id) objs[i].id = 'fctrl_' + k;
				drag = objs[i].id;
				fctrlidinit = true;
			}
		}
	};
	var show = function() {
		hideMenu('fwin_dialog', 'dialog');
		v = {'mtype':'win','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['win'],'drag':typeof drag == null ? '' : drag,'cache':cache};
		for(k in menuv) {
			v[k] = menuv[k];
		}
		showMenu(v);
	};

	if(!menuObj) {
		menuObj = document.createElement('div');
		menuObj.id = menuid;
		menuObj.className = 'fwinmask';
		menuObj.style.display = 'none';
		$$('append_parent').appendChild(menuObj);
		evt = ' style="cursor:move" onmousedown="dragMenu($$(\'' + menuid + '\'), event, 1)" ondblclick="hideWindow(\'' + k + '\')"';
		if(!BROWSER.ie) {
			hidedom = '<style type="text/css">object{visibility:hidden;}</style>';
		}

		var html = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"' + evt + '></td><td class="t_r"></td></tr>';
//		if (title){
			html += '<tr><td class="m_l">&nbsp;</td><td class="m_c"><h3 class="flb"><div class="flb_title">'+title+'</div><span><a href="javascript:void(0)" id="fwin_dialog_close" class="flbc" onclick="hideWindow(\'' + k + '\')" title="关闭">关闭</a></span></h3></td><td class="b_r" style="border-radius:0"></td></tr>';
//		}
		html += '<tr><td class="m_l"' + evt + '">&nbsp;</td><td class="m_c" id="fwin_content_' + k + '" style="padding:3px">'
		html += '</td><td class="m_r"' + evt + '"></td></tr><tr><td class="b_l"></td><td class="b_c"' + evt + '></td><td class="b_r"></td></tr></table>';
		menuObj.innerHTML = hidedom + html;
		if(mode == 'html') {
			$$('fwin_content_' + k).innerHTML = url;
			initMenu();
			show();
		} else {
			fetchContent();
		}
	} else if((mode == 'get' && (url != menuObj.url || cache != 1)) || (mode == 'post' && $$(url).action != menuObj.act)) {
		fetchContent();
	} else {
		show();
	}
	doane();
}

function showSuccess(msg) {
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	msg = msg.replace(p, '');
	if(msg !== '') {
		showDialog(msg, 'succ', '提示信息', null, true, null, '', '', '', 2);
	}
}

function showError(msg) {
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	msg = msg.replace(p, '');
	if(msg !== '') {
		showDialog(msg, 'alert', '错误信息', null, true, null, '', '', '', 2);
	}
}

function hideWindow(k, all, clear) {
	all = isUndefined(all) ? 1 : all;
	clear = isUndefined(clear) ? 1 : clear;
	hideMenu('fwin_' + k, 'win');
	if(clear && $$('fwin_' + k)) {
		$$('append_parent').removeChild($$('fwin_' + k));
	}
	if(all) {
		hideMenu();
	}
}

function ajax_get_confirm(msg, url){
	if (msg != ''){
		showDialog(msg, 'confirm', '', function(){ajaxget(url);});
	}else{
		ajaxget(url);
	}
}
function get_confirm(msg, url){
    if(msg != ''){
       showDialog(msg, 'confirm', '', function(){ window.location = url;});
    }else{
    	window.location = url;
    }
}

/*
 * 微商城弹出窗口
 */
(function($) {
    $.fn.microshop_form = function(options) {
        var settings = $.extend({}, {title: ''}, options);
        var _div = $(this);
        $(this).addClass("dialog_wrapper");
        $(this).wrapInner(function(){
            return '<div class="dialog_content" style="background: #FFFFFF;margin: 0px; padding: 0px;">';
        });
        $(this).wrapInner(function(){
            return '<div class="dialog_body" style="position: relative;">';
        });
        $(this).find('.dialog_body').prepend('<h3 class="dialog_head" style="cursor: move;"><span class="dialog_title"><span class="dialog_title_icon">'+settings.title+'</span></span><span class="dialog_close_button" style="position: absolute; text-indent: -9999px; cursor: pointer; overflow: hidden;">close</span></h3>');
        $(this).append('<div style="clear:both;"></div>');

        $(".dialog_close_button").click(function(){
            _div.hide();
        });
    }
})(jQuery);

(function($) {
    $.fn.microshop_form_show = function(options) {
        var settings = $.extend({}, {width: 480}, options);
        settings.left = $(window).scrollLeft() + ($(window).width() - settings.width) / 2;
        settings.top  = $(window).scrollTop()  + ($(window).height() - $(this).height()) / 2;
        $(this).attr("style","display:none; z-index: 1100; position: absolute; width: "+settings.width+"px; left: "+settings.left+"px; top: "+settings.top+"px;");
        $(this).show();
    }
})(jQuery);


/*
 * 微商城消息发布
 */
(function($) {
    $.fn.microshop_publish = function(options,submit_function) {
        var settings = $.extend({}, {max: 140,button_item:'#btn_publish_comment',allow_null:'false'}, options);
        $(this).after('<span id="_comment_count" nc_type="commend_count" class="commend_count"></div>');
        settings.message_item = $(this).next("[nc_type='commend_count']");
        var message_object = $(this);
        return this.each(function() {
            $(settings.message_item).html("0/"+settings.max);
            $(this).keyup(commend_message_count);
            $(this).focusout(commend_message_count);
            if(settings.button_item != '') {
                $(settings.button_item).click(commend_message_submit);
            }
        });

        function commend_message_count() {
            var message_count = $(message_object).val().length;
            if(message_count <= settings.max) {
                settings.message_item.css("color","");
                settings.message_item.html(message_count+"/"+settings.max);
            } else {
                var over_count = message_count - settings.max;
                settings.message_item.css("color","red");
                settings.message_item.html("已超出"+parseInt(over_count)+"个字");
            }
        }

        function commend_message_submit() {
            var message_count = $(message_object).val().length;
            if(message_count <= settings.max && (message_count > 0 || settings.allow_null == 'true')) {
                $(settings.button_item).attr("disabled","disabled");
                submit_function();
                $(message_object).val('');
                settings.message_item.html("0/"+settings.max);
                $(settings.button_item).removeAttr("disabled");
            }
        }
    }
})(jQuery);

/*
 * 微商城计数加减
 */
(function($) {
    $.fn.microshop_count = function(options) {
        var settings = $.extend({}, { type:'+',step:1}, options);
        var old_count = parseInt($(this).html());
        if(old_count >= 999) {
            $(this).html('999+');
        } else {
            var new_count = old_count;
            if(settings.type == '-') {
                new_count = old_count - settings.step;
            } else {
                new_count = old_count + settings.step;
            }
            if(new_count < 0) {
                new_count = 0;
            }
            $(this).html(new_count);
        }
        return this;
    }
})(jQuery);

/*
 * 微商城喜欢
 */
(function($) {
    $.fn.microshop_like = function(options) {
        var settings = $.extend({}, { type:null,count_target:'' }, options);
        if( settings.type == null ) return false;
        return this.each(function() {
            $(this).parent().parent().append("<div class='like_tooltips' style='display:none;'></div>");
            $(this).click(submit_like);
        });
        function submit_like() {
            var item = $(this);
            $.getJSON("index.php?act=like&op=like_save", { type: settings.type, like_id: item.attr("like_id") }, function(json){
                if(json.result == "true") {
                    if(settings.count_target == '') {
                        item.find("em").microshop_count({type:"+"});
                    } else {
                        settings.count_target.microshop_count({type:"+"});
                    }
                }
                $(".like_tooltips").hide();
                var tooltips = item.parent().parent().find(".like_tooltips");
                tooltips.html(json.message).show();
                setTimeout(function(){tooltips.hide()},2000);
            });
        }
    }
})(jQuery);


/*
 * 表情处理
 */
(function($) {
    $.fn.smilies = function(options) {
        var settings = $.extend({}, {smilies_input: '#comment_message'}, options);
        settings.smilies_div = "#_smilies_div"
        $(document).click(function(){
            $(settings.smilies_div).html(''); 
            $(settings.smilies_div).hide();
        });
        $(this).after('<div id="_smilies_div" class="smilies-module"></div>');
        var smilies_array = new Array();
        var STATICURL = 'resource/js/smilies/';
        smilies_array[1] = [['1', ':smile:', 'smile.gif', '28', '28', '28','微笑'], ['2', ':sad:', 'sad.gif', '28', '28', '28','难过'], ['3', ':biggrin:', 'biggrin.gif', '28', '28', '28','呲牙'], ['4', ':cry:', 'cry.gif', '28', '28', '28','大哭'], ['5', ':huffy:', 'huffy.gif', '28', '28', '28','发怒'], ['6', ':shocked:', 'shocked.gif', '28', '28', '28','惊讶'], ['7', ':tongue:', 'tongue.gif', '28', '28', '28','调皮'], ['8', ':shy:', 'shy.gif', '28', '28', '28','害羞'], ['9', ':titter:', 'titter.gif', '28', '28', '28','偷笑'], ['10', ':sweat:', 'sweat.gif', '28', '28', '28','流汗'], ['11', ':mad:', 'mad.gif', '28', '28', '28','抓狂'], ['12', ':lol:', 'lol.gif', '28', '28', '28','阴险'], ['13', ':loveliness:', 'loveliness.gif', '28', '28', '28','可爱'], ['14', ':funk:', 'funk.gif', '28', '28', '28','惊恐'], ['15', ':curse:', 'curse.gif', '28', '28', '28','咒骂'], ['16', ':dizzy:', 'dizzy.gif', '28', '28', '28','晕'], ['17', ':shutup:', 'shutup.gif', '28', '28', '28','闭嘴'], ['18', ':sleepy:', 'sleepy.gif', '28', '28', '28','睡'], ['19', ':hug:', 'hug.gif', '28', '28', '28','拥抱'], ['20', ':victory:', 'victory.gif', '28', '28', '28','胜利'], ['21', ':sun:', 'sun.gif', '28', '28', '28','太阳'],['22', ':moon:', 'moon.gif', '28', '28', '28','月亮'], ['23', ':kiss:', 'kiss.gif', '28', '28', '28','示爱'], ['24', ':handshake:', 'handshake.gif', '28', '28', '28','握手']];
        $(settings.smilies_div).position({
            of: $("body"),
            at: "left bottom",
            offset: "10 10"
        });

        this.each(function() {
            $(this).live('click',function(){
                //光标处插入代码功能
                smiliesshowdiv(this);        
                return false;
            });
        });

        //显示和隐藏表情模块
        function smiliesshowdiv(btnobj){
            if($(settings.smilies_div).css("display")=='none'){
                if($(settings.smilies_div).html() == ''){
                    smilies_show( 8, 'e_');
                }
                $(settings.smilies_div).show();
                smiliesposition(btnobj);
            }else{
                $(settings.smilies_div).hide();
            }
        }
        //弹出层位置控制
        function smiliesposition(btnobj){
            $(settings.smilies_div).position({
                of: btnobj,
                at: "left bottom",
                offset: "105 57"
            });
        }
        function smilies_show(smcols, seditorkey) {
            if(seditorkey && !$("#"+seditorkey + 'sml_menu')[0]) {
                var div = document.createElement("div");
                div.id = seditorkey + 'sml_menu';
                div.className = 'sllt';
                $(settings.smilies_div).append(div);
                var div = document.createElement("div");
                div.id = "_smilies_content" 
                    div.style.overflow = 'hidden';
                $("#"+seditorkey + 'sml_menu').append(div);
            }
            smilies_onload(smcols, seditorkey);
            //image绑定操作函数
            $("#_smilies_content").find("td").bind('click',function(){
                insertsmilie(this);
            });
        }

        function insertsmilie(smilieone){
            var code = $(smilieone).attr('codetext');
            insertAtCaret(code);
            $(settings.smilies_input).focus();
            $(settings.smilies_div).html('');
            $(settings.smilies_div).hide();
        }

        function insertAtCaret(textFeildValue){  
            var textObj = $(settings.smilies_input).get(0);  
            if(document.all && textObj.createTextRange && textObj.caretPos){  
                var caretPos=textObj.caretPos;  
                caretPos.text = caretPos.text.charAt(caretPos.text.length-1) == '' ?  
                    textFeildValue+'' : textFeildValue;  
            }  
            else if(textObj.setSelectionRange){  
                var rangeStart=textObj.selectionStart;  
                var rangeEnd=textObj.selectionEnd;  
                var tempStr1=textObj.value.substring(0,rangeStart);  
                var tempStr2=textObj.value.substring(rangeEnd);  
                textObj.value=tempStr1+textFeildValue+tempStr2;  
                textObj.focus();  
                var len=textFeildValue.length;  
                textObj.setSelectionRange(rangeStart+len,rangeStart+len);  
                textObj.blur();  
            }  
            else {  
                textObj.value+=textFeildValue;  
            }  
        }  

        function smilies_onload(smcols, seditorkey) {
            seditorkey = !seditorkey ? '' : seditorkey;
            $("#_smilies_content").html('<div id="_smilies_content_data"></div><div class="sllt-p" id="_smilies_content_page"></div>');
            smilies_switch(smcols, seditorkey);
        }

        function smilies_switch(smcols, seditorkey) {
            var page = 1;
            if(!smilies_array || !smilies_array[page]) return;
            smiliesdata = '<table id="_smilies_content_table" cellpadding="0" cellspacing="0"><tr>';
            j = k = 0;
            img = [];
            for(i in smilies_array[page]) {
                if(j >= smcols) {
                    smiliesdata += '<tr>';
                    j = 0;
                }
                var s = smilies_array[page][i];
                smilieimg = STATICURL + 'images/' + s[2];
                img[k] = new Image();
                img[k].src = smilieimg;
                smiliesdata += s && s[0] ? '<td id="' + seditorkey + 'smilie_' + s[0] + '_td" codetext="'+s[1]+'"><img id="smilie_' + s[0] + '" width="' + s[3] +'" height="' + s[4] +'" src="' + smilieimg + '" alt="' + s[1] + '" title="'+s[6]+'" />' : '<td>';
                j++; k++;
            }
            smiliesdata += '</table>';
            $('#_smilies_content_data').html(smiliesdata);
        }

    }
})(jQuery);

/*
 * 微商城图片延迟加载
 */
(function($) {
    $.fn.microshop_lazyload = function() {
        var lazy_items = [];
        this.each(function() {
            var lazy_item = {
                object: $(this),
                url: $(this).attr("data-src")
            }
            lazy_items.push(lazy_item);
        });

        var load_img = function() {
            var window_height = $(window).height();
            var scroll_top = $(window).scrollTop();

            $.each(lazy_items, function(i, lazy_item) {
                if(lazy_item.object) {
                    item_top = lazy_item.object.offset().top - scroll_top;
                    if(item_top >= 0 && item_top < window_height) {
                        if(lazy_item.url) {
                            lazy_item.object.attr("src",lazy_item.url);
                        }
                        lazy_item.object = null;
                    }
                }
            });
        }
        load_img();
        $(window).bind("scroll", load_img);
    }
})(jQuery);


