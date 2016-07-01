<?php
//------------------------------------------------------//
// common configuration
//------------------------------------------------------//
//debug flag(1=debug)
$G_is_debug=1;
//------------------------------------------------------//
//session_start
if(!$flg_cron){
	session_cache_limiter("none");
	session_start();
}
//------------------------------------------------------//
//DB setting
$G_is_pear=1;
if($G_is_pear){
	include_once("DB.php");
}
$G_db_type   = "pgsql";  //PostgreSQL=pgsql, MySQL="mysql", ....
$G_db_user   = "ominext";
$G_db_passwd = "ominext";
$G_db_name   = "ominext_realestate_db";
define("MAIN_DSN","pgsql://".$G_db_user.":".$G_db_passwd."@localhost/".$G_db_name."");
//------------------------------------------------------//
//including
include_once("func_global.php");
include_once("func_db.php");
include_once("func_naru.php");
include_once("func_smile.php");
include_once("class_image.php");
//------------------------------------------------------//
//other
$db = get_db_conn();
set_outer_param();
//------------------------------------------------------//
//URL,dir,path
$scheme_n="http://";
$scheme_s="http://";  //<-SSL
$G_domain="smile-fudosan.com";
$domain_n  ="ominext-admin.".$G_domain;
$domain_s  ="ominext-admin.".$G_domain;
$path         ="";
$dir          =$_SERVER["DOCUMENT_ROOT"];

$G_root_url   =$scheme_n.$domain_n.$path;
$G_root_url_s =$scheme_s.$domain_s.$path;
$G_root_dir   ="/";
$G_root_path  =$dir.$path;

$G_img_dir    ="/_img".$path;
$G_img_url    =$scheme_n.$domain_n.$G_img_dir;
$G_img_url_s  =$scheme_s.$domain_s.$G_img_dir;
$G_img_path   =$dir.$G_img_dir;

$G_css_dir    ="/_css".$path;
$G_css_url    =$scheme_n.$domain_n.$G_css_dir;
$G_css_url_s  =$scheme_s.$domain_s.$G_css_dir;
$G_css_path   =$dir.$G_css_dir;

$G_js_dir    ="/_js".$path;
$G_js_url    =$scheme_n.$domain_n.$G_js_dir;
$G_js_url_s  =$scheme_s.$domain_s.$G_js_dir;
$G_js_path   =$dir.$G_js_dir;

$G_up_dir    ="/_up".$path;
$G_up_url    =$scheme_n.$domain_n.$G_up_dir;
$G_up_url_s  =$scheme_s.$domain_s.$G_up_dir;
$G_up_path   =$dir.$G_up_dir;
//------------------------------------------------------//
$G_corp_name ="株式会社住まいるホーム";
$G_site_name ="株式会社住まいるホーム コントロールパネル";
$G_mail_return="info@".$G_domain;
$G_mail_info="info@".$G_domain;
$G_filesize_limit="2000";
//------------------------------------------------------//
G_tax = 8;
$G_limit_day_soldout = "14"; //成約済み表示する期間
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
?>