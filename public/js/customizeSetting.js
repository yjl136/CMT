function resetUser(){
	$.ajax({
		url : "index.php?module=reset&action=resetUser",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "success"){
				//提示操作结果
				showLayerMsg(Trans.t('操作成功'));
			}else{
				//提示错误信息
				showLayerMsg(Trans.t('操作失败'), true);
			}
		}
	});
	
	return false;
}

function clearCache(){
	$.ajax({
		url : "index.php?module=reset&action=clearCache",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "success"){
				//提示操作结果
				showLayerMsg(Trans.t('操作成功'));
			}else{
				//提示错误信息
				showLayerMsg(Trans.t('操作失败'), true);
			}
		}
	});
	
	return false;
}

function resetTimezone(){
	$.ajax({
		url : "index.php?module=reset&action=resetTimezone",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "success"){
				//提示操作结果
				showLayerMsg(Trans.t('操作成功'));
			}else{
				//提示错误信息
				showLayerMsg(Trans.t('操作失败'), true);
			}
		}
	});
	
	return false;
}

function resetDNS(){
	$.ajax({
		url : "index.php?module=reset&action=resetDNS",
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data["code"] == "success"){
				//提示操作结果
				showLayerMsg(Trans.t('操作成功'));
			}else{
				//提示错误信息
				showLayerMsg(Trans.t('操作失败'), true);
			}
		}
	});
	
	return false;
}