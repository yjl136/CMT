$(document).ready(function(){
	queryGraphs();
});

function queryGraphs(index){
	var dev_id = $("#dev_id").val();
	//var dev_type = getDevType();
	var graph_type = getGraphType();
	var period = getPeriod();
	if(index == null){
		index = 0;
	}
	
	$.ajax({
		url : "index.php?group=system&module=device&action=graphUrls",
		data : {
			"dev_id" : dev_id,
			//"dev_type" : dev_type,
			"graph_type" : graph_type,
			"time_period" : period
		},
		dataType : "json",
		beforeSend : function(){
			$.jBox.tip(Trans.t("加载中..."), "loading", {timeout:3000});
		},
		success : function(data) {
			console.log(data);
			if(data && data.length > 0){
				// URL总数
				var total = data.length;
				if(index > total - 1){
					index = total - 1
				}
				if(index < 0){
					index = 0;
				}
				var current = index + 1;
				// 当前URL
				var url = data[index];
				var content = buildImgBox(url, index, total);
				$("#imgbox").html(content);
				if(total > 1){
					$(".prev").show();
					$(".next").show();
					$(".num em").html(current);
					$(".num span").html(total);
					$(".num").show();
				}else{
					$(".prev").hide();
					$(".next").hide();
					$(".num").hide();
				}
			}else{
				$("#imgbox").html(Trans.t("无此类图形监控"));
				$(".prev").hide();
				$(".next").hide();
				$(".num").hide();
			}
		}
	});
	
	return false;
}

function buildImgBox(url, index, total){
	console.log("url="+url);
	console.log("index="+index);
	console.log("total="+total);
	var content = "";
	content += '<a class="prev" href="#" onclick="queryGraphs('+(index-1)+')"></a>';
	content += '<p>';
	content += '	<img src="'+url+'" />';
	content += '</p>';
	content += '<a class="next" href="#" onclick="queryGraphs('+(index+1)+')"></a>';
	return content;
}

function changeDevType(dev_type){
	$("#devtypebox i").attr("class", "checkbox");
	$("#dev_"+dev_type).attr("class", "checkbox_on");
	
	queryGraphs();
	return false;
}

function changeGraphType(graph_type){
	$("#graphtypebox i").attr("class", "checkbox");
	$("#graph_"+graph_type).attr("class", "checkbox_on");
	
	queryGraphs();
	return false;
}

function changePeriod(period){
	$("#periodbox i").attr("class", "checkbox");
	$("#period_"+period).attr("class", "checkbox_on");
	
	queryGraphs();
	return false;
}

function getDevType(){
	var id = $("#devtypebox .checkbox_on").attr("id");
	console.log(id);
	if(id){
		return id.replace(/dev_/g, "");
	}else{
		return null;
	}
}

function getGraphType(){
	var id = $("#graphtypebox .checkbox_on").attr("id");
	if(id){
		return id.replace(/graph_/g, "");
	}else{
		return null;
	}
}

function getPeriod(){
	var id = $("#periodbox .checkbox_on").attr("id");
	if(id){
		return id.replace(/period_/g, "");
	}else{
		return null;
	}
}

