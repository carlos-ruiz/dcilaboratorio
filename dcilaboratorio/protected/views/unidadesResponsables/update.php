<?php
/* @var $this UnidadesResponsablesController */
/* @var $model UnidadesResponsables */

$this->breadcrumbs=array(
	'Unidades Responsables'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);
?>

<h1>Modificar Unidad Responsable: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>