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
					<h3>标签列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="15%">编号</th>
                                <th width="45%">名称</th>
                                <th width="40%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach($result as $row): ?>
                            <tr>
                            	<td><?php echo $row->tag_id; ?></td>
                                <td><?php echo $row->tag_name; ?></td>
                                <td><a href="?action=modify&tid=<?php echo $row->tag_id; ?>">编辑</a> | <a href="tags/action?action=delete&tid=<?php echo $row->tag_id; ?>">删除</a></td>
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
					<h3>添加标签</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="tags/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                       		<p>
									<label>标签名称</label>
                           		<input name="tagName" type="text" class="text-input small-input" id="tagName" value="<?php echo $tag_name; ?>" />
                           	  <input name="tagUpdate" type="hidden" id="tagUpdate" value="<?php echo $tag_update; ?>" />
                           	  <input name="tagId" type="hidden" id="tagId" value="<?php echo $tag_id; ?>" />
                                	<span class="input-notification attention png_bg">填入3-20个字符</span>
                                    <br />
                                    <small>标签的名称，3-20个字符</small>
							</p>
								<p>
									<input class="button" type="submit" value="提交" />
								</p>
                            </fieldset>
                      </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div>
            
			<?php echo $copyright; ?>
		</div>