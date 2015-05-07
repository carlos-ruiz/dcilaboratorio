<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
$this->breadcrumbs=array(
	'Grupos Examenes'=>array('admin'),
	'Administración',
);
?>



<h1>Administrar Grupos Examenes</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'grupos-examenes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
