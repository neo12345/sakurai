<?php
//------------------------------------------------------//
function get_db_conn(){
	$func="get_db_conn";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!defined("MAIN_DSN"))  {_raise($func,"DB接続定数 '<b>MAIN_DSN</b>' が見つかりません。");}

	if($GLOBALS["G_is_pear"]){
		$db = DB::connect(MAIN_DSN);
		if (DB::isError($db)) {_raise($func,"DBへの接続に失敗しました。(".MAIN_DSN.")");}
	}elseif($GLOBALS["G_db_type"]=="pgsql"){
		list(,$s)=explode("://",MAIN_DSN);
		list($s1,$s2)=explode("@",$s);
		list($db_user,$db_pass)=explode(":",$s1);
		list($db_host,$db_name)=explode("/",$s2);

		if($db_user){$conn[]="user=".$db_user;}
		if($db_pass){$conn[]="password=".$db_pass;}
		if($db_host){$conn[]="host=".$db_host;}
		if($db_name){$conn[]="dbname=".$db_name;}
		$conn[]="port=5432";
		$db=pg_connect(implode(" ",$conn));
		if(!$db){_raise($func,"DBへの接続に失敗しました。(".MAIN_DSN.")");}
	}elseif($GLOBALS["G_db_type"]=="mysql"){




	}else{
		_raise($func,"不正な '<b>G_db_type</b>' が指定されました。共通設定ファイルを確認してください。");
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	'<b>".MAIN_DSN."</b>'へ接続しました。";}
	return $db;
}
//------------------------------------------------------//
function exec_sql($db,$sql,$err_place=""){
	$func="exec_sql";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DB接続リソース '<b>db</b>' が見つかりません。");}
	if(!$sql)      {_raise($func,"引数 '<b>sql</b>' が指定されていません。");}

	if(preg_match("/^[0-9]+$/",$err_place)){$err_place=$_SERVER["SCRIPT_NAME"]." in <b>line [".$err_place."]</b>";}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	実行SQL→'<b>".$sql."</b>'";}

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
		_raise($func,"不正な '<b>G_db_type</b>' が指定されました。共通設定ファイルを確認してください。");
	}

	if ($err) {
		$a=split("(\[|\])",$s);
		$s=$a[1];
		$s=preg_replace("/\'([a-zA-Z0-9_])+?\'/","<b>$0</b>",$s);
		$s=preg_replace("/\"([a-zA-Z0-9_])+?\"/","<b>$0</b>",$s);
		$m.="[<b>Message</b>]".$s."";
		_raise($func,$m);
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	結果セットを取得しました。";}
	return $rs;
}
//------------------------------------------------------//
function convert_rs($rs){
	$func="convert_rs";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$rs){_raise($func,"結果セット '<b>rs</b>' が見つかりません。");}

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
		_raise($func,"不正な '<b>G_db_type</b>' が指定されました。共通設定ファイルを確認してください。");
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	結果セットを".count($cv)."件変換しました。";}
	return $cv;
}
//------------------------------------------------------//
function get_record_count($db,$table,$condition=""){
	$func="get_record_count";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DB接続リソース '<b>db</b>' が見つかりません。");}
	if(!$table)    {_raise($func,"引数 '<b>table</b>' が指定されていません。");}

	$sql="select count(*) as count from ".$table." ".$condition;

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get count from '<b>".$table."</b>'");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,count($rs));
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	取得したレコード数は".$rs[0]["count"]."件です。";}
	return $rs[0]["count"];
}
//------------------------------------------------------//
function db_get($db,$table,&$count,$condition="",$order="",$offset=0,$limit=0,$fields=array()){
	$func="db_get";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DB接続リソース '<b>db</b>' が見つかりません。");}
	if(!$table)    {_raise($func,"引数 '<b>table</b>' が指定されていません。");}

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
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	レコードをカウントしました。→。".$count."件";}

	$sql = $prefix.$suffix." ".$order." ".$lim;

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get db data from '<b>".$table."</b>'");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,$count,$limit);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	結果セットを".count($rs)."件取得しました。";}

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
	if(!$db)       {_raise($func,"DB接続リソース '<b>db</b>' が見つかりません。");}
	if(!$table)    {_raise($func,"引数 '<b>table</b>' が指定されていません。");}
	if(!$code)     {_raise($func,"引数 '<b>code</b>' が指定されていません。");}

	$sql="select max(".$code.") as max from ".$table." ".$condition." ";

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get max record of '<b>".$table."</b>'");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,count($rs));
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	$max=$rs[0]["max"]+1;

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	対象フィールドの最大値は'<b>".$max."</b>'です。";}
	return $max;
}

