var currentPage = 1;
var totalPage = 0;
var blockWidth = 460;
var blockHeight = 300;
var scrollDirection = "left";
$(document).ready(function() {
	totalPage = $("#ads_standby").find("div.slide-block").length;
	var slideContainer = $("#ads_standby").find("div.slide-container");
	$("#pageUp").click(function() {
		if(totalPage > 1) {
			if(currentPage == 1) {
				currentPage = totalPage;
			} else {
				currentPage--;
			}
			var tagetLeft = (currentPage - 1) * blockWidth;
			slideContainer.animate( { "left": "-" + tagetLeft + "px"}, { queue: false, duration: "normal" } );
		}
	});
	$("#pageDown").click(function() {
		if(totalPage > 1) {
			if(currentPage == totalPage) {
				currentPage = 1;
			} else {
				currentPage++;
			}
			var tagetLeft = (currentPage - 1) * blockWidth;
			slideContainer.animate( { "left": "-" + tagetLeft + "px" }, { queue: false, duration: "normal" } );
		}
	});
});