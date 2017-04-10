function init(){
	$("#notebox").show();
	$("#msgbox").hide();
}

var backup_loading = null;

function backup(){
	$.ajax({
		url : "/CMT/public/sysBackup/backup",
		dataType : "json",
		global : false,
		beforeSend : function(){
			//弹出加载框
			//$.jBox.tip(Trans.t('正在进行系统备份......'), 'loading', {timeout : 0});
		//	backup_loading = layer.load(Trans.t('正在进行系统备份......'), 0);
			backup_loading = layer.load('正在进行系统备份......', 0);
		},
		success : function(data) {
			console.log(data);
			if(data && data['code'] == 1){//发送系统备份信令成功
				queryBackupProgress();
			}else{
				//关闭加载框
				//$.jBox.closeTip();
				layer.close(backup_loading);
				//隐藏提示说明
				$("#notebox").hide();
				//提示错误信息
			//	showMsg(Trans.t('系统备份失败!') + ' ' + data['msg'], 'error');
				showMsg('系统备份失败!' + ' ' + data['msg'], 'error');
				//$.jBox.tip(Trans.t('系统备份失败!') + data['msg'], 'error', {timeout : 2000});
			}
		}
	});
}

function queryBackupProgress(){
	$.ajax({
		url : "/CMT/public/sysBackup/"+"query",
		dataType : "json",
		global : false,
		success : function(data) {
			console.log(data);
			if(data && data['code'] == 1){//备份成功
				//关闭加载框
				//$.jBox.closeTip();
				layer.close(backup_loading);
				
				//隐藏提示说明
				$("#notebox").hide();
				//显示结果信息
				showMsg(data['msg'], 'success');
				//setTimeout(function(){$.jBox.tip(data['msg'], 'success', {timeout : 2000});}, 1000);
			}else if(data['code'] == 1){//备份中
				//5s后继续查询
				setTimeout("queryBackupProgress()", 5000);
			}else{
				//关闭加载框
				//$.jBox.closeTip();
				layer.close(backup_loading);
				//隐藏提示说明
				$("#notebox").hide();
				//提示错误信息
				showMsg(Trans.t('系统备份失败!') + ' ' + data['msg'], 'error');
				//$.jBox.tip(Trans.t('系统备份失败!') + data['msg'], 'error', {timeout : 2000});
			}
		}
	});
}