			<h1>物件管理</h1>
			
			<ul>
				<li class="menu2"><a href="/item/?md=list" title="物件一覧">物件一覧</a></li>
				<li class="menu2"><a href="/item/?md=regist" title="物件登録">物件登録</a></li>
				<li class="menu2 menu_selected"><a href="/item/" title="物件表示">物件表示</a></li>
			</ul>
			
			<div>
			
				<form method="post" action="" class="search">
				
					<p>検索条件</p>
				
					<fieldset>
						<label>キーワード : <input name="keyword" type="text" required /></label>
						<input type="submit" value="検索" />
					</fieldset>
				</form>
				
				<form method="post" action="/item/?md=regist">
					<table>
						<thead>
							<tr>
								<th>物件No.</th>
								<th>物件名</th>
								<th>住所</th>
								<th>編集</th>
								<th>削除</th>
							</tr>
						</thead>
						<tbody>
							<? for ($i = 0; $i < count($RS_item); $i++) : ?>
								<tr class="js_colum">
									<td class="no"><?= $RS_item[$i]['item_cd'] ?><input type="hidden" class="js_item_cd" value="<?= $RS_item[$i]['item_cd'] ?>" /></td>
									<td>
										<? if($RS_item[$i]['flg_active']): ?>
											<a href="http://www.sh-smilenavi.com/item/?md=detail&cd=<?= $RS_item[$i]['item_cd'] ?>" target="blank"><?= $RS_item[$i]['item_name'] ?></a>
										<? else: ?>
											<?= $RS_item[$i]['item_name'] ?>
										<? endif; ?>
										<input type="hidden" class="js_item_name" value="<?= $RS_item[$i]['item_name'] ?>" />
									</td>
									<td><?= $RS_item[$i]['pref_name'] ?><?= $RS_item[$i]['city_name'] ?><?= $RS_item[$i]['item_addr2'] ?><?= $RS_item[$i]['item_addr3'] ?></td>
									<td class="edit"><input type="submit" name="edit[<?= $RS_item[$i]['item_cd'] ?>]" value="編集" /></td>
									<td class="del"><p class="js_delete">削除</p></td>
								</tr>
							<? endfor; ?>
						</tbody>
					</table>
				</form>
				
			</div>
