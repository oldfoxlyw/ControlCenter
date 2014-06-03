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
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>operation/surveys"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Clipboard_3.png" alt="icon" /><br />
					调查问卷管理
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>operation/blacklists"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/User_Danger.png" alt="icon" /><br />
					黑名单管理
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>operation/products"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Box_Recycle.png" alt="icon" /><br />
					产品管理
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>operation/licenses"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Lock.png" alt="icon" /><br />
					激活码管理
				</span></a></li>
				
				<li><a class="shortcut-button" href="#messages" rel="modal"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Mail_new.png" alt="icon" /><br />
					消息通知
				</span></a></li>
				
			</ul><!-- End .shortcut-buttons-set -->
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>运维管理中心总体数据统计</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
				  <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
						
				  </div>
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<div class="content-box">
				<div class="content-box-header">
					<h3>运维管理中心更新日志</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab">
						<h4>2011-07-04</h4>
						<p><ul class="list">
                            <li>新增注册码查询，可查询注册码被使用多少次，按照使用类型排序</li>
                            <li>新增CPU码查询功能</li>
                        </ul></p>
						<h4>2011-07-13</h4>
						<p><ul class="list">
                            <li><span style="color:#FF0000">首页报表数据已增加自动统计功能，将于美国时间00:00、00:05、00:10分别进行All, Cpu, Product数据统计工作</span></li>
                            <li><span style="color:#FF0000">若想立即查看数据，请重建缓存，由于此操作耗时长，不建议频繁进行。</span></li>
                            <li><a href="<?php echo $root_path; ?>tool/caches">重建缓存</a></li>
                        </ul></p>
					</div> <!-- End #tab3 -->
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
			<div class="clear"></div>
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/index.js"></script>