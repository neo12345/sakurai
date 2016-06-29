<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();


if(!$F_md){$F_md="list";}

switch($F_md){
//	case "test":
//		get_rs("v_item", "item", "", "item_sort asc");
//		for ($i = 0; $i < count($RS_item); $i++) {
//			$hist_price_cd = $hist_price_sort = make_cd("t_history_price", "hist_price_cd", "");
//			$add_clm_array = array("hist_price_cd", "hist_price_sort", "hist_price_value", "hist_price_date");
//			$add_value_array = array($hist_price_cd, $hist_price_sort, $RS_item[$i]['item_price'], pic_object_date("Y-m-d", $RS_item[$i]['date_regist']));
//			insert_db_same_name("", "t_history_price", $add_clm_array, $add_value_array);
//			$rel_cd = make_cd("r_item11", "rel_cd", "");
//			$add_clm_array = array("rel_cd", "item_cd", "hist_price_cd");
//			$add_value_array = array($rel_cd, $RS_item[$i]['item_cd'], $hist_price_cd);
//			insert_db_same_name("", "r_item11", $add_clm_array, $add_value_array);
//		}
//		break;
	
	case "list":
		$flg_jquery = "1";
		$flg_list = "1";
		$id_body = "itemlist";
		$inc = "list.inc";
//		$F_pref_cd = "40";
//		$F_pref_cd = "41";
		get_rs("v_city", "city", "(pref_cd='40' or pref_cd='41') and count_item>0", "city_sort asc");
		get_rs("m_seller", "seller", "", "seller_sort asc");
		if($F_seller_cd){
			get_rs("m_seller_office", "seller_office", "seller_office_cd in (select seller_office_cd from r_seller where seller_cd = ".$F_seller_cd.")", "seller_office_sort asc");
		}
		$A_stat[] = array('stat_cd'=>1, 'stat_name'=>"新築");
		$A_stat[] = array('stat_cd'=>2, 'stat_name'=>"中古");
		$A_stat_item[] = array('stat_item_cd'=>1, 'stat_item_name'=>"商談中");
		$A_stat_item[] = array('stat_item_cd'=>2, 'stat_item_name'=>"成約済");
		$A_stat_item[] = array('stat_item_cd'=>3, 'stat_item_name'=>"販売中");
		if($F_city_cd){
			$A_where[] = "city_cd='".$F_city_cd."'";
		}
		if($F_seller_cd){
			$A_where[] = "seller_cd='".$F_seller_cd."'";
		}
		if($F_seller_office_cd){
			$A_where[] = "seller_office_cd='".$F_seller_office_cd."'";
		}
		if($F_stat_cd==1){
			$A_where[] = "flg_new='1'";
		}elseif($F_stat_cd==2){
			$A_where[] = "flg_new is null";
		}
		if($F_stat_item_cd==1){
			$A_where[] = "flg_nego='1'";
		}elseif($F_stat_item_cd==2){
			$A_where[] = "flg_soldout='1'";
		}elseif($F_stat_item_cd==3){
			$A_where[] = "flg_nego is null and flg_soldout is null";
		}
		if($F_item_name){
			$A_where[] = "item_name like '%".$F_item_name."%'";
		}
		$where = implode(" and ", $A_where);
		get_rs("v_item", "item", $where, "item_sort desc");
		if(!$F_regist and !$F_copy){
			$_SESSION['status'] = array("city_cd"=>$F_city_cd, "stat_cd"=>$F_stat_cd, "seller_cd"=>$F_seller_cd, "seller_office_cd"=>$F_seller_office_cd, "stat_item_cd"=>$F_stat_item_cd, "item_name"=>$F_item_name);
		}
		break;

	case "regist":
		$flg_jquery = "1";
		$flg_js_datepicker = "1";
		$flg_regist = "1";
		$flg_imgliquid = "1";
		$flg_position_search = "1";
		$id_body = "itementry";
		$inc = "regist.inc";
		
		if($F_edit){
			$item_cd = get_key($F_edit);
			get_rs("v_item", "item", "item_cd='".$item_cd."'", "item_sort asc");
			get_rs("r_item2", "item_pub", "item_cd='".$item_cd."'", "rel_cd asc");
			get_rs("t_cost", "cost", "cost_cd in (select cost_cd from r_item5 where item_cd='".$item_cd."')", "cost_sort asc");
			get_rs("t_size_add", "size_add", "size_add_cd in (select size_add_cd from r_item6 where item_cd='".$item_cd."')", "size_add_sort asc");
			get_rs("t_size_detail", "size_detail", "size_detail_cd in (select size_detail_cd from r_item7 where item_cd='".$item_cd."')", "size_detail_sort asc");
			get_rs("v_along", "along", "along_cd in (select along_cd from r_item8 where item_cd='".$item_cd."')", "along_sort asc");
			get_rs("t_history_price", "hist_price", "hist_price_cd in (select hist_price_cd from r_item11 where item_cd='".$item_cd."')", "hist_price_date desc");
			get_rs("r_item9", "item_dist", "item_cd='".$item_cd."'", "rel_cd asc");
			get_rs("v_img_detail", "item_detail", "item_cd='".$item_cd."'", "img_detail_sort asc");
			get_rs("v_img_around", "item_around", "item_cd='".$item_cd."'", "img_around_sort asc");
		}else{
			$RS_item[0]['pref_cd'] = "40";
			$RS_item[0]['city_cd'] = "40132";
		}
		preg_match("/^([0-9].+)-([0-9].+)-.+/", $RS_item[0]['item_build'], $A_item_build);
		$item_build_y = $A_item_build[1];
		$item_build_m = $A_item_build[2];
		get_rs("m_cat_item", "cat_item", "", "cat_item_sort");
		get_rs("m_pref", "pref", "", "pref_sort");
		get_rs("v_city", "city", "pref_cd='".$RS_item[0]['pref_cd']."'", "city_sort");
		get_rs("m_pubtrans", "pubtrans", "", "pubtrans_sort");
		get_rs("m_transway", "transway", "", "transway_sort");
		if($RS_item[0]['school_pri_cd']){
			get_rs("v_school_primary", "school_pri", "city_cd='".$RS_item[0]['city_cd']."' or school_pri_cd='".$RS_item[0]['school_pri_cd']."'", "school_pri_sort");
		}else{
			get_rs("v_school_primary", "school_pri", "city_cd='".$RS_item[0]['city_cd']."'", "school_pri_sort");
		}
		if($RS_item[0]['school_jun_cd']){
			get_rs("v_school_junior", "school_jun", "city_cd='".$RS_item[0]['city_cd']."' or school_jun_cd='".$RS_item[0]['school_jun_cd']."'", "school_jun_sort");
		}else{
			get_rs("v_school_junior", "school_jun", "city_cd='".$RS_item[0]['city_cd']."'", "school_jun_sort");
		}
		get_rs("m_cat_schigh", "cat_schigh", "", "cat_schigh_sort");
		get_rs("m_admintype", "admintype", "", "admintype_sort");
		get_rs("m_layout", "layout", "", "layout_sort");
		get_rs("m_structure", "struc", "", "struc_sort");
		get_rs("m_method", "meth", "", "meth_sort");
		get_rs("m_dues", "dues", "", "dues_sort");
		get_rs("m_waterworks", "water", "", "water_sort");
		get_rs("m_sewer", "sewer", "", "sewer_sort");
		get_rs("m_fuel", "fuel", "", "fuel_sort");
		get_rs("m_mediate", "med", "", "med_sort");
		get_rs("m_rights", "rights", "", "rights_sort");
		get_rs("m_landcat", "landcat", "", "landcat_sort");
		get_rs("m_plan", "plan", "", "plan_sort");
		get_rs("m_district", "dist", "", "dist_sort");
		get_rs("m_direction", "dire", "", "dire_sort");
		get_rs("m_road", "road", "", "road_sort");
		get_rs("m_seller", "seller", "", "seller_sort");
		if($RS_item[0]['seller_cd']){
			get_rs("m_seller_office", "seller_office", "seller_office_cd in (select seller_office_cd from r_seller where seller_cd = '".$RS_item[0]['seller_cd']."')", "seller_office_sort");
		}
		get_rs("m_user", "user", "user_cd != '1' and user_cd != '2'", "user_sort asc");
		break;

	case "analysis":
		$flg_jquery = "1";
		$flg_analysis = "1";
		$id_body = "itemlist";
		$inc = "analysis.inc";
		$F_pref_cd = "40";
		
		get_rs("v_city", "city", "pref_cd='".$F_pref_cd."'", "city_sort asc");
		if($F_city_cd){
			$where_city_cd = " and city_cd='".$F_city_cd."'";
		}else{
			$where_city_cd = "";
		}
		//登録中
		get_rs("v_item", "item_cat1_new_regist", "cat_item_cd='1' and flg_new='1'".$where_city_cd, "item_sort desc");
		get_rs("v_item", "item_cat1_used_regist", "cat_item_cd='1' and flg_new is null".$where_city_cd, "item_sort desc");
		get_rs("v_item", "item_cat2_regist", "cat_item_cd='2'".$where_city_cd, "item_sort desc");
		//販売中
		$where_sell = " and flg_nego is null and flg_soldout is null".$where_city_cd;
		get_rs("v_item", "item_cat1_new_sell", "cat_item_cd='1' and flg_new='1'".$where_sell, "item_sort desc");
		get_rs("v_item", "item_cat1_used_sell", "cat_item_cd='1' and flg_new is null".$where_sell, "item_sort desc");
		get_rs("v_item", "item_cat2_sell", "cat_item_cd='2'".$where_sell, "item_sort desc");
		//商談中
		$where_nego = " and flg_nego='1' and flg_soldout is null".$where_city_cd;
		get_rs("v_item", "item_cat1_new_nego", "cat_item_cd='1' and flg_new='1'".$where_nego, "item_sort desc");
		get_rs("v_item", "item_cat1_used_nego", "cat_item_cd='1' and flg_new is null".$where_nego, "item_sort desc");
		get_rs("v_item", "item_cat2_nego", "cat_item_cd='2'".$where_nego, "item_sort desc");
		//成約済(掲載)
		$where_soldout_open = " and flg_soldout='1' and (date_soldout is null or date_soldout >= '".date("Y-m-d", strtotime("-".$G_limit_day_soldout." day"))."')".$where_city_cd;
		get_rs("v_item", "item_cat1_new_soldout_open", "cat_item_cd='1' and flg_new='1'".$where_soldout_open, "item_sort desc");
		get_rs("v_item", "item_cat1_used_soldout_open", "cat_item_cd='1' and flg_new is null".$where_soldout_open, "item_sort desc");
		get_rs("v_item", "item_cat2_soldout_open", "cat_item_cd='2'".$where_soldout_open, "item_sort desc");
		//成約済(非掲載)
		$where_soldout_close = " and flg_soldout='1' and (date_soldout < '".date("Y-m-d", strtotime("-".$G_limit_day_soldout." day"))."')".$where_city_cd;
		get_rs("v_item", "item_cat1_new_soldout_close", "cat_item_cd='1' and flg_new='1'".$where_soldout_close, "item_sort desc");
		get_rs("v_item", "item_cat1_used_soldout_close", "cat_item_cd='1' and flg_new is null".$where_soldout_close, "item_sort desc");
		get_rs("v_item", "item_cat2_soldout_close", "cat_item_cd='2'".$where_soldout_close, "item_sort desc");
		break;

//	case "ajax":
//		switch($F_st){
//			case "make_city":
//				get_rs("v_city", "city", "pref_cd='".$F_pref_cd."'", "city_sort asc");
//				$json = json_encode($RS_city);
//				echo($json);
//				exit;
//				break;
//			
//			case "narrow_search_school":
//				get_rs("v_school_primary", "scpri", "city_cd='".$F_city_cd."'", "school_pri_sort asc");
//				get_rs("v_school_junior", "scjun", "city_cd='".$F_city_cd."'", "school_jun_sort asc");
//				$RS[] = $RS_scpri;
//				$RS[] = $RS_scjun;
//				$json = json_encode($RS);
//				echo($json);
//				exit;
//				break;
//			
//			case "make_stop":
//				if($F_serach_word){
//					$A_where[] = "stop_name LIKE '%".$F_serach_word."%'";
//				}
//				$A_where[] = "pubtrans_cd='".$F_pubtrans_cd."'";
//				$where = implode(" and ", $A_where);
//				get_rs("v_stop", "stop", $where, "stop_sort asc");
//				if($RS_stop){
//					$json = json_encode($RS_stop);
//				}else{
//					$json = false;
//				}
//				echo($json);
//				exit;
//				break;
//				$sql = "select * from TABLE";
//				$rs = exec_sql($db, $sql, $SERVER["SCRIPT_NAME"]);
//				$RS = convert_rs($rs);
//
//			case "del_item":
//				$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
//				$sql = "delete from t_img_detail where img_detail_cd in (select img_detail_cd from r_item3 where item_cd='".$F_item_cd."');";
//				$sql.= "delete from t_img_around where img_around_cd in (select img_around_cd from r_item4 where item_cd='".$F_item_cd."');";
//				$sql.= "delete from r_item1 where item_cd='".$F_item_cd."';";
//				$sql.= "delete from r_item2 where item_cd='".$F_item_cd."';";
//				$sql.= "delete from r_item3 where item_cd='".$F_item_cd."';";
//				$sql.= "delete from r_item4 where item_cd='".$F_item_cd."';";
//				$sql.= "delete from t_cost where cost_cd in (select cost_cd from r_item5 where item_cd='".$F_item_cd."');";
//				$sql.= "delete from r_item5 where item_cd='".$F_item_cd."';";
//				$sql.= "delete from t_size_add where size_add_cd in (select size_add_cd from r_item6 where item_cd='".$F_item_cd."');";
//				$sql.= "delete from r_item6 where item_cd='".$F_item_cd."';";
//				$sql.= "delete from t_size_detail where size_detail_cd in (select size_detail_cd from r_item7 where item_cd='".$F_item_cd."');";
//				$sql.= "delete from r_item7 where item_cd='".$F_item_cd."';";
//				$sql.= "delete from t_item where item_cd='".$F_item_cd."';";
//				$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
//				rm_dir($G_up_path."/item/".sprintf("%03d", $F_item_cd));
//				$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
//				echo(true);
//				exit;
//				break;
//			
//			default :
//				exit;
//				break;
//		}
//	break;

	default :
		break;
}

