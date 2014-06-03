var calendar = [
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30],
	[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]
];
$(document).ready(function() {
	$.datepicker.regional['zh-CN'] = {
        clearText: '清除',
        clearStatus: '清除已选日期',
        closeText: '关闭',
        closeStatus: '不改变当前选择',
        prevText: '<上月',
        prevStatus: '显示上月',
        prevBigText: '<<',
        prevBigStatus: '显示上一年',
        nextText: '下月>',
        nextStatus: '显示下月',
        nextBigText: '>>',
        nextBigStatus: '显示下一年',
        currentText: '今天',
        currentStatus: '显示本月',
        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
        monthNamesShort: ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二'],
        monthStatus: '选择月份',
        yearStatus: '选择年份',
        weekHeader: '周',
        weekStatus: '年内周次',
        dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
        dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        dayStatus: '设置 DD 为一周起始',
        dateStatus: '选择 m月 d日, DD',
        dateFormat: 'yy-mm-dd',
        firstDay: 7,
        initStatus: '请选择日期',
        isRTL: false
    };
    $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
	$("#myForm input.data-picker").datepicker();
	
	$("#productId_forVer").change(function() {
		if($(this).val()=="0") {
			$("#productVersion").empty();
			$("#productVersion").append("<option value=\"0\" selected=\"selected\">不指定</option>");
		} else {
			var parameter = {
				product_id: $(this).val()
			};
			$.post("/ControlCenter/api/products/getVersionById/json", parameter, productVersionCallback);
		}
	});
	var productVersionCallback = function(data) {
		$("#productVersion").empty();
		$("#productVersion").append("<option value=\"0\" selected=\"selected\">不指定</option>");
		var json = eval("(" + data + ")");
		for(i=0; i<json.field.length; i++) {
			$("#productVersion").append("<option value=\"" + json.field[i].product_version + "\">" + json.field[i].product_version + "</option>");
		}
	};
	
	if($("#month1").val() && $("#month2").val() && $("#month3").val() && $("#month4").val()) {
		var date1Month = parseInt($("#month1").val());
		var date2Month = parseInt($("#month2").val());
		var date3Month = parseInt($("#month3").val());
		var date4Month = parseInt($("#month4").val());
		for(i=0; i<calendar[date1Month-1].length; i++) {
			$("#date1").append("<option value=\""+calendar[date1Month-1][i]+"\">"+calendar[date1Month-1][i]+"</option>");
		}
		for(i=0; i<calendar[date2Month-1].length; i++) {
			$("#date2").append("<option value=\""+calendar[date2Month-1][i]+"\">"+calendar[date2Month-1][i]+"</option>");
		}
		for(i=0; i<calendar[date3Month-1].length; i++) {
			$("#date3").append("<option value=\""+calendar[date3Month-1][i]+"\">"+calendar[date3Month-1][i]+"</option>");
		}
		for(i=0; i<calendar[date4Month-1].length; i++) {
			$("#date4").append("<option value=\""+calendar[date4Month-1][i]+"\">"+calendar[date4Month-1][i]+"</option>");
		}
		$("#month1").change(function() {
			date1Month = parseInt($("#month1").val());
			$("#date1").empty();
			for(i=0; i<calendar[date1Month-1].length; i++) {
				$("#date1").append("<option value=\""+calendar[date1Month-1][i]+"\">"+calendar[date1Month-1][i]+"</option>");
			}
		});
		$("#month2").change(function() {
			date2Month = parseInt($("#month2").val());
			$("#date2").empty();
			for(i=0; i<calendar[date2Month-1].length; i++) {
				$("#date2").append("<option value=\""+calendar[date2Month-1][i]+"\">"+calendar[date2Month-1][i]+"</option>");
			}
		});
		$("#month3").change(function() {
			date3Month = parseInt($("#month3").val());
			$("#date3").empty();
			for(i=0; i<calendar[date3Month-1].length; i++) {
				$("#date3").append("<option value=\""+calendar[date3Month-1][i]+"\">"+calendar[date3Month-1][i]+"</option>");
			}
		});
		$("#month4").change(function() {
			date4Month = parseInt($("#month4").val());
			$("#date4").empty();
			for(i=0; i<calendar[date4Month-1].length; i++) {
				$("#date4").append("<option value=\""+calendar[date4Month-1][i]+"\">"+calendar[date4Month-1][i]+"</option>");
			}
		});
		var d = new Date();
		var currentYear = d.getFullYear();
		var currentMonth = d.getMonth() + 1;
		var currentDate = d.getDate();
		$("#year1 option[value='"+currentYear+"']").attr("selected", "selected");
		$("#year2 > option[value='"+currentYear+"']").attr("selected", "selected");
		$("#year3 > option[value='"+currentYear+"']").attr("selected", "selected");
		$("#year4 > option[value='"+currentYear+"']").attr("selected", "selected");
		$("#month1 > option[value='"+currentMonth+"']").attr("selected", "selected");
		$("#month2 > option[value='"+currentMonth+"']").attr("selected", "selected");
		$("#month3 > option[value='"+currentMonth+"']").attr("selected", "selected");
		$("#month4 > option[value='"+currentMonth+"']").attr("selected", "selected");
		$("#date1 > option[value='"+currentDate+"']").attr("selected", "selected");
		$("#date2 > option[value='"+currentDate+"']").attr("selected", "selected");
		$("#date3 > option[value='"+currentDate+"']").attr("selected", "selected");
		$("#date4 > option[value='"+currentDate+"']").attr("selected", "selected");
	}
	$("#reportType").change(function() {
		var thisVal = $(this).val();
		switch(thisVal) {
			case "1":
				$("#datetime3").fadeOut("normal", function() {
					$("#datetime1").fadeIn("normal", function() {
						$("#month_block1").fadeIn("normal");
						$("#month_block2").fadeIn("normal");
						$("#date_block1").fadeIn("normal");
						$("#date_block2").fadeIn("normal");
					});
				});
				break;
			case "2":
				$("#datetime3").fadeOut("normal", function() {
					$("#datetime1").fadeIn("normal", function() {
						$("#month_block1").fadeIn("normal");
						$("#month_block2").fadeIn("normal");
						$("#date_block1").fadeIn("normal");
						$("#date_block2").fadeIn("normal");
					});
				});
				break;
			case "3":
				$("#datetime3").fadeOut("normal", function() {
					$("#datetime1").fadeIn("normal", function() {
						$("#month_block1").fadeIn("normal");
						$("#month_block2").fadeIn("normal");
						$("#date_block1").fadeOut("normal");
						$("#date_block2").fadeOut("normal");
					});
				});
				break;
			case "4":
				$("#datetime3").fadeOut("normal", function() {
					$("#datetime1").fadeIn("normal", function() {
						$("#month_block1").fadeOut("normal");
						$("#month_block2").fadeOut("normal");
						$("#date_block1").fadeOut("normal");
						$("#date_block2").fadeOut("normal");
					});
				});
				break;
			case "5":
				$("#datetime2").fadeOut("normal");
				$("#datetime1").fadeOut("normal", function() {
					$("#datetime3").fadeIn("normal");
				});
				break;
		}
	});
	$("#isMulti").click(function() {
		if($("#reportType").val()!="5") {
			var thisVal = $(this).attr("checked");
			if(thisVal) {
				$("#datetime2").fadeIn("normal");
			} else {
				$("#datetime2").fadeOut("normal");
			}
		}
	});
	$("#moreOptions").click(function() {
		if(!$("#more-options-1").is(":visible")) {
			$("#more-options-1").show();
			$("#more-options-2").show();
			$(this).val("-更多选项");
		} else {
			$("#more-options-1").hide();
			$("#more-options-2").hide();
			$(this).val("+更多选项");
		}
	});
});
