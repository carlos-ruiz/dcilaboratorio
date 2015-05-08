<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */

?>

<h1>Actualizar especialidad: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>