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
					<h3>发布新闻</h3>
					<ul class="content-box-tabs">
                        <li><input class="button" type="button" value="返回新闻列表" onclick="window.location='<?php echo $root_path; ?>web/lists'" /></li>
					</ul>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
                    <div class="tab-content default-tab"> <!-- This is the target div. id must match the href of this div's tab -->
                   	  	<form action="articles/submit" method="post" enctype="application/x-www-form-urlencoded" name="myForm">
                        	<fieldset>
                                <div class="column-right">
                                    <div class="content-box column-right-static">
                                        <div class="content-box-header">
                                            <h3>标签云</h3>
                                        </div>
                                        <div class="content-box-content" style="height:174px;">
                                            <div id="tags_list" class="tab-content default-tab">
                                            	<?php echo $tag_list; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="content-box column-right-static">
                                        <div class="content-box-header">
                                            <h3>广告位</h3>
                                        </div> <!-- End .content-box-header -->
                                        <div class="content-box-content" style="height:326px;">
                                            <div id="ads_standby" class="tab-content default-tab">
                                           	  <div class="slide-wrapper">
                                                <div class="slide-container">
                                                    <?php
                                                    $num_rows = count($result_ads_list);
                                                    $per_page = 6;
													if($num_rows % $per_page == 0) {
														$total_page = intval($num_rows/$per_page);
													} else {
														$total_page = intval($num_rows/$per_page) + 1;
													}
													?>
                                                    <?php for($i=0; $i<$total_page; $i++): ?>
                                                    	<div class="slide-block">
                                                        <?php for($j=0; $j<$per_page; $j++): ?>
                                                        <?php if(!empty($result_ads_list[$j+$i*$per_page])): ?>
                                                        <?php
                                                        	$originalWidth = $result_ads_list[$j+$i*$per_page]->ad_pic_width;
                                                        	$originalHeight = $result_ads_list[$j+$i*$per_page]->ad_pic_height;
                                                        	if($originalWidth > $originalHeight) {
                                                        		$currentWidth = 120;
                                                        		$currentHeight = intval($originalHeight/$originalWidth * 120);
                                                        	} else {
                                                        		$currentHeight = 120;
                                                        		$currentWidth = intval($originalWidth/$originalHeight * 120);
                                                        	}
                                                        ?>
                                                        	<div class="slide-item-wrap">
                                                                <div class="slide-item">
                                                                	<div class="slide-check"><img src="<?php echo $root_path; ?>resources/images/icons/check.png" /></div>
                                                                    <img src="<?php echo $result_ads_list[$j+$i*$per_page]->ad_pic_path; ?>" width="<?php echo $currentWidth; ?>" height="<?php echo $currentHeight; ?>"  />
                                                                    <div class="ad_id hidden-element"><?php echo $result_ads_list[$j+$i*$per_page]->ad_id; ?></div>
                                                                    
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                        <?php 	break; ?>
                                                        <?php endif; ?>
                                                    	<?php endfor; ?>
                                                        </div>
                                                    <?php endfor; ?>
                                                    </div>
                                              		<div class="clear"></div>
                                              </div>
                                              <div class="slide-control">
                                                <a href="javascript:void(0)" id="pageUp"><img src="<?php echo $root_path; ?>resources/images/icons/arrow_left.png" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" id="pageDown"><img src="<?php echo $root_path; ?>resources/images/icons/arrow_right.png" /></a>
                                              </div>
                                          </div> <!-- End #tab3 -->
                    						<input name="newsAdId" type="hidden" id="newsAdId" value="<?php echo $news_ad_id; ?>" />
                                        </div> <!-- End .content-box-content -->
                                    </div>
                                </div>
                       			<p>
									<label>标题</label>
                                	<input name="newsTitle" type="text" class="text-input small-input" id="newsTitle" value="<?php echo $news_title; ?>" />
                                	<input name="newsUpdate" type="hidden" id="newsUpdate" value="<?php echo $news_update; ?>" />
                                	<input name="newsId" type="hidden" id="newsId" value="<?php echo $news_id; ?>" />
                                    <span class="input-notification attention png_bg">填入3-128个字符的内容</span><br />
                                    <small>新闻的标题，3-20个字符</small>
                            	</p>
                                <p>
									<label>对外显示标题</label>
                                	<input name="newsDisplayTitle" type="text" class="text-input small-input" id="newsDisplayTitle" value="<?php echo $news_display_title; ?>" />
                                	<span class="input-notification attention png_bg">填入3-128个字符的内容</span>
                                    <br /><small>新闻对外显示的标题，可以和主标题不同，留空表示同主标题相同</small>
                            	</p>
                                <p>
									<label>SEO标题</label>
                                	<input name="newsSEOTitle" type="text" class="text-input small-input" id="newsSEOTitle" value="<?php echo $news_seo_title; ?>" />
                                    <input name="seoError" type="hidden" id="seoError" value="0" />
                                	<span class="input-notification attention png_bg">填入3-128个字符的内容</span>
                                    <br /><small>新闻链接的别名，SEO时将会用到</small>
                             	</p>
                       			<p>
									<label>所属频道</label>
                                	<select name="newsChannel" id="newsChannel">
                                    	<?php echo $channel_list_option; ?>
                   	  	  	  	  	</select>
                                	<span class="input-notification attention png_bg">如果没有频道，请首先添加频道</span>
                                    <br /><small>选择所属频道，如果没有频道，请首先添加频道</small>
                                </p>
                       			<p>
									<label>所属分类</label>
                                	<select name="newsCategory" id="newsCategory">
                                    	<?php echo $category_list_option; ?>
                   	  	  	  	  	</select>
                                	<span class="input-notification attention png_bg">如果没有分类，请首先添加分类</span>
                                    <br /><small>先选择所属频道，再选择所属分类，如果没有分类，请首先添加分类</small>
                                </p>
                                <p>
									<label>标签</label>
                                	<input name="newsTags" type="text" class="text-input small-input" id="newsTags" value="<?php echo $news_tags; ?>" />
                                    <br /><small>请使用英文逗号“,”分隔每一个标签，可从标签云中直接点选标签</small>
                            	</p>
                                <p>
									<label>关键字(META)</label>
                                	<input name="newsKeywords" type="text" class="text-input small-input" id="newsKeywords" value="<?php echo $news_keywords; ?>" />
                                    <br /><small>SEO相关关键字，选填项</small>
                            	</p>
                                <p>
									<label>描述(META)</label>
                                    <textarea name="newsDesc" id="newsDesc" class="text-input textarea" cols="80" rows="6"><?php echo $news_desc; ?></textarea>
                                    <br /><small>SEO相关描述，选填项</small>
                            	</p>
                                <p>
									<label>概述</label>
                                    <textarea name="newsIntro" id="newsIntro" class="text-input textarea" cols="80" rows="6"><?php echo $news_intro; ?></textarea>
                                    <br /><small>该描述不同于SEO描述，该描述会显示给访客看</small>
                            	</p>
                                <p>
									<label>产品图片</label>
                                    <input name="fileUpload" type="file" id="fileUpload" size="20" class="text-input" />
                                    <input type="button" name="button" id="button" value="上传" onclick="javascript:ajaxFileUpload()" class="button" />
									<input name="newsPicPath" type="hidden" id="newsPicPath" value="<?php echo $news_pic_path; ?>" />
                                    <br /><small>有的文章内包含产品推广信息，这里可以上传一张产品的盒子图片用来显示</small>
                            	</p>
                                <p>
									<label>内容图片</label>
                                    <input name="contentUpload" type="file" id="contentUpload" size="20" class="text-input" />
                                    <input type="button" name="button" id="button" value="上传" onclick="javascript:contentPicUpload()" class="button" />
                                    <br /><small>在这里上传想要插入文章内的图片</small>
                                    <div id="contentPic"></div>
                            	</p>
                                <p>
									<label>内容</label>
                                    <textarea name="newsContent" id="newsContent" class="text-input textarea" cols="80" rows="6"><?php echo $news_content; ?></textarea>
                            	</p>
                                <p>
									<label>产品名称</label>
                                	<input name="newsProduct" type="text" class="text-input small-input" id="newsProduct" value="<?php echo $news_product; ?>" />
                                    <br /><small>如果该文章包含产品推广链接，这里可以定义链接显示的名称</small>
                            	</p>
                                <p>
									<label>购买链接</label>
                                	<input name="newsBuyLink" type="text" class="text-input small-input" id="newsBuyLink" value="<?php echo $news_buy_link; ?>" />
                                    <br /><small>如果该文章包含产品推广链接，这里可以定义该产品的购买地址</small>
                            	</p>
                                <p>
									<label>下载链接</label>
                                	<input name="newsDownLink" type="text" class="text-input small-input" id="newsDownLink" value="<?php echo $news_down_link; ?>" />
                                    <br /><small>如果该文章包含产品推广链接，这里可以定义该产品的下载地址</small>
                            	</p>
								<p>
									<input name="newsSubmit" type="submit" class="button" id="newsSubmit" value="提交" />
								</p>
                            </fieldset>
                      	</form>
                    </div>
			  	</div> <!-- End .content-box-content -->
			</div> <!-- End .content-box -->
            
			<?php echo $copyright; ?>
		</div>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/web/articles.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/web/pagination.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/ckeditor/ckeditor.js"></script>
<script language="javascript" src="<?php echo $root_path; ?>resources/scripts/uploader/ajaxfileupload.js"></script>
<script language="javascript">
$(document).ready(function() {
	
});
CKEDITOR.replace("newsContent", {
	width: 1000,
	height: 400
});
function ajaxFileUpload()
{
	$("#loading")
	.ajaxStart(function(){
		$(this).show();
	})
	.ajaxComplete(function(){
		$(this).hide();
	});
	
	$.ajaxFileUpload
	(
		{
			url:'<?php echo $root_path; ?>web/general_api/doPicUpload?el=fileUpload',
			secureuri:false,
			fileElementId:'fileUpload',
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
						$("#newsPicPath").val(data.data);
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
function contentPicUpload() {
	$.ajaxFileUpload
	(
		{
			url:'<?php echo $root_path; ?>web/general_api/doPicUpload?el=contentUpload',
			secureuri:false,
			fileElementId:'contentUpload',
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
