$(document).ready(function() {
	$("#web_all").click(function() {
		if($(this).attr("checked")) {
			$("#global_control").attr("checked", true);
			$("#news_control").attr("checked", true);
			$("#slide_control").attr("checked", true);
			$("#ad_control").attr("checked", true);
			$("#resource_control").attr("checked", true);
			$("#system_control").attr("checked", true);
			$("#mail_control").attr("checked", true);
			$("#index").attr("checked", true);
			$("#webs").attr("checked", true);
			$("#channels").attr("checked", true);
			$("#categories").attr("checked", true);
			$("#list").attr("checked", true);
			$("#news").attr("checked", true);
			$("#web_tags").attr("checked", true);
			$("#func_upload").attr("checked", true);
			$("#func_get_category").attr("checked", true);
			$("#func_get_title").attr("checked", true);
			$("#slides").attr("checked", true);
			$("#func_slides_upload").attr("checked", true);
			$("#ads").attr("checked", true);
			$("#func_ads_upload").attr("checked", true);
			$("#products").attr("checked", true);
			$("#links").attr("checked", true);
			$("#users").attr("checked", true);
			$("#permission").attr("checked", true);
			$("#permission_action").attr("checked", true);
			$("#mail").attr("checked", true);
			$("#send").attr("checked", true);
			$("#mail_templates").attr("checked", true);
			$("#auto").attr("checked", true);
			$("#func_get_mailtemplate").attr("checked", true);
		} else {
			$("#global_control").attr("checked", false);
			$("#news_control").attr("checked", false);
			$("#slide_control").attr("checked", false);
			$("#ad_control").attr("checked", false);
			$("#resource_control").attr("checked", false);
			$("#system_control").attr("checked", false);
			$("#mail_control").attr("checked", false);
			$("#index").attr("checked", false);
			$("#webs").attr("checked", false);
			$("#channels").attr("checked", false);
			$("#categories").attr("checked", false);
			$("#list").attr("checked", false);
			$("#news").attr("checked", false);
			$("#web_tags").attr("checked", false);
			$("#func_upload").attr("checked", false);
			$("#func_get_category").attr("checked", false);
			$("#func_get_title").attr("checked", false);
			$("#slides").attr("checked", false);
			$("#func_slides_upload").attr("checked", false);
			$("#ads").attr("checked", false);
			$("#func_ads_upload").attr("checked", false);
			$("#products").attr("checked", false);
			$("#links").attr("checked", false);
			$("#users").attr("checked", false);
			$("#permission").attr("checked", false);
			$("#permission_action").attr("checked", false);
			$("#mail").attr("checked", false);
			$("#send").attr("checked", false);
			$("#mail_templates").attr("checked", false);
			$("#auto").attr("checked", false);
			$("#func_get_mailtemplate").attr("checked", false);
		}
	});
	$("#report_all").click(function() {
		if($(this).attr("checked")) {
			$("#report_use_control").attr("checked", true);
			$("#report_detail_control").attr("checked", true);
			$("#report_active_control").attr("checked", true);
			$("#report_api_control").attr("checked", true);
			$("#report_index").attr("checked", true);
			$("#report_original").attr("checked", true);
			$("#report_install").attr("checked", true);
			$("#report_uninstall").attr("checked", true);
			$("#report_use").attr("checked", true);
			$("#report_function").attr("checked", true);
			$("#report_percentage").attr("checked", true);
			$("#report_account").attr("checked", true);
			$("#report_relation").attr("checked", true);
			$("#report_single_user").attr("checked", true);
			$("#report_actived").attr("checked", true);
			$("#report_license").attr("checked", true);
			$("#report_api_get_function").attr("checked", true);
			$("#report_api_get_version").attr("checked", true);
		} else {
			$("#report_use_control").attr("checked", false);
			$("#report_detail_control").attr("checked", false);
			$("#report_active_control").attr("checked", false);
			$("#report_api_control").attr("checked", false);
			$("#report_index").attr("checked", false);
			$("#report_original").attr("checked", false);
			$("#report_install").attr("checked", false);
			$("#report_uninstall").attr("checked", false);
			$("#report_use").attr("checked", false);
			$("#report_function").attr("checked", false);
			$("#report_percentage").attr("checked", false);
			$("#report_account").attr("checked", false);
			$("#report_relation").attr("checked", false);
			$("#report_single_user").attr("checked", false);
			$("#report_actived").attr("checked", false);
			$("#report_license").attr("checked", false);
			$("#report_api_get_function").attr("checked", false);
			$("#report_api_get_version").attr("checked", false);
		}
	});
	$("#operation_all").click(function() {
		if($(this).attr("checked")) {
			$("#operate_sell_control").attr("checked", true);
			$("#operate_license_control").attr("checked", true);
			$("#operation_index").attr("checked", true);
			$("#operation_coupon").attr("checked", true);
			$("#operation_blacklist").attr("checked", true);
		} else {
			$("#operate_sell_control").attr("checked", false);
			$("#operate_license_control").attr("checked", false);
			$("#operation_index").attr("checked", false);
			$("#operation_coupon").attr("checked", false);
			$("#operation_blacklist").attr("checked", false);
		}
	});
	$("#global_control").click(function() {
		if($(this).attr("checked")) {
			$("#webs").attr("checked", true);
			$("#channels").attr("checked", true);
			$("#categories").attr("checked", true);
		} else {
			$("#webs").attr("checked", false);
			$("#channels").attr("checked", false);
			$("#categories").attr("checked", false);
		}
	});
	$("#news_control").click(function() {
		if($(this).attr("checked")) {
			$("#list").attr("checked", true);
			$("#news").attr("checked", true);
			$("#web_tags").attr("checked", true);
			$("#func_upload").attr("checked", true);
			$("#func_get_category").attr("checked", true);
			$("#func_get_title").attr("checked", true);
		} else {
			$("#list").attr("checked", false);
			$("#news").attr("checked", false);
			$("#web_tags").attr("checked", false);
			$("#func_upload").attr("checked", false);
			$("#func_get_category").attr("checked", false);
			$("#func_get_title").attr("checked", false);
		}
	});
	$("#slide_control").click(function() {
		if($(this).attr("checked")) {
			$("#slides").attr("checked", true);
			$("#func_slides_upload").attr("checked", true);
		} else {
			$("#slides").attr("checked", false);
			$("#func_slides_upload").attr("checked", false);
		}
	});
	$("#ad_control").click(function() {
		if($(this).attr("checked")) {
			$("#ads").attr("checked", true);
			$("#func_ads_upload").attr("checked", true);
		} else {
			$("#ads").attr("checked", false);
			$("#func_ads_upload").attr("checked", false);
		}
	});
	$("#resource_control").click(function() {
		if($(this).attr("checked")) {
			$("#products").attr("checked", true);
			$("#links").attr("checked", true);
		} else {
			$("#products").attr("checked", false);
			$("#links").attr("checked", false);
		}
	});
	$("#system_control").click(function() {
		if($(this).attr("checked")) {
			$("#users").attr("checked", true);
			$("#permission").attr("checked", true);
			$("#permission_action").attr("checked", true);
		} else {
			$("#users").attr("checked", false);
			$("#permission").attr("checked", false);
			$("#permission_action").attr("checked", false);
		}
	});
	$("#mail_control").click(function() {
		if($(this).attr("checked")) {
			$("#mail").attr("checked", true);
			$("#send").attr("checked", true);
			$("#mail_templates").attr("checked", true);
			$("#auto").attr("checked", true);
			$("#func_get_mailtemplate").attr("checked", true);
		} else {
			$("#mail").attr("checked", false);
			$("#send").attr("checked", false);
			$("#mail_templates").attr("checked", false);
			$("#auto").attr("checked", false);
			$("#func_get_mailtemplate").attr("checked", false);
		}
	});
	$("#report_use_control").click(function() {
		if($(this).attr("checked")) {
			$("#report_original").attr("checked", true);
			$("#report_install").attr("checked", true);
			$("#report_uninstall").attr("checked", true);
			$("#report_use").attr("checked", true);
			$("#report_function").attr("checked", true);
			$("#report_percentage").attr("checked", true);
			$("#report_account").attr("checked", true);
		} else {
			$("#report_original").attr("checked", false);
			$("#report_install").attr("checked", false);
			$("#report_uninstall").attr("checked", false);
			$("#report_use").attr("checked", false);
			$("#report_function").attr("checked", false);
			$("#report_percentage").attr("checked", false);
			$("#report_account").attr("checked", false);
		}
	});
	$("#report_detail_control").click(function() {
		if($(this).attr("checked")) {
			$("#report_relation").attr("checked", true);
			$("#report_single_user").attr("checked", true);
		} else {
			$("#report_relation").attr("checked", false);
			$("#report_single_user").attr("checked", false);
		}
	});
	$("#report_active_control").click(function() {
		if($(this).attr("checked")) {
			$("#report_actived").attr("checked", true);
			$("#report_license").attr("checked", true);
		} else {
			$("#report_actived").attr("checked", false);
			$("#report_license").attr("checked", false);
		}
	});
	$("#report_api_control").click(function() {
		if($(this).attr("checked")) {
			$("#report_api_get_function").attr("checked", true);
			$("#report_api_get_version").attr("checked", true);
		} else {
			$("#report_api_get_function").attr("checked", false);
			$("#report_api_get_version").attr("checked", false);
		}
	});
	$("#operate_sell_control").click(function() {
		if($(this).attr("checked")) {
			$("#operation_coupon").attr("checked", true);
		} else {
			$("#operation_coupon").attr("checked", false);
		}
	});
	$("#operate_license_control").click(function() {
		if($(this).attr("checked")) {
			$("#operation_blacklist").attr("checked", true);
		} else {
			$("#operation_blacklist").attr("checked", false);
		}
	});
});