			<h1>物件管理</h1>
			
			<ul>
				<li class="menu2"><a href="/item/?md=list" title="物件一覧">物件一覧</a></li>
				<li class="menu2"><a href="/item/?md=regist" title="物件登録">物件登録</a></li>
				<li class="menu2 menu_selected"><a href="/item/?md=analysis" title="集計・解析">集計・解析</a></li>
			</ul>
			
			<div>
				<? shot_select("city_cd", $F_city_cd, "", $RS_city, "city_cd", "city_name", "id=\"js_city_cd\"", "全てのエリア"); ?>
				<table>
					<tr>
						<th></th>
						<th>登録中</th>
						<th>販売中</th>
						<th>商談中</th>
						<th>成約済(掲載)</th>
						<th>成約済(非掲載)</th>
					</tr>
					<tr class="tar">
						<td>戸建(新築)</td>
						<td><?= number_format($colum_regist[]=count($RS_item_cat1_new_regist)) ?>件</td>
						<td><?= number_format($colum_sell[]=count($RS_item_cat1_new_sell)) ?>件</td>
						<td><?= number_format($colum_nego[]=count($RS_item_cat1_new_nego)) ?>件</td>
						<td><?= number_format($colum_soldout_open[]=count($RS_item_cat1_new_soldout_open)) ?>件</td>
						<td><?= number_format($colum_soldout_close[]=count($RS_item_cat1_new_soldout_close)) ?>件</td>
					</tr>
					<tr class="tar">
						<td>戸建(中古)</td>
						<td><?= number_format($colum_regist[]=count($RS_item_cat1_used_regist)) ?>件</td>
						<td><?= number_format($colum_sell[]=count($RS_item_cat1_used_sell)) ?>件</td>
						<td><?= number_format($colum_nego[]=count($RS_item_cat1_used_nego)) ?>件</td>
						<td><?= number_format($colum_soldout_open[]=count($RS_item_cat1_used_soldout_open)) ?>件</td>
						<td><?= number_format($colum_soldout_close[]=count($RS_item_cat1_used_soldout_close)) ?>件</td>
					</tr>
					<tr class="tar">
						<td>マンション</td>
						<td><?= number_format($colum_regist[]=count($RS_item_cat2_regist)) ?>件</td>
						<td><?= number_format($colum_sell[]=count($RS_item_cat2_sell)) ?>件</td>
						<td><?= number_format($colum_nego[]=count($RS_item_cat2_nego)) ?>件</td>
						<td><?= number_format($colum_soldout_open[]=count($RS_item_cat2_soldout_open)) ?>件</td>
						<td><?= number_format($colum_soldout_close[]=count($RS_item_cat2_soldout_close)) ?>件</td>
					</tr>
					<tr class="fsB tar">
						<td>合計</td>
						<td><?= number_format(array_sum($colum_regist)) ?>件</td>
						<td><?= number_format(array_sum($colum_sell)) ?>件</td>
						<td><?= number_format(array_sum($colum_nego)) ?>件</td>
						<td><?= number_format(array_sum($colum_soldout_open)) ?>件</td>
						<td><?= number_format(array_sum($colum_soldout_close)) ?>件</td>
					</tr>
				</table>
			</div>
