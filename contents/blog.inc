			<h1>コンテンツ管理</h1>
			
			<ul>
<!--				<li class="menu2"><a href="/contents/?md=list" title="表示">表示</a></li>-->
				<li class="menu2"><a href="/contents/?md=select" title="スマイルセレクト">ｽﾏｲﾙｾﾚｸﾄ</a></li>
				<li class="menu2"><a href="/contents/?md=youtube" title="YouTube">YouTube</a></li>
				<li class="menu2"><a href="/contents/?md=info" title="更新情報">更新情報</a></li>
				<li class="menu2 menu_selected"><a href="/contents/?md=blog" title="ブログ案内">ブログ案内</a></li>
<!--				<li class="menu2"><a href="/contents/?md=review" title="お客様の声">お客様の声</a></li>-->
			</ul>
			
			<div>
			
				<form class="js_sort_form" action="/contents/blog.php">
					<fieldset>
						<table>
							<tr>
								<th>ブログ画像</th>
								<td>
									<ul class="js_wrap">
										<li class="js_frame">
											<div class="PreviewFrame js_image" style="background-image: url('<?= make_img_path($G_up_dir."/blog/img_blog.*", "") ?>');"></div>
											<input type="hidden" class="js_status" value="blog" />
										</li>
									</ul>
								</td>
							</tr>
							<tr>
								<th>更新日</th>
								<td><input type="text" name="blog_date" value="<?= pic_object_date("Y/m/d", $RS_blog[0]['blog_date']) ?>" class="js_datepicker" /></td>
							</tr>
							<tr>
								<th>タイトル</th>
								<td><input type="text" name="blog_title" value="<?= $RS_blog[0]['blog_title'] ?>" style="width: 100%;" /></td>
							</tr>
							<tr>
								<th>内容</th>
								<td><input type="text" name="blog_contents" value="<?= $RS_blog[0]['blog_contents'] ?>" style="width: 100%;" /></td>
							</tr>
							<tr>
								<th>リンク先</th>
								<td><input type="text" name="blog_link" value="<?= $RS_blog[0]['blog_link'] ?>" style="width: 100%;" /></td>
							</tr>
						</table>
					</fieldset>
					<input type="submit" name="regist" value="登録" />
				</form> 
				
			</div>
