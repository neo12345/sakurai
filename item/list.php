<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "del_item":
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
		$sql = "delete from t_img_detail where img_detail_cd in (select img_detail_cd from r_item3 where item_cd='".$F_item_cd."');";
		$sql.= "delete from t_img_around where img_around_cd in (select img_around_cd from r_item4 where item_cd='".$F_item_cd."');";
		$sql.= "delete from t_img_theta where img_theta_cd in (select img_theta_cd from r_item12 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item1 where item_cd='".$F_item_cd."';";
		$sql.= "delete from r_item2 where item_cd='".$F_item_cd."';";
		$sql.= "delete from r_item3 where item_cd='".$F_item_cd."';";
		$sql.= "delete from r_item4 where item_cd='".$F_item_cd."';";
		$sql.= "delete from r_item12 where item_cd='".$F_item_cd."';";
		$sql.= "delete from t_cost where cost_cd in (select cost_cd from r_item5 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item5 where item_cd='".$F_item_cd."';";
		$sql.= "delete from t_size_add where size_add_cd in (select size_add_cd from r_item6 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item6 where item_cd='".$F_item_cd."';";
		$sql.= "delete from t_size_detail where size_detail_cd in (select size_detail_cd from r_item7 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item7 where item_cd='".$F_item_cd."';";
		$sql.= "delete from t_along where along_cd in (select along_cd from r_item8 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item8 where item_cd='".$F_item_cd."';";
		$sql.= "delete from r_item9 where item_cd='".$F_item_cd."';";
		$sql.= "delete from r_item10 where item_cd='".$F_item_cd."';";
		
		$sql.= "delete from t_history where hist_cd in (select hist_cd from r_history where item_cd = ".$F_item_cd.");";
		$sql.= "delete from r_history where item_cd = ".$F_item_cd.";";
		
		$sql.= "delete from t_history_price where hist_price_cd in (select hist_price_cd from r_item11 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item11 where item_cd='".$F_item_cd."';";
		$sql.= "delete from t_item where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		rm_dir($G_up_path."/item/".sprintf("%03d", $F_item_cd));
		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
		echo(true);
		exit;
		break;
	
	case "narrow_search_city":
		if($F_city_cd){
			get_rs("v_item", "item", "city_cd='".$F_city_cd."'", "item_sort desc");
		}else{
			get_rs("v_item", "item", "", "item_sort desc");
		}
		if(count($RS_item)){
			$json = json_encode($RS_item);
			echo($json);
		}else{
			echo(false);
		}
		exit;
		break;

	case "resist_price":
		get_rs("t_item", "item", "item_cd='".$F_item_cd."'", "item_sort asc");
		$item_price_prev = $RS_item[0]['item_price'];
		$item_discount_prev = $RS_item[0]['item_discount'];
		if($RS_item[0]['flg_new']){
			if($item_discount_prev){
				if($F_item_price >= 3500){
					$item_discount = 100;
				}elseif($F_item_price >= 3000){
					$item_discount = 70;
				}elseif($F_item_price >= 1800){
					$item_discount = 50;
				}else{
					$item_discount = 30;
				}
//				if($F_item_price >= 1800){
//					$item_discount = 70;
//				}elseif($F_item_price >= 1500){
//					$item_discount = 50;
//				}else{
//					$item_discount = 30;
//				}
			}else{
				$item_discount = $item_discount_prev;
			}
		}else{
//			if($F_item_price >= 1800){
//				$item_discount = 70;
//			}elseif($F_item_price >= 1500){
//				$item_discount = 50;
//			}else{
//				$item_discount = 30;
//			}
			$item_discount = $item_discount_prev;
		}
		if($item_price_prev > $F_item_price){
			$sql = "update t_item set item_price='".$F_item_price."', item_discount = '".$item_discount."', flg_down='1'";
		}elseif($item_price_prev < $F_item_price){
			$sql = "update t_item set item_price='".$F_item_price."', item_discount = '".$item_discount."', flg_down = null";
		}else{
			$sql = "update t_item set item_price='".$F_item_price."', item_discount = '".$item_discount."'";
		}
		$sql.=" where item_cd='".$F_item_cd."'";
		$sql = sql_convert_null($sql);
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		
		//t_history
		$hist_cd = $hist_sort = make_cd("t_history", "hist_cd", "");
		$add_clm_array = array("hist_cd", "hist_sort", "hist_price", "hist_memo", "date_regist");
		$add_value_array = array($hist_cd, $hist_sort, $F_item_price, "", date("Y-m-d"));
		insert_db_same_name("", "t_history", $add_clm_array, $add_value_array);

		//r_history
		$rel_cd = make_cd("r_history", "rel_cd", "");
		$stat_cd = 2; //価格改定
		$add_clm_array = array("rel_cd", "item_cd", "hist_cd", "stat_cd", "mem_cd", "user_cd");
		$add_value_array = array($rel_cd, $F_item_cd, $hist_cd, $stat_cd, "", "");
		insert_db_same_name("", "r_history", $add_clm_array, $add_value_array);
		
		//t_history_price
		$hist_price_cd = $hist_price_sort = make_cd("t_history_price", "hist_price_cd", "");
		$add_clm_array = array("hist_price_cd", "hist_price_sort", "hist_price_value", "hist_price_date");
		$add_value_array = array($hist_price_cd, $hist_price_sort, $F_item_price, date("Y-m-d"));
		insert_db_same_name("", "t_history_price", $add_clm_array, $add_value_array);
		//r_item11
		$rel_cd = make_cd("r_item11", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "hist_price_cd");
		$add_value_array = array($rel_cd, $F_item_cd, $hist_price_cd);
		insert_db_same_name("", "r_item11", $add_clm_array, $add_value_array);
		echo(true);
		exit;
		break;

	case "switch_status":
		$sql = "update t_item set flg_soldout = null, date_soldout = null, flg_nego = null where item_cd='".$F_item_cd."';";
		switch($F_status_new){
			case "成":
				$sql.= "update t_item set flg_soldout = '1', date_soldout = '".date("Y-m-d")."' where item_cd='".$F_item_cd."';";
        $hist_cd = $hist_sort = make_cd("t_history", "hist_cd", "");
        $item_price = get_colum_key("t_item", "item_cd", $F_item_cd, "item_price", "");
        $sql.= "insert into t_history (hist_cd, hist_sort, hist_price, date_regist) values (".$hist_cd.", ".$hist_sort.", '".$item_price."', '".date("Y-m-d")."');";
        $rel_cd = make_cd("r_history", "rel_cd", "");
        $stat_cd = 6; //成約
        $sql.= "insert into r_history (rel_cd, item_cd, hist_cd, stat_cd) values (".$rel_cd.", ".$F_item_cd.", ".$hist_cd.", ".$stat_cd.");";
				break;
			case "商":
				$sql.= "update t_item set flg_nego = '1' where item_cd='".$F_item_cd."';";
        $hist_cd = $hist_sort = make_cd("t_history", "hist_cd", "");
        $item_price = get_colum_key("t_item", "item_cd", $F_item_cd, "item_price", "");
        $sql.= "insert into t_history (hist_cd, hist_sort, hist_price, date_regist) values (".$hist_cd.", ".$hist_sort.", '".$item_price."', '".date("Y-m-d")."');";
        $rel_cd = make_cd("r_history", "rel_cd", "");
        $stat_cd = 3; //商談
        $sql.= "insert into r_history (rel_cd, item_cd, hist_cd, stat_cd) values (".$rel_cd.", ".$F_item_cd.", ".$hist_cd.", ".$stat_cd.");";
        break;
			case "販":
        get_rs("v_history", "hist", "item_cd = ".$F_item_cd, "hist_cd desc");
        if($RS_hist[0]['stat_cd'] == 6){
          $sql.= "delete from t_history where hist_cd = ".$RS_hist[0]['hist_cd'].";";
          $sql.= "delete from r_history where hist_cd = ".$RS_hist[0]['hist_cd'].";";
          $rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
        }
        $hist_cd = $hist_sort = make_cd("t_history", "hist_cd", "");
        $item_price = get_colum_key("t_item", "item_cd", $F_item_cd, "item_price", "");
        $sql.= "insert into t_history (hist_cd, hist_sort, hist_price, date_regist) values (".$hist_cd.", ".$hist_sort.", '".$item_price."', '".date("Y-m-d")."');";
        $rel_cd = make_cd("r_history", "rel_cd", "");
        $stat_cd = 4; //再販
        $sql.= "insert into r_history (rel_cd, item_cd, hist_cd, stat_cd) values (".$rel_cd.", ".$F_item_cd.", ".$hist_cd.", ".$stat_cd.");";
        break;
		}
		$sql = sql_convert_null($sql);
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);

		echo(true);
		exit;
		break;

	default :
		exit;
		break;
}

exit;
?>
