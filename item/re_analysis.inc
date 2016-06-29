<!--STYLE CSS NEW-->
<link href="/_css/style-new.css" rel="stylesheet" type="text/css">
<!--Load jquery, bootstrap-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<!--Load google chart-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages': ['corechart']});</script>
<script src="/_js/item/analysis_chart.js" type="text/javascript"></script>

<!--use <input type=date/> in firefox-->
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
<script>
    webshims.setOptions('forms-ext', {types: 'date'});
    webshims.polyfill('forms forms-ext');
</script>


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
            <ul class="lst-check">
			<?php
				$count = 0;
				for($i = 0; $i < count($RS_city); $i++) {
					if($RS_city[$i]['cat_city_name'] == '福岡市') {
						if($count % 10 == 0 && $count != 0) {
							echo '</ul><ul class="lst-check" style="margin-bottom:10px">';
						}
						$count++;
						echo '<li><label><input type="checkbox" name="city[]" value="';
						echo $RS_city[$i]['city_cd'] . '">';
						echo $RS_city[$i]['city_name'];
						echo '('. $RS_city[$i]['count_item'] .')';
						echo '</label></li>';
					}
				}
			?>
            </ul>
            <h5 class="stit">福岡近郊</h5>
            <ul class="lst-check" style="margin-bottom:10px">
			<?php
				$count = 0;
				for($i = 0; $i < count($RS_city); $i++) {		
					if($RS_city[$i]['cat_city_name'] == '福岡近郊') {						
						if($count % 10 == 0 && $count != 0) {
							echo '</ul><ul class="lst-check" style="margin-bottom:10px">';
						}
						$count++;
						echo '<li><label><input type="checkbox" name="city[]" value="';
						echo $RS_city[$i]['city_cd'] . '">';
						echo $RS_city[$i]['city_name'];
						echo '('. $RS_city[$i]['count_item'] .')';
						echo '</label></li>';
					}
				}
			?>
            </ul>
            <h5 class="stit">その他</h5>
            <ul class="lst-check">
			<?php
				$count = 0;
				for($i = 0; $i < count($RS_city); $i++) {				
					if($RS_city[$i]['cat_city_name'] == 'その他') {					
						if($count % 10 == 0 && $count != 0) {
							echo '</ul><ul class="lst-check" style="margin-bottom:10px">';
						}
						$count++;
						echo '<li><label><input type="checkbox" name="city[]" value="';
						echo $RS_city[$i]['city_cd'] . '">';
						echo $RS_city[$i]['city_name'];
						echo '('. $RS_city[$i]['count_item'] .')';
						echo '</label></li>';
					}
				}
			?>
            </ul>
            <div class="clear02">
            	<div class="check-left">
                	<h4 class="mtit">種類</h4>
                    <ul class="lst-check">
                        <li><label><input type="checkbox" name="cat_item[]" value="1"> 戸建</label></li>
                        <li><label><input type="checkbox" name="cat_item[]" value="2"> マンション</label></li>
                    </ul>
                </div>
                <div class="check-right">
                	<h4 class="mtit">状態</h4>
                    <ul class="lst-check">
                        <li><label><input type="checkbox" name="condition[]" value="1"> 新築</label></li>
                        <li><label><input type="checkbox" name="condition[]" value="2"> 中古</label></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <h4 class="mtit">売主</h4>
            <ul class="lst-check" style="margin-bottom:10px;">
				<?php 
					$count = 0;
					for($i = 0; $i < count($RS_seller) ; $i++) {				
						if($count % 10 == 0 && $count != 0) {
							echo '</ul><ul class="lst-check" style="margin-bottom:10px">';
						}
						$count++;
						echo '<li><label><input type="checkbox" value="'; 
						echo $RS_seller[$i]['seller_cd'] . '" name="seller[]">';
						echo $RS_seller[$i]['seller_name'];
						echo '</label></li>';
					}
				?>
            </ul>
            <div class="line-chart">
            	<div class="control-chart">
                	<table class="tbl-control">
                    	<tr>
                        	<td>期間</td>
                            <td>
								<input class="inp-cmn" type="date" id="from" value="2000-01-01"/>
							</td>
                            <td>〜</td>
                            <td>
								<input class="inp-cmn" type="date" id="to" value="<?php echo date('Y-m-d'); ?>"/>
							</td>
                            <td>内容</td>
                            <td>
                            	<select class="select-cmn" id="select_opt">
                                	<option value="1">成約件数推移</option>
                                    <option value="2">新規登録件数推移</option>
                                    <option value="3">物件数推移</option>
                                    <option value="4">平均成約価格推移</option>
                                    <option value="5">平均販売開始価格推移</option>
                                </select>
                            </td>
                            <td>
								<button class="btn-aggregate" id="btn_th">集　計</button>
							</td>
                        </tr>
                    </table>
                <!--/control-chart--></div>
				<div id="error"></div>
                <div class="view-chart">
					<input type="hidden" id="item_cd" value="<?php echo $RS_analysis[0]['item_cd'];?>">
                    <div id="chart_div"></div>
				</div>
            <!--/line-chart--></div>
        </div>
    </div>
  </div>
  <meta name="_token" content="{!! csrf_token() !!}" />