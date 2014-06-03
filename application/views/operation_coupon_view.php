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
					<h3>打折信息管理</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="20%">打折码</th>
                                <th width="10%">产品ID</th>
                                <th width="13%">产品版本</th>
                                <th width="27%">重定向页面</th>
                                <th width="10%">折扣额</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->coupon_content; ?></td>
                                <td><?php echo $row->product_id; ?></td>
                                <td><?php echo $row->product_version; ?></td>
                                <td><?php echo $row->redirect_url; ?></td>
                                <td><?php echo $row->coupon_proportion; ?></td>
                                <td align="center"><a href="?action=modify&cid=<?php echo $row->coupon_id; ?>">编辑</a> | <a href="coupons/action?action=delete&cid=<?php echo $row->coupon_id; ?>">删除</a></td>
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
					<h3>添加打折信息</h3>
		    </div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="coupons/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                            	<p>
                            	  	<input name="submit_type" type="radio" id="rad_single" value="single" checked="checked" />单个添加
                           	  	  	<input type="radio" name="submit_type" id="rad_multiple" value="multiple" />批量生成
                           	  	  	<input type="radio" name="submit_type" id="rad_add" value="add" />批量添加
                           	  	  	<input type="radio" name="submit_type" id="rad_upload" value="upload" />通过上传批量添加
                                </p>
                           		<p id="single">
									<label>打折码</label>
                                    <input name="couponContent" type="text" class="text-input small-input" id="couponContent" value="<?php echo $coupon_content; ?>" />
                           	    	<input name="couponUpdate" type="hidden" id="couponUpdate" value="<?php echo $coupon_update; ?>" />
                                	<input name="couponId" type="hidden" id="couponId" value="<?php echo $coupon_id; ?>" />
                                    <br /><small>对外发送的打折信息激活码</small>
								</p>
                                <div id="multiple" style="display:none;">
                                	<p>
                                    	<label>数量</label>
                                        <input name="couponCount" type="text" class="text-input small-input" id="couponCount" />
                                    </p>
                                    <p>
                                        <label>打折码前缀</label>
                                        <input name="couponPrefix" type="text" class="text-input small-input" id="couponPrefix" />
                                    </p>
                                </div>
                                <div id="add" style="display:none;">
                                	<p>
                                    	<label>打折码</label>
                                    	<textarea name="couponContentAdd" id="couponContentAdd" class="text-input textarea" cols="80" rows="6"></textarea>
                                    </p>
                                </div>
                                <p>
                                	<label>打折码类型</label>
                                    <input name="couponType" type="text" class="text-input small-input" id="couponType" />
                                </p>
                           		<p>
									<label>产品ID</label>
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
									<label>重定向页面</label>
                                    <input name="redirectUrl" type="text" class="text-input small-input" id="redirectUrl" value="<?php echo $redirect_url; ?>" />
                                    <br /><small>购买成功后跳转的页面地址</small>
								</p>
                           		<p>
									<label>折扣额度</label>
                                    <input name="couponProportion" type="text" class="text-input" style="width:150px;" id="couponProportion" value="<?php echo $coupon_proportion; ?>" />
                                    <br /><small>实际价格将会在标价的基础上乘以折扣额度，请用小数表示，如0.5表示打五折</small>
								</p>
                           		<p>
									<label>自动发送邮件</label>
                                    <?php if($coupon_sendmail == '1'): ?>
                                    <input name="sendMail" type="checkbox" id="sendMail" value="1" checked="checked" />
                                    <?php else: ?>
                                    <input name="sendMail" type="checkbox" id="sendMail" value="1" />
                                    <?php endif; ?>
                                    <br /><small>勾选此项后，购买成功将不会跳转，而是自动将重定向页面发送到用户邮箱</small>
								</p>
                           		<p>
									<label>自动发送邮件列表</label>
                                  	<select name="auto_id" id="auto_id">
                                    	<option value="">不指定</option>
                                        <?php foreach($auto_result as $row): ?>
										<?php if($auto_id==$row->auto_id): ?>
                                        <option value="<?php echo $row->auto_id; ?>" selected="selected"><?php echo $row->auto_name; ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo $row->auto_id; ?>"><?php echo $row->auto_name; ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                  	</select>
                                    <br /><small>如果已勾选“自动发送邮件”，请在这里选择所使用的自动邮件项目</small>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/operation/operation.coupon.js"></script>