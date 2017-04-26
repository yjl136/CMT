$(document).ready(function(){
    loadProperties();
});
function loadProperties(){
    jQuery.i18n.properties({//加载资浏览器语言对应的资源文件
        name:'strings', //资源文件名称
        path:'./lang/string/', //资源文件路径
        mode:'map', //用Map的方式使用资源文件中的值
        callback: function() {//加载成功后设置显示内容
            alert("i18n test!!");
            console.log("i18n test!!");
        }
    });
}