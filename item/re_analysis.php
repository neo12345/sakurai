<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
//	case "narrow_search_city":
//		if($F_city_cd){
//			get_rs("v_item", "item", "city_cd='".$F_city_cd."'", "item_sort desc");
//		}else{
//			get_rs("v_item", "item", "", "item_sort desc");
//		}
//		if(count($RS_item)){
//			$json = json_encode($RS_item);
//			echo($json);
//		}else{
//			echo(false);
//		}
//		exit;
//		break;

	default :
		exit;
		break;
}

exit;
?>
