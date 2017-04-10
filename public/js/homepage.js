var password_value = '';

/**
 * 页面初始化执行的函数
 */
$(function() {
    init();
    updateNewVersion();
	//clock();   //加载页面中的时钟

	queryStatus();   //查询监视的各个状态值

	setTimeout(function() {
		onekeybite(document.getElementById('btn_onekey'));
	}, 1000);   //设置定时去自检

	setInterval(function() {
		onekeybite(document.getElementById('btn_onekey'));
	}, 120000);   //设置一定时间去循环自检
});



/**
 * 通过ajax获取监视页面的各个状态值以及参数值，并同步进行更新，刷新频率为5秒一次
 */
function queryStatus() {
	$.ajax({
		url : '../public/api/getStatus',
		dataType : "json",
		success : function(data) {
			// console.log(data);
			for ( var key in data) {
				var invalid = data[key] == 0 || data[key] == null;
				if (key == "status_wifi") {
					$("#" + key + " > span").html(
							invalid ? "Offline" : "Online");
					$("#" + key).attr("class", invalid ? "dis" : "");
				} else if (key == "status_online_users") {
					$("#" + key + " > i").html(data[key]);
				}else if(key == "status_door"){
                    $("#" + key).attr("class", invalid ? "dis" : "");
				}else if(key == "status_wow"){
                    $("#" + key).attr("class", invalid ? "dis" : "");
                }else if(key == "status_4g"){
                    $("#" + key).attr("class", invalid ? "dis" : "");
                }else if(key == "status_pa"){
                    $("#" + key).attr("class", invalid ? "dis" : "");
                } else if(key == "status_4gswitch"){
					$("#kg_4g").attr("class",data[key]==0?"close":"open");
				}else if(key == "status_wifiswitch"){
					$("#kg_wifi").attr("class",data[key]==0?"close":"open");
				}else {
					$("#" + key).attr("class", invalid ? "dis" : "");
				}
			}
		}
	});
	setTimeout("queryStatus()", 1000);
}


/**
 * 一键自检
 */
function onekeybite() {
	$.ajax({
		url : '/CMT/public/api/onekeyBite',
		　beforeSend : function() {
			setDiagnoseButtonEnable(false);
			updateDiagnoseStatus(1, Trans.t("检测中......"));
			updateTroubleMessage(new Array());
		},
		dataType : "json",
		success : function(data) {
			console.log(data);
			setDiagnoseButtonEnable(true);    // reset button style
			updateDiagnoseStatus(data["diagnose_status"], data["diagnose_message"]);  	// upgrade diagnose status and result
			updateTroubleMessage(data["message_list"]);  // show trouble message
		},
		error : function() {
			setDiagnoseButtonEnable(true);
			$("#diagnose_status").attr("class", "cont ror");
		}
	});
}

function switch4G(){
	var clazz=$('#kg_4g').attr('class');
	var mode;
	if(clazz=="open"){
		mode=0;
	}else{
		mode=1;
	}
	$.ajax({
		url: '/CMT/public/home/switch4G/'+mode,
		dataType: "json",
		success: function(data){
			if(data.code=="1"){
				//queryStatus();
				showLayerMsg("4G切换成功",false);
			}else{
				showLayerMsg("4G切换失败",true);
			}
		},
		error : function(){
         showLayerMsg("4G切换失败",true);
		}
	});
}
function showLayerMsg(msg, error){
	layer.msg(msg, {
		icon : (error ? 2:1),
		time : 2000
	});
}

function switchWifi(){
	var clazz=$('#kg_wifi').attr('class');
	console.log(status);
	var mode;
	if(clazz=="open"){
		mode=0;
	}else{
		mode=1;
	}
	$.ajax({
		url: '/CMT/public/home/switchWifi/'+mode,
		dataType: "json",
		success: function(result){
			console.log(result);
			if (result.code == '0') {
				//queryStatus();
				showLayerMsg("wifi切换成功",false);
			}else{
				showLayerMsg("wifi切换失败",true);
			}
		},
		error:function(){
			showLayerMsg("wifi切换失败",true);
		}

	});
}

/**
 * 诊断按钮的禁止与开启
 * @param enable
 */
function setDiagnoseButtonEnable(enable) {
	var element = document.getElementById('btn_onekey');
	if (enable) {
		$(element).attr("class", Trans.t("btn_jiance"));
	} else {
		$(element).attr("class", Trans.t("btn_jiance_dis"));
	}
}

/**
 * 更新诊断的状态
 * @param diagnose_status
 * @param message
 */
function updateDiagnoseStatus(diagnose_status, message) {
	diagnose_status = diagnose_status == null ? 0 : parseInt(diagnose_status);
	switch (diagnose_status) {
	case 0:// idle
	case 2:// ok
		$("#diagnose_status").attr("class", "cont ok");
		$(".message").removeClass("message_ror");
		break;
	case 1:// processing
		$("#diagnose_status").attr("class", "cont loading");
		$(".message").removeClass("message_ror");
		break;
	case 3:// warn
		$("#diagnose_status").attr("class", "cont warn");
		$(".message").removeClass("message_ror");
		break;
	case 4:// error
		$("#diagnose_status").attr("class", "cont ror");
		$(".message").addClass("message_ror");
		break;

	default:
		$("#diagnose_status").attr("class", "cont ok");
		$(".message").removeClass("message_ror");
		break;
	}
	$("#diagnose_result").html(message ? message : "");
}

/**
 * 更新错误信息
 * @param message_list
 */
