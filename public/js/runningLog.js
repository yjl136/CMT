$(function(){
	$("#dev_type a").on("click", function(){
		$("#dev_type a i").attr("class", "checkbox");
		$(this).find("i").attr("class", "checkbox_on");
	});
	
	$("#alarm_level a").on("click", function(){
		$("#alarm_level a i").attr("class", "checkbox");
		$(this).find("i").attr("class", "checkbox_on");
	});
});

function showSearchForm(){
	layer.open({
		type: 1,
		shade: [0.5, "#000"],
		shadeClose: true,
		area: ['800px', '240px'],
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
				showFieldError("开始时间不能晚于结束时间", $("#end_time"));
				return false;
			}

			var dev_type = getDevType();
			//var alarm_level = getAlarmLevel();
			var start_time = $("#start_time").val();
			var end_time = $("#end_time").val();

			search(dev_type, start_time, end_time);

			layer.close(index);
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
	return false;
}

function search(dev_type, start_time, end_time){
	var url ="/CMT/public/runningLog/"+dev_type+"/"+start_time+"/"+end_time;
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