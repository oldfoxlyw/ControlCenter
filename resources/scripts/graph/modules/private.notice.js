/**
 * Class Notice
 */
function Notice(options) {
	this.defaultOptions = {
		iconType: "warning",
		dataType: "latest",
		dataFormat: "json",
		url: "/scc/private_api/getNotice.php",
		delay: 30000,
		containerId: "notice_container",
		rootPath: "/scc/"
	};
	this.options = $.extend({}, this.defaultOptions, options);
	this.timer = null;
	this.build();
}
Notice.prototype = {
	build: function() {
		var me = this;
		this.buildNoticeContainer();
		this.buildNoticeBtn();
		this.buildNoticeContent();
		$("#"+this.options.containerId+" > p.closestatus > a").click(function() {
			$("#"+me.options.containerId).fadeOut("normal" ,function() {
				
			});
		});
		$(window).scroll(function(){
			$("#"+me.options.containerId).css("top", $(document).scrollTop());
		});
		this.timer = setInterval(function() {
			me.getNotice();
		}, this.options.delay);
	},
	buildNoticeContainer: function() {
		var container = "<div id=\""+this.options.containerId+"\" class=\"status "+this.options.iconType+" private_notice\" style=\"display:none;\"></div>";
		$(document.body).append(container);
		$("#"+this.options.containerId).css({
			width: $(document).width()-30
		});
	},
	buildNoticeBtn: function() {
		var btn = "<p class=\"closestatus\"><a href=\"javascript:void(0)\" title=\"Close\">x</a></p>";
		$("#"+this.options.containerId).append(btn);
	},
	buildNoticeContent: function() {
		var content = "<p class=\"notice_content\"><img src=\""+this.options.rootPath+"img/icons/icon_"+this.options.iconType+".png\" alt=\""+this.options.iconType+"\" /><span>注意!</span>&nbsp;&nbsp;<strong></strong></p>";
		$("#"+this.options.containerId).append(content);
	},
	getNotice: function() {
		var parameter = {
			type: this.options.dataType,
			format: this.options.dataFormat
		};
		var me = this;
		$.post(this.options.url, parameter, function(data) {
			me.getNoticeHandler(data);
		});
	},
	getNoticeHandler: function(data) {
		var json = eval("("+data+")");
		if(json.response=="NOTICE_SUCCESS") {
			var currentTime = Math.round(new Date().getTime()/1000);
			//if(json.endTime > currentTime) {
			//	
			//}
			var diffTime = json.end_time - currentTime;
			$("#"+this.options.containerId).find("p.notice_content > strong").empty();
			$("#"+this.options.containerId).find("p.notice_content > strong").append(json.message);
			$("#"+this.options.containerId).find("p.notice_content > strong").append("(距离结束还有"+diffTime+"秒)");
			$("#"+this.options.containerId).fadeIn("normal");
		} else if(json.response=="NOTICE_NOT_EXIST") {
			$("#"+this.options.containerId).hide();
		}
	}
}