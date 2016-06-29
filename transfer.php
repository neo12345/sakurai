<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
//check_login();


switch($F_md){
	
	case "history":
		
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼

//		get_rs("v_item", "item", "", "item_cd asc");
		
		for ($i = 0; $i < count($RS_item); $i++) {
			
			$item_cd = $RS_item[$i]['item_cd'];

			get_rs("t_history_price", "hist_price", "hist_price_cd in (select hist_price_cd from r_item11 where item_cd = ".$item_cd.")", "hist_price_date asc");
			
			for ($j = 0; $j < count($RS_hist_price); $j++) {
				
				//t_history
				$hist_cd = $hist_sort = make_cd("t_history", "hist_cd", "");
				$hist_price = $RS_hist_price[$j]['hist_price_value'];
				$date_regist = $RS_hist_price[$j]['hist_price_date'];
				$add_clm_array = array("hist_cd", "hist_sort", "hist_price", "date_regist");
				$add_value_array = array($hist_cd, $hist_sort, $hist_price, $date_regist);
				insert_db_same_name("", "t_history", $add_clm_array, $add_value_array);
				//r_history
				$rel_cd = make_cd("r_history", "rel_cd", "");
				if($j){
					$stat_cd = 2;
				}else{
					$stat_cd = 1;
				}
				$add_clm_array = array("rel_cd", "item_cd", "hist_cd", "stat_cd");
				$add_value_array = array($rel_cd, $item_cd, $hist_cd, $stat_cd);
				insert_db_same_name("", "r_history", $add_clm_array, $add_value_array);

			}
			
		}

		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲

		break;
	
		
	case "condition":
		
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼

		get_rs("v_item", "item", "", "item_cd asc");
		
		for ($i = 0; $i < count($RS_item); $i++) {
			
			$item_cd = $RS_item[$i]['item_cd'];
			$flg_new = $RS_item[$i]['flg_new'];
			
			if($flg_new){
				$condition_cd = 1;
			}else{
				$condition_cd = 2;
			}

			$add_clm_array = array("condition_cd");
			$add_value_array = array($condition_cd);
			update_db_same_name("", "r_item1", $add_clm_array, $add_value_array, "item_cd='".$item_cd."'");
			
		}

		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲

		break;
	
}



//-- .inc --//
//include("header.inc");
//include($inc);
//include("footer.inc");
exit;
?>
