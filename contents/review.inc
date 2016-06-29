			<h1>コンテンツ管理</h1>
			
			<ul>
<!--				<li class="menu2"><a href="/contents/?md=list" title="表示">表示</a></li>-->
				<li class="menu2"><a href="/contents/?md=select" title="スマイルセレクト">ｽﾏｲﾙｾﾚｸﾄ</a></li>
				<li class="menu2"><a href="/contents/?md=youtube" title="YouTube">YouTube</a></li>
				<li class="menu2"><a href="/contents/?md=blog" title="ブログ案内">ブログ案内</a></li>
<!--				<li class="menu2 menu_selected"><a href="/contents/?md=review" title="お客様の声">お客様の声</a></li>-->
			</ul>
			
			<div>
			
				<form method="post" action="/contents/" class="js_unsubmit">
					<fieldset>
						<table>
							<tbody>
								<tr>
									<th>表示</th>
									<td>
										<input type="hidden" name="flg_active" value="" />
										<label><input type="checkbox" name="flg_active" value="1" checked />サイトに表示する</label>
									</td>
								</tr>
								<tr>
									<th>成約済</th>
									<td>
																				<input type="hidden" name="flg_soldout" value="" />
										<label><input type="checkbox" name="flg_soldout" value="1"  />成約済を表示する</label>
									</td>
								</tr>
								<tr>
									<th>物件名</th>
									<td><input name="item_name" type="text" style="width:500px;" value="" /></td>
								</tr>
							</tbody>
						</table>
						<input type="submit" name="regist" value="登録" class="formbtn" />
					</fieldset>
				</form>
				
			</div>
