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
					<h3>分类列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                              <th width="20%">编号</th>
                              <th width="30%">分类名称</th>
                              <th width="30%">所属频道</th>
                              <th width="20%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $table_content; ?>
                        </tbody>
                      </table>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>添加分类</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="categories/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                       			<p>
									<label>所属频道</label>
                                	<select name="channelId" id="channelId">
                                    	<?php echo $channel_list_option; ?>
                       	  	  	  	</select>
                                	<input name="categoryUpdate" type="hidden" id="categoryUpdate" value="<?php echo $category_update; ?>" />
                                	<input name="categoryId" type="hidden" id="categoryId" value="<?php echo $category_id; ?>" />
                                	<span class="input-notification attention png_bg">如果没有频道，请首先添加频道</span>
                                    <br />
                                    <small>选择所属频道，如果没有频道，请首先添加频道</small>                                </p>
                   				<p>
									<label>分类名称</label>
                                	<input name="categoryName" type="text" class="text-input small-input" id="categoryName" value="<?php echo $category_name; ?>" />
                                	<span class="input-notification attention png_bg">填入3-10个字符的中文名称</span>
                                    <br />
                                    <small>分类的名称，3-10个字符</small>
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