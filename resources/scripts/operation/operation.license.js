$(document).ready(function() {
	if($("#controlFunction").attr("checked")) {
		$("#func_list").removeClass("hidden-element");
	} else {
		$("#func_list").addClass("hidden-element");
	}
	$("#controlFunction").click(function() {
		if($("#controlFunction").attr("checked")) {
			$("#func_list").slideDown("normal");
		} else {
			$("#func_list").slideUp("normal");
		}
	});
	$("#func_list span.usagetxt").css({
		"cursor": "pointer"
	});
	$("#func_list span.usagetxt").click(function() {
		var functionDisabled = $("#functionDisabled").val();
		if($(this).hasClass("greentxt")) {
			$(this).removeClass("greentxt");
			$(this).addClass("redtxt");
			
			if(functionDisabled) {
				$("#functionDisabled").val(functionDisabled + "," + $(this).text());
			} else {
				$("#functionDisabled").val($(this).text());
			}
		} else if($(this).hasClass("redtxt")) {
			$(this).removeClass("redtxt");
			$(this).addClass("greentxt");
			
			var funcName = $(this).text();
			var indexOfArray = functionDisabled.indexOf(funcName);
			if(indexOfArray!=-1) {
				if(functionDisabled.indexOf(",")!=-1) {
					if(indexOfArray==0) {
						functionDisabled = functionDisabled.replace(funcName+",", "");
					} else {
						functionDisabled = functionDisabled.replace(","+funcName, "");
					}
				} else {
					functionDisabled = functionDisabled.replace(funcName, "");
				}
				$("#functionDisabled").val(functionDisabled);
			}
		}
	});
	
	$("#licenseTimeOpt").change(function () {
		var thisVal = $(this).val();
		switch(thisVal) {
			case "2y":
				$("#licenseTimeLimit").val("730");
				break;
			case "1y":
				$("#licenseTimeLimit").val("365");
				break;
			case "6m":
				$("#licenseTimeLimit").val("180");
				break;
			case "1m":
				$("#licenseTimeLimit").val("30");
				break;
		}
	});
});