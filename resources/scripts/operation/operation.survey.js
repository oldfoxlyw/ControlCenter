$(document).ready(function() {
	var currentQuestionId = parseInt($("#questionTotal").val()) + 1;
	$("#addQuestion").click(function() {
		$(this).parent().before("<div class=\"questionSperator\"></div>");
		var newQuestion = $(this).parent().prev();
		newQuestion.append("<input name=\"questionId_"+currentQuestionId+"\" type=\"hidden\" id=\"questionId_"+currentQuestionId+"\" value=\""+currentQuestionId+"\" class=\"questionId\" /><input name=\"optionId_"+currentQuestionId+"\" type=\"hidden\" id=\"optionId_"+currentQuestionId+"\" value=\"1\" class=\"optionId\" /><div class=\"row\"><span style=\"display:inline-block;width:120px;\">问题"+currentQuestionId+"：</span><input name=\"questionContent_"+currentQuestionId+"\" type=\"text\" id=\"questionContent_"+currentQuestionId+"\" value=\"\" style=\"width:400px;\" class=\"text-input\" /><input type=\"button\" name=\"removeQuestion"+currentQuestionId+"\" id=\"removeQuestion"+currentQuestionId+"\" value=\"删除问题\" class=\"button removeQuestion\" /></div>");
		newQuestion.append("<div class=\"row\"><input type=\"button\" name=\"addOption"+currentQuestionId+"\" id=\"addOption"+currentQuestionId+"\" value=\"添加选项\" class=\"button addOption\" /></div>");
		var total = $("#questionTotal").val();
		$("#questionTotal").val(currentQuestionId);
		currentQuestionId++;
	});
	$("input.removeQuestion").live("click", function() {
		$(this).parent().parent().remove();
	});
	$("input.addOption").live("click", function() {
		var questionId = $(this).parent().parent().find("input.questionId").val();
		var optionId = $(this).parent().parent().find("input.optionId").val();
		$(this).parent().before("<div class=\"row\"><span style=\"display:inline-block;width:120px;\">问题"+questionId+"-选项"+optionId+"：</span>类型：<select name=\"optionType_"+questionId+"_"+optionId+"\" id=\"optionType_"+questionId+"_"+optionId+"\"><option value=\"radio\" selected=\"selected\">radio</option><option value=\"text\">text</option><option value=\"textarea\">textarea</option></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;变量名：<input name=\"optionVariable_"+questionId+"_"+optionId+"\" type=\"text\" id=\"optionVariable_"+questionId+"_"+optionId+"\" value=\"\" class=\"text-input\" style=\"width:300px;\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标题：<input name=\"optionTitle_"+questionId+"_"+optionId+"\" type=\"text\" id=\"optionTitle_"+questionId+"_"+optionId+"\" value=\"\" class=\"text-input\" style=\"width:300px;\" /></div>");
		$(this).parent().parent().find("input.optionId").val(parseInt(optionId)+1);
	});
});