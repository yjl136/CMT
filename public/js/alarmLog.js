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
		shade: [0.5, "#000"],
		shadeClose: true,
		area: ['800px', '360px'],
		title: "查询条件",
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
				showFieldError("开始时间不能晚于结束时间"), $("#end_time");
				return false;
			}

			var dev_type = getDevType();
			var alarm_level = getAlarmLevel();
			var clear_status = getClearStatus();
			var start_time = $("#start_time").val();
			var end_time = $("#end_time").val();

			search(dev_type, alarm_level, clear_status, start_time, end_time);

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
	var url = "/CMT/public/alarmLog/"+dev_type+"/"+alarm_level+"/"+clear_status+"/"+start_time+"/"+end_time;
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

function showAlarmDetail(id){
/*	$.get("index.php?group=device&module=device&action=alarmDetail&id="+id, {}, function(content) {
		layer.open({
			type : 1,
			shade: [0.5, "#000"],
		    shadeClose: true,
		    area: ['600px', '300px'],
		    title: false,
			content : content
		});
	});*/
}