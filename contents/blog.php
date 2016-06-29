<?php
//-- configインクルード --//
include("config.php");


//--ステータス--//
check_login();



switch($F_md){
	case "up_image":
		switch ($F_st){
			case "blog":
			$img_path = $G_up_path."/blog";
			$A_img[] = array('name'=>"img_blog", 'type'=>$F_img_type, 'uri'=>$F_img_uri, 'width'=>200, 'height'=>"", 'flg_notrim'=>1);
			break;
		}
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
}	

if($F_regist){
	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
	//t_blog
	update_db_same_name($_REQUEST, "t_blog", $add_clm_array, $add_value_array, "blog_cd='1'");
	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
	header("location:/contents/?md=blog");
	exit;
}



exit;
?>
