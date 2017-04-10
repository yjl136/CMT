var refreshMillisecond = 500000;
var hideLoadingEvent = null;
var loading_dialog = null;

$(document).ready(function () {
    // 查询控制模式
   queryWifiMode();
    // 获取WiFi实时状态
    queryWifi();
    // 定时获取WiFi实时状态
  setInterval("queryWifi()", refreshMillisecond);
});

function queryWifiMode() {
    $.ajax({
        url: '/CMT/public/sysTest/queryWifiMode',
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data["code"] == "open") {// 手动模式
                console.log("remainSeconds = " + data["remainSeconds"]);
                var seconds = data["remainSeconds"];
                showWifiMode(false, seconds);
                // 查询WiFi状态
                queryWifi();
               setTimeout("queryWifiMode()", 10000);
            } else if (data["code"] == "close") {// 自动模式
                showWifiMode(true);
            } else {
                var msg =data["content"];
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
    var text = "手动模式剩余时间";
    if (seconds) {
        text = text + "(" + Math.ceil(seconds / 60) + " min)";
    }
    $("#btn_time").html(text);

    if (auto) {
        // 切换自动模式
        $("#btn_auto").addClass("on");
        $("#btn_manual").removeClass("on");

        // 禁用AP操作
        $("#ap_box li").removeClass("enable");

        // 隐藏上下电按钮
        $("#ap_box a").css("display", "none");

        // 隐藏按钮
        $("#btn_box").hide();
        $(".reset").show();
    } else {
        // 切换手动模式
        $("#btn_manual").addClass("on");
        $("#btn_auto").removeClass("on");

        // AP可操作
        $("#ap_box li").addClass("enable");

        // 显示上下电按钮
        $("#ap_box a").css("display", "inline-block");

        // 显示按钮
        $("#btn_box").show();
        //手动模式下不显示恢复出厂设置
        $(".reset").hide();
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
    showErrorMsg(false,"");
    $.ajax({
        url: '/CMT/public/sysTest/switchWifiMode/'+mode,
        dataType: "json",
		beforeSend : function() {
			//var msg = Trans.t("切换至%1$...", mode ? Trans.t("手动模式") : Trans.t("自动模式"));
			var msg ="正在切换";
			loading_dialog = layer.load(msg, 0);
		// 2分钟后关闭
		hideLoadingEvent = setTimeout(function() {
			closeLoading();
			}, 120000);
		},
        success: function (data) {
            console.log(data);
            closeLoading();
            if (data["code"] == 0) {// 自动模式
                queryWifiMode();
            } else {
                // 显示错误信息
             //   var msg = Trans.t(data["content"]);
                var msg = data["content"];
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

function queryWifi(mode, positionID) {
    $.ajax({
        url: '/CMT/public/sysTest/queryWifi',
        dataType: "json",
        success: function (data) {
            showWifi(data, mode, positionID);
        },
        error: function (data) {
            closeLoading();
        }
    });
}

function showWifi(list, mode, positionID) {
    var wifi_open = 0;
    var wifi_close = 0;
    var ap_status = null;

    $("#ap_box li").removeClass("tloading");
    if (list && list.length > 0) {
        // 更新AP的状态
        for (var key in list) {
            var name = list[key]["Name"];
            var status = list[key]["Status"];
            if (status) {
                wifi_open = wifi_open + 1;
            } else {
                wifi_close = wifi_close + 1;
            }
            if (name == ("CAP-" + positionID)) {
                ap_status = status;
            }
            if (status) {
                $("#" + name).addClass("online");
            } else {
                $("#" + name).removeClass("online");
            }

            $("#" + name + " em").html(status ? "on" : "off");
        }
    }
    // 至少一个AP在线，关闭WiFi可用
    $("#btn_close").attr("class", wifi_open > 0 ? "Buton" : "gayButon");
    // 至少一个AP离线，开启WiFi可用
    $("#btn_open").attr("class", wifi_close > 0 ? "Buton" : "gayButon");

    if (mode != null) {
        if (positionID != null && ap_status == mode) {// 如果是对单个AP上下电，该AP状态变化时，关闭loading
            // 记录操作日志
            logSwitchAP(positionID, mode, "success");
            // 关闭loading
            closeLoading();
            return;
        }
        if (mode == 1 && wifi_open > 0 && positionID == null) {// 如果是开启WiFi，在检测到WiFi开启的情况下，关闭loading
            // 关闭loading
            closeLoading();
        }
        if (mode == 0 && wifi_open == 0 && positionID == null) {// 关闭WiFi，在全部AP关闭的情况下，关闭loading
            // 关闭loading
            closeLoading();
        }
        if (hideLoadingEvent != null) {// 切换WiFi后，查询到AP的状态发生变更才停止。
            setTimeout(function () {
                queryWifi(mode, positionID);
            }, 3000);
        }
    }
}

function switchWifi(mode) {
    // 隐藏错误信息
    showErrorMsg(false);
    if (mode) {// 开启WiFi
        if ($("#btn_open").hasClass("Buton")) {
            doSwitchWifi(1);
        }
    } else {// 关闭WiFi
        if ($("#btn_close").hasClass("Buton")) {
            doSwitchWifi(0);
        }
    }
}

function doSwitchWifi(mode) {
    showErrorMsg(false);
    $.ajax({
        url: '/CMT/public/sysTest/switchWifi/'+mode,
        beforeSend: function () {
            var msg;
            if(mode){
                 msg = "正在开启wifi";
            }else{
                msg = "正在关闭wifi";
            }
            loading_dialog = layer.load(msg, 0);
            hideLoadingEvent = setTimeout(function () {
                closeLoading();
            }, 15000);
        },
        dataType: "json",
        success: function (data) {
            if (data["code"] == 0) {
                queryWifi(mode);
            } else {
                closeLoading();
                var msg = Trans.t(data["content"]);
                showErrorMsg(true, msg);
                return false;
            }
            showErrorMsg(false);
            return false;
        }
    });
}

function switchAP(positionID) {
    showErrorMsg(false);
    var id = "CAP-" + positionID;
    if ($("#btn_manual").hasClass("on")) {
        var mode = $("#" + id).hasClass("online") ? 0 : 1;
        doSwitchAP(positionID, mode);
    }
}

function doSwitchAP(positionID, mode) {
    $.ajax({
        url: '/CMT/public/sysTest/switchAP/'+mode+"/"+positionID,
        dataType: "json",
        beforeSend: function () {
            var msg =mode?'正在开启':'正在关闭';
            loading_dialog = layer.load(msg, 0);
            hideLoadingEvent = setTimeout(function () {
                logSwitchAP(positionID, mode, "timeout");
                closeLoading();
                var msg =mode?'[CAP-'+positionID+']开启超时':'[CAP-'+positionID+']关闭超时';
                showErrorMsg(true, msg);
            }, 15000);
        },
        success: function (data) {
            console.log(data);
            if (data != null) {
                if (data["code"] ==0 ){
                    closeLoading();
                    queryWifi(mode, positionID);

                } else {
                    // 记录操作日志
                    logSwitchAP(positionID, mode, "failed");
                    // 关闭Loading
                    closeLoading();
                    var msg = data["content"];
                    showErrorMsg(true, msg);
                }
            }
        }
    });
}

function logSwitchAP(positionID, mode, code) {
    $.ajax({
        url: '/CMT/public/sysTest/logOperation',
        data: {
            "mode": mode,
            "positionID": positionID,
            "code": code
        },
        dataType: "json",
        success: function (data) {
            console.log("log switch AP operation: " + data);
        }
    });
}

function sendReset() {
    //隐藏错误信息
    showErrorMsg(false);
    layer.open({
        type: 1,
        shade: [0.5, "#000"],
        shadeClose: true,
        area: ['400px', '200px'],
        title: "提示",
        content: "<div style='margin-top:30px; text-align:center;width:390px;'>" + "确定恢复出厂设置吗？确定将进行出厂恢复，成功后重启服务器，启动后2分钟将会进行CAP置换工作，系统在进行CAP置换时无法使用。" + "</div>",
        btn: ["确定", "取消"],
        btn1: function (index) {
            $.ajax({
                url: '/CMT/public/sysTest/resetFactory',
                dataType: "json",
                beforeSend: function () {
                    //正在清除提示,2分钟超时
                    var msg ="正在恢复出厂设置...";
                    loading_dialog = layer.load(msg, 0);
                },
                success: function (data) {
                    if (data["code"] == "success") {
                        var msg = "恢复出厂设置完成，等待系统重启!";
                        //$.jBox.tip(msg, "loading", {timeout : 0});
                        loading_dialog = layer.load(msg, 0);

                    } else if (data["code"] == "failure") {
                        //关闭loading
                        closeLoading();
                        //显示错误信息
                        var msg = "系统开启2分钟之后才能进行此项功能，请稍后再试!";
                        showErrorMsg(true, msg);
                        return;
                    } else {
                        //关闭loading
                        closeLoading();
                        //显示错误信息
                        var msg = "恢复出厂设置失败";
                        showErrorMsg(true, msg);
                        return;
                    }
                }
            });

            layer.close(index);
            return false;
        },
        btn2: function (index) {
            layer.close(index);
            return false;
        },
        cancel: function (index) {
            layer.close(index);
            return false;
        },
        close: function (index) {
            layer.close(index);
            return false;
        },
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