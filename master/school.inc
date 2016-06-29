			<h1>マスタ管理</h1>
			
			<ul>
				<li class="menu2 menu_selected"><a href="/master/?md=school" title="学校">学校</a></li>
				<li class="menu2"><a href="/master/?md=stop" title="駅">駅</a></li>
				<li class="menu2"><a href="/master/?md=city" title="都市">都市</a></li>
				<li class="menu2"><a href="/master/?md=seller" title="売主">売主</a></li>
				<li class="menu2"><a href="/master/?md=seller_office" title="売主">売主営業所</a></li>
			</ul>
			
			<div>
				<div id="js_frame">
					<? shot_select("school_cd", $F_school_cd, "", $RS_school, "school_cd", "school_name", "id=\"js_school_cd\"", "") ?>
					<table>
						<thead>
							<tr>
								<th>学校コード</th>
								<th>学校名</th>
								<th>カテゴリ</th>
								<th>アクティブ</th>
								<th>画像</th>
								<th>編集</th>
							</tr>
						</thead>
						<tbody id="js_list">
						</tbody>
					</table>
				</div>
				
				<div class="controldialog js_dialog_frame" rel="view">
					<image id="js_school_view" src="<?= $G_img_dir ?>/common/icon_loading.gif" style="width: 800px; height: 600px;" />
					<input type="hidden" id ="js_dir" value="<?= $G_up_dir ?>/school" />
					<input type="button" class="ico_close js_dialog_close" rel="view" title="閉じる" value="閉" />
				</div>
				
			</div>
