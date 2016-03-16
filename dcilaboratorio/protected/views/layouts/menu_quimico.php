<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
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

	<li <?php if($this->section=="Examenes"){ echo 'class="active open"';}?>>
		<a href="javascript:;">
		<i class="icon-book-open"></i>
		<span class="title">Determinaciones</span>
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
				Nueva</a>
			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/examenes/admin">
				<i class="icon-list"></i>
				Administrar</a>
			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Grupos"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/grupos/admin">
				<i class="icon-layers"></i>
				Perfiles</a>

			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Multirangos"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/multirangos/admin">
				<i class="icon-note"></i>
				Multirangos</a>
			</li>
			<li <?php if($this->section=="Examenes" && $this->subSection=="Resultados"){ echo 'class="active"';}?>>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/detallesExamen/admin">
				<i class="icon-note"></i>
				Configura test</a>
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
