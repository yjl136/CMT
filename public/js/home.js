var freshIntervalTime = 5000;

$(function(){
	//setInterval("queryAllDeviceStatus()", freshIntervalTime);
	//setInterval("queryDashboardInfo()", freshIntervalTime);
	setInterval(function(){update_self();}, freshIntervalTime);
});

function update_self(){
	update_devicelist_status();
	update_flight_status();
}

function update_devicelist_status(){
	queryAllDeviceStatus();
}

function update_flight_status(){
	queryDashboardInfo();
}

function queryAllDeviceStatus() {
	$.ajax({
		url : "index.php?group=device&module=device&action=AsynDeviceStatus",//allDeviceStatus->DeviceStatus
		dataType: "json",
		success: function(data){
			console.log(data);
			showAllDeviceStatus(data);
		}
	});
}

function queryDashboardInfo() {
	$.ajax({
		url : "index.php?group=device&module=device&action=dashboardInfo",
		dataType: "json",
		success: function(data){
			console.log(data);
			showDashboardInfo(data);
		}
	});
}

function device_to_imagefile(name){
	switch(name.toLowerCase()){
		case "cmt": return "cmt.png";
		case "server": return "server.png";
		case "cap-1":
		case "cap-2":
		case "cap-3": return "cap.png";
		default: return "";
	}
}


function str_capitalize(data){
	if (data.length == 1){
		return 	data[0].toUpperCase();
	}
	return data[0].toUpperCase() + data.substring(1).toLowerCase();
}

function devicename_wrapper(name){
	if (name == "SERVER"){
		return str_capitalize(name);
	}else{
		return name;
	}
}

function showAllDeviceStatus(device_list){
	if(device_list){
		console.log(device_list);
		var content = [];
		var state = "";
		var devid = "";
		var img = "";
		var url = "";
		content.push("<ul>");
		for(var key in device_list){
			state = (device_list[key]["status"] == 1) ? "" : "ror";
			devid = device_list[key]["devid"];

			content.push("<li class='" + state + "'>");
			if (devid.indexOf("*:*:*") >= 0 ){
				url = "#";
			} else {
				url = "index.php?group=device&module=device&action=detail&dev_id=" + devid;
			}
			content.push("<a href='#' onclick='showDevice(this, " + "\"" + url + "\"" + ");'>" );
			content.push("<i></i>");
			img = "style/img/" + device_to_imagefile(key).toLowerCase();
			content.push("<img src='" + img + "'/>");
			content.push("<span>" + devicename_wrapper(key.toUpperCase()) + "</span>");
			content.push("</a></li>");
		}
		content.push("</ul>");
		$("#deviceStatusList").html(content.join(""));
	}
}

function showDashboardInfo(dashboard_data){
	if(dashboard_data){
		console.log(dashboard_data);
		$("#altitude").text(dashboard_data["altitude"]);
		$("#airspeed").text(dashboard_data["airspeed"]);
		$("#longitude").text(dashboard_data["longitude"]);
		$("#latitude").text(dashboard_data["latitude"]);
	}

}

function showDevice(element, url){
	if($(element).parent().hasClass("ror")){
		layer.open({
			type : 1,
			shade: [0.5, "#000"],
			shadeClose: true,
			area: ['400px', '200px'],
			title: Trans.t("提示"),
			content : '<p style="color:red;text-align: center;line-height: 100px;">设备离线，无法查看详情！</p>',
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

function formatValue(value) {
	if (value == "altitude") {
		return Trans.t("高度");
	} else if (value == "airspeed") {
		return Trans.t("空速");
	} else if (value == "latitude") {
		return Trans.t("经度");
	} else if (value == "longitude") {
		return Trans.t("纬度");
	} else if (value == "groundspeed") {
		return Trans.t("地速");
	}
}


