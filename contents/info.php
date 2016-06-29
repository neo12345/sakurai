<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "del_info":
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
		$sql = "delete from t_info where info_cd='".$F_info_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
		echo(true);
		exit;
		break;
	
	case "get_info":
		get_rs("t_info", "info", "info_cd='".$F_info_cd."'", "info_date desc");
		if($RS_info){
			$json = json_encode($RS_info);
			echo($json);
		}else{
			echo(false);
		}
		exit;
		break;
}	


if($F_regist){
	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
	if($F_info_cd){
		update_db_same_name($_REQUEST, "t_info", "", "", "info_cd='".$F_info_cd."'");
	}else{
		//t_info
		unset($_REQUEST['info_cd']);
		$info_cd = $info_sort = make_cd("t_info", "info_cd", "");
		$add_clm_array = array("info_cd", "info_sort");
		$add_value_array = array($info_cd, $info_sort);
		insert_db_same_name($_REQUEST, "t_info", $add_clm_array, $add_value_array);
	}
	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
	header("location:/contents/?md=info");
	exit;
}

if($F_cancel){
	header("location:/contents/?md=info");
}

//-- .inc --//
include("header.inc");
include($inc);
include("footer.inc");
exit;
?>
