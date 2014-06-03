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
      				<form id="myForm" name="myForm" method="post" action="originals">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr style="border-bottom:#ccc 1px solid">
                            <td width="12%">记录总数：
                            <input name="post_flag" type="hidden" id="post_flag" value="1" /></td>
                            <td width="28%"><span class="usagetxt redtxt numeric bold"><?php echo $record_total; ?></span></td>
                            <td width="12%">最后统计时间：</td>
                            <td width="20%" colspan="3"><span class="bold"><?php echo $last_post_time; ?></span></td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>开始时间：</td>
                            <td><input type="text" name="startTime" id="startTime" class="text-input data-picker" style="width:100px;" />
                                <select name="startHours" id="startHours">
                                <option value="0" selected="selected">0</option>
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                </select>
                                时
                                <select name="startMinutes" id="startMinutes">
                                    <option value="00" selected="selected">0</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                </select>
                                分
                                <select name="startSeconds" id="startSeconds">
                                    <option value="00" selected="selected">0</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                </select>
                                秒</td>
                            <td>结束时间：</td>
                            <td colspan="3"><input type="text" name="endTime" id="endTime" class="text-input data-picker" style="width:100px;" />
                                <select name="endHours" id="endHours">
                                <option value="0" selected="selected">0</option>
                                <option value="01">1</option>
                                <option value="02">2</option>
                
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                              </select>
                                时
                                <select name="endMinutes" id="select5">
                                  <option value="00" selected="selected">0</option>
                                  <option value="01">1</option>
                                  <option value="02">2</option>
                                  <option value="03">3</option>
                                  <option value="04">4</option>
                                  <option value="05">5</option>
                                  <option value="06">6</option>
                                  <option value="07">7</option>
                                  <option value="08">8</option>
                                  <option value="09">9</option>
                                  <option value="10">10</option>
                                  <option value="11">11</option>
                                  <option value="12">12</option>
                                  <option value="13">13</option>
                                  <option value="14">14</option>
                                  <option value="15">15</option>
                                  <option value="16">16</option>
                                  <option value="17">17</option>
                                  <option value="18">18</option>
                                  <option value="19">19</option>
                                  <option value="20">20</option>
                                  <option value="21">21</option>
                                  <option value="22">22</option>
                                  <option value="23">23</option>
                                  <option value="24">24</option>
                                  <option value="25">25</option>
                                  <option value="26">26</option>
                                  <option value="27">27</option>
                                  <option value="28">28</option>
                                  <option value="29">29</option>
                                  <option value="30">30</option>
                                  <option value="31">31</option>
                                  <option value="32">32</option>
                                  <option value="33">33</option>
                                  <option value="34">34</option>
                                  <option value="35">35</option>
                                  <option value="36">36</option>
                                  <option value="37">37</option>
                                  <option value="38">38</option>
                                  <option value="39">39</option>
                                  <option value="40">40</option>
                                  <option value="41">41</option>
                                  <option value="42">42</option>
                                  <option value="43">43</option>
                                  <option value="44">44</option>
                                  <option value="45">45</option>
                                  <option value="46">46</option>
                                  <option value="47">47</option>
                                  <option value="48">48</option>
                                  <option value="49">49</option>
                                  <option value="50">50</option>
                                  <option value="51">51</option>
                                  <option value="52">52</option>
                                  <option value="53">53</option>
                                  <option value="54">54</option>
                                  <option value="55">55</option>
                                  <option value="56">56</option>
                                  <option value="57">57</option>
                                  <option value="58">58</option>
                                  <option value="59">59</option>
                                </select>
                                分
                                <select name="endSeconds" id="select6">
                                  <option value="00" selected="selected">0</option>
                                  <option value="01">1</option>
                                  <option value="02">2</option>
                                  <option value="03">3</option>
                                  <option value="04">4</option>
                                  <option value="05">5</option>
                                  <option value="06">6</option>
                                  <option value="07">7</option>
                                  <option value="08">8</option>
                                  <option value="09">9</option>
                                  <option value="10">10</option>
                                  <option value="11">11</option>
                                  <option value="12">12</option>
                                  <option value="13">13</option>
                                  <option value="14">14</option>
                                  <option value="15">15</option>
                                  <option value="16">16</option>
                                  <option value="17">17</option>
                                  <option value="18">18</option>
                                  <option value="19">19</option>
                                  <option value="20">20</option>
                                  <option value="21">21</option>
                                  <option value="22">22</option>
                                  <option value="23">23</option>
                                  <option value="24">24</option>
                                  <option value="25">25</option>
                                  <option value="26">26</option>
                                  <option value="27">27</option>
                                  <option value="28">28</option>
                                  <option value="29">29</option>
                                  <option value="30">30</option>
                                  <option value="31">31</option>
                                  <option value="32">32</option>
                                  <option value="33">33</option>
                                  <option value="34">34</option>
                                  <option value="35">35</option>
                                  <option value="36">36</option>
                                  <option value="37">37</option>
                                  <option value="38">38</option>
                                  <option value="39">39</option>
                                  <option value="40">40</option>
                                  <option value="41">41</option>
                                  <option value="42">42</option>
                                  <option value="43">43</option>
                                  <option value="44">44</option>
                                  <option value="45">45</option>
                                  <option value="46">46</option>
                                  <option value="47">47</option>
                                  <option value="48">48</option>
                                  <option value="49">49</option>
                                  <option value="50">50</option>
                                  <option value="51">51</option>
                                  <option value="52">52</option>
                                  <option value="53">53</option>
                                  <option value="54">54</option>
                                  <option value="55">55</option>
                                  <option value="56">56</option>
                                  <option value="57">57</option>
                                  <option value="58">58</option>
                                  <option value="59">59</option>
                                </select>
                                秒</td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>指定报表类型：</td>
                            <td><select name="reportType" id="reportType">
                              <option value="0" selected="selected">不指定</option>
                              <option value="install">install</option>
                              <option value="uninstall">uninstall</option>
                              <option value="use">use</option>
                              <option value="function">function</option>
                            </select>            </td>
                            <td>&nbsp;</td>
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>指定单个用户机器码：</td>
                            <td><input type="text" name="machineCode" id="machineCode" class="text-input" style="width:300px;" /></td>
                            <td>指定产品：</td>
                            <td>
                              <select name="productId_forVer" id="productId_forVer">
                                <option value="0" selected="selected">不指定</option>
                                <?php foreach($product_result as $row): ?>
                                <option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>
                                <?php endforeach; ?>
                              </select></td>
                            <td width="5%">版本：</td>
                            <td width="23%"><select name="productVersion" id="productVersion">
                              <option value="0" selected="selected">不指定</option>
                            </select></td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>指定CPU：</td>
                            <td><select name="systemCPU" id="systemCPU">
                                <option value="0">不指定</option>
                                <?php foreach($cpu_result as $row): ?>
                                <option value="<?php echo $row->system_cpu; ?>"><?php echo $row->system_cpu; ?></option>
                                <?php endforeach; ?>
                            </select></td>
                            <td>指定操作系统：</td>
                            <td colspan="3"><select name="systemOS" id="systemOS">
                                <option value="0">不指定</option>
                                <?php foreach($os_result as $row): ?>
                                <option value="<?php echo $row->system_os; ?>"><?php echo $row->system_os; ?></option>
                                <?php endforeach; ?>
                            </select></td>
                          </tr>
                          <tr style="border-bottom:#ccc 1px solid">
                            <td>指定显卡：</td>
                            <td><select name="systemVideocard" id="systemVideocard">
                                <option value="0">不指定</option>
                                <?php foreach($videocard_result as $row): ?>
                                <option value="<?php echo $row->system_videocard; ?>"><?php echo $row->system_videocard; ?></option>
                                <?php endforeach; ?>
                            </select></td>
                            <td>&nbsp;</td>
                            <td colspan="3">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="6"><input name="submit" type="submit" class="button" id="submit" value="更新" /></td>
                          </tr>
                          <tr>
                            <td colspan="6">
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
					<h3>原始统计报告</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="report_list">
                            <thead>
                              <tr>
                                <th width="6%">类型</th>
                                <th width="10%">产品</th>
                                <th width="7%">版本号</th>
                                <th width="17%">机器码</th>
                                <th width="27%">运行环境</th>
                                <th width="20%">记录时间</th>
                                <th width="13%">操作</th>
                              </tr>
                            </thead>
                            <tbody>
                            	<?php foreach($result as $row): ?>
                                <tr>
                                	<?php if($row->log_type=='install'): ?>
                                    <td>安装</td>
                                    <?php elseif($row->log_type=='uninstall'): ?>
                                    <td>卸载</td>
                                    <?php elseif($row->log_type=='use'): ?>
                                    <td>使用</td>
                                    <?php elseif($row->log_type=='function'): ?>
                                    <td>功能使用</td>
                                    <?php endif; ?>
                                    <td><?php echo $row->product_name; ?></td>
                                    <td><?php echo $row->product_version; ?></td>
                                    <td><?php echo $row->client_cpu_info; ?></td>
                                    <td>
                                        <strong>CPU：</strong><?php echo $row->system_cpu; ?><br>
                                        <strong>操作系统：</strong><?php echo $row->system_os; ?><br>
                                        <strong>显卡：</strong><?php echo $row->system_videocard; ?><br>
                                    </td>
                                    <td><?php echo $row->log_localtime; ?></td>
                                    <td>无操作</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <?php echo $pagination; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/jquery-ui.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.common.js"></script>