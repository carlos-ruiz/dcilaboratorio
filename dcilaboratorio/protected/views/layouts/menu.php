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
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php">
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
					<?php if($this->section=="Users"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/usuarios/create">
							<i class="icon-plus"></i>
							Registro</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/usuarios/admin">
							<i class="icon-list"></i>
							Administrar</a>
						</li>
					</ul>
				</li>
				<li class="heading">
					<h3 class="uppercase">Catálogos</h3>
				</li>
				<li <?php if($this->section=="Users"){ echo 'class="active open"';}?>>
					<a href="javascript:;">
					<i class="icon-puzzle"></i>
					<span class="title">Doctores</span>
					<?php if($this->section=="Especialidades"){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/controller/action">
							<i class="icon-plus"></i>
							Nuevo Doctor</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/controller/action">
							<i class="glyphicon glyphicon-th-list"></i>
							Listado</a>
						</li>
						<li>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/especialidades/admin">
							<i class="glyphicon glyphicon-th-list"></i>
							Especialidades</a>
						</li>
						

					</ul>
				</li>
				
				