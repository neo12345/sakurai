<h1>物件管理</h1>
			
			<ul>
				<li class="menu2"><a href="/item/?md=list" title="物件一覧">物件一覧</a></li>
				<li class="menu2 menu_selected"><a href="/item/?md=regist" title="物件登録">物件登録</a></li>
				<li class="menu2"><a href="/item/?md=analysis" title="集計・解析">集計・解析</a></li>
			</ul>
			
			<div>
			
				<form method="post" action="/item/" class="js_unsubmit js_sort_form">
					<fieldset>
						<? if($RS_item[0]['item_cd']): ?>
							<input type="image" name="copy" value="複写" src="<?= $G_img_dir ?>/common/bt_copy.png" />
						<? endif; ?>
						<table>
							<tbody>
								<tr>
									<th>表示</th>
									<td>
										<? if($RS_item[0]['flg_active']){ $checked="checked"; }elseif(!$F_edit){ $checked="checked"; }else{ $checked=""; } ?>
										<input type="hidden" name="flg_active" value="" />
										<label><input type="checkbox" name="flg_active" value="1" <?= $checked ?> />サイトに表示する</label>
									</td>
								</tr>
								<tr>
									<th>物件状況</th>
									<td>
										<? if($RS_item[0]['flg_nego']){ $checked="checked"; }else{ $checked=""; } ?>
										<input type="hidden" name="flg_nego" value="" />
										<label class="fl"><input type="checkbox" name="flg_nego" value="1" <?= $checked ?> />商談中</label>
										<? if($RS_item[0]['flg_soldout']){ $checked="checked"; }else{ $checked=""; } ?>
										<input type="hidden" name="flg_soldout" value="" />
										<input type="hidden" name="date_soldout" value="" />
										<label class="fl ml10"><input id="js_flg_soldout" type="checkbox" name="flg_soldout" value="1" <?= $checked ?> />成約済</label>
										<input id="js_date_soldout" class="js_datepicker dn fl ml5" type="text" name="date_soldout" value="<?= pic_object_date("Y/m/d", $RS_item[0]['date_soldout']) ?>" style="width: 65px; height: 15px;" placeholder="成約日" />
										<div class="fc"></div>
									</td>
								</tr>
								<tr>
									<th>追客</th>
									<td>
										<? for ($i = 0; $i < count($RS_user); $i++) : ?>
											<? if(get_colum_key("r_item10", "item_cd", $RS_item[0]['item_cd'], "rel_cd", "user_cd='".$RS_user[$i]['user_cd']."'")){ $checked="checked"; }else{ $checked=""; } ?>
											<? if($i>0){ $class="ml10"; }else{ $class=""; } ?>
											<label class="fl <?= $class ?>"><input type="checkbox" name="user_cd_chase[]" value="<?= $RS_user[$i]['user_cd'] ?>" <?= $checked ?> /><?= $RS_user[$i]['user_name'] ?></label>
										<? endfor; ?>
										<div class="fc"></div>
									</td>
								</tr>
								<tr>
									<th>物件名</th>
									<td><input name="item_name" type="text" style="width:500px;" value="<?= $RS_item[0]['item_name'] ?>" />　<input name="item_name_sub" type="text" value="<?= $RS_item[0]['item_name_sub'] ?>" placeholder="1号棟" /></td>
								</tr>
								<tr>
									<th>売主</th>
									<td><? shot_select("seller_cd", $RS_item[0]['seller_cd'], "", $RS_seller, "seller_cd", "seller_name", "", "-----") ?></td>
								</tr>
								<tr>
									<th>物件タイプ</th>
									<td>
										<? shot_select("cat_item_cd", $RS_item[0]['cat_item_cd'], "", $RS_cat_item, "cat_item_cd", "cat_item_name", "id=\"js_cat_item_cd\"", "") ?>
										<? if($RS_item[0]['flg_new']){ $checked="checked"; }else{ $checked=""; } ?>
										<input type="hidden" name="flg_new" value="" />
										<label><input type="checkbox" name="flg_new" value="1" <?= $checked ?> id="js_flg_new" />新築</label>
										<? if($RS_item[0]['flg_member']){ $checked="checked"; }else{ $checked=""; } ?>
										<input type="hidden" name="flg_member" value="" />
										<label><input type="checkbox" name="flg_member" value="1" <?= $checked ?> />会員物件</label>
									</td>
								</tr>
								<tr>
									<th>販売価格</th>
									<td>
										<label><input name="item_price" type="text" value="<?= $RS_item[0]['item_price'] ?>" id="js_item_price" /> 万円</label>
										<? if($RS_item[0]['flg_taxinc']){ $checked="checked"; }else{ $checked=""; } ?>
										<input type="hidden" name="flg_taxinc" value="" />
										<label><input type="checkbox" name="flg_taxinc" value="1" <?= $checked ?> />税込み表示</label>
									</td>
								</tr>
								<tr>
									<th>水面下</th>
									<td>
										<label><input name="item_price_under" type="text" value="<?= $RS_item[0]['item_price_under'] ?>" /> 万円</label>
									</td>
								</tr>
								<tr>
									<th>手数料割引</th>
									<td><label><input name="item_discount" type="text" value="<?= $RS_item[0]['item_discount'] ?>" id="js_item_discount" /> ％OFF（手数料不要の場合は100、割引なしの場合は0を入力）</label></td>
								</tr>
								<tr>
									<th>間取り</th>
									<td>
										<? if($RS_item[0]['flg_closet']){ $checked="checked"; }else{ $checked=""; } ?>
										<input type="hidden" name="flg_closet" value="" />
										<label><? shot_select("layout_cd", $RS_item[0]['layout_cd'], "", $RS_layout, "layout_cd", "layout_name", "", "") ?><input type="checkbox" name="flg_closet" value="1" <?= $checked ?> />納戸(+S)</label>
									</td>
								</tr>
								<tr>
									<th>所在地</th>
									<td>
										<? shot_select("pref_cd", $RS_item[0]['pref_cd'], "", $RS_pref, "pref_cd", "pref_name", "id=\"js_pref_cd\"", "") ?>
										<? shot_select("city_cd", $RS_item[0]['city_cd'], "", $RS_city, "city_cd", "city_name", "id=\"js_city_cd\" class=\"select_city\"", "") ?>
										<input name="item_addr2" type="text" value="<?= $RS_item[0]['item_addr2'] ?>" id="js_addr2" placeholder="福岡市博多区光丘町1丁目" />
										<input name="item_addr3" type="text" value="<?= $RS_item[0]['item_addr3'] ?>" id="js_addr3" placeholder="1-36" />
										<input name="item_addr4" type="text" value="<?= $RS_item[0]['item_addr4'] ?>" id="js_addr4" placeholder="スマイルビル 101号室" />
									</td>
								</tr>
								<tr>
									<th>築年月</th>
									<td><? make_num_select("item_build_y", $item_build_y, "1960", date("Y", strtotime("+1 year")), "", "", "", date("Y"), "") ?>年<? make_num_select("item_build_m", $item_build_m, "1", "12", "", "", "2", date("m"), "") ?>月</td>
								</tr>
								<tr>
									<th>紹介見出</th>
									<td><input name="item_caption" type="text" style="width:500px;" value="<?= $RS_item[0]['item_caption'] ?>" /></td>
								</tr>
								<tr>
									<th>紹介文</th>
									<td><textarea name="item_explain" rows="10" style="width:500px;"><?= $RS_item[0]['item_explain'] ?></textarea></td>
								</tr>
								<tr>
									<th>取引形態</th>
									<td><? shot_select("med_cd", $RS_item[0]['med_cd'], "", $RS_med, "med_cd", "med_name", "", "") ?></td>
								</tr>
								<tr>
									<th>構造</th>
									<td><? shot_select("struc_cd", $RS_item[0]['struc_cd'], "", $RS_struc, "struc_cd", "struc_name", "", "") ?></td>
								</tr>
<!--								<tr>
									<th>工法</th>
									<td><? shot_select("meth_cd", $RS_item[0]['meth_cd'], "", $RS_meth, "meth_cd", "meth_name", "", "") ?></td>
								</tr>-->
								<tr>
									<th>建築確認番号</th>
									<td><input name="item_serial" type="text" value="<?= $RS_item[0]['item_serial'] ?>" /></td>
								</tr>
