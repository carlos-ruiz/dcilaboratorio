<?php /* @var $this Controller */

?>
<!DOCTYPE html>
<html>
<head>

	<!-- blueprint CSS framework
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	-->
	<meta charset="utf-8"/>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<!-- ESTILOS PERSONALIZADOS -->
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom/customStyle.css" rel="stylesheet" type="text/css"/>
	<!--
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/media/css/jquery-ui-1.10.1.custom.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/media/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	-->

	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN THEME STYLES -->
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/css/plugins.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
	<link id="style_color" href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout4/css/themes/default.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout4/css/custom.css" rel="stylesheet" type="text/css"/>

	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/datatables/media/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
	<!-- DATE TIME PICKERS-->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="fav	icon.ico"/>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>

	<script type="text/javascript">
		function alerta(mensaje){
			$("#modalTitleAviso").html("Alerta");
			$("#modalAceptarAviso").show();
			$("#modalAviso").find(".modal-body").html(mensaje);
			$("#modalAviso").modal("show");
			$("#modalAviso").modal()
				.one('hide', function () {
					$("#modalAceptarAviso").hide();
				});
		}

		function alerta(mensaje, titulo){
			$("#modalTitleAviso").html(titulo);
			$("#modalAceptarAviso").show();
			$("#modalAviso").find(".modal-body").html(mensaje);
			$("#modalAviso").modal("show");
			$("#modalAviso").modal()
			.one('hide', function () {
				$("#modalAceptarAviso").hide();
			});
		}

	</script>

<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body class="page-header-fixed page-quick-sidebar-over-content page-sidebar-fixed page-sidebar-closed-hide-logo page-footer-fixed">
<!-- BEGIN HEADER -->

<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo" >
			<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php" >
			<center><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/logoNuevo.png" alt="logo" height="65" width="65" class="logo-default"/></center>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<div class="floatLeft col-md-8">
			<div class="col-md-4 fontSize10">
				<h5  class="heading" style="color:#1e90ff ">Unidad Chapultepec</h5>
				General Nicolás Bravo No. 170
				<br />Colonia Chapultepec Norte
				<br />Código Postal 58260
				<br />Teléfono Fax. (443) 232 0166
				<br />Lunes a Sábado de 07:00 a 20:00 hrs.
				<br /> Domingo 08:00 a 14:00 hrs.
			</div>
			<div class="col-md-4 fontSize10">
				<h5  class="heading" style="color:#1e90ff ">Unidad Cancerología</h5>
				Francisco M. Díaz No. 145
				<br />Colonia Ex Gobernador Gildardo Magaña
				<br />Código Postal 58149
				<br />Tel. Fax. (443) 232 01 65
				<br />Lunes a Sábado de 07:00 a 15:00 hrs.
			</div>
			<div class="col-md-4 fontSize10">
				<h5  class="heading" style="color:#1e90ff ">Unidad Amado Nervo</h5>
				Amado Nervo No. 392-4
				<br />Colonia Centro
				<br />Código Postal 58000
				<br />Teléfono Fax. (443) 326 98 91
				<br />Lunes a Sábado de 07:00 a 15:00 hrs.
			</div>
		</div>

		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="page-top">
			<div class="top-menu">
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<ul class="nav navbar-nav pull-right">
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<img alt="" class="img-circle" src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/img/avatar.png"/>
						<span class="username username-hide-on-mobile">
						<?php if (!Yii::app()->user->isGuest) echo Yii::app()->user->name; ?> </span>
						<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/logOut">
								<i class="icon-key"></i> Cerrar sesión </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
					<!-- BEGIN QUICK SIDEBAR TOGGLER -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte
					<li class="dropdown dropdown-quick-sidebar-toggler">
						<a href="javascript:;" class="dropdown-toggle">
						<i class="icon-logout"></i>
						</a>
					</li>
					 END QUICK SIDEBAR TOGGLER -->

				</ul>
			</div>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>

<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<?php
			if(Yii::app()->user->getState('perfil')=='Administrador')
				include_once("menu_admin.php");
			if(Yii::app()->user->getState('perfil')=='Doctor')
				include_once("menu_doctor.php");
			if(Yii::app()->user->getState('perfil')=='Unidad Responsable')
				include_once("menu_ur.php");
			if(Yii::app()->user->getState('perfil')=='Paciente')
				include_once("menu_paciente.php");
			?>

			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade draggable-modal" id="modalAviso" tabindex="-1" role="basic" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 id="modalTitleAviso" class="modal-title">Titulo</h4>
						</div>
						<div class="modal-body">
							 Cargando...
						</div>
						<div class="modal-footer">
							<button type="button" id="modalAceptarAviso" class="btn red" style="display:none" data-dismiss="modal">Aceptar</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade draggable-modal" id="modal" tabindex="-1" role="basic" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 id="modalTitle" class="modal-title">Titulo</h4>
						</div>
						<div class="modal-body">
							 Cargando...
						</div>
						<div class="modal-footer">
							<button type="button" id="modalCancelar" class="btn default" style="display:none" data-dismiss="modal">Cerrar</button>
							<button type="button" id="modalGuardar" class="btn green" style="display:none" data-dismiss="modal">Guardar</button>
							<button type="button" id="modalAceptar" class="btn red" style="display:none" data-dismiss="modal">Aceptar</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->

			<!-- BEGIN PAGE CONTENT-->
			<div >

				<div class="row">
					<div class="col-md-12">

						<?php
						echo $content;
						?>
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
		</div>
	</div>
	<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">

	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->


<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/select2/select2.min.js" type="text/javascript"></script>

<!-- END CORE PLUGINS -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/pages/scripts/ui-blockui.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/layout/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/datatables/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/pages/scripts/components-pickers.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/pages/scripts/ui-extended-modals.js" type="text/javascript"></script>

<!--
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/css/media/js/jquery.cookie.min.js" type="text/javascript"></script>
-->

<script>
jQuery(document).ready(function() {

   	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features
	ComponentsPickers.init();

	$(".date-picker").datepicker({
	    language: 'es',
	});

	$('.page-container').css('margin-top', $('.page-header').height());

});

</script>
<!-- END JAVASCRIPTS -->
</body>
</html>
