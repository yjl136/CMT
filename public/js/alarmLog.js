$(function(){
	$("#dev_type a").on("click", function(){
		$("#dev_type a i").attr("class", "checkbox");
		$(this).find("i").attr("class", "checkbox_on");
	});
	
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
		skin: 'layui-layer-rim', //加上边框
		area: ['650px', '400px'], //宽高
		title: "查询条件",
		shade: [0.5, "#000"],
		shadeClose: true,
        content: $('#searchForm'),
		btn:["查询", "取消"],
		btn1:function(index){
			if(!validateField($("#start_time"), "datetime")){
				return false;
			}
			if(!validateField($("#end_time"), "datetime")){
				return false;
			}
			if($("#start_time").val() > $("#end_time").val()){
				showFieldError("开始时间不能晚于结束时间", $("#end_time"));
				return false;
			}
			var content = $("#content").val();
			var start_time = $("#start_time").val();
			var end_time = $("#end_time").val();
			search(content, start_time, end_time);
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

function search(dev_type, alarm_level, clear_status, start_time, end_time){
	var url = "index.php?group=system&menu=log&module=syslog&action=alarmLog";
	
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

function getDevType(){
	var dev_type = 0;
	$("#dev_type a i").each(function(index){
		if(this.className == "checkbox_on"){
			dev_type = this.id;
		}
	});
	return dev_type;
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

function showAlarmDetail(id){
	$.get("index.php?group=device&module=device&action=alarmDetail&id="+id, {}, function(content) {
		layer.open({
			type : 1,
			shade: [0.5, "#000"],
		    shadeClose: true,
		    area: ['600px', '300px'],
		    title: false,
			content : content
		});
	});
}