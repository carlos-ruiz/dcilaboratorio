<?php
/* @var $this TarifasActivasController */
/* @var $model TarifasActivas */

$this->breadcrumbs=array(
	'Tarifas Activases'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TarifasActivas', 'url'=>array('index')),
	array('label'=>'Create TarifasActivas', 'url'=>array('create')),
	array('label'=>'View TarifasActivas', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TarifasActivas', 'url'=>array('admin')),
);
?>

<h1>Update TarifasActivas <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>