<?php
function check_login(){
	if($_SESSION['user_cd']){
		return true;
	}else{
		$_SESSION['referer']=$_SERVER['REQUEST_URI'];
        
		header("location:/public_html_admin/gate/");
		exit;
	}
}
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
?>