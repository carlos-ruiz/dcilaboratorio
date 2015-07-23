<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
	<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
	<!--
	<li class="sidebar-search-wrapper">
		<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
		<!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
		<!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box
		<form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
			<a href="javascript:;" class="remove">
			<i class="icon-close"></i>
			</a>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search...">
				<span class="input-group-btn">
				<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
				</span>
			</div>
		</form>
		<!-- END RESPONSIVE QUICK SEARCH FORM
	</li>
	-->
	<li <?php if($this->section=='Home'){ echo 'class="startactive open"';}?>>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/">
		<i class="icon-home"></i>
		<span class="title">Inicio</span>
		<?php if($this->section==""){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
	</li>

	<li <?php if($this->section=="Ordenes"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-chemistry"></i>
		<span class="title">Ordenes</span>
		<?php if($this->section=="Ordenes"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Orednes" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/ordenes/create">
				<i class="icon-plus"></i>
				Nueva</a>
			</li>
			<li <?php if($this->section=="Ordenes" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/ordenes/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
			<li <?php if($this->section=="Ordenes" && $this->subSection=="Paciente"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/pacientes/admin">
				<i class="icon-list"></i>
				Pacientes</a>
			</li>
		</ul>
	</li>



	<li class="heading">
		<h3 class="uppercase">Catálogos</h3>
	</li>


	<li <?php if($this->section=="UnidadesResponsables"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-grid"></i>
		<span class="title">U. Responsables</span>
		<?php if($this->section=="UnidadesResponsables"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="UnidadesResponsables" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/unidadesResponsables/create">
				<i class="icon-plus"></i>
				Nueva</a>
			</li>
			<li <?php if($this->section=="UnidadesResponsables" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/unidadesResponsables/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="Doctores"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-users"></i>
		<span class="title">Doctores</span>
		<?php if($this->section=="Doctores"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Doctores" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/doctores/create">
				<i class="icon-user-follow"></i>
				Nuevo</a>
			</li>
			<li <?php if($this->section=="Doctores" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/doctores/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
			<li <?php if($this->section=="Doctores" && $this->subSection=="Especialidades"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/especialidades/admin">
				<i class="icon-notebook"></i>
				Especialidades</a>
			</li>

		</ul>
	</li>

	<li <?php if($this->section=="Examenes"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-book-open"></i>
		<span class="title">Exámenes</span>
		<?php if($this->section=="Examenes"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Examenes" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/examenes/create">
				<i class="icon-plus"></i>
				Nuevo</a>
			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/examenes/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Grupos"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/grupos/admin">
				<i class="icon-layers"></i>
				Grupos</a>

			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Resultados"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/detallesExamen/admin">
				<i class="icon-note"></i>
				Resultado de examenes</a>
			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Tarifas"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/tarifasActivas/admin">
				<i class="icon-check"></i>
				Tarifas activas</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="Multitarifarios"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-wallet"></i>
		<span class="title">Multitarifarios</span>
		<?php if($this->section=="Multitarifarios"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Multitarifarios" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/multitarifarios/create">
				<i class="icon-plus"></i>
				Nuevo</a>
			</li>
			<li <?php if($this->section=="Multitarifarios" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/multitarifarios/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="PalabrasClave"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-puzzle"></i>
		<span class="title">Palabras Clave</span>
		<?php if($this->section=="PalabrasClave"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="PalabrasClave" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/palabrasClave/create">
				<i class="icon-plus"></i>
				Nueva</a>
			</li>
			<li <?php if($this->section=="PalabrasClave" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/palabrasClave/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="Titulos"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-trophy"></i>
		<span class="title">Titulos</span>
		<?php if($this->section=="Titulos"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Titulos" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/titulosForm/create">
				<i class="icon-plus"></i>
				Nuevo</a>
			</li>
			<li <?php if($this->section=="Titulos" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/titulosForm/admin">
				<i class="icon-list"></i>
				Administración</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="UnidadesMedida"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-chemistry"></i>
		<span class="title">Unidades de Medida</span>
		<?php if($this->section=="UnidadesMedida"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="UnidadesMedida" && $this->subSection=="Nuevo"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/unidadesMedida/create">
				<i class="icon-plus"></i>
				Nueva</a>
			</li>
			<li <?php if($this->section=="UnidadesMedida" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/unidadesMedida/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="Usuarios"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-users"></i>
		<span class="title">Usuarios</span>
		<?php if($this->section=="Usuarios"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Usuarios" && $this->subSection=="Admin"){ echo 'class="active open"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/usuarios/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="Reportes"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-docs"></i>
		<span class="title">Reportes</span>
		<?php if($this->section=="Reportes"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Reportes"){ echo 'class="active open"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/reportes/generar">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
		</ul>
	</li>

	<li <?php if($this->section=="Facturacion"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-doc"></i>
		<span class="title">Facturación</span>
		<?php if($this->section=="Facturacion"){?>
		<span class="selected"></span>
		<span class="arrow open"></span>
		<?php } else{ ?>
		<span class="arrow "></span>
		<?php }?>
		</a>
		<ul class="sub-menu">
			<li <?php if($this->section=="Facturacion"){ echo 'class="active open"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/facturacion/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
		</ul>
	</li>

	<li >
		<div style="height:44px">
		</div>
	</li>
</ul>
