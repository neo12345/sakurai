			<h1>物件管理</h1>
			
			<ul>
				<li class="menu2 menu_selected"><a href="/item/?md=list" title="物件一覧">物件一覧</a></li>
				<li class="menu2"><a href="/item/?md=regist" title="物件登録">物件登録</a></li>
				<li class="menu2"><a href="/item/?md=analysis" title="集計・解析">集計・解析</a></li>
			</ul>
			
			<div>
			
<!--				<form method="post" action="" class="search">
				
					<p>検索条件</p>
				
					<fieldset>
						<label>キーワード : <input name="keyword" type="text" required /></label>
						<input type="submit" value="検索" />
					</fieldset>
				</form>-->
				
				<form method="post" action="/item/?md=regist">
					<? shot_select("city_cd", $F_city_cd, "", $RS_city, "city_cd", "city_name", "id=\"js_city_cd\"", "全てのエリア"); ?>
					<? shot_select("seller_cd", $F_seller_cd, "", $RS_seller, "seller_cd", "seller_name", "id=\"js_seller_cd\"", "-----"); ?>
					<table>
						<thead>
							<tr>
								<th>No.</th>
								<th>物件名</th>
								<th>住所</th>
								<th>価格</th>
								<th>状態</th>
								<th>編集</th>
								<th>削除</th>
							</tr>
						</thead>
						<tbody id="js_list">
							<? for ($i = 0; $i < count($RS_item); $i++) : ?>
								<? if($RS_item[$i]['flg_soldout']){ $color="silver"; $status="成"; }elseif($RS_item[$i]['flg_nego']){ $color="pink"; $status="商"; }else{ $color="white"; $status="販"; } ?>
								<tr class="js_colum" style="background-color: <?= $color ?>;">
									<td class="no"><?= $RS_item[$i]['item_cd'] ?><input type="hidden" class="js_item_cd" value="<?= $RS_item[$i]['item_cd'] ?>" /></td>
									<td>
										<? if($RS_item[$i]['flg_active']): ?>
											<a href="http://www.smile-fudosan.com/item/?md=detail&cd=<?= $RS_item[$i]['item_cd'] ?>&qwert=1" target="_blank">
												<?= $RS_item[$i]['item_name'] ?><? if($RS_item[$i]['item_name_sub']): ?>（<?= $RS_item[$i]['item_name_sub'] ?>）<? endif; ?>
											</a>
										<? else: ?>
											<?= $RS_item[$i]['item_name'] ?><? if($RS_item[$i]['item_name_sub']): ?>（<?= $RS_item[$i]['item_name_sub'] ?>）<? endif; ?>
										<? endif; ?>
										<input type="hidden" class="js_item_name" value="<?= $RS_item[$i]['item_name'] ?>" />
									</td>
									<td><?= $RS_item[$i]['pref_name'] ?><?= $RS_item[$i]['city_name'] ?><?= $RS_item[$i]['item_addr2'] ?><?= $RS_item[$i]['item_addr3'] ?></td>
									<td class="tar">
										<span class="js_item_price" style="cursor: pointer;"><?= number_format($RS_item[$i]['item_price']) ?>万円</span>
										<div class="js_price_frame dn">
											<input class="js_value" style="width: 30px; height: 13px;" type="text" value="<?= $RS_item[$i]['item_price'] ?>" />
											<span class="js_regist fsSx curp">登録</span>
										</div>
									</td>
									<td><input class="js_status" type="button" value="<?=  $status ?>" /></td>
									<td class="edit"><input type="submit" name="edit[<?= $RS_item[$i]['item_cd'] ?>]" value="編集" /></td>
									<td class="del"><p class="js_delete">削除</p></td>
								</tr>
							<? endfor; ?>
						</tbody>
					</table>
				</form>
				
			</div>
