<?php
/* @var $this UnidadesMedidaController */
/* @var $model UnidadesMedida */

$this->breadcrumbs=array(
	'Unidades Medidas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);
?>

<h1>Modificar Unidad de Medida: <?php echo $model->nombre; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>