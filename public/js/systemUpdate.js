$(function(){
	//初始化进度栏
//	init();
	//传输方式单选框点击事件
	$("#transWayBox > a").on("click", function(){
		var element = this;
		$("#transWayBox > a > i").each(function(){
			if(this.parentNode == element){
				this.className = "checkbox_on";
			}else{
				this.className = "checkbox";
			}
		});
		return false;
	});
});

function init(){
	//重置进度条
	showProgress(0);
	changeStep(1);
	return false;
}

var loading_dialog = null;

function checkTransWay(){
	var way = getTransWay();
	$.ajax({
		url : "/CMT/public/sysUpgrade/checkTransWay/"+way,
		beforeSend : function(){
			loading_dialog = layer.load('Trans.t(\'正在检测...\')', 130);
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "1"){//检测传输通道成功
				//查询更新
				setTimeout(function(){querySysUpdate();}, 500);
			}else{
				layer.close(loading_dialog);

				hideAllBox();

				showMsg(data["msg"], "error");

			}
		}
	});
	return false;
}
function showErrorMsg(display, msg) {
	if (display) {
		$("#msg").html(msg);
		$("#msgbox").show();
	} else {
		$("#msgbox").hide();
	}
}
function querySysUpdate(){
	var way = getTransWay();
	$.ajax({
		url : "/CMT/public/sysUpgrade/querySysUpdate",
		dataType : "json",
		success : function(data) {
			console.log('querySysUpdate');
			if(data["code"] == "1"){//查询成功
				//查询版本信息
				setTimeout(function(){queryVersion();}, 500);
			}else{//查询失败
				//关闭Loading
				//$.jBox.closeTip();
				layer.close(loading_dialog);
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
			}
		},
		error : function () {
			console.log('error');
		}
	});
}

function queryVersion(){
	$.ajax({
		url : "/CMT/public/sysUpgrade/queryVersion",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data != null){//查询成功
				showVersion(data);
			}
			layer.close(loading_dialog);
			//显示第二步
			changeStep(2);
		},
		error : function () {
			console.log('queryVersion error');
		}
	});
}

function showVersion(list){
	var content = '';
	for(var key in list){
		var css = list[key]["CurVersion"] == list[key]["PkgVersion"] ? "fontGreen" : "fontRed";
		content += "<tr>";
		content += "<td>"+list[key]["Name"]+"</td>";
		content += "<td>"+list[key]["CurVersion"]+"</td>";
		content += "<td class='" + css + "'>"+list[key]["PkgVersion"]+"</td>";
		content += "</tr>";
	}
	$("#versiontab").html(content);
}

function copyPackage(){
	$.ajax({
		url : "/CMT/public/sysUpgrade/copyPackage",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == 1){//发送成功
				//$("#progressmsg").html('Trans.t("正在拷贝更新包，请稍候！")');
				$("#progressmsg").html("正在拷贝更新包，请稍候！");
				//显示第三步
				changeStep(3);
				//查询拷贝进度
				setTimeout(function(){queryCopyProgress();}, 1000);
			}else{//查询失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
			}
		}
	});
	return false;
}

function queryCopyProgress(){
	$.ajax({
		url : "/CMT/public/sysUpgrade/queryCopyProgress",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == 1){//查询成功
				var progress = data["progress"];
				//更新进度条
				showProgress(progress);
				
				if(progress < 100){
					//查询拷贝进度
					setTimeout(function(){queryCopyProgress();}, 1000);
				}else{
					//开始更新
					setTimeout(function(){startUpdate();}, 1000);
				}
			}else{//查询失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
			}
		}
	});
}

function showProgress(progress){
	var percent = progress + "%";
	$("#pg_percent").html(percent);
	$("#pg_bar").css("width", percent);
}

function startUpdate(){
	$.ajax({
		url : "/CMT/public/sysUpgrade/startUpdate",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == 1){//发送成功
				//$("#progressmsg").html('Trans.t("正在升级系统，请稍候！")');
				$("#progressmsg").html('正在升级系统，请稍候！');
				//重置进度条
				showProgress(0);
				
				//查询更新进度
				setTimeout(function(){querySysUpdateProgress();}, 1000);
			}else{//发送失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
			}
		}
	});
}

function querySysUpdateProgress(){
	$.ajax({
		url : "/CMT/public/sysUpgrade/querySysUpdateProgress",
		dataType : "json",
		success : function(data) {
			if (data != null)
			{
		        console.log(data);
				if (data["code"] == 1){//查询成功
					var progress = data["progress"];
					//更新进度条
					showProgress(progress);
					if(progress < 100){
						setTimeout(function(){querySysUpdateProgress();}, 3000);
					}else{
						showDevice(data["content"]);
						changeStep(4);
						loading_dialog = layer.load('等待系统重启...', 125);
						setTimeout(function(){reboot(0);}, 120000);
					}
				}else{//查询失败
					// if unknown error, do nothing
					if (data["reason"].indexOf("unknown error") >= 0 ){
						//查询更新进度
						console.log("unknown error, querySysUpdateProgress continue query");
						setTimeout(function(){querySysUpdateProgress();}, 3000);
					} else {
						//隐藏所有box
						hideAllBox();
						//显示错误信息
						showMsg(data["msg"], "error");
					}
				}
			} else {
				//查询更新进度
				console.log("data is null, querySysUpdateProgress continue query");
				setTimeout(function(){querySysUpdateProgress();}, 3000);
			}
				
		}
	});
}

function showDevice(data){
	//TODO 
}

function reboot(target){
	$.ajax({
		url : "/CMT/public/sysUpgrade/reboot/"+target,
		dataType : "json",
		success : function(data) {
			console.log(data);
			//关闭Loading
			//$.jBox.closeTip();
			layer.close(loading_dialog);
			if(data["code"] == 1){//查询成功
				//隐藏所有box
				hideAllBox();
				//结果信息
				//showMsg('Trans.t("等待系统重启...")', "success");
				showMsg("等待系统重启...", "success");
			}else{//查询失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
			}
		}
	});
}

function getTransWay(){
	var way = 0;
	$("#transWayBox > a > i").each(function(index){
		if(this.className == "checkbox_on"){
			way = this.id;
		}
	});
	console.log("trans way = " + way);
	return way;
}

function changeStep(step){
	//跳转到第i步
	changeScrollBar(step);
	//显示第i个box
	hideAllBox();
	showBox(step);
	//隐藏错误消息框
	$("#msgbox").hide();
}

function changeScrollBar(step){
	$("#stepbox span").removeClass("on").eq(step-1).addClass("on");
	$("#scrollbar").attr("class", "on b"+step);
}

function hideAllBox(){
	for(var i = 1; i <= 4; i++){
		showBox(i, true);
	}
}

function showBox(index, hidden){
	if(!hidden){
		$("#step"+index+"box").show();
	}else{
		$("#step"+index+"box").hide();
	}
}

