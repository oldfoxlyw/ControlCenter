$(document).ready(function() {
	Highcharts.visualize = function(table, options, type) {
		if(!type) type = "column";
		if(table.length > 0) {
			if(type=="pie") {
				options.title.text = $(table).find("caption").text();
				options.series[0].data = [];
				var dataStore = new Array();
				var totalNum = 0;
				$(table).find("tbody tr").each(function(i) {
					var th = $(this).find("th").text();
					var dataItem = {
						name: th,
						data: 0,
						percent: 0
					};
					$(this).find("td").each(function() {
						var currentNum = parseInt($(this).text());
						dataItem.data += currentNum;
					});
					totalNum += dataItem.data;
					dataStore.push(dataItem);
				});
				for(i=0; i<dataStore.length; i++) {
					dataStore[i].percent = Math.round((dataStore[i].data/totalNum)*10000)/100;
					options.series[0].data.push({
						name: dataStore[i].name,
						y: dataStore[i].percent
					});
				}
			} else {
				options.title.text = $(table).find("caption").text();
				options.xAxis.categories = [];
				$(table).find("thead th").each(function(i) {
					if(i > 0) {
						options.xAxis.categories.push(this.innerText);
					}
				});
				options.series = [];
				$(table).find("tbody tr").each(function(i) {
					var tr = this;
					var th = $(tr).find("th").text();
					options.series[i] = {
						name: th,
						data: []
					};
					$(tr).find("td").each(function(j) {
						options.series[i].data.push({
							name: th,
							y: parseInt($(this).text())
						});
					});
				});
			}
			var chart1 = new Highcharts.Chart(options);
		}
	};
	if($("#report_graph > tbody > tr").length > 0) {
		if($("#graph_area").length > 0) {
			var optionsArea = {
				chart: {
					renderTo: 'graph_area',
					defaultSeriesType: 'area',
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
			Highcharts.visualize($("#report_graph"), optionsArea);
		}
		if($("#graph_bar").length > 0) {
			var optionsBar = {
				chart: {
					renderTo: 'graph_bar',
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
			Highcharts.visualize($("#report_graph"), optionsBar);
		}
		if($("#graph_line").length > 0) {
			var optionsBar = {
				chart: {
					renderTo: 'graph_line',
					defaultSeriesType: 'line',
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
			Highcharts.visualize($("#report_graph"), optionsBar);
		}
		if($("#graph_pie").length > 0) {
			var optionsPie = {
					chart: {
						renderTo: 'graph_pie',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: ''
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: Highcharts.theme.textColor || '#000000',
								connectorColor: Highcharts.theme.textColor || '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
								}
							},
							showInLegend: true
						}
					},
					series: [{
						type: 'pie',
						name: 'Pie',
						data: []
					}]
				};
			Highcharts.visualize($("#report_graph"), optionsPie, 'pie');
		}
	}
});