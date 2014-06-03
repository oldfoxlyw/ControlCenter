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
      				<form id="myForm" name="myForm" method="post" action="licenses">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr style="border-bottom:#CCCCCC 1px dotted">
                            <td width="10%">激活码总数：</td>
                            <td width="90%"><h3><span class="usagetxt redtxt"><?php echo $license_total; ?></span></h3></td>
                          </tr>
                          <tr>
                            <td width="10%">查询方式：</td>
                            <td><select name="reportType" id="reportType">
                              <option value="1">按激活码查询</option>
                              <option value="2">按机器码查询</option>
                              <option value="3">按产品查询</option>
                            </select>            </td>
                          </tr>
                          <tr>
                            <td colspan="2" id="content">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_license">
                              <tr>
                                <td width="10%">激活码：</td>
                                <td id="content"><input type="text" name="licenseCode" id="licenseCode" class="text-input" style="width:300px;" /></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_cpu" style="display:none;">
                              <tr>
                                <td width="10%">机器码：</td>
                                <td><input type="text" name="machineCode" id="machineCode" class="text-input" style="width:300px;" /></td>
                              </tr>
                            </table>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="table_product" style="display:none;">
                              <tr>
                                <td width="10%">产品：</td>
                                <td width="20%"><select name="productId_forVer" id="productId_forVer">
                                    <option value="0" selected="selected">不指定</option>
                                    <?php foreach($product_result as $row): ?>
                                    <option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </td>
                                <td width="7%">版本：</td>
                                <td width="63%"><select name="productVersion" id="productVersion">
                                  <option value="0">不指定</option>
                                </select>
                                </td>
                              </tr>
                            </table>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="4"><input name="submit" type="submit" class="button marginright10" id="submit" value="更新" /></td>
                          </tr>
                          <tr>
                            <td colspan="4">
                            <?php foreach($select_case as $value): ?>
                            	<span class="usagetxt orangetxt marginright10 bold"><?php echo $value; ?></span>
                            <?php endforeach; ?></td>
                          </tr>
                        </table>
                    </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>激活次数统计</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                    <?php if(!empty($result)): ?>
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_list" id="report_list">
                        	<?php foreach($result as $row): ?>
                        	<thead>
                                <tr style="border-top:#666666 3px solid;cursor:pointer;" class="accoudin_title">
                            	<?php if($report_type!='3'): ?>
                                	<th colspan="5" style="background:#FBFFEE;"><?php echo $row['log_type']; ?>：(<?php echo $row['count']; ?>次)</th>
                                <?php else: ?>
                                	<th colspan="6" style="background:#FBFFEE;"><?php echo $row['log_type']; ?>：(<?php echo $row['count']; ?>次)</th>
                                <?php endif; ?> 
                                </tr>
							</thead>
                            <tbody>
                            <?php if($report_type=='1'): ?>
                            	<tr> 
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">类型</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">机器码</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">产品</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">版本</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">时间</th>
                              	</tr>
                                <?php foreach($row['detail'] as $rowDetail): ?>
                                <tr>
                                	<td><?php echo $rowDetail['log_type']; ?></td>
                                	<td><?php echo $rowDetail['client_cpu_info']; ?></td>
                                	<td><?php echo $rowDetail['product_id']; ?></td>
                                	<td><?php echo $rowDetail['product_version']; ?></td>
                                	<td><?php echo $rowDetail['log_time']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php elseif($report_type=='2'): ?>
                            	<tr> 
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">类型</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">激活码</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">产品</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">版本</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">时间</th>
                              	</tr>
                                <?php foreach($row['detail'] as $rowDetail): ?>
                                <tr>
                                	<td><?php echo $rowDetail['log_type']; ?></td>
                                	<td><?php echo $rowDetail['license_content']; ?></td>
                                	<td><?php echo $rowDetail['product_id']; ?></td>
                                	<td><?php echo $rowDetail['product_version']; ?></td>
                                	<td><?php echo $rowDetail['log_time']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php elseif($report_type=='3'): ?>
                            	<tr> 
                                    <th width="15%" style="border-top:none;background:#F9F9F9;">类型</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">机器码</th>
                                    <th width="15%" style="border-top:none;background:#F9F9F9;">激活码</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">产品</th>
                                    <th width="10%" style="border-top:none;background:#F9F9F9;">版本</th>
                                    <th width="20%" style="border-top:none;background:#F9F9F9;">时间</th>
                              	</tr>
                                <?php foreach($row['detail'] as $rowDetail): ?>
                                <tr>
                                	<td><?php echo $rowDetail['log_type']; ?></td>
                                	<td><?php echo $rowDetail['client_cpu_info']; ?></td>
                                	<td><?php echo $rowDetail['license_content']; ?></td>
                                	<td><?php echo $rowDetail['product_id']; ?></td>
                                	<td><?php echo $rowDetail['product_version']; ?></td>
                                	<td><?php echo $rowDetail['log_time']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.common.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.license.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.singleUser.js"></script>