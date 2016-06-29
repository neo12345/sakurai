			<h1>会員管理</h1>
			
			<ul>
				<li class="menu2"><a href="/member/?md=list" title="会員一覧">会員一覧</a></li>
				<li class="menu2 menu_selected"><a href="/member/?md=regist" title="会員一覧">会員登録</a></li>
				<li class="menu2"><a href="/member/?md=mail" title="メール">メール</a></li>
			</ul>
			
			<div>
				<form method="post" action="/member/" class="js_unsubmit">
					<fieldset>
						<table>
							<tbody>
								<tr>
									<th>お名前</th>
									<td><input type="text" name="mem_name" value="<?= $RS_mem[0]['mem_name'] ?>" required /></td>
								</tr>
								<tr>
									<th>ふりがな</th>
									<td><input type="text" name="mem_kana" value="<?= $RS_mem[0]['mem_kana'] ?>" /></td>
								</tr>
								<tr>
									<th>メールアドレス</th>
									<td><input type="email" name="mem_mail" value="<?= $RS_mem[0]['mem_mail'] ?>" required /></td>
								</tr>
								<tr>
									<th>住所</th>
									<td>
										<label>〒</label><input name="mem_zip" type="text" value="<?= $RS_mem[0]['mem_zip'] ?>" placeholder="812-0874" /><br />
										<? shot_select("pref_cd", $RS_mem[0]['pref_cd'], "", $RS_pref, "pref_cd", "pref_name", "", "") ?>
										<input type="text" name="mem_addr1" value="<?= $RS_mem[0]['mem_addr1'] ?>" placeholder="福岡市博多区光丘町1丁目1-36" />
										<input type="text" name="mem_addr2" value="<?= $RS_mem[0]['mem_addr2'] ?>" placeholder="スマイルビル 101号室" />
									</td>
								</tr>
								<tr>
									<th>電話番号</th>
									<td><input type="text" name="mem_tel" value="<?= $RS_mem[0]['mem_tel'] ?>" placeholder="092-288-8447" /></td>
								</tr>
								<? if(!$RS_mem[0]['mem_pw']): ?>
									<tr>
										<th>パスワード</th>
										<td><input type="password" name="mem_pw" value="" placeholder="半角英数字8～12文字" required /></td>
									</tr>
								<? endif; ?>
							</tbody>
						</table>
						<? if($F_edit): ?>
							<input type="hidden" name="mem_cd" value="<?= $RS_mem[0]['mem_cd'] ?>" />
						<? endif; ?>
						<input type="submit" name="regist" value="登録" class="formbtn" />
					</fieldset>
				</form>				
			</div>
