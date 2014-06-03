$(document).ready(function() {
	var p = new PromptDialog({
		contentType:	"single",
		iframeSrc:		"http://www.weibo.com",
		autoRender:		false,
		autoSize:		true
	});
	
	$("input.noticeSendBtn").live("click", function() {
		var guid = $("#facebox #GUID").val();
		var noticeContent = $("#facebox #noticeContent").val();
		var noticeReciever = $("#facebox #noticeReciever").val();
		if(noticeContent) {
			p.setContent("<img src=\"/ControlCenter/resources/images/icons/prompt-loader.gif\" /> <span>loading...</span>");
			p.show();
			$.post("/ControlCenter/web/general_api/sendNotice", {
				"GUID": guid,
				"noticeContent": noticeContent,
				"noticeReciever": noticeReciever
			}, sendCallbackHandler);
		} else {
			alert("请填入短消息内容");
		}
	});
	$("#facebox a.remove-link").live("click", function() {
		p.setContent("<img src=\"/ControlCenter/resources/images/icons/prompt-loader.gif\" /> <span>loading...</span>");
		p.show();
		var noticeId = $(this).parent().find("input.notice_id").val();
		if(noticeId) {
			$.post("/ControlCenter/web/general_api/deleteNotice", {
				"noticeId": noticeId
			}, deleteCallbackHandler);
		} else {
			alert("短信编号错误，请刷新页面");
		}
	});
	var sendCallbackHandler = function(data) {
		var json = eval("(" + data + ")");
		if(json.result=="API_NOTICE_SEND") {
			p.setContent("<span>" + json.message + "</span>");
			p.hide();
			$("#facebox #noticeContent").val("");
		} else {
			p.setContent("<span>" + json.message + "</span>");
			p.hide();
		}
	}
	var deleteCallbackHandler = function(data) {
		var json = eval("(" + data + ")");
		if(json.result=="API_NOTICE_DELETED") {
			p.setContent("<span>" + json.message + "</span>");
			p.hide();
			$("#facebox div.notice-container > p").each(function() {
				noticeId = $(this).find("small > input.notice_id").val();
				if(noticeId == json.id) {
					$(this).slideUp("normal", function() {
						$(this).remove();
					})
				}
			});
		} else {
			p.setContent("<span>" + json.message + "</span>");
			p.hide();
		}
	}
});