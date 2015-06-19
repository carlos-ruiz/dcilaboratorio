<?php
/* @var $this PacientesController */
/* @var $model Pacientes */

?>
<?php if (Yii::app()->user->getState('perfil')=="Administrador"){ ?> 
	<h1>Actualizar paciente: <?php echo $model->nombre; ?></h1>
<?php } elseif(Yii::app()->user->getState('perfil')=="Paciente") { ?>
	<h1>Actualizar mis datos: </h1>
<?php } ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>