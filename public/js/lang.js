$(function(){
	var cookie_value = cookie('lang');
	if(cookie_value == null){
		cookie('lang', 'zh');
	}
});

function cookie(name, value, options){
	if(typeof value != 'undefined'){
		options = options || {};
		if(value === null){
			value = '';
			options.expires = -1;
		}
		
		var expires = '';
		if(options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)){
			var date;
			if(typeof options.expires  == 'number'){
				date = new Date();
				date.setTime(date.getTime() + options.expires *24*60*60*1000);
			}else{
				date = options.expires;
			}
			expires = ';expires=' + date.toUTCString();
		}
		
		var path = options.path ? ';path=' + (options.path) : '';
		var domain = options.domain ? ';domain=' + (options.domain) : '';
		var secure = options.secure ? ';secure' : '';
		document.cookie = [name, ' = ', encodeURIComponent(value), expires, path, domain, secure].join('');
	}else{
		var cookieValue = null;
		if(document.cookie && document.cookie != ''){
			var cookies = document.cookie.split(';');
			for(var i = 0; i < cookies.length; i++){
				var cookie = (cookies[i]).replace(/^\s + |\s + $/g, "");
				if(cookie.substring(0, name.length + 1) == (name + '=')){
					cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
					break;
				}
			}
		}
		return cookieValue;
	}
}

function changeLang(){
	var url = window.location.href;
	if(document.getElementById("lang").className=="en"){
		//changeLocale("zh", url);
		cookie('lang', 'zh');
	}else{
		//changeLocale("en", url);
		cookie('lang', 'en');
	}
	//replace # to avoid the error window.location not reloading
	url = url.replace(/#/g, '');
	// add param "noHtml=1" if it is the login page
	window.location = (url.indexOf("?")>0 || url.indexOf("%3F")>0) ? url : url +"?noHtml=1";
}

function changeLocale(locale, url){
	var loading_dialog = null;
	$.ajax({
		url : "index.php?group=home&module=index&action=changeLocale",
		data : {
			"locale" : locale
		},
		dataType : "json",
		beforeSend : function(){
			//$.jBox.tip(Trans.t("正在切换语言..."), "loading", {timeout:3000});
			layer.load(Trans.t("正在切换语言..."), 10);
		},
		success : function(data) {
			console.log(data);
			//$.jBox.closeTip();
			layer.close(loading_dialog);
			window.location = url;
		}
	});
}

function exitFive(){
	layer.load(Trans.t("正在退出系统"),100);
}