//------------------------------------------------------//
function db_add_record_sql($db,$table,$prefix="F_"){
	$func="db_add_record_sql";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DB接続リソース '<b>db</b>' が見つかりません。");}
	if(!$table)    {_raise($func,"引数 '<b>table</b>' が指定されていません。");}

	$str_regx="time|date|char|text";

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$cols=get_column_list($db,$table,"",false);
	$type=get_column_list($db,$table,"",true);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	for($i=0; $i<count($cols); $i++){
		$s=$prefix.$cols[$i];
		if(!isset($GLOBALS[$s]))     {$ex[]=$cols[$i]; $GLOBALS["LCL_LOGS"][]="%msg%	フィールド'<b>".$cols[$i]."</b>'は対応する変数が見つからなかったため、SQL文の生成を除外しました。"; continue;}
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

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	SQL文'<b>".$sql."</b>'を生成しました。";}
	return $sql;
}

//------------------------------------------------------//
function get_column_list($db,$table,$sep="",$is_type=false,$except=array()){
	$func="get_column_list";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DB接続リソース '<b>db</b>' が見つかりません。");}
	if(!$table)    {_raise($func,"引数 '<b>table</b>' が指定されていません。");}

	if($GLOBALS["G_db_type"]=="pgsql"){
		$fld="field";
		$typ="type";
		$sql="select a.attname as field, format_type(a.atttypid, a.atttypmod) as type, a.attnotnull, a.atthasdef, a.attnum from pg_class c, pg_attribute a where c.relname = '".$table."' and a.attnum > 0 and a.attrelid = c.oid order by a.attnum;";
	}elseif($GLOBALS["G_db_type"]=="mysql"){
		$fld="Field";
		$typ="Type";
		$sql="show columns from ".$table;
	}else{
		_raise($func,"不正な '<b>G_db_type</b>' が指定されました。共通設定ファイルを確認してください。");
	}

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$rs = exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]."--->get '<b>".$table."</b>' column list");
	$rs = convert_rs($rs);
	_set_sql_info($func,$sql,count($rs));
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	if(!count($rs)) {_raise($func,"DBにレコードが存在しません。");}
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	テーブルの構造を取得しました。";}

	if($is_type){
		for ($i=0; $i<count($rs); $i++){
			if(!in_array($rs[$i][$fld],$except)){$arr[]=$rs[$i][$typ];}
		}
		if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	フィールドの型情報リストを生成しました。";}

	}else{
		for ($i=0; $i<count($rs); $i++){
			if(!$except){$except=array();}
			if(!in_array($rs[$i][$fld],$except)){$arr[]=$rs[$i][$fld];}
		}
		if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	フィールド名リストを生成しました。";}
	}

	if($sep){return implode($sep,$arr); if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	生成されたリスト→'<b>".implode($sep,$arr)."</b>'";}}
	else    {return $arr;               if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	生成されたリスト→'<b>".implode($sep,",")."</b>'リストは配列で返されました。";}}
}

//------------------------------------------------------//
function db_change_record_sql($db,$table,$condition="",$prefix="F_",$except=array(),$change=array()){
	$func="db_change_record_sql";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$db)       {_raise($func,"DB接続リソース '<b>db</b>' が見つかりません。");}
	if(!$table)    {_raise($func,"引数 '<b>table</b>' が指定されていません。");}
	if(!count($except) && !count($change))  {_raise($func,"引数 '<b>except</b>' と '<b>change</b>' の両方とも指定されていません。");}

	$str_regx="time|date|char|text";


	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%callfrom%	".$func;}
	$cols=get_column_list($db,$table,"",false);
	$type=get_column_list($db,$table,"",true);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%return%	".$func;}

	for($i=0; $i<count($cols); $i++){
		$s=$prefix.$cols[$i];
		if(!isset($GLOBALS[$s])){$GLOBALS["LCL_LOGS"][]="%msg%	フィールド'<b>".$cols[$i]."</b>'は対応する変数が見つからなかったため、SQL文の生成を除外しました。"; continue;}

		if(count($except)){
			if(in_array($cols[$i],$except)){$GLOBALS["LCL_LOGS"][]="%msg%	フィールド'<b>".$cols[$i]."</b>'はSQL文の生成から除外されました。"; continue;}
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
			else{$GLOBALS["LCL_LOGS"][]="%msg%	フィールド'<b>".$cols[$i]."</b>'はSQL文の生成から除外されました。"; continue;}
		}
	}

	$sql="update ".$table." set ".implode(", ",$set)." ".$condition;
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	SQL文'<b>".$sql."</b>'を生成しました。";}
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

	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	文字列をHTMLエスケープしました。";}
	return $str;
}
//------------------------------------------------------//
function keyword_modify($str){
	$func="keyword_modify";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$str){_raise($func,"引数 '<b>str</b>' が指定されていません。");}

	$kw=trim($str);
	$kw=mb_convert_kana($kw,"KVs");
	$kw=quotemeta($kw);
	$kw=addslashes($kw);
	$kw=mb_ereg_replace("\s+"," ",$kw);

	$tmp=explode(" ",$kw);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	キーワードを".count($tmp)."件の配列に格納しました。";}
	return $tmp;
}
//------------------------------------------------------//
function get_kw_search($keywords,$fields){
	$func="get_kw_search";
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%call%	".$func;}
	if(!$keywords){_raise($func,"引数 '<b>keyword</b>' が指定されていません。");}
	if(!$fields)  {_raise($func,"引数 '<b>fields</b>' が指定されていません。");}

	for($i=0; $i<count($keywords); $i++){
		for($j=0; $j<count($fields); $j++){
			$kw[$i][]=$fields[$j]." like '%".$keywords[$i]."%'";
		}
		$cond[]="((".implode(") or (",$kw[$i])."))";
	}

	$condition=implode(" and ",$cond);
	if($GLOBALS["G_is_debug"]){$GLOBALS["LCL_LOGS"][]="%msg%	SQL条件文'<b>".$condition."</b>'を生成しました。";}
	return $condition;
}

?>
