//状态栏刷新频率（ms）
var interval = 5000;
//CAP置换状态刷新频率（ms）
var displace_interval = 10000;
//CAP置换标识
var displace_flag = false;
//CAP置换定时查询事件
var displace_event = null;
//CAP置换提示框
var displace_loading = null;

$(document).ready(function(){
	//resetStatusWidth();
	//查询状态栏状态
	//queryStatus();
	//setInterval(function(){queryStatus();}, interval);
	//查询CAP置换状态
	queryDisplaceStatus();
	displace_event = setInterval(function(){queryDisplaceStatus();}, displace_interval);
});

//动态计算每个状态占用状态栏的宽度
function resetStatusWidth(){
	var length = $("#status_bar span").length;
	var width = $(".main").width();
	//console.log(width);
	if(length > 0){
		//左右边框共 2px
		var element_width = width/length - 2;
		//console.log(element_width);
		$("#status_bar span").css("width", element_width + "px");
	}
}

//查询所有状态
function queryStatus(){
	$.ajax({
		url : 'index.php?group=device&module=device&action=status&date='+new Date().getTime(),
		dataType : "json",
		success : function(data) {
			for(var key in data){
				$("#"+key).attr("class", (data[key] == 0 || data[key] == null) ? "ror" : "");
			}
		}
	});
}

function queryDisplaceStatus(){
	$.ajax({
		url : '/CMT/public/displaceStatus',
		success : function(data) {
			if(data == '1'){
				if(!displace_flag){
					displace_flag = true;
					displace_loading = layer.load('正在置换CAP，请稍候...');
				}
				return ;
			}else if(data == '2'){
				if(displace_loading) {
					layer.close(displace_loading);
					displace_loading = null;
				}
				displace_loading = layer.load('CAP置换完成，系统准备重启中...');
				return ;
			}else if(data == '3'){
				displace_event = clearInterval(displace_event);
			}
			displace_flag = false;
			if(displace_loading) {
				layer.close(displace_loading);
				displace_loading = null;
			}
		}
	});
}