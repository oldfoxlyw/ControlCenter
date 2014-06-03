$(document).ready(function() {
	$("#isAllFunction").click(function() {
		var thisVal = $(this).attr("checked");
		if(thisVal) {
			$("#selectFunction").attr("disabled", "disabled");
		} else {
			$("#selectFunction").attr("disabled", "");
		}
	});
	$("#productVersion").change(function() {
		if($(this).val()=="0") {
			$("#selectFunction").empty();
			$("#selectFunction").append("<option value=\"0\" selected=\"selected\">不指定</option>");
		} else {
			var parameter = {
				product_id: $("#productId_forVer").val(),
				product_version: $(this).val()
			};
			$.post("/ControlCenter/api/products/getFunctionByProduct/json", parameter, callbackVersion);
		}
	});
	var callbackVersion = function(data) {
		$("#selectFunction").empty();
		$("#selectFunction").append("<option value=\"0\" selected=\"selected\">不指定</option>");
		var json = eval("(" + data + ")");
		for(i=0; i<json.field.length; i++) {
			$("#selectFunction").append("<option value=\"" + json.field[i].func_id + "\">" + json.field[i].func_name + "</option>");
		}
	};
	$("#softwareType").change(function() {
		switch($(this).val()) {
			case "converter":
				$("#special-ripper").hide();
				$("#special-player").hide();
				$("#special-converter").show();
				break;
			case "ripper":
				$("#special-converter").hide();
				$("#special-player").hide();
				$("#special-ripper").show();
				break;
			case "player":
				$("#special-converter").hide();
				$("#special-ripper").hide();
				$("#special-player").show();
				break;
		}
	});
});