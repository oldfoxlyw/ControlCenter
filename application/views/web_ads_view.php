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
					<h3>广告列表</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;">
                      <thead>
                            <tr>
                              	<th width="10%">编号</th>
                                <th width="30%">图片地址</th>
                                <th width="15%">图片预览</th>
                                <th width="20%">链接</th>
                                <th width="10%">所属频道</th>
                                <th width="15%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($result as $row): ?>
							<?php
								$originalWidth = $row->ad_pic_width;
								$originalHeight = $row->ad_pic_height;
								if($originalWidth > $originalHeight) {
									$currentWidth = 150;
									$currentHeight = intval($originalHeight/$originalWidth * 150);
								} else {
									$currentHeight = 150;
									$currentWidth = intval($originalWidth/$originalHeight * 150);
								}
							?>
                            <tr>
                            	<td align="center" valign="middle"><?php echo $row->ad_id; ?></td>
                                <td valign="middle" style="word-wrap: break-word;"><a href="<?php echo $row->ad_pic_path; ?>" target="_blank"><?php echo $row->ad_pic_path; ?></a></td>
                                <td valign="middle"><a href="<?php echo $row->ad_pic_path; ?>" target="_blank"><img src="<?php echo $row->ad_pic_path; ?>" width="<?php echo $currentWidth; ?>" height="<?php echo $currentHeight; ?>" /></a></td>
                                <td valign="middle"><?php echo $row->ad_link; ?></td>
                                <td valign="middle"><?php echo $row->channel_name; ?></td>
                                <td align="center" valign="middle"><a href="?action=modify&aid=<?php echo $row->ad_id; ?>">编辑</a> | <a href="ads/action?action=delete&aid=<?php echo $row->ad_id; ?>">删除</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        	<tr>
                            	<td colspan="6">
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
					<h3>添加广告</h3>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  <form action="ads/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                       		<p>
									<label>所属频道</label>
									<select name="adChannel" id="adChannel">
                                    <?php foreach($channel_result as $rowChannel): ?>
                                    <?php if($rowChannel->channel_id==$slide_channel_id): ?>
                                    	<option value="<?php echo $rowChannel->channel_id; ?>" selected="selected"><?php echo $rowChannel->channel_name; ?></option>
                                    <?php else: ?>
                                    	<option value="<?php echo $rowChannel->channel_id; ?>"><?php echo $rowChannel->channel_name; ?></option>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
					  		        </select>
                                	<input name="adUpdate" type="hidden" id="adUpdate" value="<?php echo $ad_update; ?>" />
                                	<input name="adId" type="hidden" id="adId" value="<?php echo $ad_id; ?>" />
                                	<span class="input-notification attention png_bg">请选择频道</span>
                                    <br /><small>如果没有频道，请先添加频道</small>
								</p>
                   	  			<p>
									<label>宽</label>
                                	<input name="adWidth" type="text" class="text-input small-input" id="adWidth" value="<?php echo $ad_width; ?>" />
                                    <span class="input-notification attention png_bg">图片的宽度</span>
                                    <br /><small>图片的宽度，可以设置成和真实宽度不一样的值</small>
							</p>
                   	  			<p>
									<label>高</label>
                                	<input name="adHeight" type="text" class="text-input small-input" id="adHeight" value="<?php echo $ad_height; ?>" />
                                    <span class="input-notification attention png_bg">图片的高度</span>
                                    <br /><small>图片的高度，可以设置成和真实高度不一样的值</small>
								</p>
                   	  			<p>
									<label>链接地址</label>
                                	<input name="adLink" type="text" class="text-input small-input" id="adLink" value="<?php echo $ad_link; ?>" />
                                    <br /><small>点击图片后链接到的页面地址</small>
							</p>
                                <p>
									<label>上传图片</label>
                                    <input name="adUpload" type="file" id="adUpload" size="20" class="text-input" />
                                    <input name="adPicPath" type="hidden" id="adPicPath" value="<?php echo $ad_pic_path; ?>" />
                                    <input type="button" name="button" id="button" value="上传" onclick="javascript:adPicUpload()" class="button" />
                                    <br /><small>在这里上幻灯的图片</small>
                                    <div id="contentPic"></div>
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
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/uploader/ajaxfileupload.js"></script>
<script language="javascript">
function adPicUpload() {
	$.ajaxFileUpload
	(
		{
			url:'<?php echo $root_path; ?>web/general_api/doPicUpload?el=adUpload',
			secureuri:false,
			fileElementId:'adUpload',
			dataType: 'json',
			data:{},
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					if(data.error != 'null')
					{
						alert(data.error);
					}
					else
					{
						alert(data.msg);
						$("#contentPic").append("<p>" + data.data + "</p>");
						$("#adPicPath").val(data.data);
					}
				}
			},
			error: function (data, status, e) {
				alert(e);
			}
		}
	)
	return false;
}
</script>
