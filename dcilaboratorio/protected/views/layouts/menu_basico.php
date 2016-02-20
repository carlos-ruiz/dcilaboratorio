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

	<li >
		<div style="height:44px">
		</div>
	</li>
</ul>
