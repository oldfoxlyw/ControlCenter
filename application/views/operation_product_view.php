		<link rel="stylesheet" href="<?php echo $root_path; ?>resources/css/zebra_dialog.css" type="text/css">
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
					<h3>产品列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="15%">编号</th>
                                <th width="15%">版本</th>
                                <th width="15%">名称</th>
                                <th width="15%">类型</th>
                                <th width="20%">首页</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td><?php echo $row->product_id; ?></td>
                            	<td><?php echo $row->product_version; ?></td>
                            	<td><?php echo $row->product_name; ?></td>
                                <td><?php echo $row->product_type; ?></td>
                                <td><?php echo $row->product_web; ?></td>
                                <?php if($row->product_index_show=='1'): ?>
                                <td align="center"><a href="?action=modify&pid=<?php echo $row->PID; ?>">编辑</a> | <a href="products/action?action=delete&pid=<?php echo $row->PID; ?>">删除</a> | <a href="javascript:$.Zebra_Dialog('<?php echo $row->product_access_token; ?>', {width:800});">通讯密钥</a> | <a href="products/action?action=index_hidden&pid=<?php echo $row->PID; ?>">不在首页统计</a></td>
                                <?php else: ?>
                                <td align="center"><a href="?action=modify&pid=<?php echo $row->PID; ?>">编辑</a> | <a href="products/action?action=delete&pid=<?php echo $row->PID; ?>">删除</a> | <a href="javascript:$.Zebra_Dialog('<?php echo $row->product_access_token; ?>', {width:800});">通讯密钥</a> | <a href="products/action?action=index_show&pid=<?php echo $row->PID; ?>">在首页统计</a></td>
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
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>添加产品</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="products/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                            	<div class="column-right">
                                    <div class="content-box">
                                        <div class="content-box-header">
                                            <h3>指令集</h3>
                                            <ul class="content-box-tabs">
                                                <li><a href="#control_list_purchase" class="default-tab">Purchase</a></li> <!-- href must be unique and match the id of target div -->
                                                <li><a href="#control_list_giveaway">Giveaway</a></li>
                                                <li><a href="#control_list_free">Free</a></li>
                                            </ul>
                                        </div>
                                        <?php
										$forbiddenPurchaseChecked = $popupPurchaseChecked = $updatePurchaseChecked = $functionPurchaseChecked = '';
										$forbiddenGiveawayChecked = $popupGiveawayChecked = $updateGiveawayChecked = $functionGiveawayChecked = '';
										$forbiddenFreeChecked = $popupFreeChecked = $updateFreeChecked = $functionFreeChecked = '';
										$disabledPurchaseFunc = $disabledGiveawayFunc = $disabledFreeFunc = array();
										if(!empty($control_command)) {
                                        	$command = explode('@@', $control_command);
											foreach($command as $item) {
												switch($item) {
													case 'CONTROL_PURCHASE_FORBIDDEN':
														$forbiddenPurchaseChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_GIVEAWAY_FORBIDDEN':
														$forbiddenGiveawayChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_FREE_FORBIDDEN':
														$forbiddenFreeChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_PURCHASE_POPUP_BUY':
														$popupPurchaseChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_GIVEAWAY_POPUP_BUY':
														$popupGiveawayChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_FREE_POPUP_BUY':
														$popupFreeChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_PURCHASE_UPDATE':
														$updatePurchaseChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_GIVEAWAY_UPDATE':
														$updateGiveawayChecked = "checked=\"checked\"";
														break;
													case 'CONTROL_FREE_UPDATE':
														$updateFreeChecked = "checked=\"checked\"";
														break;
													default:
														if(strstr($item, "PURCHASE_DISABLED")!=false) {
															$functionPurchaseChecked = "checked=\"checked\"";
															$func = explode('_', $item);
															array_push($disabledPurchaseFunc, $func[3]);
														} elseif(strstr($item, "GIVEAWAY_DISABLED")!=false) {
															$functionGiveawayChecked = "checked=\"checked\"";
															$func = explode('_', $item);
															array_push($disabledGiveawayFunc, $func[3]);
														} elseif(strstr($item, "FREE_DISABLED")!=false) {
															$functionFreeChecked = "checked=\"checked\"";
															$func = explode('_', $item);
															array_push($disabledFreeFunc, $func[3]);
														}
														break;
												}
											}
										}
										?>
                                        <div class="content-box-content">
                                            <div id="control_list_purchase" class="tab-content default-tab">
                                                <p>
                                                  <label>
                                                  <input name="controlForbiddenPurchase" type="checkbox" id="controlForbiddenPurchase" value="1" <?php echo $forbiddenPurchaseChecked; ?> />
                                                  不能运行，强制购买</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlPopupPurchase" type="checkbox" id="controlPopupPurchase" value="1" <?php echo $popupPurchaseChecked; ?> />
                                                  可以运行，并弹出购买窗口</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlUpdatePurchase" type="checkbox" id="controlUpdatePurchase" value="1" <?php echo $updatePurchaseChecked; ?> />
                                                  强制升级</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlFunctionPurchase" type="checkbox" id="controlFunctionPurchase" value="1" <?php echo $functionPurchaseChecked; ?> />
                                                  禁用功能</label>
                                                </p>
                                          	</div>
                                          	<div id="control_list_giveaway" class="tab-content">
                                                <p>
                                                  <label>
                                                  <input name="controlForbiddenGiveaway" type="checkbox" id="controlForbiddenGiveaway" value="1" <?php echo $forbiddenGiveawayChecked; ?> />
                                                  不能运行，强制购买</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlPopupGiveaway" type="checkbox" id="controlPopupGiveaway" value="1" <?php echo $popupGiveawayChecked; ?> />
                                                  可以运行，并弹出购买窗口</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlUpdateGiveaway" type="checkbox" id="controlUpdateGiveaway" value="1" <?php echo $updateGiveawayChecked; ?> />
                                                  强制升级</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlFunctionGiveaway" type="checkbox" id="controlFunctionGiveaway" value="1" <?php echo $functionGiveawayChecked; ?> />
                                                  禁用功能</label>
                                                </p>
                                          	</div>
                                          	<div id="control_list_free" class="tab-content">
                                                <p>
                                                  <label>
                                                  <input name="controlForbiddenFree" type="checkbox" id="controlForbiddenFree" value="1" <?php echo $forbiddenFreeChecked; ?> />
                                                  不能运行，强制购买</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlPopupFree" type="checkbox" id="controlPopupFree" value="1" <?php echo $popupFreeChecked; ?> />
                                                  可以运行，并弹出购买窗口</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlUpdateFree" type="checkbox" id="controlUpdateFree" value="1" <?php echo $updateFreeChecked; ?> />
                                                  强制升级</label>
                                                </p>
                                                <p>
                                                  <label>
                                                  <input name="controlFunctionFree" type="checkbox" id="controlFunctionFree" value="1" <?php echo $functionFreeChecked; ?> />
                                                  禁用功能</label>
                                                </p>
                                          	</div>
                                      	</div>
                                    </div>
                                    <div class="clear"></div>
                                    <div id="func_list_purchase" class="content-box hidden-element">
                                        <div class="content-box-header">
                                            <h3>选择要禁用的功能(Purchase) <span class="usagetxt greentxt marginright10 bold">绿色为开启状态</span><span class="usagetxt redtxt marginright10 bold">红色为禁用状态</span></h3>
                                        </div>
                                        <div class="content-box-content">
                                            <div class="tab-content default-tab">
                                            	<?php foreach($func_result as $row): ?>
                                                <?php if(in_array(strtoupper($row->func_name), $disabledPurchaseFunc)): ?>
                                                <span class="usagetxt redtxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php else: ?>
                                                <span class="usagetxt greentxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                                <div class="clear"></div>
                                                <input name="functionDisabledPurchase" id="functionDisabledPurchase" type="hidden" value="<?php echo implode(',', $disabledPurchaseFunc); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div id="func_list_giveaway" class="content-box hidden-element">
                                        <div class="content-box-header">
                                            <h3>选择要禁用的功能(Giveaway) <span class="usagetxt greentxt marginright10 bold">绿色为开启状态</span><span class="usagetxt redtxt marginright10 bold">红色为禁用状态</span></h3>
                                        </div>
                                        <div class="content-box-content">
                                            <div class="tab-content default-tab">
                                            	<?php foreach($func_result as $row): ?>
                                                <?php if(in_array(strtoupper($row->func_name), $disabledGiveawayFunc)): ?>
                                                <span class="usagetxt redtxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php else: ?>
                                                <span class="usagetxt greentxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                                <div class="clear"></div>
                                                <input name="functionDisabledGiveaway" id="functionDisabledGiveaway" type="hidden" value="<?php echo implode(',', $disabledGiveawayFunc); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div id="func_list_free" class="content-box hidden-element">
                                        <div class="content-box-header">
                                            <h3>选择要禁用的功能(Free) <span class="usagetxt greentxt marginright10 bold">绿色为开启状态</span><span class="usagetxt redtxt marginright10 bold">红色为禁用状态</span></h3>
                                        </div>
                                        <div class="content-box-content">
                                            <div class="tab-content default-tab">
                                            	<?php foreach($func_result as $row): ?>
                                                <?php if(in_array(strtoupper($row->func_name), $disabledFreeFunc)): ?>
                                                <span class="usagetxt redtxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php else: ?>
                                                <span class="usagetxt greentxt marginright10 bold"><?php echo $row->func_name; ?></span>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                                <div class="clear"></div>
                                                <input name="functionDisabledFree" id="functionDisabledFree" type="hidden" value="<?php echo implode(',', $disabledFreeFunc); ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="content-box">
                                        <div class="content-box-header">
                                            <h3>推送消息</h3>
                                            <ul class="content-box-tabs">
                                                <li><a href="#tab-url" class="default-tab">URL</a></li> <!-- href must be unique and match the id of target div -->
                                                <li><a href="#tab-text">Text</a></li>
                                            </ul>
                                            <?php
                                            	if($product_default_message=='url') {
													$urlChecked = "checked=\"checked\"";
												} elseif($product_default_message=='text') {
													$textChecked = "checked=\"checked\"";
												} else {
													$urlChecked = "checked=\"checked\"";
												}
											?>
                                            <h5 style="line-height:40px;">
                                              当前默认：
                                              <input type="radio" name="productDefaultMessage" id="radio" value="url" <?php echo $urlChecked; ?> />
                                              URL
                                              <input type="radio" name="productDefaultMessage" id="radio2" value="text" <?php echo $textChecked; ?> />
                                              Text
                                              <input name="productMessageAll" type="checkbox" id="productMessageAll" value="1" />
                                              应用于该产品系列                                            </h5>
                                   	  </div>
                                        <div class="content-box-content">
                                            <div class="tab-content default-tab" id="tab-url">
                                            	<p>
                                                	<label>URL</label>
                                                    <input type="text" name="productMessageUrl" id="productMessageUrl" class="text-input" value="<?php echo $product_message_url; ?>" style="width:80%;" />
                                            	</p>
                                       	  	</div>
                                            <div class="tab-content" id="tab-text">
                                            	<?php
                                                	$textArray = explode('@@', $product_message_text);
												?>
                                            	<p>
                                                	<label>标题</label>
                                                  	<input type="text" name="productMessageTextTitle" id="productMessageTextTitle" class="text-input" value="<?php echo $textArray[0]; ?>" style="width:80%;" />
                                            	</p>
                                            	<p>
                                                	<label>内容</label>
                                                    <textarea name="productMessageText" rows="8" class="text-input" id="productMessageText"><?php echo $textArray[2]; ?></textarea>
                                            	</p>
                                          	</div>
                                      	</div>
                                    </div>
                                </div>
                           		<p>
									<label>产品名称</label>
                                    <input name="productName" type="text" class="text-input small-input" id="productName" value="<?php echo $product_name; ?>" />
                           	    	<input name="productUpdate" type="hidden" id="productUpdate" value="<?php echo $product_update; ?>" />
                                	<input name="PID" type="hidden" id="PID" value="<?php echo $pid; ?>" />
                                    <br /><small>产品的显示名称</small>
								</p>
                           		<p>
									<label>产品编号</label>
                                    <input name="productId" type="text" class="text-input small-input" id="productId" value="<?php echo $product_id; ?>" />
                                    <br /><small>产品内部识别编号</small>
								</p>
                           		<p>
									<label>产品版本</label>
                                    <input name="productVersion" type="text" class="text-input small-input" id="productVersion" value="<?php echo $product_version; ?>" />
                                    <br /><small>产品版本</small>
								</p>
                           		<p>
									<label>产品描述</label>
                                    <input name="productComment" type="text" class="text-input small-input" id="productComment" value="<?php echo $product_comment; ?>" />
                                    <br /><small>产品的一句简单描述</small>
								</p>
                           		<p>
									<label>产品类型</label>
                                    <select name="productType" id="productType">
                                    	<option value="free" <?php if($product_type=='free'): ?>selected="selected"<?php endif; ?>>免费版</option>
                                    	<option value="commercial" <?php if($product_type=='commercial'): ?>selected="selected"<?php endif; ?>>商业版</option>
                                    </select>
                                    <br /><small>主要区别在于激活时候的验证机制</small>
								</p>
                           		<p>
									<label>产品官网</label>
                                    <input name="productWeb" type="text" class="text-input small-input" id="productWeb" value="<?php echo $product_web; ?>" />
                                    <br /><small>产品的官方网站，在卸载时会弹出该网站</small>
								</p>
                           		<p>
									<label>产品卸载地址</label>
                                    <input name="productUninstallPage" type="text" class="text-input small-input" id="productUninstallPage" value="<?php echo $product_uninstall_page; ?>" />
                                    <br /><small>一般该地址为卸载调查的地址，在该地址不为空的情况下，优先跳转该地址</small>
								</p>
                           		<p>
									<label>选择调查问卷</label>
                                    <select name="surveyId" id="surveyId">
                                    	<option value="">不选择</option>
                                        <?php foreach($survey_result as $row): ?>
                                        <?php if($survey_id==$row->survey_id): ?>
                                        <option value="<?php echo $row->survey_id; ?>" selected="selected"><?php echo $row->survey_comment; ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo $row->survey_id; ?>"><?php echo $row->survey_comment; ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <br /><small>该项会作为参数传递给指定的产品卸载地址</small>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/operation/operation.product.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/zebra_dialog.js"></script>