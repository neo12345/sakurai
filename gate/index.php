<?php
//-- configã‚¤ãƒ³ã‚¯ãƒ«ãƒ¼ãƒ‰ --//
//include("config.php");
include ('/../_common/config.php');
//--ã‚¹ãƒ†ãƒ¼ã‚¿ã‚¹--//
//check_login();

switch($F_md){
	case "in":
		if($F_user_id and $F_user_pw){
			$sql="select * from m_user";
			$sql.=" where user_id='".$F_user_id."' and user_pw='".$F_user_pw."'";
			$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
			$RS_user=convert_rs($rs);

			if($RS_user[0]['user_cd']){
				$_SESSION['user_cd']=$RS_user[0]['user_cd'];
			}else{
				$error_message="IDã?‹ãƒ‘ã‚¹ãƒ¯ãƒ¼ãƒ‰ã?Œé–“é?•ã?£ã?¦ã?„ã?¾ã?™ã€‚";
				include("common_error.inc");
				exit;
			}
			if($S_referer){
				header("location:".$S_referer."");
				exit;
			}else{
				header("location:".$G_root_url_s."/item/");
				exit;
			}
		}else{
			$error_message="å…¥åŠ›æ¼?ã‚Œã?Œã?‚ã‚Šã?¾ã?™ã€‚";
			include("common_error.inc");
			exit;
		}
	break;

	case "out":
		unset($_SESSION['user_cd']);
		unset($_SESSION['referer']);
		header("location:".$G_root_url_s."/gate/");
		exit;
	break;

	default :
		if($_SESSION['user_cd']){
			header("location:".$G_root_url_s."/");
			exit;
		}
	break;
}

//-- .inc --//
include("index.inc");
exit;
?>
