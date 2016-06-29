			<h1>コンテンツ管理</h1>
			
			<ul>
<!--				<li class="menu2"><a href="/contents/?md=list" title="表示">表示</a></li>-->
				<li class="menu2"><a href="/contents/?md=select" title="スマイルセレクト">ｽﾏｲﾙｾﾚｸﾄ</a></li>
				<li class="menu2 menu_selected"><a href="/contents/?md=youtube" title="YouTube">YouTube</a></li>
				<li class="menu2"><a href="/contents/?md=info" title="更新情報">更新情報</a></li>
				<li class="menu2"><a href="/contents/?md=blog" title="ブログ案内">ブログ案内</a></li>
<!--				<li class="menu2"><a href="/contents/?md=review" title="お客様の声">お客様の声</a></li>-->
			</ul>
			
			<div>
			
				<form class="js_sort_form">
					<fieldset>
						<table>
							<thead>
								<tr>
									<th>連番</th>
									<th>物件コード</th>
									<th>物件名</th>
									<th>並替</th>
								</tr>
							</thead>
							<tbody class="js_sortable">
								<? for ($i = 0; $i < count($RS_yout); $i++) : ?>
									<tr class="js_colum">
										<td>
											<?= $i+1 ?>
											<input type="hidden" name="yout_sort[]" value="<?= $RS_yout[$i]['yout_sort'] ?>" />
											<input class="js_yout_cd" type="hidden" name="yout_cd[]" value="<?= $RS_yout[$i]['yout_cd'] ?>" />
										</td>
										<td>
											<span class="js_item_cd" style="cursor: pointer;"><?= $RS_yout[$i]['item_cd'] ?></span>
											<div class="js_cd_frame dn">
												<input class="js_value" style="width: 25px; height: 13px;" type="text" name="item_cd[]" value="<?= $RS_yout[$i]['item_cd'] ?>" />
												<span class="js_regist fsSx curp">登録</span>
											</div>
										</td>
										<td class="js_item_name"><a href="http://www.sh-smilenavi.com/item/?md=detail&cd=<?= $RS_yout[$i]['item_cd'] ?>" target="blank"><?= $RS_yout[$i]['item_name'] ?></a></td>
										<td><div class="js_sort" style="cursor: move;">並替</div></td>
									</tr> 
								<? endfor; ?>
							</tbody>
						</table>
					</fieldset>
					<input type="hidden" id="js_file_path" value="/contents/youtube.php" />
				</form>
				
			</div>
