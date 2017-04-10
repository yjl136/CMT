$(function(){
	queryDeviceStatus();
	
	//定时30s后重复查询
	setInterval(function(){queryDeviceStatus();}, 5000);
});

function queryDeviceStatus(){
	$.ajax({
		url : "index.php?group=home&module=device&action=deviceStatus",
		dataType : "json",
		success : function(data){
			console.log(JSON.stringify(data));
			if(data != null){
				for(var key in data){
					showDevice(key, data[key]);
				}
			}
		}
	});
}

function showDevice(id, status){
	if($("#"+id).length > 0){//标签存在
		$("#"+id).attr("class", status ? id : (id+"_"));
	}
}

function showDeviceDetail(element, url){
	var css_name = $(element).attr("class");
	if(css_name.indexOf("_") > 0){
		layer.open({
			type : 1,
			shade: [0.5, "#000"],
		    shadeClose: true,
		    area: ['400px', '200px'],
		    title: Trans.t("提示"),
			content : $('#dev_offline_prompt'),
			btn:[Trans.t("关闭")],
		    btn1:function(index){
		    	layer.close(index);
		    	return false;
		    }
		});
	}else{
		window.location.href = url;
	}
}