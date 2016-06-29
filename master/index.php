<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();

if(!$F_md){$F_md="city";}

switch($F_md){
	case "city":
		$flg_jquery = "1";
		$flg_js_city = "1";
		$id_body = "master";
		$inc = "city.inc";
		if(!$F_pref_cd){
			$F_pref_cd = "40";
		}
		get_rs("m_pref", "pref", "", "pref_sort asc");
		get_rs("v_city", "city", "pref_cd='".$F_pref_cd."'", "city_sort asc");
		get_rs("m_cat_city", "cat_city", "", "cat_city_sort asc");
		break;

	case "school":
		$flg_jquery = "1";
		$flg_imgliquid = "1";
		$flg_js_school = "1";
		$id_body = "master";
		$inc = "school.inc";
		if(!$F_pref_cd){
			$F_pref_cd = "40";
		}
		get_rs("m_pref", "pref", "", "pref_sort asc");
		get_rs("m_school", "school", "", "school_sort asc");
		get_rs("m_school_primary", "school_pri", "", "school_pri_sort asc");
		get_rs("m_school_junior", "school_jun", "", "school_jun_sort asc");
		get_rs("m_school_high", "school_high", "", "school_high_sort asc");
		break;

	case "stop":
		$flg_jquery = "1";
		$flg_js_stop = "1";
		$id_body = "master";
		$inc = "stop.inc";
		if(!$F_pubtrans_cd){
			$F_pubtrans_cd = "1";
		}
		get_rs("m_pubtrans", "pubtrans", "", "pubtrans_sort asc");
		get_rs("v_stop", "stop", "pubtrans_cd='".$F_pubtrans_cd."'", "stop_sort desc");
		break;

	case "seller":
		$flg_jquery = "1";
		$flg_js_seller = "1";
		$id_body = "master";
		$inc = "seller.inc";
		get_rs("m_seller", "seller", "", "seller_sort asc");
		break;

	case "seller_office":
		$flg_jquery = "1";
		$flg_js_seller_office = "1";
		$id_body = "master";
		$inc = "seller_office.inc";
		get_rs("m_seller", "seller", "", "seller_sort asc");
		get_rs("m_seller_office", "seller_office", "", "seller_office_sort asc");
		break;

//	case "test":
//		//98万円は一建設で登録
//		get_rs("t_item", "item", "", "item_cd asc");
//		for ($i = 0; $i < count($RS_item); $i++) {
//			$value = ($RS_item[$i]['item_price']-98)%100;
//			if($value==0){
//				$sql = "update r_item1 set seller_cd=1";
//				$sql.=" where item_cd='".$RS_item[$i]['item_cd']."'";
//				$sql = sql_convert_null($sql);
//				$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
//			}
//		}
//		break;

	default :
		break;
}

if($F_regist){
	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
	//r_city
	$sql = "update r_city set cat_city_cd='".$F_cat_city_cd."'";
	$sql.=" where city_cd='".$F_city_cd."'";
	$sql = sql_convert_null($sql);
	$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	//r_city2
	$sql = "delete from r_city2 where city_cd='".$F_city_cd."'";
	$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	$F_link_city_cd = array_unique($F_link_city_cd);
	for ($i = 0; $i < count($F_link_city_cd); $i++) {
		if($F_link_city_cd[$i] != $F_city_cd){
			//r_city2
			$rel_cd = make_cd("r_city2", "rel_cd", "");
			$add_clm_array = array("rel_cd", "city_cd", "link_city_cd");
			$add_value_array = array($rel_cd, $F_city_cd, $F_link_city_cd[$i]);
			insert_db_same_name("", "r_city2", $add_clm_array, $add_value_array);
		}
	}
	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
	header("location:/master/?md=city&pref_cd=".$F_pref_cd);
	exit;
}

//-- .inc --//
include("header.inc");
include($inc);
include("footer.inc");
exit;
?>