<!--								<tr>
									<th>諸会費</th>
									<td><? shot_select("dues_cd", $RS_item[0]['dues_cd'], "", $RS_dues, "dues_cd", "dues_name", "", "無し") ?></td>
								</tr>-->
								<tr>
									<th>上水道</th>
									<td><? shot_select("water_cd", $RS_item[0]['water_cd'], "", $RS_water, "water_cd", "water_name", "", "なし", 1) ?></td>
								</tr>
								<tr>
									<th>下水道</th>
									<td><? shot_select("sewer_cd", $RS_item[0]['sewer_cd'], "", $RS_sewer, "sewer_cd", "sewer_name", "", "なし", 1) ?></td>
								</tr>
								<tr>
									<th>光熱設備</th>
									<td><? shot_select("fuel_cd", $RS_item[0]['fuel_cd'], "", $RS_fuel, "fuel_cd", "fuel_name", "", "なし", 1) ?></td>
								</tr>
								<tr>
									<th>沿線・駅</th>
									<td class="js_colum">
										<ul class="add js_flame_stop">
											<li class="js_list" style="display: none;">
												<a class="js_del_list">削除</a>
												<? shot_select("pubtrans_cd[]", "1", "", $RS_pubtrans, "pubtrans_cd", "pubtrans_name", "class=\"js_pubtrans\"", "") ?>
												<? shot_select_db("stop_cd[]", "82", "", "v_stop", "stop_cd", "stop_name", "class=\"select_st js_stop\"", "pubtrans_cd='1'", "") ?>
												まで<? shot_select("transway_cd[]", "1", "", $RS_transway, "transway_cd", "transway_name", "", "") ?>
												<label><input name="transdist[]" type="text" class="input_min" /> m</label>  <input name="transtime[]" type="text" class="input_min" /> 分
												<input style="width: 100px;" type="text" class="js_search_word_stop" placeholder="検索補助" />
											</li>
											<? if(count($RS_item_pub)): ?>
												<? for ($i = 0; $i < count($RS_item_pub); $i++) : ?>
													<li class="js_list">
														<a class="js_del_list">削除</a>
														<? shot_select("pubtrans_cd[]", $RS_item_pub[$i]['pubtrans_cd'], "", $RS_pubtrans, "pubtrans_cd", "pubtrans_name", "class=\"js_pubtrans\"", "") ?>
														<? shot_select_db("stop_cd[]", $RS_item_pub[$i]['stop_cd'], "", "v_stop", "stop_cd", "stop_name", "class=\"select_st js_stop\"", "pubtrans_cd='".$RS_item_pub[$i]['pubtrans_cd']."'", "") ?>
														まで<? shot_select("transway_cd[]", $RS_item_pub[$i]['transway_cd'], "", $RS_transway, "transway_cd", "transway_name", "", "") ?>
														<label><input name="transdist[]" type="text" class="input_min" value="<?= $RS_item_pub[$i]['transdist'] ?>" /> m</label>  <input name="transtime[]" type="text" class="input_min" value="<?= $RS_item_pub[$i]['transtime'] ?>" /> 分
														<input style="width: 100px;" type="text" class="js_search_word_stop" placeholder="検索補助" />
													</li>
												<? endfor; ?>
											<? else: ?>
												<li class="js_list">
													<? shot_select("pubtrans_cd[]", "1", "", $RS_pubtrans, "pubtrans_cd", "pubtrans_name", "class=\"js_pubtrans\"", "") ?>
													<? shot_select_db("stop_cd[]", "82", "", "v_stop", "stop_cd", "stop_name", "class=\"select_st js_stop\"", "pubtrans_cd='1'", "") ?>
													まで<? shot_select("transway_cd[]", "1", "", $RS_transway, "transway_cd", "transway_name", "", "") ?>
													<label><input name="transdist[]" type="text" class="input_min" /> m</label>  <input name="transtime[]" type="text" class="input_min" /> 分
													<input style="width: 100px;" type="text" class="js_search_word_stop" placeholder="検索補助" />
												</li>
											<? endif; ?>
										</ul>
										<p class="plus"><a class="js_add_list">追加</a></p>
									</td>
								</tr>
								<tr class="js_colum_apart">
									<th>管理形態</th>
									<td><? shot_select("admintype_cd", $RS_item[0]['admintype_cd'], "", $RS_admintype, "admintype_cd", "admintype_name", "", "") ?></td>
								</tr>
								<tr class="js_colum_apart">
									<th>管理会社</th>
									<td><input name="item_manage" type="text" value="<?= $RS_item[0]['item_manage'] ?>" /></td>
								</tr>
								<tr class="js_colum_apart">
									<th>管理費</th>
									<td><label><input name="item_cost_admin" type="text" value="<?= $RS_item[0]['item_cost_admin'] ?>" /> 円</label></td>
								</tr>
								<tr class="js_colum_apart">
									<th>修繕積立金</th>
									<td><label><input name="item_cost_repair" type="text" value="<?= $RS_item[0]['item_cost_repair'] ?>" /> 円</label></td>
								</tr>
								<tr>
									<th>その他費用</th>
									<td class="js_colum">
										<ul class="add js_flame_stop">
											<li class="js_list" style="display: none;">
												<a class="js_del_list">削除</a>
												<input name="cost_name[]" type="text" placeholder="ルーフバルコニー使用料" />：<input name="cost_price[]" type="text" />円
											</li>
											<? for ($i = 0; $i < count($RS_cost); $i++) : ?>
												<li class="js_list">
													<a class="js_del_list">削除</a>
													<input name="cost_name[]" type="text" value="<?= $RS_cost[$i]['cost_name'] ?>" placeholder="ルーフバルコニー使用料" />：<input name="cost_price[]" type="text" value="<?= $RS_cost[$i]['cost_price'] ?>" />円
												</li>
											<? endfor; ?>
										</ul>
										<p class="plus"><a class="js_add_list">追加</a></p>
									</td>
								</tr>
								<tr class="js_colum_house">
									<th>駐車場</th>
									<td>敷地内に<input name="item_park_in" type="text" value="<?= $RS_item[0]['item_park_in'] ?>" class="input_min" />台（なしは0台もしくは無記入）</td>
								</tr>
								<tr class="js_colum_apart">
									<th>駐車場</th>
									<td>空き<input name="item_park_vacancy" type="text" value="<?= $RS_item[0]['item_park_vacancy'] ?>" class="input_min" />台（なしは0台もしくは無記入）<input name="item_park_min" type="text" value="<?= $RS_item[0]['item_park_min'] ?>" class="input_min" />円 ～ <input name="item_park_max" type="text" value="<?= $RS_item[0]['item_park_max'] ?>" class="input_min" placeholder="空白は固定" />円</td>
								</tr>
								<tr class="js_colum_house">
									<th>土地面積</th>
									<td><label><input name="item_size_land" type="text" value="<?= $RS_item[0]['item_size_land'] ?>" /> ㎡</label></td>
								</tr>
								<tr class="js_colum_house">
									<th>建築面積</th>
									<td class="js_colum">
										<label><input id="js_item_size_build" name="item_size_build" type="text" value="<?= $RS_item[0]['item_size_build'] ?>" /> ㎡</label>
										<p>面積内訳</p>
										<ul class="add js_flame_stop">
											<li class="js_list" style="display: none;">
												<a class="js_del_list">削除</a>
												<input class="js_detail_name" name="size_detail_name[]" type="text" placeholder="1階面積" />：<input class="js_detail_size" name="size_detail_size[]" type="text" value="" />㎡
											</li>
											<? for ($i = 0; $i < count($RS_size_detail); $i++) : ?>
												<li class="js_list">
													<a class="js_del_list">削除</a>
													<input class="js_detail_name" name="size_detail_name[]" type="text" value="<?= $RS_size_detail[$i]['size_detail_name'] ?>" placeholder="1階面積" />：<input class="js_detail_size" name="size_detail_size[]" type="text" value="<?= $RS_size_detail[$i]['size_detail_size'] ?>" />㎡
												</li>
											<? endfor; ?>
										</ul>
										<p class="plus"><a class="js_add_list" id="js_cal_size">追加</a></p>
									</td>
								</tr>
								<tr class="js_colum_apart">
									<th>専有面積</th>
									<td><label><input name="item_size_floor" type="text" value="<?= $RS_item[0]['item_size_floor'] ?>" /> ㎡</td>
								</tr>
								<tr class="js_colum_apart">
									<th>バルコニー面積</th>
									<td>
										<label><input name="item_size_balcony" type="text" value="<?= $RS_item[0]['item_size_balcony'] ?>" /> ㎡</label>
										向き：<? shot_select("dire_cd", $RS_item[0]['dire_cd'], "", $RS_dire, "dire_cd", "dire_name", "", "-----") ?>
										（なしは0㎡もしくは無記入）
									</td>
								</tr>
								<tr class="js_colum_apart">
									<th>ルーフバルコニー面積</th>
									<td>
										<label><input name="item_size_roofbalcony" type="text" value="<?= $RS_item[0]['item_size_roofbalcony'] ?>" /> ㎡</label>（なしは0㎡もしくは無記入）
									</td>
								</tr>
								<tr class="js_colum_apart">
									<th>その他面積</th>
									<td class="js_colum">
										<ul class="add js_flame_stop">
											<li class="js_list" style="display: none;">
												<a class="js_del_list">削除</a>
												<input name="size_add_name[]" type="text" placeholder="アルコーブ面積" />：<input name="size_add_size[]" type="text" />㎡
											</li>
											<? for ($i = 0; $i < count($RS_size_add); $i++) : ?>
												<li class="js_list">
													<a class="js_del_list">削除</a>
													<input name="size_add_name[]" type="text" value="<?= $RS_size_add[$i]['size_add_name'] ?>" placeholder="アルコーブ面積" />：<input name="size_add_size[]" type="text" value="<?= $RS_size_add[$i]['size_add_size'] ?>" />㎡
												</li>
											<? endfor; ?>
										</ul>
										<p class="plus"><a class="js_add_list">追加</a></p>
									</td>
								</tr>
								<tr class="js_colum_house">
									<th>建ぺい率</th>
									<td><label><input name="item_ratio_build" type="text" value="<?= $RS_item[0]['item_ratio_build'] ?>" />%</label></td>
								</tr>
								<tr class="js_colum_house">
									<th>容積率</th>
									<td><label><input name="item_ratio_floor" type="text" value="<?= $RS_item[0]['item_ratio_floor'] ?>" />%</label></td>
								</tr>
								<tr>
									<th>建物階数</th>
									<td><label>地上<input name="item_floor_above" type="text" value="<?= $RS_item[0]['item_floor_above'] ?>" />階</label>　<label>地下<input name="item_floor_under" type="text" value="<?= $RS_item[0]['item_floor_under'] ?>" />階</label></td>
								</tr>
								<tr class="js_colum_apart">
									<th>総戸数</th>
									<td><label><input name="item_houses" type="text" value="<?= $RS_item[0]['item_houses'] ?>" />戸</label></td>
								</tr>
								<tr class="js_colum_apart">
									<th>所在階数</th>
									<td><label><input name="item_floor" type="text" value="<?= $RS_item[0]['item_floor'] ?>" />階</label></td>
								</tr>
								<tr class="js_colum_apart">
									<th>部屋番号</th>
									<td><label><input name="item_room_num" type="text" value="<?= $RS_item[0]['item_room_num'] ?>" />号室</label></td>
								</tr>
