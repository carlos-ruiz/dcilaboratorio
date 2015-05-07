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
						<li <?php if($this->section=="Usuarios" && $this->subSection=="Registro"){ echo 'class="active open"';}?>>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/usuarios/create">
							<i class="icon-user-follow"></i>
							Nuevo</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/usuarios/admin">
							<i class="icon-list"></i>
							Administrar</a>
						</li>
					</ul>
				</li>
				<li class="heading">
					<h3 class="uppercase">Catálogos</h3>
				</li>
				<li <?php if($this->section=="Doctores"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
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
							<i class="icon-plus"></i>
							Nuevo Doctor</a>
						</li>
						<li <?php if($this->section=="Doctores" && $this->subSection=="Admin"){ echo 'class="active"';}?>>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/doctores/admin">
							<i class="icon-list"></i>
							Listado</a>
						</li>
						<li <?php if($this->section=="Doctores" && $this->subSection=="Especialidades"){ echo 'class="active"';}?>>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/especialidades/admin">
							<i class="icon-list"></i>
							Especialidades</a>
						</li>

					</ul>
				<li <?php if($this->section=="Titulos"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Titulos</span>
					<?php if($this->section=="Titulos"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/titulosForm/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/TitulosForm/create">
							<i class="icon-plus"></i>
							Nuevo Título</a>
						</li>
					</ul>
				</li>
				
				
				<li <?php if($this->section=="Examenes"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Exámenes</span>
					<?php if($this->section=="Examenes"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/examenes/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/examenes/create">
							<i class="icon-plus"></i>
							Nuevo Examen</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/grupos/index">
							<i class="icon-plus"></i>
							Grupos</a>

						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/tarifasActivas/admin">
							<i class="icon-plus"></i>
							Tarifas activas</a>
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
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/palabrasClave/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/palabrasClave/create">
							<i class="icon-plus"></i>
							Nueva Palabra Clave</a>
						</li>
					</ul>
				</li>

				<li <?php if($this->section=="Multitarifarios"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Multitarifarios</span>
					<?php if($this->section=="Multitarifarios"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/multitarifarios/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/multitarifarios/create">
							<i class="icon-plus"></i>
							Nuevo Multitarifario</a>
						</li>
					</ul>
				</li>

				<li <?php if($this->section=="UnidadesResponsables"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Unidades Responsables</span>
					<?php if($this->section=="UnidadesResponsables"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/unidadesResponsables/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/unidadesResponsables/create">
							<i class="icon-plus"></i>
							Nueva Unidad Responsable</a>
						</li>
					</ul>
				</li>
				<li <?php if($this->section=="DetallesExamenes"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Resultado de exámenes</span>
					<?php if($this->section=="DetallesExamenes"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/detallesExamen/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/detallesExamen/create">
							<i class="icon-plus"></i>
							Nuevo Resultado de Examen</a>
						</li>
					</ul>
				</li>
					<li <?php if($this->section=="UnidadesMedida"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Unidades de Medida</span>
					<?php if($this->section=="UnidadesMedida"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/unidadesMedida/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/unidadesMedida/create">
							<i class="icon-plus"></i>
							Nueva Unidad Responsable</a>
						</li>
					</ul>
				</li>

				</li>
					<li <?php if($this->section=="GrupoExamenes"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Grupo de Exámenes</span>
					<?php if($this->section=="GrupoExamenes"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/gruposExamenes/admin">
							<i class="icon-plus"></i>
							Administración</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/gruposExamenes/create">
							<i class="icon-plus"></i>
							Nuevo Grupo de Exámenes</a>
						</li>
					</ul>
				</li>

