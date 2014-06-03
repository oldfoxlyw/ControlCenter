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
					<h3>激活码列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="20%">激活码</th>
                                <th width="15%">类型</th>
                                <th width="15%">产品编号</th>
                                <th width="15%">产品版本</th>
                                <th width="15%">生成时间</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td><?php echo $row->license_content; ?></td>
                            	<td><?php echo $row->license_type; ?></td>
                            	<td><?php echo $row->product_id; ?></td>
                                <td><?php echo $row->product_version; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $row->license_generated_time); ?></td>
                                <td align="center"><a href="?action=modify&lid=<?php echo $row->license_id; ?>">编辑</a> | <a href="licenses/action?action=delete&lid=<?php echo $row->license_id; ?>">删除</a></td>
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
					<h3>添加激活码</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="licenses/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm" id="myForm">
                        	<fieldset>
                            	<div class="column-right">
                                    <div class="content-box">
                                        <div class="content-box-header">
                                            <h3>指令集</h3>
                                        </div>
                                        <?php
										$forbiddenChecked = $popupChecked = $updateChecked = $functionChecked = '';
										$disabledFunc = array();
										if(!empty($control_command)) {
                                        	$command = explode('@@', $control_command);
											foreach($command as $item) {
												switch($item) {
													case 'CONTROL_FORBIDDEN':
														$forbiddenChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_POPUP_BUY':
														$popupChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_UPDATE':
														$updateChecked = "checked=\"checked\"";
														break;
													default:
														$func = explode('_', $item);
														if(in_array('DISABLED', $func)) {
															$functionChecked = "checked=\"checked\"";
															array_push($disabledFunc, $func[3]);
														}
														break;
												}
											}
										}
										?>
                                        <div class="content-box-content">
                                            <div id="control_list" class="tab-content default-tab">
                                                <p>
                                                  <label>
                                                  <input name="controlForbidden" type="checkbox" id="controlForbidden" value="1" <?php echo $forbiddenChecked; ?> />
                                                  不能运行，强制购买</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlPopup" type="checkbox" id="controlPopup" value="1" <?php echo $popupChecked; ?> />
                                                  可以运行，并弹出购买窗口</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlUpdate" type="checkbox" id="controlUpdate" value="1" <?php echo $updateChecked; ?> />
                                                  强制升级</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlFunction" type="checkbox" id="controlFunction" value="1" <?php echo $functionChecked; ?> />
                                                  禁用功能</label>
                                                </p>
                                          </div>
                                      </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div id="func_list" class="content-box hidden-element">
                                        <div class="content-box-header">
                                            <h3>选择要禁用的功能 <span class="usagetxt greentxt marginright10 bold">绿色为开启状态</span><span class="usagetxt redtxt marginright10 bold">红色为禁用状态</span></h3>
                                        </div>
                                        <div class="content-box-content">
                                            <div class="tab-content default-tab">
                                            	<?php foreach($func_result as $row): ?>
                                                <?php if(in_array(strtoupper($row->func_name), $disabledFunc)): ?>
                                                <span class="usagetxt redtxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php else: ?>
                                                <span class="usagetxt greentxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                                <div class="clear"></div>
                                                <input name="functionDisabled" id="functionDisabled" type="hidden" value="<?php echo implode(',', $disabledFunc); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           		<p>
									<label>激活码</label>
                                    <input name="licenseContent" type="text" class="text-input small-input" id="licenseContent" value="<?php echo $license_content; ?>" />
                           	    	<input name="licenseUpdate" type="hidden" id="licenseUpdate" value="<?php echo $license_update; ?>" />
                                	<input name="licenseId" type="hidden" id="licenseId" value="<?php echo $license_id; ?>" />
                                    <br /><small>激活码内容</small>
								</p>
                           		<p>
									<label>激活码类型</label>
									<select name="licenseType" id="licenseType">
                                    <?php
                                    if($license_type=='free') {
										$freeChecked = "selected=\"selected\"";
									} elseif($license_type=='commercial') {
										$comChecked = "selected=\"selected\"";
									}
									?>
									  <option value="free" <?php echo $freeChecked; ?>>免费版</option>
									  <option value="commercial" <?php echo $comChecked; ?>>商业版</option>
						  	  	  	</select>
                                    <br /><small>免费版会有激活时限，商业版无任何限制</small>
 								</p>
                           		<p>
									<label>授权类型</label>
									<select name="licenseLimit" id="licenseLimit">
                                    <?php
                                    if($license_limit=='lifetime') {
										$freeChecked = "selected=\"selected\"";
									} elseif($license_limit=='timelimit') {
										$comChecked = "selected=\"selected\"";
									}
									?>
									  <option value="lifetime" <?php echo $freeChecked; ?>>终生授权</option>
									  <option value="timelimit" <?php echo $comChecked; ?>>时间限制</option>
						  	  	  	</select>
                                    <br /><small>终生授权没有时间限制</small>
 								</p>
                           		<p>
									<label>授权时限</label>
									<select name="licenseTimeOpt" id="licenseTimeOpt">
									  <option value="2y">2年</option>
									  <option value="1y">1年</option>
									  <option value="6m">半年</option>
									  <option value="1m">1个月</option>
						  	  	  	</select>
                                    <input name="licenseTimeLimit" type="text" class="text-input" style="width:100px;" id="licenseTimeLimit" value="<?php echo $license_time_limit; ?>" />天
                                    <br /><small>当选择授权类型为“时间限制”时，在这里设置该激活码允许使用的最长时间</small>
 								</p>
                           		<p>
									<label>免费版激活时限</label>
                                    <input type="text" name="licenseLastTime" id="licenseLastTime" class="text-input data-picker" style="width:150px;" value="<?php echo date('Y-m-d', $license_last_time); ?>" />
                                    <br /><small>当选择激活码类型选择“免费版”时，在这里设置免费版的激活时限，单位天</small>
 								</p>
                           		<p>
									<label>产品编号</label>
                                    <select name="productId_forVer" id="productId_forVer">
                                    	<option value="0">不指定</option>
                                    <?php foreach($product_result as $row): ?>
                                    <?php if($product_id==$row->product_id): ?>
                           	  	  		<option value="<?php echo $row->product_id; ?>" selected="selected"><?php echo $row->product_name; ?></option>
                                    <?php else: ?>
                                    	<option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    </select>
                                    <br /><small>对应的产品</small>
								</p>
                           		<p>
									<label>产品版本</label>
                                  <select name="productVersion" id="productVersion">
                                  	<option value="0">不指定</option>
                                    <?php if(!empty($product_version)): ?>
                                    <option value="<?php echo $product_version; ?>" selected="selected"><?php echo $product_version; ?></option>
                                    <?php endif; ?>
                                  </select>
                                    <br /><small>对应产品的版本</small>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.common.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/operation/operation.license.js"></script>