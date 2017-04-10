$(function(){
	//初始化进度栏
	//init();
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
	showProgress(0);
	changeStep(1);
	return false;
}

var loading_dialog = null;
function checkTransWay(){
	var way = getTransWay();
	$.ajax({
		url : "/CMT/public/progUpdate/checkTransWay/"+way,
		beforeSend : function(){
			loading_dialog = layer.load('正在检测...', 130);
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == 1){
				setTimeout(function(){queryProgUpdate();}, 500);
			}else{
				layer.close(loading_dialog);
				hideAllBox();
				showMsg(data["msg"], "error");
			}
		}
	});
	return false;
}

function queryProgUpdate(){
	var way = getTransWay();
	$.ajax({
		url : "/CMT/public/progUpdate/queryProgUpdate/"+way,
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "1"){
				if(data["unfinished"]){
					layer.close(loading_dialog);
					changeStep(2);
					hideAllBox();
					showMsg(data["msg"], "error", "progError","下一步", "startProgUpdate");
				}else{
					setTimeout(function(){queryProgVersion();}, 500);					
				}
			}else{
				layer.close(loading_dialog);

				hideAllBox();
				showMsg(data["msg"], "error");
			}
		}
	});
}

function queryProgVersion(){
	$.ajax({
		url : "/CMT/public/progUpdate/queryProgVersion",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "1"){
				showVersion(data);
			}
			layer.close(loading_dialog);
			changeStep(2);
		}
	});
}

function showVersion(data){
	$("#create_time").html(data["create_time"]);
	$("#desc").html(data["desc"]);
}

function startProgUpdate(){
	var way = getTransWay();
	$.ajax({
		url : "/CMT/public/progUpdate/startProgUpdate/"+way,
		dataType : "json",
		success : function(data) {
			if(data["code"] == "1"){
				$("#progressmsg").html("正在升级节目，请稍候！");
				showProgress(0);
				changeStep(3);
				setTimeout(function(){queryProgUpdateProgress();}, 5000);
			}else{
				hideAllBox();
				showMsg(data["msg"], "error");
			}
		}
	});
}

function queryProgUpdateProgress(){
	var way = getTransWay();
	$.ajax({
		url : "/CMT/public/progUpdate/queryProgUpdateProgress/"+way,
		dataType : "json",
		success : function(data) {
			if (data != null)
			{
				if(data["code"] == "1"){//查询成功
					var progress = parseInt(data["progress"]);
					var type = parseInt(data["type"]);
					showProgress(progress);
					if(type != 4){
						setTimeout(function(){queryProgUpdateProgress();}, 3000);
					}else{
						changeStep(4);
						setTimeout(function(){cleanup();}, 1000);
					}
				}else{
					if (data["reason"].indexOf("unknown error") >= 0 ){
						console.log("unknown error, queryProgUpdateProgress, continue query");
						setTimeout(function(){queryProgUpdateProgress();}, 3000);
					} else {
						hideAllBox();
						showMsg(data["msg"], "error", "progError");
					}
				}
			} else {
				console.log("data is null, queryProgUpdateProgress, continue query");
				setTimeout(function(){queryProgUpdateProgress();}, 3000);
			}
		}
	});
}

function showProgress(progress){
	var percent = progress + "%";
	$("#pg_percent").html(percent);
	$("#pg_bar").css("width", percent);
}

function cleanup(){
	$.ajax({
		url : "/CMT/public/progUpdate/cleanup",
		dataType : "json",
		beforeSend : function(){
			loading_dialog = layer.load('正在清理...', 30);
		},
		success : function(data) {
			console.log(data);
			layer.close(loading_dialog);
			if(data["code"] == "1"){
				hideAllBox();
				showMsg(data["msg"], "success");
			}else{
				hideAllBox();
				showMsg(data["msg"], "error");
			}
		},
		error : function(data) {
			console.log(data);
			layer.close(loading_dialog);
			hideAllBox();
			showMsg("未知错误", "error");
		}
	});
}

function queryErrorLog(){
	var url = "index.php?group=maintenance&module=upgrade&action=progErrorLog";
	$.get(url, {}, function(content) {
		layer.open({
			type: 1,
		    shade: [0.5, "#000"],
		    shadeClose: true,
		    area: ['600px', '400px'],
		    title: false,
			content : content
		});
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
	changeScrollBar(step);
	hideAllBox();
	showBox(step);
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

/*
 * function hideAllBox(sum){
 * 	  var sum = parseInt(sum);
 * 	  for(var i = 1; i <= sum; i++){
		showBox(i, true);
	  }
 * }
 * */

function showBox(index, hidden){
	if(!hidden){
		$("#step"+index+"box").show();
	}else{
		$("#step"+index+"box").hide();
	}
}

