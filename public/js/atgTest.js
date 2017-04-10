var refreshMillisecond = 5000;
var hideLoadingEvent = null;
var loading_dialog = null;

$(document).ready(function() {
	// 查询控制模式
	queryWifiMode();

	// 获取WiFi实时状态
	queryATG();

	// 定时获取WiFi实时状态
	setInterval("queryATG()", refreshMillisecond);
});

function queryWifiMode() {
	$.ajax({
		url : 'index.php?group=maintenance&module=system&action=queryWifiMode',
		dataType : "json",
		success : function(data) {
			console.log(data);
			if (data["code"] == "open") {// 手动模式
				console.log("remainSeconds = " + data["remainSeconds"]);
				var seconds = data["remainSeconds"];
				showWifiMode(false, seconds);

				// 查询WiFi状态
				queryATG();

				setTimeout("queryWifiMode()", 10000);
			} else if (data["code"] == "close") {// 自动模式
				showWifiMode(true);
			} else {
				// 显示错误信息
				var msg = Trans.t(data["content"]);
				showErrorMsg(true, msg);

				setTimeout("queryWifiMode()", 5000);
				return;
			}
			// 隐藏错误信息
			showErrorMsg(false);
		}
	});
}

function showWifiMode(auto, seconds) {
	var text = Trans.t("手动模式剩余时间");
	if (seconds) {
		text = text + "(" + Math.ceil(seconds / 60) + " min)";
	}
	$("#btn_time").html(text);

	if (auto) {
		// 切换自动模式
		$("#btn_auto").addClass("on");
		$("#btn_manual").removeClass("on");

		// 禁用ATG操作
		$("#ap_box li").removeClass("enable");

		// 隐藏上下电按钮
		$("#ap_box a").css("display", "none");

		// 隐藏按钮
		$("#btn_box").hide();
	} else {
		// 切换手动模式
		$("#btn_manual").addClass("on");
		$("#btn_auto").removeClass("on");

		// ATG可操作
		$("#ap_box li").addClass("enable");

		// 显示上下电按钮
		$("#ap_box a").css("display", "inline-block");

		// 显示按钮
		$("#btn_box").show();
	}
}

function switchWifiMode(manual) {
	if (manual) {
		if (!$("#btn_manual").hasClass("on")) {
			doSwitchWifiMode(1);
		}
	} else {
		if (!$("#btn_auto").hasClass("on")) {
			doSwitchWifiMode(0);
		}
	}
}

function doSwitchWifiMode(mode) {
	// 隐藏错误信息
	showErrorMsg(false);

	var url = 'index.php?group=maintenance&module=system&action=switchWifiMode';
	$.ajax({
		url : url,
		data : {
			"mode" : mode,
		},
		dataType : "json",
		success : function(data) {
			console.log(data);

			// 关闭loading
			//closeLoading();
			if (data["code"] == 0) {// 自动模式
				queryWifiMode();
			} else {
				// 显示错误信息
				var msg = Trans.t(data["content"]);
				showErrorMsg(true, msg);

				return;
			}

			// 隐藏错误信息
			showErrorMsg(false);
		}
	});
}

function forceSwitchMode() {
	// 强制切换到手动模式以续时
	doSwitchWifiMode(1);
}

function queryATG(mode) {
	$.ajax({
		url : 'index.php?group=maintenance&module=system&action=atgTest&do=query',
		dataType : "json",
		success : function(data) {
			console.log(data);
			showATGStatus(data, mode);
		}
	});
}

function showATGStatus(cpe, mode) {
	console.log("showATGStatus " + mode);

	var atg_status = null;
	
	$("#ap_box li").removeClass("tloading");
	if (cpe) {
		// 更新ATG的状态
		var name = cpe["Name"];
		var status = cpe["Status"];
		atg_status = status;
		
		if (status) {
			$("#" + name).addClass("online");
		} else {
			$("#" + name).removeClass("online");
		}
		
		$("#" + name + " em").html(status ? "on" : "off");
	}

	if (mode != null) {
		if (atg_status == mode) {// 如果是对单个ATG上下电，该ATG状态变化时，关闭loading
			// 记录操作日志
			logSwitchATG(mode, "success");

			// 关闭loading
			closeLoading();
			return;
		}

		if (hideLoadingEvent != null) {// 切换WiFi后，查询到ATG的状态发生变更才停止。
			setTimeout(function() { queryATG(mode); }, 3000);
		}
	}
}

function switchATG() {
	// 隐藏错误信息
	showErrorMsg(false);

	if ($("#btn_manual").hasClass("on")) {// 手动模式
		var mode = $("#CPE").hasClass("online") ? 0 : 1;
		doSwitchATG(mode);
	}
}

function doSwitchATG(mode) {
	$.ajax({
		url : 'index.php?group=maintenance&module=system&action=switchATG',
		data : {
			"mode" : mode,
		},
		dataType : "json",
		beforeSend : function() {
			var msg = Trans.t("正在%1$...", mode ? Trans.t("开启") : Trans.t("关闭"));
			loading_dialog = layer.load(msg, 0);

			// 2分钟后自动关闭Loading
			hideLoadingEvent = setTimeout(function() {
				// 记录操作日志
				logSwitchATG(mode, "timeout");

				// 关闭Loading
				closeLoading();

				// 显示错误信息
				var msg = Trans.t("CPE%1$超时", mode ? Trans.t("开启") : Trans.t("关闭"));
				showErrorMsg(true, msg);
			}, 120000);
		},
		success : function(data) {
			console.log(data);
			if (data != null) {
				if (data["code"] == 0) {
					// 查询指定位置的ATG状态是否更新，更新后关闭loading
					queryATG(mode);
				} else {
					// 记录操作日志
					logSwitchATG(mode, "failed");

					// 关闭Loading
					closeLoading();

					// 显示错误信息
					var msg = Trans.t(data["content"]);
					showErrorMsg(true, msg);
				}
			}
		}
	});
}

function logSwitchATG(mode, code) {
	$.ajax({
		url : 'index.php?group=maintenance&module=system&action=logOperation',
		data : {
			"mode" : mode,
			"code" : code,
			"type" : "ATG"
		},
		dataType : "json",
		success : function(data) {
			console.log("log switch ATG operation: " + data);
		}
	});
}

function showErrorMsg(display, msg) {
	if (display) {
		$("#msg").html(msg);
		$("#msgbox").show();
	} else {
		$("#msgbox").hide();
	}
}

function closeLoading() {
	layer.close(loading_dialog);
	
	if (hideLoadingEvent) {
		clearTimeout(hideLoadingEvent);
		hideLoadingEvent = null;
	}
}