$(function(){
	$("#alarm_level a").on("click", function(){
		$("#alarm_level a i").attr("class", "checkbox");
		$(this).find("i").attr("class", "checkbox_on");
	});
	$("#clear_status a").on("click", function(){
		$("#clear_status a i").attr("class", "checkbox");
		$(this).find("i").attr("class", "checkbox_on");
	});
});

function showSearchForm(mac,flag){
	layer.open({
	    type: 1,
	    shade: [0.5, "#000"],
	    shadeClose: true,
	    area: ['800px', '360px'],
	    title: "查询条件",
	    content: $('#searchForm'),
	    btn:["查询", "取消"],
	    btn1:function(index){
			var start_time = $("#start_time").val();
			var end_time = $("#end_time").val();
			if (start_time != '' && end_time != '') {
				if (!validateField($("#start_time"), "datetime")) {
					return false;
				}
				if (!validateField($("#end_time"), "datetime")) {
					return false;
				}
				if ($("#start_time").val() > $("#end_time").val()) {
					showFieldError("开始时间不能晚于结束时间"), $("#end_time");
					return false;
				}
			} else {
				start_time = 'start_time';
				end_time = 'end_time';
			}
	    	var clear_status = getClearStatus();
	    	var alarm_level = getAlarmLevel();
	    	search(mac,flag,alarm_level, clear_status, start_time, end_time);
	    	layer.close(index);
	    	return false;
	    },
	    btn2 : function(index){
	    	clearError();
	    	layer.close(index);
	    },
	    cancel:function(index){
	    	clearError();
	    	layer.close(index);
	    },
	    close:function(index){
	    	clearError();
	    	layer.close(index);
	    }
	});
}

function search(mac,flag,alarm_level, clear_status, start_time, end_time){
	var url = "";
	if(flag=="super"){
		 url = "/CMT/public/showDevice/"+mac+"/alarm/"+alarm_level+"/"+clear_status+"/"+start_time+"/"+end_time;
	}else{
		url = "/CMT/public/maintenance/showDevice/"+mac+"/alarm/"+alarm_level+"/"+clear_status+"/"+start_time+"/"+end_time;
	}

	window.location.href = url;
}

function getAlarmLevel(){
	var alarm_level = 0;
	$("#alarm_level a i").each(function(index){
		if(this.className == "checkbox_on"){
			alarm_level = this.id;
		}
	});
	return alarm_level;
}

function getClearStatus(){
	var clear_status = null;
	$("#clear_status a i").each(function(index){
		if(this.className == "checkbox_on"){
			clear_status = this.id;
		}
	});
	return clear_status;
}

function getUrl(){
	var url = "index.php?group=device&module=device&action=alarm";
	$("#cate_list a i").each(function(index){
		if(this.className == "checkbox_on"){
			url = $(this).parent().attr("href");
		}
	});
	return url;
}

function showAlarmDetail(id){
/*	
	$.get("index.php?group=device&module=device&action=alarmDetail&id="+id, {}, function(content) {
		layer.open({
			type : 1,
			shade: [0.5, "#000"],
		    shadeClose: true,
		    area: ['600px', '360px'],
		    title: false,
			content : content
		});
	});
*/	
}