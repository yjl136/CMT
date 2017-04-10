$(function(){
	setTimeout(function(){bite();}, 3000);
	
	setInterval(function(){bite();}, 30000);
});

function bite(){
	var dev_id = $("#dev_id").val();
	
	$.ajax({
		url: "index.php?group=maintenance&menu=bite&module=system&action=startBite",
		data:{
			"dev_id" : dev_id
		},
		dataType:"json",
		success:function(data){
			console.log(data);
			
			if(data["code"] == "success"){
				showDeviceDetail(dev_id, data["biteTime"]);
			}
		}
	});
}

function queryBiteResult(dev_id, bite_time, bite_type, call_back, retry_times){
	$.ajax({
		url: "index.php?module=device&action=queryBiteResult",
		data:{
			"dev_id" : dev_id,
			"bite_type" : bite_type,
			"bite_time" : bite_time
		},
		dataType:"json",
		success:function(data){
			console.log(data);
			
			if(data["code"] == "success"){
				call_back && call_back(data["detail"]);
			}else{
				if(retry_times == null){
					retry_times = 0;
				}else if(retry_times < 5){
					setTimeout(function(){queryBiteResult(dev_id, bite_type, bite_time, call_back, ++retry_times);}, 2000);
				}
			}
		}
	});
}

function showDeviceDetail(dev_id, bite_time){
	var dev_type = $("#dev_type").val();
	
	if(dev_type == 3 || dev_type == 4){//CMT Server
		queryBiteResult(dev_id, bite_time, 3, showApplicationList);
		queryBiteResult(dev_id, bite_time, 4, showHarddiskList);
		queryBiteResult(dev_id, bite_time, 5, showPhysicInfo);
	}else if(dev_type == 5){//ADB
		queryBiteResult(dev_id, bite_time, 1, showDevice);
	}else if(dev_type == 13){//APs
		
	}else if(dev_type == 14){//CPE
		
	}else if(dev_type == 15){//CAP

	}else if(dev_type == 1){//SMARTLCD
		queryBiteResult(dev_id, bite_time, 1, showDevice);
		queryBiteResult(dev_id, bite_time, 6, showStatusInfo);
	}
}

function showDevice(device){
	if(device){
		$("#dev_status").attr("class", device["Status"] ? "label label-success" : "label label-inverse").html(device["StatusText"]);
		$("#dev_ip").html(device["IPText"]);
		$("#dev_mac").html(device["MacText"]);
		$("#dev_uptime").html(device["RegisterDate"]);
	}
}

function showSubDevice(dev_list){
	
}

function showApplicationList(app_list){
	if(app_list){
		var content = [];
		var index = 1;
		for(var key in app_list){
			content.push("<tr>");
			content.push("<td>"+ index + "</td>");
			content.push("<td>"+key+"</td>");
			content.push("<td>"+app_list[key]["up_time"]+"</td>");
			var css = app_list[key]["state"] == '1' ? "label-success" : "label-inverse";
			content.push("<td><label class=\"label "+css+"\">" + app_list[key]["state_text"]+"</label></td>");
			content.push("</tr>");
			index++;
		}
		
		
		$("#app_list").html(content.join(""));
	}
}

function showHarddiskList(disk_list){
	if(disk_list){
		var content = [];
		for(var key in disk_list){
			content.push("<tr class='disk'>");
			content.push("<td class=\"smallText\">" + disk_list[key]["Partion"] + "</td>");
			content.push("<td><span class=\"gayColumn\"><b class=\"blueColumn\" style=\"width:" + disk_list[key]["DiskPercent"] + ";\"><i>" + disk_list[key]["DiskPercent"] + "</i></b></span></td>");
			content.push("<td class=\"smallText\">" + Trans.t("%1\$ 可用，共 %2\$", disk_list[key]["DiskAvail"], disk_list[key]["DiskTotal"])+"</td>");
			content.push("</tr>");
		}
		
		$("#disk_list").html(content.join(""));
	}
}

function showPhysicInfo(physic_info){
	if(physic_info){
		var content = [];
		for(var key in physic_info){
			content.push("<li>");
			content.push("<label>" + physic_info[key]['label'] + "：</label>");
			content.push("<span>" + physic_info[key]['value'] + "</span>");
			content.push("</li>");
		}
		$("#physic_info").html(content.join(""));
	}
}

function showStatusInfo(status_info){
	if(status_info){
		var content = [];
		for(var key in status_info){
			content.push("<li>");
			content.push("<label>" + status_info[key]['label'] + "：</label>");
			content.push("<span>" + status_info[key]['value'] + "</span>");
			content.push("</li>");
		}
		$("#status_info").html(content.join(""));
	}
}

function getCapId() {
	$(".devName > span").text
}