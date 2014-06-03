$(document).ready(function() {
	$("#rad_single").click(function() {
		$("#single").show();
		$("#multiple").hide();
		$("#add").hide();
	});
	$("#rad_multiple").click(function() {
		$("#single").hide();
		$("#multiple").show();
		$("#add").hide();
	});
	$("#rad_add").click(function() {
		$("#single").hide();
		$("#multiple").hide();
		$("#add").show();
	});
});