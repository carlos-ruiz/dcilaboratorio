<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */

$this->breadcrumbs=array(
	'Ordenes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Ordenes', 'url'=>array('index')),
	array('label'=>'Create Ordenes', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ordenes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ordenes</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ordenes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'id_doctores',
		'id_pacientes',
		'id_status',
		'id_unidades_responsables',
		'fecha_captura',
		/*
		'informacion_clinica_y_terapeutica',
		'comentarios',
		'requiere_factura',
		'descuento',
		'id_multitarifarios',
		'compartir_con_doctor',
		'ultima_edicion',
		'usuario_ultima_edicion',
		'creacion',
		'usuario_creacion',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
