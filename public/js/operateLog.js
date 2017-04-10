
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

function search(content, start_time, end_time){
	var url = "index.php?group=system&menu=log&module=syslog&action=operateLog";
	
	if(content){
		url += "&content=" + content;
	}
	if(start_time){
		url += "&start_time=" + start_time;
	}
	if(end_time){
		url += "&end_time=" + end_time;
	}
	window.location.href = url;
}