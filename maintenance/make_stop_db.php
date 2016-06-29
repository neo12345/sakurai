<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();

$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
get_rs("m_pubtrans", "pubtrans", "", "pubtrans_sort asc");
$count = 0;
for ($i = 0; $i < count($RS_pubtrans); $i++) {
	$colum_sort = $RS_pubtrans[$i]['pubtrans_init']."_sort";
	$colum_name = $RS_pubtrans[$i]['pubtrans_init']."_name";
	$colum_kana = $RS_pubtrans[$i]['pubtrans_init']."_kana";
	get_rs($RS_pubtrans[$i]['pubtrans_table'], "", "", $colum_sort." asc");
	for ($j = 0; $j < count($RS); $j++) {
		if(!get_colum_key("v_stop", "stop_name", $RS[$j][$colum_name], "stop_cd", "pubtrans_cd='".$RS_pubtrans[$i]['pubtrans_cd']."'")){
			//m_stop
			$stop_cd = $stop_sort = make_cd("m_stop", "stop_cd", "");
			$add_clm_array = array("stop_cd", "stop_sort", "stop_name", "stop_kana");
			$add_value_array = array($stop_cd, $stop_sort, $RS[$j][$colum_name], $RS[$j][$colum_kana]);
			insert_db_same_name("", "m_stop", $add_clm_array, $add_value_array);
			//r_pubtrans
			$rel_cd = make_cd("r_pubtrans", "rel_cd", "");
			$add_clm_array = array("rel_cd", "pubtrans_cd", "stop_cd");
			$add_value_array = array($rel_cd, $RS_pubtrans[$i]['pubtrans_cd'], $stop_cd);
			insert_db_same_name("", "r_pubtrans", $add_clm_array, $add_value_array);
			$count++;
		}
	}
}
$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲

print_r($count."件追加");

exit;
?>
