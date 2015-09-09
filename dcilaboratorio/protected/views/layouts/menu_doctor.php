<?php 
	$user=Usuarios::model()->findByPk(Yii::app()->user->id);
 ?>
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

<!--				<li <?php if($this->section=="Pacientes"){ echo 'class="startactive open"';}?>>
					<a href="<?php echo Yii::app()->controller->createUrl('/doctores/view',array('id'=>Yii::app()->user->getState('id_persona'))); ?>">
					<i class="icon-home"></i>
					<span class="title">Datos personales</span>
					<?php if($this->section==""){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
				</li>
-->
				<li <?php if($this->section=='Ordenes'&&$this->subSection!="Pacientes"){ echo 'class="startactive open"';}?>>
					<a href="<?php echo Yii::app()->controller->createUrl('/ordenes/admin'); ?>">
					<i class="icon-chemistry"></i>
					<span class="title">Ordenes</span>
					<?php if($this->section==""){?>
					<span class="selected"></span>
					<span class="arrow open"></span>
					<?php } else{ ?>
					<span class="arrow "></span>
					<?php }?>
					</a>
				</li>

				<li >
					<div style="height:44px">
					</div>
				</li>
</ul>
					
						

				

			
