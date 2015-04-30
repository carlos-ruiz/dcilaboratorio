<?php
/* @var $this MultitarifariosController */
/* @var $model Multitarifarios */

$this->breadcrumbs=array(
	'Multitarifarioses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Modificar Multitarifario: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>