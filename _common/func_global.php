<?php
//------------------------------------------------------//
function _raise($location,$msg,$kind="function"){
	$format  ="<b style=\"color:#FF0000;\">ERROR!!</b> : [".$kind." <b>%s</b>]<br><div style=\"font-size:10pt;\">%s</div>";

	if($GLOBALS["G_is_debug"]){
		echo("<div style=\"font-family:'Courier New' font-size:15pt; border:3px double #FF0000; padding:5px; text-align:left; width:80%;\">");
		echo(sprintf($format,$location,$msg));
		echo('</div>');
	}else{
		$a[]="Location : ".$location;
		$a[]="Kind     : ".$kind;
		$a[]="Message  : ".$msg;
		$s=implode("\n",$a);
		$s=base64_encode($s);
		$s=wordwrap($s,50,"<br>",1);

		$s="<b style=\"color:#FF0000;\">Fatal Error Has Raised!!</b><br><div style=\"font-size:10pt;\">Error Code:<br>".$s."</div>";

		echo("<div style=\"font-family:'Courier New' font-size:15pt; border:3px double #FF0000; padding:5px; text-align:left; width:80%;\">");
		echo($s);
		echo('</div>');
	}

	exit;
}
//------------------------------------------------------//
function set_outer_param(){
	foreach($_REQUEST as $key=>$value){
		$F="F_".$key;
		global $$F;
		$$F=$value;
	}
	foreach($_SESSION as $key=>$value){
		$S="S_".$key;
		global $$S;
		$$S=$value;
	}
}
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
?>