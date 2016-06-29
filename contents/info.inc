			<h1>コンテンツ管理</h1>
			
			<ul>
<!--				<li class="menu2"><a href="/contents/?md=list" title="表示">表示</a></li>-->
				<li class="menu2"><a href="/contents/?md=select" title="スマイルセレクト">ｽﾏｲﾙｾﾚｸﾄ</a></li>
				<li class="menu2"><a href="/contents/?md=youtube" title="YouTube">YouTube</a></li>
				<li class="menu2 menu_selected"><a href="/contents/?md=info" title="更新情報">更新情報</a></li>
				<li class="menu2"><a href="/contents/?md=blog" title="ブログ案内">ブログ案内</a></li>
<!--				<li class="menu2"><a href="/contents/?md=review" title="お客様の声">お客様の声</a></li>-->
			</ul>
			
			<div>
				
				<div>
						<table>
							<thead>
								<tr>
									<th>日付</th>
									<th>タイトル</th>
									<th>内容</th>
									<th>編集</th>
									<th>削除</th>
								</tr>
							</thead>
							<tbody id="js_list">
							<? for($i=0; $i<count($RS_info); $i++) : ?>
								<tr class="js_colum">
									<td>
										<?= pic_object_date("Y年m月d日(D)", $RS_info[$i]['info_date']) ?>
										<input type="hidden" class="js_info_cd" value="<?= $RS_info[$i]['info_cd'] ?>" />
										<input type="hidden" class="js_info_date" value="<?= pic_object_date("Y年m月d日(D)", $RS_info[$i]['info_date']) ?>" />
									</td>
									<td><?= $RS_info[$i]['info_title'] ?></td>
									<td>
										<? if($RS_info[$i]['info_link']): ?>
											<a href="<?= $RS_info[$i]['info_link'] ?>" target="blank"><?= $RS_info[$i]['info_contents'] ?></a>
										<? else: ?>
											<?= $RS_info[$i]['info_contents'] ?>
										<? endif; ?>
									</td>
									<td class="edit"><input type="submit" class="js_edit" name="" value="編集" /></td>
									<td class="del"><p class="js_delete curp">削除</p></td>
								</tr>
							<? endfor; ?>
							</tbody>
						</table>
				</div>
				<div class="mt30">
					<form method="post" action="/contents/info.php" class="js_unsubmit">
						<table>
							<tbody>
								<tr>
									<th style="width: 200px;">日付</th>
									<td><input type="text" name="info_date" id="js_info_date" class="js_datepicker" style="width: 100px;" value="" /></td>
								</tr>
								<tr>
									<th>タイトル</th>
									<td><input type="text" name="info_title" id="js_info_title" style="width: 200px;" value="" /></td>
								</tr>
								<tr>
									<th>内容</th>
									<td><input type="text" name="info_contents" id="js_info_contents" style="width: 500px;" value="" /></td>
								</tr>
								<tr>
									<th>リンク</th>
									<td><input type="text" name="info_link" id="js_info_link" style="width: 500px;" value="" /></td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" id="js_info_cd" name="info_cd" value="" />
						<input type="submit" name="cancel" value="キャンセル" />
						<input type="submit" name="regist" value="登録" class="formbtn" />
					</form>
				</div>
				
			</div>
