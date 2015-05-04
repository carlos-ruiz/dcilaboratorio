<?php
/* @var $this DetallesExamenController */
/* @var $model DetallesExamen */

$this->breadcrumbs=array(
	'Detalles Examens'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

?>

<h1>Modificar Resultado de Examen: <?php echo $model->descripcion; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>