function updateTroubleMessage(message_list) {
	if (message_list != null) {
		var message_content = "";
		for ( var key in message_list) {
			message_content += '<a href="#">'
					+ message_list[key]["Description"] + '</a>';
		}
		// determine whether to show message list and message count
		if ($("#diagnose_status").hasClass("warn")
				|| $("#diagnose_status").hasClass("ror")) {
			$(".message").removeClass("hidden");
			$("#message_count").show();
		} else {
			$(".message").addClass("hidden");
			$("#message_count").hide();
		}

		// upgrade message list
		$(".message_list div p").html(
				message_list.length > 0 ? message_content : "");

		// upgrade message count
		$("#message_count").html(
				message_list.length > 0 ? Trans.t(
						"本次检测发现<a href=\"#\">%1$</a>个问题", message_list.length)
						: "");
	}
}

/**
 * 执行登录操作
 */
function logon() {
	var password = $("#password").val();
	if(password == null || password == ''){
	    $(".tip_message").html("请输入密码!");
    }else{
        axios({
            method: 'post',
            url: "/CMT/public/loginWithPassword",
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: {
                "password" : password,
                "_token": $('input[name=_token]').val()
            }
        }) .then(function (response) {
            console.log(response);
			var user_type = response["data"];
            switch (user_type)
            {
                case "superAdmin":
                    window.location = '../public/topo';
                    break;
                case "operation":
                    window.location = '../public/operate/topo';
                    break;
                case "maintenance":
                    window.location = '../public/maintenance/topo';
                    break;
                case "factorySet":
                    window.location = '../public/factoryset/customizeSetting';
                    break;
                default:
                    $(".tip_message").html("密码输入错误，请重新输入。");
            }
        }).catch(function (error) {
            console.log(error);
            //提示错误信息
            $(".tip_message").html("登录出现未知错误。");
        });
    }
}


function init() {

	$(".user a").click(function() {
		$(".login").slideToggle();
		$(this).toggleClass("ck");
		$(".side a").click(function() {
			$(".login").slideUp();
			$(".user a").removeClass("ck");
		});
	});

	$(".btn_up").click(function() {
		if (!$(this).hasClass("ck")) {
			$(".message").animate({
				height : "470px"
			}, 1000);
			$(this).addClass("ck");
		} else {
			$(".message").animate({
				height : "70px"
			}, 1000);
			$(this).removeClass("ck");
		}
	});

	$(".btn button, .btn_en button").click(function() {
		logon();
	});

	$(".nub button").click(
			function() {
				// clear error tip message
				$(".tip_message").html("");

				if ($(this).hasClass('del')) {
					password_value = password_value.substr(0,
							password_value.length - 1);
				} else {
					var css = $(this).attr("class");
					password_value = password_value + ""
							+ css.replace(/a/ig, "");
				}
				$("#password").val(password_value);
			});
}

function clock(status_lan,status_usb) {
	var datetime = new Date();
	var flag = $("#utc_flag").val() == "1";
	var years = flag ? datetime.getUTCFullYear() : datetime.getFullYear();
	var months = flag ? (datetime.getUTCMonth() + 1.0):(datetime.getMonth() + 1.0);
	var dates =  flag ? datetime.getUTCDate() : datetime.getDate();
	var hours =  flag ? datetime.getUTCHours() : datetime.getHours();
	var minutes =  flag ? datetime.getUTCMinutes() : datetime.getMinutes();
	var seconds =  flag ? datetime.getUTCSeconds() : datetime.getSeconds();

	if (eval(months) < 10) {
		months = "0" + months;
	}
	if (eval(dates) < 10) {
		dates = "0" + dates;
	}
	if (eval(hours) < 10) {
		hours = "0" + hours;
	}
	if (eval(minutes) < 10) {
		minutes = "0" + minutes;
	}
	if (eval(seconds) < 10) {
		seconds = "0" + seconds;
	}
	thisdate = Trans.t("%1$/%2$/%3$ %4$:%5$:%6$", years, months, dates, hours,
			minutes, seconds);
	if(flag){
		thisdate += " UTC";
	}
	// document.getElementById('cur_time').innerHTML = thisdate;
	document.getElementById('new_version').innerHTML = "<div id='cur_time' class='time'>"
		+thisdate
		+"</div>"
        + "<div class='screen'>"
        + "<a>"+"LAN"+"<i class="+status_lan+"></i>"+"</a>"
        + "<a>"+"USB"+"<i class="+status_usb+"></i>"+"</a>"
        + "</div>";

	//setTimeout("clock()", 900);
}

function updateNewVersion() {
    $.ajax({
        url: '/CMT/public/api/getNewVersion',
        dataType: "json",
        success: function(data){
            // console.log(data);
            // console.log(data.flag.var_value);
            // console.log(data.version.var_value);
            if (data.status.status_lan==0){
                var status_lan = 'lan';
            }else{
                var status_lan = 'lan_';
            }

            if (data.status.status_usb==0){
                var status_usb = 'usb';
            }else{
                var status_usb = 'usb_';
            }
            if (data.flag.var_value==0) {
                document.getElementById('new_version').innerHTML = "<div class='time' style='color: #e90;'>"
					+"有最新版本："
					+data.version.var_value
					+ "</div>"
					+ "<div id='cur_time' class='time' style='display: none;'></div>"
					+ "<div class='screen'>"
					+ "<a>"+"LAN"+"<i class="+status_lan+"></i>"+"</a>"
					+ "<a>"+"USB"+"<i class="+status_usb+"></i>"+"</a>"
					+ "</div>";

            }else if(data.flag.var_value==1){
                clock(status_lan,status_usb);
			}else{
                clock(status_lan,status_usb);
                //console.log("获取新版本的信息错误！");
            }
        },
        error:function(){
        	console.log("更新版本出错！");
        }

    });
    setTimeout("updateNewVersion()", 1000);
}