$(document).ready(function() {
	$("table.google-table-style tr").unbind("mouseover").unbind("mouseout");
	$("#index_data_sortable").tablesorter();
	$("#index_data_sortable").bind("sortEnd",function() { 
		$("#index_data_sortable > tbody").find("tr").each(function(i) {
			if(i%2==0) {
				$(this).addClass("alt-row");
			} else {
				$(this).removeClass("alt-row");
			}
		});
    });
	$("#index_data_sortable > thead > tr > th > div.th-title > a").click(function() {
		target = $(this).attr("href");
		window.location.href = target;
	});
});