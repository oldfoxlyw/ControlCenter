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
					<h3>新闻列表</h3>
					<ul class="content-box-tabs">
                        <li><input class="button" type="button" value="添加新闻" onclick="window.location='<?php echo $root_path; ?>web/articles'" /></li>
					</ul>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="8%">编号</th>
                                <th width="30%">标题</th>
                                <th width="15%">所属频道</th>
                                <th width="12%">所属分类</th>
                                <th width="15%">发布时间</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach($result as $row): ?>
                            <tr>
                            	<td><?php echo $row->news_id; ?></td>
                                <td><?php echo $row->news_title; ?></td>
                                <td><?php echo $row->channel_name; ?></td>
                                <td><?php echo $row->category_name; ?></td>
                                <td><?php echo $row->news_posttime; ?></td>
                                <?php if($row->news_scroll_show): ?>
                                <td><a href="lists/action?action=unscroll&nid=<?php echo $row->news_id; ?>">取消滚动</a> | <a href="articles?action=modify&nid=<?php echo $row->news_id; ?>">编辑</a> | <a href="lists/action?action=delete&nid=<?php echo $row->news_id; ?>">删除</a></td>
                                <?php else: ?>
                                <td><a href="lists/action?action=scroll&nid=<?php echo $row->news_id; ?>">设置滚动</a> | <a href="articles?action=modify&nid=<?php echo $row->news_id; ?>">编辑</a> | <a href="lists/action?action=delete&nid=<?php echo $row->news_id; ?>">删除</a></td>
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