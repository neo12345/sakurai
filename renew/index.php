<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();

//--ステータス--//
$inc = "index.inc";

//-- .inc --//
include("re_header.inc");
include("re_side.inc");
include($inc);
include("re_footer.inc");
exit;
?>
