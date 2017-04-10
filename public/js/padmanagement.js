var interval = 5000;

$(function() {
	// update controls first time
	queryPadStatus();

	$("#btn_power_off").click(function() {
		//if (!$("#btn_power_off").hasClass("ButonUn")) {
		// Power off all pads
		configPower(0);
		//}
	});
	
	$("#btn_power_on").click(function() {
		//if (!$("#btn_power_on").hasClass("ButonUn")) {
		// Power on all pads
		configPower(1);
		//}
	});

	$(".volume_state").click(function() {
		configSound($("#sound_on").hasClass("on") ? 0 : 1);
	});

	$("#btn_volume").click(function() {
		if (!$("#btn_volume").hasClass("ButonUn")) {
			var volume = $("#volume").val();

			configVolume(volume);
		}
	});
});

function queryPadStatus() {
	execRestful("status", null, handleQueryResult, handleQueryError);
}

function configPower(mode) {
	execRestful("power", {
		"mode" : mode
	}, handleResult, handleError);
}

function configSound(mode) {
	execRestful("sound", {
		"mode" : mode
	}, handleResult, handleError);
}

function configVolume(volume) {
	if (isNaN(volume)) {
		popupMessage(Trans.t("音量必须在0~100范围内！"), "error");
		return;
	}

	volume = parseInt(volume);
	//console.log("volume = " + volume);
	if (volume == null || volume < 0 || volume > 100) {
		popupMessage(Trans.t("音量必须在0~100范围内！"), "error");
		return;
	}

	execRestful("volume", {
		"volume" : volume
	}, handleResult, handleError);
}

/**
 * execute restful API with AJAX
 * 
 * @param route :
 *            refer to route
 * @param data :
 *            form data
 * @param success_callback
 * @param error_callback
 */
function execRestful(route, data, success_callback, error_callback) {
	var url = "index.php?group=config&module=config&action=padmanagement&route="
			+ route;

	console.log(data);
	$.ajax({
		url : url,
		timeout : interval,
		data : data,
		dataType : "json",
		success : function(data) {
			console.log(data);

			if (success_callback) {
				success_callback(data);
			}
		},
		error : function() {
			if (error_callback) {
				error_callback();
			}

			console.log("exec api failed: " + action);
		}
	});
}

function handleQueryResult(data) {
	console.log(data);

	if (data) {
		if (data["code"] == 0) {
			var power_status = data["data"]["power_status"];
			var sound_status = data["data"]["sound_status"];
			var volume = data["data"]["volume"];

			updatePowerStatus(power_status);
			updateSoundStatus(sound_status);
			updateVolume(volume);
		}
	}
}

function handleQueryError() {
	console.log("query status failed, retry query in " + interval + " seconds");

	setTimeout(function() {
		queryPadStatus();
	}, interval);
}

function handleResult(data) {
	console.log(data);

	if (data) {
		var message = data["message"];
		if (data["code"] == 0) { // success
			popupMessage(message);
		} else {// failed
			popupMessage(message, "error");
		}
	}

	queryPadStatus();
}

function handleError() {
	queryPadStatus();
}

function updatePowerStatus(power_status) {
	if (power_status == 0) {
		// enable power off setting button
		$("#btn_power_on").addClass("ButonUn");
		$("#btn_power_off").removeClass("ButonUn");
	} else if(power_status == 1){
		// disable power off setting button
		$("#btn_power_off").addClass("ButonUn");
		$("#btn_power_on").removeClass("ButonUn");
	} else{
		// disable all
		$("#btn_power_off").addClass("ButonUn");
		$("#btn_power_on").addClass("ButonUn");
	}
}

function updateSoundStatus(sound_status) {
	if (sound_status) {
		// enable sound status
		$("#sound_on").addClass("on");
		$("#sound_off").removeClass("on");

		// enable volume setting button
		$("#btn_volume").removeClass("ButonUn");
	} else {
		// disable sound status
		$("#sound_off").addClass("on");
		$("#sound_on").removeClass("on");

		// disable volume setting button
		$("#btn_volume").addClass("ButonUn");
	}
}

function updateVolume(volume) {
	if (volume >= 0 && volume <= 100) {
		$("#volume").val(volume);
		$("#volume_bar").css("width", volume + "%");
	}
}

function popupMessage(msg, type) {
	if (type) {
		layer.msg(Trans.t(msg), 1, {
			type : 3
		});
	} else {
		layer.msg(Trans.t(msg), 1, {
			type : 1
		});
	}
}