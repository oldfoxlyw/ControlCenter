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
					<h3>服务包信息管理</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="20%">服务名称</th>
                                <th width="20%">激活码前缀</th>
                                <th width="40%">激活码信息</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                                <td><?php echo $row->service_name; ?></td>
                                <td><?php echo $row->license_prefix; ?></td>
                                <td></td>
                                <td align="center"><a href="?action=modify&id=<?php echo $row->service_id; ?>">编辑</a> | <a href="services/action?action=delete&id=<?php echo $row->service_id; ?>">删除</a></td>
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
					<h3>添加服务包信息</h3>
		    </div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="services/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           		<p>
									<label>服务包名称</label>
                                    <input name="serviceName" type="text" class="text-input small-input" id="serviceName" value="<?php echo $single_result->service_name; ?>" />
                           	    	<input name="serviceUpdate" type="hidden" id="serviceUpdate" value="<?php echo $service_update; ?>" />
                                	<input name="serviceId" type="hidden" id="serviceId" value="<?php echo $service_id; ?>" />
								</p>
                           		<p>
									<label>激活码前缀</label>
                                    <input name="licensePrefix" type="text" class="text-input small-input" id="licensePrefix" value="<?php echo $single_result->license_prefix; ?>" />
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