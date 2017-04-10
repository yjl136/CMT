$(function(){
	//初始化进度栏
	init();
});

function init(){
	//重置进度条
	showProgress(0);
	changeStep(1);
	return false;
}
var loading_dialog = null;
function queryDevUpdate(){
	console.log("queryDevUpdate");
	$.ajax({
		url : "/CMT/public/devUpgrade/queryDevUpdate",
		dataType : "json",
		beforeSend : function(){
			//Loading 30s后关闭
			//$.jBox.tip(Trans.t('正在检测部件版本...'), 'loading', {timeout : 30000});
			//loading_dialog = layer.load(Trans.t('正在检测部件版本...'), 200);
			loading_dialog = layer.load('正在检测部件版本...', 200);

		},
		success : function(data) {
			//关闭Loading
			//$.jBox.closeTip();
			layer.close(loading_dialog);
			if(data["code"] == 1){//查询成功
				//查询版本信息
				setTimeout(function(){queryVersion();}, 500);
			}else{//查询失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
				//showErrorMsg(true,data["msg"]);
			}
		}
	});
}
function showErrorMsg(display, msg) {
	if (display) {
		$("#msg").html(msg);
		$("#msgbox").show();
	} else {
		$("#msgbox").hide();
	}
}
function queryVersion(){
	$.ajax({
		url : "/CMT/public/devUpgrade/queryVersion",
		dataType : "json",
		success : function(data) {
			if(data != null){//查询成功
				showVersion(data);
			}
		}
	});
}

function showVersion(list){
	var content = '';
	for(var key in list){
		if(list[key]["CurVersion"] == list[key]["PkgVersion"]){
			continue;
		}
		var css = list[key]["CurVersion"] == list[key]["PkgVersion"] ? "fontGreen" : "fontRed";
		content += "<tr>";
		content += "<td class=\"fontCenter\"><i class=\"dk_checkbox\" id=\"" + list[key]["DevType"] + "\"></i></td></td>";
		content += "<td>"+list[key]["Name"]+"</td>";
		content += "<td>"+list[key]["CurVersion"]+"</td>";
		content += "<td class='" + css + "'>"+list[key]["PkgVersion"]+"</td>";
		content += "</tr>";
	}
	if(content == ''){//不存在版本异常的设备
		//隐藏所有box
		hideAllBox();
		//显示错误信息
		//showMsg(Trans.t("不存在版本异常的设备！"), "error");
		showMsg("不存在版本异常的设备！", "error");
		//showErrorMsg(true,"不存在版本异常的设备！");
		return ;
	}
	$("#versiontab").html(content);
	$("#versiontab tr").on("click", function(){
		$("#versiontab i").attr("class", "dk_checkbox");
		$(this).children("td:eq(0)").children("i").attr("class", "dk_checkbox_on");
	});
	$("#versiontab tr").eq(0).trigger("click");
	
	//显示第二步
	changeStep(2);
}

function showProgress(progress){
	var percent = progress + "%";
	$("#pg_percent").html(percent);
	$("#pg_bar").css("width", percent);
}

function getTarget(){
	return $("#versiontab .dk_checkbox_on").eq(0).attr("id");
}

function startUpdate(){
	var target = getTarget();
	$.ajax({
		url : "/CMT/public/sysUpgrade/startUpdate/"+target,
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] ==1){//发送成功
				//$("#progressmsg").html(Trans.t("正在升级部件，请稍候！"));
				$("#progressmsg").html("正在升级部件，请稍候！");
				//显示第三步
				changeStep(3);
				
				//重置进度条
				showProgress(0);
				
				//查询更新进度
				setTimeout(function(){querySysUpdateProgress();}, 10000);
			}else{//发送失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
				//showErrorMsg(true,data["msg"]);
			}
		}
	});
}

function querySysUpdateProgress(){
	var target = getTarget();
	$.ajax({
		url : "/CMT/public/sysUpgrade/querySysUpdateProgress/"+target,
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == 1){//查询成功
				var progress = data["progress"];
				//更新进度条
				showProgress(progress);
				
				if(progress < 100){
					//查询更新进度
					setTimeout(function(){querySysUpdateProgress();}, 3000);
				}else{
					//显示部件
					showDevice(data["content"]);
					//显示第三步
					changeStep(4);
					//Loading 200s后关闭
					//$.jBox.tip(Trans.t('等待系统重启...'), 'loading', {timeout : 200000});
					//loading_dialog = layer.load(Trans.t('等待系统重启...'), 125);
					loading_dialog = layer.load('等待系统重启...', 125);
					//定时3分钟后重启系统
					setTimeout(function(){reboot(0);}, 120000);
				}
			}else{//查询失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
				//showErrorMsg(true,data["msg"]);
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
				//showMsg(Trans.t("等待系统重启..."), "success");
				showMsg("等待系统重启...", "success");
				//showErrorMsg(true,data["msg"]);
			}else{//查询失败
				//隐藏所有box
				hideAllBox();
				//显示错误信息
				showMsg(data["msg"], "error");
				//showErrorMsg(true,data["msg"]);
			}
		}
	});
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

