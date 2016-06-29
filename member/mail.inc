			<h1>会員管理</h1>
			
			<ul>
				<li class="menu2"><a href="/member/?md=list" title="会員一覧">会員一覧</a></li>
				<li class="menu2"><a href="/member/?md=regist" title="会員一覧">会員登録</a></li>
				<li class="menu2 menu_selected"><a href="/member/?md=mail" title="メール">メール</a></li>
			</ul>
			
			<div>
				<div id="js_frame">
					<table>
						<thead>
							<tr>
								<th>会員コード</th>
								<th>会員名</th>
								<th>編集</th>
							</tr>
						</thead>
						<tbody id="js_list">
						<? for($i=0; $i<count($RS_mem); $i++) : ?>
							<tr class="js_colum">
								<td><?= $RS_mem[$i]['mem_cd'] ?><input type="hidden" class="js_mem_cd" value="<?= $RS_mem[$i]['mem_cd'] ?>" /></td>
								<td><?= $RS_mem[$i]['mem_name'] ?></td>
								<td class="edit"><input type="button" class="js_edit" value="編" /></td>
							</tr>
						<? endfor; ?>
						</tbody>
					</table>
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
						<input type="button" class="btn_back" id="js_return_link" value="戻るaaa" />
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
