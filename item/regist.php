<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "make_city":
		get_rs("v_city", "city", "pref_cd='".$F_pref_cd."'", "city_sort asc");
		$json = json_encode($RS_city);
		echo($json);
		exit;
		break;

	case "narrow_search_school":
		get_rs("v_school_primary", "scpri", "city_cd='".$F_city_cd."'", "school_pri_sort asc");
		get_rs("v_school_junior", "scjun", "city_cd='".$F_city_cd."'", "school_jun_sort asc");
		$cat_schigh_cd = $RS_scjun[0]['cat_schigh_cd'];
		$RS[] = $RS_scpri;
		$RS[] = $RS_scjun;
		$RS[] = $cat_schigh_cd;
		$json = json_encode($RS);
		echo($json);
		exit;
		break;
	
	case "narrow_search_school_high":
		$cat_schigh_cd = get_colum_key("v_school_junior", "school_jun_cd", $F_school_jun_cd, "cat_schigh_cd", "");
		echo($cat_schigh_cd);
		exit;
		break;

	case "make_stop":
		if($F_serach_word){
			$A_where[] = "stop_name LIKE '%".$F_serach_word."%'";
		}
		$A_where[] = "pubtrans_cd='".$F_pubtrans_cd."'";
		$where = implode(" and ", $A_where);
		get_rs("v_stop", "stop", $where, "stop_sort asc");
		if($RS_stop){
			$json = json_encode($RS_stop);
		}else{
			$json = false;
		}
		echo($json);
		exit;
		break;

	case "make_school_pri":
		if($F_serach_word){
			$A_where[] = "school_pri_name LIKE '%".$F_serach_word."%'";
		}else{
			$A_where[] = "city_cd='".$F_city_cd."'";
		}
		$where = implode(" and ", $A_where);
		get_rs("v_school_primary", "schpri", $where, "school_pri_sort asc");
		if($RS_schpri){
			$json = json_encode($RS_schpri);
		}else{
			$json = false;
		}
		echo($json);
		exit;
		break;

	case "make_school_jun":
		if($F_serach_word){
			$A_where[] = "school_jun_name LIKE '%".$F_serach_word."%'";
		}else{
			$A_where[] = "city_cd='".$F_city_cd."'";
		}
		$where = implode(" and ", $A_where);
		get_rs("v_school_junior", "schjun", $where, "school_jun_sort asc");
		if($RS_schjun){
			$json = json_encode($RS_schjun);
		}else{
			$json = false;
		}
		echo($json);
		exit;
		break;

	case "select_office":
		$A_where[] = "seller_office_cd in (select seller_office_cd from r_seller where seller_cd = '".$F_seller_cd."')";
		$where = implode(" and ", $A_where);
		get_rs("m_seller_office", "seller_office", $where, "seller_office_sort asc");
		if($RS_seller_office){
			$json = json_encode($RS_seller_office);
		}else{
			$json = false;
		}
		echo($json);
		exit;
		break;

	default :
		exit;
		break;
}

exit;
?>
