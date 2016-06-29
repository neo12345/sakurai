<!DOCTYPE html>
<!-- saved from url=(0030)http://www.smile-reforeno.com/ -->
<html class="" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<title>スマイル不動産福岡 Control Panel［物件一覧］</title>
<link rel="stylesheet" href="<?= $G_css_dir ?>/html5reset-1.6.1_kai.css" />
<link rel="stylesheet" href="<?= $G_css_dir ?>/common.css" />
<link rel="stylesheet" href="<?= $G_css_dir ?>/style.css" />

<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/_common/favicon.ico" />

<!--[if lt IE 9]>
<script type="text/javascript">document.write(unescape('%3Cscript src="' + ('https:' == document.location.protocol ? 'https://' : 'http://') +   'html5shiv.googlecode.com/svn/trunk/html5.js" %3E%3C/script%3E'));</script>
<![endif]-->

	<? if($flg_jquery): ?>
		<script src="<?= $G_js_dir ?>/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script src="<?= $G_js_dir ?>/jquery/jquery-ui-1.10.2.custom.min.js" type="text/javascript"></script>
		<script src="<?= $G_js_dir ?>/jquery/jquery.json-2.4.min.js" type="text/javascript"></script>
		<script src="<?= $G_js_dir ?>/jquery/jquery_common.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?= $G_js_dir ?>/jquery/jquery.print_r.js" type="text/javascript" charset="utf-8"></script>
		<link href="<?= $G_js_dir ?>/confirm/css/confirm.css" rel="stylesheet" type="text/css" />
		<script src="<?= $G_js_dir ?>/confirm/confirm.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?= $G_js_dir ?>/dialog.js" type="text/javascript" charset="utf-8"></script>
	<? endif; ?>

	<? if($flg_js_datepicker): ?>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js" type="text/javascript" charset="utf-8"></script>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" rel="stylesheet" type="text/css" />
	<? endif; ?>

	<? if($flg_regist): ?>
		<script src="<?= $G_js_dir ?>/item/regist.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_list): ?>
		<script src="<?= $G_js_dir ?>/item/list.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_analysis): ?>
		<script src="<?= $G_js_dir ?>/item/analysis.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_imgliquid): ?>
		<script src="<?= $G_js_dir ?>/imgLiquid/imgLiquid-min.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_position_search): ?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script src="<?= $G_js_dir ?>/map/position_search.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_city): ?>
		<script src="<?= $G_js_dir ?>/master/city.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_school): ?>
		<script src="<?= $G_js_dir ?>/master/school.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_stop): ?>
		<script src="<?= $G_js_dir ?>/master/stop.js" type="text/javascript"></script>
	<? endif; ?>
		
	<? if($flg_js_seller): ?>
		<script src="<?= $G_js_dir ?>/master/seller.js" type="text/javascript"></script>
	<? endif; ?>
		
	<? if($flg_js_seller_office): ?>
		<script src="<?= $G_js_dir ?>/master/seller_office.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_member): ?>
		<script src="<?= $G_js_dir ?>/member/list.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_info): ?>
		<script src="<?= $G_js_dir ?>/contents/info.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_select): ?>
		<script src="<?= $G_js_dir ?>/contents/select.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_youtube): ?>
		<script src="<?= $G_js_dir ?>/contents/youtube.js" type="text/javascript"></script>
	<? endif; ?>

	<? if($flg_js_blog): ?>
		<script src="<?= $G_js_dir ?>/contents/blog.js" type="text/javascript"></script>
	<? endif; ?>

</head>

<body id="<?= $id_body ?>">

	<a id="top" name="top"></a>
	
	<div id="wrapper">
	
		<header>
			
			<h1><a href="/" title="スマイル不動産福岡 Control Panel [ホームへ]">スマイル不動産福岡 Control Panel</a></h1>
			<p class="username">ようこそ　<?= get_colum_key("m_user", "user_cd", $S_user_cd, "user_name", "") ?> 様</p>
			<p class="logout"><a href="/gate/?md=out" title="ログアウト">ログアウト</a></p>
			
			<ul>
				<li class="menu1_item"><a href="/item/" title="物件管理">物件管理</a></li>
				<li class="menu1_member"><a href="/member/" title="会員管理">会員管理</a></li>
				<li class="menu1_contents"><a href="/contents/" title="コンテンツ管理">コンテンツ管理</a></li>
				<li class="menu1_master"><a href="/master/" title="マスタ管理">マスタ管理</a></li>
			</ul>
			
		</header>
		
		<section id="main">
