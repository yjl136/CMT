var loading_layer;

function checkTransWay(){
	var way = 1;
	$.ajax({
		url : "index.php?group=maintenance&menu=data&module=data&action=checkTransWay&token="+new Date().getTime(),
		data : {
			"way" : way
		},
		beforeSend : function(){
			//Loading 15分钟后关闭
			//$.jBox.tip(Trans.t('正在导入数据...'), 'loading', {timeout : 900000});
			loading_layer = layer.load(Trans.t('正在导入数据...'), 900);
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "success"){//检测传输通道成功
				//生成数据
				setTimeout(function(){importData();}, 500);
			}else{//检测传输通道失败
				//关闭Loading
				closeLoading();
				//隐藏提示说明
				$("#notebox").hide();
				//显示错误信息
				showMsg(data["msg"], "error");
			}
		}
	});
}

function importData(){
	var way = 1;
	
	$.ajax({
		url : "index.php?group=maintenance&menu=data&module=data&action=dataImport&do=import&token="+new Date().getTime(),
		data : {
			"way" : way
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			//关闭Loading
			closeLoading();
			if(data["code"] == "success"){//导出数据成功
				//隐藏提示说明
				$("#notebox").hide();
				//显示错误信息
				showMsg(data["msg"], "success");
			}else{//导出数据失败
				//隐藏提示说明
				$("#notebox").hide();
				//显示错误信息
				showMsg(data["msg"], "error");
			}
		},
		error:function(data) {
			console.log(data);
			//关闭Loading
			closeLoading();
			//隐藏提示说明
			$("#notebox").hide();
			showMsg(Trans.t("文件格式错误！"), "error");
		}
	});
}

function init(){
	$("#notebox").show();
	$("#msgbox").hide();
}

function closeLoading(){
	//关闭Loading
	//$.jBox.closeTip();
	layer.close(loading_layer);
}

