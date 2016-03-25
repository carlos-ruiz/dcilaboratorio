<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<head>
		<meta charset="utf-8"/>
		<title>DCI Laboratorio | Login</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<meta content="" name="description"/>
		<meta content="" name="author"/>
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL STYLES -->
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/pages/css/login.css" rel="stylesheet" type="text/css"/>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME STYLES -->
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/css/plugins.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/css/layout.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/css/custom.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom/customStyle.css" rel="stylesheet" type="text/css"/>
		<!-- END THEME STYLES -->
		<link rel="shortcut icon" href="<?= Yii::app()->request->baseUrl ?>/css/layout/img/favicon.png"/>
	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<body class="login">
		<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
		<div class="menu-toggler sidebar-toggler">
		</div>
		<!-- END SIDEBAR TOGGLER BUTTON -->

		<!-- BEGIN LOGO -->
		<div class="side-bar col-md-3 col-sm-12">
			<div class="row col-12" style="text-align:center;">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/logo.png" height="100" alt="Laboratorio"/>
			</div>
			<br/>
			<div class="">
				<div class="col-md-12">
					<h5  class="heading" style="color:#1e90ff ">Unidad Chapultepec</h5>
					General Nicolás Bravo No. 170
					<br />Colonia Chapultepec Norte
					<br />Código Postal 58260
					<br />Teléfono Fax. (443) 232 0166
					<br />Lunes a Sábado de 07:00 a 20:00 hrs.
					<br />Domingo 08:00 a 14:00 hrs.
				</div>
				<div class="col-md-12">
					<h5  class="heading" style="color:#1e90ff ">Unidad Cancerología</h5>
					Francisco M. Díaz No. 145
					<br />Fracc. Ex Gobernador Gildardo Magaña
					<br />Código Postal 58149
					<br />Tel. Fax. (443) 232 01 65
					<br />Lunes a Sábado de 07:00 a 15:00 hrs.
				</div>
				<div class="col-md-12">
					<h5  class="heading" style="color:#1e90ff ">Unidad Amado Nervo</h5>
					Amado Nervo No. 392-4
					<br />Colonia Centro
					<br />Código Postal 58000
					<br />Teléfono Fax. (443) 326 98 91
					<br />Lunes a Sábado de 07:00 a 15:00 hrs.
				</div>
			</div>
		</div>
		<!-- END LOGO -->

		<!-- BEGIN CONTENT -->
		<div class="centered-container">
			<div class="col-md-9 col-sm-2 centered-inner">
				<div class="col-md-6">
					<div class=" col-md-12">
						<?php
						echo $content;
						?>
					</div>
				</div>

				<div class="col-md-6 imagen-login">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/lab5.png"  alt="Laboratorio de analisis clínicos"/>
					</a>
					<div class=" col-md-12  copyright">
						DCI Laboratorio <?= date('Y') ?> © Techinc.
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT -->

		<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
		<!-- BEGIN CORE PLUGINS -->
		<!--[if lt IE 9]>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/respond.min.js"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/excanvas.min.js"></script>
		<![endif]-->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/scripts/metronic.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/scripts/layout.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/scripts/demo.js" type="text/javascript"></script>
		<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/pages/scripts/login.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<script>
			jQuery(document).ready(function() {
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
			Login.init();
			Demo.init();
		});
		</script>
		<!-- END JAVASCRIPTS -->
	</body>
	<!-- END BODY -->
</html>