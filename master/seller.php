<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "make_main":
		get_rs("m_seller", "seller", "", "seller_sort asc");
		for ($i = 0; $i < count($RS_seller); $i++) {
			$A_html[] = '<tr class="js_colum">';
			$A_html[].= '<td>'.$RS_seller[$i]['seller_cd'].'';
			$A_html[].= '<input type="hidden" class="js_seller_cd" value="'.$RS_seller[$i]['seller_cd'].'" />';
			$A_html[].= '</td>';
			$A_html[].= '<td>'.$RS_seller[$i]['seller_name'].'';
			$A_html[].= '<input type="hidden" class="js_seller_name" value="'.$RS_seller[$i]['seller_name'].'" />';
			$A_html[].= '</td>';
			$A_html[].= '<td class="edit"><input type="button" class="js_edit" value="編" /></td>';
			$A_html[].= '<td class=""><div class="js_sort" style="cursor: move;">並替</div></td>';
			$A_html[].= '<td class="del"><p class="js_delete">削除</p></td>';
			$A_html[].= '</tr>';
		}
		$html = implode("\n", $A_html);
		echo($html);
		exit;
		break;

	case "regist_seller":
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
		if($F_seller_cd){
			$sql = "update m_seller set seller_name='".$F_seller_name."', seller_tel='".$F_seller_tel."'";
			$sql.=" where seller_cd='".$F_seller_cd."'";
			$sql = sql_convert_null($sql);
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}else{
			//m_seller
			$seller_cd = $seller_sort = make_cd("m_seller", "seller_cd", "");
			$add_clm_array = array("seller_cd", "seller_sort", "seller_name", "seller_tel");
			$add_value_array = array($seller_cd, $seller_sort, $F_seller_name, $F_seller_tel);
			insert_db_same_name("", "m_seller", $add_clm_array, $add_value_array);
		}
		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
		echo(true);
		exit;
		break;

	case "delete_seller":
		get_rs("v_item", "item", "item_cd in (select item_cd from r_item1 where seller_cd='".$F_seller_cd."')", "item_sort asc");
		if(!$RS_item){
			$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
			$sql = "delete from m_seller where seller_cd='".$F_seller_cd."';";
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
			$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
			echo(true);
		}else{
			echo(false);
		}
		exit;
		break;

	case "check_link":
		get_rs("v_item", "item", "item_cd in (select item_cd from r_item1 where seller_cd='".$F_seller_cd."')", "item_sort asc");
		if($RS_item){
			echo(false);
		}else{
			echo(true);
		}
		exit;
		break;

	case "sort":
		sort($F_seller_sort);
		$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
		for ($i = 0; $i < count($F_seller_cd); $i++) {
			$sql = "update m_seller set seller_sort='".$F_seller_sort[$i]."'";
			$sql.=" where seller_cd='".$F_seller_cd[$i]."'";
			$sql = sql_convert_null($sql);
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
		echo(true);
		exit;
		break;

//	case "up_image":
//		$img_path=$G_up_path."/stop";
//		$A_img[] = array('name'=>sprintf("%04d", $F_stop_cd)."_s", 'type'=>$F_img_type, 'uri'=>$F_img_uri, 'width'=>290, 'height'=>190, 'exist'=>$F_img_exist, 'flg_notrim'=>"");
//		$A_img[] = array('name'=>sprintf("%04d", $F_stop_cd), 'type'=>$F_img_type, 'uri'=>$F_img_uri, 'width'=>800, 'height'=>600, 'exist'=>$F_img_exist, 'flg_notrim'=>"");
//		for($i = 0; $i<count($A_img); $i++){
//			rm_file($img_path."/".$A_img[$i]['name'].".*");
//			if(preg_match("/jpeg/",$A_img[$i]['type'])){
//				$filesuffix = ".jpg";
//				$mimeprefix = "data:image/jpeg;base64,";
//			}elseif(preg_match("/gif/",$A_img[$i]['type'])){
//				$filesuffix = ".gif";
//				$mimeprefix = "data:image/gif;base64,";
//			}elseif(preg_match("/png/",$A_img[$i]['type'])){
//				$filesuffix = ".png";
//				$mimeprefix = "data:image/png;base64,";
//			}
//			$filename = $A_img[$i]['name'].$filesuffix;
//			$filepathname = $img_path."/".$filename;
//			if($A_img[$i]['uri']){
//				$uri = str_replace($mimeprefix, "", $A_img[$i]['uri']);
//				$uri = str_replace(" ", "+", $uri);
//				file_put_contents($filepathname,base64_decode($uri));
//				$A_size = getimagesize($filepathname);
//				$w = $A_size[0];
//				$h = $A_size[1];
//				if($w >= $h){
//					$width = $A_img[$i]['width'];
//					$height = $A_img[$i]['height'];
//				}else{
//					$width = $A_img[$i]['height'];
//					$height = $A_img[$i]['width'];
//				}
//				resize_image($img_path, $filename, $width, $height, "", $A_img[$i]['flg_notrim']);
//			}
//		}
//		echo(true);
//		exit;
//		break;

//	case "pic_city":
//		get_rs("v_city", "city", "pref_cd='".$F_pref_cd."'", "city_sort asc");
//		$json = json_encode($RS_city);
//		echo($json);
//		exit;
//		break;
//
//	case "add_list":
//		get_rs("v_city", "city", "city_cd='".$F_city_cd."'", "city_sort asc");
//		if($RS_city){
//			$json = json_encode($RS_city);
//		}else{
//			$json = false;
//		}
//		echo($json);
//		exit;
//		break;
//
//	case "get_name":
//		get_rs("v_city", "city", "city_cd='".$F_city_cd."'", "city_sort asc");
//		$data = $RS_city[0]['pref_name']." ".$RS_city[0]['city_name'];
//		echo($data);
//		exit;
//		break;
//
//	case "make_list":
//		get_rs("v_link_city", "link_city", "city_cd='".$F_city_cd."'", "link_city_sort asc");
//		if($RS_link_city){
//			$json = json_encode($RS_link_city);
//		}else{
//			$json = false;
//		}
//		echo($json);
//		exit;
//		break;
}	


//-- .inc --//
include("header.inc");
include($inc);
include("footer.inc");
exit;
?>
