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
					<h3>产品链接列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="10%">产品编号</th>
                                <th width="15%">产品名称</th>
                                <th width="25%">下载地址</th>
                                <th width="35%">其他地址</th>
                                <th width="15%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->redirect_pid; ?></td>
                                <td><?php echo $row->redirect_pname; ?></td>
                                <td>内部地址：<?php echo $row->redirect_down_inner; ?><br />外部地址：<?php echo $row->redirect_down_outer; ?></td>
                                <td>Paypal:<?php echo $row->redirect_paypal; ?><br />Avangate:<?php echo $row->redirect_avangate; ?><br />Regnow:<?php echo $row->redirect_regnow; ?></td>
                                <td align="center"><a href="?action=modify&rid=<?php echo $row->redirect_id; ?>">编辑</a> | <a href="redirects/action?action=delete&rid=<?php echo $row->redirect_id; ?>">删除</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="6">
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
					<h3>添加链接</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="redirects/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           	<p>
									<label>产品编号</label>
                                	<input name="redirectPid" type="text" class="text-input small-input" id="redirectPid" value="<?php echo $redirect_pid; ?>" />
                                	<input name="redirectUpdate" type="hidden" id="redirectUpdate" value="<?php echo $redirect_update; ?>" />
                                	<input name="redirectId" type="hidden" id="redirectId" value="<?php echo $redirect_id; ?>" />
                                	<span class="input-notification attention png_bg">填入数字和英文组成的编号</span>
                                    <br /><small>产品编号，由数字和英文组成</small>							</p>
                           		<p>
									<label>产品名称</label>
                                	<input name="redirectName" type="text" class="text-input small-input" id="redirectName" value="<?php echo $redirect_pname; ?>" />
                                    <br /><small>产品的名称</small>
								</p>
                           		<p>
									<label>内部链接</label>
                                	<input name="redirectInner" type="text" class="text-input small-input" id="redirectInner" value="<?php echo $redirect_down_inner; ?>" />
                                    <span class="input-notification attention png_bg">地址前需要填写使用的协议，比如“http://”或"https://"，结尾不加"/"</span>
                                    <br /><small>从网站内部来访的请求，会重定向到该链接</small>
								</p>
                           		<p>
									<label>外部链接</label>
                                	<input name="redirectOuter" type="text" class="text-input small-input" id="redirectOuter" value="<?php echo $redirect_down_outer; ?>" />
                                    <span class="input-notification attention png_bg">地址前需要填写使用的协议，比如“http://”或"https://"，结尾不加"/"</span>
                                    <br /><small>从网站外部来访的请求，会重定向到该链接</small>
								</p>
                           		<p>
									<label>Paypal ID</label>
                                	<input name="redirectPaypal" type="text" class="text-input small-input" id="redirectPaypal" value="<?php echo $redirect_paypal; ?>" />
                                    <br /><small>Paypal销售的产品ID</small>
								</p>
                           		<p>
									<label>Avangate ID</label>
                                	<input name="redirectAvangate" type="text" class="text-input small-input" id="redirectAvangate" value="<?php echo $redirect_avangate; ?>" />
                                    <br /><small>Avangate销售的产品ID</small>
								</p>
                           		<p>
									<label>Regnow ID</label>
                                	<input name="redirectRegnow" type="text" class="text-input small-input" id="redirectRegnow" value="<?php echo $redirect_regnow; ?>" />
                                    <br /><small>Regnow销售的产品ID</small>
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