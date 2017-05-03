$(document).ready(function(){
    window.navigator.language='en-US';
    loadProperties(window.navigator.language);
});
function loadProperties(language){
    jQuery.i18n.properties({
        name:'strings',
        path:'./lang/string/',
        mode:'both',
        language: language,
        async: true,
        callback: function() {
            console.log($.i18n.prop('string_username')+":欢迎您");
        }
    });
}