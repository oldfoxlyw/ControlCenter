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
					<h3>新建系统配置</h3>
					<ul class="content-box-tabs">
                        <li><input class="button" type="button" value="返回配置列表" onclick="window.location='<?php echo $root_path; ?>web/settings'" /></li>
					</ul>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
      				<form method="post" action="settings_action/submit" enctype="application/x-www-form-urlencoded">
                    	<fieldset>
                           	<p>
                                <label>编辑完成后立即使用该配置</label>
                                <input type="radio" name="configSelected" id="configSelected" value="1" <?php echo $config_selected_checked; ?> />是
                                <input type="radio" name="configSelected" id="configSelected" value="0" <?php echo $config_selected_unchecked; ?> />否
                                <input name="configUpdate" type="hidden" id="configUpdate" value="<?php echo $config_update; ?>" />
                                <input name="configId" type="hidden" id="configId" value="<?php echo $config_id; ?>" />
							</p>
                            <p>
                                <label>配置方案名称</label>
                                <input name="configName" type="text" class="text-input small-input" id="configName" value="<?php echo $config_name; ?>" />
                                <br /><small>配置方案名称</small>
                            </p>
                            <p>
                                <label>是否关闭数据中心</label>
                                <input type="radio" name="configCloseScc" id="configCloseScc" value="1" <?php echo $config_close_scc_checked; ?> />是
                                <input type="radio" name="configCloseScc" id="configCloseScc" value="0" <?php echo $config_close_scc_unchecked; ?> />否
                                <br /><small>在此，关闭数据中心将不会影响API的通信，仅关闭后台管理的功能</small>
                            </p>
                            <p>
                                <label>关闭数据中心的原因</label>
                                <textarea name="configCloseReason" id="configCloseReason" class="text-input textarea" cols="80" rows="6"><?php echo $config_close_reason; ?></textarea>
                                <br /><small>当上一选项选择“是”的时候，将会显示该选项所设置的内容</small>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/ckeditor/ckeditor.js"></script>
<script language="javascript">
CKEDITOR.replace("configCloseReason", {
	width: 1000,
	height: 300
});
</script>