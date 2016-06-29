<?php
//-- configインクルード --//
//include("config.php");
include("_common/config.php");
//--ステータス--//
check_login();

header("location:/public_html_admin/item/");
exit;


//-- .inc --//
include("header.inc");
include($inc);
include("footer.inc");
exit;
?>
