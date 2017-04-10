var retry_times = 0;
var loading_dialog = null;
$(function () {
    //传输方式单选框点击事件
    $("#transWayBox > a").on("click", function () {
        var element = this;
        $("#transWayBox > a > i").each(function () {
            if (this.parentNode == element) {
                this.className = "checkbox_on";
            } else {
                this.className = "checkbox";
            }
        });

        return false;
    });

    //内容类型多选框点击事件
    $("#contentTypeBox > a").on("click", function () {
        var element = $(this).children("i");
        if (element.hasClass("checkboxDb_on")) {
            element.attr("class", "checkboxDb");
        } else {
            element.attr("class", "checkboxDb_on");
        }
        return false;
    });

    //导出格式单选框点击事件
    $("#formatTypeBox > a").on("click", function () {
        var element = this;
        $("#formatTypeBox > a > i").each(function () {
            if (this.parentNode == element) {
                this.className = "checkbox_on";
            } else {
                this.className = "checkbox";
            }
        });

        return false;
    });
});

function init() {
    //跳转到第一步
    changeProgBar(1);
    $("#conditionBox").show();
    $("#msgbox").hide();
}

function exportData() {
    var way = getTransWay();
    var format_type = getFormatType();
    var content_type = getContentType();
    var start_time = $("#startTime").val();
    var end_time = $("#endTime").val();
    $.ajax({
       url: "/CMT/public/dataExport/exportData/" + way + "/" + format_type + "/" + start_time + "/" + end_time,
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data["code"] == "1") {
                //导出成功
                layer.close(loading_dialog);
                changeProgBar(2);
                $("#conditionBox").hide();
                showMsg(data["msg"], "success");
                //setTimeout(function(){queryProgress();}, 500);
            } else {
                layer.close(loading_dialog);
                changeProgBar(2);
                $("#conditionBox").hide();
                showMsg(data["msg"], "error");
            }
        },
        error: function (data) {
            console.log(data);
            layer.close(loading_dialog);
            changeProgBar(2);
            $("#conditionBox").hide();
            //showMsg(Trans.t("导出数据超时！"), "error");
            showMsg("导出数据超时！", "error");
        }
    });
}

function queryProgress() {
    var way = getTransWay();
    var format_type = getFormatType();
    var content_type = getContentType();
    var start_time = $("#startTime").val();
    var end_time = $("#endTime").val();
    $.ajax({
        url: "/CMT/public/dataExport/queryProgress/" + way + "/" + content_type + "/" + format_type + "/" + start_time + "/" + end_time,

        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data["code"] == 1) {
                layer.close(loading_dialog);
                changeProgBar(2);
                $("#conditionBox").hide();
                showMsg(data["msg"], "success");
                retry_times = 0;
                setTimeout(function () {
                    logExport();
                }, 1000);
            } else {
                layer.close(loading_dialog);
                changeProgBar(2);
                $("#conditionBox").hide();
                showMsg(data["msg"], "error");
                setTimeout(function () {
                    logExport();
                }, 1000);
            }
        }
    });
}

function checkTransWay() {
    var way = getTransWay();
    var format_type = getFormatType();
    var end_time = $("#endTime").val();
    var start_time = $("#startTime").val();
    if (format_type == 0) {
        showFieldError("至少选择一项格式", $("#formatTypeBox"));
        return false;
    }
    if (!validateField($("#startTime"), "date")) {
        return false;
    }
    if (!validateField($("#endTime"), "date")) {
        return false;
    }
    // TODO compare date
    if ($("#startTime").val() > $("#endTime").val()) {
        showFieldError("开始日期不能晚于结束日期", $("#endTime"));
        return false;
    }
    $.ajax({
            url: "/CMT/public/dataExport/checkTransWay/" + way,
            dataType: "json",
            beforeSend: function () {
                loading_dialog = layer.load('正在导出数据...', 900);
            },
            success: function (data) {
                console.log(data);
                if (data["code"] == "1") {// 检测成功
                    // 尝试向USB插入数据测试读写
                    if (way == 1 || way == '1') {
                        setTimeout(function () {
                            exportData();
                        }, 5000);//50s->5s
                    } else {
                        setTimeout(function () {
                            exportData();
                        }, 500);
                    }
                } else {// 检测失败
                    // 关闭Loading
                    layer.close(loading_dialog);
                    // 跳转到第二步
                    changeProgBar(2);
                    // 隐藏条件框
                    $("#conditionBox").hide();
                    // 显示错误信息
                    showMsg(data["msg"], "error");
                }
            }

        });
}

function attemptWriteFile() {
    $.ajax({
        url: "index.php?group=maintenance&menu=data&module=data&action=attemptWriteFile&token=" + new Date().getTime(),
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data["code"] == "success") {// 写入文件成功
                // 重置超时条件
                retry_times = 0;
                // 执行导出
                setTimeout(function () {
                    exportData();
                }, 500);
            } else if (data["code"] == "failure") {
                if (retry_times++ < 20) {
                    // 每隔5s查询一次，直到查询成功为止
                    setTimeout(function () {
                        attemptWriteFile();
                    }, 5000);
                } else {
                    // 关闭Loading
                    layer.close(loading_dialog);
                    // 跳转到第二步
                    changeProgBar(2);
                    // 隐藏条件框
                    $("#conditionBox").hide();
                    // 显示错误信息
                    showMsg(Trans.t("数据导出失败"), "error");
                    // 重置超时条件
                    retry_times = 0;
                    // 记录操作日志
                    //setTimeout(function(){logExport();}, 1000);
                }
            }
        }
    });
}

function logExport() {
    $.ajax({
        url: "index.php?group=maintenance&menu=data&module=data&action=logExport&token=" + new Date().getTime(),
        dataType: "json",
        success: function (data) {
            console.log(data);
        }
    });
}

function changeProgBar(step) {
    if (step == 1) {
        $("#step1").addClass("on");
        $("#step2").removeClass("on");
        $("#progBar").removeClass("x2").addClass("x1");
    } else if (step == 2) {
        $("#step1").removeClass("on");
        $("#step2").addClass("on");
        $("#progBar").removeClass("x1").addClass("x2");
    }
}

function getTransWay() {
    var way = 0;
    $("#transWayBox > a > i").each(function (index) {
        if (this.className == "checkbox_on") {
            way = this.id;
        }
    });
    console.log("trans way = " + way);
    return way;
}

function getContentType() {
    var type = 0;
    $("#contentTypeBox > a > i").each(function (index) {
        if (this.className == "checkboxDb_on") {
            type = this.id;
        }
    });
    console.log("content type = " + type);
    return type;
}

function getFormatType() {
    var type = 0;
    $("#formatTypeBox > a > i").each(function (index) {
        if (this.className == "checkbox_on") {
            var id = this.getAttribute('id');
            var value = parseInt(id.replace(/format_type_/g, ""));
            type = type + value;
        }
    });
    console.log("format type = " + type);
    return type;
}
