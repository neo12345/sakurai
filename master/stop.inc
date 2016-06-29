			<h1>マスタ管理</h1>
			
			<ul>
				<li class="menu2"><a href="/master/?md=school" title="学校">学校</a></li>
				<li class="menu2 menu_selected"><a href="/master/?md=stop" title="駅">駅</a></li>
				<li class="menu2"><a href="/master/?md=city" title="都市">都市</a></li>
				<li class="menu2"><a href="/master/?md=seller" title="売主">売主</a></li>
				<li class="menu2"><a href="/master/?md=seller_office" title="売主">売主営業所</a></li>
			</ul>
			
			<div>
				<div id="js_frame">
					<? shot_select("pubtrans_cd", $F_pubtrans_cd, "", $RS_pubtrans, "pubtrans_cd", "pubtrans_name", "id=\"js_pubtrans_cd\"", "") ?>
					<div id="js_frame_regist" class="">
						<table>
							<tr>
								<th>駅名</th>
								<td><input type="text" id="js_stop_name" /><input type="button" id="js_regist_stop" value="登録" /></td>
							</tr>
						</table>
					</div>
					<table>
						<thead>
							<tr>
								<th>駅コード</th>
								<th>駅名</th>
								<th>画像</th>
								<th>編集</th>
								<th>削除</th>
							</tr>
						</thead>
						<tbody id="js_list">
						</tbody>
					</table>
				</div>
				
				<div class="controldialog js_dialog_frame" rel="view">
					<image id="js_stop_view" src="<?= $G_img_dir ?>/common/icon_loading.gif" style="width: 800px; height: 600px;" />
					<input type="hidden" id ="js_dir" value="<?= $G_up_dir ?>/stop" />
					<input type="button" class="ico_close js_dialog_close" rel="view" title="閉じる" value="閉" />
				</div>
			</div>
