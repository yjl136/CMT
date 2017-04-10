function saveSystemConfig(){
	var system_id = $("#system_id").val();
	axios({
		method: 'post',
		url: "system",
		headers: {'X-Requested-With': 'XMLHttpRequest'},
		data: {
			"system_id" : system_id,
			"_token": $('input[name=_token]').val()
		}
	}) .then(function (response) {
		console.log(response);
		if (response['data']=="success"){
			//提示操作结果
			layer.msg('修改成功', {icon: 1});
		}else {
			//提示错误信息
			layer.msg('修改失败', {icon: 2});
		}
	}).catch(function (error) {
		console.log(error);
		//提示错误信息
		layer.msg('修改失败', {icon: 2});
	});
}

function saveServerConfig(){
    var server_sn = $("#server_sn").val();
    var server_em = $("#server_em").val();
    axios({
        method: 'post',
        url: "server",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        data: {
            "server_sn" : server_sn,
            "server_em" : server_em,
            "_token": $('input[name=_token]').val()
        }
    }) .then(function (response) {
        console.log(response);
        if (response['data']=="success"){
            //提示操作结果
            layer.msg('修改成功', {icon: 1});
        }else {
            //提示错误信息
            layer.msg('修改失败', {icon: 2});
        }
    }).catch(function (error) {
        console.log(error);
        //提示错误信息
        layer.msg('修改失败', {icon: 2});
    });
}


function saveCapConfig(){
    var cap_sn1 = $("#cap_sn1").val();
    var cap_sn2 = $("#cap_sn2").val();
    var cap_sn3 = $("#cap_sn3").val();
    var cap_em1 = $("#cap_em1").val();
    var cap_em2 = $("#cap_em2").val();
    var cap_em3 = $("#cap_em3").val();
    axios({
        method: 'post',
        url: "cap",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        data: {
            "cap_sn1" : cap_sn1,
            "cap_sn2" : cap_sn2,
            "cap_sn3" : cap_sn3,
            "cap_em1" : cap_em1,
            "cap_em2" : cap_em2,
            "cap_em3" : cap_em3,
            "_token": $('input[name=_token]').val()
        }
    }) .then(function (response) {
        console.log(response);
        if (response['data']=="success"){
            //提示操作结果
            layer.msg('修改成功', {icon: 1});
        }else {
            //提示错误信息
            layer.msg('修改失败', {icon: 2});
        }
    }).catch(function (error) {
        console.log(error);
        //提示错误信息
        layer.msg('修改失败', {icon: 2});
    });
}