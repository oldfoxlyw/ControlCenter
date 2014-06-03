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
					<h3>外链列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="20%">链接编号</th>
                                <th width="40%">链接内容</th>
                                <th width="40%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->link_id; ?></td>
                                <td><?php echo $row->link_content; ?></td>
                                <td align="center"><a href="?action=modify&lid=<?php echo $row->link_id; ?>">编辑</a> | <a href="links/action?action=delete&lid=<?php echo $row->link_id; ?>">删除</a></td>
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
                   	  <form action="links/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           		<p>
									<label>链接内容</label>
                                    <textarea name="linkContent" id="linkContent" class="text-input textarea" cols="80" rows="6"><?php echo $link_content; ?></textarea>
                                	<input name="linkUpdate" type="hidden" id="linkUpdate" value="<?php echo $link_update; ?>" />
                                	<input name="linkId" type="hidden" id="linkId" value="<?php echo $link_id; ?>" />
                                    <br /><small>链接的HTML代码，注意请使用英文的引号“"”</small>
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