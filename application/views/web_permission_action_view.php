		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					Download From <a href="http://www.exet.tk">exet.tk</a></div>
				</div>
			</noscript>
			
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>新建权限</h3>
					<ul class="content-box-tabs">
                        <li><input class="button" type="button" value="返回权限列表" onclick="window.location='<?php echo $root_path; ?>web/permissions'" /></li>
					</ul>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                    <form action="permissions_action/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                    	<fieldset>
                        <p>
                            <label>权限等级</label>
                            <input name="permissionId" type="text" class="text-input small-input" id="permissionId" value="<?php echo $permission_id; ?>" <?php echo $read_only; ?> />
                            <input name="permissionIdHidden" type="hidden" id="permissionIdHidden" value="<?php echo $permission_id; ?>" />
              				<input name="permissionUpdate" type="hidden" id="permissionUpdate" value="<?php echo $permission_update; ?>" />
                            <input name="permissionType" type="hidden" id="permissionType" value="<?php echo $permission_type; ?>" />
                            <input name="GUID" type="hidden" id="GUID" value="<?php echo $guid; ?>" />
                            <span class="input-notification attention png_bg">0-1000以内的数字，不包括1000</span>
                            <br /><small>根据权限等级的高低，低等级的管理员不能管理高等级的管理员，高等级的管理员优先权高</small>
                        </p>
                        <p>
                            <label>权限等级</label>
                            <input name="permissionName" type="text" class="text-input small-input" id="permissionName" value="<?php echo $permission_name; ?>" <?php echo $read_only; ?> />
                            <span class="input-notification attention png_bg">3-10个中文或英文字符</span>
                            <br /><small>描述权限的名称</small>
                        </p>
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_list">
                          <tr>
                            <th colspan="5" style="font-size:14px;font-weight:bold;">
            					通用接口
                            </th>
                          </tr>
                          <tr>
                            <th width="20%" style="font-size:14px;font-weight:bold;">
                            <input name="global_api_control" type="checkbox" id="global_api_control" value="1" /> 
                                全局接口</th>
                            <td width="20%">
                              <input name="func_send_notice" type="checkbox" id="func_send_notice" value="func_send_notice" <?php echo $func_send_notice; ?> /> 
                                发送短消息
                            </td>
                            <td width="20%">
                              <input name="func_delete_notice" type="checkbox" id="func_delete_notice" value="func_delete_notice" <?php echo $func_delete_notice; ?> /> 
                                删除短消息
                            </td>
                            <td width="20%">&nbsp;</td>
                            <td width="20%">&nbsp;</td>
                          </tr>
                          <tr>
                            <th colspan="5" style="font-size:14px;font-weight:bold;">
                            	<input name="web_all" type="checkbox" id="web_all" value="web_all" /> 
            					网站管理中心 - 
                           	  <input name="web_index" type="checkbox" id="web_index" value="web_index" <?php echo $web_index; ?> /> 
                            	首页访问
                            </th>
                          </tr>
                          <tr>
                            <th width="20%" style="font-size:14px;font-weight:bold;">
                                <input name="global_control" type="checkbox" id="global_control" value="1" /> 
                                全局功能                            </th>
                            <td width="20%">
                              <input name="web_webs" type="checkbox" id="web_webs" value="web_webs" <?php echo $web_webs; ?> /> 
                                选择当前操作网站
                            </td>
                            <td width="20%">
                              <input name="web_channels" type="checkbox" id="web_channels" value="web_channels" <?php echo $web_channels; ?> /> 
                                频道管理
                            </td>
                            <td width="20%">
                           	  <input name="web_categories" type="checkbox" id="web_categories" value="web_categories" <?php echo $web_categories; ?> /> 
              					分类管理
                            </td>
                            <td width="20%"><input name="func_upload" type="checkbox" id="func_upload" value="func_upload" <?php echo $func_upload; ?> /> 
                            图片上传</td>
                          </tr>
                          <tr> 
                            <th rowspan="3" style="font-size:14px;font-weight:bold;"><input name="news_control" type="checkbox" id="news_control" value="1" /> 
                            新闻管理</th> 
                            <td><input name="web_list" type="checkbox" id="web_list" value="web_list" <?php echo $web_list; ?> /> 
                            新闻列表</td> 
                            <td><input name="web_articles" type="checkbox" id="web_articles" value="web_articles" <?php echo $web_articles; ?> /> 
                            添加新闻</td> 
                            <td><input name="web_tags" type="checkbox" id="web_tags" value="web_tags" <?php echo $web_tags; ?> /> 
                			标签管理</td> 
                            <td>&nbsp;</td> 
                          </tr>
                          <tr style="border-top:#666666 3px solid;"> 
                            <th colspan="4" style="font-size:14px;font-weight:bold;">以下为添加新闻功能所需要使用的接口</th> 
                          </tr>
                          <tr> 
                            <td><input name="func_get_category" type="checkbox" id="func_get_category" value="func_get_category" <?php echo $func_get_category; ?> /> 
                            根据频道获取分类</td> 
                            <td><input name="func_get_title" type="checkbox" id="func_get_title" value="func_get_title" <?php echo $func_get_title; ?> /> 
                              判定是否存在相同标题</td> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="slide_control" type="checkbox" id="slide_control" value="1" /> 
                            幻灯管理</th>
                            <td><input name="web_slides" type="checkbox" id="web_slides" value="web_slides" <?php echo $web_slides; ?> /> 
                              幻灯列表</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="ad_control" type="checkbox" id="ad_control" value="1" />
                            广告管理</th>
                            <td><input name="web_ads" type="checkbox" id="web_ads" value="web_ads" <?php echo $web_ads; ?> />
                            广告列表</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="resource_control" type="checkbox" id="resource_control" value="1" />
                            资源管理</th>
                            <td><input name="web_redirects" type="checkbox" id="web_redirects" value="web_redirects" <?php echo $web_redirects; ?> />
                            链接管理</td>
                            <td><input name="web_links" type="checkbox" id="web_links" value="web_links" <?php echo $web_links; ?> />
                            外链管理</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr> 
                            <th rowspan="2" style="font-size:14px;font-weight:bold;"><input name="system_control" type="checkbox" id="system_control" value="1" /> 
                            系统设置</th> 
                            <td><input name="web_users" type="checkbox" id="web_users" value="web_users" <?php echo $web_users; ?> /> 
                              管理员设置</td> 
                            <td><input name="web_permission" type="checkbox" id="web_permission" value="web_permission" <?php echo $web_permission; ?> /> 
                              权限列表</td> 
                            <td><input name="web_permissions_action" type="checkbox" id="web_permissions_action" value="web_permission_action" <?php echo $web_permission_action; ?> /> 
                              添加权限</td> 
                            <td>&nbsp;</td> 
                          </tr> 
                          <tr> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                          </tr>
                          <tr> 
                            <th rowspan="3" style="font-size:14px;font-weight:bold;"><input name="mail_control" type="checkbox" id="mail_control" value="1" /> 
                            邮件管理</th> 
                            <td><input name="web_mail" type="checkbox" id="web_mail" value="web_mail" <?php echo $web_mail; ?> /> 
                              邮件列表（用户列表）</td> 
                            <td><input name="web_send" type="checkbox" id="web_send" value="web_send" <?php echo $web_send; ?> /> 
                              群发邮件</td> 
                            <td><input name="web_mail_templates" type="checkbox" id="web_mail_templates" value="web_mail_templates" <?php echo $web_mail_templates; ?> /> 
                            邮件模版</td> 
                            <td><input name="web_auto" type="checkbox" id="web_auto" value="web_auto" <?php echo $web_auto; ?> /> 
                            自动发送邮件</td> 
                          </tr> 
                          <tr style="border-top:#666666 3px solid;"> 
                            <th colspan="4" style="font-size:14px;font-weight:bold;">以下为群发邮件功能所需要使用的接口</th> 
                          </tr> 
                          <tr> 
                            <td><input name="func_get_mailtemplate" type="checkbox" id="func_get_mailtemplate" value="func_get_mailtemplate" <?php echo $func_get_mailtemplate; ?> /> 
                            获取邮件模版内容</td> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                            <td>&nbsp;</td> 
                          </tr> 
                          <tr> 
                            <th colspan="5" style="font-size:14px;font-weight:bold;"><input name="report_all" type="checkbox" id="report_all" value="report_all" /> 
                            报表分析中心 - 
                              <input name="report_index" type="checkbox" id="report_index" value="report_index" <?php echo $report_index; ?> /> 
                            首页访问</th> 
                          </tr> 
                          <tr>
                            <th rowspan="2" style="font-size:14px;font-weight:bold;"> <input name="report_use_control" type="checkbox" id="report_use_control" value="1" />
                            软件使用情况统计报表 </th>
                            <td><input name="report_original" type="checkbox" id="report_original" value="report_original" <?php echo $report_original; ?> />
                            原始统计报表</td>
                            <td><input name="report_install" type="checkbox" id="report_install" value="report_install" <?php echo $report_install; ?> />
                              软件安装次数统计</td>
                            <td><input name="report_uninstall" type="checkbox" id="report_uninstall" value="report_uninstall" <?php echo $report_uninstall; ?> />
                              软件卸载次数统计</td>
                            <td><input name="report_use" type="checkbox" id="report_use" value="report_use" <?php echo $report_use; ?> />
                            软件使用次数统计</td>
                          </tr>
                          <tr>
                            <td><input name="report_function" type="checkbox" id="report_function" value="report_function" <?php echo $report_function; ?> />
                            软件功能使用统计统计</td>
                            <td><input name="report_percentage" type="checkbox" id="report_percentage" value="report_percentage" <?php echo $report_percentage; ?> />
                              百分比数据统计</td>
                            <td><input name="report_account" type="checkbox" id="report_account" value="report_account" <?php echo $report_account; ?> />
                              用户注册量统计</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="report_detail_control" type="checkbox" id="report_detail_control" value="1" />
                            软件详细数据统计报表</th>
                            <td><input name="report_relation" type="checkbox" id="report_relation" value="report_relation" <?php echo $report_relation; ?> />
                              软件使用统计(附带关联信息)</td>
                            <td><input name="report_single_user" type="checkbox" id="report_single_user" value="report_single_user" <?php echo $report_single_user; ?> />
                              单用户软件使用情况统计</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="report_active_control" type="checkbox" id="report_active_control" value="1" />
                            软件激活情况统计报表</th>
                            <td><input name="report_actived" type="checkbox" id="report_actived" value="report_actived" <?php echo $report_actived; ?> />
                            激活统计报告</td>
                            <td><input name="report_license" type="checkbox" id="report_license" value="report_license" <?php echo $report_license; ?> />
                            激活码使用情况统计报告</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="report_api_control" type="checkbox" id="report_api_control" value="1" />
                            报表中心数据接口</th>
                            <td><input name="report_api_get_function" type="checkbox" id="report_api_get_function" value="report_api_get_function" <?php echo $report_api_get_function; ?> />
                              获取软件功能列表</td>
                            <td><input name="report_api_get_version" type="checkbox" id="report_api_get_version" value="report_api_get_version" <?php echo $report_api_get_version; ?> />
                              获取软件版本列表</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <th colspan="5" style="font-size:14px;font-weight:bold;"><input name="operation_all" type="checkbox" id="operation_all" value="operation_all" />
                            运维管理中心 - 
                              <input name="operation_index" type="checkbox" id="operation_index" value="operation_index" <?php echo $operation_index; ?> />
                            首页访问</th>
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="operate_sell_control" type="checkbox" id="operate_sell_control" value="1" />
                            营销策略管理</th>
                            <td><input name="operation_coupon" type="checkbox" id="operation_coupon" value="operation_coupon" <?php echo $operation_coupon; ?> />
                              打折信息管理</td>
                            <td><input name="operation_survey" type="checkbox" id="operation_survey" value="operation_survey" <?php echo $operation_survey; ?> />
							调查问卷管理</td>
                            <td><input name="operation_survey_add" type="checkbox" id="operation_survey_add" value="operation_survey_add" <?php echo $operation_survey_add; ?> />
							新建调查问卷</td>
                            <td><input name="operation_survey_template" type="checkbox" id="operation_survey_template" value="operation_survey_template" <?php echo $operation_survey_template; ?> />
							调查问卷模板管理</td>
                          </tr>
                          <tr>
                            <th style="font-size:14px;font-weight:bold;"><input name="operate_license_control" type="checkbox" id="operate_license_control" value="1" />
                            激活信息管理</th>
                            <td><input name="operation_license" type="checkbox" id="operation_license" value="operation_license" <?php echo $operation_license; ?> />
                			激活码管理</td>
                            <td><input name="operation_blacklist" type="checkbox" id="operation_blacklist" value="operation_blacklist" <?php echo $operation_blacklist; ?> />
                			黑名单管理</td>
                            <td><input name="operation_exchange" type="checkbox" id="operation_exchange" value="operation_exchange" <?php echo $operation_exchange; ?> />
                			激活码更新管理</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <p>
                            <input class="button" type="submit" value="提交" />
                        </p>
               		  </fieldset>
                  	</form>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
			<?php echo $copyright; ?>
		</div>