<!--								<tr class="js_colum_house">
									<th>接道(削除予定)</th>
									<td><label><input name="item_road" type="text" value="<?= $RS_item[0]['item_road'] ?>" placeholder="削除予定" /></label></td>
								</tr>-->
								<tr class="js_colum_house">
									<th>接道</th>
									<td class="js_colum">
										<ul class="add js_flame_stop">
											<li class="js_list" style="display: none;">
												<a class="js_del_list">削除</a>
												<? shot_select("along_dire_cd[]", "", "", $RS_dire, "dire_cd", "dire_name", "", "") ?>側　<input name="along_size[]" type="text" />m　<? shot_select("road_cd[]", "", "", $RS_road, "road_cd", "road_name", "", "") ?>
											</li>
											<? if(count($RS_along)): ?>
												<? for ($i = 0; $i < count($RS_along); $i++) : ?>
													<li class="js_list">
														<? if($i != 0): ?>
															<a class="js_del_list">削除</a>
														<? endif; ?>
														<? shot_select("along_dire_cd[]", $RS_along[$i]['dire_cd'], "", $RS_dire, "dire_cd", "dire_name", "", "") ?>側　<input name="along_size[]" type="text" value="<?= $RS_along[$i]['along_size'] ?>" />m　<? shot_select("road_cd[]", $RS_along[$i]['road_cd'], "", $RS_road, "road_cd", "road_name", "", "") ?>
													</li>
												<? endfor; ?>
											<? else: ?>
												<li class="js_list">
													<? shot_select("along_dire_cd[]", "", "", $RS_dire, "dire_cd", "dire_name", "", "") ?>側　<input name="along_size[]" type="text" />m　<? shot_select("road_cd[]", "", "", $RS_road, "road_cd", "road_name", "", "") ?>
												</li>
											<? endif; ?>
										</ul>
										<p class="plus"><a class="js_add_list">追加</a></p>
									</td>
								</tr>
								<tr>
									<th>土地権利</th>
									<td><? shot_select("rights_cd", $RS_item[0]['rights_cd'], "", $RS_rights, "rights_cd", "rights_name", "", "") ?></td>
								</tr>
								<tr class="js_colum_house">
									<th>地目</th>
									<td><? shot_select("landcat_cd", $RS_item[0]['landcat_cd'], "", $RS_landcat, "landcat_cd", "landcat_name", "", "") ?></td>
								</tr>
								<tr>
									<th>都市計画</th>
									<td><? shot_select("plan_cd", $RS_item[0]['plan_cd'], "", $RS_plan, "plan_cd", "plan_name", "", "") ?></td>
								</tr>
								<tr class="js_colum_house">
									<th>用途地域</th>
									<td class="js_colum">
										<ul class="add js_flame_stop">
											<li class="js_list" style="display: none;">
												<a class="js_del_list">削除</a>
												<? shot_select("dist_cd[]", $RS_item[0]['dist_cd'], "", $RS_dist, "dist_cd", "dist_name", "", "") ?>
											</li>
											<? if(count($RS_item_dist)): ?>
												<? for ($i = 0; $i < count($RS_item_dist); $i++) : ?>
													<li class="js_list">
														<? if($i != 0): ?>
															<a class="js_del_list">削除</a>
														<? endif; ?>
														<? shot_select("dist_cd[]", $RS_item_dist[$i]['dist_cd'], "", $RS_dist, "dist_cd", "dist_name", "", "") ?>
													</li>
												<? endfor; ?>
											<? else: ?>
												<li class="js_list">
													<? shot_select("dist_cd[]", $RS_item_dist[$i]['dist_cd'], "", $RS_dist, "dist_cd", "dist_name", "", "") ?>
												</li>
											<? endif; ?>
										</ul>
										<p class="plus"><a class="js_add_list">追加</a></p>
									</td>
								</tr>
								<tr>
									<th>その他制限等</th>
									<td><input name="item_restrict" type="text" value="<?= $RS_item[0]['item_restrict'] ?>" style="width: 500px;" placeholder="建基法22条指定区域・絶対高10m" /></td>
								</tr>
								<tr class="js_colum">
									<th>小学校</th>
									<td>
										<? shot_select("school_pri_cd", $RS_item[0]['school_pri_cd'], "", $RS_school_pri, "school_pri_cd", "school_pri_name", "id=\"js_school_pri_cd\" style=\"width: 170px;\"", "") ?>まで<input class="js_dist input_min" name="item_dist_pri" type="text" value="<?= $RS_item[0]['item_dist_pri'] ?>" /> m  <input class="js_min input_min" name="item_min_pri" type="text" value="<?= $RS_item[0]['item_min_pri'] ?>" /> 分
										<input style="width: 100px;" type="text" id="js_search_word_pri" placeholder="検索補助" />
									</td>
								</tr>
								<tr class="js_colum">
									<th>中学校</th>
									<td>
										<? shot_select("school_jun_cd", $RS_item[0]['school_jun_cd'], "", $RS_school_jun, "school_jun_cd", "school_jun_name", "id=\"js_school_jun_cd\" style=\"width: 170px;\"", "") ?>まで<input class="js_dist input_min" name="item_dist_jun" type="text" value="<?= $RS_item[0]['item_dist_jun'] ?>" /> m  <input class="js_min input_min" name="item_min_jun" type="text" value="<?= $RS_item[0]['item_min_jun'] ?>" /> 分
										<input style="width: 100px;" type="text" id="js_search_word_jun" placeholder="検索補助" />
									</td>
								</tr>
								<tr>
									<th>学区</th>
									<td>
										<? if(!$RS_item[0]['cat_schigh_cd']){ $RS_item[0]['cat_schigh_cd']=4; } //ディフォルトで「千代中学校」の場合 ?>
										<? shot_select("cat_schigh_cd", $RS_item[0]['cat_schigh_cd'], "", $RS_cat_schigh, "cat_schigh_cd", "cat_schigh_name", "id=\"js_cat_schigh_cd\"", "") ?>
									</td>
								</tr>
								<tr>
									<th>特記事項</th>
									<td><textarea name="item_memo" rows="10" style="width:500px;"><?= $RS_item[0]['item_memo'] ?></textarea></td>
								</tr>
								<tr>
									<th>物件特徴</th>
									<td>
										<dl class="point">
										
											<dt>表示</dt>
											<dd>
											<? if($RS_item[0]['flg_recommend']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_recommend" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_recommend" value="1" <?= $checked ?> />オススメ</label>
											<? if($RS_item[0]['flg_reform']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_reform" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_reform" value="1" <?= $checked ?> />リフォーム</label>
											<? if($RS_item[0]['flg_down']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_down" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_down" value="1" <?= $checked ?> />プライスダウン</label>
											<? if($RS_item[0]['flg_finish']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_finish" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_finish" value="1" <?= $checked ?> />完成済</label>
											</dd>
	
											<dt>立地・土地特徴</dt>
											<dd>
											<? if($RS_item[0]['flg_investigate']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_investigate" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_investigate" value="1" <?= $checked ?> />地盤調査済</label>
											<? if($RS_item[0]['flg_land_100over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_land_100over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_land_100over" value="1" <?= $checked ?> />土地100坪以上</label>
											<? if($RS_item[0]['flg_land_50over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_land_50over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_land_50over" value="1" <?= $checked ?> />土地50坪以上</label>
											<? if($RS_item[0]['flg_near_urban']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_near_urban" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_near_urban" value="1" <?= $checked ?> />市街地が近い</label>
<!--											<? if($RS_item[0]['flg_road_south']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_road_south" value="" />
											<label><input type="checkbox" name="flg_road_south" value="1" <?= $checked ?> />南側道路面す</label>-->
											<? if($RS_item[0]['flg_quiet']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_quiet" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_quiet" value="1" <?= $checked ?> />閑静な住宅地</label>
											<? if($RS_item[0]['flg_road_6over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_road_6over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_road_6over" value="1" <?= $checked ?> />前道６m以上</label>
											<? if($RS_item[0]['flg_corner_lot']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_corner_lot" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_corner_lot" value="1" <?= $checked ?> />角地</label>
<!--											<? if($RS_item[0]['flg_fairing']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_fairing" value="" />
											<label><input type="checkbox" name="flg_fairing" value="1" <?= $checked ?> />整形地</label>
											<? if($RS_item[0]['flg_nature']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_nature" value="" />
											<label><input type="checkbox" name="flg_nature" value="1" <?= $checked ?> />緑豊かな住宅地</label>
											<? if($RS_item[0]['flg_suburb']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_suburb" value="" />
											<label><input type="checkbox" name="flg_suburb" value="1" <?= $checked ?> />都市近郊</label>
											<? if($RS_item[0]['flg_none_front']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_none_front" value="" />
											<label><input type="checkbox" name="flg_none_front" value="1" <?= $checked ?> />前面棟無</label>
											<? if($RS_item[0]['flg_hill']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_hill" value="" />
											<label><input type="checkbox" name="flg_hill" value="1" <?= $checked ?> />高台に立地</label>
											<? if($RS_item[0]['flg_large_town']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_large_town" value="" />
											<label><input type="checkbox" name="flg_large_town" value="1" <?= $checked ?> />大型タウン内</label>
											<? if($RS_item[0]['flg_flatland']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_flatland" value="" />
											<label><input type="checkbox" name="flg_flatland" value="1" <?= $checked ?> />平坦地</label>
											<? if($RS_item[0]['flg_land_develop']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_land_develop" value="" />
											<label><input type="checkbox" name="flg_land_develop" value="1" <?= $checked ?> />開発分譲地内</label>
											<? if($RS_item[0]['flg_land_fix']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_land_fix" value="" />
											<label><input type="checkbox" name="flg_land_fix" value="1" <?= $checked ?> />区画整理地内</label>-->
											</dd>
	
											<dt>駅利便性</dt>
											<dd>
											<? if($RS_item[0]['flg_line_2over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_line_2over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_line_2over" value="1" <?= $checked ?> />2沿線以上利用可</label>
<!--											<? if($RS_item[0]['flg_road_flat']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_road_flat" value="" />
											<label><input type="checkbox" name="flg_road_flat" value="1" <?= $checked ?> />駅まで平坦</label>
											<? if($RS_item[0]['flg_terminal']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_terminal" value="" />
											<label><input type="checkbox" name="flg_terminal" value="1" <?= $checked ?> />始発駅</label>-->
											</dd>
	
											<dt>建物構造</dt>
											<dd>
											<? if($RS_item[0]['flg_evaluation_build']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_evaluation_build" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_evaluation_build" value="1" <?= $checked ?> />建設住宅性能評価付</label>
											<? if($RS_item[0]['flg_evaluation_design']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_evaluation_design" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_evaluation_design" value="1" <?= $checked ?> />設計住宅性能評価付</label>
											<? if($RS_item[0]['flg_long_quality']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_long_quality" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_long_quality" value="1" <?= $checked ?> />長期優良住宅</label>
<!--											<? if($RS_item[0]['flg_measures_quake']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_measures_quake" value="" />
											<label><input type="checkbox" name="flg_measures_quake" value="1" <?= $checked ?> />制震・免震・耐震</label>
											<? if($RS_item[0]['flg_inspection']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_inspection" value="" />
											<label><input type="checkbox" name="flg_inspection" value="1" <?= $checked ?> />インスペクション済</label>
											<? if($RS_item[0]['flg_quake_resistant']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_quake_resistant" value="" />
											<label><input type="checkbox" name="flg_quake_resistant" value="1" <?= $checked ?> />耐震適合</label>-->
											</dd>
	
											<dt>住戸・階数</dt>
											<dd>
											<? if($RS_item[0]['flg_floor_double']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_floor_double" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_floor_double" value="1" <?= $checked ?> />2階建</label>
											<? if($RS_item[0]['flg_floor_3over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_floor_3over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_floor_3over" value="1" <?= $checked ?> />3階建以上</label>
											<? if($RS_item[0]['flg_corner_room']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_corner_room" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_corner_room" value="1" <?= $checked ?> />角住戸</label>
											<? if($RS_item[0]['flg_top_floor']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_top_floor" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_top_floor" value="1" <?= $checked ?> />最上階・上階なし</label>
<!--											<? if($RS_item[0]['flg_upper_floor']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_upper_floor" value="" />
											<label><input type="checkbox" name="flg_upper_floor" value="1" <?= $checked ?> />高層階</label>-->
											</dd>
	
											<dt>陽当り・採光・通風</dt>
											<dd>
											<? if($RS_item[0]['flg_south_prospect']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_south_prospect" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_south_prospect" value="1" <?= $checked ?> />南向き</label>
											<? if($RS_item[0]['flg_sunshine']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_sunshine" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_sunshine" value="1" <?= $checked ?> />陽当り良好</label>
											<? if($RS_item[0]['flg_triple_lighting']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_triple_lighting" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_triple_lighting" value="1" <?= $checked ?> />３面採光</label>
<!--											<? if($RS_item[0]['flg_southeast_prospect']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_southeast_prospect" value="" />
											<label><input type="checkbox" name="flg_southeast_prospect" value="1" <?= $checked ?> />東南向き</label>
											<? if($RS_item[0]['flg_all_south']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_all_south" value="" />
											<label><input type="checkbox" name="flg_all_south" value="1" <?= $checked ?> />全室南向き</label>
											<? if($RS_item[0]['flg_ventilation']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_ventilation" value="" />
											<label><input type="checkbox" name="flg_ventilation" value="1" <?= $checked ?> />通風良好</label>
											<? if($RS_item[0]['flg_southwest_prospect']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_southwest_prospect" value="" />
											<label><input type="checkbox" name="flg_southwest_prospect" value="1" <?= $checked ?> />南西向き</label>-->
											<? if($RS_item[0]['flg_double_lighting']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_double_lighting" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_double_lighting" value="1" <?= $checked ?> />全室２面採光</label>
<!--											<? if($RS_item[0]['flg_all_southwest']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_all_southwest" value="" />
											<label><input type="checkbox" name="flg_all_southwest" value="1" <?= $checked ?> />全室南西向き</label>
											<? if($RS_item[0]['flg_all_southeast']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_all_southeast" value="" />
											<label><input type="checkbox" name="flg_all_southeast" value="1" <?= $checked ?> />全室東南向き</label>-->
											</dd>
	
											<dt>室内設備･仕様</dt>
											<dd>
											<? if($RS_item[0]['flg_barrier_free']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_barrier_free" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_barrier_free" value="1" <?= $checked ?> />バリアフリー</label>
<!--											<? if($RS_item[0]['flg_natural']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_natural" value="" />
											<label><input type="checkbox" name="flg_natural" value="1" <?= $checked ?> />自然素材</label>-->
											<? if($RS_item[0]['flg_all_flooring']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_all_flooring" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_all_flooring" value="1" <?= $checked ?> />全居室フローリング</label>
<!--											<? if($RS_item[0]['flg_ceiling_25over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_ceiling_25over" value="" />
											<label><input type="checkbox" name="flg_ceiling_25over" value="1" <?= $checked ?> />天井高2.5ｍ以上</label>-->
											<? if($RS_item[0]['flg_living_stair']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_living_stair" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_living_stair" value="1" <?= $checked ?> />リビング階段</label>
											<? if($RS_item[0]['flg_floorheat']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_floorheat" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_floorheat" value="1" <?= $checked ?> />床暖房</label>
											</dd>
	
											<dt>間取り</dt>
											<dd>
											<? if($RS_item[0]['flg_ldk_20over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_ldk_20over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_ldk_20over" value="1" <?= $checked ?> />LDK20畳以上</label>
											<? if($RS_item[0]['flg_ldk_18over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_ldk_18over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_ldk_18over" value="1" <?= $checked ?> />LDK18畳以上</label>
											<? if($RS_item[0]['flg_ldk_15over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_ldk_15over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_ldk_15over" value="1" <?= $checked ?> />LDK15畳以上</label>
											<? if($RS_item[0]['flg_jp_room']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_jp_room" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_jp_room" value="1" <?= $checked ?> />和室</label>
											<? if($RS_item[0]['flg_loft']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_loft" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_loft" value="1" <?= $checked ?> />ロフト</label>
<!--											<? if($RS_item[0]['flg_wellhole']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_wellhole" value="" />
											<label><input type="checkbox" name="flg_wellhole" value="1" <?= $checked ?> />吹抜け</label>-->
											<? if($RS_item[0]['flg_all_6over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_all_6over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_all_6over" value="1" <?= $checked ?> />全居室6畳以上</label>
											<? if($RS_item[0]['flg_two_gene']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_two_gene" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_two_gene" value="1" <?= $checked ?> />2世帯住宅</label>
<!--											<? if($RS_item[0]['flg_movable_partition']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_movable_partition" value="" />
											<label><input type="checkbox" name="flg_movable_partition" value="1" <?= $checked ?> />可動間仕切り</label>-->
											<? if($RS_item[0]['flg_alcove']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_alcove" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_alcove" value="1" <?= $checked ?> />アルコーブ</label>
											<? if($RS_item[0]['flg_porch']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_porch" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_porch" value="1" <?= $checked ?> />専用ポーチ</label>
											</dd>
											
											<dt>収納</dt>
											<dd>
											<? if($RS_item[0]['flg_all_closet']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_all_closet" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_all_closet" value="1" <?= $checked ?> />全居室収納</label>
											<? if($RS_item[0]['flg_under_strage']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_under_strage" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_under_strage" value="1" <?= $checked ?> />床下収納</label>
											<? if($RS_item[0]['flg_walkin_closet']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_walkin_closet" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_walkin_closet" value="1" <?= $checked ?> />ウォークインクロゼット</label>
											<? if($RS_item[0]['flg_strage']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_strage" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_strage" value="1" <?= $checked ?> />納戸</label>
											<? if($RS_item[0]['flg_strage_loft']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_strage_loft" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_strage_loft" value="1" <?= $checked ?> />屋根裏収納</label>
											<? if($RS_item[0]['flg_trunkroom']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_trunkroom" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_trunkroom" value="1" <?= $checked ?> />トランクルーム</label>
											</dd>

											<dt>キッチン設備</dt>
											<dd>
											<? if($RS_item[0]['flg_builtin_kitchen']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_builtin_kitchen" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_builtin_kitchen" value="1" <?= $checked ?> />システムキッチン</label>
											<? if($RS_item[0]['flg_open_kitchen']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_open_kitchen" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_open_kitchen" value="1" <?= $checked ?> />対面式キッチン</label>
											<? if($RS_item[0]['flg_ih_heater']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_ih_heater" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_ih_heater" value="1" <?= $checked ?> />IHクッキングヒーター</label>
											<? if($RS_item[0]['flg_dishwasher']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_dishwasher" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_dishwasher" value="1" <?= $checked ?> />食器洗乾燥機</label>
											<? if($RS_item[0]['flg_water_purifier']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_water_purifier" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_water_purifier" value="1" <?= $checked ?> />浄水器</label>
											<? if($RS_item[0]['flg_disposer']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_disposer" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_disposer" value="1" <?= $checked ?> />ディスポーザー</label>
											</dd>

											<dt>浴室</dt>
											<dd>
											<? if($RS_item[0]['flg_bath_drier']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_bath_drier" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_bath_drier" value="1" <?= $checked ?> />浴室乾燥機</label>
<!--											<? if($RS_item[0]['flg_mist']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_mist" value="" />
											<label><input type="checkbox" name="flg_mist" value="1" <?= $checked ?> />ミストサウナ</label>-->
											<? if($RS_item[0]['flg_bath_1over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_bath_1over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_bath_1over" value="1" <?= $checked ?> />浴室1坪以上</label>
											<? if($RS_item[0]['flg_bath_auto']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_bath_auto" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_bath_auto" value="1" <?= $checked ?> />オートバス</label>
											<? if($RS_item[0]['flg_bath_tv']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_bath_tv" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_bath_tv" value="1" <?= $checked ?> />ＴＶ付浴室</label>
												<? if($RS_item[0]['flg_window']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_window" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_window" value="1" <?= $checked ?> />浴室に窓</label>
<!--											<? if($RS_item[0]['flg_jet_bath']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_jet_bath" value="" />
											<label><input type="checkbox" name="flg_jet_bath" value="1" <?= $checked ?> />ジェットバス</label>-->
											</dd>

											<dt>トイレ・洗面施設</dt>
											<dd>
											<? if($RS_item[0]['flg_shower_washstand']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_shower_washstand" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_shower_washstand" value="1" <?= $checked ?> />シャワー付洗面台</label>
											<? if($RS_item[0]['flg_wc_2over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_wc_2over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_wc_2over" value="1" <?= $checked ?> />トイレ2ヶ所</label>
											<? if($RS_item[0]['flg_washlet']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_washlet" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_washlet" value="1" <?= $checked ?> />温水洗浄便座</label>
<!--											<? if($RS_item[0]['flg_high_toilet']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_high_toilet" value="" />
											<label><input type="checkbox" name="flg_high_toilet" value="1" <?= $checked ?> />高機能トイレ</label>-->
											</dd>

											<dt>バルコニー・テラス</dt>
											<dd>
<!--											<? if($RS_item[0]['flg_balcony_wide']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_balcony_wide" value="" />
											<label><input type="checkbox" name="flg_balcony_wide" value="1" <?= $checked ?> />ワイドバルコニー</label>-->
											<? if($RS_item[0]['flg_balcony_2over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_balcony_2over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_balcony_2over" value="1" <?= $checked ?> />2面以上バルコニー</label>
											<? if($RS_item[0]['flg_balcony_south']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_balcony_south" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_balcony_south" value="1" <?= $checked ?> />南面バルコニー</label>
											<? if($RS_item[0]['flg_wooddeck']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_wooddeck" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_wooddeck" value="1" <?= $checked ?> />ウッドデッキ</label>
											<? if($RS_item[0]['flg_balcony_roof']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_balcony_roof" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_balcony_roof" value="1" <?= $checked ?> />ルーフバルコニー</label>
											<? if($RS_item[0]['flg_terrace']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_terrace" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_terrace" value="1" <?= $checked ?> />テラス</label>
											</dd>

											<dt>庭</dt>
											<dd>
<!--											<? if($RS_item[0]['flg_yard_10over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_yard_10over" value="" />
											<label><input type="checkbox" name="flg_yard_10over" value="1" <?= $checked ?> />庭10坪以上</label>-->
											<? if($RS_item[0]['flg_yard']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_yard" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_yard" value="1" <?= $checked ?> />庭</label>
<!--											<? if($RS_item[0]['flg_yard_south']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_yard_south" value="" />
											<label><input type="checkbox" name="flg_yard_south" value="1" <?= $checked ?> />南庭</label>-->
											<? if($RS_item[0]['flg_yard_own']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_yard_own" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_yard_own" value="1" <?= $checked ?> />専用庭</label>
											</dd>

											<dt>エコ関連</dt>
											<dd>
											<? if($RS_item[0]['flg_eco_point']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_eco_point" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_eco_point" value="1" <?= $checked ?> />エコポイント対象住宅</label>
<!--											<? if($RS_item[0]['flg_energy_saving']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_energy_saving" value="" />
											<label><input type="checkbox" name="flg_energy_saving" value="1" <?= $checked ?> />省エネルギー対策</label>-->
											<? if($RS_item[0]['flg_solar']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_solar" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_solar" value="1" <?= $checked ?> />太陽光発電システム</label>
<!--											<? if($RS_item[0]['flg_insulation']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_insulation" value="" />
											<label><input type="checkbox" name="flg_insulation" value="1" <?= $checked ?> />高気密高断熱住宅</label>-->
											<? if($RS_item[0]['flg_eco_heater']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_eco_heater" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_eco_heater" value="1" <?= $checked ?> />省エネ給湯器</label>
											<? if($RS_item[0]['flg_double_glass']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_double_glass" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_double_glass" value="1" <?= $checked ?> />複層ガラス</label>
											<? if($RS_item[0]['flg_all_electric']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_all_electric" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_all_electric" value="1" <?= $checked ?> />オール電化</label>
											</dd>

											<dt>テレビ・通信</dt>
											<dd>
											<? if($RS_item[0]['flg_flg_internet']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_internet" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_internet" value="1" <?= $checked ?> />高速ネット対応</label>
											<? if($RS_item[0]['flg_satellite_tv']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_satellite_tv" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_satellite_tv" value="1" <?= $checked ?> />BS・CS・CATV</label>
											</dd>

											<dt>駐車・駐輪</dt>
											<dd>
											<? if($RS_item[0]['flg_park']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_park" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_park" value="1" <?= $checked ?> />駐輪1台可</label>
											<? if($RS_item[0]['flg_park_1']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_park_1" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_park_1" value="1" <?= $checked ?> />駐車１台可</label>
											<? if($RS_item[0]['flg_park_2']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_park_2" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_park_2" value="1" <?= $checked ?> />駐車２台可</label>
											<? if($RS_item[0]['flg_park_3over']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_park_3over" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_park_3over" value="1" <?= $checked ?> />駐車３台以上可</label>
											<? if($RS_item[0]['flg_park_shutter']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_park_shutter" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_park_shutter" value="1" <?= $checked ?> />シャッター車庫</label>
											<? if($RS_item[0]['flg_park_build']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_park_build" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_park_build" value="1" <?= $checked ?> />ビルトガレージ</label>
											<? if($RS_item[0]['flg_park_flat']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_park_flat" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_park_flat" value="1" <?= $checked ?> />平面駐車場</label>
											</dd>

											<dt>共用部</dt>
											<dd>
<!--											<? if($RS_item[0]['flg_pool']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_pool" value="" />
											<label><input type="checkbox" name="flg_pool" value="1" <?= $checked ?> />プール</label>
											<? if($RS_item[0]['flg_share_bath']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_share_bath" value="" />
											<label><input type="checkbox" name="flg_share_bath" value="1" <?= $checked ?> />共用露天風呂</label>-->
											<? if($RS_item[0]['flg_share_facility']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_share_facility" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_share_facility" value="1" <?= $checked ?> />共有施設充実</label>
<!--											<? if($RS_item[0]['flg_garbage_24h']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_garbage_24h" value="" />
											<label><input type="checkbox" name="flg_garbage_24h" value="1" <?= $checked ?> />24時間ゴミ出し可</label>-->
											<? if($RS_item[0]['flg_elevator']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_elevator" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_elevator" value="1" <?= $checked ?> />エレベーター</label>
											<? if($RS_item[0]['flg_delivery_box']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_delivery_box" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_delivery_box" value="1" <?= $checked ?> />宅配ボックス</label>
											<? if($RS_item[0]['flg_kids_room']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_kids_room" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_kids_room" value="1" <?= $checked ?> />キッズルーム・託児所</label>
											</dd>

											<dt>管理・セキュリティー</dt>
											<dd>
											<? if($RS_item[0]['flg_security']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_security" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_security" value="1" <?= $checked ?> />セキュリティ充実</label>
											<? if($RS_item[0]['flg_tvinter']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_tvinter" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_tvinter" value="1" <?= $checked ?> />ＴＶモニタ付インターホン</label>
											<? if($RS_item[0]['flg_warden_24h']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_warden_24h" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_warden_24h" value="1" <?= $checked ?> />24時間有人管理</label>
											</dd>

											<dt>改装</dt>
											<dd>
											<? if($RS_item[0]['flg_renovation_fulfil']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_renovation_fulfil" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_renovation_fulfil" value="1" <?= $checked ?> />適合リノベーション</label>
											<? if($RS_item[0]['flg_reform_all']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_reform_all" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_reform_all" value="1" <?= $checked ?> />内外装リフォーム</label>
											<? if($RS_item[0]['flg_reform_in']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_reform_in" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_reform_in" value="1" <?= $checked ?> />内装リフォーム</label>
											<? if($RS_item[0]['flg_reform_out']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_reform_out" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_reform_out" value="1" <?= $checked ?> />外装リフォーム</label>
											<? if($RS_item[0]['flg_reform_flooring']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_reform_flooring" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_reform_flooring" value="1" <?= $checked ?> />フローリング張替</label>
<!--											<? if($RS_item[0]['flg_renovation']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_renovation" value="" />
											<label><input type="checkbox" name="flg_renovation" value="1" <?= $checked ?> />リノベーション</label>-->
											</dd>

											<dt>周辺施設</dt>
											<dd>
<!--											<? if($RS_item[0]['flg_near_golf']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_near_golf" value="" />
											<label><input type="checkbox" name="flg_near_golf" value="1" <?= $checked ?> />ゴルフ場が近い</label>
											<? if($RS_item[0]['flg_near_tennis']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_near_tennis" value="" />
											<label><input type="checkbox" name="flg_near_tennis" value="1" <?= $checked ?> />テニスコートが近い</label>-->
											<? if($RS_item[0]['flg_near_market']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_near_market" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_near_market" value="1" <?= $checked ?> />スーパーが近い</label>
											<? if($RS_item[0]['flg_light_traffic']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_light_traffic" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_light_traffic" value="1" <?= $checked ?> />周辺交通量少なめ</label>
<!--											<? if($RS_item[0]['flg_space_neighbor']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_space_neighbor" value="" />
											<label><input type="checkbox" name="flg_space_neighbor" value="1" <?= $checked ?> />隣家との間隔が大きい</label>-->
											<? if($RS_item[0]['flg_sidewalk']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_sidewalk" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_sidewalk" value="1" <?= $checked ?> />整備された歩道</label>
											</dd>

											<dt>眺望・自然環境</dt>
											<dd>
											<? if($RS_item[0]['flg_riverside']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_riverside" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_riverside" value="1" <?= $checked ?> />リバーサイド</label>
											<? if($RS_item[0]['flg_oceanview']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_oceanview" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_oceanview" value="1" <?= $checked ?> />オーシャンビュー</label>
<!--											<? if($RS_item[0]['flg_sight_lake']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_sight_lake" value="" />
											<label><input type="checkbox" name="flg_sight_lake" value="1" <?= $checked ?> />湖・池が見える</label>
											<? if($RS_item[0]['flg_sight_mountain']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_sight_mountain" value="" />
											<label><input type="checkbox" name="flg_sight_mountain" value="1" <?= $checked ?> />山が見える</label>
											<? if($RS_item[0]['flg_sea_2km']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_sea_2km" value="" />
											<label><input type="checkbox" name="flg_sea_2km" value="1" <?= $checked ?> />海まで2km以内</label>
											<? if($RS_item[0]['flg_sight_rural']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_sight_rural" value="" />
											<label><input type="checkbox" name="flg_sight_rural" value="1" <?= $checked ?> />田園風景</label>-->
											<? if($RS_item[0]['flg_prospect']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_prospect" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_prospect" value="1" <?= $checked ?> />眺望良好</label>
											<? if($RS_item[0]['flg_sight_fireworks']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_sight_fireworks" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_sight_fireworks" value="1" <?= $checked ?> />花火大会鑑賞</label>
											</dd>

											<dt>費用・引渡し・入居条件</dt>
											<dd>
											<? if($RS_item[0]['flg_flat35s']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_flat35s" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_flat35s" value="1" <?= $checked ?> />フラット35Sに対応</label>
											<? if($RS_item[0]['flg_within_year']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_within_year" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_within_year" value="1" <?= $checked ?> />年内入居可</label>
											<? if($RS_item[0]['flg_immediate']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_immediate" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_immediate" value="1" <?= $checked ?> />即入居可</label>
<!--											<? if($RS_item[0]['flg_within_bizyear']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_within_bizyear" value="" />
											<label><input type="checkbox" name="flg_within_bizyear" value="1" <?= $checked ?> />年度内入居可</label>-->
											<? if($RS_item[0]['flg_pet']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_pet" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_pet" value="1" <?= $checked ?> />ペット相談</label>
											</dd>

											<dt>その他</dt>
											<dd>
<!--											<? if($RS_item[0]['flg_spa']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_spa" value="" />
											<label><input type="checkbox" name="flg_spa" value="1" <?= $checked ?> />温泉付</label>
											<? if($RS_item[0]['flg_vegetable_garden']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_vegetable_garden" value="" />
											<label><input type="checkbox" name="flg_vegetable_garden" value="1" <?= $checked ?> />家庭菜園</label>-->
											<? if($RS_item[0]['flg_change_owner']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_change_owner" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_change_owner" value="1" <?= $checked ?> />オーナーチェンジ</label>
											<? if($RS_item[0]['flg_urban_gas']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_urban_gas" value="" />
											<label class="fsRed_icon"><input type="checkbox" name="flg_urban_gas" value="1" <?= $checked ?> />都市ガス</label>
<!--											<? if($RS_item[0]['flg_rooftop']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_rooftop" value="" />
											<label><input type="checkbox" name="flg_rooftop" value="1" <?= $checked ?> />屋上</label>
											<? if($RS_item[0]['flg_eable_spa']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_eable_spa" value="" />
											<label><input type="checkbox" name="flg_eable_spa" value="1" <?= $checked ?> />温泉引き込み可</label>
											<? if($RS_item[0]['flg_loghouse']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_loghouse" value="" />
											<label><input type="checkbox" name="flg_loghouse" value="1" <?= $checked ?> />ログハウス</label>
											<? if($RS_item[0]['flg_field']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_field" value="" />
											<label><input type="checkbox" name="flg_field" value="1" <?= $checked ?> />畑</label>
											<? if($RS_item[0]['flg_vintage']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_vintage" value="" />
											<label><input type="checkbox" name="flg_vintage" value="1" <?= $checked ?> />古民家風</label>
											<? if($RS_item[0]['flg_skeleton']){ $checked="checked"; }else{ $checked=""; } ?>
											<input type="hidden" name="flg_skeleton" value="" />
											<label><input type="checkbox" name="flg_skeleton" value="1" <?= $checked ?> />スケルトン渡し</label>-->
											</dd>
										</dl>
									</td>
								</tr>
								<tr>
									<th>Youtube URL</th>
									<td><input name="item_youtube" type="url" style="width:500px;" value="<?= $RS_item[0]['item_youtube'] ?>" /></td>
								</tr>
								<tr>
									<th>ファクトシート</th>
									<td class="js_flame">
										<div id="file-input_fact" class="dragbox mainimg js_box">
											<div class="js_img">
												<? if(file_exists_expression($G_up_path."/item/".sprintf("%03d", $RS_item[0]['item_cd']), "fact\..+")): ?>
													<? $exist_fact = "1"; $class_fact = "del_on"; ?>
												<? endif; ?>
											</div>
											<div class="js_drop"></div>
										</div>
										<input class="js_input" type="file">
										<input type="button" value="" class="file_btn fleft js_choose" />
										<input type="button" value="" class="del_btn js_delete_contents <?= $class_fact ?>" />
										<input type="hidden" class="js_uri" name="uri_fact" value="" />
										<input type="hidden" class="js_type" name="type_fact" value="" />
										<input type="hidden" class="js_exist" name="exist_fact" value="<?= $exist_fact ?>" />
									</td>
								</tr>
								<tr>
									<th>トップ画像</th>
									<td class="js_flame">
										<div id="file-input_top" class="dragbox topimg js_box">
											<div class="js_img">
												<? if(file_exists_expression($G_up_path."/item/".sprintf("%03d", $RS_item[0]['item_cd']), "top\..+")): ?>
													<?= make_img($G_up_dir."/item/".sprintf("%03d", $RS_item[0]['item_cd'])."/top.*", "", "", "", "") ?>
													<? $exist_top = "1"; $class_top = "del_on"; ?>
												<? endif; ?>
											</div>
											<div class="js_drop"></div>
										</div>
										<input class="js_input" type="file">
										<input type="button" value="" class="file_btn fleft js_choose" />
										<input type="button" value="" class="del_btn js_delete_contents <?= $class_top ?>" />
										<input type="hidden" class="js_uri" name="uri_top" value="" />
										<input type="hidden" class="js_type" name="type_top" value="" />
										<input type="hidden" class="js_exist" name="exist_top" value="<?= $exist_top ?>" />
									</td>
								</tr>
								<tr>
									<th>メイン画像</th>
									<td class="js_flame">
										<div id="file-input_main" class="dragbox mainimg js_box">
											<div class="js_img">
												<? if(file_exists_expression($G_up_path."/item/".sprintf("%03d", $RS_item[0]['item_cd']), "main\..+")): ?>
													<?= make_img($G_up_dir."/item/".sprintf("%03d", $RS_item[0]['item_cd'])."/main.*", "", "", "", "") ?>
													<? $exist_main = "1"; $class_main = "del_on"; ?>
												<? endif; ?>
											</div>
											<div class="js_drop"></div>
										</div>
										<input class="js_input" type="file">
										<input type="button" value="" class="file_btn fleft js_choose" />
										<input type="button" value="" class="del_btn js_delete_contents <?= $class_main ?>" />
										<input type="hidden" class="js_uri" name="uri_main" value="" />
										<input type="hidden" class="js_type" name="type_main" value="" />
										<input type="hidden" class="js_exist" name="exist_main" value="<?= $exist_main ?>" />
									</td>
								</tr>
								<tr>
									<th>詳細画像</th>
									<td>
										<ul class="imglist js_ul js_sortable">
											<? for ($i = 0; $i < count($RS_item_detail); $i++) : ?>
												<li class="js_flame js_colum">
													<div id="file-input_detail1" class="dragbox detailimg js_box">
														<div class="js_img div1077">
															<?= make_img($G_up_dir."/item/".sprintf("%03d", $RS_item[0]['item_cd'])."/detail/".sprintf("%02d", $RS_item_detail[$i]['img_detail_number'])."_s.*", "", "", "", "") ?>
														</div>
														<div class="js_drop" style="width: 116px; height: 116px; position: absolute; top: -3px; left: -3px;"></div>
													</div>
													<a class="move js_sort">ファイル移動</a>
													<input class="js_input" type="file">
													<input type="button" value="" class="file_btn fleft js_choose" />
													<input type="button" value="" class="del_btn js_delete_flame del_on" />
													<input type="text" name="title_detail[]" class="file_title js_title" value="<?= $RS_item_detail[$i]['img_detail_title'] ?>" placeholder="画像タイトル" />
													<input type="hidden" class="js_uri" name="uri_detail[]" value="" />
													<input type="hidden" class="js_type" name="type_detail[]" value="" />
													<input type="hidden" class="js_num" name="num_detail[]" value="<?= $RS_item_detail[$i]['img_detail_number'] ?>" />
												</li>
											<? endfor; ?>
											<li class="js_flame">
												<div id="file-input_detail1" class="dragbox detailimg js_box">
													<div class="js_img div1077"></div>
													<div class="js_drop"></div>
												</div>
												<a class="move js_sort">ファイル移動</a>
												<input class="js_input" type="file">
												<input type="button" value="" class="file_btn fleft js_choose" />
												<input type="button" value="" class="del_btn js_delete_flame" />
												<input type="text" name="title_detail[]" class="file_title js_title" placeholder="画像タイトル" />
												<input type="hidden" class="js_uri" name="uri_detail[]" value="" />
												<input type="hidden" class="js_type" name="type_detail[]" value="" />
												<input type="hidden" class="js_num" name="num_detail[]" value="" />
											</li>
										</ul>
									</td>
								</tr>
								<tr>
									<th>間取図</th>
									<td class="js_flame">
										<div id="file-input_main" class="dragbox mainimg js_box">
											<div class="js_img">
												<? if(file_exists_expression($G_up_path."/item/".sprintf("%03d", $RS_item[0]['item_cd']), "plan1\..+")): ?>
													<?= make_img($G_up_dir."/item/".sprintf("%03d", $RS_item[0]['item_cd'])."/plan1.*", "", "", "", "") ?>
													<? $exist_plan1 = "1"; $class_plan1 = "del_on"; ?>
												<? endif; ?>
											</div>
											<div class="js_drop"></div>
										</div>
										<input class="js_input" type="file">
										<input type="button" value="" class="file_btn fleft js_choose" />
										<input type="button" value="" class="del_btn js_delete_contents <?= $class_plan1 ?>" /><br />
										<input type="hidden" class="js_uri" name="uri_plan1" value="" />
										<input type="hidden" class="js_type" name="type_plan1" value="" />
										<input type="hidden" class="js_exist" name="exist_plan1" value="<?= $exist_plan1 ?>" />
									</td>
								</tr>
								<tr>
									<th>配置図</th>
									<td class="js_flame">
										<div id="file-input_main" class="dragbox mainimg js_box">
											<div class="js_img">
												<? if(file_exists_expression($G_up_path."/item/".sprintf("%03d", $RS_item[0]['item_cd']), "plan2\..+")): ?>
													<?= make_img($G_up_dir."/item/".sprintf("%03d", $RS_item[0]['item_cd'])."/plan2.*", "", "", "", "") ?>
													<? $exist_plan2 = "1"; $class_plan2 = "del_on"; ?>
												<? endif; ?>
											</div>
											<div class="js_drop"></div>
										</div>
										<input class="js_input" type="file">
										<input type="button" value="" class="file_btn fleft js_choose" />
										<input type="button" value="" class="del_btn js_delete_contents <?= $class_plan2 ?>" /><br />
										<input type="hidden" class="js_uri" name="uri_plan2" value="" />
										<input type="hidden" class="js_type" name="type_plan2" value="" />
										<input type="hidden" class="js_exist" name="exist_plan2" value="<?= $exist_plan2 ?>" />
									</td>
								</tr>
								<tr>
									<th>周辺環境</th>
									<td>
										<ul class="imglist neighbor js_ul js_sortable">
											<? for ($i = 0; $i < count($RS_item_around); $i++) : ?>
												<li class="js_flame js_colum">
													<div id="file-input_neighbor1" class="dragbox neighborimg js_box">
														<div class="js_img">
															<?= make_img($G_up_dir."/item/".sprintf("%03d", $RS_item[0]['item_cd'])."/around/".sprintf("%02d", $RS_item_around[$i]['img_around_number'])."_s.*", "", "", "", "") ?>
														</div>
														<div class="js_drop"></div>
													</div>
													<a class="move js_sort">ファイル移動</a>
													<input class="js_input" type="file">
													<input type="button" value="" class="file_btn fleft js_choose" />
													<input type="button" value="" class="del_btn js_delete_flame del_on" />
													<input type="text" name="title_around[]" class="file_title js_title" value="<?= $RS_item_around[$i]['img_around_title'] ?>" placeholder="画像タイトル" />
													<textarea name="cmt_around[]" rows="3" placeholder="詳細入力"><?= $RS_item_around[$i]['img_around_cmt'] ?></textarea>
													<input type="hidden" class="js_uri" name="uri_around[]" value="" />
													<input type="hidden" class="js_type" name="type_around[]" value="" />
													<input type="hidden" class="js_num" name="num_around[]" value="<?= $RS_item_around[$i]['img_around_number'] ?>" />
												</li>
											<? endfor; ?>
											<li class="js_flame">
												<div id="file-input_neighbor1" class="dragbox neighborimg js_box">
													<div class="js_img"></div>
													<div class="js_drop"></div>
												</div>
												<a class="move js_sort">ファイル移動</a>
												<input class="js_input" type="file">
												<input type="button" value="" class="file_btn fleft js_choose" />
												<input type="button" value="" class="del_btn js_delete_flame" />
												<input type="text" name="title_around[]" class="file_title js_title" placeholder="画像タイトル" />
												<textarea name="cmt_around[]" rows="3" placeholder="詳細入力"></textarea>
												<input type="hidden" class="js_uri" name="uri_around[]" value="" />
												<input type="hidden" class="js_type" name="type_around[]" value="" />
												<input type="hidden" class="js_num" name="num_around[]" value="" />
											</li>
										</ul>
									</td>
								</tr>
								<tr>
									<th>地図</th>
									<td>
										<input type="text" id="js_word" value="" />
										<input type="button" id="js_search" value="検索" />
										<input type="button" id="js_search_item" value="物件所在地で検索" />
										<div style=" position: relative;">
											<div id="js_map" style="width:600px; height:328px;"></div>
											<img id="js_marker" style="position: absolute; top: 143px; left: 279px;" src="<?= $G_img_dir ?>/common/target.png" />
										</div>
										緯度：<input type="text" id="js_lat" name="item_lat" value="<?= $RS_item[0]['item_lat'] ?>" /> 
										経度：<input type="test" id="js_lng" name="item_lng" value="<?= $RS_item[0]['item_lng'] ?>" /> 
										<input type="hidden" id="js_zoom" name="item_zoom" value="<?= $RS_item[0]['item_zoom'] ?>" /> 
									</td>
								</tr>
							</tbody>
						</table>
						<div style="height: 50px;">
							<input type="hidden" name="prev_city_cd" value="<?= $F_city_cd ?>" />
							<input type="hidden" name="item_cd" value="<?= $RS_item[0]['item_cd'] ?>" />
							<input type="submit" name="regist" value="登録" class="formbtn" />
						</div>
					</fieldset>
				</form>
				
			</div>
