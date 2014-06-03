$(document).ready(function() {
	$(".survey_question_graph").each(function(i) {
		if($(this).find("tbody > tr").length > 0) {
			if($("#graph_bar" + (i+1)).length > 0) {
				var optionsBar = {
					chart: {
						renderTo: 'graph_bar' + (i+1),
						defaultSeriesType: 'column',
						marginRight: 30
					},
					title: {
						text: ''
					},
					xAxis: {
					},
					yAxis: {
						title: {
							text: '数量'
						}
					}
				};
				Highcharts.visualize($(this), optionsBar);
			}
		}
	});
});