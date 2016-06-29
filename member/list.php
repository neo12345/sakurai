<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "del_mem":
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
		$sql = "delete from r_member where mem_cd='".$F_mem_cd."';";
		$sql.= "delete from t_member where mem_cd='".$F_mem_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
		echo(true);
		exit;
		break;
}	

exit;
?>
