$(document).ready(function() {
	$("#productId_forVer").change(function() {
		if($(this).val()!='0') {
			var productName = $(this).find("option:selected").text();
			$("#productName").val(productName);
		}
	});
});