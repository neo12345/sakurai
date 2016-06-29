
			<h1>マスタ管理</h1>
			
			<ul>
				<li class="menu2"><a href="/master/?md=school" title="学校">学校</a></li>
				<li class="menu2"><a href="/master/?md=stop" title="駅">駅</a></li>
				<li class="menu2 menu_selected"><a href="/master/?md=city" title="都市">都市</a></li>
				<li class="menu2"><a href="/master/?md=seller" title="売主">売主</a></li>
				<li class="menu2"><a href="/master/?md=seller_office" title="売主">売主営業所</a></li>
			</ul>
			
			<div>
				<div id="js_frame">
					<form class="js_sort_form">
						<? shot_select("pref_cd", $F_pref_cd, "", $RS_pref, "pref_cd", "pref_name", "id=\"js_pref_cd\"", "") ?>
						<table>
							<thead>
								<tr>
									<th>都市コード</th>
									<th>カテゴリ</th>
									<th>都市名</th>
									<th>編集</th>
									<th>並替</th>
								</tr>
							</thead>
							<tbody id="js_list" class="js_sortable">
							<? for($i=0; $i<count($RS_city); $i++) : ?>
								<tr class="js_colum">
									<td>
										<?= $RS_city[$i]['city_cd'] ?>
										<input type="hidden" class="js_city_cd" name="city_cd[]" value="<?= $RS_city[$i]['city_cd'] ?>" />
										<input type="hidden" class="js_city_sort" name="city_sort[]" value="<?= $RS_city[$i]['city_sort'] ?>" />
									</td>
									<td><?= $RS_city[$i]['cat_city_name'] ?></td>
									<td><?= $RS_city[$i]['city_name'] ?></td>
									<td class="edit"><input type="button" class="js_edit" value="編集" /></td>
									<td class=""><div class="js_sort" style="cursor: move;">並替</div></td>
								</tr>
							<? endfor; ?>
							</tbody>
						</table>
						<input type="hidden" id="js_file_path" value="/master/city.php" />
					</form>
				</div>
				
				<div id="js_frame_link" class="dn">
					<form method="post" action="/master/" class="js_unsubmit">
						<table>
							<tbody>
								<tr>
									<th>都市名</th>
									<td id="js_city_name_link"></td>
								</tr>
								<tr>
									<th>カテゴリ</th>
									<td><? shot_select("cat_city_cd", $F_cat_city_cd, "", $RS_cat_city, "cat_city_cd", "cat_city_name", "id=\"js_cat_city_cd\"", "未選択") ?></td>
								</tr>
								<tr>
									<th>紐付都市</th>
									<td>
										<ul id="js_list_link"></ul>
										<input type="button" id="js_add_link" class="btn_plus js_dialog_open" rel="add" value="追加" />
									</td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" name="pref_cd" id="js_pref_cd_link" />
						<input type="hidden" name="city_cd" id="js_city_cd_link" />
						<input type="button" class="btn_back" id="js_return_link" value="戻る" />
						<input type="submit" name="regist" value="登録" class="formbtn" />
					</form>
				</div>
				
				<div class="controldialog js_dialog_frame" rel="add">
					<p class="bold">紐付都市 追加</p>
					<? shot_select("pref_cd", $F_pref_cd, "", $RS_pref, "pref_cd", "pref_name", "id=\"js_pref_cd_add\"", "") ?>
					<select id="js_city_cd_add"></select>
					<input type="button" class="ico_close js_dialog_close" title="閉じる" value="閉" />
					<input type="button" id="js_add_add" class="btn_plus js_dialog_close" value="追加" />
				</div>
				
			</div>
