<?php
/* @var $this EspecialidadesController */
/* @var $model Especialidades */
$this->breadcrumbs=array(
	'Especialidades'=>array('index'),
	'Actualizar especialidad',
);

$this->pageTitle="Especialidades";
?>

<h1>Update Especialidades <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>