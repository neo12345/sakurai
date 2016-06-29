<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();

$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
get_rs("m_pref", "pref", "", "pref_sort asc");
$count = 0;
for ($i = 0; $i < count($RS_pref); $i++) {
	get_rs("m_address", "addr", "pref_cd='".$RS_pref[$i]['pref_cd']."'", "city_cd asc");
	for ($j = 0; $j < count($RS_addr); $j++) {
		if(!get_colum_key("r_pref", "city_cd", $RS_addr[$j]['city_cd'], "rel_cd", "")){
			//r_pref
			$rel_cd = make_cd("r_pref", "rel_cd", "");
			$add_clm_array = array("rel_cd", "pref_cd", "city_cd");
			$add_value_array = array($rel_cd, $RS_pref[$i]['pref_cd'], $RS_addr[$j]['city_cd']);
			insert_db_same_name("", "r_pref", $add_clm_array, $add_value_array);
			//m_pref
			$city_cd = $city_sort = $RS_addr[$j]['city_cd'];
			$add_clm_array = array("city_cd", "city_sort", "city_name");
			$add_value_array = array($city_cd, $city_sort, $RS_addr[$j]['city_name']);
			insert_db_same_name("", "m_city", $add_clm_array, $add_value_array);
			$count++;
		}
	}
}
$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲

print_r($count."件追加");

exit;
?>
