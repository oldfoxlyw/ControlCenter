		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					Download From <a href="http://www.exet.tk">exet.tk</a></div>
				</div>
			</noscript>
            
            <form action="sends/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>发送邮件</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                        <fieldset>
                            <p>
                                <label>收件人</label>
                                <textarea name="mailAccount" id="mailAccount" class="text-input textarea" cols="80" rows="6"><?php echo $mail_account; ?></textarea>
                                <input type="button" class="button" id="getAccountMail" name="getAccountMail" value="获得帐户邮件列表" />
                                <br /><small>多个联系人请使用英文逗号“,”进行分隔，若要向全体用户发送，请填入“all”，请使用以下格式：“称呼|Email地址”</small>
                            </p>
                            <p>
                                <label>称呼</label>
                              <input name="mailName" type="text" class="text-input small-input" id="mailName" value="" />
                                <br />
                                <small>该项不为空的情况下，收件人中设置的称呼将无效，称呼将统一使用该项设定的值</small>
                            </p>
                            <p>
                                <label>主题</label>
                                <input name="mailSubject" type="text" class="text-input small-input" id="mailSubject" value="" />
                                <br />
                                <small>邮件的主题</small>
                            </p>
                            <p>
                                <label>使用的模版</label>
                                <select name="mailTemplate" id="mailTemplate">
                                    <option value="0" selected="selected">不使用模板</option>
                                <?php foreach($template_result as $row): ?>
                                    <option value="<?php echo $row->template_id; ?>"><?php echo $row->template_name; ?></option>
                                <?php endforeach; ?>
                                </select>
                                <br />
                                <small>通过“邮件模版管理”上传模版，选择模版后将会直接替换邮件内容</small>
                            </p>
                            <p>
                                <label>邮件内容</label>
                                <textarea name="mailContent" id="mailContent" class="text-input textarea" cols="80" rows="6"></textarea>
                                <br /><small>邮件的内容，支持HTML</small>
                            </p>
                            <p>
                                <input class="button" type="submit" value="发送" />
                            </p>
                    </fieldset>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>服务器配置</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                        <fieldset>
                            <div class="notification attention png_bg">
                                <a href="#" class="close"><img src="<?php echo $root_path; ?>resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                                <div>注意：当选择模版时，优先使用模板所指定的服务器配置！</div>
                            </div>
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
                        </fieldset>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            </form>
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/web/send.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/ckeditor/ckeditor.js"></script>
<script language="javascript">
CKEDITOR.replace("mailContent", {
	width: 1000,
	height: 400
});
</script>