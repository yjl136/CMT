function timesync(){
	if(!validateField($("#current_time"), "datetime")){
		return false;
	}
	$.ajax({
		url : "/CMT/public/timesync",
		data : {
			"current_time" : $('#current_time').val()
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == 1){
				showLayerMsg('同步成功', false);
				setTimeout(function(){reboot();}, 500);
			}else{
				showLayerMsg('同步失败', true);
			}
		},
		error : function(data) {
			console.log(data);
			showLayerMsg('同步失败', true);
		}
	});
	return false;
}
function showLayerMsg(msg, error){
	layer.msg(msg, {
		icon : (error ? 2:1),
		time : 2000
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

function reboot(){
	var target=0;
	$.ajax({
		url : "/CMT/public/sysUpgrade/reboot/"+target,
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data){
				var ii=layer.load('等待重启...',5);
				setTimeout(function(){
					layer.close(ii);
				},5000);
			}else{
				showLayerMsg('重启失败!', true);
			}
		}
	});
}
