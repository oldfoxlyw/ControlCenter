$(document).ready(function() {
	$("#mailTemplate").change(function() {
		var thisVal = $(this).val();
		if(thisVal!="0") {
			$.post("general_api/getMailTemplate", {
				tid: thisVal
			}, callbackHandler);
		} else {
			CKEDITOR.instances.mailContent.setData("");
		}
	});
	$("#getAccountMail").click(function() {
		$.post("/ControlCenter/web/general_api/getAccountMail", {}, accountCallback);
	});
	
	var accountCallback = function(data) {
		if(data) {
			$("#mailAccount").text(data);
		}
	};
});

function callbackHandler (data) {
	CKEDITOR.instances.mailContent.setData(data);
}