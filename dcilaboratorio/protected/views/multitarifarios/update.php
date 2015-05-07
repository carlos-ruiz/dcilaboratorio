<?php
/* @var $this MultitarifariosController */
/* @var $model Multitarifarios */

$this->breadcrumbs=array(
	'Multitarifarioses'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

?>

<h1>Modificar Multitarifario: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>