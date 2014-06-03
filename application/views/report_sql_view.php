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
					<ul class="content-box-tabs">
						<li><a href="#tab1" class="default-tab">向导模式(MySQL)</a></li> <!-- href must be unique and match the id of target div -->
						<li><a href="#tab2">专家模式</a></li>
					</ul>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                  <div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
      				<form id="myForm1" name="myForm1" method="post" action="sqls">
                    	<fieldset>
                        <input name="post_flag" type="hidden" id="post_flag" value="1" />
                    	<div class="column-left" style="width:20%;">
                            <p>
                                <label>
                                选择数据库</label>
                                <select name="sqlDatabase" id="sqlDatabase">
                                    <option value="0">请选择数据库</option>
                                    <option value="scc_accountdb">scc_accountdb</option>
                                    <option value="scc_authorization">scc_authorization</option>
                                    <option value="scc_commercial">scc_commercial</option>
                                    <option value="scc_logdb_201107">scc_logdb_201107</option>
                                    <option value="scc_productdb">scc_productdb</option>
                                    <option value="scc_webdb">scc_webdb</option>
                                </select>
                            </p>
                          <p>
                                <label>语句类型</label>
                                <select name="sqlType" id="sqlType">
                                    <option value="SELECT">SELECT</option>
                                    <option value="UPDATE">UPDATE</option>
                                    <option value="INSERT">INSERT</option>
                                    <option value="DELETE">DELETE</option>
                                </select>
                          </p>
                            <p>
                                <label>表</label>
                                <select name="sqlTable" id="sqlTable">
                                    <option value="1">1</option>
                                </select>
                            </p>
                            <p>
                                <label>字段</label>
                                <select name="sqlField" id="sqlField">
                                    <option value="1">1</option>
                                </select>
                            </p>
                        </div>
                        <div class="column-left">
                            <p>
                                <label>WHERE语句</label>
                                <select name="sqlWhereField" id="sqlWhereField">
                                    <option value="1">1</option>
                                </select>
                                <select name="sqlWhereOperation" id="sqlWhereOperation">
                                  <option value="=" selected="selected">=</option>
                                    <option value="&lt;">&lt;</option>
                                    <option value="&lt;=">&lt;=</option>
                                    <option value="&gt;">&gt;</option>
                                    <option value="&gt;=">&gt;=</option>
                                    <option value="&lt;&gt;">&lt;&gt;</option>
                                </select>
                                <input name="sqlWhereValue" type="text" class="text-input" id="sqlWhereValue" value="" style="width:100px;" />
                            </p>
                            <p>
                                <label>Group by语句</label>
                                <select name="sqlGroupby" id="sqlGroupby">
                                    <option value="1">1</option>
                                </select>
                            </p>
                            <p>
                                <label>Order by语句</label>
                                <select name="sqlOrderby" id="sqlOrderby">
                                    <option value="1">1</option>
                                </select>
                            </p>
                        </div>
                        <div class="clear"></div>
                        <p>
                            <input name="submit" type="submit" class="button" id="submit" value="提交" />
                        </p>
                        </fieldset>
      				</form>
                    </div>
                    <div class="tab-content" id="tab2"> <!-- This is the target div. id must match the href of this div's tab -->
      				<form id="myForm2" name="myForm2" method="post" action="sqls">
                    	<fieldset>
                        <input name="post_flag" type="hidden" id="post_flag" value="2" />
                            <p>
                                <label>选择数据库</label>
                                <select name="sqlDatabase" id="sqlDatabase">
                                    <option value="0">请选择数据库</option>
                                    <option value="scc_logdb_201107" selected="selected">scc_logdb_201107</option>
                                    <option value="scc_accountdb">scc_accountdb</option>
                                    <option value="scc_authorization">scc_authorization</option>
                                    <option value="scc_commercial">scc_commercial</option>
                                    <option value="scc_productdb">scc_productdb</option>
                                    <option value="scc_webdb">scc_webdb</option>
                                </select>
                            </p>
                        	<p>
                                <label>SQL语句</label>
                                <textarea name="sqlStatement" id="sqlStatement" class="text-input textarea" cols="80" rows="6"><?php echo $sql_statement; ?></textarea>
                                <br /><small>SQL语句</small>
                            </p>
                            <p>
                                <input name="submit" type="submit" class="button" id="submit" value="提交" />
                            </p>
                        </fieldset>
                    </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>SQL语句查询结果</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="report_list">
                      	<tr>
                        	<?php foreach($fields as $value): ?>
                            <th><?php echo $value; ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach($result as $row): ?>
                        <tr>
                        	<?php foreach($row as $value): ?>
                            <td><?php echo $value; ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                      </table>
                    </div>
		  	  </div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/jquery-ui.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/report/report.common.js"></script>