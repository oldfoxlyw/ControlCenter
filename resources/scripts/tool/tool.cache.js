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
	$("input.data-picker").datepicker();
	
	$("#cacheTimeEnable").click(function() {
		if($(this).attr("checked")) {
			$("#cacheTime").attr("disabled", false);
		} else {
			$("#cacheTime").attr("disabled", true);
		}
	});
	
	$("#startCache").click(function() {
		$(this).parent().prev().show();
		$(this).parent().hide();
		$("#message").empty();
		$("#message").hide();
		var cacheDataVal = "0";
		var cacheIndexDataVal = "0";
		if($("#cacheData").attr("checked")) {
			cacheDataVal = "1";
		}
		if($("#cacheIndexData").attr("checked")) {
			cacheIndexDataVal = "1";
		}
		if($("#cacheTimeEnable").attr("checked") && $("#cacheTime").val()) {
			var timeStamp = Date.parse($("#cacheTime").val() + "10:00:00") / 1000;
		} else {
			var timeStamp = Date.parse(new Date()) / 1000;
		}
		var parameter = {
			cacheData: cacheDataVal,
			cacheTime: timeStamp
		};
		$.post("/ControlCenter/api/caches/rebuidCache/json", parameter, cacheCallback1);
	});
	
	var cacheCallback1 = function(data) {
		if(data) {
			var message = "<ul>";
			var json = eval("(" + data + ")");
			for(i in json.field) {
				if(json.field[i].result) {
					if(json.field[i].result=="API_CACHE_WRITE_ERROR") {
						message += "<li><span class=\"red bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_ALL_SUCCESS" || json.field[i].result=="API_CACHE_CPU_SUCCESS" || json.field[i].result=="API_CACHE_PRODUCT_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					}
				}
			}
			message += "</ul>";
			$("#message").html(message);
			$("#message").show();
			
			var cacheIndexDataVal = "0";
			if($("#cacheIndexData").attr("checked")) {
				cacheIndexDataVal = "1";
			}
			if($("#cacheTimeEnable").attr("checked") && $("#cacheTime").val()) {
				var timeStamp = Date.parse($("#cacheTime").val() + " 10:00:00") / 1000;
			} else {
				var timeStamp = Date.parse(new Date()) / 1000;
			}
			var parameter = {
				cacheIndexDataAll: cacheIndexDataVal,
				cacheTime: timeStamp
			};
			$.post("/ControlCenter/api/caches/rebuidCache/json", parameter, cacheCallback2);
		}
	};
	
	var cacheCallback2 = function(data) {
		if(data) {
			var message = "";
			var json = eval("(" + data + ")");
			for(i in json.field) {
				if(json.field[i].result) {
					if(json.field[i].result=="API_CACHE_WRITE_ERROR") {
						message += "<li><span class=\"red bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_ALL_SUCCESS" || json.field[i].result=="API_CACHE_CPU_SUCCESS" || json.field[i].result=="API_CACHE_PRODUCT_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					}
				}
			}
			$("#message").find("ul").append(message);
			
			var cacheIndexDataVal = "0";
			if($("#cacheIndexData").attr("checked")) {
				cacheIndexDataVal = "1";
			}
			if($("#cacheTimeEnable").attr("checked") && $("#cacheTime").val()) {
				var timeStamp = Date.parse($("#cacheTime").val() + " 10:00:00") / 1000;
			} else {
				var timeStamp = Date.parse(new Date()) / 1000;
			}
			var parameter = {
				cacheIndexDataCpu: cacheIndexDataVal,
				cacheTime: timeStamp
			};
			$.post("/ControlCenter/api/caches/rebuidCache/json", parameter, cacheCallback3);
		}
	};
	
	var cacheCallback3 = function(data) {
		if(data) {
			var message = "";
			var json = eval("(" + data + ")");
			for(i in json.field) {
				if(json.field[i].result) {
					if(json.field[i].result=="API_CACHE_WRITE_ERROR") {
						message += "<li><span class=\"red bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_ALL_SUCCESS" || json.field[i].result=="API_CACHE_CPU_SUCCESS" || json.field[i].result=="API_CACHE_PRODUCT_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					}
				}
			}
			$("#message").find("ul").append(message);
			
			var cacheIndexDataVal = "0";
			if($("#cacheIndexData").attr("checked")) {
				cacheIndexDataVal = "1";
			}
			if($("#cacheTimeEnable").attr("checked") && $("#cacheTime").val()) {
				var timeStamp = Date.parse($("#cacheTime").val() + " 10:00:00") / 1000;
			} else {
				var timeStamp = Date.parse(new Date()) / 1000;
			}
			var parameter = {
				cacheIndexDataProduct: cacheIndexDataVal,
				cacheTime: timeStamp
			};
			$.post("/ControlCenter/api/caches/rebuidCache/json", parameter, cacheCallback4);
		}
	};
	
	var cacheCallback4 = function(data) {
		if(data) {
			var message = "";
			var json = eval("(" + data + ")");
			for(i in json.field) {
				if(json.field[i].result) {
					if(json.field[i].result=="API_CACHE_WRITE_ERROR") {
						message += "<li><span class=\"red bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					} else if(json.field[i].result=="API_CACHE_ALL_SUCCESS" || json.field[i].result=="API_CACHE_CPU_SUCCESS" || json.field[i].result=="API_CACHE_PRODUCT_SUCCESS") {
						message += "<li><span class=\"green bold\">" + json.field[i].message + "</span></li>";
					}
				}
			}
			$("#message").find("ul").append(message);
		}
		$("#startCache").parent().prev().hide();
		$("#startCache").parent().show();
	}
});