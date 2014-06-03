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
					<h3>黑名单列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="10%">编号</th>
                                <th width="20%">激活码</th>
                                <th width="20%">机器码</th>
                                <th width="30%">跳转地址</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->list_id; ?></td>
                                <td><?php echo $row->license_content; ?></td>
                                <td><?php echo $row->client_cpu_info; ?></td>
                                <td><?php echo $row->redirect_url; ?></td>
                                <?php
                                	if($row->list_actived=='1') {
										$activedFlag = "<a href=\"blacklists/action?action=deactive&lid={$row->list_id}\">停用</a>";
									} else {
										$activedFlag = "<a href=\"blacklists/action?action=active&lid={$row->list_id}\">启用</a>";
									}
								?>
                                <td align="center"><?php echo $activedFlag; ?> | <a href="?action=modify&lid=<?php echo $row->list_id; ?>">编辑</a> | <a href="blacklists/action?action=delete&lid=<?php echo $row->list_id; ?>">删除</a></td>
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
					<h3>添加黑名单</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="blacklists/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           		<p>
									<label>激活码</label>
                                    <div class="notification attention png_bg">
                                        <a href="#" class="close"><img src="<?php echo $root_path; ?>resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                                        <div>注意：若要屏蔽该激活码，请保持机器码为空</div>
                                    </div>
                                    <input name="licenseContent" type="text" class="text-input small-input" id="licenseContent" value="<?php echo $license_content; ?>" />
                                	<input name="listUpdate" type="hidden" id="listUpdate" value="<?php echo $list_update; ?>" />
                                	<input name="listId" type="hidden" id="listId" value="<?php echo $list_id; ?>" />
                                    <br /><small>将要被列入黑名单的激活码，列入黑名单后，该激活码将不能在任何情况下使用</small>
								</p>
               		  			<p>
									<label>机器码</label>
                                    <div class="notification attention png_bg">
                                        <a href="#" class="close"><img src="<?php echo $root_path; ?>resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
                                        <div>注意：若要屏蔽该机器码，请保持激活码为空</div>
                                    </div>
                                    <input name="machineCode" type="text" class="text-input small-input" id="machineCode" value="<?php echo $client_cpu_info; ?>" />
                                    <br /><small>将要被列入黑名单的机器码，列入黑名单后，该机器码对应的计算机讲不能再激活任何产品</small>
								</p>
               		  			<p>
									<label>跳转地址</label>
                                    <input name="redirectUrl" type="text" class="text-input small-input" id="redirectUrl" value="<?php echo $redirect_url; ?>" />
                                    <br /><small>用户使用以上设定的激活码或机器码时，将会跳转到的页面</small>
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