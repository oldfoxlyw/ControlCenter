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
					<h3>模板列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="10%">编号</th>
                                <th width="25%">模版描述</th>
                                <th width="25%">邮件标题</th>
                                <th width="20%">收件人称呼</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->template_id; ?></td>
                                <td><?php echo $row->template_name; ?></td>
                                <td><?php echo $row->template_subject; ?></td>
                                <td><?php echo $row->template_reader; ?></td>
                                <td align="center"><a href="mail_templates/action?action=preview&tid=<?php echo $row->template_id; ?>" target="_blank">预览模版</a> | <a href="?action=modify&tid=<?php echo $row->template_id; ?>">编辑</a> | <a href="mail_templates/action?action=delete&tid=<?php echo $row->template_id; ?>">删除</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="5">
                                	<?php echo $pagination; ?>
                                </td>
                            </tr>
                        </tfoot>
                      </table>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>添加模板</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="mail_templates/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           		<p>
									<label>模板描述</label>
                                    <input name="templateName" type="text" class="text-input small-input" id="templateName" value="<?php echo $template_name; ?>" />
                                	<input name="templateUpdate" type="hidden" id="templateUpdate" value="<?php echo $template_update; ?>" />
                                	<input name="templateId" type="hidden" id="templateId" value="<?php echo $template_id; ?>" />
                                    <br /><small>对模板的一句简单描述，比如“Group buy WinX DVD Ripper Platinum”</small>
								</p>
                           		<p>
									<label>模板标题</label>
                                    <input name="templateSubject" type="text" class="text-input small-input" id="templateSubject" value="<?php echo $template_subject; ?>" />
                                    <br /><small>将会显示在收件人的邮件列表里的标题</small>
								</p>
                           		<p>
									<label>收件人称呼</label>
                                    <input name="templateReader" type="text" class="text-input small-input" id="templateReader" value="<?php echo $template_reader; ?>" />
                                    <br /><small>支持自定义变量，{%first_name%}代表名，{%last_name%}代表姓。注意，使能在客户端程序支持自定义变量处理的情况下使用自定义变量</small>
								</p>
               		  <p>
									<label>模板内容</label>
                                    <textarea name="templateContent" id="templateContent" class="text-input textarea" cols="80" rows="25"><?php echo $template_content; ?></textarea>
                                    <br /><small>请复制模板的HTML代码到这里</small>
							</p>
                           		<p>
									<label>SMTP服务器</label>
                                    <input name="smtpHost" type="text" class="text-input small-input" id="smtpHost" value="<?php echo $smtp_host; ?>" />
                                    <br /><small>发送邮件所使用的SMTP服务器地址，支持IP、域名</small>
								</p>
                           		<p>
									<label>SMTP用户名</label>
                                    <input name="smtpUser" type="text" class="text-input small-input" id="smtpUser" value="<?php echo $smtp_user; ?>" />
                                    <br /><small>发送邮件使用的用户名</small>
								</p>
                           		<p>
									<label>SMTP密码</label>
                                    <input name="smtpPass" type="text" class="text-input small-input" id="smtpPass" value="<?php echo $smtp_pass; ?>" />
                                    <br /><small>发送邮件使用的密码</small>
								</p>
                           		<p>
									<label>发件邮箱</label>
                                    <input name="smtpFrom" type="text" class="text-input small-input" id="smtpFrom" value="<?php echo $smtp_from; ?>" />
                                    <br /><small>发送邮件使用的邮箱地址</small>
								</p>
                           		<p>
									<label>发件人称呼</label>
                                    <input name="smtpFromName" type="text" class="text-input small-input" id="smtpFromName" value="<?php echo $smtp_from_name; ?>" />
                                    <br /><small>收件人回复邮件时使用的称呼，注意：某些国内邮箱服务商将会出现乱码</small>
								</p>
								<p>
									<input class="button" type="submit" value="提交" />
								</p>
                            </fieldset>
                      </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>