if($F_regist or $F_copy){
	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
	if($F_copy){
		$F_item_cd = "";
		$_REQUEST['item_name'] = "【コピー】".$_REQUEST['item_name'];
	}
	if($F_item_cd){
		$item_cd = $F_item_cd;
	}else{
		unset($_REQUEST['item_cd']);
	}
	$_REQUEST['item_youtube'] = str_replace("http://youtu.be/", "http://www.youtube.com/embed/", $_REQUEST['item_youtube']);
	$_REQUEST['item_build'] = $F_item_build_y."-".$F_item_build_m."-01";
	if($F_cat_item_cd == 1){
		$_REQUEST['item_size_floor'] = $F_item_size_build;
	}
	//t_item
	if($F_item_cd){
		$item_point = "(".$F_item_lat.",".$F_item_lng.")";
		$add_clm_array = array("item_point");
		$add_value_array = array($item_point);
		update_db_same_name($_REQUEST, "t_item", $add_clm_array, $add_value_array, "item_cd='".$F_item_cd."'");
	}else{
		$item_cd = $item_sort = make_cd("t_item", "item_cd", "");
		$item_point = "(".$F_item_lat.",".$F_item_lng.")";
		$add_clm_array = array("item_cd", "item_sort", "date_regist", "item_point");
		$add_value_array = array($item_cd, $item_sort, date("Y-m-d H:i:s"), $item_point);
		insert_db_same_name($_REQUEST, "t_item", $add_clm_array, $add_value_array);
	}
	//r_item1
	if($F_item_cd){
		update_db_same_name($_REQUEST, "r_item1", $add_clm_array="", $add_value_array="", "item_cd='".$F_item_cd."'");
	}else{
		$rel_cd = make_cd("r_item1", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd");
		$add_value_array = array($rel_cd, $item_cd);
		insert_db_same_name($_REQUEST, "r_item1", $add_clm_array, $add_value_array);
	}
	//r_item2
	if($F_item_cd){
		$sql = "delete from r_item2 where item_cd='".$F_item_cd."'";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_stop_cd); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$rel_cd = make_cd("r_item2", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "pubtrans_cd", "stop_cd", "transway_cd", "transdist", "transtime");
		$add_value_array = array($rel_cd, $item_cd, $F_pubtrans_cd[$i], $F_stop_cd[$i], $F_transway_cd[$i], $F_transdist[$i], $F_transtime[$i]);
		insert_db_same_name("", "r_item2", $add_clm_array, $add_value_array);
	}
	//r_item5
	if($F_item_cd){
		$sql = "delete from t_cost where cost_cd in (select cost_cd from r_item5 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item5 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_cost_name); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$cost_cd = $cost_sort = make_cd("t_cost", "cost_cd", "");
		$add_clm_array = array("cost_cd", "cost_sort", "cost_name", "cost_price");
		$add_value_array = array($cost_cd, $cost_sort, $F_cost_name[$i], $F_cost_price[$i]);
		insert_db_same_name("", "t_cost", $add_clm_array, $add_value_array);
		$rel_cd = make_cd("r_item5", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "cost_cd");
		$add_value_array = array($rel_cd, $item_cd, $cost_cd);
		insert_db_same_name("", "r_item5", $add_clm_array, $add_value_array);
	}
	//r_item6
	if($F_item_cd){
		$sql = "delete from t_size_add where size_add_cd in (select size_add_cd from r_item6 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item6 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_size_add_name); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$size_add_cd = $size_add_sort = make_cd("t_size_add", "size_add_cd", "");
		$add_clm_array = array("size_add_cd", "size_add_sort", "size_add_name", "size_add_size");
		$add_value_array = array($size_add_cd, $size_add_sort, $F_size_add_name[$i], $F_size_add_size[$i]);
		insert_db_same_name("", "t_size_add", $add_clm_array, $add_value_array);
		$rel_cd = make_cd("r_item6", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "size_add_cd");
		$add_value_array = array($rel_cd, $item_cd, $size_add_cd);
		insert_db_same_name("", "r_item6", $add_clm_array, $add_value_array);
	}
	//r_item7
	if($F_item_cd){
		$sql = "delete from t_size_detail where size_detail_cd in (select size_detail_cd from r_item7 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item7 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_size_detail_name); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$size_detail_cd = $size_detail_sort = make_cd("t_size_detail", "size_detail_cd", "");
		$add_clm_array = array("size_detail_cd", "size_detail_sort", "size_detail_name", "size_detail_size");
		$add_value_array = array($size_detail_cd, $size_detail_sort, $F_size_detail_name[$i], $F_size_detail_size[$i]);
		insert_db_same_name("", "t_size_detail", $add_clm_array, $add_value_array);
		$rel_cd = make_cd("r_item7", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "size_detail_cd");
		$add_value_array = array($rel_cd, $item_cd, $size_detail_cd);
		insert_db_same_name("", "r_item7", $add_clm_array, $add_value_array);
	}
	//r_item8
	if($F_item_cd){
		$sql = "delete from t_along where along_cd in (select along_cd from r_item8 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item8 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_along_size); $i++) {
		if($F_along_size[$i]){
			if($i == 0){ continue; } //1つ目は複製用の為
			$along_cd = $along_sort = make_cd("t_along", "along_cd", "");
			$add_clm_array = array("along_cd", "along_sort", "along_size");
			$add_value_array = array($along_cd, $along_sort, $F_along_size[$i]);
			insert_db_same_name("", "t_along", $add_clm_array, $add_value_array);
			$rel_cd = make_cd("r_item8", "rel_cd", "");
			$add_clm_array = array("rel_cd", "item_cd", "along_cd", "dire_cd", "road_cd");
			$add_value_array = array($rel_cd, $item_cd, $along_cd, $F_along_dire_cd[$i], $F_road_cd[$i]);
			insert_db_same_name("", "r_item8", $add_clm_array, $add_value_array);
		}
	}
	//r_item9
	if($F_item_cd){
		$sql= "delete from r_item9 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_dist_cd); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$rel_cd = make_cd("r_item9", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "dist_cd");
		$add_value_array = array($rel_cd, $item_cd, $F_dist_cd[$i]);
		insert_db_same_name("", "r_item9", $add_clm_array, $add_value_array);
	}
	//r_item10
	if($F_item_cd){
		$sql= "delete from r_item10 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_user_cd_chase); $i++) {
		$rel_cd = make_cd("r_item10", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "user_cd");
		$add_value_array = array($rel_cd, $item_cd, $F_user_cd_chase[$i]);
		insert_db_same_name("", "r_item10", $add_clm_array, $add_value_array);
	}
	//r_item11
	if($F_item_cd){
		$sql = "delete from t_history_price where hist_price_cd in (select hist_price_cd from r_item11 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item11 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}else{
		array_push($F_hist_price_value, $F_item_price);
		array_push($F_hist_price_date, date("Y-m-d"));
	}
	for ($i = 0; $i < count($F_hist_price_value); $i++) {
		if($F_hist_price_value[$i]){
			if($i == 0){ continue; } //1つ目は複製用の為
			$hist_price_cd = $hist_price_sort = make_cd("t_history_price", "hist_price_cd", "");
			$add_clm_array = array("hist_price_cd", "hist_price_sort", "hist_price_value", "hist_price_date");
			$add_value_array = array($hist_price_cd, $hist_price_sort, $F_hist_price_value[$i], $F_hist_price_date[$i]);
			insert_db_same_name("", "t_history_price", $add_clm_array, $add_value_array);
			$rel_cd = make_cd("r_item11", "rel_cd", "");
			$add_clm_array = array("rel_cd", "item_cd", "hist_price_cd");
			$add_value_array = array($rel_cd, $item_cd, $hist_price_cd);
			insert_db_same_name("", "r_item11", $add_clm_array, $add_value_array);
		}
	}
//イメージフォルダ準備
	$path_item = $G_up_path."/item/".sprintf("%03d",$item_cd);
	$path_detail = $G_up_path."/item/".sprintf("%03d",$item_cd)."/detail";
	$path_around = $G_up_path."/item/".sprintf("%03d",$item_cd)."/around";
	if(!is_dir($path_item)){
		mkdir($path_item,0777);
		chmod($path_item,0777);
	}
	if(!is_dir($path_detail)){
		mkdir($path_detail,0777);
		chmod($path_detail,0777);
	}
	if(!is_dir($path_around)){
		mkdir($path_around,0777);
		chmod($path_around,0777);
	}
	if(!$F_copy){
		//イメージアップロード
		$A_img[] = array('name'=>"top", 'type'=>$F_type_top, 'uri'=>$F_uri_top, 'width'=>950, 'height'=>"", 'exist'=>$F_exist_top, 'flg_notrim'=>"1");
		//$A_img[] = array('name'=>"top", 'type'=>$F_type_top, 'uri'=>$F_uri_top, 'width'=>950, 'height'=>440, 'exist'=>$F_exist_top, 'flg_notrim'=>"");
		$A_img[] = array('name'=>"main", 'type'=>$F_type_main, 'uri'=>$F_uri_main, 'width'=>800, 'height'=>600, 'exist'=>$F_exist_main, 'flg_notrim'=>"");
		$A_img[] = array('name'=>"main_s", 'type'=>$F_type_main, 'uri'=>$F_uri_main, 'width'=>200, 'height'=>200, 'exist'=>$F_exist_main, 'flg_notrim'=>"");
		$A_img[] = array('name'=>"plan1", 'type'=>$F_type_plan1, 'uri'=>$F_uri_plan1, 'width'=>800, 'height'=>600, 'exist'=>$F_exist_plan1, 'flg_notrim'=>"1");
		$A_img[] = array('name'=>"plan1_s", 'type'=>$F_type_plan1, 'uri'=>$F_uri_plan1, 'width'=>175, 'height'=>175, 'exist'=>$F_exist_plan1, 'flg_notrim'=>"1");
		$A_img[] = array('name'=>"plan2", 'type'=>$F_type_plan2, 'uri'=>$F_uri_plan2, 'width'=>800, 'height'=>600, 'exist'=>$F_exist_plan2, 'flg_notrim'=>"1");
		for($i = 0; $i<count($A_img); $i++){
			if(!$A_img[$i]['exist']){
				rm_file($path_item."/".$A_img[$i]['name'].".*");
				if(preg_match("/jpeg/",$A_img[$i]['type'])){
					$filesuffix = ".jpg";
					$mimeprefix = "data:image/jpeg;base64,";
				}elseif(preg_match("/gif/",$A_img[$i]['type'])){
					$filesuffix = ".gif";
					$mimeprefix = "data:image/gif;base64,";
				}elseif(preg_match("/png/",$A_img[$i]['type'])){
					$filesuffix = ".png";
					$mimeprefix = "data:image/png;base64,";
				}
				$filename = $A_img[$i]['name'].$filesuffix;
				$filepathname = $path_item."/".$filename;
				if($A_img[$i]['uri']){
					file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $A_img[$i]['uri'])));
					$A_size = getimagesize($filepathname);
					$w = $A_size[0];
					$h = $A_size[1];
					if($w >= $h or $A_img[$i]['name'] == "top"){
						$width = $A_img[$i]['width'];
						$height = $A_img[$i]['height'];
					}else{
						$width = $A_img[$i]['height'];
						$height = $A_img[$i]['width'];
					}
					resize_image($path_item, $filename, $width, $height, "", $A_img[$i]['flg_notrim']);
				}
			}
		}
		//ファクトシートアップロード
		if(!$F_exist_fact){
			rm_file($path_item."/fact.*");
			if(preg_match("/jpeg/",$F_type_fact)){
				$filesuffix = ".jpg";
				$mimeprefix = "data:image/jpeg;base64,";
			}elseif(preg_match("/gif/",$F_type_fact)){
				$filesuffix = ".gif";
				$mimeprefix = "data:image/gif;base64,";
			}elseif(preg_match("/png/",$F_type_fact)){
				$filesuffix = ".png";
				$mimeprefix = "data:image/png;base64,";
			}elseif(preg_match("/pdf/",$F_type_fact)){
				$filesuffix = ".pdf";
				$mimeprefix = "data:application/pdf;base64,";
			}
			$filename = "fact".$filesuffix;
			$filepathname = $path_item."/".$filename;
			if($F_uri_fact){
				file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $F_uri_fact)));
			}
		}
		//t_img_detail
		$count = 1;
		if($F_item_cd){
			$dh=opendir($path_detail);
			while(($entry=readdir($dh))){
				if(!is_dir($path_detail."/".$entry)){
					preg_match("/^([0-9]{2}).*\.[^.]+$/", $entry, $A_match);
					$num = sprintf("%01d", $A_match[1]);
					if(!in_array($num, $F_num_detail)){
						unlink($path_detail."/".$entry);
					}
				}
			}
			closedir($dh);
			$sql = "delete from t_img_detail where img_detail_cd in (select img_detail_cd from r_item3 where item_cd='".$F_item_cd."');";
			$sql.= "delete from r_item3 where item_cd='".$F_item_cd."';";
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		for ($i = 0; $i < count($F_uri_detail); $i++) {
			if($F_uri_detail[$i] or $F_num_detail[$i]){
				$img_detail_cd = $img_detail_sort = make_cd("t_img_detail", "img_detail_cd", "");
				if($F_num_detail[$i]){
					$img_detail_number = $F_num_detail[$i];
				}else{
					while(in_array($count, $F_num_detail)){
						$count++;
					}
					$img_detail_number = $count;
					$count++;
				}
				$add_clm_array = array("img_detail_cd", "img_detail_sort", "img_detail_number", "img_detail_title");
				$add_value_array = array($img_detail_cd, $img_detail_sort, $img_detail_number, $F_title_detail[$i]);
				insert_db_same_name("", "t_img_detail", $add_clm_array, $add_value_array);
				//r_item3
				$rel_cd = make_cd("r_item3", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_detail_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_detail_cd);
				insert_db_same_name("", "r_item3", $add_clm_array, $add_value_array);
				//イメージアップロード
				if(!$F_num_detail[$i]){
					if(preg_match("/jpeg/",$F_type_detail[$i])){
						$filesuffix = ".jpg";
						$mimeprefix = "data:image/jpeg;base64,";
					}elseif(preg_match("/gif/",$F_type_detail[$i])){
						$filesuffix = ".gif";
						$mimeprefix = "data:image/gif;base64,";
					}elseif(preg_match("/png/",$F_type_detail[$i])){
						$filesuffix = ".png";
						$mimeprefix = "data:image/png;base64,";
					}
					$filename = sprintf("%02d",$img_detail_number).$filesuffix;
					$filepathname = $path_detail."/".$filename;
					file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $F_uri_detail[$i])));
					$A_size = getimagesize($filepathname);
					$w = $A_size[0];
					$h = $A_size[1];
					if($w >= $h){
						resize_image($path_detail, $filename, 800, 600, "");
					}else{
						resize_image($path_detail, $filename, 600, 800, "");
					}
					resize_image($path_detail, $filename, 140, 140, sprintf("%02d",$img_detail_number)."_s");
				}
			}
		}
		//t_img_around
		$count = 1;
		if($F_item_cd){
			$dh=opendir($path_around);
			while(($entry=readdir($dh))){
				if(!is_dir($path_around."/".$entry)){
					preg_match("/^([0-9]{2}).*\.[^.]+$/", $entry, $A_match);
					$num = sprintf("%01d", $A_match[1]);
					if(!in_array($num, $F_num_around)){
						unlink($path_around."/".$entry);
					}
				}
			}
			closedir($dh);
			$sql = "delete from t_img_around where img_around_cd in (select img_around_cd from r_item4 where item_cd='".$F_item_cd."');";
			$sql.= "delete from r_item4 where item_cd='".$F_item_cd."';";
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		for ($i = 0; $i < count($F_uri_around); $i++) {
			if($F_uri_around[$i] or $F_num_around[$i]){
				$img_around_cd = $img_around_sort = make_cd("t_img_around", "img_around_cd", "");
				if($F_num_around[$i]){
					$img_around_number = $F_num_around[$i];
				}else{
					while(in_array($count, $F_num_around)){
						$count++;
					}
					$img_around_number = $count;
					$count++;
				}
				$add_clm_array = array("img_around_cd", "img_around_sort", "img_around_number", "img_around_title", "img_around_cmt");
				$add_value_array = array($img_around_cd, $img_around_sort, $img_around_number, $F_title_around[$i], $F_cmt_around[$i]);
				insert_db_same_name("", "t_img_around", $add_clm_array, $add_value_array);
				//r_item4
				$rel_cd = make_cd("r_item4", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_around_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_around_cd);
				insert_db_same_name("", "r_item4", $add_clm_array, $add_value_array);
				//イメージアップロード
				if(!$F_num_around[$i]){
					if(preg_match("/jpeg/",$F_type_around[$i])){
						$filesuffix = ".jpg";
						$mimeprefix = "data:image/jpeg;base64,";
					}elseif(preg_match("/gif/",$F_type_around[$i])){
						$filesuffix = ".gif";
						$mimeprefix = "data:image/gif;base64,";
					}elseif(preg_match("/png/",$F_type_around[$i])){
						$filesuffix = ".png";
						$mimeprefix = "data:image/png;base64,";
					}
					$filename = sprintf("%02d",$img_around_number).$filesuffix;
					$filepathname = $path_around."/".$filename;
					file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $F_uri_around[$i])));
					$A_size = getimagesize($filepathname);
					$w = $A_size[0];
					$h = $A_size[1];
					if($w >= $h){
						resize_image($path_around, $filename, 800, 600, "");
					}else{
						resize_image($path_around, $filename, 600, 800, "");
					}
					resize_image($path_around, $filename, 290, 190, sprintf("%02d",$img_around_number)."_s");
				}
			}
		}
	}
	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
	if($F_item_cd or $F_copy){
		foreach ($_SESSION['status'] as $name => $cd) {
			$A_param[] = $name."=".$cd;
		}
		$param = implode("&", $A_param);
		unset($_SESSION['status']);
		header("location:/item/?md=list&".$param);
	}else{
		unset($_SESSION['status']);
		header("location:/item/?md=regist");
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
