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
					<h3>查询条件</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
      				<form id="myForm" name="myForm" method="post" action="single_users">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr style="border-bottom:#CCCCCC 1px dotted">
                            <td width="10%">机器码：
                              <input name="post_flag" type="hidden" id="post_flag" value="1" /></td>
                            <td width="90%"><input type="text" name="machineCode" id="machineCode" class="text-input" style="width:300px;" /></td>
                          </tr>
                          <tr>
                            <td colspan="2"><input name="submit" type="submit" class="button" id="submit" value="更新" /></td>
                          </tr>
                          <tr>
                            <td colspan="2">
                            <?php foreach($select_case as $value): ?>
                            	<span class="usagetxt orangetxt marginright10 bold"><?php echo $value; ?></span>
                            <?php endforeach; ?>                          	</td>
                          </tr>
                        </table>
                    </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>用户软件使用统计</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                    <?php if(!empty($actived_result)): ?>
                    	<div class="report-table-title">已激活软件</div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_list" id="report_list">
                        <?php foreach($actived_result as $row): ?>
                        	<thead>
                              <tr style="border-top:#666666 3px solid;cursor:pointer;" class="accoudin_title">
                                <th colspan="5" style="background:#FBFFEE;">产品名：<?php echo $row['product_name']; ?> (Version:<?php echo $row['product_version']; ?>) 使用次数：<?php echo $row['use_total']; ?>次
                                    <span class="control_panel">
                                    	<input type="hidden" value="<?php echo $row['client_cpu_info']; ?>" name="machine" />
										<input type="hidden" value="<?php echo $row['license_content']; ?>" name="license" />
                                        <a href="javascript:void(0)" title="移出黑名单" class="btn_actived"><img src="<?php echo $root_path; ?>resources/images/icons/icon_approve.png" alt="移出黑名单" /></a>
                                        <a href="javascript:void(0)" title="列入黑名单" class="btn_inactived"><img src="<?php echo $root_path; ?>resources/images/icons/icon_unapprove.png" alt="列入黑名单" /></a>
                                    </span>
                                </th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                <th width="20%" style="border-top:none;background:#F9F9F9;">功能</th>
                                <th width="80%" style="border-top:none;background:#F9F9F9;">使用次数</th>
                              </tr>
                              <?php foreach($row['function_data'] as $key => $value): ?>
                              <tr>
                              	<td><?php echo $key; ?></td>
                              	<td><?php echo $value; ?></td>
                              </tr>
                              <?php endforeach; ?>
                          </tbody>
                        <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                    <?php if(!empty($all_result)): ?>
                    	<div class="report-table-title">所有软件</div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_list">
                        <?php foreach($all_result as $row): ?>
                        	<thead>
                              <tr style="border-top:#666666 3px solid;cursor:pointer;" class="accoudin_title">
                                <th colspan="5" style="background:#FBFFEE;">产品名：<?php echo $row['product_name']; ?> (Version:<?php echo $row['product_version']; ?>) 使用次数：<?php echo $row['use_total']; ?>次
                                </th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                <th width="20%" style="border-top:none;background:#F9F9F9;">功能</th>
                                <th width="80%" style="border-top:none;background:#F9F9F9;">使用次数</th>
                              </tr>
                              <?php foreach($row['function_data'] as $key => $value): ?>
                              <tr>
                              	<td><?php echo $key; ?></td>
                              	<td><?php echo $value; ?></td>
                              </tr>
                              <?php endforeach; ?>
                          </tbody>
                        <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/jquery-ui.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.singleUser.js"></script>