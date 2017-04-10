
function checkUser(){
	$('#errorTip').html();
	
	var name = Trim($('#userName').val());
	var pwd  = Trim($('#passWord').val());
	
	if( 0 == name.length){
		$('#errorTip').html(Trans.t("请输入用户名!"));
		return false;
	}
	
	if(0 == pwd.length){
		$('#errorTip').html(Trans.t("请输入密码!"));
		return false;
	}
	
	if (name.length && pwd.length){
		$.ajax({
			url : 'index.php?group=home&module=index&action=login&date='+new Date().getTime(),
			data : {
				"name" : name,
				"pwd" : pwd
			},
			dataType : "json",
			success : function(data) {
				console.log(data);
				if(data["code"] == 'name'){            		
					$('#errorTip').html(Trans.t("用户名错误，请重新输入。"));
            	} else if(data["code"] == 'pwd') {
            		$('#errorTip').html(Trans.t("密码输入错误，请重新输入。"));
				} else if(data["code"] == 'yes') {
            		window.location='index.php?group=home&module=index&action=main';
            	}
			}
		});
	}
}

function Trim(v){
	return v.replace(/(^\s*)|(\s*$)/g,"");
}

function changePwd(){
	var usertype = $('#usertype').val();
	var newpassword = $("#newpassword").val();
	var repeatpassword = $("#repeatpassword").val();

    if(!validateField($("#newpassword"), "required")){
        return false;
    }
    if(!validateField($("#repeatpassword"), "required")){
        return false;
    }
    if(repeatpassword != newpassword){
        showFieldError(("重复密码必须与新密码相同"), $("#repeatpassword"));
        return false;
    }
	axios({
		method: 'post',
		url: usertype+"?do=change",
		headers: {'X-Requested-With': 'XMLHttpRequest'},
		data: {
			"usertype" : usertype,
			"newpassword" : newpassword,
			"repeatpassword" : repeatpassword,
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
