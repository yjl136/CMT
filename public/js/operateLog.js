
function showSearchForm(flag){
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
			var content = $("#content").val();
			var start_time = $("#start_time").val();
			var end_time = $("#end_time").val();
			if(start_time=='' && end_time == '' && content==''){
				showFieldError("查询条件不能全为空", $("#end_time"));
				return false;
			}
			if(content == null || content == ''){
				content = 'all';
			}
			if(start_time!='' && end_time != ''){
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
			}
			else{
			/*	Date.prototype.Format = function (fmt) {
					var o = {
						"M+": this.getMonth() + 1,
						"d+": this.getDate(),
						"h+": this.getHours(),
						"m+": this.getMinutes(),
						"s+": this.getSeconds(),
						"q+": Math.floor((this.getMonth() + 3) / 3),
						"S": this.getMilliseconds()
					};
					if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
					for (var k in o)
						if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
					return fmt;
				}
				start_time = new Date().Format("yyyy-MM-dd");
				end_time = new Date().Format("yyyy-MM-dd HH:mm:ss");*/

				start_time = 'start_time';
				end_time = 'end_time';
			}


			search(flag,content, start_time, end_time);
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

function search(flag,content, start_time, end_time){
	//var url = "/CMT/public/operateLog?group=system&menu=log&module=syslog&action=operateLog";
	var url = "";
	if(flag=="super"){
		 url = "/CMT/public/operateLog/"+content+"/"+start_time+"/"+end_time;
	}else{
		 url = "/CMT/public/maintenance/operateLog/"+content+"/"+start_time+"/"+end_time;
	}
	window.location.href = url;
}