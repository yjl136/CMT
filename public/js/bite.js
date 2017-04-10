var retryTimes = 0;
var maxTimes = 5;
var bite_loading = null;

function bite(element, dev_id){
	showErrorMsg(false, "");
	$.ajax({
		url : "/CMT/public/bite/startBite/"+dev_id,
		dataType : "json",
		beforeSend : function(){
			bite_loading = layer.load("正在自检...", 30);
		},
		success : function(data) {
			if(data['code'] == 1){
				var bite_time = data["biteTime"];
				setTimeout(function(){query(dev_id, bite_time);}, 5000);
			}else{
				if(bite_loading){
					layer.close(bite_loading);
					bite_loading = null;
				}
				var msg = data['content'];
				showErrorMsg(true, msg);
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
function query(dev_id, bite_time){
	if(bite_loading){
		layer.close(bite_loading);
		bite_loading = null;
	}
	window.location.href = "showBiteResult/"+dev_id;
}

function showBiteContent(mac) {
    layer.load(2, {time: 5*1000});
    setTimeout(function(){showBiteDetail(mac);}, 5000);
}

function showBiteDetail(mac) {
    window.location.href = "showDevice/"+mac;
}

function layerMessage(msg) {
	layer.alert(msg,{icon: 2});
}
