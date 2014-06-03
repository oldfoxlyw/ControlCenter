$(document).ready(function() {
	$("#reportType").change(function() {
		switch($(this).val()) {
			case "1":
				$("#content").find("table:visible").fadeOut("normal", function() {
					$("#table_license").fadeIn("normal");
				});
				break;
			case "2":
				$("#content").find("table:visible").fadeOut("normal", function() {
					$("#table_cpu").fadeIn("normal");
				});
				break;
			case "3":
				$("#content").find("table:visible").fadeOut("normal", function() {
					$("#table_product").fadeIn("normal");
				});
				break;
		}
	});
});