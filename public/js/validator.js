function validateField(element, rule, msg) {
	var value = element.val();
	var valid = true;
	if (rule == "required") {
		valid = validateRequired(value);
		//msg = msg ? msg : Trans.t("请输入必填项");
		msg = msg ? msg : "请输入必填项";
	} else if (rule == "email") {
		valid = validateEmail(value);
		//msg = msg ? msg : Trans.t("请输入正确的邮箱，如: aa@bb.cc");
		msg = msg ? msg :"请输入正确的邮箱，如: aa@bb.cc";
	} else if (rule == "ip") {
		valid = validateIP(value);
		//msg = msg ? msg : Trans.t("请输入正确的IP，如: 192.168.0.1");
		msg = msg ? msg : "请输入正确的IP，如: 192.168.0.1";
	} else if (rule == "mac") {
		valid = validateMac(value);
		//msg = msg ? msg : Trans.t("请输入正确的Mac，如: 00:0c:e6:12:35:e1");
		msg = msg ? msg : "请输入正确的Mac，如: 00:0c:e6:12:35:e1";
	} else if (rule == "id_number") {
		valid = validateIDNumber(value);
		//msg = msg ? msg : Trans.t("请输入正确的身份证号(15或18位)");
		msg = msg ? msg : "请输入正确的身份证号(15或18位)";
	} else if (rule == "date") {
		valid = validateDate(value);
		//msg = msg ? msg : Trans.t("请输入正确的日期格式，如: YYYY-mm-dd");
		msg = msg ? msg : "请输入正确的日期格式，如: YYYY-mm-dd";
	} else if (rule == "datetime") {
		valid = validateDateTime(value);
		//msg = msg ? msg : Trans.t("请输入正确的时间格式，如: YYYY-mm-dd HH:ii:ss");
		msg = msg ? msg : "请输入正确的时间格式，如: YYYY-mm-dd HH:ii:ss";
	} else if  (rule == "url") {
		valid = validateURL(value);
		//msg = msg ? msg : Trans.t("请输入正确的网址，如: https://www.baidu.com/");
		msg = msg ? msg :"请输入正确的网址，如: https://www.baidu.com/";
	} else if (rule == "password") {
		valid = validatePassword(value);
		//msg = msg ? msg : Trans.t("最少为6位，不能为纯数字、字母、符号");
		msg = msg ? msg : "最少为6位，不能为纯数字、字母、符号";
	} else if (rule == "sn") {
		valid = validateSn(value);
		//msg = msg ? msg : Trans.t("只能输入7位数字或者不配置");
		msg = msg ? msg : "只能输入7位数字或者不配置";
	} else if  (rule == "mod") {
		valid = validateMod(value);
		//msg = msg ? msg : Trans.t("只能输入1位数字或者2位数字或者不配置");
		msg = msg ? msg : "只能输入1位数字或者2位数字或者不配置";
	} else if  (rule == "alinenum") {
		valid = validateAlinenum(value);
		//msg = msg ? msg : Trans.t("以字母数字开头，后面可接字母数字_-符号，长度4位以上");
		msg = msg ? msg : "以字母数字开头，后面可接字母数字_-符号，长度4位以上";
	} else if  (rule == "username") {
		valid = validateUsername(value);
		//msg = msg ? msg : Trans.t("字母数字加中文字符，和_符号");
		msg = msg ? msg : "字母数字加中文字符，和_符号";
	}


	if (!valid) {
		showFieldError(msg, element);
	}
	return valid;
}

function showFieldError(msg, element) {
	// layer.tips(msg, element, {
	// 	time: 10000
	// });

    layer.msg(msg, {icon: 2});
}



function clearError() {
	layer.closeAll("tips");
}

function validateDate(value) {
	var pattern = /^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))$/;
	return pattern.test(value);
}

function validateDateTime(value) {
	var pattern = /^((((1[6-9]|[2-9]\d)\d{2})-(0?[13578]|1[02])-(0?[1-9]|[12]\d|3[01]))|(((1[6-9]|[2-9]\d)\d{2})-(0?[13456789]|1[012])-(0?[1-9]|[12]\d|30))|(((1[6-9]|[2-9]\d)\d{2})-0?2-(0?[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))-0?2-29-))(\s(([01]\d{1})|(2[0123])):([0-5]\d):([0-5]\d))?$/;
	return pattern.test(value);
}

function validateEmail(value) {
	var pattern = /^([a-zA-Z0-9]+[\-|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[\-|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	return pattern.test(value);
}

function validateIDNumber(value) {
	var pattern = /^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;
	return pattern.test(value);
}

function validateIP(value) {
	var pattern = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
	return (pattern.test(value) && (RegExp.$1 < 256 && RegExp.$2 < 256
	&& RegExp.$3 < 256 && RegExp.$4 < 256));
}

function validateMac(value) {
	var pattern = /^[A-Fa-f0-9]{2}:[A-Fa-f0-9]{2}:[A-Fa-f0-9]{2}:[A-Fa-f0-9]{2}:[A-Fa-f0-9]{2}:[A-Fa-f0-9]{2}$/;
	return pattern.test(value);
}

function validateURL(value) {
	var pattern = /^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+$/;
	return pattern.test(value);
}

function validatePassword(value) {
	var pattern = /^((?!\d+$)(?![a-zA-Z]+$)[a-zA-Z\d@#$%^&_+].{5,19})+$/;
	return pattern.test(value);
}

function validateSn(value) {
	var pattern = /^[0-9]{7}$/;
	return pattern.test(value);
}

function validateMod(value) {
	var pattern = /^(\d{1,2}(,\d{1,2})*)?$/;
	return pattern.test(value);
}

function validateAlinenum(value) {
	var pattern = /^([0-9a-zA-Z])([0-9a-zA-Z-_]){4,23}$/;
	return pattern.test(value);
}

function validateUsername(value) {
	var pattern = /^[A-Za-z0-9_\-\u4e00-\u9fa5]+$/;
	return pattern.test(value);
}



function validateRequired(value) {
	return value != null && value != '';
}

// -------------------私有方法-------------------------
function checkIDNumber(num) {
	var len = num.length;
	var re;
	if (len == 15) {
		re = new RegExp(/^(\d{6})()?(\d{2})(\d{2})(\d{2})(\d{2})(\w)$/);
	} else if (len == 18) {
		re = new RegExp(/^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})(\w)$/);
	} else {
		// alert("输入的数字位数不对。");
		return false;
	}
	var a = num.match(re);
	if (a != null) {
		var D, B;
		if (len == 15) {
			D = new Date("19" + a[3] + "/" + a[4] + "/" + a[5]);
			B = D.getYear() == a[3] && (D.getMonth() + 1) == a[4]
				&& D.getDate() == a[5];
		} else {
			D = new Date(a[3] + "/" + a[4] + "/" + a[5]);
			B = D.getFullYear() == a[3] && (D.getMonth() + 1) == a[4]
				&& D.getDate() == a[5];
		}
		if (!B) {
			// alert("输入的身份证号 "+ a[0] +" 里出生日期不对。");
			return false;
		}
	}
	if (!re.test(num)) {
		return false;
	}
	return true;
}

