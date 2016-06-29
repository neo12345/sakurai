<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();

if(!$F_md){$F_md="info";}

switch($F_md){
	case "list":
		$flg_jquery = "1";
		$id_body = "contents";
		$inc = "list.inc";
		//get_rs("v_item", "item", "", "item_sort desc");
		break;

	case "select":
		$flg_jquery = "1";
		$flg_js_select = "1";
		$id_body = "contents";
		$inc = "select.inc";
		get_rs("v_recommend", "reco", "", "reco_sort asc", "");
		break;

	case "youtube":
		$flg_jquery = "1";
		$flg_js_youtube = "1";
		$id_body = "contents";
		$inc = "youtube.inc";
		get_rs("v_youtube", "yout", "", "yout_sort asc", "");
		break;

	case "info":
		$flg_jquery = "1";
		$flg_js_info = "1";
		$flg_js_datepicker = "1";
		$id_body = "contents";
		$inc = "info.inc";
		get_rs("t_info", "info", "", "info_date desc");
		break;

	case "blog":
		$flg_jquery = "1";
		$flg_js_blog = "1";
		$flg_js_datepicker = "1";
		$id_body = "contents";
		$inc = "blog.inc";
		get_rs("t_blog", "blog", "blog_cd='1'");
		break;

	case "review":
		$flg_jquery = "1";
		$id_body = "contents";
		$inc = "review.inc";
		//get_rs("v_item", "item", "", "item_sort desc");
		break;

	default :
		break;
}

if($F_regist){
	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
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
		update_db_same_name($_REQUEST, "t_item", $add_clm_array="", $add_value_array="", "item_cd='".$F_item_cd."'");
	}else{
		$item_cd = $item_sort = make_cd("t_item", "item_cd", "");
		$add_clm_array = array("item_cd", "item_sort", "date_regist");
		$add_value_array = array($item_cd, $item_sort, date("Y-m-d H:i:s"));
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
	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
	if($F_item_cd){
		header("location:/item/?md=list");
	}else{
		header("location:/item/?md=regist");
	}
	exit;
}

//-- .inc --//
include("header.inc");
include($inc);
include("footer.inc");
exit;
?>
