/**
 * Class PromptDialog
 * @contentType	["iframe", "single", "dialog"]
 */
function PromptDialog(options) {
	this.defaultOptions = {
		width:					400,
		height:					300,
		z_index:				999,
		contentType:			"iframe",
		iframeSrc:				"#",
		maskTransparency:		"50",
		maskBackgroundColor:	"#666666",
		maskId:					"prompt_mask",
		containerId:			"prompt_container",
		contentId:				"prompt_content",
		btnId:					"prompt_close_btn",
		frameId:				"prompt_frame",
		singleId:				"prompt_single",
		dialogId:				"prompt_dialog",
		autoRender:				true,
		autoSize:				false
	};
	this.options = $.extend({}, this.defaultOptions, options);
	this.build();
}
PromptDialog.prototype = {
	build: function() {
		this.showMask();
		this.showPrompt();
		this.showContent();
		if(this.options.autoRender) {
			this.show();
		}
	},
	
	showMask: function() {
		var maskContent = "<div id=\""+this.options.maskId+"\" class=\"prompt_mask\" style=\"display:none;\"></div>";
		$("body").append(maskContent);
		$("#"+this.options.maskId).css({
			"width":			$(document).width(),
			"height":			$(document).height(),
			"top":				"0px",
			"left":				"0px",
			"z-index":			this.options.z_index,
			"background-color":	this.options.maskBackgroundColor,
			"filter":			"Alpha(opacity="+this.options.maskTransparency+")",  
			"-moz-opacity":		this.options.maskTransparency/100,
			"opacity":			this.options.maskTransparency/100
		});
		$("#"+this.options.maskId).click(function() {return false;});
		$("#"+this.options.maskId).select(function() {return false});
	},
	
	showPrompt: function() {
		var me = this;
		var promptContainer = "<div id=\""+this.options.containerId+"\" class=\"prompt_container\" style=\"display:none;\"></div>";
		var promptContent = "<div id=\""+this.options.contentId+"\" class=\"prompt_content\"></div>";
		var promptCloseBtn = "<a href=\"javascript:void(0)\" id=\""+this.options.btnId+"\" class=\"prompt_close_btn\">×</a>";
		$("body").append(promptContainer);
		$("#"+this.options.containerId).append(promptContent);
		if(this.options.contentType!="single") {
			$("#"+this.options.contentId).append(promptCloseBtn);
		}
		if(!this.options.autoSize) {
			$("#"+this.options.contentId).css({
				"width": this.options.width+"px",
				"height": this.options.height+"px"
			});
		}
		var containerWidth = $("#"+this.options.containerId).outerWidth();
		var containerHeight = $("#"+this.options.containerId).outerHeight();
		var containerTop = ($(window).height()-containerHeight)/2;
		var containerLeft = ($(window).width()-containerWidth)/2;
		$("#"+this.options.containerId).css({
			"top": containerTop,
			"left": containerLeft,
			"z-index": this.options.z_index+1
		});
		$("#"+this.options.btnId).css({
			"top": 0,
			"right": 0
		});
		$("#"+this.options.btnId).click(function() {
			me.destroy();
		});
	},
	
	showContent: function() {
		switch(this.options.contentType) {
			case "iframe":
				var content = "<iframe id=\""+this.options.frameId+"\" src=\"#\" width=\"100%\" height=\"100%\" scrolling=\"no\" frameborder=\"0\" border=\"0\"></iframe>";
				$("#"+this.options.contentId).append(content);
				$("#"+this.options.frameId).attr("src", this.options.iframeSrc);
				break;
			case "single":
				var content = "<div id=\""+this.options.singleId+"\" class=\"prompt_content_single\"></div>";
				$("#"+this.options.contentId).append(content);
				break;
		}
	},
	
	setContent: function(data) {
		if(data) {
			$("#"+this.options.singleId).empty();
			$("#"+this.options.singleId).append(data);
			this.fixPosition();
		}
		return $("#"+this.options.singleId);
	},
	
	fixPosition: function() {
		var containerWidth = $("#"+this.options.containerId).outerWidth();
		var containerHeight = $("#"+this.options.containerId).outerHeight();
		var containerTop = ($(window).height()-containerHeight)/2;
		var containerLeft = ($(window).width()-containerWidth)/2;
		$("#"+this.options.containerId).css({
			"top": containerTop,
			"left": containerLeft
		});
	},
	
	show: function() {
		$("#"+this.options.containerId).fadeIn("fast");
		$("#"+this.options.maskId).fadeIn("fast");
	},
	
	hide: function() {
		$("#"+this.options.containerId).fadeOut("fast");
		$("#"+this.options.maskId).fadeOut("fast");
	},
	
	destroy: function() {
		$("#"+this.options.containerId).fadeOut("fast", function() {
			$(this).remove();
		});
		$("#"+this.options.maskId).fadeOut("fast", function() {
			$(this).remove();
		});
	}
};