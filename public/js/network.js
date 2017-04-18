$(function(){
    //初始化进度栏
//	init();
    //传输方式单选框点击事件
    $("#transWayBox > a").on("click", function(){
        var element = this;
        $("#transWayBox > a > i").each(function(){
            if(this.parentNode == element){
                this.className = "checkbox_on";
            }else{
                this.className = "checkbox";
            }
        });
        return false;
    });
});
function getModeWay(){
    var way = 0;
    $("#transWayBox > a > i").each(function(index){
        if(this.className == "checkbox_on"){
            way = this.id;
        }
    });
    console.log("trans way = " + way);
    return way;
}

function saveNetworkMode(){
    var mode=getModeWay();
    console.log("mode="+mode);
    axios({
        method: 'post',
        url: "network",
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        data: {
            "mode" : mode,
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
       // back();
    }).catch(function (error) {
        console.log(error);
        //提示错误信息
        layer.msg('修改失败', {icon: 2});
       // back();
    });
}

function back(){
    window.location.href='../public/network';
}