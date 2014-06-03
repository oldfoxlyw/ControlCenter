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
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>report/installs"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Chart_1.png" alt="icon" /><br />
					安装数统计
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>report/uses"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Chart_2.png" alt="icon" /><br />
					使用数统计
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>report/uninstalls"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Chart_3.png" alt="icon" /><br />
					卸载数统计
				</span></a></li>
				
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>report/surveys"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Chart_4.png" alt="icon" /><br />
					问卷调查统计
				</span></a></li>
                
				<li><a class="shortcut-button" href="<?php echo $root_path; ?>report/licenses"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Chart_5.png" alt="icon" /><br />
					激活码使用情况统计
				</span></a></li>
				
				<li><a class="shortcut-button" href="#messages" rel="modal"><span>
					<img src="<?php echo $root_path; ?>resources/images/icons/Mail_new.png" alt="icon" /><br />
					消息通知
				</span></a></li>
				
			</ul><!-- End .shortcut-buttons-set -->
			<div class="clear"></div> <!-- End .clear -->
			
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>报表管理中心总体数据统计</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
				  <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
						<table width="100%" class="report_list" id="index_data_sortable">
							<thead>
                                <tr style="border-top:#666666 3px solid;background:#F9F9F9;">
                                  <th width="13%" rowspan="2">产品</th>
                                  <th width="13%" rowspan="2">
                                    <div class="th-title"><a href="<?php echo $root_path; ?>report/installs">软件安装总数</a></div>
                                    <div class="th-num"><?php echo $install_total; ?></div>
                                    <div class="th-time">最后安装时间：<br /><?php echo $last_installTime; ?></div>
                                  </th>
                                  <th width="13%" rowspan="2">
                                    <div class="th-title"><a href="<?php echo $root_path; ?>report/activeds">软件激活总数</a></div>
                                    <div class="th-num"><?php echo $actived_total; ?></div>
                                    <div class="th-time">最后激活时间：<br /><?php echo $last_activedtime; ?></div>
                                  </th>
                                  <th width="18%" rowspan="2">
                                    <div class="th-title"><a href="<?php echo $root_path; ?>report/uses">软件使用总数</a> / 平均使用次数</div>
                                    <div class="th-num"><span class="red"><?php echo $use_total; ?></span> / <span class="orange"><?php echo $use_avg; ?></span></div>
                                    <div class="th-time">最后使用时间：<br /><?php echo $last_useTime; ?></div>
                                  </th>
                                  <th height="30" colspan="2">
                                    <div class="th-title"><a href="<?php echo $root_path; ?>report/uses">软件运行次数</a></div>
                                  </th>
                                  <th width="13%" rowspan="2">
                                    <div class="th-title"><a href="<?php echo $root_path; ?>report/uninstalls">软件卸载总数</a></div>
                                    <div class="th-num"><?php echo $uninstall_total; ?></div>
                                    <div class="th-time">最后卸载时间：<br /><?php echo $last_uninstallTime; ?></div>
                                  </th>
                                  <th width="9%" rowspan="2">
                                    <div class="th-title">首购买数</div>
                                    <div class="th-num"><?php echo $firstbuy_total; ?></div>
                                  </th>
                                  <th width="9%" rowspan="2">
                                    <div class="th-title">回头数</div>
                                    <div class="th-num"><?php echo $clickbuy_total; ?></div>
                                  </th>
                                </tr>
                                <tr style="border-top:#666666 2px solid">
                                  <th width="6%" style="font-weight:normal;">未激活</th>
                                  <th width="6%" style="font-weight:normal;">已激活</th>
                                </tr>
							</thead>
							<tbody>
                            	<?php foreach($product_result as $row): ?>
                                <tr>
                                	<td><a href="relations?post_flag=1&productId_forVer=<?php echo $row['product_id']; ?>&productName=<?php echo $row['product_name']; ?>&productVersion=<?php echo $row['product_version']; ?>"><?php echo $row['product_name'] . '(' . $row['product_version'] . ')'; ?></a></td>
                                    <td><?php echo $row['install_total_detail']; ?></td>
                                    <td><?php echo $row['active_total_detail']; ?></td>
                                    <td><span class="red"><?php echo $row['use_total_detail']; ?></span> / <span class="orange"><?php echo $row['use_avg_detail']; ?></span></td>
                                    <td><?php echo $row['diactived_use_total']; ?></td>
                                    <td><?php echo $row['actived_use_total']; ?></td>
                                    <td><?php echo $row['uninstall_total_detail']; ?></td>
                                    <td><?php echo $row['firstbuy_total_detail']; ?></td>
                                    <td><?php echo $row['clickbuy_total_detail']; ?></td>
                                </tr>
                                <?php endforeach; ?>
							</tbody>
					  </table>
				  </div>
				</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<div class="content-box">
				<div class="content-box-header">
					<h3>报表管理中心更新日志</h3>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/jquery.tablesorter.min.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/index.js"></script>