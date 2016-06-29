<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();


switch($F_md){
	case "make_main":
		$dir=$G_up_path."/stop";
		get_rs("v_stop", "stop", "pubtrans_cd='".$F_pubtrans_cd."'", "stop_sort desc");
		for ($i = 0; $i < count($RS_stop); $i++) {
			$A_html[] = '<tr class="js_colum">';
			$A_html[].= '<td>'.$RS_stop[$i]['stop_cd'].'';
			$A_html[].= '<input type="hidden" class="js_stop_cd" value="'.$RS_stop[$i]['stop_cd'].'" />';
			$A_html[].= '</td>';
			$A_html[].= '<td>'.$RS_stop[$i]['stop_name'].'';
			$A_html[].= '<input type="hidden" class="js_stop_name" value="'.$RS_stop[$i]['stop_name'].'" />';
			$A_html[].= '</td>';
			if(file_exists_expression($dir, sprintf("%04d", $RS_stop[$i]['stop_cd'])."\..*")){
				$A_html[].= '<td class="image js_drop"><input type="button" class="js_view js_dialog_open" rel="view" value="画" /></td>';
			}else{
				$A_html[].= '<td class="image js_drop"><input type="button" class="js_view btngray" rel="view" value="画" /></td>';
			}
			$A_html[].= '<td class="edit"><input type="button" class="js_edit" value="編" /></td>';
			$A_html[].= '<td class="del"><p class="js_delete">削除</p></td>';
			$A_html[].= '</tr>';
		}
		$html = implode("\n", $A_html);
		echo($html);
		exit;
		break;

	case "search_name":
		get_rs("v_stop", "stop", "stop_name LIKE '%".$F_stop_name."%'", "stop_sort desc");
		if($RS_stop){
			$json = json_encode($RS_stop);
			echo($json);
		}else{
			echo(false);
		}
		exit;
		break;

	case "regist_stop":
		//$stop_cd = get_colum_key("m_stop", "stop_name", $F_stop_name, "stop_cd", "stop_cd in (select stop_cd from r_pubtrans1 where pubtrans_cd='".$F_pubtrans_cd."')");
		$stop_cd = "";
		if(!$stop_cd){
			$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
			//m_stop
			$stop_cd = $stop_sort = make_cd("m_stop", "stop_cd", "");
			$add_clm_array = array("stop_cd", "stop_sort", "stop_name");
			$add_value_array = array($stop_cd, $stop_sort, $F_stop_name);
			insert_db_same_name("", "m_stop", $add_clm_array, $add_value_array);
			//r_pubtrans1
			$rel_cd = make_cd("r_pubtrans1", "rel_cd", "");
			$add_clm_array = array("rel_cd", "stop_cd", "pubtrans_cd");
			$add_value_array = array($rel_cd, $stop_cd, $F_pubtrans_cd);
			insert_db_same_name("", "r_pubtrans1", $add_clm_array, $add_value_array);
			$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
			echo($stop_cd);
		}else{
			echo(false);
		}
		exit;
		break;

	case "delete_stop":
		get_rs("v_item", "item", "item_cd in (select item_cd from r_item2 where stop_cd='".$F_stop_cd."')", "item_sort asc");
		if(!$RS_item){
			$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
			$sql = "delete from m_stop where stop_cd='".$F_stop_cd."';";
			$sql.= "delete from r_pubtrans1 where stop_cd='".$F_stop_cd."';";
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
			$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
			echo(true);
		}else{
			echo(false);
		}
		exit;
		break;

	case "check_link":
		get_rs("v_item", "item", "item_cd in (select item_cd from r_item2 where stop_cd='".$F_stop_cd."')", "item_sort asc");
		if($RS_item){
			echo(false);
		}else{
			echo(true);
		}
		exit;
		break;

	case "up_image":
		$img_path=$G_up_path."/stop";
		$A_img[] = array('name'=>sprintf("%04d", $F_stop_cd)."_s", 'type'=>$F_img_type, 'uri'=>$F_img_uri, 'width'=>290, 'height'=>190, 'exist'=>$F_img_exist, 'flg_notrim'=>"");
		$A_img[] = array('name'=>sprintf("%04d", $F_stop_cd), 'type'=>$F_img_type, 'uri'=>$F_img_uri, 'width'=>800, 'height'=>600, 'exist'=>$F_img_exist, 'flg_notrim'=>"");
		for($i = 0; $i<count($A_img); $i++){
			rm_file($img_path."/".$A_img[$i]['name'].".*");
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
			$filepathname = $img_path."/".$filename;
			if($A_img[$i]['uri']){
				$uri = str_replace($mimeprefix, "", $A_img[$i]['uri']);
				$uri = str_replace(" ", "+", $uri);
				file_put_contents($filepathname,base64_decode($uri));
				$A_size = getimagesize($filepathname);
				$w = $A_size[0];
				$h = $A_size[1];
				if($w >= $h){
					$width = $A_img[$i]['width'];
					$height = $A_img[$i]['height'];
				}else{
					$width = $A_img[$i]['height'];
					$height = $A_img[$i]['width'];
				}
				resize_image($img_path, $filename, $width, $height, "", $A_img[$i]['flg_notrim']);
			}
		}
		echo(true);
		exit;
		break;

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
