function deleteAP(id){
	$.jBox.confirm(Trans.t("确定要删除该AP吗？"), Trans.t("提示"), function(v, h, f){
		if(v == 'ok'){
			$.ajax({
				url : "index.php?group=config&menu=apconfig&module=config&action=apDelete",
				data : {
					"id" : id
				},
				dataType : "json",
				success : function(data) {
					console.log(data);
					if(data){
						$.jBox.tip(Trans.t('操作成功。'), 'success', {timeout : 1000});
						setTimeout("backToList()", 1500);
					}else{
						$.jBox.tip(Trans.t('操作失败。'), 'error', {timeout : 2000});
					}
				}
			});
		}else if(v == 'cancel'){
			
		}
		
		return true;//关闭提示框
	});
}

function saveOrUpdateAP(){
	if(!validateForm()){
		return false;
	}
	
	var id = $("#id").val();
	var url = "index.php?group=config&menu=apconfig&module=config&action=apEdit&do=save";
	if(id > 0){
		url = "index.php?group=config&menu=apconfig&module=config&action=apEdit&do=upgrade";
	}
	
	$.ajax({
		url : url,
		data : {
			"ID" : id,
			//"PositionID" : $("#positionID").val(),
			"Name" : $("#name").val(),
			"IPAddress" : $("#ip").val(),
			"Mac" : $("#mac").val(),
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			if(data){
				$.jBox.tip(Trans.t('操作成功。'), 'success', {timeout : 1000});
				setTimeout("backToList()", 1200);
			}else{
				$.jBox.tip(Trans.t('操作失败。'), 'error', {timeout : 2000});
			}
		}
	});
}

function validateForm(){
	if(!validateField($("#name"), "required")){
		return false;
	}
	
	if(!validateField($("#mac"), "mac")){
		return false;
	}
	
	return true;
}

function backToList(){
	window.location = "index.php?group=config&menu=apconfig&module=config&action=ap";
}