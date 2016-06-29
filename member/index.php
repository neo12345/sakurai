<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


if(!$F_md){$F_md="list";}

switch($F_md){
	case "list":
		$flg_jquery = "1";
		$flg_js_member = "1";
		$id_body = "member";
		$inc = "list.inc";
		get_rs("v_member", "mem", "", "mem_sort asc");
		break;

	case "regist":
		$flg_jquery = "1";
		$flg_js_member = "1";
		$id_body = "member";
		$inc = "regist.inc";
		get_rs("m_pref", "pref", "", "pref_sort asc");
		if($F_edit){
			$item_cd = get_key($F_edit);
			get_rs("v_member", "mem", "mem_cd='".$item_cd."'", "mem_sort asc");
		}else{
			$RS_mem[0]['pref_cd'] = "40";
		}
		break;

	case "mail":
		$flg_jquery = "1";
		$flg_js_member = "1";
		$id_body = "member";
		$inc = "mail.inc";
		break;

	default :
		break;
}

if($F_regist){
	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
	if($F_mem_cd){
		$add_clm_array = array("mem_id");
		$add_value_array = array($F_mem_mail);
		update_db_same_name($_REQUEST, "t_member", $add_clm_array, $add_value_array, "mem_cd='".$F_mem_cd."'");
		update_db_same_name($_REQUEST, "r_member", "", "", "mem_cd='".$F_mem_cd."'");
	}else{
		//t_member
		$mem_cd = $mem_sort = make_cd("t_member", "mem_cd", "");
		$add_clm_array = array("mem_cd", "mem_sort", "mem_id", "date_regist", "flg_active");
		$add_value_array = array($mem_cd, $mem_sort, $F_mem_mail, date("Y-m-d H:i:s"), "1");
		insert_db_same_name($_REQUEST, "t_member", $add_clm_array, $add_value_array);
		//r_member
		$rel_cd = make_cd("r_member", "rel_cd", "");
		$add_clm_array = array("rel_cd", "mem_cd", "pref_cd");
		$add_value_array = array($rel_cd, $mem_cd, $F_pref_cd);
		insert_db_same_name("", "r_member", $add_clm_array, $add_value_array);
	}
	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
	if($F_mem_cd){
		header("location:/member/?md=list");
	}else{
		header("location:/member/?md=regist");
	}
	exit;
}


//-- .inc --//
if($F_md == "list"){
	include("re_header.inc");
	include("re_side.inc");
	include("re_".$inc);
	include("re_footer.inc");
}else{
	include("header.inc");
	include($inc);
	include("footer.inc");
}
exit;
?>
