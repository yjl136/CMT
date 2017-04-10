function deleteTwlu(id){
	//弹出确认框
	$.jBox.confirm(Trans.t("确定要删除该网络吗？"), Trans.t("提示"), function(v, h, f){
		if(v == 'ok'){//点击“确定”按钮
			$.ajax({
				url : "index.php?group=config&menu=twlu&module=config&action=twluDelete",
				data : {
					"id" : id
				},
				dataType : "json",
				success : function(data) {
					console.log(data);
					if(data){
						//提示操作结果
						$.jBox.tip(Trans.t('删除成功。'), 'success', {timeout : 1000});
						//刷新本界面
						setTimeout(function(){window.location = window.location;}, 1500);
					}else{
						//提示错误信息
						$.jBox.tip(Trans.t('删除失败。'), 'error', {timeout : 2000});
					}
				}
			});
		}
		
		return true;//关闭提示框
	});
}

function updateTwlu(){
	if(!validateForm()){
		return false;
	}
	
	$.ajax({
		url : "index.php?group=config&menu=twlu&module=config&action=twluEdit&do=upgrade",
		data : {
			"ID" : $("#id").val(),
			"SSID" : $("#ssid").val(),
			"SecureMode" : $("#securemode").val(),
			"Password" : $("#password").val(),
			"IPMode" : $("#ipmode").val(),
			"Gateway" : $("#gateway").val(),
			"Netmask" : $("#netmask").val(),
			"DNS" : $("#dns").val(),
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data){
				//提示操作结果
				$.jBox.tip(Trans.t('操作成功。'), 'success', {timeout : 1000});
				//跳转到用户列表界面
				setTimeout("backToList()", 1000);
			}else{
				//提示错误信息
				$.jBox.tip(Trans.t('操作失败。'), 'error', {timeout : 2000});
			}
		}
	});
	return false;
}

function validateForm(){
	if(!validateField($("#ssid"), "required")){
		return false;
	}
	if(!validateField($("#password"), "required")){
		return false;
	}
	if(!validateField($("#gateway"), "ip")){
		return false;
	}
	if(!validateField($("#netmask"), "ip")){
		return false;
	}
	if(!validateField($("#dns"), "ip")){
		return false;
	}
	return true;
}

function backToList(){
	window.location = 'index.php?group=config&menu=twlu&module=config&action=twlu';
}