		<link rel="stylesheet" href="<?php echo $root_path ?>resources/css/jquery.ui.css" type="text/css" media="screen" />
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
					<h3>短消息列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="25%">通知内容</th>
                                <th width="15%">发件人</th>
                                <th width="15%">收件人</th>
                                <th width="15%">发布时间</th>
                                <th width="15%">到期时间</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->notice_id; ?></td>
                                <td><?php echo $row->notice_content; ?></td>
                                <td><?php echo $row->notice_sender_id; ?></td>
                                <td><?php echo $row->notice_reciever_id; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $row->notice_posttime); ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $row->notice_endtime); ?></td>
                                <?php
                                if($row->notice_visible=='1') {
									$visibleFlag = "<a href=\"notices/action?action=hide&nid={$row->notice_id}\">隐藏</a>";
								} else {
									$visibleFlag = "<a href=\"notices/action?action=show&nid={$row->notice_id}\">显示</a>";
								}
								?>
                                <td align="center"><?php echo $visibleFlag; ?> | <a href="?action=modify&nid=<?php echo $row->notice_id; ?>">编辑</a> | <a href="notices/action?action=delete&nid=<?php echo $row->notice_id; ?>">删除</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="7">
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
					<h3>发送短消息</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="notices/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                           		<p>
									<label>通知内容</label>
                                    <textarea name="noticeContent" id="noticeContent" class="text-input textarea" cols="80" rows="6"><?php echo $notice_content; ?></textarea>
                                	<input name="noticeUpdate" type="hidden" id="noticeUpdate" value="<?php echo $notice_update; ?>" />
                                	<input name="noticeId" type="hidden" id="noticeId" value="<?php echo $notice_id; ?>" />
                                    <br /><small>通知内容不宜过长，140字符以内合适</small>
								</p>
                           		<p>
									<label>发件人</label>
                                    <input name="noticeSender" type="text" class="text-input small-input" id="noticeSender" value="<?php echo $notice_sender_id; ?>" />
                                    <br /><small>发件人默认情况下为当前登录管理员</small>
								</p>
                           		<p>
									<label>收件人</label>
                                    <input name="noticeReciever" type="text" class="text-input small-input" id="noticeReciever" value="<?php echo $notice_reciever_id; ?>" />
                                    <br /><small>如果想发送给全部管理员，填入“all”即可</small>
								</p>
                           		<p>
									<label>到期时间</label>
                                    <select name="quickSelect" id="quickSelect">
                                      <option value="0" selected="selected">请选择</option>
                                      <option value="1">一天后</option>
                                      <option value="2">1小时后</option>
                                      <option value="3">30分钟后</option>
                                      <option value="4">10分钟后</option>
                                    </select>
								</p>
                                <p>
                                    <input name="notice_endtime" type="text" class="text-input" id="notice_endtime" style="width:120px;" value="<?php echo $notice_endtime; ?>" /> 
                                    <input type="text" name="notice_endtime_hour" id="notice_endtime_hour" class="text-input" style="width:50px;" value="<?php echo $notice_endtime_hour; ?>" />
                                    时
                                    <input type="text" name="notice_endtime_minute" id="notice_endtime_minute" class="text-input" style="width:50px;" value="<?php echo $notice_endtime_minute; ?>" />
                                    分
                                    <input type="text" name="notice_endtime_second" id="notice_endtime_second" class="text-input" style="width:50px;" value="<?php echo $notice_endtime_second; ?>" />
                                    秒
                                    <br /><small>到期后，短消息将不会显示出来</small>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/jquery-ui.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/web/notices.js"></script>