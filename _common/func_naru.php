<?php
//------------------------------------------------------//
/**
 * Ominext
 * execute sql query
 * 
 * @global type $db
 * @global string $RS_name
 * @param string $select
 * @param string $table
 * @param string $name
 * @param string $where
 * @param string $group_by
 * @return query result
 */
function Omi_get_rs_with_group_by($select, $table, $name, $where="", $group_by=""){
	global $db;
	if($name){
		$RS_name="RS_".$name;
	}else{
		$RS_name="RS";
	}
	global $$RS_name;

	if($table){
		$sql="select ".$select." from ".$table."";
		if($where){
			$sql.=" where ".$where."";
		}
		if($group_by){
			$sql.=" group by ".$group_by."";
		}
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS=convert_rs($rs);
	}else{
		print("error");
	}

	$$RS_name=$RS;

	return($$RS_name);
}

//------------------------------------------------------//
/**
 * Ominext
 * execute sql query
 * 
 * @global type $db
 * @global string $RS_name
 * @param string $select
 * @param string $table
 * @param string $name
 * @param string $where
 * @param string $order_by
 * @return query result
 */
function Omi_get_rs($select, $table, $name, $where="", $order_by=""){
	global $db;
	if($name){
		$RS_name="RS_".$name;
	}else{
		$RS_name="RS";
	}
	global $$RS_name;

	if($table){
		$sql="select ".$select." from ".$table."";
		if($where){
			$sql.=" where ".$where."";
		}
		if($order_by){
			$sql.=" order by ".$order_by."";
		}
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS=convert_rs($rs);
	}else{
		print("error");
	}

	$$RS_name=$RS;

	return($$RS_name);
}
//------------------------------------------------------//
function get_rs($table,$name,$where="",$order_by=""){
	global $db;
	if($name){
		$RS_name="RS_".$name;
	}else{
		$RS_name="RS";
	}
	global $$RS_name;

	if($table){
		$sql="select * from ".$table."";
		if($where){
			$sql.=" where ".$where."";
		}
		if($order_by){
			$sql.=" order by ".$order_by."";
		}
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS=convert_rs($rs);
	}else{
		print("error");
	}

	$$RS_name=$RS;

	return($$RS_name);
}
//------------------------------------------------------//
function get_key($array){
	if(count($array)){
		$tmp=array_keys($array);
		return $tmp[0];
	}
}
//------------------------------------------------------//
function get_colum_key($table,$colum_in,$value,$colum_out,$where){
	global $db;

	if($colum_in and $value){
		$sql="select * from ".$table."";
		$sql.=" where ".$colum_in."='".$value."'";
		if($where){
			$sql.=" and ".$where."";
		}
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS=convert_rs($rs);
	}

	return($RS[0][$colum_out]);
}
//------------------------------------------------------//
function shot_text($name,$value,$prev,$size,$option){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(mb_strlen($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		echo "<input type=\"text\" size=\"".$size."\" name=\"".$name."\" value=\"".$value."\" ".$option." />";
	}else{
		echo $value."<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" />";
	}
}
//------------------------------------------------------//
function shot_text2($name,$value,$prev,$size,$style,$option,$required){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(mb_strlen($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		if($required){
			echo "<input type=\"text\" size=\"".$size."\" name=\"".$name."\" value=\"".$value."\" id=\"".$name."\" style=\"background-color:#FFD5FF; ".$style."\" onKeyUp=\"CheckRequired('".$name."');\" onblur=\"CheckRequired('".$name."');\" ".$option." />";
		}else{
			if($style){
				$style="style=\"".$style."\"";
			}
			echo "<input type=\"text\" size=\"".$size."\" name=\"".$name."\" value=\"".$value."\" ".$style." ".$option." />";
		}
	}else{
		echo $value."<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" />";
	}
}
//------------------------------------------------------//
function shot_text_zip($name,$value,$prev,$size,$style,$option,$pref,$addr,$required){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(mb_strlen($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	preg_match("/^([0-9]{3}?)([0-9]{4}?)$/",$value,$matches);
	if($matches[0]){
		$value=$matches[1]."-".$matches[2];
	}

	if($prev==""){
		if($required){
			echo "<input type=\"text\" size=\"".$size."\" name=\"".$name."\" value=\"".$value."\" maxlength=\"8\" id=\"".$name."\" style=\"background-color:#FFD5FF; width:55px; ".$style."\" onKeyUp=\"AjaxZip2.zip2addr(this,'".$pref."','".$addr."'); CheckRequired('".$name."'); CheckRequired('".$pref."'); CheckRequired('".$addr."');\" onblur=\"AjaxZip2.zip2addr(this,'".$pref."','".$addr."'); CheckRequired('".$name."'); CheckRequired('".$pref."'); CheckRequired('".$addr."');\" ".$option." />";
		}else{
			echo "<input type=\"text\" size=\"".$size."\" name=\"".$name."\" value=\"".$value."\" maxlength=\"8\" style=\"width:55px; ".$style."\" onKeyUp=\"AjaxZip2.zip2addr(this,'".$pref."','".$addr."');\" onChange=\"AjaxZip2.zip2addr(this,'".$pref."','".$addr."');\" ".$option." />";
		}
	}else{
		echo $value."<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" />";
	}
}
//------------------------------------------------------//
function shot_radio($name,$value,$prev,$rs,$key1,$key2,$num,$option){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(mb_strlen($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		$rest=count($rs)%$num;
		$ceil=ceil(count($rs)/$num);
		for($i=0;$i<$ceil;$i++){
			if($ceil > $i+1){
				$num_list=$num;
			}else{
				if($rest){
					$num_list=$rest;
				}else{
					$num_list=$num;
				}
			}
			for($j=0;$j<$num_list;$j++){
				if(is_array($value)){
					if(in_array($rs[$num*$i+$j][$key1],$value)){
						$chk="checked";
					}else{
						$chk="";
					}
				}else{
					if($value == $rs[$num*$i+$j][$key1]){
						$chk="checked";
					}else{
						$chk="";
					}
				}
				echo "<input type=\"radio\" name=\"".$name."\" value=\"".$rs[$num*$i+$j][$key1]."\" ".$option." ".$chk.">&nbsp;".$rs[$num*$i+$j][$key2]."&nbsp;&nbsp;&nbsp;";
			}
			echo "<br>";
		}
	}else{
		for($i=0;$i<count($rs);$i++){
			if($rs[$i][$key1]==$value){
				echo $rs[$i][$key2]."<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" />";
			}
		}
	}
/*
	if($prev==""){
		for($i=0;$i<ceil(count($rs)/$num);$i++){
			for($j=0;$j<$num;$j++){
				if($value == $rs[$num*$i+$j][$key1]){
					$chk="checked";
				}else{
					$chk="";
				}
				echo "<input type=\"radio\" name=\"".$name."\" value=\"".$rs[$num*$i+$j][$key1]."\" ".$option." ".$chk.">&nbsp;".$rs[$num*$i+$j][$key2]."&nbsp;&nbsp;&nbsp;";
			}
			echo "<br>";
		}
	}else{
		for($i=0;$i<count($rs);$i++){
			if($rs[$i][$key1]==$value){
				echo $rs[$i][$key2]."<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" />";
			}
		}
	}
*/
}
//------------------------------------------------------//
function shot_checkbox_old($name,$value,$prev,$rs,$key1,$key2,$num,$option){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(!is_array($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		$rest=count($rs)%$num;
		$ceil=ceil(count($rs)/$num);
		for($i=0;$i<$ceil;$i++){
			if($ceil > $i+1){
				$num_list=$num;
			}else{
				if($rest){
					$num_list=$rest;
				}else{
					$num_list=$num;
				}
			}
			for($j=0;$j<$num_list;$j++){
				if(is_array($value)){
					if(in_array($rs[$num*$i+$j][$key1],$value)){
						$chk="checked";
					}else{
						$chk="";
					}
				}else{
					if($value == $rs[$num*$i+$j][$key1]){
						$chk="checked";
					}else{
						$chk="";
					}
				}
				echo "<input type=\"checkbox\" name=\"".$name."[]\" value=\"".$rs[$num*$i+$j][$key1]."\" ".$option." ".$chk.">&nbsp;".$rs[$num*$i+$j][$key2]."&nbsp;&nbsp;&nbsp;";
			}
			echo "<br>";
		}
	}else{
		for($i=0;$i<count($rs);$i++){
			for($j=0;$j<count($value);$j++){
				if($rs[$i][$key1]==$value[$j]){
					echo $rs[$i][$key2]."<input type=\"hidden\" name=\"".$name."[]\" value=\"".$value[$j]."\" />";
					echo "<br />";
				}
			}
		}
/*
		for($i=0;$i<count($rs);$i++){
			if($rs[$i][$key1]==$value){
				echo $rs[$i][$name][$key2]."<input type=\"hidden\" name=\"".$name."\" value=\"".$value."\" />";
			}
		}
*/
	}
}
//------------------------------------------------------//
function shot_checkbox($name,$value,$prev,$rs,$key1,$key2,$width,$option){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(!is_array($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		for($i=0;$i<count($rs);$i++) {
			if(is_array($value)){
				if(in_array($rs[$i][$key1],$value)){
					$chk="checked";
				}else{
					$chk="";
				}
			}else{
				if($value == $rs[$i][$key1]){
					$chk="checked";
				}else{
					$chk="";
				}
			}
			echo "<div style=\"width: ".$width."px; text-align: left; float: left;\"><input type=\"checkbox\" name=\"".$name."[]\" value=\"".$rs[$i][$key1]."\" ".$option." ".$chk." />&nbsp;".$rs[$i][$key2]."</div>";
		}
		echo "<div style=\"clear: both;\"></div>";
	}else{
		for($i=0;$i<count($rs);$i++){
			for($j=0;$j<count($value);$j++){
				if($rs[$i][$key1]==$value[$j]){
					echo $rs[$i][$key2]."<input type=\"hidden\" name=\"".$name."[]\" value=\"".$value[$j]."\" />";
					echo "<br />";
				}
			}
		}
	}
}
//------------------------------------------------------//
function shot_file($name,$value,$prev,$size,$option){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(mb_strlen($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		echo "<input type=\"file\" name=\"".$name."\" value=\"".$value."\" size=\"".$size."\" ".$option."/>";
	}else{
		echo $value."<span style=\"display:none;\"><input type=\"file\" name=\"".$name."\" value=\"".$value."\" size=\"".$size."\" ".$option."/></span>";
	}
}
//------------------------------------------------------//
function shot_textarea($name,$value,$prev,$row,$col,$option){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(mb_strlen($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		echo "<textarea name=\"".$name."\" rows=\"".$row."\" cols=\"".$col."\" ".$option.">".$value."</textarea>";
	}elseif($prev!=""){
		$req=str_replace('\"','\'',$value);
		$req=stripslashes($req);
		echo nl2br($req)."<input type=\"hidden\" name=\"".$name."\" value=\"".$req."\" />";
	}
}
//------------------------------------------------------//
function shot_textarea2($name,$value,$prev,$row,$col,$style,$option,$null,$required){
	$tmp=preg_split("/[\[\]]/",$name);
	$name_spl=$tmp[0];
	$name_spl_key=$tmp[1];

	if(mb_strlen($_REQUEST[$name])){
		if($prev){
			$value=$_REQUEST[$name];
		}else{
			$value=$value;
		}
	}elseif($_REQUEST[$name_spl][$name_spl_key]){
		$value=$_REQUEST[$name_spl][$name_spl_key];
	}

	if($prev==""){
		if($required){
			echo "<textarea name=\"".$name."\" rows=\"".$row."\" cols=\"".$col."\" id=\"".$name."\" style=\"background-color:#FFD5FF; ".$style."\" onKeyUp=\"CheckRequired('".$name."');\" onblur=\"CheckRequired('".$name."');\" ".$option.">".$value."</textarea>";
		}else{
			if($style){
				$style="style=\"".$style."\"";
			}
			echo "<textarea name=\"".$name."\" rows=\"".$row."\" cols=\"".$col."\" ".$style." ".$option.">".$value."</textarea>";
		}

	}elseif($prev!=""){
		if($value){
			$req=str_replace('\"','\'',$value);
			$req=stripslashes($req);
			echo nl2br($req)."<input type=\"hidden\" name=\"".$name."\" value=\"".$req."\" />";
		}else{
			echo $null;
		}
	}
}
//------------------------------------------------------//
function shot_passwd($name,$selected,$prev,$size,$option){
	if($prev==""){
		echo "<input type=\"password\" size=\"".$size."\" name=\"".$name."\" value=\"".$selected."\" ".$option." />";
	}elseif($prev!=""){
		$str=ereg_replace(".","*",$selected);
		echo $str."<input type=\"hidden\" name=\"".$name."\" value=\"".$selected."\" />";
	}
}
//------------------------------------------------------//
function shot_passwd2($name,$selected,$prev,$size,$style,$option,$required){
	if($prev==""){
		if($required){
			echo "<input type=\"password\" size=\"".$size."\" name=\"".$name."\" value=\"".$selected."\" style=\"background-color:#FFD5FF; ".$style."\" id=\"".$name."\" onKeyUp=\"CheckRequired('".$name."');\" onblur=\"CheckRequired('".$name."');\" ".$option." />";
		}else{
			if($style){
				$style="style=\"".$style."\"";
			}
			echo "<input type=\"password\" size=\"".$size."\" name=\"".$name."\" value=\"".$selected."\" ".$style." ".$option." />";
		}
	}elseif($prev!=""){
		$str=ereg_replace(".","*",$selected);
		echo $str."<input type=\"hidden\" name=\"".$name."\" value=\"".$selected."\" />";
	}
}
//------------------------------------------------------//
function shot_select($name,$selected,$prev,$rs,$value,$str,$option,$null, $default=""){
	if($prev==""){

		echo "<select name=\"".$name."\" ".$option.">";

		if($null){
			echo "<option value=\"\">".$null."</option>";
		}

		if(isset($rs)){
			for($i=0;$i<count($rs);$i++) {
				if($rs[$i][$value] == $selected and $selected){
					echo "<option value=\"".$rs[$i][$value]."\" selected>".$rs[$i][$str]."</option>";
				}elseif($rs[$i][$value] == $default and !$selected){
					echo "<option value=\"".$rs[$i][$value]."\" selected>".$rs[$i][$str]."</option>";
				}else{
					echo "<option value=\"".$rs[$i][$value]."\">".$rs[$i][$str]."</option>";
				}
			}
		}

		echo "</select>";

	}elseif($prev!=""){
		if($_REQUEST[$name]){
			$selected=$_REQUEST[$name];
		}
		for($i=0;$i<count($rs);$i++) {
			if($rs[$i][$value] == $selected){
				echo $rs[$i][$str]."<input type=\"hidden\" name=\"".$name."\" value=\"".$selected."\" />";
			}
		}

	}
}
//------------------------------------------------------//
function shot_select2($name,$selected,$prev,$rs,$value,$str,$style,$option,$null,$required){
	if($prev==""){

		if($required){
			echo "<select name=\"".$name."\" style=\"background-color:#FFD5FF; ".$style."\" id=\"".$name."\" onchange=\"CheckRequired('".$name."');\" ".$option.">";
		}else{
			if($style){
				$style="style=\"".$style."\"";
			}
			echo "<select name=\"".$name."\" ".$style." ".$option.">";
		}

		if($null){
			echo "<option value=>".$null."</option>";
		}

		if(isset($rs)){
			for($i=0;$i<count($rs);$i++) {
				if($rs[$i][$value] == $selected){
					echo "<option value=\"".$rs[$i][$value]."\" selected>".$rs[$i][$str]."</option>";
				}else{
					echo "<option value=\"".$rs[$i][$value]."\">".$rs[$i][$str]."</option>";
				}
			}
		}

		echo "</select>";

	}elseif($prev!=""){
		if($_REQUEST[$name]){
			$selected=$_REQUEST[$name];
		}
		if($selected){
			for($i=0;$i<count($rs);$i++) {
				if($rs[$i][$value] == $selected){
					echo $rs[$i][$str]."<input type=\"hidden\" name=\"".$name."\" value=\"".$selected."\" ".$option." />";
				}
			}
		}else{
			if($null){
				echo $null."<input type=\"hidden\" name=\"".$name."\" value=\"".$selected."\" ".$option." />";
			}
		}

	}
}
//------------------------------------------------------//
function shot_select_db($name,$selected,$prev,$tale,$key,$value,$id="",$where="",$null=""){

	if($null==""){
		$null="---";
	}

	if($prev ==""){
		if($where){
			$where="where ".$where;
		}
		$db = get_db_conn();
		$sql="select * from ".$tale." ".$where."";
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS=convert_rs($rs);

		echo "<select name=\"".$name."\" ".$id.">";
				echo "<option value=>".$null."</option>";

			if(isset($RS)){
				for($i=0;$i<count($RS);$i++) {
					if($RS[$i][$key] == $selected){
						echo "<option value=\"".$RS[$i][$key]."\" selected>".$RS[$i][$value]."</option>";
					}else{
						echo "<option value=\"".$RS[$i][$key]."\">".$RS[$i][$value]."</option>";
					}
				}
			}

		echo "</select>";

	}elseif($prev!="" and $_REQUEST[$name]){
		if($where){
			$where="where ".$name."=".$_REQUEST[$name]." and ".$where;
		}else{
			$where="where ".$name."=".$_REQUEST[$name]."";
		}
		$db = get_db_conn();
		$sql="select * from ".$tale." ".$where."";
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS=convert_rs($rs);

		echo $RS[0][$value];
		echo "<input type=\"hidden\" name=\"".$name."\" value=\"".$_REQUEST[$name]."\" />";
	}
}
//------------------------------------------------------//
function rs_filter($rs,$colum,$value,$sort="",$limit=""){

	$num=0;
	if(count($rs)){
		foreach($rs as $k=>$v){
			if(is_array($colum)){
				for($i=0;$i<count($colum);$i++){
					if($v[$colum[$i]]!=$value[$i]){
						$flg="1";
					}
				}
				if(!$flg){
					$rs_new[$num]=$v;
					$num=$num+1;
				}
				unset($flg);
			}else{
				if($v[$colum]==$value){
					$rs_new[$num]=$v;
					$num=$num+1;
				}
			}
		}
		unset($num);

		if($sort){
			if(is_array($sort)){
				$A_sort=$sort;
			}else{
				$A_sort[0]=$sort;
			}
			for($i=0;$i<count($A_sort);$i++) {
				$tmp1=explode(" ",$A_sort[$i]);
				$sort_col=$tmp1[0];
				$sort_val=$tmp1[1];
				if(count($rs_new)){
					foreach($rs_new as $key=>$value){
						$tmp2[$key]=$value[$sort_col];
					}
					if($sort_val=="asc"){
						asort($tmp2);
					}elseif($sort_val=="desc"){
						arsort($tmp2);
					}
					foreach($tmp2 as $key=>$value){
						$rs_new_tmp[]=$rs_new[$key];
					}
					$rs_new=$rs_new_tmp;
				}
			}
		}
	}

	if($limit){
		$tmp=explode(",",$limit);
		$rs_new=array_slice($rs_new,$tmp[0]-1,$tmp[1]-$tmp[0]+1);
	}



	return($rs_new);
}
//------------------------------------------------------//
function sql_convert_null($sql){

	$sql_1=str_replace('""','null',$sql);
	$sql_2=str_replace("''","null",$sql_1);
	$sql_3=str_replace(",,",",null,",$sql_2);
	$sql_4=str_replace(",)",",null)",$sql_3);
	$sql_new=str_replace("(,","(null,",$sql_4);

	return($sql_new);
}
//------------------------------------------------------//
function make_passwd($length){
	$ar[0] =array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	$ar[1] =array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$ar[2] =array(0,1,2,3,4,5,6,7,8,9);
	$array=array();
	for($i=0;$i<$length;$i++){
		$num_3=rand(0,2);
		$num_10=rand(0,9);
		$num_26=rand(0,25);
		if($num_3==0 or $num_3==1){
			$array[$i]=$ar[$num_3][$num_26];
		}elseif($num_3==2){
			$array[$i]=$ar[$num_3][$num_10];
		}
	}
	$passwd=implode("",$array);

	return($passwd);
}
//------------------------------------------------------//
function make_cd($tbl,$clm,$where){
	$db = get_db_conn();
	if(!is_array($tbl)){
		$A_tbl[0]=$tbl;
		$A_clm[0]=$clm;
		$A_where[0]=$where;
	}
	if(is_array($tbl) and !is_array($clm)){
		for($i=0;$i<count($tbl);$i++) {
			$A_clm[]=$clm;
		}
	}
	if(is_array($tbl) and !is_array($where)){
		for($i=0;$i<count($tbl);$i++) {
			$A_where[]=$where;
		}
	}
	if(is_array($tbl) and is_array($clm)){
		$A_tbl=$tbl;
		$A_clm=$clm;
	}
	if(is_array($where)){
		$A_where=$where;
	}

	for($i=0;$i<count($A_tbl);$i++) {
		$sql="select MAX(".$A_clm[$i].") as max from ".$A_tbl[$i]."";
		if($where){
			$sql.=" where ".$A_where[$i]."";
		}
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS=convert_rs($rs);
		if($RS[0]['max']==""){
			$cd=1;
		}else{
			$cd=$RS[0]['max']+1;
		}
		if($cd > $cd_return){
			$cd_return=$cd;
		}
	}

	return($cd_return);
}
//------------------------------------------------------//
function make_date_select($name,$selected,$from_y,$to_y,$prev,$default,$null,$flg_youbi){

	$name_y=$name."_y";
	$name_m=$name."_m";
	$name_d=$name."_d";

	if($selected){
		preg_match("/^([0-9]+)-([0-9]+)-([0-9]+).*$/",$selected,$matches_select);
		$y=$matches_select[1];
		$m=$matches_select[2];
		$d=$matches_select[3];
	}elseif($default){
		preg_match("/^([0-9]+)-([0-9]+)-([0-9]+).*$/",$default,$matches_default);
		$ary=explode("-",$default);
		$y=$matches_default[1];
		$m=$matches_default[2];
		$d=$matches_default[3];
	}else{
		$y="----";
		$m="--";
		$d="--";
	}

	if($prev){
		if($_REQUEST[$name_y] and $_REQUEST[$name_m] and $_REQUEST[$name_d]){
			if($flg_youbi){
				echo "".$_REQUEST[$name_y]."年".$_REQUEST[$name_m]."月".$_REQUEST[$name_d]."日（".pic_object_date("D",$_REQUEST[$name_y]."-".$_REQUEST[$name_m]."-".$_REQUEST[$name_d])."）";
			}else{
				echo "".$_REQUEST[$name_y]."年".$_REQUEST[$name_m]."月".$_REQUEST[$name_d]."日";
			}
			echo "<input type=\"hidden\" name=\"".$name_y."\" value=\"".$_REQUEST[$name_y]."\">
						<input type=\"hidden\" name=\"".$name_m."\" value=\"".$_REQUEST[$name_m]."\">
						<input type=\"hidden\" name=\"".$name_d."\" value=\"".$_REQUEST[$name_d]."\">
						<input type=\"hidden\" name=\"".$name."\" value=\"".$_REQUEST[$name_y]."-".$_REQUEST[$name_m]."-".$_REQUEST[$name_d]."\">
						";
		}elseif($selected and $y and $m and $d){
			if($flg_youbi){
				echo "".$y."年".$m."月".$d."日（".pic_object_date("D",$y."-".$m."-".$d)."）";
			}else{
				echo "".$y."年".$m."月".$d."日";
			}
			echo "<input type=\"hidden\" name=\"".$name_y."\" value=\"".$y."\">
						<input type=\"hidden\" name=\"".$name_m."\" value=\"".$m."\">
						<input type=\"hidden\" name=\"".$name_d."\" value=\"".$d."\">
						<input type=\"hidden\" name=\"".$name."\" value=\"".$y."-".$m."-".$d."\">
						";
		}else{
			echo $null;
		}
	}else{
		if($from_y > $to_y){
			echo "error";
		}else{
			for($i=$from_y;$i<=$to_y;$i++){
				$tmp_y[]=$i;
			}
			for($i=1;$i<=12;$i++){
				$tmp_m[]=$i;
			}
			for($i=1;$i<=31;$i++){
				$tmp_d[]=$i;
			}

			for($i=0;$i<count($tmp_y);$i++){
				if(isset($_REQUEST[$name_y])){
					if($tmp_y[$i] == $_REQUEST[$name_y]){
						$tmp_option_y[]="<option value=\"".$tmp_y[$i]."\" selected>".$tmp_y[$i]."";
					}else{
						$tmp_option_y[]="<option value=\"".$tmp_y[$i]."\">".$tmp_y[$i]."";
					}
				}else{
					if($tmp_y[$i] == $y){
						$tmp_option_y[]="<option value=\"".$tmp_y[$i]."\" selected>".$tmp_y[$i]."";
					}else{
						$tmp_option_y[]="<option value=\"".$tmp_y[$i]."\">".$tmp_y[$i]."";
					}
				}
			}
			for($i=0;$i<count($tmp_m);$i++){
				if(isset($_REQUEST[$name_m])){
					if($tmp_m[$i] == $_REQUEST[$name_m]){
						$tmp_option_m[]="<option value=\"".sprintf("%02d",$tmp_m[$i])."\" selected>".sprintf("%02d",$tmp_m[$i])."";
					}else{
						$tmp_option_m[]="<option value=\"".sprintf("%02d",$tmp_m[$i])."\">".sprintf("%02d",$tmp_m[$i])."";
					}
				}else{
					if($tmp_m[$i] == $m){
						$tmp_option_m[]="<option value=\"".sprintf("%02d",$tmp_m[$i])."\" selected>".sprintf("%02d",$tmp_m[$i])."";
					}else{
						$tmp_option_m[]="<option value=\"".sprintf("%02d",$tmp_m[$i])."\">".sprintf("%02d",$tmp_m[$i])."";
					}
				}
			}
			for($i=0;$i<count($tmp_d);$i++){
				if(isset($_REQUEST[$name_d])){
					if($tmp_d[$i] == $_REQUEST[$name_d]){
						$tmp_option_d[]="<option value=\"".sprintf("%02d",$tmp_d[$i])."\" selected>".sprintf("%02d",$tmp_d[$i])."";
					}else{
						$tmp_option_d[]="<option value=\"".sprintf("%02d",$tmp_d[$i])."\">".sprintf("%02d",$tmp_d[$i])."";
					}
				}else{
					if($tmp_d[$i] == $d){
						$tmp_option_d[]="<option value=\"".sprintf("%02d",$tmp_d[$i])."\" selected>".sprintf("%02d",$tmp_d[$i])."";
					}else{
						$tmp_option_d[]="<option value=\"".sprintf("%02d",$tmp_d[$i])."\">".sprintf("%02d",$tmp_d[$i])."";
					}
				}
			}
			$option_y=implode("\n",$tmp_option_y);
			$option_m=implode("\n",$tmp_option_m);
			$option_d=implode("\n",$tmp_option_d);

			if($selected){
				$value=$selected;
			}elseif($default){
				$value=$default;
			}
			echo "<select name=\"".$name."_y\" id=\"".$name."_y\" onchange=\"MakeHiddenDate('".$name."');\">
							<!-- <option value=\"\">---- -->
							".$option_y."
						</select>
						年
						<select name=\"".$name."_m\" id=\"".$name."_m\" onchange=\"MakeHiddenDate('".$name."');\">
							<!-- <option value=\"\">-- -->
							".$option_m."
						</select>
						月
						<select name=\"".$name."_d\" id=\"".$name."_d\" onchange=\"MakeHiddenDate('".$name."');\">
							<!-- <option value=\"\">-- -->
							".$option_d."
						</select>
						日
						<input type=\"hidden\" name=\"".$name."\" id=\"".$name."\" value=\"".$value."\">
						";
		}
	}
}
//------------------------------------------------------//
function make_time_select($name,$selected,$prev,$type,$unit,$from_h,$to_h){

	if($from_h>$to_h or $from_h>24 or $from_h<0 or $to_h>24 or $to_h<0){
		echo "Hの範囲指定が不正です。";
	}elseif($from_h and $to_h){
		$h_f=$from_h;
		$h_t=$to_h;
	}else{
		$h_f="0";
		$h_t="23";
	}

	$name_H=$name."_H";
	$name_i=$name."_i";
	$name_s=$name."_s";

	if($selected){
		$selected=date("H:i:s",strtotime($selected));
	}

	if($selected){
		$ary=explode(":",$selected);
		$selected_H=$ary[0];
		$selected_i=$ary[1];
		$selected_s=$ary[2];
	}else{
		$selected_H="--";
		$selected_i="--";
		$selected_s="--";
	}

	if($prev){
		if($type=="Hi"){
			if($_REQUEST[$name_H] and $_REQUEST[$name_i]){
				echo "".date("H時i分",strtotime($_REQUEST[$name_H].":".$_REQUEST[$name_i]))."
							<input type=\"hidden\" name=\"".$name_H."\" value=\"".$_REQUEST[$name_H]."\">
							<input type=\"hidden\" name=\"".$name_i."\" value=\"".$_REQUEST[$name_i]."\">
							";
			}else{
				echo "".date("H時i分",strtotime($selected))."
							<input type=\"hidden\" name=\"".$name_H."\" value=\"".$selected_H."\">
							<input type=\"hidden\" name=\"".$name_i."\" value=\"".$selected_i."\">
							";
			}
		}else{
			if($_REQUEST[$name_H] and $_REQUEST[$name_i] and $_REQUEST[$name_s]){
				echo "".date("H時i分s秒",strtotime($_REQUEST[$name_H].":".$_REQUEST[$name_i].":".$_REQUEST[$name_s]))."
							<input type=\"hidden\" name=\"".$name_H."\" value=\"".$_REQUEST[$name_H]."\">
							<input type=\"hidden\" name=\"".$name_i."\" value=\"".$_REQUEST[$name_i]."\">
							<input type=\"hidden\" name=\"".$name_s."\" value=\"".$_REQUEST[$name_s]."\">
							";
			}else{
				echo "".date("H時i分s秒",strtotime($selected))."
							<input type=\"hidden\" name=\"".$name_H."\" value=\"".$selected_H."\">
							<input type=\"hidden\" name=\"".$name_i."\" value=\"".$selected_i."\">
							<input type=\"hidden\" name=\"".$name_s."\" value=\"".$selected_s."\">
							";
			}
		}
	}else{
		for($i=$h_f;$i<=$h_t;$i++){
			$tmp_H[]=$i;
		}
		for($i=0;$i<count($tmp_H);$i++){
			if(isset($_REQUEST[$name_H])){
				if($_REQUEST[$name_H] == "".$tmp_H[$i].""){
					$tmp_option_H[]="<option value=\"".sprintf("%02d",$tmp_H[$i])."\" selected>".sprintf("%02d",$tmp_H[$i])."";
				}else{
					$tmp_option_H[]="<option value=\"".sprintf("%02d",$tmp_H[$i])."\">".sprintf("%02d",$tmp_H[$i])."";
				}
			}else{
				if($selected_H == "".$tmp_H[$i].""){
					$tmp_option_H[]="<option value=\"".sprintf("%02d",$tmp_H[$i])."\" selected>".sprintf("%02d",$tmp_H[$i])."";
				}else{
					$tmp_option_H[]="<option value=\"".sprintf("%02d",$tmp_H[$i])."\">".sprintf("%02d",$tmp_H[$i])."";
				}
			}
		}
		$option_H=implode("\n",$tmp_option_H);

		for($i=0;$i<=59;$i++){
			if($unit){
				if($i%$unit=="0"){
					$tmp_i[]=$i;
				}
			}else{
				$tmp_i[]=$i;
			}
		}
		for($i=0;$i<count($tmp_i);$i++){
			if(isset($_REQUEST[$name_i])){
				if($_REQUEST[$name_i] == "".$tmp_i[$i].""){
					$tmp_option_i[]="<option value=\"".sprintf("%02d",$tmp_i[$i])."\" selected>".sprintf("%02d",$tmp_i[$i])."";
				}else{
					$tmp_option_i[]="<option value=\"".sprintf("%02d",$tmp_i[$i])."\">".sprintf("%02d",$tmp_i[$i])."";
				}
			}else{
				if($selected_i == "".$tmp_i[$i].""){
					$tmp_option_i[]="<option value=\"".sprintf("%02d",$tmp_i[$i])."\" selected>".sprintf("%02d",$tmp_i[$i])."";
				}else{
					$tmp_option_i[]="<option value=\"".sprintf("%02d",$tmp_i[$i])."\">".sprintf("%02d",$tmp_i[$i])."";
				}
			}
		}
		$option_i=implode("\n",$tmp_option_i);

		if($type!="Hi"){
			for($i=0;$i<=59;$i++){
				$tmp_s[]=$i;
			}
			for($i=0;$i<count($tmp_s);$i++){
				if(isset($_REQUEST[$name_s])){
					if($_REQUEST[$name_s] == "".$tmp_s[$i].""){
						$tmp_option_s[]="<option value=\"".sprintf("%02d",$tmp_s[$i])."\" selected>".sprintf("%02d",$tmp_s[$i])."";
					}else{
						$tmp_option_s[]="<option value=\"".sprintf("%02d",$tmp_s[$i])."\">".sprintf("%02d",$tmp_s[$i])."";
					}
				}else{
					if($selected_s == "".$tmp_s[$i].""){
						$tmp_option_s[]="<option value=\"".sprintf("%02d",$tmp_s[$i])."\" selected>".sprintf("%02d",$tmp_s[$i])."";
					}else{
						$tmp_option_s[]="<option value=\"".sprintf("%02d",$tmp_s[$i])."\">".sprintf("%02d",$tmp_s[$i])."";
					}
				}
			}
			$option_s=implode("\n",$tmp_option_s);
		}

		if($type=="Hi"){
			echo "<select name=\"".$name."_H\">
							<option value=\"\">--
							".$option_H."
						</select>
						時
						<select name=\"".$name."_i\">
							<option value=\"\">--
							".$option_i."
						</select>
						分
						";
		}else{
			echo "<select name=\"".$name."_H\">
							<option value=\"\">--
							".$option_H."
						</select>
						時
						<select name=\"".$name."_i\">
							<option value=\"\">--
							".$option_i."
						</select>
						分
						<select name=\"".$name."_s\">
							<option value=\"\">--
							".$option_s."
						</select>
						秒
						";
		}
	}

}
//------------------------------------------------------//
function convert_date_request($name){
	$name_y=$name."_y";
	$name_m=$name."_m";
	$name_d=$name."_d";
	$name_H=$name."_H";
	$name_i=$name."_i";
	$name_s=$name."_s";

	$y=$_REQUEST[$name_y];
	$m=$_REQUEST[$name_m];
	$d=$_REQUEST[$name_d];
	if(!$y or !$m or !$d){
		echo "エラー";
		exit;
	}

	if($_REQUEST[$name_H]){
		$H=$_REQUEST[$name_H];
	}else{
		$H="00";
	}
	if($_REQUEST[$name_i]){
		$i=$_REQUEST[$name_i];
	}else{
		$i="00";
	}
	if($_REQUEST[$name_s]){
		$s=$_REQUEST[$name_s];
	}else{
		$s="00";
	}

	return $y."-".$m."-".$d." ".$H.":".$i.":".$s;
}
//------------------------------------------------------//
function make_num_select($name,$value,$from,$to,$prev,$null,$figure,$default,$option){
	if($from > $to){
		echo "error";
	}else{

		if(!$value){
			$value=$default;
		}

		$tmp=preg_split("/[\[\]]/",$name);
		$name_spl=$tmp[0];
		$name_spl_key=$tmp[1];

		if(mb_strlen($_REQUEST[$name])){
			if($prev){
				$value=$_REQUEST[$name];
			}else{
				$value=$value;
			}
		}elseif($_REQUEST[$name_spl][$name_spl_key]){
			$value=$_REQUEST[$name_spl][$name_spl_key];
		}

		if($prev){
			echo $value."<input type=\"hidden\" name=\"".$name."\" value=\"".$_REQUEST[$name]."\">";
		}else{
//			if($null==""){
//				$null="--";
//			}

			for($i=$from;$i<=$to;$i++){
				$tmp_d[]=$i;
			}

			for($i=0;$i<count($tmp_d);$i++){
					if($tmp_d[$i] == $value){
						$tmp_option_d[]="<option value=\"".sprintf("%0".$figure."d",$tmp_d[$i])."\" selected>".sprintf("%0".$figure."d",$tmp_d[$i])."";
					}else{
						$tmp_option_d[]="<option value=\"".sprintf("%0".$figure."d",$tmp_d[$i])."\">".sprintf("%0".$figure."d",$tmp_d[$i])."";
					}
			}
			$option_d=implode("\n",$tmp_option_d);

			echo "<select name=\"".$name."\" ".$option.">";
			if($null){
				echo 	"<option value=\"\">".$null;
			}
			echo 	$option_d;
			echo "</select>";
		}

	}
}//------------------------------------------------------//
function make_year_select($name, $value, $from, $to, $prev, $null, $default, $flg_era, $option){
	if($from > $to){
		echo "error";
	}else{

		if(!$value){
			$value=$default;
		}

		$tmp=preg_split("/[\[\]]/",$name);
		$name_spl=$tmp[0];
		$name_spl_key=$tmp[1];

		if(mb_strlen($_REQUEST[$name])){
			if($prev){
				$value=$_REQUEST[$name];
			}else{
				$value=$value;
			}
		}elseif($_REQUEST[$name_spl][$name_spl_key]){
			$value=$_REQUEST[$name_spl][$name_spl_key];
		}

		if($prev){
			echo $value."<input type=\"hidden\" name=\"".$name."\" value=\"".$_REQUEST[$name]."\">";
		}else{
//			if($null==""){
//				$null="--";
//			}

			for($i=$from;$i<=$to;$i++){
				if($flg_era){
					if($i <= 1911 and $i >= 1868){
						$era_name = "明治";
						$era_num = $i - 1867;
					}elseif($i <= 1925 and $i >= 1912){
						$era_name = "大正";
						$era_num = $i - 1911;
					}elseif($i <= 1988 and $i >= 1926){
						$era_name = "昭和";
						$era_num = $i - 1925;
					}elseif($i >= 1989){
						$era_name = "平成";
						$era_num = $i - 1988;
					}else{
						$era_name = $era_num = "";
					}
					if($era_num == 1){
						$era_num = "元";
					}
					if($era_name and $era_num){
						$era = " （".$era_name.$era_num."）";
					}else{
						$era = "";
					}
				}else{
					$era = "";
				}
				$A_era[] = $era;
				$A_year[] = $i;
			}
			for($i=0;$i<count($A_year);$i++){
					if($A_year[$i] == $value){
						$tmp_option_d[]="<option value=\"".$A_year[$i]."\" selected>".$A_year[$i].$A_era[$i]."";
					}else{
						$tmp_option_d[]="<option value=\"".$A_year[$i]."\">".$A_year[$i].$A_era[$i]."";
					}
			}
			$option_d=implode("\n",$tmp_option_d);

			echo "<select name=\"".$name."\" ".$option.">";
			if($null){
				echo 	"<option value=\"\">".$null;
			}
			echo 	$option_d;
			echo "</select>";
		}

	}
}
//------------------------------------------------------//
function difference_time($from,$to){
	$db = get_db_conn();

	if($from=="now"){
		$from=date("Y-m-d");
	}elseif($to=="now"){
		$to=date("Y-m-d");
	}

	$sql="select to_timestamp('".$from."', 'yyyy.mm.dd') - to_timestamp('".$to."', 'yyyy.mm.dd')";
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	$tmp=explode(" ",$RS[0]['?column?']);

	return $tmp[0];
}
//------------------------------------------------------//
//------------------------------------------------------//
function send_mail($mailto,$mailfrom,$mailfrom_address,$mailtitle,$mailcontents,$mailupfile){
	//-- 初期設定 --//
	$mailboundary =md5(uniqid(rand())); //バウンダリー文字（パートの境界）
	//-- 文字コード変更 --//
	$mailtitle="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($mailtitle,"JIS")).'?=';
	$mailfrom="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($mailfrom,"JIS")).'?=';
	//-- ヘッダー作成 --//
	$mailheader ="From: ".$mailfrom." <".$mailfrom_address.">\r\n";
	$mailheader.="Reply-To: ".$mailfrom_address."\n";
	$mailheader.="X-Mailer: PHP/".phpversion()."\n";
	$mailheader.="MIME-version: 1.0\n";
	for($i=0;$i<count($mailupfile);$i++){
		if($_FILES[$mailupfile[$i]]['tmp_name']){
			$is_upfile="true";
		}
	}
	if($is_upfile){ //アップファイルがあれば
		$mailheader.="Content-Type: multipart/mixed;\n";
		$mailheader.="\tboundary=\"".$mailboundary."\"\n";
		$mailheader.="This is a multi-part message in MIME format.\n\n";
		$mailheader.="--".$mailboundary."\n";
	}
	$mailheader.="Content-Type: text/plain; charset=ISO-2022-JP\n";
	$mailheader.="Content-Transfer-Encoding: 7bit";
	//-- ファイル添付 --//
	if($is_upfile){
		$mailattach="";
		for($i=0;$i<count($mailupfile);$i++){
			$mailupfile_tmp_name=$_FILES[$mailupfile[$i]]['tmp_name'];
			$mailupfile_name=$_FILES[$mailupfile[$i]]['name'];
			$mailupfile_name=mb_encode_mimeheader($mailupfile_name);
			$mailupfile_type=$_FILES[$mailupfile[$i]]['type'];
			if(file_exists($mailupfile_tmp_name)){
				$fp=fopen($mailupfile_tmp_name, "r") or die("error"); //ファイルの読み込み
				$contents=fread($fp, filesize($mailupfile_tmp_name));
				fclose($fp);
				$f_encoded=chunk_split(base64_encode($contents)); //エンコードして分割
				$mailattach.="\n\n--".$mailboundary."\n";
				$mailattach.="Content-Type: " . $mailupfile_type . ";\n";
				$mailattach.="\tname=\"".$mailupfile_name."\"\n";
				$mailattach.="Content-Transfer-Encoding: base64\n";
				$mailattach.="Content-Disposition: attachment;\n";
				$mailattach.="\tfilename=\"".$mailupfile_name."\"\n\n";
				$mailattach.="".$f_encoded."\n";
				$mailattach.="--".$mailboundary."--";
			}
		}
	}
	//-- 送信 --//
	for($i=0;$i<count($mailto);$i++){
		if(is_array($mailto[$i]['replace'])){
			foreach($mailto[$i]['replace'] as $key=>$value){
				$mailcontents=str_replace($key,$value,$mailcontents);
			}
		}
		$mailcontents=mb_convert_encoding($mailcontents,"JIS");
		$mailcontents.=$mailattach;
		if(mail($mailto[$i]['mail'],$mailtitle,$mailcontents,$mailheader)){ //ファイル添付に対応
			$result[]="1"; //成功
		}else{
			$result[]="0"; //失敗
		}
	}
	//-- 配列を返す --//
	return $result;
}
//------------------------------------------------------//
function send_mail2($mailto,$mailfrom,$mailfrom_address,$mailtitle,$mailcontents,$mailupfile){
	//-- 初期設定 --//
	$mailboundary =md5(uniqid(rand())); //バウンダリー文字（パートの境界）
	//-- 文字コード変更 --//
	$mailtitle="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($mailtitle,"JIS")).'?=';
	$mailfrom="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($mailfrom,"JIS")).'?=';
	//-- ヘッダー作成 --//
	$mailheader ="From: ".$mailfrom." <".$mailfrom_address.">\r\n";
	$mailheader.="Reply-To: ".$mailfrom_address."\n";
	$mailheader.="X-Mailer: PHP/".phpversion()."\n";
	$mailheader.="MIME-version: 1.0\n";
	for($i=0;$i<count($mailupfile);$i++){
		if($_FILES[$mailupfile[$i]]['tmp_name']){
			$is_upfile="true";
		}
	}
	if($is_upfile){ //アップファイルがあれば
		$mailheader.="Content-Type: multipart/mixed;\n";
		$mailheader.="\tboundary=\"".$mailboundary."\"\n";
		$mailheader.="This is a multi-part message in MIME format.\n\n";
		$mailheader.="--".$mailboundary."\n";
	}
	$mailheader.="Content-Type: text/plain; charset=ISO-2022-JP\n";
	$mailheader.="Content-Transfer-Encoding: 7bit";
	//-- ファイル添付 --//
	if($is_upfile){
		$mailattach="";
		for($i=0;$i<count($mailupfile);$i++){
			$mailupfile_tmp_name=$_FILES[$mailupfile[$i]]['tmp_name'];
			$mailupfile_name=$_FILES[$mailupfile[$i]]['name'];
			$mailupfile_name=mb_encode_mimeheader($mailupfile_name);
			$mailupfile_type=$_FILES[$mailupfile[$i]]['type'];
			if(file_exists($mailupfile_tmp_name)){
				$fp=fopen($mailupfile_tmp_name, "r") or die("error"); //ファイルの読み込み
				$contents=fread($fp, filesize($mailupfile_tmp_name));
				fclose($fp);
				$f_encoded=chunk_split(base64_encode($contents)); //エンコードして分割
				$mailattach.="\n\n--".$mailboundary."\n";
				$mailattach.="Content-Type: " . $mailupfile_type . ";\n";
				$mailattach.="\tname=\"".$mailupfile_name."\"\n";
				$mailattach.="Content-Transfer-Encoding: base64\n";
				$mailattach.="Content-Disposition: attachment;\n";
				$mailattach.="\tfilename=\"".$mailupfile_name."\"\n\n";
				$mailattach.="".$f_encoded."\n";
				$mailattach.="--".$mailboundary."--";
			}
		}
	}
	//-- 送信 --//
	for($i=0;$i<count($mailto);$i++){
		if(is_array($mailto['replace'])){
			foreach($mailto['replace'] as $key=>$value){
				$mailcontents=str_replace($key,$value,$mailcontents);
			}
		}
		$mailcontents=mb_convert_encoding($mailcontents,"JIS");
		$mailcontents.=$mailattach;

		if(mail($mailto['mail'][$i],$mailtitle,$mailcontents,$mailheader)){ //ファイル添付に対応
			$result[]="1"; //成功
		}else{
			$result[]="0"; //失敗
		}
	}
	//-- 配列を返す --//
	return $result;
}
//------------------------------------------------------//
function pic_object_date($object,$date){
	if($date){
		$day=date($object,strtotime($date));

		$day=str_replace("Sun","日",$day);
		$day=str_replace("Mon","月",$day);
		$day=str_replace("Tue","火",$day);
		$day=str_replace("Wed","水",$day);
		$day=str_replace("Thu","木",$day);
		$day=str_replace("Fri","金",$day);
		$day=str_replace("Sat","土",$day);
	}else{
		$day="";
	}
	return $day;
}
//------------------------------------------------------//
function make_zip_input($name_1,$name_2,$selected_1,$selected_2,$prev,$option_1,$option_2){
	if($prev){
		if($_REQUEST[$name_1]){
			$zip_1=$_REQUEST[$name_1];
		}else{
			$zip_1=$selected_1;
		}
		if($_REQUEST[$name_2]){
			$zip_2=$_REQUEST[$name_2];
		}else{
			$zip_2=$selected_2;
		}
			echo $zip_1."-".$zip_2."<input type=\"hidden\" name=\"".$name_1."\" value=\"".$zip_1."\"><input type=\"hidden\" name=\"".$name_2."\" value=\"".$zip_2."\">";
	}else{
		echo "<input type=\"text\" name=\"".$name_1."\" value=\"".$selected_1."\" size=\"3\" maxlength=\"3\" ".$option_1.">-<input type=\"text\" name=\"".$name_2."\" value=\"".$selected_2."\" size=\"4\" maxlength=\"4\" ".$option_2.">";
	}
}
//------------------------------------------------------//
function make_sex_radio($name,$default_selected,$selected,$prev,$option){
	if($prev){
		echo "<input type=\"hidden\" name=\"".$name."\" value=\"".$_REQUEST[$name]."\">".$_REQUEST[$name]."";
	}else{
		if($selected=="男性"){
			$mark_m="checked";
		}elseif($selected=="女性"){
			$mark_f="checked";
		}elseif($default_selected=="男性"){
			$mark_m="checked";
		}elseif($default_selected=="女性"){
			$mark_f="checked";
		}
		echo "<input type=\"radio\" name=\"".$name."\" value=\"男性\" ".$option." ".$mark_m.">男性 &nbsp;&nbsp;&nbsp; <input type=\"radio\" name=\"".$name."\" value=\"女性\" ".$option." ".$mark_f.">女性";
	}
}
//------------------------------------------------------//
function get_db_colum_name($table){
	global $db;
	global $G_db_name;

	$sql="select column_name from information_schema.columns";
	$sql.=" where table_catalog='".$G_db_name."'and table_name='".$table."'";
	$sql.=" order by ordinal_position";
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	for($i=0;$i<count($RS);$i++){
		$colum_name[]=$RS[$i]['column_name'];
	}

	return $colum_name;
}
//------------------------------------------------------//
function insert_db_same_name($request,$table,$add_clm_array,$add_value_array){
	global $db;
	global $G_db_name;

	$sql="select column_name from information_schema.columns";
	$sql.=" where table_catalog='".$G_db_name."' and table_name='".$table."'";

	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	foreach($RS as $key=>$value){
		$clm_name[]=$value['column_name'];
	}

	if($request){
		foreach($request as $key=>$value){
			if(isset($clm_name)){
				if(in_array($key,$clm_name) and !is_array($value)){
					$insert_clm[]='"'.$key.'"';
					$insert_value[]="'".addslashes($value)."'";
				}
			}
		}
	}

	if($add_clm_array){
		for($i=0;$i<count($add_clm_array);$i++){
			if(isset($clm_name)){
				if(in_array($add_clm_array[$i],$clm_name)){
					$insert_clm[]='"'.$add_clm_array[$i].'"';
					$insert_value[]="'".addslashes($add_value_array[$i])."'";
				}
			}
		}
	}
	if(count($insert_clm)){
		$sql="insert into ".$table." (".implode(",",$insert_clm).") values(".implode(",",$insert_value).")";
		$sql=sql_convert_null($sql);
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);		
	}
}
//------------------------------------------------------//
function insert_db_same_name_array($request,$table,$add_clm_array,$add_value_array,$req_key){
	global $db;
	global $G_db_name;

	$sql="select column_name from information_schema.columns";
	$sql.=" where table_catalog='".$G_db_name."'and table_name='".$table."'";
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	foreach($RS as $key=>$value){
		$clm_name[]=$value['column_name'];
	}

	if($request){
		foreach($request as $key=>$value){
			if(is_array($value)){
				if(isset($clm_name)){
					if(in_array($key,$clm_name)){
						$insert_clm[]=$key;
						$insert_value[]="'".$value[$req_key]."'";
					}
				}
			}else{
				if(isset($clm_name)){
					if(in_array($key,$clm_name) and !is_array($value)){
						$insert_clm[]=$key;
						$insert_value[]="'".$value."'";
					}
				}
			}
		}
	}

	if($add_clm_array){
		for($i=0;$i<count($add_clm_array);$i++){
			$insert_clm[]=$add_clm_array[$i];
			$insert_value[]="'".$add_value_array[$i]."'";
		}
	}

	$sql="insert into ".$table." (".implode(",",$insert_clm).") values(".implode(",",$insert_value).")";
	$sql=sql_convert_null($sql);
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
}
//------------------------------------------------------//
function update_db_same_name($request,$table,$add_clm_array,$add_value_array,$where){
	global $db;
	global $G_db_name;

	$sql="select column_name from information_schema.columns";
	$sql.=" where table_catalog='".$G_db_name."'and table_name='".$table."'";
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	foreach($RS as $key=>$value){
		$clm_name[]=$value['column_name'];
	}

	if($request){
		foreach($request as $key=>$value){
			if(isset($clm_name)){
				if(in_array($key,$clm_name)){
					$update_clm_val[]=$key."='".addslashes($value)."'";
				}
			}
		}
	}

	if($add_clm_array){
		if(isset($add_clm_array)){
			for($i=0;$i<count($add_clm_array);$i++){
				if(isset($clm_name)){
					if(in_array($add_clm_array[$i],$clm_name)){
						$update_clm_val[]=$add_clm_array[$i]."='".addslashes($add_value_array[$i])."'";
					}
				}
			}
		}
	}

	if(isset($update_clm_val)){
		$sql="update ".$table." set ".implode(",",$update_clm_val)."";
		if($where){
			$sql.=" where ".$where."";
		}
		$sql=sql_convert_null($sql);
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	}
}
//------------------------------------------------------//
function check_input($request,$key_array,$name_array){
	for($i=0;$i<count($key_array);$i++){
		if(array_key_exists($key_array[$i],$request)){
			if($request[$key_array[$i]]==""){
				return $name_array[$i];
			}
		}else{
			return $name_array[$i];
		}
	}
	return "0";
}
//------------------------------------------------------//
function resort_list($sort_rs,$sort_tbl,$colum_name_sort,$colum_name_cd,$return_path){
	global $db;

	if($_REQUEST['up']){
		foreach($sort_rs as $key=>$value){
			$array_sort[]=$value[$colum_name_sort];
		}
		for($i=0;$i<count($array_sort);$i++){
			if($array_sort[$i]==$_REQUEST['request_sort']){
				$pre=$i-1;
				$sql="update ".$sort_tbl." set ".$colum_name_sort."='".$_REQUEST['request_sort']."' where ".$colum_name_sort."='".$array_sort[$pre]."'";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
				$sql="update ".$sort_tbl." set ".$colum_name_sort."='".$array_sort[$pre]."' where ".$colum_name_cd."='".$_REQUEST['request_cd']."'";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
			}
		}
		header("location:".$return_path);
		exit;
	}elseif($_REQUEST['down']){
		foreach($sort_rs as $key=>$value){
			$array_sort[]=$value[$colum_name_sort];
		}
		for($i=0;$i<count($array_sort);$i++){
			if($array_sort[$i]==$_REQUEST['request_sort']){
				$next=$i+1;
				$sql="update ".$sort_tbl." set ".$colum_name_sort."='".$_REQUEST['request_sort']."' where ".$colum_name_sort."='".$array_sort[$next]."'";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
				$sql="update ".$sort_tbl." set ".$colum_name_sort."='".$array_sort[$next]."' where ".$colum_name_cd."='".$_REQUEST['request_cd']."'";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
			}
		}
		header("location:".$return_path);
		exit;
	}elseif($_REQUEST['move_over']){
		foreach($sort_rs as $key=>$value){
			$array_sort[]=$value[$colum_name_sort];
			$array_cd[]=$value[$colum_name_cd];
		}
		for($i=0;$i<count($array_cd);$i++){
			if($array_cd[$i]==$_REQUEST['move_cd']){
				$sql="update ".$sort_tbl." set ".$colum_name_sort."=".$colum_name_sort."+1 where ".$colum_name_sort.">=".$array_sort[$i]."";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
				$sql="update ".$sort_tbl." set ".$colum_name_sort."=".$array_sort[$i]." where ".$colum_name_cd."=".$_REQUEST['request_cd']."";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
			}
		}
		header("location:".$return_path);
		exit;
	}elseif($_REQUEST['move_under']){
		foreach($sort_rs as $key=>$value){
			$array_sort[]=$value[$colum_name_sort];
			$array_cd[]=$value[$colum_name_cd];
		}
		for($i=0;$i<count($array_cd);$i++){
			if($array_cd[$i]==$_REQUEST['move_cd']){
				$sql="update ".$sort_tbl." set ".$colum_name_sort."=".$colum_name_sort."+1 where ".$colum_name_sort.">".$array_sort[$i]."";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
				if($array_sort[$i+1]){
					$sql="update ".$sort_tbl." set ".$colum_name_sort."=".$array_sort[$i+1]." where ".$colum_name_cd."=".$_REQUEST['request_cd']."";
					$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
				}else{
					$sql="update ".$sort_tbl." set ".$colum_name_sort."=".$array_sort[$i]."+1 where ".$colum_name_cd."=".$_REQUEST['request_cd']."";
					$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
				}
			}
		}
		header("location:".$return_path);
		exit;
	}

}
//------------------------------------------------------//
function shot_cat($selected_a,$selected_b,$selected_c,$prev,$option,$null,$layer){
	global $db;

	if($prev==""){

		$sql="select * from mst_cat_a";
		$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
		$RS_cat_a=convert_rs($rs);

		if(count($RS_cat_a)){
			echo "<select name=\"cat_a_cd\" id=\"select_a\" onchange=\"Appear_display('select_b','')\" ".$option.">";

			if($null){
				echo "<option value=\"\">".$null."</option>";
			}
			for($i=0;$i<count($RS_cat_a);$i++) {
				if($RS_cat_a[$i]['cat_a_cd'] == $selected_a){
					echo "<option value=\"".$RS_cat_a[$i]['cat_a_cd']."\" selected>".$RS_cat_a[$i]['cat_a_name']."</option>";
				}else{
					echo "<option value=\"".$RS_cat_a[$i]['cat_a_cd']."\">".$RS_cat_a[$i]['cat_a_name']."</option>";
				}
			}

			echo "</select>";
			echo "<br />";
		}

		if($layer >= "2" and count($RS_cat_a)){
			for($i=0;$i<count($RS_cat_a);$i++){
				$sql="select * from mst_cat_b";
				$sql.=" where cat_a_cd='".$RS_cat_a[$i]['cat_a_cd']."'";
				$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
				$RS_cat_b=convert_rs($rs);
				if(count($RS_cat_b)){
					if($RS_cat_a[$i]['cat_a_cd']==$selected_a){
						echo "<div id=\"div_b_a".$RS_cat_a[$i]['cat_a_cd']."\" style=\"display:block;\">";
					}else{
						echo "<div id=\"div_b_a".$RS_cat_a[$i]['cat_a_cd']."\" style=\"display:none;\">";
					}
					echo "<select name=\"cat_b_cd[".$RS_cat_a[$i]['cat_a_cd']."]\" id=\"select_b_a".$RS_cat_a[$i]['cat_a_cd']."\" onchange=\"Appear_display('select_c','".$RS_cat_a[$i]['cat_a_cd']."')\" ".$option.">";

					if($null){
						echo "<option value=\"\">".$null."</option>";
					}
					for($j=0;$j<count($RS_cat_b);$j++) {
						if($RS_cat_b[$j]['cat_b_cd'] == $selected_b){
							echo "<option value=\"".$RS_cat_b[$j]['cat_b_cd']."\" selected>".$RS_cat_b[$j]['cat_b_name']."</option>";
						}else{
							echo "<option value=\"".$RS_cat_b[$j]['cat_b_cd']."\">".$RS_cat_b[$j]['cat_b_name']."</option>";
						}
						$array_cat_b_cd[]=$RS_cat_b[$j]['cat_b_cd'];
					}

					echo "</select>";
					echo "<br />";
					echo "</div>";
				}

				if($layer >= "3" and count($RS_cat_b)){
					for($k=0;$k<count($array_cat_b_cd);$k++){
						$sql="select * from mst_cat_c";
						$sql.=" where cat_b_cd='".$array_cat_b_cd[$k]."'";
						$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
						$RS_cat_c=convert_rs($rs);
						if(count($RS_cat_c)){
							if($array_cat_b_cd[$k]==$selected_b){
								echo "<div id=\"div_c_b".$array_cat_b_cd[$k]."\" style=\"display:block;\">";
							}else{
								echo "<div id=\"div_c_b".$array_cat_b_cd[$k]."\" style=\"display:none;\">";
							}
							echo "<select name=\"cat_c_cd[".$array_cat_b_cd[$k]."]\" id=\"select_c_b".$array_cat_b_cd[$k]."\" ".$option.">";

							if($null){
								echo "<option value=\"\">".$null."</option>";
							}
							for($l=0;$l<count($RS_cat_c);$l++) {
								if($RS_cat_c[$l]['cat_c_cd'] == $selected_c){
									echo "<option value=\"".$RS_cat_c[$l]['cat_c_cd']."\" selected>".$RS_cat_c[$l]['cat_c_name']."</option>";
								}else{
									echo "<option value=\"".$RS_cat_c[$l]['cat_c_cd']."\">".$RS_cat_c[$l]['cat_c_name']."</option>";
								}
								$array_cat_c_cd[]=$RS_cat_c[$l]['cat_c_cd'];
							}

							echo "</select>";
							echo "<br />";
							echo "</div>";
						}
					}
					unset($array_cat_b_cd);
				}
			}
		}


	}elseif($prev!=""){

		echo get_colum_key("mst_cat_a","cat_a_cd",$_REQUEST['cat_a_cd'],"cat_a_name","")."<input type=\"hidden\" name=\"cat_a_cd\" value=\"".$_REQUEST['cat_a_cd']."\" />";
		if($_REQUEST['cat_b_cd'][$_REQUEST['cat_a_cd']]){
			echo "<br />";
			echo "　?".get_colum_key("mst_cat_b","cat_b_cd",$_REQUEST['cat_b_cd'][$_REQUEST['cat_a_cd']],"cat_b_name","")."<input type=\"hidden\" name=\"cat_b_cd[".$_REQUEST['cat_a_cd']."]\" value=\"".$_REQUEST['cat_b_cd'][$_REQUEST['cat_a_cd']]."\" />";
			if($_REQUEST['cat_c_cd'][$_REQUEST['cat_b_cd'][$_REQUEST['cat_a_cd']]]){
				echo "<br />";
				echo "　　　?".get_colum_key("mst_cat_c","cat_c_cd",$_REQUEST['cat_c_cd'][$_REQUEST['cat_b_cd'][$_REQUEST['cat_a_cd']]],"cat_c_name","")."<input type=\"hidden\" name=\"cat_c_cd[".$_REQUEST['cat_b_cd'][$_REQUEST['cat_a_cd']]."]\" value=\"".$_REQUEST['cat_c_cd'][$_REQUEST['cat_b_cd'][$_REQUEST['cat_a_cd']]]."\" />";
			}
		}

	}
}
//------------------------------------------------------//
function copy_dir($org_path,$cp_path){
	if(!file_exists($cp_path)){
		mkdir($cp_path,0777);
		chmod($cp_path,0777);
	}
	$dh=opendir($org_path);
	while(($entry=readdir($dh))){
		if(!is_dir($org_path."/".$entry)){
			if(file_exists($cp_path."/".$entry)){
				copy($org_path."/".$entry,$cp_path."/".$entry);
			}else{
				copy($org_path."/".$entry,$cp_path."/".$entry);
				chmod($cp_path."/".$entry,0777);
			}
		}elseif(is_dir($org_path."/".$entry) and !ereg("^\.+",$entry)){
			if(!is_dir($cp_path."/".$entry)){
				mkdir($cp_path."/".$entry,0777);
				chmod($cp_path."/".$entry,0777);
			}

			copy_dir($org_path."/".$entry,$cp_path."/".$entry);
		}
	}
	closedir($dh);
}
//------------------------------------------------------//
function rm_dir($rm_dir){
	if(is_dir($rm_dir)){
		$dh=opendir($rm_dir);
		while(($entry=readdir($dh))){
			if(!is_dir($rm_dir."/".$entry)){
				unlink($rm_dir."/".$entry);
			}elseif(is_dir($rm_dir."/".$entry) and !ereg("^\.+",$entry)){
				if(count(glob($rm_dir."/".$entry."/*"))){
					rm_dir($rm_dir."/".$entry);
					if(is_dir($rm_dir."/".$entry)){
						rmdir($rm_dir."/".$entry);
					}
				}else{
					rmdir($rm_dir."/".$entry);
				}
			}
		}
		closedir($dh);
		rmdir($rm_dir);
	}
}
//------------------------------------------------------//
function rm_file($rm_file){
	preg_match("/(.*)\/(.*)\.(.*)$/",$rm_file,$matches);
	if($matches[3]=="*"){
		$dh=opendir($matches[1]);
		while(($entry=readdir($dh))){
			if(ereg($matches[2]."\.(.+)",$entry)){
				unlink($matches[1]."/".$entry);
			}
		}
	}else{
		unlink($matches[0]);
	}
}
//------------------------------------------------------//
function date_format_in($year,$month,$day,$name,$prefix="F"){
	if($year && $month && $day){
		while (1) {
			if (checkdate($month, $day, $year)) {
				$month = sprintf('%02d',$month);
				$day = sprintf('%02d',$day);
				$GLOBALS[$prefix."_".$name] = $year."-".$month."-".$day;
				break;
			}else{
				$day = $day -1;
			}
		}
	}else{
		$GLOBALS[$prefix."_".$name]=null;
	}
}
// 日付を分割する関数
function date_format_out($date,$name,$prefix="F"){
	if($date){
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		$day = substr($date,8,2);

		$name_y= $prefix."_".$name."_y";
		$name_m= $prefix."_".$name."_m";
		$name_d= $prefix."_".$name."_d";
		$GLOBALS[$name_y] = $year;
		$GLOBALS[$name_m] = $month;
		$GLOBALS[$name_d] = $day;
	}
}

//指定月の毎月の請求をチェック
function check_acpt($F_hp_cd,$year,$month){
	global $db;
	global $G_db_name;

	$sql="select sum(acpt_money) as money from tbl_acpt_mng";
	$sql.=" where acpt_date like '".sprintf("%04d", $year)."-".sprintf("%02d", $month)."%'";
	//$sql.=" and acpt_kbn=1";
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);
	if(count($RS)){
		return($RS[0]['money']);
	}
}
//カテゴリ名取得
//function get_cat_name($F_cat_a_cd,$F_cat_b_cd,$F_cat_c_cd){
//	global $db;
//	global $G_db_name;
//
//	echo get_colum_key("mst_cat_a","cat_a_cd",$F_cat_a_cd,"cat_a_name","")."";
//	if($F_cat_b_cd){
//		echo "<br />";
//		echo "⇒".get_colum_key("mst_cat_b","cat_b_cd",$F_cat_b_cd,"cat_b_name","")."";
//		if($F_cat_a_cd && $F_cat_b_cd && $F_cat_c_cd){
//			echo "<br />";
//			echo " ⇒".get_colum_key("mst_cat_c","cat_c_cd",$F_cat_c_cd,"cat_c_name","")."";
//		}
//	}
//}
//------------------------------------------------------//
function count_record($table,$where){
	global $db;

	$sql="select count(*) from ".$table."";
	if($where){
		$sql.=" where ".$where."";
	}
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	$record_count=$RS[0]['count'];

	return $record_count;
}
//------------------------------------------------------//
//年月からの請求・入金金額を表示
function view_acp_data($kbn,$year,$month,$day=""){
	global $db;
	global $G_db_name;

	//未請求
	if($kbn==1){
		$sql="select sum(acpt_req_money) as money from tbl_acpt_mng";
		if($day){
			$sql.=" where acpt_req_date like '".sprintf("%04d", $year)."-".sprintf("%02d", $month)."-".sprintf("%02d", $day)."%'";
		}else{
			$sql.=" where acpt_req_date like '".sprintf("%04d", $year)."-".sprintf("%02d", $month)."%'";
		}
		$sql.=" and acpt_req_flg !=1";
	//請求済
	}elseif($kbn==2){
		$sql="select sum(acpt_req_money) as money from tbl_acpt_mng";
		if($day){
			$sql.=" where acpt_req_date like '".sprintf("%04d", $year)."-".sprintf("%02d", $month)."-".sprintf("%02d", $day)."%'";
		}else{
			$sql.=" where acpt_req_date like '".sprintf("%04d", $year)."-".sprintf("%02d", $month)."%'";
		}
		$sql.=" and acpt_req_flg =1";
	//入金
	}elseif($kbn==3){
		$sql="select sum(acpt_money) as money from tbl_acpt_mng";
		if($day){
			$sql.=" where acpt_date like '".sprintf("%04d", $year)."-".sprintf("%02d", $month)."-".sprintf("%02d", $day)."%' ";
		}else{
			$sql.=" where acpt_date like '".sprintf("%04d", $year)."-".sprintf("%02d", $month)."%'";
		}
	}
	//$sql.=" and acpt_kbn=1";

	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);
	if(count($RS)){
		return($RS[0]['money']);
	}
}
//------------------------------------------------------//
function print_a($array){
	global $G_count;
	if(!$G_count){
		$G_count=1;
	}
	$count=$G_count;

	for($i=0;$i<$count*5;$i++){
		$tmp_apace[]="&nbsp;";
	}
	$space=implode("",$tmp_apace);
	unset($tmp_apace);

	if(is_array($array)){
		while(!$flg_end){
			echo "Array ( <br />";
			foreach($array as $key=>$value){
				if(is_array($value)){
					echo $space."[".$key."] => ";
					$G_count=$G_count+1;
					print_a($value);
				}else{
					echo $space."[".$key."] => ".$value."<br />";
					$flg_end="1";
				}
			}
			//echo $space.")<br />";
		}
	}else{
		echo $array;
	}
	unset($G_count);
}
//------------------------------------------------------//
function resize_image($path, $file, $width, $height, $another_name, $flg_notrim=""){
	$file_path = $path."/".$file;
	
	if($flg_notrim){
		resize_gd($file_path, $width, $height, $file_dir_name_new, "1");
	}else{
		$A_size = GetImageSize($file_path);
		$w = $A_size[0];
		$h = $A_size[1];

		$thumb = new Image($file_path);
		if($another_name){
			preg_match("/^.+(\.[^.]+)$/", $file, $A_match);
			$ext = $A_match[1];
			$name_tmp = "_tmp";
			$file_tmp = $name_tmp.$ext;
			$file_path = $path."/".$file_tmp;
			$thumb->name($name_tmp);
		}
		$rate_org = $w / $h;
		$rate_new = $width / $height;
		if($rate_org >= $rate_new){
			$thumb->height($height);
		}else{
			$thumb->width($width);
		}
		$thumb->save();

		$A_size = GetImageSize($file_path);
		$w = $A_size[0];
		$h = $A_size[1];

		if($another_name){
			$thumb = new Image($file_path);
			$thumb->name($another_name);
		}
		$thumb->width($width); 
		$thumb->height($height);
		$x = floor(($w-$width)/2);
		$y = floor(($h-$height)/2);
		$thumb->crop($x,$y); 
		$thumb->save();

		if($another_name){
			unlink($file_path);
		}
	}
}
//------------------------------------------------------//
function resize_gd($file_path,$width,$height,$file_dir_name_new,$flg_background){
	// --1
	// 画像を読み込む。
	preg_match("/\.(.+)$/",$file_path,$matches);
	$type=$matches[1];
	if($type == "jpg" or $type == "jpeg"){
		$image = ImageCreateFromJPEG($file_path); //JPEGファイルを読み込む
	}elseif($type == "gif"){
		$image = ImageCreateFromGIF($file_path); //GIFファイルを読み込む
	}elseif($type == "png" or $type == "ping"){
		$image = ImageCreateFromPNG($file_path); //PNGファイルを読み込む
	}else{
		echo "ファイル形式エラー";
		exit;
	}

	// --2
	// 画像のサイズを取得。
	$width_org = ImageSX($image); //横幅（ピクセル）
	$height_org = ImageSY($image); //縦幅（ピクセル）

	// --3
	// 縮小した画像のサイズを決める。
	// 例えば、幅を100ピクセルに固定したい場合は以下のとおり。
	//$width = 100;
	if($width and $height){
		if($width/$height <= $width_org/$height_org){
			$rate = $width / $width_org; //圧縮比
			$height_new = $rate * $height_org;
			$width_new = $width;
		}elseif($width/$height >= $width_org/$height_org){
			$rate = $height / $height_org; //圧縮比
			$width_new = $rate * $width_org;
			$height_new = $height;
		}
	}elseif($width){
		$rate = $width / $width_org; //圧縮比
		$height_new = $rate * $height_org;
		$width_new = $width;
	}elseif($height){
		$rate = $height / $height_org; //圧縮比
		$width_new = $rate * $width_org;
		$height_new = $height;
	}

	// --4
	// 空の画像を作成する。
	$new_image = ImageCreateTrueColor($width_new, $height_new);

	// --5
	// 画像を普通にリサイズコピーする場合。
	//ImageCopyResized($new_image,$image,0,0,0,0,$width_new,$height_new,$width_org,$height_org);
	// サンプリングしなおす場合。
	ImageCopyResampled($new_image,$image,0,0,0,0,$width_new,$height_new,$width_org,$height_org);

	// --5.5
	// 画像を重ねる場合。
	//if($F_lay){
	//	$file_layer = $G_root_path.$F_lay;
	//	$layer_img=ImageCreateFromPng($file_layer);
	//	$width_layer = ImageSX($layer_img);
	//	$height_layer = ImageSY($layer_img);
	//	$cd_x = ($width_new-$width_layer)/2;
	//	$cd_y = ($height_new-$height_layer)/2;
	//	ImageCopy($new_image, $layer_img, $cd_x, $cd_y, 0, 0, $width_layer, $height_layer);
	//}

	if($flg_background and $width and $height){
		$back_image = ImageCreateTrueColor($width , $height); //背景イメージを作成
		imagefill($back_image , 0 , 0 , 0xFFFFFF); //0,0の位置から色0xFFFFFF（白）で塗りつぶす
		ImageCopy($back_image, $new_image, ($width-$width_new)/2, ($height-$height_new)/2, 0,0, $width_new, $height_new); //画像を合成
		$new_image = $back_image;
	}

	// --6
	// ブラウザに出力する場合。
	//if($type == "jpg" or $type == "jpeg"){
	//	ImageJPEG($new_image);
	//}elseif($type == "gif"){
	//	ImageGIF($new_image); //環境によっては使えない
	//}elseif($type == "png" or $type == "ping"){
	//	ImagePNG($new_image);
	//}
	// ファイルに保存する場合。
	if($file_dir_name_new){
		$file_path=$file_dir_name_new;
	}
	if($type == "jpg" or $type == "jpeg"){
		ImageJPEG($new_image, $file_path, 100); //３つ目の引数はクオリティー
	}elseif($type == "gif"){
		ImageGIF($new_image, $file_path); //環境によっては使えない
	}elseif($type == "png" or $type == "ping"){
		ImagePNG($new_image, $file_path);
	}

	// --7
	// ちゃんとメモリを解放する。※これを怠るとサーバ  るかもねーｗ
	if($back_image){
		imagedestroy ($back_image);
	}else{
		imagedestroy ($new_image); //サムネイル用イメージIDの破棄 ※3
	}
	imagedestroy ($image); //サムネイル元イメージIDの破棄 ※4
	//imagedestroy ($layer_img);
}
//------------------------------------------------------//
function make_gd_img($file_path,$file_noimg,$width,$height,$layer_path,$option) {
	global $G_img_dir;
	global $G_root_path;

	preg_match("/(.*)\/(.+)\.(.+)$/",$file_path,$matches);

	if($matches[3]=="*"){
		$A_type=array("jpg","png","gif");
		for($i=0;$i<count($A_type);$i++) {
			$fp=str_replace("*",$A_type[$i],$G_root_path.$file_path);
			if(file_exists($fp)){
				$file_path_new=str_replace("*",$A_type[$i],$file_path);
				echo "<img src=\"".$G_img_dir."/GD.php?fp=".$file_path_new."&w=".$width."&h=".$height."&lay=".$layer_path."\" ".$option." />";
			}
		}
		if(!$file_path_new){
			echo "<img src=\"".$G_img_dir."/GD.php?fp=".$file_noimg."&w=".$width."&h=".$height."&lay=".$layer_path."\" ".$option." />";
		}
	}else{
		if(file_exists($G_root_path.$file_path)){
			echo "<img src=\"".$G_img_dir."/GD.php?fp=".$file_path."&w=".$width."&h=".$height."&lay=".$layer_path."\" ".$option." />";
		}elseif(file_exists($G_root_path.$file_noimg)){
			echo "<img src=\"".$G_img_dir."/GD.php?fp=".$file_noimg."&w=".$width."&h=".$height."&lay=".$layer_path."\" ".$option." />";
		}
	}
}
//------------------------------------------------------//
function make_gd_img_path($file_path,$file_noimg,$width,$height,$layer_path) {
	global $G_img_dir;
	global $G_root_path;

	preg_match("/(.*)\/(.+)\.(.+)$/",$file_path,$matches);

	if($matches[3]=="*"){
		$A_type=array("jpg","png","gif");
		for($i=0;$i<count($A_type);$i++) {
			$fp=str_replace("*",$A_type[$i],$G_root_path.$file_path);
			if(file_exists($fp)){
				$file_path_new=str_replace("*",$A_type[$i],$file_path);
				echo $G_img_dir."/GD.php?fp=".$file_path_new."&w=".$width."&h=".$height."&lay=".$layer_path;
			}
		}
		if(!$file_path_new){
			echo $G_img_dir."/GD.php?fp=".$file_noimg."&w=".$width."&h=".$height."&lay=".$layer_path;
		}
	}else{
		if(file_exists($G_root_path.$file_path)){
			echo $G_img_dir."/GD.php?fp=".$file_path."&w=".$width."&h=".$height."&lay=".$layer_path;
		}elseif(file_exists($G_root_path.$file_noimg)){
			echo $G_img_dir."/GD.php?fp=".$file_noimg."&w=".$width."&h=".$height."&lay=".$layer_path;
		}
	}
}
//------------------------------------------------------//
function make_img($file_path,$file_noimg,$width,$height,$option) {
	global $G_img_dir;
	global $G_root_path;

	preg_match("/(.*)\/(.+)\.(.+)$/",$file_path,$matches);

	if($matches[3]=="*"){
		$A_type=array("jpg","png","gif");
		for($i=0;$i<count($A_type);$i++) {
			$fp=str_replace("*",$A_type[$i],$G_root_path.$file_path);
			if(file_exists($fp)){
				$file_path_new=str_replace("*",$A_type[$i],$file_path);

				preg_match("/(.*)\/(.+)\.(.+)$/",$fp,$matches);
				$type=$matches[3];
				if($type == "jpg" or $type == "jpeg"){
					$image = ImageCreateFromJPEG($fp); //JPEGファイルを読み込む
				}elseif($type == "gif"){
					$image = ImageCreateFromGIF($fp); //GIFファイルを読み込む
				}elseif($type == "png" or $type == "ping"){
					$image = ImageCreateFromPNG($fp); //PNGファイルを読み込む
				}
				$width_org = ImageSX($image);
				$height_org = ImageSY($image);
				if($width and $height){
					if($width/$height <= $width_org/$height_org){
						$rate = $width / $width_org; //圧縮比
						$height = $rate * $height_org;
					}elseif($width/$height >= $width_org/$height_org){
						$rate = $height / $height_org; //圧縮比
						$width = $rate * $width_org;
					}
				}elseif($width){
					$rate = $width / $width_org; //圧縮比
					$height = $rate * $height_org;
				}elseif($height){
					$rate = $height / $height_org; //圧縮比
					$width = $rate * $width_org;
				}

				if($width and $height){
					echo "<img src=\"".$file_path_new."\" width=\"".$width."\" height=\"".$height."\" ".$option." />";
				}else{
					echo "<img src=\"".$file_path_new."\" ".$option." />";
				}
			}
		}
		if(!$file_path_new and $file_noimg){

			preg_match("/(.*)\/(.+)\.(.+)$/",$G_root_path.$file_noimg,$matches);
			$type=$matches[3];
			if($type == "jpg" or $type == "jpeg"){
				$image = ImageCreateFromJPEG($G_root_path.$file_noimg); //JPEGファイルを読み込む
			}elseif($type == "gif"){
				$image = ImageCreateFromGIF($G_root_path.$file_noimg); //GIFファイルを読み込む
			}elseif($type == "png" or $type == "ping"){
				$image = ImageCreateFromPNG($G_root_path.$file_noimg); //PNGファイルを読み込む
			}
			$width_org = ImageSX($image);
			$height_org = ImageSY($image);
			if($width and $height){
				if($width/$height <= $width_org/$height_org){
					$rate = $width / $width_org; //圧縮比
					$height = $rate * $height_org;
				}elseif($width/$height >= $width_org/$height_org){
					$rate = $height / $height_org; //圧縮比
					$width = $rate * $width_org;
				}
			}elseif($width){
				$rate = $width / $width_org; //圧縮比
				$height = $rate * $height_org;
			}elseif($height){
				$rate = $height / $height_org; //圧縮比
				$width = $rate * $width_org;
			}

			if($width and $height){
				echo "<img src=\"".$file_noimg."\" width=\"".$width."\" height=\"".$height."\" ".$option." />";
			}else{
				echo "<img src=\"".$file_noimg."\" ".$option." />";
			}
		}
	}else{
		if(file_exists($G_root_path.$file_path)){
			$file_name=$file_path;
		}elseif(file_exists($G_root_path.$file_noimg)){
			$file_name=$file_noimg;
		}

		preg_match("/(.*)\/(.+)\.(.+)$/",$G_root_path.$file_name,$matches);
		$type=$matches[3];
		if($type == "jpg" or $type == "jpeg"){
			$image = ImageCreateFromJPEG($G_root_path.$file_name); //JPEGファイルを読み込む
		}elseif($type == "gif"){
			$image = ImageCreateFromGIF($G_root_path.$file_name); //GIFファイルを読み込む
		}elseif($type == "png" or $type == "ping"){
			$image = ImageCreateFromPNG($G_root_path.$file_name); //PNGファイルを読み込む
		}
		$width_org = ImageSX($image);
		$height_org = ImageSY($image);
		if($width and $height){
			if($width/$height <= $width_org/$height_org){
				$rate = $width / $width_org; //圧縮比
				$height = $rate * $height_org;
			}elseif($width/$height >= $width_org/$height_org){
				$rate = $height / $height_org; //圧縮比
				$width = $rate * $width_org;
			}
		}elseif($width){
			$rate = $width / $width_org; //圧縮比
			$height = $rate * $height_org;
		}elseif($height){
			$rate = $height / $height_org; //圧縮比
			$width = $rate * $width_org;
		}

		if($width and $height){
			echo "<img src=\"".$file_name."\" width=\"".$width."\" height=\"".$height."\" ".$option." />";
		}else{
			echo "<img src=\"".$file_name."\" ".$option." />";
		}
	}
}
//------------------------------------------------------//
function make_img_path($file_path,$file_noimg) {
	global $G_img_dir;
	global $G_root_path;

	preg_match("/(.*)\/(.+)\.(.+)$/",$file_path,$matches);

	if($matches[3]=="*"){
		$A_type=array("jpg","png","gif");
		for($i=0;$i<count($A_type);$i++) {
			$fp=str_replace("*",$A_type[$i],$G_root_path.$file_path);
			if(file_exists($fp)){
				$file_path_new=str_replace("*",$A_type[$i],$file_path);
				echo $file_path_new;
			}
		}
		if(!$file_path_new){
			echo $file_noimg;
		}
	}else{
		echo $file_path;
		if(file_exists($G_root_path.$file_path)){
			echo $file_path;
		}elseif(file_exists($G_root_path.$file_noimg)){
			echo $file_noimg;
		}
	}
}
//------------------------------------------------------//
function file_exists_expression($path,$expression) {
	$dir=$path;
	if(is_dir($dir)){
		$dh=opendir($dir);
		while(($entry=readdir($dh))){
			if(!is_dir($dir."/".$entry)){
				preg_match("/".$expression."/",$entry,$matches);
				if($matches[0]){
					return $matches;
				}
			}
		}
		closedir($dh);
	}
}
//------------------------------------------------------//
function separate_extension($file_name) {
	preg_match("/^(.+)\.(.+)$/",$file_name,$matches);
	$result[]=$matches[0];
	$result[]=$matches[1];
	$result[]=strtolower($matches[2]);

	return $result;
}
//------------------------------------------------------//
function make_list($table,$amt,$seg,$page,$where,$option,$href,$param){
	//$page   // 表示するページ
	//$option // whereやorder文
	//$table  // リスト表示するテーブル
	//$amt    // 1ページに表示する件数
	//$seg    // 表示するページングの数
	//$param  // 追加するパラメーター

	global $db;

	if(!$page){
		$page="1";
	}

	$sql="select count(*) from ".$table;
	if($where){
		$sql.=" where ".$where;
	}
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS_count=convert_rs($rs);

	$count = $RS_count[0]['count']; // 全件数
	$page_prev = $page-1;
	$page_next = $page+1;

	if($param){
		$param = "?".$param;
	}

	$number_rest = $count%$amt;        // 余り件数
	if($number_rest=="0"){
		$number_page = floor($count/$amt); // ページ数
	}else{
		$number_page = floor($count/$amt)+1; // ページ数
	}
	if($seg > $number_page){
		$seg=$number_page;
	}

	$limit = ($page-1)*$amt;

	$sql="select * from ".$table;
	if($where){
		$sql.=" where ".$where;
	}
	$sql.=" ".$option;
	$sql.=" limit ".$amt." offset ".$limit;
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	$sql="select count(*) from ".$table;
	if($where){
		$sql.=" where ".$where;
	}
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS_amount=convert_rs($rs);
	$amount=$RS_amount[0]['count'];
	$condition=$where;

	if($number_page > 1){
		$uper=floor($seg/2);
		$under=($seg-$uper)-1;
		$min=$page-$under;
		$max=($min-1)+$seg;
		if($number_page < $max){
			$max = $number_page;
			$min = $number_page-($seg-1);
		}elseif($min < 1){
			$max = 1+($seg-1);
			$min = "1";
		}

		for($i=$min;$i<=$max;$i++) {
			if($i==$page){
				$A_page_list[]="[<b>".$i."</b>]";
			}else{
				$A_page_list[]="<a href=\"".$href.$i."/".$param."\">[<b>".$i."</b>]</a>";
			}
		}
		$page_list=implode("　",$A_page_list);

		if($page=="1"){
			$paging=$page_list." <a href=\"".$href.$page_next."/".$param."\">next</a>";
		}elseif($page==$number_page){
			$paging="<a href=\"".$href.$page_prev."/".$param."\">prev</a> ".$page_list;
		}else{
			$paging="<a href=\"".$href.$page_prev."/".$param."\">prev</a> ".$page_list." <a href=\"".$href.$page_next."/".$param."\">next</a>";
		}
	}

	return array("rs"=>$RS,"paging"=>$paging,"count"=>$number_page,"page"=>$page,"amount"=>$amount,"condition"=>$condition);
}
function make_list_original($table,$amt,$seg,$page,$where,$option,$href,$param){
	//$page   // 表示するページ
	//$option // whereやorder文
	//$table  // リスト表示するテーブル
	//$amt    // 1ページに表示する件数
	//$seg    // 表示するページングの数
	//$param  // 追加するパラメーター

	global $db;

	if(!$page){
		$page="1";
	}

	$sql="select count(*) from ".$table;
	if($where){
		$sql.=" where ".$where;
	}
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS_count=convert_rs($rs);

	$count = $RS_count[0]['count']; // 全件数
	$page_prev = $page-1;
	$page_next = $page+1;

	if($param){
		$param = "&".$param;
	}

	$number_rest = $count%$amt;        // 余り件数
	if($number_rest=="0"){
		$number_page = floor($count/$amt); // ページ数
	}else{
		$number_page = floor($count/$amt)+1; // ページ数
	}
	if($seg > $number_page){
		$seg=$number_page;
	}

	$limit = ($page-1)*$amt;

	$sql="select * from ".$table;
	if($where){
		$sql.=" where ".$where;
	}
	$sql.=" ".$option;
	$sql.=" limit ".$amt." offset ".$limit;
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	$sql="select count(*) from ".$table;
	if($where){
		$sql.=" where ".$where;
	}
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS_amount=convert_rs($rs);
	$amount=$RS_amount[0]['count'];
	$condition=$where;

	if($number_page > 1){
		$uper=floor($seg/2);
		$under=($seg-$uper)-1;
		$min=$page-$under;
		$max=($min-1)+$seg;
		if($number_page < $max){
			$max = $number_page;
			$min = $number_page-($seg-1);
		}elseif($min < 1){
			$max = 1+($seg-1);
			$min = "1";
		}

		for($i=$min;$i<=$max;$i++) {
			if($i==$page){
				$A_page_list[]="[<b>".$i."</b>]";
			}else{
				$A_page_list[]="<a href=\"".$href."?page=".$i.$param."\">[<b>".$i."</b>]</a>";
			}
		}
		$page_list=implode("　",$A_page_list);

		if($page=="1"){
			$paging=$page_list." <a href=\"".$href."?page=".$page_next.$param."\">next</a>";
		}elseif($page==$number_page){
			$paging="<a href=\"".$href."?page=".$page_prev.$param."\">prev</a> ".$page_list;
		}else{
			$paging="<a href=\"".$href."?page=".$page_prev.$param."\">prev</a> ".$page_list." <a href=\"".$href."?page=".$page_next.$param."\">next</a>";
		}
	}

	return array("rs"=>$RS,"paging"=>$paging,"count"=>$number_page,"page"=>$page,"amount"=>$amount,"condition"=>$condition);
}

//------------------------------------------------------//

function make_cat_tree($mode,$selected_cat_cd){

	function make_cat_tree_include($cat_list,$mode,$selected_cat_cd){
		foreach($cat_list as $cat_name=>$value){
				$cat_cd=$value[0];
				unset($value[0]);

				if($mode=="regist"){
					echo '			<li><a href="javascript:PassInput(\'id_from_'.$cat_cd.'\',\'id_to\');">'.$cat_name.'</a><input type="hidden" id="id_from_'.$cat_cd.'" name="" value="'.$cat_cd.'">';
				}elseif($mode=="regist2"){
					if(is_array($selected_cat_cd)){
						if(in_array($cat_cd,$selected_cat_cd)){
							$checked="checked";
						}
					}else{
						if($cat_cd==$selected_cat_cd){
							$checked="checked";
						}
					}
					echo '			<li><a href="javascript:CheckCheckBox(\'id_to_'.$cat_cd.'\');">'.$cat_name.'</a><input type="checkbox" id="id_to_'.$cat_cd.'" name="cat_cd[]" value="'.$cat_cd.'" '.$checked.' />';
					unset($checked);
				}else{
					echo '			<li><a href="/item/cat/'.$cat_cd.'/">'.$cat_name.'</a>';
				}
				if(!empty($value)){
					echo '			<ul id="sitemap">';
												make_cat_tree_include($value,$mode,$selected_cat_cd);
					echo '			</ul>';
				}
				echo '			</li>';
		}
	}


	global $db;
	global $G_db_name;
	global $_REQUEST;
	global $F_prev;

	$table="v_cat";
	$sql="select column_name from information_schema.columns";
	$sql.=" where table_catalog='".$G_db_name."'and table_name='".$table."'";
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS_colum=convert_rs($rs);

	for($i=0;$i<count($RS_colum);$i++) {
		preg_match("/^cat_([0-9]+)_name$/",$RS_colum[$i]['column_name'],$matches);
		if($matches[0]){
			$A_cat_name[$matches[1]]=$matches[0];
		}
		preg_match("/^cat_([0-9]+)_sort$/",$RS_colum[$i]['column_name'],$matches);
		if($matches[0]){
			$A_cat_sort[$matches[1]]=$matches[0]." is not null,".$matches[0];
		}
	}
	ksort($A_cat_name);
	ksort($A_cat_sort);

	$order_by=implode(",",$A_cat_sort);

	$sql="select * from v_cat";
	$sql.=" order by ".$order_by;
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);


//		for($i=0;$i<count($RS);$i++) {
//			if($RS[$i][$A_cat_name[2]]){
//				if($RS[$i][$A_cat_name[3]]){
//					$A_cat[$RS[$i][$A_cat_name[1]]][$RS[$i][$A_cat_name[2]]][$RS[$i][$A_cat_name[3]]][0] = $RS[$i]['cat_cd'];
//				}else{
//					$A_cat[$RS[$i][$A_cat_name[1]]][$RS[$i][$A_cat_name[2]]][0] = $RS[$i]['cat_cd'];
//				}
//			}else{
//				$A_cat[$RS[$i][$A_cat_name[1]]][0] = $RS[$i]['cat_cd'];
//			}
//		}


	for($i=0;$i<count($RS);$i++) {
		if($RS[$i]['cat_2_name']){
			if($RS[$i]['cat_3_name']){
				$A_cat[$RS[$i]['cat_1_name']][$RS[$i]['cat_2_name']][$RS[$i]['cat_3_name']][0] = $RS[$i]['cat_cd'];
			}else{
				$A_cat[$RS[$i]['cat_1_name']][$RS[$i]['cat_2_name']][0] = $RS[$i]['cat_cd'];
			}
		}else{
			$A_cat[$RS[$i]['cat_1_name']][0] = $RS[$i]['cat_cd'];
		}
	}

	if($mode=="regist"){
		for($i=0;$i<count($RS);$i++) {
			foreach($A_cat_name as $key=>$value){
				if($RS[$i][$value]){
					$A_cat_tree[$i][]=$RS[$i][$value];
				}
			}
			$cat_tree=implode("-",$A_cat_tree[$i]);
			$RS_cat_tree[]=array("cat_cd"=>$RS[$i]['cat_cd'],"cat_tree"=>$cat_tree);
		}
		if(is_array($selected_cat_cd)){
			$selected_cat_cd=$selected_cat_cd[0];
		}
		echo 			shot_select("item_cat_cd",$selected_cat_cd,$F_prev,$RS_cat_tree,"cat_cd","cat_tree","id=\"id_to\"","カテゴリを選択");
		//echo '		<input type="text" value="" id="id_to" style="width:160px; border:0px; font-weight:bold; background:#ffffff;" readonly="readonly" />';
	}elseif($mode=="regist2"){

	}
	echo '		<ul id="sitemap">';
									make_cat_tree_include($A_cat,$mode,$selected_cat_cd);
	echo '		</ul>';
}
//------------------------------------------------------//
function get_cat_name($mode,$cat_cd){
	global $db;
	global $G_db_name;

	$table="v_cat";
	$sql="select column_name from information_schema.columns";
	$sql.=" where table_catalog='".$G_db_name."'and table_name='".$table."'";
	$rs=exec_sql($db,$sql,$_SERVER["SCRIPT_NAME"]);
	$RS_colum=convert_rs($rs);

	for($i=0;$i<count($RS_colum);$i++) {
		preg_match("/^cat_([0-9]+)_name$/",$RS_colum[$i]['column_name'],$matches);
		if($matches[0]){
			$A_cat_name[$matches[1]]=$matches[0];
		}
		preg_match("/^cat_([0-9]+)_sort$/",$RS_colum[$i]['column_name'],$matches);
		if($matches[0]){
			$A_cat_sort[$matches[1]]=$matches[0]." is not null,".$matches[0];
		}
		preg_match("/^cat_([0-9]+)_cd$/",$RS_colum[$i]['column_name'],$matches);
		if($matches[0]){
			$A_cat_cd[$matches[1]]=$matches[0];
		}
	}
	ksort($A_cat_name);
	ksort($A_cat_sort);
	ksort($A_cat_cd);

	$order_by=implode(",",$A_cat_sort);

	$sql="select * from v_cat";
	$sql.=" order by ".$order_by;
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS_v_cat=convert_rs($rs);

	$sql="select * from v_cat";
	$sql.=" where cat_cd='".$cat_cd."'";
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);

	foreach($A_cat_name as $key=>$value){
		if($RS[0][$value]){
			$RS_tmp=rs_filter($RS_v_cat,$A_cat_cd[$key],$RS[0][$A_cat_cd[$key]],"","");
			$A_footprints[]='<a href="/item/cat/'.$RS_tmp[0]['cat_cd'].'">'.$RS[0][$value].'</a>';
			$cat_name_now=$RS[0][$value];
			$where_cat_name_cd=$A_cat_cd[$key]."=".$RS[0][$A_cat_cd[$key]];
		}
	}
	$footprints=implode("＞",$A_footprints);

	$sql="select * from v_cat";
	$sql.=" where ".$where_cat_name_cd;
	$rs=exec_sql($db,$sql,$SERVER["SCRIPT_NAME"]);
	$RS=convert_rs($rs);
	for($i=0;$i<count($RS);$i++) {
		//$A_where[]="item_cat_cd='".$RS[$i]['cat_cd']."'";
		$A_where[]="cat_cd='".$RS[$i]['cat_cd']."'";
	}
	$where=implode(" or ",$A_where);

	if($mode=="footprints"){
		return $footprints;
	}elseif($mode=="cat_name"){
		return $cat_name_now;
	}elseif($mode=="where"){
		return $where;
	}

}
//------------------------------------------------------//
function make_calendar($param){
	global $_REQUEST;

	if($param){
		$param="&".$param;
	}
	//##############################################################
	//あいねこの館http://aineko.com/
	//2006.08.04
	//カレンダースクリプトVer1.0
	//使い方・・・カレンダーを貼り付けたいPHPスクリプトに
	//require(cal.php)と記述するだけです。
	//改造、改造配布などは自由にして頂いて結構です。
	//改造した場合には、上記のコメントを全て削除してください。
	//バグ、問題が発生した時などの責任はとれません。
	//自己処理でお願い致します。
	//##############################################################

	//本日の日付を取得する
	$time = time();

	//各日付をセットする
	$year = date("Y", $time);
	$month = date("n", $time);
	$day = date("j", $time);

	//GETにきた年月をチェックする
	$strtotime=strtotime($_REQUEST['year']."-".$_REQUEST['month']."-1");
	if($_REQUEST['month_prev']){
		$year2=date("Y",strtotime("-1 month",$strtotime));
		$month2=date("n",strtotime("-1 month",$strtotime));
		$day2="";
	}elseif($_REQUEST['month_next']){
		$year2=date("Y",strtotime("+1 month",$strtotime));
		$month2=date("n",strtotime("+1 month",$strtotime));
		$day2="";
	}else{
		$year2=$_REQUEST["year"];
		$month2=$_REQUEST["month"];
		$day2=$_REQUEST["day"];
	}

	//先月、来月をクリックした場合の処理
	if($year2!="" || $month2!="" || $day2!=""){
		if($year2!=""){
			$year = $year2;
		}
		if($month2!=""){
			$month = $month2;
		}
		if($day2!=""){
			$day = $day2;
		}
		else{
			$day = 1;
		}
		$time = mktime(0,0,0,$month,$day,$year);
	}

	//今月の日付の数
	$num = date("t", $time);

	//曜日を取得するために時間をセット
	$today = mktime(0,0,0,$month,$day,$year);

	//曜日の配列
	$date = array('日','月','火','水','木','金','土');

	//カレンダーを表示する
	//先月の場合
	if($month==1){
		$year3 = $year-1;
		$month3 = 12;
	}
	else{
		$year3 = $year;
		$month3 = $month-1;
	}

	//来月の場合
	if($month==12){
		$year4 = $year+1;
		$month4 = 1;
	}
	else{
		$year4 = $year;
		$month4 = $month+1;
	}

	if($_REQUEST['month_prev']){
		$date_selected=date("Y-n",strtotime("-1 month",strtotime($_REQUEST['year']."-".$_REQUEST['month']."-1")));
	}elseif($_REQUEST['month_next']){
		$date_selected=date("Y-n",strtotime("+1 month",strtotime($_REQUEST['year']."-".$_REQUEST['month']."-1")));
	}else{
		$date_selected=$_REQUEST['year']."-".$_REQUEST['month'];
	}

	//カレンダーを表示するHTML
	print "<table width=150 class=\"table2\"><tr><td colspan=7>";
	print "<center>
	<input type=\"submit\" name=\"month_prev\" value=\"".$month3."月\" />";
	if($year."-".$month == $date_selected and !$_REQUEST['day']){
		print "　<font size=\"4\"><b>".$year."年".$month."月</b></font>　";
	}else{
		print "　<input type=\"submit\" name=\"month_now\" value=\"".$year."年".$month."月\" />　";
	}
	print "<input type=\"hidden\" name=\"year\" value=\"".$year."\" />";
	print "<input type=\"hidden\" name=\"month\" value=\"".$month."\" />";
	print "<input type=\"submit\" name=\"month_next\" value=\"".$month4."月\" />
	</td></tr>
	";

	print "
	<tr>
	<td><font color=red>日</font></td>
	<td>月</td>
	<td>火</td>
	<td>水</td>
	<td>木</td>
	<td>金</td>
	<td><font color=blue>土</font></td>
	</tr>
	";

	//特定の日付の場合の処理
	function check($i,$w,$year,$month,$day,$param){
		global $_REQUEST;
		$date_today=date("Y-n-j");
		$date_selected=$_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day'];
		if(!$_REQUEST['year'] and !$_REQUEST['month'] and !$_REQUEST['day']){
			$date_selected=$date_today;
		}
		if($w==0){
			if($year."-".$month."-".$i != $date_selected){
				$change = "<font color=red><input type=\"submit\" name=\"day\" value=\"".$i."\" style=\"width:22px; color:red;\" /></font>";
			}else{
				$change = "<font color=red size=\"4\"><b>$i</b></font>";
			}
			if($year."-".$month."-".$i == $date_today){
				$change = "<div style=\"padding:1px; background:black; border:solid black 1px; color:white;\">".$change."</div>";
			}
		}
		elseif($w==6){
			if($year."-".$month."-".$i != $date_selected){
				$change = "<font color=blue><input type=\"submit\" name=\"day\" value=\"".$i."\" style=\"width:22px; color:blue;\" /></font>";
			}else{
				$change = "<font color=blue size=\"4\"><b>$i</b></font>";
			}
			if($year."-".$month."-".$i == $date_today){
				$change = "<div style=\"padding:1px; background:black; border:solid black 1px; color:white;\">".$change."</div>";
			}
		}
		else{
			if($year."-".$month."-".$i != $date_selected){
				$change = "<input type=\"submit\" name=\"day\" value=\"".$i."\" style=\"width:22px;\" />";
			}else{
				$change = "<font size=\"4\"><b>$i</b></font>";
			}
			if($year."-".$month."-".$i == $date_today){
				$change = "<div style=\"padding:1px; background:black; border:solid black 1px; color:white;\">".$change."</div>";
			}
		}

		return $change;

	}

	//カレンダーの日付を作る
	for($i=1;$i<=$num;$i++){

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		//曜日は数値
		$w = date("w", $print_today);

		//一日目の曜日を取得する
		if($i==1){
			//一日目の曜日を提示するまでを繰り返し
			print "<tr>";
			for($j=1;$j<=$w;$j++){
				print "<td></td>";
			}
			$data = check($i,$w,$year,$month,$day,$param);
			print "<td>$data</td>";
			if($w==6){
				print "</tr>";
			}
		}
		//一日目以降の場合
		else{
			if($w==0){
				print "<tr>";
			}
			$data = check($i,$w,$year,$month,$day,$param);
			print "<td>$data</td>";
			if($w==6){
				print "</tr>";
			}
		}

	}
	print "</table>";

}
//------------------------------------------------------//
function make_calendar_bk($param){
	if($param){
		$param="&".$param;
	}
	//##############################################################
	//あいねこの館http://aineko.com/
	//2006.08.04
	//カレンダースクリプトVer1.0
	//使い方・・・カレンダーを貼り付けたいPHPスクリプトに
	//require(cal.php)と記述するだけです。
	//改造、改造配布などは自由にして頂いて結構です。
	//改造した場合には、上記のコメントを全て削除してください。
	//バグ、問題が発生した時などの責任はとれません。
	//自己処理でお願い致します。
	//##############################################################

	//本日の日付を取得する
	$time = time();

	//各日付をセットする
	$year = date("Y", $time);
	$month = date("n", $time);
	$day = date("j", $time);

	//GETにきた年月をチェックする
	$year2=@$_GET["year"];
	$month2=@$_GET["month"];
	$day2=@$_GET["day"];

	//先月、来月をクリックした場合の処理
	if($year2!="" || $month2!="" || $day2!=""){
		if($year2!=""){
			$year = $year2;
		}
		if($month2!=""){
			$month = $month2;
		}
		if($day2!=""){
			$day = $day2;
		}
		else{
			$day = 1;
		}
		$time = mktime(0,0,0,$month,$day,$year);
	}

	//今月の日付の数
	$num = date("t", $time);

	//曜日を取得するために時間をセット
	$today = mktime(0,0,0,$month,$day,$year);

	//曜日の配列
	$date = array('日','月','火','水','木','金','土');

	//カレンダーを表示する
	//先月の場合
	if($month==1){
		$year3 = $year-1;
		$month3 = 12;
	}
	else{
		$year3 = $year;
		$month3 = $month-1;
	}

	//来月の場合
	if($month==12){
		$year4 = $year+1;
		$month4 = 1;
	}
	else{
		$year4 = $year;
		$month4 = $month+1;
	}

	global $_REQUEST;
	$date_selected=$_REQUEST['year']."-".$_REQUEST['month'];
	//カレンダーを表示するHTML
	print "<table width=150 class=\"table2\"><tr><td colspan=7>";
	print "<center>
	<a href=\"?year=$year3&month=$month3".$param."\">".$month3."月</a>";
	if($year."-".$month == $date_selected and !$_REQUEST['day']){
		print "　<font size=\"4\"><b>".$year."年".$month."月</b></font>　";
	}else{
		print "　<a href=\"?year=$year&month=$month".$param."\">".$year."年".$month."月</a>　";
	}
	print "<a href=\"?year=$year4&month=$month4".$param."\">".$month4."月</a>
	</td></tr>
	";

	print "
	<tr>
	<td><font color=red>日</font></td>
	<td>月</td>
	<td>火</td>
	<td>水</td>
	<td>木</td>
	<td>金</td>
	<td><font color=blue>土</font></td>
	</tr>
	";

	//特定の日付の場合の処理
	function check($i,$w,$year,$month,$day,$param){
		global $_REQUEST;
		$date_today=date("Y-n-j");
		$date_selected=$_REQUEST['year']."-".$_REQUEST['month']."-".$_REQUEST['day'];
		if(!$_REQUEST['year'] and !$_REQUEST['month'] and !$_REQUEST['day']){
			$date_selected=$date_today;
		}
		if($w==0){
			if($year."-".$month."-".$i != $date_selected){
				$change = "<font color=red><a href=\"?year=$year&month=$month&day=$i&write=on".$param."\" color=red>$i</a></font>";
			}else{
				$change = "<font color=red size=\"4\"><b>$i</b></font>";
			}
			if($year."-".$month."-".$i == $date_today){
				$change = "【".$change."】";
			}
		}
		elseif($w==6){
			if($year."-".$month."-".$i != $date_selected){
				$change = "<font color=blue><a href=\"?year=$year&month=$month&day=$i&write=on".$param."\">$i</a></font>";
			}else{
				$change = "<font color=blue size=\"4\"><b>$i</b></font>";
			}
			if($year."-".$month."-".$i == $date_today){
				$change = "【".$change."】";
			}
		}
		else{
			if($year."-".$month."-".$i != $date_selected){
				$change = "<a href=\"?year=$year&month=$month&day=$i&write=on".$param."\">$i</a>";
			}else{
				$change = "<font size=\"4\"><b>$i</b></font>";
			}
			if($year."-".$month."-".$i == $date_today){
				$change = "【".$change."】";
			}
		}

		return $change;

	}

	//カレンダーの日付を作る
	for($i=1;$i<=$num;$i++){

		//本日の曜日を取得する
		$print_today = mktime(0, 0, 0, $month, $i, $year);
		//曜日は数値
		$w = date("w", $print_today);

		//一日目の曜日を取得する
		if($i==1){
			//一日目の曜日を提示するまでを繰り返し
			print "<tr>";
			for($j=1;$j<=$w;$j++){
				print "<td></td>";
			}
			$data = check($i,$w,$year,$month,$day,$param);
			print "<td>$data</td>";
			if($w==6){
				print "</tr>";
			}
		}
		//一日目以降の場合
		else{
			if($w==0){
				print "<tr>";
			}
			$data = check($i,$w,$year,$month,$day,$param);
			print "<td>$data</td>";
			if($w==6){
				print "</tr>";
			}
		}

	}
	print "</table>";

}
//------------------------------------------------------//
function get_mob_id($server){
	preg_match("/^.+ser([0-9a-zA-Z]+).*$/",$server["HTTP_USER_AGENT"],$matches);
	if($matches[0]){
		$hp_id=$matches[1];//Docomo
	}else{
		preg_match("/^.+SN([0-9a-zA-Z]+).*$/",$server["HTTP_USER_AGENT"],$matches);
		if($matches[0]){
			$hp_id=$matches[1];//SoftBank
		}
	}

	return $hp_id;
}
//------------------------------------------------------//
function make_count($number){
	global $G_img_dir;
	$amount=strlen($number);
	for($i=0;$i<$amount;$i++) {
		$num=substr($number,$i,1);
		$A_src[]="<img src=\"".$G_img_dir."/_number/".$num.".png\" />";
	}
	$src=implode("",$A_src);

	return $src;
}
//------------------------------------------------------//
function trim_str($str,$width,$marker,$enc){
	if($str){
		$A_str = array();
		while ($iLen = mb_strlen($str, $enc)) {
			//array_push($A_str, mb_substr($str, 0, 1, $enc));
			$tmp=mb_substr($str, 0, 1, $enc);
			if(mb_ereg("[a-z0-9]",$tmp)){
				$count=$count+3;
			}elseif(mb_ereg("[A-Zｱ-ﾝ]",$tmp)){
				$count=$count+4;
			}elseif(mb_ereg("[あ-んア-ン]",$tmp)){
				$count=$count+6;
			}else{
				if(strlen($tmp)=="1"){
					$count=$count+3;
				}elseif(strlen($tmp)=="2"){
					$count=$count+6;
				}
			}
			if($count >= $width){
				$result_str=implode("",$A_tmp);
				return $result_str.$marker;
				break;
			}
			$A_tmp[]=$tmp;
			$str = mb_substr($str, 1, $iLen, $enc);
		}

		$result_str=implode("",$A_tmp);
		return $result_str;
	}
}
//------------------------------------------------------//
function getLatLng($address,$api_key){
	$api_uri = 'http://maps.google.com/maps/geo?key='.$api_key.'&output=xml&ie=UTF8&q=';
	//simpleXMLで読み込む
	$xml = simplexml_load_file($api_uri . urlencode($address));
	foreach($xml->Response as $res){
		$code = $res->Status->code;
		//正常に返された場合
		if($code == '200'){
			$coordinates = $res->Placemark->Point->coordinates;
		}else{
			$coordinates = FALSE;
		}
	}
	$tmp=explode(",",$coordinates);
	return array("lat"=>$tmp[1],"lon"=>$tmp[0]);
}
//------------------------------------------------------//
?>