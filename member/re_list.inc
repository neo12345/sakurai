  <div class="right">
    <h2 class="PageTitle page02">会員管理</h2>
    <div class="tab_wrap clear">
      <ul class="tab">
				<li class="tab_on"><a href="/member/?md=list" title="会員一覧">会員一覧</a></li>
				<li class="tab_off"><a href="/member/?md=regist" title="会員一覧">会員登録</a></li>
				<li class="tab_off"><a href="/member/?md=mail" title="メール">メール</a></li>
      </ul>
    </div>
    <div class="cnt_wrap">
      <div class="cnt_title clear w260">
        <h3>会員一覧</h3>
      </div>
			<form method="post" action="/member/?md=regist">
				<table class="table_style">
					<thead>
						<tr>
							<th>会員コード</th>
							<th>会員名</th>
							<th>メールアドレス</th>
							<th>住所</th>
							<th>登録日時</th>
							<th>編集</th>
							<th>削除</th>
						</tr>
					</thead>
					<tbody id="js_list">
					<? for($i=0; $i<count($RS_mem); $i++) : ?>
						<tr class="js_colum">
							<td><?= $RS_mem[$i]['mem_cd'] ?><input type="hidden" class="js_mem_cd" value="<?= $RS_mem[$i]['mem_cd'] ?>" /></td>
							<td><?= $RS_mem[$i]['mem_name'] ?><input type="hidden" class="js_mem_name" value="<?= $RS_mem[$i]['mem_name'] ?>" /></td>
							<td><?= $RS_mem[$i]['mem_mail'] ?></td>
							<td><?= $RS_mem[$i]['mem_addr1'].$RS_mem[$i]['mem_addr2'].$RS_mem[$i]['mem_addr3'] ?></td>
							<td><?= pic_object_date("Y年m月d日 H:i:s", $RS_mem[$i]['date_regist']) ?></td>
							<td class="edit"><input type="submit" name="edit[<?= $RS_mem[$i]['mem_cd'] ?>]" value="編集" /></td>
							<td class="del"><p class="js_delete">削除</p></td>
						</tr>
					<? endfor; ?>
					</tbody>
				</table>
			</form>
    </div>
  </div>
