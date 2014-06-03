$(document).ready(function() {
	if($("#controlFunctionPurchase").attr("checked")) {
		$("#func_list_purchase").removeClass("hidden-element");
	} else {
		$("#func_list_purchase").addClass("hidden-element");
	}
	if($("#controlFunctionGiveaway").attr("checked")) {
		$("#func_list_giveaway").removeClass("hidden-element");
	} else {
		$("#func_list_giveaway").addClass("hidden-element");
	}
	if($("#controlFunctionFree").attr("checked")) {
		$("#func_list_free").removeClass("hidden-element");
	} else {
		$("#func_list_free").addClass("hidden-element");
	}
	
	$("#controlFunctionPurchase").click(function() {
		if($(this).attr("checked")) {
			$("#func_list_purchase").slideDown("normal");
		} else {
			$("#func_list_purchase").slideUp("normal");
		}
	});
	$("#controlFunctionGiveaway").click(function() {
		if($(this).attr("checked")) {
			$("#func_list_giveaway").slideDown("normal");
		} else {
			$("#func_list_giveaway").slideUp("normal");
		}
	});
	$("#controlFunctionFree").click(function() {
		if($(this).attr("checked")) {
			$("#func_list_free").slideDown("normal");
		} else {
			$("#func_list_free").slideUp("normal");
		}
	});
	
	$("#func_list_purchase span.usagetxt").css({
		"cursor": "pointer"
	});
	$("#func_list_giveaway span.usagetxt").css({
		"cursor": "pointer"
	});
	$("#func_list_free span.usagetxt").css({
		"cursor": "pointer"
	});
	
	$("#func_list_purchase span.usagetxt").click(function() {
		var functionDisabled = $("#functionDisabledPurchase").val();
		if($(this).hasClass("greentxt")) {
			$(this).removeClass("greentxt");
			$(this).addClass("redtxt");
			
			if(functionDisabled) {
				$("#functionDisabledPurchase").val(functionDisabled + "," + $(this).text());
			} else {
				$("#functionDisabledPurchase").val($(this).text());
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
				$("#functionDisabledPurchase").val(functionDisabled);
			}
		}
	});
	$("#func_list_giveaway span.usagetxt").click(function() {
		var functionDisabled = $("#functionDisabledGiveaway").val();
		if($(this).hasClass("greentxt")) {
			$(this).removeClass("greentxt");
			$(this).addClass("redtxt");
			
			if(functionDisabled) {
				$("#functionDisabledGiveaway").val(functionDisabled + "," + $(this).text());
			} else {
				$("#functionDisabledGiveaway").val($(this).text());
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
				$("#functionDisabledGiveaway").val(functionDisabled);
			}
		}
	});
	$("#func_list_free span.usagetxt").click(function() {
		var functionDisabled = $("#functionDisabledFree").val();
		if($(this).hasClass("greentxt")) {
			$(this).removeClass("greentxt");
			$(this).addClass("redtxt");
			
			if(functionDisabled) {
				$("#functionDisabledFree").val(functionDisabled + "," + $(this).text());
			} else {
				$("#functionDisabledFree").val($(this).text());
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
				$("#functionDisabledFree").val(functionDisabled);
			}
		}
	});
});