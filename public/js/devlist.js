$(function(){
    setInterval(function(){
        console.log("reload");
		window.location.reload();
    }, 15000);
});

function showDevice(mac){
	if (mac){
		window.location = "showDevice/"+mac;
	}else{
		console.log('function showDevice error!');
	}
}

function layerMessage() {
	layer.alert('设备离线，无法查看详情！',{icon: 2});
}