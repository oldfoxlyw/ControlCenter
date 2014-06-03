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
	$("#notice_endtime").datepicker();
	$("#quickSelect").change(function() {
		var value = $(this).val();
		var currentTimeStamp = Math.round(new Date().getTime()/1000);
		switch(value) {
			case "1":
				currentTimeStamp += (24 * 60 * 60);
				break;
			case "2":
				currentTimeStamp += (60 * 60);
				break;
			case "3":
				currentTimeStamp += (30 * 60);
				break;
			case "4":
				currentTimeStamp += (10 * 60);
				break;
		}
		if(value!="0") {
			var currentDate = new Date();
			currentDate.setTime(currentTimeStamp * 1000);
			$("#notice_endtime").val(currentDate.getFullYear() + "-" + (currentDate.getMonth()+1) + "-" + currentDate.getDate());
			$("#notice_endtime_hour").val(currentDate.getHours());
			$("#notice_endtime_minute").val(currentDate.getMinutes());
			$("#notice_endtime_second").val(currentDate.getSeconds());
		}
	});
});