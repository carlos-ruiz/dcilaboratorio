<?php
/* @var $this TitulosFormController */
/* @var $model TitulosForm */

$this->breadcrumbs=array(
	'Titulos'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Modificación',
);
?>

<h1>Modificar Título: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
