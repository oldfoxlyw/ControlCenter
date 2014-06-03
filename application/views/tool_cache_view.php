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
					<h3>操作提示</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                        <ul>
                        	<li>当论坛进行了数据恢复、升级或者工作出现异常的时候，您可以使用本功能重新生成缓存。更新缓存的时候，可能让服务器负载升高，请尽量避开会员访问的高峰时间</li>
                            <li>数据缓存：更新论坛的版块设置、全局设置、用户组设置、权限设置等缓存</li>
                            <li>模板缓存：更新论坛模板、风格等缓存文件，当您修改了模板或者风格，但是没有立即生效的时候使用</li>
                        </ul>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
            <div class="content-box"><!-- Start Content Box -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                    	<form id="myForm" name="myForm" action="caches" method="post">
                        	<fieldset>
                            	<p>
                            	  <label>
                            	  <input name="cacheData" type="checkbox" id="cacheData" value="1" checked="checked" />
                            	  数据缓存</label>
                                  <small>该数据缓存将会写入数据到硬盘文件"config/cache.php"，请确保该文件具有可写入的666、777权限</small>
                                </p>
                            	<p>
                            	  <label>
                            	  <input name="cacheIndexData" type="checkbox" id="cacheIndexData" value="1" />
                            	  首页报表缓存(不推荐手动执行)</label>
                                  <small>首页报表数据已增加自动统计功能，将于美国时间00:00、00:05、00:10分别进行All, Cpu, Product数据统计工作</small>
                                  <small>若想立即查看数据，请手动进行统计，由于此操作耗时长，不建议频繁进行。</small>
                                </p>
                            	<p>
                            	  <label>
                            	  <input name="cacheTimeEnable" type="checkbox" id="cacheTimeEnable" value="1" />
                            	  指定更新某一天的数据</label>
                                  <input name="cacheTime" type="text" id="cacheTime" class="text-input data-picker" disabled="disabled" />
                                </p>
								<p style="display:none;" id="message"></p>
								<p style="display:none;">
									<img src="<?php echo $root_path; ?>resources/images/icons/ajax-loader.gif" />
								</p>
								<p>
									<input name="startCache" type="button" class="button" value="开始更新" id="startCache" />
								</p>
                            </fieldset>
                        </form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/jquery-ui.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/tool/tool.cache.js"></script>