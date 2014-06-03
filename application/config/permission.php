<?php
$config['permission'] = array (
	'func_send_notice', 'func_delete_notice',

	'web_index', 'web_webs', 'web_channels', 'web_categories', 'web_tags', 'web_list', 'web_articles', 'func_upload', 'func_get_category',
	'func_get_title', 'web_slides', 'web_ads', 'web_redirects', 'web_links', 'web_notices', 'web_settings', 'web_settings_action',
	'web_users', 'web_permission', 'web_permission_action', 'web_mail', 'web_send', 'web_mail_templates', 'web_auto', 'func_get_mailtemplate',
	
	'report_index', 'report_sql', 'report_original', 'report_install', 'report_uninstall', 'report_use', 'report_function',
	'report_percentage', 'report_survey', 'report_account', 'report_relation', 'report_single_user', 'report_api_get_function',
	'report_api_get_version', 'report_actived', 'report_license',

	'operation_index', 'operation_coupon', 'operation_survey', 'operation_survey_add', 'operation_survey_template', 'operation_blacklist',
	'operation_product', 'operation_product_function', 'operation_license', 'operation_service', 'operation_exchange',

	'tool_cache'
);
$config['permission_detail'] = array (
	'web_index'				=>	array(
									'后台管理首页',
									'web/index'
								),
	'web_webs'				=>	array(
									'网站管理',
									'web/webs'
								),
	'web_channels'			=>	array(
									'频道管理',
									'web/channels'
								),
	'web_categories'		=>	array(
									'分类管理',
									'web/categories'
								),
	'web_tags'				=>	array(
									'标签管理',
									'web/tags'
								),
	'web_list'				=>	array(
									'新闻管理总览',
									'web/lists'
								),
	'web_articles'			=>	array(
									'添加新闻',
									'web/articles'
								),
	'func_upload'			=>	array(
									'上传文件',
									'web/logic/doPicUpload'
								),
	'func_get_category'		=>	array(
									'获取分类信息',
									'web/logic/getCategoryByChannel'
								),
	'func_get_title'		=>	array(
									'检查标题是否重复',
									'web/logic/getDuplicateTitle'
								),
	'web_slides'			=>	array(
									'幻灯管理总览',
									'web/slides'
								),
	'web_ads'				=>	array(
									'广告管理总览',
									'web/ads'
								),
	'web_redirects'			=>	array(
									'链接管理总览',
									'web/redirects'
								),
	'web_links'				=>	array(
									'外链管理总览',
									'web/links'
								),
	'web_notices'			=>	array(
									'内部通知管理',
									'web/notices'
								),
	'web_settings'			=>	array(
									'系统配置',
									'web/settings'
								),
	'web_settings_action'	=>	array(
									'编辑系统配置',
									'web/settings_action'
								),
	'web_users'				=>	array(
									'管理员设置',
									'web/users'
								),
	'web_permission'		=>	array(
									'权限设置',
									'web/permissions'
								),
	'web_permission_action'	=>	array(
									'添加权限',
									'web/permissions_action'
								),
	'web_mail'				=>	array(
									'邮件管理',
									'web/mails'
								),
	'web_send'				=>	array(
									'群发邮件',
									'web/sends'
								),
	'web_mail_templates'	=>	array(
									'邮件模板',
									'web/mail_templates'
								),
	'web_auto'				=>	array(
									'自动发送邮件',
									'web/autos'
								),
	'func_get_mailtemplate'	=>	array(
									'获取邮件模版内容',
									'web/logic/getMailTemplate'
								),
	'report_index'			=>	array(
									'报表中心首页',
									'report/index'
								),
	'report_sql'			=>	array(
									'高级统计报表（SQL）',
									'report/sqls'
								),
	'report_original'		=>	array(
									'原始统计报告',
									'report/originals'
								),
	'report_install'		=>	array(
									'软件安装次数统计',
									'report/installs'
								),
	'report_uninstall'		=>	array(
									'软件卸载次数统计',
									'report/uninstalls'
								),
	'report_use'			=>	array(
									'软件使用次数统计',
									'report/uses'
								),
	'report_function'		=>	array(
									'软件功能使用统计',
									'report/functions'
								),
	'report_percentage'		=>	array(
									'百分比数据统计',
									'report/percentages'
								),
	'report_survey'			=>	array(
									'调查问卷统计',
									'report/surveys'
								),
	'report_account'		=>	array(
									'用户注册量',
									'report/accounts'
								),
	'report_relation'		=>	array(
									'关联软件统计',
									'report/relations'
								),
	'report_single_user'	=>	array(
									'用户软件使用统计',
									'report/single_users'
								),
	'report_api_get_function'=>	array(
									'获取指定产品的功能列表',
									'report/api/getFunctionByProduct'
								),
	'report_api_get_version'=>	array(
									'获取指定产品的版本列表',
									'report/api/getVersionByName'
								),
	'report_actived'		=>	array(
									'激活统计报告',
									'report/activeds'
								),
	'report_license'		=>	array(
									'激活码使用情况统计报告',
									'report/licenses'
								),
	'operation_index'		=>	array(
									'运维管理中心首页',
									'operation/index'
								),
	'operation_coupon'		=>	array(
									'打折信息管理',
									'operation/coupons'
								),
	'operation_survey'		=>	array(
									'调查问卷管理',
									'operation/surveys'
								),
	'operation_survey_add'	=>	array(
									'新建调查问卷',
									'operation/survey_adds'
								),
	'operation_survey_template'	=>	array(
									'调查问卷模板管理',
									'operation/survey_templates'
								),
	'operation_license'		=>	array(
									'激活码管理',
									'operation/licenses'
								),
	'operation_blacklist'	=>	array(
									'黑名单管理',
									'operation/blacklists'
								),
	'operation_product'		=>	array(
									'产品管理',
									'operation/products'
								),
	'operation_product_function'=>array(
									'产品功能管理',
									'operation/functions'
								),
	'operation_service'		=>	array(
									'服务包信息管理',
									'operation/services'
								),
	'operation_exchange'	=>	array(
									'激活码更新管理',
									'operation/exchanges'
								),
	'tool_cache'			=>	array(
									'重建缓存',
									'tool/caches'
								)
);
?>