function updateRecver(){
	var user_id = $("#userid").val();
	var mail_type = $("#mailtype").val();
	axios({
		method: 'post',
		url: mail_type+"?do=change",
		headers: {'X-Requested-With': 'XMLHttpRequest'},
		data: {
			"MailType" : mail_type,
			"UserID" : user_id,
			"_token": $('input[name=_token]').val()
		}
	}) .then(function (response) {
		console.log(response);
        if (response['data']=="success"){
            layer.msg('修改成功', {icon: 1});
        }else {
            layer.msg('修改失败', {icon: 2});
        }
	}).catch(function (error) {
		console.log(error);
		layer.msg('修改失败', {icon: 2});
    });
}

function backToRecver(){
	window.location = '';
}

function updateSender(){
	var user_id = $("#userid").val();
	var pwd = $("#pwd").val();
	var smtpsvr = $("#smtpsvr").val();
	var port = $("#port").val();
    axios({
        method: 'post',
        url: user_id+"?do=change",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        data: {
            "UserID" : user_id,
            "Pwd" : pwd,
            "SmtpSvr" : smtpsvr,
            "Port" : port,
			"_token": $('input[name=_token]').val()
        }
    }) .then(function (response) {
        console.log(response);
        if (response['data']=="success"){
            layer.msg('修改成功', {icon: 1});
        }else {
            layer.msg('修改失败', {icon: 2});
        }
    }).catch(function (error) {
        console.log(error);
        layer.msg('修改失败', {icon: 2});
    });
}

function validateSender(user_id){
    axios({
        method: 'get',
        url: "validate/mail",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        data: {
            "UserID" : user_id,
            "_token": $('input[name=_token]').val()
        }
    }) .then(function (response) {
        console.log(response);
        if (response['data']=="success"){
            layer.msg('校验成功', {icon: 1});
        }else {
            layer.msg('校验失败，邮箱或者密码错误', {icon: 2});
        }
    }).catch(function (error) {
        console.log(error);
        layer.msg('校验失败，网络错误', {icon: 2});
    });
}


