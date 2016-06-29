<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "make_main":
		get_rs("v_city", "city", "pref_cd='".$F_pref_cd."'", "city_sort asc");
		$json = json_encode($RS_city);
		echo($json);
		exit;
		break;

	case "pic_city":
		get_rs("v_city", "city", "pref_cd='".$F_pref_cd."'", "city_sort asc");
		$json = json_encode($RS_city);
		echo($json);
		exit;
		break;

	case "add_list":
		get_rs("v_city", "city", "city_cd='".$F_city_cd."'", "city_sort asc");
		if($RS_city){
			$json = json_encode($RS_city);
		}else{
			$json = false;
		}
		echo($json);
		exit;
		break;

	case "get_name":
		get_rs("v_city", "city", "city_cd='".$F_city_cd."'", "city_sort asc");
		if($RS_city){
			$json = json_encode($RS_city);
		}else{
			$json = false;
		}
		echo($json);
		exit;
		break;

	case "make_list":
		get_rs("v_link_city", "link_city", "city_cd='".$F_city_cd."'", "link_city_sort asc");
		if($RS_link_city){
			$json = json_encode($RS_link_city);
		}else{
			$json = false;
		}
		echo($json);
		exit;
		break;

	case "sort":
		sort($F_city_sort);
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
		for ($i = 0; $i < count($F_city_cd); $i++) {
			$sql = "update m_city set city_sort='".$F_city_sort[$i]."'";
			$sql.=" where city_cd='".$F_city_cd[$i]."'";
			$sql = sql_convert_null($sql);
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
		echo(true);
		exit;
		break;

	default :
		exit;
		break;
}

exit;
?>
