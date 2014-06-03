$(document).ready(function() {
	$("#newsSubmit").click(function() {
		var newsTitle = $("#newsTitle").val();
		var newsSEOTitle = $("#newsSEOTitle").val();
		var seoError = $("#seoError").val();
		var newsChannel = $("#newsChannel").val();
		var newsCategory = $("#newsCategory").val();
		var newsContent = CKEDITOR.instances.newsContent.getData();
		if(!newsTitle) {
			alert("请填写标题");
			return false;
		}
		if(!newsSEOTitle) {
			alert("请填写静态页面标题");
			return false;
		} else {
			newsSEOTitle = newsSEOTitle.replace(/ +/g, "-");
			$("#newsSEOTitle").val(newsSEOTitle);
		}
		if(seoError=="1") {
			alert("静态页面标题已存在，请换一个标题");
			return false;
		}
		if(newsChannel=="0") {
			alert("请选择频道");
			return false;
		}
		if(!newsCategory || newsCategory=="0") {
			alert("请选择分类");
			return false;
		}
		if(!newsContent) {
			alert("请填写内容");
			return false;
		}
	});
	$("#newsChannel").change(function() {
		var keyValue = $("#newsChannel").val();
		if(keyValue) {
			$.post("general_api/getCategoryByChannel", {
				cid: keyValue
			}, callbackHandler);
		}
	});
	$(".tags_a").click(function() {
		if($("#newsTags").val()=="") {
			$("#newsTags").val($(this).text());
		} else {
			$("#newsTags").val($("#newsTags").val() + "," + $(this).text());
		}
	});
	$("#newsTitle").blur(function() {
		var text = $(this).val();
		if(text) {
			text = text.replace(/ +/g, "-");
			$("#newsSEOTitle").val(text.toLowerCase());
		}
	});
	$("#newsSEOTitle").blur(function() {
		$.post("general_api/getDuplicateTitle", {
			title: $(this).val()
		}, getDuplicationTitleHandler);
	});
	$("#ads_standby div.slide-item-wrap").click(function() {
		var newsAdList = $("#newsAdId").val();
		if($(this).hasClass("slide-selected")) {
			var adId = $(this).find(".ad_id").text();
			var indexOfArray = newsAdList.indexOf(adId);
			if(indexOfArray!=-1) {
				if(newsAdList.indexOf(",")!=-1) {
					if(indexOfArray==0) {
						newsAdList = newsAdList.replace(adId+",", "");
					} else {
						newsAdList = newsAdList.replace(","+adId, "");
					}
				} else {
					newsAdList = newsAdList.replace(adId, "");
				}
				$("#newsAdId").val(newsAdList);
			}
			$(this).removeClass("slide-selected");
			$(this).find("div.slide-check").hide();
		} else {
			if(newsAdList) {
				$("#newsAdId").val($("#newsAdId").val() + "," + $(this).find("div.ad_id").text());
			} else {
				$("#newsAdId").val($(this).find(".ad_id").text());
			}
			$(this).addClass("slide-selected");
			$(this).find("div.slide-check").show();
		}
	});
	var newsAdsList = $("#newsAdId").val();
	if(newsAdsList!="") {
		var adsList = newsAdsList.split(",");
		$("#ads_standby").find("div.slide-item-wrap").each(function() {
			var adId = $(this).find("div.ad_id").text();
			if(adsList.in_array(adId)) {
				$(this).addClass("slide-selected");
				$(this).find("div.slide-check").show();
			}
		});
	}
});
Array.prototype.in_array = function(e){
	for(i=0;i<this.length && this[i]!=e;i++);
	return !(i==this.length);
}

function callbackHandler (data) {
	var jsonData = eval("(" + data + ")");
	$("#newsCategory").empty();
	for(var i=0; i<jsonData.field.length; i++) {
		$("#newsCategory").append("<option value=\"" + jsonData.field[i].id + "\">" + jsonData.field[i].name + "</option>");
	}
}

function getDuplicationTitleHandler (data) {
	data = trim(data);
	if(data=="error") {
		$("#info_error").show();
		$("#seoError").val("1");
	} else {
		$("#info_error").hide();
		$("#seoError").val("0");
	}
}

function trim(str) {
	return str.replace(/(^\s*)|(\s*$)/g, "");
}