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
      				<form id="myForm" name="myForm" method="post" action="relations">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr style="border-bottom:#CCCCCC 1px dotted">
                            <td width="10%">指定产品：
                            <input name="post_flag" type="hidden" id="post_flag" value="1" /></td>
                            <td colspan="3">
                              <select name="productId_forVer" id="productId_forVer">
                                <option value="0" selected="selected">不指定</option>
                                <?php foreach($product_result as $row): ?>
                                <option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                                <?php endforeach; ?>
                              </select>
                                <input type="hidden" name="productName" id="productName" /></td>
                          </tr>
                          <tr>
                            <td>选择版本：</td>
                            <td colspan="3"><select name="productVersion" id="productVersion">
                                <option value="0" selected="selected">不指定</option>
                            	</select>
				            </td>
                          </tr>
                          <tr>
                            <td width="10%">开始时间：</td>
                            <td width="19%"><input type="text" name="startTime" id="startTime" class="text-input data-picker" style="width:100px;" /></td>
                            <td width="10%">结束时间：</td>
                            <td width="61%"><input type="text" name="endTime" id="endTime" class="text-input data-picker" style="width:100px;" /></td>
                          </tr>
                          <tr>
                            <td colspan="4"><input name="submit" type="submit" class="button" id="submit" value="更新" /></td>
                          </tr>
                          <tr>
                            <td colspan="4">
                            <?php foreach($select_case as $value): ?>
                            	<span class="usagetxt orangetxt marginright10 bold"><?php echo $value; ?></span>
                            <?php endforeach; ?>
                          	</td>
                          </tr>
                        </table>
                    </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>详细数据</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                        <?php if(!empty($product_name)): ?>
                   		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_list">
							<thead>
                            <tr style="border-top:#666666 3px solid;background:#F9F9F9;">
                              <th width="20%"><?php echo $product_name;?>&nbsp;(<?php echo $product_version; ?>)</td>
                              <th width="20%">
                                <div class="th-title"><a href="{%root_path%}report/install.php">软件安装总数</a></div>
                                <div class="th-num"><?php echo $install_total; ?></div>
                                <div class="th-time">最后安装时间：<br /><?php echo $last_installTime; ?></div></td>
                              <th width="20%">
                                <div class="th-title"><a href="{%root_path%}report/actived.php">软件激活总数</a></div>
                                <div class="th-num"><?php echo $actived_total; ?></div>
                                <div class="th-time">最后激活时间：<br /><?php echo $last_activedtime; ?></div></td>
                              <th width="20%">
                                <div class="th-title"><a href="{%root_path%}report/use.php">软件使用总数</a> / 平均使用次数</div>
                                <div class="th-num"><span class="red"><?php echo $use_total; ?></span> / <span class="orange"><?php echo $use_avg; ?></span></div>
                                <div class="th-time">最后使用时间：<br /><?php echo $last_useTime; ?></div></td>
                              <th width="20%">
                                <div class="th-title"><a href="{%root_path%}report/uninstall.php">软件卸载总数</a></div>
                                <div class="th-num"><?php echo $uninstall_total; ?></div>
                                <div class="th-time">最后卸载时间：<br /><?php echo $last_uninstallTime; ?></div></td>
                            </tr>
                            </thead>
                      	</table>
                        <?php endif; ?>
                        <?php if(!empty($result)): ?>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_list">
                          <tr>
                            <th width="25%" style="border-top:none;">同时安装的软件</th>
                            <th width="25%" style="border-top:none;">软件安装数</th>
                            <th width="25%" style="border-top:none;">软件使用数</th>
                            <th width="25%" style="border-top:none;">软件卸载数</th>
                          </tr>
                          <?php foreach($result as $row): ?>
                          <tr>
                          	<td><strong><?php echo $row->product_name; ?></strong> Version:<?php echo $row->product_version; ?></td>
                            <td><?php echo $row->install_total; ?></td>
                            <td><?php echo $row->use_total; ?></td>
                            <td><?php echo $row->uninstall_total; ?></td>
                          </tr>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.relation.js"></script>