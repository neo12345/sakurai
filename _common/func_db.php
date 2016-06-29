<?php
//------------------------------------------------------//
function get_db_conn(){
	$func="get_db_conn";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!defined("MAIN_DSN"))  {_raise($func,"DBæŽ¥ç¶šå®šæ•° '<b>MAIN_DSN</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}

	if($GLOBALS["G_is_pear"]){
		$db = DB::connect(MAIN_DSN);
		if (DB::isError($db)) {_raise($func,"DBã?¸ã?®æŽ¥ç¶šã?«å¤±æ•—ã?—ã?¾ã?—ã?Ÿã€‚(".MAIN_DSN.")");}
	}elseif($GLOBALS["G_db_type"]=="pgsql"){
		list(,$s)=explode("://",MAIN_DSN);
		list($s1,$s2)=explode("@",$s);
		list($db_user,$db_pass)=explode(":",$s1);
		list($db_host,$db_name)=explode("/",$s2);

		if($db_user){$conn[]="user=ominext";}
		if($db_pass){$conn[]="password=ominext";}
		if($db_host){$conn[]="host=localhost";}
		if($db_name){$conn[]="dbname=ominext_realestate_db";}
		$conn[]="port=5432";
		$db=pg_connect(implode(" ",$conn));
		if(!$db){_raise($func,"DBã?¸ã?®æŽ¥ç¶šã?«å¤±æ•—ã?—ã?¾ã?—ã?Ÿã€‚(".MAIN_DSN.")");}
	}elseif($GLOBALS["G_db_type"]=="mysql"){




	}else{
		_raise($func,"ä¸?æ­£ã?ª '<b>G_db_type</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¾ã?—ã?Ÿã€‚å…±é€šè¨­å®šãƒ•ã‚¡ã‚¤ãƒ«ã‚’ç¢ºèª?ã?—ã?¦ã??ã? ã?•ã?„ã€‚");
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	'<b>".MAIN_DSN."</b>'ã?¸æŽ¥ç¶šã?—ã?¾ã?—ã?Ÿã€‚";}
	return $db;
}
//------------------------------------------------------//
function exec_sql($db,$sql,$err_place=""){
	$func="exec_sql";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DBæŽ¥ç¶šãƒªã‚½ãƒ¼ã‚¹ '<b>db</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}
	if(!$sql)      {_raise($func,"å¼•æ•° '<b>sql</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	if(preg_match("/^[0-9]+$/",$err_place)){$err_place=$_SERVER["SCRIPT_NAME"]." in <b>line [".$err_place."]</b>";}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	å®Ÿè¡ŒSQLâ†’'<b>".$sql."</b>'";}

	if($GLOBALS["G_is_pear"]){
		$rs=$db->query($sql);
		$err=DB::isError($rs);

		if($err){
			$db->query("rollback");
			$m ='Failed to execute SQL.<br>';
			$a=explode(" ",$sql);
			$s=$a[0];
			$m.='[<b>Activity</b>]'.strtoupper($s).'<br>';
			$m.='[<b>Place</b>]'.$err_place.'<br>';
			$m.="[<b>SQL</b>]".$sql."<br>";
			$m.="[<b>Cause</b>]".$rs->getMessage()."<br>";
			$s=$rs->getUserInfo();
		}
	}elseif($GLOBALS["G_db_type"]=="pgsql"){
		$rs=@pg_query($sql);
		if(!$rs){$err=1;}

		if($err){
			$m ='Failed to execute SQL.<br>';
			$a=explode(" ",$sql);
			$s=$a[0];
			$m.='[<b>Activity</b>]'.strtoupper($s).'<br>';
			$m.='[<b>Place</b>]<b>'.$err_place.'</b><br>';
			$m.="[<b>SQL</b>]".$sql."<br>";
			$m.="[<b>Message</b>]<b>".pg_last_error($db)."</b>";
			$rs=@pg_query("rollback");
		}


	}elseif($GLOBALS["G_db_type"]=="mysql"){

	}else{
		_raise($func,"ä¸?æ­£ã?ª '<b>G_db_type</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¾ã?—ã?Ÿã€‚å…±é€šè¨­å®šãƒ•ã‚¡ã‚¤ãƒ«ã‚’ç¢ºèª?ã?—ã?¦ã??ã? ã?•ã?„ã€‚");
	}

	if ($err) {
		$a=split("(\[|\])",$s);
		$s=$a[1];
		$s=preg_replace("/\'([a-zA-Z0-9_])+?\'/","<b>$0</b>",$s);
		$s=preg_replace("/\"([a-zA-Z0-9_])+?\"/","<b>$0</b>",$s);
		$m.="[<b>Message</b>]".$s."";
		_raise($func,$m);
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	çµ?æžœã‚»ãƒƒãƒˆã‚’å?–å¾—ã?—ã?¾ã?—ã?Ÿã€‚";}
	return $rs;
}
//------------------------------------------------------//
function convert_rs($rs){
	$func="convert_rs";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$rs){_raise($func,"çµ?æžœã‚»ãƒƒãƒˆ '<b>rs</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}

	if($GLOBALS["G_is_pear"]){
		for($i=0; $i<$rs->numRows(); $i++){
			$cv[$i] = $rs->fetchRow(DB_FETCHMODE_ASSOC);
		}
	}elseif($GLOBALS["G_db_type"]=="pgsql"){
		for ($i=0; $i<pg_num_rows($rs); $i++){
			$a=pg_fetch_array($rs,$i);
			unset($t);
			foreach ($a as $k => $v) {if(!ereg("[0-9]+",$k)){$t[$k]=$a[$k];}}
			$cv[$i]=$t;
		}
	}elseif($GLOBALS["G_db_type"]=="mysql"){




	}else{
		_raise($func,"ä¸?æ­£ã?ª '<b>G_db_type</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¾ã?—ã?Ÿã€‚å…±é€šè¨­å®šãƒ•ã‚¡ã‚¤ãƒ«ã‚’ç¢ºèª?ã?—ã?¦ã??ã? ã?•ã?„ã€‚");
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	çµ?æžœã‚»ãƒƒãƒˆã‚’".count($cv)."ä»¶å¤‰æ?›ã?—ã?¾ã?—ã?Ÿã€‚";}
	return $cv;
}
//------------------------------------------------------//
function get_record_count($db,$table,$condition=""){
	$func="get_record_count";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DBæŽ¥ç¶šãƒªã‚½ãƒ¼ã‚¹ '<b>db</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}
	if(!$table)    {_raise($func,"å¼•æ•° '<b>table</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	$sql="select count(*) as count from ".$table." ".$condition;

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get count from '<b>".$table."</b>'");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,count($rs));
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	å?–å¾—ã?—ã?Ÿãƒ¬ã‚³ãƒ¼ãƒ‰æ•°ã?¯".$rs[0]["count"]."ä»¶ã?§ã?™ã€‚";}
	return $rs[0]["count"];
}
//------------------------------------------------------//
function db_get($db,$table,&$count,$condition="",$order="",$offset=0,$limit=0,$fields=array()){
	$func="db_get";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DBæŽ¥ç¶šãƒªã‚½ãƒ¼ã‚¹ '<b>db</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}
	if(!$table)    {_raise($func,"å¼•æ•° '<b>table</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	if(count($fields)){$fld=implode(", ",$fields);}else{$fld="*";}

	if($limit){
		if($GLOBALS["G_db_type"]=="pgsql")    {$lim="offset ".$offset." limit ".$limit.";";}
		elseif($GLOBALS["G_db_type"]=="mysql"){$lim="limit ".$offset.",".$limit;}
	}else{
		$lim="";
	}

	$prefix ="select ".$fld." from ".$table." ";
	$suffix =" ".$condition;

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$count=get_record_count($db,$table,$suffix);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	ãƒ¬ã‚³ãƒ¼ãƒ‰ã‚’ã‚«ã‚¦ãƒ³ãƒˆã?—ã?¾ã?—ã?Ÿã€‚â†’ã€‚".$count."ä»¶";}

	$sql = $prefix.$suffix." ".$order." ".$lim;

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get db data from '<b>".$table."</b>'");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,$count,$limit);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	çµ?æžœã‚»ãƒƒãƒˆã‚’".count($rs)."ä»¶å?–å¾—ã?—ã?¾ã?—ã?Ÿã€‚";}

	return $rs;
}
//------------------------------------------------------//
function _set_sql_info($func,$sql,$count=0,$limit=0){  //privete
	$GLOBALS["LCL_SQL"].="\n";
	$GLOBALS["LCL_SQL"].="Call From   : ".$func."\n";
	$GLOBALS["LCL_SQL"].="Excuted SQL : ".$sql."\n";
	if($count){$GLOBALS["LCL_SQL"].="Totla Rows  : ".$count."\n";}
	if($limit){$GLOBALS["LCL_SQL"].="Limit       : ".$limit."\n";}
}

//------------------------------------------------------//
function get_max_code($db,$table,$code,$condition=""){
	$func="get_max_code";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DBæŽ¥ç¶šãƒªã‚½ãƒ¼ã‚¹ '<b>db</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}
	if(!$table)    {_raise($func,"å¼•æ•° '<b>table</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}
	if(!$code)     {_raise($func,"å¼•æ•° '<b>code</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	$sql="select max(".$code.") as max from ".$table." ".$condition." ";

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get max record of '<b>".$table."</b>'");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,count($rs));
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	$max=$rs[0]["max"]+1;

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	å¯¾è±¡ãƒ•ã‚£ãƒ¼ãƒ«ãƒ‰ã?®æœ€å¤§å€¤ã?¯'<b>".$max."</b>'ã?§ã?™ã€‚";}
	return $max;
}

//------------------------------------------------------//
function db_add_record_sql($db,$table,$prefix="F_"){
	$func="db_add_record_sql";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DBæŽ¥ç¶šãƒªã‚½ãƒ¼ã‚¹ '<b>db</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}
	if(!$table)    {_raise($func,"å¼•æ•° '<b>table</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	$str_regx="time|date|char|text";

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$cols=get_column_list($db,$table,"",false);
	$type=get_column_list($db,$table,"",true);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	for($i=0; $i<count($cols); $i++){
		$s=$prefix.$cols[$i];
		if(!isset($GLOBALS[$s]))     {$ex[]=$cols[$i]; $GLOBALS["LCL_LOGS"][]="%msg%	ãƒ•ã‚£ãƒ¼ãƒ«ãƒ‰'<b>".$cols[$i]."</b>'ã?¯å¯¾å¿œã?™ã‚‹å¤‰æ•°ã?Œè¦‹ã?¤ã?‹ã‚‰ã?ªã?‹ã?£ã?Ÿã?Ÿã‚?ã€?SQLæ–‡ã?®ç”Ÿæˆ?ã‚’é™¤å¤–ã?—ã?¾ã?—ã?Ÿã€‚"; continue;}
		if(ereg($str_regx,$type[$i])){$ins[]="'".$GLOBALS[$s]."'";}
		else{
			if($GLOBALS[$s]==="" || $GLOBALS[$s]===null){$GLOBALS[$s]="null";}
			$ins[]=$GLOBALS[$s];
		}
	}

	$sql ="insert into ".$table." (";

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$sql.=get_column_list($db,$table,", ",false,$ex);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	$sql.=") values(".implode(",",$ins).")";

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	SQLæ–‡'<b>".$sql."</b>'ã‚’ç”Ÿæˆ?ã?—ã?¾ã?—ã?Ÿã€‚";}
	return $sql;
}

//------------------------------------------------------//
function get_column_list($db,$table,$sep="",$is_type=false,$except=array()){
	$func="get_column_list";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DBæŽ¥ç¶šãƒªã‚½ãƒ¼ã‚¹ '<b>db</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}
	if(!$table)    {_raise($func,"å¼•æ•° '<b>table</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	if($GLOBALS["G_db_type"]=="pgsql"){
		$fld="field";
		$typ="type";
		$sql="select a.attname as field, format_type(a.atttypid, a.atttypmod) as type, a.attnotnull, a.atthasdef, a.attnum from pg_class c, pg_attribute a where c.relname = '".$table."' and a.attnum > 0 and a.attrelid = c.oid order by a.attnum;";
	}elseif($GLOBALS["G_db_type"]=="mysql"){
		$fld="Field";
		$typ="Type";
		$sql="show columns from ".$table;
	}else{
		_raise($func,"ä¸?æ­£ã?ª '<b>G_db_type</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¾ã?—ã?Ÿã€‚å…±é€šè¨­å®šãƒ•ã‚¡ã‚¤ãƒ«ã‚’ç¢ºèª?ã?—ã?¦ã??ã? ã?•ã?„ã€‚");
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get '<b>".$table."</b>' column list");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,count($rs));
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	if(!count($rs)) {_raise($func,"DBã?«ãƒ¬ã‚³ãƒ¼ãƒ‰ã?Œå­˜åœ¨ã?—ã?¾ã?›ã‚“ã€‚");}
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	ãƒ†ãƒ¼ãƒ–ãƒ«ã?®æ§‹é€ ã‚’å?–å¾—ã?—ã?¾ã?—ã?Ÿã€‚";}

	if($is_type){
		for ($i=0; $i<count($rs); $i++){
			if(!in_array($rs[$i][$fld],$except)){$arr[]=$rs[$i][$typ];}
		}
		if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	ãƒ•ã‚£ãƒ¼ãƒ«ãƒ‰ã?®åž‹æƒ…å ±ãƒªã‚¹ãƒˆã‚’ç”Ÿæˆ?ã?—ã?¾ã?—ã?Ÿã€‚";}

	}else{
		for ($i=0; $i<count($rs); $i++){
			if(!$except){$except=array();}
			if(!in_array($rs[$i][$fld],$except)){$arr[]=$rs[$i][$fld];}
		}
		if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	ãƒ•ã‚£ãƒ¼ãƒ«ãƒ‰å??ãƒªã‚¹ãƒˆã‚’ç”Ÿæˆ?ã?—ã?¾ã?—ã?Ÿã€‚";}
	}

	if($sep){return implode($sep,$arr); if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	ç”Ÿæˆ?ã?•ã‚Œã?Ÿãƒªã‚¹ãƒˆâ†’'<b>".implode($sep,$arr)."</b>'";}}
	else    {return $arr;               if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	ç”Ÿæˆ?ã?•ã‚Œã?Ÿãƒªã‚¹ãƒˆâ†’'<b>".implode($sep,",")."</b>'ãƒªã‚¹ãƒˆã?¯é…?åˆ—ã?§è¿”ã?•ã‚Œã?¾ã?—ã?Ÿã€‚";}}
}

//------------------------------------------------------//
function db_change_record_sql($db,$table,$condition="",$prefix="F_",$except=array(),$change=array()){
	$func="db_change_record_sql";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DBæŽ¥ç¶šãƒªã‚½ãƒ¼ã‚¹ '<b>db</b>' ã?Œè¦‹ã?¤ã?‹ã‚Šã?¾ã?›ã‚“ã€‚");}
	if(!$table)    {_raise($func,"å¼•æ•° '<b>table</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}
	if(!count($except) && !count($change))  {_raise($func,"å¼•æ•° '<b>except</b>' ã?¨ '<b>change</b>' ã?®ä¸¡æ–¹ã?¨ã‚‚æŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	$str_regx="time|date|char|text";


	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$cols=get_column_list($db,$table,"",false);
	$type=get_column_list($db,$table,"",true);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	for($i=0; $i<count($cols); $i++){
		$s=$prefix.$cols[$i];
		if(!isset($GLOBALS[$s])){$GLOBALS["LCL_LOGS"][]="%msg%	ãƒ•ã‚£ãƒ¼ãƒ«ãƒ‰'<b>".$cols[$i]."</b>'ã?¯å¯¾å¿œã?™ã‚‹å¤‰æ•°ã?Œè¦‹ã?¤ã?‹ã‚‰ã?ªã?‹ã?£ã?Ÿã?Ÿã‚?ã€?SQLæ–‡ã?®ç”Ÿæˆ?ã‚’é™¤å¤–ã?—ã?¾ã?—ã?Ÿã€‚"; continue;}

		if(count($except)){
			if(in_array($cols[$i],$except)){$GLOBALS["LCL_LOGS"][]="%msg%	ãƒ•ã‚£ãƒ¼ãƒ«ãƒ‰'<b>".$cols[$i]."</b>'ã?¯SQLæ–‡ã?®ç”Ÿæˆ?ã?‹ã‚‰é™¤å¤–ã?•ã‚Œã?¾ã?—ã?Ÿã€‚"; continue;}
			else{
				if(ereg($str_regx,$type[$i])){
					//if($GLOBALS[$s]==="null"){$set[]=$cols[$i]."=".$GLOBALS[$s];}
					if($GLOBALS[$s]==="null"){$set[]=$cols[$i]."=".$GLOBALS[$s];}
					else                     {$set[]=$cols[$i]."="."'".$GLOBALS[$s]."'";}
				}else{
					if($GLOBALS[$s]==="" || $GLOBALS[$s]===null){$GLOBALS[$s]="null";}
					$set[]=$cols[$i]."=".$GLOBALS[$s];
				}
			}
		}else{
			if(in_array($cols[$i],$change)){
				if(ereg($str_regx,$type[$i])){
					//if($GLOBALS[$s]==="null"){$set[]=$cols[$i]."=".$GLOBALS[$s];}
					if($GLOBALS[$s]==="null"){$set[]=$cols[$i]."=".$GLOBALS[$s];}
					else                     {$set[]=$cols[$i]."="."'".$GLOBALS[$s]."'";}
				}else{
					if($GLOBALS[$s]==="" || $GLOBALS[$s]===null){$GLOBALS[$s]="null";}
					$set[]=$cols[$i]."=".$GLOBALS[$s];
				}
			}
			else{$GLOBALS["LCL_LOGS"][]="%msg%	ãƒ•ã‚£ãƒ¼ãƒ«ãƒ‰'<b>".$cols[$i]."</b>'ã?¯SQLæ–‡ã?®ç”Ÿæˆ?ã?‹ã‚‰é™¤å¤–ã?•ã‚Œã?¾ã?—ã?Ÿã€‚"; continue;}
		}
	}

	$sql="update ".$table." set ".implode(", ",$set)." ".$condition;
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	SQLæ–‡'<b>".$sql."</b>'ã‚’ç”Ÿæˆ?ã?—ã?¾ã?—ã?Ÿã€‚";}
	return $sql;
}

//------------------------------------------------------//
function str_modify($str){
	$func="str_modify";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}

	$str=htmlspecialchars($str);
	$str=str_replace("'","&rsquo;",$str);
	$str=str_replace("\"","&rdquo;",$str);

	$str=str_replace("\n","<br />",$str);
	$str=str_replace("\r","",$str);

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	æ–‡å­—åˆ—ã‚’HTMLã‚¨ã‚¹ã‚±ãƒ¼ãƒ—ã?—ã?¾ã?—ã?Ÿã€‚";}
	return $str;
}
//------------------------------------------------------//
function keyword_modify($str){
	$func="keyword_modify";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$str){_raise($func,"å¼•æ•° '<b>str</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	$kw=trim($str);
	$kw=mb_convert_kana($kw,"KVs");
	$kw=quotemeta($kw);
	$kw=addslashes($kw);
	$kw=mb_ereg_replace("\s+"," ",$kw);

	$tmp=explode(" ",$kw);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	ã‚­ãƒ¼ãƒ¯ãƒ¼ãƒ‰ã‚’".count($tmp)."ä»¶ã?®é…?åˆ—ã?«æ ¼ç´?ã?—ã?¾ã?—ã?Ÿã€‚";}
	return $tmp;
}
//------------------------------------------------------//
function get_kw_search($keywords,$fields){
	$func="get_kw_search";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$keywords){_raise($func,"å¼•æ•° '<b>keyword</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}
	if(!$fields)  {_raise($func,"å¼•æ•° '<b>fields</b>' ã?ŒæŒ‡å®šã?•ã‚Œã?¦ã?„ã?¾ã?›ã‚“ã€‚");}

	for($i=0; $i<count($keywords); $i++){
		for($j=0; $j<count($fields); $j++){
			$kw[$i][]=$fields[$j]." like '%".$keywords[$i]."%'";
		}
		$cond[]="((".implode(") or (",$kw[$i])."))";
	}

	$condition=implode(" and ",$cond);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	SQLæ?¡ä»¶æ–‡'<b>".$condition."</b>'ã‚’ç”Ÿæˆ?ã?—ã?¾ã?—ã?Ÿã€‚";}
	return $condition;
}

?>
