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
					<h3>网站列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                              <th width="20%">编号</th>
                              <th width="50%">网站名称</th>
                              <th width="40%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $table_content; ?>
                        </tbody>
                      </table>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>添加网站</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="webs/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           	<p>
									<label>网站名称</label>
                                	<input name="webName" type="text" class="text-input small-input" id="webName" value="<?php echo $web_name; ?>" />
                                	<input name="webUpdate" type="hidden" id="webUpdate" value="<?php echo $web_update; ?>" />
                                	<input name="webId" type="hidden" id="webId" value="<?php echo $web_id; ?>" />
                                	<span class="input-notification attention png_bg">填入3-20个字符的中文名称</span>
                                    <br /><small>网站的名称，3-20个字符</small>							</p>
                           	<p>
									<label>网站地址</label>
                                	<input name="webUrl" type="text" class="text-input small-input" id="webUrl" value="<?php echo $web_url; ?>" />
                                    <span class="input-notification attention png_bg">地址前需要填写使用的协议，比如“http://”或"https://"，结尾不加"/"</span>
                                    <br /><small>网站的链接地址，用于数据统计</small>
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