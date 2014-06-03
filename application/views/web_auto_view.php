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
					<h3>自动发送邮件列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="20%">编号</th>
                                <th width="30%">描述</th>
                                <th width="20%">邮件内容</th>
                                <th width="30%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->auto_id; ?></td>
                                <td><?php echo $row->auto_name; ?></td>
                                <td align="center"><a href="mail_templates/action?action=preview&tid=<?php echo $row->template_id; ?>" target="_blank">预览模版</a></td>
                                <td align="center"><a href="?action=modify&aid=<?php echo $row->auto_id; ?>">编辑</a> | <a href="autos/action?action=delete&aid=<?php echo $row->auto_id; ?>">删除</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="4">
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
					<h3>添加自动发送邮件</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="autos/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           		<p>
									<label>描述</label>
                                    <input name="autoName" type="text" class="text-input small-input" id="autoName" value="<?php echo $auto_name; ?>" />
                           	    	<input name="autoUpdate" type="hidden" id="autoUpdate" value="<?php echo $auto_update; ?>" />
                                	<input name="autoId" type="hidden" id="autoId" value="<?php echo $auto_id; ?>" />
                                    <br /><small>自动发送邮件的描述</small>
								</p>
                           		<p>
									<label>选择模版</label>
                                    <select name="templateId" id="templateId">
                                    <?php foreach($template_result as $row): ?>
                                    <?php if($template_id==$row->template_id): ?>
                                    	<option value="<?php echo $row->template_id; ?>" selected="selected"><?php echo $row->template_name; ?></option>
                                    <?php else: ?>
                                    	<option value="<?php echo $row->template_id; ?>"><?php echo $row->template_name; ?></option>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    </select>
                                    <br /><small>自动发送邮件所使用的模板，请在“邮件模板”页面添加模板</small>
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