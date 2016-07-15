<?php
/* Search in array and return index 
*
* input string $keyword
* input array $array
* input string $column
*
* return $index
*/
function search_in_column($keyword, $array, $column){
    foreach ($array as $key => $val) {
       if ($val[''.$column.''] === $keyword) {
           return $key;
       }
   }
   return -1;
}

/* Get commission 
*
* input param $price
* input param $flg_detail
* input param Global G_tax
*
* return $commission
*/
function cal_commission($price, $flg_detail=""){
        global $G_tax;
		
        if($price <= 200){
                $commission = $price * 0.05;
        }elseif($price <= 400){
                $commission = $price * 0.04 + 2;
        }else{
                $commission = $price * 0.03 + 6;
        }
        $commission = $commission * 10000;
        $commission = $commission * (1 + $G_tax/100);
        if($flg_detail){
                //$commission = floor($commission / 10) * 10;
        }else{
                $commission = floor($commission / 1000) / 10;
                $commission = sprintf("%.1f", $commission);
        }
        return $commission;
}

function check_login(){
	if($_SESSION['user_cd']){
		return true;
	}else{
		$_SESSION['referer']=$_SERVER['REQUEST_URI'];

		header("location:/gate/");
		exit;
	}
}
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
//------------------------------------------------------//
?>