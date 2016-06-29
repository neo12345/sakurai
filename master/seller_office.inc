			<h1>マスタ管理</h1>
			
			<ul>
				<li class="menu2"><a href="/master/?md=school" title="学校">学校</a></li>
				<li class="menu2"><a href="/master/?md=stop" title="駅">駅</a></li>
				<li class="menu2"><a href="/master/?md=city" title="都市">都市</a></li>
				<li class="menu2"><a href="/master/?md=seller" title="売主">売主</a></li>
				<li class="menu2 menu_selected"><a href="/master/?md=seller_office" title="売主">売主営業所</a></li>
			</ul>
			
			<div>
				<div id="js_frame">
					<div id="js_frame_regist" class="">
						<table>
							<tr>
								<th>売主名</th>
								<td>
									<?= shot_select_db("seller_cd", $selected, "", "m_seller", "seller_cd", "seller_name", "id='js_seller_cd'") ?>
									<input type="text" id="js_seller_office_name" placeholder="営業所名" /><input type="text" id="js_seller_office_tel" placeholder="電話番号" /><input type="button" id="js_regist_seller" value="登録" />
									<input type="hidden" value="" id="js_seller_office_cd" />
								</td>
							</tr>
						</table>
					</div>
					<form class="js_sort_form">
						<table>
							<thead>
								<tr>
									<th>営業所コード</th>
									<th>売主名</th>
									<th>営業所名</th>
									<th>電話番号</th>
									<th>編集</th>
									<th>並替</th>
									<th>削除</th>
								</tr>
							</thead>
							<tbody id="js_list" class="js_sortable">
								<? for($i=0; $i<count($RS_seller_office); $i++) : ?>
									<tr class="js_colum">
										<td>
											<?= $RS_seller_office[$i]['seller_office_cd'] ?>
											<input type="hidden" class="js_seller_office_cd" name="seller_office_cd[]" value="<?= $RS_seller_office[$i]['seller_office_cd'] ?>" />
											<input type="hidden" class="js_seller_office_sort" name="seller_office_sort[]" value="<?= $RS_seller_office[$i]['seller_office_sort'] ?>" />
										</td>
										<td>
											<?= get_colum_key("m_seller", "seller_cd", $seller_cd = get_colum_key("r_seller", "seller_office_cd", $RS_seller_office[$i]['seller_office_cd'], "seller_cd", ""), "seller_name", "") ?>
											<input type="hidden" class="js_seller_cd" value="<?= $seller_cd ?>" />
										</td>
										<td>
											<?= $RS_seller_office[$i]['seller_office_name'] ?>
											<input type="hidden" class="js_seller_office_name" value="<?= $RS_seller_office[$i]['seller_office_name'] ?>" />
										</td>
										<td>
											<?= $RS_seller_office[$i]['seller_office_tel'] ?>
											<input type="hidden" class="js_seller_office_tel" value="<?= $RS_seller_office[$i]['seller_office_tel'] ?>" />
										</td>
										<td class="edit"><input type="button" class="js_edit" value="編集" /></td>
										<td class=""><div class="js_sort" style="cursor: move;">並替</div></td>
										<td class="del"><p class="js_delete">削除</p></td>
									</tr>
								<? endfor; ?>
							</tbody>
						</table>
						<input type="hidden" id="js_file_path" value="/master/seller.php" />
					</form>
				</div>
			</div>
