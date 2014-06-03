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
					<h3>调查问卷</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                    <?php if(!empty($result)): ?>
                        <form id="myForm" name="myForm" method="post" action="survey_adds/submit">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="10%">描述
                              	<input name="surveyUpdate" type="hidden" id="surveyUpdate" value="<?php echo $survey_update; ?>" />
                            	<input name="surveyId" type="hidden" id="surveyId" value="<?php echo $survey_id; ?>" /></td>
                            <td width="40%"><input name="surveyComment" type="text" id="surveyComment" value="<?php echo $survey_comment; ?>" class="text-input small-input" /></td>
                            <td width="50%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>模板</td>
                            <td>
                              <select name="surveyTemplateId" id="surveyTemplateId">
                              <?php foreach($template_result as $row): ?>
                              <?php if($template_id == $row->template_id): ?>
                              	<option value="<?php echo $row->template_id; ?>" selected="selected"><?php echo $row->template_name; ?></option>
                              <?php else: ?>
                              	<option value="<?php echo $row->template_id; ?>"><?php echo $row->template_name; ?></option>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              </select></td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <input name="questionTotal" type="hidden" id="questionTotal" value="<?php echo $question_total; ?>" />
                        <?php for($i=1; $i<=count($result); $i++): ?>
                        <?php
						$optionJson = json_decode($result[$i-1]->question_options);
						$optionTotal = count($optionJson->field) + 1;
						?>
                        <div class="questionSperator">
                          <input name="questionId_<?php echo strval($i); ?>" type="hidden" id="questionId_<?php echo strval($i); ?>" class="questionId" value="<?php echo strval($i); ?>" />
                          <input name="optionId_<?php echo strval($i); ?>" type="hidden" id="optionId_<?php echo strval($i); ?>" class="optionId" value="<?php echo $optionTotal; ?>" />
                          <div class="row"><span style="display:inline-block;width:120px;">问题<?php echo strval($i); ?>：</span><input name="questionContent_<?php echo strval($i); ?>" type="text" id="questionContent_<?php echo strval($i); ?>" value="<?php echo $result[$i-1]->question_content; ?>" style="width:400px;" class="text-input" />
                          <input type="button" name="removeQuestion<?php echo strval($i); ?>" id="removeQuestion<?php echo strval($i); ?>" value="删除问题" class="button removeQuestion" />
                          </div>
							<?php for($j=1; $j<=$optionTotal-1; $j++): ?>
                            <?php
                            $radioType = $textType = $textareaType = '';
							$selectValue = $optionJson->field[$j-1]->type;
							switch($selectValue) {
								case 'radio':
									$radioType = "selected=\"selected\"";
									break;
								case 'text':
									$textType = "selected=\"selected\"";
									break;
								case 'textarea':
									$textareaType = "selected=\"selected\"";
									break;
							}
							?>
                            <div class="row"><span style="display:inline-block;width:120px;">问题<?php echo strval($i); ?>-选项<?php echo strval($j); ?>：</span>类型：<select name="optionType_<?php echo strval($i); ?>_<?php echo strval($j); ?>" id="optionType_<?php echo strval($i); ?>_<?php echo strval($j); ?>">
                              <option value="radio" <?php echo $radioType; ?>>radio</option>
                              <option value="text" <?php echo $textType; ?>>text</option>
                              <option value="textarea" <?php echo $textareaType; ?>>textarea</option>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;变量名：<input name="optionVariable_<?php echo strval($i); ?>_<?php echo strval($j); ?>" type="text" id="optionVariable_<?php echo strval($i); ?>_<?php echo strval($j); ?>" value="<?php echo $optionJson->field[$j-1]->variable; ?>" class="text-input" style="width:300px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标题：<input name="optionTitle_<?php echo strval($i); ?>_<?php echo strval($j); ?>" type="text" id="optionTitle_<?php echo strval($i); ?>_<?php echo strval($j); ?>" value="<?php echo $optionJson->field[$j-1]->title; ?>" class="text-input" style="width:300px;" />
                          	</div>
                          	<?php endfor; ?>
                            <div class="row"><input type="button" name="addOption<?php echo strval($i); ?>" id="addOption<?php echo strval($i); ?>" value="添加选项" class="button addOption" /></div>
                        </div>
                        <?php endfor; ?>
                        <div class="extrabottom">
                            <input type="button" name="addQuestion" id="addQuestion" value="添加问题" class="button" />
                            <input type="submit" name="submit" id="submit" value="提交" class="button" style="width:80px;" />
                        </div>
                        </form>
                    <?php else: ?>
                        <form id="myForm" name="myForm" method="post" action="survey_adds/submit">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="10%">描述
                              	<input name="surveyUpdate" type="hidden" id="surveyUpdate" value="<?php echo $survey_update; ?>" />
                            	<input name="surveyId" type="hidden" id="surveyId" value="<?php echo $survey_id; ?>" /></td>
                            <td width="40%"><input name="surveyComment" type="text" id="surveyComment" value="<?php echo $survey_comment; ?>" class="text-input small-input" /></td>
                            <td width="50%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td>模板</td>
                            <td>
                              <select name="surveyTemplateId" id="surveyTemplateId">
                              <?php foreach($template_result as $row): ?>
                              <?php if($template_id == $row->template_id): ?>
                              	<option value="<?php echo $row->template_id; ?>" selected="selected"><?php echo $row->template_name; ?></option>
                              <?php else: ?>
                              	<option value="<?php echo $row->template_id; ?>"><?php echo $row->template_name; ?></option>
                              <?php endif; ?>
                              <?php endforeach; ?>
                              </select></td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <input name="questionTotal" type="hidden" id="questionTotal" value="1" />
                        <div class="questionSperator">
                          <input name="questionId_1" type="hidden" id="questionId_1" class="questionId" value="1" />
                          <input name="optionId_1" type="hidden" id="optionId_1" class="optionId" value="2" />
                          <div class="row"><span style="display:inline-block;width:120px;">问题1：</span><input name="questionContent_1" type="text" id="questionContent_1" value="" style="width:400px;" class="text-input" />
                          <input type="button" name="removeQuestion1" id="removeQuestion1" value="删除问题" class="button removeQuestion" />
                          </div>
                            <div class="row"><span style="display:inline-block;width:120px;">问题1-选项1：</span>类型：<select name="optionType_1_1" id="optionType_1_1">
                              <option value="radio" selected="selected">radio</option>
                              <option value="text">text</option>
                              <option value="textarea">textarea</option>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;变量名：<input name="optionVariable_1_1" type="text" id="optionVariable_1_1" value="" class="text-input" style="width:300px;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;标题：<input name="optionTitle_1_1" type="text" id="optionTitle_1_1" value="" class="text-input" style="width:300px;" />
                          </div>
                            <div class="row"><input type="button" name="addOption1" id="addOption1" value="添加选项" class="button addOption" /></div>
                        </div>
                        <div class="row">
                            <input type="button" name="addQuestion" id="addQuestion" value="添加问题" class="button" />
                            <input type="submit" name="submit" id="submit" value="提交" class="button" style="width:80px;" />
                        </div>
                        </form>
                    <?php endif; ?>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/operation/operation.survey.js"></script>