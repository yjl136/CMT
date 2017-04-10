function rebootDevice(dev_type, dev_position){
	//隐藏错误消息
	showErrorMsg(false);
	
	$.ajax({
		url : "index.php?module=system&action=devReboot&do=reboot",
		data : {
			"dev_type" : dev_type,
			"dev_position" : dev_position
			
		},
		dataType : "json",
		beforeSend : function(){
			//$.jBox.tip(Trans.t("正在自检..."), "loading", {timeout:30000});
			bite_loading = layer.load(Trans.t("准备重启..."), 30);
		},
		success : function(data) {
			console.log(data);
			if(data['code'] == "success"){
				layer.close(bite_loading);
				
				bite_loading = layer.load(Trans.t("正在重启..."), 120);
			}else{
				//$.jBox.closeTip();
				if(bite_loading){
					layer.close(bite_loading);
					bite_loading = null;
				}
				
				//提示错误信息
				showErrorMsg(true, data['msg']);
			}
		}
	});
	
	return false;
}

function showErrorMsg(display, msg){
	if(display){
		$("#msg").html(msg);
		$("#msgbox").show();
	}else{
		$("#msgbox").hide();
	}
}
