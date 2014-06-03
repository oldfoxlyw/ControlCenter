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
					<h3>管理员列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="30%">管理员编号</th>
                                <th width="30%">管理员帐号</th>
                                <th width="20%">权限等级</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->GUID; ?></td>
                                <td><?php echo $row->user_name; ?></td>
                                <td><?php echo $row->user_permission; ?></td>
                                <?php
                                	if($row->user_freezed=='1') {
										$freezeFlag = "<a href=\"users/action?action=unfreezed&guid={$row->GUID}\">解冻</a>";
									} else {
										$freezeFlag = "<a href=\"users/action?action=freezed&guid={$row->GUID}\">冻结</a>";
									}
								?>
                                <td align="center"><?php echo $freezeFlag; ?> | <a href="?action=modify&guid=<?php echo $row->GUID; ?>">编辑</a> | <a href="permissions_action?action=modify&type=user&guid=<?php echo $row->GUID; ?>">编辑详细权限</a> | <a href="users/action?action=delete&guid=<?php echo $row->GUID; ?>">删除</a></td>
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
					<h3>添加管理员</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="users/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           		<p>
									<label>管理员帐号</label>
                                	<input name="userName" type="text" class="text-input small-input" id="userName" value="<?php echo $user_name; ?>" />
                                	<input name="userUpdate" type="hidden" id="userUpdate" value="<?php echo $user_update; ?>" />
                               	  	<input name="GUID" type="hidden" id="GUID" value="<?php echo $guid; ?>" />
                                    <span class="input-notification attention png_bg">填入3-20个由英文及数字组成的字符</span>
                                  	<br /><small>请不要使用"""、"|"、"#"、"$"、"%"、"*"等符号</small>
								</p>
                   	  			<p>
									<label>密码</label>
                            		<div class="notification attention png_bg">
                                        <a href="#" class="close"><img src="<?php echo $root_path; ?>resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                                        <div>注意：不改变密码请留空！</div>
                                    </div>
                                    <input name="userPass" type="text" class="text-input small-input" id="userPass" value="" />
                                    <span class="input-notification attention png_bg">注意：不改变密码请留空</span>
                                    <br /><small>请不要使用"""、"|"、"#"、"$"、"%"、"*"等符号</small>
								</p>
                   	  			<p>
									<label>权限等级</label>
                                	<select name="userPermission" id="userPermission">
                                    <?php echo $user_permission; ?>
                              	  	</select>
                                    <br /><small>如果想编辑详细权限列表，请添加管理员后，点击“编辑详细权限”</small>
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