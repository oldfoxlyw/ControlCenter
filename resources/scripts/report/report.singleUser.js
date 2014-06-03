$(document).ready(function() {
	$("tr.accoudin_title").click(function() {
		$(this).parent().next().toggle("normal");
	});
	$("#report_list > thead a.btn_inactived").click(function() {
		var license = $(this).parent().find("input[name='license']").val();
		var machine = $(this).parent().find("input[name='machine']").val();
		var parameter = {
			"license_content": license,
			"machine_code": machine
		};
		$.post("/ControlCenter/api/actives/deactived", parameter, controlActivationHandler);
		event.stopPropagation();
	});
	$("#report_list > thead a.btn_actived").click(function() {
		var license = $(this).parent().find("input[name='license']").val();
		var machine = $(this).parent().find("input[name='machine']").val();
		var parameter = {
			"license_content": license,
			"machine_code": machine
		};
		$.post("/ControlCenter/api/actives/actived", parameter, controlActivationHandler);
		event.stopPropagation();
	});
	var controlActivationHandler = function(data) {
		switch(data) {
			case "API_DEACTIVED_SUCCESS":
				alert("列入黑名单成功");
				break;
			case "API_DEACTIVED_ERROR":
				alert("列入黑名单失败，可能的原因是黑名单中已存在相同项");
				break;
			case "API_DEACTIVED_NO_PARAM":
				alert("列入黑名单失败，可能的原因是参数不完整");
				break;
			case "API_ACTIVED_SUCCESS":
				alert("移出黑名单成功");
				break;
			case "API_ACTIVED_ERROR":
				alert("移出黑名单失败，可能的原因是黑名单中不存在该项");
				break;
			case "API_ACTIVED_NO_PARAM":
				alert("移出黑名单失败，可能的原因是参数不完整");
				break;
		}
	}
});