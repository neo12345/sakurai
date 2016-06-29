
  <div class="right">
    <h2 class="PageTitle page01">物件管理</h2>
    <div class="tab_wrap clear">
      <ul class="tab">
        <li class="tab_on"><a href="/item/?md=list" title="物件一覧">物件一覧</a></li>
        <li class="tab_off"><a href="/item/?md=regist" title="物件登録">物件登録</a></li>
        <li class="tab_off"><a href="/item/?md=analysis" title="集計・解析">集計・解析</a></li>
      </ul>
    </div>
    <div class="cnt_wrap">
      <div class="cnt_title clear w260">
        <h3>物件一覧</h3>
<!--        <input type="button" value="追加" id="js_add" class="btn_add btn_style_01" />-->
      </div>
			<form method="post" action="/item/?md=regist">
				<? shot_select("city_cd", $F_city_cd, "", $RS_city, "city_cd", "city_name", "id=\"js_city_cd\"", "全てのエリア"); ?>
				<? shot_select("seller_cd", $F_seller_cd, "", $RS_seller, "seller_cd", "seller_name", "id=\"js_seller_cd\"", "-----"); ?>
				<table class="table_style">
					<thead>
						<tr>
							<td>No.</td>
							<td>物件名</td>
							<td>売主</td>
							<td>住所</td>
							<td>価格</td>
							<th>水面下</th>
							<td class="btn_tbl_with">状態</td>
							<td class="btn_tbl_with">編集</td>
							<td class="btn_tbl_with">削除</td>
						</tr>
					</thead>
					<tbody id="js_list">
						<? for ($i = 0; $i < count($RS_item); $i++) : ?>
							<? if($RS_item[$i]['flg_soldout']){ $color="silver"; $status="成"; }elseif($RS_item[$i]['flg_nego']){ $color="pink"; $status="商"; }else{ $color="white"; $status="販"; } ?>
							<tr class="js_colum" style="background-color: <?= $color ?>;">
								<td class="no"><?= $RS_item[$i]['item_cd'] ?><input type="hidden" class="js_item_cd" value="<?= $RS_item[$i]['item_cd'] ?>" /></td>
								<td>
									<? if($RS_item[$i]['flg_active']): ?>
										<a href="http://www.sh-smilenavi.com/item/?md=detail&cd=<?= $RS_item[$i]['item_cd'] ?>&qwert=1" target="_blank">
											<?= $RS_item[$i]['item_name'] ?><? if($RS_item[$i]['item_name_sub']): ?>（<?= $RS_item[$i]['item_name_sub'] ?>）<? endif; ?>
										</a>
									<? else: ?>
										<?= $RS_item[$i]['item_name'] ?><? if($RS_item[$i]['item_name_sub']): ?>（<?= $RS_item[$i]['item_name_sub'] ?>）<? endif; ?>
									<? endif; ?>
									<input type="hidden" class="js_item_name" value="<?= $RS_item[$i]['item_name'] ?>" />
									<? get_rs("r_item10", "chase", "item_cd='".$RS_item[$i]['item_cd']."'", "rel_cd asc"); ?>
									<? for ($j = 0; $j < count($RS_chase); $j++) : ?>
										<img src="<?= $G_img_dir ?>/common/ico_user_<?= sprintf("%02d", $RS_chase[$j]['user_cd']) ?>.png" />
									<? endfor; ?>
								</td>
								<td><?= $RS_item[$i]['seller_name'] ?></td>
								<td><?= $RS_item[$i]['pref_name'] ?><?= $RS_item[$i]['city_name'] ?><?= $RS_item[$i]['item_addr2'] ?><?= $RS_item[$i]['item_addr3'] ?></td>
								<td class="tar">
									<span class="js_item_price" style="cursor: pointer;"><?= number_format($RS_item[$i]['item_price']) ?>万円</span>
									<div class="js_price_frame dn">
										<input class="js_value" style="width: 35px;" type="text" value="<?= $RS_item[$i]['item_price'] ?>" />
										<span class="js_regist fsSx curp">登録</span>
									</div>
								</td>
								<td class="tar">
									<? if($RS_item[$i]['item_price_under']): ?>
										<?= number_format($RS_item[$i]['item_price_under']) ?>万円
									<? else: ?>
										----万円
									<? endif; ?>
								</td>
								<td><input class="js_status" style="width: 20px;" type="button" value="<?=  $status ?>" /></td>
								<td class="edit"><input type="submit" name="edit[<?= $RS_item[$i]['item_cd'] ?>]" value="編集" class="btn_edit btn_style_02" /></td>
								<td class="del"><input type="button" value="削除" class="js_delete btn_delete btn_style_02" /></td>
							</tr>
						<? endfor; ?>
					</tbody>
				</table>
			</form>
    </div>
  </div>