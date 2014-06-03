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
					<h3>系统配置列表</h3>
					<ul class="content-box-tabs">
                        <li><input class="button" type="button" value="新建配置" onclick="window.location='<?php echo $root_path; ?>web/settings_action'" /></li>
					</ul>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="20%">编号</th>
                                <th width="40%">配置名称</th>
                                <th width="40%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach($result as $row): ?>
                            <tr>
                            	<td><?php echo $row->config_id; ?></td>
                                <td><?php echo $row->config_name; ?></td>
                                <?php if($row->config_selected): ?>
                                <td><span class="red bold">已选配置方案</span> | <a href="settings_action?action=modify&cid=<?php echo $row->config_id; ?>">编辑</a> | <a href="settings/action?action=delete&cid=<?php echo $row->config_id; ?>">删除</a></td>
                                <?php else: ?>
                                <td><a href="settings/action?action=select&cid=<?php echo $row->config_id; ?>">选择该配置方案</a> | <a href="settings_action?action=modify&cid=<?php echo $row->config_id; ?>">编辑</a> | <a href="settings/action?action=delete&cid=<?php echo $row->config_id; ?>">删除</a></td>
                                <?php endif; ?>
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
            
			<?php echo $copyright; ?>
		</div>