/**
 * Created by Administrator on 2016/7/20.
 */
var loading_dialog = null;
$(function () {
    //传输协议单选框点击事件
    $("#autoExportTactics > a").on("click", function () {
        var element = this;
        $("#autoExportTactics > a > i").each(function () {
            if (this.parentNode == element) {
                this.className = "checkbox_on";
            } else {
                this.className = "checkbox";
            }
        });

        return false;
    });
});

function checkTransWay() {
    var exportTactics = 0;
    var exportDays = getExportDays();

    var exportWeeks = getExportWeeks();

    var exportMonths = getExportMonths();

    var exportInputChecked = getExportInputChecked();
    $.ajax({
        url: "/CMT/public/autoExport/autoExportConfig/" + exportTactics + "/" + exportDays + "/" + exportWeeks + "/" + exportMonths + "/" + exportInputChecked,
        dataType: "json",
        success: function (data) {
            setTimeout(function () {
                backToAutoExport();
            }, 100);
            // showLayerMsg(Trans.t('修改成功'));
            showLayerMsg('修改成功');
        },
        error: function (data) {
            //提示错误信息

            //showLayerMsg(Trans.t('修改失败'), true);
            showLayerMsg('修改失败', true);
        }

    });
}
function showLayerMsg(msg, error) {
    layer.msg(msg, {
        icon: (error ? 2 : 1),
        time: 2000
    });
}
function getExportTactics() {
    var type = 0;
    $("#autoExportTactics > a > i").each(function (index) {
        if (this.className == "checkbox_on") {
            var id = this.getAttribute('id');
            console.log("is happy = " + id);
            type = type + id;
        }
    });
    return type;
}


function getExportDays() {
    //var days = $("#export_days").attr('value');
    var days = $("#export_days").val();
    if ('' == days) {
        days = 0;
    }
    return days;
}

function getExportWeeks() {
    // var weeks = $("#export_weeks").attr('value');
    var weeks = $("#export_weeks").val();
    if ('' == weeks) {
        weeks = 0;
    }
    return weeks;

}

function getExportMonths() {
    // var months = $("#export_months").attr('value');
    var months = $("#export_months").val();
    if ('' == months) {
        months = 0;
    }
    return months;

}

function getExportInputChecked() {
    var radionum = document.getElementsByName('export_policy');
    for (var i = 0; i < radionum.length; i++)
        if (radionum[i].checked) {
            typeid = radionum[i].value
        }
    //console.log("input checked "+ typeid);
    return typeid;
}

function backToAutoExport() {
    window.location.reload();;
}
