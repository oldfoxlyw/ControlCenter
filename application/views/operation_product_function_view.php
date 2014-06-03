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
					<h3>功能列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th width="20%">编号</th>
                                <th width="20%">功能名称</th>
                                <th width="20%">产品编号</th>
                                <th width="20%">产品版本</th>
                                <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
                            <tr>
                            	<td><?php echo $row->func_id; ?></td>
                            	<td><?php echo $row->func_name; ?></td>
                            	<td><?php echo $row->product_id; ?></td>
                                <td><?php echo $row->product_version; ?></td>
                                <td align="center"><a href="?action=modify&fid=<?php echo $row->func_id; ?>">编辑</a> | <a href="functions/action?action=delete&fid=<?php echo $row->func_id; ?>">删除</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="5">
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
					<h3>添加功能</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="functions/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm" id="myForm">
                        	<fieldset>
                           		<p>
									<label>功能名称</label>
                                    <input name="funcName" type="text" class="text-input small-input" id="funcName" value="<?php echo $func_name; ?>" />
                           	    	<input name="funcUpdate" type="hidden" id="funcUpdate" value="<?php echo $func_update; ?>" />
                                	<input name="funcId" type="hidden" id="funcId" value="<?php echo $func_id; ?>" />
                                    <br /><small>功能的名称</small>
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