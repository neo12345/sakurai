<div class="overlay">
	<img id="img_loading" src="/_img/common/loading.gif"/>
</div>


<div class="right">
    <h2 class="PageTitle page01">物件管理</h2>
    <div class="tab_wrap clear">
      <ul class="tab">
        <li class="tab_off"><a href="/item/?md=list" title="物件一覧">物件一覧</a></li>
        <li class="tab_off"><a href="/item/?md=regist" title="物件登録">物件登録</a></li>
        <li class="tab_on"><a href="/item/?md=analysis" title="集計・解析">集計・解析</a></li>
        <li class="tab_off"><a>解析(物件)</a></li>

      </ul>
    </div>
    <div class="cnt_wrap">
        <div class="cnt_title clear w260"><h3>集計･解析</h3></div>
        <div class="tabl-analysis">
            <h4 class="mtit">地域</h4>
            <h5 class="stit">福岡市</h5>
			<table class="form-analysis lst-check">
				<tr>
				<?php 
					$count = 0;
					for($i = 0; $i < count($RS_city) ; $i++) {	
						if($RS_city[$i]['cat_city_name'] == '福岡市') {			
							if($count % 8 == 0 && $count != 0) {
								echo '</tr><tr>';
							}
							$count++;
							echo '<td class="checkbox"><input type="checkbox" value="'; 
							echo $RS_city[$i]['city_cd'] . '" name="city[]"></td><td class="analysis-name">';
							echo $RS_city[$i]['city_name'];
							echo '('. $RS_city[$i]['count_item'] .')';
							echo '</td>';
						}
					}
				?>
				</tr>
			</table>
			
            <h5 class="stit">福岡近郊</h5>
			<table class="form-analysis lst-check">
				<tr>
				<?php 
					$count = 0;
					for($i = 0; $i < count($RS_city) ; $i++) {	
						if($RS_city[$i]['cat_city_name'] == '福岡近郊') {			
							if($count % 8 == 0 && $count != 0) {
								echo '</tr><tr>';
							}
							$count++;
							echo '<td class="checkbox"><input type="checkbox" value="'; 
							echo $RS_city[$i]['city_cd'] . '" name="city[]"></td><td class="analysis-name">';
							echo $RS_city[$i]['city_name'];
							echo '('. $RS_city[$i]['count_item'] .')';
							echo '</td>';
						}
					}
				?>
				</tr>
			</table>
            
            <h5 class="stit">その他</h5>
			<table class="form-analysis lst-check">
				<tr>
				<?php 
					$count = 0;
					for($i = 0; $i < count($RS_city) ; $i++) {	
						if($RS_city[$i]['cat_city_name'] == 'その他') {			
							if($count % 8 == 0 && $count != 0) {
								echo '</tr><tr>';
							}
							$count++;
							echo '<td class="checkbox"><input type="checkbox" value="'; 
							echo $RS_city[$i]['city_cd'] . '" name="city[]"></td><td class="analysis-name">';
							echo $RS_city[$i]['city_name'];
							echo '('. $RS_city[$i]['count_item'] .')';
							echo '</td>';
						}
					}
				?>
				</tr>
			</table>
            
            <div class="clear02">
            	<div class="check-left">
                	<h4 class="mtit">種類</h4>
                    <ul class="lst-check">
						<?php 
							$count = 0;
							for($i = 0; $i < count($RS_cat_item) ; $i++) {				
								if($count % 8 == 0 && $count != 0) {
									echo '</ul><ul class="lst-check">';
								}
								$count++;
								echo '<li>';
								echo '<label class="checkbox"><input type="checkbox" value="'; 
								echo $RS_cat_item[$i]['cat_item_cd'] . '" name="cat_item[]"></label><label class="analysis-name">';
								echo $RS_cat_item[$i]['cat_item_name'];
								echo '</label></li>';
							}
						?>
                    </ul>
                </div>
                <div class="check-right">
                	<h4 class="mtit">状態</h4>
					<ul class="lst-check">
						<?php 
							$count = 0;
							for($i = 0; $i < count($RS_condition) ; $i++) {				
								if($count % 8 == 0 && $count != 0) {
									echo '</ul><ul class="lst-check">';
								}
								$count++;
								echo '<li>';
								echo '<label class="checkbox"><input type="checkbox" value="'; 
								echo $RS_condition[$i]['condition_cd'] . '" name="condition[]"></label><label class="analysis-name">';
								echo $RS_condition[$i]['condition_name'];
								echo '</label></li>';
							}
						?>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <h4 class="mtit">売主</h4>
			<table class="form-analysis">
				<tr>
				<?php 
					$count = 0;
					for($i = 0; $i < 6 ; $i++) {				
						if($count % 8 == 0 && $count != 0) {
							echo '</tr><tr>';
						}
						$count++;
						echo '<td class="checkbox"><input type="checkbox" value="'; 
						echo $RS_seller[$i]['seller_cd'] . '" name="seller[]"></td><td class="analysis-name">';
						echo $RS_seller[$i]['seller_name'];
						echo '</td>';
					}
				?>
					<td class="checkbox"><input type="checkbox" value="0" name="seller[]"></td><td class="analysis-name">その他</td>
				</tr>
			</table>
            <div class="line-chart">
            	<div class="control-chart">
                	<table class="tbl-control">
                    	<tr>
                        	<td>期間</td>
                            <td>
								<input class="inp-cmn" type="text" id="from" value="2012/01/01"/>
							</td>
                            <td>〜</td>
                            <td>
								<input class="inp-cmn" type="text" id="to" value="<?php echo date('Y/m/d'); ?>"/>
							</td>
                            <td>内容</td>
                            <td>
                            	<select class="select-cmn" id="select_opt">
									<?php 
									for($i = 0; $i < count($RS_analytics); $i++) {
										echo '<option value="';
										echo $RS_analytics[$i]['analy_cd'];
										echo '">';
										echo $RS_analytics[$i]['analy_name'];
										echo '</option>';
									}
									?>
                                </select>
                            </td>
                            <td>
								<button class="btn-aggregate" id="btn_th">集　計</button>
							</td>
                        </tr>
                    </table>
					
					<div class="form-btn-time">
						<table class="tbl-control">
							<tr>
								<td><button class="btn btn-time" value="6"/>過去6 ヶ月</button></td>
								<td><button class="btn btn-time" value="12"/>過去1 年間</button></td>
								<td><button class="btn btn-time" value="24"/>過去2 年間</button></td>
								<td><button class="btn btn-time" value="36"/>過去3 年間</button></td>
							</tr>
						</table>
					</div>
                <!--/control-chart--></div>
				
				<div id="error"></div>
				
                <div class="view-chart" id="dashboard">
					<input type="hidden" id="item_cd" value="<?php echo $RS_analysis[0]['item_cd'];?>">
                    <div id="chart_div"></div>
					
					<br>
					<div id="analysis_tbl">
						<div class="strike">
							<span>売主別集計</span>
						</div>
						<br>
						
						<table class="form-compare-item" border="1" width="100%">
							<tr id="name">
								<th width="12%"></th>
							</tr>
							<tr id="sale_number">
							<th>売出件数</th>
							</tr>
							<tr id="avg_price_regist">
								<th>平均売出価格</th>
							</tr>
							<tr id="avg_price_sold">
								<th>平均成約価格</th>
							</tr>
							<tr id="avg_time_sold">
								<th>平均売出期間</th>
							</tr>
							<tr id="avg_time_change_circle">
								<th>平均価格改定周期</th>
							</tr>
							<tr id="avg_down_price_rate">
								<th>平均値下率</th>
							</tr>
							<tr id="market_rate">
								<th>販売シェア率</th>
							</tr>
						</table>
						
						<div id="piechart_3d" style="width: 100%; height: 500px;"></div>
					</div>
				</div>
            <!--/line-chart--></div>
        </div>
    </div>
  </div>
  <meta name="_token" content="{!! csrf_token() !!}" />
  
  
<!--STYLE CSS NEW-->
<link href="/_css/style-new.css" rel="stylesheet" type="text/css">
<!--Load jquery, bootstrap-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!--jqueryUI datepicker-->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js" type="text/javascript" charset="utf-8"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" rel="stylesheet" type="text/css" />

<!--Load google chart-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages': ['corechart', 'controls']});</script>
<script src="/_js/item/analysis_chart.js" type="text/javascript"></script>

<script>
   $(function() {
     $("#from").datepicker({ dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true });
     $("#to").datepicker({ dateFormat: 'yy/mm/dd', changeMonth: true, changeYear: true });
   });
</script>