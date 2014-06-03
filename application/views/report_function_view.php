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
      				<form id="myForm" name="myForm" method="post" action="functions">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr style="border-bottom:#ccc 1px solid">
                            <td width="11%">记录总数：
                            <input name="post_flag" type="hidden" id="post_flag" value="1" /></td>
                            <td width="25%"><span class="usagetxt redtxt numeric bold"><?php echo $record_total; ?></span></td>
                            <td width="10%">最后统计时间：</td>
                            <td colspan="3"><span class="bold"><?php echo $last_post_time; ?></span></td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>需要统计的数据表：</td>
                            <td><select name="softwareType" id="softwareType">
                              <option value="converter" selected="selected">converter</option>
                              <option value="ripper">ripper</option>
                              <option value="player">player</option>
                            </select>                            </td>
                            <td>&nbsp;</td>
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>统计方式：</td>
                            <td><select name="reportType" id="reportType">
                                  <option value="1" selected="selected">按周进行统计</option>
                                  <option value="2">按天进行统计</option>
                                  <option value="3">按月份进行统计</option>
                                  <option value="4">按年份进行统计</option>
                                  <option value="5">自定义时间段</option>
                                </select></td>
                            <td>加入同期数据：</td>
                            <td colspan="3"><input name="isMulti" type="checkbox" id="isMulti" value="1" />
                            是</td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>选择时间：</td>
                            <td colspan="5">
                            	<span id="datetime1">
                                    <select name="year1" id="year1">
                                      <option value="2011">2011</option>
                                      <option value="2012">2012</option>
                                      <option value="2013">2013</option>
                                      <option value="2014">2014</option>
                                      <option value="2015">2015</option>
                                    </select>
                                    年 <span id="month_block1">
                                    <select name="month1" id="month1">
                                      <option value="1" selected="selected">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                      <option value="6">6</option>
                                      <option value="7">7</option>
                                      <option value="8">8</option>
                                      <option value="9">9</option>
                                      <option value="10">10</option>
                                      <option value="11">11</option>
                                      <option value="12">12</option>
                                    </select>
                                    月</span> <span id="date_block1">
                                    <select name="date1" id="date1">
                                    </select>
                                    日</span>                                </span>
                                <span id="datetime3" style="display:none;">
                                    <span class="bold">起始日期：</span>
                                    <select name="year3" id="year3">
                                    <option value="2011">2011</option>
                                    <option value="2012">2012</option>
                                    <option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    </select>
                                    年
                                    <select name="month3" id="month3">
                                    <option value="1" selected="selected">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    </select>
                                    月
                                    <select name="date3" id="date3">
                                    </select>日
                                    <span class="bold">结束时间：</span>
                                    <select name="year4" id="year4">
                                    <option value="2011">2011</option>
                                    <option value="2012">2012</option>
                                    <option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    </select>
                                    年
                                    <select name="month4" id="month4">
                                    <option value="1" selected="selected">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    </select>
                                    月
                                    <select name="date4" id="date4">
                                        </select>日                                </span>                            </td>
                          </tr>
                          <tr id="datetime2" style="display:none;border-bottom:#ccc 1px solid;">
                            <td>选择同期时间：</td>
                            <td colspan="5"><select name="year2" id="year2">
                                <option value="2011">2011</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                              </select>
                                年
                                <span id="month_block2">
                                <select name="month2" id="month2">
                                  <option value="1" selected="selected">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                  <option value="7">7</option>
                                  <option value="8">8</option>
                                  <option value="9">9</option>
                                  <option value="10">10</option>
                                  <option value="11">11</option>
                                  <option value="12">12</option>
                                </select>
                                月 </span>
                                <span id="date_block2">
                              <select name="date2" id="date2">
                              </select>
                              日</span></td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>指定产品：</td>
                            <td>
                              <select name="productId_forVer" id="productId_forVer">
                                <option value="0" selected="selected">不指定</option>
                                <?php foreach($product_result as $row): ?>
                                <option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                                <?php endforeach; ?>
                              </select></td>
                            <td>指定版本：</td>
                            <td width="16%"><select name="productVersion" id="productVersion">
                              <option value="0" selected="selected">不指定</option>
                            </select></td>
                            <td width="9%">指定功能：</td>
                            <td width="29%"><select name="selectFunction" id="selectFunction">
                              <option value="0">不指定</option>
                            </select></td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid" id="more-options-1" class="hidden-element">
                          	<td>指定机器码：</td>
                            <td><input type="text" name="machineCode" id="machineCode" class="text-input" style="width:300px;" /></td>
                            <td>指定操作系统：</td>
                            <td colspan="3"><select name="systemOS" id="systemOS">
                                <option value="0">不指定</option>
                                <?php foreach($os_result as $row): ?>
                                <option value="<?php echo $row->system_os; ?>"><?php echo $row->system_os; ?></option>
                                <?php endforeach; ?>
                            </select></td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid" id="more-options-2" class="hidden-element">
                          	<td>指定CPU：</td>
                            <td><select name="systemCPU" id="systemCPU">
                                <option value="0">不指定</option>
                                <?php foreach($cpu_result as $row): ?>
                                <option value="<?php echo $row->system_cpu; ?>"><?php echo $row->system_cpu; ?></option>
                                <?php endforeach; ?>
                            </select></td>
                            <td>指定显卡：</td>
                            <td colspan="3"><select name="systemVideocard" id="systemVideocard">
                                <option value="0">不指定</option>
                                <?php foreach($videocard_result as $row): ?>
                                <option value="<?php echo $row->system_videocard; ?>"><?php echo $row->system_videocard; ?></option>
                                <?php endforeach; ?>
                            </select></td>
                          </tr>
                          <tr id="special-converter">
                            <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="4">特殊选项(Converter)</td>
                              </tr>
                              <tr>
                                <td width="11%">Filetype:</td>
                                <td width="25%"><select name="converterFileType" id="converterFileType">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($convert_filetype_result as $row): ?>
                                  <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                                  <?php endforeach; ?>
                                </select></td>
                                <td width="10%">&nbsp;</td>
                                <td width="54%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>input:</td>
                                <td><select name="converterInput" id="converterInput">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($convert_input_result as $row): ?>
                                  <option value="<?php echo $row->input; ?>"><?php echo $row->input; ?></option>
                                  <?php endforeach; ?>
                                </select>                                </td>
                                <td>output:</td>
                                <td><select name="converterOutput" id="converterOutput">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($convert_output_result as $row): ?>
                                  <option value="<?php echo $row->output; ?>"><?php echo $row->output; ?></option>
                                  <?php endforeach; ?>
                                </select>                                </td>
                              </tr>
                              <tr>
                                <td>width:</td>
                                <td><select name="converterWidthCase" id="converterWidthCase">
                                  <option value="1" selected="selected">小于等于</option>
                                  <option value="2">大于</option>
                                </select>
                                  <input type="text" name="converterWidth" id="converterWidth" class="text-input" style="width:100px;" />
                                px</td>
                                <td>height:</td>
                                <td><select name="converterHeightCase" id="converterHeightCase">
                                  <option value="1" selected="selected">小于等于</option>
                                  <option value="2">大于</option>
                                </select>
                                  <input type="text" name="converterHeight" id="converterHeight" class="text-input" style="width:100px;" />
                                px</td>
                              </tr>
                              <tr>
                                <td>vcode:</td>
                                <td><select name="converterVcode" id="converterVcode">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($convert_vcode_result as $row): ?>
                                  <option value="<?php echo $row->vcode; ?>"><?php echo $row->vcode; ?></option>
                                  <?php endforeach; ?>
                                </select>                                </td>
                                <td>acode:</td>
                                <td><select name="converterAcode" id="converterAcode">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($convert_acode_result as $row): ?>
                                  <option value="<?php echo $row->acode; ?>"><?php echo $row->acode; ?></option>
                                  <?php endforeach; ?>
                                </select>                                </td>
                              </tr>
                              <tr>
                                <td>subtitle:</td>
                                <td><select name="converterSubtitle" id="converterSubtitle">
                                  <option value="-1" selected="selected">不指定</option>
                                  <option value="1">是</option>
                                  <option value="0">否</option>
                                </select>                                </td>
                                <td>crop:</td>
                                <td><select name="converterCrop" id="converterCrop">
                                  <option value="-1" selected="selected">不指定</option>
                                  <option value="1">是</option>
                                  <option value="0">否</option>
                                </select></td>
                              </tr>
                              <tr>
                                <td>timerange:</td>
                                <td><select name="converterTimerange" id="converterTimerange">
                                  <option value="-1" selected="selected">不指定</option>
                                  <option value="1">是</option>
                                  <option value="0">否</option>
                                </select></td>
                                <td>cuda:</td>
                                <td><select name="converterCuda" id="converterCuda">
                                  <option value="-1" selected="selected">不指定</option>
                                  <option value="1">是</option>
                                  <option value="0">否</option>
                                </select></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr id="special-ripper" class="hidden-element">
                            <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="4">特殊选项(Ripper)</td>
                              </tr>

                              <tr>
                                <td width="11%">input:</td>
                                <td width="25%"><select name="ripperInput" id="ripperInput">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($ripper_input_result as $row): ?>
                                  <option value="<?php echo $row->input; ?>"><?php echo $row->input; ?></option>
                                  <?php endforeach; ?>
                                </select>                                </td>
                                <td width="10%">output:</td>
                                <td width="54%"><select name="ripperOutput" id="ripperOutput">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($ripper_output_result as $row): ?>
                                  <option value="<?php echo $row->output; ?>"><?php echo $row->output; ?></option>
                                  <?php endforeach; ?>
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <td>width:</td>
                                <td><select name="ripperWidthCase" id="ripperWidthCase">
                                  <option value="1" selected="selected">小于等于</option>
                                  <option value="2">大于</option>
                                </select>
                                <input type="text" name="ripperWidth" id="ripperWidth" class="text-input" style="width:100px;" />
                                px</td>
                                <td>height:</td>
                                <td><select name="ripperHeightCase" id="ripperHeightCase">
                                  <option value="1" selected="selected">小于等于</option>
                                  <option value="2">大于</option>
                                </select>
                                <input type="text" name="ripperHeight" id="ripperHeight" class="text-input" style="width:100px;" />
                                px</td>
                              </tr>
                              <tr>
                                <td>vcode:</td>
                                <td><select name="ripperVcode" id="ripperVcode">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($ripper_vcode_result as $row): ?>
                                  <option value="<?php echo $row->vcode; ?>"><?php echo $row->vcode; ?></option>
                                  <?php endforeach; ?>
                                </select></td>
                                <td>acode:</td>
                                <td><select name="ripperAcode" id="ripperAcode">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($ripper_acode_result as $row): ?>
                                  <option value="<?php echo $row->acode; ?>"><?php echo $row->acode; ?></option>
                                  <?php endforeach; ?>
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <td>subtitle:</td>
                                <td><select name="ripperSubtitle" id="ripperSubtitle">
                                  <option value="-1" selected="selected">不指定</option>
                                  <option value="1">是</option>
                                  <option value="0">否</option>
                                  </select>                                </td>
                                <td>crop:</td>
                                <td><select name="ripperCrop" id="ripperCrop">
                                  <option value="-1" selected="selected">不指定</option>
                                  <option value="1">是</option>
                                  <option value="0">否</option>
                                </select></td>
                              </tr>
                              <tr>
                                <td>timerange:</td>
                                <td><select name="ripperTimerange" id="ripperTimerange">
                                  	<option value="-1" selected="selected">不指定</option>
                                    <option value="1">是</option>
                                    <option value="0">否</option>
                                </select></td>
                                <td>cuda:</td>
                                <td><select name="ripperCuda" id="ripperCuda">
                                  	<option value="-1" selected="selected">不指定</option>
                                    <option value="1">是</option>
                                    <option value="0">否</option>
                                </select></td>
                              </tr>
                            </table></td>
                          </tr>
                          <tr id="special-player" class="hidden-element">
                            <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="4">特殊选项(Player)</td>
                              </tr>
                              <tr>
                                <td width="11%">Filetype:</td>
                                <td width="25%"><select name="playerFileType" id="playerFileType">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($player_filetype_result as $row): ?>
                                  <option value="<?php echo $row->file_type; ?>"><?php echo $row->file_type; ?></option>
                                  <?php endforeach; ?>
                                </select>
                                </td>
                                <td width="10%">input:</td>
                                <td width="54%"><select name="playerInput" id="playerInput">
                                  <option value="0" selected="selected">不指定</option>
                                  <?php foreach($player_input_result as $row): ?>
                                  <option value="<?php echo $row->input; ?>"><?php echo $row->input; ?></option>
                                  <?php endforeach; ?>
                                </select>
                                </td>
                              </tr>

                            </table></td>
                          </tr>
                          <tr>
                            <td colspan="6"><input name="submit" type="submit" class="button marginright10" id="submit" value="更新" />
                            <input name="moreOptions" type="button" class="button" id="moreOptions" value="+更多选项" /></td>
                          </tr>
                          <tr style="border-top:#ccc 1px solid">
                            <td colspan="6">
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
					<h3>功能使用次数统计</h3>
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">面积图</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#tab2">柱状图</a></li>
						<li><a href="#tab3">线图</a></li>
					</ul>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
                        <center>
                        <div id="graph_area" class="report-graph">
                        </div>
                        </center>
                    </div>
                    <div class="tab-content" id="tab2"> <!-- This is the target div. id must match the href of this div's tab -->
                        <center>
                        <div id="graph_bar" class="report-graph">
                        </div>
                        </center>
                    </div>
                    <div class="tab-content" id="tab3"> <!-- This is the target div. id must match the href of this div's tab -->
                        <center>
                        <div id="graph_line" class="report-graph">
                        </div>
                        </center>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>详细数据</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                    	<table id="report_graph" class="report_list">
                   		<?php if($report_type=='1'): ?>
                        	<caption><?php echo $year1; ?>年<?php echo $month1; ?>月<?php echo $date1; ?>日前一周功能使用次数统计</caption>
                   		<?php elseif($report_type=='2'): ?>
                        	<caption><?php echo $year1; ?>年<?php echo $month1; ?>月<?php echo $date1; ?>日功能使用次数统计</caption>
                   		<?php elseif($report_type=='3'): ?>
                        	<caption><?php echo $year1; ?>年<?php echo $month1; ?>月功能使用次数统计</caption>
                   		<?php elseif($report_type=='4'): ?>
                        	<caption><?php echo $year1; ?>年功能使用次数统计</caption>
                   		<?php elseif($report_type=='5'): ?>
                        	<caption><?php echo $year3; ?>年<?php echo $month3; ?>月<?php echo $date3; ?>日-<?php echo $year4; ?>年<?php echo $month4; ?>月<?php echo $date4; ?>日功能使用次数统计</caption>
                        <?php endif; ?>
                        	<thead>
							<?php if($report_type=='1'): ?>
                            	<tr>
                                	<th width="15%" scope="col"></th>
                                	<?php foreach(current($result) as $row): ?>
                                	<th><?php echo $row['date']; ?>日</th>
                                	<?php endforeach; ?>
                                </tr>
                            <?php elseif($report_type=='2'): ?>
                            	<tr>
                                	<th width="15%" scope="col"></th>
                                	<?php foreach(current($result) as $row): ?>
                                	<th><?php echo $row['date']; ?>时</th>
                                	<?php endforeach; ?>
                                </tr>
                            <?php elseif($report_type=='3'): ?>
                            	<tr>
                                	<th width="15%" scope="col"></th>
                                	<?php foreach(current($result) as $row): ?>
                                	<th><?php echo $row['date']+1; ?>日</th>
                                	<?php endforeach; ?>
                                </tr>
                            <?php elseif($report_type=='4'): ?>
                            	<tr>
                                	<th width="15%" scope="col"></th>
                                	<?php foreach(current($result) as $row): ?>
                                	<th><?php echo $row['date']+1; ?>月</th>
                                	<?php endforeach; ?>
                                </tr>
                            <?php elseif($report_type=='5'): ?>
                            	<tr>
                                	<th width="15%" scope="col"></th>
                                	<?php foreach(current($result) as $row): ?>
                                	<th><?php echo $row['date']; ?>日</th>
                                	<?php endforeach; ?>
                                </tr>
                            <?php endif; ?>
                            </thead>
                            <tbody>
							<?php if($report_type=='1'): ?>
                            	<?php foreach($result as $func_name=>$item): ?>
                            	<tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year1; ?>年<?php echo $month1; ?>月<?php echo $date1; ?>日前一周功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if(!empty($multi_result)): ?>
                                <?php foreach($result as $func_name=>$item): ?>
                                <tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year2; ?>年<?php echo $month2; ?>月<?php echo $date2; ?>日前一周功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            <?php elseif($report_type=='2'): ?>
                            	<?php foreach($result as $func_name=>$item): ?>
                            	<tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year1; ?>年<?php echo $month1; ?>月<?php echo $date1; ?>日各时段功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if(!empty($multi_result)): ?>
                                <?php foreach($result as $func_name=>$item): ?>
                                <tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year2; ?>年<?php echo $month2; ?>月<?php echo $date2; ?>日各时段功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            <?php elseif($report_type=='3'): ?>
                            	<?php foreach($result as $func_name=>$item): ?>
                            	<tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year1; ?>年<?php echo $month1; ?>月功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if(!empty($multi_result)): ?>
                                <?php foreach($result as $func_name=>$item): ?>
                                <tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year2; ?>年<?php echo $month2; ?>月功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            <?php elseif($report_type=='4'): ?>
                            	<?php foreach($result as $func_name=>$item): ?>
                            	<tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year1; ?>年功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if(!empty($multi_result)): ?>
                                <?php foreach($result as $func_name=>$item): ?>
                                <tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year2; ?>年功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            <?php elseif($report_type=='5'): ?>
                            	<?php foreach($result as $func_name=>$item): ?>
                            	<tr>
                                	<th scope="row">[<?php echo $func_name; ?>]<?php echo $year3; ?>年<?php echo $month3; ?>月<?php echo $date3; ?>日-<?php echo $year4; ?>年<?php echo $month4; ?>月<?php echo $date4; ?>日功能使用次数(次)</th>
                                	<?php foreach($item as $row): ?>
                                	<td><?php echo $row['count']; ?></td>
                                	<?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/graph/highcharts.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/graph/modules/exporting.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/graph/themes/grid.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/jquery-ui.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.common.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.graph.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.function.js"></script>