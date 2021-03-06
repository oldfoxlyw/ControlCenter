		<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->
			<h1 id="sidebar-title"><a href="#"><?php echo $title ?></a></h1>
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="<?php echo $root_path; ?>resources/images/logo.png" alt="<?php echo $title ?>" /></a>
			<!-- Sidebar Profile links -->
			<div id="profile-links">
				欢迎回来，<a href="#" title="<?php echo $userName; ?>"><?php echo $userName; ?></a><br />
				您有 <a href="#messages" rel="modal" title="<?php echo $notice_count; ?> 条短消息"><?php echo $notice_count; ?> 条短消息</a><br /><br />
				<a href="#" title="查看网站">查看网站</a> | <a href="<?php echo $root_path; ?>login/out" title="退出登录">退出登录</a>
			</div>
			<div id="profile-links">
            <form action="<?php echo $root_path; ?>api/general_api/changePlatform" method="post" id="platform" name="platform">
                <select name="platformId" id="platformId" onchange="platform.submit();">
                	<option value="0">选择其他管理平台</option>
                    <?php foreach($platform_result as $row): ?>
                    <option value="<?php echo $row['platform_id']; ?>"><?php echo $row['platform_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
			</div>
			<ul id="main-nav">  <!-- Accordion Menu -->
                <li><a href="" title="" class="nav-top-item">常规管理</a>
                	<ul>
                    	<?php echo $operation_index; ?>
                    </ul>
                </li>
				<li><a href="#" class="nav-top-item">营销策略管理</a>
					<ul>
                    	<?php echo $operation_coupon; ?>
                        <?php echo $operation_survey; ?>
                        <?php echo $operation_survey_add; ?>
                    	<?php echo $operation_survey_template; ?>
                    	<?php echo $operation_service; ?>
					</ul>
				</li>
				<li>
					<a href="#" class="nav-top-item">产品信息管理</a>
					<ul>
                    	<?php echo $operation_product; ?>
                    	<?php echo $operation_product_function; ?>
					</ul>
				</li>
				<li>
					<a href="#" class="nav-top-item">激活信息管理</a>
					<ul>
                    	<?php echo $operation_license; ?>
                    	<?php echo $operation_blacklist; ?>
                    	<?php echo $operation_exchange; ?>
					</ul>
				</li>
				<li>
					<a href="#" class="nav-top-item">系统工具</a>
					<ul>
                    	<?php echo $tool_cache; ?>
					</ul>
				</li>
				<li>
					<a href="#" class="nav-top-item">系统设置</a>
					<ul>
                    	<?php echo $web_notices; ?>
                    	<?php echo $web_settings; ?>
                    	<?php echo $web_settings_action; ?>
                    	<?php echo $web_users; ?>
                    	<?php echo $web_permission; ?>
                    	<?php echo $web_permission_action; ?>
					</ul>
				</li>
			</ul> <!-- End #main-nav -->
			<div id="messages" style="display: none"> <!-- Messages are shown when a link with these attributes are clicked: href="#messages" rel="modal"  -->
				<h3>您有 <?php echo $notice_count; ?> 条新短消息</h3>
                <div class="notice-container">
					<?php foreach($notice_result as $row): ?>
                    <p>
                        <?php if($row->notice_reciever_id!='all'): ?>
                        <strong><?php echo date('Y-m-d H:i:s', $row->notice_posttime); ?></strong> 由 <span class="green bold"><?php echo $row->user_name; ?></span> 向 <span class="green bold">你</span> 发送：<small>
                        <input type="hidden" class="notice_id" value="<?php echo $row->notice_id; ?>" />
                        [<a href="javascript:void(0)" class="remove-link" title="删除这条由 <?php echo $row->user_name; ?> 发送的短消息">删除</a>]</small>
                        <?php else: ?>
                        <strong><?php echo date('Y-m-d H:i:s', $row->notice_posttime); ?></strong> 由 <span class="green bold"><?php echo $row->user_name; ?></span> 向 <span class="green bold">全体管理员</span> 发送：
                        <?php endif; ?><br />
                        <?php echo $row->notice_content; ?>
                    </p>
                    <?php endforeach; ?>
                </div>
				<form action="" method="post">
                	<fieldset>
					<h4>发送短消息</h4>
					<p>
						<textarea class="textarea" name="noticeContent" id="noticeContent" cols="79" rows="5"></textarea>
                        <input name="GUID" type="hidden" id="GUID" value="<?php echo $guid; ?>" />
					</p>
					<p>
						<select name="noticeReciever" id="noticeReciever">
							<option value="all">全体管理员</option>
                            <?php foreach($user_result as $row): ?>
                            <?php if($userName!=$row->user_name): ?>
                            <option value="<?php echo $row->GUID; ?>"><?php echo $row->user_name; ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
					  </select>
					  <input class="noticeSendBtn button" type="button" value="发送" />
					</p>
                    </fieldset>
				</form>
			</div> <!-- End #messages -->
		</div></div>