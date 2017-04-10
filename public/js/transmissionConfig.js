/**
 * Created by Administrator on 2016/7/20.
 */
var loading_dialog = null;
$(function(){
    //传输协议单选框点击事件
    $("#transportProtocol > a").on("click", function(){
        var element = this;
        $("#transportProtocol > a > i").each(function(){
            if(this.parentNode == element){
                this.className = "checkbox_on";
                var id = this.getAttribute('id');
                if (id == "SMTP"){
                    $("#third_url").attr("disabled",true);
                    $("#third_url").attr("style",'background-color:gray;');
                    $("#third_username").attr("disabled",true);
                    $("#third_username").attr("style",'background-color:gray;');
                    $("#third_password").attr("disabled",true);
                    $("#third_password").attr("style",'background-color:gray;');
                }else{
                    $("#third_url").attr("disabled",false);
                    $("#third_url").attr("style",'background-color:white;');
                    $("#third_username").attr("disabled",false);
                    $("#third_username").attr("style",'background-color:white;');
                    $("#third_password").attr("disabled",false);
                    $("#third_password").attr("style",'background-color:white;');
                }
            }else{
                this.className = "checkbox";
            }
        });
        return false;
    });

    //数据导出方式单选框点击事件
    $("#exportMethod > a").on("click", function(){
        var element = this;
        $("#exportMethod > a > i").each(function(){
            if(this.parentNode == element){
                this.className = "checkbox_on";
            }else{
                this.className = "checkbox";
            }
        });
        return false;
    });
});

function onInitConfig() {
    $("#transportProtocol > a > i").each(function () {
        if (this.className == "checkbox_on") {
            var id = this.getAttribute('id');
            if (id == "SMTP") {
                $("#third_url").attr("disabled", true);
                $("#third_url").attr("style", 'background-color:gray;');
                $("#third_username").attr("disabled", true);
                $("#third_username").attr("style", 'background-color:gray;');
                $("#third_password").attr("disabled", true);
                $("#third_password").attr("style", 'background-color:gray;');
            } else {
                $("#third_url").attr("disabled", false);
                $("#third_url").attr("style", 'background-color:white;');
                $("#third_username").attr("disabled", false);
                $("#third_username").attr("style", 'background-color:white;');
                $("#third_password").attr("disabled", false);
                $("#third_password").attr("style", 'background-color:white;');
            }
        }
    });
}

function checkTransWay() {
    var transportProtocol = getTransportProtocol();
    var exportUserName = getExportUserName();
    var exportPassword = getExportPassword();
    var exportMethod = getExportMethod();
    var exportUrl = getExportUrl();
    if (transportProtocol==4){
        if (!validateField($("#third_url"), "ip")) {
            return false;
        }

        if (!validateField($("#third_username"), "username")) {
            return false;
        }

        // if (!validateField($("#third_password"), "password")) {
        //     return false;
        // }
    }

    $.ajax({
        url: "/CMT/public/transmissionsave",
        data: {
            "transportProtocol": transportProtocol,
            "exportUserName": exportUserName,
            "exportPassword": exportPassword,
            "exportMethod": exportMethod,
            "exportUrl": exportUrl
        },
        dataType: "json",
        success: function (data) {
            if(data=="success"){
                showLayerMsg('修改成功');
                //跳转到用户列表界面
                setTimeout("backToTransmissionConfig()", 1000);
            }else{
                showLayerMsg('修改失败', true);
            }

        },
        error: function (data) {
            //提示错误信息
           // showLayerMsg(Trans.t('修改失败'), true);
            showLayerMsg('修改失败', true);
        }

    });
}
function showLayerMsg(msg, error){
    layer.msg(msg, {
        icon : (error ? 2:1),
        time : 2000
    });
}
function getTransportProtocol(){
    var way = 0;
    $("#transportProtocol > a > i").each(function(index){
        if(this.className == "checkbox_on"){
            var id = this.getAttribute('id');
            if (id=='HTTP'){
                value=19;
            }
            if (id=='SMTP'){
                value=3;
            }
            if (id=='FTP') {
                value=4;
            }
            if (id=='SFTP'){
                value=20;
            }
            way = way + value;
        }
    });
    console.log("transportProtocol = " + way);
    return way;
}

function getExportMethod(){
    var type = 0;
    $("#exportMethod > a > i").each(function(index){
        if(this.className == "checkbox_on"){
            var id = this.getAttribute('id');
            type = id;
        }
    });
    //console.log("exportMethod = " + type);
    return type;
}

function getExportUrl(){
   // var url =$("#third_url").attr('value');
    var url =$("#third_url").val();
    //console.log("exportUrl = " + url);
    return url;

}

function getExportUserName(){
    //var username =$("#third_username").attr('value');
    var username =$("#third_username").val();
    //console.log("exportUserName = " + username);
    return username;

}

function getExportPassword(){
   // var password =$("#third_password").attr('value');
    var password =$("#third_password").val();
    //console.log("exportPassword = " + password);
    return password;

}

function backToTransmissionConfig(){
    window.location ='/CMT/public/transmission';
}

function backToHttpConfig(){
    window.location ='../public/http';
}

function updateUsbConfig() {
    var url = $("#url").val();
    var username = $("#username").val();;
    var password = $("#password").val();;
    $.ajax({
        url: "../public/http",
        data: {
            "url": url,
            "username": username,
            "password": password
        },
        dataType: "json",
        success: function (data) {
            if(data=="success"){
                showLayerMsg('修改成功');
                //跳转到用户列表界面
                setTimeout("backToHttpConfig()", 1000);
            }else{
                showLayerMsg('修改失败', true);
            }

        },
        error: function (data) {
            //提示错误信息
            showLayerMsg('修改失败', true);
        }

    });
}

