<?php
//-- configインクルード --//
include("config.php");
//--ステータス--//
check_login();


if(!$F_md){$F_md="list";}

switch($F_md){
//	case "test":
//		get_rs("v_item", "item", "", "item_sort asc");
//		for ($i = 0; $i < count($RS_item); $i++) {
//			$hist_price_cd = $hist_price_sort = make_cd("t_history_price", "hist_price_cd", "");
//			$add_clm_array = array("hist_price_cd", "hist_price_sort", "hist_price_value", "hist_price_date");
//			$add_value_array = array($hist_price_cd, $hist_price_sort, $RS_item[$i]['item_price'], pic_object_date("Y-m-d", $RS_item[$i]['date_regist']));
//			insert_db_same_name("", "t_history_price", $add_clm_array, $add_value_array);
//			$rel_cd = make_cd("r_item11", "rel_cd", "");
//			$add_clm_array = array("rel_cd", "item_cd", "hist_price_cd");
//			$add_value_array = array($rel_cd, $RS_item[$i]['item_cd'], $hist_price_cd);
//			insert_db_same_name("", "r_item11", $add_clm_array, $add_value_array);
//		}
//		break;
	
	case "list":
		$flg_jquery = "1";
		$flg_list = "1";
		$id_body = "itemlist";
		$inc = "list.inc";
//		$F_pref_cd = "40";
//		$F_pref_cd = "41";
		get_rs("v_city", "city", "(pref_cd='40' or pref_cd='41') and count_item>0", "city_sort asc");
		get_rs("m_seller", "seller", "", "seller_sort asc");
		if($F_seller_cd){
			get_rs("m_seller_office", "seller_office", "seller_office_cd in (select seller_office_cd from r_seller where seller_cd = ".$F_seller_cd.")", "seller_office_sort asc");
		}
		$A_stat[] = array('stat_cd'=>1, 'stat_name'=>"新築");
		$A_stat[] = array('stat_cd'=>2, 'stat_name'=>"中古");
		$A_stat_item[] = array('stat_item_cd'=>1, 'stat_item_name'=>"商談中");
		$A_stat_item[] = array('stat_item_cd'=>2, 'stat_item_name'=>"成約済");
		$A_stat_item[] = array('stat_item_cd'=>3, 'stat_item_name'=>"販売中");
		if($F_city_cd){
			$A_where[] = "city_cd='".$F_city_cd."'";
		}
		if($F_seller_cd){
			$A_where[] = "seller_cd='".$F_seller_cd."'";
		}
		if($F_seller_office_cd){
			$A_where[] = "seller_office_cd='".$F_seller_office_cd."'";
		}
		if($F_stat_cd==1){
			$A_where[] = "flg_new='1'";
		}elseif($F_stat_cd==2){
			$A_where[] = "flg_new is null";
		}
		if($F_stat_item_cd==1){
			$A_where[] = "flg_nego='1'";
		}elseif($F_stat_item_cd==2){
			$A_where[] = "flg_soldout='1'";
		}elseif($F_stat_item_cd==3){
			$A_where[] = "flg_nego is null and flg_soldout is null";
		}
		if($F_search_name){
			$A_where[] = "(item_name like '%".$F_search_name."%' or pref_name like '%".$F_search_name."%' or city_name like '%".$F_search_name."%' or item_addr1 like '%".$F_search_name."%'"
							. " or item_addr2 like '%".$F_search_name."%' or item_addr3 like '%".$F_search_name."%' or item_addr4 like '%".$F_search_name."%'"
							. " or school_pri_name like '%".$F_search_name."%' or school_jun_name like '%".$F_search_name."%' or cat_schigh_name like '%".$F_search_name."%'"
							. " or item_cd in (select item_cd from v_pubtrans where pubtrans_name like '%".$F_search_name."%') or item_cd in (select item_cd from v_pubtrans where stop_name like '%".$F_search_name."%'))";
		}

		if($F_type_search){
			$char = $F_type_search;
		}else{
			$char = $F_type_search = "and";
		}

		$where = implode(" ".$char." ", $A_where);
		get_rs("v_item", "item", $where, "item_sort desc");
		if(!$F_regist and !$F_copy){
			$_SESSION['status'] = array("city_cd"=>$F_city_cd, "stat_cd"=>$F_stat_cd, "seller_cd"=>$F_seller_cd, "seller_office_cd"=>$F_seller_office_cd, "stat_item_cd"=>$F_stat_item_cd, "search_name"=>$F_search_name, "type_search"=>$F_type_search);
		}
		break;

	case "regist":
		$flg_jquery = "1";
		$flg_js_datepicker = "1";
		$flg_regist = "1";
		$flg_imgliquid = "1";
		$flg_position_search = "1";
		$id_body = "itementry";
		$inc = "regist.inc";
		
		if($F_edit){
			$item_cd = get_key($F_edit);
			get_rs("v_item", "item", "item_cd='".$item_cd."'", "item_sort asc");
			get_rs("r_item2", "item_pub", "item_cd='".$item_cd."'", "rel_cd asc");
			get_rs("t_cost", "cost", "cost_cd in (select cost_cd from r_item5 where item_cd='".$item_cd."')", "cost_sort asc");
			get_rs("t_size_add", "size_add", "size_add_cd in (select size_add_cd from r_item6 where item_cd='".$item_cd."')", "size_add_sort asc");
			get_rs("t_size_detail", "size_detail", "size_detail_cd in (select size_detail_cd from r_item7 where item_cd='".$item_cd."')", "size_detail_sort asc");
			get_rs("v_along", "along", "along_cd in (select along_cd from r_item8 where item_cd='".$item_cd."')", "along_sort asc");
			get_rs("t_history_price", "hist_price", "hist_price_cd in (select hist_price_cd from r_item11 where item_cd='".$item_cd."')", "hist_price_date desc, hist_price_sort desc");
			get_rs("r_item9", "item_dist", "item_cd='".$item_cd."'", "rel_cd asc");
			get_rs("v_img_detail", "item_detail", "item_cd='".$item_cd."'", "img_detail_sort asc");
			get_rs("v_img_around", "item_around", "item_cd='".$item_cd."'", "img_around_sort asc");
			get_rs("t_img_theta", "item_theta", "img_theta_cd in (select img_theta_cd from r_item12 where item_cd = ".$item_cd.")", "img_theta_sort asc");

			get_rs("m_status", "stat", "", "stat_sort asc");
			get_rs("m_user", "user", "", "user_sort asc");
			get_rs("t_member", "mem", "", "mem_sort asc");
			get_rs("v_history", "hist", "item_cd = ".$item_cd, "date_regist asc, hist_cd asc");

		}else{
			$RS_item[0]['pref_cd'] = "40";
			$RS_item[0]['city_cd'] = "40132";
		}
		preg_match("/^([0-9].+)-([0-9].+)-.+/", $RS_item[0]['item_build'], $A_item_build);
		$item_build_y = $A_item_build[1];
		$item_build_m = $A_item_build[2];
		get_rs("m_cat_item", "cat_item", "", "cat_item_sort");
		get_rs("m_pref", "pref", "", "pref_sort");
		get_rs("v_city", "city", "pref_cd='".$RS_item[0]['pref_cd']."'", "city_sort");
		get_rs("m_pubtrans", "pubtrans", "", "pubtrans_sort");
		get_rs("m_transway", "transway", "", "transway_sort");
		if($RS_item[0]['school_pri_cd']){
			get_rs("v_school_primary", "school_pri", "city_cd='".$RS_item[0]['city_cd']."' or school_pri_cd='".$RS_item[0]['school_pri_cd']."'", "school_pri_sort");
		}else{
			get_rs("v_school_primary", "school_pri", "city_cd='".$RS_item[0]['city_cd']."'", "school_pri_sort");
		}
		if($RS_item[0]['school_jun_cd']){
			get_rs("v_school_junior", "school_jun", "city_cd='".$RS_item[0]['city_cd']."' or school_jun_cd='".$RS_item[0]['school_jun_cd']."'", "school_jun_sort");
		}else{
			get_rs("v_school_junior", "school_jun", "city_cd='".$RS_item[0]['city_cd']."'", "school_jun_sort");
		}
		get_rs("m_cat_schigh", "cat_schigh", "", "cat_schigh_sort");
		get_rs("m_admintype", "admintype", "", "admintype_sort");
		get_rs("m_layout", "layout", "", "layout_sort");
		get_rs("m_structure", "struc", "", "struc_sort");
		get_rs("m_method", "meth", "", "meth_sort");
		get_rs("m_dues", "dues", "", "dues_sort");
		get_rs("m_waterworks", "water", "", "water_sort");
		get_rs("m_sewer", "sewer", "", "sewer_sort");
		get_rs("m_fuel", "fuel", "", "fuel_sort");
		get_rs("m_mediate", "med", "", "med_sort");
		get_rs("m_rights", "rights", "", "rights_sort");
		get_rs("m_landcat", "landcat", "", "landcat_sort");
		get_rs("m_plan", "plan", "", "plan_sort");
		get_rs("m_district", "dist", "", "dist_sort");
		get_rs("m_direction", "dire", "", "dire_sort");
		get_rs("m_road", "road", "", "road_sort");
		get_rs("m_seller", "seller", "", "seller_sort");
		if($RS_item[0]['seller_cd']){
			get_rs("m_seller_office", "seller_office", "seller_office_cd in (select seller_office_cd from r_seller where seller_cd = '".$RS_item[0]['seller_cd']."')", "seller_office_sort");
		}
		get_rs("m_user", "user", "flg_active = 1", "user_sort asc");
		break;

	case "analysis":
		$flg_jquery = "1";
		$flg_analysis = "1";
		$id_body = "itemlist";
		$inc = "analysis.inc";
		$F_pref_cd = "40";
	
		/* --Ominext-- */
	
		//get city
		$select = 'count(r_item1.item_cd) AS count_item, city_name, cat_city_name, m_city.city_cd';
		$table = 'm_cat_city, r_city, m_city, r_item1';
		$where = 'm_city.city_cd = r_item1.city_cd AND '
			. 'm_cat_city.cat_city_cd = r_city.cat_city_cd AND '
			. 'r_city.city_cd = m_city.city_cd';
		$groupBy = 'm_city.city_name, m_cat_city.cat_city_name, m_city.city_cd';
	
		Omi_get_rs_with_group_by($select, $table, 'city', $where, $groupBy);
	
		//get cat_item
		$select = 'cat_item_cd, cat_item_name';
		$table = 'm_cat_item';
		$where = '';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'cat_item', $where, $orderBy);
		
		//get condition
		$select = 'condition_cd, condition_name';
		$table = 'm_condition';
		$where = '';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'condition', $where, $orderBy);
		
		//get seller
		$select = 'seller_cd, seller_name';
		$table = 'm_seller';
		$where = '';
		$orderBy = 'seller_sort ASC';
	
		Omi_get_rs($select, $table, 'seller', $where, $orderBy);
		
		//get analytics
		$select = 'analy_cd, analy_name';
		$table = 'm_analytics';
		$where = '';
		$orderBy = 'analy_cd ASC';
	
		Omi_get_rs($select, $table, 'analytics', $where, $orderBy);
	
		/* --Ominext end-- */
	
	break;

	case "analysis_item":
		$flg_jquery = "1";
		$flg_analysis = "1";
		$id_body = "itemlist";
		$inc = "analysis_item.inc";
	
		/* --Ominext-- */
		if (!isset($_GET['item_cd'])) {
			header('Location:/item/');
			exit;
		} else {
			//get item_cd
			$item_cd = $_GET['item_cd'];
	
			//get item
			$table = 't_item';
			$where = 't_item.item_cd = \'' . $item_cd . '\'';
			$orderBy = '';
	
			get_rs($table, 'item', $where, $orderBy);
			
			if($RS_item == null) {
				header('Location:/item/');
				exit;
			}
			
			//get list cat_item
			$select = 'cat_item_cd, cat_item_name';
			$table = 'm_cat_item';
			$where = '';
			$orderBy = '';
		
			Omi_get_rs($select, $table, 'list_cat_item', $where, $orderBy);
			
		
			//get list condition
			$select = 'condition_cd, condition_name';
			$table = 'm_condition';
			$where = '';
			$orderBy = '';
		
			Omi_get_rs($select, $table, 'list_condition', $where, $orderBy);
			
			//get list layout
			$select = 'layout_cd, layout_name';
			$table = 'm_layout';
			$where = '';
			$orderBy = '';
		
			Omi_get_rs($select, $table, 'list_layout', $where, $orderBy);
			
			//get list seller
			$select = 'seller_cd, seller_name';
			$table = 'm_seller';
			$where = '';
			$orderBy = 'seller_cd';
		
			Omi_get_rs($select, $table, 'list_seller', $where, $orderBy);

			//get history price	
			$select = 'v_history.date_regist, v_history.stat_name, v_history.hist_price, v_history.user_name';
			$table = 'v_history';
			$where = 'v_history.item_cd = \'' . $item_cd . '\'';
			$orderBy = '(CASE WHEN v_history.date_regist IS NULL THEN 1 ELSE 0 END) DESC, v_history.date_regist ASC';
			
			Omi_get_rs($select, $table, 'history', $where, $orderBy);
			$count_history = count($RS_history);
			
			//get image img
	
			if ($item_cd < 10) {
				$folder = '00' . $item_cd;
			}
			if ($item_cd >= 10 && $item_cd < 100) {
				$folder = '0' . $item_cd;
			}
			if ($item_cd >= 100) {
				$folder = $item_cd;
			}
	
			$link_img_main_s = '/_up/item/' . $folder . '/main_s.jpg';
			$link_img_plan1 = '/_up/item/' . $folder . '/plan1.jpg';
			$link_img_plan2 = '/_up/item/' . $folder . '/plan2.jpg';
	
	
			//get cat_item
			$select = 'r_item1.cat_item_cd';
			$table = 'r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\'';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'cat_item', $where, $orderBy);
			
			//get commission, discount
			$commission = cal_commission($RS_item[0]['item_price'], "");
			$commission = (float)$commission * 10000;
			$discount = $commission * $RS_item[0]['item_discount'] / 100;
			
			//get seller
			$select = 'seller_name';
			$table = 'm_seller, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.seller_cd = m_seller.seller_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'seller', $where, $orderBy);
	
			//get size detail
			//old database (before 27/06)
			$table = 't_size_detail, r_item7';
			$where = 'r_item7.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item7.size_detail_cd = t_size_detail.size_detail_cd';
			$orderBy = '';
	
			get_rs($table, 'size_detail', $where, $orderBy);
			
			//new database (from 27/06)
					/*$table = 't_size_detail, r_size_detail';
					$where = 'r_size_detail.item_cd = \'' . $item_cd . '\' AND '
						. 'r_size_detail.size_detail_cd = t_size_detail.size_detail_cd';
					$orderBy = '';
			
					get_rs($table, 'size_detail', $where, $orderBy);*/
	
			//get water, sewer, fuel
			$select = 'water_name';
			$table = 'm_waterworks, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.water_cd = m_waterworks.water_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'water', $where, $orderBy);
			//--
			$select = 'sewer_name';
			$table = 'm_sewer, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.sewer_cd = m_sewer.sewer_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'sewer', $where, $orderBy);
			//--
			$select = 'fuel_name';
			$table = 'm_fuel, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.fuel_cd = m_fuel.fuel_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'fuel', $where, $orderBy);
	
			//get structure
			$select = 'struc_name';
			$table = 'm_structure, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.struc_cd = m_structure.struc_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'structure', $where, $orderBy);
	
			//get floor plan
			$select = 'layout_name';
			$table = 'm_layout, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.layout_cd = m_layout.layout_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'layout', $where, $orderBy);
	
			//get schools
			$select = 'school_pri_name';
			$table = 'm_school_primary, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.school_pri_cd = m_school_primary.school_pri_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'school_pri', $where, $orderBy);
			//--
			$select = 'school_jun_name';
			$table = 'm_school_junior, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.school_jun_cd = m_school_junior.school_jun_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'school_jun', $where, $orderBy);
			//--
			$select = 'cat_schigh_name';
			$table = 'm_cat_schigh, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.cat_schigh_cd = m_cat_schigh.cat_schigh_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'cat_schigh', $where, $orderBy);
	
			//get road
			//old database (before 27/06)
			$select = 'dire_name, road_name, along_size';
			$table = 'm_road, t_along, m_direction, r_item8';
			$where = 'r_item8.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item8.road_cd = m_road.road_cd AND '
				. 'r_item8.along_cd = t_along.along_cd AND '
				. 'r_item8.dire_cd = m_direction.dire_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'road', $where, $orderBy);
			
			//new database (from 27/06)
					/*$select = 'dire_name, road_name, along_size';
					$table = 'm_road, t_along, m_direction, r_along';
					$where = 'r_along.item_cd = \'' . $item_cd . '\' AND '
						. 'r_along.road_cd = m_road.road_cd AND '
						. 'r_along.along_cd = t_along.along_cd AND '
						. 'r_along.dire_cd = m_direction.dire_cd';
					$orderBy = '';
			
					Omi_get_rs($select, $table, 'road', $where, $orderBy);*/
	
			//get rights
			$select = 'rights_name';
			$table = 'm_rights, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.rights_cd = m_rights.rights_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'rights', $where, $orderBy);
	
			//get landcat
			$select = 'landcat_name';
			$table = 'm_landcat, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.landcat_cd = m_landcat.landcat_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'landcat', $where, $orderBy);
	
			//get plan
			$select = 'plan_name';
			$table = 'm_plan, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.plan_cd = m_plan.plan_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'plan', $where, $orderBy);
	
			//get method
			$select = 'meth_name';
			$table = 'm_method, r_item1';
			$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item1.meth_cd = m_method.meth_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'method', $where, $orderBy);
	
			//get district
			//old datebase (before 27/06)
			$select = 'dist_name';
			$table = 'm_district, r_item9';
			$where = 'r_item9.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item9.dist_cd = m_district.dist_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'district', $where, $orderBy);
			
			//new database (from 27/06)
			/*        $select = 'dist_name';
					$table = 'm_district, r_district';
					$where = 'r_district.item_cd = \'' . $item_cd . '\' AND '
						. 'r_district.dist_cd = m_district.dist_cd';
					$orderBy = '';
			
					Omi_get_rs($select, $table, 'district', $where, $orderBy);*/
			
			//get pubtrans
			//old database (before 27/06)
			$select = 'pubtrans_name, stop_name, transway_name, transtime';
			$table = 'm_transway, m_stop, m_pubtrans, r_item2';
			$where = 'r_item2.item_cd = \'' . $item_cd . '\' AND '
				. 'r_item2.pubtrans_cd = m_pubtrans.pubtrans_cd AND '
				. 'r_item2.stop_cd = m_stop.stop_cd AND '
				. 'r_item2.transway_cd = m_transway.transway_cd';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'pubtrans', $where, $orderBy);
			
			//new database (from 27/06)
					/*$select = 'pubtrans_name, stop_name, transway_name, nearest_time';
					$table = 'm_transway, m_stop, m_pubtrans, r_nearest, t_nearest, r_stop';
					$where = 'r_nearest.item_cd = \'' . $item_cd . '\' AND '
						. 'r_stop.pubtrans_cd = m_pubtrans.pubtrans_cd AND '
						. 'r_stop.stop_cd = m_stop.stop_cd AND '
						. 'r_nearest.stop_cd = m_stop.stop_cd AND '
						. 'r_nearest.nearest_cd = t_nearest.nearest_cd AND '
						. 'r_nearest.transway_cd = m_transway.transway_cd';
					$orderBy = '';
			
					Omi_get_rs($select, $table, 'pubtrans', $where, $orderBy);*/
	
			//get latitude, longitude
			$item_point = $RS_item[0]['item_point'];
			$item_point = substr($item_point, 1, -1);
			$lat_lng = explode(',', $item_point);
		}
	
		/* --Ominext end-- */
	break;

	case "get_history_price":
		/* --Ominext-- */
		/* --get history price AJAX-- */
	
		/* get item_cd */
		$item_cd = $_GET['item_cd'];
	
		/* search db */
		if ($item_cd) {
			$select = 't_item.*, m_status.*, r_history.*, t_history.date_regist AS hist_date_regist, t_history.*';
			$table = 't_item, r_history, t_history, m_status';
			$where = 't_item.item_cd = r_history.item_cd AND '
				. 'r_history.hist_cd = t_history.hist_cd AND '
				. 'm_status.stat_cd = r_history.stat_cd AND '
				. 't_item.item_cd = \'' . $item_cd . '\'';
			$orderBy = '';
	
			Omi_get_rs($select, $table, 'history_price', $where, $orderBy);
	
			//sort by date
			usort($RS_history_price, function($a, $b) {
				return $a['hist_date_regist'] > $b['hist_date_regist'];
			});
	
			for ($i = 0; $i < count($RS_history_price); $i++) {
				$history_price[] = array(
					'date_regist' => $RS_history_price[$i]['hist_date_regist'],
					'stat_name' => $RS_history_price[$i]['stat_name'],
					'hist_price' => $RS_history_price[$i]['hist_price']
				);
			}
		} else {
			$history_price = null;
		}
	
		//convert to json
		$history_price_json = json_encode($history_price);
		header('Content-type:application/json;charset=utf-8');
		echo $history_price_json;
		return 1;
		/* --Ominext end-- */
	break;
	
	case "get_item_compare":
		/* --Ominext-- */
		/* --compare item AJAX-- */
		$list_item = $_POST['list_item'];
		
		$items = explode(',', $list_item);
		$list = array();
		for ($i = 0; $i < count($items) ; $i++) {
			if ( !in_array($items[$i], $list)) {
				$list[] = $items[$i];
			}
		}
		
		$select_compare = 't_item.item_cd, t_item.item_name, m_status.stat_name, t_history.date_regist as date_regist, t_history.*, m_seller.seller_name';
		$table_compare = 't_item, r_history, t_history, m_status, r_item1, m_seller';
		$where_compare = 't_item.item_cd = r_history.item_cd AND '
			. 'r_history.hist_cd = t_history.hist_cd AND '
			. 'm_status.stat_cd = r_history.stat_cd AND '
			. 'm_seller.seller_cd = r_item1.seller_cd AND '
			. 't_item.item_cd = r_item1.item_cd AND '
			. ' t_item.item_cd IN (';
		for ($i = count($list) - 1; $i >= count($list) - 5 ; $i--) {
			$where_compare = $where_compare . '\'' . $list[$i] . '\', ';
		}
		$where_compare = substr($where_compare, 0, -2);
		$where_compare = $where_compare . ')';
		$orderBy_compare = 'item_cd ASC, date_regist ASC';
		
		Omi_get_rs($select_compare, $table_compare, 'compare', $where_compare, $orderBy_compare);
		
		$compare = array();
		for ($i = 0; $i < count($RS_compare); $i++) {
			for ($j = 0; $j < count($compare); $j++) {
				$k = search_in_column($RS_compare[$i]['item_cd'], $compare[$j], 'item_cd');
				if ( $k >= 0 ) {
					$compare[$j][] = [
							'item_cd' => $RS_compare[$i]['item_cd'], 
							'item_name' => $RS_compare[$i]['item_name'],
							'seller' => $RS_compare[$i]['seller_name'],
							'date_regist' => $RS_compare[$i]['date_regist'],
							'stat_name' => $RS_compare[$i]['stat_name'],
							'hist_price' => $RS_compare[$i]['hist_price']
							];
					$check = 1;
				} else {
					$check = 0;
				}
			}
			if ($check == 0) {
				$compare[][] = [
							'item_cd' => $RS_compare[$i]['item_cd'], 
							'item_name' => $RS_compare[$i]['item_name'],
							'seller' => $RS_compare[$i]['seller_name'],
							'date_regist' => $RS_compare[$i]['date_regist'],
							'stat_name' => $RS_compare[$i]['stat_name'],
							'hist_price' => $RS_compare[$i]['hist_price']
							];
			}
		}
		
		//convert to json
		$compare_json = json_encode($compare);
		header('Content-type:application/json;charset=utf-8');
		echo $compare_json;
		return 1;
		/* --Ominext end-- */
	break;
	
	case "get_item_info_by_item_cd":
		/*--Ominext--*/
		//get item's info by item_cd AJAX
		//get item cd
		$item_cd = $_POST['item_cd'];
		//query
		$select_item = 't_item.item_cd, t_item.item_name, t_history.date_regist as date_regist, t_history.*, m_seller.seller_name';
		$table_item = 't_item, r_history, t_history, r_item1, m_seller';
		$where_item = 't_item.item_cd = r_history.item_cd AND '
			. 'r_history.hist_cd = t_history.hist_cd AND '
			. 'm_seller.seller_cd = r_item1.seller_cd AND '
			. 't_item.item_cd = r_history.item_cd AND '
			. 't_item.item_cd = r_item1.item_cd AND '
			. ' t_item.item_cd = \'' . $item_cd . '\'';
		$orderBy_item = 'item_cd ASC, date_regist ASC';
		
		Omi_get_rs($select_item, $table_item, 'item', $where_item, $orderBy_item);
		
		$item = [
					'item_cd' => $RS_item[count($RS_item) -1]['item_cd'], 
					'item_name' => $RS_item[count($RS_item) -1]['item_name'],
					'seller' => $RS_item[count($RS_item) -1]['seller_name'],
					'date_regist' => $RS_item[count($RS_item) -1]['date_regist'],
					'hist_price' => $RS_item[count($RS_item) -1]['hist_price']
					];
							
							
		//convert to json
		$item_json = json_encode($item);
		header('Content-type:application/json;charset=utf-8');
		echo $item_json;
		return 1;
		/* --Ominext end-- */
	break;
	
	case "get_item_in_area":
		/* --Ominext-- */
		/* --get item in radius AJAX-- */
		/* get item_cd */
		//$item_cd = $_POST['item_cd'];
		$item_cd = $_POST['item_cd'];
		$radius = $_POST['radius'];
		$sold_before_complete = $_POST['sold_before_complete'];
		
		//get lat-lng
		$select_item = 'item_point';
		$table_item = 't_item';
		$where_item = 'item_cd = \'' . $item_cd . '\'';
		$orderBy_item = '';
		
		Omi_get_rs($select_item, $table_item, 'item', $where_item, $orderBy_item);
		
		$item_point = $RS_item[0]['item_point'];
		$item_point = substr($item_point, 1, -1);
		$lat_lng = explode(',', $item_point);
		
		//caculate max min lat-lng
		$R = 6317; //Earth's radius
		$d = $radius; //distance
		$lat_src = deg2rad($lat_lng[0]);
		$lng_src = deg2rad($lat_lng[1]);
		
		$lat_diff = $d/$R;
		
		$lat_max = $lat_diff + $lat_src;
		$lat_min =  -$lat_diff + $lat_src;
		
		$lng_diff = acos(1 - ( 2 * pow(sin($d/ ($R * 2)), 2)) / pow(cos($lat_src), 2));
		
		$lng_max = $lng_diff + $lng_src;
		$lng_min = -$lng_diff + $lng_src;
		
		//get lat-lng all item
		$now = date('Y-m-d');
		$oneYearAgo = date('Y-m-d H:i:s', strtotime($now.'-1 year'));
		
		$select_item_point = 't_item.item_cd, t_item.item_name, t_item.date_regist as regist,'
							.' t_item.item_build, t_item.date_soldout, r_item1.cat_item_cd,'
							.' t_item.item_point, t_history.date_regist, t_history.hist_price, m_seller.seller_name';
		$table_item_point = 't_item, r_item1, r_history, t_history, m_seller';
		$where_item_point = 't_item.item_cd != \'' . $item_cd . '\''
							//.' AND t_item.date_regist > \'' . $oneYearAgo . '\''
							.' AND r_history.item_cd = t_item.item_cd'
							.' AND r_item1.item_cd = t_item.item_cd'
							.' AND r_item1.seller_cd = m_seller.seller_cd'
							.' AND r_history.hist_cd = t_history.hist_cd';
		$orderBy_item_point= 'r_history.item_cd ASC, t_history.date_regist ASC';
		
		if (isset($_POST['cat_item'])) {
			$cat_item = $_POST['cat_item'];
			$where_item_point = $where_item_point . ' AND r_item1.cat_item_cd IN (';
			for ($i = 0; $i < count($cat_item); $i++) {
				$where_item_point = $where_item_point . '\'' . $cat_item[$i] . '\', ';
			}
	
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
	
		if (isset($_POST['condition'])) {
			$condition = $_POST['condition'];
			$where_item_point = $where_item_point . ' AND r_item1.condition_cd IN (';
			for ($i = 0; $i < count($condition); $i++) {
				$where_item_point = $where_item_point . '\'' . $condition[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
		
		if (isset($_POST['layout'])) {
			$layout = $_POST['layout'];
			$where_item_point = $where_item_point . ' AND r_item1.layout_cd IN (';
			for ($i = 0; $i < count($layout); $i++) {
				$where_item_point = $where_item_point . '\'' . $layout[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
		
		if (isset($_POST['seller'])) {
			$seller = $_POST['seller'];
			
			$where_item_point = $where_item_point . ' AND ( r_item1.seller_cd IN (';
			for ($i = 0; $i < count($seller); $i++) {
				$where_item_point = $where_item_point . '\'' . $seller[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
			
			if (in_array(0, $seller)) {
				$where_item_point = substr($where_item_point, 0, -1);
				$where_item_point = $where_item_point . ') OR r_item1.seller_cd >= 7';
			}
			$where_item_point = $where_item_point . ')';
		}	
		
		Omi_get_rs($select_item_point, $table_item_point, 'item_point', $where_item_point, $orderBy_item_point);
		
		$result = array();
		
		for($i = 0; $i < count($RS_item_point); $i++) {
			$item_point = $RS_item_point[$i]['item_point'];
			$item_point = substr($item_point, 1, -1);
			$lat_lng_item = explode(',', $item_point);
			
			$lat_des = deg2rad($lat_lng_item[0]);
			$lng_des = deg2rad($lat_lng_item[1]);
			
			//if lat, lng in range caculate distance
			if( $lat_des >= $lat_min && $lat_des <= $lat_max && $lng_des >= $lng_min && $lng_des <= $lng_max ) {
				//caculate distance
				$distance = 2 * $R * sqrt( pow(sin(($lat_des - $lat_src) / 2), 2) + 
						cos($lat_des) * cos($lat_src) * pow( sin(($lng_des - $lng_src) / 2), 2 ));
				
				if($distance <= $radius) {
					$hist_change = null;
				
					if ($RS_item_point[$i]['date_soldout'] != '') {
						$status = 2;
					}
					if ($RS_item_point[$i]['date_soldout'] < $RS_item_point[$i]['item_build']) {
						$status = 3;
					} 
					if ($RS_item_point[$i]['date_soldout'] == '') {
						$status = 1;
						$select_hist = 't_history.date_regist';
						$table_hist = 't_history, r_history';
						$where_hist = 't_history.hist_cd = r_history.hist_cd'
									 .' AND r_history.stat_cd = \'2\''
									 .' AND r_history.item_cd =\''.$RS_item_point[$i]['item_cd'].'\'';
						$orderBy_hist = 't_history.date_regist DESC';
						
						Omi_get_rs($select_hist, $table_hist, 'hist', $where_hist, $orderBy_hist);
						$hist_change = $RS_hist[0]['date_regist'];
					}
				if ($RS_item_point[$i]['date_soldout'] <= $RS_item_point[$i]['item_build']) {
					$diff = strtotime($RS_item_point[$i]['date_soldout']) - strtotime($RS_item_point[$i]['item_build']);
					$time = ceil((($diff > 0) ? $diff : 0) /86400);
				} else {
					$diff = strtotime($RS_item_point[$i]['date_soldout']) - strtotime($RS_item_point[$i]['regist']);
					$time = ceil((($diff > 0) ? $diff : 0) /86400);
				}
				
				if ($sold_before_complete == 0) {
					$j = search_in_column($RS_item_point[$i]['item_cd'], $result, 'item_cd');
					if ( $j >= 0 ) {
						$result[$j] = array(
										'item_cd' => $RS_item_point[$i]['item_cd'],
										'item_name' => $RS_item_point[$i]['item_name'],
										'cat_item' => $RS_item_point[$i]['cat_item_cd'],
										'date_regist' => date('Y-m-d', strtotime($RS_item_point[$i]['date_regist'])),
										'hist_price' => $RS_item_point[$i]['hist_price'],
										'seller' => $RS_item_point[$i]['seller_name'],
										'status' => $status,
										'hist_change' =>$hist_change,
										'time' => $time,
										'lat' => $lat_lng_item[0],
										'lng' => $lat_lng_item[1],
									);
					} else {
						$result[] = array(	
							'item_cd' => $RS_item_point[$i]['item_cd'],
							'item_name' => $RS_item_point[$i]['item_name'],
							'cat_item' => $RS_item_point[$i]['cat_item_cd'],
							'date_regist' => date('Y-m-d', strtotime($RS_item_point[$i]['date_regist'])),
							'hist_price' => $RS_item_point[$i]['hist_price'],
							'seller' => $RS_item_point[$i]['seller_name'],
							'status' => $status,
							'hist_change' =>$hist_change,
							'time' => $time,
							'lat' => $lat_lng_item[0],
							'lng' => $lat_lng_item[1],
						);
					}
					} else {
						if ($status == 3) {
							$j = search_in_column($RS_item_point[$i]['item_cd'], $result, 'item_cd');
							if ( $j >= 0 ) {
								$result[$j] = array(
												'item_cd' => $RS_item_point[$i]['item_cd'],
												'item_name' => $RS_item_point[$i]['item_name'],
												'cat_item' => $RS_item_point[$i]['cat_item_cd'],
												'date_regist' => date('Y-m-d', strtotime($RS_item_point[$i]['date_regist'])),
												'hist_price' => $RS_item_point[$i]['hist_price'],
												'seller' => $RS_item_point[$i]['seller_name'],
												'status' => $status,
												'hist_change' =>$hist_change,
												'time' => $time,
												'lat' => $lat_lng_item[0],
												'lng' => $lat_lng_item[1],
											);
							} else {
								$result[] = array(	
									'item_cd' => $RS_item_point[$i]['item_cd'],
									'item_name' => $RS_item_point[$i]['item_name'],
									'cat_item' => $RS_item_point[$i]['cat_item_cd'],
									'date_regist' => date('Y-m-d', strtotime($RS_item_point[$i]['date_regist'])),
									'hist_price' => $RS_item_point[$i]['hist_price'],
									'seller' => $RS_item_point[$i]['seller_name'],
									'status' => $status,
									'hist_change' =>$hist_change,
									'time' => $time,
									'lat' => $lat_lng_item[0],
									'lng' => $lat_lng_item[1],
								);
							}
						}
					}
				}
			}
		}
		
		//convert to json
		$result_json = json_encode($result);
		header('Content-type:application/json;charset=utf-8');
		echo $result_json;
		return 1;
		/*--Ominext end--*/
	break;
	
	case "get_info_group_item_in_area":
		/* --Ominext-- */
		/* --get item in radius AJAX-- */
		/* get item_cd */
		//$item_cd = $_POST['item_cd'];
		$item_cd = $_POST['item_cd'];
		$radius = $_POST['radius'];
		$sold_before_complete = $_POST['sold_before_complete'];
		
		//get lat-lng
		$select_item = 'item_point';
		$table_item = 't_item';
		$where_item = 'item_cd = \'' . $item_cd . '\'';
		$orderBy_item = '';
		
		Omi_get_rs($select_item, $table_item, 'item', $where_item, $orderBy_item);
		
		$item_point = $RS_item[0]['item_point'];
		$item_point = substr($item_point, 1, -1);
		$lat_lng = explode(',', $item_point);
		
		//caculate max min lat-lng
		$R = 6317; //Earth's radius
		$d = $radius; //distance
		$lat_src = deg2rad($lat_lng[0]);
		$lng_src = deg2rad($lat_lng[1]);
		
		$lat_diff = $d/$R;
		
		$lat_max = $lat_diff + $lat_src;
		$lat_min =  -$lat_diff + $lat_src;
		
		$lng_diff = acos(1 - ( 2 * pow(sin($d/ ($R * 2)), 2)) / pow(cos($lat_src), 2));
		
		$lng_max = $lng_diff + $lng_src;
		$lng_min = -$lng_diff + $lng_src;
		
		//get all item
		
		$select_item_point = 't_item.item_cd, t_item.date_regist as regist, t_item.item_build,'
							.' t_item.date_soldout, t_item.item_point, r_item1.cat_item_cd,'
							.' r_item1.seller_cd, m_seller.seller_name, r_history.stat_cd, t_history.date_regist, t_history.*';
		$table_item_point = 't_item, r_item1, r_history, t_history, m_seller';
		$where_item_point = 'r_history.item_cd = t_item.item_cd'
							.' AND r_item1.item_cd = t_item.item_cd'
							.' AND r_item1.seller_cd = m_seller.seller_cd'
							.' AND r_history.hist_cd = t_history.hist_cd'
							.' AND t_item.flg_soldout = \'1\'';
		$orderBy_item_point = 'r_item1.seller_cd ASC, r_history.item_cd ASC, t_history.date_regist ASC';
		
		if (isset($_POST['cat_item'])) {
			$cat_item = $_POST['cat_item'];
			$where_item_point = $where_item_point . ' AND r_item1.cat_item_cd IN (';
			for ($i = 0; $i < count($cat_item); $i++) {
				$where_item_point = $where_item_point . '\'' . $cat_item[$i] . '\', ';
			}
	
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
	
		if (isset($_POST['condition'])) {
			$condition = $_POST['condition'];
			$where_item_point = $where_item_point . ' AND r_item1.condition_cd IN (';
			for ($i = 0; $i < count($condition); $i++) {
				$where_item_point = $where_item_point . '\'' . $condition[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
		
		if (isset($_POST['layout'])) {
			$layout = $_POST['layout'];
			$where_item_point = $where_item_point . ' AND r_item1.layout_cd IN (';
			for ($i = 0; $i < count($layout); $i++) {
				$where_item_point = $where_item_point . '\'' . $layout[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
		
		if (isset($_POST['seller'])) {
			$seller = $_POST['seller'];
			
			$where_item_point = $where_item_point . ' AND ( r_item1.seller_cd IN (';
			for ($i = 0; $i < count($seller); $i++) {
				$where_item_point = $where_item_point . '\'' . $seller[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
			
			if (in_array(0, $seller)) {
				$where_item_point = substr($where_item_point, 0, -1);
				$where_item_point = $where_item_point . ') OR r_item1.seller_cd >= 7';
			}
			$where_item_point = $where_item_point . ')';
		}	
		
		Omi_get_rs($select_item_point, $table_item_point, 'item_point', $where_item_point, $orderBy_item_point);
		
		$list_item = array();
		
		for($i = 0; $i < count($RS_item_point); $i++) {
			$item_point = $RS_item_point[$i]['item_point'];
			$item_point = substr($item_point, 1, -1);
			$lat_lng_item = explode(',', $item_point);
			
			$lat_des = deg2rad($lat_lng_item[0]);
			$lng_des = deg2rad($lat_lng_item[1]);
			
			//if lat, lng in range caculate distance
			if( $lat_des >= $lat_min && $lat_des <= $lat_max && $lng_des >= $lng_min && $lng_des <= $lng_max ) {
				//caculate distance
				$distance = 2 * $R * sqrt( pow(sin(($lat_des - $lat_src) / 2), 2) + 
						cos($lat_des) * cos($lat_src) * pow( sin(($lng_des - $lng_src) / 2), 2 ));
				
				if($distance <= $radius) {
					$price_regist = null;
					$price_soldout = null;
					if ($RS_item_point[$i]['stat_cd'] == '1') {
						$price_regist = $RS_item_point[$i]['hist_price'];
					}
					if ($RS_item_point[$i]['stat_cd'] == '6') {
						$price_soldout = $RS_item_point[$i]['hist_price'];
					}
					
					if ($RS_item_point[$i]['date_soldout'] <= $RS_item_point[$i]['item_build']) {
						$diff = strtotime($RS_item_point[$i]['date_soldout']) - strtotime($RS_item_point[$i]['item_build']);
						$time = ceil((($diff > 0) ? $diff : 0) /86400);
					} else {
						$diff = strtotime($RS_item_point[$i]['date_soldout']) - strtotime($RS_item_point[$i]['regist']);
						$time = ceil((($diff > 0) ? $diff : 0) /86400);
					}
					
					$list_item[] = array(	
						'item_cd' => $RS_item_point[$i]['item_cd'],
						'stat_cd' => $RS_item_point[$i]['stat_cd'],
						'regist' => $RS_item_point[$i]['regist'],
						'date_soldout' => $RS_item_point[$i]['date_soldout'],
						'price_regist' => $price_regist,
						'price_soldout' => $price_soldout,
						'hist_regist' => $RS_item_point[$i]['date_regist'],
						'seller_cd' => ($RS_item_point[$i]['seller_cd'] >= "7" || $RS_item_point[$i]['seller_cd'] == '')
										? "7" : $RS_item_point[$i]['seller_cd'],
						'seller_name' => $RS_item_point[$i]['seller_name'], 
						'time' => $time,
					);
				}
			}
		}
		
		$items = array();
		$history = array();
		$price_regist = null;
		$price_soldout = null;
		for ($i = 0; $i < count($list_item); $i++) {
			if ($list_item[$i]['item_cd'] == $list_item[$i - 1]['item_cd'] || $i == 0 ) {
				$history[] = array(
							'stat_cd' => $list_item[$i]['stat_cd'],
							'hist_regist' => $list_item[$i]['hist_regist']
								);
				if ($list_item[$i]['stat_cd'] == 1) {
					$price_regist = $list_item[$i]['price_regist'];
				}
				if ($list_item[$i]['stat_cd'] == 6) {
					$price_soldout = $list_item[$i]['price_soldout'];
				}
			} else {
				$items[] = array(
						'item_cd' => $list_item[$i - 1]['item_cd'],
						'regist' => $list_item[$i - 1]['regist'],
						'date_soldout' => $list_item[$i - 1]['date_soldout'],
						'price_regist' => $price_regist,
						'price_soldout' => $price_soldout,
						'time' => $list_item[$i - 1]['time'],
						'seller_cd' => $list_item[$i - 1]['seller_cd'],
						'seller_name' => $list_item[$i - 1]['seller_name'],
						'history' => $history
					);
				
				$price_regist = null;
				$price_soldout = null;	
				$history = null;
				
				if ($list_item[$i]['stat_cd'] == 1) {
					$price_regist = $list_item[$i]['price_regist'];
				}
				if ($list_item[$i]['stat_cd'] == 6) {
					$price_soldout = $list_item[$i]['price_soldout'];
				}
				$history[] = array(
						'stat_cd' => $list_item[$i]['stat_cd'],
						'hist_regist' => $list_item[$i]['hist_regist']
							);
			}
		}
		
		$items[] = array(
						'item_cd' => $list_item[$i - 1]['item_cd'],
						'regist' => $list_item[$i - 1]['regist'],
						'date_soldout' => $list_item[$i - 1]['date_soldout'],
						'price_regist' => $price_regist,
						'price_soldout' => $price_soldout,
						'time' => $list_item[$i - 1]['time'],
						'seller_cd' => $list_item[$i - 1]['seller_cd'],
						'seller_name' => $list_item[$i - 1]['seller_name'],
						'history' => $history
					);		
					
		$result = array();
		$array_item = array();
		for ($i = 0; $i < count($items); $i++) {
			if ($items[$i]['seller_cd'] == $items[$i - 1]['seller_cd'] || $i == 0 ) {
				$array_item[] = array(
									'item_cd' => $items[$i]['item_cd'],
									'regist' => $items[$i]['regist'],
									'date_soldout' => $items[$i]['date_soldout'],
									'price_regist' => $items[$i]['price_regist'],
									'price_soldout' => $items[$i]['price_soldout'],
									'time' => $items[$i]['time'],
									'history' => $items[$i]['history']
								);
			} else {
				$result[] = array(
						'seller_cd' => $items[$i - 1]['seller_cd'],
						'seller_name' => $items[$i - 1]['seller_name'],
						'items' => $array_item
					);
				
				$array_item = null;
				$array_item[] = array(
									'item_cd' => $items[$i]['item_cd'],
									'regist' => $items[$i]['regist'],
									'date_soldout' => $items[$i]['date_soldout'],
									'price_regist' => $items[$i]['price_regist'],
									'price_soldout' => $items[$i]['price_soldout'],
									'time' => $items[$i]['time'],
									'history' => $items[$i]['history']
								);				
			}
		}
		$result[] = array(
						'seller_cd' => $items[$i - 1]['seller_cd'],
						'seller_name' => $items[$i - 1]['seller_name'],
						'items' => $array_item
					);
					
		if ($result[count($result) - 1]['seller_cd'] == "7") {
			$result[count($result) - 1]['seller_name'] = 'その他';
		}			
		
		//convert to json
		$result_json = json_encode($result);
		header('Content-type:application/json;charset=utf-8');
		echo $result_json;
		return 1;
		/*--Ominext end--*/
	break;

case "get_info_item":
	/*--Ominext--*/
	//get item detail by item_cd AJAX
	
	$list_item = $_POST['list_item'];
	
	$items = explode(',', $list_item);
	$list = array();
	for ($i = 0; $i < count($items) ; $i++) {
		if ( !in_array($items[$i], $list)) {
			$list[] = $items[$i];
		}
	}
	
	$details = array();
	
	for ($j = count($list) - 1; $j >= count($list) - 5 ; $j--) {
		$item_cd = 	$list[$j];

		//get image img
		if ($item_cd < 10) {
			$folder = '00' . $item_cd;
		}
		if ($item_cd >= 10 && $item_cd < 100) {
			$folder = '0' . $item_cd;
		}
		if ($item_cd >= 100) {
			$folder = $item_cd;
		}
		
		$link_img_main_s = '/_up/item/' . $folder . '/main_s.jpg';
		
		//get name, price, size land, size build, date_soldout
		$select = "*";
		$table = "t_item";
		$where = "item_cd = '" . $item_cd . "'";
		$orderBy = "";
		
		Omi_get_rs($select, $table, 'item', $where, $orderBy);
		
		$item_name = $RS_item[0]['item_name'] . '<br>' . $RS_item[0]['item_name_sub'];
		
		if ($RS_item[0]['item_size_land'] != null) {
			$item_size_land = $RS_item[0]['item_size_land'] . '㎡（';
			$item_size_land = $item_size_land . round($RS_item[0]['item_size_land'] * 0.302, 2) . '坪）';
		} else {
			$item_size_land = '';
		}
		
		if ($RS_item[0]['date_soldout'] != '') {
			$date_soldout = date('Y年m月d日', strtotime($RS_item[0]['date_soldout']));
			$date1 = strtotime($RS_item[0]['date_soldout']);
			$date2 = strtotime($RS_item[0]['date_regist']);
			$date_soldout = $date_soldout . '<br>(' . floor(($date1 - $date2) / 86400) . '日)';
		} else {
			$date_soldout = '----';
		}
		
		
		//get cat_item
		$select = 'cat_item_cd';
		$table = 'r_item1';
		$where = 'item_cd = \'' . $item_cd . '\'';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'cat_item', $where, $orderBy);
		
		//get seller
		$select = 'seller_name';
		$table = 'r_item1, m_seller';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\''
				.' AND r_item1.seller_cd = m_seller.seller_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'seller', $where, $orderBy);
		
		//get size detail
		//old database (before 27/06)
		$table = 't_size_detail, r_item7';
		$where = 'r_item7.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item7.size_detail_cd = t_size_detail.size_detail_cd';
		$orderBy = '';

		get_rs($table, 'size_detail', $where, $orderBy);
		
		//new database (from 27/06)
				/*$table = 't_size_detail, r_size_detail';
				$where = 'r_size_detail.item_cd = \'' . $item_cd . '\' AND '
					. 'r_size_detail.size_detail_cd = t_size_detail.size_detail_cd';
				$orderBy = '';
		
				get_rs($table, 'size_detail', $where, $orderBy);*/
		
		$item_size_build = '';
		if($RS_cat_item[0]['cat_item_cd'] == 1) {
			$item_size_build = $item_size_build . $RS_item[0]['item_size_build'] . '㎡（';								
			$item_size_build = $item_size_build . round($RS_item[0]['item_size_build'] * 0.302, 2) . '坪）';
		} else {
			$item_size_build = $item_size_build . $RS_item[0]['item_size_floor'] . '㎡（';								
			$item_size_build = $item_size_build . round($RS_item[0]['item_size_floor'] * 0.302, 2) . '坪）';
		}								
		if($RS_size_detail[0]) {
			for ($i = 0; $i < count($RS_size_detail) ; $i++) {
				$item_size_build = $item_size_build . '<br>' . $RS_size_detail[$i]['size_detail_name'];
				$item_size_build = $item_size_build . '	: '. $RS_size_detail[$i]['size_detail_size'] . '㎡';
			}
		}					
		
		//get floor plan
		$select = 'layout_name';
		$table = 'm_layout, r_item1';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item1.layout_cd = m_layout.layout_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'layout', $where, $orderBy);
		
		$layout = '';
		for($i = 0; $i < count($RS_layout); $i++) {
			$layout = $layout . $RS_layout[$i]['layout_name'];
		}
		
		//get pubtrans
		//old database (before 27/06)
		$select = 'pubtrans_name, stop_name, transway_name, transtime';
		$table = 'm_transway, m_stop, m_pubtrans, r_item2';
		$where = 'r_item2.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item2.pubtrans_cd = m_pubtrans.pubtrans_cd AND '
			. 'r_item2.stop_cd = m_stop.stop_cd AND '
			. 'r_item2.transway_cd = m_transway.transway_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'pubtrans', $where, $orderBy);
		
		//new database (from 27/06)
				/*$select = 'pubtrans_name, stop_name, transway_name, nearest_time';
				$table = 'm_transway, m_stop, m_pubtrans, r_nearest, t_nearest, r_stop';
				$where = 'r_nearest.item_cd = \'' . $item_cd . '\' AND '
					. 'r_stop.pubtrans_cd = m_pubtrans.pubtrans_cd AND '
					. 'r_stop.stop_cd = m_stop.stop_cd AND '
					. 'r_nearest.stop_cd = m_stop.stop_cd AND '
					. 'r_nearest.nearest_cd = t_nearest.nearest_cd AND '
					. 'r_nearest.transway_cd = m_transway.transway_cd';
				$orderBy = '';
		
				Omi_get_rs($select, $table, 'pubtrans', $where, $orderBy);*/
		
		$pubtrans = '';
		for ($i = 0; $i < count($RS_pubtrans); $i++) {
			$pubtrans = $pubtrans . $RS_pubtrans[$i]['pubtrans_name'];
			$pubtrans = $pubtrans . ' 「';
			$pubtrans = $pubtrans . $RS_pubtrans[$i]['stop_name'];
			$pubtrans = $pubtrans . '」 駅まで';
			$pubtrans = $pubtrans . $RS_pubtrans[$i]['transway_name'];
			$pubtrans = $pubtrans . $RS_pubtrans[$i]['transtime'];
			$pubtrans = $pubtrans . '分<br>';
		} 
		
		//get road
		//old database (before 27/06)
		$select = 'dire_name, road_name, along_size';
		$table = 'm_road, t_along, m_direction, r_item8';
		$where = 'r_item8.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item8.road_cd = m_road.road_cd AND '
			. 'r_item8.along_cd = t_along.along_cd AND '
			. 'r_item8.dire_cd = m_direction.dire_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'road', $where, $orderBy);
		
		//new database (from 27/06)
				/*$select = 'dire_name, road_name, along_size';
				$table = 'm_road, t_along, m_direction, r_along';
				$where = 'r_along.item_cd = \'' . $item_cd . '\' AND '
					. 'r_along.road_cd = m_road.road_cd AND '
					. 'r_along.along_cd = t_along.along_cd AND '
					. 'r_along.dire_cd = m_direction.dire_cd';
				$orderBy = '';
		
				Omi_get_rs($select, $table, 'road', $where, $orderBy);*/
		
		$road = null;		
		for ($i = 0; $i < count($RS_road); $i++) { 
			$road = $road . $RS_road[$i]['dire_name'] . '側';
			$road = $road . $RS_road[$i]['along_size'] . 'm';
			$road = $road . $RS_road[$i]['road_name'] . '<br>';
		}	
	
		//get schools
		$select = 'school_pri_name';
		$table = 'm_school_primary, r_item1';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item1.school_pri_cd = m_school_primary.school_pri_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'school_pri', $where, $orderBy);
		//--
		$select = 'school_jun_name';
		$table = 'm_school_junior, r_item1';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item1.school_jun_cd = m_school_junior.school_jun_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'school_jun', $where, $orderBy);
		//--
		$select = 'cat_schigh_name';
		$table = 'm_cat_schigh, r_item1';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item1.cat_schigh_cd = m_cat_schigh.cat_schigh_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'cat_schigh', $where, $orderBy);
		
		$school = '';
		if($RS_school_pri[0]) {
			for($i = 0; $i < count($RS_school_pri); $i++) {
				$school = $school . $RS_school_pri[$i]['school_pri_name'];
				$school = $school . '	: ';
				$school = $school . $RS_item[$i]['item_dist_pri'] . 'm';
				$school = $school . '(' . $RS_item[$i]['item_min_pri'] . '分）';
				$school = $school . '<br>';
			}
		}
		if($RS_school_jun[0]) {
			for($i = $i; $i < count($RS_school_jun); $i++) {
				$school = $school . $RS_school_jun[$i]['school_jun_name'];
				$school = $school . '	: ';
				$school = $school . $RS_item[$i]['item_dist_jun'] . 'm';
				$school = $school . '(' . $RS_item[$i]['item_min_jun'] . '分）';
				$school = $school . '<br>';
			}
		}
		if($RS_cat_schigh[0]) {
			for($i = 0; $i < count($RS_cat_schigh); $i++) {
				$school = $school . '高校学区	: ';
				$school = $school . $RS_cat_schigh[$i]['cat_schigh_name'];
			}
		}
		
		//get water, sewer, fuel
		$select = 'water_name';
		$table = 'm_waterworks, r_item1';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item1.water_cd = m_waterworks.water_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'water', $where, $orderBy);
		
		$select = 'sewer_name';
		$table = 'm_sewer, r_item1';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item1.sewer_cd = m_sewer.sewer_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'sewer', $where, $orderBy);
		
		$select = 'fuel_name';
		$table = 'm_fuel, r_item1';
		$where = 'r_item1.item_cd = \'' . $item_cd . '\' AND '
			. 'r_item1.fuel_cd = m_fuel.fuel_cd';
		$orderBy = '';
	
		Omi_get_rs($select, $table, 'fuel', $where, $orderBy);
		$equip = '';
		for($i = 0; $i < count($RS_fuel); $i++) {
			$equip = $equip . 'ガス	:';
			$equip = $equip . $RS_fuel[$i]['fuel_name'];
			$equip = $equip . '<br/>';
		}
		
		for($i = 0; $i < count($RS_water); $i++) {
			$equip = $equip . '上水道	：';
			$equip = $equip . $RS_water[$i]['water_name'];
			$equip = $equip . '<br/>';
		}
		
		for($i = 0; $i < count($RS_sewer); $i++) {
			$equip = $equip . '下水道	：';
			$equip = $equip . $RS_sewer[$i]['sewer_name'];
			$equip = $equip . '<br/>';
		}
		
		//---	
		$details[] = array(
			'item_cd' => $item_cd,
			'item_img' => $link_img_main_s,
			'item_name' => $item_name,
			'item_price' => $RS_item[0]['item_price'],
			'date_soldout' => $date_soldout,
			'seller' => $RS_seller[0]['seller_name'],
			'item_size_land' => $item_size_land,
			'item_size_build' => $item_size_build,
			'item_layout' => $layout,
			'item_pubtrans' => $pubtrans,
			'item_road' => $road,
			'item_school' => $school,
			'item_equip' => $equip,
			);
	}
	
	//convert to json
	$result_json = json_encode($details);
	header('Content-type:application/json;charset=utf-8');
	echo $result_json;
	return 1;		
	/*--Ominext end--*/
	break;

	case "get_analysis":
		/* --Ominext-- */
		/* --analysis a group item AJAX-- */
	
		/* validate */
		if (isset($_POST['from']) && isset($_POST['to'])) {
			$from = $_POST['from'];
			$to = $_POST['to'];
			if ($from > $to) {
				return 1;
			}
		}
	
		/* search db */
		$opt = $_POST['select_opt'];
	
	
		if ($opt == 1) { //count item - soldout
			$select = 't_item.date_soldout AS date, COUNT(t_item.item_cd) AS count';
			$table = 't_item, r_item1';
			$groupBy = 't_item.date_soldout';
	
			$where = 't_item.item_cd = r_item1.item_cd';
		} else if ($opt == 2) { //count item - regist
			$select = 't_item.date_regist AS date, COUNT(t_item.item_cd) AS count';
			$table = 't_item, r_item1';
			$groupBy = 't_item.date_regist';
	
			$where = 't_item.item_cd = r_item1.item_cd';
		} else if ($opt == 3) { //count item - total
			$select = 't_item.date_regist AS date, t_item.item_cd';
			$table = 't_item, r_item1';
	
			$where = 't_item.item_cd = r_item1.item_cd';
		} else if ($opt == 4) { //avg price - soldout
			$select = 't_history.date_regist AS date, SUM(t_history.hist_price) AS sum, COUNT(t_item.item_cd) as count';
			$table = 't_item, r_item1, r_history, t_history';
			$groupBy = 't_history.date_regist';
	
			$where = 't_item.item_cd = r_history.item_cd AND '
				. 'r_history.hist_cd = t_history.hist_cd AND '
				. 't_item.item_cd = r_item1.item_cd AND '
				. 'r_history.stat_cd = \'6\'';
		} else { //avg price - regist
			$select = 't_history.date_regist AS date, SUM(t_history.hist_price) AS sum, COUNT(t_item.item_cd) as count';
			$table = 't_item, r_history, t_history, r_item1';
			$groupBy = 't_history.date_regist';
	
			$where = 't_item.item_cd = r_history.item_cd AND '
				. 'r_history.hist_cd = t_history.hist_cd AND '
				. 't_item.item_cd = r_item1.item_cd AND '
				. 'r_history.stat_cd = \'1\'';
		}
	
		if (isset($_POST['city'])) {
			$city = $_POST['city'];
			$where = $where . ' AND r_item1.city_cd IN (';
			for ($i = 0; $i < count($city); $i++) {
				$where = $where . '\'' . $city[$i] . '\', ';
			}
			$where = substr($where, 0, -2);
			$where = $where . ')';
		}
	
		if (isset($_POST['cat_item'])) {
			$cat_item = $_POST['cat_item'];
			$where = $where . ' AND r_item1.cat_item_cd IN (';
			for ($i = 0; $i < count($cat_item); $i++) {
				$where = $where . '\'' . $cat_item[$i] . '\', ';
			}
	
			$where = substr($where, 0, -2);
			$where = $where . ')';
	
	
		}
	
		if (isset($_POST['condition'])) {
			$condition = $_POST['condition'];
			$where = $where . ' AND r_item1.condition_cd IN (';
			for ($i = 0; $i < count($condition); $i++) {
				$where = $where . '\'' . $condition[$i] . '\', ';
			}
			$where = substr($where, 0, -2);
			$where = $where . ')';
		}
	
		if (isset($_POST['seller'])) {
			$seller = $_POST['seller'];
			
			$where = $where . ' AND ( r_item1.seller_cd IN (';
			for ($i = 0; $i < count($seller); $i++) {
				$where = $where . '\'' . $seller[$i] . '\', ';
			}
			$where = substr($where, 0, -2);
			$where = $where . ')';
			
			if (in_array(0, $seller)) {
				$where = substr($where, 0, -1);
				$where = $where . ') OR r_item1.seller_cd >= 7';
			}
			$where = $where . ')';
		}
	
		// count item - soldout
		if ($opt == 1) {
			$where = $where . ' AND t_item.date_soldout BETWEEN \'' . $from . '\' AND \'' . $to . '\'';
			$where = $where . ' AND t_item.flg_soldout = \'1\'';
			Omi_get_rs_with_group_by($select, $table, 'result', $where, $groupBy);
		}
		if ($opt == 2) { //count item - regist
			$where = $where . ' AND t_item.date_regist BETWEEN \'' . $from . '\' AND \'' . $to . '\'';
			Omi_get_rs_with_group_by($select, $table, 'result', $where, $groupBy);
		}
		if ($opt == 3) { //count item - total
			//count item from beginning
			$select_all_before = 'COUNT (t_item.item_cd) as count';
			$table_all_before = 't_item, r_item1';
			$where_all_before = $where . ' AND t_item.date_regist < \'' . $from . '\'';
	
			Omi_get_rs($select_all_before, $table_all_before, 'count_all_before', $where_all_before, '');
			
			$select_soldout_before = 'COUNT(t_item.item_cd) AS count';
			$table_soldout_before = 't_item, r_item1';
			$where_soldout_before = $where . ' AND t_item.date_soldout < \'' . $from . '\'';
			$where_soldout_before = $where_soldout_before . ' AND t_item.flg_soldout = \'1\'';
			//$groupBy_soldout_before = 't_item.date_soldout';
			
			Omi_get_rs_with_group_by($select_soldout_before, $table_soldout_before, 'count_soldout_before', $where_soldout_before, '');
	
			//get all item
			$select_item_all = 't_item.date_regist AS date, t_item.item_cd';
			$table_item_all = 't_item, r_item1';
			$where_item_all = $where . ' AND t_item.date_regist BETWEEN \'' . $from . '\' AND \'' . $to . '\'';
			$orderBy_item_all = 't_item.date_regist ASC';
			
			Omi_get_rs($select_item_all, $table_item_all, 'item_all', $where_item_all, $orderBy_item_all);
			
			$select_soldout = 't_item.date_soldout AS date, t_item.item_cd';
			$table_soldout = 't_item, r_item1';
			$where_soldout = $where . ' AND t_item.date_soldout BETWEEN \'' . $from . '\' AND \'' . $to . '\'';
			$where_soldout = $where_soldout . ' AND t_item.flg_soldout = \'1\'';
			$orderBy_soldout = 't_item.date_soldout ASC';
			Omi_get_rs($select_soldout, $table_soldout, 'item_soldout', $where_soldout, $orderBy_soldout);
		}
		if ($opt == 4) { //avg price - soldout
			$where = $where . ' AND t_history.date_regist BETWEEN \'' . $from . '\' AND \'' . $to . '\'';
			Omi_get_rs_with_group_by($select, $table, 'result', $where, $groupBy);
		}
		if ($opt == 5) { //avg price - regist
			$where = $where . ' AND t_history.date_regist BETWEEN \'' . $from . '\' AND \'' . $to . '\'';
			Omi_get_rs_with_group_by($select, $table, 'result', $where, $groupBy);
		}
	
	
		//get data for google chart
		//count item - soldout / regist
		if ($opt <= 2) {
			$result = array();
			$date1=date_create($from);
			$date2=date_create($to);
			$diff_days = date_diff($date1,$date2)->days;
			
			for ($i = 0; $i < count($RS_result); $i++) {
				if ($diff_days > 730) { //if more than 2 years get data per month
					$date = date('Y-m', strtotime($RS_result[$i]['date']));
					
					$date = date('Y-m-d',strtotime($date.'-16'));
					
				} else if ($diff_days > 365) { //1-2 years get data per 2 weeks
					$date = date('Y-m-d', strtotime($RS_result[$i]['date']));
					$dayNumber = date('z', strtotime($RS_result[$i]['date']));
					
					$diff = '+'.(7-($dayNumber % 14)).' days';
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else if ($diff_days > 180) { //6-12 month get data per week
					$date = date('Y-m-d', strtotime($RS_result[$i]['date']));
					
					$day = date('w', strtotime($RS_result[$i]['date']));
					$diff = '+'.(4-$day).' days';
					
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else if ($diff_days > 60) { // 2-6 months get data per 3 days
					$date = date('Y-m-d', strtotime($RS_result[$i]['date']));
					$dayNumber = date('z', strtotime($RS_result[$i]['date']));
					
					$diff = '+'.(1-($dayNumber % 3)).' days';
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else { //less than 2 months get data per day
					$date = date('Y-m-d', strtotime($RS_result[$i]['date']));
				}
				
				$j = search_in_column($date, $result, 'x_axis');
				if ( $j >= 0 ) {
					$result[$j]['y_axis'] += (int) $RS_result[$i]['count'];
				} else {			
					$result[] = array(	
						'x_axis' => $date,
						'y_axis' => (int) $RS_result[$i]['count']
					);
				}
			}
			//sort by date
			usort($result, function($a, $b) {
				return $a['x_axis'] > $b['x_axis'];
			});
		}
	
		//count item - total 
		if ($opt == 3) {
			//count item from beginning
			$totalItemFromBegin = (int) ($RS_count_all_before[0]['count']) - (int) ($RS_count_soldout_before[0]['count']);
		
			//count number item change eachday
			$countNumberItemChange = array();
			$index = 0;
			
			for ($i = 0; $i < count($RS_item_all); $i++) {
				$date = date('Y-m-d', strtotime($RS_item_all[$i]['date']));
				
				if ($date > $countNumberItemChange[$index]['date']) {
					$countNumberItemChange[] = array(
						'date' => $date,
						'count' => (int) (1),
					);
	
					$index++;
				} else {
					$countNumberItemChange[$index]['count'] = (int) $countNumberItemChange[$index]['count'] + 1;
				}
			}
			
			for ($i = 0; $i < count($RS_item_soldout); $i++) {
				$date = date('Y-m-d', strtotime($RS_item_soldout[$i]['date']));
				
				$j = search_in_column($date, $countNumberItemChange, 'date');
				if ( $j >= 0 ) {		
					$countNumberItemChange[$j]['count'] = $countNumberItemChange[$j]['count'] - 1;
	
				} else {
					$countNumberItemChange[] = array(
						'date' => $date,
						'count' => (int) (-1),
					);
				}
			}
			
			usort($countNumberItemChange, function($a, $b) {
				return $a['date'] > $b['date'];
			});
	
			//set temp
			$temp[] = array(
				'x_axis' => '1970-01-01',
				'y_axis' => $totalItemFromBegin
			);
			$index = 0;
			
			//count
			$result = array();
			
			$date1=date_create($from);
			$date2=date_create($to);
			$diff_days = date_diff($date1,$date2)->days;
			
			for ($i = 0; $i < count($countNumberItemChange); $i++) {
				if ($diff_days > 730) { //if more than 2 years get data per month
					$date = date('Y-m', strtotime($countNumberItemChange[$i]['date']));
					
					$date = date('Y-m-d',strtotime($date.'-16'));
	
				} else if ($diff_days > 365) { //1-2 years get data per 2 weeks
					$date = date('Y-m-d', strtotime($countNumberItemChange[$i]['date']));
					$dayNumber = date('z', strtotime($countNumberItemChange[$i]['date']));
					
					$diff = '+'.(7-($dayNumber % 14)).' days';
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else if ($diff_days > 180) { //6-12 month get data per week
					$date = date('Y-m-d', strtotime($countNumberItemChange[$i]['date']));
					
					$day = date('w', strtotime($countNumberItemChange[$i]['date']));
					$diff = '+'.(4-$day).' days';
					
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else if ($diff_days > 60) { // 2-6 months get data per 3 days
					$date = date('Y-m-d', strtotime($countNumberItemChange[$i]['date']));
					$dayNumber = date('z', strtotime($countNumberItemChange[$i]['date']));
					
					$diff = '+'.(1-($dayNumber % 3)).' days';
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else { //else get data per day
					$date = date('Y-m-d', strtotime($countNumberItemChange[$i]['date']));
				}
	
				if ($date > $temp[$index]['x_axis']) {
					$temp[] = array(
						'x_axis' => $date,
						'y_axis' => (int) $temp[$index]['y_axis'] + (int) ($countNumberItemChange[$i]['count']),
					);
					$index++;
					
				} else {
					$temp[$index]['y_axis'] = (int) $temp[$index]['y_axis'] + (int) ($countNumberItemChange[$i]['count']);
				}
			}
	
			//don't get first item			
			for ($i = 1; $i < count($temp); $i++) {
				$result[] = array(
					'x_axis' => $temp[$i]['x_axis'],
					'y_axis' => $temp[$i]['y_axis'],
				);
			}
			
			//dump data
			$RS_result = array(
				'temp' => '1'
			);
		}
	
		//avg price - soldout / regist
		if ($opt >= 4) {
	
			//dummy data
			$temp[] = array(
				'date' => '0000-00-00',
				'sum' => '0',
				'count' => '0'
			);
			
			$date1=date_create($from);
			$date2=date_create($to);
			$diff_days = date_diff($date1,$date2)->days;
	
			//count item and sum price
			for ($i = 0; $i < count($RS_result); $i++) {
				if ($diff_days > 365) { // over 1 year get data per month
					$date = date('Y-m', strtotime($RS_result[$i]['date']));
					
					$date = date('Y-m-d',strtotime($date.'-16'));
					
				} else if ($diff_days > 180) { // more than 6 month get data per 2 weeks
					$date = date('Y-m-d', strtotime($RS_result[$i]['date']));
					$dayNumber = date('z', strtotime($RS_result[$i]['date']));
					
					$diff = '+'.(7-($dayNumber % 14)).' days';
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else if ($diff_days > 30) { // more than 1 month get data per week
					$date = date('Y-m-d', strtotime($RS_result[$i]['date']));
					
					$day = date('w', strtotime($RS_result[$i]['date']));
					$diff = '+'.(4-$day).' days';
					
					$date = str_replace('-', '/', $date);
					$date = date('Y-m-d',strtotime($date . $diff));
					
				} else { //less than 1 months get data per day
					$date = date('Y-m-d', strtotime($RS_result[$i]['date']));
				}
	
				$j = search_in_column($date, $temp, 'date');
				if ( $j >= 0 ) {
					$temp[$j]['sum'] += $RS_result[$i]['sum'];
					$temp[$j]['count'] += $RS_result[$i]['count'];
				} else {
					$temp[] = array(
						'date' => $date,
						'sum' => $RS_result[$i]['sum'],
						'count' => $RS_result[$i]['count']
					);
				}
			}
	
			//sort by date
			usort($temp, function($a, $b) {
				return $a['date'] > $b['date'];
			});
	
			//get avg price per day
			//dont get dummy data
			for ($i = 1; $i < count($temp); $i++) {
				$result[] = array(
					'x_axis' => $temp[$i]['date'],
					'y_axis' => $temp[$i]['sum'] / $temp[$i]['count']
				);
			}
		}
		if (count($RS_result) == 0) {
			$result = null;
		}
	
	
		//convert to json
		$result_json = json_encode($result);
		header('Content-type:application/json;charset=utf-8');
		echo $result_json;
		return 1;
		/* --Ominext end-- */
	break;
	
	case "get_info_group_item_on_demand":
		/* --Ominext-- */
		/* --get item in radius AJAX-- */
		/* validate */
		if (isset($_POST['from']) && isset($_POST['to'])) {
			$from = $_POST['from'];
			$to = $_POST['to'];
			if ($from > $to) {
				return 1;
			}
		}
		//get all item	
		$select_item_point = 't_item.item_cd, t_item.date_regist as regist, t_item.item_build,'
							.' t_item.date_soldout, r_item1.cat_item_cd, r_item1.city_cd,'
							.' r_item1.seller_cd, m_seller.seller_name, r_history.stat_cd, t_history.date_regist, t_history.*';
		$table_item_point = 't_item, r_item1, r_history, t_history, m_seller';
		$where_item_point = 'r_history.item_cd = t_item.item_cd'
							.' AND r_item1.item_cd = t_item.item_cd'
							.' AND r_item1.seller_cd = m_seller.seller_cd'
							.' AND r_history.hist_cd = t_history.hist_cd'
							//.' AND t_item.flg_soldout = \'1\''
							.' AND t_item.date_regist BETWEEN \'' . $from . '\' AND \'' . $to . '\'';
		$orderBy_item_point = 'r_item1.seller_cd ASC, r_history.item_cd ASC, t_history.date_regist ASC';
		
		if (isset($_POST['city'])) {
			$city = $_POST['city'];
			$where_item_point = $where_item_point . ' AND r_item1.city_cd IN (';
			for ($i = 0; $i < count($city); $i++) {
				$where_item_point = $where_item_point . '\'' . $city[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
		
		if (isset($_POST['cat_item'])) {
			$cat_item = $_POST['cat_item'];
			$where_item_point = $where_item_point . ' AND r_item1.cat_item_cd IN (';
			for ($i = 0; $i < count($cat_item); $i++) {
				$where_item_point = $where_item_point . '\'' . $cat_item[$i] . '\', ';
			}
	
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
	
		if (isset($_POST['condition'])) {
			$condition = $_POST['condition'];
			$where_item_point = $where_item_point . ' AND r_item1.condition_cd IN (';
			for ($i = 0; $i < count($condition); $i++) {
				$where_item_point = $where_item_point . '\'' . $condition[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
		
		if (isset($_POST['layout'])) {
			$layout = $_POST['layout'];
			$where_item_point = $where_item_point . ' AND r_item1.layout_cd IN (';
			for ($i = 0; $i < count($layout); $i++) {
				$where_item_point = $where_item_point . '\'' . $layout[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
		}
		
		if (isset($_POST['seller'])) {
			$seller = $_POST['seller'];
			
			$where_item_point = $where_item_point . ' AND ( r_item1.seller_cd IN (';
			for ($i = 0; $i < count($seller); $i++) {
				$where_item_point = $where_item_point . '\'' . $seller[$i] . '\', ';
			}
			$where_item_point = substr($where_item_point, 0, -2);
			$where_item_point = $where_item_point . ')';
			
			if (in_array(0, $seller)) {
				$where_item_point = substr($where_item_point, 0, -1);
				$where_item_point = $where_item_point . ') OR r_item1.seller_cd >= 7';
			}
			$where_item_point = $where_item_point . ')';
		}	
		
		Omi_get_rs($select_item_point, $table_item_point, 'item_point', $where_item_point, $orderBy_item_point);
		
		$list_item = array();
		
		for($i = 0; $i < count($RS_item_point); $i++) {
			$price_regist = null;
			$price_soldout = null;
			if ($RS_item_point[$i]['stat_cd'] == '1') {
				$price_regist = $RS_item_point[$i]['hist_price'];
			}
			if ($RS_item_point[$i]['stat_cd'] == '6') {
				$price_soldout = $RS_item_point[$i]['hist_price'];
			}
			
			if ($RS_item_point[$i]['date_soldout'] <= $RS_item_point[$i]['item_build']) {
				$diff = strtotime($RS_item_point[$i]['date_soldout']) - strtotime($RS_item_point[$i]['item_build']);
				$time = ceil((($diff > 0) ? $diff : 0) /86400);
			} else {
				$diff = strtotime($RS_item_point[$i]['date_soldout']) - strtotime($RS_item_point[$i]['regist']);
				$time = ceil((($diff > 0) ? $diff : 0) /86400);
			}
			
			$list_item[] = array(	
				'item_cd' => $RS_item_point[$i]['item_cd'],
				'stat_cd' => $RS_item_point[$i]['stat_cd'],
				'regist' => $RS_item_point[$i]['regist'],
				'date_build' => $RS_item_point[$i]['item_build'],
				'date_soldout' => $RS_item_point[$i]['date_soldout'],
				'price_regist' => $price_regist,
				'price_soldout' => $price_soldout,
				'hist_regist' => $RS_item_point[$i]['date_regist'],
				'seller_cd' => ($RS_item_point[$i]['seller_cd'] >= "7" || $RS_item_point[$i]['seller_cd'] == '')
								? "7" : $RS_item_point[$i]['seller_cd'],
				'seller_name' => $RS_item_point[$i]['seller_name'],
				'city_cd' => $RS_item_point[$i]['city_cd'],
				'time' => $time,
			);
		}
			
		$items = array();
		$history = array();
		$price_regist = null;
		$price_soldout = null;
		for ($i = 0; $i < count($list_item); $i++) {
			if ($list_item[$i]['item_cd'] == $list_item[$i - 1]['item_cd'] || $i == 0 ) {
				$history[] = array(
							'stat_cd' => $list_item[$i]['stat_cd'],
							'hist_regist' => $list_item[$i]['hist_regist']
								);
				if ($list_item[$i]['stat_cd'] == 1) {
					$price_regist = $list_item[$i]['price_regist'];
				}
				if ($list_item[$i]['stat_cd'] == 6) {
					$price_soldout = $list_item[$i]['price_soldout'];
				}
			} else {
				$items[] = array(
						'item_cd' => $list_item[$i - 1]['item_cd'],
						'regist' => $list_item[$i - 1]['regist'],
						'date_build' => $list_item[$i - 1]['date_build'],
						'date_soldout' => $list_item[$i - 1]['date_soldout'],
						'price_regist' => $price_regist,
						'price_soldout' => $price_soldout,
						'time' => $list_item[$i - 1]['time'],
						'seller_cd' => $list_item[$i - 1]['seller_cd'],
						'seller_name' => $list_item[$i - 1]['seller_name'],
						'city_cd' => $list_item[$i - 1]['city_cd'],
						'history' => $history
					);
				
				$price_regist = null;
				$price_soldout = null;	
				$history = null;
				
				if ($list_item[$i]['stat_cd'] == 1) {
					$price_regist = $list_item[$i]['price_regist'];
				}
				if ($list_item[$i]['stat_cd'] == 6) {
					$price_soldout = $list_item[$i]['price_soldout'];
				}
				$history[] = array(
						'stat_cd' => $list_item[$i]['stat_cd'],
						'hist_regist' => $list_item[$i]['hist_regist']
							);
			}
		}
		
		$items[] = array(
						'item_cd' => $list_item[$i - 1]['item_cd'],
						'regist' => $list_item[$i - 1]['regist'],
						'date_build' => $list_item[$i - 1]['date_build'],
						'date_soldout' => $list_item[$i - 1]['date_soldout'],
						'price_regist' => $price_regist,
						'price_soldout' => $price_soldout,
						'time' => $list_item[$i - 1]['time'],
						'seller_cd' => $list_item[$i - 1]['seller_cd'],
						'seller_name' => $list_item[$i - 1]['seller_name'],
						'city_cd' => $list_item[$i - 1]['city_cd'],
						'history' => $history
					);		
					
		$result = array();
		$array_item = array();
		for ($i = 0; $i < count($items); $i++) {
			if ($items[$i]['seller_cd'] == $items[$i - 1]['seller_cd'] || $i == 0 ) {
				$array_item[] = array(
									'item_cd' => $items[$i]['item_cd'],
									'regist' => $items[$i]['regist'],
									'date_build' => $items[$i]['date_build'],
									'date_soldout' => $items[$i]['date_soldout'],
									'price_regist' => $items[$i]['price_regist'],
									'price_soldout' => $items[$i]['price_soldout'],
									'time' => $items[$i]['time'],
									'city_cd' => $items[$i]['city_cd'],
									'history' => $items[$i]['history']
								);
			} else {
				$result[] = array(
						'seller_cd' => $items[$i - 1]['seller_cd'],
						'seller_name' => $items[$i - 1]['seller_name'],
						'items' => $array_item
					);
				
				$array_item = null;
				$array_item[] = array(
									'item_cd' => $items[$i]['item_cd'],
									'regist' => $items[$i]['regist'],
									'date_build' => $items[$i]['date_build'],
									'date_soldout' => $items[$i]['date_soldout'],
									'price_regist' => $items[$i]['price_regist'],
									'price_soldout' => $items[$i]['price_soldout'],
									'time' => $items[$i]['time'],
									'city_cd' => $items[$i]['city_cd'],
									'history' => $items[$i]['history']
								);				
			}
		}
		$result[] = array(
						'seller_cd' => $items[$i - 1]['seller_cd'],
						'seller_name' => $items[$i - 1]['seller_name'],
						'items' => $array_item
					);
					
		if ($result[count($result) - 1]['seller_cd'] == "7") {
			$result[count($result) - 1]['seller_name'] = 'その他';
		}			
		
		//convert to json
		$result_json = json_encode($result);
		header('Content-type:application/json;charset=utf-8');
		echo $result_json;
		return 1;
		/*--Ominext end--*/
	break;

	default :
		break;
}


if($F_regist or $F_copy){
	$rs = exec_sql($db, "begin", $_SERVER["SCRIPT_NAME"]); //▼トランザクションBEGIN▼
	if($F_copy){
		$item_cd_org = $F_item_cd;
		$F_item_cd = "";
		$_REQUEST['item_name'] = "【コピー】".$_REQUEST['item_name'];
	}
	if($F_item_cd){
		$item_cd = $F_item_cd;
	}else{
		unset($_REQUEST['item_cd']);
	}
	$_REQUEST['item_youtube'] = str_replace("http://youtu.be/", "http://www.youtube.com/embed/", $_REQUEST['item_youtube']);
	$_REQUEST['item_build'] = $F_item_build_y."-".$F_item_build_m."-01";
	if($F_cat_item_cd == 1){
		$_REQUEST['item_size_floor'] = $F_item_size_build;
	}
  if($F_item_cd){
    $item_price_last = get_colum_key("v_item", "item_cd", $F_item_cd, "item_price", "");
  }
	//t_item
	if($F_item_cd){
		$item_point = "(".$F_item_lat.",".$F_item_lng.")";
		$add_clm_array = array("item_point");
		$add_value_array = array($item_point);
		update_db_same_name($_REQUEST, "t_item", $add_clm_array, $add_value_array, "item_cd='".$F_item_cd."'");
	}else{
		$item_cd = $item_sort = make_cd("t_item", "item_cd", "");
		$item_point = "(".$F_item_lat.",".$F_item_lng.")";
		$add_clm_array = array("item_cd", "item_sort", "date_regist", "item_point");
		$add_value_array = array($item_cd, $item_sort, date("Y-m-d H:i:s"), $item_point);
		insert_db_same_name($_REQUEST, "t_item", $add_clm_array, $add_value_array);
	}
	//r_item1
	if($F_item_cd){
		update_db_same_name($_REQUEST, "r_item1", $add_clm_array="", $add_value_array="", "item_cd='".$F_item_cd."'");
	}else{
		$rel_cd = make_cd("r_item1", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd");
		$add_value_array = array($rel_cd, $item_cd);
		insert_db_same_name($_REQUEST, "r_item1", $add_clm_array, $add_value_array);
	}
	//r_item2
	if($F_item_cd){
		$sql = "delete from r_item2 where item_cd='".$F_item_cd."'";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_stop_cd); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$rel_cd = make_cd("r_item2", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "pubtrans_cd", "stop_cd", "transway_cd", "transdist", "transtime");
		$add_value_array = array($rel_cd, $item_cd, $F_pubtrans_cd[$i], $F_stop_cd[$i], $F_transway_cd[$i], $F_transdist[$i], $F_transtime[$i]);
		insert_db_same_name("", "r_item2", $add_clm_array, $add_value_array);
	}
	//r_item5
	if($F_item_cd){
		$sql = "delete from t_cost where cost_cd in (select cost_cd from r_item5 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item5 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_cost_name); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$cost_cd = $cost_sort = make_cd("t_cost", "cost_cd", "");
		$add_clm_array = array("cost_cd", "cost_sort", "cost_name", "cost_price");
		$add_value_array = array($cost_cd, $cost_sort, $F_cost_name[$i], $F_cost_price[$i]);
		insert_db_same_name("", "t_cost", $add_clm_array, $add_value_array);
		$rel_cd = make_cd("r_item5", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "cost_cd");
		$add_value_array = array($rel_cd, $item_cd, $cost_cd);
		insert_db_same_name("", "r_item5", $add_clm_array, $add_value_array);
	}
	//r_item6
	if($F_item_cd){
		$sql = "delete from t_size_add where size_add_cd in (select size_add_cd from r_item6 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item6 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_size_add_name); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$size_add_cd = $size_add_sort = make_cd("t_size_add", "size_add_cd", "");
		$add_clm_array = array("size_add_cd", "size_add_sort", "size_add_name", "size_add_size");
		$add_value_array = array($size_add_cd, $size_add_sort, $F_size_add_name[$i], $F_size_add_size[$i]);
		insert_db_same_name("", "t_size_add", $add_clm_array, $add_value_array);
		$rel_cd = make_cd("r_item6", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "size_add_cd");
		$add_value_array = array($rel_cd, $item_cd, $size_add_cd);
		insert_db_same_name("", "r_item6", $add_clm_array, $add_value_array);
	}
	//r_item7
	if($F_item_cd){
		$sql = "delete from t_size_detail where size_detail_cd in (select size_detail_cd from r_item7 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item7 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_size_detail_name); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$size_detail_cd = $size_detail_sort = make_cd("t_size_detail", "size_detail_cd", "");
		$add_clm_array = array("size_detail_cd", "size_detail_sort", "size_detail_name", "size_detail_size");
		$add_value_array = array($size_detail_cd, $size_detail_sort, $F_size_detail_name[$i], $F_size_detail_size[$i]);
		insert_db_same_name("", "t_size_detail", $add_clm_array, $add_value_array);
		$rel_cd = make_cd("r_item7", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "size_detail_cd");
		$add_value_array = array($rel_cd, $item_cd, $size_detail_cd);
		insert_db_same_name("", "r_item7", $add_clm_array, $add_value_array);
	}
	//r_item8
	if($F_item_cd){
		$sql = "delete from t_along where along_cd in (select along_cd from r_item8 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item8 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_along_size); $i++) {
		if($F_along_size[$i]){
			if($i == 0){ continue; } //1つ目は複製用の為
			$along_cd = $along_sort = make_cd("t_along", "along_cd", "");
			$add_clm_array = array("along_cd", "along_sort", "along_size");
			$add_value_array = array($along_cd, $along_sort, $F_along_size[$i]);
			insert_db_same_name("", "t_along", $add_clm_array, $add_value_array);
			$rel_cd = make_cd("r_item8", "rel_cd", "");
			$add_clm_array = array("rel_cd", "item_cd", "along_cd", "dire_cd", "road_cd");
			$add_value_array = array($rel_cd, $item_cd, $along_cd, $F_along_dire_cd[$i], $F_road_cd[$i]);
			insert_db_same_name("", "r_item8", $add_clm_array, $add_value_array);
		}
	}
	//r_item9
	if($F_item_cd){
		$sql= "delete from r_item9 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_dist_cd); $i++) {
		if($i == 0){ continue; } //1つ目は複製用の為
		$rel_cd = make_cd("r_item9", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "dist_cd");
		$add_value_array = array($rel_cd, $item_cd, $F_dist_cd[$i]);
		insert_db_same_name("", "r_item9", $add_clm_array, $add_value_array);
	}
	//r_item10
	if($F_item_cd){
		$sql= "delete from r_item10 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
	}
	for ($i = 0; $i < count($F_user_cd_chase); $i++) {
		$rel_cd = make_cd("r_item10", "rel_cd", "");
		$add_clm_array = array("rel_cd", "item_cd", "user_cd");
		$add_value_array = array($rel_cd, $item_cd, $F_user_cd_chase[$i]);
		insert_db_same_name("", "r_item10", $add_clm_array, $add_value_array);
	}



	//r_history
	if($F_item_cd){
		
		$sql = "delete from t_history where hist_cd in (select hist_cd from r_history where item_cd = ".$F_item_cd.");";
		$sql.= "delete from r_history where item_cd = ".$F_item_cd.";";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		
    if($F_item_price != $item_price_last){
			
      array_push($F_hist_date_regist, date("Y-m-d"));
      array_push($F_hist_stat_cd, 2); //価格改定
      array_push($F_hist_price, $F_item_price);
      array_push($F_hist_user_cd, "");
      array_push($F_hist_mem_cd, "");
      array_push($F_hist_memo, "");
			
    }
		
	}else{
		
    if(!$F_copy){
      array_push($F_hist_date_regist, date("Y-m-d"));
      array_push($F_hist_stat_cd, 1); //販売開始
      array_push($F_hist_price, $F_item_price);
      array_push($F_hist_user_cd, "");
      array_push($F_hist_mem_cd, "");
      array_push($F_hist_memo, "");
    }

	}
	
	for ($i = 0; $i < count($F_hist_price); $i++) {
		
		if($F_hist_date_regist[$i] and $F_hist_stat_cd[$i] and $F_hist_price[$i]){
			
			if($i == 0){ continue; } //1つ目は複製用の為
			
			//t_history
			$hist_cd = $hist_sort = make_cd("t_history", "hist_cd", "");
			$add_clm_array = array("hist_cd", "hist_sort", "hist_price", "hist_memo", "date_regist");
			$add_value_array = array($hist_cd, $hist_sort, $F_hist_price[$i], $F_hist_memo[$i], $F_hist_date_regist[$i]);
			insert_db_same_name("", "t_history", $add_clm_array, $add_value_array);
			
			//r_history
			$rel_cd = make_cd("r_history", "rel_cd", "");
			$add_clm_array = array("rel_cd", "item_cd", "hist_cd", "stat_cd", "mem_cd", "user_cd");
			$add_value_array = array($rel_cd, $item_cd, $hist_cd, $F_hist_stat_cd[$i], $F_hist_mem_cd[$i], $F_hist_user_cd[$i]);
			insert_db_same_name("", "r_history", $add_clm_array, $add_value_array);
			
		}
		
	}
	






	//r_item11
	if($F_item_cd){
		$sql = "delete from t_history_price where hist_price_cd in (select hist_price_cd from r_item11 where item_cd='".$F_item_cd."');";
		$sql.= "delete from r_item11 where item_cd='".$F_item_cd."';";
		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
    if($F_item_price != $item_price_last){
      array_push($F_hist_price_value, $F_item_price);
      array_push($F_hist_price_date, date("Y-m-d"));
    }
	}else{
		if(!$F_copy){
			array_push($F_hist_price_value, $F_item_price);
			array_push($F_hist_price_date, date("Y-m-d"));
		}
	}
	for ($i = 0; $i < count($F_hist_price_value); $i++) {
		if($F_hist_price_value[$i]){
			if($i == 0){ continue; } //1つ目は複製用の為
			$hist_price_cd = $hist_price_sort = make_cd("t_history_price", "hist_price_cd", "");
			$add_clm_array = array("hist_price_cd", "hist_price_sort", "hist_price_value", "hist_price_date");
			$add_value_array = array($hist_price_cd, $hist_price_sort, $F_hist_price_value[$i], $F_hist_price_date[$i]);
			insert_db_same_name("", "t_history_price", $add_clm_array, $add_value_array);
			$rel_cd = make_cd("r_item11", "rel_cd", "");
			$add_clm_array = array("rel_cd", "item_cd", "hist_price_cd");
			$add_value_array = array($rel_cd, $item_cd, $hist_price_cd);
			insert_db_same_name("", "r_item11", $add_clm_array, $add_value_array);
		}
	}
//	//r_item12
//	if($F_item_cd){
//		$sql = "delete from t_img_theta where img_theta_cd in (select img_theta_cd from r_item12 where item_cd='".$F_item_cd."');";
//		$sql.= "delete from r_item12 where item_cd='".$F_item_cd."';";
//		$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
//	}
//	for ($i = 0; $i < count($F_img_theta_url); $i++) {
//		if($F_img_theta_url[$i]){
//			if($i == 0){ continue; } //1つ目は複製用の為
//			//t_img_theta
//			$img_theta_cd = $img_theta_sort = make_cd("t_img_theta", "img_theta_cd", "");
//			$add_clm_array = array("img_theta_cd", "img_theta_sort", "img_theta_number", "img_theta_title", "img_theta_url");
//			$add_value_array = array($img_theta_cd, $img_theta_sort, $img_theta_number, $F_img_theta_title[$i], $F_img_theta_url[$i]);
//			insert_db_same_name("", "t_img_theta", $add_clm_array, $add_value_array);
//			//r_item12
//			$rel_cd = make_cd("r_item12", "rel_cd", "");
//			$add_clm_array = array("rel_cd", "item_cd", "img_theta_cd");
//			$add_value_array = array($rel_cd, $item_cd, $img_theta_cd);
//			insert_db_same_name("", "r_item12", $add_clm_array, $add_value_array);
//		}
//	}

	
//イメージフォルダ準備
	$path_item = $G_up_path."/item/".sprintf("%03d",$item_cd);
	$path_detail = $G_up_path."/item/".sprintf("%03d",$item_cd)."/detail";
	$path_around = $G_up_path."/item/".sprintf("%03d",$item_cd)."/around";
	$path_theta = $G_up_path."/item/".sprintf("%03d",$item_cd)."/theta";
	if(!is_dir($path_item)){
		mkdir($path_item,0777);
		chmod($path_item,0777);
	}
	if(!is_dir($path_detail)){
		mkdir($path_detail,0777);
		chmod($path_detail,0777);
	}
	if(!is_dir($path_around)){
		mkdir($path_around,0777);
		chmod($path_around,0777);
	}
	if(!is_dir($path_theta)){
		mkdir($path_theta,0777);
		chmod($path_theta,0777);
	}
	if($F_copy){
		//画像も複写
		$path_item_org = $G_up_path."/item/".sprintf("%03d", $item_cd_org);
		$path_detail_org = $G_up_path."/item/".sprintf("%03d", $item_cd_org)."/detail";
		$path_around_org = $G_up_path."/item/".sprintf("%03d", $item_cd_org)."/around";
		$path_theta_org = $G_up_path."/item/".sprintf("%03d", $item_cd_org)."/theta";

		copy_dir($path_item_org, $path_item);
//		copy_dir($path_detail_org, $path_detail);
//		copy_dir($path_around_org, $path_around);
		
		for ($i = 0; $i < count($F_uri_detail); $i++) {
			if($F_uri_detail[$i] or $F_num_detail[$i]){
				//t_img_detail
				$img_detail_cd = $img_detail_sort = make_cd("t_img_detail", "img_detail_cd", "");
				if($F_num_detail[$i]){
					$img_detail_number = $F_num_detail[$i];
				}else{
					while(in_array($count, $F_num_detail)){
						$count++;
					}
					$img_detail_number = $count;
					$count++;
				}
				$add_clm_array = array("img_detail_cd", "img_detail_sort", "img_detail_number", "img_detail_title");
				$add_value_array = array($img_detail_cd, $img_detail_sort, $img_detail_number, $F_title_detail[$i]);
				insert_db_same_name("", "t_img_detail", $add_clm_array, $add_value_array);
				//r_item3
				$rel_cd = make_cd("r_item3", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_detail_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_detail_cd);
				insert_db_same_name("", "r_item3", $add_clm_array, $add_value_array);
			}
		}

		for ($i = 0; $i < count($F_uri_around); $i++) {
			if($F_uri_around[$i] or $F_num_around[$i]){
				//t_img_around
				$img_around_cd = $img_around_sort = make_cd("t_img_around", "img_around_cd", "");
				if($F_num_around[$i]){
					$img_around_number = $F_num_around[$i];
				}else{
					while(in_array($count, $F_num_around)){
						$count++;
					}
					$img_around_number = $count;
					$count++;
				}
				$add_clm_array = array("img_around_cd", "img_around_sort", "img_around_number", "img_around_title", "img_around_cmt");
				$add_value_array = array($img_around_cd, $img_around_sort, $img_around_number, $F_title_around[$i], $F_cmt_around[$i]);
				insert_db_same_name("", "t_img_around", $add_clm_array, $add_value_array);
				//r_item4
				$rel_cd = make_cd("r_item4", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_around_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_around_cd);
				insert_db_same_name("", "r_item4", $add_clm_array, $add_value_array);
			}
		}

		for ($i = 0; $i < count($F_uri_theta); $i++) {
			if($F_uri_theta[$i] or $F_num_theta[$i]){
				//t_img_theta
				$img_theta_cd = $img_theta_sort = make_cd("t_img_theta", "img_theta_cd", "");
				if($F_num_theta[$i]){
					$img_theta_number = $F_num_theta[$i];
				}else{
					while(in_array($count, $F_num_theta)){
						$count++;
					}
					$img_theta_number = $count;
					$count++;
				}
        $url_theta = str_replace(array(" ", "　"), "", $F_url_theta[$i]);
				$add_clm_array = array("img_theta_cd", "img_theta_sort", "img_theta_number", "img_theta_title", "img_theta_url");
				$add_value_array = array($img_theta_cd, $img_theta_sort, $img_theta_number, $F_title_theta[$i], $url_theta);
				insert_db_same_name("", "t_img_theta", $add_clm_array, $add_value_array);
				//r_item12
				$rel_cd = make_cd("r_item12", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_theta_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_theta_cd);
				insert_db_same_name("", "r_item12", $add_clm_array, $add_value_array);
			}
		}
		
	}else{
		//イメージアップロード
		$A_img[] = array('name'=>"top", 'type'=>$F_type_top, 'uri'=>$F_uri_top, 'width'=>950, 'height'=>"", 'exist'=>$F_exist_top, 'flg_notrim'=>"1");
		//$A_img[] = array('name'=>"top", 'type'=>$F_type_top, 'uri'=>$F_uri_top, 'width'=>950, 'height'=>440, 'exist'=>$F_exist_top, 'flg_notrim'=>"");
		$A_img[] = array('name'=>"main", 'type'=>$F_type_main, 'uri'=>$F_uri_main, 'width'=>800, 'height'=>600, 'exist'=>$F_exist_main, 'flg_notrim'=>"");
		$A_img[] = array('name'=>"main_s", 'type'=>$F_type_main, 'uri'=>$F_uri_main, 'width'=>200, 'height'=>200, 'exist'=>$F_exist_main, 'flg_notrim'=>"");
		$A_img[] = array('name'=>"plan1", 'type'=>$F_type_plan1, 'uri'=>$F_uri_plan1, 'width'=>800, 'height'=>600, 'exist'=>$F_exist_plan1, 'flg_notrim'=>"1");
		$A_img[] = array('name'=>"plan1_s", 'type'=>$F_type_plan1, 'uri'=>$F_uri_plan1, 'width'=>175, 'height'=>175, 'exist'=>$F_exist_plan1, 'flg_notrim'=>"1");
		$A_img[] = array('name'=>"plan2", 'type'=>$F_type_plan2, 'uri'=>$F_uri_plan2, 'width'=>800, 'height'=>600, 'exist'=>$F_exist_plan2, 'flg_notrim'=>"1");
		for($i = 0; $i<count($A_img); $i++){
			if(!$A_img[$i]['exist']){
				rm_file($path_item."/".$A_img[$i]['name'].".*");
				if(preg_match("/jpeg/",$A_img[$i]['type'])){
					$filesuffix = ".jpg";
					$mimeprefix = "data:image/jpeg;base64,";
				}elseif(preg_match("/gif/",$A_img[$i]['type'])){
					$filesuffix = ".gif";
					$mimeprefix = "data:image/gif;base64,";
				}elseif(preg_match("/png/",$A_img[$i]['type'])){
					$filesuffix = ".png";
					$mimeprefix = "data:image/png;base64,";
				}
				$filename = $A_img[$i]['name'].$filesuffix;
				$filepathname = $path_item."/".$filename;
				if($A_img[$i]['uri']){
					file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $A_img[$i]['uri'])));
					$A_size = getimagesize($filepathname);
					$w = $A_size[0];
					$h = $A_size[1];
					if($w >= $h or $A_img[$i]['name'] == "top"){
						$width = $A_img[$i]['width'];
						$height = $A_img[$i]['height'];
					}else{
						$width = $A_img[$i]['height'];
						$height = $A_img[$i]['width'];
					}
					resize_image($path_item, $filename, $width, $height, "", $A_img[$i]['flg_notrim']);
				}
			}
		}
		//ファクトシートアップロード
		if(!$F_exist_fact){
			rm_file($path_item."/fact.*");
			if(preg_match("/jpeg/",$F_type_fact)){
				$filesuffix = ".jpg";
				$mimeprefix = "data:image/jpeg;base64,";
			}elseif(preg_match("/gif/",$F_type_fact)){
				$filesuffix = ".gif";
				$mimeprefix = "data:image/gif;base64,";
			}elseif(preg_match("/png/",$F_type_fact)){
				$filesuffix = ".png";
				$mimeprefix = "data:image/png;base64,";
			}elseif(preg_match("/pdf/",$F_type_fact)){
				$filesuffix = ".pdf";
				$mimeprefix = "data:application/pdf;base64,";
			}
			$filename = "fact".$filesuffix;
			$filepathname = $path_item."/".$filename;
			if($F_uri_fact){
				file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $F_uri_fact)));
			}
		}
		//t_img_detail
		$count = 1;
		if($F_item_cd){
			$dh=opendir($path_detail);
			while(($entry=readdir($dh))){
				if(!is_dir($path_detail."/".$entry)){
					preg_match("/^([0-9]{2}).*\.[^.]+$/", $entry, $A_match);
					$num = sprintf("%01d", $A_match[1]);
					if(!in_array($num, $F_num_detail)){
						unlink($path_detail."/".$entry);
					}
				}
			}
			closedir($dh);
			$sql = "delete from t_img_detail where img_detail_cd in (select img_detail_cd from r_item3 where item_cd='".$F_item_cd."');";
			$sql.= "delete from r_item3 where item_cd='".$F_item_cd."';";
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		for ($i = 0; $i < count($F_uri_detail); $i++) {
			if($F_uri_detail[$i] or $F_num_detail[$i]){
				$img_detail_cd = $img_detail_sort = make_cd("t_img_detail", "img_detail_cd", "");
				if($F_num_detail[$i]){
					$img_detail_number = $F_num_detail[$i];
				}else{
					while(in_array($count, $F_num_detail)){
						$count++;
					}
					$img_detail_number = $count;
					$count++;
				}
				$add_clm_array = array("img_detail_cd", "img_detail_sort", "img_detail_number", "img_detail_title");
				$add_value_array = array($img_detail_cd, $img_detail_sort, $img_detail_number, $F_title_detail[$i]);
				insert_db_same_name("", "t_img_detail", $add_clm_array, $add_value_array);
				//r_item3
				$rel_cd = make_cd("r_item3", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_detail_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_detail_cd);
				insert_db_same_name("", "r_item3", $add_clm_array, $add_value_array);
				//イメージアップロード
				if(!$F_num_detail[$i]){
					if(preg_match("/jpeg/",$F_type_detail[$i])){
						$filesuffix = ".jpg";
						$mimeprefix = "data:image/jpeg;base64,";
					}elseif(preg_match("/gif/",$F_type_detail[$i])){
						$filesuffix = ".gif";
						$mimeprefix = "data:image/gif;base64,";
					}elseif(preg_match("/png/",$F_type_detail[$i])){
						$filesuffix = ".png";
						$mimeprefix = "data:image/png;base64,";
					}
					$filename = sprintf("%02d",$img_detail_number).$filesuffix;
					$filepathname = $path_detail."/".$filename;
					file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $F_uri_detail[$i])));
					$A_size = getimagesize($filepathname);
					$w = $A_size[0];
					$h = $A_size[1];
					if($w >= $h){
						resize_image($path_detail, $filename, 800, 600, "");
					}else{
						resize_image($path_detail, $filename, 600, 800, "");
					}
					resize_image($path_detail, $filename, 140, 140, sprintf("%02d",$img_detail_number)."_s");
				}
			}
		}
		//t_img_around
		$count = 1;
		if($F_item_cd){
			$dh=opendir($path_around);
			while(($entry=readdir($dh))){
				if(!is_dir($path_around."/".$entry)){
					preg_match("/^([0-9]{2}).*\.[^.]+$/", $entry, $A_match);
					$num = sprintf("%01d", $A_match[1]);
					if(!in_array($num, $F_num_around)){
						unlink($path_around."/".$entry);
					}
				}
			}
			closedir($dh);
			$sql = "delete from t_img_around where img_around_cd in (select img_around_cd from r_item4 where item_cd='".$F_item_cd."');";
			$sql.= "delete from r_item4 where item_cd='".$F_item_cd."';";
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		for ($i = 0; $i < count($F_uri_around); $i++) {
			if($F_uri_around[$i] or $F_num_around[$i]){
				$img_around_cd = $img_around_sort = make_cd("t_img_around", "img_around_cd", "");
				if($F_num_around[$i]){
					$img_around_number = $F_num_around[$i];
				}else{
					while(in_array($count, $F_num_around)){
						$count++;
					}
					$img_around_number = $count;
					$count++;
				}
				$add_clm_array = array("img_around_cd", "img_around_sort", "img_around_number", "img_around_title", "img_around_cmt");
				$add_value_array = array($img_around_cd, $img_around_sort, $img_around_number, $F_title_around[$i], $F_cmt_around[$i]);
				insert_db_same_name("", "t_img_around", $add_clm_array, $add_value_array);
				//r_item4
				$rel_cd = make_cd("r_item4", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_around_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_around_cd);
				insert_db_same_name("", "r_item4", $add_clm_array, $add_value_array);
				//イメージアップロード
				if(!$F_num_around[$i]){
					if(preg_match("/jpeg/",$F_type_around[$i])){
						$filesuffix = ".jpg";
						$mimeprefix = "data:image/jpeg;base64,";
					}elseif(preg_match("/gif/",$F_type_around[$i])){
						$filesuffix = ".gif";
						$mimeprefix = "data:image/gif;base64,";
					}elseif(preg_match("/png/",$F_type_around[$i])){
						$filesuffix = ".png";
						$mimeprefix = "data:image/png;base64,";
					}
					$filename = sprintf("%02d",$img_around_number).$filesuffix;
					$filepathname = $path_around."/".$filename;
					file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $F_uri_around[$i])));
					$A_size = getimagesize($filepathname);
					$w = $A_size[0];
					$h = $A_size[1];
					if($w >= $h){
						resize_image($path_around, $filename, 800, 600, "");
					}else{
						resize_image($path_around, $filename, 600, 800, "");
					}
					resize_image($path_around, $filename, 290, 190, sprintf("%02d",$img_around_number)."_s");
				}
			}
		}
		//t_img_theta
		$count = 1;
		if($F_item_cd){
			$dh=opendir($path_theta);
			while(($entry=readdir($dh))){
				if(!is_dir($path_theta."/".$entry)){
					preg_match("/^([0-9]{2}).*\.[^.]+$/", $entry, $A_match);
					$num = sprintf("%01d", $A_match[1]);
					if(!in_array($num, $F_num_theta)){
						unlink($path_theta."/".$entry);
					}
				}
			}
			closedir($dh);
			$sql = "delete from t_img_theta where img_theta_cd in (select img_theta_cd from r_item12 where item_cd='".$F_item_cd."');";
			$sql.= "delete from r_item12 where item_cd='".$F_item_cd."';";
			$rs = exec_sql($db, $sql, $_SERVER["SCRIPT_NAME"]);
		}
		for ($i = 0; $i < count($F_url_theta); $i++) {
			if($i == 0){ continue; } //1つ目は複製用の為
			if($F_url_theta[$i] or $F_num_theta[$i]){
				$img_theta_cd = $img_theta_sort = make_cd("t_img_theta", "img_theta_cd", "");
				if($F_num_theta[$i]){
					$img_theta_number = $F_num_theta[$i];
				}else{
					while(in_array($count, $F_num_theta)){
						$count++;
					}
					$img_theta_number = $count;
					$count++;
				}
        $url_theta = str_replace(array(" ", "　"), "", $F_url_theta[$i]);
				$add_clm_array = array("img_theta_cd", "img_theta_sort", "img_theta_number", "img_theta_title", "img_theta_url");
				$add_value_array = array($img_theta_cd, $img_theta_sort, $img_theta_number, $F_title_theta[$i], $url_theta);
				insert_db_same_name("", "t_img_theta", $add_clm_array, $add_value_array);
				//r_item12
				$rel_cd = make_cd("r_item12", "rel_cd", "");
				$add_clm_array = array("rel_cd", "item_cd", "img_theta_cd");
				$add_value_array = array($rel_cd, $item_cd, $img_theta_cd);
				insert_db_same_name("", "r_item12", $add_clm_array, $add_value_array);
				//イメージアップロード
				if(!$F_num_theta[$i]){
					if(preg_match("/jpeg/",$F_type_theta[$i])){
						$filesuffix = ".jpg";
						$mimeprefix = "data:image/jpeg;base64,";
					}elseif(preg_match("/gif/",$F_type_theta[$i])){
						$filesuffix = ".gif";
						$mimeprefix = "data:image/gif;base64,";
					}elseif(preg_match("/png/",$F_type_theta[$i])){
						$filesuffix = ".png";
						$mimeprefix = "data:image/png;base64,";
					}
					$filename = sprintf("%02d",$img_theta_number).$filesuffix;
					$filepathname = $path_theta."/".$filename;
					file_put_contents($filepathname,base64_decode(str_replace($mimeprefix, "", $F_uri_theta[$i])));
					$A_size = getimagesize($filepathname);
					$w = $A_size[0];
					$h = $A_size[1];
					if($w >= $h){
						resize_image($path_theta, $filename, 700, 250, "");
					}else{
						resize_image($path_theta, $filename, 700, 250, "");
					}
					resize_image($path_theta, $filename, 280, 100, sprintf("%02d",$img_theta_number)."_s");
				}
			}
		}
	}
	$rs = exec_sql($db, "commit", $_SERVER["SCRIPT_NAME"]); //▲トランザクションCOMMIT▲
	if($F_item_cd or $F_copy){
		foreach ($_SESSION['status'] as $name => $cd) {
			$A_param[] = $name."=".$cd;
		}
		$param = implode("&", $A_param);
		unset($_SESSION['status']);
		header("location:/item/?md=list&".$param);
	}else{
		unset($_SESSION['status']);
		header("location:/item/?md=regist");
	}
	exit;
}

//-- .inc --//
if($F_md == "list" or $F_md == "analysis" or $F_md == "analysis_item"){
	include("re_header.inc");
	include("re_side.inc");
	include("re_".$inc);
	include("re_footer.inc");
}else{
	include("header.inc");
	include($inc);
	include("footer.inc");
}
exit;
?>
