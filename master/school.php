<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();

if(!$F_md){$F_md="city";}

switch($F_md){
	case "make_main":
		get_rs("m_school", "", "school_cd='".$F_school_cd."'", "school_sort asc");
		$school_table = $RS[0]['school_table'];
		$school_table_v = str_replace("m_school", "v_school", $school_table);
		$school_initial = $RS[0]['school_initial'];
		$school_initial2 = $RS[0]['school_initial2'];
		if($F_school_cd==1){ $dir=$G_up_path."/school/primary"; }elseif($F_school_cd==2){ $dir=$G_up_path."/school/junior"; }elseif($F_school_cd==3){ $dir=$G_up_path."/school/high"; }
		get_rs($school_table_v, "school", "", $school_initial."_sort asc");
		for ($i = 0; $i < count($RS_school); $i++) {
			if($RS_school[$i]['flg_active']){ $checked="checked"; }else{ $checked=""; }
			$A_html[] = '<tr class="js_colum">';
			$A_html[].= '<td>'.$RS_school[$i][$school_initial.'_cd'].'';
			$A_html[].= '<input type="hidden" class="js_school_cd" value="'.$RS_school[$i][$school_initial.'_cd'].'" />';
			$A_html[].= '<input type="hidden" class="js_school_table" value="'.$school_table.'" />';
			$A_html[].= '<input type="hidden" class="js_school_initial" value="'.$school_initial.'" />';
			$A_html[].= '</td>';
			$A_html[].= '<td>'.$RS_school[$i][$school_initial.'_name'].'</td>';
			$A_html[].= '<td>'.$RS_school[$i]['cat_'.$school_initial2.'_name'].'</td>';
			$A_html[].= '<td><input class="js_active" type="checkbox" value="1" '.$checked.' /></td>';
			if(file_exists_expression($dir, sprintf("%03d", $RS_school[$i][$school_initial.'_cd'])."\..*")){
				$A_html[].= '<td class="image js_drop"><input type="button" class="js_view js_dialog_open" rel="view" value="画" /></td>';
			}else{
				$A_html[].= '<td class="image js_drop"><input type="button" class="js_view btngray" rel="view" value="画" /></td>';
			}
			$A_html[].= '<td class="edit"><input type="button" rel="edit" value="編" /></td>';
			$A_html[].= '</tr>';
		}
		$html = implode("\n", $A_html);
		echo($html);
		exit;
		break;

	case "switch_active":
		$sql = "update ".$F_school_table." set flg_active='".$F_flg_active."'";
		$sql.=" where ".$F_school_initial."_cd='".$F_school_cd."'";
		$sql = sql_convert_null($sql);
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		echo(true);
		exit;
		break;

	case "up_image":
		if($F_m_school_cd==1){ $img_path=$G_up_path."/school/primary"; }elseif($F_m_school_cd==2){ $img_path=$G_up_path."/school/junior"; }elseif($F_m_school_cd==3){ $img_path=$G_up_path."/school/high"; }
		$A_img[] = array('name'=>sprintf("%03d", $F_school_cd)."_s", 'type'=>$F_img_type, 'uri'=>$F_img_uri, 'width'=>290, 'height'=>190, 'exist'=>$F_img_exist, 'flg_notrim'=>"");
		$A_img[] = array('name'=>sprintf("%03d", $F_school_cd), 'type'=>$F_img_type, 'uri'=>$F_img_uri, 'width'=>800, 'height'=>600, 'exist'=>$F_img_exist, 'flg_notrim'=>"");
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
		
						
//if($F_regist){
//	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
//	$sql = "delete from r_city2 where city_cd='".$F_city_cd."'";
//	$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
//	$F_link_city_cd = array_unique($F_link_city_cd);
//	for ($i = 0; $i < count($F_link_city_cd); $i++) {
//		if($F_link_city_cd[$i] != $F_city_cd){
//			$rel_cd = make_cd("r_city2", "rel_cd", "");
//			$add_clm_array = array("rel_cd", "city_cd", "link_city_cd");
//			$add_value_array = array($rel_cd, $F_city_cd, $F_link_city_cd[$i]);
//			insert_db_same_name("", "r_city2", $add_clm_array, $add_value_array);
//		}
//	}
//	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
//	header("location:/master/?md=city&pref_cd=".$F_pref_cd);
//	exit;
//}

//-- .inc --//
include("header.inc");
include($inc);
include("footer.inc");
exit;
?>
