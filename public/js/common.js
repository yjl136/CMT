function showMsg(msg, type, action, text, func){
	//清空原错误信息
	$("#msgbox").html('');
/*	$("#msgbox").html("commmm");
	$("#msgbox").show();*/
	action = action ? action : "error";
	var url = "/CMT/public/common/"+action;
	$.ajax({
		url : url,
		data : {
			"type" : type,
			"msg" : msg,
			"text" : text,
			"func" : func,
		},
		success : function(data) {
			$("#msgbox").html(data);
			$("#msgbox").show();
		}
	});
}

function showMenuGroup(group){
	console.log(group);
	$(".topMenu li").removeClass("on");
	$("."+group).parent().addClass("on");
}