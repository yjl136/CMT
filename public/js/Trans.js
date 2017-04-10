if(typeof(TRANS_MSGS) === "undefined") {
	TRANS_MSGS = {};	
}
TRANS_MSGS["Test,I have %1$ apples,%%1$"] = "测试,我有%1$个苹果,%%1$";
(function (){
	this.Trans = {
		t: function (msg, arg1_null, arg2_null, argAndSoOn_null) {
			var transMsg = msg = msg + "";
			var doubuleFlag = "doublueEeeeFlgGggg";
			if(TRANS_MSGS && TRANS_MSGS[msg]) {
				transMsg = TRANS_MSGS[msg];
			}
			transMsg = transMsg.replace(new RegExp("%%", "g"), doubuleFlag);
			for(var i=1, len=arguments.length; i<len; i++) {
				transMsg = transMsg.replace(new RegExp("%"+i+"\\$", "g"), arguments[i]);				
			}
			transMsg = transMsg.replace(new RegExp(doubuleFlag, "g"), "%");
			return transMsg;
		}
	};
})();
