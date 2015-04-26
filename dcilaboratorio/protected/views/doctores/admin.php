<?php
/* @var $this DoctoresController */
/* @var $model Doctores */

$this->breadcrumbs=array(
	'Doctores'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Doctores', 'url'=>array('index')),
	array('label'=>'Create Doctores', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#doctores-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Doctores</h1>

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
	'id'=>'doctores-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		'a_paterno',
		'a_materno',
		'correo_electronico',
		'hora_consulta_de',
		/*
		'hora_consulta_hasta',
		'porcentaje',
		'calle',
		'ciudad',
		'colonia',
		'estado',
		'codigo_postal',
		'numero_ext',
		'numero_int',
		'id_especialidades',
		'id_titulos',
		'id_usuarios',
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
