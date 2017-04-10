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

function showSearchForm(){
	layer.open({
	    type: 1,
	    shade: [0.5, "#000"],
	    shadeClose: true,
	    area: ['800px', '315px'],
	    title: Trans.t("查询条件"),
	    content: $('#searchForm'),
	    btn:[Trans.t("查询"), Trans.t("取消")],
	    btn1:function(index){
	    	if(!validateField($("#start_time"), "datetime")){
	    		return false;
	    	}
	    	
	    	if(!validateField($("#end_time"), "datetime")){
	    		return false;
	    	}
	    	
	    	if($("#start_time").val() > $("#end_time").val()){
	    		showFieldError(Trans.t("开始时间不能晚于结束时间"), $("#end_time"));
	    		return false;
	    	}
	    	
	    	var dev_id = $("#dev_id").val();
	    	var dev_type = $("#dev_type").val();
	    	var clear_status = getClearStatus();
	    	var alarm_level = getAlarmLevel();
	    	var start_time = $("#start_time").val();
	    	var end_time = $("#end_time").val();
	    	
	    	search(dev_id, dev_type, alarm_level, clear_status, start_time, end_time);
	    	
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

function search(dev_id, dev_type, alarm_level, clear_status, start_time, end_time){
	var url = getUrl();
	
	if(dev_id){
		url += "&dev_id=" + dev_id;
	}
	if(dev_type){
		url += "&dev_type=" + dev_type;
	}
	if(alarm_level){
		url += "&alarm_level=" + alarm_level;
	}
	if(clear_status != null){
		url += "&clear_status=" + clear_status;
	}
	if(start_time){
		url += "&start_time=" + start_time;
	}
	if(end_time){
		url += "&end_time=" + end_time;
	}
	window.location.href = url;
}

function getAlarmLevel(){
	var alarm_level = 0;
	$("#alarm_level a i").each(function(index){
		if(this.className == "checkbox_on"){
			alarm_level = index;
		}
	});
	return alarm_level;
}

function getClearStatus(){
	var clear_status = null;
	$("#clear_status a i").each(function(index){
		if(this.className == "checkbox_on"){
			clear_status = index;
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
}