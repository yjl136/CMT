// JavaScript Document
var xmlHttp;
function $(id)
{
	id = id.replace(/#/, id);
	return document.getElementById(id);
}

function $c(cssName)
{
	cssName = cssName.replace(/./, cssName);
	return getElementsByClassName(cssName);
}

function getElementsByClassName(cssName){
	var classElements = [], allElements = document.getElementsByTagName('*');
	for(var i = 0; i < allElements.length; i++){
		if(allElements.className == cssName){
			classElements[classElements.length] = allElements[i];
		}
	}
	return classElements;
}

function $s(selector, attr, value){
	if(selector.indexOf('#') == 0){
		var element = null;
		element = $(selector);
		setAttribute(element, attr, value);
	}else if(selector.indexOf('.') == 0){
		var elements = $c(selector);
		for(var element in elements){
			setAttribute(element, attr, value);
		}
	}
}

function setAttribute(element, attr, value){
	if(element != null){
		if(attr == "html"){
			element.innerHTML = value;
		}else if(attr == "css"){
			element.className = value;
		}else if(attr == "value"){
			element.value = value;
		}else if(attr == "display"){
			element.display = value;
		}
	}
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	{
		 // Firefox, Opera 8.0+, Safari
		 xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
		  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
		  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function ajaxQuery(url, success, error, complete){
	xmlHttp=GetXmlHttpObject();
	xmlHttp.open('GET', url, true);
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xmlHttp.onreadystatechange=function(){
		if(xmlHttp.readyState==4){
			if(complete != null){
				complete();
			}
			
			if(xmlHttp.status==200){
				if(success != null){
					var data = xmlHttp.responseText;
					success(data);
				}
			}else{
				if(error != null){
					var data = xmlHttp.responseText;
					error(data);
				}
			}
		}
	}
	xmlHttp.send(null);	
}

function getUrlQuery(name, url) {
	if(url == null) {
		url = location.href;
	}
	var value;
	var query;
	var queryStart = url.indexOf("?");
	if(queryStart < 0 || queryStart == url.length-1) {
		return null;
	}
	query = url.substring(queryStart+1);
	query = "&" + query + "&";
	
	var nameString = "&" + name + "=";
	var nameStart = query.indexOf(nameString);
	if(nameStart < 0) {
		return null;		
	}
	
	var nameEnd = query.indexOf("&", nameStart + nameString.length);
	value = query.substring(nameStart + nameString.length, nameEnd);
	value = decodeURIComponent(value);
	return value;
}
