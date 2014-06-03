		<div id="main-content"> <!-- Main Content Section with everything -->
			
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					Download From <a href="http://www.exet.tk">exet.tk</a></div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<h2>欢迎回来，<?php echo $userName; ?></h2>
			<p id="page-intro">你想做什么？</p>
			
			<ul class="shortcut-buttons-set">
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>web/articles"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/pencil_48.png" alt="icon" /><br />
					添加新闻
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>web/lists"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/paper_content_pencil_48.png" alt="icon" /><br />
					新闻管理总览
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>web/slides"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/image_add_48.png" alt="icon" /><br />
					幻灯管理总览
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>web/users"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Briefcase_files.png" alt="icon" /><br />
					管理员设置
				</span></a></li>
                
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>web/mail_templates"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Adobe_InDesign.png" alt="icon" /><br />
					邮件模板
				</span></a></li>
				
				<li><a class="shortcut-button" href="#messages" rel="modal"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Mail_new.png" alt="icon" /><br />
					消息通知
				</span></a></li>
				
			</ul><!-- End .shortcut-buttons-set -->
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>SCC网站管理系统概览</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
				  <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
					<div class="notification information png_bg">
							<a href="#" class="close"><img src="<?php echo $root_path; ?>resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
							<div>
								这里显示的是所有接入SCC系统的多媒体内容总数
							</div>
					</div>
						<table width="100%">
							<thead>
								<tr>
								   <th width="20%">内容</th>
								   <th width="20%">数量</th>
						           <th width="60%">操作</th>
							  </tr>
							</thead>
							<tbody>
								<tr>
									<td><strong>网站</strong></td>
									<td><span class="numeric green"><?php echo $totalWebs; ?></span> 个</td>
							        <td><a href="<?php echo $root_path; ?>web/webs">详细信息</a></td>
							  </tr>
								<tr>
									<td><strong>新闻</strong></td>
									<td><span class="numeric green"><?php echo $totalNews; ?></span> 篇</td>
							        <td><a href="<?php echo $root_path; ?>web/lists">详细信息</a></td>
							  </tr>
								<tr>
									<td><strong>频道</strong></td>
									<td><span class="numeric green"><?php echo $totalChannels; ?></span> 个</td>
							        <td><a href="<?php echo $root_path; ?>web/channels">详细信息</a></td>
							  </tr>
								<tr>
									<td><strong>分类</strong></td>
									<td><span class="numeric green"><?php echo $totalCategories; ?></span> 个</td>
							        <td><a href="<?php echo $root_path; ?>web/categories">详细信息</a></td>
							  </tr>
								<tr>
									<td><strong>幻灯</strong></td>
									<td><span class="numeric green"><?php echo $totalSlides; ?></span> 个</td>
							        <td><a href="<?php echo $root_path; ?>web/slides">详细信息</a></td>
							  </tr>
								<tr>
									<td><strong>广告</strong></td>
									<td><span class="numeric green"><?php echo $totalAds; ?></span> 个</td>
							        <td><a href="<?php echo $root_path; ?>web/ads">详细信息</a></td>
							  </tr>
								<tr>
									<td><strong>外链</strong></td>
									<td><span class="numeric green"><?php echo $totalLinks; ?></span> 条</td>
							        <td><a href="<?php echo $root_path; ?>web/links">详细信息</a></td>
							  </tr>
							</tbody>
					  </table>
				  </div>
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<div class="content-box column-left">
				<div class="content-box-header">
					<h3>SCC系统更新日志</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab">
						<h4>2011-05-30</h4>
						<p><ul class="list">
                            <li>修复Cookie记录出错的BUG，现在登录一次之后除非点退出按钮或者手动清理Cookie，否则将会一直是登录状态</li>
                        </ul></p>
						<h4>2011-06-01至2011-06-08</h4>
						<p><ul class="list">
                            <li>报表中心与网站后台管理中心无缝拼接，从顶部下拉菜单中可以选择切换不同的工作平台</li>
            				<li>追踪软件使用情况的各项统计报表正在测试中...</li>
                        </ul></p>
						<h4>2011-09-26</h4>
						<p><ul class="list">
                            <li>软件使用情况统计报表系统已测试完成</a></li>
                            <li>服务器已更换，原服务器将不再使用</li>
                        </ul></p>
					</div> <!-- End #tab3 -->
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<div class="content-box column-right">
				<div class="content-box-header"> <!-- Add the class "closed" to the Content box header to have it closed by default -->
					<h3>快速添加</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab">
						<h4>添加频道</h4>
						<form action="channels/submit" method="post">
                        <fieldset>
                        	<p>
                            	<label>频道名称</label>
                                <input class="text-input small-input" type="text" id="channelName" name="channelName" />
                                <span class="input-notification attention png_bg">在添加前请确定已选择操作网站</span><!-- Classes for input-notification: success, error, information, attention -->
                            </p>
                            <p>
                                <input class="button" type="submit" value="提交" />
                            </p>
                        </fieldset>
                        </form>
					</div>
					<div class="tab-content default-tab block-content">
                    	<h4>添加分类</h4>
						<form action="categories/submit" method="post">
                        <fieldset>
                            <p>
                                <label>频道名称</label>              
                                <select name="channelId" class="small-input" id="channelId">
                                    <?php echo $channel_list_option; ?>
                                </select> 
                            </p>
                        	<p>
                            	<label>分类名称</label>
                                <input class="text-input small-input" type="text" id="categoryName" name="categoryName" />
                                <span class="input-notification attention png_bg">在添加前请确定已选择操作网站</span><!-- Classes for input-notification: success, error, information, attention -->
                            </p>
                            <p>
                                <input class="button" type="submit" value="提交" />
                            </p>
                        </fieldset>
                        </form>
                    </div>
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
			<div class="clear"></div>
            
			<?php echo $copyright; ?>
		</div>