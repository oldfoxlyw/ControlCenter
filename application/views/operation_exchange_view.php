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
      				<form id="myForm" name="myForm" method="post" action="exchanges">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="13%">支付网关：</td>
                            <td width="87%"><select name="paymentGate" id="paymentGate">
                              <option value="0">不限制</option>
                              <option value="paypal" <?php if($payment_gate=='paypal'): ?>selected="selected"<?php endif; ?>>Paypal</option>
                              <option value="avangate" <?php if($payment_gate=='avangate'): ?>selected="selected"<?php endif; ?>>Avangate</option>
                            </select>                            </td>
                          </tr>
                          <tr>
                            <td>Order id：</td>
                            <td><input type="text" name="orderId" id="orderId" class="text-input small-input" value="<?php echo $order_id; ?>" /></td>
                          </tr>
                          <tr>
                            <td>邮箱：</td>
                            <td><input type="text" name="orderEmail" id="orderEmail" class="text-input small-input" value="<?php echo $order_email; ?>" /></td>
                          </tr>
                          <tr>
                            <td>来源网站：</td>
                            <td><select name="website" id="website">
                              <option value="0">不限制</option>
                              <option value="winxdvd" <?php if($website=='winxdvd'): ?>selected="selected"<?php endif; ?>>winxdvd.com</option>
                              <option value="macxdvd" <?php if($website=='macxdvd'): ?>selected="selected"<?php endif; ?>>macxdvd.com</option>
                              <option value="bdlot" <?php if($website=='bdlot'): ?>selected="selected"<?php endif; ?>>bdlot.com</option>
                            </select>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"><input name="submit" type="submit" class="button marginright10" id="submit" value="查询" /></td>
                          </tr>
                        </table>
                    </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>激活码购买记录</h3>
				</div> <!-- End .content-box-header -->
                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="report_list">
                    <thead>
                      <tr>
                        <th width="5%">编号</th>
                        <th width="10%">支付网关</th>
                        <th width="10%">账单ID</th>
                        <th width="10%">用户姓名</th>
                        <th width="10%">用户邮件</th>
                        <th width="5%">币种</th>
                        <th width="5%">价格</th>
                        <th width="30%">购买的产品</th>
                        <th width="10%">时间</th>
                        <th width="5%">查询次数</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result as $row): ?>
                        <tr>
                            <td><?php echo $row->id; ?></td>
                            <td><?php echo $row->payment_gate; ?></td>
                            <td><?php echo $row->order_id; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->order_email; ?></td>
                            <td><?php echo $row->currency; ?></td>
                            <td><?php echo $row->gross; ?></td>
                            <td><?php echo $row->product_name; ?></td>
                            <td><?php echo $row->datetime; ?></td>
                            <td><?php echo $row->query_count; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="10">
                                <?php echo $pagination; ?>
                            </td>
                        </tr>
                    </tfoot>
                 </table>
			  	<!-- End .content-box-content -->
		  	</div>
            <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>