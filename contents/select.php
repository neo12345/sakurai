<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "sort":
		sort($F_reco_sort);
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
		for ($i = 0; $i < count($F_item_cd); $i++) {
			$sql = "update m_recommend set reco_sort='".$F_reco_sort[$i]."'";
			$sql.=" where item_cd='".$F_item_cd[$i]."'";
			$sql = sql_convert_null($sql);
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
		echo(true);
		exit;
		break;
		
	case "resist_cd":
		get_rs("t_item", "item", "item_cd='".$F_item_cd."'", "item_sort asc");
		if($RS_item[0]['item_cd']){
			$sql = "update m_recommend set item_cd='".$F_item_cd."'";
			$sql.=" where reco_cd='".$F_reco_cd."'";
			$sql = sql_convert_null($sql);
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
			echo($RS_item[0]['item_name']);
		}else{
			echo(false);
		}
		exit;
		break;
}	



exit;
?>
