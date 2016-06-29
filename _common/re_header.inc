<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset=UTF-8" />

		<? if(!$header_title){$header_title="スマイル不動産福岡 管理システム";} ?>
		<? if(!$header_description){$header_description="";} ?>
		<? if(!$header_keywords){$header_keywords="";} ?>

		<title><?= $header_title ?></title>
		
		<meta name="Description" content="<?= $header_description ?>" />
		<meta name="Keywords" content="<?= $header_keywords ?>" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />

		<link rev="MADE" href="mailto:<?= $G_mail_info ?></link>" />
		<link rel="INDEX" href="index.php" />
		<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/_common/favicon.ico" />

		<link href="<?= $G_css_dir ?>/re_base.css" rel="stylesheet" type="text/css" />
		<link href="<?= $G_css_dir ?>/re_common.css" rel="stylesheet" type="text/css" />
		<link href="<?= $G_css_dir ?>/re_setting.css" rel="stylesheet" type="text/css" />
		<link href="<?= $G_css_dir ?>/re_style.css" rel="stylesheet" type="text/css" />
		<link href="<?= $G_css_dir ?>/re_js.css" rel="stylesheet" type="text/css" />
		
		
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
	<body>
    <header class="grade_01 clear">
      <div class="header clear">
        <div class="logo clear">
          <h1><img src="/_re_img/common/logo.png" alt="" /></h1>
          <p>Control Panel</p>
        </div>
        <div class="logout clear">
          <p>ようこそ　<?= get_colum_key("m_user", "user_cd", $S_user_cd, "user_name", "") ?> 様</p>
					<a href="/gate/?md=out" title="ログアウト"><img src="/_re_img/common/logout.png" alt="" /></a>
        </div>
      </div>
    </header>
    
    <div class="wrap clear">