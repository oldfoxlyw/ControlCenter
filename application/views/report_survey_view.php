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
      				<form id="myForm" name="myForm" method="post" action="surveys">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr style="border-bottom:#ccc 1px solid">
                            <td width="12%">选择问卷：
                            <input name="post_flag" type="hidden" id="post_flag" value="1" /></td>
                            <td width="28%">
                            <select name="surveyId" id="surveyId">
                            <?php foreach($survey_result as $row): ?>
                            	<option value="<?php echo $row->survey_id; ?>"><?php echo $row->survey_comment; ?></option>
                            <?php endforeach; ?>
                            </select>
				            </td>
                            <td width="12%">&nbsp;</td>
                            <td width="48%">&nbsp;</td>
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
                            <td><input type="text" name="endTime" id="endTime" class="text-input data-picker" style="width:100px;" />
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
					<h3>调查问卷报告</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                	<?php if(!empty($result)): ?>
                    <?php for($i=0; $i<count($result); $i++): ?>
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   		<center>
                        <div id="graph_bar<?php echo strval($i+1); ?>" class="report-graph">
                        </div>
                        </center>
                    </div>
                    <?php endfor; ?>
                    <?php endif; ?>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>详细数据</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                    <?php if(!empty($result)): ?>
                    <?php foreach($result as $title => $row): ?>
                    	<?php if(!empty($row)): ?>
                   		<table class="report_list survey_question_graph">
                        	<caption><?php echo $title; ?></caption>
                        	<thead>
                            	<tr>
                                	<th width="10%" scope="col"></th>
                                    <?php foreach($row as $key => $value): ?>
                                	<th scope="col"><?php echo $key; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                            	<tr>
                                	<th scope="row">数量</th>
                            		<?php foreach($row as $key => $value): ?>
                                	<td><?php echo $value; ?></td>
                               		<?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>详细数据</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
    					<?php foreach($question as $key1=>$value1): ?>
                   		<h2 style="padding-bottom:10px;"><?php echo $key1; ?></h2>
                        <?php foreach($value1 as $key2=>$value2): ?>
                        <table class="report_list" width="100%">
                            <tr>
                            	<th><span class="green"><?php echo $key2; ?></span></th>
                            </tr>
                            <?php foreach($value2 as $value3): ?>
                            <tr>
                                <td>[<?php echo $value3[1]; ?>] - <?php echo $value3[0]; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.survey.js"></script>